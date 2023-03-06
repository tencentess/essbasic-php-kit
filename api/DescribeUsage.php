<?php
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/./Common.php');
require_once(__DIR__ . '/../config.php');

use TencentCloud\Common\Exception\TencentCloudSDKException;
use TencentCloud\Essbasic\V20210526\Models\DescribeUsageRequest;

// DescribeUsage
// 此接口（DescribeUsage）用于获取第三方应用集成所有合作企业流量消耗情况。
// 注: 此接口每日限频2次，若要扩大限制次数,请提前与客服经理或邮件至e-contract@tencent.com进行联系。
// 详细参考 https://cloud.tencent.com/document/api/1420/61520
function DescribeUsage($startDate, $endDate, $needAggregate, $limit, $offset)  {
    // 构造客户端调用实例
    $client = GetClientInstance(Config::secretId, Config::secretKey, Config::endPoint);

    // 实例化一个请求对象,每个接口都会对应一个request对象
    $req = new DescribeUsageRequest();

    // 应用信息，此接口Agent.AppId必填
    $agent = GetAgent();
    $req->setAgent($agent);

    // 开始时间，例如：2021-03-21
    $req->setStartDate($startDate);
    // 结束时间，例如：2021-06-21；
	// 开始时间到结束时间的区间长度小于等于90天。
    $req->setEndDate($endDate);
    // 是否汇总数据，默认不汇总。
	// 不汇总：返回在统计区间内第三方应用集成下所有企业的每日明细，即每个企业N条数据，N为统计天数；
	// 汇总：返回在统计区间内第三方应用集成下所有企业的汇总后数据，即每个企业一条数据；
    $req->setNeedAggregate($needAggregate);
    // 单次返回的最多条目数量。默认为1000，且不能超过1000。
    $req->setLimit($limit);
    // 偏移量，默认是0。
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