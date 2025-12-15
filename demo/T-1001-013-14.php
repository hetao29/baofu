<?php

/**
 * 宝付账簿 - 账户提现接口
 * https://doc.mandao.com/docs/bct/accWithdrawal
 */
require_once 'init.php';

Baofu\Util\Log::EchoFormat("==========================");
Baofu\Util\Log::EchoFormat("宝付账簿提现接口");
Baofu\Util\Log::EchoFormat("==========================");


/* Header 参数*/
$HeaderPost = array();
$HeaderPost["memberId"] = $GLOBALS["WMember_Id"]; //宝付提供给商户的唯一编号
$HeaderPost["terminalId"] = $GLOBALS["WTerminal_Id"];
$HeaderPost["serviceTp"] = "T-1001-013-14"; //报文编号
$HeaderPost["verifyType"] = "1"; //加密方式目前只有1种，请填：1

$contentData = array();
$contentData["header"] = $HeaderPost;


$BodyData = array();
$BodyData["version"] = "4.0.0"; //版本号
$BodyData["contractNo"] = "CP610000000000188888"; //客户账户号
$BodyData["transSerialNo"] = Baofu\Util\Tools::getTransid("TSN"); //商户订单号
$BodyData["dealAmount"] = "10.5"; //单位（元）
$BodyData["returnUrl"] = "http://10.0.60.66:8048/Demo/WithdrawReturn.php"; //提现异步通知
//$BodyData["feeMemberId"] = "CP610000000000188888"; // 内扣模式
Baofu\Util\Log::EchoFormat("提现订单号：" . $BodyData["transSerialNo"]);

$contentData["body"] = $BodyData;

$JsonObject = json_encode($contentData);
Baofu\Util\Log::EchoFormat("JSON：" . $JsonObject);

$Data_Content = Baofu\Security\RSA::encryptByPFXFile($JsonObject, $GLOBALS["PFX_FILE_PATH"], $GLOBALS["Key_Pwd"]);
$HeaderPost["content"] = $Data_Content;

$result = Baofu\Client::call($GateWay_Account . $HeaderPost["serviceTp"] . "/transReq.do", $HeaderPost, $GLOBALS["CER_FILE_PATH"]);

Baofu\Util\Log::EchoFormat("解密明文：", $result);
