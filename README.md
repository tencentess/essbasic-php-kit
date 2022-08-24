# 腾讯电子签渠道版API接入工具包

## 项目说明
项目通过composer引入了腾讯云sdk，补充了调用电子签企业版API所需要的内容，并提供了调用的样例。使用前请先在项目中导入腾讯云sdk。

## 通过 Composer 安装腾讯云sdk
通过 Composer 获取安装是使用 PHP SDK 的推荐方法，Composer 是 PHP 的依赖管理工具，支持您项目所需的依赖项，并将其安装到项目中。关于 Composer 详细可参考 Composer 官网。
1. 安装Composer：
   windows环境请访问[Composer官网](https://getcomposer.org/download/)下载安装包安装。

   unix环境在命令行中执行以下命令安装。
   > curl -sS https://getcomposer.org/installer | php

   > sudo mv composer.phar /usr/local/bin/composer
2. 建议中国大陆地区的用户设置腾讯云镜像源：`composer config -g repos.packagist composer https://mirrors.tencent.com/composer/`
3. 执行命令 `composer require tencentcloud/tencentcloud-sdk-php` 添加依赖。如果只想安装某个产品的，可以使用`composer require tencentcloud/产品名`，例如`composer require tencentcloud/essbasic`。
4. 在代码中添加以下引用代码。注意：如下仅为示例，composer 会在项目根目录下生成 vendor 目录，`/path/to/`为项目根目录的实际绝对路径，如果是在当前目录执行，可以省略绝对路径。

   > require '/path/to/vendor/autoload.php';

## 目录文件说明
### api
api目录是对电子签渠道版所有API的简单封装，以及调用的Example。
如果需要API更加高级的功能，需要结合业务修改api的封装。

### byfile
byfile目录是电子签渠道版的核心场景之一 - 通过文件发起的快速上手样例。
业务方可以结合自己的业务调整，用于正式对接。

### bytemplate
byfile目录是电子签渠道版的核心场景之一 - 通过模版发起的快速上手样例。
业务方可以结合自己的业务调整，用于正式对接。

### callback
callback目录是电子签渠道版对接的回调解密部分。
业务方需要配置好回调地址和加密key，就可以接收到相关的回调了。

### testdata
testdata是一个空白的pdf用于快速发起合同，测试。

### config.php
里面定义调用电子签渠道版API需要的一些核心参数。

## 电子签渠道版官网入口
[腾讯电子签渠道版](https://cloud.tencent.com/document/product/1420/61534)