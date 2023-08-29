<?php
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/./Common.php');
require_once(__DIR__ . '/../config.php');

use TencentCloud\Essbasic\V20210526\Models\ChannelCancelFlowRequest;

function ChannelCancelFlow($flowId, $cancelMessage)  {
    // 构造客户端调用实例
    $client = GetClientInstance(Config::secretId, Config::secretKey, Config::endPoint);

    // 实例化一个请求对象,每个接口都会对应一个request对象
    $req = new ChannelCancelFlowRequest();

    $agent = GetAgent();
    $req->setAgent($agent);

    $req->setCancelMessage($cancelMessage);

    $req->setFlowId($flowId);

    $resp = $client->ChannelCancelFlow($req);

    return $resp;
}

// 批量撤销合同
try {
    $flowId = '*****************';
    $cancelMessage = "撤销理由";
    $resp = ChannelCancelFlow($flowId, $cancelMessage);
    print_r($resp);
} catch (TencentCloudSDKException $e) {
    echo $e;
}
