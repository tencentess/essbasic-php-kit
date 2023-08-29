<?php
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/./Common.php');
require_once(__DIR__ . '/../config.php');

use TencentCloud\Essbasic\V20210526\Models\ChannelGetTaskResultApiRequest;
use TencentCloud\Common\Exception\TencentCloudSDKException;

function ChannelGetTaskResultApi($taskId)  {
    // 构造客户端调用实例
    $client = GetClientInstance(Config::secretId, Config::secretKey, Config::endPoint);

    // 实例化一个请求对象,每个接口都会对应一个request对象
    $req = new ChannelGetTaskResultApiRequest();

    $agent = GetAgent();
    $req->setAgent($agent);

    $req->setTaskId($taskId);

    $resp = $client->ChannelGetTaskResultApi($req);

    return $resp;

}

// 获取转换任务结果
try {
    //taskid, 从ChannelCreateConvertTaskApi 中获取
    $taskId = "*****************";

    $resp = ChannelGetTaskResultApi($taskId);
    print_r($resp);
} catch (TencentCloudSDKException $e) {
    echo $e;
}
