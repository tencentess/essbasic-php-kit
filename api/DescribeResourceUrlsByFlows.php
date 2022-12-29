<?php
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/./Common.php');
require_once(__DIR__ . '/../config.php');

use TencentCloud\Essbasic\V20210526\Models\DescribeResourceUrlsByFlowsRequest;

// DescribeResourceUrlsByFlows
// 根据签署流程信息批量获取资源下载链接，可以下载签署中、签署完的合同，需合作企业先进行授权。
// 此接口直接返回下载的资源的url，与接口GetDownloadFlowUrl跳转到控制台的下载方式不同。
// 详细参考 https://cloud.tencent.com/document/api/1420/63220
function DescribeResourceUrlsByFlows($flowIds)  {
    // 构造客户端调用实例
    $client = GetClientInstance(Config::secretId, Config::secretKey, Config::endPoint);

    // 实例化一个请求对象,每个接口都会对应一个request对象
    $req = new DescribeResourceUrlsByFlowsRequest();

    // 渠道应用相关信息。
	// 此接口Agent.ProxyOrganizationOpenId、Agent. ProxyOperator.OpenId、Agent.AppId 和 Agent.ProxyAppId 均必填。
    $agent = GetAgent();
    $req->setAgent($agent);

    // 查询资源所对应的签署流程Id，最多支持50个
    $req->setFlowIds($flowIds);

    $resp = $client->DescribeResourceUrlsByFlows($req);

    return $resp;
}

// 获取转换任务结果
try {
    //flowId
    $flowId = "*****************";

    $resp = DescribeResourceUrlsByFlows(array($flowId));
    print_r($resp);
} catch (TencentCloudSDKException $e) {
    echo $e;
}