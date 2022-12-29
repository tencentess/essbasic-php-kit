<?php
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/./Common.php');
require_once(__DIR__ . '/../config.php');

use TencentCloud\Essbasic\V20210526\Models\CreateConsoleLoginUrlRequest;

// CreateConsoleLoginUrl
// 用于创建渠道子客企业控制台Web/移动登录链接。登录链接是子客控制台的唯一入口。
// 若子客企业未激活，会进入企业激活流程，首次参与激活流程的经办人会成为超管。
// （若企业激活过程中填写信息有误，需要重置激活流程，可以换一个经办人OpenId获取新的链接进入。）
// 若子客企业已激活，使用了新的经办人OpenId进入，则会进入经办人的实名流程。
// 若子客企业、经办人均已完成认证，则会直接进入子客Web控制台。
// 详细参考 https://cloud.tencent.com/document/api/1420/61524
function CreateConsoleLoginUrl($proxyOrganizationName)  {
    // 构造客户端调用实例
    $client = GetClientInstance(Config::secretId, Config::secretKey, Config::endPoint);

    // 实例化一个请求对象,每个接口都会对应一个request对象
    $req = new CreateConsoleLoginUrlRequest();

    // 应用信息
	// 此接口Agent.AppId、Agent.ProxyOrganizationOpenId 和 Agent. ProxyOperator.OpenId 必填
    $agent = GetAgent();
    $agent->setProxyAppId("");
    $req->setAgent($agent);

    //渠道侧合作企业名称，最大长度64个字符
    $req->setProxyOrganizationName($proxyOrganizationName);

    // 其他参数根据业务需要参考接口文档
	// https://cloud.tencent.com/document/api/1420/61524

    // 返回的resp是一个CreateConsoleLoginUrlResponse的实例，与请求对象对应
	/* 返回ConsoleUrl说明：
	1. 所有类型的链接在企业未认证/员工未认证完成时，只要在有效期内（一年）都可以访问
	2. 若企业认证完成且员工认证完成后，重新获取pc端的链接5分钟之内有效，且只能访问一次
	3. 若企业认证完成且员工认证完成后，重新获取H5/APP的链接只要在有效期内（一年）都可以访问
	4. 此链接仅单次有效，使用后需要再次创建新的链接（部分聊天软件，如企业微信默认会对链接进行解析，此时需要使用类似“代码片段”的方式或者放到txt文件里发送链接）
	5. 创建的链接应避免被转义，如：&被转义为\u0026；如使用Postman请求后，请选择响应类型为 JSON，否则链接将被转义
	*/

    // 返回的resp是一个CreateConsoleLoginUrlResponse的实例，与请求对象对应
    $resp = $client->CreateConsoleLoginUrl($req);

    return $resp;

}