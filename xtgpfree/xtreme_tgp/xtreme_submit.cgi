#!/usr/bin/perl

######################################################################
#                       X-treme TGP v1.0
#                        Created by Relic
#                     webmaster@cyphonic.net
#####################################################################

#URL TO YOUR ADMIN DIRECTORY
##################################
$apath = "/home/darkforce/newraw";

#Your email Address
######################################################################
$recipient = "whatever@whatever.com";

#SCROLL DOWN AND EDIT THE SPECIFIED HTML
###########################################################

read(STDIN, $buffer, $ENV{'CONTENT_LENGTH'});
@pairs = split(/&/, $buffer);
foreach $pair (@pairs) {
    ($name, $value) = split(/=/, $pair);
    $value =~ tr/+/ /;
    $value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
    $FORM{$name} = $value;
}

print "Content-type:text/html\n\n";





sub done {

$ip = $ENV{'REMOTE_ADDR'};
$aproveme="aprove.txt";
open(DAT,">>$aproveme") || die("THERE WAS A FILE ERROR!");
print DAT "$FORM{'name'}|$FORM{'email'}|$FORM{'count'}|$FORM{'url'}|$ip|$FORM{'type'}\n";  

$ip2="ips.txt";
open(DAT,">>$ip2") || die("THERE WAS A FILE ERROR!");
print DAT "$ip|\n";  

$mailprog = '/usr/sbin/sendmail';
open (MAIL, "|$mailprog -t") or dienice("Can't access $mailprog!\n");
print MAIL "To: $recipient\n";
print MAIL "Subject: TGP SUBMISSION\n\n";
print MAIL "NEW TGP SUBMISSION\n";
close(MAIL);


print <<EndOfHTML;

###############################################################################################################################################################################################################################EDIT THIS HTML
##############################################################################################################################################################################################################################

<html><head><title>EliteList Movie Post</title></head>
<body bgcolor="#FEAE0A" text="#000000" link="#000000" vlink="#000000" alink="#000000">
<div align="center"></div>
<div align="center">
  <table width="63%" cellspacing="1" cellpadding="2" bgcolor="#000000">
    <tr bgcolor="#FFCC00"> 
      <td bgcolor="#FFCC00"> 
        <div align="center"><font face="Verdana, Arial, Helvetica, sans-serif"><b><font size="2">Thank 
          You!</font></b></font></div>
      </td>
    </tr>
    <tr bgcolor="#FEC650"> 
      <td height="19" bgcolor="#FEC650"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">We 
        have received your information and if you followed the rules, you will 
        be listed within 1-3 days.</font></td>
    </tr>
  </table>
  <br>
  <table width="63%" cellspacing="1" cellpadding="2" bgcolor="#000000">
    <tr bgcolor="#FFCC00"> 
      <td bgcolor="#FFCC00"> 
        <div align="center"><font face="Verdana, Arial, Helvetica, sans-serif"><b><font size="2">YOU 
          MUST ADD THE FOLLOWING TO YOUR PAGE!</font></b></font></div>
      </td>
    </tr>
    <tr bgcolor="#FEC650"> 
      <td height="19" bgcolor="#FEC650"> 
        <textarea name="textfield" cols="60" rows="3"><table width="25%" cellspacing="0" cellpadding="0" border="1" bordercolor="#000000">
  <tr> 
    <td height="49" bgcolor="#FFCC00">
      <div align="center"><font face="Verdana, Arial, Helvetica, sans-serif"><b><font size="2" color="#000000"><a href="http://www.elitelist.net" target="_blank"><font color="black">WANT 
        MORE MOVIES?<br>
        CLICK HERE NOW!</font></a></font></b></font></div>
    </td>
  </tr>
</table>
</textarea>
      </td>
    </tr>
  </table>
  <br>
  <table width="63%" cellspacing="1" cellpadding="2" bgcolor="#000000">
    <tr bgcolor="#FFCC00"> 
      <td colspan="2"> 
        <div align="center"><font face="Verdana, Arial, Helvetica, sans-serif"><b><font size="2">This 
          is the Data That We Recieved!</font></b></font></div>
      </td>
    </tr>
    <tr bgcolor="#FEC650"> 
      <td width="31%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Your 
        Name:</font></td>
      <td width="69%"><font face="Verdana, Arial, Helvetica, sans-serif" size="2"> 
        $FORM{'name'}</font></td>
    </tr>
    <tr bgcolor="#FEC650"> 
      <td width="31%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Email 
        Address: </font></td>
      <td width="69%"><font face="Verdana, Arial, Helvetica, sans-serif" size="2"> 
        $FORM{'email'}</font></td>
    </tr>
    <tr bgcolor="#FEC650"> 
      <td bgcolor="#FEC650" width="31%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">How 
        Many Movies</font></td>
      <td width="69%"><font face="Verdana, Arial, Helvetica, sans-serif" size="2"> 
        $FORM{'count'}</font></td>
    </tr>
    <tr bgcolor="#FEC650"> 
      <td bgcolor="#FEC650" width="31%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Type 
        of Movies</font></td>
      <td width="69%"><font face="Verdana, Arial, Helvetica, sans-serif" size="2"> 
        $FORM{'type'}</font></td>
    </tr>
  </table>
</div>

###############################################################################################################################################################################################################################END EDIT
##############################################################################################################################################################################################################################  


EndOfHTML
}

sub errors {

print <<errors;

<html><head><title>Problem!</title></head>
<body bgcolor="#FEAE0A" text="#000000" link="#000000" vlink="#000000" alink="#000000">
<div align="center">
<table width="80%" cellspacing="1" cellpadding="2" bgcolor="#000000">
    <tr bgcolor="#FFCC00"> 
      <td bgcolor="#FFCC00" height="12"> 
        <div align="center"><font face="Verdana, Arial, Helvetica,
sans-serif"><b><font size="2">There Were Errors!</font></b></font></div>
      </td>
    </tr>
    <tr bgcolor="#FEC650"> 
      <td height="10" bgcolor="#FEC650"><font size="2" face="Verdana,
Arial, Helvetica, sans-serif">You must fill out all the fields for your submission 
        to be accepted! Please hit your back button and try again!</font></td>
    </tr>
  </table>
  </div>


errors

}





if ($FORM{'name'} eq "")
{
&errors;
exit;
}
if ($FORM{'email'} eq "")
{
&errors;
exit;
}
if ($FORM{'count'} eq "")
{
&errors;
exit;
}
if ($FORM{'url'} eq "")
{
&errors;
exit;
}
else
{
 &done;
}




