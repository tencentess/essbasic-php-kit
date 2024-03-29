<?php
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/./Common.php');
require_once(__DIR__ . '/../config.php');

use TencentCloud\Common\Exception\TencentCloudSDKException;
use TencentCloud\Essbasic\V20210526\Models\DescribeChannelFlowEvidenceReportRequest;

function DescribeChannelFlowEvidenceReport($reportId)  {
    // 构造客户端调用实例
    $client = GetClientInstance(Config::secretId, Config::secretKey, Config::endPoint);

    // 实例化一个请求对象,每个接口都会对应一个request对象
    $req = new DescribeChannelFlowEvidenceReportRequest();

    $agent = GetAgent();
    $req->setAgent($agent);

    $req->setReportId($reportId);

    // 返回的resp是一个DescribeChannelFlowEvidenceReportResponse的实例，与请求对象对应
    return $client->DescribeChannelFlowEvidenceReport($req);
}

try {
    $reportId = "********************************";
    $resp = DescribeChannelFlowEvidenceReport($reportId);
    print_r($resp);
} catch (TencentCloudSDKException $e) {
    echo $e;
}