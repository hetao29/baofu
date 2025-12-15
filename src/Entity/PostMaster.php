<?php

namespace Baofu\Entity;

class PostMaster
{
    var $merId;
    var $terId;
    var $method;
    var $charset;
    var $version;
    var $format;
    var $timestamp;
    var $signType;
    var $signSn;
    var $ncrptnSn;
    var $dgtlEnvlp;
    var $signStr;
    var $bizContent;

    function __construct()
    {
        $this->merId;
        $this->terId;
        $this->method;
        $this->charset = "UTF-8";
        $this->version = "1.0";
        $this->format = "json";
        $this->timestamp = date('YmdHis');
        $this->signType = "RSA";
        $this->signSn = "1";
        $this->ncrptnSn = "1";
        $this->dgtlEnvlp = "";
        $this->signStr;
        $this->bizContent;
    }

    function getMerId()
    {
        return $this->merId;
    }

    function getTerId()
    {
        return $this->terId;
    }

    function getMethod()
    {
        return $this->method;
    }

    function getCharset()
    {
        return $this->charset;
    }

    function getVersion()
    {
        return $this->version;
    }

    function getFormat()
    {
        return $this->format;
    }

    function getTimestamp()
    {
        return $this->timestamp;
    }

    function getSignType()
    {
        return $this->signType;
    }

    function getSignSn()
    {
        return $this->signSn;
    }

    function getNcrptnSn()
    {
        return $this->ncrptnSn;
    }

    function getDgtlEnvlp()
    {
        return $this->dgtlEnvlp;
    }

    function getSignStr()
    {
        return $this->signStr;
    }

    function getBizContent()
    {
        return $this->bizContent;
    }

    function setMerId($merId)
    {
        $this->merId = $merId;
    }

    function setTerId($terId)
    {
        $this->terId = $terId;
    }

    function setMethod($method)
    {
        $this->method = $method;
    }

    function setCharset($charset)
    {
        $this->charset = $charset;
    }

    function setVersion($version)
    {
        $this->version = $version;
    }

    function setFormat($format)
    {
        $this->format = $format;
    }

    function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;
    }

    function setSignType($signType)
    {
        $this->signType = $signType;
    }

    function setSignSn($signSn)
    {
        $this->signSn = $signSn;
    }

    function setNcrptnSn($ncrptnSn)
    {
        $this->ncrptnSn = $ncrptnSn;
    }

    function setDgtlEnvlp($dgtlEnvlp)
    {
        $this->dgtlEnvlp = $dgtlEnvlp;
    }

    function setSignStr($signStr)
    {
        $this->signStr = $signStr;
    }

    function setBizContent($bizContent)
    {
        $this->bizContent = $bizContent;
    }
}
