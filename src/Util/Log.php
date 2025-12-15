<?php

namespace Baofu\Util;

class Log
{
	public static function LogWirte($args)
	{
		$path = !empty($_SERVER['DOCUMENT_ROOT'])  ? $_SERVER['DOCUMENT_ROOT'] : "/tmp";
		$path = $path . "/log/";
		$file = $path .  date('Ymd', time()) . ".txt";
		if (!is_dir($path)) {
			mkdir($path);
		}
		$str =  self::getStr($args) . "\r\n";
		if (!file_exists($file)) {
			$logfile = fopen($file, "w") or die("Unable to open file!");
			fwrite($logfile, $str);
			fclose($logfile);
		} else {
			$logfile = fopen($file, "a") or die("Unable to open file!");
			fwrite($logfile, $str);
			fclose($logfile);
		}
	}

	public static function EchoFormat(...$args)
	{
		echo  self::getStr($args) . (PHP_SAPI === 'cli' ? "\n" : "<br>");
	}

	private static function getStr(...$args)
	{
		$data = date('Y-m-d H:i:s', time());
		foreach ($args as $info) {
			if (is_object($info) || is_array($info)) {
				$data .= " " . var_export($info, true);
			} elseif (is_bool($info)) {
				$data .= " " . ($info ? "true" : "false");
			} else {
				$data .= " " . $info;
			}
		}

		echo  $data . (PHP_SAPI === 'cli' ? "\n" : "<br>");
	}
}
