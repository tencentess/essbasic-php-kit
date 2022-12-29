<?php
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/./Common.php');
require_once(__DIR__ . '/../config.php');

use TencentCloud\Essbasic\V20210526\Models\DescribeTemplatesRequest;
use TencentCloud\Common\Exception\TencentCloudSDKException;

// DescribeTemplates 查询该子客企业在电子签拥有的有效模板，不包括渠道模板
// 详细参考 https://cloud.tencent.com/document/api/1420/61521
function DescribeTemplates($templateId)  {
    // 构造客户端调用实例
    $client = GetClientInstance(Config::secretId, Config::secretKey, Config::endPoint);

    // 实例化一个请求对象,每个接口都会对应一个request对象
    $req = new DescribeTemplatesRequest();

    // 渠道应用相关信息。 
	// 此接口Agent.ProxyOrganizationOpenId、Agent. ProxyOperator.OpenId、Agent.AppId 和 Agent.ProxyAppId 均必填。
    $agent = GetAgent();
    $req->setAgent($agent);

    // 模板唯一标识，查询单个模板时使用
    $req->setTemplateId($templateId);

    // 其他查询参数参考官网文档
	// https://cloud.tencent.com/document/api/1420/61521

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
