


# Copyright 1999 - 2000 Diran Alemshah.  All Rights Reserved.
#
# LICENSOR'S PROGRAM IS COPYRIGHTED AND LICENSED (NOT SOLE).
# LICENSOR DOES NOT SELL OR TRANSFER TITLE TO THE LICENSED
# PROGRAM TO YOU. YOUR LICENSE OF THE LICENSED PROGRAM WILL
# NOT COMMENCE UNTIL YOU HAVE EXECUTED THIS AGREEMENT AND AN
# AUTHORIZED REPRESENTATIVE OF LICENSOR HAS RECEIVED, APPROVED,
# AND EXECUTED A COPY OF IT AS EXECUTED BY YOU.
# 1. License Grant.</B> Licensor hereby grants to you, and you
# accept, a nonexclusive license to use the downloaded computer
# programs, object code form only (collectively referred to as
# the &quot;Software&quot;), and any accompanying User Documentation,
# only as authorized in this License Agreement. The Software may be
# used on any website owned by Licensee, or if Licensee is a company
# or corporation, any website owned by Licensee company or corporation.
# You agree that you will not assign, sublicense, transfer, pledge,
# lease, rent, or share your rights under this License Agreement.
# You agree that you may not reverse assemble, reverse compile, or
# otherwise translate the Software<BR> <BR> Upon loading the Software
# into your computer, you may make a copy of the Software for
# backup purposes. You may make one copy of any User's Manual
# provided for backup purposes. Any such copies of the Software
# or the User's Manual shall include Licensor's copyright and other
# proprietary notices. Except as authorized under this paragraph,
# no copies of the Program or any portions thereof may be made by
# you or any person under your authority or control.
# 2. License Fees.  The license fees paid by you are paid
# in consideration of the licenses granted under this License
# Agreement. You are solely responsible for payment of any taxes
# (including sales or use taxes, intangible taxes, and property taxes)
# resulting from your acceptance of this license and your possession
# and use of the Licensed Program, exclusive of taxes based on
# Licensor's income. Licensor reserves the right to have you
# pay any such taxes as they fall due to Licensor for remittance to
# the appropriate authority. You agree to hold harmless Licensor
# from all claims and liability arising from your failure to report
# or pay such taxes.
# 3. This License Agreement is effective upon your submission of this form.
# 4. Limited Warranty. Licensor warrants, for your benefit alone,
# that the Licensed Program conforms in all material respects to
# the specifications for the current version of the Licensed Program.
# This warranty is expressly conditioned on your observance of the
# operating, security, and data-control procedures set forth in the
# User's Manual included with the Licensed Program.
# 
# EXCEPT AS EXPRESSLY SET FORTH IN THIS AGREEMENT, LICENSOR
# DISCLAIMS ANY AND ALL PROMISES, REPRESENTATIONS, AND WARRANTIES
# WITH RESPECT TO THE LICENSED PROGRAM, INCLUDING ITS CONDITION,
# ITS CONFORMITY TO ANY REPRESENTATION OR DESCRIPTION, THE EXISTENCE
# OF ANY LATENT OR PATENT DEFECTS, ANY NEGLIGENCE, AND ITS
# MERCHANTABILITY OR FITNESS FOR A PARTICULAR USE.
# 5. Limitation of Liability.</B> Licensor's cumulative liability
# to you or any other party for any loss or damages resulting
# from any claims, demands, or actions arising out of or relating
# to this Agreement shall not exceed the license fee paid to Licensor
# for the use of the Program. In no event shall Licensor be liable
# for any indirect, incidental, consequential, special, or exemplary
# damages or lost profits, even if Licensor has been advised of the
# possibility of such damages.
# 6. Proprietary Protection. Licensor shall have sole and exclusive
# ownership of all right, title, and interest in and to the Licensed
# Program and all modifications and enhancements thereof (including
# ownership of all trade secrets and copyrights pertaining thereto),
# subject only to the rights and privileges expressly granted to you
# herein by Licensor. This Agreement does not provide you with title
# or ownership of the Licensed Program, but only a right of limited
# use. You must keep the Licensed Program free and clear of all claims,
# liens, and encumbrances.
# 7. Restrictions. You may not use, copy, modify, or distribute the
# Licensed Program (electronically or otherwise), or any copy,
# adaptation, transcription, or merged portion thereof, except as
# expressly authorized by Licensor. You may not reverse assemble,
# reverse compile, or otherwise translate the Licensed Program.
# Your rights may not be transferred, leased, assigned, or sublicensed
# except for a transfer of the Licensed Program in its entirety to
# (1) a successor in interest of your entire business who assumes
# the obligations of this Agreement or (2) any other party who is
# reasonably acceptable to Licensor, enters into a substitute
# version of this Agreement, and pays an administrative fee intended
# to cover attendant costs. No service bureau work, multiple-user
# license, or time-sharing arrangement is permitted, except as
# expressly authorized by Licensor. If you use, copy, or modify
# the Licensed Program or if you transfer possession of any copy,
# adaptation, transcription, or merged portion of the Licensed
# Program to any other party in any way not expressly authorized
# by Licensor, your license is automatically terminated.
# 8. Licensor's Right Of Entry.</B> You hereby authorize Licensor
# to enter your premises in order to inspect the Licensed Program
# in any reasonable manner during regular business hours to verify
# your compliance with the terms hereof.
# 9. Injunctive Relief.</B> You acknowledge that, in the event
# of your breach of any of the foregoing provisions, Licensor
# will not have an adequate remedy in money or damages. Licensor
# shall therefore be entitled to obtain an injunction against such
# breach from any court of competent jurisdiction immediately upon
# request. Licensor's right to obtain injunctive relief shall not
# limit its right to seek further remedies.
# 10. Trademark. COMMISSION CART(TM), ACCOUNT MANAGER(TM), PICLINK
# ADVERTISER(TM), BANDWIDTH PROTECTOR(TM), PC CONFIGURATOR(TM),
# Subscribe Me(TM) Professional
# are all trademarks of Licensor. No right, license, or interest
# to such trademark is granted hereunder, and you agree that no
# such right, license, or interest shall be asserted by you with
# respect to such trademark.
# 11. Governing Law.  This License Agreement shall be construed
# and governed in accordance with the laws of the State of California,
# USA.
# 12. Costs of Litigation. If any action is brought by either party
# to this License Agreement against the other party regarding the
# subject matter hereof, the prevailing party shall be entitled
# to recover, in addition to any other relief granted, reasonable
# attorney fees and expenses of litigation.
# 13. Severability. Should any term of this License Agreement be
# declared void or unenforceable by any court of competent
# jurisdiction, such declaration shall have no effect on the
# remaining terms hereof.
# 14. No Waiver. The failure of either party to enforce any
# rights granted hereunder or to take action against the other
# party in the event of any breach hereunder shall not be deemed
# a waiver by that party as to subsequent enforcement of rights
# or subsequent actions in the event of future breaches.
# 15. Integration.  THIS AGREEMENT IS THE COMPLETE AND EXCLUSIVE
# STATEMENT OF LICENSOR'S OBLIGATIONS AND RESPONSIBILITIES TO YOU
# AND SUPERSEDES ANY OTHER PROPOSAL, REPRESENTATION, OR OTHER
# COMMUNICATION BY OR ON BEHALF OF LICENSOR RELATING TO THE
# SUBJECT MATTER HEREOF
##############################################################
# DO NOT EDIT BELOW THIS LINE
##############################################################


sub  sendmail {


	my($to, $from, $subject, $body, $tempfile) = @_;

	if (lc $mailusing eq 'sendmail')   
		{
		open (MAIL, "|$mailprog -t -oi") || print ("Can't open $mailprog!\n");
                if ($in{'html'}) {
                print MAIL "Content-type: text/html\n";
                }
		print MAIL "To: $to\r\n";
		print MAIL "From: $from\r\n";
		print MAIL "Subject: $subject\r\n";
		print MAIL "$body\r\n";
            print MAIL "\r\n\r\n";
		close MAIL;
		}
	else
		{
		if (lc $mailusing eq 'blat') 
			{

$tempfile = "$memberinfo/$to";
 
        open(MAIL,">$tempfile") || die("Cannot open $tempfile -- Check Directory Permissions : $!"); 


		print MAIL "$body\r\n";
            close MAIL;

        #'use' the process module.
        use Win32::Process;
       
        #theWin32:: module. Includes the Win32 error checking etc.
        # see Win32:: section for included functions.
        use Win32;
        
        #Create the process object.
        Win32::Process::Create($ProcessObj, $mailprog, "Blat $tempfile -t \"$to\" -i \"$from\" -s \"$subject\"  ", 0, DETACHED_PROCESS, ".")|| die ; 

        #Wait for the process to end. NO timeout 
        $ProcessObj->Wait(INFINITE);
        unlink($tempfile);

			}
		else
			{
			$err = &sockets_mail($to, $from, $subject, $body); 
			if ($err < 1)
				{print "<br>\nSendmail error # $err<br>\n";}			
			}
		}	
}


sub sockets_mail {

    my ($to, $from, $subject, $message) = @_;

    my ($replyaddr) = $from;
   
    if (!$to) { return -8; }

    my ($proto, $port, $smptaddr);

    my ($AF_INET)     =  2;
    my ($SOCK_STREAM) =  1;

    $proto = (getprotobyname('tcp'))[2];
    $port  = 25;

    $smtpaddr = ($smtp_addr =~ /^(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})$/)
                    ? pack('C4',$1,$2,$3,$4)
                    : (gethostbyname($smtp_addr))[4];

    if (!defined($smtpaddr)) { return -1; }

    if (!socket(S, $AF_INET, $SOCK_STREAM, $proto))             { return -2; }
    if (!connect(S, pack('Sna4x8', $AF_INET, $port, $smtpaddr))) { return -3; }

    # my($oldfh) = select(S); $| = 1; select($oldfh);

    select(S);
    $| = 1;
    select(STDOUT);

    $_ = <S>; if (/^[45]/) { close S; return -4; }

    print S "helo localhost\r\n";
    $_ = <S>; if (/^[45]/) { close S; return -5; }

    print S "mail from: $from\r\n";
    $_ = <S>; if (/^[45]/) { close S; return -5; }
   
    print S "rcpt to: $to\r\n";
    $_ = <S>; if (/^[45]/) { close S; return -6; }
    

    print S "data\r\n";
    $_ = <S>; if (/^[45]/) { close S; return -5; }


    if ($in{'html'}) {
    print S "Content-type: text/html\n";
    } else {
    print S "Content-Type: text/plain; charset=us-ascii\r\n";
    }
    print S "To: $to\r\n";
    print S "From: $from\r\n";
    print S "Reply-to: $replyaddr\r\n" if $replyaddr;
    print S "Subject: $subject\r\n\r\n";
    print S "$message";
    print S "\r\n.\r\n";

    $_ = <S>; if (/^[45]/) { close S; return -7; }

    print S "quit\r\n";
    $_ = <S>;

    close S;
    return 1;
}

sub mailing {
if ($in{'to_lists'} eq choose) {
print "Content-type: text/html\n\n";
print "Don't forget to choose a list to send your mailing to!<BR>";
exit;
}
open (PASSWORD, "$passfile/password.txt");
		$password = <PASSWORD>;
		close (PASSWORD);
		chop ($password) if ($password =~ /\n$/);


		if ($in{'password'}) {
			$newpassword = crypt($in{'password'}, "aa");
		}
		else {
                  
print "Content-type: text/html\n\n";

&header;
&header3;

print<<EOF;
   
    <CENTER>
    <TABLE BORDER="0" WIDTH="400">
      <TBODY>
      <TR>
        <TD>        
        <P ALIGN="CENTER"><BR><B><FONT FACE="verdana, arial, helvetica"><FONT COLOR="#FF0000">Subscribe
          Me</FONT> Status:<BR>
           Password Error!</FONT></B></P>
        
        <P><FONT SIZE="-1" FACE="verdana, arial, helvetica">Please press your browser's BACK button.  Be sure to enter your Administration Password correctly.</FONT></P>
     </TD>
      </TR>
    </TBODY>
    </TABLE></CENTER>

EOF
&footer2;
&footer;
exit;
		}
		unless ($newpassword eq $password) {

print "Content-type: text/html\n\n";

&header;
&header3;

print<<EOF;
   
    <CENTER>
    <TABLE BORDER="0" WIDTH="400">
      <TBODY>
      <TR>
        <TD>        
        <P ALIGN="CENTER"><BR><B><FONT FACE="verdana, arial, helvetica"><FONT COLOR="#FF0000">Subscribe
          Me</FONT> Status:<BR>
           Password Error!</FONT></B></P>
        
        <P><FONT SIZE="-1" FACE="verdana, arial, helvetica">Incorrect Password.  Please press your browser's back button and be sure to enter the correct Administration Password.</FONT></P>
     </TD>
      </TR>
    </TBODY>
    </TABLE></CENTER>

EOF
&footer2;
&footer;
exit;
		}

########################################


if ($in{'sendto'} eq choose) {
print "Content-type: text/html\n\n";
print "Please choose whom you would like to send this mailing to<BR>";
exit;
}

open(URL, ">$trackdir/$in{'to_lists'}-$datename-$hour-$sec.urlfile") or print "unable to create user info temp file.  Check your directory permission settings";
if ($LOCK_EX){ 
      flock(URL, $LOCK_EX); #Locks the file
	}
if ($in{'useurl'} =~ /\/$/) {
                       chop($in{'useurl'});
                       print URL "$in{'useurl'}";
                       } else {
                       print URL "$in{'useurl'}";
                       }
close (URL);




open (DB, "<$lists/lists.db");
if ($LOCK_EX){ 
      flock(DB, $LOCK_EX); #Locks the file
	}
@db_array = <DB>;
close (DB);

foreach $lines(@db_array) {
@edit_db = split(/\|/,$lines);

if ($edit_db[0] == $in{'to_lists'}) {

$admin_email = $edit_db[2];


last;
 }
}

open (SUBJECT, ">$memberinfo/mmailsubject.txt");
if ($LOCK_EX){ 
      flock(SUBJECT, $LOCK_EX); #Locks the file
	}

print SUBJECT "$in{'mail_subject'}|$in{'to_lists'}|$admin_email|$servername|$cgiurl|$in{'unsubscribe_address'}|$in{'to_lists'}-$datename-$hour-$sec|$in{'tracking'}|$in{'useurl'}|$in{'html'}|$in{'no_credit'}|0|0|0|0|0|0|0|0|0\n";
close (SUBJECT);

open (MESSAGE, ">$memberinfo/$in{'to_lists'}-$datename-$hour-$sec-mm.txt");
if ($LOCK_EX){ 
      flock(MESSAGE, $LOCK_EX); #Locks the file
	}

print MESSAGE "$in{'message'}";
close (MESSAGE);


$cmd = "$cgipath/blat_mail.$extension"; # script to give to perl
$cmdline = "perl $cmd"; # full command line (including perl as first word)

$ret = Win32::Spawn ($perlpath, $cmdline, $pid) or die "spawn - Perl Path = $perlpath  Path to blat_mail.$extension = $cmdline : $!";
1 if $ret or $pid; # drop warnings


&mailsent;
exit;
}





1;
