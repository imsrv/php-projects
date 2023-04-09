# Common routines
# Ben Duncan (ben@isecure.net)
# http://cgisupport.com

sub config
{

$|++;                                           # Don't buffer output
$cgi = new CGI;                                 # Create new CGI object                
#print header;
formvars($cgi);                                 # Get form vars

&newuser if($newuser);
%preferences = cookie('atmail');

foreach ('username','password','pop3host') {
#$preferences{$_} = param($_);
#$$_ = param($_) || $preferences{$_};
$preferences{$_} = param($_) || $preferences{$_};
$$_ = param($_) || $preferences{$_};
                                                }
($username,$pop3host) = split("\@",$email) if($email);

if($logout)     {
$the_cookie = cookie(-name=>'atmail',
                     -value=>'',
                     -expires=>'now');
                }

# Refresh the cookie so that it doesn't expire.  This also
# makes any changes the user made permanent.
$the_cookie = cookie(-name=>'atmail',
                         -value=>\%preferences,
                         -expires=>'+1hr'); # Keep the cookie for 30 days!
                                            # Change to 1d, for 1 day, 1hr, etc

print header(-cookie=>$the_cookie);

&colorsetup;
&preferences;
&error("Password incorrect") if($localmail && $userpassword ne $masterpassword);
}

sub formvars {        

    my($self, $type) = @_;

    my($param,$value,@result);
    return 0 unless $self->param;
    foreach $param ($self->param) {
        $name=$self->escapeHTML($param);                     
        foreach $value ($self->param($param)) {
        $$name = $value;
        push(@$name, "$value") if($name eq "msgdelete");
        $myenv{$name} = $value;
    }
 }                               
}

sub smtpmail
{
my($from, $to, $subject, $msg) = @_;
use Net::SMTP;

$smtp = Net::SMTP->new("$smtphost");
$smtp->mail("$from");
$smtp->to("$to");
$smtp->data();
$smtp->datasend("Subject: $subject\n");
$smtp->datasend("X-Mailer: \@Mail $version (http://webbasedemail.net)\n");

$smtp->datasend("$msg");
$smtp->datasend("\n$footermsg") if(!$fileupload);
$smtp->dataend();
$smtp->quit;

}

sub printhtml
{
my($file) = $_[0];
my($html);

open(FILE,"$file");
while(<FILE>) {$html .= $_; }
close(FILE);

print $html;                                                 

}


sub htmlend {

print<<_EOF;
</tr></td></table></html>
_EOF


if($pop3)       {
$pop3->quit();
                }
else {
&cleanup if($myinbox);
      }

exit();

}


sub htmlheader {

print<<_EOF;
<html>
<head>
<title>$_[0]</title>
</head>
<body bgcolor="$bgcolor" text="$textcolor" link="$linkcolor" vlink="$vlinkcolor">

<a href="index.html" target=_new>
<table width=600>
<tr><td>
<img border="0" src="imgs/banner.gif">
</td>
</tr></table>
</a>
_EOF

if($navbar)     {
print<<_EOF;
<map name="navbar">
  <area shape="rect" coords="486,10,561,36" alt="Help" href="http://webbasedemail.com/help.html">
  <area shape="rect" coords="365,12,481,36" alt="Email Search" href="ldap.pl">
  <area shape="rect" coords="244,15,362,36" alt="Preferences" 
href="settings.pl?username=$username&pop3host=$pop3host">    
  <area shape="rect" coords="123,9,242,36" alt="Compose Msg" 
href="compose.pl?username=$username&pop3host=$pop3host">      
  <area shape="rect" coords="0,11,120,36" alt="Check Mail" 
href="showmail.pl?username=$username&pop3host=$pop3host">       
</map>
<img src="imgs/nav.gif" usemap="#navbar" border="0">
<br>

_EOF
                }

print<<_EOF;
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr> 
<td> 
<P>
_EOF
print "<img src=\"imgs/alert.gif\"><font face=geneva,arial size=-1>$status</font>" if($status);

}



sub colorsetup
{

if(!$designtype || $designtype eq "standard")                 
 {                                                                          
$primarycolor = "#B7C2F1";                                                  
$secondarycolor = "#CCCCFF";                 
$bgcolor = "#ffffff";        
$linkcolor = "#000000";      
$vlinkcolor = "#000033";     
$quotecolor = "#ff3333";     
$textcolor = "#000033";      
$headercolor = "#5167C6";    
 }                         

if($designtype eq "purplehaze")
 {
$primarycolor = "#7777aa";
$secondarycolor = "#7777bb";
$bgcolor = "#FFFFFF";
$linkcolor = "#0000FF";
$vlinkcolor = "#0000FF";
$quotecolor = "#ff3333";
$textcolor = "#000000";
$headercolor = "#FFFFFF";
 }


if($designtype eq "grey")
 {
$primarycolor = "#CCCCCC";
$secondarycolor = "#A3A3A3";
$bgcolor = "#FFFFFF";
$linkcolor = "#FF9900";
$vlinkcolor = "#FF3366";
$quotecolor = "#ff3333";
$textcolor = "#000000";
$headercolor = "#000000";
 }

}

sub preferences {

umask(000);

$userpassword = $password;

return if(!$username && !$pop3host);

$confdir = "$username\@$pop3host";

mkdir("$Bin/users/$confdir",0777) if(!-e "$Bin/users/$confdir");
mkdir("$Bin/users/$confdir/mbox",0777) if(!-e "$Bin/users/$confdir/mbox");

if($newuser)    {

if(!-e "$Bin/users/$confdir/Inbox") {
open(SENTMAIL,">>$Bin/users/$confdir/Inbox"); close(SENTMAIL);
                                        }

$sendmailbinary = "sendmail -t" if(!$sendmailbinary);
open(SENDMAIL,"|$sendmailbinary -t") || print "Cannot execute $sendmailbinary: $!<BR>";
print SENDMAIL "To: $username\@$pop3host\n";
print SENDMAIL "From: $adminemail\n";
print SENDMAIL "Subject: Welcome $firstname to your new account!\n";
print SENDMAIL "X-Mailer: \@Mail $version (http://webbasedemail.net)\n\n";
print SENDMAIL "$welcomemsg\n";
print SENDMAIL "$footermsg" if($footermsg);
close(SENDMAIL);

open(F, ">>$Bin/users/$confdir/user.info") || print "Cannot write $Bin/users/$confdir/user.info: $!\n";
foreach (sort keys %myenv)      {
print F "$_: $myenv{$_}\n";
                                }
print F "signdate: ", time, "\n";
close(F);

                }

open(INDEX,">$Bin/users/$confdir/index.html") || print "Cannot create $Bin/users/$confdir/index.html: $!";
print INDEX<<_EOF;
<HTML>
<HEAD>
<BODY BGCOLOR="white">
<TITLE>Welcome to $firstname $lastname home page</TITLE>
<FONT SIZE=+2>Welcome!</FONT>
<HR>
This is the personal website of $firstname $lastname<BR>
You can contact me at <a href="mailto:$username\@$pop3host">$username\@$pop3host</a>
_EOF

if(!-e "$Bin/users/$confdir/mbox/Sent") {
open(SENTMAIL,">>$Bin/users/$confdir/mbox/Sent"); close(SENTMAIL);
                                        }

if(!-e "$Bin/users/$confdir/mbox/Trash") {
open(SENTMAIL,">>$Bin/users/$confdir/mbox/Trash"); close(SENTMAIL);
                                        }

if(!-e "$Bin/users/$confdir/address.book")      {
open(BOOK,">>$Bin/users/$confdir/address.book");
print BOOK "$username!$username\@$pop3host!http://UNKNOWN!This is my email address\n";
close(BOOK);
                                        }

if(-e "$Bin/users/$confdir/usersettings" && !$savesettings)
{ print ""; }

else {
$status = "Writing configuration file for $username\@$pop3host";
open(CONF,">$Bin/users/$confdir/usersettings") || print "Cannot write $Bin/users/$confdir/usersettings: $!";
print CONF "\$username = \"$username\";\n";
print CONF "\$password = \"$password\";\n" if(!-e "$Bin/users/$confdir/Inbox");
print CONF "\$masterpassword = \"$password\";\n";
print CONF "\$password = \"$password\";\n";
print CONF "\$pop3host = \"$pop3host\";\n";
print CONF "\$realname = \"$username\";\n" if ($firstname && $lastname);
print CONF "\$realname = \"$username\";\n" if (!$realname && !$fistname && !$lastname);
print CONF "\$realname = \"$realname\";\n" if ($realname);
print CONF "\$refresh = \"600\";\n";
print CONF "\$navbar = \"$navbar\";\n";
print CONF "\$primarycolor = \"$primarycolor\";\n";
print CONF "\$secondarycolor = \"$secondarycolor\";\n";
print CONF "\$linkcolor = \"$linkcolor\";\n";
print CONF "\$vlinkcolor = \"$vlinkcolor\";\n";
print CONF "\$bgcolor = \"$bgcolor\";\n";
print CONF "\$textcolor = \"$textcolor\";\n";
print CONF "\$headercolor = \"$headercolor\";\n";
print CONF "\$localmail = \"Inbox\";\n" if(-e "$Bin/users/$confdir/Inbox");
print CONF "\$signature = \"$signature\";\n";
print CONF "\n1;\n";

close(CONF);
}

do "$Bin/users/$confdir/usersettings";
}


sub pop3connect
{
my($error);

$pop3 = new Net::POP3($pop3host);
$pop3->login($username, $password) || $error;

$status = "Cannot login to POP3 Account $username\@$pop3host: $!\n" if($error);

}


sub subject_header
{
my($subject) = @_;

$subject = "No Subject" if(!$subject);

$length = length($subject);

if($length>35)  {
$subject = substr($subject,0,35);
$subject .= "..";
                }

return $subject;
}

###
# Parse date header
###

sub date_header
{
my($date) = @_;

$date = parsedate($date);
$date = strftime("%e/%m/%y %R ", localtime $date);

return $date;
}

###
# Strip from header to 40 characters
###

sub from_header
{
my($from, $type) = @_;

$from = "Unknown" if(!$from);

$length = length($from);

if($length>40)  {

if($from =~ /&lt;(.+\@.+)&gt;/) { $from = $1; }

if(!$type)      {
$from = substr($from,0,40);
$from .= "...";
                }

        }

return $from;
}


sub parseheader {

my($header) = $_[0];
$header =~ s|<|&lt;|m;
$header =~ s|>|&gt;|m;
#$header =~ s|"||m;
$header =~ s/"//g;
return $header;

}

sub date_header
{
my($date) = @_;

$date = parsedate($date);
$date = strftime("%e/%m/%y %R ", localtime $date);

return $date;
}



sub error
 {
my($error) = $_[0];
print "Content-type: text/html\n\n";
print<<_EOF;
<HTML><BODY BGCOLOR="#ffffff">
<font color="red">$error</font>
<BR><HR>Please use the <b>back</b> button on your browser and correct the error
_EOF

exit;
 }

# Turn form vars into something we can read
sub myescape {                                                 
    shift() if ref($_[0]) || $_[0] eq $DefaultClass;                      
    my $toencode = shift;                                               
    return undef unless defined($toencode);                             
    $toencode=~s/([^a-zA-Z0-9_.-])/uc sprintf("%%%02x",ord($1))/eg;
    return $toencode;
}


sub myunescape {
    shift() if ref($_[0]);
    my $todecode = shift;
    return undef unless defined($todecode);                             
    $todecode =~ tr/+/ /;       # pluses become spaces
    $todecode =~ s/%([0-9a-fA-F]{2})/pack("c",hex($1))/ge;
    return $todecode;                                                       
}

1;
