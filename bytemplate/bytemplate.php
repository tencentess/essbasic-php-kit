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

    // 签署人类型
	// PERSON-个人/自然人；
	// ORGANIZATION-企业（企业签署方或模板发起时的企业静默签）；
	// ENTERPRISESERVER-企业静默签（文件发起时的企业静默签字）。
    $approver->setApproverType("PERSON");

    // 签署人姓名，最大长度50个字符
    $approver->setName($name);
    // 签署人手机号，脱敏显示。大陆手机号为11位，暂不支持海外手机号
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

    // 签署人类型
	// PERSON-个人/自然人；
	// ORGANIZATION-企业（企业签署方或模板发起时的企业静默签）；
	// ENTERPRISESERVER-企业静默签（文件发起时的企业静默签字）。
    $approver->setApproverType("ORGANIZATION");

    // 企业签署方工商营业执照上的企业名称，签署方为非发起方企业场景下必传，最大长度64个字符；
    $approver->setOrganizationName($organizationName);
    // 如果签署方是子客企业，此处需要传子客企业的OrganizationOpenId
	// 企业签署方在同一第三方应用集成下的其他合作企业OpenId，签署方为非发起方企业场景下必传，最大长度64个字符；
    $approver->setOrganizationOpenId($organizationOpenId);
    // 如果签署方是子客企业，此处需要传子客企业经办人的OpenId
	// 当签署方为同一平台下的员工时，该字段若不指定，则发起【待领取】的流程
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

    // 签署人类型
	// PERSON-个人/自然人；
	// ORGANIZATION-企业（企业签署方或模板发起时的企业静默签）；
	// ENTERPRISESERVER-企业静默签（文件发起时的企业静默签字）。
    $approver->setApproverType("ENTERPRISESERVER");

    // 注：此时发起方会替换为接口调用的企业+经办人，所以不需要传签署方信息
    
    return $approver;
}

