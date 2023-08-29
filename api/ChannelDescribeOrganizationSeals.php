<?php
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/./Common.php');
require_once(__DIR__ . '/../config.php');

use TencentCloud\Common\Exception\TencentCloudSDKException;
use TencentCloud\Essbasic\V20210526\Models\ChannelDescribeOrganizationSealsRequest;

function ChannelDescribeOrganizationSeals($infoType, $sealId, $offset, $limit)  {
    // 构造客户端调用实例
    $client = GetClientInstance(Config::secretId, Config::secretKey, Config::endPoint);

    // 实例化一个请求对象,每个接口都会对应一个request对象
    $req = new ChannelDescribeOrganizationSealsRequest();

    $agent = GetAgent();
    $req->setAgent($agent);

    $req->setInfoType($infoType);

    $req->setSealId($sealId);

    $req->setOffset($offset);

    $req->setLimit($limit);

    // 返回的resp是一个ChannelDescribeOrganizationSealsResponse的实例，与请求对象对应
    return $client->ChannelDescribeOrganizationSeals($req);
}

try {
    $infoType = 1;
    $sealId = "";
    $offset = 0;
    $limit = 10;
    $resp = ChannelDescribeOrganizationSeals($infoType, $sealId, $offset, $limit);
    print_r($resp);
} catch (TencentCloudSDKException $e) {
    echo $e;
}