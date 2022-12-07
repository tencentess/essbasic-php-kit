<?php
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/./Common.php');
require_once(__DIR__ . '/../config.php');

use TencentCloud\Essbasic\V20210526\Models\GetDownloadFlowUrlRequest;
use TencentCloud\Essbasic\V20210526\Models\DownloadFlowInfo;


function GetDownloadFlowUrl($downloadFlowInfo)  {
    // 构造客户端调用实例
    $client = GetClientInstance(Config::secretId, Config::secretKey, Config::endPoint);

    // 实例化一个请求对象,每个接口都会对应一个request对象
    $req = new GetDownloadFlowUrlRequest();

    $agent = GetAgent();
    $req->setAgent($agent);

    $req->setDownLoadFlows($downloadFlowInfo);

    $resp = $client->GetDownloadFlowUrl($req);

    return $resp;
}

// 获取下载链接的url , 这个方法生成的是跳转链接
try {
    $downloadFlows = [];

    $flowId = "*****************";
    $flowIds = [];
    array_push($flowIds, $flowId);
    $downloadFlow = new DownloadFlowInfo();
    $downloadFlow -> setFileName("我的第一份合同");
    $downloadFlow -> setFlowIdList($flowIds);



    $resp = GetDownloadFlowUrl(array($downloadFlow));
    print_r($resp);
} catch (TencentCloudSDKException $e) {
    echo $e;
}