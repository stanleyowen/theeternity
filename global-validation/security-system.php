<?php
	$key = ""; //Your Secret Keys goes here
	$salt = ""; //Your Salt Keys goes here

	function encrypt($string,$key) {
		$encrypted = openssl_encrypt($string, "AES-256-CBC", $key, OPENSSL_RAW_DATA, ''); //Put your salt keywords here
		return $encrypted;
	}
	function decrypt($string,$key) {
		$decrypted = openssl_decrypt($string, "AES-256-CBC", $key, OPENSSL_RAW_DATA, ''); //Put your salt keywords here
		return $decrypted;
	}
	function hashword($string, $salt) {
		$string = crypt($string, '' . $salt . '');//Put your salt keywords here
		return $string;
	}
	function enter($str){
		return str_replace('\n', "<br>", $str);
	}
?>