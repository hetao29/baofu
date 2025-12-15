<?php

/**
 * 宝付账簿 - 个人/机构账户余额查询接口
 * https://doc.mandao.com/docs/bct/queryBalace
 */
require_once 'init.php';

Baofu\Util\Log::EchoFormat("==========================");
Baofu\Util\Log::EchoFormat("宝付账簿个人/机构账户余额查询接口");
Baofu\Util\Log::EchoFormat("==========================");


/* Header 参数*/
$HeaderPost = array();
$HeaderPost["memberId"] = $GLOBALS["Member_Id"]; //宝付提供给商户的唯一编号
$HeaderPost["terminalId"] = $GLOBALS["Terminal_Id"];
$HeaderPost["serviceTp"] = "T-1001-013-06"; //报文编号
$HeaderPost["verifyType"] = "1"; //加密方式目前只有1种，请填：1

$contentData = array();
$contentData["header"] = $HeaderPost;


$BodyData = array();
$BodyData["version"] = "4.0.0"; //版本号
$BodyData["accType"] = "1"; //账户类型:1个人,2商户

$BodyData["contractNo"] = "CP610000000000188888"; //客户账户号


$contentData["body"] = $BodyData;

$JsonObject = json_encode($contentData);
Baofu\Util\Log::EchoFormat("JSON：" . $JsonObject);

$Data_Content = Baofu\Security\RSA::encryptByPFXFile($JsonObject, $GLOBALS["PFX_FILE_PATH"], $GLOBALS["Key_Pwd"]);
$HeaderPost["content"] = $Data_Content;

$result = Baofu\Client::call($GateWay_Account . $HeaderPost["serviceTp"] . "/transReq.do", $HeaderPost, $GLOBALS["CER_FILE_PATH"]);

Baofu\Util\Log::EchoFormat("解密明文：", $result);
