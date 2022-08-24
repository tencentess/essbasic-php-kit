<?php

// 基础配置，调用API之前必须填充的参数
class Config
{
    // 调用API的密钥对，通过腾讯云控制台获取
    const secretId = '********************';
    const secretKey = '*******************';

    // appId: 应用号，电子签提供
    const appId = '***************';

    // 腾讯电子签颁发给渠道侧合作企业的应用ID
    const proxyAppId = '*****************';

    // 渠道/平台合作企业的企业ID
    const ProxyOrganizationOpenId = "***********";

    // 渠道/平台合作企业经办人（操作员）ID
    const ProxyOperatorOpenId = "*****************";

    // 企业方静默签用的印章Id，电子签控制台获取
    const ServerSignSealId = "****************";

    // 模板Id，电子签控制台获取，仅在通过模板发起时使用
    const templateId = "*******************";

    // API域名，现网使用 essbasic.ess.tencent.cn
    const endPoint = 'essbasic.test.ess.tencent.cn';

    // 文件服务域名，现网使用 file.ess.tencent.cn
    const fileServiceEndPoint = 'file.test.ess.tencent.cn';

    // 合同发起数量,可以修改
    const count = 1;

}
