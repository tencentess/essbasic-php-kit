<?php
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/./Common.php');
require_once(__DIR__ . '/../config.php');

use TencentCloud\Common\Exception\TencentCloudSDKException;
use TencentCloud\Essbasic\V20210526\Models\ChannelCreateMultiFlowSignQRCodeRequest;
use TencentCloud\Essbasic\V20210526\Models\ApproverRestriction;

// ChannelCreateMultiFlowSignQRCode
//  用于创建一码多扫流程签署二维码。
//  适用场景：无需填写签署人信息，可通过模板id生成签署二维码，签署人可通过扫描二维码补充签署信息进行实名签署。常用于提前不知道签署人的身份信息场景，例如：劳务工招工、大批量员工入职等场景。
//  适用的模板仅限于B2C（1、无序签署，2、顺序签署时B静默签署，3、顺序签署时B非首位签署）、单C的模板，且模板中发起方没有填写控件。
// 详细参考 https://cloud.tencent.com/document/api/1420/75452
function ChannelCreateMultiFlowSignQRCode($templateId, $flowName, $maxFlowNum, $flowEffectiveDay,
                                          $qrEffectiveDay, $restrictions, $callbackUrl)  {
    // 构造客户端调用实例
    $client = GetClientInstance(Config::secretId, Config::secretKey, Config::endPoint);

    // 实例化一个请求对象,每个接口都会对应一个request对象
    $req = new ChannelCreateMultiFlowSignQRCodeRequest();

    // 渠道应用相关信息。
	// 此接口Agent.ProxyOrganizationOpenId、Agent. ProxyOperator.OpenId、Agent.AppId 和 Agent.ProxyAppId 必填。
    $agent = GetAgent();
    $req->setAgent($agent);

    // 模板ID
    $req->setTemplateId($templateId);
    // 签署流程名称，最大长度200个字符。
    $req->setFlowName($flowName);
    // 最大可发起签署流程份数，默认5份；发起签署流程数量超过此上限后，二维码自动失效
    $req->setMaxFlowNum($maxFlowNum);
    // 签署流程有效天数 默认7天 最高设置不超过30天
    $req->setFlowEffectiveDay($flowEffectiveDay);
    // 二维码有效天数 默认7天 最高设置不超过90天
    $req->setQrEffectiveDay($qrEffectiveDay);
    // 限制二维码用户条件
    $req->setRestrictions($restrictions);
    // 回调地址，最大长度1000个字符
    // 不传默认使用渠道应用号配置的回调地址
    // 回调时机:用户通过签署二维码发起合同时，企业额度不足导致失败
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