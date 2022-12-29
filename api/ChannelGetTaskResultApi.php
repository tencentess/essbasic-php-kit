<?php
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/./Common.php');
require_once(__DIR__ . '/../config.php');

use TencentCloud\Essbasic\V20210526\Models\ChannelGetTaskResultApiRequest;
use TencentCloud\Common\Exception\TencentCloudSDKException;

// ChannelGetTaskResultApi
// 渠道版查询转换任务状态
// 详细参考 https://cloud.tencent.com/document/api/1420/78773
function ChannelGetTaskResultApi($taskId)  {
    // 构造客户端调用实例
    $client = GetClientInstance(Config::secretId, Config::secretKey, Config::endPoint);

    // 实例化一个请求对象,每个接口都会对应一个request对象
    $req = new ChannelGetTaskResultApiRequest();

    // 渠道应用相关信息。 
	// 此接口Agent.ProxyOrganizationOpenId、Agent. ProxyOperator.OpenId、Agent.AppId 和 Agent.ProxyAppId 均必填。
    $agent = GetAgent();
    $req->setAgent($agent);

    // 任务Id，通过ChannelCreateConvertTaskApi接口获得
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
