<?php

namespace Baofu;

class Client
{
    /**
     * @param string $url
     * @param array $params
     * @param string $certFilePath=NULL 解密的公钥证书路径，如果没有或文件不存在则不解密
     * @return mixed
     */

    public static function call($url, $params, $certFilePath = NULL)
    {
        $client = new \GuzzleHttp\Client();
        $res = $client->request('POST', $url, [
            'form_params' => $params,
        ]);
        $PostString = (string)$res->getBody();

        if (empty($PostString)) {
            throw new \Exception("返回异常！");
        }
        if ($certFilePath && is_file($certFilePath)) {
            $PostString = Security\RSA::decryptByCERFile($PostString, $certFilePath);
        }

        return json_decode($PostString);
    }
}
