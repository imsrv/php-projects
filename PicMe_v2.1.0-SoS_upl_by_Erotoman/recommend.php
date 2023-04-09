<?php
/*
#
#	$Id: RECOMMEND.PHP
#	Version 2.0.0
#
*/ 
 
 include "header.php";

$receiveNotifications = 1;
// Tells who used it and what addresses they sent it to.
// Either 1 for Yes or 0 for No.

$messagecolor = "#ff0000";
// Color of notification messages displayed on error or successful sending of message

$subject = "Website Recommendation from $yourName ($yourEmail)";
// This will be the subject that appears on sent messages

$sendMessage = "Hello,\n**YourName** though you would like the following site:\n$siteurl ";
// This is a message that will be sent at the top of all emails
// Use \n to create a new line.  **YourName** will be replaced by the name of the sender.
// Done - No need to edit below //


if($action == "go") {
  
  if(empty($yourName)) {
  $message .= "Please enter your name.<br>";
  $error = 1;
  }
  
  if(empty($yourEmail)) {
  $message .= "Please enter your email address. NO HOTMAIL accounts!<br>";
  $error = 1;
  }
  else {
    if(!isValid($yourEmail)) {
    $message .= "Please enter a proper email address for yourself.<br>";
    $error = 1;
    }
  }
  if(empty($a1) && empty($a2) && empty($a3) && empty($a4) && empty($a5)) {
  $message .= "Please enter at least one friend's email address. NO HOTMAIL accounts!<br>";
  $error = 1;
  }
 
 // Now we will gather how many form fields are filled in and
 // create an array to fill with them if the addresses are valid.
 $emailList = array(); // create empty array
 if(!empty($a1)) {
   if(!isValid($a1)) {
     $finalM .= "Email 1 was not valid and no message was sent to it.<br>";
     }
    else {
   $amount = $amount + 1;
   array_push($emailList,$a1);
     }
   }
 if(!empty($a2)) {
   if(!isValid($a2)) {
     $finalM .= "Email 2 was not valid and no message was sent to it.<br>";
     }
    else {
   $amount = $amount + 1;
   array_push($emailList,$a2);
     }
   }

  if(!empty($a3)) {
   if(!isValid($a3)) {
     $finalM .= "Email 3 was not valid and no message was sent to it.<br>";
     }
    else {
   $amount = $amount + 1;
   array_push($emailList,$a3);
     }
   }

  if(!empty($a4)) {
   if(!isValid($a4)) {
     $finalM .= "Email 4 was not valid and no message was sent to it.<br>";
     }
    else {
   $amount = $amount + 1;
   array_push($emailList,$a4);
     }
   }
	
  if(!empty($a5)) {
   if(!isValid($a5)) {
     $finalM .= "Email 5 was not valid and no message was sent to it.<br>";
     }
    else {
   $amount = $amount + 1;
   array_push($emailList,$a5);
     }
   }
 reset($emailList); // Set the array pointer to the beginning

  // Now if there are no errors actually send the messages.
 if($error == 0) {
   $sendMessage = str_replace("**YourName**",$yourName,$sendMessage);
   foreach($emailList as $to) {
    if(!mail($to,$subject,"$sendMessage\n\n" . $customMessage . "\n\nNote: This message was not sent unsolicited.  It was sent through a form located at http://" . $_SERVER['SERVER_NAME'] . "$PHP_SELF.  If you beleive this message was received on error, please disregard it.",
    "From: $yourEmail\r\n"
   ."Reply-To: $yourEmail\r\n"
   ."X-Mailer: PicMe Tell-A-Friend\r\n"))
       {
    $finalM .= "Message was not successfully sent to ${to} for some reason.  Pleas try again later.<br>";
       } // != mail()
     else {
      $finalM .= "Message was sent to $to.<br>";
	$reciplist .= " $to,"; // To be used in notifications
     } // end != else 
   } // end foreach
  } // end error if
// Thats a lot of curly braces...

 if ($error == "1") {
    echo "<center><font color=\"$messagecolor\">$message</font></center><br>\n";
    }
 if ($finalM) {
    echo "<center><font color=\"$messagecolor\">$finalM<br>Thank you very much for referring us.</font></center><br>\n";
    if($receiveNotifications) {
	   @mail($mailadmin,"Someone Recommended Your Site","Hi\nThis is a message to tell your that $yourName ($yourEmail) sent a website recommendation to$reciplist.\nEnd Message",
	   "From: $mailadmin\r\n"
        ."X-Mailer: PicMe Tell-A-Friend");
        } // end if receive notifications.
	}

} // end main if

else {
echo<<<EOD
<br>
<center>
<form method="POST" action="$PHP_SELF">
<input type=hidden name=action value="go">
<center><b>Enter up to five friends' email addresses to send a referral to.<br><font color=red>*</font> marked are required.<br><br></b></center>
<table border=0 cellpadding=3 cellspacing=3 align=center width=300>
<tr><td align=left><font color=red>*</font><b>&nbsp;Your Name:</td>
<td align=right><input type=text name=yourName></td>
</tr>

<tr><td align=left><font color=red>*</font><b>&nbsp;Your Email:</td>
<td align=right><input type=text name=yourEmail></td>
</tr>

<tr><td align=left><font color=red>*</font><b>&nbsp;Friend 1:</td>
<td align=right><input type=text name=a1></td>
</tr>

<tr>
<td align=left><b>Friend 2:</td>
<td align=right><input type=text name=a2></td>
</tr>

<tr><td align=left><b>Friend 3:</td>
<td align=right><input type=text name=a3></td>
</tr>

<tr><td align=left><b>Friend 4:</td>
<td align=right><input type=text name=a4></td>
</tr>

<tr><td align=left><b>Friend 5:</td>
<td align=right><input type=text name=a5></td>
</tr>
</table>
  <table border=0 cellpadding=3 cellspacing=3 width=300>
  <tr><td align=center>The text below will be sent at the top
  of the message your friends will receive.
  <textarea name=sendMessage cols=34 rows=5 readonly>$sendMessage
  </textarea></td></tr>
  <tr><td align=center><textarea name=customMessage cols=34 rows=5>Enter a personal message to your friend here if you wish.
  </textarea></td></tr>
  </table>

<input type=submit value="Send Message">
<input type=reset value="Start Over">
</form>
</center>
EOD;
} // end main else

function isValid($email) { 
  if(eregi("^[a-z0-9\._-]+@+[a-z0-9\._-]+\.+[a-z]{2,3}$", $email)) return TRUE; 
  else return FALSE; 
  }

include "footer.php";
?>