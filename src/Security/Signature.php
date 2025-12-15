<?php

namespace Baofu\Security;

class Signature
{
	/**
	 * 签名
	 * @param string $Data  原数据
	 * @param string $PfxPath Pfx私钥路径
	 * @param string $PrivateKPASS Pfx私钥密码
	 * @return string
	 * @throws \Exception
	 */
	public static function SignByPFXFile($Data, $PfxPath, $PrivateKPASS)
	{
		$KeyObj = RSA::getPriveKey($PfxPath, $PrivateKPASS);
		$signature = '';
		if (!openssl_sign($Data, $signature, $KeyObj, OPENSSL_ALGO_SHA256)) {
			throw new \Exception('签名创建失败: ' . openssl_error_string());
		}
		return bin2hex($signature);
	}

	/**
	 * 签名
	 * @param string $Data  原数据
	 * @param string $PemPath Pem私钥路径
	 * @return string
	 * @throws \Exception
	 */
	public static function SignByPEMFile($Data, $PemPath)
	{
		$KeyObj = RSA::getPriveKey($PemPath, NULL, true);
		$signature = '';
		if (!openssl_sign($Data, $signature, $KeyObj, OPENSSL_ALGO_SHA256)) {
			throw new \Exception('签名创建失败: ' . openssl_error_string());
		}
		return bin2hex($signature);
	}

	/**
	 * 验证签名自己生成的是否正确
	 *
	 * @param string $Data 签名的原文
	 * @param string $publicKeyPath 公钥路径（用签名私钥对应的公钥）
	 * @param string $SignaTure 签名
	 * @return bool
	 */
	public static function VerifySign($Data, $publicKeyPath, $SignaTure)
	{
		$KeyObj = RSA::getPublicKey($publicKeyPath);
		$ok = openssl_verify($Data, hex2bin($SignaTure), $KeyObj, OPENSSL_ALGO_SHA256);
		return $ok == 1 ? true : false;
	}
}
