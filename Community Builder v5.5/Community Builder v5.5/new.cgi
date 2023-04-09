#!/usr/bin/perl
###
#######################################################
#		
#     
#    		
# 		
#		
#
#######################################################
#
#
# COPYRIGHT NOTICE:
#
# Copyright 1998  Scripts  All Rights Reserved.
#
# Selling the code for this program without prior written consent is
# expressly forbidden. In all cases
# copyright and header must remain intact.
#
#######################################################

require "variables.pl";

unless ($over_bg) { $over_bg= "white"; }
unless ($table_bg) { $table_bg= "white"; }
unless ($table_head_bg) { $table_head_bg= "\#003C84"; }
unless ($text_color) { $text_color= "black"; }
unless ($link_color) { $link_color= "blue"; }
unless ($text_table) { $text_table= "black"; }
unless ($text_table_head) { $text_table_head= "white"; }
unless ($text_highlight) { $text_highlight= "red"; }
unless ($font_face) { $font_face= "arial"; }
unless ($font_size) { $font_size= "-1"; }


@char_set = ('a'..'z','0'..'9');


$version = "3.13";

$start_head ="<!-- START HOME FREE HEADER CODE -->\n";
$start_foot ="<!-- START HOME FREE FOOTER CODE -->\n";
$end_head ="<!-- END HOME FREE HEADER CODE -->\n";
$end_foot ="<!-- END HOME FREE FOOTER CODE -->\n";

$temp=$ENV{'QUERY_STRING'};

print "Content-type: text/html\n\n ";

if ($temp) {
	@pairs=split(/&/,$temp);
	foreach $item(@pairs) {
		($key,$content)=split (/=/,$item,2);
		$content=~tr/+/ /;
		$content=~ s/%(..)/pack("c",hex($1))/ge;
		$INPUT{$key}=$content;
	}
}
else {
	read(STDIN, $buffer, $ENV{'CONTENT_LENGTH'});
	@pairs = split(/&/, $buffer);
	foreach $pair (@pairs) {
		($name, $value) = split(/=/, $pair);
		$value =~ tr/+/ /;
		$value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
		if ($INPUT{$name}) { $INPUT{$name} = $INPUT{$name}.",".$value; }
		else { $INPUT{$name} = $value; }
#print "<font size=1 face=verdana>$name -- $value<BR></FONT>\n";
	}
}

$time = time;
($sec,$min,$hour,$mday,$mon,$year,$wday,$yday,$isdst) = localtime($time);
$mon++;
$year += 1900;
$now = "$mon.$mday.$year";
$cgiurl = $ENV{'SCRIPT_NAME'};


&Header;

if ($INPUT{'join'}) { &join; }
elsif ($INPUT{'view'}) { &view; }
elsif ($INPUT{'signup'}) { &signup; }
elsif ($INPUT{'action'} eq "remove") { &remove; }
elsif ($INPUT{'newpass'}) { &newpass; }
elsif ($INPUT{'delete_select'}) { &delete_select; }
elsif ($INPUT{'delete_final'}) { &delete_final; }
elsif ($INPUT{'sendemail'}) { &sendemail; }
else { &main; }
exit;


########## JOIN NOW SCREEN ##########
sub main {

## IF category MAKE USER SELECT category ##
if ($category) {
print <<EOF;
<FONT face=$font_face size=$font_size> 
The first step to obtaining you new web site is to<BR>
choose a $cata_name where your web site will be hosted<BR><BR>
Below are the different $cata_name<NBR>s that are available for<BR>
you to choose one. Look them over and at the bottom of this page<BR>
select the one that best fits the web site you will be building
<BR>
<FORM METHOD=POST ACTION="$cgiurl">
<table cellspacing=0 cellpadding=5 border=1 bgcolor=$table_bg>
EOF
	$select_list = '';
	if ($cata_base) {
		$select_list .= "<OPTION VALUE=\"accounts\">No $cata_name \n";
	}
	open (ACC, "$path/categories.txt");
	@cata_data = <ACC>;
	close (ACC);

	foreach $cata_line(@cata_data) {
		chomp($cata_line);
			@abbo = split(/\|/,$cata_line);
			($key,$abbo[0]) = split(/\%\%/,$abbo[0]);

			$openings = $abbo[7] - $abbo[8];
			unless ($openings) {
				$openings = "$cata_name Full";
			}
			else {
				$select_list .= "<OPTION VALUE=\"$key\">$abbo[1]\n";
			}
print <<EOF;
<TR align=left><TD>
<font face=$font_face size=$font_size color=$text_table>
<B>$cata_name</B> - $abbo[1]<BR>
<B>Base Url</B> - $url/$abbo[0]<BR>
<B>Openings Left</B> - $openings<BR>
<B>Description</B> - 

<BLOCKQUOTE>
$abbo[2]
</BLOCKQUOTE>
</TD></TR>
EOF
	}
print <<EOF;
<TR align=center bgcolor=$table_head_bg><TD>
<font face=$font_face size=$font_size color=$text_table_head>
Select the $cata_name that best fits your future web site<BR><BR>
<select name="category">
$select_list
</select>&nbsp;&nbsp;&nbsp;<input type="Submit" name="signup" value=" continue ">
</TD></TR></TABLE>
</FORM>
EOF
&Footer;
exit;
}
## NO category STRAIT TO JOIN SCREEN ## 
else {
	&signup;
}
}

## NEW ACCOUNT SIGN UP ##
sub signup {

print <<EOF;
<FONT face=$font_face size=$font_size> 
<B>Fill out the following fields to set up<BR>
your new account for a web site.</B>
<BR>
<FORM METHOD=POST ACTION="$cgiurl">
EOF
if ($INPUT{'category'}) {
	print "<INPUT TYPE=HIDDEN NAME=\"category\" value=\"$INPUT{'category'}\">\n";
}
else {
	print "<INPUT TYPE=HIDDEN NAME=category value=\"accounts\">\n";
}

if ($terms) {
	open (PASSWORD, "$path/rules.txt");
	@rules = <PASSWORD>; 
	close (PASSWORD);
		
print <<EOF;
<table border=0 width=60%>
<TR align=left>
<TD><font face=$font_face size=$font_size>
<B>Terms and Conditions</B><BR><BR>
@rules
<BR><BR></TD></TR><TR><TD bgcolor = $table_head_bg align=center>
<font face=$font_face size=$font_size color=$text_table_head> 
<input type="Checkbox" name="agree"> -- <B>I Agree</B>
</TD></TR>
</TABLE><BR>
EOF
}

print <<EOF;
<table cellspacing =0 cellpadding =8 border=0>
<TR><TD align=left>
<font face=$font_face size=$font_size>
<font color=red>*</font>Create account name:
</TD><TD align=left>
<INPUT TYPE="TEXT" NAME="account" VALUE="">
</TD>
<TD align=left valign=top><font face=$font_face size=-2><i>
will become $url/<font color=red>account</font><BR>
use only letters and 3 to 12 characters</FONT></I></TD>
</TR>
<TR><TD align=left>
<font face=$font_face size=$font_size>
<font color=red>*</font>Your e-mail address:
</TD><TD align=left>
<INPUT TYPE="TEXT" NAME="email" VALUE="">
</TD>
<TD align=left valign=top><font face=$font_face size=-2><i>
must be real as password will be sent to this address</FONT></I></TD>
</TR>

<TR><TD align=left>
<font face=$font_face size=$font_size>
<font color=red>*</font>Your name:
</TD><TD align=left>
<INPUT TYPE="TEXT" NAME="name" VALUE="">
</TD>
<TD align=left valign=top><font face=$font_face size=-2><i>
Your real name please.</FONT></I></TD>
</TR>
EOF

%user = ("Address","info_address","City","info_city","State","info_state","Zip","info_zip","Country","info_country","Telephone Number","info_tele","Gender","info_gender","Age","info_age","ICQ Num","info_icq","Education","info_edu","Income","info_inc","Occupation","info_job","Birth Date","info_dob");

$start=37;
foreach $key ("Address","City","State","Zip","Country","Telephone Number","Gender","Age","ICQ Num","Education","Income","Occupation","Birth Date") {
	$thek = $user{$key};
	$thev = $$thek;
	if ($thev) {
		if ($thev eq "required") { $req = "<font color=red>*</FONT>"; }
print <<EOF;
<TR><TD align=left>
<font face=$font_face size=$font_size>
$req $key:
</TD><TD align=left>
<INPUT TYPE="TEXT" NAME="$user{$key}" VALUE="">
</TD>
<TD align=left valign=top></TD>
</TR>
EOF
	}
	$req ='';
	$start++;
}

unless ($acc_type eq "Email Random Password") { 
print <<EOF;
<TR><TD align=left>
<font face=$font_face size=$font_size>
Choose a password:
</TD><TD align=left>
<INPUT TYPE="password" NAME="password" VALUE="">
</TD></TR>
EOF
}

print <<EOF;
<TR><TD> </TD><TD align=center><INPUT TYPE="SUBMIT" NAME="join" VALUE="  Join Now  ">
</TD><TD> </TD></TR>
</TABLE>
</FORM>
EOF
&Footer;
exit;
}



########### VERIFY AND ADD NEW ACCOUNT ##########
sub join {

$account = $INPUT{'account'};
$account = "\L$account\E";

if ($terms) {
	unless ($INPUT{'agree'}) {
print <<EOF;
<BR>
<table cellpadding=5 border=1 cellspacing=0 bgcolor=$table_bg>
<TR><TD><font face=$font_face size=$font_size><B>
You must agree to the terms and conditions before joining,<BR><BR>
please go back and read them, then check the "I agree box"
</TD></TR></TABLE>
EOF
		&Footer;
		exit;
	}
}		

$error ='';

unless ($INPUT{'account'}) {
	$error .= "You must enter an account name<BR>";
}
unless($INPUT{'email'} =~ /\@/) {
	$error .= "You must enter your email address<BR>";
}
unless ($INPUT{'name'}) {
	$error .= "You must enter your name<BR>";
}
%user = ("Address","info_address","City","info_city","State","info_state","Zip","info_zip","Country","info_country","Telephone Number","info_tele","Gender","info_gender","Age","info_age","ICQ Num","info_icq","Education","info_edu","Income","info_inc","Occupation","info_job","Birth Date","info_dob");
foreach $key ("Address","City","State","Zip","Country","Telephone Number","Gender","Age","ICQ Num","Education","Income","Occupation","Birth Date") {
	$thek = $user{$key};
	$thev = $$thek;
	if (($thev eq "required") && !($INPUT{$thek})) {
		$error .= "You must enter your $key<BR>";
	}
}
if (($acc_type ne "Email Random Password") && !($INPUT{'password'})) { 
	$error .= "You must enter a password<BR>";
}


if ($error) {
print <<EOF;
<BR>
<table cellpadding=5 border=1 cellspacing=0 bgcolor=$table_bg>
<TR><TD><font face=$font_face size=$font_size color=$text_table>
There are errors in application form<BR>
Please go back and fix the following:<BR><BR>
<font color=red>$error</FONT>
</TD></TR></TABLE><BR><BR>
EOF
	&Footer;
	exit;
}

@out = split(//,$account);
$a=0;
foreach $char (@out) {
	$a++;
	unless ($char =~ /[a-z0-9]/) {
print <<EOF;
<BR>
<table cellpadding=5 border=1 cellspacing=0 bgcolor=$table_bg>
<TR><TD><font face=$font_face size=$font_size color=$text_table>
You entered an invalid account name $char-$account<BR>
Make sure you only enter letters/numbers and nothing else<BR>
and that it is only 3 to 12 characters
</TD></TR></TABLE><BR><BR>
EOF
	&Footer;
	exit;
	}
}

if ($a < 3 || $a > 12) {
print <<EOF;
<BR>
<table cellpadding=5 border=1 cellspacing=0 bgcolor=$table_bg>
<TR><TD><font face=$font_face size=$font_size color=$text_table>
You entered an invalid account name.<BR>
Make sure you only enter letters/numbers and nothing else<BR>
and that it is only 3 to 12 characters
</TD></TR></TABLE><BR><BR>
EOF
&Footer;
exit;
}

@res = split(/\,/,$reserved);

foreach $r(@res) {
	$r = "\L$r\E";
	if ($account eq $r) {
		&account_taken;
		&Footer;
		exit;
	}	
}

### MAKE SURE ITS NOT A category ###
open (ACC, "$path/categories.txt");
@cata_data = <ACC>;
close (ACC);

foreach $cata_line(@cata_data) {
	chomp($cata_line);
	@abbo = split(/\|/,$cata_line);
	($key,$abbo[0]) = split(/\%\%/,$abbo[0]);
	if ($account eq $key) { 
	   &account_taken;
	   &Footer;
	   exit;
	}
}



## GET LIST OF ALL DIRS ##
$dir = "$path/members";
opendir(DIR,"$dir") || &error("can not open $dir");
@dirs = grep {!(/^\./) && -d "$dir/$_" } readdir(DIR);
close DIR;
foreach $cata(@dirs) {
	foreach $ch(@char_set) {
		opendir (DIR, "$dir/$cata/$ch") || &error("can not open $dir/$cata/$ch");
		@acc_arr = grep {!(/^\./) && -f "$dir/$cata/$ch/$_"}  readdir(DIR);
		close (DIR); 
		foreach $accs(@acc_arr) {
			undef $/;
			open (ACC, "$dir/$cata/$ch/$accs") || &error("Error reading $dir/$cata/$ch/$accs");
			$acc_data = <ACC>;
			close (ACC);
			$/ = "\n";
			
			$accs =~ s/\.dat//;
			if ($accs eq $account) {
				&account_taken;
				&Footer;
				exit;
			}  
			@acco = split(/\n/,$acc_data);
			$numaccounts ++;

			unless ($mult_email) {
			   	if ($acco[0] eq $INPUT{'email'}) {
			   	   &email_taken;
				   &Footer;
				   exit;
				}
			}
		}
	}
}


$dir_acc = $account;

unless ($INPUT{'category'} eq "accounts") {
   open (ACC, "$path/categories.txt");
   @cata_data = <ACC>;
   close (ACC);

   foreach $cata_line(@cata_data) {
   	   chomp($cata_line);
	   @cata = split(/\|/,$cata_line);
	   ($key,$cata[0]) = split(/\%\%/,$cata[0]);
	   if ($INPUT{'category'} eq $key) {
	   	  $cata[8]++;
		  $caat=$cata[0];
		  $cata[0] = "$key\%\%$cata[0]";
		  $cata_line = join("\|",@cata);
		  $cata_line .= "\n";
	  	  last;
	   }  	
	   $cata_line .= "\n";
	}	
	  
	$dir_acc = "$caat/$dir_acc";
	open (ACC, ">$path/categories.txt");
	print ACC @cata_data;
	close (ACC);
}

$! = '';

open(LIST,"$path/welcome_html.txt");
@welcs = <LIST>;
close(LIST);

open(LIST,"$path/welcome.txt");
@confirmit = <LIST>;
close(LIST);

$start=19;
%user = ("Address","info_address","City","info_city","State","info_state","Zip","info_zip","Country","info_country","Telephone Number","info_tele","Gender","info_gender","Age","info_age","ICQ Num","info_icq","Education","info_edu","Income","info_inc","Occupation","info_job","Birth Date","info_dob");
foreach $key ("Address","City","State","Zip","Country","Telephone Number","Gender","Age","ICQ Num","Education","Income","Occupation","Birth Date") {
	$thek = $user{$key};
	$new_acc[$start] = $INPUT{$thek};
	$start++;
}	
	
#### CREATE NEW FOLDER AND SITE ####

mkdir("$free_path/$dir_acc", 0777) || &error("Can't make $free_path/$dir_acc");

undef $/;
open(LIST,"$path/index.txt");
$index = <LIST>;
close(LIST);
$/="\n";

unless ($index) {
	$index .= "<HTML><HEAD><TITLE>Welcome to $INPUT{'name'}\'s homepage</TITLE></HEAD>\n<BODY>\n<center>\n";
	$index .= "<BR><font face=$font_face>Welcome to $INPUT{'name'}\'s homepage<BR><BR>";
	$index .= "$INPUT{'name'} has yet to move in, but you can email them at <A HREF=\"mailto:$INPUT{'email'}\">$INPUT{'email'}</A>";
	$index .= "</BODY>\n</HTML>";
}

$index =~ s/\%\%NAME\%\%/$INPUT{'name'}/gm;
$index =~ s/\%\%EMAIL\%\%/$INPUT{'email'}/gm;
$index =~ s/\%\%ACCOUNT\%\%/$INPUT{'account'}/gm;

%user = ("Address","info_address","City","info_city","State","info_state","Zip","info_zip","Country","info_country","Telephone Number","info_tele","Gender","info_gender","Age","info_age","ICQ Num","info_icq","Education","info_edu","Income","info_inc","Occupation","info_job","Birth Date","info_dob");
foreach $key ("Address","City","State","Zip","Country","Telephone Number","Gender","Age","ICQ Num","Education","Income","Occupation","Birth Date") {
	$thek = $user{$key};
	$thk = $thek;
	$thk =~ s/^info_//;
	$thk = "\U$thk\E";

	$index =~ s/\%\%$thk\%\%/$INPUT{$thek}/gm;
	$start++;
}	

open(LIST,">$free_path/$dir_acc/index.html") || &error("Can't make $free_path/$dir_acc/index.html");
print LIST $index;
close(LIST);

## PASSWORD EMAIL TO USER ##
if ($acc_type eq "Email Random Password") { 

	# generate random password
	srand($time);
	$password ="";
	@passset = ('a'..'k', 'm'..'z', 'A'..'N', 'P'..'Z', '2'..'9');
	for ($i = 0; $i < 8; $i++) {
		$randum_num = int(rand($#passset + 1));
		$password .= @passset[$randum_num];
	}
	$new_acc[0] = $INPUT{'email'};
	$new_acc[1] = $INPUT{'name'};
	$new_acc[2] = $password;
	$new_acc[4] = $time;
	$new_acc[7] = "on";
	
	$the_new_account = join("\n",@new_acc);
	
print <<EOF;
<table cellpadding=5 border=1 cellspacing=0 bgcolor=$table_bg>
<TR><TD>
<font face=$font_face size=$font_size color=$text_table><B>The creation of the account "$account" is complete</B>
<BR><BR>
Your password has been emailed to the address you entered.<BR><BR>
Your url for your new homepage will be:<BR>
<A HREF="$url/$dir_acc">$url/$dir_acc</A>
<BR><BR>
You can edit and upload your files through our file manager,<BR>
located <A HREF="$url_to_cgi/manager.cgi">$url_to_cgi/manager.cgi</A><BR><BR>
Any and all questions should be directed to <A HREF="mailto:$your_email">$your_email</A>
</TD></TR></TABLE>
<BR><BR>
@welcs
<BR><BR>
EOF

	$subject = "Welcome to $free_name\n";

	$message = "Welcome to $free_name, your free web site is ready for you to login\n\n";
	$message .= "Your information is as follows:\n";
	$message .= "---------------------------------------\n";
	$message .= "Account -- $account\n";
	$message .= "Password -- $password\n";
	$message .= "Your Url -- $url/$dir_acc\n\n";
	$message .= "To login to your web site and upload or create your pages\n";
	$message .= "please go to\n";
	$message .= "$url_to_cgi/manager.cgi\n\n";
	foreach $line(@confirmit) {
		$message .= "$line";
	}
	$message .= "\n\n";

	&write_email($INPUT{'email'},$subject,$message);
	
}
## USER SELECTED PASSWORD ##
elsif ($acc_type eq "User Selects Password") { 

	$new_acc[0] = $INPUT{'email'};
	$new_acc[1] = $INPUT{'name'};
	$new_acc[2] = $INPUT{'password'};
	$new_acc[4] = $time;
	$new_acc[7] = "on";
		
	$the_new_account = join("\n",@new_acc);
	untie(%acc);
print <<EOF;
<table cellpadding=5 border=1 cellspacing=0 bgcolor=$table_bg>
<TR><TD>
<font face=$font_face size=$font_size color=$text_table><B>The creation of the account "$account" is complete</B>
<BR>
Your url for your new homepage will be:<BR>
<A HREF="$url/$dir_acc">$url/$dir_acc</A>
<BR><BR>
You can edit and upload your files through our file manager,<BR>
located <A HREF="$url_to_cgi/manager.cgi">$url_to_cgi/manager.cgi</A><BR><BR>
Any and all questions should be directed to <A HREF="mailto:$your_email">$your_email</A>
</TD></TR></TABLE>
<BR><BR>
@welcs
<BR><BR>
EOF

	$subject = "Welcome to $free_name\n";

	$message = "Welcome to $free_name, your free web site is ready for you to login\n\n";
	$message .= "Your information is as follows:\n";
	$message .= "---------------------------------------\n";
	$message .= "Account -- $account\n";
	$message .= "Password -- $INPUT{'password'}\n";
	$message .= "Your Url -- $url/$dir_acc\n\n";
	$message .= "To login to your web site and upload or create your pages\n";
	$message .= "please go to\n";
	$message .= "$url_to_cgi/manager.cgi\n\n";
	foreach $line(@confirmit) {
		$message .= "$line";
	}
	$message .= "\n\n";

	&write_email($INPUT{'email'},$subject,$message);

}
else { ## ADMIN MUST CONFIRM ACCOUNT ##

	$new_acc[0] = $INPUT{'email'};
	$new_acc[1] = $INPUT{'name'};
	$new_acc[2] = $INPUT{'password'};
	$new_acc[4] = $time;
	$new_acc[7] = "on";
	$new_acc[18] = "All new accounts must be confirmed before they can be used";
		
	$the_new_account = join("\n",@new_acc);
	untie(%abc);
print <<EOF;
<table cellpadding=5 border=1 cellspacing=0 bgcolor=$table_bg>
<TR><TD>
<font face=$font_face size=$font_size color=$text_table><B>The creation of the account "$account" is complete</B>
<BR><BR>
Your account must first be approved,<BR>
upon approval your url for your new homepage will be:<BR>
<A HREF="$url/$dir_acc">$url/$dir_acc</A>
<BR><BR>
You will receive an email upon approval of your account.<BR> 
You can then edit and upload your files through our file manager,<BR>
located <A HREF="$url_to_cgi/manager.cgi">$url_to_cgi/manager.cgi</A><BR><BR>
Any and all questions should be directed to <A HREF="mailto:$your_email">$your_email</A>
</TD></TR></TABLE>
<BR><BR>
@welcs
<BR><BR>
EOF

}

## EMAIL ADMIN IF NEW ACCOUNT ##
if ($e_notify) {
	$subject = "Subject: $free_name -- New Signup\n\n";
	$message .= "A new signup at $free_name\n\n";
	$message .= "Their information is as follows:\n";
	$message .= "---------------------------------------\n";
	$message .= "Account -- $account\n";
	$message .= "Name -- $INPUT{'name'}\n";
	$message .= "Email -- $INPUT{'email'}\n";
	$message .= "Url -- $url/$dir_acc\n\n";
	$message .= "\n\n";
	
	&write_email($your_email,$subject,$message);
}


@accarray = split(//,$account);
$accfile = "$path/members/$INPUT{'category'}/$accarray[0]/$account.dat";

open (ACC, ">$accfile") || &error("Error printing $accfile");
print ACC $the_new_account;
close (ACC);


####
&Footer;
exit;
}

########## SORT HASH ##########
sub sort_hash {
	my $x = shift;
	my %array = %$x;
	sort { $array{$b} cmp $array{$a}; } keys %array;
}

########## SORRY ACCOUNT NAME TAKEN ##########
sub account_taken {

print <<EOF;
<BR>
<table cellpadding=5 border=1 cellspacing=0 bgcolor=$table_bg>
<TR><TD align=center><font face=$font_face size=$font_size color=$text_table>
We are sorry, but the account name "$account"<BR>	
has already be taken, please hit your<BR>
back button and choose another account name
</TD></TR></TABLE>
EOF
}

########## EMAIL ALREADY USED ##########
sub email_taken {

print <<EOF;
<BR>
<table cellpadding=5 border=1 cellspacing=0 bgcolor=$table_bg>
<TR><TD><font face=$font_face size=$font_size color=$text_table>
We are sorry, we only allow one account per email address<BR>
The email address you used already has an account with us
</TD></TR></TABLE>
EOF
}



########## ACTUAL SENDING OF EMAIL ##########
sub write_email {
if ($demo){&demo;}

$recipient = $_[0];
$subject = $_[1];
$message = $_[2];

### SMTP ###
if ($email_prog =~ /\./) {

	$smtp_server = $email_prog;
	$emailfrom = $your_email;

	$debug =0;	

	$smtp = $smtp_server;
	$from = $emailfrom;
	$to = $recipient;
	$smtpaddr = $smtp;
 
    my ($replyaddr) = $emailfrom;
	print "</CENTER><BR>to: $to<BR>" if $debug;
	print "from: $from<BR>" if $debug;
	print "subject: $subject<BR>" if $debug;
   
    if (!$to) {  &error("SMTP Error: No To address - $_");}

    my ($proto, $port, $smptaddr);

    my ($AF_INET)     =  2;
    my ($SOCK_STREAM) =  1;

    $proto = (getprotobyname('tcp'))[2];
    $port  = 25;
	
	print "proto: $proto<BR>" if $debug;
	print "smtp: $smtpaddr<BR>" if $debug;

    $smtpaddr = ($smtp_addr =~ /^(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})$/)
                    ? pack('C4',$1,$2,$3,$4)
                    : (gethostbyname($smtp_addr))[4];

    if (!defined($smtpaddr)) {  &error("SMTP Error: invalid mail server - $_"); }
	print "smtp: $smtpaddr<BR>" if $debug;
    if (!socket(S, $AF_INET, $SOCK_STREAM, $proto))             {  &error("SMTP Error: connection failed. - $_"); }
    if (!connect(S, pack('Sna4x8', $AF_INET, $port, $smtpaddr))) {  &error("SMTP Error: connection failed.. - $_"); }

    select(S);
    $| = 1;
    select(STDOUT);

    $_ = <S>; if (/^[45]/) { close S;  &error("SMTP Error: connection failed...  - $_");}
	print "$_<BR>" if $debug;
    print S "helo localhost\r\n";
    $_ = <S>; if (/^[45]/) { close S;  &error("SMTP Error: helo localhost failed - $_");}
	print "helo localhost: $_<BR>" if $debug;
    print S "mail from: $from\r\n";
    $_ = <S>; if (/^[45]/) { close S;  &error("SMTP Error: mail from failed: - $_"); }
	print "mail from: $from $_<BR>" if $debug; 
    print S "rcpt to: $to\r\n";
    $_ = <S>; if (/^[45]/) { close S;  &error("SMTP Error: rcpt to failed - $_");}
	print "rcprt to: $to $_<BR>" if $debug;    

    print S "data\r\n";
    $_ = <S>; if (/^[45]/) { close S;  &error("SMTP Error: Message send failed - $_"); }
	print "data: $_<BR>" if $debug;

    print S "Content-Type: text/plain; charset=us-ascii\r\n";
    print S "To: $to\r\n";
    print S "From: $from\r\n";
    print S "Reply-to: $replyaddr\r\n" if $replyaddr;
    print S "Subject: $subject\r\n\r\n";
    print S "$message";
    print S "\r\n.\r\n";

    $_ = <S>; if (/^[45]/) { close S; &error("SMTP Error: end of message - $_"); }
	print "End message: $_<BR>" if $debug;
    print S "quit\r\n";
    $_ = <S>;
	print "quit: $_<BR>" if $debug;
    close S;
}
else {
	open(MAIL, "|$mail_prog -t") || &error("Could not send out emails");
	print MAIL "To: $recipient \n";
	print MAIL "From: $your_email \n";
	print MAIL "Subject: $subject \n\n";
	print MAIL $message;
	print MAIL "\n\n";
	close (MAIL);
}
} 


########## CGI HEADER ##########
sub Header {

	print "<HTML><HEAD><TITLE>$free_name</TITLE></HEAD>\n";
	print "<body bgcolor=$over_bg text=$text_color link=$link_color alink=$link_color vlink=$link_color>\n";		open (HEAD, "$path/header.txt");
	@head = <HEAD>;
	close (HEAD);
	foreach $line (@head) {
			print "$line";
	}
	print "<br><BR><center>";
}

########## CGI FOOTER ##########
sub Footer {
         print HTML"</center>";
	open (HEAD, "$path/footer.txt");
	@foot = <HEAD>;
	close (HEAD);
			foreach $line (@foot) {
			print "$line";
		}
if ($credit) {
	print "<center><font size=$font_size><hr width=525 noshade size=1><a href=\"http://www.freedomain.com\">Community Builder</a> v$version<br>Created by <a href=\"http://www.freedomain.com\"> Scripts</a><br><br>";
	}
	print "</BODY></HTML>\n";
}

########## ERROR ##########
sub error {
$error = $_[0] ;
print <<EOF;

<table cellpadding=5 border=1 cellspacing=0 bgcolor=$table_bg>
<TR><TD><font face=$font_face size=$font_size color=$text_table>
<B>We are sorry, the system is down at the moment, please try again later<BR><BR>
Thank you<BR><BR><BR>
To help us correct this problem, please let <A HREF="mailto:$your_email">$your_email</A> of the error.<BR><BR>
Error: <I>$error -- $!</I><BR><BR></TD></TR></TABLE>
EOF
&Footer;
exit;
}