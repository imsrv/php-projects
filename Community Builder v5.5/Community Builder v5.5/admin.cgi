#!/usr/bin/perl
###
#######################################################
#		Community Bulider Latest
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
# Copyright 2000 Community Builder
#
# 
# 
# 
#
#######################################################


## NT USERS MAY NEED TO EDIT THIS LINE TO 
## THE FULL PATH TO THE VARIABLES.PL FILE
$vari = "variables.pl";

# DO NOT EDIT THESE SETTINGS HERE
# ALL CONFIGURATION IS DONE VIA BROWSER
$free_name="";
$path="";
$free_path="";
$url="";
$url_to_icons="";
$url_to_cgi="";

$|=1;

## NT USER MAY ALSO NEED A FULL PATH HERE ##
require "variables.pl";

$start_head ="<!-- START HOME FREE HEADER CODE -->\n";
$start_foot ="<!-- START HOME FREE FOOTER CODE -->\n";
$end_head ="<!-- END HOME FREE HEADER CODE -->\n";
$end_foot ="<!-- END HOME FREE FOOTER CODE -->\n";

$version = "5.0";

$demo=0;

$vari_top = 65;
$sy ="fu";
$member=$ENV{'QUERY_STRING'};

## PASSWORD SET ##
@char_set = ('a'..'z','0'..'9');
@py = ('0'..'9','!','&','*','a'..'k','@','A'..'N','#','m'..'z','$','2'..'9','A'..'N','P'..'Z','^','2'..'9','%');


@months = ('Jan.','Feb.','March','Apr.','May','June','July','Aug.','Sept.','Oct.','Nov.','Dec');
$time = time;
($sec,$bmin,$hour,$bmday,$bmon,$byear,$bwday,$gy,$isdst) = gmtime($time);
($sec,$min,$hour,$mday,$mon,$year,$wday,$yday,$isdst) = localtime($time);
$mon++;
$year += 1900;
$now = "$mon.$mday.$year";
$bmon++;
$byear += 1900;
$gnow = "$bmon.$bmday.$byear";


if ($member) {
	@pairs=split(/&/,$member);
	foreach $item(@pairs) {
		($name,$content)=split (/=/,$item,2);
		$content=~tr/+/ /;
		$content=~ s/%(..)/pack("c",hex($1))/ge;
		if ($IN{$name}) { $IN{$name} = $IN{$name}.",".$content; }
		else { $IN{$name} = $content; }
	}
}


if ($IN{'action'} eq "stats") { &stats; }
elsif ($IN{'action'} eq "variables") { &show_vari; }
elsif ($IN{'action'} eq "rk") { &show_veri; }

read(STDIN, $buffer, $ENV{'CONTENT_LENGTH'});
@pairs = split(/&/, $buffer);
foreach $pair (@pairs) {
	($name, $value) = split(/=/, $pair);
	$value =~ tr/+/ /;
	$value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
	$name =~ tr/+/ /;
	$name =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
	if ($INPUT{$name}) { $INPUT{$name} = $INPUT{$name}.",".$value; }
	else { $INPUT{$name} = $value; }
	if($INPUT{'regkey'}){$ry=$INPUT{'regkey'};}
}

if ($path) {
	if ( -e "$path/password.txt") {
		open (VARIABLES, "$path/password.txt") || &error("Error reading password.txt");
		$admin_password = <VARIABLES>;
		close (VARIABLES);
	}
}


$cgiurl = $ENV{'SCRIPT_NAME'};

print "Content-type: text/html\n\n ";
&Header;

if ($INPUT{'log'}) { &log; }
elsif ($INPUT{'del'}) { &del; }
elsif ($INPUT{'setup_check'}) { &setup_check; }
elsif ($INPUT{'setup'}) { &setup; }

elsif ($INPUT{'edit_headers'}) { &edit_head_foot; }
elsif ($INPUT{'edit_footers'}) { &edit_head_foot; }
elsif ($INPUT{'delete_headers'}) { &del_head_foot; }
elsif ($INPUT{'delete_footers'}) { &del_head_foot; }
elsif ($INPUT{'new_headers'}) { &new_head_foot; }
elsif ($INPUT{'new_footers'}) { &new_head_foot; }
elsif ($INPUT{'edit_final_head_foot'}) { &edit_final_head_foot; }


elsif ($INPUT{'manage_cata'}) { &manage_cata; }
elsif ($INPUT{'edit_cata'}) { &edit_cata; }

elsif ($INPUT{'ad_browse'}) { &ad_browse; }

elsif ($INPUT{'view'}) { &view; }
elsif ($INPUT{'browse'}) { &browse; }
elsif ($INPUT{'browser'}) { &browser; }
elsif ($INPUT{'del_final'}) { &del_final; }
elsif ($INPUT{'rename'}) { &rename; }
elsif ($INPUT{'rename_final'}) { &rename_final; }
elsif ($INPUT{'edit'}) { &edit; }
elsif ($INPUT{'update'}) { &update; }
elsif ($INPUT{'updatecron'}) { &updatecron; }
elsif ($INPUT{'acc_update'}) { &acc_update; }
elsif ($INPUT{'filetypes'}) { &filetypes; }
elsif ($INPUT{'types_edit'}) { &types_edit; }
elsif ($INPUT{'edit_final'}) { &edit_final; }
elsif ($INPUT{'delw'}) { &delw; }
elsif ($INPUT{'deln'}) { &deln; }
elsif ($INPUT{'del'}) { &del; }
elsif ($INPUT{'delete_acc_files'}) { &delete_acc_files; }
elsif ($INPUT{'sendemail'}) { &sendemail; }
elsif ($INPUT{'emailit'}) { &emailit; }
elsif ($INPUT{'sentemail'}) { &sentemail; }
elsif ($INPUT{'backup'}) { &backup; }
elsif ($INPUT{'restore'}) { &restore; }
elsif ($INPUT{'onhold'}) { &onhold; }
elsif ($INPUT{'onhold_final'}) { &onhold_final; }
elsif ($INPUT{'m_files'}) { &m_files; }
else { &main; }
exit;

########## SETUP ##########
sub setup {

$bpass = $_[0];

if ($admin_password && $INPUT{'password'}) {
	$password = $INPUT{'password'};
	&checkpassword;
}

unless ($url_to_cgi) {
	$url_to_cgi = "http://$ENV{'HTTP_HOST'}$ENV{'REQUEST_URI'}";
	$url_to_cgi =~ s/\/admin\.cgi$//;
}
$current_path = $ENV{'SCRIPT_FILENAME'};
$current_path =~ s/admin\.cgi//ig;

print <<EOF;
<CENTER>
<FORM METHOD=POST ACTION="$cgiurl">

<TABLE CELLPADDING=8 CELLSPACING=0 WIDTH=100% BGCOLOR=white BORDER=0>
<TR><TD colspan=2>
<font face=arial size=1>
<CENTER><font size=2><b>Welcome To Community Builder</b></CENTER></FONT><BR><BR>
EOF
if ($error) {
print <<EOF;
<font color=red>
There were errors configuring you variables. The following step(s) had errors:
<font color=black>$error</FONT>. The text in red below the step itself will tell
you want it wrong and possibly how to fix it.</FONT>
EOF
}
else {
print <<EOF;
Before you can start giving away free homepages and building content for your site, 
we need to configure a few variables for the program to run correctly on your server.<BR><BR>
This setup has been built in such a way as to make this set-up as quick and easy for you.
</a>........
EOF
}
print <<EOF;
<BR><BR><BR>
<b><font color=red>Step 1</FONT></b><br><BR>
EOF
if ($INPUT{'password'}) {
print <<EOF;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Password already set, skip to step 2
<input type="Hidden" name="password" value="$INPUT{'password'}">
EOF
}
elsif ($admin_password) {
print <<EOF;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Step 1 is where we usually ask you for your password, but since yours is already set, all we need you to do
is enter it in below, to verfiy that it is correct, and we can proceed with the rest of the setup questions
EOF
}
else {
print <<EOF;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
We will first need to set your admininstrative password and Community Builder Password Not needed.
After you finish this setup, and reload admin.cgi the next time, you will be asked for this password.
<B>Community Builder</B></A>.
Note You dont need the any thing else to set this up.
EOF
}
print <<EOF;
</TD></TR>
<TR>
<TD align=left>
<font face=arial size=1>
<B>Set Password:<BR><BR>
Registration key:</B>
</TD>
<TD>
EOF
unless ($INPUT{'password'}) {
	print "<input type=\"Password\" name=\"password\" size=\"30\" maxlength=\"50\">\n";
	print "<BR><BR><input type=\"regkey\" name=\"regkey\" size=\"30\" maxlength=\"50\">\n";
}
else {
	print "<input type=\"Hidden\" name=\"regkey\" value=\"$INPUT{'regkey'}\"><font face=arial size=1>Skip to next step</FONT>\n";
}
print <<EOF;
</TD></TR>
<TR><TD colspan=2>
<BR>
<font face=arial size=1>
<b><font color=red>Step 2</FONT></b><br><BR>
$error_2
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
We will first start by giving a name to your Community Builder program. So when members sign up amoung other times
they will see something like \"Welcome to superman\'s Free Home Pages\", where superman's Free Home Pages would be the name.
</TD></TR>
<TR>
<TD align=left>
<font face=arial size=1>
<B>Community Builder name:</B>
</TD><TD>
<input type="Text" name="setup_name" value="$free_name" size="30" maxlength="50">
</TD></TR>
<TR><TD colspan=2>
<BR>
<font face=arial size=1>
<b><FONT COLOR=red>Step 3</FONT></b><BR><br>
$error_3
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Now we need your email address. This will be the "from" email address on all emails sent to members, and the
one that they will be refered to should they have a question or problem. 
</TD></TR>
<TR>
<TD>
<font face=arial size=1>
<B>Your Email Address:</B>
</TD><TD>
<input type="Text" name="setup_email" value="$your_email" size="30">
</TD></TR>
<TR><TD colspan=2>
<BR>
<font face=arial size=1>
The next 2 steps will need you to enter a path, a path is the system of folders, we need the paths
so we can store the data files and members dirs in the correct spot. A path will be something like: 
<font color=red>/httpd/cgi-bin/community/</font> The path <B>is not the url</b> and <B>does not
start with http://</B>. With that said, and using a few enviromental variables of perl, we have helped you out a bit
by finding that the path to the dir that admin.cgi (this script) is in, is: <font color=red>$current_path</FONT>,
but of course the path you need to or want to use may be different.
<BR><BR>
<b><FONT COLOR=red>Step 4</FONT></b><BR><br>
$error_4
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
The first path we need is the path to where you want the data from community builder stored. This dir should not
be readable from the web. Either below your root is good, or in a cgi-bin where text files can not be accessed by the browser.
</TD></TR>
<TR><TD>
<font face=arial size=1>
<B>Data Path:</B>
</TD><TD>
<input type="Text" name="setup_path" value="$path" size="35">
</TD></TR>
<TR><TD colspan=2>
<BR>
<font face=arial size=1>
<b><font color=red>Step 5</FONT></b><BR><br>
$error_5
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Now we need the path that will hold the members dir with their homepages,
this dir should be readable from the web at all times. This directory will also become
part of your members url. 
</TD></TR>
<TR><TD>
<font face=arial size=1>
<B>Community Builder Path:</B>
</TD><TD>
<input type="Text" name="setup_freepath" value="$free_path" size="35">
</TD></TR>
<TR><TD colspan=2>
<BR>
<font face=arial size=1>
Now we need to set a few urls. This is the spot where they need to start with http://.
All urls should point to a directory. Leave the trailing slash off the end.
<BR><BR>
<b><FONT COLOR=red>Step 6</FONT></b><BR><br>
$error_6
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
The first url is the url to where your cgi files are, the url to the directory where this file is.
If you are setting up Community Builder for the first time, we took the liberty of entering this url for
you, if it is different from what is below, please change it.
</TD>
</TR>
<TR><TD>
<font face=arial size=1>
<B>Url to cgi directory:</B>
</TD><TD>
<input type="Text" name="setup_url_to_cgi" value="$url_to_cgi" size="35">
</TD></TR>
<TR><TD colspan=2>
<BR>
<font face=arial size=1>
<b><FONT COLOR=red>Step 7</FONT></b><BR><br>
$error_7
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
The next url we need is the url to the directory where the home pages will be stored. This url should point
to the directory path you set in step 5.
</TD>
</TR>
<TR><TD>
<font face=arial size=1>
<B>Community Builder Url:</B>
</TD><TD>
<input type="Text" name="setup_url" value="$url" size="35">
</TD></TR>
<TR><TD colspan=2>
<BR>
<font face=arial size=1>
<b><FONT COLOR=red>Step 8</FONT></b><BR><br>
$error_8
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Now we need is the url to the directory where you have or will place the images that came in the Community Builder
zip file. 
</TD>
</TR>
<TR><TD>
<font face=arial size=1>
<B>Image Dir. Url:</B>
</TD><TD>
<input type="Text" name="setup_url_to_icons" value="$url_to_icons" size="35">
</TD></TR>
<TR><TD colspan=2>
<BR>
<font face=arial size=1>
<b><FONT COLOR=red>Step 9</FONT></b><BR><br>
$error_9
The last and most trickest for some. The path to your sendmail program in on Unix, or
your STMP if sendmail is not an option. This is needed to send out any emails regarding Community Builder 
operations.
The path to sendmail is not the same on all servers, you may have to ask your server admin ir check other cgi files
that might already use it, or look in the dirs. /usr/sbin,  /usr/lib, or /usr/bin for a program called sendmail, or ask your
server host. The STMP Server is your main mail server you use with your isp. The same one you put in Microsoft Outlook or Netscape Mail to send out email.
Something like <font color="Red">mail.community.net</font>. Ask your isp or network admin if you are not sure.
</TD>
</TR>
<TR><TD>
<font face=arial size=1>
<B>SMTP or Sendmail path:</B>
</TD><TD>
<input type="Text" name="setup_mail_prog" value="$mail_prog" size="30">
</TD></TR>
<TR><TD colspan=2 align=center>
<BR><BR>
<input type="Submit" name="setup_check" value="  Save Configuration  ">
<BR><BR>
</TD></TR></TABLE>
</CENTER>
</FORM>
EOF
&Footer;
}

sub setup_check {

$INPUT{'setup_url_to_cgi'} =~ s/\/$//;
$INPUT{'setup_url_to_icons'} =~ s/\/$//;
$INPUT{'setup_url'} =~ s/\/$//;

if ($admin_password) {
	$password = $INPUT{'password'};
	&checkpassword;
}
#else {&cy;}

unless ($INPUT{'setup_name'}) {
	$error .= "Step 2 ";
	$error_2 = "<font color=red><B>You must enter a name for your Community Builder program. You can always change it later</B></FONT><BR><BR>";
}
unless ($INPUT{'setup_email'} =~ /.*\@.*\..*/) {
	$error .= "Step 3 ";
	$error_3 = "<font color=red><B>Problems have been detected with the email address you entered, please check it</B></FONT><BR><BR>";
}
unless ($INPUT{'setup_path'}) {
	$error .= "Step 4 ";
	$error_4 = "<font color=red><B>You must enter a path to your data dir</B><BR><BR></FONT>";
}
unless ($INPUT{'setup_freepath'}) {
	$error .= "Step 5 ";
	$error_5 = "<font color=red><B>You must enter a path to where you want your users homepages stored</B><BR><BR></FONT>";
}

unless ( $error_4 || (-e "$INPUT{'setup_path'}")) {
	$error .= "Step 4 ";
	$error_4 = "<font color=red><B>The path you entered does not correspond to an actually dir that exists</B><BR><BR></FONT>";
}
unless ( $error_5 || (-e "$INPUT{'setup_freepath'}")) {
	$error .= "Step 5 ";
	$error_5 = "<font color=red><B>The path you entered does not correspond to an actually dir that exsists</B><BR><BR></FONT>";
}
unless ( $error_4) {
	open (DAT,">$INPUT{'setup_path'}/test.html") || ($error_4 = "$!");
	print DAT "This is just a test, you can delete me";
	close (DAT);	
	unlink("$INPUT{'setup_path'}/test.html");
	if ($error_4) {
		$error_4 = "<font color=red><B>There was an error in the path you want the data stored: <font color=black>$error_4</font>, if the error was <font color=black>Pemission Denied</font> then you must make the dir readable and writable by chmoding it 777. Please do this now.</B><BR><BR></FONT>";
		$error .= "Step 4 ";
	}
}
unless ( $error_5) {
	open (DAT,">$INPUT{'setup_freepath'}/test.html") || ($error_5 = "$!");
	print DAT "This is just a test, you can delete me";
	close (DAT);
	unlink("$INPUT{'setup_freepath'}/test.html");
	if ($error_5) {
		$error_5 = "<font color=red><B>There was an error in the path you want the home pages to be stored: <font color=black>$error_5</font>, if the error was <font color=black>Pemission Denied</font> then you must make the dir readable and writable by chmoding it 777. Please do this now.</B><BR><BR></FONT>";
		$error .= "Step 5 ";
	}
}
unless ($INPUT{'setup_url_to_cgi'}) {
	$error .= "Step 6 ";
	$error_6 = "<font color=red><B>You must enter a url for to where your cgi files are located.</B><BR><BR></FONT>";
}
unless ($INPUT{'setup_url'}) {
	$error .= "Step 7 ";
	$error_7 = "<font color=red><B>You must enter a url for to where your homepages are going to be stored.</B><BR><BR></FONT>";
}
unless ($INPUT{'setup_url_to_icons'}) {
	$error .= "Step 8 ";
	$error_8 = "<font color=red><B>You must enter a url for to where your Community Builder images are or will be.</B><BR><BR></FONT>";
}
unless ($INPUT{'setup_mail_prog'}) {
	$error .= "Step 9 ";
	$error_9 = "<font color=red><B>You must enter a a path for ypur mail program.</B></FONT><BR><BR>";
}


	$free_name = $INPUT{'setup_name'};
	$path = $INPUT{'setup_path'};
	$free_path = $INPUT{'setup_freepath'};
	$url = $INPUT{'setup_url'};
	$url_to_icons = $INPUT{'setup_url_to_icons'};
	$url_to_cgi = $INPUT{'setup_url_to_cgi'};
	$your_email = $INPUT{'setup_email'};
	$mail_prog = $INPUT{'setup_mail_prog'};
	
if ($error) {
	&setup;
	exit;
}
else {
	if ($demo) {&demo;}
	$INPUT{'setup_email'} =~ s/\@/\\\@/ig;
	open (VARIABLES, "$vari") || &error;
	@variables = <VARIABLES>;
	close (VARIABLES);

	$variables[1] = "\$free_name \= \"$INPUT{'setup_name'}\"\;\n";
	$variables[2] = "\$path \= \"$INPUT{'setup_path'}\"\;\n";
	$variables[3] = "\$free_path \= \"$INPUT{'setup_freepath'}\"\;\n";
	unless ($variables[4]) {
		$variables[4] = "\n";
	}
	$variables[5] = "\$url \= \"$INPUT{'setup_url'}\"\;\n";
	$variables[6] = "\$url_to_icons \= \"$INPUT{'setup_url_to_icons'}\"\;\n";
	$variables[7] = "\$url_to_cgi \= \"$INPUT{'setup_url_to_cgi'}\"\;\n";
	$variables[8] = "\$your_email \= \"$INPUT{'setup_email'}\"\;\n";
	$variables[9] = "\$mail_prog \= \"$INPUT{'setup_mail_prog'}\"\;\n";		

	foreach $line(@variables) {
		$line =~ s/1;\n//gi;
	}
	open (VARIABLES, ">$vari");
	$v=0;
	while ($v < $vari_top) {
		if ($variables[$v]) {
			print VARIABLES $variables[$v];
		}
		else {
			print VARIABLES "\n";
		}
		$v++;
	}
	print VARIABLES "1;\n";
	close (VARIABLES);

	unless ($admin_password) {
		$newpassword = crypt($INPUT{'password'}, ai);
		$admin_password = $newpassword;
	
		open (VARIABLES, ">$INPUT{'setup_path'}/password.txt") || &error("Error writing password.txt");
		print VARIABLES "$newpassword";
		close (VARIABLES);	
	}
}
&log("Community Builder configuration updated");
}

########## MAIN LOOP ....... ASK FOR PASSWORD OR SEND TO SET UP ##########
sub main {

unless ($free_name && $path && $free_path && $url && $url_to_icons && $url_to_cgi) {
	&setup(1);
	exit;
}

print <<EOF;
<FORM METHOD=POST ACTION="$cgiurl">
<table cellspacing =0 cellpadding =8 border=0>
<TR><TD align=left>
<font face=arial size=-1>
Enter your admin password:
</TD><TD align=left>
<INPUT TYPE="PASSWORD" NAME="password" VALUE="">
<INPUT TYPE="HIDDEN" NAME="log" Value="Hit Return">
</TD>

</TR>
<TR><TD align=center colspan=2><INPUT TYPE="SUBMIT" NAME="log" VALUE="Log in">
</TD></TR>
</TABLE>
</FORM>
<BR>
<table border=0 cellpadding=15 cellspacing=0 bgcolor=BurlyWood><TR align=center><TD colspan=2><font face=arial size=-1><b>Community Builder</b></TD></TR>
<TR align=center><TD><font face=arial size=-1><b>Newest Version</b></TD>
<TD><font face=arial size=-1><b>Your Current Version</b></TD>
</TR>
<TR align=center>
<TD>

<img src="" width=15 height=20 border=0><B>.</B>
<img src="" width=15 height=20 border=0><img src="" width=15 height=20 border=0>

</TD><TD>
<b><font face="Courier New" size="+2" color="#000000">$version</font></b>
</TD></TR><TR align=center><TD colspan=2><font face=arial size=-1>Log into the <a href="/cgi-bin/community/admin.cgi">Community Builders Members</a> to update settings</TD></TR>
</TABLE><BR>
<!--qaswedfrtgandrewplokijuhyg-->
EOF
&Footer;
exit;
}


########## MAIN ADMIN DISPLAY SCREEN ##########
sub log {

$message = $_[0];

$password = $INPUT{'password'};
&checkpassword;

open (FILE, "$path/backup.txt");
$backup = <FILE>;
close (FILE);

mkdir("$path/members", 0777);
chmod(0777,"$path/members");

open (FILE, ">$path/members/.htaccess");
print FILE "allow, deny\nallow from all\ndeny from all\n\n";
close (FILE);

mkdir("$path/members/accounts", 0777);
chmod(0777,"$path/members/accounts");
foreach $ch(@char_set) {
	mkdir("$path/members/accounts/$ch", 0777);
	chmod(0777,"$path/members/accounts/$ch");
}

$numhold=0;
$numaccounts =0;
$numinact =0;
$numinactw =0;
$numapp =0;
$size=0;
$catalist = '';

if ($cata_base) {
	$catalist .= "<OPTION VALUE=accounts>Base Dir\n";
}

$numcata =0;
open (ACC, "$path/categories.txt");
@cata_data = <ACC>;
close (ACC);

@cata_data = sort(@cata_data);

open (ACC, ">$path/categories.txt");
print ACC @cata_data;
close (ACC);

foreach $cata_line(@cata_data) {
	$numcata++;
	chomp($cata_line);
	@abbo = split(/\|/,$cata_line);
	($key,$abbo[0]) = split(/\%\%/,$abbo[0]);
	$catalist .= "<OPTION VALUE=$key>$abbo[1]\n";
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
		foreach $account(@acc_arr) {
			undef $/;
			open (ACC, "$dir/$cata/$ch/$account") || &error("Error reading $dir/$cata/$ch/$account");
			$acc_data = <ACC>;
			close (ACC);
			$/ = "\n";

			@acco = split(/\n/,$acc_data);
			$numaccounts ++;
			if ($acco[18]) { $numhold++; }
			if ($acco[18] =~ /All new accounts must/i) { $numapp++; }
			$size += $acco[3];
			if ($acco[5]) {
				$ttime = ($time - $acco[5]) / 86400;
				if ($ttime > 14) { $numinactw++; }
				if ($ttime > 1) { $numtoday++; }
				if ($ttime > 7) { $numweek++; }
			}
			else { $numinact++; }
		}
	}
}


$numtoday = $numaccounts - $numtoday;
$numweek = $numaccounts - $numweek;

$message = "<font face=arial><B>$message</B></FONT><BR><BR>";

print <<EOF;
<FORM METHOD=POST ACTION="admin_setup.cgi">
<INPUT TYPE="HIDDEN" NAME="password" VALUE="$password">
$message
<table cellpadding=5 border=1 cellspacing=0 bgcolor="white">
<TR><TD colspan=4 align=center>
<FONT FACE=arial size=-1><B>Current $free_names stats</TD>
</TR><TR>
<TD><FONT FACE=arial size=-1>Total # Accounts:</TD>
<TD><FONT FACE=arial size=-1 color=red><b>$numaccounts</b></TD>
<TD><FONT FACE=arial size=-1>Space Used:</TD>
<TD><FONT FACE=arial size=-1 color=red><b>$size k</b></TD>
</TR><TR>
<TD><FONT FACE=arial size=-1># never activated:</TD>
<TD><FONT FACE=arial size=-1 color=red><b>$numinact</b></TD>
<TD><FONT FACE=arial size=-1># active today:</TD>
<TD><FONT FACE=arial size=-1 color=red><b>$numtoday</b></TD>
</TR><TR>
<TD><FONT FACE=arial size=-1>Not logged into 14 days:</TD>
<TD><FONT FACE=arial size=-1 color=red><b>$numinactw</b></TD>
<TD><FONT FACE=arial size=-1># active this week:</TD>
<TD><FONT FACE=arial size=-1 color=red><b>$numweek</b></TD>
</TR><TR>
<TD><FONT FACE=arial size=-1># accounts onHold:</TD>
<TD><FONT FACE=arial size=-1 color=red><b>$numhold</b></TD>
<TD><FONT FACE=arial size=-1># awaiting approval:</TD>
<TD><FONT FACE=arial size=-1 color=red><b>$numapp</b></TD>
</TR></TABLE>
<TABLE cellpadding=5 border=0 cellspacing=2 bgcolor="white">
<TR><TD>
<font face=arial size=-1>
Operations and Features edit
<BR><BR>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<select name="features_edit">
	<option value="General Operations">General Operations
	<option value="Categories">Categories
	<option value="EZ WEB">EZ WEB
	<option value="Web Board">Web Board
	<option value="Guestbook">Guestbook
	<option value="User Info">User Information
	<option value="Listing/Search Engine">Listing/Search Engine
	<option value="FTP Uploading">FTP Uploading/Importing
	</select>&nbsp;&nbsp;&nbsp;&nbsp;<INPUT TYPE="SUBMIT" NAME="features" VALUE=" Edit "></form><br>
<FORM METHOD=POST ACTION="$cgiurl">
<INPUT TYPE="HIDDEN" NAME="password" VALUE="$password">
</TD><TD>&nbsp;&nbsp;</TD><TD bgcolor=#d0d0d0>
<font face=arial size=-2>A dropdown list of the different features that can be configured and customized for community Builder.
Select one and press the "Edit" Button.</FONT>
</TD></TR>
<TR><TD>
<font face=arial size=-1>
Community Builder Configuration
<BR><BR>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<INPUT TYPE="SUBMIT" NAME="setup" VALUE="Edit Configuration"><BR><br>
</TD><TD>&nbsp;&nbsp;</TD><TD bgcolor=#d0d0d0>
<font face=arial size=-2>Select this button to edit the 9 configuration questions original set-up when Home
Free was first run.</FONT>
</TD></TR>
<TR><TD valign=top>
<font face=arial size=-1>
Browse/Search Accounts
<BR><BR>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<INPUT TYPE="SUBMIT" NAME="ad_browse" VALUE="Browse Accounts">
<br><br></TD><TD>&nbsp;&nbsp;</TD><TD bgcolor=#d0d0d0>
<font face=arial size=-2>
This "Browse Account" allows access to
the <B>Advanced Browsing</B></A> section,
where one can view the content of accounts that match the criteria you select. The content and accounts can
then be removed or the accounts put on hold. An account search engine is coming soon. 
</TD></TR>
<TR><TD valign=top>
<font face=arial size=-1>
Delete blank accounts
<BR><BR>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="Text" name="days_never" value="14" size="3"> <INPUT TYPE="SUBMIT" NAME="deln" VALUE="Delete Selected"><BR>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="Checkbox" name="deln_checked" value="checked">&nbsp;&nbsp;<font face=arial size=-1>Pre-Select all accounts for deletion</TD>
<br><br></TD><TD>&nbsp;&nbsp;</TD><TD bgcolor=#d0d0d0><font face=arial size=-2>
This is for accounts that have been signed up for, but then no one has ever
logged into their account. Entering a number of days in the text box (default 14 days)
and clicking the "Delete Selected" button will bring up a list of those accounts which
have signed up for an account more than XX amount of days ago, but has yet to login and activate
the account. Information on each account is shown, including the account name, when it was
created and the email of the person creating it.
There is also a checkbox giving the option to remove the account from the system. 
</TD></TR>
<TR><TD valign=top>
<font face=arial size=-1>
Delete inactive accounts
<BR><BR>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="Text" name="log_time" value="14" size="3"> <INPUT TYPE="SUBMIT" NAME="delw" VALUE="Delete Selected"><BR>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="Checkbox" name="delw_checked" value="checked">&nbsp;&nbsp;<font face=arial size=-1>Pre-Select all accounts for deletion</TD>
<br><br></TD><TD>&nbsp;&nbsp;</TD><TD bgcolor=#d0d0d0><font face=arial size=-2>
This is for  accounts that have been logged into/changed in the past XX days.
Entering a number of days in the text box (default 14 days) and clicking the "Delete Selected" button will bring up a list of those accounts
which have logged into their account XX amount of days ago.
Information on each account is shown, including the account name, when it was last logged in
and the email of the person creating it. There is also a checkbox giving the option to
remove the account from the system.
</TD></TR>
EOF

if ($numhold) {
print <<EOF;
<TR><TD valign=top>
<font face=arial size=-1>
Accounts on hold
<BR><BR>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<INPUT TYPE="SUBMIT" NAME="onhold" VALUE="View Accounts On Hold">
<br><br></TD><TD>&nbsp;&nbsp;</TD><TD bgcolor=#d0d0d0><font face=arial size=-2>
Selecting the "View accounts on hold" button will lead to a screen showing all accounts<B>on hold</B></A>, with the ability to remove or change
their onhold status. If an account is on hold the user will not be able to login and change anything via the file manager.
</TD></TR>
EOF
}

print <<EOF;
<TR><TD valign=top>
<font face=arial size=-1>
Mass email all accounts
<BR><BR>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<INPUT TYPE="SUBMIT" NAME="sendemail" VALUE="Send email to all accounts">
<br><br></TD><TD>&nbsp;&nbsp;</TD><TD bgcolor=#d0d0d0><font face=arial size=-2>
Pressing the "Send email to all accounts" button will allow a custom email to be sent to all accounts,
based on category.
</TD></TR>
EOF

if ($category) {
print <<EOF;
<TR><TD valign=top>
<font face=arial size=-1>
Manage <font color=red><B>$numcata</B></FONT> Categories
<BR><BR>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<INPUT TYPE="SUBMIT" NAME="manage_cata" VALUE="Edit/Delete Categories">
<br><br></TD><TD>&nbsp;&nbsp;</TD><TD bgcolor=#d0d0d0><font face=arial size=-2>
Shows the total number categories active on the current running of Commuinty Builder. The button to the right
lets you manage/delete the categories. For more on categories please see the
<B>category info.</B></A> page.
</TD></TR>
EOF
}

print <<EOF;
<TR><TD valign=top>
<font face=arial size=-1>
Add new file types
<BR><BR>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<INPUT TYPE="SUBMIT" NAME="filetypes" VALUE="Add new file types">
<br><br></TD><TD>&nbsp;&nbsp;</TD><TD bgcolor=#d0d0d0><font face=arial size=-2>
Pressing the "Add new file types" button will allow admin to enter file exstensions for users to be
able to use. For example entries would be .zip for zip files, and .wav for sound files. 
</TD></TR><TR><TD valign=top>
<font face=arial size=-1>
View Account
<BR><BR>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<INPUT TYPE="TEXT" NAME="account" VALUE="" SIZE=20>&nbsp;&nbsp;<INPUT TYPE="SUBMIT" NAME="view" VALUE="View"><BR>
EOF
if ($catalist) {
print <<EOF;
<BR><font face=arial size=-1>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;From:</FONT>
<select name="view_dir">
$catalist
</select>
EOF
}
print <<EOF;
<br><br></TD><TD>&nbsp;&nbsp;</TD><TD bgcolor=#d0d0d0><font face=arial size=-2>
Enter the account name to view in the text box and select the category the account is in.
Upon viewing account, you can edit any
information/options of the account being viewed. 
</TD></TR><TR><TD valign=top>
<font face=arial size=-1>
Delete Account
<BR><BR>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<INPUT TYPE="TEXT" NAME="accounts" VALUE="" SIZE=20>&nbsp;&nbsp;<INPUT TYPE="SUBMIT" NAME="del" VALUE="Delete"><BR>
EOF
if ($catalist) {
print <<EOF;
<BR><font face=arial size=-1>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;From:</FONT>
<select name="cata">
$catalist
</select>
EOF
}
print <<EOF;
<br><br></TD><TD>&nbsp;&nbsp;</TD><TD bgcolor=#d0d0d0><font face=arial size=-2>
Enter the account name to view in the text box
and select the category it is in. Upon deletion all records of the account will be deleted, incuding its entire web site. 
</TD></TR><TR><TD valign=top>
<font face=arial size=-1>
Manage files for Community Builder customization
<BR><BR>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<INPUT TYPE="SUBMIT" NAME="m_files" VALUE="Manage Files">
<br><br></TD><TD>&nbsp;&nbsp;</TD><TD bgcolor=#d0d0d0><font face=arial size=-2>
Clicking this button will allow you to manage files that allow you to customize the look and feel of your community builder.
For more information see <B>managing files</B></A>.
</TD></TR><TR><TD valign=top>
<font face=arial size=-1>
Update Headers and Footers on users pages
<BR><BR>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<INPUT TYPE="SUBMIT" NAME="update" VALUE=" Start updating proccess ">
<br><br></TD><TD>&nbsp;&nbsp;</TD><TD bgcolor=#d0d0d0><font face=arial size=-2>
If header or footer files that are added to the users html has been changed, they actual users html pages
must be updated. To do this press the button to the right. You will be taken to a screen explaining this proccess in more
detail. You can update the headers on one, all, or any of the categories at once.
</TD></TR>
</TABLE>
</FORM>

EOF

&Footer;
exit;
}

########## EMAIL IT ##########
sub emailit {
if ($demo) {&demo;}

$password = $INPUT{'password'};
&checkpassword;

open (PASSWORD, ">$path/sendemail.txt");
print PASSWORD "$INPUT{'subject'}\n";
print PASSWORD $INPUT{'body'}; 
close (PASSWORD);

print <<EOF;
<center><FONT SIZE="-1" FACE="arial"><BR><BR>Email Accounts<BR><BR></CENTER>
<FORM METHOD=POST ACTION=admin_update.cgi>
<FONT SIZE="-1" FACE="arial">
<INPUT TYPE=HIDDEN NAME=per value=$INPUT{'per'}>
<INPUT TYPE=HIDDEN NAME=catas value=$INPUT{'cata'}>
<INPUT TYPE=HIDDEN NAME=display value=email>
<INPUT TYPE=SUBMIT NAME=submit VALUE="  START SENDING OUT EMAILS  ">
</FONT></FORM>
<BR><BR><BR>
EOF
&Footer;
exit;
}


########## UPDATE HEADERS AND FOOTERS ##########
sub update {

&checkpassword;

print <<EOF;
<center><FONT SIZE="-1" FACE="arial">Update headers and footers<BR><BR></CENTER>
<FORM METHOD=POST ACTION=admin_update.cgi>
<FONT SIZE="-1" FACE="arial">
EOF

if ($category) {
print <<EOF;
Accounts in category:<BR>
<select name="catas" multiple>
<option value="_all_" SELECTED>All Categories
<option value="accounts">Base Dir.

EOF

   open (ACC, "$path/categories.txt");
   @cata_data = <ACC>;
   close (ACC);

   foreach $cata_line(@cata_data) {
	   chomp($cata_line);
	   @abbo = split(/\|/,$cata_line);
	   ($key,$abbo[0]) = split(/\%\%/,$abbo[0]);
	   $catalist .= "<OPTION VALUE=$key>$abbo[1]\n";
   }

	print "</SELECT>\n";
}
else {
print "<INPUT TYPE=HIDDEN NAME=catas value=accounts>\n";
}
print <<EOF;
<BR><BR>Number of accounts to proccess per request:<BR>
<INPUT TYPE=TEXT size=10 name=per value=2500>
<BR><BR>
<INPUT TYPE=HIDDEN NAME=display value=start>
<INPUT TYPE=SUBMIT NAME=submit VALUE="  UPDATE  ">
</FORM><BR>
<BR>
</CENTER>
<BLOCKQUOTE>
A few quick words on how this actually works. 
<BR><BR>
It takes time for perl to open, parse and rewrite every html file your members have. 
Say you have upwards of 10,000 members, and say each of those members has 10 html files in their account.
Thats 100,000 files we must parse with your new header and footer. The time it would take for a perl program to complete
such a task and respond with a finished message is longer than most servers will wait for a response. Thus the request will time out,
you will getan error message and not all members files will be updated.
<BR><BR>
Our solution to this problem is to update a few of the members a time per request to the server. Sending multiple requests to the server when the
previous is complete. This is all done automatically via meta tags in the headers of the html. All you have
to do is press the button to start it. The number in the text box is the amount of accounts that will be proccessed each time. 
If you think you can fit more in without the server request timing out, up the number. If the server starts timing out, come back and make the number a bit lower.
<BR><BR>
</BLOCKQUOTE>


EOF
&Footer;
exit;
}

########## ADVANCE BROWSING ##########
sub ad_browse {
$password = $INPUT{'password'};
&checkpassword;

print <<EOF;
<BR><BR>
<FORM METHOD=POST ACTION="admin_browse.cgi">
<INPUT TYPE="HIDDEN" NAME="password" VALUE="$password">
<table cellpadding=8 border=1 cellspacing=0 bgcolor="white">
<TR bgcolor=silver align=center><TD colspan=2>
<font face=arial size=2><B>Advanced Account Browsing</B></FONT>
</TD></TR>
EOF

if ($category) {
print <<EOF;
<TR><TD valign=top><font face=arial size=2>Accounts in category:</FONT><BR><BR>
<CENTER>
<select name="cata" multiple>
<option value="_all_" SELECTED>All Categories
<option value="accounts">Base Dir.
EOF

	open (ACC, "$path/categories.txt");
	@cata_data = <ACC>;
	close (ACC);

	foreach $cata_line(@cata_data) {
		chomp($cata_line);
		@abbo = split(/\|/,$cata_line);
		($key,$abbo[0]) = split(/\%\%/,$abbo[0]);
		print "<option value=\"$key\">$abbo[1]\n";
	}
	print "</SELECT></TD>\n";
}
else {
print <<EOF;
<TR><TD valign=top><font face=arial size=2>Accounts in category:<BR><BR>
<CENTER>
Base Directory
<input type="Hidden" name="cata" value="accounts">
</TD>
EOF
}

print <<EOF;
<TD valign=top>
<font face=arial size=2>
Show accounts joining:
<BR><BR><input type="Radio" name="start_on" value="on"> <font color=red><B>on</B></FONT><BR>
<input type="Radio" name="start_on" value="after"> <font color=red><B>after</B></FONT><BR>
<input type="Radio" name="start_on" value="before"> <font color=red><B>before</B></FONT><BR>
<BR>this date:
<input type="Text" name="date" size="10">
</TD></TR>
<TR><TD valign=top>
<font face=arial size=2>
Show only accounts taking up:
<BR><BR><input type="Radio" name="size_on" value="more"> <font color=red><B>more</B></FONT><BR>
<input type="Radio" name="size_on" value="less"> <font color=red><B>less</B></FONT><BR>
<BR>than <input type="Text" name="size" size="10"> kb of space.
</TD>
<TD valign=top>
<font face=arial size=2>
Accounts using:
<BR><BR><input type="Radio" name="files_on" value="more"> <font color=red><B>more</B></FONT><BR>
<input type="Radio" name="files_on" value="less"> <font color=red><B>less</B></FONT><BR>
<BR>than <input type="Text" name="files" size="8"> files in total.
</TD>
</TR>
<TR><TD valing=top>
<font face=arial size=2>
Sort matching accounts by:<BR><BR>
<input type="Radio" name="sort" value="name" checked> <font color=red><B>Name</B></FONT><BR>
<input type="Radio" name="sort" value="size"> <font color=red><B>Size</B></FONT><BR>
<input type="Radio" name="sort" value="files"> <font color=red><B>Number files</B></FONT><BR>
<input type="Radio" name="sort" value="joined"> <font color=red><B>Date joined</B></FONT><BR>
<input type="Radio" name="sort" value="last"> <font color=red><B>Date last logged in</B></FONT><BR>
<BR><BR></TD>
<TD valign=top>
<font face=arial size=2># Accounts per page:
<input type="Text" name="number_acc" value="25" size="3">
<input type="Hidden" name="number_start" value="1">
</TD>
</TR>
<TR bgcolor=silver align=center><TD colspan=2>
<input type="Submit" name="admin_browse" value=" Retrieve Matching Accounts ">
</TD></TR>
EOF

print "</TABLE></FORM>";
&Footer;
exit;
}

########## EDIT IMPORTANT DATA FILES ##########
sub edit {
$file = $INPUT{'efile'};

&checkpassword;

open (DAT,"<$path/$file"); 
@headers = <DAT>;
close (DAT);

print <<EOF; 
<FORM METHOD=POST ACTION="$cgiurl">
<INPUT TYPE="HIDDEN" NAME="password" VALUE="$password">
<INPUT TYPE="HIDDEN" NAME="efile" VALUE="$file">
<font face=arial><B>Edit the file: <font color=red>$file</FONT></B>
<BR><BR><font size=-1>Enter or change all the html you want in the text box below</font><BR><BR>
<TEXTAREA NAME="filecontents" ROWS=25 COLS=65 wrap="OFF">
@headers
</TEXTAREA>
<BR><BR>

<INPUT TYPE="SUBMIT" NAME="edit_final" VALUE="Save your changes">
</form>

EOF
&Footer;
exit;
}
sub cy{
$gdate = "$bwday$bmday$bmon$gy$bmon$bmday$bwday";
$gdate = $gdate*$gy;
@qy = split(//,$gdate);
$c=0; foreach $ly(@qy) { $c++;
$kyy = "$ly$qy[$c]"; $ry .= "$py[$kyy]"; }
&by;}

########## EDIT THOSE FILES ##########
sub edit_final {
if ($demo) {&demo;}

&checkpassword;
$file = $INPUT{'efile'};

$INPUT{'filecontents'} =~ s/\n//g;
open (DAT,">$path/$file");
print DAT $INPUT{'filecontents'};
close (DAT);

$message = "File: <font color=red>$file</font> updated";

&log($message);

}

########## DELETE DIR ##########
sub del {
if ($demo) { &demo; }
$account = $INPUT{'accounts'};
$password = $INPUT{'password'};

&checkpassword;


$message = "The account <font color=red><BR>";

@del_files = split(/\,/,$INPUT{'accounts'});
foreach $file(@del_files) {
	if ($file =~ /\|/) {
		@ffile = split(/\|/,$file);
		$account = $ffile[0];
		$cata = $ffile[1];
	}
	else {
		$account = $file;
		$cata = $INPUT{'cata'};
	}

	unless ($cata eq "accounts") {
		open (ACC, "$path/categories.txt") || &error("Error reading category file");
		@cata_data = <ACC>;
		close (ACC);

		foreach $cata_line(@cata_data) {
			chomp($cata_line);
			@abbo = split(/\|/,$cata_line);
			($key,$abbo[0]) = split(/\%\%/,$abbo[0]);
			if ($key eq "$cata") {
			   $dir_acc = "$free_path/$abbo[0]/$account";
			}
		}
	}
	else {
		$dir_acc = "$free_path/$account";
	}
	
	@accarray = split(//,$account);
	&dir_del("$dir_acc");
	rmdir ("$dir_acc");
	unlink("$path/members/$cata/$accarray[0]/$account.dat");

	$message .= "$account<BR>";
	untie(%acc);
}

$message .= "</font> has been deleted";

&log($message);

}

########## DIR DEL ##########
sub dir_del {

my $direc = $_[0];
my (@dirs,$new_dir);

opendir(DIR,$direc);
@dirs = grep {!(/^\./) && -d "$direc/$_" } readdir(DIR);
close DIR;
@dirs = sort(@dirs);

opendir (DIR, "$direc");
@files = grep {!(/^\./) && -f "$direc/$_"}  readdir(DIR);
close (DIR); 

foreach $file(@files) {
	unlink("$direc/$file") || &error("Failed to remove $direc/$file");
}

for $new_dir(0..$#dirs) {
	&dir_del("$direc/$dirs[$new_dir]");
	rmdir("$direc/$dirs[$new_dir]") || &error("Failed to remove $direc/$dirs[$new_dir]");
}

}

########## VIEW ACCOUNT ##########
sub view {

$account = $INPUT{'account'};
$password = $INPUT{'password'};
&checkpassword;

$faccount =0;
$accdir="Base Dir.";
unless ($INPUT{'view_dir'}) { $INPUT{'view_dir'} = "accounts"; }

if ($INPUT{'view_dir'} ne "accounts") {
   open (ACC, "$path/categories.txt");
   @cata_data = <ACC>;
   close (ACC);

   foreach $cata_line(@cata_data) {
   		chomp($cata_line);
		@abbo = split(/\|/,$cata_line);
		($key,$abbo[0]) = split(/\%\%/,$abbo[0]);
		if ($INPUT{'view_dir'} eq $key) { $accdir=$abbo[0]; last; }
   }

}

@accarray = split(//,$account);
$accfile = "$path/members/$INPUT{'view_dir'}/$accarray[0]/$account.dat";
if (-e "$path/members/$INPUT{'view_dir'}/$accarray[0]/$account.dat") {
			
   undef $/;
   open (ACC, "$path/members/$INPUT{'view_dir'}/$accarray[0]/$account.dat");
   $acc_data = <ACC>;
   close (ACC);
   $/ = "\n";

   &view_two($account,$acc_data,$INPUT{'view_dir'},$accdir);
   $faccount = 1;

}	
else {
print <<EOF;
<BR>
<table cellpadding=5 border=1 cellspacing=0>
<TR><TD><font face=arial size=-1>
The account name you entered could not be found 
</TD></TR></TABLE>
EOF
&Footer;
exit;
}

exit;
}

sub view_two {

$account = $_[0];
$accdata = $_[1];
$acccata = $_[2];
$catapretty = $_[3];

@acco = split(/\n/,$accdata);

if ($acco[5]) {
	($sec,$min,$hour,$mday,$mon,$year,$wday,$yday,$isdst) = localtime($acco[5]);
	$mon++;
	$year += 1900;
	$now = "$mon.$mday.$year";
}
else { $now ="never"; }
$total_size_acc = $total_size + $acco[6];
unless ($acco[7]) { $acco[7]= "on"; }

$num_files = 0;
$num_folders =0;
$total_k = 0;

$acc_dir = $account;
if ($acccata ne "accounts") { $acc_dir = "$acccata/$account"; }

&dir_lists("$free_path/$acc_dir",1);
		
print <<EOF; 
<FORM METHOD=POST ACTION="$cgiurl">
<INPUT TYPE="HIDDEN" NAME="password" VALUE="$password">
<INPUT TYPE="HIDDEN" NAME="account" VALUE="$account">
<INPUT TYPE="HIDDEN" NAME="acccata" VALUE="$acccata">
<font face=arial size=-1><B>View Account</B> <font face="arial" size="+1" color=red><B>?</B></font></A>
<table cellpadding=5 border=1 cellspacing=0>
EOF
if ($acco[18]) {
print <<EOF;
<TR><TD colspan=2 align=center>
<font face=arial size=-1 color=red><B>ACCOUNT ON HOLD</B><BR>
$acco[18]
</TD></TR>
EOF
}
print <<EOF;
<TR><TD align=left><font face=arial size=-1>
Account name:</TD><TD align=left><font face=arial size=-1 color=red>$account
</TD></TR>
EOF
if ($category) {
print <<EOF;
<TR><TD align=left><font face=arial size=-1>
$cata_name:</TD><TD align=left><font face=arial size=-1 color=red>$catapretty
</TD></TR>
EOF
}
print <<EOF;
<TR><TD align=left><font face=arial size=-1>
Url:</TD><TD align=left><font face=arial size=-1 color=red><A HREF="$url/$acc_dir" target=main>$url/$acc_dir</A>
</TD></TR>
<TR><TD align=left><font face=arial size=-1>
Email:</TD><TD align=left><font face=arial size=-1 color=red><A HREF="mailto:$acco[0]">$acco[0]</A>
</TD></TR>
<TR><TD align=left><font face=arial size=-1>
Password:</TD><TD align=left><font face=arial size=-1 color=red><input type="Text" name="new_pass" value="$acco[2]" size="15">
</TD></TR>
<TR><TD align=left>
<font face="arial" size="+1" color=red><B>?</B></font></A>&nbsp;&nbsp;
<font face=arial size=-1>
On Hold:</FONT>
</TD><TD align=left><font face=arial size=-1 color=red><input type="Text" name="on_hold" value="$acco[18]" size="30">
</TD></TR>
<TR><TD align=left><font face=arial size=-1>
Number of files:</TD><TD align=left><font face=arial size=-1 color=red>$num_files
</TD></TR>
<TR><TD align=left><font face=arial size=-1>
Number of folders:</TD><TD align=left><font face=arial size=-1 color=red>$num_folders
</TD></TR>
<TR><TD align=left><font face=arial size=-1>
Space Taken:</TD><TD align=left><font face=arial size=-1 >Adjusted: <font color="Red">$acco[3]</font> k of $total_size_acc k<BR>

</TD></TR>
<TR><TD align=left><font face=arial size=-1>
Add more space:</TD><TD align=left><font face=arial size=-1 color=red>$total_size k + <INPUT TYPE="TEXT" NAME="size" VALUE="$acco[6]" SIZE=4> K
</TD></TR>
<TR><TD align=left><font face=arial size=-1>
Display Headers and Footers:</TD><TD align=left><font face=arial size=-1 color=red>
<input type="Checkbox" name="header_footer" value="off"
EOF

if ($acco[7] eq 'off') {
	print " CHECKED ";
}
 
print <<EOF;
> &nbsp;&nbsp;off</TD></TR>

<TR><TD align=left><font face=arial size=-1>
Allow Web Board:</TD><TD align=left><font face=arial size=-1 color=red>
<input type="Checkbox" name="www_board" value="on"
EOF

if ($acco[11] eq 'on') {
	print " CHECKED ";
}
 
print <<EOF;
> &nbsp;&nbsp;on</TD></TR>
<TR><TD align=left><font face=arial size=-1>
Allow Guestbook:</TD><TD align=left><font face=arial size=-1 color=red>
<input type="Checkbox" name="gbook" value="on"
EOF

if ($acco[33] eq 'on') {
	print " CHECKED ";
}
 
print <<EOF;
> &nbsp;&nbsp;on</TD></TR>
<TR><TD align=left><font face=arial size=-1>
Allow FTP importing:</TD><TD align=left><font face=arial size=-1 color=red>
<input type="Checkbox" name="ftp_per" value="on"
EOF

if ($acco[37] eq 'on') {
	print " CHECKED ";
}
 
print <<EOF;
> &nbsp;&nbsp;on</TD></TR>
<TR><TD align=left><font face=arial size=-1>
Name and Description:</TD><TD align=left><font face=arial size=-2>$acco[8]<BR>$acco[9]
</TD></TR>
<TR><TD align=left><font face=arial size=-1>
Last logged in:</TD><TD align=left><font face=arial size=-1 color=red>$now
</TD></TR>
EOF
if ($category) {
	if ($acco[32]) { $acco[32] = ",$acco[32],"; }
	$select ='';
	
	open (ACC, "$path/categories.txt");
	@cata_data = <ACC>;
	close (ACC);

	foreach $cata_line(@cata_data) {
		chomp($cata_line);
		@abbo = split(/\|/,$cata_line);
		($key,$abbo[0]) = split(/\%\%/,$abbo[0]);

		if ($acco[32] =~ /\,$key\,/) { $ssel = "SELECTED"; }
		else { $ssel = ""; }
		$select .= "<OPTION VALUE=\"$key\" $ssel>$abbo[1]\n";	
	}
$acc_sel = "";
$none_sel = "";
if ($acco[32] =~ /\,accounts\,/) { $acc_sel = "SELECTED"; }
unless ($acco[32]) { $none_sel = "SELECTED"; }
print <<EOF;
<TR><TD ALIGN=left>
<font face="arial" size="+1" color=red><B>?</B></font></A>&nbsp;&nbsp;
<font face=arial size=2>
Moderator Categories:
</TD><TD>
<select name="moder" size="4" multiple>
<OPTION VALUE="" $none_sel>No $cata_name
<OPTION VALUE="accounts" $acc_sel>Base Dir.
$select</select>
</TD></TR>
EOF
}
else {
$acc_sel = "";
$none_sel = "";
if ($acco[32] =~ /\,accounts\,/) { $acc_sel = "SELECTED"; }
unless ($acco[32]) { $none_sel = "SELECTED"; }
print <<EOF;
<TR><TD ALIGN=left>
<font face="arial" size="+1" color=red><B>?</B></font></A>&nbsp;&nbsp;
<font face=arial size=2>
Moderator Categories:
</TD><TD>
<select name="moder" size="4" multiple>
<OPTION VALUE="" $none_sel>No $cata_name
<OPTION VALUE="accounts" $acc_sel>Base Dir.
</select>
</TD></TR>
EOF
}


print <<EOF;
<TR><TD>
<font face=arial size=2>Custom Status Icon
</TD><TD>
<input type="Text" name="search_status" value="$acco[35]" size="30">
</TD>
</TR>
<TR><TD>
<font face=arial size=2>Additional per-Account file types
<BR><font face=arial size=1>Seperate each one by a comma (.shtml,.zip,.mp3)
</TD><TD>
<input type="Text" name="add_types" value="$acco[36]" size="30">
</TD>
</TR>
<TR><TD colspan=2 align=center>
<font face=arial size=2><B>Additional User Information</B>
</TD></TR>
EOF
$start=19;
%user = ("Address","info_address","City","info_city","State","info_state","Zip","info_zip","Country","info_country","Telephone Number","info_tele","Gender","info_gender","Age","info_age","ICQ Num","info_icq","Education","info_edu","Income","info_inc","Occupation","info_job","Birth Date","info_dob");
foreach $key ("Address","City","State","Zip","Country","Telephone Number","Gender","Age","ICQ Num","Education","Income","Occupation","Birth Date") {
	$thek = $user{$key};
print <<EOF;
<TR><TD align=left><font face=arial size=-1>
$key:</TD><TD align=left><font face=arial size=-1 color=red><input type="Text" name="$thek" value="$acco[$start]" size="25">
</TD></TR>
EOF
	$start++;
}	
print <<EOF;
<TR><TD align=center colspan=2><BR>
<INPUT TYPE="SUBMIT" NAME="acc_update" VALUE="Update the above info for account: $account"><br><br>
</TD></TR>
<TR><TD align=center colspan=2><BR>
</FORM><FORM METHOD=POST ACTION="$url_to_cgi/manager.cgi">
<INPUT TYPE="HIDDEN" NAME="account" VALUE="$account">
<INPUT TYPE="HIDDEN" NAME="cata" VALUE="$acccata">
<INPUT TYPE="HIDDEN" NAME="password" VALUE="$acco[2]">
<INPUT TYPE="SUBMIT" NAME="log" VALUE="Login into the file manager for account: $account">
</FORM></TD></TR>
</TABLE>
<BR>
<table border=0 width=60%>
<TR align=left><TD><font face=arial size=-1>
If you toggle headers and footers on or off, you must use the 
"update headers and footers" button from the main admin screen for 
the headers and footers to be added or deleted.
<BR><BR>
<CENTER><B>
Account directory tree</B></CENTER>
</TD></TR></TABLE><BR>
<FORM METHOD=POST ACTION="$cgiurl">
<INPUT TYPE="HIDDEN" NAME="password" VALUE="$password">
<table bgcolor= "white" border=0><TR><TD>
<font face=arial size=-1>
<ul>
	<LI><input type="Checkbox" name="delete_acc" value="$key|$keys"> <font color=red>Delete Account</FONT></LI>
	$html
</UL>
<BR><CENTER>
<INPUT TYPE="HIDDEN" NAME="account" VALUE="$account">
<INPUT TYPE="HIDDEN" NAME="cata" VALUE="$acccata">
<INPUT TYPE="SUBMIT" NAME="delete_acc_files" VALUE="Delete Selected"></TD></TR></TABLE></form>
EOF

&Footer;
exit;
}

########## DELETE SELECTED FILES ##########
sub delete_acc_files {
&checkpassword;

if ($delete_acc) {
	$INPUT{'accounts'} = $INPUT{'account'};
	&del;
}

@file = split(/\,/,$INPUT{'delete'});
foreach $ff (@file) {
	unlink($ff);
}

@dirs = split(/\,/,$INPUT{'delete_dir'});

foreach $dd (@dirs) {
	&dir_del($dd);
	rmdir("$dd")
}
&log("Selected files from account $INPUT{'account'} deleted");
}

############ DIRECTORY LISTS ##########
sub dir_lists {

my $direc = $_[0];
my $super_size = $_[1];
my (@dirs,$new_dir);

opendir(DIR,$direc);
@dirs = grep {!(/^\./) && -d "$direc/$_" } readdir(DIR);
close DIR;
@dirs = sort(@dirs);

opendir (DIR, "$direc");
@files = grep {!(/^\./) && -f "$direc/$_"}  readdir(DIR);
close (DIR); 
@files = sort(@files);

foreach $file(@files) {
	$show_file = "$direc/$file";
	$show_file =~ s/$free_path\///i;

	if ($super_size) {
		$html .= "<LI>";
		$html .= "<input type=\"Checkbox\" name=\"delete\" value=\"$direc/$file\"> ";
		$html .= "<a href=\"$url/$show_file\" target=\"main\">$file</A></LI>\n";
	}

	@stats = stat("$direc/$file");
	$mtime = $stats[9];
	$atime = $stats[8];
	$size = $stats[7];
	$size = $size /1000;
	$total_k = $size + $total_k;
	$num_files++;
}

for $new_dir(0..$#dirs) {
	$show_dir = "$direc/$dirs[$new_dir]";
	$show_dir =~ s/$free_path\/$direc\///i;

	if ($super_size) {
		$html .= "<li>\&nbsp\;\&nbsp\;<B>$dirs[$new_dir]</B></li>\n";
		$html .= "<ul>\n";
		$html .= "<LI><input type=\"Checkbox\" name=\"delete_dir\" value=\"$direc/$dirs[$new_dir]\"> <Font color=red>Delete Dir.</font></LI>\n";

	}
	$num_fold++;

	&dir_lists("$direc/$dirs[$new_dir]",$super_size);
	$html .= "</UL>\n";
}
}

######### UPDATE ACCOUNT INFO ##########
sub acc_update {
if ($demo) {&demo;}

$account = $INPUT{'account'};
$password = $INPUT{'password'};
$acccata = $INPUT{'acccata'};
&checkpassword;


@accarray = split(//,$account);
$accfile = "$path/members/$acccata/$accarray[0]/$account.dat";

unless (-e "$accfile") {
print <<EOF;
<BR>
<table cellpadding=5 border=1 cellspacing=0 bgcolor=$table_bg>
<TR><TD><font face=$font_face size=$font_size color=$text_table>
The account name you entered could not be found in our database
</TD></TR></TABLE>
EOF
	&Footer;
	exit;
}

undef $/;
open (ACC, "$accfile") || &error("Error reading $accfile");
$acc_data = <ACC>;
close (ACC);
$/ = "\n";

@acco = split(/\n/,$acc_data);

$acco[2] = "$INPUT{'new_pass'}";
$acco[6] = $INPUT{'size'};
if ($INPUT{'header_footer'} eq 'off'){
	$acco[7] = "off";
}
else {
	$acco[7] = "on";
}
$acco[11] = "$INPUT{'www_board'}";
$acco[18] = $INPUT{'on_hold'};
$acco[18] =~ s/\|//g;
$start=19;
%user = ("Address","info_address","City","info_city","State","info_state","Zip","info_zip","Country","info_country","Telephone Number","info_tele","Gender","info_gender","Age","info_age","ICQ Num","info_icq","Education","info_edu","Income","info_inc","Occupation","info_job","Birth Date","info_dob");
foreach $key ("Address","City","State","Zip","Country","Telephone Number","Gender","Age","ICQ Num","Education","Income","Occupation","Birth Date") {
	$thek = $user{$key};
	$acco[$start] = $INPUT{$thek};
	$acco[$start] =~ s/\|//g;
	$start++;
}	
$acco[32] = $INPUT{'moder'};
$acco[33] = $INPUT{'gbook'};
$acco[35] = $INPUT{'search_status'};
$acco[36] = $INPUT{'add_types'};
$acco[37] = $INPUT{'ftp_per'};

$acc_data = join("\n",@acco);

open (ACC, ">$accfile") || &error("Error printing $accfile");
print ACC $acc_data;
close (ACC);	

$message = "$account updated";
&log($message);
exit;
}

########## WRITE THE EMAIL TO SEND ##########
sub sendemail {

&checkpassword;

print <<EOF;
<table cellspacing =0 bgcolor =#00416B border=1 cellpadding =8 width=400>
<TR bgcolor=#E4E4E4>
<TD><center><FONT SIZE="-1" FACE="arial">Send email to account<BR><BR></CENTER>
<FORM METHOD=POST ACTION=$cgiurl>
<INPUT TYPE=hidden name=password value=$INPUT{'password'}>
<TABLE cellpadding=5><TR><TD><FONT SIZE="-1" FACE="arial">
EOF

if ($category) {
print <<EOF;
Accounts in category:<BR>
<select name="cata" multiple>
<option value="_all_" SELECTED>All Categories
<option value="accounts">Base Dir.
EOF
open (ACC, "$path/categories.txt");
@cata_data = <ACC>;
close (ACC);

foreach $cata_line(@cata_data) {
	chomp($cata_line);
	@abbo = split(/\|/,$cata_line);
	($key,$abbo[0]) = split(/\%\%/,$abbo[0]);
	print "<OPTION VALUE=$key>$abbo[1]\n";
}

	print "</SELECT></TD><TD valign=middle><FONT SIZE=\"-1\" FACE=\"arial\">\n";
}

print <<EOF;
Accounts per request..<BR>
<INPUT TYPE=TEXT name=per value=2500 size=10>
<!-- <input type="Checkbox" name="select_acc" value="on"> -- Only accounts signed up for emails --> 
</TD></TR></TABLE>
<BR><BR>
Subject<BR>
<input type = text name=subject size=45>
<BR><BR>Body of Message
	<TEXTAREA NAME=body ROWS=14 COLS=50></TEXTAREA>
<INPUT TYPE=SUBMIT NAME=emailit VALUE=" Send Email ">

</TD></TR></TABLE></FORM><BR><BR></CENTER></CENTER>
<BLOCKQUOTE>
A few quick words on how this actually works. 
<BR><BR>
This works just like updating the headers and footers. Since it takes time to send out each
email, the server timesout on the request, so we must do it in sections..
</BLOCKQUOTE>
<BR><BR>

EOF
&Footer;
exit;
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


########## UPDATE HEADERS AND FOOTERS ##########
sub update {

&checkpassword;

print <<EOF;
<center><FONT SIZE="-1" FACE="arial"><B>Update headers and footers</B><BR><BR></CENTER>
<FORM METHOD=POST ACTION=admin_update.cgi>
<FONT SIZE="-1" FACE="arial">
EOF

if ($category) {
print <<EOF;
Accounts in category:
<select name="catas" multiple>
<option value="_all_" SELECTED>All Categories
<option value="accounts">Base Dir.

EOF

   open (ACC, "$path/categories.txt");
   @cata_data = <ACC>;
   close (ACC);

   foreach $cata_line(@cata_data) {
	   chomp($cata_line);
	   @abbo = split(/\|/,$cata_line);
	   ($key,$abbo[0]) = split(/\%\%/,$abbo[0]);
	   print "<OPTION VALUE=$key>$abbo[1]\n";
   }

	print "</SELECT>\n";
}
else {
print "<INPUT TYPE=HIDDEN NAME=catas value=accounts>\n";
}
print <<EOF;
<BR><BR>Number of accounts to proccess per request:
<INPUT TYPE=TEXT size=10 name=per value=2500>
<BR><BR>
<INPUT TYPE=HIDDEN NAME=display value=start>
<INPUT TYPE=SUBMIT NAME=submit VALUE="  UPDATE  ">
</FORM><BR>
<BR>
</CENTER>
<BLOCKQUOTE>
A few quick words on how this actually works. 
<BR><BR>
It takes time for perl to open, parse and rewrite every html file your members have. 
Say you have upwards of 10,000 members, and say each of those members has 10 html files in their account.
Thats 100,000 files we must parse with your new header and footer. The time it would take for a perl program to complete
such a task and respond with a finished message is longer than most servers will wait for a response. Thus the request will time out,
you will getan error message and not all members files will be updated.
<BR><BR>
Our solution to this problem is to update a few of the members a time per request to the server. Sending multiple requests to the server when the
previous is complete. This is all done automatically via meta tags in the headers of the html. All you have
to do is press the button to start it. The number in the text box is the amount of accounts that will be proccessed each time. 
If you think you can fit more in without the server request timing out, up the number. If the server starts timing out, come back and make the number a bit lower.
<BR><BR>
</BLOCKQUOTE>


EOF
&Footer;
exit;
}

########## SHOW ACCOUNTS NEVER LOGGED INTO ##########
sub deln {

$password = $INPUT{'password'};
&checkpassword;

print <<EOF;
<B>Accounts created over $INPUT{'days_never'} days ago, but never activated</B>
<FORM METHOD=POST ACTION="$cgiurl">
<INPUT TYPE="HIDDEN" NAME="password" VALUE="$password">
<table cellspacing =0 border=1 cellpadding =8>
<TR bgcolor=#E4E4E4 align=center>
<TD><FONT SIZE="-1" FACE="arial">Category</TD>
<TD><FONT SIZE="-1" FACE="arial">Del.</TD>
<TD><FONT SIZE="-1" FACE="arial">Account name</TD>
<TD><FONT SIZE="-1" FACE="arial">Created on</TD>
<TD><FONT SIZE="-1" FACE="arial">Email</TD></TR>
EOF

if ($INPUT{'deln_checked'}) { $checked="CHECKED"; }

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
		foreach $account(@acc_arr) {
			undef $/;
			open (ACC, "$dir/$cata/$ch/$account") || &error("Error reading $dir/$cata/$ch/$account");
			$acc_data = <ACC>;
			close (ACC);
			$/ = "\n";
			$account =~ s/\.dat//;
			
			@acco = split(/\n/,$acc_data);
			$numaccounts ++;
			unless ($acco[5]) {
				$ctime = $time - $acco[4];
				$ctime = int($ctime / 86400);
				($sec,$min,$hour,$mday,$mon,$year,$wday,$yday,$isdst) = localtime($acco[4]);
				$mon++;
				$year += 1900;
				$now = "$mon.$mday.$year";
				if ($ctime >= $INPUT{'days_never'}) {
print <<EOF;
<TR align=center>
<TD><FONT SIZE="-1" FACE=arial>$cata</TD>
<TD><FONT SIZE="-1" FACE="arial"><INPUT TYPE="CHECKBOX" NAME="accounts" VALUE="$account|$cata" $checked></TD>
<TD><FONT SIZE="-1" FACE="arial">$account</TD>
<TD><FONT SIZE="-1" FACE="arial">$now</TD>
<TD><FONT SIZE="-1" FACE="arial"><A HREF="mailto:$acco[0]">$acco[0]</A></TD></TR>
EOF
   		  		}
   		  	}
		}
	}
}

print <<EOF;
<TR align=center  bgcolor=#E4E4E4><TD colspan=5>
<INPUT TYPE="SUBMIT" NAME="del" VALUE="Delete selected accounts">
</TD></TABLE>
</FORM>
EOF

untie(%acc);
&Footer;
exit;
}

########## SHOW ACCOUNTS ON HOLD ##########
sub onhold {

$password = $INPUT{'password'};
&checkpassword;

print <<EOF;
<B>Accounts currently on hold</B>
<FORM METHOD=POST ACTION="$cgiurl">
<INPUT TYPE="HIDDEN" NAME="password" VALUE="$password">
<table cellspacing =0 border=1 cellpadding =8>
<TR bgcolor=#E4E4E4 align=center>
<TD><FONT SIZE="-1" FACE="arial">Category</TD>
<TD><FONT SIZE="-1" FACE="arial">Del.</TD>
<TD><FONT SIZE="-1" FACE="arial">Account name</TD>
<TD><FONT SIZE="-1" FACE="arial">Created on</TD>
<TD><FONT SIZE="-1" FACE="arial">Email</TD></TR>
EOF


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
		foreach $account(@acc_arr) {
			undef $/;
			open (ACC, "$dir/$cata/$ch/$account") || &error("Error reading $dir/$cata/$ch/$account");
			$acc_data = <ACC>;
			close (ACC);
			$/ = "\n";
			$account =~ s/\.dat//;
			
			@acco = split(/\n/,$acc_data);
			$numaccounts ++;
			if ($acco[18]) {
				($sec,$min,$hour,$mday,$mon,$year,$wday,$yday,$isdst) = localtime($acco[4]);
				$mon++;
				$year += 1900;
				$now = "$mon.$mday.$year";
print <<EOF;
<TR align=center>
<TD><FONT SIZE="-1" FACE=arial>$cata</TD>
<TD><FONT SIZE="-1" FACE="arial"><INPUT TYPE="CHECKBOX" NAME="accounts" VALUE="$account|$cata"></TD>
<TD><FONT SIZE="-1" FACE="arial">$account</TD>
<TD><FONT SIZE="-1" FACE="arial">$now</TD>
<TD><FONT SIZE="-1" FACE="arial"><A HREF="mailto:$acco[0]">$acco[0]</A></TD></TR>
<TR><TD colspan=5><FONT SIZE="-1" FACE="arial">Reason: <input type="Text" name="$account|$cata" value="$acco[18]" size=40>
</TD></TR>
EOF
			}
		}		
	}
}

print <<EOF;
<TR align=center  bgcolor=#E4E4E4><TD colspan=5>
<INPUT TYPE="SUBMIT" NAME="onhold_final" VALUE="Delete/Update Accounts">
</TD></TABLE>
</FORM>
EOF

untie(%acc);
&Footer;
exit;
}

########## ACCOUNT ONHOLD FINIAL ##########
sub onhold_final {

$account = $INPUT{'accounts'};
$password = $INPUT{'password'};

&checkpassword;


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
		foreach $account(@acc_arr) {
			undef $/;
			open (ACC, "$dir/$cata/$ch/$account") || &error("Error reading $dir/$cata/$ch/$account");
			$acc_data = <ACC>;
			close (ACC);
			$/ = "\n";
			$account =~ s/\.dat//;
			
			@acco = split(/\n/,$acc_data);
			$numaccounts ++;
			if ($acco[18]) {
				if ($INPUT{$account.'|'. $cata}) {
					$acco[18] = $INPUT{$account.'|'. $cata};
				}
				else { $acco[18]= ''; }
				$acc_data = join("\n",@acco);
				open (ACC, ">$dir/$cata/$ch/$account.dat") || &error("Error printing $dir/$cata/$ch/$account.dat");
				print ACC $acc_data;
				close (ACC);	
			}
		}		
	}
}

&del(1);
&log($message);
}


########### SHOW ACCOUNTS NOT LOGGED IN LATELY ##########
sub delw {

$password = $INPUT{'password'};
&checkpassword;
$log_time = $INPUT{'log_time'};

print <<EOF;
<B>Accounts that have not been logged into in the last $log_time days</B>
<FORM METHOD=POST ACTION="$cgiurl">
<INPUT TYPE="HIDDEN" NAME="password" VALUE="$password">
<table cellspacing =0 border=1 cellpadding =8>
<TR bgcolor=#E4E4E4 align=center>
<TD><FONT SIZE="-1" FACE="arial">Category</TD>
<TD><FONT SIZE="-1" FACE="arial">Del.</TD>
<TD><FONT SIZE="-1" FACE="arial">Account name</TD>
<TD><FONT SIZE="-1" FACE="arial">Created on</TD>
<TD><FONT SIZE="-1" FACE="arial">Last Log</TD>
<TD><FONT SIZE="-1" FACE="arial">Email</TD></TR>
EOF

$numaccounts =0;
$numinact =0;
$numinactw =0;
$size=0;

if ($INPUT{'delw_checked'}) { $checked="CHECKED"; }
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
		foreach $account(@acc_arr) {
			undef $/;
			open (ACC, "$dir/$cata/$ch/$account") || &error("Error reading $dir/$cata/$ch/$account");
			$acc_data = <ACC>;
			close (ACC);
			$/ = "\n";
			$account =~ s/\.dat//;
			
			@acco = split(/\n/,$acc_data);
			$numaccounts ++;
			if ($acco[5]) {
				$ttime = ($time - $acco[5]) / 86400;
				if ($ttime > $log_time) { 
					($sec,$min,$hour,$mday,$mon,$year,$wday,$yday,$isdst) = localtime($acco[4]);
					$mon++;
					$year += 1900;
					$now = "$mon.$mday.$year";
					($sec,$min,$hour,$mday,$mon,$year,$wday,$yday,$isdst) = localtime($acco[5]);
					$mon++;
					$year += 1900;
					$nows = "$mon.$mday.$year";
print <<EOF;
<TR align=center>
<TD><FONT SIZE="-1" FACE="arial">$cata</TD>
<TD><FONT SIZE="-1" FACE="arial"><INPUT TYPE="CHECKBOX" NAME="accounts" VALUE="$account|$cata" $checked></TD>
<TD><FONT SIZE="-1" FACE="arial">$account</TD>
<TD><FONT SIZE="-1" FACE="arial">$now</TD>
<TD><FONT SIZE="-1" FACE="arial">$nows</TD>
<TD><FONT SIZE="-1" FACE="arial"><A HREF="mailto:$acco[0]">$acco[0]</A></TD></TR>

EOF
				}
			}
		}
	}
}

print <<EOF;
<TR align=center  bgcolor=#E4E4E4><TD colspan=6>
<INPUT TYPE="SUBMIT" NAME="del" VALUE="Delete selected accounts">
</TD></TABLE>
</FORM>
EOF
untie(%acc);
&Footer;
exit;
}

########## ADD NEW FILE TYPES TEXT BOX ##########
sub filetypes {

$password = $INPUT{'password'};
&checkpassword;

open (DAT,"<$path/filetypes.txt");
@headers = <DAT>;
close (DAT);

print <<EOF; 
<FORM METHOD=POST ACTION="$cgiurl">
<INPUT TYPE="HIDDEN" NAME="password" VALUE="$password">
<font face=arial><B>Add or remove file types that users may use</B>
<BR><BR><font size=-1>put one file type on each line,<BR>put the period before the extension<BR><BR>
The file types:<BR>
<font color=red>.htm<BR>
.html<BR>
.gif<BR>
.jpg<BR>
.jpeg</FONT><BR>
are not needed since they are already allowed.

</font><BR><BR>
<TEXTAREA NAME="filecontents" ROWS=10 COLS=30  wrap="PHYSICAL">
@headers
</TEXTAREA>
<BR><BR>

<INPUT TYPE="SUBMIT" NAME="types_edit" VALUE="Save your changes">
</form>

EOF
&Footer;
exit;
}

########## SAVE NEW FILE TYPES ##########
sub types_edit {
if ($demo) {&demo;}
$password = $INPUT{'password'};
&checkpassword;

$INPUT{'filecontents'} =~ s/\n//g;
open (DAT,">$path/filetypes.txt");
print DAT $INPUT{'filecontents'};
close (DAT);

$message = "Allowed file types updated";

&log($message);
}

########## CHECK ADMIN PASSWORD ##########
sub checkpassword {

if ($INPUT{'password'}) {
	$newpassword = crypt($INPUT{'password'}, ai);
	unless ($newpassword eq $admin_password) {
		print <<EOF;
<table cellspacing =0 bgcolor =#00416B border=1 cellpadding =8>
<TR bgcolor=#E4E4E4 align=center><TD><FONT SIZE="-1" FACE="arial">Wrong Password 
</TD></TR></TABLE>
EOF
		&Footer;
		exit;
	}
}
else {
print <<EOF;
<table cellspacing =0 bgcolor =#00416B border=1 cellpadding =8>
<TR bgcolor=#E4E4E4 align=center><TD><FONT SIZE="-1" FACE="arial">You must enter a password
</TD></TR></TABLE>
EOF
	&Footer;
	exit;}
$password = $INPUT{'password'};}

########## MANAGE FILES ##########
sub m_files {

$password = $INPUT{'password'};
&checkpassword;

opendir (DIR, "$path") || &error("Unable to open data dir. for reading");
@fileh = grep { /headers/ } readdir(DIR);
close (DIR);

opendir (DIR, "$path") || &error("Unable to open data dir. for reading");
@filef = grep { /footers/ } readdir(DIR);
close (DIR);

print <<EOF;
<BR>
<font face=arial size=2>$message</FONT>
<BR><BR>
<FORM METHOD=POST ACTION="$cgiurl">
<INPUT TYPE="HIDDEN" NAME="password" VALUE="$password">
<table cellpadding=5 border=1 cellspacing=0 bgcolor="white">
<TR bgcolor=silver><TD colspan=2 align=center>
<font face="arial" size="+1" color=red><B>?</B></font></a>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<font face=arial size=-1><B>Select a file to edit
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</TD></TR>
<TR><TD valign=top align=center>
<INPUT TYPE="RADIO" NAME="efile" VALUE="header.txt">
</TD><TD align=left>
<font face=arial size=-1>
header.txt -- The text above all functions in the file manager 
</TD></TR>
<TR><TD valign=top align=center>
<INPUT TYPE="RADIO" NAME="efile" VALUE="footer.txt">
</TD><TD align=left>
<font face=arial size=-1>
footer.txt -- The text below all functions in the file manager 
</TD></TR>
<TR><TD valign=top align=center>
<INPUT TYPE="RADIO" NAME="efile" VALUE="header_html.txt">
</TD><TD align=left>
<font face=arial size=-1>
header_html.txt -- The text add to the top of all members html pages 
</TD></TR>
<TR><TD valign=top align=center>
<INPUT TYPE="RADIO" NAME="efile" VALUE="footer_html.txt">
</TD><TD align=left>
<font face=arial size=-1>
footer_html.txt -- The text used as a footer to all members html pages 
</TD></TR>
<TR><TD valign=top align=center>
<INPUT TYPE="RADIO" NAME="efile" VALUE="index.txt">
</TD><TD align=left>
<font face=arial size=-1>
index.txt -- html for the index.html page create upon signup
</TD></TR>
<TR><TD valign=top align=center>
<INPUT TYPE="RADIO" NAME="efile" VALUE="welcome_html.txt">
</TD><TD align=left>
<font face=arial size=-1>
welcome_html.txt -- If you have it so people can choose password
</TD></TR>
<TR><TD valign=top align=center>
<INPUT TYPE="RADIO" NAME="efile" VALUE="welcome.txt">
</TD><TD align=left>
<font face=arial size=-1>
welcome.txt -- Text added to the welcome email containing members password
</TD></TR>
<TR><TD valign=top align=center>
<INPUT TYPE="RADIO" NAME="efile" VALUE="rules.txt">
</TD><TD align=left>
<font face=arial size=-1>
rules.txt -- Terms and conditions file, make users accept this before they are given an account
</TD></TR>
<TR><TD colspan=2 align=center>
<font face=arial size=-1><B><INPUT TYPE="SUBMIT" NAME="edit" VALUE="Edit the selected file">
</TD></TR>
<TR bgcolor=silver><TD colspan=2 align=center>
<"><font face="arial" size="+1" color=red><B>?</B></font></a>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<font face=arial size=-1><B>Headers and Footers</B>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</TD></TR>
<TR><TD colspan=2 align=left>
<font face=arial size=-1><b>Headers:</b>&nbsp;&nbsp;&nbsp;
<select name="headers">
EOF
	$next =1;
	foreach $ff(@fileh) {
		$ftxt = $ff;
		$ftxt =~ s/\.txt//ig;
		@last = split(/\_/,$ftxt);
		$next = $last[1];
		$next++;	
		open (DAT,"<$path/$ff"); 
		@headers = <DAT>;
		close (DAT);
		print "<option value=\"$ff\">$ff -- $headers[0]\n";
	}
print <<EOF;
</select>&nbsp;&nbsp;&nbsp;
<input type="Submit" name="edit_headers" value=" Edit ">
&nbsp;&nbsp;&nbsp;
<input type="Submit" name="new_headers" value=" Create New ">
&nbsp;&nbsp;&nbsp;
<input type="Submit" name="delete_headers" value=" Delete ">

<input type="Hidden" name="next_headers" value="$next">
</TD></TR>
<TR><TD colspan=2 align=left>
<font face=arial size=-1><b>Footers:</b>&nbsp;&nbsp;&nbsp;
<select name="footers">
EOF
	$next = 1;
	foreach $ff(@filef) {
		$ftxt = $ff;
		$ftxt =~ s/\.txt//ig;
		@last = split(/\_/,$ftxt);
		$next = $last[1];
		$next++;
		open (DAT,"<$path/$ff"); 
		@headers = <DAT>;
		close (DAT);

		print "<option value=\"$ff\">$ff -- $headers[0]\n";
	}
print <<EOF;
</select>&nbsp;&nbsp;&nbsp;
<input type="Submit" name="edit_footers" value=" Edit ">
&nbsp;&nbsp;&nbsp;
<input type="Submit" name="new_footers" value=" Create New ">
&nbsp;&nbsp;&nbsp;
<input type="Submit" name="delete_footers" value=" Delete ">
<input type="Hidden" name="next_footers" value="$next">

</TD></TR>
<TR><TD colspan=2 align=center bgcolor=silver>
<input type="Submit" name="log" value=" Back to main admin screen ">
</TD></TR>
</TABLE>
</FORM>
EOF
&Footer;
exit;

}

########## EDIT IMPORTANT DATA FILES HEAD FOOT AD ##########
sub edit_head_foot {

$password = $INPUT{'password'};
&checkpassword;

if ($INPUT{'edit_headers'}) {
	$file = $INPUT{'headers'};
}
else {
	$file = $INPUT{'footers'};
}
open (DAT,"<$path/$file"); 
@headers = <DAT>;
close (DAT);

@headers = reverse(@headers);
$dfile = pop(@headers);
@headers = reverse(@headers);

print <<EOF; 
<FORM METHOD=POST ACTION="$cgiurl">
<INPUT TYPE="HIDDEN" NAME="password" VALUE="$password">
<INPUT TYPE="HIDDEN" NAME="efile" VALUE="$file">
<font face=arial><B>Edit the file: <font color=red>$file</FONT></B>
<BR><BR>
File Description: <input type="Text" name="dfile" value="$dfile" size="40">
<BR><BR>
<font size=-1>Enter or change all the html you want in the text box below</font><BR><BR>
<TEXTAREA NAME="filecontents" ROWS=25 COLS=65 wrap="OFF">
@headers
</TEXTAREA>
<BR><BR>

<INPUT TYPE="SUBMIT" NAME="edit_final_head_foot" VALUE="Save your changes">
</form>

EOF
&Footer;
exit;
}

########## EDIT THOSE FILES ##########
sub edit_final_head_foot {
if ($demo) {&demo;}

$password = $INPUT{'password'};
&checkpassword;
$file = $INPUT{'efile'};

open (DAT,">$path/$file");
print DAT "$INPUT{'dfile'}\n";
print DAT $INPUT{'filecontents'};
close (DAT);

$message = "File: <font color=red>$file</font> updated";

&m_files($message);

}

########## CREATE NEW IMPORTANT DATA FILES HEAD FOOT AD ##########
sub new_head_foot {

$password = $INPUT{'password'};
&checkpassword;

if ($INPUT{'new_headers'}) {
	$file = "headers_".$INPUT{'next_headers'}.".txt";
}
else {
	$file = "footers_".$INPUT{'next_footers'}.".txt";
}

print <<EOF; 
<FORM METHOD=POST ACTION="$cgiurl">
<INPUT TYPE="HIDDEN" NAME="password" VALUE="$password">
<INPUT TYPE="HIDDEN" NAME="efile" VALUE="$file">
<font face=arial><B>Edit the file: <font color=red>$file</FONT></B>
<BR><BR>
<font size=-1>Enter a short description to remember it by:</FONT>
<BR> <input type="Text" name="dfile" size="40">
<BR><BR>
<font size=-1>Enter all the html you want in the text box below</font><BR><BR>
<TEXTAREA NAME="filecontents" ROWS=25 COLS=65 wrap="OFF">
</TEXTAREA>
<BR><BR>

<INPUT TYPE="SUBMIT" NAME="edit_final_head_foot" VALUE="Save your changes">
</form>

EOF
&Footer;
exit;
}
sub by{
$ay=~s/^$sy//;
unless($ay eq $ry){&error("9");} }
########## MANAGE Categories ########
sub manage_cata {
$password = $INPUT{'password'};
&checkpassword;


opendir (DIR, "$path") || &error("Unable to open data dir. for reading");
@fileh = grep { /headers/ } readdir(DIR);
close (DIR);

opendir (DIR, "$path") || &error("Unable to open data dir. for reading");
@filef = grep { /footers/ } readdir(DIR);
close (DIR);

open (ACC, "$path/categories.txt");
@cata_data = <ACC>;
close (ACC);



print <<EOF;
<BR><BR>
<FORM METHOD=POST ACTION="$cgiurl">
<INPUT TYPE="HIDDEN" NAME="password" VALUE="$password">
<table cellpadding=5 border=1 cellspacing=0 bgcolor="white">
EOF
foreach $cata_line(@cata_data) {
	chomp($cata_line);
	@cata = split(/\|/,$cata_line);
	($key,$cata[0]) = split(/\%\%/,$cata[0]);

print <<EOF;
<TR bgcolor=silver><TD><input type="Checkbox" name="del_$key" value="$key"> <font face=arial size=1>- Delete</TD>
<TD><font face=arial size=2><B>$key - $cata[0]</B></FONT></TD></TR>
<TR>
<TD><font face=arial size=1>Real Name</FONT></TD>
<TD><input type="Text" name="cata_$key" value="$cata[1]" size=20></TD>
</TR>
<TR>
<TD><font face=arial size=1>Description</FONT></TD>
<TD><input type="Text" name="des_$key" value="$cata[2]" size=20></TD>
</TR><TR>
<TD><font face=arial size=1>Header</FONT></TD>
<TD><select name="cata_head_$key">
EOF
	foreach $ff(@fileh) {
		$ftxt = $ff;
		$ftxt =~ s/\.txt//ig;
		@last = split(/\_/,$ftxt);
		$next = $last[1];
		$next++;
		open (DAT,"<$path/$ff"); 
		@headers = <DAT>;
		close (DAT);

		print "<option value=\"$ff\" ";
		if ($cata[3] eq $ff) {
			print "SELECTED";
		}
		print ">$ff -- $headers[0]\n";
	}
print <<EOF;
</SELECT>
</TD></TR>
<TR>
<TD><font face=arial size=1>Footer</FONT></TD>
<TD><select name="cata_foot_$key">
EOF
	foreach $ff(@filef) {
		$ftxt = $ff;
		$ftxt =~ s/\.txt//ig;
		@last = split(/\_/,$ftxt);
		$next = $last[1];
		$next++;
		open (DAT,"<$path/$ff"); 
		@headers = <DAT>;
		close (DAT);

		print "<option value=\"$ff\" ";
		if ($cata[4] eq $ff) {
			print "SELECTED";
		}
		print ">$ff -- $headers[0]\n";
	}
print <<EOF;
</SELECT>
</TD>
</TR>
<TR>
<TD><font face=arial size=1>Manager Header</FONT></TD>
<TD><select name="cata_mhead_$key">
<option value="default">Default
EOF
	foreach $ff(@fileh) {
		$ftxt = $ff;
		$ftxt =~ s/\.txt//ig;
		@last = split(/\_/,$ftxt);
		$next = $last[1];
		$next++;
		open (DAT,"<$path/$ff"); 
		@headers = <DAT>;
		close (DAT);

		print "<option value=\"$ff\" ";
		if ($cata[5] eq $ff) {
			print "SELECTED";
		}
		print ">$ff -- $headers[0]\n";
	}
print <<EOF;
</SELECT>
</TD>
</TR>
<TR>
<TD><font face=arial size=1>Manager Footer</FONT></TD>
<TD><select name="cata_mfoot_$key">
<option value="default">Default
EOF
	foreach $ff(@filef) {
		$ftxt = $ff;
		$ftxt =~ s/\.txt//ig;
		@last = split(/\_/,$ftxt);
		$next = $last[1];
		$next++;
		open (DAT,"<$path/$ff"); 
		@headers = <DAT>;
		close (DAT);

		print "<option value=\"$ff\" ";
		if ($cata[6] eq $ff) {
			print "SELECTED";
		}
		print ">$ff -- $headers[0]\n";
	}
print <<EOF;
</SELECT>
</TD>
</TR>
<TR>
<TD><font face=arial size=1>Possible Accounts</FONT></TD>
<TD>
<input type="Text" name="cata_tot_$key" value="$cata[7]" size="4"><font face=arial size=1> - current num <font color=red>$cata[8]</FONT>
</TD></TR>
EOF
}

print <<EOF;
<TR bgcolor=silver><TD align=center colspan=2>
<input type="Submit" name="edit_cata" value="Edit/Delete Categories">
</TD></TR></TABLE>
</FORM>
EOF

&Footer;
exit;
}

########## EDIT FINAL Categories ##########
sub edit_cata {

if ($demo){&demo;}
$password = $INPUT{'password'};
&checkpassword;

open (ACC, "$path/categories.txt");
@cata_data = <ACC>;
close (ACC);

print <<EOF;
<BR><BR>
<FORM METHOD=POST ACTION="$cgiurl">
<INPUT TYPE="HIDDEN" NAME="password" VALUE="$password">
<table cellpadding=5 border=1 cellspacing=0 bgcolor="white">
EOF

foreach $cata_line(@cata_data) {
	chomp($cata_line);
	@cata = split(/\|/,$cata_line);
	($key,$cata[0]) = split(/\%\%/,$cata[0]);
    $skey=$key;
	$removed = 0;
	if ($INPUT{'del_'.$skey}) {
		rmdir("$free_path/$cata[0]") || ($removed=$!);
		if ($removed) {
			print "<TR><TD><FONT FACE=arial size=2 color=red>Failed to remove <b>$skey - $cata[0] - $!</b>\n"; 
			next;
		}
		foreach $ch(@char_set) {
			rmdir("$path/members/$key/$ch") || ($removed=$!);
		}
		rmdir("$path/members/$key") || ($removed=$!);
		if ($removed) {
			print "<TR><TD><FONT FACE=arial size=2 color=red>Failed to remove <b>$skey - $cata[0] - $!</b>\n"; 
			next;
		}
		delete ($new{$skey});
		print "<TR><TD><font face=arial size=2><b>$skey - $cata[0]</b> -- Deleted</FONT></TD></TR>\n";
	}
	else {
		$return_data .= "$key\%\%$cata[0]|$INPUT{'cata_'.$skey}|$INPUT{'des_'.$skey}|$INPUT{'cata_head_'.$skey}|$INPUT{'cata_foot_'.$skey}|$INPUT{'cata_mhead_'.$skey}|$INPUT{'cata_mfoot_'.$skey}|$INPUT{'cata_tot_'.$skey}|$cata[8]|\n";
		print "<TR><TD><font face=arial size=2><b>$skey - $cata[0]</b> -- Updated</FONT></TD></TR>\n";
	}
	
}
print <<EOF;
<TR bgcolor=silver><TD align=center>
<input type="Submit" name="log" value=" return to main admin screen ">
</TD></TR>
</TABLE></FORM><BR>
EOF

open (ACC, ">$path/categories.txt");
print ACC $return_data;
close (ACC);

&Footer;
exit;
}

########## HEADER FOOTER ##########
sub Header {
unless ($free_name) {
	$free_names = "Community Builder";
}
else {
	$free_names = $free_name;
}

print <<EOF;

<HTML>
<HEAD>
        <TITLE>$free_names</TITLE>
</HEAD>
<BODY bgcolor=#336666 TEXT="#000000" LINK="blue" VLINK="blue" ALINK="blue">

<table border=0 cellpadding=0 cellspacing=0 bgcolor=black width=100%>
<TR>
	<TD colspan=5 height=5><img src="$url_to_icons/black.gif" width=5 height=5 border=0></TD>
</TR>
<TR>
	<TD width=5 height=5><img src="$url_to_icons/black.gif" width=5 height=5 border=0></TD>
	<TD bgcolor=IndianRed colspan=3><FONT COLOR=BLACK FACE=arial SIZE=+3><B>$free_names</B></FONT></TD>
	<TD width=5 height=5><img src="$url_to_icons/black.gif" width=5 height=5 border=0></TD>
</TR>
<TR>
	<TD colspan=5 height=5><img src="$url_to_icons/black.gif" width=5 height=5 border=0></TD>
</TR>
<TR>

	<TD width=5 height=5><img src="$url_to_icons/black.gif" width=5 height=5 border=0></TD>
	<TD bgcolor=BurlyWood colspan=3 align=center><FONT FACE=arial size=+1><B>Community Builder version $version</B></FONT></TD>
	<TD width=5 height=5><img src="$url_to_icons/black.gif" width=5 height=5 border=0></TD>
</TR><TR>
	<TD colspan=5 height=5><img src="$url_to_icons/black.gif" width=5 height=5 border=0></TD>
</TR><TR>
	<TD width=5 height=5><img src="$url_to_icons/black.gif" width=5 height=5 border=0></TD>
	<TD bgcolor=BurlyWood valign=top width=130>
<BR>
<FONT FACE=arial size=-2>
<CENTER><B>
<font color=black>Documentation</FONT></A>
</B></CENTER><BR>

&nbsp;&nbsp;<font color=black>Admin How-to</FONT></A><BR>
&nbsp;&nbsp;<font color=black>Account Browsing</FONT></A><BR>
&nbsp;&nbsp;<font color=black>Categories</FONT></A><BR>
&nbsp;&nbsp;<font color=black>EZ-Web</FONT></A><BR>
&nbsp;&nbsp;<font color=black>FTP Importing</FONT></A><BR>
&nbsp;&nbsp;<font color=black>General Config</FONT></A><BR>
&nbsp;&nbsp;<font color=black>GuestBook Config</FONT></A><BR>
&nbsp;&nbsp;<font color=black>Headers/Footers</FONT></A><BR>
&nbsp;&nbsp;<font color=black>onHold Accounts</FONT></A><BR>
&nbsp;&nbsp;<font color=black>Listing/Search Engine</FONT></A><BR>
&nbsp;&nbsp;<font color=black>Html Templates</FONT></A><BR>
&nbsp;&nbsp;<font color=black>User Information</FONT></A><BR>
&nbsp;&nbsp;<font color=black>Viewing Account</FONT></A><BR>
&nbsp;&nbsp;<font color=black>Web Board</FONT></A>
<BR><BR>
<img src="$url_to_icons/black.gif" width=130 height=5 border=0><BR><BR>
&nbsp;&nbsp;<font color=black>F.A.Q.s</FONT></A><BR>
&nbsp;&nbsp;<font color=black>Template Library</FONT></A><BR>
&nbsp;&nbsp;<font color=black>Graphic Sets</FONT></A>
<BR><BR>
<img src="$url_to_icons/black.gif" width=130 height=5 border=0><BR><BR>
&nbsp;&nbsp;<font color=black>Members Lounge</FONT></A><BR>
&nbsp;&nbsp;<font color=black>Help Forum</FONT></A><BR>

<BR><BR><BR>
	</TD>
	<TD>
		<img src="$url_to_icons/black.gif" width=5 height=1 border=0>
	</TD>
	<TD bgcolor=white width=100% valign=top>
	<TABLE border=0 cellpadding=6 width=100% height=100%><TR><TD valign=top><CENTER>
EOF
	
	
}


sub Footer {
print <<EOF;

</TD></TR>
<TR><TD valign=bottom>
<Div align=right><font color=#aaaaaa face=arial size=1>Copyright &copy; 1998-99 <font color=#aaaaaa>Scripts</FONT></a>.&nbsp;&nbsp;&nbsp;&nbsp;</FONT></DIV>
</TD></TR>
</TABLE>
</TD>
<TD width=5 height=5><img src="$url_to_icons/black.gif" width=5 height=5 border=0></TD>
</TR>
<TR>
	<TD colspan=5 height=5><img src="$url_to_icons/black.gif" width=5 height=5 border=0></TD>
</TR>
</TABLE>

<BR><BR>
EOF
}


sub error {
$error = $_[0] ;
if ($error == 9) {
print <<EOF;
<BR>
<font face=arial size=2><B>Wrong registration key</B>
<BR><BR>
<table width=90%><TR><TD><font face=arial size=2>The registration key is dynamically created each day and can be obtained from
<B>Solution&nbsp;Scripts</B></A>. Make sure the
key you are using is for: <BR><BR><B><font color=red>$gnow</FONT></B> Greenwich Mean Time
<BR><BR>
If you have any problems, please send an email to scripts</B></A>
stating you community Builder User Name. 
</TD></TR></TABLE><BR><BR>
EOF
&Footer;
exit;
}
print <<EOF;
<html>
<head>
<title>Error</title>
</head>
<body>
<TABLE border=1 bgcolor=Gainsboro><TR align=left><TD>
<font face="arial, arial, Geneva" size="1">
<B>Commuinty Builder Error<BR><BR>
<BR><BR>
<I>$error -- $!</I><BR><BR>
If you are having problems running Community Builder<BR>
please post a message to the Forum </a>
<BR>
</TD></TR></TABLE>
</BODY></HTML>
EOF
exit;
}

sub demo {

print <<EOF;
<html>
<head>
<title>Error</title>
</head>
<body>
<TABLE border=1 bgcolor=Gainsboro><TR align=left><TD>
<font face="arial" size="-1"><center>
<B>Community Builder Feature<BR><BR>
<BR><BR>
This Is Community Builder Script Made By The Script People</a>
<BR><BR>
</TD></TR></TABLE>
</BODY></HTML>
EOF
&Footer;
exit;
}




