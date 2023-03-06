<?php
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/./Common.php');
require_once(__DIR__ . '/../config.php');

use TencentCloud\Common\Exception\TencentCloudSDKException;
use TencentCloud\Essbasic\V20210526\Models\ChannelCreateReleaseFlowRequest;
use TencentCloud\Essbasic\V20210526\Models\RelieveInfo;
use TencentCloud\Essbasic\V20210526\Models\ReleasedApprover;

// ChannelCreateReleaseFlow
// 第三方应用集成发起解除协议，主要应用场景为：基于一份已经签署的合同，进行解除操作。
// 合同发起人必须在电子签已经进行实名。
// 详细参考 https://cloud.tencent.com/document/api/1420/83461
function ChannelCreateReleaseFlow($needRelievedFlowId, $reliveInfo, $ReleasedApprovers, $callbackUrl)  {
    // 构造客户端调用实例
    $client = GetClientInstance(Config::secretId, Config::secretKey, Config::endPoint);

    // 实例化一个请求对象,每个接口都会对应一个request对象
    $req = new ChannelCreateReleaseFlowRequest();

    // 第三方平台应用相关信息
	// 此接口Agent.ProxyOrganizationOpenId、Agent. ProxyOperator.OpenId、Agent.AppId 和 Agent.ProxyAppId 均必填。
    $agent = GetAgent();
    $req->setAgent($agent);

    // 待解除的流程编号（即原流程的编号）
    $req->setNeedRelievedFlowId($needRelievedFlowId);
    // 解除协议内容，其中Reason必填
	// 详细参考 https://cloud.tencent.com/document/api/1420/61525#RelieveInfo
    $req->setReliveInfo($reliveInfo);
    // 非必须，解除协议的本企业签署人列表，默认使用原流程的签署人列表；
	// 当解除协议的签署人与原流程的签署人不能相同时（例如原流程签署人离职了），需要指定本企业的其他签署人来替换原流程中的原签署人，
	// 注意需要指明ApproverNumber来代表需要替换哪一个签署人，解除协议的签署人数量不能多于原流程的签署人数量
    $req->setReleasedApprovers($ReleasedApprovers);
    // 签署完回调url，最大长度1000个字符
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