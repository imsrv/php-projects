#!/usr/bin/perl
#!/usr/local/bin/perl
#!/usr/local/bin/perl5
#!C:\perl\bin\perl.exe -w 
=Copyright Infomation
==========================================================
                                                   Mewsoft 

    Program Name    : Mewsoft Auction Software
    Program Version : 3.0
    Program Author  : Elsheshtawy, Ahmed Amin.
    Home Page       : http://www.mewsoft.com
    Nullified By    : TNO (T)he (N)ameless (O)ne

 Copyrights © 2000-2001 Mewsoft. All rights reserved.
==========================================================
 This software license prohibits selling, giving away, or otherwise distributing 
 the source code for any of the scripts contained in this SOFTWARE PRODUCT,
 either in full or any subpart thereof. Nor may you use this source code, in full or 
 any subpart thereof, to create derivative works or as part of another program 
 that you either sell, give away, or otherwise distribute via any method. You must
 not (a) reverse assemble, reverse compile, decode the Software or attempt to 
 ascertain the source code by any means, to create derivative works by modifying 
 the source code to include as part of another program that you either sell, give
 away, or otherwise distribute via any method, or modify the source code in a way
 that the Software looks and performs other functions that it was not designed to; 
 (b) remove, change or bypass any copyright or Software protection statements 
 embedded in the Software; or (c) provide bureau services or use the Software in
 or for any other company or other legal entity. For more details please read the
 full software license agreement file distributed with this software.
==========================================================
              ___                         ___    ___    ____  _______
  |\      /| |     \        /\         / |      /   \  |         |
  | \    / | |      \      /  \       /  |     |     | |         |
  |  \  /  | |-|     \    /    \     /   |___  |     | |-|       |
  |   \/   | |        \  /      \   /        | |     | |         |
  |        | |___      \/        \/       ___|  \___/  |         |

==========================================================
                                 Do not modify anything below this line
==========================================================
=cut
#==========================================================
package Auction;
#==========================================================
# usage Email($From, $TO, $Subject,   $Message);
# $TO ="address1, address2, address3,....."
sub Email {
my ($From, $TO, $Subject,   $Message);
$From = $_[0];
$TO = $_[1];
$Subject = $_[2];
$Message = $_[3];

	if (!$Global{'Email_Status'}) {return;}

	if ($Global{'Mail_Program_Type'} == 0){
					open (MAIL, "| $Global{'Mail_Program_Or_SMTP_Server'} -t") 
							or &Exit("Can't open mail  Program $Global{'Mail_Program_Or_SMTP_Server'}"."<BR>Line ". __LINE__ . ", File ". __FILE__);
					print MAIL "To: $TO\n";
					print MAIL "From: $From\n";
					print MAIL "Subject: $Subject\n";
					print MAIL "X-Priority: 1\n";
					print MAIL "X-Mailer: Mewsoft-Online Business Software at www.mewsoft.com\n";
					if ($Global{'Email_Format'} == 1 ) {
							print MAIL "Content-type: text/html\n";
					}
					else{
							print MAIL "Content-type: text/plain\n";
					}
					print MAIL "$Message\n";
					close MAIL;
	}
	elsif ( $Global{'Mail_Program_Type'} == 4 ){ #Unix sendmail module sendmail.pm
					&Send_Email($From, $TO, $Subject,   $Message);
			}
	elsif ( $Global{'Mail_Program_Type'} == 3 ){ #SMTP server
					&SMTP_Mail($From, $TO, $Subject,   $Message);
	}
	elsif ( $Global{'Mail_Program_Type'} == 1 ){ # Windows Blat mail program
					&Blat_Mail($From, $TO, $Subject,   $Message);
	}
	elsif ( $Global{'Mail_Program_Type'} == 2 ){ # Windows windmail mail program
					&Wind_Mail($From, $TO, $Subject,   $Message);
	}
	else{ # No mail program specified
					return 0;
	}

	return 1;
}
#==========================================================
# SMTP Information http://freesoft.org/CIE/RFC/821/6.htm
#http://freesoft.org/CIE/RFC/821/14.htm:
#SEND <SP> FROM:<reverse-path> <CRLF>
#HELO <SP> <domain> <CRLF>
#QUIT <CRLF>
#MAIL FROM:<>
#DATA (DATA) "<CRLF>.<CRLF>" 
#RECIPIENT (RCPT)
#This command is used to identify an individual recipient of the mail data; multiple recipients are specified 
#by multiple use of this command. The forward-path consists of an optional list of hosts and a required 
#destination mailbox. When the list of hosts is present, it is a source route and indicates that the mail must be
#relayed to the next host on the list. If the receiver-SMTP does not implement the relay function it may user
#the same reply it would for an unknown local user (550). When mail is relayed, the relay host must remove
#itself from the beginning forward-path and put itself at the beginning of the reverse-path. When mail reaches 
#its ultimate destination (the forward-path contains only a destination mailbox), the receiver-SMTP inserts it 
#into the destination mailbox in accordance with its host mail conventions. 
#For example, mail received at relay host A with arguments 
#                  FROM:<USERX@HOSTY.ARPA>
#                 TO:<@HOSTA.ARPA,@HOSTB.ARPA:USERC@HOSTD.ARPA>
#will be relayed on to host B with arguments 
#                  FROM:<@HOSTA.ARPA:USERX@HOSTY.ARPA>
 #                 TO:<@HOSTB.ARPA:USERC@HOSTD.ARPA>.
#This command causes its forward-path argument to be appended to the forward-path buffer. 
#==========================================================
sub SMTP_Mail{
my($iaddr, $paddr, $proto, $Reply, $RCPT_List, $Curr_Email) = undef;
my ($Localhost, $Mail_Data, $SMTP_Server);	
my ($SMTP_Port, $Sender, $CRLF);
my ($From, $TO, $Subject,   $Message);
$From=$_[0];
$TO=$_[1];
$Subject=$_[2];
$Message=$_[3];

	use Socket;
	use Sys::Hostname;
	$Localhost = hostname;
	#------------------------------------------------------
	$SMTP_Server=$Global{'Mail_Program_Or_SMTP_Server'};
	$SMTP_Port = 25;
	#------------------------------------------------------
	$CRLF ="\x0D\x0A";
	 $Message =~ s/^\./\.\./gm; # handle . as first character
	$Message =~ s/\n/$CRLF/g;

	$Mail_Data = "To: $TO$CRLF";
    $Mail_Data .= "From: $From$CRLF";
    $Mail_Data .= "Reply-To: $From$CRLF";
    $Mail_Data .= "Sender: $From$CRLF";
    $Mail_Data .= "X-Priority: 1$CRLF";
	#X-Priority: $priority
	$Mail_Data .= "Subject: $Subject$CRLF";
	$Mail_Data .= "X-Mailer: Mewsoft-Online Business Software at www.mewsoft.com$CRLF";

	if ($Global{'Email_Format'} == 1 ) {
			$Mail_Data .= "Content-type:text/html$CRLF";
	}
	else{
			$Mail_Data .= "Content-Type: text/plain$CRLF";
	}
	
	#$Mail_Data .= "Content-Transfer-Encoding: 7bit$CRLF";
	$Mail_Data .= "$CRLF";
    $Mail_Data .= "$Message$CRLF";
	#------------------------------------------------------
	$iaddr = inet_aton($SMTP_Server) or die "no host: $SMTP_Server"."<BR>Line ". __LINE__ . ", File ". __FILE__;
    $paddr = sockaddr_in($SMTP_Port, $iaddr);

    $proto = getprotobyname('tcp');
    socket(SOCK, PF_INET, SOCK_STREAM, $proto) or die "Socket error: $!"."<BR>Line ". __LINE__ . ", File ". __FILE__;;

	connect(SOCK, $paddr) or die "Error in connecting to $SMTP_Server at port $SMTP_Port: $!"."<BR>Line ". __LINE__ . ", File ". __FILE__;
    $Reply = <SOCK>;
    return $Reply ."<BR>Line ". __LINE__ . ", File ". __FILE__  if $Reply =~ /^5/;
    #---------------------------------------------

	send(SOCK, "HELO $Localhost$CRLF", 0) or die "Fail to send \"HELO\" message: $!"."<BR>Line ". __LINE__ . ", File ". __FILE__;
    $Reply = <SOCK>;
    return $Reply ."<BR>Line ". __LINE__ . ", File ". __FILE__  if $Reply =~ /^5/;
    
	send(SOCK, "MAIL FROM: <$From>$CRLF", 0) or die "Fail to send \"MAIL FROM:\" message: $!"."<BR>Line ". __LINE__ . ", File ". __FILE__;
    $Reply = <SOCK>;
    return $Reply ."<BR>Line ". __LINE__ . ", File ". __FILE__  if $Reply =~ /^5/;
    
	send(SOCK, "RCPT TO: $TO<$TO>$CRLF", 0) or die "Fail to send \"RCPT TO:\" message: $!"."<BR>Line ". __LINE__ . ", File ". __FILE__;
	$Reply = <SOCK>;
	return $Reply."<BR>Line ". __LINE__ . ", File ". __FILE__ if $Reply =~ /^5/;

    send(SOCK, "DATA$CRLF", 0) or die "Fail to send \"DATA\" message: $!"."<BR>Line ". __LINE__ . ", File ". __FILE__;
    $Reply = <SOCK>;
    return $Reply ."<BR>Line ". __LINE__ . ", File ". __FILE__  if $Reply =~ /^5/;

	send(SOCK, "$Mail_Data$CRLF\.$CRLF", 0) or die "Fail to send data: $!"."<BR>Line ". __LINE__ . ", File ". __FILE__;
    $Reply = <SOCK>;
    return $Reply ."<BR>Line ". __LINE__ . ", File ". __FILE__  if $Reply =~ /^5/;
    
	send(SOCK, "QUIT$CRLF", 0) or die "Fail to send \"QUIT\" message: $!"."<BR>Line ". __LINE__ . ", File ". __FILE__;
    $Reply = <SOCK>;
    return $Reply ."<BR>Line ". __LINE__ . ", File ". __FILE__ if $Reply =~ /^5/;
    
	close(SOCK) or die "Fail close connectiong socket: $!"."<BR>Line ". __LINE__ . ", File ". __FILE__;

	return 0;

}
#============================================================
#Using sendmail.pm module to send mail
sub Send_Email {
my ($From, $TO, $Subject,   $Message);
my (@TO, $sm);

$From=$_[0];
$TO=$_[1];
$Subject=$_[2];
$Message=$_[3];
	
	#use sendmail;

	@TO=split(/\,/, $TO);

	#$sm = new SendMail($Global{'Mail_Program_Or_SMTP_Server'});
	#$sm->setDebug($sm->OFF);
	#$sm->From($From);
	#$sm->Subject($Subject);
	#$sm->To(@TO);
	#$sm->setMailBody($Message);

	#if ($sm->sendMail() != 0) {
			#print $sm->{'error'}."MAIL ERROR!!$CRLF";
			# exit -1;
			# exit 0;	
	#}

	return 0;
}
#==========================================================
#Blat Home page  http://gepasi.dbs.aber.ac.uk/softw/Blat.html
#The syntax for blat program is:
#Blat <filename> -t <recipient> [optional switches (see below)]
#Blat -install <server addr>
#Blat -h [-q]
#-install <server addr> <sender's addr>: sets default SMTP server and sender
 # <filename>     : file with the message body ('-' for console input, end with ^Z
#-t <recipient> : recipient list (comma separated)
#-s <subj>      : subject line
#-f <sender>    : overrides the default sender address (must be known to server)
#-i <addr>      : a 'From:' address, not necessari;y known to the SMTP server.
#-c <recipient> : carbon copy recipient list (comma separated)
#-b <recipient> : blind carbon copy recipient list (comma separated)
#-h             : dsplays this help
#-mime          : MIME Quoted-Printable Content-Transfer-Encoding.
#-q             : supresses *all* output.
#-server <addr> : overrides the default SMTP server to be used.
 
# Note that if the '-i' option is used, <sender> is included in 'Reply to:'
 #---------------------------------------------------------------
#$mail_program = "c:\\Winnt\\System32\\blat.exe";

sub Blat_Mail{
my($From, $TO, $Subject, $Message) = @_;
my ($Temp, @TO, $Send_TO);

	@TO=split(/\,/, $TO);
#	BEGIN{ srand $$.time }
	foreach $Send_TO (@TO) {
		do {
				$Temp  = "$Global{'Temp_Dir'}/". int (rand(9999999999)).".mail"
		} until (!-e $Temp);

		open (TEMP, ">$Temp") or &Exit("Can't Creat Temp Email File."."<BR>Line ". __LINE__ . ", File ". __FILE__);
		print TEMP "$Message";
		close TEMP;
		system("$Global{'Mail_Program_Or_SMTP_Server'} $Temp -s \"$Subject\" -t  $Send_TO -f $From");
		unlink $Temp;
	}

}
#==========================================================
sub Wind_Mail{
my($From, $TO, $Subject, $Message) = @_;
my ($Temp, @TO, $Send_TO);

	@TO=split(/\,/, $TO);
#	BEGIN{ srand $$.time }
	foreach $Send_TO (@TO) {
		do {
				$Temp  = "$Global{'Temp_Dir'}/". int (rand(9999999999)).".mail"
		} until (!-e $Temp);

		open(MAIL,">$Temp") or &Exit("Can't Creat Temp Email File."."<BR>Line ". __LINE__ . ", File ". __FILE__);
		print MAIL "To: $to$CRLF";
		print MAIL "From: $from$CRLF";
		print MAIL "Subject: $subject$CRLF$CRLF";
		print MAIL "$messagebody$CRLF";
		close (MAIL);
 
		system("$Global{'Mail_Program_Or_SMTP_Server'} -t -t -n $Temp"); 

		if (-e $Temp){
				unlink($Temp);
		}
	}

}
#==========================================================
#==========================================================
1;