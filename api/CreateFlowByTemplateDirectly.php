<?php
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/./Common.php');
require_once(__DIR__ . '/../config.php');

require_once(__DIR__ . '/./CreateFlowsByTemplates.php');
require_once(__DIR__ . '/./CreateSignUrls.php');

use TencentCloud\Essbasic\V20210526\Models\FlowInfo;



function CreateFlowByTemplateDirectly($templateId, $flowName, $approvers)  {


    $flowInfo = new FlowInfo();
    $flowInfo->setTemplateId($templateId);
    $flowInfo->setFlowName($flowName);
    $flowInfo->setFlowType("");
    $flowInfo->setFlowApprovers($approvers);

    $flowResp = CreateFlowsByTemplates(array($flowInfo));
    $flowIds = $flowResp->FlowIds;


    $urlResp = CreateSignUrls($flowIds);
    $urls = array();
    foreach ($urlResp->SignUrlInfos as  $u) {
        array_push($urls, $u->SignUrl);
    }

    return array(
        'FlowIds' => $flowIds,
        'Urls' => $urls
    );

}