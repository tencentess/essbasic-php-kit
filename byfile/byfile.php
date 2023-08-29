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

    $approver->setApproverType("PERSON");

    $approver->setName($name);

    $approver->setMobile($mobile);

	// 这里简单定义一个个人手写签名的签署控件
    $component = BuildComponent(146.15625, 472.78125, 112, 40, 0, "SIGN_SIGNATURE", 1, '');

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

    $approver->setApproverType("ORGANIZATION");

    $approver->setOrganizationName($organizationName);

    $approver->setOrganizationOpenId($organizationOpenId);

    $approver->setName($approverName);
    $approver->setMobile($approverMobile);
    $approver->setOpenId($approverOpenId);


    // 模板控件信息
    // 签署人对应的签署控件
    $component = BuildComponent(246.15625, 472.78125, 112, 40, 0, "SIGN_SEAL", 1, '');

    $approver->SignComponents = [];
    array_push($approver->SignComponents, $component);

    return $approver;
}

// 打包SaaS企业签署方参与者信息
function BuildSaaSOrganizationApprover($organizationName, $approverName, $approverMobile)
{
    // 签署参与者信息
    $approver = new FlowApproverInfo();

    $approver->setApproverType("ORGANIZATION");
    $approver->setNotChannelOrganization(true);

    $approver->setOrganizationName($organizationName);
    $approver->setName($approverName);
    $approver->setMobile($approverMobile);


    // 这里简单定义一个个人手写签名的签署控件
    $component = BuildComponent(246.15625, 472.78125, 112, 40, 0, "SIGN_SEAL", 1, '');

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

    $approver->setApproverType("ENTERPRISESERVER");
    $approver->setOrganizationName($organizationName);

    // 这里简单定义一个个人手写签名的签署控件
    $component = BuildComponent(346.15625, 472.78125, 112, 40, 0, "SIGN_SEAL", 1, Config::serverSignSealId);

    $approver->SignComponents = [];
    array_push($approver->SignComponents, $component);

    return $approver;
}

// BuildComponent 构建（签署）控件信息
function BuildComponent($componentPosX, $componentPosY, $componentWidth, $componentHeight,
                        $fileIndex, $componentType, $componentPage, $componentValue)
{
    $component = new Component();

    $component->setComponentPosX($componentPosX);

    $component->setComponentPosY($componentPosY);

    $component->setComponentWidth($componentWidth);

    $component->setComponentHeight($componentHeight);

    $component->setFileIndex($fileIndex);

    $component->setComponentPage($componentPage);

    $component->setComponentType($componentType);
    $component->setComponentValue($componentValue);

    return $component;
}