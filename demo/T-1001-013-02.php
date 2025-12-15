<?php

/**
 * 宝付账簿 - 个人/机构账户信息修改接口
 * https://doc.mandao.com/docs/bct/updateCard
 */
require_once 'init.php';

Baofu\Util\Log::EchoFormat("==========================");
Baofu\Util\Log::EchoFormat("宝付账簿个人/机构开户接口");
Baofu\Util\Log::EchoFormat("==========================");


/* Header 参数*/
$HeaderPost = array();
$HeaderPost["memberId"] = $GLOBALS["Member_Id"]; //宝付提供给商户的唯一编号
$HeaderPost["terminalId"] = $GLOBALS["Terminal_Id"];
$HeaderPost["serviceTp"] = "T-1001-013-02"; //报文编号
$HeaderPost["verifyType"] = "1"; //加密方式目前只有1种，请填：1

$contentData = array();
$contentData["header"] = $HeaderPost;

$BodyData = array();
$BodyData["version"] = "4.0.0"; //版本号
$BodyData["accType"] = "1"; //账户类型:1个人,2商户

$accInfo = array();
if ($BodyData["accType"] == "1") {
    $accInfo["transSerialNo"] = Baofu\Util\Tools::getTsnOderid("TSN"); //请求流水号
    $accInfo["contractNo"] = "CP610000000000188888"; //客户账户号
    $accInfo["cardNo"] = "6217006757530269670"; //卡号
    $accInfo["mobileNo"] = "14810060961"; //银行预留手机号

} else if ($BodyData["accType"] == "2") {

    $accInfo["transSerialNo"] = Baofu\Util\Tools::getTsnOderid("TSN"); //请求流水号
    $accInfo["contractNo"] = "170046192475";
    $accInfo["email"] = ""; //邮箱
    $accInfo["cardNo"] = ""; //卡号
    $accInfo["bankName"] = ""; //银行名称
    $accInfo["depositBankProvince"] = ""; //开户行省份
    $accInfo["depositBankCity"] = ""; //开户行城市
    $accInfo["depositBankName"] = ""; //开户支行名称

    $accInfo["contactName"] = ""; //联系人姓名
    $accInfo["contactMobile"] = ""; //联系人手机号
    $accInfo["corporateMobile"] = ""; //法人手机号

}

$BodyData["accInfo"] = $accInfo; //开户详细信息
$contentData["body"] = $BodyData;

$JsonObject = json_encode($contentData);
Baofu\Util\Log::EchoFormat("JSON：" . $JsonObject);

$Data_Content = Baofu\Security\RSA::encryptByPFXFile($JsonObject, $GLOBALS["PFX_FILE_PATH"], $GLOBALS["Key_Pwd"]);
$HeaderPost["content"] = $Data_Content;

$result = Baofu\Client::call($GateWay_Account . $HeaderPost["serviceTp"] . "/transReq.do", $HeaderPost, $GLOBALS["CER_FILE_PATH"]);

Baofu\Util\Log::EchoFormat("返回：", $result);
