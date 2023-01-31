<?php
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/../api/CreateFlowByFileDirectly.php');

use TencentCloud\Essbasic\V20210526\Models\FlowApproverInfo;
use TencentCloud\Essbasic\V20210526\Models\Component;

// 构造签署人 - 以B2B2C为例, 实际请根据自己的场景构造签署方、控件
function BuildApprovers()
{
    //静默签发起方参数
    $creatorOrganizationName = '********';
    // 个人签署方构造参数
    $personName = '**';
    $personMobile = '**********';

    // 企业签署方构造参数
    $organizationName = '**********';
    $organizationOpenId = '***********';
    $organizationUserOpenId = '*******';
    $organizationUserName = '**';
    $organizationUserMobile = '**********';


    $approvers = [];
    array_push($approvers,
        BuildServerSignApprover($creatorOrganizationName), // 发起方企业静默签署，此处需要在config.php中设置一个持有的印章值serverSignSealId
        BuildChannelOrganizationApprover($organizationName, $organizationOpenId, $organizationUserOpenId, $organizationUserName, $organizationUserMobile), //另一家子客签署方
//        BuildSaaSOrganizationApprover($organizationName, $organizationUserName, $organizationUserMobile), // 另一家SaaS企业签署方
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

    // 签署人类型
    // PERSON-个人/自然人；
    // ORGANIZATION-企业（企业签署方或模版发起时的企业静默签）；
    // ENTERPRISESERVER-企业静默签（文件发起时的企业静默签字）。
    $approver->setApproverType("PERSON");

    // 签署人姓名，最大长度50个字符
    $approver->setName($name);
    // 签署人手机号，脱敏显示。大陆手机号为11位，暂不支持海外手机号
    $approver->setMobile($mobile);

    /// 控件，包括填充控件、签署控件，具体查看
	// https://cloud.tencent.com/document/api/1420/61525#Component

	// 这里简单定义一个个人手写签名的签署控件
    $component = BuildComponent(146.15625, 472.78125, 112, 40, 0, "SIGN_SIGNATURE", 1, '');

    // 本环节操作人签署控件配置，为企业静默签署时，只允许类型为SIGN_SEAL（印章）和SIGN_DATE（日期）控件，并且传入印章编号
    $approver->SignComponents = [];
    array_push($approver->SignComponents, $component);

    return $approver;
}

// 打包企业签署方参与者信息
function BuildChannelOrganizationApprover($organizationName, $organizationOpenId, $approverOpenId, $approverName,
                                          $approverMobile)
{
    // 签署参与者信息
    // 企业签署方
    $approver = new FlowApproverInfo();

    // 签署人类型
	// PERSON-个人/自然人；
	// ORGANIZATION-企业（企业签署方或模版发起时的企业静默签）；
	// ENTERPRISESERVER-企业静默签（文件发起时的企业静默签字）。
    $approver->setApproverType("ORGANIZATION");

    // 企业签署方工商营业执照上的企业名称，签署方为非发起方企业场景下必传，最大长度64个字符；
    $approver->setOrganizationName($organizationName);
    // 如果签署方是子客企业，此处需要传子客企业的OrganizationOpenId
	// 企业签署方在同一渠道下的其他合作企业OpenId，签署方为非发起方企业场景下必传，最大长度64个字符；
    $approver->setOrganizationOpenId($organizationOpenId);
    // 如果签署方是子客企业，此处需要传子客企业经办人的OpenId
	// 当签署方为同一渠道下的员工时，该字段若不指定，则发起【待领取】的流程

    $approver->setName($approverName);
    $approver->setMobile($approverMobile);
    $approver->setOpenId($approverOpenId);


    // 模板控件信息
    // 签署人对应的签署控件
    $component = BuildComponent(246.15625, 472.78125, 112, 40, 0, "SIGN_SEAL", 1, '');

    // 本环节操作人签署控件配置，为企业静默签署时，只允许类型为SIGN_SEAL（印章）和SIGN_DATE（日期）控件，并且传入印章编号
    $approver->SignComponents = [];
    array_push($approver->SignComponents, $component);

    return $approver;
}

// 打包SaaS企业签署方参与者信息
function BuildSaaSOrganizationApprover($organizationName, $approverName, $approverMobile)
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
    $approver->setNotChannelOrganization(true);
    // 本环节需要企业操作人的企业名称
    $approver->setOrganizationName($organizationName);
    $approver->setName($approverName);
    $approver->setMobile($approverMobile);


    // 控件，包括填充控件、签署控件，具体查看
	// https://cloud.tencent.com/document/api/1420/61525#Component

    // 这里简单定义一个个人手写签名的签署控件
    $component = BuildComponent(246.15625, 472.78125, 112, 40, 0, "SIGN_SEAL", 1, '');

    // 本环节操作人签署控件配置，为企业静默签署时，只允许类型为SIGN_SEAL（印章）和SIGN_DATE（日期）控件，并且传入印章编号
    $approver->SignComponents = [];
    array_push($approver->SignComponents, $component);

    return $approver;
}

// 打包企业静默签署方参与者信息
function BuildServerSignApprover($organizationName)
{
    // 签署参与者信息
    // 企业静默签
    $approver = new FlowApproverInfo();

    // 签署人类型
	// PERSON-个人/自然人；
	// ORGANIZATION-企业（企业签署方或模版发起时的企业静默签）；
	// ENTERPRISESERVER-企业静默签（文件发起时的企业静默签字）。
    $approver->setApproverType("ENTERPRISESERVER");
    $approver->setOrganizationName($organizationName);

    // 控件，包括填充控件、签署控件，具体查看
	// https://cloud.tencent.com/document/api/1420/61525#Component

    // 这里简单定义一个个人手写签名的签署控件
    $component = BuildComponent(346.15625, 472.78125, 112, 40, 0, "SIGN_SEAL", 1, Config::serverSignSealId);

    // 本环节操作人签署控件配置，为企业静默签署时，只允许类型为SIGN_SEAL（印章）和SIGN_DATE（日期）控件，并且传入印章编号
    $approver->SignComponents = [];
    array_push($approver->SignComponents, $component);

    return $approver;
}

// BuildComponent 构建（签署）控件信息
// 详细参考 https://cloud.tencent.com/document/api/1420/61525#Component

// 在通过文件发起合同时，对应的component有三种定位方式
// 绝对定位方式
// 表单域(FIELD)定位方式
// 关键字(KEYWORD)定位方式
// 可以参考官网说明
// https://cloud.tencent.com/document/product/1323/78346#component-.E4.B8.89.E7.A7.8D.E5.AE.9A.E4.BD.8D.E6.96.B9.E5.BC.8F.E8.AF.B4.E6.98.8E
function BuildComponent($componentPosX, $componentPosY, $componentWidth, $componentHeight,
                        $fileIndex, $componentType, $componentPage, $componentValue)
{
    // 位置信息 包括：
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
    // 参数控件所在页码，取值为：1-N
    $component->setComponentPage($componentPage);

    // 控件类型与对应值，这里以官网说明为准
	// https://cloud.tencent.com/document/api/1420/61525#Component
    $component->setComponentType($componentType);
    $component->setComponentValue($componentValue);

    return $component;
}