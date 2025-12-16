<?php

namespace Baofu\Util;

class Tools
{

    /**
     * 生成订单号
     * @param string $header=""
     * @return string
     */
    public static function getTransid($header = "")
    {
        $transid = $header . self::getStamp() . self::getRand4();
        return $transid;
    }

    /**
     * 时间戳
     * @return string
     */
    public static function getStamp()
    {
        return strtotime(date('Y-m-d H:i:s', time()));
    }

    /**
     * 订单号流水号生成
     * @param $header=""
     * @return string
     */
    public static function getTsnOderid($header = "")
    {
        return self::getTransid($header) . self::getRand4();
    }

    /**
     * 生成四位随机数
     * @return int
     */
    public static function getRand4()
    {
        return rand(1000, 9999);
    }
    /**
     * 获取当前时间
     * @return string
     */
    public static function getTime($datef = "Y-m-d H:i:s")
    {
        $date = new \DateTime('now', new \DateTimeZone('Asia/Shanghai'));
        return $date->format($datef);
    }

    /**
     * 排序输出k=v&k1=v1.....格式
     * @param array $DArray
     * @return string
     */
    public static function SortAndOutString($DArray)
    {
        $TempData = array();
        foreach ($DArray as $Key => $Value) {
            if (!self::isBlank($Value)) {
                $TempData[$Key] = $Value;
            }
        }
        ksort($TempData); //排序
        return http_build_query($TempData);
    }

    /**
     * 判断是否空值
     * @param string $Strings
     * @return boolean
     */
    public static function isBlank($Strings)
    {
        $Strings = trim($Strings);
        if ((empty($Strings) || ($Strings == null)) && (strlen($Strings) <= 0)) {
            return true;
        } else {
            return FALSE;
        }
    }

    /**
     * 删除数组元素
     * @param array $data
     * @param string $key
     * @return array
     */
    public static function array_remove($data, $key)
    {
        if (!array_key_exists($key, $data)) {
            return $data;
        }
        $keys = array_keys($data);
        $index = array_search($key, $keys);
        if ($index !== FALSE) {
            array_splice($data, $index, 1);
        }
        return $data;
    }
    /**
     * 获取信封中的key值
     * @param string $Strings
     * @return string
     * @throws Exception
     */
    public static function getAesKey($Strings)
    {
        $KeyArray = explode("|", $Strings);
        if (count($KeyArray) == 2) {
            $KeyArray[1] = trim($KeyArray[1]);
            if (!empty($KeyArray[1])) {
                return $KeyArray[1];
            } else {
                throw new \Exception("Key is Null!");
            }
        } else {
            throw new \Exception("Data format is incorrect!");
        }
    }
}
