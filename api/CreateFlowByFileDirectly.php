<?php
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/../config.php');
require_once(__DIR__ . '/./UploadFiles.php');
require_once(__DIR__ . '/./ChannelCreateFlowByFiles.php');
require_once(__DIR__ . '/./CreateSignUrls.php');


function CreateFlowByFileDirectly($fileBase64, $flowName, $approvers)  {

    // 上传文件获取fileId
    $uploadResp = UploadFiles($fileBase64, $flowName);
    $fileId = $uploadResp->FileIds[0];


    $flowResp = ChannelCreateFlowByFiles($approvers, $flowName, $fileId);
    $flowId = $flowResp->getFlowId();

    $flowIds = [];
    array_push($flowIds, $flowId);

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