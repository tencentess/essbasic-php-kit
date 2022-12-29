<?php
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/./Common.php');
require_once(__DIR__ . '/../config.php');

use TencentCloud\Common\Exception\TencentCloudSDKException;
use TencentCloud\Essbasic\V20210526\Models\ChannelCancelMultiFlowSignQRCodeRequest;

// ChannelCancelMultiFlowSignQRCode 
// 用于取消一码多扫二维码。该接口对传入的二维码ID，若还在有效期内，可以提前失效
// 详细参考 https://cloud.tencent.com/document/api/1420/75453
function ChannelCancelMultiFlowSignQRCode($qrCodeId)  {
    // 构造客户端调用实例
    $client = GetClientInstance(Config::secretId, Config::secretKey, Config::endPoint);

    // 实例化一个请求对象,每个接口都会对应一个request对象
    $req = new ChannelCancelMultiFlowSignQRCodeRequest();

    // 渠道应用相关信息。 
	// 此接口Agent.ProxyOrganizationOpenId、Agent. ProxyOperator.OpenId、Agent.AppId 和 Agent.ProxyAppId 均必填。
    $agent = GetAgent();
    $req->setAgent($agent);
    // 二维码ID
    $req->setQrCodeId($qrCodeId);

    // 返回的resp是一个ChannelCancelMultiFlowSignQRCodeResponse的实例，与请求对象对应
    return $client->ChannelCancelMultiFlowSignQRCode($req);
}

try {
    $qrCodeId = "********************************";

    $resp = ChannelCancelMultiFlowSignQRCode($qrCodeId);
    print_r($resp);
} catch (TencentCloudSDKException $e) {
    echo $e;
}