<?php
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/./Common.php');
require_once(__DIR__ . '/../config.php');

use TencentCloud\Essbasic\V20210526\Models\DescribeTemplatesRequest;
use TencentCloud\Common\Exception\TencentCloudSDKException;


function DescribeTemplates($templateId)  {
    // 构造客户端调用实例
    $client = GetClientInstance(Config::secretId, Config::secretKey, Config::endPoint);

    // 实例化一个请求对象,每个接口都会对应一个request对象
    $req = new DescribeTemplatesRequest();

    $agent = GetAgent();
    $req->setAgent($agent);

    $req->setTemplateId($templateId);

    $resp = $client->DescribeTemplates($req);

    return $resp;

}


// 查询模板调用样例
try {
    $templateId = Config::templateId;
    $resp = DescribeTemplates($templateId);
    print_r($resp);
} catch (TencentCloudSDKException $e) {
    echo $e;
}
