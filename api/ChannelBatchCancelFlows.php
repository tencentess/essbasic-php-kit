<?php
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/./Common.php');
require_once(__DIR__ . '/../config.php');

use TencentCloud\Essbasic\V20210526\Models\ChannelBatchCancelFlowsRequest;

// ChannelBatchCancelFlows
// 指定需要批量撤销的签署流程Id，批量撤销合同
// 客户指定需要撤销的签署流程Id，最多100个，超过100不处理；接口失败后返回错误信息
// 注意:
// 能撤回合同的只能是合同的发起人或者发起企业的超管、法人
// 详细参考 https://cloud.tencent.com/document/api/1420/80391
function ChannelBatchCancelFlows($flowIds, $cancelMessage)  {
    // 构造客户端调用实例
    $client = GetClientInstance(Config::secretId, Config::secretKey, Config::endPoint);

    // 实例化一个请求对象,每个接口都会对应一个request对象
    $req = new ChannelBatchCancelFlowsRequest();

    // 第三方平台应用相关信息
	// 此接口Agent.ProxyOrganizationOpenId、Agent. ProxyOperator.OpenId、Agent.AppId 和 Agent.ProxyAppId 均必填。
    $agent = GetAgent();
    $req->setAgent($agent);

    // 签署流程Id数组，最多100个，超过100不处理
    $req->setFlowIds($flowIds);
    // 撤回原因，最大不超过200字符
    $req->setCancelMessage($cancelMessage);

    $resp = $client->ChannelBatchCancelFlows($req);

    return $resp;
}

// 批量撤销合同
try {
    $flowId = '*****************';
    $cancelMessage = "撤销理由";
    $resp = ChannelBatchCancelFlows(array($flowId), $cancelMessage);
    print_r($resp);
} catch (TencentCloudSDKException $e) {
    echo $e;
}
