<?php
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/./Common.php');
require_once(__DIR__ . '/../config.php');

use TencentCloud\Essbasic\V20210526\Models\ChannelCreateFlowByFilesRequest;
use TencentCloud\Essbasic\V20210526\Models\FlowApproverInfo;
use TencentCloud\Essbasic\V20210526\Models\Component;
use TencentCloud\Common\Exception\TencentCloudSDKException;

function ChannelCreateFlowByFiles($flowApprovers, $flowName, $fileId)  {
    // 构造客户端调用实例
    $client = GetClientInstance(Config::secretId, Config::secretKey, Config::endPoint);

    // 实例化一个请求对象,每个接口都会对应一个request对象
    $req = new ChannelCreateFlowByFilesRequest();

    $agent = GetAgent();
    $req->setAgent($agent);

    $req->setFlowApprovers($flowApprovers);

    $req->setFlowName($flowName);

    $req->setFileIds(array($fileId));

    $resp = $client->ChannelCreateFlowByFiles($req);

    return $resp;

}

// 使用文件创建合同
try {
    //创建签署区
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

    //生成签署人
    $approver = new FlowApproverInfo();
    $approver->setApproverType("PERSON");
    $approver->setName("**");
    $approver->setMobile("**");
    $approver->setSignComponents($components);

    //流程名称
    $flowName = "我的第一个合同";
    //文件id, 从UploadFile 获取
    $fileId = "***********************";
    $approvers = [];
    array_push($approvers, $approver);


    $resp = ChannelCreateFlowByFiles($approvers, $flowName, $fileId);
    print_r($resp);
} catch (TencentCloudSDKException $e) {
    echo $e;
}