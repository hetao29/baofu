<?php

/**
 * 账户绑定查询接口
 * https://doc.mandao.com/docs/bct/bct-1gahm7u2hj1s1
 */

require_once 'init.php';


$ServiceTp = "T-1001-013-22";

$HeaderPost = array();
$HeaderPost["memberId"] = $GLOBALS["Member_Id"]; //宝付提供给商户的唯一编号
$HeaderPost["terminalId"] = $GLOBALS["Terminal_Id"];
$HeaderPost["serviceTp"] = $ServiceTp; //报文编号
$HeaderPost["verifyType"] = "1"; //加密方式目前只有1种，请填：1

$DataBody = [];
$DataBody["version"] = "4.1.0";
$DataBody["contractNo"] = "CM610000000000185348";
$DataBody["requestNo"] = Baofu\Util\Tools::getTsnOderid("RN");

$contentData = array();
$contentData["header"] = $HeaderPost;
$contentData["body"] = $DataBody;

$ContentStr = json_encode($contentData);
Baofu\Util\Log::EchoFormat("JSON序列号：" . $ContentStr);
$enContent = Baofu\Security\RSA::encryptByPFXFile($ContentStr, $GLOBALS["PFX_FILE_PATH"], $GLOBALS["Key_Pwd"]);

$HeaderPost["content"] = $enContent;

$result = Baofu\Client::call($GateWay_Account . $HeaderPost["serviceTp"] . "/transReq.do", $HeaderPost, $GLOBALS["CER_FILE_PATH"]);

Baofu\Util\Log::EchoFormat("返回参数：", $result);
