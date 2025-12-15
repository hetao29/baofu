<?php

/**
 * 宝付账簿 - 个人/机构账户间转账接口
 * https://doc.mandao.com/docs/bct/accTransfer
 */
require_once 'init.php';

Baofu\Util\Log::EchoFormat("==========================");
Baofu\Util\Log::EchoFormat("宝付账簿个人/机构账户间转账接口");
Baofu\Util\Log::EchoFormat("==========================");


/* Header 参数*/
$HeaderPost = array();
$HeaderPost["memberId"] = $GLOBALS["Member_Id"]; //宝付提供给商户的唯一编号
$HeaderPost["terminalId"] = $GLOBALS["Terminal_Id"];
$HeaderPost["serviceTp"] = "T-1001-013-13"; //报文编号
$HeaderPost["verifyType"] = "1"; //加密方式目前只有1种，请填：1

$contentData = array();
$contentData["header"] = $HeaderPost;


$BodyData = array();
$BodyData["version"] = "4.0.0"; //版本号

$BodyData["payerNo"] = "CP610000000000188888"; //付款方(二级子商户号)
$BodyData["payeeNo"] = "CP610000000000188978"; //收款方(二级子商户号)

$BodyData["transSerialNo"] = Baofu\Util\Tools::getTransid("TSN"); //商户订单号
$BodyData["dealAmount"] = "10.05"; //单位（元）
Baofu\Util\Log::EchoFormat("转账订单：" . $BodyData["transSerialNo"]);

$contentData["body"] = $BodyData;

$JsonObject = json_encode($contentData);
Baofu\Util\Log::EchoFormat("JSON：" . $JsonObject);

$Data_Content = Baofu\Security\RSA::encryptByPFXFile($JsonObject, $GLOBALS["PFX_FILE_PATH"], $GLOBALS["Key_Pwd"]);
$HeaderPost["content"] = $Data_Content;

$result = Baofu\Client::call($GateWay_Account . $HeaderPost["serviceTp"] . "/transReq.do", $HeaderPost, $GLOBALS["CER_FILE_PATH"]);

Baofu\Util\Log::EchoFormat("解密明文：" , $result);
