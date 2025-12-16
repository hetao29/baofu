<?php

/**
 * 订单查询接口
 */

require_once 'init.php';

Baofu\Util\Log::EchoFormat("==========================");
Baofu\Util\Log::EchoFormat("查询接口 测试实例");
Baofu\Util\Log::EchoFormat("==========================");

$merId = $GLOBALS["Member_Id"];
$terId = $GLOBALS["Terminal_Id"];
$Method = "order_query";

$tradeNo = ""; //宝付订单号
$outTradeNo = "OTN1653571557865"; //商户系统内部订单号，同一个商户号下唯

$Biz_Content = array();
/*
$Biz_Content["agentMerId"] = "";
$Biz_Content["agentTerId"] = "";
*/
$Biz_Content["merId"] = $merId;
$Biz_Content["terId"] = $terId;
//$Biz_Content["tradeNo"] = $tradeNo;
$Biz_Content["outTradeNo"]  = $outTradeNo;

$PostParm = new Baofu\Entity\PostMaster();

$BizContent = json_encode($Biz_Content);
$PostParm->setBizContent($BizContent);
$PostParm->setMerId($merId);
$PostParm->setTerId($terId);
$PostParm->setMethod($Method);

$SignStr = Baofu\Security\Signature::SignByPFXFile($BizContent, $GLOBALS["PFX_FILE_PATH"], $GLOBALS["Key_Pwd"]);
$PostParm->setSignStr($SignStr);

Baofu\Util\Log::EchoFormat("请求参数:", $PostParm);

$result = Baofu\Client::call("https://mch-juhe.baofoo.com/api", $PostParm);

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
