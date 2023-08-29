<?php
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/./Common.php');
require_once(__DIR__ . '/../config.php');

use TencentCloud\Essbasic\V20210526\Models\DescribeResourceUrlsByFlowsRequest;

function DescribeResourceUrlsByFlows($flowIds)  {
    // 构造客户端调用实例
    $client = GetClientInstance(Config::secretId, Config::secretKey, Config::endPoint);

    // 实例化一个请求对象,每个接口都会对应一个request对象
    $req = new DescribeResourceUrlsByFlowsRequest();

    $agent = GetAgent();
    $req->setAgent($agent);

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