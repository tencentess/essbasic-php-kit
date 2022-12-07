<?php
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/./Common.php');
require_once(__DIR__ . '/../config.php');

use TencentCloud\Essbasic\V20210526\Models\ChannelCreateConvertTaskApiRequest;
use TencentCloud\Common\Exception\TencentCloudSDKException;


function ChannelCreateConvertTaskApi($resourceType, $resourceName, $resourceId)  {
    // 构造客户端调用实例
    $client = GetClientInstance(Config::secretId, Config::secretKey, Config::endPoint);

    // 实例化一个请求对象,每个接口都会对应一个request对象
    $req = new ChannelCreateConvertTaskApiRequest();

    $agent = GetAgent();
    $req->setAgent($agent);
    $req->setResourceName($resourceName);
    $req->setResourceType($resourceType);
    $req->setResourceId($resourceId);

    $resp = $client->ChannelCreateConvertTaskApi($req);

    return $resp;

}

// 创建转换任务
try {

    $resourceType = "docx";//取值范围doc,docx,html,xls,xlsx
    $resourceName = "我的第一个合同";
    //文件id, 从UploadFile 获取
    $resourceId = "*****************";

    $resp = ChannelCreateConvertTaskApi($resourceType, $resourceName, $resourceId);
    print_r($resp);
} catch (TencentCloudSDKException $e) {
    echo $e;
}