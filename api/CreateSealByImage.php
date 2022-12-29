<?php
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/./Common.php');
require_once(__DIR__ . '/../config.php');

use TencentCloud\Common\Exception\TencentCloudSDKException;
use TencentCloud\Essbasic\V20210526\Models\CreateSealByImageRequest;

// CreateSealByImage
// 渠道通过图片为子客代创建印章，图片最大5MB
function CreateSealByImage($sealName, $sealImage)  {
    // 构造客户端调用实例
    $client = GetClientInstance(Config::secretId, Config::secretKey, Config::endPoint);

    // 实例化一个请求对象,每个接口都会对应一个request对象
    $req = new CreateSealByImageRequest();

    $agent = GetAgent();
    $req->setAgent($agent);

    // 印章名称，最大长度不超过30字符
    $req->setSealName($sealName);
    // 印章图片base64
    $req->setSealImage($sealImage);

    // 返回的resp是一个CreateSealByImageResponse的实例，与请求对象对应
    return $client->CreateSealByImage($req);
}

try {
    $sealName = "********************************";

    $filePath = "../testdata/test_seal.png";
    $handle = fopen($filePath, "rb");
    $contents = fread($handle, filesize ($filePath));
    fclose($handle);
    $sealImage = chunk_split(base64_encode($contents));
    $resp = CreateSealByImage($sealName, $sealImage);
    print_r($resp);
} catch (TencentCloudSDKException $e) {
    echo $e;
}