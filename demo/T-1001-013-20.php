<?php

/**
 * 账户升级接口
 * https://doc.mandao.com/docs/bct/bct-1gahm5f1j79sk
 */

require_once 'init.php';

$ServiceTp = "T-1001-013-20";

$HeaderPost = array();
$HeaderPost["memberId"] = $GLOBALS["Member_Id"]; //宝付提供给商户的唯一编号
$HeaderPost["terminalId"] = $GLOBALS["Terminal_Id"];
$HeaderPost["serviceTp"] = $ServiceTp; //报文编号
$HeaderPost["verifyType"] = "1"; //加密方式目前只有1种，请填：1

$DataBody = [];
$DataBody["version"] = "4.1.0";
$DataBody["contractNo"] = "CM610000000000185348";
$DataBody["requestNo"] = Baofu\Util\Tools::getTsnOderid("RN");
$DataBody["qualificationTransSerialNo"] = "TSN17464188619653";
$DataBody["province"] = "浙江省";
$DataBody["city"] = "宁波市";
$DataBody["district"] = "镇海区";
$DataBody["detailedAddress"] = "人民大道155号";
$DataBody["businessAddress"] = "浙江省宁波市镇海区人民大道155号 凌云威尼斯8栋3070室";
$DataBody["registeredAddress"] = "浙江省宁波市奉化区玉兰路72号 第5期碧波世纪华庭17栋2242室";
$DataBody["legalPersonIdValidityPeriod"] = "20440506";
$DataBody["businessScope"] = "电子产品制造、服装加工";
$DataBody["establishmentDate"] = "20201023";
$DataBody["registeredCapital"] = "600";
$DataBody["businessExecutionValidityPeriod"] = "20360506";
$DataBody["contactMobile"] = "13014417705";


$contentData = array();
$contentData["header"] = $HeaderPost;
$contentData["body"] = $DataBody;

$ContentStr = json_encode($contentData);
Baofu\Util\Log::EchoFormat("JSON序列号：" . $ContentStr);
$enContent = Baofu\Security\RSA::encryptByPFXFile($ContentStr, $GLOBALS["PFX_FILE_PATH"], $GLOBALS["Key_Pwd"]);

$HeaderPost["content"] = $enContent;

$result = Baofu\Client::call($GateWay_Account . $HeaderPost["serviceTp"] . "/transReq.do", $HeaderPost, $GLOBALS["CER_FILE_PATH"]);

Baofu\Util\Log::EchoFormat("返回参数：", $result);
