<?php

/* 
 * 开户通知
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

try {
    require_once '../Init/init.php';
    Log::LogWirte("===================接收开户异步通知========================");
    $EndataContent =  isset($_REQUEST["data_content"])?$_REQUEST["data_content"]:die("No parameters are received [data_content]");
    $MemberID=$_REQUEST['member_id'];//商户号
    $TerminalID =$_REQUEST['terminal_id'];//商户终端号

    Log::LogWirte("异步通知原文：".$EndataContent);
    $ReturnDecode = NewRsaUtil::decrptByPub($EndataContent,$GLOBALS["CER_FILE_PATH"]);//解密返回的报文
    Log::LogWirte("异步通知解密原文：".$ReturnDecode);
    
    /**
     * 业务处理
     */
    
    echo "OK";//返回OK与业务无关，只表示收到异步通知
    
} catch (Exception $ex) {
    echo "OK";
}
