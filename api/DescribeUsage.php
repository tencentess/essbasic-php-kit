<?php
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/./Common.php');
require_once(__DIR__ . '/../config.php');

use TencentCloud\Common\Exception\TencentCloudSDKException;
use TencentCloud\Essbasic\V20210526\Models\DescribeUsageRequest;


function DescribeUsage($startDate, $endDate, $needAggregate, $limit, $offset)  {
    // 构造客户端调用实例
    $client = GetClientInstance(Config::secretId, Config::secretKey, Config::endPoint);

    // 实例化一个请求对象,每个接口都会对应一个request对象
    $req = new DescribeUsageRequest();

    $agent = GetAgent();
    $req->setAgent($agent);
    $req->setStartDate($startDate);
    $req->setEndDate($endDate);
    $req->setNeedAggregate($needAggregate);
    $req->setLimit($limit);
    $req->setOffset($offset);

    // 返回的resp是一个DescribeUsageResponse的实例，与请求对象对应
    return $client->DescribeUsage($req);
}

try {
    $startDate = "2022-10-01";
    $endDate = "2022-10-20";
    $needAggregate = false;
    $limit = 10;
    $offset = 0;

    $resp = DescribeUsage($startDate, $endDate, $needAggregate, $limit, $offset);
    print_r($resp);
} catch (TencentCloudSDKException $e) {
    echo $e;
}