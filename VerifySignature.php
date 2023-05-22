<?php
require_once(__DIR__ . '/../vendor/autoload.php');

// 回调消息验证签名

// 回调消息体
$payload = "**********";
// secretToken 创建应用号时配置的
$secretToken = "**********";

// 1. 取出header [Content-Signature]
$signFromHeader = "***********";

// 2. 验证签名
$hash = hash_hmac('sha256', $payload, $secretToken);
//echo $hash == $signFromHeader;

//3. 如果验证通过，继续处理。如果不通过，忽略该请求
var_dump('sha256='.$hash == $signFromHeader);



