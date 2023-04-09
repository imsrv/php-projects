<?php
include './config.php';

If ($to_email && $message && $subject) {$to = "\"$to_name\" <$to_email>";
$from = "\"$from_name\" <$from_email>";
$to = str_replace("\\'", "'", $to);
$from = str_replace("\\'", "'", $from);$subject = str_replace("\\'", "'", $subject);
$message = str_replace("\\'", "'", $message);
mail($to, $subject, $message, "From: $from\nX-Mailer: AvidNewMedia News");
echo "Mail message sent : \nTo : $to\nFrom : $from\nSubject : $subject\nMessage : $message";
exit; } ?>

<HTML>
 <HEAD>
<STYLE>
body{margin: 0px, 0px, 0px, 0px;}
</STYLE>
    <TITLE><? echo "$CONF[sitename]" ?> Email This Article</TITLE>
  <META NAME="GENERATOR" CONTENT="MicroVision Development / WebExpress">
 </HEAD>
 <BODY BGCOLOR="WHITE" LINK="#00007F" VLINK="#00007F" ALINK="#00007F">
  <P>
   <TABLE WIDTH="100%" CELLPADDING="2" CELLSPACING="1" BORDER="0">
    <TR>
     <TD COLSPAN="2" WIDTH="62%" BGCOLOR="#E3E3E3" VALIGN=TOP>
      <P>
       <FONT FACE="Arial,Helvetica,Monaco"><B><I><? echo "$CONF[sitename]" ?></I> 
      </B></FONT><B><FONT FACE="Arial,Helvetica,Monaco"><I>Email this article</I></FONT></B><FONT FACE="Arial,Helvetica,Monaco"><FONT SIZE="2">&#153;</FONT></FONT></TD>
    </TR>
    <TR>
     <TD WIDTH="62%" VALIGN=TOP>
      <FORM ACTION="<?php echo $PHP_SELF; ?>">
       <P>
        <B><FONT FACE="Verdana,Arial,Times New I2"><FONT SIZE="1">Your 
        Friend's Name:</FONT></FONT></B><BR>
        <INPUT TYPE=TEXT NAME="to_name" SIZE="20" MAXLENGTH="256"></P>
       <P>
        <FONT FACE="Verdana,Arial,Times New I2"><FONT SIZE="1"><B>Your 
        Friend's Email:</B></FONT></FONT><BR>
        <INPUT TYPE=TEXT NAME="to_email" SIZE="20" MAXLENGTH="256"></P>
       <P>
        <FONT FACE="Verdana,Arial,Times New I2"><FONT SIZE="1"><B>Your Name:</B></FONT></FONT><BR>
        <INPUT TYPE=TEXT NAME="from_name" SIZE="20" MAXLENGTH="256"></P>
       <P>
        <FONT FACE="Verdana,Arial,Times New I2"><FONT SIZE="1"><B>Your Email </B></FONT></FONT><B><FONT FACE="Verdana,Arial,Times New I2"><FONT SIZE="1">A</FONT></FONT></B><FONT FACE="Verdana,Arial,Times New I2"><FONT SIZE="1"><B>ddress:</B></FONT></FONT><BR>
        <INPUT TYPE=TEXT NAME="from_email" SIZE="20" MAXLENGTH="256"></P>
       <P>
        <FONT FACE="Verdana,Arial,Times New I2"><FONT SIZE="1"><B>Subject:</B></FONT></FONT><BR>
        <INPUT TYPE=TEXT NAME="subject" SIZE="20" MAXLENGTH="256"></P>
       <P>
        <FONT FACE="Verdana,Arial,Times New I2"><FONT SIZE="1"><B>Message:</B></FONT></FONT><BR>
        <TEXTAREA NAME="message" COLS="60" ROWS="10">Hi! I found this page and thought you'd be interested. Link: <? if (empty($HTTP_REFERER)) { $referrer = 'No referrer reported'; } else { $referrer = $HTTP_REFERER; } echo $referrer; ?></TEXTAREA></P>
       <CENTER>
       <P ALIGN=CENTER>
        <INPUT TYPE=SUBMIT VALUE="Email this article">
       </FORM></TD>
     <TD WIDTH="38%" BGCOLOR="#E3E3E3" VALIGN=TOP>
      <P>
       <FONT FACE="Arial,Helvetica,Monaco"><B>Inst</B></FONT><B><FONT FACE="Arial,Helvetica,Monaco">ructions:</FONT></B></P>
      <UL>
       <LI>
       <P>
        <FONT FACE="Arial,Helvetica,Monaco"><FONT SIZE="1">Fill out the form 
        on the left.</FONT></FONT><BR>
        <LI><FONT FACE="Arial,Helvetica,Monaco"><FONT SIZE="1">make sure to 
        inlclude all information</FONT></FONT><BR>
        <LI><FONT FACE="Arial,Helvetica,Monaco"><FONT SIZE="1">Push the 
        &quot;Email this article&quot; button.</FONT></FONT></TD>
    </TR>
    <TR>
     <TD WIDTH="62%" VALIGN=TOP></TD>
     <TD WIDTH="38%" VALIGN=TOP></TD>
    </TR>
   </TABLE>
 </BODY>
</HTML>