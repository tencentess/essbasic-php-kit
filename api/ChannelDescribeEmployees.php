<?php
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/./Common.php');
require_once(__DIR__ . '/../config.php');

use TencentCloud\Common\Exception\TencentCloudSDKException;
use TencentCloud\Essbasic\V20210526\Models\ChannelDescribeEmployeesRequest;
use TencentCloud\Essbasic\V20210526\Models\Filter;

// ChannelDescribeEmployees
// 查询企业员工列表
// 详细参考 https://cloud.tencent.com/document/api/1420/81119
function ChannelDescribeEmployees($filters, $offset, $limit)  {
    // 构造客户端调用实例
    $client = GetClientInstance(Config::secretId, Config::secretKey, Config::endPoint);

    // 实例化一个请求对象,每个接口都会对应一个request对象
    $req = new ChannelDescribeEmployeesRequest();

    // 第三方平台应用相关信息
	// 此接口Agent.ProxyOrganizationOpenId、Agent. ProxyOperator.OpenId、Agent.AppId 和 Agent.ProxyAppId 均必填。
    $agent = GetAgent();
    $req->setAgent($agent);

    // 查询过滤实名用户，Key为Status，Values为["IsVerified"]
	// 根据第三方系统openId过滤查询员工时,Key为StaffOpenId,Values为["OpenId","OpenId",...]
	// 查询离职员工时，Key为Status，Values为["QuiteJob"]
    $req->setFilters($filters);

    // 偏移量，默认为0，最大为20000
    $req->setOffset($offset);
    // 返回最大数量，最大为20
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