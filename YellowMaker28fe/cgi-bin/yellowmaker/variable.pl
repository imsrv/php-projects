
########################################################################
# PROGRAM NAME : YellowMaker
# COPYRIGHT: YellowMaker.com
# E-MAIL ADDRESS: webmaster@yellowmaker.com
# WEBSITE: http://www.yellowmaker.com/
########################################################################
# variable.pl
########################################################################

$sub1="member";
$sub2="profile";
$sub3="time";
$sub4="name";
$sub5="specialise";
$sub6="intro";
$sub7="describe";
$sub8="categories";
$sub9="template";

if (!$root) {
$root="$ENV{'DOCUMENT_ROOT'}";
}

if (!$url) {
$url="http://$ENV{'SERVER_NAME'}";
}

@cgipath=split(/\//, $ENV{'SCRIPT_FILENAME'});
pop(@cgipath);
$subyb=pop(@cgipath);

@cgipath2=split(/\/$subyb/, $ENV{'SCRIPT_FILENAME'});
pop(@cgipath2);
$subyb2=pop(@cgipath2);

if (!$cgi) {
$cgisub="$subyb2/$subyb";
@cgipath3=split(/\//, $cgisub);
pop(@cgipath3);
$cgi=pop(@cgipath3);
if (!$cgi) {
$cgi="cgi-bin";
}
}

if (!$sub) {
if (($subyb =~ /wrap/i) || (!$subyb)) {
$sub="yellowmaker";
} else {
$sub="$subyb";
}
}

$home="$url/$sub";
$homecgi="$url/$cgi/$sub";
$homedir="$root/$sub";

$tmpfile="$sub1/tmplist.txt";
$userfile="$sub1/userlist.txt";
$mailfile="$sub1/maillist.txt";
$mailtmpfile="$sub1/mailtmplist.txt";
$delfile="$sub1/dellist.txt";
$tellfile="$sub1/telllist.txt";
$banmail="$sub1/banmail.txt";
$banip="$sub1/banip.txt";

$counter="$sub2/counter.txt";
$database="$sub2/current.txt";
$previous="$sub2/previous.txt";
$history="$sub2/history.txt";
$temp="$sub2/temp.txt";

$lock="lock.txt";
