<?php
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/./Common.php');
require_once(__DIR__ . '/../config.php');

use TencentCloud\Essbasic\V20210526\Models\CreateConsoleLoginUrlRequest;


function CreateConsoleLoginUrl($proxyOrganizationName)  {
    // 构造客户端调用实例
    $client = GetClientInstance(Config::secretId, Config::secretKey, Config::endPoint);

    // 实例化一个请求对象,每个接口都会对应一个request对象
    $req = new CreateConsoleLoginUrlRequest();

    $agent = GetAgent();
    $agent->setProxyAppId("");
    $req->setAgent($agent);
    $req->setProxyOrganizationName($proxyOrganizationName);

    // 返回的resp是一个CreateConsoleLoginUrlResponse的实例，与请求对象对应
    $resp = $client->CreateConsoleLoginUrl($req);

    return $resp;

}