<?php

namespace Baofu\Security;

/**
 * RSA 算法
 * 注意：私钥加密的数据，需要公钥解密；反之，公钥加密的数据，需要私钥解密
 */
class RSA
{

	private static $cache = [];
	/**
	 * 私钥加密（用PFX格式的私钥）
	 * 注意：
	 *		PHP8以后，如果识别不了pfx文件，可能尝试升级成新的pfx(.p12)密钥文（目前提供的SDK里的pfx文件就是旧版本）
	 *		# 第一步，先把pfx文件，转换成pem文件格式
	 *		openssl pkcs12 -legacy -passin pass:123456 -in in.pfx -out out.pem -nodes
	 *		# 第二步，把pem文件格式升级成新的pfx格式
	 *		openssl pkcs12 -passout pass:123456 -export -in out.pem -out in_new.pfx -certpbe AES-256-CBC -keypbe AES-256-CBC -iter 2048
	 * @param string $Data
	 * @param string $PfxPath
	 * @param string $PrivateKPASS
	 * @return string
	 * @throws \Exception
	 */
	public static function encryptByPFXFile($Data, $PfxPath, $PrivateKPASS)
	{
		$KeyObj = self::getPriveKey($PfxPath, $PrivateKPASS);
		return self::encryptByObj($Data, $KeyObj, true);
	}
	/**
	 * 私钥加密，用PEM格式的私钥加密
	 * @param string $Data
	 * @param string $PemPath
	 * @return string
	 * @throws \Exception
	 */
	public static function encryptByPEMFile($Data, $PemPath)
	{
		$KeyObj = self::getPriveKey($PemPath, NULL, true);
		return self::encryptByObj($Data, $KeyObj, true);
	}
	/**
	 * 公钥加密
	 * @param string $Data    加密数据
	 * @param string $PublicPath 公钥路径
	 * @return string
	 * @throws \Exception
	 */
	public static function encryptByCERFile($Data, $PublicPath)
	{
		$KeyObj = self::getPublicKey($PublicPath);
		return self::encryptByObj($Data, $KeyObj, false);
	}
	/**
	 * 私钥解密，用PFX密钥于解密公钥加密的数据 encryptByCERFile()
	 * @param string $Data    解密数据
	 * @param string $PfxPath 私钥路径
	 * @param string $PrivateKPASS 私钥密码
	 * @return type
	 * @throws \Exception
	 */
	public static function decryptByPFXFile($Data, $PfxPath, $PrivateKPASS)
	{
		$KeyObj = self::getPriveKey($PfxPath, $PrivateKPASS);
		return self::decrypt($Data, $KeyObj);
	}
	/**
	 * 私钥解密，用PEM密钥于解密公钥加密的数据 encryptByCERFile()
	 * @param string $Data    解密数据
	 * @param string $PemPath 私钥路径
	 * @param string $PrivateKPASS 私钥密码
	 * @return type
	 * @throws \Exception
	 */
	public static function decryptByPEMFile($Data, $PemPath)
	{
		$KeyObj = self::getPriveKey($PemPath, NULL, true);
		return self::decrypt($Data, $KeyObj);
	}

	/**
	 * 公钥解密，用于解密私钥加密的数据
	 * @param string $Data
	 * @param string $PublicPath
	 * @return string
	 * @throws \Exception
	 */
	public static function decryptByCERFile($Data, $PublicPath)
	{
		$KeyObj = self::getPublicKey($PublicPath);
		return self::decrypt($Data, $KeyObj, false);
	}

	/**
	 * 加密（公钥&私钥）的方法
	 * @param string $Data
	 * @param object $KeyObj
	 * @param boolean $isPrivate=true
	 * @return string
	 */
	private static function encryptByObj($Data, $KeyObj, $isPrivate = true)
	{
		$BASE64EN_DATA = base64_encode($Data);
		$EncryptStr = "";
		$blockSize = self::getKeySize($KeyObj);
		if ($blockSize <= 0) {
			throw new \Exception("BlockSize is 0");
		} else {
			$blockSize = $blockSize / 8 - 11; //分段
		}
		$totalLen = strlen($BASE64EN_DATA);
		$EncryptSubStarLen = 0;
		$EncryptTempData = "";
		while ($EncryptSubStarLen < $totalLen) {
			if ($isPrivate) {
				openssl_private_encrypt(substr($BASE64EN_DATA, $EncryptSubStarLen, $blockSize), $EncryptTempData, $KeyObj);
			} else {
				openssl_public_encrypt(substr($BASE64EN_DATA, $EncryptSubStarLen, $blockSize), $EncryptTempData, $KeyObj);
			}
			$EncryptStr .= bin2hex($EncryptTempData);
			$EncryptSubStarLen += $blockSize;
		}
		return $EncryptStr;
	}
	/**
	 * 解密（公钥&私钥）的方法
	 * @param string $Data
	 * @param object $KeyObj
	 * @param boolean $isPrivate=true
	 * @return string
	 */
	private static function decrypt($Data, $KeyObj, $isPrivate = true)
	{
		if (!ctype_xdigit($Data)) {
			throw new \InvalidArgumentException("不是16进制数据，无法解密，[$Data]");
		}
		$DecryptRsult = "";
		$blockSize = self::getKeySize($KeyObj, false);
		if ($blockSize <= 0) {
			throw new \Exception("BlockSize is 0");
		} else {
			$blockSize = $blockSize / 4;
		}
		$totalLen = strlen($Data);
		$EncryptSubStarLen = 0;
		$DecryptTempData = "";
		while ($EncryptSubStarLen < $totalLen) {
			if ($isPrivate) {
				openssl_private_decrypt(hex2bin(substr($Data, $EncryptSubStarLen, $blockSize)), $DecryptTempData, $KeyObj);
			} else {
				openssl_public_decrypt(hex2bin(substr($Data, $EncryptSubStarLen, $blockSize)), $DecryptTempData, $KeyObj);
			}
			$DecryptRsult .= $DecryptTempData;
			$EncryptSubStarLen += $blockSize;
		}
		return base64_decode($DecryptRsult);
	}

	/**
	 * 获取证书长度
	 * @param object $KeyObj
	 * @return int
	 */
	private static function getKeySize($KeyObj)
	{
		$details = openssl_pkey_get_details($KeyObj);
		return $details['bits'] ?? 0;
	}
	/**
	 * 读取私钥
	 * @param string $privateKeyPath
	 * @param string $PrivateKPASS
	 * @return string
	 * @throws \Exception
	 */
	public static function getPriveKey($privateKeyPath, $PrivateKPASS, $isPem = false)
	{
		if (!file_exists($privateKeyPath)) {
			throw new \Exception("私钥文件不存在！路径：" . $privateKeyPath);
		}
		$pemFile = $privateKeyPath;
		if (!$isPem) {
			$pemFile = $privateKeyPath . ".pem.cached";
			if (!file_exists($pemFile) || filemtime($pemFile) < filemtime($privateKeyPath)) {
				$PrivateKey = array();
				$PKCS12 = file_get_contents($privateKeyPath);
				if (openssl_pkcs12_read($PKCS12, $PrivateKey, $PrivateKPASS)) {
					file_put_contents($pemFile, $PrivateKey["pkey"], LOCK_EX);
				} else {
					throw new \Exception("私钥证书读取出错！原因[证书或密码不匹配]，请检查本地证书相关信息。");
				}
			}
		}
		return openssl_pkey_get_private(file_get_contents($pemFile));
	}

	/**
	 * 读取公钥
	 * @param string $PublicPath
	 * @return string
	 * @throws \Exception
	 */
	public static function  getPublicKey($PublicPath)
	{
		if (!file_exists($PublicPath)) {
			throw new \Exception("公钥文件不存在！路径：" . $PublicPath);
		}
		$KeyFile = file_get_contents($PublicPath);
		$PublicKey = openssl_get_publickey($KeyFile);
		if (empty($PublicKey)) {
			throw new \Exception("公钥不可用！路径：" . $PublicPath);
		}
		return $PublicKey;
	}
}
