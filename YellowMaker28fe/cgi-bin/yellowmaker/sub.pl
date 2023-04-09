
########################################################################
# PROGRAM NAME : YellowMaker
# COPYRIGHT: YellowMaker.com
# E-MAIL ADDRESS: webmaster@yellowmaker.com
# WEBSITE: http://www.yellowmaker.com/
########################################################################
# sub.pl
########################################################################

eval {
  ($0 =~ m,(.*)/[^/]+,)   && unshift (@INC, "$1"); # Get the script location: UNIX / or Windows /
  ($0 =~ m,(.*)\\[^\\]+,) && unshift (@INC, "$1"); # Get the script location: Windows \

use sender;
};

if ($@) {
print ("Content-type: text/html\n\n");
print "Error including required files: $@\n";
print "Make sure these files exist, permissions are set properly, and paths are set correctly.";
exit;
}


sub admincheckpermission {
&GetCookies("dataadmin","datapassword");
$dataadmin=lc($Cookies{'dataadmin'});
$datapassword=$Cookies{'datapassword'};
if (($dataadmin ne $admin) && ($datapassword ne $adminpwd)) {
&header;
&top;
&include("/$sub/$sub9/admin.htm");
&bottom;
exit;
} 
}


sub adminlogout {
	my (@cookies);
	push (@cookies,"dataadmin","","datapassword","");
	my ($Header);
	my ($cookie,$value,$char);
	my (@Days)=("Sun","Mon","Tue","Wed","Thu","Fri","Sat");
	my (@Months)=("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
	my ($Sec,$Min,$Hour,$MDay,$Mon,$Year,$WDay)=gmtime(time+31536000);
	if ($Year>50) {
		$Year+=1900;
	}else{
		$Year+=2000;
	}

	while(($cookie,$value)=@cookies) {
		foreach $char (@cookie_encode_chars) {
			$cookie =~ s/$char/$cookie_Encode_Chars{$char}/g;
			$value  =~ s/$char/$cookie_Encode_Chars{$char}/g;
		}
		$Header.="Set-Cookie: ".$cookie."=". $value."; ";
		$Header.="expires=$Days[$WDay], $MDay-$Months[$Mon]-$Year $Hour:$Min:$Sec GMT;";
		$Header.="\n";
		shift(@cookies);
		shift(@cookies);
	}
	
	print $Header;

$message="You are now logged out of Administrative Center.";
&logoutstandard;
}


sub admincreatesession {
my ($dataadmin, $datapassword)=@_;
$dataadmin =~ s/\|/\$\|/g;
$dataadmin =~ s/\n/\\\|n/g;
$datapassword =~ s/\|/\$\|/g;
$datapassword =~ s/\n/\\\|n/g;
&SetCookies("dataadmin",$dataadmin,"datapassword",$datapassword);
}


sub adminstandard {
&header;
&top;
&include("/$sub/$sub9/adminstandard.htm");
&bottom;
exit;
}


sub bottom {
&include("/$sub/$sub9/bottom.htm");
} 

sub check {
my ($list, $filespec)=@_;
open(LIST, $filespec) || return 0;
while (<LIST>){
if (/^$list/) {
close LIST;
return 1;
}
}
close LIST;
return 0;
}


sub checkid  {
my ($userid, $filespec)=@_;
open(USERFILE, $filespec) || return 0;
foreach $line (<USERFILE>) {
@datafile =split(/\s*\|\s*/,$line, 19);
if ($datafile[1] eq "$userid") {
$name=$datafile[0];
$name =~ s/^\s+//;
$name =~ s/\s+$//;
$ip=$datafile[2];
$ip =~ s/^\s+//;
$ip =~ s/\s+$//;
$emailaddr=$datafile[7];
$emailaddr =~ s/^\s+//;
$emailaddr =~ s/\s+$//;
$companyemailaddress=$datafile[17];
$companyemailaddress =~ s/^\s+//;
$companyemailaddress =~ s/\s+$//;
close USERFILE;
return 1;
return $name;
return $ip;
return $emailaddr;
return $companyemailaddress;
}
}
close USERFILE;
return 0;
}


sub checkimage {
$imagefile="$homedir/image/$id.gif"; 
if (-e $imagefile) {
$image=1;
}
}


sub check_new {
$returnval=substr($dateadd,0,4);
$yearofcreated=$returnval*365;
$returnval2=substr($dateadd,6,1);
if ($returnval2 ne "-") {
$returnval3=substr($dateadd,5,2);
$returnval4=substr($dateadd,8,2);
} else {
$returnval3=substr($dateadd,5,1);
$returnval4=substr($dateadd,7,2);
}
if (int(length($returnval3)) == 1 ) {
$returnval3="0$returnval3";
}
if ($returnval3 eq "01") {$monthofcreated=31;}
elsif ($returnval3 eq "02") {$monthofcreated=59;}
elsif ($returnval3 eq "03") {$monthofcreated=90;}
elsif ($returnval3 eq "04") {$monthofcreated=120;}
elsif ($returnval3 eq "05") {$monthofcreated=151;}
elsif ($returnval3 eq "06") {$monthofcreated=181;}
elsif ($returnval3 eq "07") {$monthofcreated=212;}
elsif ($returnval3 eq "08") {$monthofcreated=243;}
elsif ($returnval3 eq "09") {$monthofcreated=273;}
elsif ($returnval3 eq "10") {$monthofcreated=304;}
elsif ($returnval3 eq "11") {$monthofcreated=334;}
elsif ($returnval3 eq "12") {$monthofcreated=365;}
$dayofcreated=$returnval4;
$totalcreated=$yearofcreated+$monthofcreated+$dayofcreated;
$dayofyear=$year*365;
if (int(length($month)) == 1 ) {
$month="0$month";
}
if ($month eq "01") {$dayofmonth=31;}
elsif ($month eq "02") {$dayofmonth=59;}
elsif ($month eq "03") {$dayofmonth=90;}
elsif ($month eq "04") {$dayofmonth=120;}
elsif ($month eq "05") {$dayofmonth=151;}
elsif ($month eq "06") {$dayofmonth=181;}
elsif ($month eq "07") {$dayofmonth=212;}
elsif ($month eq "08") {$dayofmonth=243;}
elsif ($month eq "09") {$dayofmonth=273;}
elsif ($month eq "10") {$dayofmonth=304;}
elsif ($month eq "11") {$dayofmonth=334;}
elsif ($month eq "12") {$dayofmonth=365;}
$totalday=$dayofyear+$dayofmonth+$day;
$results=$totalday-$totalcreated;
$new="";
if ($expired > $results) {
$new="*";
}
}


sub checkpermission {
&GetCookies("emailaddress","password");
$emailaddress=lc($Cookies{'emailaddress'});
$password=$Cookies{'password'};
$file=$userfile;
$user="$emailaddress";
$file =~ /(.+)/;
$safefile=$1;
$returnval=&userdefined($user, $safefile);
if (($returnval eq "0") || ($password ne $pwd)) {
&header;
&top;
&include("/$sub/$sub9/login.htm");
&bottom;
exit;
} 
}


sub checkrecord {
$name=$fieldvalue[0];
$id=$fieldvalue[1];
$ip=$fieldvalue[2];
$host=$fieldvalue[3];
$dateadd=$fieldvalue[4];
$datemod=$fieldvalue[5];
$category=$fieldvalue[6];
$emailaddr=$fieldvalue[7];
$establish=$fieldvalue[8];
$address1=$fieldvalue[9];
$address2=$fieldvalue[10];
$city=$fieldvalue[11];
$state=$fieldvalue[12];
$zipcode=$fieldvalue[13];
$country=$fieldvalue[14];
$phone=$fieldvalue[15];
$fax=$fieldvalue[16];
$companyemailaddress=$fieldvalue[17];
$homepage=$fieldvalue[18];
$name =~ s/^\s+//;
$name =~ s/\s+$//;
$id =~ s/^\s+//;
$id =~ s/\s+$//;
$ip =~ s/^\s+//;
$ip =~ s/\s+$//;
$host =~ s/^\s+//;
$host =~ s/\s+$//;
$dateadd =~ s/^\s+//;
$datemod =~ s/\s+$//;
$category =~ s/^\s+//;
$category =~ s/\s+$//;
$emailaddr =~ s/^\s+//;
$emailaddr =~ s/\s+$//;
$establish =~ s/^\s+//;
$establish =~ s/\s+$//;
$address1 =~ s/^\s+//;
$address1 =~ s/\s+$//;
$city =~ s/^\s+//;
$city =~ s/\s+$//;
$state =~ s/^\s+//;
$state =~ s/\s+$//;
$zipcode =~ s/^\s+//;
$zipcode =~ s/\s+$//;
$country =~ s/^\s+//;
$country =~ s/\s+$//;
$phone =~ s/^\s+//;
$phone =~ s/\s+$//;
$fax =~ s/^\s+//;
$fax =~ s/\s+$//;
$companyemailaddress =~ s/^\s+//;
$companyemailaddress =~ s/\s+$//;
$homepage =~ s/^\s+//;
$homepage =~ s/\s+$//;

$recordvalue=$name . " " . $id . " " . $ip . " " . $host . " " . $dateadd . " " . $datemod . " " . $category . " " . $emailaddr . " " . $establish . " " . $address1 . " " . $address2 . " " . $city . " " . $state . " " . $zipcode . " " . $country . " " . $phone . " " . $fax . " " . $companyemailaddress . " " . $homepage;

$search=0;
$exact=0;
$wildcard=0;
$strmatched=0;
$matched=0;
$notmatched=1; 
$keywords=$form{'keys'};
$keywords =~ s/%26/&/g;

if ($search == 0) {
if ($keywords) {
@words=split(/ +/, $keywords);
foreach $line (@words) {
if (($exact == 0) && ($wildcard == 0)) {
if ($recordvalue =~ /$line/oi)  {
$strmatched=1;
} else {
$notmatched=0;
}
}
if (($exact == 1) && ($wildcard == 0)) {
if ($recordvalue =~ /\b$line\b/oi)  {
$strmatched=1;
} else {
$notmatched=0;
}
}
if (($exact == 0) && ($wildcard == 1)) {
if ($recordvalue =~ /\b$line/oi)  {
$strmatched=1;
} else {
$notmatched=0;
}
}
}
} else {
$matched=1;
}
}

if (($strmatched == 1) && ($notmatched == 1)) {
$matched=1;
}

}


sub checksearchsession {
&GetCookies("keys","name","category","establish","city","state","zipcode","country","phone","fax");
$form{'keys'}=($Cookies{'keys'});
$form{'name'}=($Cookies{'name'});
$form{'category'}=$Cookies{'category'};
$form{'establish'}=($Cookies{'establish'});
$form{'city'}=$Cookies{'city'};
$form{'state'}=($Cookies{'name'});
$form{'zipcode'}=$Cookies{'zipcode'};
$form{'country'}=($Cookies{'country'});
$form{'phone'}=$Cookies{'phone'};
$form{'fax'}=$Cookies{'fax'};
}


sub convertstr {
my ($string)=@_;
$length=length($string);
$string=lc($string);
$num=0;
$results="";
while ($num <= $length) {
$returnval=substr($string,$num,1);
if ($returnval eq " ") {
$num2=$num+1;
$returnval=uc(substr($string,$num2,1));
$results="$results $returnval";
$num=$num+2;
} else {
$results="$results$returnval";
$num=$num+1;
}
}
$results=ucfirst($results);
return $results;
}


sub createsearchsession {
$form{'keys'} =~ s/\|/\$\|/g;
$form{'keys'} =~ s/\n/\\\|n/g;
$form{'name'} =~ s/\|/\$\|/g;
$form{'name'} =~ s/\n/\\\|n/g;
$form{'category'} =~ s/\|/\$\|/g;
$form{'category'} =~ s/\n/\\\|n/g;
$form{'establish'} =~ s/\|/\$\|/g;
$form{'establish'} =~ s/\n/\\\|n/g;
$form{'city'} =~ s/\|/\$\|/g;
$form{'city'} =~ s/\n/\\\|n/g;
$form{'state'} =~ s/\|/\$\|/g;
$form{'state'} =~ s/\n/\\\|n/g;
$form{'zipcode'} =~ s/\|/\$\|/g;
$form{'zipcode'} =~ s/\n/\\\|n/g;
$form{'country'} =~ s/\|/\$\|/g;
$form{'country'} =~ s/\n/\\\|n/g;
$form{'phone'} =~ s/\|/\$\|/g;
$form{'phone'} =~ s/\n/\\\|n/g;
$form{'fax'} =~ s/\|/\$\|/g;
$form{'fax'} =~ s/\n/\\\|n/g;
&SetCookies("keys",$form{'keys'},"name",$form{'name'},"category",$form{'category'},"establish",$form{'establish'},"city",$form{'city'},"state",$form{'state'},"zipcode",$form{'zipcode'},"country",$form{'country'},"phone",$form{'phone'},"fax",$form{'fax'});
}


sub createsession {
my ($emailaddress, $password)=@_;
$emailaddress =~ s/\|/\$\|/g;
$emailaddress =~ s/\n/\\\|n/g;
$password =~ s/\|/\$\|/g;
$password =~ s/\n/\\\|n/g;
&SetCookies("emailaddress",$emailaddress,"password",$password);
}


sub datadefined  {
my ($username, $filespec)=@_;
open(USERFILE, $filespec) || return 0;
foreach $line (<USERFILE>){
@datafile =split(/\s*\|\s*/,$line, 19);
if ($datafile[7] eq "$username") {
$name=$datafile[0];
$id=$datafile[1];
$ip=$datafile[2];
$host=$datafile[3];
$dateadd=$datafile[4];
$datemod=$datafile[5];
$category=$datafile[6];
$establish=$datafile[8];
$address1=$datafile[9];
$address2=$datafile[10];
$city=$datafile[11];
$state=$datafile[12];
$zipcode=$datafile[13];
$country=$datafile[14];
$phone=$datafile[15];
$fax=$datafile[16];
$companyemailaddress=$datafile[17];
$homepage=$datafile[18];
close USERFILE;
return 1;
}
}
close USERFILE;
return 0;
}



sub delete {
my ($list, $filespec)=@_;
open(LIST, "+<$filespec") || return 0;
@listings=<LIST>;
seek (LIST, 0, 0);
truncate (LIST,0);
foreach $record(@listings) {
chomp($record);
unless ($record =~ /^$list$/i) {
print LIST "$record\n";
}
}	
close(LIST);
}


sub deleteuser  {
my ($username, $filespec)=@_;
my ($thisusr, $thispw, $thiscode, $thisaddr, $thishost, $thisdate, $elem, %passwords, %codes, %addrs, %hosts, %dates);
open(USERFILE, "$filespec") || die "Could not open user file \"$filespec\" for reading: $!\n";
while (<USERFILE>) {
chop;
($thisusr, $thispw, $thiscode, $thisaddr, $thishost, $thisdate)=split(/\s*\|\s*/, $_) ;
$passwords{$thisusr}=$thispw;
$codes{$thisusr}=$thiscode;
$addrs{$thisusr}=$thisaddr;
$hosts{$thisusr}=$thishost;
$dates{$thisusr}=$thisdate;
}
close USERFILE;
if ($passwords{$username}) { 
delete $passwords{$username};
open(USERFILE, ">$filespec") || die "Could not open user file \"$filespec\" for reading: $!\n";
foreach $elem ( keys %passwords ) {
print USERFILE $elem, "|", $passwords{$elem}, "|", $codes{$elem}, "|", $addrs{$elem}, "|", $hosts{$elem}, "|", $dates{$elem}, "\n" || die "Failed to write user/password to file \"$filespec\": $!.\n";
}
close USERFILE;
}
}


sub error {
&header;
&top;
&include("/$sub/$sub9/error.htm");
&bottom;
exit;
}


sub generate_password {
srand(time|$$);
my $returnpwd="";
my $random="1234567890abcdefghijklmnopqrstuvwxyz";
for (1..6) {
$returnpwd .= substr($random,int(rand(36)),1);
$code=$returnpwd;
}
}


sub get_time {
$time=time;
$time2=localtime($time);
($wday, $month, $day, $time, $year)=split(" ",$time2,5);
if ($month =~ /Dec/i){$month=12;}
elsif ($month =~ /Nov/i){$month=11;}
elsif ($month =~ /Oct/i){$month=10;}
elsif ($month =~ /Sep/i){$month=9;}
elsif ($month =~ /Aug/i){$month=8;}
elsif ($month =~ /Jul/i){$month=7;}
elsif ($month =~ /Jun/i){$month=6;}	
elsif ($month =~ /May/i){$month=5;}
elsif ($month =~ /Apr/i){$month=4;}
elsif ($month =~ /Mar/i){$month=3;}				
elsif ($month =~ /Feb/i){$month=2;}
elsif ($month =~ /Jan/i){$month=1;}
if (int(length($month)) == 1 ) {
$month="0$month";
}
if (int(length($day)) == 1 ) {
$day="0$day";
}
}


sub header {
$time=time;
$time2=localtime($time);
($wday, $dmonth, $dday, $dtime, $dyear)=split(" ",$time2,5);
$date="$wday, $dday $dmonth, $dyear";
return print ("Content-type: text/html\n\n");
}


sub include {
&localvals;
local (%listvals)=%localvals;
local ($thehtmlfile)=@_;
local ($thepathtohtmlfile)="$ENV{'DOCUMENT_ROOT'}/$thehtmlfile";
open(in, "<$thepathtohtmlfile") || die "Cannot open file: 
$thepathtohtmlfile for read!\n";
$thepathtohtmlfile="";
while(<in>) {
$thepathtohtmlfile .= $_;
}
close(in);
for $ikey (keys(%listvals)) {
local($value)=$listvals{"$ikey"};
$thepathtohtmlfile =~ s/$ikey/$value/gm;
}	
print "$thepathtohtmlfile\n";
return;
}


sub localvals {
%localvals=(
"!ACTIVATED!","$total_activated",
"!ADDRESS1!","$address1",
"!ADDRESS2!","$address2",
"!ADMIN!","$admin",
"!ADMINLIST!","$adminlist",
"!ADMINPWD!","$adminpwd",
"!AGE!","$age",
"!BACKGROUND!","$background",
"!BEGIN!","$form{'begin'}",
"!CATEGORY!","$category",
"!CGI!","$cgi",
"!CITY!","$city",
"!CODE!","$code",
"!COMPANY!","$company",
"!COMPANYEMAILADDRESS!","$companyemailaddress",
"!CONTACT!","$contact",
"!COPYRIGHT!","$copyright",
"!COUNTRY!","$country",
"!DATE!","$date",
"!DATEADD!","$dateadd",
"!DATEMOD!","$datemod",
"!DESCRIBE!","$describe",
"!DISPLAY!","$display",
"!EMAILADDRESS!","$emailaddress",
"!EMAILADDR!","$emailaddr",
"!EMAILFUNCTION!","$EmailFunction",
"!END!","$form{'end'}",
"!ESTABLISH!","$establish",
"!EXPIRED!","$expired",
"!FAX!","$fax",
"!FONT!","$font",
"!FORMEMAILADDRESS!","$form{'formemailaddress'}",
"!FORMID!","$form{'formid'}",
"!FORMIP!","$form{'formip'}",
"!FORMLIST!","$form{'formlist'}",
"!FORMPASSWORD!","$form{'formpassword'}",
"!HOME!","$home",
"!HOMECGI!","$homecgi",
"!HOMEPAGE!","$homepage",
"!HOST!","$host",
"!ID!","$id",
"!ID2!","$form{'id'}",
"!IMAGE!","$image",
"!IMGMAX!","$imgmax",
"!INTRO!","$intro",
"!IP!","$ip",
"!LINK!","$link",
"!LIST!","$list",
"!MESSAGE!","$message",
"!MSGACTIVATE!","$msgactivate",
"!MSGADD!","$msgadd",
"!MSGREMOVE!","$msgremove",
"!MSGSIGNUP!","$msgsignup",
"!NAME!","$name",
"!NEWCODE!","$form{'newcode'}",
"!NEWEMAILADDRESS!","$form{'newemailaddress'}",
"!NEWPASSWORD!","$form{'newpassword'}",
"!NEW!","$new",
"!NEWSLETTER!","$newsletter",
"!NO!","$no",
"!NO1!","$no1",
"!NO2!","$no2",
"!NO3!","$no3",
"!NO4!","$no4",
"!NO5!","$no5",
"!NO6!","$no6",
"!NO7!","$no7",
"!NO8!","$no8",
"!NO9!","$no9",
"!NO10!","$no10",
"!NO11!","$no11",
"!NO12!","$no12",
"!NO13!","$no13",
"!NO14!","$no14",
"!NO15!","$no15",
"!NO16!","$no16",
"!NO17!","$no17",
"!NO18!","$no18",
"!NO19!","$no19",
"!NO20!","$no20",
"!NO21!","$no21",
"!NO22!","$no22",
"!NO23!","$no23",
"!NO24!","$no24",
"!NO25!","$no25",
"!NO26!","$no26",
"!NO27!","$no27",
"!NO28!","$no28",
"!NO29!","$no29",
"!NO30!","$no30",
"!NO31!","$no31",
"!NO32!","$no32",
"!NO33!","$no33",
"!NO34!","$no34",
"!NO35!","$no35",
"!NO36!","$no36",
"!NO37!","$no37",
"!NUM!","$num",
"!OPEN!","$open",
"!OPERATINGHOURS!","$operatinghours",
"!PASSWORD!","$password",
"!PHONE!","$phone",
"!PLATFORM!","$platform",
"!REDIRECT!","$redirect",
"!REGISTER!","$register",
"!REGISTERED!","$total_registered",
"!REPLY!","$reply",
"!ROOT!","$root",
"!SENDMAILLOCATION!","$SendMailLocation",
"!SIZE!","$size",
"!SLOGAN!","$slogan",
"!SPECIALISE!","$specialise",
"!STATE!","$state",
"!SUB!","$sub",
"!SUBSIZE!","$subsize",
"!TELL!","$tell",
"!TITLE!","$title",
"!TOTALPROFILES!","$total_profiles",
"!URL!","$url",
"!VERSION!","$version",
"!WEBSITE!","$website",
"!WEBMASTER!","$webmaster",
"!YELLOWPAGE!","$yellowpage",
"!ZIPCODE!","$zipcode",
);
}


sub lock {
chmod (0666, "$filename");
local ($lockname, $filename)=@_;
local ($endtime);
$endtime=15;
$endtime=time + $endtime;
while (-e $lockname && time < $endtime) {
open (LOCKFILE, ">$lockname");
}
}


sub logout {
	my (@cookies);
	push (@cookies,"emailaddress","","password","");
	my ($Header);
	my ($cookie,$value,$char);
	my (@Days)=("Sun","Mon","Tue","Wed","Thu","Fri","Sat");
	my (@Months)=("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
	my ($Sec,$Min,$Hour,$MDay,$Mon,$Year,$WDay)=gmtime(time+31536000);
	if ($Year>50) {
		$Year+=1900;
	}else{
		$Year+=2000;
	}
	
	while(($cookie,$value)=@cookies) {
		foreach $char (@cookie_encode_chars) {
			$cookie =~ s/$char/$cookie_Encode_Chars{$char}/g;
			$value  =~ s/$char/$cookie_Encode_Chars{$char}/g;
		}
		$Header.="Set-Cookie: ".$cookie."=". $value."; ";
		$Header.="expires=$Days[$WDay], $MDay-$Months[$Mon]-$Year $Hour:$Min:$Sec GMT;";
		$Header.="\n";
		shift(@cookies);
		shift(@cookies);
	}
	
	print $Header;

$message="You are now logged out of Member Center.";
&logoutstandard;
}



sub logoutstandard {
&header;
&top;
&include("/$sub/$sub9/logoutstandard.htm");
&bottom;
exit;
}


sub maildefined  {
my ($username, $filespec)=@_;
open(USERFILE, $filespec) || return 0;
while (<USERFILE>) {
if (/^$username/) {
close USERFILE;
return 1;
}
}
close USERFILE;
return 0;
}


sub parse_form {
read(STDIN, $buffer, $ENV{'CONTENT_LENGTH'});
if (length($buffer) < 5) {
$buffer=$ENV{QUERY_STRING};
}
@pairs=split(/&/, $buffer);
foreach $pair (@pairs) {
($frmname, $value)=split(/=/, $pair);
$value =~ tr/+/ /;
$value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
$form{$frmname}=$value;
}
}


sub print_noresults {
print qq~
<div align="center"><center>

<table border="0" cellpadding="0" cellspacing="0" width="85%" height="50">
  <tr>
    <td width="100%" height="25"></td>
  </tr>
  <tr>
    <td width="100%" valign="middle" align="center" height="125"><p align="center"><font
    face="$font" size="$size"><strong>Sorry, no results were found matching!<br>
    </strong><br>
    Total Profiles: 0</font></td>
  </tr>
  <tr>
    <td width="100%" height="25"></td>
  </tr>
</table>
</center></div>
~;
}


sub print_record {
&localvals;
local (%listvals)=%localvals;
local ($template)="$plate";
open(TEMPL, "$template") || print "no file found $template!";
$template="";
while(<TEMPL>) {
$template .= $_;
}
close(TEMPL);
for $ikey (keys(%listvals)) {
local($value)=$listvals{"$ikey"};
$template =~ s/$ikey/$value/gm;
}	
print "$template\n";
return;
}


sub print_search {
&include("/$sub/$sub9/simple.htm");
}


sub print_top {
if ($form{'end'} > $total_profiles) {
$form{'end'}=$total_profiles;
}
$pagenum=int(($form{'begin'}/$display)+1);

if ($total_profiles > $display) {
$top="<a href=\"#top\">Top</a>  |";
} else {
$top="<a href=\"#top\">Top</a>";
}

##########
# Profiles > $display & next result, so show back to HOME.
##########
if ($form{'begin'} > $display) {
$back_home="<a href=\"$homecgi/$redirect?begin=1&end=$display&back=1\">Home</a>";
}

##########
# Profiles > $display & no next result, so back to previous.
##########
if ($form{'begin'} > $display) {
$begin=$form{'begin'}-$display;
$end=$begin+($display-1);
$back_previous="| <a href=\"$homecgi/$redirect?begin=$begin&end=$end&back=1\">Previous</a>";
}

##########
# Profiles > $display & next results < 20, so continue to next results.
##########
if (($total_profiles > $display) && ($total_profiles > $form{'end'}) && ($search_limit eq "")) {
$begin=$form{'end'}+1;
$end=$begin+($display-1);
if ($back_previous eq "") {
$next="<a href=\"$homecgi/$redirect?begin=$begin&end=$end&back=1\">Next</a>";
} else {
$next="| <a href=\"$homecgi/$redirect?begin=$begin&end=$end&back=1\">Next</a>";
}
}

##########
# Profiles > $display, so show go to last results.
##########
if (($total_profiles > $display) && ($form{'end'} < $total_profiles) && ($form{'end'} != $total_profiles) && ($search_limit eq "")) {
if ($redirect eq "advanced2.pl") {
$all=$search_results;
} else {
$all=$total_profiles;
}
$begin=int($all/$display);
$begin=$begin*$display;
if ($begin < $all) {
$begin=$begin+1;;
} else {
if ($begin eq "$all") {
$begin=($begin-$display)+1;;
}
}
$end=$all;
$last="| <a href=\"$homecgi/$redirect?begin=$begin&end=$end&back=1\">Last</a>";
}

if (($total_profiles > 0) && ($top_index == 1)) {
if ($total_profiles>$display) {
$tdheight=10;
$tdheight2=20;
} else {
$tdheight=25;
$tdheight2=0;
}

&print_total;

}
&include("/$sub/$sub9/header.htm");
}


sub print_total {
print qq~
<div align="center"><center>

<table border="0" cellpadding="0" cellspacing="0" width="90%" height="40">
  <tr>
    <td colspan="3"><hr color="#FF9933" noshade size="1">
    </td>
  </tr>
  <tr>
    <td valign="top" align="left"><p align="left"><font face="$font" size="$size">Search
    Results » <font color="#FF0000"><strong>$form{'keys'}</strong></font>:
    $form{'begin'}-$form{'end'} of $total_profiles record(s) » Page $pagenum</font></td>
    <td width="20"><font face="$font" size="$size"></font></td>
    <td valign="top" align="right"><font face="$font" size="$size"><p align="right">$back_home
    $back_previous $next $last&nbsp;</font></td>
  </tr>
  <tr>
    <td colspan="3"><hr color="#FF9933" noshade size="1">
    </td>
  </tr>
  <tr>
    <td colspan="3" height="25"></td>
  </tr>
</table>
</center></div>
~;
}


sub print_total2 {
print qq~
<div align="center"><center>

<table border="0" cellpadding="0" cellspacing="0" width="90%">
  <tr>
    <td width="100%" colspan="3" height="25"></td>
  </tr>
  <tr>
    <td width="100%" colspan="3"><hr noshade color="#FF9933" size="1">
    </td>
  </tr>
  <tr>
    <td valign="top" align="left"><p align="left"><font face="$font" size="$size">Search
    Results » <font color="#FF0000"><strong>$form{'keys'}</strong></font>:
    $form{'begin'}-$form{'end'} of $recno record(s) » Page $pagenum</font></td>
    <td width="20"><font face="$font" size="$size"></font></td>
    <td valign="top" align="right"><strong><p align="right"></strong><font face="$font"
    size="$size">$top $back_home $back_previous $next $last&nbsp;</font></td>
  </tr>
  <tr>
    <td width="100%" colspan="3"><hr noshade color="#FF9933" size="1">
    </td>
  </tr>
  <tr>
    <td width="100%" height="15" colspan="3"></td>
  </tr>
</table>
</center></div>
~;
}


sub retrieveid  {
my ($username, $filespec)=@_;
open(USERFILE, $filespec) || return 0;
foreach $line (<USERFILE>){
@datafile =split(/\s*\|\s*/,$line, 19);
if ($datafile[7] eq "$username") {
$name=$datafile[0];
$name =~ s/^\s+//;
$name =~ s/\s+$//;
$id=$datafile[1];
$id =~ s/^\s+//;
$id =~ s/\s+$//;
close USERFILE;
return 1;
return $id;
return $name;
}
}
close USERFILE;
return 0;
}


###################################################################
# Mail::Sender.pm version 0.6.7
#
# Copyright (c) 1997 Jan Krynicky <Jenda@Krynicky.cz>. 
# All rights reserved.      
# This program is free software; you can redistribute it and/or
# modify it under the same terms as Perl itself.
###################################################################
sub sendmail{
	local ($From, $Subject, $Message, $To)=@_;
	if (($EmailFunction eq "SMTP") || ($EmailFunction eq "smtp")) {
		do "sender.pm";
		ref ($Sender=new Mail::Sender {smtp => $SendMailLocation, from => $From})||&CGIError("Couldn't open the SMTP server<br>\n SMTP Path: $SendMailLocation<br>\nReason : $Mail::Sender::Error");
		(ref
			(	$Sender->MailMsg(
						{
							to => $To, 
							subject => $Subject,
							msg => $Message
						}
					)
			)
		)||&CGIError("Couldn't send the email by SMTP server<br>\n SMTP Path: $SendMailLocation<br>\nReason : $Mail::Sender::Error");
		$Sender->Close();
	}elsif (($EmailFunction eq "SendMail") || ($EmailFunction eq "sendmail")) {
		open (MAIL, "|$SendMailLocation -t") || &CGIError("Couldn't open the SendMail program<br>\nPath: $SendMailLocation<br>\nReason : $!");
			print MAIL "To: $To\n";
			print MAIL "From: $From\n";
			print MAIL "Subject: $Subject\n\n";
			print MAIL "$Message\n\n";
		close (MAIL);
	}
}
###################################################################


sub standard {
&header;
&top;
&include("/$sub/$sub9/standard.htm");
&bottom;
exit;
}


sub top {
&include("/$sub/$sub9/top.htm");
}


sub total_activated {
open (USERFILE, "$userfile") || die ("Can't open $userfile");
$total_activated=0;
while (<USERFILE>) {
$total_activated+=1;
}
close (USERFILE);
return $total_activated;
}


sub total_profiles {
open (DATABASE, "<$database");
@entries=<DATABASE>;
close(DATABASE);
$total_profiles=@entries;
close DATABASE;
}


sub total_registered {
open (TMPFILE, "$tmpfile") || die ("Can't open $tmpfile");
$total_registered=0;
while (<TMPFILE>) {
$total_registered+=1;
}
close (TMPFILE);
return $total_registered;
}


sub unlock {
chmod (0666, "$filename");
local ($lockname, $filename)=@_;
close (LOCKFILE);
unlink ($lockname);
} 


sub userdefined  {
my ($username, $filespec)=@_;
open(USERFILE, $filespec) || return 0;
foreach $line (<USERFILE>){
@datafile =split(/\s*\|\s*/,$line, 8);
if ($datafile[0] eq "$username") {
$pwd=$datafile[1];
$pwd =~ s/^\s+//;
$pwd =~ s/\s+$//;
$code=$datafile[2];
$code =~ s/^\s+//;
$code =~ s/\s+$//;
$ip=$datafile[3];
$ip =~ s/^\s+//;
$ip =~ s/\s+$//;
$emailaddress2=$datafile[6];
$emailaddress2 =~ s/^\s+//;
$emailaddress2 =~ s/\s+$//;
$code2=$datafile[7];
$code2 =~ s/^\s+//;
$code2 =~ s/\s+$//;
close USERFILE;
return 1;
return $pwd;
return $code;
return $emailaddress2;
return $code2;
}
}
close USERFILE;
return 0;
}


sub valid_address {
local ($testmail)=@_;
if ($testmail !~ /^[a-zA-Z0-9-_.]+@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*\.[a-zA-Z0-9-]+/)
{return 0;}
else 
{return 1;}
}




1;
