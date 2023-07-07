<?php
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/./Common.php');
require_once(__DIR__ . '/../config.php');

use TencentCloud\Common\Exception\TencentCloudSDKException;
use TencentCloud\Essbasic\V20210526\Models\ChannelDescribeOrganizationSealsRequest;

// ChannelDescribeOrganizationSeals
// 查询子客企业电子印章，需要操作者具有管理印章权限
// 客户指定需要获取的印章数量和偏移量，数量最多100，超过100按100处理；
// 入参InfoType控制印章是否携带授权人信息，为1则携带，为0则返回的授权人信息为空数组。
// 接口调用成功返回印章的信息列表还有企业印章的总数。
// 详细参考 https://cloud.tencent.com/document/api/1420/82455
function ChannelDescribeOrganizationSeals($infoType, $sealId, $offset, $limit)  {
    // 构造客户端调用实例
    $client = GetClientInstance(Config::secretId, Config::secretKey, Config::endPoint);

    // 实例化一个请求对象,每个接口都会对应一个request对象
    $req = new ChannelDescribeOrganizationSealsRequest();

    // 第三方平台应用相关信息。
	// 此接口Agent.ProxyOrganizationOpenId、Agent. ProxyOperator.OpenId、Agent.AppId 必填。
    $agent = GetAgent();
    $req->setAgent($agent);

    // 查询信息类型，为1时返回授权用户，为其他值时不返回
    $req->setInfoType($infoType);
    // 印章id（没有输入返回所有）
    $req->setSealId($sealId);
    // 偏移量，默认为0，最大为20000
    $req->setOffset($offset);
    // 返回最大数量，最大为100
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