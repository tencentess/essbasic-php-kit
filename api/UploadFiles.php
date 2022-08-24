<?php
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/./Common.php');
require_once(__DIR__ . '/../config.php');

use TencentCloud\Essbasic\V20210526\Models\UploadFilesRequest;
use TencentCloud\Essbasic\V20210526\Models\UploadFile;


function UploadFiles($fileBase64, $filename)  {
    // 构造客户端调用实例
    $client = GetClientInstance(Config::secretId, Config::secretKey, Config::fileServiceEndPoint);

    // 实例化一个请求对象,每个接口都会对应一个request对象
    $req = new UploadFilesRequest();

    $agent = GetAgent();
    $req->setAgent($agent);

    // 文件对应业务类型，用于区分文件存储路径：
    // 1. TEMPLATE - 模板； 文件类型：.pdf/.html
    // 2. DOCUMENT - 签署过程及签署后的合同文档 文件类型：.pdf/.html
    // 3. SEAL - 印章； 文件类型：.jpg/.jpeg/.png
    $req->setBusinessType("DOCUMENT");

    // 上传文件内容
    $file = new UploadFile();
    // Base64编码后的文件内容
    $file->setFileBody($fileBase64);
    // 文件名，最大长度不超过200字符
    $file->setFileName($filename);

    $req->FileInfos = [];
    array_push($req->FileInfos, $file);

    $resp = $client->UploadFiles($req);

    return $resp;

}