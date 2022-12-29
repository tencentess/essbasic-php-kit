<?php
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/./Common.php');
require_once(__DIR__ . '/../config.php');

use TencentCloud\Essbasic\V20210526\Models\ChannelCreateFlowSignReviewRequest;

// ChannelCreateFlowSignReview
// 在通过接口(CreateFlowsByTemplates 或者ChannelCreateFlowByFiles)创建签署流程时
// 若指定了参数 NeedSignReview 为true,则可以调用此接口提交企业内部签署审批结果。
// 若签署流程状态正常，且本企业存在签署方未签署，同一签署流程可以多次提交签署审批结果，签署时的最后一个“审批结果”有效。
// 详细参考 https://cloud.tencent.com/document/api/1420/78953
function ChannelCreateFlowSignReview($flowId, $reviewType)  {
    // 构造客户端调用实例
    $client = GetClientInstance(Config::secretId, Config::secretKey, Config::endPoint);

    // 实例化一个请求对象,每个接口都会对应一个request对象
    $req = new ChannelCreateFlowSignReviewRequest();

    // 渠道应用相关信息。 
	// 此接口Agent.ProxyOrganizationOpenId、Agent. ProxyOperator.OpenId、Agent.AppId 和 Agent.ProxyAppId 均必填。
    $agent = GetAgent();
    $req->setAgent($agent);

    // 签署流程编号
    $req->setFlowId($flowId);
    // 企业内部审核结果
	// PASS: 通过
	// REJECT: 拒绝
	// SIGN_REJECT:拒签(流程结束)	request.ReviewType = flowFileInfos
    $req->setReviewType($reviewType);

    $resp = $client->ChannelCreateFlowSignReview($req);

    return $resp;
}

// 提交企业签署流程审批结果
try {
    $flowId = '*****************';
    $reviewType = "PASS";
    $resp = ChannelCreateFlowSignReview($flowId, $reviewType);
    print_r($resp);
} catch (TencentCloudSDKException $e) {
    echo $e;
}
