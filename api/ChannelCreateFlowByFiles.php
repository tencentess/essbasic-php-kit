<?php
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/./Common.php');
require_once(__DIR__ . '/../config.php');

use TencentCloud\Essbasic\V20210526\Models\ChannelCreateFlowByFilesRequest;
use TencentCloud\Essbasic\V20210526\Models\FlowApproverInfo;
use TencentCloud\Essbasic\V20210526\Models\Component;
use TencentCloud\Common\Exception\TencentCloudSDKException;

// ChannelCreateFlowByFiles
// 用于第三方应用集成通过文件创建签署流程。
// 注意事项：该接口需要依赖“多文件上传”接口生成pdf资源编号（FileIds）进行使用。
// 此接口静默签能力不可直接使用，需要运营申请
// 详细参考 https://cloud.tencent.com/document/api/1420/73068
function ChannelCreateFlowByFiles($flowApprovers, $flowName, $fileId)  {
    // 构造客户端调用实例
    $client = GetClientInstance(Config::secretId, Config::secretKey, Config::endPoint);

    // 实例化一个请求对象,每个接口都会对应一个request对象
    $req = new ChannelCreateFlowByFilesRequest();

    // 第三方平台应用相关信息。
	// 此接口Agent.ProxyOrganizationOpenId、Agent. ProxyOperator.OpenId、Agent.AppId 必填。
    $agent = GetAgent();
    $req->setAgent($agent);

    // 签署流程签约方列表，最多不超过5个参与方
    $req->setFlowApprovers($flowApprovers);
    // 签署流程名称，长度不超过200个字符
    $req->setFlowName($flowName);
    // 签署文件资源Id列表，目前仅支持单个文件
    $req->setFileIds(array($fileId));

    // 其他更多参数和控制，参考文档 https://cloud.tencent.com/document/api/1420/73068
	// 也可以结合test case传参

    $resp = $client->ChannelCreateFlowByFiles($req);

    return $resp;

}

// 使用文件创建合同
try {
    //创建签署区
    $component = new Component();
    // 参数控件宽度，默认100，单位px，表单域和关键字转换控件不用填
    $component -> setComponentWidth(100);
    // 参数控件高度，默认100，单位px，表单域和关键字转换控件不用填
    $component -> setComponentHeight(100);
    // 参数控件X位置，单位px
    $component -> setComponentPosX(60);
    // 参数控件Y位置，单位px
    $component -> setComponentPosY(160);
    // 参数控件所在页码，从1开始
    $component -> setComponentPage(1);
    // 控件所属文件的序号 (文档中文件的排列序号，从0开始)
    $component -> setFileIndex(0);

    // 如果是Component控件类型，则可选的字段为：
    //TEXT - 普通文本控件；
    //DATE - 普通日期控件；跟TEXT相比会有校验逻辑
    //DYNAMIC_TABLE- 动态表格控件
    //如果是SignComponent控件类型，则可选的字段为
    //SIGN_SEAL - 签署印章控件；
    //SIGN_DATE - 签署日期控件；
    //SIGN_SIGNATURE - 用户签名控件；
    //SIGN_PERSONAL_SEAL - 个人签署印章控件；
    //表单域的控件不能作为印章和签名控件
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