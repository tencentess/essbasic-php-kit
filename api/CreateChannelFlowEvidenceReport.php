<?php
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/./Common.php');
require_once(__DIR__ . '/../config.php');

use TencentCloud\Common\Exception\TencentCloudSDKException;
use TencentCloud\Essbasic\V20210526\Models\CreateChannelFlowEvidenceReportRequest;

// CreateChannelFlowEvidenceReport
// 创建出证报告，返回报告 ID
// 详细参考 https://cloud.tencent.com/document/api/1420/79688
function CreateChannelFlowEvidenceReport($flowId)  {
    // 构造客户端调用实例
    $client = GetClientInstance(Config::secretId, Config::secretKey, Config::endPoint);

    // 实例化一个请求对象,每个接口都会对应一个request对象
    $req = new CreateChannelFlowEvidenceReportRequest();

    // 渠道应用相关信息。 
	// 此接口Agent.ProxyOrganizationOpenId、Agent. ProxyOperator.OpenId、Agent.AppId 和 Agent.ProxyAppId 均必填
    $agent = GetAgent();
    $req->setAgent($agent);

    // 签署流程编号，合同id
    $req->setFlowId($flowId);

    // 返回的resp是一个CreateChannelFlowEvidenceReportResponse的实例，与请求对象对应
    return $client->CreateChannelFlowEvidenceReport($req);
}

try {
    $flowId = "********************************";
    $resp = CreateChannelFlowEvidenceReport($flowId);
    print_r($resp);
} catch (TencentCloudSDKException $e) {
    echo $e;
}