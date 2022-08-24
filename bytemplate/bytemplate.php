<?php
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/../api/CreateFlowByFileDirectly.php');

use TencentCloud\Essbasic\V20210526\Models\FlowApproverInfo;

// 构造签署人 - 以B2B2C为例, 实际请根据自己的场景构造签署方、控件
function BuildFlowCreateApprovers()
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
        BuildServerSignFlowCreateApprover(), // 发起方企业静默签署，此处需要在config.php中设置一个持有的印章值serverSignSealId
        BuildOrganizationFlowCreateApprover($organizationUserName, $organizationUserMobile, $organizationName), // 另一家企业签署方
        BuildPersonFlowCreateApprover($personName, $personMobile) // 个人签署方
    );

    return $approvers;
}

// 打包个人签署方参与者信息
function BuildPersonFlowCreateApprover($name, $mobile)
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

    return $approver;
}

// 打包企业签署方参与者信息
function BuildOrganizationFlowCreateApprover($organizationOpenId, $openId, $organizationName)
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



    return $approver;
}

// 打包企业静默签署方参与者信息
function BuildServerSignFlowCreateApprover()
{
    // 签署参与者信息
    $approver = new FlowApproverInfo();
    // 签署人类型，PERSON-个人；
    // ORGANIZATION-企业；
    // ENTERPRISESERVER-企业静默签;
    // 注：ENTERPRISESERVER 类型仅用于使用文件创建流程（ChannelCreateFlowByFiles）接口；并且仅能指定发起方企业签署方为静默签署；
    $approver->setApproverType("ENTERPRISESERVER");

    return $approver;
}

