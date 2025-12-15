<?php

namespace Baofu\Entity;

class SharingInfo
{
    var $sharingNotifyUrl;
    var $sharingDetails = array();

    function getSharingNotifyUrl()
    {
        return $this->sharingNotifyUrl;
    }

    function getSharingDetails()
    {
        return $this->sharingDetails;
    }

    function setSharingNotifyUrl($sharingNotifyUrl)
    {
        $this->sharingNotifyUrl = $sharingNotifyUrl;
    }

    function setSharingDetails($sharingDetails)
    {
        array_push($this->sharingDetails, $sharingDetails);
    }
}
