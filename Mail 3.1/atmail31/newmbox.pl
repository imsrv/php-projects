#!/usr/bin/perl
# Create a new Mailbox

# @Mail library configuration
use CGI qw(:standard);
use CGI::Carp qw(fatalsToBrowser carpout);

# Find cwd and set to library path
use FindBin qw($Bin);
use lib "$Bin/libs";

do "$Bin/atmail.conf";
do "$Bin/html/header.phtml";
do "$Bin/html/footer.phtml";
do "$Bin/html/javascript.js";

require 'Common.pm';

&config;
&deletembox if($deletembox);
&creatembox if($creatembox);
&getmbox;
&htmlend;
exit;

sub deletembox
 {
$cnt = unlink "$Bin/users/$confdir/mbox/$deletembox";
$status = "Deleted mailbox $deletembox" if($cnt);
$status = "Error deleting mailbox $deletembox" if(!$cnt);
 }

sub creatembox
 {
if($creatembox =~ / /) {
$status = "Mailboxes cannot contain whitespace characters!";
return;
			}

if(-e "$Bin/users/$confdir/mbox/$creatembox") {
$status = "$creatembox already exists!";
return;
                        }


open(NEWMBOX,">>$Bin/users/$confdir/mbox/$creatembox") ||
print "Cannot create $Bin/users/$confdir/mbox/$creatembox: $!\n";
close(NEWMBOX);
$status = "Created new mailbox $creatembox";
 }

sub getmbox
 {
&htmlheader("Reading $folder ...");

print<<_EOF;
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr> 
    <td> 
      <form method="post">
        <table width="100%" border="1">
          <tr bgcolor="$primarycolor"> 
            <td colspan="4" height="28"><font color="$headercolor"><b> <font size="3" face="Verdana, Arial, Helvetica, sans-serif">Active 
              Mailbox's for $username\@$pop3host</font></b></font></td>
          </tr>
          <input type="hidden" name="username" value="$username">
          <input type="hidden" name="pop3host" value="$pop3host">
          <tr> 
            <td width="29%" bgcolor="$secondarycolor" height="26">Mailbox Name</td>
            <td width="29%" bgcolor="$secondarycolor" height="26">Total Messages</td>
            <td width="61%" bgcolor="$secondarycolor" height="26">Filesize</td>
	    <td width="10%" bgcolor="$secondarycolor" height="26">Delete</td>
          </tr>
_EOF

opendir(DIR,"$Bin/users/$confdir/mbox");
@folders = readdir(DIR);

foreach $folder (@folders)
	{
next if($folder eq "." || $folder eq ".." || $folder eq "tmp");
$mboxmsgs=0;

open(MBOX,"$Bin/users/$confdir/mbox/$folder");
while(<MBOX>) { $mboxmsgs++ if($_ =~ /^Subject:/); }
close(MBOX);

$size = (stat("$Bin/users/$confdir/mbox/$folder"))[7];
$size = $size / 1024;
$size = sprintf ("%2.1f KB",$size);
print<<_EOF;
          <tr>
            <td width="29%" bgcolor="$secondarycolor" height="26">
<a href="showmail.pl?username=$username&pop3host=$pop3host&localmbox=$folder" target=window>$folder</a></td>
            <td width="29%" bgcolor="$secondarycolor" height="26">$mboxmsgs messages</td>
            <td width="61%" bgcolor="$secondarycolor" height="26">$size</td>
<td width="10%" bgcolor="$secondarycolor" height="26">
<a href="newmbox.pl?username=$username&pop3host=$pop3host&deletembox=$folder">
<img border=0 src="imgs/trash.gif" width="16" height="16" alt="Delete Mailbox $folder"></a>
</td>
          </tr>
_EOF
	}

print<<_EOF;
        </table>
        <br>
        <table width="100%" border="1">
          <tr bgcolor="$primarycolor"> 
            <td colspan="2" height="25"><font color="$headercolor"><b> <font size="3" face="Verdana, Arial, Helvetica, sans-serif">Create 
              a new Mailbox</font></b></font></td>
          </tr>
          <tr> 
            <td width="29%" bgcolor="$secondarycolor" height="26">Mailbox Name</td>
            <td width="71%" bgcolor="$secondarycolor" height="26">
              <input type="text" name="creatembox" value="Enter mailbox name" size="30">
            </td>
          </tr>
        </table>
        <br>
  <table width="190" border="1">
    <tr bgcolor="$primarycolor"> 
      <td colspan="2" height="25">
              <div align="center"><font color="$headercolor"><b> <font size="3" face="Verdana, Arial, Helvetica, sans-serif">Create 
                Mbox</font></b></font></div>
      </td>
    </tr>
    <tr bgcolor="$secondarycolor"> 
      <td width="100%" height="42" colspan="2"><center> 
        <input type="submit" name="Submit" value="Save"></center>
      </td>
    </tr>
  </table>
</form>
</tr></table>
_EOF

}
