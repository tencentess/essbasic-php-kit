<?php
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/../api/CreateFlowByFileDirectly.php');
require_once(__DIR__ . '/./byfile.php');
require_once(__DIR__ . '/../api/DescribeResourceUrlsByFlows.php');


use TencentCloud\Common\Exception\TencentCloudSDKException;

try {
    // Step 1
    // 定义文件所在的路径
    $filePath = __DIR__ . "/../testdata/test.pdf";
    // 定义合同名
    $flowName = '我的第一个合同';

    /// 构造签署人
    /// 此块代码中的$approvers仅用于快速发起一份合同样例，非正式对接用
    $personName = "**********"; // 个人签署方的姓名，必须是真实的才能正常签署
    $personMobile = "************"; // 个人签署方的手机号，必须是真实的才能正常签署

    $proxyOrganizationName = "我的企业名称";
    $loginResp = CreateConsoleLoginUrl($proxyOrganizationName);

    $approvers = [];
    array_push($approvers, BuildPersonApprover($personName, $personMobile));

    /// 如果是正式接入，需使用这里注释的$approvers。请进入BuildApprovers函数内查看说明，构造需要的场景参数
    /// $approvers = BuildApprovers();

    // Step 2
    // 将文件处理为Base64编码后的文件内容
    $handle = fopen($filePath, "rb");
    $contents = fread($handle, filesize ($filePath));
    fclose($handle);
    $fileBase64 = chunk_split(base64_encode($contents));

    // 发起合同
    $resp = CreateFlowByFileDirectly($fileBase64, $flowName, $approvers);

    // 返回控制台登录url
    print_r("您的控制台入口为：\r\n");
    print_r($loginResp->ConsoleUrl);
    print_r("\r\n\r\n");

    // 返回合同Id
    print_r("您创建的合同id为：\r\n");
    print_r($resp['FlowId']);
    print_r("\r\n\r\n");
    // 返回签署的链接
    print_r("签署链接（请在手机浏览器中打开）为：\r\n");
    print_r($resp['Urls']);
    print_r("\r\n\r\n");

    // Step 3
    // 下载合同

    $fileUrlResp = DescribeResourceUrlsByFlows(array($resp['FlowId']));
    // 返回合同下载链接
    print_r("请访问以下地址下载您的合同：\r\n");
    print_r($fileUrlResp->FlowResourceUrlInfos[0]->ResourceUrlInfos[0]->Url);
    print_r("\r\n\r\n");

} catch (TencentCloudSDKException $e) {
    echo $e;
}
