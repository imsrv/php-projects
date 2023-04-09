<?
/////////////////////////////////////////////////////////
//	
//	include/encryption.inc
//
//	(C)Copyright 2000-2002 Ryo Chijiiwa <Ryo@IlohaMail.org>
//
//	This file is part of IlohaMail. IlohaMail is free software released 
//	under the GPL license.  See enclosed file COPYING for details, or 
//	see http://www.fsf.org/copyleft/gpl.html
//
/////////////////////////////////////////////////////////

/********************************************************

	PURPOSE:
		Provide basic encryption related functionality.
	COMMENTS:
		This library commits the worst crime in cryptography: 
		Never write your own crypto algos.

********************************************************/

function GenerateMessage($messLen){
	srand ((double) microtime() * 1000000);
	$seed="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
	$seedLen=strlen($seed);
	if ($messLen==0) $messLen = rand(10, 20);
	for ($i=0;$i<$messLen;$i++){
		$point=rand(0, $seedLen-1);
		$message.=$seed[$point];
	}
	return $message;
}

function EncryptMessage($key,$message){
	$messLen=strlen($message);
	$keylen=strlen($key);
	$enc_message="";
	
	for ($i=0;$i<$messLen;$i++){
		$j=$i % $keylen;
		$code=chr((ord($message[$i]) + ord($key[$j])) % 128);
		$enc_message.=$code;
	}

	return base64_encode($enc_message);
}

function DecodeMessage($pass, $message){
	$message=base64_decode($message);
	$messLen=strlen($message);
	$passLen=strlen($pass);
	
	$decMessage="";
	for ($i=0;$i<$messLen;$i++){
		$j=$i % $passLen;
		$num=ord($message[$i]);
		$decNum=(($num + 128) - ord($pass[$j])) % 128;
		$decMessage.=chr($decNum);
	}
	
	return $decMessage;
}

?>