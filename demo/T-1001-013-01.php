<?php

/* 
 * 宝付账簿 - 个人/机构开户接口
 * https://doc.mandao.com/docs/bct/openAcc
 */
require_once 'init.php';


Baofu\Util\Log::EchoFormat("==========================");
Baofu\Util\Log::EchoFormat("3.宝付账簿个人/机构开户接口");
Baofu\Util\Log::EchoFormat("==========================");

/* Header 参数*/
$HeaderPost = array();
$HeaderPost["memberId"] = $GLOBALS["Member_Id"]; //宝付提供给商户的唯一编号
$HeaderPost["terminalId"] = $GLOBALS["Terminal_Id"];
$HeaderPost["serviceTp"] = "T-1001-013-01"; //报文编号
$HeaderPost["verifyType"] = "1"; //加密方式目前只有1种，请填：1

$contentData = array();
$contentData["header"] = $HeaderPost;

$BodyData = array();
$BodyData["version"] = "4.1.0"; //版本号
$BodyData["accType"] = "1"; //账户类型:1个人,2商户
$BodyData["noticeUrl"] = "http://10.0.60.66:8048/Demo/OpenReturn.php"; //异步通知地址
$BodyData["businessType"] = "BCT2.0"; //宝财通2.0

$accInfo = array();
$accInfo["loginNo"] = Baofu\Util\Tools::getTransid("LN"); //登录号(用户ID)建议长度8位以上 唯一
Baofu\Util\Log::EchoFormat("登录号：" . $accInfo["loginNo"]);

if ($BodyData["accType"] == "1") {
    $accInfo["transSerialNo"] = Baofu\Util\Tools::getTsnOderid("TSN"); //请求流水号
    $accInfo["customerName"] = "范鑫岩"; //客户名称
    $accInfo["certificateType"] = "ID"; //证件类型 1身份证:” ID”
    $accInfo["certificateNo"] = "340621198312275396"; //身份证号码
    $accInfo["cardNo"] = "6222802446263815045"; //卡号
    $accInfo["mobileNo"] = "19182433399"; //银行预留手机号
    $accInfo["cardUserName"] = ""; //持卡人姓名
    $accInfo["needUploadFile"] = "false"; //false不上传开户证件照
} else if ($BodyData["accType"] == "2") {
    $accInfo["transSerialNo"] = Baofu\Util\Tools::getTsnOderid("TSN"); //请求流水号
    $accInfo["email"] = ""; //邮箱
    $accInfo["selfEmployed"] = ""; //是否个体户 默认为false
    $accInfo["customerName"] = ""; //商户名称（营业执照上的名称）
    $accInfo["aliasName"] = ""; //商户名称别名  (选传)
    $accInfo["certificateNo"] = ""; //证件号码
    $accInfo["certificateType"] = "LICENSE"; //证件类型 营业执照:LICENSE
    $accInfo["corporateName"] = ""; //法人姓名
    $accInfo["corporateCertType"] = ""; //法人证件类型  身份证:ID
    $accInfo["corporateCertId"] = ""; //法人身份证号码
    $accInfo["corporateMobile"] = ""; //法人手机号
    $accInfo["industryId"] = "";
    $accInfo["contactName"] = ""; //联系人姓名
    $accInfo["contactMobile"] = ""; //联系人手机号
    $accInfo["cardNo"] = ""; //卡号
    $accInfo["bankName"] = ""; //银行名称
    $accInfo["depositBankProvince"] = ""; //开户行省份
    $accInfo["depositBankCity"] = ""; //开户行城市
    $accInfo["depositBankName"] = ""; //开户支行名称
    $accInfo["registerCapital"] = ""; //注册资本
    $accInfo["cardUserName"] = ""; //持卡人姓名  (个体绑法人对私必传)
}

$accInfo["platformNo"] = ""; //平台号(主商户号) (代理模式必传)
$accInfo["platformTerminalId"] = ""; //终端号(代理模式必传)
$accInfo["qualificationTransSerialNo"] = ""; //资质文件流水,businessType为宝财通2.0非必填

$BodyData["accInfo"] = $accInfo; //开户详细信息
$contentData["body"] = $BodyData;

$JsonObject = json_encode($contentData);
Baofu\Util\Log::EchoFormat("JSON：", $JsonObject);

$Data_Content = Baofu\Security\RSA::encryptByPFXFile($JsonObject, $GLOBALS["PFX_FILE_PATH"], $GLOBALS["Key_Pwd"]);
$HeaderPost["content"] = $Data_Content;

$result = Baofu\Client::call($GateWay_Account . $HeaderPost["serviceTp"] . "/transReq.do", $HeaderPost, $GLOBALS["CER_FILE_PATH"]);

Baofu\Util\Log::EchoFormat("解密明文：", $result);
