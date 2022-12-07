<?php
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/./Common.php');
require_once(__DIR__ . '/../config.php');

use TencentCloud\Common\Exception\TencentCloudSDKException;
use TencentCloud\Essbasic\V20210526\Models\ChannelDescribeEmployeesRequest;
use TencentCloud\Essbasic\V20210526\Models\Filter;


function ChannelDescribeEmployees($filters, $offset, $limit)  {
    // 构造客户端调用实例
    $client = GetClientInstance(Config::secretId, Config::secretKey, Config::endPoint);

    // 实例化一个请求对象,每个接口都会对应一个request对象
    $req = new ChannelDescribeEmployeesRequest();

    $agent = GetAgent();
    $req->setAgent($agent);
    $req->setFilters($filters);
    $req->setOffset($offset);
    $req->setLimit($limit);

    // 返回的resp是一个ChannelDescribeEmployeesResponse的实例，与请求对象对应
    return $client->ChannelDescribeEmployees($req);

}

try {
    $filter = new Filter();
    $filter->setKey("Status");
    $filter->setValues(["IsVerified"]);

    $filters = [$filter];
    $offset = 0;
    $limit = 10;
    $resp = ChannelDescribeEmployees($filters, $offset, $limit);
    print_r($resp);
} catch (TencentCloudSDKException $e) {
    echo $e;
}