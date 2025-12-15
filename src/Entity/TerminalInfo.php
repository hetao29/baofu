<?php

namespace Baofu\Entity;

class TerminalInfo
{
    var $location;
    var $network_license;
    var $device_type;
    var $serial_num;
    var $terminal_id; ////终端设备的硬件序列号---支付宝，
    var $device_id; ///-终端设备号----微信，
    var $encrypt_rand_num;
    var $secret_text;
    var $app_version;
    var $device_ip;
    var $mobile_country_cd;
    var $mobile_net_num;
    var $icc_id;
    var $location_cd1;
    var $lbs_num1;
    var $lbs_signal1;
    var $location_cd2;
    var $lbs_num2;
    var $lbs_signal2;
    var $location_cd3;
    var $lbs_num3;
    var $lbs_signal3;
    var $telecom_sys_id;
    var $telecom_net_id;
    var $telecom_lbs;
    var $telecom_lbs_signal;

    function __construct($payCode, $Deviceid)
    {
        if (substr($payCode, 0, strlen("WECHAT")) == "WECHAT") {
            $this->device_id = $Deviceid; ///-终端设备号
        } else if (substr($payCode, 0, strlen("ALIPAY")) == "ALIPAY") {
            $this->terminal_id = $Deviceid;
        }
    }

    function getLocation()
    {
        return $this->location;
    }

    function getNetwork_license()
    {
        return $this->network_license;
    }

    function getDevice_type()
    {
        return $this->device_type;
    }

    function getSerial_num()
    {
        return $this->serial_num;
    }

    function getTerminal_id()
    {
        return $this->terminal_id;
    }

    function getDevice_id()
    {
        return $this->device_id;
    }

    function getEncrypt_rand_num()
    {
        return $this->encrypt_rand_num;
    }

    function getSecret_text()
    {
        return $this->secret_text;
    }

    function getApp_version()
    {
        return $this->app_version;
    }

    function getDevice_ip()
    {
        return $this->device_ip;
    }

    function getMobile_country_cd()
    {
        return $this->mobile_country_cd;
    }

    function getMobile_net_num()
    {
        return $this->mobile_net_num;
    }

    function getIcc_id()
    {
        return $this->icc_id;
    }

    function getLocation_cd1()
    {
        return $this->location_cd1;
    }

    function getLbs_num1()
    {
        return $this->lbs_num1;
    }

    function getLbs_signal1()
    {
        return $this->lbs_signal1;
    }

    function getLocation_cd2()
    {
        return $this->location_cd2;
    }

    function getLbs_num2()
    {
        return $this->lbs_num2;
    }

    function getLbs_signal2()
    {
        return $this->lbs_signal2;
    }

    function getLocation_cd3()
    {
        return $this->location_cd3;
    }

    function getLbs_num3()
    {
        return $this->lbs_num3;
    }

    function getLbs_signal3()
    {
        return $this->lbs_signal3;
    }

    function getTelecom_sys_id()
    {
        return $this->telecom_sys_id;
    }

    function getTelecom_net_id()
    {
        return $this->telecom_net_id;
    }

    function getTelecom_lbs()
    {
        return $this->telecom_lbs;
    }

    function getTelecom_lbs_signal()
    {
        return $this->telecom_lbs_signal;
    }

    function setLocation($location)
    {
        $this->location = $location;
    }

    function setNetwork_license($network_license)
    {
        $this->network_license = $network_license;
    }

    function setDevice_type($device_type)
    {
        $this->device_type = $device_type;
    }

    function setSerial_num($serial_num)
    {
        $this->serial_num = $serial_num;
    }

    function setTerminal_id($terminal_id)
    {
        $this->terminal_id = $terminal_id;
    }

    function setDevice_id($device_id)
    {
        $this->device_id = $device_id;
    }

    function setEncrypt_rand_num($encrypt_rand_num)
    {
        $this->encrypt_rand_num = $encrypt_rand_num;
    }

    function setSecret_text($secret_text)
    {
        $this->secret_text = $secret_text;
    }

    function setApp_version($app_version)
    {
        $this->app_version = $app_version;
    }

    function setDevice_ip($device_ip)
    {
        $this->device_ip = $device_ip;
    }

    function setMobile_country_cd($mobile_country_cd)
    {
        $this->mobile_country_cd = $mobile_country_cd;
    }

    function setMobile_net_num($mobile_net_num)
    {
        $this->mobile_net_num = $mobile_net_num;
    }

    function setIcc_id($icc_id)
    {
        $this->icc_id = $icc_id;
    }

    function setLocation_cd1($location_cd1)
    {
        $this->location_cd1 = $location_cd1;
    }

    function setLbs_num1($lbs_num1)
    {
        $this->lbs_num1 = $lbs_num1;
    }

    function setLbs_signal1($lbs_signal1)
    {
        $this->lbs_signal1 = $lbs_signal1;
    }

    function setLocation_cd2($location_cd2)
    {
        $this->location_cd2 = $location_cd2;
    }

    function setLbs_num2($lbs_num2)
    {
        $this->lbs_num2 = $lbs_num2;
    }

    function setLbs_signal2($lbs_signal2)
    {
        $this->lbs_signal2 = $lbs_signal2;
    }

    function setLocation_cd3($location_cd3)
    {
        $this->location_cd3 = $location_cd3;
    }

    function setLbs_num3($lbs_num3)
    {
        $this->lbs_num3 = $lbs_num3;
    }

    function setLbs_signal3($lbs_signal3)
    {
        $this->lbs_signal3 = $lbs_signal3;
    }

    function setTelecom_sys_id($telecom_sys_id)
    {
        $this->telecom_sys_id = $telecom_sys_id;
    }

    function setTelecom_net_id($telecom_net_id)
    {
        $this->telecom_net_id = $telecom_net_id;
    }

    function setTelecom_lbs($telecom_lbs)
    {
        $this->telecom_lbs = $telecom_lbs;
    }

    function setTelecom_lbs_signal($telecom_lbs_signal)
    {
        $this->telecom_lbs_signal = $telecom_lbs_signal;
    }
}
