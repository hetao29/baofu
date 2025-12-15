<?php

namespace Baofu\Entity;

class SharingDetails
{

    var $sharingMerId;
    var $sharingAmt; //分账金额，单位：分;

    function getSharingMerId()
    {
        return $this->sharingMerId;
    }

    function getSharingAmt()
    {
        return $this->sharingAmt;
    }

    function setSharingMerId($sharingMerId)
    {
        $this->sharingMerId = $sharingMerId;
    }

    function setSharingAmt($sharingAmt)
    {
        $this->sharingAmt = $sharingAmt;
    }
}
