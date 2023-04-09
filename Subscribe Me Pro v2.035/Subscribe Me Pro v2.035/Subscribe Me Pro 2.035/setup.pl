#! /usr/bin/perl


# Copyright 1999-2000 Diran Alemshah.  All Rights Reserved.
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


##############
&MethGet;
&ReadParse;


sub ReadParse {
  local (*in) = @_ if @_;
  local ($i, $key, $val);

  # Read in text
  if (&MethGet) {
    $in = $ENV{'QUERY_STRING'};
  } elsif (&MethPost) {
    read(STDIN,$in,$ENV{'CONTENT_LENGTH'});
  }

  @in = split(/[&;]/,$in); 

  foreach $i (0 .. $#in) {
    # Convert plus's to spaces
    $in[$i] =~ s/\+/ /g;

    # Split into key and value.  
    ($key, $val) = split(/=/,$in[$i],2); # splits on the first =.

    # Convert %XX from hex numbers to alphanumeric
    $key =~ s/%(..)/pack("c",hex($1))/ge;
    $val =~ s/%(..)/pack("c",hex($1))/ge;

    # Associate key and value
    $in{$key} .= "\0" if (defined($in{$key})); # \0 is the multiple separator
    $in{$key} .= $val;

  }

  return scalar(@in); 
}
# MethGet
# Return true if this cgi call was using the GET request, false otherwise

sub MethGet {
  return ($ENV{'REQUEST_METHOD'} eq "GET");
}


# MethPost
# Return true if this cgi call was using the POST request, false otherwise

sub MethPost {
  return ($ENV{'REQUEST_METHOD'} eq "POST");
}

$val =~ s/<!--(.|\n)*-->//g;



$version = "2.035";
$programname = "Subscribe Me!";
$cgiurl = $ENV{'SCRIPT_NAME'};

if ($in{'cgipath'}) {
$cgipath = $in{'cgipath'};
} elsif ($cgipath) {
$cgipath = $cgipath;
} elsif ($ENV{'SCRIPT_FILENAME'}) {
$cgipath = $ENV{'SCRIPT_FILENAME'};
} elsif ($ENV{'PATH_TRANSLATED'}) {
$cgipath = $ENV{'PATH_TRANSLATED'};
$cgipath =~ s/\\/\//g;
}



# $cgipath =~ s/\/setup.cgi//;
# $cgipath =~ s/\/setup.pl//;

$cgipath =~ s/\/setup\.cgi$//;
$cgipath =~ s/\/setup\.pl$//;

unless ($in{'configs'}) {
$information = "$ENV{'DOCUMENT_ROOT'}/path-to-your-account/s";
}


&requireconfig;
&requiremail;



sub requireconfig {
if (-e "$cgipath/config.cgi") {
require "$cgipath/config.cgi";
} elsif  (-e "$cgipath/config.pl") {
require "$cgipath/config.pl";
}
}





sub requiremail {
if (-e "$cgipath/unix_mail.cgi") {
require "$cgipath/unix_mail.cgi";
} elsif  (-e "$cgipath/unix_mail.pl") {
require "$cgipath/unix_mail.pl";
} elsif  (-e "$cgipath/nt_mail.cgi") {
require "$cgipath/nt_mail.cgi";
} elsif  (-e "$cgipath/nt_mail.pl") {
require "$cgipath/nt_mail.pl";
}
}



sub requiresubscribe {

if (-e "$cgipath/s.cgi") {
require "$cgipath/s.cgi";
} elsif (-e "$cgipath/s.pl") {
require "$cgipath/s.pl";
}

}

if ($in{'RUNINSTALLATION'}) { &runinstallation; }
elsif ($in{'passcheck'}) {&passcheck; }
elsif ($in{'graphic'}) {&display_graphic; }
elsif ($in{'setpwd'}) { &setpwd; }
elsif ($in{'enterpass'}) {&passcheck; }
else {&install; }
exit;






sub install {



# $output = `which sendmail`;
$output = `whereis sendmail`;

$outperl = "$^X";



if ((!($outperl)) || (lc $outperl eq 'perl')) {
$outperl = `which perl`;
} 

if ((!($outperl)) || (lc $outperl eq 'perl')) {
$outperl = `which perl5`;
}

if ((!($outperl)) || (lc $outperl eq 'perl')) {
$outperl = "/usr/bin/perl";
} 

$outperl =~ s/\\/\//g;

if (!($output)) {
$output = "/usr/bin/sendmail";
}

unless ($ready == "1") {



print "Content-type: text/html\n\n";
&header;
&header2;
print<<EOF;

    
    <CENTER>
    <FORM METHOD="POST" ACTION="$cgiurl">
    <TABLE BORDER="0">
      <TR>
        <TD VALIGN="MIDDLE" ALIGN="CENTER" COLSPAN="3"><FONT SIZE="-1" FACE="verdana, arial, helvetica"><B>INSTALLER:</B>
        <FONT COLOR="#0000FF"><B>Subscribe Me Professional $version</B></FONT></FONT><BR>
         <BR>
        </TD>
      </TR>
      <TR>
        <TD VALIGN="MIDDLE" ALIGN="LEFT"><A HREF="javascript:Start('http://www.cgiscriptcenter.com/subscribe/install/pathtoperl.shtm')"><FONT FACE="verdana, arial, helvetica" SIZE="-1"><B>?</B></FONT></A>
        <FONT SIZE="-1" FACE="verdana, arial, helvetica" COLOR="#FF0000"><B>1.
        </B></FONT></TD>
        <TD VALIGN="MIDDLE" ALIGN="LEFT"><FONT SIZE="-1" FACE="verdana, arial, helvetica"><B>PATH
        TO PERL: </B></FONT></TD>
        <TD VALIGN="MIDDLE" ALIGN="RIGHT" WIDTH="210"><INPUT TYPE="TEXT" NAME="perlpath" VALUE="$outperl" SIZE="30"></TD>
      </TR>
      <TR>
        <TD VALIGN="MIDDLE" ALIGN="LEFT"><A HREF="javascript:Start('http://www.cgiscriptcenter.com/subscribe/install/pathtocgidir.shtm')"><FONT FACE="verdana, arial, helvetica" SIZE="-1"><B>?</B></FONT></A>
        <FONT SIZE="-1" FACE="verdana, arial, helvetica" COLOR="#FF0000"><B>2.
        </B></FONT></TD>
        <TD VALIGN="MIDDLE" ALIGN="LEFT"><FONT SIZE="-1" FACE="verdana, arial, helvetica"><B>PATH
        TO CGI DIRECTORY: </B></FONT></TD>
        <TD VALIGN="MIDDLE" ALIGN="RIGHT" WIDTH="210"><INPUT TYPE="TEXT" NAME="cgipath" VALUE="$cgipath" SIZE="30"></TD>
      </TR>
      <TR>
        <TD VALIGN="MIDDLE" ALIGN="LEFT"><A HREF="javascript:Start('http://www.cgiscriptcenter.com/subscribe/install/pathtoroot.shtm')"><FONT FACE="verdana, arial, helvetica" SIZE="-1"><B>?</B></FONT></A>
        <FONT SIZE="-1" FACE="verdana, arial, helvetica" COLOR="#FF0000"><B>3.
        </B></FONT></TD>
        <TD VALIGN="MIDDLE" ALIGN="LEFT"><FONT SIZE="-1" FACE="verdana, arial, helvetica"><B>YOUR
        ROOT DIRECTORY: </B></FONT></TD>
        <TD VALIGN="MIDDLE" ALIGN="RIGHT" WIDTH="210"><INPUT TYPE="TEXT" NAME="information" VALUE="$information" SIZE="30"></TD>
      </TR>

<!-- Org Name Remove from here -->
      
      
<!-- Org Mail Remove from here -->
      
      <TR>
        <TD VALIGN="MIDDLE" ALIGN="LEFT"><A HREF="javascript:Start('http://www.cgiscriptcenter.com/subscribe/install/pathtomailprog.shtm')"><FONT FACE="verdana, arial, helvetica" SIZE="-1"><B>?</B></FONT></A>
        <FONT SIZE="-1" FACE="verdana, arial, helvetica" COLOR="#FF0000"><B>4.
        </B></FONT></TD>
        <TD VALIGN="MIDDLE" ALIGN="LEFT"><FONT SIZE="-1" FACE="verdana, arial, helvetica"><B>MAIL
        PROGRAM: </B></FONT></TD>
        <TD VALIGN="MIDDLE" ALIGN="RIGHT" WIDTH="210"><INPUT TYPE="TEXT" NAME="mailprog" VALUE="$output" SIZE="30"></TD>
      </TR>
      <TR>
        <TD VALIGN="MIDDLE" ALIGN="LEFT"><A HREF="javascript:Start('http://www.cgiscriptcenter.com/subscribe/install/filelock.shtm')"><FONT FACE="verdana, arial, helvetica" SIZE="-1"><B>?</B></FONT></A>
        <FONT SIZE="-1" FACE="verdana, arial, helvetica" COLOR="#FF0000"><B>5.
        </B></FONT></TD>
        <TD VALIGN="MIDDLE" ALIGN="LEFT"><FONT SIZE="-1" FACE="verdana, arial, helvetica"><B>FILE
        LOCKING: </B></FONT></TD>
        <TD VALIGN="MIDDLE" ALIGN="LEFT" WIDTH="210"><SELECT NAME="LOCK_EX" SIZE="1">
        <OPTION VALUE="2" SELECTED="SELECTED">ON</OPTION>
        <OPTION VALUE="0">OFF</OPTION></SELECT></TD>
      </TR>
      <TR>
        <TD VALIGN="MIDDLE" ALIGN="LEFT"><A HREF="javascript:Start('http://www.cgiscriptcenter.com/subscribe/install/websiteurl.shtm')"><FONT FACE="verdana, arial, helvetica" SIZE="-1"><B>?</B></FONT></A>
        <FONT SIZE="-1" FACE="verdana, arial, helvetica" COLOR="#FF0000"><B>6.
        </B></FONT></TD>
        <TD VALIGN="MIDDLE" ALIGN="LEFT"><FONT SIZE="-1" FACE="verdana, arial, helvetica"><B>WEBSITE
        URL: </B></FONT></TD>
        <TD VALIGN="MIDDLE" ALIGN="RIGHT" WIDTH="210"><INPUT TYPE="TEXT" NAME="websiteurl" VALUE="http://" SIZE="30"></TD>
      </TR>
      <TR>
        <TD VALIGN="MIDDLE" ALIGN="LEFT"><A HREF="javascript:Start('http://www.cgiscriptcenter.com/subscribe/install/os.shtm')"><FONT FACE="verdana, arial, helvetica" SIZE="-1"><B>?</B></FONT></A>
        <FONT SIZE="-1" FACE="verdana, arial, helvetica" COLOR="#FF0000"><B>7.
        </B></FONT></TD>
        <TD VALIGN="MIDDLE" ALIGN="LEFT"><FONT SIZE="-1" FACE="verdana, arial, helvetica"><B>UNIX
        OR NT SERVER: </B></FONT></TD>
        <TD VALIGN="MIDDLE" ALIGN="LEFT" WIDTH="210"><SELECT NAME="os" SIZE="1">
        <OPTION VALUE="unix" SELECTED="SELECTED">UNIX</OPTION>
        <OPTION VALUE="nt">NT</OPTION></SELECT></TD>
      </TR>
      <TR>
        <TD VALIGN="MIDDLE" ALIGN="LEFT"><A HREF="javascript:Start('http://www.cgiscriptcenter.com/subscribe/install/mailusing.shtm')"><FONT FACE="verdana, arial, helvetica" SIZE="-1"><B>?</B></FONT></A>
        <FONT SIZE="-1" FACE="verdana, arial, helvetica" COLOR="#FF0000"><B>8.
        </B></FONT></TD>
        <TD VALIGN="MIDDLE" ALIGN="LEFT"><FONT SIZE="-1" FACE="verdana, arial, helvetica"><B>MAIL
        USING: </B></FONT></TD>
        <TD VALIGN="MIDDLE" ALIGN="LEFT" WIDTH="210"><SELECT NAME="mailusing" SIZE="1">
        <OPTION VALUE="sendmail" SELECTED="SELECTED">Sendmail</OPTION>
        <OPTION VALUE="blat">BLAT</OPTION>
        <OPTION VALUE="sockets">Sockets</OPTION></SELECT></TD>
      </TR>
      <TR>
        <TD VALIGN="MIDDLE" ALIGN="LEFT"><A HREF="javascript:Start('http://www.cgiscriptcenter.com/subscribe/install/smtpmail.shtm')"><FONT FACE="verdana, arial, helvetica" SIZE="-1"><B>?</B></FONT></A>
        <FONT SIZE="-1" FACE="verdana, arial, helvetica" COLOR="#FF0000"><B>9.
        </B></FONT></TD>
        <TD VALIGN="MIDDLE" ALIGN="LEFT">
        <TABLE BORDER="0" WIDTH="180">
          <TR>
            <TD><FONT SIZE="-1" FACE="verdana, arial, helvetica"><B>SMTP MAIL
            SERVER: </B></FONT><BR>
            <FONT SIZE="-2" FACE="arial, helvetica"><B>Only needed if you
            chose Sockets mail above</B></FONT></TD>
          </TR>
        </TABLE></TD>
        <TD VALIGN="MIDDLE" ALIGN="RIGHT" WIDTH="210"><INPUT TYPE="TEXT" NAME="smtp_addr" VALUE="mail.yourserver.com" SIZE="30"></TD>
      </TR>
      <TR>
        <TD VALIGN="MIDDLE" ALIGN="LEFT"><A HREF="javascript:Start('http://www.cgiscriptcenter.com/subscribe/install/cgiextension.shtm')"><FONT FACE="verdana, arial, helvetica" SIZE="-1"><B>?</B></FONT></A>
        <FONT SIZE="-1" FACE="verdana, arial, helvetica" COLOR="#FF0000"><B>10.
        </B></FONT></TD>
        <TD VALIGN="MIDDLE" ALIGN="LEFT"><FONT SIZE="-1" FACE="verdana, arial, helvetica"><B>CGI
        EXTENSION:</B> </FONT></TD>
        <TD VALIGN="MIDDLE" ALIGN="LEFT" WIDTH="210"><SELECT NAME="extension" SIZE="1">
        <OPTION VALUE="pl" SELECTED="SELECTED">pl</OPTION>
        <OPTION VALUE="cgi">cgi</OPTION></SELECT></TD>
      </TR>
      <TR>
        <TD VALIGN="MIDDLE" ALIGN="LEFT"><A HREF="javascript:Start('http://www.cgiscriptcenter.com/subscribe/install/notification.shtm')"><FONT FACE="verdana, arial, helvetica" SIZE="-1"><B>?</B></FONT></A>
        <FONT SIZE="-1" FACE="verdana, arial, helvetica" COLOR="#FF0000"><B>11.
        </B></FONT></TD>
        <TD VALIGN="MIDDLE" ALIGN="LEFT"><FONT SIZE="-1" FACE="verdana, arial, helvetica"><B>ADMIN
        SIGN-UP<BR>
         NOTIFICATION:</B> </FONT></TD>
        <TD VALIGN="MIDDLE" ALIGN="LEFT" WIDTH="210"><SELECT NAME="notification" SIZE="1">
        <OPTION VALUE="ON" SELECTED="SELECTED">ON</OPTION>
        <OPTION VALUE="OFF">OFF</OPTION></SELECT></TD>
      </TR>
      <TR>
        <TD VALIGN="MIDDLE" ALIGN="LEFT"><A HREF="javascript:Start('http://www.cgiscriptcenter.com/subscribe/install/session.shtm')"><FONT FACE="verdana, arial, helvetica" SIZE="-1"><B>?</B></FONT></A>
        <FONT SIZE="-1" FACE="verdana, arial, helvetica" COLOR="#FF0000"><B>12.
        </B></FONT></TD>
        <TD VALIGN="MIDDLE" ALIGN="LEFT"><FONT SIZE="-1" FACE="verdana, arial, helvetica"><B>
        SESSION TIME:</B> </FONT></TD>
        <TD VALIGN="MIDDLE" ALIGN="LEFT" WIDTH="210"><SELECT NAME="session" SIZE="1">
        <OPTION VALUE="900">15 Minutes</OPTION>
        <OPTION VALUE="1800" SELECTED="SELECTED">30 Minutes</OPTION>
        <OPTION VALUE="3600">1 Hour</OPTION>
        <OPTION VALUE="5400">1.5 Hours</OPTION>
        <OPTION VALUE="7200">2 Hours</OPTION></SELECT> </TD>
      </TR>
      <TR>
        <TD VALIGN="MIDDLE" ALIGN="LEFT"><A HREF="javascript:Start('http://www.cgiscriptcenter.com/subscribe/install/permissions.shtm')"><FONT FACE="verdana, arial, helvetica" SIZE="-1"><B>?</B></FONT></A>
        <FONT SIZE="-1" FACE="verdana, arial, helvetica" COLOR="#FF0000"><B>13.
        </B></FONT></TD>
        <TD VALIGN="MIDDLE" ALIGN="LEFT"><FONT SIZE="-1" FACE="verdana, arial, helvetica"><B>SCRIPT
        PERMISSIONS :</B> </FONT></TD>
        <TD VALIGN="MIDDLE" ALIGN="LEFT" WIDTH="210"><SELECT NAME="permissions" SIZE="1">
        <OPTION VALUE="0755" SELECTED="SELECTED">755</OPTION>
        <OPTION VALUE="0777">777</OPTION></SELECT></TD>
      </TR>
      <TR>
        <TD VALIGN="MIDDLE" ALIGN="LEFT"></TD>
        <TD VALIGN="MIDDLE" ALIGN="LEFT" COLSPAN="2">
        
        <P><BR>
          <INPUT TYPE="SUBMIT" NAME="RUNINSTALLATION" VALUE="Run Configuration"><INPUT TYPE="RESET" NAME="Reset1"><BR>
          <BR>
          </P></TD>
      </TR>
    </TABLE></FORM></CENTER>
EOF
&footer2;
&footer;
exit;
}


&editconfigs;


sub editconfigs {

if ($session_id) {
$in{'session_id'} = $session_id;
} 



&sessioncheck;

print "Content-type: text/html\n\n";


&header;
&header2;
print<<EOF;

    <CENTER>
    <FORM METHOD="POST" ACTION="$cgiurl">
    <INPUT TYPE="HIDDEN" NAME="session_id" VALUE="$in{'session_id'}">
    <TABLE BORDER="0">
      <TR>
        <TD VALIGN="MIDDLE" ALIGN="LEFT"><A HREF="javascript:Start('http://www.cgiscriptcenter.com/subscribe/install/pathtoperl.shtm')"><FONT FACE="verdana, arial, helvetica" SIZE="-1"><B>?</B></FONT></A><FONT SIZE="-1" FACE="verdana, arial, helvetica" COLOR="#FF0000"><B> 1.
        </B></FONT></TD>
        <TD VALIGN="MIDDLE" ALIGN="LEFT"><FONT SIZE="-1" FACE="verdana, arial, helvetica"><B>PATH
        TO PERL: </B></FONT></TD>
        <TD VALIGN="MIDDLE" ALIGN="RIGHT" WIDTH="210"><INPUT TYPE="TEXT" NAME="perlpath" VALUE="$perlpath" SIZE="30"></TD>
      </TR>
      <TR>
        <TD VALIGN="MIDDLE" ALIGN="LEFT"><A HREF="javascript:Start('http://www.cgiscriptcenter.com/subscribe/install/pathtocgidir.shtm')"><FONT FACE="verdana, arial, helvetica" SIZE="-1"><B>?</B></FONT></A>
        <FONT SIZE="-1" FACE="verdana, arial, helvetica" COLOR="#FF0000"><B>2.
        </B></FONT></TD>
        <TD VALIGN="MIDDLE" ALIGN="LEFT"><FONT SIZE="-1" FACE="verdana, arial, helvetica"><B>PATH
        TO CGI DIRECTORY: </B></FONT></TD>
        <TD VALIGN="MIDDLE" ALIGN="RIGHT" WIDTH="210"><INPUT TYPE="TEXT" NAME="cgipath" VALUE="$cgipath" SIZE="30"></TD>
      </TR>
      <TR>
        <TD VALIGN="MIDDLE" ALIGN="LEFT"><A HREF="javascript:Start('http://www.cgiscriptcenter.com/subscribe/install/pathtoroot.shtm')"><FONT FACE="verdana, arial, helvetica" SIZE="-1"><B>?</B></FONT></A>
        <FONT SIZE="-1" FACE="verdana, arial, helvetica" COLOR="#FF0000"><B>3.
        </B></FONT></TD>
        <TD VALIGN="MIDDLE" ALIGN="LEFT"><FONT SIZE="-1" FACE="verdana, arial, helvetica"><B>YOUR
        ROOT DIRECTORY: </B></FONT></TD>
        <TD VALIGN="MIDDLE" ALIGN="CENTER"><INPUT TYPE="TEXT" NAME="information" VALUE="$information" SIZE="30"></TD>
      </TR>
<!-- Orgname and Orgmail removed here -->      
      <TR>
        <TD VALIGN="MIDDLE" ALIGN="LEFT"><A HREF="javascript:Start('http://www.cgiscriptcenter.com/subscribe/install/pathtomailprog.shtm')"><FONT FACE="verdana, arial, helvetica" SIZE="-1"><B>?</B></FONT></A>
        <FONT SIZE="-1" FACE="verdana, arial, helvetica" COLOR="#FF0000"><B>4.
        </B></FONT></TD>
        <TD VALIGN="MIDDLE" ALIGN="LEFT"><FONT SIZE="-1" FACE="verdana, arial, helvetica"><B>MAIL
        PROGRAM: </B></FONT></TD>
        <TD VALIGN="MIDDLE" ALIGN="LEFT"><INPUT TYPE="TEXT" NAME="mailprog" VALUE="$mailprog" SIZE="30"></TD>
      </TR>
      <TR>
        <TD VALIGN="MIDDLE" ALIGN="LEFT"><A HREF="javascript:Start('http://www.cgiscriptcenter.com/subscribe/install/filelock.shtm')"><FONT FACE="verdana, arial, helvetica" SIZE="-1"><B>?</B></FONT></A>
        <FONT SIZE="-1" FACE="verdana, arial, helvetica" COLOR="#FF0000"><B>5.
        </B></FONT></TD>
        <TD VALIGN="MIDDLE" ALIGN="LEFT"><FONT SIZE="-1" FACE="verdana, arial, helvetica"><B>FILE
        LOCKING: </B></FONT></TD>
        <TD VALIGN="MIDDLE" ALIGN="LEFT"><SELECT NAME="LOCK_EX" SIZE="1">
EOF


if ($LOCK_EX) {
print<<EOF; 
<OPTION VALUE="2" SELECTED="SELECTED">ON</OPTION>
<OPTION VALUE="0">OFF</OPTION>
EOF
} else {
print<<EOF;
<OPTION VALUE="0" SELECTED="SELECTED">OFF</OPTION>
<OPTION VALUE="2">ON</OPTION>
EOF
}
print<<EOF;

      </SELECT></TD>
      </TR>
      <TR>
        <TD VALIGN="MIDDLE" ALIGN="LEFT"><A HREF="javascript:Start('http://www.cgiscriptcenter.com/subscribe/install/websiteurl.shtm')"><FONT FACE="verdana, arial, helvetica" SIZE="-1"><B>?</B></FONT></A>
        <FONT SIZE="-1" FACE="verdana, arial, helvetica" COLOR="#FF0000"><B>6.
        </B></FONT></TD>
        <TD VALIGN="MIDDLE" ALIGN="LEFT"><FONT SIZE="-1" FACE="verdana, arial, helvetica"><B>WEBSITE
        URL: </B></FONT></TD>
        <TD VALIGN="MIDDLE" ALIGN="LEFT"><INPUT TYPE="TEXT" NAME="websiteurl" VALUE="$websiteurl" SIZE="30"></TD>
      </TR>
      <TR>
        <TD VALIGN="MIDDLE" ALIGN="LEFT"><A HREF="javascript:Start('http://www.cgiscriptcenter.com/subscribe/install/os.shtm')"><FONT FACE="verdana, arial, helvetica" SIZE="-1"><B>?</B></FONT></A>
        <FONT SIZE="-1" FACE="verdana, arial, helvetica" COLOR="#FF0000"><B>7.
        </B></FONT></TD>
        <TD VALIGN="MIDDLE" ALIGN="LEFT"><FONT SIZE="-1" FACE="verdana, arial, helvetica"><B>UNIX
        OR NT SERVER: </B></FONT></TD>
        <TD VALIGN="MIDDLE" ALIGN="LEFT"><SELECT NAME="os" SIZE="1">
EOF


if ($os eq 'unix') {
print<<EOF; 
<OPTION VALUE="unix" SELECTED="SELECTED">UNIX</OPTION>
<OPTION VALUE="nt">NT</OPTION>
EOF
} elsif ($os eq 'nt') {
print<<EOF;
<OPTION VALUE="nt" SELECTED="SELECTED">NT</OPTION>
<OPTION VALUE="unix">UNIX</OPTION>
EOF
}
print<<EOF;

      </SELECT></TD>
      </TR>
      <TR>
        <TD VALIGN="MIDDLE" ALIGN="LEFT"><A HREF="javascript:Start('http://www.cgiscriptcenter.com/subscribe/install/mailusing.shtm')"><FONT FACE="verdana, arial, helvetica" SIZE="-1"><B>?</B></FONT></A>
        <FONT SIZE="-1" FACE="verdana, arial, helvetica" COLOR="#FF0000"><B>8.
        </B></FONT></TD>
        <TD VALIGN="MIDDLE" ALIGN="LEFT"><FONT SIZE="-1" FACE="verdana, arial, helvetica"><B>MAIL
        USING: </B></FONT></TD>
        <TD VALIGN="MIDDLE" ALIGN="LEFT"><SELECT NAME="mailusing" SIZE="1">
EOF


if ($mailusing eq 'sendmail') {
print<<EOF; 
<OPTION VALUE="sendmail" SELECTED="SELECTED">Sendmail</OPTION>
<OPTION VALUE="blat">BLAT</OPTION>
<OPTION VALUE="sockets">Sockets</OPTION>
EOF
} elsif ($mailusing eq 'blat') {
print<<EOF;
<OPTION VALUE="blat" SELECTED="SELECTED">BLAT</OPTION>
<OPTION VALUE="sendmail">Sendmail</OPTION>
<OPTION VALUE="sockets">Sockets</OPTION>
EOF
} elsif ($mailusing eq 'sockets') {
print<<EOF;
<OPTION VALUE="sockets" SELECTED="SELECTED">Sockets</OPTION>
<OPTION VALUE="sendmail">Sendmail</OPTION>
<OPTION VALUE="blat">BLAT</OPTION>
EOF
}

print<<EOF;

      </SELECT>
      </TD>
      </TR>
      <TR>
        <TD VALIGN="MIDDLE" ALIGN="LEFT"><A HREF="javascript:Start('http://www.cgiscriptcenter.com/subscribe/install/smtpmail.shtm')"><FONT FACE="verdana, arial, helvetica" SIZE="-1"><B>?</B></FONT></A>
        <FONT SIZE="-1" FACE="verdana, arial, helvetica" COLOR="#FF0000"><B>9.
        </B></FONT></TD>
        <TD VALIGN="MIDDLE" ALIGN="LEFT">
        <TABLE BORDER="0" WIDTH="180">
          <TR>
            <TD><FONT SIZE="-1" FACE="verdana, arial, helvetica"><B>SMTP MAIL
            SERVER: </B></FONT><BR>
            <FONT SIZE="-2" FACE="arial, helvetica"><B>Only needed if you
            chose Sockets mail above</B></FONT></TD>
          </TR>
        </TABLE></TD>
        <TD VALIGN="MIDDLE" ALIGN="LEFT"><INPUT TYPE="TEXT" NAME="smtp_addr" VALUE="$smtp_addr" SIZE="30"></TD>
      </TR>
      <TR>
        <TD VALIGN="MIDDLE" ALIGN="LEFT"><A HREF="javascript:Start('http://www.cgiscriptcenter.com/subscribe/install/cgiextension.shtm')"><FONT FACE="verdana, arial, helvetica" SIZE="-1"><B>?</B></FONT></A>
        <FONT SIZE="-1" FACE="verdana, arial, helvetica" COLOR="#FF0000"><B>10.
        </B></FONT></TD>
        <TD VALIGN="MIDDLE" ALIGN="LEFT"><FONT SIZE="-1" FACE="verdana, arial, helvetica"><B>CGI
        EXTENSION:</B> </FONT></TD>
        <TD VALIGN="MIDDLE" ALIGN="LEFT"><SELECT NAME="extension" SIZE="1">

EOF

if ($extension eq "pl") {
print<<EOF;
<OPTION VALUE="pl" SELECTED="SELECTED">pl</OPTION>
<OPTION VALUE="cgi">cgi</OPTION>
EOF
} else {
print<<EOF;
<OPTION VALUE="pl">pl</OPTION>
<OPTION VALUE="cgi" SELECTED="SELECTED">cgi</OPTION>
EOF
}

print<<EOF;


      </SELECT></TD>
      </TR>
      <TR>
        <TD VALIGN="MIDDLE" ALIGN="LEFT"><A HREF="javascript:Start('http://www.cgiscriptcenter.com/subscribe/install/notification.shtm')"><FONT FACE="verdana, arial, helvetica" SIZE="-1"><B>?</B></FONT></A>
        <FONT SIZE="-1" FACE="verdana, arial, helvetica" COLOR="#FF0000"><B>11.
        </B></FONT></TD>
        <TD VALIGN="MIDDLE" ALIGN="LEFT"><FONT SIZE="-1" FACE="verdana, arial, helvetica"><B>ADMIN
        SIGN-UP<BR>
         NOTIFICATION:</B> </FONT></TD>
        <TD VALIGN="MIDDLE" ALIGN="LEFT"><SELECT NAME="notification" SIZE="1">
EOF

if ($notification eq "ON") {
print<<EOF
<OPTION VALUE="ON" SELECTED="SELECTED">ON</OPTION>
<OPTION VALUE="OFF">OFF</OPTION>
EOF
} else {
print<<EOF;
<OPTION VALUE="OFF" SELECTED="SELECTED">OFF</OPTION>
<OPTION VALUE="ON">ON</OPTION>
EOF
}

print<<EOF;

      </SELECT></TD>
        </TR>
        <TR>
        <TD VALIGN="MIDDLE" ALIGN="LEFT"><A HREF="javascript:Start('http://www.cgiscriptcenter.com/subscribe/install/session.shtm')"><FONT FACE="verdana, arial, helvetica" SIZE="-1"><B>?</B></FONT></A>
        <FONT SIZE="-1" FACE="verdana, arial, helvetica" COLOR="#FF0000"><B>12.
        </B></FONT></TD>
        <TD VALIGN="MIDDLE" ALIGN="LEFT"><FONT SIZE="-1" FACE="verdana, arial, helvetica"><B>        SESSION TIME:</B> </FONT></TD>
        <TD VALIGN="MIDDLE" ALIGN="LEFT"><SELECT NAME="session" SIZE="1">
EOF

if ($config_session eq '900') {
print<<EOF;
        <OPTION VALUE="900" SELECTED= "SELECTED">15 Minutes</OPTION>
        <OPTION VALUE="1800">30 Minutes</OPTION>
        <OPTION VALUE="3600">1 Hour</OPTION>
        <OPTION VALUE="5400">1.5 Hours</OPTION>
        <OPTION VALUE="7200">2 Hours</OPTION>
EOF
} elsif ($config_session eq '1800') {
print<<EOF;
        <OPTION VALUE="900">15 Minutes</OPTION>
        <OPTION VALUE="1800" SELECTED= "SELECTED">30 Minutes</OPTION>
        <OPTION VALUE="3600">1 Hour</OPTION>
        <OPTION VALUE="5400">1.5 Hours</OPTION>
        <OPTION VALUE="7200">2 Hours</OPTION>
EOF
} elsif ($config_session eq '3600') {
print<<EOF;
        <OPTION VALUE="900">15 Minutes</OPTION>
        <OPTION VALUE="1800">30 Minutes</OPTION>
        <OPTION VALUE="3600" SELECTED= "SELECTED">1 Hour</OPTION>
        <OPTION VALUE="5400">1.5 Hours</OPTION>
        <OPTION VALUE="7200">2 Hours</OPTION>
EOF
} elsif ($config_session eq '5400') {
print<<EOF;
        <OPTION VALUE="900">15 Minutes</OPTION>
        <OPTION VALUE="1800">30 Minutes</OPTION>
        <OPTION VALUE="3600">1 Hour</OPTION>
        <OPTION VALUE="5400" SELECTED= "SELECTED">1.5 Hours</OPTION>
        <OPTION VALUE="7200">2 Hours</OPTION>
EOF
} elsif ($config_session eq '7200') {
print<<EOF;
        <OPTION VALUE="900">15 Minutes</OPTION>
        <OPTION VALUE="1800">30 Minutes</OPTION>
        <OPTION VALUE="3600">1 Hour</OPTION>
        <OPTION VALUE="5400">1.5 Hours</OPTION>
        <OPTION VALUE="7200" SELECTED= "SELECTED">2 Hours</OPTION>
EOF
}

print<<EOF;
      </SELECT> </TD>
      </TR>
            <TR>
        <TD VALIGN="MIDDLE" ALIGN="LEFT"><A HREF="javascript:Start('http://www.cgiscriptcenter.com/subscribe/install/session.shtm')"><FONT FACE="verdana, arial, helvetica" SIZE="-1"><B>?</B></FONT></A>
        <FONT SIZE="-1" FACE="verdana, arial, helvetica" COLOR="#FF0000"><B>13.
        </B></FONT></TD>
        <TD VALIGN="MIDDLE" ALIGN="LEFT"><FONT SIZE="-1" FACE="verdana, arial, helvetica"><B>        SCRIPT PERMISSIONS:</B> </FONT></TD>
        <TD VALIGN="MIDDLE" ALIGN="LEFT"><SELECT NAME="permissions" SIZE="1">
EOF

if ($permissions eq '0755') {
print<<EOF;
        <OPTION VALUE="0755" SELECTED= "SELECTED">755</OPTION>
        <OPTION VALUE="0777">777</OPTION>
EOF
} elsif ($permissions eq '0777') {
print<<EOF;
        <OPTION VALUE="0777" SELECTED= "SELECTED">777</OPTION>
        <OPTION VALUE="0755">755</OPTION>
EOF
}
print<<EOF;
</SELECT> </TD>
      </TR>
      <TR>
        <TD VALIGN="MIDDLE" ALIGN="LEFT"></TD>
      </TR>
      <TR>
        <TD VALIGN="MIDDLE" ALIGN="LEFT"></TD>
        <TD VALIGN="MIDDLE" ALIGN="LEFT" COLSPAN="2">
        
        <P><INPUT TYPE="SUBMIT" NAME="RUNINSTALLATION" VALUE="Install/Update"><INPUT TYPE="RESET" NAME="Reset1"></P></TD>
      </TR>
    </TABLE></FORM></CENTER>
EOF
&footer2;
&footer;
exit;

}
}




sub runinstallation {


if ($ready) {

$sessioncheck;
#&blindcheck;
}


if ($in{'information'}) {
$information = "$in{'information'}";
} else {
&writeerror;
exit;

}


$filename = $in{'information'};
if ($filename) {
@aa =split(/\//,$filename);
$alen = push(@aa);
$alen = $alen -1;

$filename = $aa[$alen];
#$cgi_cfn{'upfile'} = $filename;
}


$information =~ s/\/$filename//;



print "Content-type: text/html\n\n";


sub writeerror {

&error1;
&maingraphic;
&error2;
print<<EOF;
Path Not Found or Not Writeable.
EOF
&error3;
print<<EOF;
<P><FONT SIZE="-1" COLOR="$fontcolor" FACE="verdana, arial, helvetica">
Can't set permissions on <B>$maindir</B> to <B>$in{'permissions'}</B> via this program.  Your server responded: <B>$!.</B>
EOF

if ($upload) {
print<<EOF;
<BR><BR>
It appears that you either didn't set the proper permissions on the directory, or you didn't upload the <B>$uploadfile</B> to the directory specified above.  
Subscribe Me Professional will not function without it!
EOF
}

print<<EOF;
<BR><BR>
A server response of <B>"Permission denied"</B> or anything similiar usually means that you are not able to write to this directory.  This may be because your permissions are set too low (use <B>777</B> if unsure), or you are not the "owner" of the directory (as far as Subscribe Me is concerned).  If you have tried changing the permissions to no avail, create another directory using FTP and set the permissions of that directory at <B>777</B>.  Be sure to give the path to the new directory in LINE 2 of your configuration panel.<BR><BR>

A server response of <B>"No such file or directory"</B> usually means that the path you specified
in LINE 2 of the configuration panel does not exist. Double-check your path and correct
the path in LINE 2 of your configuration settings.</FONT></P>
EOF
&error5;
unlink("$information/config.$in{'extension'}");

$upload = "";
exit;
}




$permissions = oct($in{'permissions'});
$information = "$in{'information'}";


unless ($in{'os'}) {
if ($os) { $in{'os'} = $os; }
}

unless ($in{'extension'}) {
if ($extension) { $in{'extension'} = $extension; }
}

unless ($in{'mailusing'}) {
if ($mailusing) { $in{'mailusing'} = $mailusing; }
}

if ($in{'os'} eq 'unix') {



unless (-e "$cgipath/unixmail_eng.$in{'extension'}") {

$maindir = "$cgipath/unixmail_eng.$in{'extension'}";
$upload = "1";
$uploadfile = "unixmail_eng.$in{'extension'}";
&writeerror;
exit;
}

} elsif ($in{'os'} eq 'nt') {

unless (-e "$cgipath/ntmail_eng.$in{'extension'}") {
$maindir = "$cgipath/ntmail_eng.$in{'extension'}";
$upload = "1";
$uploadfile = "ntmail_eng.$in{'extension'}";
&writeerror;
exit;
}

unless (-e "$cgipath/blatmail_eng.$in{'extension'}") {
$maindir = "$cgipath/blatmail_eng.$in{'extension'}";
$upload = "1";
$uploadfile = "blatmail_eng.$in{'extension'}";
&writeerror;
exit;
}
} 


#if ($in{'mailusing'} eq 'blat') {
if (lc $in{'os'} eq 'nt') {
chmod ($permissions,"$cgipath/blatmail_eng.$in{'extension'}");
open (MAIL3,"<$cgipath/blatmail_eng.$in{'extension'}") || die print "Can't find blatmail_eng.$in{'extension'}";
@database_mmail = <MAIL3>;
close(MAIL3);




open (MAIL4, ">$cgipath/blat_mail.$in{'extension'}") || die print "unable to create $cgipath/blat_mail.$in{'extension'}.  Check/increase your directory permission settings on your $cgipath directory";
chmod ($permissions,"$cgipath/blat_mail.$in{'extension'}");
if ($LOCK_EX){ 
      flock(MAIL4, $LOCK_EX); #Locks the file
	} 


print MAIL4 "#!$in{'perlpath'}\n\n";
print MAIL4 "require \"$cgipath/config.$in{'extension'}\";\n\n";


foreach $linesmm(@database_mmail) {
         chomp($lines);
         print MAIL4 "$linesmm";
         }          
close(MAIL4);


}


if ($in{'os'} eq 'unix') {

chmod ($permissions,"$cgipath/unixmail_eng.$in{'extension'}");
open (MAIL,"<$cgipath/unixmail_eng.$in{'extension'}") || die print "Can't find unixmail_eng.$in{'extension'}";
@database_mail = <MAIL>;
close(MAIL);



open (MAIL2, ">$cgipath/unix_mail.$in{'extension'}") or die &temperror1;

sub temperror1 {

$maindir = "$cgipath/unix_mail.$in{'extension'}";
$upload = "1";
$uploadfile = "unixmail_eng.$in{'extension'}";
&writeerror;

}





chmod ($permissions,"$cgipath/unix_mail.$in{'extension'}") || die print "Can't chmod unix_mail.$in{'extension'} to $permissions : $!";
if ($LOCK_EX){ 
      flock(MAIL2, $LOCK_EX); #Locks the file
	} 

print MAIL2 "#!$in{'perlpath'}\n\n";


foreach $lines(@database_mail) {
         chomp($lines);
         print MAIL2 "$lines\n";
         }          

close (MAIL2);




} elsif ($in{'os'} eq 'nt') {


chmod ($permissions,"$cgipath/ntmail_eng.$in{'extension'}");
open (MAIL,"<$cgipath/ntmail_eng.$in{'extension'}") || die print "Can't find ntmail_eng.$in{'extension'}";
@database_mail = <MAIL>;
close(MAIL);

open (MAIL2, ">$cgipath/nt_mail.$in{'extension'}") or die print "unable to create cgipath/nt_mail.$in{'extension'}.  Check/increase your directory permission settings on your $cgipath directory";
chmod ($permissions,"cgipath/nt_mail.$in{'extension'}");
if ($LOCK_EX){ 
      flock(MAIL2, $LOCK_EX); #Locks the file
	} 



print MAIL2 "#!$in{'perlpath'}\n\n";


foreach $lines(@database_mail) {
         chomp($lines);
         print MAIL2 "$lines\n";
         }          

close (MAIL2);

}



open(TEMP2, ">$cgipath/config.$in{'extension'}") or die print "unable to create $cgipath/config.$in{'extension'}.  Check/increase your directory permission settings on your $cgipath directory";
chmod ($permissions,"$cgipath/config.$in{'extension'}");
if ($LOCK_EX){ 
      flock(TEMP2, $LOCK_EX); #Locks the file
	}



unless (-e "$in{'perlpath'}") {
&error1;
&maingraphic;
&error2;
print<<EOF;
Path to Perl Does Not Exist.
EOF
&error3;
print<<EOF;
<P><FONT SIZE="-1" COLOR="$fontcolor" FACE="verdana, arial, helvetica">
The path/file <B>$in{'perlpath'}</B> does not exist. Please verify that you have uploaded this file and that it is in the directory that you specified.</FONT></P>
EOF
&error4;
print TEMP2 "1\;";
exit;
} else {
print TEMP2 "#!$in{'perlpath'}\n\n";
print TEMP2 "\$perlpath = \"$in{'perlpath'}\"\;\n";
}

################ START ###################
######### PRINT DIRECTORY PATHS ##########
################ START ###################

print TEMP2 "\$passfile = \"$information/pass\";\n";
print TEMP2 "\$memberinfo = \"$information/info\";\n";
print TEMP2 "\$trackdir = \"$information/trackdir\";\n";
print TEMP2 "\$tempdir = \"$information/tempdir\";\n";
print TEMP2 "\$maildir = \"$information/maildir\";\n";
print TEMP2 "\$lists = \"$information/lists\";\n";
print TEMP2 "\$graphics = \"$information/graphics\";\n";


################ END #####################
######### PRINT DIRECTORY PATHS ##########
################ END ##################### 

################ START ###################
##### VARIABLE #8 ORGANIZATION NAME ######
################ START ###################


# if ($in{'list_name'} eq "Your Organization Name") {
# &error1;
# &maingraphic;
# &error2;
# print<<EOF;
# Variable #3<BR>
# Missing Organization Name.
# EOF
# &error3;
# print<<EOF;
# <P><FONT SIZE="-1" COLOR="$fontcolor" FACE="verdana, arial, helvetica">
# Please don't forget to enter your <B>Organization Name</B> in variable #3. Your Organization # Name is used to identify your organization throughout the program.</FONT></P>
# EOF
# &error4;
# exit;
# } else {
# print TEMP2 "\$list_name = \"$in{'list_name'}\"\;\n";

# }
################# END ####################
##### VARIABLE #8 ORGANIZATION NAME ######
################# END ####################


################ START ###################
##### VARIABLE #9 ORGANIZATION EMAIL ######
################ START ###################

# $in{'list_mail'} =~ s/\s//g;

# unless ($in{'list_mail'} =~ /(@.*@)|(\.\.)|(@\.)|(\.@)|(^\.)|(,)/
# 	  || $in{'list_mail'} !~
#	  /^.+\@(\[?)[a-zA-Z0-9\-\.]+\.([a-zA-Z]{2,3}|[0-9]{1,3})(\]?)$/)
#	  {
#         $legalemail = 1;
#        } else {
#         $legalemail = 0;
#        }


# if (($in{'list_mail'} eq "youremail\@yourserver.com") || ($legalemail !~ 1)) {
# &error1;
# &maingraphic;
# &error2;
# print<<EOF;
# Variable #4<BR>
# Invalid Oranization E-Mail Address.
# EOF
# &error3;
# print<<EOF;
# <P><FONT SIZE="-1" COLOR="$fontcolor" FACE="verdana, arial, helvetica">
# Please don't forget to enter your valid <B>Organization E-Mail Address</B> in variable #4. # Your Organization E-Mail is used to identify your organization throughout the # program.</FONT></P>
# EOF
# &error4;
# exit;
# } else {

# $list_mail = $in{'list_mail'};
# $list_mail =~ s/\@/\\@/;
# print TEMP2 "\$list_mail = \"$list_mail\"\;\n";

# }
################# END ####################
##### VARIABLE #9 ORGANIZATION EMAIL #####
################# END ####################


################ START ###################
####### VARIABLE #10 MAIL PROGRAM ########
################ START ###################

unless ($in{'mailusing'} eq 'sockets') {

unless ($in{'mailprog'}) {
&error1;
&maingraphic;
&error2;

print<<EOF;
Variable #5<BR>
Enter a Mail Program Directory Path.

EOF
&error3;

print<<EOF;
<P><FONT SIZE="-1" COLOR="$fontcolor" FACE="verdana, arial, helvetica">
When using either Sendmail or BLAT mailing, you <B>must</B> specify a directory
path to the mail program.  Contact your server administrator if you are unsure
of that path.</FONT></P>

EOF
&error4;
exit;
 }


if (!(-e "$in{'mailprog'}")) {
&error1;
&maingraphic;
&error2;
print<<EOF;
Variable #5<BR>
Invalid Mail Program Directory.
EOF
&error3;
print<<EOF;
<P><FONT SIZE="-1" COLOR="$fontcolor" FACE="verdana, arial, helvetica">
The Mail Program path you gave in variable #5: <B>$in{'mailprog'}</B> does not exist. Contact your server administrator if you are unsure of the path to your Mail Program (like Sendmail) path.</FONT></P>
EOF
&error4;
exit;
} else {
print TEMP2 "\$mailprog = \"$in{'mailprog'}\"\;\n";

}
}
################# END ####################
####### VARIABLE #10 MAIL PROGRAM ########
################# END ####################




################ START ###################
####### VARIABLE #13 FILE LOCKING ########
################ START ###################



if ($in{'LOCK_EX'} == 2) {
print TEMP2 "\$LOCK_EX = \"$in{'LOCK_EX'}\"\;\n";

} else {
print TEMP2 "\$LOCK_EX = \"\"\;\n";

}
################# END ####################
####### VARIABLE #13 FILE LOCKING ########
################# END ####################



################ START ###################
####### VARIABLE #20 WEBSITE URL #########
################ START ###################

$websiteln = (length($in{'websiteurl'}));

if ($websiteln > 7) {
print TEMP2 "\$websiteurl = \"$in{'websiteurl'}\"\;\n";

} else {
&error1;
&maingraphic;
&error2;
print<<EOF;
Variable #6<BR>
No Website URL Given.
EOF
&error3;
print<<EOF;
<P><FONT SIZE="-1" COLOR="$fontcolor" FACE="verdana, arial, helvetica">
Please place your website URL path in variable #6. Your URL path should appear similar to: <B>http://www.yourserver.com</B>.</FONT></P>
EOF
&error4;
exit;

}
################# END ####################
####### VARIABLE #20 WEBSITE URL #########
################# END ####################

################ START ###################
##### VARIABLE #20.1 SERVER PLATFORM #####
################ START ###################

print TEMP2 "\$os = \"$in{'os'}\"\;\n";

################ END ###################
#### VARIABLE #20.1 SERVER PLATFORM ####
################ END ###################

################ START ##################
###### VARIABLE #20.2 MAIL USING ########
################ START ##################

print TEMP2 "\$mailusing = \"$in{'mailusing'}\"\;\n";

################ END ###################
###### VARIABLE #20.2 MAIL USING #######
################ END ###################

################ START ##################
######### VARIABLE #20.2 SMTP ###########
################ START ##################

print TEMP2 "\$smtp_addr = \"$in{'smtp_addr'}\"\;\n";

################ END ###################
######### VARIABLE #20.2 SMTP ##########
################ END ###################


# print "$information<BR>";

print TEMP2 "\$cgipath = \"$in{'cgipath'}\"\;\n";
print TEMP2 "\$extension = \"$in{'extension'}\"\;\n";
print TEMP2 "\$information = \"$in{'information'}\"\;\n";
print TEMP2 "\$notification = \"$in{'notification'}\"\;\n";
print TEMP2 "\$config_session = \"$in{'session'}\"\;\n";
print TEMP2 "\$permissions = \"$in{'permissions'}\"\;\n\n";

############ START ################
####### CREATE DIRECTORIES ########
############ START ################



if (!(-e "$information")) {
	mkdir("$information",$permissions) || die &temperror2;
	chmod ($permissions,"$information") || die &temperror2;



sub temperror2 {

$maindir = "$information";
&writeerror;
}
} else {
chmod ($permissions,"$information") || die &temperror2;
}



if (!(-e "$information/info")) {
	mkdir("$information/info",$permissions) || die &temperror3;
	chmod ($permissions,"$information/info") || die &temperror3;

sub temperror3 {

$maindir = "$information/info";
&writeerror;
}
} else {
chmod ($permissions,"$information/info") || die &temperror3;
}


if (!(-e "$information/trackdir")) {
	mkdir("$information/trackdir",$permissions) || die &temperror4;
	chmod ($permissions,"$information/trackdir")|| die &temperror4;

sub temperror4 {

$maindir = "$information/trackdir";
&writeerror;
}
} else {
chmod ($permissions,"$information/trackdir")|| die &temperror4;
}



if (!(-e "$information/maildir")) {
	mkdir("$information/maildir",$permissions) || die &temperror5;
	chmod ($permissions,"$information/maildir")|| die &temperror5;

sub temperror5 {

$maindir = "$information/maildir";
&writeerror;
}
} else {
chmod ($permissions,"$information/maildir")|| die &temperror5;
}


if (!(-e "$information/graphics")) {
	mkdir("$information/graphics",$permissions) || die &temperror6;
	chmod ($permissions,"$information/graphics")|| die &temperror6;

sub temperror6 {

$maindir = "$information/graphics";
&writeerror;
}
} else {
chmod ($permissions,"$information/graphics")|| die &temperror6;
}


if (!(-e "$information/lists")) {
	mkdir("$information/lists",$permissions) || die &temperror7;
	chmod ($permissions,"$information/lists")|| die &temperror7;

sub temperror7 {

$maindir = "$information/lists";
&writeerror;
}
} else {
chmod ($permissions,"$information/lists")|| die &temperror7;
}



if (!(-e "$information/pass")) {
	mkdir("$information/pass",$permissions) || die &temperror8;
	chmod ($permissions,"$information/pass")|| die &temperror8;

sub temperror8 {

$maindir = "$information/pass";
&writeerror;
}
} else {
chmod ($permissions,"$information/pass")|| die &temperror8;
}

if (!(-e "$information/tempdir")) {
	mkdir("$information/tempdir",$permissions) || die &temperror9;
	chmod ($permissions,"$information/tempdir")|| die &temperror9;

sub temperror9 {

$maindir = "$information/tempdir";
&writeerror;
}
} else {
chmod ($permissions,"$information/tempdir")|| die &temperror9;
}

sub exists {
print<<EOF;
$program Upload Directorys already exist.  Subscribe Me will not overwrite your
existing directories for the security of your files.  Please FTP into your web account
and delete these directories manually.
<BR><BR>
EOF

if (-e "$information/info") {
print "$information/info<BR>";
}


if (-e "$information/pass") {
print "$information/pass<BR>";
}
# exit;
}


print TEMP2 "\$ready = \"1\"\;\n\n";
print TEMP2 "1\;";
############# END #################
####### CREATE DIRECTORIES ########
############# END #################

close (TEMP2);



#### CREATE DEFAULT TEMPLATES ####

open (SIGNUP,">$information/info/default.signup");
 if ($LOCK_EX){ 
      flock(SIGNUP, $LOCK_EX); #Locks the file
	}

print SIGNUP <<EOF;
This message is to confirm the addition of your
email address: <E-MAIL> to the <LIST_NAME>
Subscribe Me mailing list.

If you feel you have received this notice in error,
please visit the <LIST_NAME> Subscribe Me mailing list
at our website: <WEBSITEURL>
to remove yourself automatically, or click the link below:

http://<SERVER_NAME><CGI_URL>?r=1&l=<LIST>&e=<E-MAIL>

Thank you,

<LIST_NAME>

EOF

close(SIGNUP);

#### CREATE DEFAULT TEMPLATES ####

#### CREATE DEFAULT TEMPLATES ####

open (SIGNUP,">$information/info/default.removal");
 if ($LOCK_EX){ 
      flock(SIGNUP, $LOCK_EX); #Locks the file
	}

print SIGNUP <<EOF;
This message is to confirm the removal of your
email address: <E-MAIL> from the <LIST_NAME>
Subscribe Me mailing list.

We're sorry to see you go!

If you feel you have received this notice in error,
please visit the <LIST_NAME> Subscribe Me mailing list
at our website: <WEBSITEURL>
to add yourself automatically, or click on the link
below to automatically re-subscribe yourself:

http://<SERVER_NAME><CGI_URL>?a=1&l=<LIST>&e=<E-MAIL>

Thank you,

<LIST_NAME>

EOF

close(SIGNUP);

#### CREATE DEFAULT TEMPLATES ####





# sub header {
# open (FILE,"<$header/header.txt"); #### Full path name from root. 
# @headerfile = <FILE>;
# close(FILE);
#print "<HTML><HEAD><TITLE></TITLE></HEAD><BODY LINK=\"#0000FF\" VLINK=\"#0000FF\" #ALINK=\"#FFB500\">\n";
#foreach $line(@headerfile) {
#print "$line";
#  }
#}

#sub footer {
#open (FILE,"<$footer/footer.txt"); #### Full path name from root. 
# @footerfile = <FILE>;
# close(FILE);
#foreach $line(@footerfile) {
#print "$line";
#}
#print "</BODY></HTML>";
#}

sub maingraphic {

if (-e "$graphics/sub3.gif") {
print<<EOF;
<IMG SRC="$cgiurl?graphic=sub3.gif" WIDTH="129" HEIGHT="77"><BR> <B><FONT SIZE="-2"  FACE="verdana, arial, helvetica" COLOR="#FF0000">Version $version</FONT></B></TD><TD VALIGN="TOP"  ALIGN="CENTER" COLSTART="2"></TD></TR>
EOF
 }
}


sub error1 {
print<<EOF;
<CENTER>
<TABLE BORDER="0"><TR><TD VALIGN="MIDDLE" ALIGN="CENTER">

EOF
}

sub error2 {

print<<EOF;
<TR><TD VALIGN="MIDDLE" ALIGN="CENTER"><CENTER><TABLE BORDER="0" WIDTH="400"><TBODY>
<TR><TD COLSTART="1"><CENTER> <P><B><FONT COLOR="$fontcolor" FACE="verdana, arial, helvetica"><FONT COLOR="#FF0000">$programname</FONT> Status:<BR>
EOF
}


sub error3 {
print<<EOF;
</FONT></B></P></CENTER> 
EOF
}

sub error4 {
print<<EOF;
</TD></TR>
<TR><TD COLSTART="1"><BR> <FONT SIZE="-1" FACE="verdana, arial, helvetica" COLOR="$fontcolor">Press your &quot;BACK&quot; button to return to the installation form or use this button if your browser supports Javascript</FONT></TD></TR></ROWS></TBODY></TABLE></CENTER></TD></TR></ROWS></SQTBODY></TABLE>
<FORM><INPUT TYPE="BUTTON" VALUE="BACK TO INSTALLATION FORM" ONCLICK="history.go(-1)"></FORM>
</CENTER>
EOF
}

sub error5 {
print<<EOF;
</TD></TR>
<TR><TD COLSTART="1"><BR> <FONT SIZE="-1" FACE="verdana, arial, helvetica" COLOR="$fontcolor">Once you have changed the permission on this directory to <B>777</B>, press the CONTINUE BUTTON below.</FONT></TD></TR></ROWS></TBODY></TABLE></CENTER></TD></TR></ROWS></SQTBODY></TABLE>
<FORM><INPUT TYPE="BUTTON" VALUE="BACK TO INSTALLATION FORM" ONCLICK="history.go(-1)"></FORM>
</CENTER>
EOF
}



&createmain;



unless (-e "$information/pass/password.txt") {

&header;
&header3;
print<<EOF;
    <FORM ACTION="$cgiurl" METHOD="POST"><INPUT TYPE="HIDDEN" NAME="cgipath" 
    VALUE="$in{'cgipath'}"><INPUT TYPE="HIDDEN" NAME="extension" 
    VALUE="$in{'extension'}">
    <CENTER><BR>
    <TABLE BORDER="0" WIDTH="400">
      <TBODY>
      <TR>
        <TD>
        
        <P><B><FONT FACE="verdana, arial, helvetica"><FONT COLOR="#FF0000">Subscribe
          Me</FONT> Status: Set Password!</FONT></B></P>
        
        <P><FONT SIZE="-1" FACE="verdana, arial, helvetica">You have not yet
          set your administration password! Please enter your password below,
          once to set the password and the second time to confirm it.</FONT></P>
        <CENTER>
        <TABLE BORDER="0">
          <TBODY>
          <TR>
            <TD ALIGN="RIGHT"><INPUT TYPE="PASSWORD" NAME="pwd"></TD>
            <TD><FONT SIZE="-2" FACE="verdana, arial, helvetica">password</FONT></TD>
          </TR>
          <TR>
            <TD ALIGN="RIGHT"><INPUT TYPE="PASSWORD" NAME="pwd2"></TD>
            <TD><FONT SIZE="-2" FACE="verdana, arial, helvetica">confirmation</FONT></TD>
          </TR>
          <TR>
            <TD ALIGN="CENTER"><BR>
            <INPUT TYPE="SUBMIT" NAME="setpwd" VALUE="  Set Password  "></TD>
            <TD><BR>
            <INPUT TYPE="RESET" NAME=""></TD>
          </TR></TBODY>
        </TABLE></CENTER> </TD>
      </TR></TBODY>
    </TABLE></CENTER></FORM>
EOF
&footer3;
&footer;
exit;

}


&header;
&header2;

print<<EOF;
    <CENTER>
    <P><FONT FACE="verdana, arial, helvetica" COLOR="#FF0000"><B>Subscribe Me
      $version Update Successful!</B></FONT></P>
    <TABLE BORDER="0">
      <TR>
        <TD VALIGN="MIDDLE" ALIGN="RIGHT" WIDTH="200">
        <FORM METHOD="POST" ACTION="$cgiurl">
        <INPUT TYPE="HIDDEN" NAME="session_id" VALUE="$in{'session_id'}">
        <INPUT TYPE="HIDDEN" NAME="pwd" VALUE="$in{'pwd'}">
        <INPUT TYPE="SUBMIT" NAME="reinstall" VALUE="View/Edit Changes">
        </FORM></TD>
        <TD VALIGN="MIDDLE" ALIGN="LEFT" WIDTH="200">
EOF

$subscribeurl = $ENV{'SCRIPT_NAME'};
$subscribeurl =~ s/setup\.cgi$/s\.cgi/;
$subscribeurl =~ s/setup\.pl$/s\.pl/;


print<<EOF;
        <FORM METHOD="POST" ACTION="$subscribeurl"><INPUT TYPE="HIDDEN" 
        NAME="session_id" VALUE="$in{'session_id'}"><INPUT TYPE="SUBMIT" 
        NAME="adminreturn" VALUE="Return to Administration"></FORM></TD>
      </TR>
    </TABLE></CENTER>
EOF

# &copypaste;

&footer3;
&footer;
exit;

}








sub createmain {


# unless (-e "$cgipath/s.$in{'extension'}") {

open (ENGINE,"<$cgipath/subscribe_eng.$in{'extension'}") || die print "Can't find subscribe_eng.$in{'extension'}";
@database_engine = <ENGINE>;
close(ENGINE);

open (TEMP3, ">$cgipath/s.$in{'extension'}") or die print "unable to create $cgipath/s.$in{'extension'}.  Check/increase your directory permission settings on your $cgipath directory";
chmod ($permissions,"$cgipath/s.$in{'extension'}");
if ($LOCK_EX){ 
      flock(TEMP3, $LOCK_EX); #Locks the file
	} 



print TEMP3 "#!$in{'perlpath'}\n\n";
print TEMP3 "require \"$cgipath/config.$in{'extension'}\";\n\n";
print TEMP3 "require \"$cgipath/$in{'os'}_mail.$in{'extension'}\";\n\n";
# print TEMP3 "require \"$cgipath/setup.$in{'extension'}\";\n\n";


foreach $lines(@database_engine) {
         chomp($lines);
         print TEMP3 "$lines\n";
         }          

close (TEMP3);




# }






sub setpassword {
print "Content-type: text/html\n\n";
&header;
&header3;
print<<EOF;

    <FORM ACTION="$cgiurl" METHOD="POST">
    <CENTER><BR>
    <TABLE BORDER="0" WIDTH="400">
      <TBODY>
      <TR>
        <TD>
        
        <P><B><FONT FACE="verdana, arial, helvetica"><FONT COLOR="#FF0000">Subscribe
          Me</FONT> Status: Set Password!</FONT></B></P>
        
        <P><FONT SIZE="-1" FACE="verdana, arial, helvetica">You have not yet
          set your administration password! Please enter your password below,
          once to set the password and the second time to confirm it.</FONT></P>
        <CENTER>
        <TABLE BORDER="0">
          <TBODY>
          <TR>
            <TD ALIGN="RIGHT"><INPUT TYPE="PASSWORD" NAME="pwd"></TD>
            <TD><FONT SIZE="-2" FACE="verdana, arial, helvetica">password</FONT></TD>
          </TR>
          <TR>
            <TD ALIGN="RIGHT"><INPUT TYPE="PASSWORD" NAME="pwd2"></TD>
            <TD><FONT SIZE="-2" FACE="verdana, arial, helvetica">confirmation</FONT></TD>
          </TR>
          <TR>
            <TD ALIGN="CENTER"><BR>
            <INPUT TYPE="SUBMIT" NAME="setpwd" VALUE="  Set Password  "></TD>
            <TD><BR>
            <INPUT TYPE="RESET" NAME=""></TD>
          </TR></TBODY>
        </TABLE></CENTER> </TD>
      </TR></TBODY>
    </TABLE></CENTER></FORM>
EOF
&footer3;
&footer;
exit;

}

sub setpwd {

$content = "";

if (-e "$passfile/password.txt") {
print "Content-type: text/html\n\n";
print "Password already exists.  Please delete your password file manually if you want to reset your password<BR>";
exit;
}


unless ($in{'pwd'} && $in{'pwd2'}) {
unless ($content)  {
print "Content-type: text/html\n\n";
}
$content = 1;
&header;
&header3;
print<<EOF;

    <FORM ACTION="$cgiurl" METHOD="POST">
    <CENTER><BR>
    <TABLE BORDER="0" WIDTH="400">
      <TBODY>
      <TR>
        <TD>
        
        <P><B><FONT FACE="verdana, arial, helvetica"><FONT COLOR="#FF0000">Subscribe
          Me</FONT> Status: Password Error!</FONT></B></P>
        
        <P><FONT SIZE="-1" FACE="verdana, arial, helvetica">Please enter your
          password twice. Once to set it, and once to confirm it.</FONT></P>
        <CENTER>
        <TABLE BORDER="0">
          <TBODY>
          <TR>
            <TD ALIGN="RIGHT"><INPUT TYPE="PASSWORD" NAME="pwd"></TD>
            <TD><FONT SIZE="-2" FACE="verdana, arial, helvetica">password</FONT></TD>
          </TR>
          <TR>
            <TD ALIGN="RIGHT"><INPUT TYPE="PASSWORD" NAME="pwd2"></TD>
            <TD><FONT SIZE="-2" FACE="verdana, arial, helvetica">confirmation</FONT></TD>
          </TR>
          <TR>
            <TD ALIGN="CENTER"><BR>
            <INPUT TYPE="SUBMIT" NAME="setpwd" VALUE="  Set Password  "></TD>
            <TD><BR>
            <INPUT TYPE="RESET" NAME=""></TD>
          </TR></TBODY>
        </TABLE></CENTER> </TD>
      </TR></TBODY>
    </TABLE></CENTER></FORM>
EOF
&footer3;
&footer;
exit;
}


unless ($content)  {
print "Content-type: text/html\n\n";
}
$content = 1;

if ($in{'pwd'} && $in{'pwd2'}) {
    if ($in{'pwd'} ne $in{'pwd2'}) {

&header;
&header3;
print<<EOF;


    <FORM ACTION="$cgiurl" METHOD="POST">
    <CENTER><BR>
    <TABLE BORDER="0" WIDTH="400">
      <TBODY>
      <TR>
        <TD>
        
        <P><B><FONT FACE="verdana, arial, helvetica"><FONT COLOR="#FF0000">Subscribe
          Me</FONT> Status: Password Mismatch!</FONT></B></P>
        
        <P><FONT SIZE="-1" FACE="verdana, arial, helvetica">The confirmation
          password you entered did not match the orginal password. Please try
          again.</FONT></P>
        <CENTER>
        <TABLE BORDER="0">
          <TBODY>
          <TR>
            <TD ALIGN="RIGHT"><INPUT TYPE="PASSWORD" NAME="pwd"></TD>
            <TD><FONT SIZE="-2" FACE="verdana, arial, helvetica">password</FONT></TD>
          </TR>
          <TR>
            <TD ALIGN="RIGHT"><INPUT TYPE="PASSWORD" NAME="pwd2"></TD>
            <TD><FONT SIZE="-2" FACE="verdana, arial, helvetica">confirmation</FONT></TD>
          </TR>
          <TR>
            <TD ALIGN="CENTER"><BR>
            <INPUT TYPE="SUBMIT" NAME="setpwd" VALUE="  Set Password  "></TD>
            <TD><BR>
            <INPUT TYPE="RESET" NAME=""></TD>
          </TR></TBODY>
        </TABLE></CENTER></TD>
      </TR></TBODY>
    </TABLE></CENTER></FORM>

EOF
&footer3;
&footer;
exit;


}
}

chop ($pwd) if ($pwd =~ /\n$/);
		$newpassword = crypt($in{'pwd'}, aa);



open (PASSWORD, ">$passfile/password.txt")|| die print "Unable to create $passfile/password.txt file.  Check your directory permissions";
     
    if ($LOCK_EX){ 
      flock(PASSWORD, $LOCK_EX); #Locks the file
	}
      print PASSWORD "$newpassword";
	close (PASSWORD);

unless ($content)  {
print "Content-type: text/html\n\n";
}
$content = 1;
&header;
&header3;
print<<EOF;
    <CENTER>
    
    <P><FONT FACE="verdana, arial, helvetica" COLOR="#FF0000"><B>Subscribe Me
      $version Update Successful!</B></FONT></P>
    <TABLE BORDER="0">
      <TR>
        <TD VALIGN="MIDDLE" ALIGN="RIGHT" WIDTH="200">
        <FORM METHOD="POST" ACTION="$cgiurl">
        <INPUT TYPE="HIDDEN" NAME="session_id" VALUE="$in{'session_id'}">
        <INPUT TYPE="HIDDEN" NAME="pwd" VALUE="$in{'pwd'}">
        <INPUT TYPE="SUBMIT" NAME="reinstall" VALUE="View/Edit Changes">
        </FORM></TD>
        <TD VALIGN="MIDDLE" ALIGN="LEFT" WIDTH="200">
EOF

$subscribeurl = $ENV{'SCRIPT_NAME'};
$subscribeurl =~ s/setup\.cgi$/s\.cgi/;
$subscribeurl =~ s/setup\.pl$/s\.pl/;

print<<EOF;
        <FORM METHOD="POST" ACTION="$subscribeurl"><INPUT TYPE="HIDDEN" 
        NAME="session_id" VALUE="$in{'session_id'}"><INPUT TYPE="SUBMIT" 
        NAME="adminreturn" VALUE="Return to Administration"></FORM></TD>
      </TR>
    </TABLE></CENTER>
EOF
&footer3;
&footer;
exit;
}
}

sub form {

unless (-e "$passfile/password.txt") {


&setpassword;

}

print "Content-type: text/html\n\n";
print "Congratulations, your installation is successful";

exit;

}


sub blindcheck {
open (PASSWORD, "$passfile/password.txt");
           if ($LOCK_EX){ 
      flock(PASSWORD, $LOCK_EX); #Locks the file
	}
		$password = <PASSWORD>;
		close (PASSWORD);
		chop ($password) if ($password =~ /\n$/);

		if ($in{'pwd'}) {
			$newpassword = crypt($in{'pwd'}, 'aa');
		}
		else {
print "Content-type: text/html\n\n";
&header;
print<<EOF;
<FORM ACTION=\"$cgiurl\" METHOD=\"POST\"><CENTER><BR>
<TABLE BORDER=\"0\" WIDTH=\"400\"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR><TD
COLSTART=\"1\"><P><B><FONT FACE=\"verdana, arial, helvetica\"><FONT
COLOR=\"#FF0000\">Subscribe Me Professional</FONT> Status:  Password Error!</FONT></B></P>
<P><FONT SIZE=\"-1\" FACE=\"verdana, arial, helvetica\">Please enter your password!</FONT></P>
<CENTER><TABLE
BORDER=\"0\" WIDTH=\"400\"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR><TD
COLSTART=\"1\"><HR SIZE=\"1\"></TD></TR><TR><TD ALIGN=\"CENTER\" COLSTART=\"1\"><FONT
SIZE=\"-2\" FACE=\"verdana, arial, helvetica\">
Maintained with  <A HREF=\"http://www.cgiscriptcenter.com/subpro/index2.html\"><B>Subscribe Me Professional $version</B></A></FONT></TD></TR></ROWS></TBODY></TABLE></CENTER></TD></TR></ROWS></TBODY></TABLE></CENTER></FORM>
EOF
&footer;
exit;
		}
		unless ($newpassword eq $password) {
print "Content-type: text/html\n\n";
&header;
print<<EOF;
<CENTER><P><FONT FACE="verdana, arial, helvetica" COLOR="#FF0000"><B>Subscribe Me $version Update Successful!</B></FONT></P> <TABLE BORDER="0">
<SQTBODY><COLDEFS><COLDEF><COLDEF></COLDEFS><ROWS><TR><TD VALIGN="MIDDLE" ALIGN="CENTER" COLSTART="1"><IMG SRC="http://www.cgiscriptcenter.com/subscribe/sub3.gif" ALT="Subscribe Me!" WIDTH="129" HEIGHT="77"><BR> <B><FONT SIZE="-2" FACE="verdana, arial, helvetica" COLOR="#FF0000">Version $version</FONT></B></TD><TD VALIGN="TOP" ALIGN="CENTER" COLSTART="2"><FONT FACE="verdana, arial, helvetica"><B>CGI Script Center Install-a-Script</B></FONT><HR SIZE="1"><BR> <FONT SIZE="-1" FACE="verdana, arial, helvetica">PROGRAM: <FONT COLOR="#FF0000"><B>Subscribe Me! $version</B></FONT></FONT></TD></TR>
<TR><TD VALIGN="MIDDLE" ALIGN="LEFT" COLSTART="1" COLSPAN="2"><BR><FONT SIZE="-1" FACE="verdana, arial, helvetica">Your update was successful!</FONT></TD></TR>
<TR><TD VALIGN="MIDDLE" ALIGN="RIGHT" COLSTART="1" COLSPAN="1" WIDTH="200"><BR><FORM METHOD="POST" ACTION="$cgiurl">
<INPUT TYPE="HIDDEN" NAME="session_id" VALUE="$in{'session_id'}">
<INPUT TYPE="HIDDEN" NAME="pwd" VALUE="$in{'pwd'}">
<INPUT TYPE="SUBMIT" NAME="reinstall" VALUE="View/Edit Changes"></FORM></TD><TD VALIGN="MIDDLE" ALIGN="LEFT" COLSTART="2" COLSPAN="1" WIDTH="200"><BR>
EOF

$subscribeurl = $ENV{'SCRIPT_NAME'};
$subscribeurl =~ s/setup\.cgi$/s\.cgi/;
$subscribeurl =~ s/setup\.pl$/s\.pl/;


print<<EOF;
<FORM METHOD="POST" ACTION="$subscribeurl">
<INPUT TYPE="HIDDEN" NAME="session_id" VALUE="$in{'session_id'}">
<INPUT TYPE="SUBMIT" NAME="adminreturn" VALUE="Return to Administration"></FORM></TD></TR></ROWS></SQTBODY></TABLE></CENTER>
EOF
&footer3;
&footer;
exit;

}
}




sub adminpass {


if (-e "$passfile/password.txt") {

print "Content-type: text/html\n\n";
&header;
&header3;
print<<EOF;

    
    <FORM ACTION="$cgiurl" METHOD="POST">
    <INPUT TYPE="HIDDEN" NAME="enterpass" VALUE="1">
    <CENTER>
    <TABLE BORDER="0" WIDTH="400">
      <TBODY>
      <TR>
        <TD>
        
        <P ALIGN="CENTER"><B><FONT FACE="verdana, arial, helvetica"><FONT COLOR="#FF0000">Subscribe
          Me</FONT> Status:<BR>
           Administration Password</FONT></B></P>
        
        <P><FONT SIZE="-1" FACE="verdana, arial, helvetica">The Administration
          section is restricted to authorized individuals only. Please enter the
          Administration password below.</FONT></P>
        <CENTER>
        <TABLE BORDER="0">
          <TBODY>
          <TR>
            <TD ALIGN="CENTER"><FONT SIZE="-1" FACE="verdana, arial, helvetica"><B>Password</B></FONT><BR>
            <INPUT TYPE="PASSWORD" NAME="pwd"></TD>
          </TR>
          <TR>
            <TD ALIGN="CENTER"><BR>
            <INPUT TYPE="SUBMIT" NAME="passcheck" VALUE="  Enter Password  " CHECKED="CHECKED"><INPUT TYPE="RESET" NAME=""></TD>
          </TR></TBODY>
        </TABLE></CENTER> </TD>
      </TR>
      <TR>
        <TD><BR>
        <FONT SIZE="-2" FACE="arial, helvetica"><B>Enable Javascript
        on your web browser to see script update information below.</B></FONT></TD>
      </TR></TBODY>
    </TABLE></CENTER></FORM>
    <CENTER>
    <TABLE BORDER="0" WIDTH="400">
      <TR>
        <TD ALIGN="CENTER"><FONT SIZE="-1" FACE="arial, helvetica"><B>Version Information</B></FONT></TD>
      </TR>
        <TR>
        <TD BGCOLOR="#000000">
        <TABLE BORDER="0" WIDTH="400" BGCOLOR="#FFFFFF" CELLPADDING="0" CELLSPACING="0">
       <TR>
        <TD ALIGN="CENTER" WIDTH="50%"><FONT SIZE="-2" FACE="arial, helvetica">Your
        Version:</FONT></TD>
        <TD ALIGN="CENTER" WIDTH="50%"><FONT SIZE="-2" FACE="arial, helvetica">$version</FONT></TD>
      </TR>

<SCRIPT LANGUAGE="javascript1.1" SRC="http://www.cgiscriptcenter.com/subscribe/install/js.js">
</SCRIPT>
          
        </TABLE></TD>
      </TR>
    </TABLE></CENTER>

<CENTER><BR>
    <TABLE BORDER="0" WIDTH="400">
      <TR>
        <TD ALIGN="CENTER"><FONT SIZE="-1" FACE="arial, helvetica"><B>News Updates</B></FONT></TD>
      </TR>
        <TR>
        <TD BGCOLOR="#000000">
        <TABLE BORDER="0" WIDTH="400" BGCOLOR="#FFFFFF" CELLPADDING="4" CELLSPACING="0">
<SCRIPT LANGUAGE="javascript1.1" SRC="http://www.cgiscriptcenter.com/subscribe/install/jsnews.js">
</SCRIPT>
          
        </TABLE></TD>
      </TR>
    </TABLE></CENTER><BR>
EOF
&footer3;
&footer;
exit;

} else {

print "Content-type: text/html\n\n";
&header;
&header3;
print<<EOF;

    <FORM ACTION="$cgiurl" METHOD="POST">
    <INPUT TYPE="HIDDEN" NAME="setpwd" VALUE="1">
    <CENTER><BR>
    <TABLE BORDER="0" WIDTH="400">
      <TBODY>
      <TR>
        <TD>
        
        <P><B><FONT FACE="verdana, arial, helvetica"><FONT COLOR="#FF0000">Subscribe
          Me</FONT> Status: Set Password!</FONT></B></P>
        
        <P><FONT SIZE="-1" FACE="verdana, arial, helvetica">You have not yet
          set your administration password! Please enter your password below,
          once to set the password and the second time to confirm it.</FONT></P>
        <CENTER>
        <TABLE BORDER="0">
          <TBODY>
          <TR>
            <TD ALIGN="RIGHT"><INPUT TYPE="PASSWORD" NAME="pwd"></TD>
            <TD><FONT SIZE="-2" FACE="verdana, arial, helvetica">password</FONT></TD>
          </TR>
          <TR>
            <TD ALIGN="RIGHT"><INPUT TYPE="PASSWORD" NAME="pwd2"></TD>
            <TD><FONT SIZE="-2" FACE="verdana, arial, helvetica">confirmation</FONT></TD>
          </TR>
          <TR>
            <TD ALIGN="CENTER"><BR>
            <INPUT TYPE="SUBMIT" NAME="setpwd" VALUE="  Set Password  "></TD>
            <TD><BR>
            <INPUT TYPE="RESET" NAME=""></TD>
          </TR></TBODY>
        </TABLE></CENTER> </TD>
      </TR></TBODY>
    </TABLE></CENTER></FORM>
EOF
&footer3;
&footer;
exit;
 }
}


sub blindcheck {
open (PASSWORD, "$passfile/password.txt");
           if ($LOCK_EX){ 
      flock(PASSWORD, $LOCK_EX); #Locks the file
	}
		$password = <PASSWORD>;
		close (PASSWORD);
		chop ($password) if ($password =~ /\n$/);

		if ($in{'pwd'}) {
			$newpassword = crypt($in{'pwd'}, 'aa');
		}
		else {
print "Content-type: text/html\n\n";
&header;
print<<EOF;
<FORM ACTION=\"$cgiurl\" METHOD=\"POST\"><CENTER><BR>
<TABLE BORDER=\"0\" WIDTH=\"400\"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR><TD
COLSTART=\"1\"><P><B><FONT FACE=\"verdana, arial, helvetica\"><FONT
COLOR=\"#FF0000\">Subscribe Me Professional</FONT> Status:  Password Error!</FONT></B></P>
<P><FONT SIZE=\"-1\" FACE=\"verdana, arial, helvetica\">Please enter your password!</FONT></P>
<CENTER><TABLE
BORDER=\"0\" WIDTH=\"400\"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR><TD
COLSTART=\"1\"><HR SIZE=\"1\"></TD></TR><TR><TD ALIGN=\"CENTER\" COLSTART=\"1\"><FONT
SIZE=\"-2\" FACE=\"verdana, arial, helvetica\">$list_name
maintained with  <A HREF=\"http://www.cgiscriptcenter.com/subpro/index2.html\"><B>Subscribe Me Professional $version</B></A></FONT></TD></TR></ROWS></TBODY></TABLE></CENTER></TD></TR></ROWS></TBODY></TABLE></CENTER></FORM>
EOF
&footer;
exit;
		}
		unless ($newpassword eq $password) {
print "Content-type: text/html\n\n";
&header;
print<<EOF;
<FORM ACTION=\"$cgiurl\" METHOD=\"POST\"><CENTER><BR>
<TABLE BORDER=\"0\" WIDTH=\"400\"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR><TD
COLSTART=\"1\"><P><B><FONT FACE=\"verdana, arial, helvetica\"><FONT
COLOR=\"#FF0000\">Subscribe Me Professional</FONT> Status:  Password Error!</FONT></B></P>
<P><FONT SIZE=\"-1\" FACE=\"verdana, arial, helvetica\">Incorrect password!  Please enter the correct password.</FONT></P>
<CENTER><TABLE
BORDER=\"0\" WIDTH=\"400\"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR><TD
COLSTART=\"1\"><HR SIZE=\"1\"></TD></TR><TR><TD ALIGN=\"CENTER\" COLSTART=\"1\"><FONT
SIZE=\"-2\" FACE=\"verdana, arial, helvetica\">
Maintained with  <A HREF=\"http://www.cgiscriptcenter.com/subpro/index2.html\"><B>Subscribe Me Professional  $version</B></A></FONT></TD></TR></ROWS></TBODY></TABLE></CENTER></TD></TR></ROWS></TBODY></TABLE></CENTER></FORM>
EOF
exit;

}
}






sub passcheck {

open (PASSWORD, "$passfile/password.txt");
           if ($LOCK_EX){ 
      flock(PASSWORD, $LOCK_EX); #Locks the file
	}
		$password = <PASSWORD>;
		close (PASSWORD);
		chop ($password) if ($password =~ /\n$/);


		if ($in{'pwd'}) {
			$newpassword = crypt($in{'pwd'}, 'aa');
		}
		else {
                  print "Content-type: text/html\n\n";
print "<HTML><HEAD><TITLE>Subscribe Me: Password Error!</TITLE></HEAD><BODY
BGCOLOR=\"#FFFFFF\"><FORM ACTION=\"$cgiurl\" METHOD=\"POST\"><CENTER><BR>
<TABLE BORDER=\"0\" WIDTH=\"400\"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR><TD
COLSTART=\"1\"><P><B><FONT FACE=\"verdana, arial, helvetica\"><FONT
COLOR=\"#FF0000\">Subscribe Me</FONT> Status:  Password Error!</FONT></B></P>
<P><FONT SIZE=\"-1\" FACE=\"verdana, arial, helvetica\">Please enter your password!</FONT></P>
<CENTER><TABLE
BORDER=\"0\" WIDTH=\"400\"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR><TD
COLSTART=\"1\"><HR SIZE=\"1\"></TD></TR><TR><TD ALIGN=\"CENTER\" COLSTART=\"1\"><FONT
SIZE=\"-2\" FACE=\"verdana, arial, helvetica\">
Maintained with  <A HREF=\"http://www.cgiscriptcenter.com/subpro/index2.html\"><B>Subscribe
Me $version</B></A></FONT></TD></TR></ROWS></TBODY></TABLE></CENTER></TD></TR></ROWS></TBODY></TABLE></CENTER></FORM></BODY></HTML>";
exit;
		}
		unless ($newpassword eq $password) {
                  print "Content-type: text/html\n\n";
print "<HTML><HEAD><TITLE>Subscribe Me: Password Error!</TITLE></HEAD><BODY
BGCOLOR=\"#FFFFFF\"><FORM ACTION=\"$cgiurl\" METHOD=\"POST\"><CENTER><BR>
<TABLE BORDER=\"0\" WIDTH=\"400\"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR><TD
COLSTART=\"1\"><P><B><FONT FACE=\"verdana, arial, helvetica\"><FONT
COLOR=\"#FF0000\">Subscribe Me</FONT> Status:  Password Error!</FONT></B></P>
<P><FONT SIZE=\"-1\" FACE=\"verdana, arial, helvetica\">Incorrect password!  Please enter the correct password.</FONT></P>
<CENTER><TABLE
BORDER=\"0\" WIDTH=\"400\"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR><TD
COLSTART=\"1\"><HR SIZE=\"1\"></TD></TR><TR><TD ALIGN=\"CENTER\" COLSTART=\"1\"><FONT
SIZE=\"-2\" FACE=\"verdana, arial, helvetica\">
Maintained with  <A HREF=\"http://www.cgiscriptcenter.com/subpro/index2.html\"><B>Subscribe
Me $version</B></A></FONT></TD></TR></ROWS></TBODY></TABLE></CENTER></TD></TR></ROWS></TBODY></TABLE></CENTER></FORM></BODY></HTML>";
exit;
		}
#&form2;
&sessionid;
&install;
}



sub sessionid {
&blindcheck;


$thetime = time();

	srand($thetime);
	$session ="";
	@passset = ('a'..'z', 'A'..'Z', '1'..'9');
	for ($i = 0; $i < 15; $i++) {
		$randum_num = int(rand($#passset + 1));
		$session .= @passset[$randum_num];
	}

open(SESSIONID, ">$memberinfo/session.id");
           if ($LOCK_EX){ 
      flock(SESSIONID, $LOCK_EX); #Locks the file
	}




print SESSIONID "$session";
close(SESSIONID);

$session_id = "$session";

open(SESSIONTIME, ">$memberinfo/session.time");
           if ($LOCK_EX){ 
      flock(SESSIONTIME, $LOCK_EX); #Locks the file
	}


print SESSIONTIME "$thetime";
close(SESSIONTIME);

}


sub sessioncheck {

open(SESSIONTIME, "<$memberinfo/session.time");
if ($LOCK_EX){ 
      flock(SESSIONTIME, $LOCK_EX); #Locks the file
	}
 $session_time = <SESSIONTIME>;
 close(SESSIONTIME);

$user_session = $thetime - $session_time;

open(SESSIONID, "<$memberinfo/session.id");
if ($LOCK_EX){ 
      flock(SESSIONID, $LOCK_EX); #Locks the file
	}
 $session_variable = <SESSIONID>;
 close(SESSIONID);

unless (($in{'session_id'} eq "$session_variable") && ("$user_session" < "$config_session") && ($session_variable)) {
# print "Content-type: text/html\n\n";
# print "No match: Input Session ID = $in{'session_id'} - Session Variable = # $session_variable<BR>User Session = $user_session";
&adminpass;
exit;
 }

# print "Content-type: text/html\n\n";
# print "Match: Input Session ID = $in{'session_id'} - Session Variable = # $session_variable<BR>User Session = $user_session<BR>Config Session = $config_session";

open(SESSIONTIME, ">$memberinfo/session.time");
           if ($LOCK_EX){ 
      flock(SESSIONTIME, $LOCK_EX); #Locks the file
	}

print SESSIONTIME "$thetime";
close(SESSIONTIME);

} 


sub image {

#print "$information/graphics/sub3.gif<BR>";


print "Content-type: image/gif\n";
print "\n";
$file = "$information/graphics/sub3.gif";
open (IMAGE, "<$file") || die "Can't open $file: $!";
if (($in{'os'} eq 'nt') || ($os eq 'nt')) {
binmode(IMAGE); ## If used on an NT server, remove the "#" at front.
binmode(STDOUT); ## If used on an NT server, remove the "#" at front.
}
while (<IMAGE>)
{
        print "<IMG SRC=\"$_\">";
}
close(IMAGE);

}



sub header {
open (FILE,"<$memberinfo/default.header"); #### Full path name from root.
if ($LOCK_EX){ 
      flock(FILE, $LOCK_EX); #Locks the file
	} 
 @headerfile = <FILE>;
 close(FILE);
print "<HTML><HEAD><TITLE></TITLE>
<SCRIPT LANGUAGE=\"JavaScript\">
<!-- Begin
function Start(page) {
OpenWin = this.open(page, \"CtrlWindow\", [\"toolbar=no,menubar=no,location=no,scrollbars=yes,resize=yes,height=350,width=520\"]);
}
// End -->

</SCRIPT>
</HEAD><BODY TEXT=\"#000040\" LINK=\"#0000FF\" VLINK=\"#0000FF\" ALINK=\"#FF0000\">\n";
foreach $line(@headerfile) {
print "$line";
  }
}


sub footer {
open (FILE,"<$memberinfo/default.footer"); #### Full path name from root.
if ($LOCK_EX){ 
      flock(FILE, $LOCK_EX); #Locks the file
	} 
 @footerfile = <FILE>;
 close(FILE);
foreach $line(@footerfile) {
print "$line";

}
if (lc $link eq "partial_credit") {
print<<EOF;
    <CENTER>
    <TABLE BORDER="0" WIDTH="400">
      <TBODY>
      <TR>
        <TD><HR SIZE="1"></TD>
      </TR>
      <TR>
        <TD ALIGN="CENTER"><FONT SIZE="-2" FACE="verdana, arial, helvetica">
        <FONT COLOR="#C0C0C0">Maintained with <B>Subscribe Me $version</B></FONT></FONT></TD>
      </TR></TBODY>
    </TABLE></CENTER>
</BODY></HTML>
EOF
} elsif (lc $link eq "no_credit") {
print<<EOF;
</BODY></HTML>
EOF
} else {
print<<EOF;
    <CENTER>
    <TABLE BORDER="0" WIDTH="400">
      <TBODY>
      <TR>
        <TD><HR SIZE="1"></TD>
      </TR>
      <TR>
        <TD ALIGN="CENTER"><FONT SIZE="-2" FACE="verdana, arial, helvetica">
        Maintained with <A HREF="http://www.subscribemepro.com/" TARGET="_blank"><B>Subscribe
          Me $version</B></A></FONT></TD>
      </TR></TBODY>
    </TABLE></CENTER>
</BODY></HTML>
EOF
}
}



sub header2 {

if (-e "$graphics/sub3.gif") {
print<<EOF;
<CENTER>
    <TABLE BORDER="0" CELLPADDING="1" CELLSPACING="0" BGCOLOR="#FFFF80" WIDTH="500">
      <TR>
        <TD BGCOLOR="#FFB500" ALIGN="CENTER" WIDTH="100%">
        <TABLE BORDER="0" BGCOLOR="#FFFFFF" CELLSPACING="0" CELLPADDING="5" WIDTH="100%">
          <TR>
            <TD ALIGN="CENTER"><IMG SRC="$cgiurl?graphic=sub3.gif" 
    ALT="Subscribe Me Professional logo" WIDTH="129" HEIGHT="77"></TD>
            <TD ALIGN="CENTER" VALIGN="MIDDLE"><FONT FACE="verdana, arial, helvetica" SIZE="-1"><B>Subscribe
            Me Professional<BR>
             Administration Panel $version</B></FONT><HR SIZE="1" WIDTH="150">
            <FONT SIZE="-2" FACE="verdana, arial, helvetica"><A HREF="http://www.cgiscriptcenter.com/subscribe/pro/support/" TARGET="_blank">Users
              Manual and Support</A></FONT></TD>
          </TR>
        </TABLE> <BR>

EOF
} else {
print<<EOF;
<CENTER>
    <TABLE BORDER="0" CELLPADDING="1" CELLSPACING="0" BGCOLOR="#FFFF80" WIDTH="500">
      <TR>
        <TD BGCOLOR="#FFB500" ALIGN="CENTER" WIDTH="100%">
        <TABLE BORDER="0" BGCOLOR="#FFFFFF" CELLSPACING="0" CELLPADDING="5" WIDTH="100%">
          <TR>
            <TD ALIGN="CENTER" VALIGN="MIDDLE"><FONT FACE="verdana, arial, helvetica" SIZE="-1"><B>Subscribe
            Me Professional<BR>
             Administration Panel $version</B></FONT><HR SIZE="1" WIDTH="150">
            <FONT SIZE="-2" FACE="verdana, arial, helvetica"><A HREF="http://www.cgiscriptcenter.com/subscribe/pro/support/" TARGET="_blank">Users
              Manual and Support</A></FONT></TD>
          </TR>
        </TABLE> <BR>
EOF
}


}




sub footer2 {

print "<P><BR></P></TD>
      </TR>
    </TABLE></CENTER>";

}




sub header3 {

# &totalsubscribers;

if (-e "$graphics/sub3.gif") {
print<<EOF;
<CENTER>
    <TABLE BORDER="0" CELLPADDING="1" CELLSPACING="0" BGCOLOR="#FFFF80" WIDTH="500">
      <TR>
        <TD BGCOLOR="#FFB500" ALIGN="CENTER" WIDTH="100%">
        <TABLE BORDER="0" BGCOLOR="#FFFFFF" CELLSPACING="0" CELLPADDING="5" WIDTH="100%">
          <TR>
            <TD ALIGN="CENTER"><IMG SRC="$cgiurl?graphic=sub3.gif" 
    ALT="Subscribe Me Professional logo" WIDTH="129" HEIGHT="77"></TD>
            <TD ALIGN="CENTER" VALIGN="MIDDLE"><FONT FACE="verdana, arial, helvetica" SIZE="-1"><B>Subscribe
            Me Professional $version<BR>
             Administration Panel</B></FONT><HR SIZE="1" WIDTH="150">
            <FONT SIZE="-2" FACE="verdana, arial, helvetica"><A HREF="http://www.cgiscriptcenter.com/subscribe/pro/support/" TARGET="_blank">Users
              Manual and Support</A></FONT></TD>
          </TR>
        </TABLE>
EOF
} else {
print<<EOF;
<CENTER>
    <TABLE BORDER="0" CELLPADDING="1" CELLSPACING="0" BGCOLOR="#FFFF80" WIDTH="500">
      <TR>
        <TD BGCOLOR="#FFB500" ALIGN="CENTER" WIDTH="100%">
        <TABLE BORDER="0" BGCOLOR="#FFFFFF" CELLSPACING="0" CELLPADDING="5" WIDTH="100%">
          <TR>
            <TD ALIGN="CENTER" VALIGN="MIDDLE"><FONT FACE="verdana, arial, helvetica" SIZE="-1"><B>Subscribe
            Me Professional $version<BR>
             Administration Panel</B></FONT><HR SIZE="1" WIDTH="150">
            <FONT SIZE="-2" FACE="verdana, arial, helvetica"><A HREF="http://www.cgiscriptcenter.com/subscribe/pro/support/" TARGET="_blank">Users
              Manual and Support</A></FONT></TD>
          </TR>
        </TABLE>
EOF
}
}

sub footer3 {

print"</TD>
      </TR>
    </TABLE></CENTER>";

}








sub display_graphic {

if ($in{'graphic'}) {

print "Content-type: image/$imagetype\n";
print "\n";
$file = "$graphics/$in{'graphic'}";
open (IMAGE, "<$file") || die "Can't open $file: $!";
if ($os eq 'nt') {
binmode(IMAGE); ## If used on an NT server, remove the "#" at front.
binmode(STDOUT); ## If used on an NT server, remove the "#" at front.
}
while (<IMAGE>)
{
        print $_;
}
close(IMAGE);
# exit;
}
}


1;