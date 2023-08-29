<?php
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/./Common.php');
require_once(__DIR__ . '/../config.php');

use TencentCloud\Common\Exception\TencentCloudSDKException;
use TencentCloud\Essbasic\V20210526\Models\UploadFilesRequest;
use TencentCloud\Essbasic\V20210526\Models\UploadFile;

function UploadFiles($fileBase64, $filename)  {
    // 构造客户端调用实例
    $client = GetClientInstance(Config::secretId, Config::secretKey, Config::fileServiceEndPoint);

    // 实例化一个请求对象,每个接口都会对应一个request对象
    $req = new UploadFilesRequest();

    $agent = GetAgent();
    $req->setAgent($agent);

    $req->setBusinessType("DOCUMENT");

    $file = new UploadFile();

    $file->setFileBody($fileBase64);

    $file->setFileName($filename);

    $req->FileInfos = [];
    array_push($req->FileInfos, $file);

    $resp = $client->UploadFiles($req);

    return $resp;

}

// 使用文件创建合同
try {
    //文件流

    // 定义文件所在的路径
    $filePath = __DIR__ . "/../testdata/电子签测试合同.docx";

    $handle = fopen($filePath, "rb");
    $contents = fread($handle, filesize ($filePath));
    fclose($handle);
    $fileBase64 = chunk_split(base64_encode($contents));
    //文件id, 从UploadFile 获取
    $fileName = "测试文件合同";


    $resp = UploadFiles($fileBase64, $fileName);
    print_r($resp);
} catch (TencentCloudSDKException $e) {
    echo $e;
}