<?php

namespace Baofu\Security;

class SHA1U
{
    /**
     * SHA1摘要
     * @param string $Strings
     * @return string
     */
    public static function Sha1AndHex($Strings)
    {
        return openssl_digest($Strings, "SHA1");
    }
}
