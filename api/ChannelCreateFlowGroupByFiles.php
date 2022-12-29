<?php
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/./Common.php');
require_once(__DIR__ . '/../config.php');

use TencentCloud\Essbasic\V20210526\Models\ChannelCreateFlowGroupByFilesRequest;
use TencentCloud\Essbasic\V20210526\Models\FlowFileInfo;
use TencentCloud\Essbasic\V20210526\Models\FlowApproverInfo;
use TencentCloud\Essbasic\V20210526\Models\Component;

// ChannelCreateFlowGroupByFiles
// 用于通过多文件创建合同组签署流程。
// 详细参考 https://cloud.tencent.com/document/api/1420/80390
function ChannelCreateFlowGroupByFiles($flowFileInfos, $flowGroupName)  {
    // 构造客户端调用实例
    $client = GetClientInstance(Config::secretId, Config::secretKey, Config::endPoint);

    // 实例化一个请求对象,每个接口都会对应一个request对象
    $req = new ChannelCreateFlowGroupByFilesRequest();

    // 渠道应用相关信息。 
	// 此接口Agent.ProxyOrganizationOpenId、Agent. ProxyOperator.OpenId、Agent.AppId 和 Agent.ProxyAppId 均必填。
    $agent = GetAgent();
    $req->setAgent($agent);

    // 每个子合同的发起所需的信息，数量限制2-100
	// 详细参考 https://cloud.tencent.com/document/product/1420/61534
    $req->setFlowFileInfos($flowFileInfos);
    // 合同组名称，长度不超过200个字符
    $req->setFlowGroupName($flowGroupName);

    $resp = $client->ChannelCreateFlowGroupByFiles($req);

    return $resp;

}

// 创建合同组
try {

    $fileId = "*****************";
    $flowGroupName = "第一个合同组";
    $flowName = "子合同";

    $component = new Component();
    $component -> setComponentWidth(100);
    $component -> setComponentHeight(100);
    $component -> setComponentPosX(60);
    $component -> setComponentPosY(160);
    $component -> setComponentPage(1);
    $component -> setFileIndex(0);
    $component -> setComponentType("SIGN_SIGNATURE");
    $components = [];
    array_push($components, $component);

    // 构造签署人
    // 此块代码中的$approvers仅用于快速发起一份合同样例，非正式对接用
    $approvers = [];
    $personName = "程龙"; // 个人签署方的姓名
    $personMobile = "18768158110"; // 个人签署方的手机号
    // 签署参与者信息
    // 个人签署方
    $approver = new FlowApproverInfo();
    $approver->setApproverType("PERSON");
    // 本环节需要操作人的名字
    $approver->setName($personName);
    // 本环节需要操作人的手机号
    $approver->setMobile($personMobile);
    $approver->setSignComponents($components);

    array_push($approvers, $approver);


    $flowInfo1 = new FlowFileInfo();
    $flowInfo1->setFileIds(array($fileId));
    $flowInfo1->setFlowName($flowName);
    $flowInfo1->setFlowApprovers($approvers);

    $flowInfo2 = new FlowFileInfo();
    $flowInfo2->setFileIds(array($fileId));
    $flowInfo2->setFlowName($flowName);
    $flowInfo2->setFlowApprovers($approvers);

    $flowInfos = [];
    array_push($flowInfos, $flowInfo1, $flowInfo2);
    $resp = ChannelCreateFlowGroupByFiles($flowInfos, $flowGroupName);
    print_r($resp);
} catch (TencentCloudSDKException $e) {
    echo $e;
}