#!/usr/bin/perl
require "configdat.lib";
#########################################################################

$SIG{__DIE__} = \&Error_Msg;
sub Error_Msg {
    $msg = "@_"; 
   print "\nContent-type: text/html\n\n";
  print "The following error occurred : $msg\n";
  exit;
}

# Get the input
read(STDIN, $input, $ENV{'CONTENT_LENGTH'});
   @pairs = split(/&/, $input);
   foreach $pair (@pairs) {

   ($name, $value) = split(/=/, $pair);
  
   $name =~ tr/+/ /;  
   $name =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
   $value =~ tr/+/ /;
   $value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
   $value =~ s/<([^>]|\n)*>//g;
   

 $FORM{$name} = $value;  
      }




##########################################################################

$emailaddr=$FORM{'emailaddr'};

##########################################################################

if ($FORM{'loginreminder'}eq "Submit") {
	&loginreminder;
	}

##########################################################################

sub loginreminder {


if(-e "$storepass/$emailaddr.txt"){


open (FILE, "$storepass/$emailaddr.txt") || die "Cannot open this file\n";
flock (FILE, 1) or die "Cannot lock file\n";
while (<FILE>) {
chop;
	@datafile=split(/\n/);

	foreach $line (@datafile) {
	&sendloginfo($line);
	}
	}
	close(FILE);
	
}
###########################################################################

else {
print "Content-type:text/html\n\n";
print <<EOF;
<html><head>
<title>Email Address Not Found</title>
</head>
<body bgcolor="#FFFFFF" text="#000000" link="#003399" vlink="#993300" alink="#336633"><!--mstheme--><font face="Arial, Arial, Helvetica">
$mainheader
<blockquote>
  <blockquote>
    <blockquote>
     <form method="post" action="/cgi-bin/apersonalstouch/personals.pl">
      <!--mstheme--></font><table border="0" width="555">
        <tr>
           <td><table border="0" width="373" height="101">
               <tr>
                   <td>
<font size=1 face=verdana>We're sorry, but the email address, <b>$emailaddr</b>, was not found. The information you 
requested cannot be emailed to you without your email address.<p>Is it possible you
have entered a different address from the one you supplied at the time you created your web page? 
It is necessary that you enter the same email address you supplied when you first created your
web page.<p>
If the address you have entered is correct, and you continue 
to receive this message, please consider creating a new page again.
</font></center><br>
<center><FORM> <INPUT type="button" value="Click here to go back" onClick="history.go(-1)"> </FORM></center> 
                   <!--mstheme--></font></td>
                  </tr>
                </table><!--mstheme--><font face="Arial, Arial, Helvetica">
              </blockquote>
            </blockquote>
          <!--mstheme--></font></td>
        </tr>
      </table><!--mstheme--><font face="Arial, Arial, Helvetica">
    </blockquote>
  </blockquote>
</blockquote>
<!--mstheme--></font>
$botcode
</body></html>
EOF
exit;
}
}	

#######################################################################

sub sendloginfo($line){

local ($line) = @_;
	local ($loginname,$password,$securitycode);
		  ($loginname,$password,$securitycode)= split(/\|/, $line);		  


open  (MAIL, "| $sendmail -t") || die "cannot open sendmail\n";
print MAIL "To: $loginname <$emailaddr>\n";
print MAIL "From: $mailsenderid\n";
print MAIL "Subject: Your $sitename login information\n";
print MAIL "Dear $loginname,\n";
print MAIL "\n";
print MAIL "Below is the information you have requested. Your login name and password are:\n";
print MAIL "\n";
print MAIL "Login Name: $loginname\n";
print MAIL "Password: $password\n";
print MAIL "Security Code: $securitycode\n";
print MAIL "\n";
print MAIL "$sitename\n";
close MAIL;


#########################################################################

print "Content-type:text/html\n\n";
print <<EOF;
<html><head>
<title>Login Reminder Sent</title>
</head>
<body bgcolor="#FFFFFF" text="#000000" link="#003399" vlink="#993300" alink="#336633"><!--mstheme--><font face="Arial, Arial, Helvetica">
$mainheader
<blockquote>
  <blockquote>
    <blockquote>
      <!--mstheme--></font><table border="0" width="555">
        <tr><td>
          <table border="0" width="373" height="101">
               <tr>
                   <td>
<font size=1 face=verdana>
Your login information has been sent to <b>$emailaddr</b>. You should receive it 
shortly.<br>
<center><FORM> <INPUT type="button" value="Click here to go back" onClick="history.go(-1)"> </FORM></center> 
                   <!--mstheme--></font></td>
                  </tr>
                </table><!--mstheme--><font face="Arial, Arial, Helvetica">
              </blockquote>
            </blockquote>
          <!--mstheme--></font></td>
        </tr>
      </table><!--mstheme--><font face="Arial, Arial, Helvetica">
    </blockquote>
  </blockquote>
</blockquote>
<!--mstheme--></font>
$botcode
</body></html>
EOF
exit;
}



