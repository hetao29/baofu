<?php

namespace Baofu\Security;

class AES
{
    /**
     * 
     * @param string $data    待加密的数据
     * @param string $key     密钥
     * @param string $iv      密钥
     * @return string
     * @throws Exception
     */
    public static function AesEncrypt($data, $key)
    {
        if (!function_exists('bin2hex')) {
            function hex2bin($str)
            {
                $sbin = "";
                $len = strlen($str);
                for ($i = 0; $i < $len; $i += 2) {
                    $sbin .= pack("H*", substr($str, $i, 2));
                }
                return $sbin;
            }
        }
        if (!(strlen($key) == 16)) {
            throw new \Exception("AES密码长度固定为16位！当前KEY长度为：" .  strlen($key));
        }
        $iv = $key; //偏移量与key相同
        $encrypted = openssl_encrypt($data, "AES-128-CBC", $key, OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING, $iv);
        $data = bin2hex($encrypted);
        return $data;
    }
    /**
     * 解密
     * @param string $sData   待解密的数据
     * @param string $sKey    密钥
     * @param string $iv      密钥
     * @return string
     * @throws Exception
     */
    public static function AesDecrypt($sData, $sKey)
    {
        if (!function_exists('hex2bin')) {
            function hex2bin($str)
            {
                $sbin = "";
                $len = strlen($str);
                for ($i = 0; $i < $len; $i += 2) {
                    $sbin .= pack("H*", substr($str, $i, 2));
                }
                return $sbin;
            }
        }
        if (!(strlen($sKey) == 16)) {
            throw new \Exception("AES密码长度固定为16位！当前KEY长度为：" .  strlen($sKey));
        }
        $sIv = $sKey; //偏移量与key相同
        $sData = hex2bin($sData);
        $retrun = openssl_decrypt($sData, "AES-128-CBC", $sKey, OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING, $sIv);
        return $retrun;
    }
}
