<?
/////////////////////////////////////////////////////////
//	
//	include/smtp.inc
//
//	(C)Copyright 2002 Ryo Chijiiwa <Ryo@IlohaMail.org>
//
//		This file is part of IlohaMail.
//		IlohaMail is free software released under the GPL 
//		license.  See enclosed file COPYING for details,
//		or see http://www.fsf.org/copyleft/gpl.html
//
/////////////////////////////////////////////////////////

/********************************************************

	AUTHOR: Ryo Chijiiwa <ryo@ilohamail.org>
	FILE:  include/smtp.php
	PURPOSE:
		Provide SMTP functionality using pure PHP.
	PRE-CONDITIONS:
		The functions here require a SMTP server configured to allow relaying.
	POST-CONDITIONS:
		The following global variables are returned:
		$smtp_errornum - error number, 0 if successful
		$smtp_error - error message(s)
	COMMENTS:
		The optional $smtp_message_file can be used for sending extremely large
		messages.  Storing large messages in a variable will consume whatever
		amount of memory required, which may be more than is available if dealing
		with messages with large attachments.  By storing them in a file, it becomes
		possible to read/send bits at a time, drastically reducing memory useage.
		
		This library only provides bare-bones SMTP functionality.  It is up to the
		parent code to form valid RFC822 (MIME) messages.
		
		Authenticated SMTP is currently not supported.
	
********************************************************/

	function smtp_check_reply($reply){
		global $smtp_error;
		
		$a = explode(" ", chop($reply));
		//echo "Reply-line: $reply<br>\n";
		if (count($a)>1){
			//echo "Reply-line[0]: ".$a[1]."<br>\n";
			if ($a[0]==250) return true;
			else{
				$smtp_error .= $reply."\n";
			}
		}else{
			$smtp_error .= "Invalid SMTP response line: $reply\n";
		}
		
		return false;
	}
	
	
	function smtp_connect($host, $port){
		if (empty($host)) $host = "localhost";
		if (empty($port)) $port = 25;
	
		return fsockopen($host, $port);
	}
	
	
	function smtp_close($conn){
		fclose($conn);
	}


	function smtp_mail($conn, $from, $recipients, $message, $is_file){
		global $smtp_errornum;
		global $smtp_error;
		
		//check recipients and sender addresses
		if ((count($recipients)==0) || (!is_array($recipients))){
			$smtp_errornum = -1;
			$smtp_error .= "Recipients list is empty\n";
		}
		if (empty($from)){
			$smtp_errornum = -1;
			$smtp_error .= "From address unspecified\n";
		}
		
		if ($conn){
			//read greeting
			$greeting = fgets($conn, 1024);
			
			//send MAIL FROM command
			$command = "MAIL FROM: $from\r\n";
			fputs($conn, $command);
			//echo $command."<br>\n";
			if (smtp_check_reply(fgets($conn, 1024))){
				//send RCPT TO commands, count valid recipients
				$num_recipients = 0;	
				while ( list($k, $recipient) = each($recipients) ){
					$command = "RCPT TO: $recipient\r\n";
					fputs($conn, $command);

					$reply = smtp_check_reply(fgets($conn, 1024));
					if ($reply) $num_recipients++;
					else $smtp_error .= $reply."\n";
				}
				
				//error out if no valid recipiets
				if ($num_recipients == 0){
					$smtp_errornum = -2;
					$smtp_error .= "No valid recipients\n";
					return false;
				}
				
				//send DATA command
				fputs($conn, "DATA\r\n");
				$reply = chop(fgets($conn, 1024));
				$a = explode(" ", $reply);
				
				//error out if DATA command ill received
				if ($a[0]!=354){
					$smtp_errornum = -3;
					$smtp_error .= $reply;
					return false;	
				}

				//send data
				if ($is_file){
					//if message file, open file
					$fp = false;
					if (file_exists($message)) $fp = fopen($message, "r");
					if (!$fp)
					{ 
						$smtp_errornum = -4;
						$smtp_error .= "Invlid message file\n";
						return false;
					}
					
					//send file
					while(!feof($fp)){
						$buffer = chop(fgets($fp, 4096), "\r\n");
						fputs($conn, $buffer."\r\n");
					}
					fclose($fp);
					fputs($conn, "\r\n.\r\n");
					
					return smtp_check_reply(fgets($conn, 1024));
				}else{
					//else, send message
					$message = str_replace("\r\n", "\n", $message);
					$message = str_replace("\n", "\r\n", $message);
					fputs($conn, $message);
					fputs($conn, "\r\n.\r\n");
					
					return smtp_check_reply(fgets($conn, 1024));
				}
			}
		}else{
			$smtp_errornum = -2;
			$smtp_error .= "Could not connect to $smtp_host:$smtp_port\n";
		}
		
		return false;
	}

	
	function smtp_ExplodeQuotedString($delimiter, $string){
		$quotes=explode("\"", $string);
		while ( list($key, $val) = each($quotes))
			if (($key % 2) == 1) 
				$quotes[$key] = str_replace($delimiter, "_!@!_", $quotes[$key]);
		$string=implode("\"", $quotes);
	
		$result=explode($delimiter, $string);
		while ( list($key, $val) = each($result) )
			$result[$key] = str_replace("_!@!_", $delimiter, $result[$key]);
	
		return $result;
	}	
	
	
	function smtp_expand($str){
		$addresses = array();
		$recipients = smtp_ExplodeQuotedString(",", $str);
		reset($recipients);
		while ( list($k, $recipient) = each($recipients) ){
			$a = explode(" ", $recipient);
			while ( list($k2, $word) = each($a) ){
				if ((strpos($word, "@") > 0) && (strpos($word, ".") > 0) && (strpos($word, "\"")===false)){
					array_push($addresses, $word);
				}
			}
		}
		return $addresses;
	}
?>
