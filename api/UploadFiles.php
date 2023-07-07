<?php
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/./Common.php');
require_once(__DIR__ . '/../config.php');

use TencentCloud\Common\Exception\TencentCloudSDKException;
use TencentCloud\Essbasic\V20210526\Models\UploadFilesRequest;
use TencentCloud\Essbasic\V20210526\Models\UploadFile;

// UploadFiles 用于生成pdf资源编号（FileIds）来配合“用PDF创建流程”接口使用，使用场景可详见“用PDF创建流程”接口说明。
// 调用时需要设置Domain, 正式环境为 file.ess.tencent.cn
// 测试环境为 https://file.test.ess.tencent.cn
// 详细参考 https://cloud.tencent.com/document/api/1420/71479
function UploadFiles($fileBase64, $filename)  {
    // 构造客户端调用实例
    $client = GetClientInstance(Config::secretId, Config::secretKey, Config::fileServiceEndPoint);

    // 实例化一个请求对象,每个接口都会对应一个request对象
    $req = new UploadFilesRequest();

    // 应用相关信息，AppId 和 ProxyOrganizationOpenId 必填
    $agent = GetAgent();
    $req->setAgent($agent);

    /// 文件对应业务类型
	// 1. TEMPLATE - 模板； 文件类型：.pdf/.doc/.docx/.html
	// 2. DOCUMENT - 签署过程及签署后的合同文档/图片控件 文件类型：.pdf/.doc/.docx/.jpg/.png/.xls.xlsx/.html
    $req->setBusinessType("DOCUMENT");

    // 上传文件内容数组，最多支持20个文件
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