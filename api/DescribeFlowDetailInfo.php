<?php
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/./Common.php');
require_once(__DIR__ . '/../config.php');

use TencentCloud\Common\Exception\TencentCloudSDKException;
use TencentCloud\Essbasic\V20210526\Models\DescribeFlowDetailInfoRequest;

// DescribeFlowDetailInfo 此接口用于查询合同(签署流程)的详细信息。
// 详细参考 https://cloud.tencent.com/document/api/1420/66683
function DescribeFlowDetailInfo($flowIds)  {
    // 构造客户端调用实例
    $client = GetClientInstance(Config::secretId, Config::secretKey, Config::endPoint);

    // 实例化一个请求对象,每个接口都会对应一个request对象
    $req = new DescribeFlowDetailInfoRequest();

    // 第三方平台应用相关信息
	// 此接口Agent.ProxyOrganizationOpenId、Agent. ProxyOperator.OpenId、Agent.AppId 必填。
    $agent = GetAgent();
    $req->setAgent($agent);

    // 合同(流程)编号数组，最多支持100个
    $req->setFlowIds($flowIds);

    $resp = $client->DescribeFlowDetailInfo($req);

    return $resp;
}

// 查询模板调用样例
try {
    $flowId = '*****************';
    $resp = DescribeFlowDetailInfo(array($flowId));
    print_r($resp);
} catch (TencentCloudSDKException $e) {
    echo $e;
}
