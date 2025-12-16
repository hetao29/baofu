<?php

/* 
 * 开户通知
 * https://doc.mandao.com/docs/bct/openAccNotify
 */

try {
    require_once 'init.php';
    Baofu\Util\Log::LogWirte("===================接收开户异步通知========================");
    $EndataContent =  isset($_REQUEST["data_content"]) ? $_REQUEST["data_content"] : die("No parameters are received [data_content]");
    $MemberID = $_REQUEST['member_id']; //商户号
    $TerminalID = $_REQUEST['terminal_id']; //商户终端号

    Baofu\Util\Log::LogWirte("异步通知原文：" . $EndataContent);
    $ReturnDecode = Baofu\Security\RSA::decryptByCERFile($EndataContent, $GLOBALS["CER_FILE_PATH"]); //解密返回的报文
    Baofu\Util\Log::LogWirte("异步通知解密原文：" . $ReturnDecode);

    /**
     * 业务处理
     */

    echo "OK"; //返回OK与业务无关，只表示收到异步通知

} catch (Exception $ex) {
    echo "OK";
}
