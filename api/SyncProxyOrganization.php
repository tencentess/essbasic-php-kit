<?php
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/./Common.php');
require_once(__DIR__ . '/../config.php');

use TencentCloud\Common\Exception\TencentCloudSDKException;
use TencentCloud\Essbasic\V20210526\Models\SyncProxyOrganizationRequest;

function SyncProxyOrganization($proxyOrganizationName, $businessLicense, $uniformSocialCreditCode, $proxyLegalName)  {
    // 构造客户端调用实例
    $client = GetClientInstance(Config::secretId, Config::secretKey, Config::endPoint);

    // 实例化一个请求对象,每个接口都会对应一个request对象
    $req = new SyncProxyOrganizationRequest();

    $agent = GetAgent();
    $req->setAgent($agent);

    $req->setProxyOrganizationName($proxyOrganizationName);

    $req->setBusinessLicense($businessLicense);

    $req->setUniformSocialCreditCode($uniformSocialCreditCode);

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