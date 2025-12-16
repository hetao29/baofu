<?php

namespace Baofu;

class Client
{
    /**
     * @param string $url
     * @param array $params
     * @param string $cert=NULL 解密的公钥证书路径
     * @return mixed
     */

    public static function call($url, $params, $cert = NULL)
    {
        $client = new \GuzzleHttp\Client();
        $res = $client->request('POST', $url, [
            'form_params' => $params,
        ]);
        $PostString = (string)$res->getBody();

        if (empty($PostString)) {
            throw new \Exception("返回异常！");
        }
        if ($cert && is_file($cert)) {
            $PostString = Security\RSA::decryptByCERFile($PostString, $cert);
        }

        return json_decode($PostString);
    }
}
