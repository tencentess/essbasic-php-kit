<?php
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/./Common.php');
require_once(__DIR__ . '/../config.php');

use TencentCloud\Common\Exception\TencentCloudSDKException;
use TencentCloud\Essbasic\V20210526\Models\OperateChannelTemplateRequest;

// OperateChannelTemplate
// 用于针对渠道模板库中的模板对子客企业可见性的查询和设置，不会直接分配渠道模板给子客企业。
// 1、OperateType=select时：
// 查询渠道模板库
// 2、OperateType=update或者delete时：
// 对子客企业进行模板库中模板可见性的修改、删除操作。
// 详细参考 https://cloud.tencent.com/document/api/1420/66367
function OperateChannelTemplate($operateType, $templateId, $authTag, $proxyOrganizationOpenIds)  {
    // 构造客户端调用实例
    $client = GetClientInstance(Config::secretId, Config::secretKey, Config::endPoint);

    // 实例化一个请求对象,每个接口都会对应一个request对象
    $req = new OperateChannelTemplateRequest();

    // 渠道应用相关信息。 
	// 此接口Agent.ProxyOrganizationOpenId、Agent. ProxyOperator.OpenId、Agent.AppId 和 Agent.ProxyAppId 均必填。
    $agent = GetAgent();
    $req->setAgent($agent);

    // 操作类型，查询:"SELECT"，删除:"DELETE"，更新:"UPDATE"
    $req->setOperateType($operateType);
    // 渠道方模板库模板唯一标识
    $req->setTemplateId($templateId);
    // 模板可见性, 全部可见-"all", 部分可见-"part"
    $req->setAuthTag($authTag);
    // 合作企业方第三方机构唯一标识数据，支持多个， 用","进行分隔
    $req->setProxyOrganizationOpenIds($proxyOrganizationOpenIds);

    // 返回的resp是一个OperateChannelTemplateResponse的实例，与请求对象对应
    return $client->OperateChannelTemplate($req);
}

try {
    $operateType = "SELECT";
    $templateId = "********************************";
    $authTag = "all";
    $proxyOrganizationOpenIds = "";
    $resp = OperateChannelTemplate($operateType, $templateId, $authTag, $proxyOrganizationOpenIds);
    print_r($resp);
} catch (TencentCloudSDKException $e) {
    echo $e;
}