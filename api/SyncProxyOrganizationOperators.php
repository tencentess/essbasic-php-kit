<?php
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/./Common.php');
require_once(__DIR__ . '/../config.php');

use TencentCloud\Common\Exception\TencentCloudSDKException;
use TencentCloud\Essbasic\V20210526\Models\SyncProxyOrganizationOperatorsRequest;
use TencentCloud\Essbasic\V20210526\Models\ProxyOrganizationOperator;

// SyncProxyOrganizationOperators
// 用于同步渠道子客企业经办人列表，主要是同步经办人的离职状态。
// 子客Web控制台的组织架构管理，是依赖于渠道平台的，无法针对员工做新增/更新/离职等操作。
// 若经办人信息有误，或者需要修改，也可以先将之前的经办人做离职操作，然后重新使用控制台链接CreateConsoleLoginUrl让经办人重新实名。
// 详细参考 https://cloud.tencent.com/document/api/1420/61517
function SyncProxyOrganizationOperators($operatorType, $proxyOrganizationOperators)  {
    // 构造客户端调用实例
    $client = GetClientInstance(Config::secretId, Config::secretKey, Config::endPoint);

    // 实例化一个请求对象,每个接口都会对应一个request对象
    $req = new SyncProxyOrganizationOperatorsRequest();

    // 渠道应用相关信息。 
	// 此接口Agent.AppId 和 Agent.ProxyOrganizationOpenId必填。
    $agent = GetAgent();
    $req->setAgent($agent);

    // 操作类型，新增:"CREATE"，修改:"UPDATE"，离职:"RESIGN"
    $req->setOperatorType($operatorType);
    // 经办人信息列表，最大长度200
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