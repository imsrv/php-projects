<html>
 <head>
  <title>Thank You</title>
 </head>
 <body>
  <center>
   <h1>Thank You For Filling Out This Form</h1>
</center>
Below is what you submitted to <? echo $recipient ?> on <? echo datetime() ?><p><hr size=1 width=75%><p>
<?
/*
This program is copywrite Eyekon, 1998, All rights
reserved. You may not sell, distribute, or give away
any copy of this program without the express consent
or Eyekon. This notice must remain in the top of every
document included in this distribution.
*/
while ( list( $key, $val ) = each($HTTP_POST_VARS) ) {
   $message .= "$key = $val\n";
   echo "$key: $val<br>";
}
while ( list( $key, $val ) = each($HTTP_GET_VARS) ) {
   $message .= "$key = $val\n";
   echo "$key => $val<br>";
}
$replyfilelocation;

$to = $recipient;

mail($to,$subject,$message,$headers);
?>      

</body>
</html>
