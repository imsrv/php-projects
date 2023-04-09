#!/usr/bin/perl -s
use Socket;
####################################################################################################
# DBAY				                                        	Version 1.0                            
# Copyright 1999  Telecore Media International, Inc.				webmaster@superscripts.com                 
# Created 9/24/99                                      			Last Modified 11/29/99                           
####################################################################################################
# COPYRIGHT NOTICE                                                           
# Copyright 1999  Telecore Media International, Inc. - All Rights Reserved.                    
# http://www.superscripts.com/                                                                                                           
# Selling the code for this program without prior written consent is         
# expressly forbidden.                                           
#                                                                           
# Obtain written permission before redistributing this software over the Internet or 
# in any other medium.  In all cases copyright and header must remain intact.
#
# My name is drew star... and i am funky...  http://www.drewstar.com/artist/
####################################################################################################
require "configure.cgi";
&configure;
&refergate;
open (HDISPLAY, "$htmlheader");
@header=<HDISPLAY>;
open (HDISPLAY, "$htmlfooter");
@footer=<HDISPLAY>;
&generatevariables;

&form_parse;

	$title = $FORM{'title'};
	$category = $FORM{'category'};
	$description = $FORM{'description'};
	$description =~ s/ /\|/g;
	$description =~ s/\s/\|/g;
	$description =~ s/\|+/ /g;
	$reserve = $FORM{'reserve'};
	$getnoticed = $FORM{'getnoticed'};
	$pictureurl = $FORM{'pictureurl'};
	$username = $FORM{'username'};
	$password = $FORM{'password'};
	$startprice = $FORM{'startprice'};
	$duration = $FORM{'duration'};
	$cardnumber = $FORM{'cardnumber'};
	$buyerpaymentmethod = $FORM{'buyerpaymentmethod'};
	$shipinternationally = $FORM{'shipinternationally'};
	$whopaysshipping = $FORM{'whopaysshipping'};
	$paymentmethodbyseller = $FORM{'paymentmethod'};
	$METHOD = $FORM{'paymentmethod'};
	$cardnumber = $FORM{'cardnumber'};
	$expirationdate = $FORM{'expirationdate'};
		$description =~ tr/\\n//; 
		$cardnumber =~ s/-//g;
		$cardnumber =~ s/ //g;
		$expirationdate =~ s/ //g;
		$expirationdate =~ s/-//g;
		$expirationdate =~ s/\///g;

		if ($startprice eq ""){
			$startprice="0.00";
			}
		if (!($startprice =~ /\./)){
			$startprice = $startprice.".00";
			}
		$currentbid= $startprice;
		if ($pictureurl eq "http://"){
			$pictureurl = $nopic;
			}
&calculatecharge;
&errcheck;
use DBI;
$dbh = DBI->connect("dbi:mysql:$mysqldatabase","$mysqlusername","$mysqlpassword") || die("Couldn't connect to database!\n");
&lookup;
&postdata;
&bankswitch;
if ($status eq "FAILED"){
	&failed;
	exit;
	}

&savedata;
&emailnotice;
&getitemdata;

$dbh->disconnect;

&countdown;
print "Content-type: text/html\n\n";
&confirmationpage;
############################################################
#  CALCULATE CHARGE TO CARD
############################################################
sub calculatecharge{

$AMOUNT = "2.00";

if ($getnoticed eq "boldface"){
	$AMOUNT = "4.00";
	}
if ($getnoticed eq "hilited"){
	$AMOUNT = "10.00";
	}
if ($getnoticed eq "icon"){
	$AMOUNT = "5.00";
	}
}
############################################################
#  DO THIS IF CARD FAILS
############################################################
sub failed {
print "Content-type: text/html\n\n";
		foreach $reply(@reply){
		print "$reply";
		}
}
############################################################
#  CHARGE CREDIT CARD
############################################################
sub postdata{

	($firstname,$lastname)=split(/ /,$vname);
	$buffer="x_Login=$LOGIN&x_Password=$PASSWORD&x_Invoice_Num=$itemnumber&x_Description=$DESCRIPTION&x_Amount=$AMOUNT&x_Cust_ID=$username&x_Method=$METHOD&x_Type=$TYPE&x_Card_Num=$cardnumber&x_Exp_Date=$expirationdate&x_Auth_Code=$AUTHCODE&x_Bank_Acct_Num=$ACCTNO&x_Bank_ABA_Code=$ABACODE&x_Bank_Name=$BANKNAME&x_Last_Name=$lastname&x_Address=$vaddress&x_City=$vcity&x_State=$vstate&x_Zip=$vzip&x_Country=$vcountry&x_Phone=$vphone&x_Fax=$vphone&x_Email=$vemail&x_Email_Customer=$MAILCUSTOMER&ECHODATA=$ECHODATA&x_AVS_Filter=$REJECTAVSMISMATCH&x_Test_Request=$TESTREQUEST&x_ADC_Delim_Character=$DELIMCHARACTER&is x_ADC_Encapsulate_Character=$ENCAPSULATE";
	$add = $buffer;
	$postlen = length($add);
	$msg = "POST $script HTTP/1.0\r\nContent-type: application/x-www-form-urlencoded\r\nContent-length: $postlen\r\n\r\n$add\r\n";
	$submit = "$msg";

        if ($port =~ /\D/) { $port = getservbyname($port, 'tcp') }
        die "No port specified." unless $port;
        $iaddr   = inet_aton($remote)               || die "Could not find host: $remote";
        $paddr   = sockaddr_in($port, $iaddr);

        $proto   = getprotobyname('tcp');
        socket(SOCK, PF_INET, SOCK_STREAM, $proto)  || die "socket: $!";
        connect(SOCK, $paddr)    || die "connect: $!";
        send(SOCK,$submit,0);
        while(<SOCK>) { 
        push (@reply,$_);
	  #print $_;
        }
        return 0;
}
#####################################################################################################
#  DETERMINE IF BANK RESULT IS PASS OR FAIL
#####################################################################################################
sub bankswitch{
foreach $reply(@reply){

$status = "FAILED";

	if ($reply =~ /This is your receipt/i){
		$status = "PASSED";
		last;
		}
	}
}
############################################################
#  FIGURE OUT REMAINING TIME/BID INCREMENTS
############################################################
sub countdown  {

chop($date = &ctime(time));
($weekday,$month,$day,$time,$zone,$year)=split(/ /,$date);

if ($day eq ""){
	$day = $time;
	$time= $zone;
	}
if ($weekday =~ /mon/i){
$ttheday = 1;
}
if ($weekday =~ /tue/i){
$ttheday = 2;
}
if ($weekday =~ /wed/i){
$ttheday = 3;
}
if ($weekday =~ /thr/i){
$ttheday = 4;
}
if ($weekday =~ /fri/i){
$ttheday = 5;
}
if ($weekday =~ /sat/i){
$ttheday = 6;
}
if ($weekday =~ /sun/i){
$ttheday = 7;
}

if ($ttheday < $rstartday){
$ttheday = $ttheday+7;
}

($shour,$min,$sec)=split(/\:/,$rstarttime);
($fhour,$min,$sec)=split(/\:/,$time);

$hourcountdown = $shour - $fhour;
$dayselapsed = $ttheday- $rstartday;
$daysremaining = $rduration - $dayselapsed;

if ($hourcountdown < 0){
$hourcountdown = $hourcountdown+24;
$daysremaining = $daysremaining - 1;
}

}
############################################################
#  GET ITEM DATA FROM DATABASE
############################################################
sub getitemdata  {

	my($query) = "SELECT * FROM items where itemnumber = '$itemnumber'";
	my($sth) = $dbh->prepare($query);
	$sth->execute || die("Couldn't exec sth!");

	while(@row = $sth->fetchrow)  {
		$ritemnumber = $row[0];
		$rtitle = $row[1];
		$rcategory = $row[2];
		$rdescription = $row[3];
		$rreserve = $row[4];
		$rgetnoticed = $row[5];
		$rpictureurl = $row[6];
		$rusername = $row[7];
		$rpassword = $row[8];
		$rstartprice = $row[9];
		$rduration = $row[10];
		$rbuyerpaymentmethod = $row[11];
		$rshipinternationally = $row[12];
		$rwhopaysshipping = $row[13];
		$rpaymentmethodbyseller = $row[14];
		$rcardnumber = $row[15];
		$rexpirationdate = $row[16];
		$rstartday = $row[17];
		$rstarttime = $row[18];
		$rcurrenthibid = $row[19];
		$rcurrenthibidder = $row[20];
		$rcurrenthibidemail = $row[21];
		$rmaxbid = $row[22];
		$rfinalbid = $row[23];
		$ritemstatus = $row[24];
	}
	$sth->finish;

}
############################################################
#  LOOKUP ACCOUNT INFO
############################################################
sub lookup  {

	my($query) = "SELECT * FROM profile where username = '$username' or email = '$email'";
	my($sth) = $dbh->prepare($query);
	$sth->execute || die("Couldn't exec sth!");

	while(@row = $sth->fetchrow)  {
		$vemail = $row[0];
		$vname = $row[1];
		$vaddress = $row[2];
		$vcity = $row[3];
		$vstate = $row[4];
		$vcountry = $row[5];
		$vzip = $row[6];
		$vphone = $row[7];
		$vusername = $row[8];
		$vpassword = $row[9];
	}
	$sth->finish;

	if (!$vusername){
	print "Content-type: text/html\n\n";
	print "Not a valid username";
	exit;
	}
	if ($password ne $vpassword){
	print "Content-type: text/html\n\n";
	print "Invalid Account Information";
	exit;
	}
	if ($password ne $vpassword){
	print "Content-type: text/html\n\n";
	print "Invalid Account Information";
	exit;
	}
}
############################################################
#  ERRORCHECK
############################################################
sub errcheck{

if (!$title){
print "Content-type: text/html\n\n";
print "Title is required.  Please backup and complete form.";
exit;
}
if (!$description){
print "Content-type: text/html\n\n";
print "Description is required.  Please backup and complete form.";
exit;
}
if (!$username){
print "Content-type: text/html\n\n";
print "Username is required.  Please backup and complete form.";
exit;
}
if (!$password ){
print "Content-type: text/html\n\n";
print "Password is required.  Please backup and complete form.";
exit;
}
if (!$cardnumber){
print "Content-type: text/html\n\n";
print "Cardnumber is required.  Please backup and complete form.";
exit;
}
if (!$cardnumber){
print "Content-type: text/html\n\n";
print "Cardnumber is required.  Please backup and complete form.";
exit;
}
if (!$expirationdate){
print "Content-type: text/html\n\n";
print "Expiration Date is required.  Please backup and complete form.";
exit;
}
if (!$buyerpaymentmethod){
print "Content-type: text/html\n\n";
print "You must specify payment method for buyer.  Please backup and complete form.";
exit;
}
}
############################################################
#  GENERATE VARIABLES
############################################################
sub generatevariables {

$reserve="",
$pictureurl ="",

$currenthibidder ="",
$currenthibidemail ="",
$maxbid ="",
$finalbid ="",
$itemstatus ="open",

$itemnumber = &generateorderid;

chop($date = &ctime(time));
($weekday,$month,$day,$time,$zone,$year)=split(/ /,$date);

if ($day eq ""){
$day = $time;
$time=$zone
}

if ($weekday =~ /mon/i){
$theday = 1;
}
if ($weekday =~ /tue/i){
$theday = 2;
}
if ($weekday =~ /wed/i){
$theday = 3;
}
if ($weekday =~ /thr/i){
$theday = 4;
}
if ($weekday =~ /fri/i){
$theday = 5;
}
if ($weekday =~ /sat/i){
$theday = 6;
}
if ($weekday =~ /sun/i){
$theday = 7;
}

}
############################################################
#  SAVE ITEM DATA
############################################################
sub savedata{
	$query = "INSERT INTO items values('$itemnumber','$title','$category','$description','$reserve','$getnoticed','$pictureurl','$username','$password','$startprice','$duration','$buyerpaymentmethod','$shipinternationally','$whopaysshipping','$paymentmethodbyseller','$cardnumber','$expirationdate','$theday','$time','$currenthibid','$currenthibidder','$currenthibidemail','$maxbid','$finalbid','$itemstatus')";
	$dbh->do($query);
}
######################################################################
# EMAIL ITEM INFO
######################################################################
sub emailnotice	{

open (MAIL, "| $mailprogram $vemail");
print MAIL "Reply-to: $adminemail\n";
print MAIL "From: $adminemail\n";
print MAIL "To: $vemail\n";

print MAIL "Subject: AUCTION STARTED!\n\n";

print MAIL "Your auction has begun!\n";

print MAIL "$getitemcgi?$itemnumber\n\n";

print MAIL "TITLE:  $title\n";
print MAIL "CATEGORY:  $category\n";
print MAIL "DESCRIPTION:  $description\n";

print MAIL "Please see the item description url for more information.\n";
print MAIL "Best Regards\n";
print MAIL "Staff\n\n\n";


print MAIL "CGI developed by http://www.superscripts.com/\n";
close MAIL;

}
############################################################
#  PRINT ITEM CONFIRMATION PAGE
############################################################
sub confirmationpage{
print @header;

print <<ENDCONFIRM;


<table border="1" cellspacing="0" width="100%" bgcolor="#99CCCC">
  <tr>
    <td align="center" width="100%"><font color="#000000" face="Arial" size="3"><b>$title</b></font></td>
  </tr>
  <tr>
    <td align="center" width="100%"><font color="#000000" face="Arial" size="2"><b>Item
    #$itemnumber</b></font></td>
  </tr>
  <tr>
    <td align="center" width="100%"><font color="#000000" face="Arial" size="2"><a
    href="$searchcategorycgi?$category">$category</a></font></td>
  </tr>
</table>
</center></div>

<p align="center">&nbsp;</p>
<div align="center"><center>

<table border="0" width="100%" cellpadding="0">
  <tr>
    <td width="25%" bgcolor="#DADADA"><strong><font color="#000000"><font face="Arial"><small>Starting
    Price</small></font></font></strong></td>
    <td width="25%" bgcolor="#DADADA"><font color="#000000"><small><font face="Arial">\$$startprice</font></small></font></td>
  </tr>
  <tr>
    <td width="25%" bgcolor="#DADADA"><strong><font color="#000000"><font face="Arial"><small>Time
    Remaining</small></font></font></strong></td>
    <td width="25%" bgcolor="#DADADA"><font color="#000000"><small><font face="Arial">$daysremaining Days:$hourcountdown Hours</font></small></font></td>
  </tr>
  <tr>
    <td width="25%" bgcolor="#DADADA"><strong><font color="#000000"><font face="Arial"><small>Seller ID</small></font></font></strong></td>
    <td width="25%" bgcolor="#DADADA"><font color="#000000"><small><font face="Arial"><a href="$getprofilecgi?$username">$username</a></font></small></font></td>
  </tr>
  <tr>
    <td width="25%" bgcolor="#DADADA"><strong><font color="#000000"><font face="Arial"><small>Payment
    Method</small></font></font></strong></td>
    <td width="25%" bgcolor="#DADADA"><font color="#000000"><small><font face="Arial">$buyerpaymentmethod</font></small></font></font></td>
  </tr>
  <tr>
    <td width="25%" bgcolor="#DADADA"><strong><font color="#000000"><font face="Arial"><small>Who
    Pays Shipping</small></font></font></strong></td>
    <td width="25%" bgcolor="#DADADA"><font color="#000000"><small><font face="Arial">$whopaysshipping</font></small></font></td>
  </tr>
  <tr>
    <td width="25%" bgcolor="#DADADA"><strong><font color="#000000"><font face="Arial"><small>Current
    Bid</small></font></font></strong></td>
    <td width="25%" bgcolor="#DADADA"><font color="#000000"><small><font face="Arial">\$$currentbid</font></small></font></td>
  </tr>
  <tr>
    <td width="25%" bgcolor="#DADADA"><strong><font color="#000000"><font face="Arial"><small>Location</small></font></font></strong></td>
    <td width="25%" bgcolor="#DADADA"><font color="#000000"><small><font face="Arial">$vcity,$vstate,$vcountry</font></small></font></td>
  </tr>
  <tr>
    <td width="25%" bgcolor="#DADADA"><strong><font face="Arial" color="#000000"><small>Email
    Seller</small></font></strong></td>
    <td width="25%" bgcolor="#DADADA"><font face="Arial" color="#000000"><small><a href="mailto:$vemail">$vemail</a></small></font></td>
  </tr>
</table>
</center></div>

<blockquote>
  <blockquote>
    <blockquote>
      <blockquote>
        <blockquote>
          <blockquote>
            <p align="center"><small><font face="Arial">Seller assumes all responsibility for listing
            this item. You should contact the seller to resolve any questions before bidding. Currency
            is U.S. dollar (\$) unless otherwise noted.</font></small></p>
          </blockquote>
        </blockquote>
      </blockquote>
    </blockquote>
  </blockquote>
</blockquote>
<div align="center"><center>

<table border="1" cellspacing="0" width="100%" bgcolor="#99CCCC">
  <tr>
    <td align="center" width="100%"><font color="#000000" face="Arial" size="3"><b><a
    name="DESC">Description</a></b></font></td>
  </tr>
</table>
</center></div>

<blockquote>
  <p align="center"><small><font face="Arial"><br>
  $description</font></small></p>
  <p align="center"><small><font face="Arial"><img src="$pictureurl"><br>
  </font></small></p>
</blockquote>

<p>&nbsp;</p>
</body>
</html>




ENDCONFIRM

print @footer;
}
############################################################
#  SUBROUTINES
############################################################
sub form_parse  {
	read (STDIN, $buffer, $ENV{'CONTENT_LENGTH'});
	@pairs = split(/&/, $buffer);
	foreach $pair (@pairs)
	{
    	($name, $value) = split(/=/, $pair);
    	$value =~ tr/+/ /;
    	$value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
    	$FORM{$name} = $value;
	}}
#####################################################################################################
#  GENERATE RANDOM ORDER ID
#####################################################################################################
sub generateorderid {
    local($orderid);
    local($sec,$min,$hour,$mday,$mon,$year,$wday,$yday,$isdst) = gmtime(time());
    $orderid = sprintf("%02d%02d%02d%02d%02d%05d",$year,$mon+1,$mday,$hour,$min,$$);
    return $orderid;
}
############################################################
#  TIME ROUTINE
############################################################
sub ctime {

    @DoW = ('Sun','Mon','Tue','Wed','Thu','Fri','Sat');
    @MoY = ('Jan','Feb','Mar','Apr','May','Jun',
	    'Jul','Aug','Sep','Oct','Nov','Dec');

    local($time) = @_;
    local($[) = 0;
    local($sec, $min, $hour, $mday, $mon, $year, $wday, $yday, $isdst);

    $TZ = defined($ENV{'TZ'}) ? ( $ENV{'TZ'} ? $ENV{'TZ'} : 'GMT' ) : '';
    ($sec, $min, $hour, $mday, $mon, $year, $wday, $yday, $isdst) =
        ($TZ eq 'GMT') ? gmtime($time) : localtime($time);

    if($TZ=~/^([^:\d+\-,]{3,})([+-]?\d{1,2}(:\d{1,2}){0,2})([^\d+\-,]{3,})?/){
        $TZ = $isdst ? $4 : $1;
    }
    $TZ .= ' ' unless $TZ eq '';

    $year += 1900;
    sprintf("%s %s %2d %2d:%02d:%02d %s%4d\n",
      $DoW[$wday], $MoY[$mon], $mday, $hour, $min, $sec, $TZ, $year);
}
############################################################
#  VALIDATE POST IS AUTHENTIC
############################################################
sub refergate {            
         if ($ENV{'HTTP_REFERER'} =~ /$localurl/i) {
			$flag = "OK";
          } 
        if ($flag ne "OK"){
          print "Content-Type: text/html\n\n";
          print "PERMISSION DENIED:  $ENV{'HTTP_REFERER'}";
          exit;
          }                 
}  