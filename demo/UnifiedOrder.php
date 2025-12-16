<?php

/**
 * 统一下单交易创建
 * https://doc.mandao.com/docs/bct/bct-1f9qlvjef634j
 */
require_once 'init.php';


Baofu\Util\Log::EchoFormat("==========================");
Baofu\Util\Log::EchoFormat("统一下单交易创建 测试实例");
Baofu\Util\Log::EchoFormat("==========================");

$txnAmt = 1000; //用户实际付款金额
$totalAmt = 1000; //订单总金额
$merId = $GLOBALS["Member_Id"];
$terId = $GLOBALS["Terminal_Id"];
$Method = "unified_order";
$txnTime = Baofu\Util\Tools::getTime(); //报文发送日期时间	
$payCode = "WECHAT_JSAPI"; //"WECHAT_JSAPI";
$subMchId = ""; //测试不用传

///微信支付参数。
$sub_appid = "";
$sub_openid = "";
$body = "123456";

///支付宝参数
$buyer_id = "";

$Notify_Url = "http://10.0.60.66:8042/DEMO/NotifyUrl.php";
//$Notify_Url = "http://10.0.60.66:8080/AgreementReturnUrl/NotifyUrlS.action";
$Biz_Content = array();

$Biz_Content["agentMerId"] = "";
$Biz_Content["agentTerId"] = "";
$Biz_Content["merId"] = $merId;
$Biz_Content["terId"] = $terId;
$Biz_Content["outTradeNo"] = Baofu\Util\Tools::getTransid();
$Biz_Content["txnAmt"] = $txnAmt;
$Biz_Content["txnTime"] = Baofu\Util\Tools::getTime("YmdHis");
$Biz_Content["totalAmt"] = $totalAmt;
$Biz_Content["timeExpire"] = "120"; //订单支付的有效时间，单位：分钟
$Biz_Content["prodType"] = "ORDINARY"; //SHARING:分账产品,ORDINARY:普通产品
$Biz_Content["payCode"] = $payCode;

$Pay_Extend = array();

if (substr($payCode, 0, strlen("WECHAT")) == "WECHAT") {
    ///微信支付属性-公共属性
    $Pay_Extend["body"] = "特价手机";

    ////terminal_info 终端信息参数     支付方式为：WECHAT_MICROPAY该字段必填
    $Deviceid = ""; ///终端设备号
    $Terminal_Info = new Baofu\Entity\TerminalInfo($payCode, $Deviceid);
    if ($payCode == "WECHAT_JSAPI") {
        $Pay_Extend["sub_appid"] = $sub_appid;
        $Pay_Extend["sub_openid"] = $sub_openid;
    } else if ($payCode == "WECHAT_MICROPAY") {
        $Pay_Extend["terminal_info"] = $Terminal_Info;
    }
} else if (substr($payCode, 0, strlen("ALIPAY")) == "ALIPAY") {
    $Pay_Extend["subject"] = "商品名称";
    $Pay_Extend["area_info"] = "";

    ////terminal_info 终端信息参数     支付方式为：WECHAT_MICROPAY该字段必填
    $Deviceid = ""; ///终端设备号
    $Terminal_Info = new Baofu\Entity\TerminalInfo($payCode, $Deviceid);

    if ($payCode == "ALIPAY_JSAPI") {
        $Pay_Extend["buyer_id"] = $buyer_id;
    } else if ($payCode == "ALIPAY_MICROPAY") {
        $Pay_Extend["terminal_info"] = $Terminal_Info;
    }
}

$Biz_Content["payExtend"] = $Pay_Extend;
$Biz_Content["subMchId"]  = $subMchId;
$Biz_Content["notifyUrl"] = $Notify_Url;
$Biz_Content["forbidCredit"] = "0";//1：禁止,0：不禁止;不传默认为0


/**
 * 
 * 
 *   ///分账信息
 *   $Details = new SharingDetailsEntity();
 *   $Details->setSharingAmt("100");
 *   $Details->setSharingMerId("120838");
 *
 *   $Sie = new SharingInfoEntity();
 *   $Sie->setSharingDetails($Details);
 *   $Sie->setSharingNotifyUrl("");
 *
 *   $Biz_Content["sharingInfo"] = $Sie;
 */

/***
 * ////营销信息
 * $Mie = new MktInfoEntity();
 *  $Mie->setMktMerId($merId);
 *   $Mie->setMktAmt("100");
 *  $Biz_Content["mktInfo"] = $Mie;
 * 
 */


$Rie = new Baofu\Entity\RiskInfo();
$Rie->setLocationPoint(""); //空值
$Rie->setClientIp("181.219.133.152");

$Biz_Content["riskInfo"] = $Rie;

$PostParm = new Baofu\Entity\PostMaster();

$BizContent = json_encode($Biz_Content);
$PostParm->setBizContent($BizContent);
$PostParm->setMerId($merId);
$PostParm->setTerId($terId);
$PostParm->setMethod($Method);

$SignStr = Baofu\Security\Signature::SignByPFXFile($BizContent, $GLOBALS["PFX_FILE_PATH"], $GLOBALS["Key_Pwd"]);
$PostParm->setSignStr($SignStr);

Baofu\Util\Log::EchoFormat("请求参数:", $PostParm);

$result  =  Baofu\Client::call("https://mch-juhe.baofoo.com/api", $PostParm);

Baofu\Util\Log::EchoFormat("返回报文:", $result);


if (!isset($result->returnCode)) {
    throw new Exception("缺少returnCode参数！");
}
if (!isset($result->dataContent)) {
    throw new Exception("缺少dataContent参数！");
}

if ($result->returnCode === "SUCCESS") {
    if (empty($result->dataContent)) {
        throw new Exception("返回值dataContent为空！");
    }
    if (!isset($result->signStr) && empty($result->signStr)) {
        throw new Exception("signStr参数不存在或为空！");
    }

    if (Baofu\Security\Signature::VerifySign($result->dataContent, $GLOBALS["CER_FILE_PATH"], $result->signStr)) {
        Baofu\Util\Log::EchoFormat("验签：YES");
    } else {
        Baofu\Util\Log::EchoFormat("验签：NO");
    }
}
