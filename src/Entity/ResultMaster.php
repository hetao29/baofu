<?php

namespace Baofu\Entity;

class ResultMaster
{
    var $merId;
    var $terId;
    var $charset;
    var $version;
    var $format;
    var $returnMsg;
    var $returnCode;
    var $signType;
    var $signSn;
    var $ncrptnSn;
    var $signStr;
    var $dataContent;

    function getMerId()
    {
        return $this->merId;
    }

    function getTerId()
    {
        return $this->terId;
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

    function getReturnMsg()
    {
        return $this->returnMsg;
    }

    function getReturnCode()
    {
        return $this->returnCode;
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

    function getSignStr()
    {
        return $this->signStr;
    }

    function getDataContent()
    {
        return $this->dataContent;
    }

    function setMerId($merId)
    {
        $this->merId = $merId;
    }

    function setTerId($terId)
    {
        $this->terId = $terId;
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

    function setReturnMsg($returnMsg)
    {
        $this->returnMsg = $returnMsg;
    }

    function setReturnCode($returnCode)
    {
        $this->returnCode = $returnCode;
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

    function setSignStr($signStr)
    {
        $this->signStr = $signStr;
    }

    function setDataContent($dataContent)
    {
        $this->dataContent = $dataContent;
    }

    function test()
    {
        echo "<br>YES<br>";
    }
}
