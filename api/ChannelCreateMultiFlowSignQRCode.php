<?php
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/./Common.php');
require_once(__DIR__ . '/../config.php');

use TencentCloud\Common\Exception\TencentCloudSDKException;
use TencentCloud\Essbasic\V20210526\Models\ChannelCreateMultiFlowSignQRCodeRequest;
use TencentCloud\Essbasic\V20210526\Models\ApproverRestriction;

function ChannelCreateMultiFlowSignQRCode($templateId, $flowName, $maxFlowNum, $flowEffectiveDay,
                                          $qrEffectiveDay, $restrictions, $callbackUrl)  {
    // 构造客户端调用实例
    $client = GetClientInstance(Config::secretId, Config::secretKey, Config::endPoint);

    // 实例化一个请求对象,每个接口都会对应一个request对象
    $req = new ChannelCreateMultiFlowSignQRCodeRequest();

    $agent = GetAgent();
    $req->setAgent($agent);


    $req->setTemplateId($templateId);

    $req->setFlowName($flowName);

    $req->setMaxFlowNum($maxFlowNum);

    $req->setFlowEffectiveDay($flowEffectiveDay);

    $req->setQrEffectiveDay($qrEffectiveDay);

    $req->setRestrictions($restrictions);

    $req->setCallbackUrl($callbackUrl);

    // 返回的resp是一个ChannelCreateMultiFlowSignQRCodeResponse的实例，与请求对象对应
    return $client->ChannelCreateMultiFlowSignQRCode($req);
}

try {
    $qrCodeId = "********************************";

    $templateId = "********************************";
    $flowName = "********************************";
    $maxFlowNum = 10;
    $flowEffectiveDay = 7;
    $qrEffectiveDay = 7;

    $restriction = new ApproverRestriction();
    $restriction -> setName("********************************");
    $restriction -> setMobile("********************************");
    $restriction -> setIdCardType("********************************");
    $restriction -> setIdCardNumber("********************************");
    $restrictions = [$restriction];

    $callbackUrl = "********************************";

    $resp = ChannelCreateMultiFlowSignQRCode($templateId, $flowName, $maxFlowNum, $flowEffectiveDay,
        $qrEffectiveDay, $restrictions, $callbackUrl);
    print_r($resp);
} catch (TencentCloudSDKException $e) {
    echo $e;
}