<?php
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/../config.php');
require_once(__DIR__ . '/./UploadFiles.php');
require_once(__DIR__ . '/./ChannelCreateFlowByFiles.php');
require_once(__DIR__ . '/./CreateSignUrls.php');

// CreateFlowByFileDirectly 通过文件base64直接发起签署流程，返回flowId和签署链接
// 本接口是对于发起合同几个接口的封装，详细参数需要根据自身业务进行调整
// UploadFiles--ChannelCreateFlowByFiles--CreateSignUrls
function CreateFlowByFileDirectly($fileBase64, $flowName, $approvers)  {

    // 上传文件获取fileId
    $uploadResp = UploadFiles($fileBase64, $flowName);
    $fileId = $uploadResp->FileIds[0];

    // 创建签署流程
    $flowResp = ChannelCreateFlowByFiles($approvers, $flowName, $fileId);
    // 获取flowId
    $flowId = $flowResp->getFlowId();

    $flowIds = [];
    array_push($flowIds, $flowId);

    // 获取签署链接
    $urlResp = CreateSignUrls($flowIds);
    $urls = array();
    foreach ($urlResp->SignUrlInfos as  $u) {
        array_push($urls, $u->SignUrl);
    }

    return array(
        'FlowId' => $flowId,
        'Urls' => $urls
    );

}