<?php
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/./Common.php');
require_once(__DIR__ . '/../config.php');

use TencentCloud\Essbasic\V20210526\Models\GetDownloadFlowUrlRequest;
use TencentCloud\Essbasic\V20210526\Models\DownloadFlowInfo;

// GetDownloadFlowUrl
// 用于创建电子签批量下载地址，让合作企业进入控制台直接下载，支持客户合同（流程）按照自定义文件夹形式 分类下载。
// 当前接口限制最多合同（流程）50个.
// 详细参考 https://cloud.tencent.com/document/api/1420/66368
function GetDownloadFlowUrl($downloadFlowInfo)  {
    // 构造客户端调用实例
    $client = GetClientInstance(Config::secretId, Config::secretKey, Config::endPoint);

    // 实例化一个请求对象,每个接口都会对应一个request对象
    $req = new GetDownloadFlowUrlRequest();

    // 第三方平台应用相关信息
	// 此接口Agent.ProxyOrganizationOpenId、Agent. ProxyOperator.OpenId、Agent.AppId 必填。
    $agent = GetAgent();
    $req->setAgent($agent);

    // 文件夹数组，签署流程总数不能超过50个，一个文件夹下，不能超过20个签署流程
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