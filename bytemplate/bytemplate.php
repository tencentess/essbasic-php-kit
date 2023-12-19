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

    // 内容控件填充结构，详细说明参考
    // https://cloud.tencent.com/document/api/1420/61525#FormField

    return $approvers;
}

// 打包个人签署方参与者信息
function BuildPersonFlowCreateApprover($name, $mobile)
{
    // 签署参与者信息
    // 个人签署方
    $approver = new FlowApproverInfo();

    $approver->setApproverType("PERSON");


    $approver->setName($name);

    $approver->setMobile($mobile);

    // 可以从模板中对应签署方的参与方id

    return $approver;
}

// 打包企业签署方参与者信息
function BuildOrganizationFlowCreateApprover($organizationOpenId, $openId, $organizationName)
{
    // 签署参与者信息
    // 企业签署方
    $approver = new FlowApproverInfo();

    $approver->setApproverType("ORGANIZATION");

    $approver->setOrganizationName($organizationName);

    $approver->setOrganizationOpenId($organizationOpenId);

    $approver->setOpenId($openId);

    // 可以从模板中对应签署方的参与方id

    return $approver;
}

// 打包企业静默签署方参与者信息
function BuildServerSignFlowCreateApprover()
{
    // 签署参与者信息
    // 企业静默签
    $approver = new FlowApproverInfo();

    $approver->setApproverType("ORGANIZATION");

    // 注：此时发起方会替换为接口调用的企业+经办人，所以不需要传签署方信息
    
    return $approver;
}

