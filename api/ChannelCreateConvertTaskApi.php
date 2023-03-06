<?php
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/./Common.php');
require_once(__DIR__ . '/../config.php');

use TencentCloud\Essbasic\V20210526\Models\ChannelCreateConvertTaskApiRequest;
use TencentCloud\Common\Exception\TencentCloudSDKException;

// ChannelCreateConvertTaskApi
// 平台企业创建文件转换任务
// 详细参考 https://cloud.tencent.com/document/api/1420/78774
function ChannelCreateConvertTaskApi($resourceType, $resourceName, $resourceId)  {
    // 构造客户端调用实例
    $client = GetClientInstance(Config::secretId, Config::secretKey, Config::endPoint);

    // 实例化一个请求对象,每个接口都会对应一个request对象
    $req = new ChannelCreateConvertTaskApiRequest();

    // 第三方平台应用相关信息。
	// 此接口Agent.ProxyOrganizationOpenId、Agent. ProxyOperator.OpenId、Agent.AppId 和 Agent.ProxyAppId 均必填。
    $agent = GetAgent();
    $req->setAgent($agent);

    // 资源名称，长度限制为256字符
    $req->setResourceName($resourceName);
    // 资源类型 取值范围doc,docx,html,xls,xlsx之一
    $req->setResourceType($resourceType);
    // 资源Id，通过UploadFiles获取
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