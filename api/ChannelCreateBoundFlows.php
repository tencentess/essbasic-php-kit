<?php
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/./Common.php');
require_once(__DIR__ . '/../config.php');

use TencentCloud\Essbasic\V20210526\Models\ChannelCreateBoundFlowsRequest;

// ChannelCreateBoundFlows
// 此接口（ChannelCreateBoundFlows）用于子客领取合同，经办人需要有相应的角色，领取后的合同不能重复领取。
// 详细参考 https://cloud.tencent.com/document/api/1420/83118
function ChannelCreateBoundFlows($flowIds)  {
    // 构造客户端调用实例
    $client = GetClientInstance(Config::secretId, Config::secretKey, Config::endPoint);

    // 实例化一个请求对象,每个接口都会对应一个request对象
    $req = new ChannelCreateBoundFlowsRequest();

    // 应用信息
	// 此接口Agent.AppId、Agent.ProxyOrganizationOpenId 和 Agent. ProxyOperator.OpenId 必填
    $agent = GetAgent();
    $req->setAgent($agent);
    // 领取的合同id列表
    $req->setFlowIds($flowIds);

    $resp = $client->ChannelCreateBoundFlows($req);

    return $resp;

}

// 领取合同
try {

    $flowId = "*****************";

    $resp = ChannelCreateBoundFlows(array($flowId));
    print_r($resp);
} catch (TencentCloudSDKException $e) {
    echo $e;
}