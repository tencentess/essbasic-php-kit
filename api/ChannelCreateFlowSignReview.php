<?php
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/./Common.php');
require_once(__DIR__ . '/../config.php');

use TencentCloud\Essbasic\V20210526\Models\ChannelCreateFlowSignReviewRequest;

function ChannelCreateFlowSignReview($flowId, $reviewType)  {
    // 构造客户端调用实例
    $client = GetClientInstance(Config::secretId, Config::secretKey, Config::endPoint);

    // 实例化一个请求对象,每个接口都会对应一个request对象
    $req = new ChannelCreateFlowSignReviewRequest();

    $agent = GetAgent();
    $req->setAgent($agent);


    $req->setFlowId($flowId);

    $req->setReviewType($reviewType);

    $resp = $client->ChannelCreateFlowSignReview($req);

    return $resp;
}

// 提交企业签署流程审批结果
try {
    $flowId = '*****************';
    $reviewType = "PASS";
    $resp = ChannelCreateFlowSignReview($flowId, $reviewType);
    print_r($resp);
} catch (TencentCloudSDKException $e) {
    echo $e;
}
