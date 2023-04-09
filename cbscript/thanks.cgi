#!/usr/bin/perl
# Location of Perl on your server. Please read README.TXT before editing this Script.

# Location of SendMail Program
$mailprog="/usr/sbin/sendmail";

# Auth Code. A 10 charecter code confirm whether the buyer is paid.
$AuthCode = "Zb44Ri9jW4";

# Enter your Email Address. The '\' is Required before the '@' sign.
$EmailAddress = "you\@YourDomain.com";

# Enter your Name
$YourName = "Ben Johnson";

# Enter Name of your Company/Firm/Website
$Company = "ABC Publishing";

# Product Name
$Product = "Internet Marketing Ebook";

# Price of the Product. The '\' is Required before the '$' sign.
$Price = "\$49.95";

# Download Page URL.  Starts with http://
$DownloadURL = "http://www.YourSite.com/dosnload/download.html";

# Whether to Activate Autoresponder. Default value = 0
# Change it to 1 (one) if you want to add the buyer into your autoresponder.
$AutoResponder = 0;

# Your Autoresponder Email Address.  Keep default value if you don't have one.
# The '\' is Required before the '@' sign.
$AutoAddress = "you\@YourServiceProvider.com";

# Whether to send you a Sales Report for each sale. Default value = 1
# Change it to 0 (zero) if you do not want sales report.
$SalesReport = 1;

# URL of this Script. Starts with http://
$ScriptURL = "http://www.ecommercedealers.com/cgi-bin/test/register.cgi";



# Please Do not make any changes below this line if you are not femiliar with Perl.
#---------------------------------------------------------#

read(STDIN, $buffer, $ENV{'CONTENT_LENGTH'});
if (length($buffer) < 5) {
$buffer = $ENV{QUERY_STRING};
}

@pairs = split(/&/, $buffer);
foreach $pair (@pairs)
 {
($name, $value) = split(/=/, $pair);
$value =~ tr/+/ /;
$value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
$value =~ s/[\;\|\\ ]/ /ig;
push(@values,$value); push(@names,$name);
$FORM{$name} = $value;
}

my $remote_addr = $ENV{'REMOTE_ADDR'};

if ($ENV{'REQUEST_METHOD'} eq 'POST')
{

$cbreceipt=$FORM{'cbreceipt'};
$salesreport=$SalesReport;
$autoresponder=$AutoResponder;
$autoaddress=$AutoAddress;
$downloadurl=$DownloadURL;
$product=$Product;
$emailaddress=$EmailAddress;
$yourname=$YourName;
$company=$Company;
$price=$Price;
$name=$FORM{'name'};
$email=$FORM{'email'};


###### Email to the buyer
open (MAIL, "| $mailprog -t -oi") || die "Can't open $mailprog";
print MAIL "To: $email\n";
print MAIL "Reply-to: $emailaddress\n";
print MAIL "From: $emailaddress\n";
print MAIL "Subject: Order Confirmation - $cbreceipt";
print MAIL "\n\n";
print MAIL "Hi $name,\n\n";
print MAIL "Thank you for visiting us and for placing an order.\n";
print MAIL "Please note that Your Credit Card will be charged\n";
print MAIL "under the name \"ClickBank/Keynetics\".\n\n";
print MAIL "Order Details:-\n\n";
print MAIL "ClickBank Receipt: $cbreceipt\n";
print MAIL "Item   : $product\n";
print MAIL "Price  : $price\n\n";
print MAIL "Buyer  : $name\n";
print MAIL "Email  : $email\n";
print MAIL "IP Address Recorded: $remote_addr\n\n";
print MAIL "We assure you that your information will remain private\n";
print MAIL "and will not be shared or sold to other parties.\n";
print MAIL "\n";
print MAIL "You can contact us for further details at: $emailaddress\n\n";
print MAIL "Best Regards,\n\n";
print MAIL "$yourname,\n";
print MAIL "$emailaddress.\n";
print MAIL "$company\n\n";
print MAIL "--------------------------------------------------------\n";
print MAIL "Copyright (c) $company. All Rights Reserved\n";
print MAIL "--------------------------------------------------------\n";
print MAIL "\n";
close (MAIL);


###### Email to the Seller
if ($salesreport==1) {
open (MAIL, "| $mailprog -t -oi") || die "Can't open $mailprog";
print MAIL "To: $emailaddress\n";
print MAIL "Reply-to: $emailaddress\n";
print MAIL "From: $emailaddress\n";
print MAIL "Subject: ** Sales Report **\n";
print MAIL "\n";
print MAIL "Hello $yourname,\n\n";
print MAIL "Congratulations! A sale is reported on your website.\n";
print MAIL "\n";
print MAIL "ClickBank Receipt: $cbreceipt\n";
print MAIL "Buyer  : $name\n";
print MAIL "Email  : $email\n";
print MAIL "IP Address : $remote_addr\n";
print MAIL "Item   : $product\n";
print MAIL "Price  : $price\n";
print MAIL "\n";
print MAIL "--------------------------------------------------------------\n";
print MAIL "Note: If you want to stop sending this System Generated Report,\n";
print MAIL "make necessary changes in the Perl Script as specified there.\n";
print MAIL "\n";
print MAIL "[Auto Report sent from $Company WebSite]\n";
print MAIL "\n";
close (MAIL);
}

##### Activate Autoresponder
if ($autoresponder==1) {
open (MAIL, "| $mailprog -t -oi") || die "Can't open $mailprog";
print MAIL "To: $autoaddress\n";
print MAIL "Reply-to: $email\n";
print MAIL "From: \"$name\" <$email>\n";
print MAIL "Subject: Subscribe\n";
print MAIL "Subscribe\n";
print MAIL "\n";
close (MAIL);

}
#Redirect to the Download Page.

print "Content-type: text/html\n\n";
print <<EOF;

<HTML>
<HEAD>
<title>Thank You</title>
<META http-equiv=Content-Type content="text/html; charset=windows-1252">
</HEAD>
<FRAMESET border=0 frameSpacing=0 rows=100%,* frameBorder=0 marginbottom=0 marginright=0 margintop=0 marginleft=0>

<FRAME border=0 src="$DownloadURL" frameBorder=no noResize>

<FRAME border=0 marginWidth=0 marginHeight=0 frameBorder=no noResize scrolling=no topmargin=0>
</FRAMESET>
</HTML>

EOF
exit;


}
else
{

$cbreceipt=$FORM{'cbreceipt'};
$auth = $FORM{'auth'};

if ($auth eq $AuthCode)
{
print "Content-type: text/html\n\n";
print <<EOF;

<HTML>
<HEAD>
<TITLE>Thank You</TITLE>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<META NAME="robots" CONTENT="noindex,nofollow">
<script language="JavaScript">

function click()
{if (event.button==2) {alert('Copyright (c) $Company. All rights reserved.');}
}
document.onmousedown=click


function ValidateForm(form)
{
if (form.name.value.length < 6)
{
alert("Please Enter your Full Name !");
form.name.focus();
return (false);
};

if (form.email.value.length < 12)
{
  alert("Please enter a valid Email Address");
  form.email.focus();
  return (false);
};

if (form.email.value.indexOf ('\@',0) == -1 ||  form.email.value.indexOf ('.',0) == -1)
{
  alert("Please enter a valid Email Address");
  form.email.focus();
  return (false);
};

if (form.email.value != form.reemail.value)
{
  alert("You Entered Different Email Address");
  form.reemail.focus();
  return (false);
};

return (true);
};

</script>
</HEAD>
<BODY BGCOLOR="#FFFFFF">
<div align="center">
<table bgcolor="#FFFFFF" border="0" width="626" style="border: 6 solid #0000FF" cellspacing="0" cellpadding="0">
<tr><td align="center" style="border: 2 solid #000000; padding-left: 0" width="610" bgcolor="#FFFFFF">
<p style="word-spacing: 0; margin-top: 0; margin-bottom: 0"><center><u><b><font face="Verdana,Arial,Helvetica" size="4" color="#000000">
Thank You</font></b></u></center>
<p style="word-spacing: 0; margin-top: 0; margin-bottom: 0">&nbsp;
<table border="1" width="566" cellspacing="0" style="border: 1 solid #000000">
  <tr>
    <td width="538" colspan="4" valign="top" align="center" bgcolor="#CAE4FF">
      <p align="center"><b><font face="Verdana,Arial,Helvetica" size="2" color="#0000FF">[
      ORDER DETAILS ]</font></b></td>
  </tr>
  <tr>
    <td width="147" valign="top" align="right" bgcolor="#CAE4FF"><font face="Verdana,Arial,Helvetica" size="2"><b>ClickBank
      Receipt #</b></font></td>
    <td width="241" valign="top" align="left" bgcolor="#CAE4FF"><font face="Verdana,Arial,Helvetica" size="2"><b>$cbreceipt</b></font></td>
    <td width="50" valign="top" align="right" bgcolor="#CAE4FF"><font face="Verdana,Arial,Helvetica" size="2"><b>Date:</b></font></td>
    <td width="100" valign="top" align="left" bgcolor="#CAE4FF"><font face="Verdana,Arial,Helvetica" size="2">

<SCRIPT language=JavaScript>
<!--
var lmod = new Date();
var monthname;
var lmonth = lmod.getMonth();
if (lmonth == 0) monthname = "January";
if (lmonth == 1) monthname = "February";
if (lmonth == 2) monthname = "March";
if (lmonth == 3) monthname = "April";
if (lmonth == 4) monthname = "May";
if (lmonth == 5) monthname = "June";
if (lmonth == 6) monthname = "July";
if (lmonth == 7) monthname = "August";
if (lmonth == 8) monthname = "September";
if (lmonth == 9) monthname = "October";
if (lmonth == 10) monthname = "November";
if (lmonth == 11) monthname = "December";
var outstr = monthname + " " + lmod.getDate() + ", " + lmod.getYear();
document.write(outstr);
// -->
</SCRIPT>

  </font></td>
  </tr>
  <tr>
    <td width="147" valign="top" align="right" bgcolor="#CAE4FF"><font face="Verdana,Arial,Helvetica" size="2"><b>Product:</b></font></td>
    <td width="241" valign="top" align="left" bgcolor="#CAE4FF"><font face="Verdana,Arial,Helvetica" size="2">$Product</font></td>
    <td width="50" valign="top" align="right" bgcolor="#CAE4FF"><font face="Verdana,Arial,Helvetica" size="2"><b>Price:</b></font></td>
    <td width="100" valign="top" align="left" bgcolor="#CAE4FF"><font face="Verdana,Arial,Helvetica" size="2">$Price</font></td>
  </tr>
  <tr>
    <td width="538" colspan="4" valign="top" align="center" bgcolor="#CAE4FF">
      <p align="center"><center><b><font face="Verdana,Arial,Helvetica" size="2">Your Credit Card will be charged under the name "ClickBank/Keynetics"</font></b></center>
    </td>
  </tr>
</table>
<p style="word-spacing: 0; margin-top: 0; margin-bottom: 0"><center><br>
</center>
<b><u><font face="Verdana,Arial,Helvetica" size="3" color="#CC0000">Please enter the
following information to complete the sale</font></u></b>
<form action="$ScriptURL" method="post" name="Form" onsubmit="return ValidateForm(this)">
<input name="cbreceipt" type="hidden" value="$cbreceipt">

<div align="center">
<center><table border="1" width="381" cellspacing="0" bgcolor="#FFFFDB">
<tr><td width="183" valign="top" align="right" style="padding-right: 3" bgcolor="#CAE4FF"><b>
<font face="Verdana,Arial,Helvetica" size="2">
Your Name:</font></b></td><td width="182" valign="top" align="left" style="padding-left: 3" bgcolor="#CAE4FF">
<input id="name" name="name" size="20"></td></tr>
<tr><td width="183" valign="top" align="right" style="padding-right: 3" bgcolor="#CAE4FF"><b>
<font face="Verdana,Arial,Helvetica" size="2">
Email:</font></b></td><td width="182" valign="top" align="left" style="padding-left: 3" bgcolor="#CAE4FF">
<input id="email" name="email" size="20"></td></tr>
<tr><td width="183" valign="top" align="right" style="padding-right: 3" bgcolor="#CAE4FF"><b>
<font face="Verdana,Arial,Helvetica" size="2">
Retype Email:</font></b></td><td width="182" valign="top" align="left" style="padding-left: 3" bgcolor="#CAE4FF">
<input id="reemail" name="reemail" size="20"></td></tr>
<tr><td width="365" valign="top" align="center" colspan="2" style="padding-right: 0" bgcolor="#CAE4FF">
<p align="center"><b><input name="button" type="submit" value="Continue" style="font-family: Verdana, Arial, Helvetica; font-size: 10pt; font-weight: bold"></b></td></tr>
</table></center></div></form>
<hr size="1">
<p style="word-spacing: 0; margin-top: 0; margin-bottom: 0" align="center">
<b><font face="Verdana,Arial,Helvetica" size="2" color="#000000">The data being collected here will not be forwarded to any third
party</font><font size=2 color=black face="Arial,Helvetica">.</font>
</b>
<p style="word-spacing: 0; margin-top: 0; margin-bottom: 0" align="center">
<b><font face="Verdana,Arial,Helvetica" color="#000000" size="1">Contact Email:</font><font face="Verdana,Arial,Helvetica" size="2" color="#000000">
</font>
</b>
<font size="3"><b>
<a href="mailto:$EmailAddress">$EmailAddress</a></b>
</font>
<hr size="1">
<p style="word-spacing: 0; margin-top: 0; margin-bottom: 0" align="center"><b><font face="Verdana,Arial,Helvetica" size="1" color="#808080">Copyright © $Company. All Rights Reserved</font></b>
</td></tr></table></BODY></HTML>

EOF
exit;
}
else
{
print "Content-type: text/html\n\n";
print <<EOF;

<HTML>
<HEAD>
<TITLE>Error</TITLE>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
</HEAD>
<BODY BGCOLOR="#FFFFFF">
<br>
<div align="center">
<table bgcolor="#FFFFFF" border="0" width="511" style="border: 6 solid #0000FF" cellspacing="0" cellpadding="0">
<tr><td align="center" style="border: 2 solid #000000; padding-left: 0" width="495" bgcolor="#FFFFFF">
<p style="word-spacing: 0; margin-top: 0; margin-bottom: 0"><center><b><font face="Verdana,Arial,Helvetica" size="4" color="#FF0000">&nbsp;</font></b></center>
<p style="word-spacing: 0; margin-top: 0; margin-bottom: 0"><center><u><b><font face="Verdana,Arial,Helvetica" size="4" color="#FF0000">ERROR
!</font></b></u></center><p style="word-spacing: 0; margin-top: 0; margin-bottom: 0">&nbsp;<p style="word-spacing: 0; margin-top: 0; margin-bottom: 0"><u><b><font face="Verdana,Arial,Helvetica" color="#000000" size="3">You
are not authorized to access this page</font></b></u><p style="word-spacing: 0; margin-top: 0; margin-bottom: 0">&nbsp;<p style="word-spacing: 0; margin-top: 0; margin-bottom: 0"><font face="Verdana,Arial,Helvetica" size="2"><b>We have recorded your IP Address
<font color="#FF0000"><span style="background-color: #FFFF00">$remote_addr</span></font></b></font><p style="word-spacing: 0; margin-top: 0; margin-bottom: 0">&nbsp;<p style="word-spacing: 0; margin-top: 0; margin-bottom: 0"><font face="Verdana,Arial,Helvetica" size="1"><i>All fraudulent attempts will be investigated and prosecuted</i></font><p style="word-spacing: 0; margin-top: 0; margin-bottom: 0"><font face="Verdana,Arial,Helvetica" size="1"><i>in accordance with applicable law.</i></font><p style="word-spacing: 0; margin-top: 0; margin-bottom: 0">&nbsp;
<hr size="1">
<p style="word-spacing: 0; margin-top: 0; margin-bottom: 0" align="center">
<b><font face="Verdana,Arial,Helvetica" color="#000000" size="1">Customer
Support :</font><font face="Verdana,Arial,Helvetica" size="2" color="#000000">
</font>
</b>
<font size="3"><b>
<a href="mailto:$EmailAddress">$EmailAddress</a></b>
</font>
<hr size="1">
<p style="word-spacing: 0; margin-top: 0; margin-bottom: 0" align="center"><b><font face="Verdana,Arial,Helvetica" size="1" color="#808080">Copyright
© $Company All Rights Reserved</font></b>
</td></tr></table></BODY></HTML>

EOF
exit;
}

}

####### End
