<?php
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/./Common.php');
require_once(__DIR__ . '/../config.php');

use TencentCloud\Common\Exception\TencentCloudSDKException;
use TencentCloud\Essbasic\V20210526\Models\ChannelCreateReleaseFlowRequest;
use TencentCloud\Essbasic\V20210526\Models\RelieveInfo;
use TencentCloud\Essbasic\V20210526\Models\ReleasedApprover;


function ChannelCreateReleaseFlow($needRelievedFlowId, $reliveInfo, $ReleasedApprovers, $callbackUrl)  {
    // 构造客户端调用实例
    $client = GetClientInstance(Config::secretId, Config::secretKey, Config::endPoint);

    // 实例化一个请求对象,每个接口都会对应一个request对象
    $req = new ChannelCreateReleaseFlowRequest();

    $agent = GetAgent();
    $req->setAgent($agent);
    $req->setNeedRelievedFlowId($needRelievedFlowId);
    $req->setReliveInfo($reliveInfo);
    $req->setReleasedApprovers($ReleasedApprovers);
    $req->setCallbackUrl($callbackUrl);

    // 返回的resp是一个ChannelCreateReleaseFlowResponse的实例，与请求对象对应
    return $client->ChannelCreateReleaseFlow($req);
}

try {
    $needRelievedFlowId = "********************************";

    $reliveInfo = new RelieveInfo();
    $reliveInfo->setReason("********************************");
    $reliveInfo->setRemainInForceItem("********************************");
    $reliveInfo->setOriginalExpenseSettlement("********************************");
    $reliveInfo->setOriginalOtherSettlement("********************************");
    $reliveInfo->setOtherDeals("********************************");

    $ReleasedApprover = new ReleasedApprover();
    $ReleasedApprover->setOrganizationName("********************************");
    $ReleasedApprover->setApproverNumber(0);
    $ReleasedApprover->setApproverType("********************************");
    $ReleasedApprover->setName("********************************");
    $ReleasedApprover->setIdCardType("********************************");
    $ReleasedApprover->setIdCardNumber("********************************");
    $ReleasedApprover->setMobile("********************************");
    $ReleasedApprover->setOrganizationOpenId("********************************");
    $ReleasedApprover->setOpenId("********************************");
    $ReleasedApprovers = [$ReleasedApprover];

    $callbackUrl = "********************************";

    $resp = ChannelCreateReleaseFlow($needRelievedFlowId, $reliveInfo, $ReleasedApprovers, $callbackUrl);
    print_r($resp);
} catch (TencentCloudSDKException $e) {
    echo $e;
}