<?php
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/./Common.php');
require_once(__DIR__ . '/../config.php');

use TencentCloud\Essbasic\V20210526\Models\CreateFlowsByTemplatesRequest;
use TencentCloud\Essbasic\V20210526\Models\FlowInfo;
use TencentCloud\Essbasic\V20210526\Models\FlowApproverInfo;

function CreateFlowsByTemplates($flowInfos)  {
    // 构造客户端调用实例
    $client = GetClientInstance(Config::secretId, Config::secretKey, Config::endPoint);

    // 实例化一个请求对象,每个接口都会对应一个request对象
    $req = new CreateFlowsByTemplatesRequest();

    $agent = GetAgent();
    $req->setAgent($agent);

    $req->setFlowInfos($flowInfos);

    $resp = $client->CreateFlowsByTemplates($req);

    return $resp;

}

// 根据模板生成流程
try {

    $templateId = Config::templateId;
    $flowName = "我的第一份合同";

    // 构造签署人
    // 此块代码中的$approvers仅用于快速发起一份合同样例，非正式对接用
    $approvers = [];
    $personName = "**"; // 个人签署方的姓名
    $personMobile = "***********"; // 个人签署方的手机号
    // 签署参与者信息
    // 个人签署方
    $approver = new FlowApproverInfo();
    $approver->setApproverType("PERSON");

    $approver->setName($personName);

    $approver->setMobile($personMobile);

    array_push($approvers, $approver);


    $flowInfo = new FlowInfo();
    $flowInfo->setTemplateId($templateId);
    $flowInfo->setFlowName($flowName);
    $flowInfo->setFlowType("");
    $flowInfo->setFlowApprovers($approvers);

    $resp = CreateFlowsByTemplates(array($flowInfo));
    print_r($resp);
} catch (TencentCloudSDKException $e) {
    echo $e;
}