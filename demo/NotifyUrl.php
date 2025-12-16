<?php

/**
 * 支付回调
 */
require_once 'init.php';
Baofu\Util\Log::LogWirte("接收参数：" . http_build_query($_REQUEST));
$ReturnData = $_REQUEST;

$Rsingstr = $ReturnData["signStr"] ?? "";
$RDataContent = $ReturnData["dataContent"] ?? "";


if (Baofu\Security\Signature::VerifySign($RDataContent, $GLOBALS["CER_FILE_PATH"], $Rsingstr)) {
    Baofu\Util\Log::LogWirte("YES");
} else {
    Baofu\Util\Log::LogWirte("NO");
}
