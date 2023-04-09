<?php 
###############################################################################
# 452 Productions Internet Group (http://452productions.com)
# 452 Multi-MAIL  v1.6 BETA
#    This script is freeware and is realeased under the GPL
#    Copyright (C) 2000, 2001  452 Productions
#
#    This program is free software; you can redistribute it and/or modify
#    it under the terms of the GNU General Public License as published by
#    the Free Software Foundation; either version 2 of the License, or
#    (at your option) any later version.
#
#    This program is distributed in the hope that it will be useful,
#    but WITHOUT ANY WARRANTY; without even the implied warranty of
#    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#    GNU General Public License for more details.
#
#    You should have received a copy of the GNU General Public License
#    along with this program; if not, write to the Free Software
#    Foundation, Inc., 675 Mass Ave, Cambridge, MA 02139, USA.
#    Or just download it http://fsf.org/
################################################################################
# Upload and run this script to see why your messages arn't arriving.
###############################################################################
# A non local email address.
$email = "you@someotherdomain.com";
$email2 = "you@someotherdomain2.com";
require("config.inc.php"); 
require("functions.php");
# Close the socket, ie send the message, only called once
# If the script pukes out before this point the email is _NOT_ sent
function close_socket_print($socket) {
	fputs($socket, "QUIT\r\n"); 
	while(!feof($socket)){
		echo fgets($socket, "1024") . "<br>";
		flush();
	}
	fclose($socket);
}
$from = $mail_admin; 
$nice_mail = $mail_admin_alias . " <" . $from . ">"; 
$header = "From: " . $nice_mail ."\nX-Sender: " . $mail_admin ."\nReply-To: " . $mail_admin . "\nX-Mailer: 452-PHP 452productions.com";
$socket = fsockopen($smtp_server, 25, $errno, $errstr); 
$body = "did it work";

if($socket) { 
open_socket($socket, $from); 
write_current_mail($socket, $email); 
write_current_mail($socket, $email2); 
close_socket_print($socket, $header, $subject, $body);
echo"Sent...unless it says other wise above<br>"; 
}else { 
echo"Terminal failure! Unable to connect to the SMTP server via socket! ($errno) $errstr<br>"; 
} 
$socket = fsockopen($pop_server, "110", $errno, $errstr);
if($socket){
	echo"Able to connect to pop server<br>";
} else {
	echo"Unable to connect to pop server<br>";
}
fclose($socket);
?> 
