<?php
$ROOT = dirname(__FILE__);

require_once($ROOT . "/vendor/autoload.php");

//====================配置商户的宝付接口授权参数==============
/**
 * 开户及交易分账商户号信息/账户间转账接口
 */
$Member_Id = "";    //商户号
$Terminal_Id = "";    //终端号
$Key_Pwd = "";	//商户私钥证书密码

/**
 * 提现及提现查询使用以下商户号
 */
$WMember_Id = "";    //商户号
$WTerminal_Id = "";    //终端号
$WKey_Pwd = "";	//商户私钥证书密码


/**
 * 证书路径，请填写证书所在的绝对路径
 * 获取方法请联系宝付技术支持
 */
$PFX_FILE_PATH = ""; //商家的私钥，pfx格式
$CER_FILE_PATH = ""; //宝付的证书（公钥）

/**
 * 测试环境 https://vgw.baofoo.com/union-gw/api/
 * 正式环境 https://public.baofu.com/union-gw/api/
 */
$GateWay_Account = "https://public.baofu.com/union-gw/api/";
