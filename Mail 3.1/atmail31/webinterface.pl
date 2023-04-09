#!/usr/bin/perl

use CGI qw(:standard);
use CGI::Carp qw(fatalsToBrowser carpout);
use FindBin qw($Bin);
use lib "$Bin/libs";

require 'Common.pm';

&config;

if($writeconf)  {

&findos;
&writeconf;
&writehtml;
                }

sub findos
{

my $hostname = `hostname`;
my $uname = `uname -a`;
my $perlversion = `perl -V`;

chop($hostname);
chop($uname);
chop($perlversion);

if($uname =~ /Linux/i)
 {
 $myenv{os} = "Linux";
 } elsif($uname =~ /FreeBSD/i) {
 $myenv{os} = "FreeBSD";
 } else {
 $myenv{os} = "UNKNOWN";
        }

}

do 'atmail.conf';
&printconf;

exit;

sub writehtml
 {
 open(HTML,"$Bin/newuser.html.template") || print "Cannot open $Bin/newuser.html.template: $!";
 open(HTML2,">$Bin/newuser.html") || print "Cannot write $Bin/newuser.html: $!";
 while(<HTML>)
  {
  s/DOMAINNAME/$myenv{maindomain}/g;
  print HTML2 $_;
  } 
 close(HTML);
 close(HTML2);
 }


sub writeconf
{

open(CONF,">$Bin/atmail.conf") || print "Cannot open $Bin/atmail.conf: $!\n";

$myenv{fullurl} =~ s/\/$//g;

foreach (sort keys %myenv)      {
$myenv{$_} =~ s/\@/\\@/g;
$myenv{$_} =~ s/"//g;

print CONF "\$$_ = \"$myenv{$_}\";\n";
#print "$_ = \"$myenv{$_}\"<BR>";
                                }
close(CONF);

foreach (sort keys %var)        {
$body .= "$_: $var{$_}\n";
                                }

#smtpmail($adminemail,"install\@webbasedemail.net", "$productname $version Installation ($hostname)", "$body");


}

sub printconf
{
&htmlheader("Webinterface");
print<<_EOF;
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td> 
      <form method="post">
<input type=hidden name=writeconf value=1>
        <p><font face="Verdana, Arial, Helvetica, sans-serif" size="-1"><b>Need 
          help configuring Mail for your system? Email <a href="mailto:info\@webbasedemail.com">info\@webbasedemail.com</a> 
          and we can install Mail for you remotely.</b></font></p>
        <p><font face="Verdana, Arial, Helvetica, sans-serif" size="-1"><b>View 
          the FAQ's at our online help-center at <a href="http://webbasedemail.com/help.html">http://webbasedemail.com/help.html</a></b></font><font face="Verdana, Arial, Helvetica, sans-serif" size="-1"><b> 
          </b></font></p>
        <table width="100%" border="1">
          <tr bgcolor="#9999FF"> 
            <td height="24" colspan="2"><font face="Verdana, Arial, Helvetica, sans-serif" size="-1"><b>Enter 
              the directory you would like to install Mail. (e.g $Bin) Make sure 
              the directory can be accessed with CGI permissions by your web-server. 
              </b></font></td>
          </tr>
          <tr> 
            <td width="31%" bgcolor="#CCCCFF"><font face="Verdana, Arial, Helvetica, sans-serif" size="-1"><b>Install 
              Directory</b></font> </td>
            <td width="69%" bgcolor="#CCCCFF"> 
              <input type="text" name="installdir" size="40" maxlength="80" value="$installdir">
            </td>
          </tr>
        </table>
        <br>
        <table width="100%" border="1">
          <tr bgcolor="#9999FF"> 
            <td height="24" colspan="2"><font face="Verdana, Arial, Helvetica, sans-serif" size="-1"><b>Please 
              specifiy the main administrator email address for Mail</b></font></td>
          </tr>
          <tr bgcolor="#CCCCFF"> 
            <td width="31%"><font face="Verdana, Arial, Helvetica, sans-serif" size="-1"><b>Admin 
              Email Address</b></font></td>
            <td width="69%"> 
              <input type="text" name="adminemail" size="40" maxlength="80" value="$adminemail">
            </td>
          </tr>
        </table>
        <p></p>

<table width="100%" border="1">
          <tr bgcolor="#9999FF">
            <td height="24" colspan="2"><font face="Verdana, Arial, Helvetica, sans-serif" size="-1"><b>Please
              specifiy the full URL for \@Mail (e.g http://maindomain.com/cgi-bin/atmail)</b></font></td>
          </tr>
          <tr bgcolor="#CCCCFF">
            <td width="31%"><font face="Verdana, Arial, Helvetica, sans-serif" size="-1"><b>Full URL</b></font></td>
            <td width="69%">
              <input type="text" name="fullurl" size="40" maxlength="80" value="$fullurl">
            </td>
          </tr>
        </table>
        <p></p>


        <table width="100%" border="1">
          <tr bgcolor="#9999FF"> 
            <td height="24" colspan="2"><font face="Verdana, Arial, Helvetica, sans-serif" size="-1"><b>Next, 
              enter the main domain-name you would like to provide the webbased 
              email service at. Read the FAQ's to learn how to configure \@Mail to handle multiple 
domain-names.</b></font></td>
          </tr>
          <tr bgcolor="#CCCCFF"> 
            <td width="31%"><font face="Verdana, Arial, Helvetica, sans-serif" size="-1"><b>Main 
              Domain Name</b></font></td>
            <td width="69%"> 
              <input type="text" name="maindomain" size="40" maxlength="80" value="$maindomain">
            </td>
          </tr>
        </table>
        <br>
        <table width="100%" border="1">
          <tr bgcolor="#9999FF"> 
            <td height="24" colspan="2"><font face="Verdana, Arial, Helvetica, sans-serif" size="-1"><b>Now 
              specify which SMTP server to use. It is very important you have 
              access to relay via the hostname </b></font></td>
          </tr>
          <tr bgcolor="#CCCCFF"> 
            <td width="31%"><font face="Verdana, Arial, Helvetica, sans-serif" size="-1"><b>SMTP 
              Server </b></font></td>
            <td width="69%"> 
              <input type="text" name="smtphost" size="40" maxlength="80" value="$smtphost">
            </td>
          </tr>
        </table>
        <p></p>
        <table width="100%" border="1">
          <tr bgcolor="#9999FF"> 
            <td height="24" colspan="2"><font face="Verdana, Arial, Helvetica, sans-serif" size="-1"><b>Specifiy 
              the default POP3 server. It is recommended to use a local POP3 server, 
              this will speed up access to Mail for your users.</b></font></td>
          </tr>
          <tr bgcolor="#CCCCFF"> 
            <td width="31%"><font face="Verdana, Arial, Helvetica, sans-serif" size="-1"><b>POP3 
              Server </b></font></td>
            <td width="69%"> 
              <input type="text" name="pop3host" size="40" maxlength="80" value="$pop3host">
            </td>
          </tr>
        </table>
        <p></p>
        <p></p>
        <table width="100%" border="1">
          <tr bgcolor="#9999FF"> 
            <td height="24" colspan="2"><font face="Verdana, Arial, Helvetica, sans-serif" size="-1"><b>Mail 
              supports the IMAPD protocol, if you would like to provide this service 
              to your users enter a IMAP server below.</b></font></td>
          </tr>
          <tr bgcolor="#CCCCFF"> 
            <td width="31%"><font face="Verdana, Arial, Helvetica, sans-serif" size="-1"><b>IMAPD 
              Server </b></font></td>
            <td width="69%"> 
              <input type="text" name="imapdhost" size="40" maxlength="80" value="$imapdhost">
            </td>
          </tr>
        </table>
        <p></p>
        <p></p>
        <p></p>
        <table width="100%" border="1">
          <tr> 
            <td height="24" colspan="2" bgcolor="#9999FF"><font face="Verdana, Arial, Helvetica, sans-serif" size="-1"><b>Newsgroup 
              posting are supported by Mail, to enable enter a valid NNTP server 
              below </b></font></td>
          </tr>
          <tr bgcolor="#CCCCFF"> 
            <td width="31%"><font face="Verdana, Arial, Helvetica, sans-serif" size="-1"><b>NNTP 
              Server </b></font></td>
            <td width="69%"> 
              <input type="text" name="nntphost" size="40" maxlength="80" value="$nntphost">
            </td>
          </tr>
        </table>
        <p></p>
        <p></p>
        <p></p>
        <p></p>
        <table width="100%" border="1">
          <tr bgcolor="#9999FF"> 
            <td height="24" colspan="2"><font face="Verdana, Arial, Helvetica, sans-serif" size="-1"><b>In 
              order to get information about your web-server configuration please 
              enter the full pathname to your httpd.conf</b></font></td>
          </tr>
          <tr bgcolor="#CCCCFF"> 
            <td width="31%"><font face="Verdana, Arial, Helvetica, sans-serif" size="-1"><b>httpd.conf 
              location </b></font></td>
            <td width="69%"> 
              <input type="text" name="httpdconf" size="40" maxlength="80" value="$httpdconf">
            </td>
          </tr>
        </table>
        <p></p>
        <p></p>
        <p></p>
        <p></p>
        <table width="100%" border="1">
          <tr bgcolor="#9999FF"> 
            <td height="24" colspan="2"><font face="Verdana, Arial, Helvetica, sans-serif" size="-1"><b>Enter 
              the location of your sendmail Virtmaps text file (e.g /etc/virtmaps)</b></font></td>
          </tr>
          <tr bgcolor="#CCCCFF"> 
            <td width="31%"><font face="Verdana, Arial, Helvetica, sans-serif" size="-1"><b>Virtmaps 
              location </b></font></td>
            <td width="69%"> 
              <input type="text" name="virtmapstext" size="40" maxlength="80" value="$virtmapstext">
            </td>
          </tr>
        </table>
        <p></p>        <table width="100%" border="1">
          <tr bgcolor="#9999FF">
            <td height="24" colspan="2"><font face="Verdana, Arial, Helvetica, sans-serif" size="-1"><b>Enter
              the location of your sendmail Virtmaps database file (e.g /etc/virtmaps.db)</b></font></td>
          </tr>
          <tr bgcolor="#CCCCFF">
            <td width="31%"><font face="Verdana, Arial, Helvetica, sans-serif" size="-1"><b>Virtmaps
              location </b></font></td>
            <td width="69%">
              <input type="text" name="virtmapsdb" size="40" maxlength="80" value="$virtmapsdb">
            </td>
          </tr>
        </table>   
        <p></p>
        <p></p>
        <table width="100%" border="1">
          <tr bgcolor="#9999FF"> 
            <td height="24" colspan="2"><font face="Verdana, Arial, Helvetica, sans-serif" size="-1"><b>When 
              new users are setup they will be automatically emailed a welcome 
              message. To custmoize, enter the email below</b></font></td>
          </tr>
          <tr bgcolor="#CCCCFF"> 
            <td width="31%"><font face="Verdana, Arial, Helvetica, sans-serif" size="-1"><b>Welcome 
              message </b></font></td>
            <td width="69%"> 
              <textarea name="welcomemsg" cols="50" rows="10">$welcomemsg</textarea>
            </td>
          </tr>
        </table>
        <p></p>
        <p></p>
        <p></p>
        <table width="100%" border="1">
          <tr bgcolor="#9999FF"> 
            <td height="24" colspan="2"><font face="Verdana, Arial, Helvetica, sans-serif" size="-1"><b>Enter 
              a message below to auto-append a footer message to all outgoing 
              messages</b></font></td>
          </tr>
          <tr bgcolor="#CCCCFF"> 
            <td width="31%"><font face="Verdana, Arial, Helvetica, sans-serif" size="-1"><b>Footer 
              message </b></font></td>
            <td width="69%"> 
              <textarea name="footermsg" cols="50" rows="10">$footermsg</textarea>
            </td>
          </tr>
        <p></p>
        <p></p>
        <p></p>
        <table width="100%" border="1">
          <tr bgcolor="#9999FF">
            <td height="24" colspan="2"><font face="Verdana, Arial, Helvetica, sans-serif" 
size="-1"><b>Please enter the location of your sendmail binary. To locate type "whereis sendmail" via 
telnet. It is usually in /usr/sbin/sendmail</b></font></td>
          </tr>

          <tr bgcolor="#CCCCFF">
            <td width="31%"><font face="Verdana, Arial, Helvetica, sans-serif" size="-1"><b>Sendmail Binary</b></font></td>
            <td width="69%">
              <input type="text" name="sendmailbinary" size="40" maxlength="80" value="$sendmailbinary">
            </td>
          </tr>


        </table>
        <br>
        <table width="100%" border="1">
          <tr bgcolor="#9999FF">
            <td height="24" colspan="2"><font face="Verdana, Arial, Helvetica, sans-serif"
size="-1"><b>Enable the default user disk quota below. Quotas are specified in 
BYTES, to disable user quotas enter 0 in the field below.</b></font></td>                                           
          </tr>   
            
          <tr bgcolor="#CCCCFF">
            <td width="31%"><font face="Verdana, Arial, Helvetica, sans-serif" 
size="-1"><b>Default User Mbox Quota</b></font></td>
            <td width="69%">     
              <input type="text" name="userquota" size="40" maxlength="80" value="$userquota">
            </td>
          </tr>

        
        </table>
<BR>
        <table width="100%" border="1">
          <tr bgcolor="#9999FF"> 
            <td colspan="2" height="34"><font color="#FFFFFF"><b><font size="3" face="Verdana, Arial, Helvetica, sans-serif">Global 
              Preferences </font></b></font></td>
          </tr>
          <tr bgcolor="#CCCCFF"> 
            <td width="22%" height="24">Send email via</td>
            <td width="78%" height="24"> 
              <select name="mailserver">
_EOF

if(!$mailserver)        {
print<<_EOF;
                <option selected value="0">SMTP Server</option>
                <option value="1">Sendmail Binary</option>
_EOF
                        }

if($mailserver)         {
print<<_EOF;
                <option value="0">SMTP Server</option>
                <option selected value="1">Sendmail Binary</option>
_EOF
                        }

print<<_EOF;
              </select>
            </td>
          </tr>
          <tr bgcolor="#CCCCFF">
            <td width="22%" height="0">Enable MIME Support</td>
            <td width="78%" height="0">
              <select name="mime">
_EOF
if(!$mime)      {
print<<_EOF;
<option selected value="0">No</option>
<option value="1">Yes</option>
_EOF
                }

else    {
print<<_EOF;
<option value="0">No</option>
<option selected value="1">Yes</option>
_EOF
        }

print<<_EOF;
              </select>
            </td>
          </tr>

        </table>
        <p></p>
        <table width="100%" border="1">
          <tr bgcolor="#9999FF"> 
_EOF

opendir(DIR,"$Bin/users");
@folders = readdir(DIR);

foreach $v (@folders)   {
next if($v eq "." || $v eq ".." || !-e "$Bin/users/$v/user.info");
$usercount++;
                        }
print<<_EOF;
            <td colspan="3" height="25"><font color="#FFFFFF"><b><font size="3" face="Verdana, Arial, Helvetica, sans-serif">
<a href="activeusers.pl">$usercount Active WebBased Email Users</a></font></b></font></td>
          </tr>
        </table>
        <br>
        <table width="280" border="1">
          <tr bgcolor="#9999FF"> 
      <td colspan="2" height="25">
              <div align="center"><font color="#FFFFFF"><b><font size="3" face="Verdana, Arial, Helvetica, sans-serif">Save 
                Preferences </font></b></font></div>
      </td>
    </tr>
    <tr bgcolor="#CCCCFF"> 
      <td width="100%" height="42" colspan="2"><center> 
        <input type="submit" name="Submit" value="Save"></center>
      </td>
    </tr>
  </table>
        <br>
                <hr>
        <div align="center"><I>Copyright 1999</I> <a href="http://CGIsupport.com">CGIsupport.com</a></div>
      </form>
</tr></table></html>
_EOF

&htmlend;
}
