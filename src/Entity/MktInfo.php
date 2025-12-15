<?php

namespace Baofu\Entity;

class MktInfo
{
    var $mktMerId;
    var $mktAmt; //营销金额，单位：分;

    function getMktMerId()
    {
        return $this->mktMerId;
    }

    function getMktAmt()
    {
        return $this->mktAmt;
    }

    function setMktMerId($mktMerId)
    {
        $this->mktMerId = $mktMerId;
    }

    function setMktAmt($mktAmt)
    {
        $this->mktAmt = $mktAmt;
    }
}
