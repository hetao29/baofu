<?php

namespace Baofu\Entity;

class RiskInfo
{
    var $clientIp; //付款用户ip地址
    var $locationPoint; //包含经度和纬度，英文逗号分隔;

    function getClientIp()
    {
        return $this->clientIp;
    }

    function getLocationPoint()
    {
        return $this->locationPoint;
    }

    function setClientIp($clientIp)
    {
        $this->clientIp = $clientIp;
    }

    function setLocationPoint($locationPoint)
    {
        $this->locationPoint = $locationPoint;
    }
}
