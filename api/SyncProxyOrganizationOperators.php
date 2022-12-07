<?php
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/./Common.php');
require_once(__DIR__ . '/../config.php');

use TencentCloud\Common\Exception\TencentCloudSDKException;
use TencentCloud\Essbasic\V20210526\Models\SyncProxyOrganizationOperatorsRequest;
use TencentCloud\Essbasic\V20210526\Models\ProxyOrganizationOperator;


function SyncProxyOrganizationOperators($operatorType, $proxyOrganizationOperators)  {
    // 构造客户端调用实例
    $client = GetClientInstance(Config::secretId, Config::secretKey, Config::endPoint);

    // 实例化一个请求对象,每个接口都会对应一个request对象
    $req = new SyncProxyOrganizationOperatorsRequest();

    $agent = GetAgent();
    $req->setAgent($agent);
    $req->setOperatorType($operatorType);
    $req->setProxyOrganizationOperators($proxyOrganizationOperators);

    // 返回的resp是一个SyncProxyOrganizationOperatorsResponse的实例，与请求对象对应
    return $client->SyncProxyOrganizationOperators($req);
}

try {
    $operatorType = "CREATE";

    $proxyOrganizationOperator = new ProxyOrganizationOperator();
    $proxyOrganizationOperator->setId("********************************");
    $proxyOrganizationOperator->setName("********************************");
    $proxyOrganizationOperator->setIdCardType("********************************");
    $proxyOrganizationOperator->setIdCardNumber("********************************");
    $proxyOrganizationOperator->setMobile("********************************");

    $proxyOrganizationOperators = [$proxyOrganizationOperator];

    $resp = SyncProxyOrganizationOperators($operatorType, $proxyOrganizationOperators);
    print_r($resp);
} catch (TencentCloudSDKException $e) {
    echo $e;
}