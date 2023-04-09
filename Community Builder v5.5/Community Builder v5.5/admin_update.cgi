#!/usr/bin/perl
###
#######################################################
#		Community Builder v5.0
#     
#    		Created by Scripts
# 		Email: Community
#		Web: Community
#
#######################################################
#
#
# COPYRIGHT NOTICE:
#
# Copyright 1999 Scripts  All Rights Reserved.
#
# Selling the code for this program without prior written consent is
# expressly forbidden. In all cases
# copyright and header must remain intact.
#
#######################################################
$|=1;

$start_head ="<!-- START HOME FREE HEADER CODE -->\n";
$start_foot ="<!-- START HOME FREE FOOTER CODE -->\n";
$end_head ="<!-- END HOME FREE HEADER CODE -->\n";
$end_foot ="<!-- END HOME FREE FOOTER CODE -->\n";

require "variables.pl";

$debug=0;

@char_set = ('a'..'z','0'..'9');
print "Content-type: text/html\n\n ";

$member=$ENV{'QUERY_STRING'};
$cgiurl = $ENV{'SCRIPT_NAME'};

if ($member) {
	@pairs=split(/&/,$member);
	foreach $item(@pairs) {
		($name,$content)=split (/=/,$item,2);
		$content=~tr/+/ /;
		$content=~ s/%(..)/pack("c",hex($1))/ge;
		if ($INPUT{$name}) { $INPUT{$name} = $INPUT{$name}.",".$content; }
		else { $INPUT{$name} = $content; }
	}
}

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
}

if ($INPUT{'display'} eq "top") {
print <<EOF;
<HTML><HEAD></HEAD><BODY>
<font face=arial>
Updating users html files to reflect current headers and footers<BR><BR>
This may take some time, please do not hit stop or leave this page until<BR>
<B>DONE</B> is diplayed in the bottom frame.<BR><BR>
</BODY></HTML>
EOF
exit;
}
if ($INPUT{'display'} eq "topemail") {
print <<EOF;
<HTML><HEAD></HEAD><BODY>
<font face=arial>
Sending out emails to current accounts.<BR><BR>
This may take some time, please do not hit stop or leave this page until<BR>
<B>DONE</B> is diplayed in the bottom frame.<BR><BR>
</BODY></HTML>
EOF
exit;
}


$per = $INPUT{'per'};
$catas = $INPUT{'catas'};
$dcata = $INPUT{'dcata'};
$dper = $INPUT{'dper'};
$daccount=$INPUT{'daccount'};
$total=$INPUT{'total'};
$dletter= $INPUT{'dletter'};
$session = $INPUT{'session'};

if ($catas eq "_all_") {
   $catas = "accounts";
   
   open (ACC, "$path/categories.txt");
   @cata_data = <ACC>;
   close (ACC);

   foreach $cata_line(@cata_data) {
	   chomp($cata_line);
	   @abbo = split(/\|/,$cata_line);
	   ($key,$abbo[0]) = split(/\%\%/,$abbo[0]);
	   $catas .= ",$key";
   }
}

if ($INPUT{'display'} eq "start") {
print <<EOF;
<HTML>
<HEAD>
	<TITLE>Community Header-Footer Updating in progress</TITLE>
</HEAD>
<FRAMESET ROWS="150,*" COLS="100%" border=0 >
	<FRAME NAME="TOP" SRC="$cgiurl?display=top"  FRAMEBORDER=0 frameborder="NO" border=0 MARGINHEIGHT=5 MARGINWIDTH=5 framespacing=0>

	<FRAME NAME="MAIN" SRC="$cgiurl?per=$per&catas=$catas&session=$session" "SCROLLING="NO" FRAMEBORDER=0 frameborder="NO" border=0 MARGINHEIGHT=5 MARGINWIDTH=5 framespacing=0>
</FRAMESET>
<NOFRAMES>
<BODY bgcolor="#FFFFFF">
<P>
Sorry, you must use a frames-capable browser (such as Microsoft Internet Explorer 3.0 or higher or Netscape Navigator 2.0 or higher).

</BODY>
</NOFRAMES>
</HTML>
EOF
exit;
}
if ($INPUT{'display'} eq "email") {
print <<EOF;
<HTML>
<HEAD>
	<TITLE>Community emailing in progress</TITLE>
</HEAD>
<FRAMESET ROWS="150,*" COLS="100%" border=0 >
	<FRAME NAME="TOP" SRC="$cgiurl?display=topemail"  FRAMEBORDER=0 frameborder="NO" border=0 MARGINHEIGHT=5 MARGINWIDTH=5 framespacing=0>

	<FRAME NAME="MAIN" SRC="$cgiurl?action=email&per=$per&catas=$catas&session=$session" "SCROLLING="NO" FRAMEBORDER=0 frameborder="NO" border=0 MARGINHEIGHT=5 MARGINWIDTH=5 framespacing=0>
</FRAMESET>
<NOFRAMES>
<BODY bgcolor="#FFFFFF">
<P>
Sorry, you must use a frames-capable browser (such as Microsoft Internet Explorer 3.0 or higher or Netscape Navigator 2.0 or higher).

</BODY>
</NOFRAMES>
</HTML>
EOF
exit;
}

#&verify_session;


open (ACC, "$path/categories.txt");
@cata_data = <ACC>;
close (ACC);

foreach $cata_line(@cata_data) {
	chomp($cata_line);
	@abbo = split(/\|/,$cata_line);
	($key,$abbo[0]) = split(/\%\%/,$abbo[0]);
	$cataa{$key}=$cata_line;
}
	


$dir = "$path/members";

## GET LIST OF ALL DIRS ##
@dirs = split(/\,/,$catas);

unless ($dcata) { $dcata = $dirs[0]; } # IF NO CURRENT CATA, SET FIRST AS CURRENT #
unless ($dletter) { $dletter = "a"; } # IF NO CURRENT LETTER, SET FIRST AS a #

undef $/;

$num_cata=0;
foreach $cata(@dirs) {
	print "<HR>cata - $cata<BR>" if $debug;
	$num_cata++;

	if ($cata ne $dcata) { next; } # CHECK IF CURRENT CATA #
	$dcata = $dirs[$num_cata];

		
	if ($cataa{$cata}) {
	   @values = split(/\|/,$cataa{$cata});
	   ($null,$cpath) = split(/\%\%/,$values[0]);
	   $file_header = $values[3];
	   $file_footer = $values[4];

	   print "header - $file_header - footer - $file_footer<BR>" if $debug;
	
	   $bhead='';	
	   if (-e "$path/$file_header") {
	   open (DAT,"<$path/$file_header");
	   $bhead = <DAT>;
	   close (DAT);
	   }
	
	   $bfoot='';	
	   if (-e "$path/$file_footer") {	
	   open (DAT,"<$path/$file_footer");
	   $bfoot = <DAT>;
	   close (DAT);
	}
	
	   $bhead =~ s/(.)*?\n//;
	   $bfoot =~ s/(.)*?\n//;
	}
	else {
		$bhead='';	
	   	if (-e "$path/header_html.txt") {
		 open (DAT,"<$path/header_html.txt");
		 $bhead = <DAT>;
		 close (DAT);
		}
		$bfoot='';	
	   	if (-e "$path/footer_html.txt") {	
		 open (DAT,"<$path/footer_html.txt");
		 $bfoot = <DAT>;
		 close (DAT);
		}
	}
	
	$num_chset=0;
	foreach $ch(@char_set) {
		$num_chset++;
		print "letter - $ch<BR>" if $debug;
		if ($dletter ne $ch) { next; } # CHECK IF CURRENT LETTER #
		$dletter=@char_set[$num_chset];
		
		opendir (DIR, "$dir/$cata/$ch") || &error("can not open $dir/$cata/$ch");
		@acc_arr = grep {!(/^\./) && -f "$dir/$cata/$ch/$_"}  readdir(DIR);
		close (DIR); 			
		unless ($daccount) { $daccount = $acc_arr[0]; } # IF NO CURRENT ACCOUNT, SET FIRST AS CURRENT #
		
		$num_acc=0;
		foreach $account(@acc_arr) {
			print "account - $account<BR>" if $debug;
			$num_acc++;
			
			if ($daccount ne $account) { next; } # CHECK IF CURRENT ACCOUNT #
			
			$daccount = $acc_arr[$num_acc];
			
			
			undef $/;
			open (ACC, "$dir/$cata/$ch/$account") || &error("Error reading $dir/$cata/$ch/$account");
			$acc_data = <ACC>;
			close (ACC);
			
			$faccount = $account;
			$faccount =~ s/\.dat//;
 			
			@acco = split(/\n/,$acc_data);

			if ($INPUT{'action'} eq "email") {
				open (PASSWORD, "$path/sendemail.txt");
				@email = <PASSWORD>;
				close (PASSWORD);
			
				$subject = $email[0];
				$email[0] = "";
			
				$subject = "$subject\n";
				$message = "@email \n\n";
				&write_email($acco[0],$subject,$message);

				$status ="Emailing";
				$action="email";
			}
			else {
				if ($cata eq "accounts") {
					$dir_acc = "$free_path/$faccount";
				}
				else {
					$dir_acc = "$free_path/$cpath/$faccount";
				}
				unless ($acco[7]) {
					$acco[7] = "on";
				}
				if ($acco[7] eq "on") {
					&dir_hf("$dir_acc",1);
				}
				else {
					 &dir_hf("$dir_acc",0);	
				}
				$status ="Updating";
				$action="update";
			}
			$numaccounts ++;
			$total++;
			if ($numaccounts eq $per) {
print <<EOF;
<HTML><HEAD>
<meta http-equiv="Refresh" content="2; URL=$cgiurl?session=$session&per=$per&catas=$catas&dcata=$cata&dletter=$ch&daccount=$account&total=$total&action=$action">
</head>
<BODY bgcolor=#FFFFFF>
<BR><BR>
<blockquote>
<FONT FACE="Verdana, Arial" size=-1><B>
<FONT FACE="Courier New" size=+1><B>$status.... Please Wait!!</B></FONT>
<P>
$status $total accounts....<BR><BR>
We are now $status the next $per accounts starting at:<BR>
Category: $cata<BR>
Letter: $ch<BR>
Account: $faccount<BR><BR>
</FONT></blockquote></BODY></HTML>
EOF
exit;
	 		}			
		}
	}
	$dletter="a";
}
print <<EOF;
<HTML><BODY>
<h1 align=center>Done $status..........</H1>
<BR><BR>
EOF
exit;


########## DIR HEADERS FOOTERS ##########
sub dir_hf {

my $direc = $_[0];
my $add = $_[1];
my (@dirs,$new_dir);

opendir(DIR,$direc);
@dirs = grep {!(/^\./) && -d "$direc/$_" } readdir(DIR);
close DIR;
@dirs = sort(@dirs);

$type = 0;
if (($direc =~ /$dir_acc\/wwwboard/) && $wwwboard_header) {
	open (HEAD, "$path/wwwboard_header.txt");
	$wheader = <HEAD>;
	close (HEAD);

	open (HEAD, "$path/wwwboard_footer.txt");
	$wfooter = <HEAD>;
	close (HEAD);
	
	$afoot = $wfooter;
	$ahead = $wheader;
}
else {
	$afoot = $bfoot;
	$ahead = $bhead;
}

opendir (DIR, "$direc");
@files = grep {(/\.html/i) || (/\.htm/i) || (/\.shtml/i) && -f "$direc/$_"}  readdir(DIR);
close (DIR); 

foreach $file(@files) {
	$full_file = "$direc/$file";
	$num_files ++;
	if (($full_file =~ /$dir_acc\/guestbook\.html/) && $gbook_header) {
		open (HEAD, "$path/gbook_header.txt");
		$wheader = <HEAD>;
		close (HEAD);
	
		open (HEAD, "$path/gbook_footer.txt");
		$wfooter = <HEAD>;
		close (HEAD);
		
		$afoot = $wfooter;
		$ahead = $wheader;
	}
	else {
		$afoot = $bfoot;
		$ahead = $bhead;
	}
	
	open (DAT,"<$direc/$file");
	$content = <DAT>;
	close (DAT);

	$content = &remove_header;
	$content = &remove_header;


	if ($add) {
		$new_content = &add_header($type);
	}
	else {
		$new_content = $content;
	}
	open (FILE, ">$direc/$file");
	print FILE $new_content;
	close (FILE);
	
}

for $new_dir(0..$#dirs) {
	&dir_hf("$direc/$dirs[$new_dir]",$add);
}

}


########## ADD HEADER AND FOOTER ##########
sub add_header {

$type = $_[0];

$*=1;

$header = "\n$start_head";
$header .="$ahead\n";
$header .= "$end_head";

$footer = "\n$start_foot";
$footer .="$afoot\n";
$footer .= "$end_foot";

unless ($frameset && ($content =~ /<(.|\n)*?FRAMESET(.|\n)*?>/i)) {

	$content =~ s/<(.|\n)*?BODY(.|\n)*?>/$&$header/i;
	unless ($content =~ /$start_head/) {
		$content = $header . $content;
	}
	$content =~ s/<\/BODY(.|\n)*?>/$&$footer/i;
	unless ($content =~ /$start_foot/) {
		$content = $content . $footer
	}
}
return($content);
}

########## REMOVE HEADER FOOTER #########
sub remove_header {

$*=1;
$content =~ s/$start_head(.|\n)*?$end_head\n*//i;
$content =~ s/$start_foot(.|\n)*?$end_foot\n*//i;

return($content);
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

