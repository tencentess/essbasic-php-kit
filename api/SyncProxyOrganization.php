<?php
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/./Common.php');
require_once(__DIR__ . '/../config.php');

use TencentCloud\Common\Exception\TencentCloudSDKException;
use TencentCloud\Essbasic\V20210526\Models\SyncProxyOrganizationRequest;

// SyncProxyOrganization
// 用于同步渠道子客企业信息，主要是子客企业的营业执照，便于子客企业开通过程中不用手动上传。
// 若有需要调用此接口，需要在创建控制链接CreateConsoleLoginUrl之后即刻进行调用。
// 详细参考 https://cloud.tencent.com/document/api/1420/61518
function SyncProxyOrganization($proxyOrganizationName, $businessLicense, $uniformSocialCreditCode, $proxyLegalName)  {
    // 构造客户端调用实例
    $client = GetClientInstance(Config::secretId, Config::secretKey, Config::endPoint);

    // 实例化一个请求对象,每个接口都会对应一个request对象
    $req = new SyncProxyOrganizationRequest();

    // 应用信息
	// 此接口Agent.AppId、Agent.ProxyOrganizationOpenId必填
    $agent = GetAgent();
    $req->setAgent($agent);

    // 渠道侧合作企业名称，最大长度64个字符
    $req->setProxyOrganizationName($proxyOrganizationName);
    // 营业执照正面照(PNG或JPG) base64格式, 大小不超过5M
    $req->setBusinessLicense($businessLicense);
    // 渠道侧合作企业统一社会信用代码，最大长度200个字符
    $req->setUniformSocialCreditCode($uniformSocialCreditCode);
    // 渠道侧合作企业法人/负责人姓名
    $req->setProxyLegalName($proxyLegalName);

    // 返回的resp是一个SyncProxyOrganizationResponse的实例，与请求对象对应
    return $client->SyncProxyOrganization($req);
}

try {
    $proxyOrganizationName = "********************************";

    $filePath = "../testdata/test_businessLicense.png";
    $handle = fopen($filePath, "rb");
    $contents = fread($handle, filesize ($filePath));
    fclose($handle);
    $businessLicense = chunk_split(base64_encode($contents));

    $uniformSocialCreditCode = "********************************";
    $proxyLegalName = "********************************";
    $resp = SyncProxyOrganization($proxyOrganizationName, $businessLicense, $uniformSocialCreditCode, $proxyLegalName);
    print_r($resp);
} catch (TencentCloudSDKException $e) {
    echo $e;
}