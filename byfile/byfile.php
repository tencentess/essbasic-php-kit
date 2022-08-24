<?php
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/../api/CreateFlowByFileDirectly.php');

use TencentCloud\Essbasic\V20210526\Models\FlowApproverInfo;
use TencentCloud\Essbasic\V20210526\Models\Component;

// 构造签署人 - 以B2B2C为例, 实际请根据自己的场景构造签署方、控件
function BuildApprovers()
{
    // 个人签署方构造参数
    $personName = '********************';
    $personMobile = '********************';

    // 企业签署方构造参数
    $organizationName = '********************';
    $organizationUserName = '********************';
    $organizationUserMobile = '********************';

    $approvers = [];
    array_push($approvers,
        BuildServerSignApprover(), // 发起方企业静默签署，此处需要在config.php中设置一个持有的印章值serverSignSealId
        BuildOrganizationApprover($organizationUserName, $organizationUserMobile, $organizationName), // 另一家企业签署方
        BuildPersonApprover($personName, $personMobile) // 个人签署方
    );

    return $approvers;
}

// 打包个人签署方参与者信息
function BuildPersonApprover($name, $mobile)
{
    // 签署参与者信息
    // 个人签署方
    $approver = new FlowApproverInfo();
    // 参与者类型：
    // 0：企业
    // 1：个人
    // 3：企业静默签署
    // 注：类型为3（企业静默签署）时，此接口会默认完成该签署方的签署。
    $approver->setApproverType("PERSON");
    // 本环节需要操作人的名字
    $approver->setName($name);
    // 本环节需要操作人的手机号
    $approver->setMobile($mobile);


    // 模板控件信息
    // 签署人对应的签署控件
    $component = BuildComponent(146.15625, 472.78125, 112, 40, 0, "SIGN_SIGNATURE", 1, '');

    // 本环节操作人签署控件配置，为企业静默签署时，只允许类型为SIGN_SEAL（印章）和SIGN_DATE（日期）控件，并且传入印章编号
    $approver->SignComponents = [];
    array_push($approver->SignComponents, $component);

    return $approver;
}

// 打包企业签署方参与者信息
function BuildOrganizationApprover($organizationOpenId, $openId, $organizationName)
{
    // 签署参与者信息
    $approver = new FlowApproverInfo();
    // 参与者类型：
    // 0：企业
    // 1：个人
    // 3：企业静默签署
    // 注：类型为3（企业静默签署）时，此接口会默认完成该签署方的签署。
    // 企业签署方
    $approver->setApproverType("ORGANIZATION");
    // 本环节需要企业操作人的企业名称
    $approver->setOrganizationName($organizationName);
    $approver->setOrganizationOpenId($organizationOpenId);
    $approver->setOpenId($openId);


    // 模板控件信息
    // 签署人对应的签署控件
    $component = BuildComponent(246.15625, 472.78125, 112, 40, 0, "SIGN_SEAL", 1, '');

    // 本环节操作人签署控件配置，为企业静默签署时，只允许类型为SIGN_SEAL（印章）和SIGN_DATE（日期）控件，并且传入印章编号
    $approver->SignComponents = [];
    array_push($approver->SignComponents, $component);

    return $approver;
}

// 打包企业静默签署方参与者信息
function BuildServerSignApprover()
{
    // 签署参与者信息
    $approver = new FlowApproverInfo();
    // 签署人类型，PERSON-个人；
    // ORGANIZATION-企业；
    // ENTERPRISESERVER-企业静默签;
    // 注：ENTERPRISESERVER 类型仅用于使用文件创建流程（ChannelCreateFlowByFiles）接口；并且仅能指定发起方企业签署方为静默签署；
    $approver->setApproverType("ENTERPRISESERVER");

    // 模板控件信息
    // 签署人对应的签署控件
    $component = BuildComponent(346.15625, 472.78125, 112, 40, 0, "SIGN_SEAL", 1, Config::serverSignSealId);

    // 本环节操作人签署控件配置，为企业静默签署时，只允许类型为SIGN_SEAL（印章）和SIGN_DATE（日期）控件，并且传入印章编号
    $approver->SignComponents = [];
    array_push($approver->SignComponents, $component);

    return $approver;
}

// 构建（签署）控件信息
function BuildComponent($componentPosX, $componentPosY, $componentWidth, $componentHeight,
                        $fileIndex, $componentType, $componentPage, $componentValue)
{
    // 模板控件信息
    // 签署人对应的签署控件
    $component = new Component();
    // 参数控件X位置，单位pt
    $component->setComponentPosX($componentPosX);
    // 参数控件Y位置，单位pt
    $component->setComponentPosY($componentPosY);

    // 参数控件宽度，单位pt
    $component->setComponentWidth($componentWidth);
    // 参数控件高度，单位pt
    $component->setComponentHeight($componentHeight);
    // 控件所属文件的序号（取值为：0-N）
    $component->setFileIndex($fileIndex);
    // 如果是 Component 控件类型，则可选类型为：
    // TEXT - 单行文本
    // MULTI_LINE_TEXT - 多行文本
    // CHECK_BOX - 勾选框
    // ATTACHMENT - 附件
    // SELECTOR - 选择器
    // 如果是 SignComponent 控件类型，则可选类型为：
    // SIGN_SEAL - 签署印章控件，静默签署时需要传入印章id作为ComponentValue
    // SIGN_DATE - 签署日期控件
    // SIGN_SIGNATURE - 手写签名控件，静默签署时不能使用
    $component->setComponentType($componentType);
    // 参数控件所在页码，取值为：1-N
    $component->setComponentPage($componentPage);
    // 自动签署所对应的印章Id
    $component->setComponentValue($componentValue);

    return $component;
}