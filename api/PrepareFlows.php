<?php
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/./Common.php');
require_once(__DIR__ . '/../config.php');

use TencentCloud\Essbasic\V20210526\Models\PrepareFlowsRequest;
use TencentCloud\Essbasic\V20210526\Models\FlowInfo;
use TencentCloud\Essbasic\V20210526\Models\FlowApproverInfo;

// PrepareFlows
// 该接口 (PrepareFlows) 用于创建待发起文件
// 用户通过该接口进入签署流程发起的确认页面，进行发起信息二次确认， 如果确认则进行正常发起。
// 目前该接口只支持B2C，不建议使用，将会废弃。
// 详细参考 https://cloud.tencent.com/document/api/1420/61519
function PrepareFlows($flowInfos, $jumpUrl)  {
    // 构造客户端调用实例
    $client = GetClientInstance(Config::secretId, Config::secretKey, Config::endPoint);

    // 实例化一个请求对象,每个接口都会对应一个request对象
    $req = new PrepareFlowsRequest();

    // 第三方平台应用相关信息
	// 此接口Agent.ProxyOrganizationOpenId、Agent. ProxyOperator.OpenId、Agent.AppId 和 Agent.ProxyAppId 均必填。
    $agent = GetAgent();
    $req->setAgent($agent);

    // 多个合同（签署流程）信息，最大支持20个签署流程。
    $req->setFlowInfos($flowInfos);
    // 操作完成后的跳转地址，最大长度200
    $req->setJumpUrl($jumpUrl);


    $resp = $client->PrepareFlows($req);

    return $resp;
}

// 准备待发起文件
try {

    $templateId = Config::templateId;
    $flowName = "我的第一个合同";

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

    $jumpUrl = "https://www.qq.com";

    $resp = PrepareFlows(array($flowInfo), $jumpUrl);
    print_r($resp);
} catch (TencentCloudSDKException $e) {
    echo $e;
}
