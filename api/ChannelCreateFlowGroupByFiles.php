<?php
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/./Common.php');
require_once(__DIR__ . '/../config.php');

use TencentCloud\Essbasic\V20210526\Models\ChannelCreateFlowGroupByFilesRequest;
use TencentCloud\Essbasic\V20210526\Models\FlowFileInfo;
use TencentCloud\Essbasic\V20210526\Models\FlowApproverInfo;
use TencentCloud\Essbasic\V20210526\Models\Component;

function ChannelCreateFlowGroupByFiles($flowFileInfos, $flowGroupName)  {
    // 构造客户端调用实例
    $client = GetClientInstance(Config::secretId, Config::secretKey, Config::endPoint);

    // 实例化一个请求对象,每个接口都会对应一个request对象
    $req = new ChannelCreateFlowGroupByFilesRequest();

    $agent = GetAgent();
    $req->setAgent($agent);

    $req->setFlowFileInfos($flowFileInfos);

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
    $personName = "**"; // 个人签署方的姓名
    $personMobile = "***********"; // 个人签署方的手机号
    // 签署参与者信息
    // 个人签署方
    $approver = new FlowApproverInfo();
    $approver->setApproverType("PERSON");

    $approver->setName($personName);

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