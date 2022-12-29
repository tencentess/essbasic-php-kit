<?php
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/./Common.php');
require_once(__DIR__ . '/../config.php');

require_once(__DIR__ . '/./CreateFlowsByTemplates.php');
require_once(__DIR__ . '/./CreateSignUrls.php');

use TencentCloud\Essbasic\V20210526\Models\FlowInfo;


// CreateFlowByTemplateDirectly 通过合同名和模板Id直接发起签署流程
// 本接口是对于发起合同几个接口的封装，详细参数需要根据自身业务进行调整
// CreateFlowsByTemplates--CreateSignUrls
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