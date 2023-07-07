<?php
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/./Common.php');
require_once(__DIR__ . '/../config.php');

use TencentCloud\Essbasic\V20210526\Models\CreateFlowsByTemplatesRequest;
use TencentCloud\Essbasic\V20210526\Models\FlowInfo;
use TencentCloud\Essbasic\V20210526\Models\FlowApproverInfo;

// CreateFlowsByTemplates
// 用于使用多个模板批量创建签署流程。当前可批量发起合同（签署流程）数量最大为20个。
// 如若在模板中配置了动态表格, 上传的附件必须为A4大小
// 合同发起人必须在电子签已经进行实名。
// 详细参考 https://cloud.tencent.com/document/api/1420/61523
function CreateFlowsByTemplates($flowInfos)  {
    // 构造客户端调用实例
    $client = GetClientInstance(Config::secretId, Config::secretKey, Config::endPoint);

    // 实例化一个请求对象,每个接口都会对应一个request对象
    $req = new CreateFlowsByTemplatesRequest();

    // 第三方平台应用相关信息
	// 此接口Agent.ProxyOrganizationOpenId、Agent. ProxyOperator.OpenId、Agent.AppId 必填。
    $agent = GetAgent();
    $req->setAgent($agent);

    // 多个合同（签署流程）信息，最多支持20个
	// 详细参考 https://cloud.tencent.com/document/api/1420/61525#FlowInfo
	// 签署人 https://cloud.tencent.com/document/api/1420/61525#FlowApproverInfo
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
    // 本环节需要操作人的名字
    $approver->setName($personName);
    // 本环节需要操作人的手机号
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