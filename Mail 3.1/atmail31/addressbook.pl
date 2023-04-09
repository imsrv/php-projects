#!/usr/bin/perl
# Address Book for @Mail 2.3

# @Mail library configuration
use CGI qw(:standard);
use CGI::Carp qw(fatalsToBrowser carpout);

# Find cwd and set to library path
use FindBin qw($Bin);
use lib "$Bin/libs";

do "$Bin/atmail.conf";
do "$Bin/html/header.phtml";
do "$Bin/html/footer.phtml";

require 'Common.pm';

&config;
&htmlheader("\@Mail Address Book");
&delete if($delete);
&update if($update);
&more if($more);
&addaddress if($addaddress);
&viewaddressbook;
&addaddressbook;

sub delete
{
open(BOOK,"$Bin/users/$confdir/address.book") || die "Cannot open $Bin/users/$confdir/address.book: $!\n";
open(NEWBOOK,">$Bin/users/$confdir/address.book.new") || die "Cannot open $Bin/users/$confdir/address.book.new: $!\n";

while(<BOOK>)	{

($myfullname,$myemailaddress,$myurl,$myinfo) = split("!");
	if($myfullname eq $fullname)	{ } else {
	print NEWBOOK "$_"; }
	                        	}
close(BOOK);
close(NEWBOOK);

rename("$Bin/users/$confdir/address.book.new","$Bin/users/$confdir/address.book");

}

sub clean
{

$fullname =~ s/!//g;
$fullname =~ s/\n//g;

$emailaddress =~ s/!//g;
$emailaddress =~ s/\n//g;

$url =~ s/!//g;
$url =~ s/\n//g;

$info =~ s/!//g;
$info =~ s/\n//g;
$info =~ s/\r/ /g;
}

sub update
{
open(BOOK,"$Bin/users/$confdir/address.book") || die "Cannot open $installdir/users/$confdir/address.book: $!\n";
open(NEWBOOK,">$Bin/users/$confdir/address.book.new") || die "Cannot open $Bin/users/$confdir/address.book.new: $!\n";

&clean;

while(<BOOK>)	{
($myfullname,$myemailaddress,$myurl,$myinfo) = split("!");
	if($myfullname eq $fullname)	{
	print NEWBOOK "$fullname!$emailaddress!$url!$info\n";
	} else { print NEWBOOK "$_"; }
		}
close(BOOK);
close(NEWBOOK);
rename("$Bin/users/$confdir/address.book.new","$Bin/users/$confdir/address.book");

}

sub more
{

open(BOOK,"$Bin/users/$confdir/address.book") || die "Cannot open $installdir/users/$confdir/address.book: $!\n";


while(<BOOK>)
 {
my($fullname,$emailaddress,$url,$info) = split("!");
	if($fullname eq $more && !$read{$fullname})	{

$read{$fullname}++;

$cgi->delete_all();
$cgi->param('delete', $fullname);
my $delete = $cgi->self_url;

print<<_EOF;
        <table width="100%" border="1"><form>

<input type="hidden" name="username" value="$username">
<input type="hidden" name="pop3host" value="$pop3host">
<input type="hidden" name="update" value="1">
          <tr bgcolor="$primarycolor"> 
            <td colspan="2" height="29"><font color="#FFFFFF"><b>
<font size="3" face="Verdana, Arial, Helvetica, sans-serif">
$fullname information [<a href="$delete">delete</a>]</font></b></font></td>
          </tr>
          <tr> 
            <td width="22%" bgcolor="$secondarycolor" height="26">Full Name</td>
            <td width="78%" bgcolor="$secondarycolor" height="26">
              <input type="text" name="fullname" size="45" value="$fullname">
            </td>
          </tr>
          <tr bgcolor="$primarycolor"> 
            <td width="22%" height="26">Email Address</td>
            <td width="78%" height="26"> 
              <input type="text" name="emailaddress" size="45" value="$emailaddress">
            </td>
          </tr>
          <tr> 
            <td width="22%" bgcolor="$secondarycolor" height="26">URL</td>
            <td width="78%" bgcolor="$secondarycolor" height="26">
              <input type="text" name="url" size="45" value="$url">
            </td>
          </tr>
          <tr bgcolor="$primarycolor"> 
            <td width="22%" height="26">Additional Info</td>
            <td width="78%" height="26"> 
              <textarea name="info" cols="37" rows="5">$info</textarea>
            </td>
          </tr>
<tr bgcolor="$primarycolor"> 
            <td width="22%" height="26">Update Entry</td>
            <td width="78%" height="26"> 
 <input type="submit" name="Submit" value="Update">            
</td>
          </tr>
</form>
        </table>
<BR>
_EOF
	}
    }

}


sub viewaddressbook {


open(BOOK,"$Bin/users/$confdir/address.book") || die "Cannot open $installdir/users/$confdir/address.book: $!\n";

print<<_EOF;
<table width="100%" border="1">
          <tr bgcolor="$primarycolor"> 
            <td colspan="3" height="25"><font color="#FFFFFF"><b><font size="3" face="Verdana, Arial, Helvetica, sans-serif">$username\@$pop3host 
              Address Book </font></b></font></td>
          </tr>
          <input type="hidden" name="savesettings" value="1">
          <input type="hidden" name="username" value="demo3">
          <input type="hidden" name="pop3host" value="webbasedemail.net">
          <tr> 
            <td width="19%" bgcolor="$secondarycolor" height="26"><b>Full Name</b></td>
            <td width="19%" bgcolor="$secondarycolor" height="26"><b>Email Address</b></td>
            <td width="25%" bgcolor="$secondarycolor" height="26"><b>URL</b></td>
          </tr>
_EOF

while(<BOOK>)
 {

my($fullname,$emailaddress,$url,$info) = split("!");

$cgi->delete_all();
$cgi->param('more', $fullname);
my $more = $cgi->self_url;


$newbgcolor = ($newbgcolor eq "$secondarycolor") ? "$primarycolor" : "$secondarycolor";

print<<_EOF;

<tr bgcolor="$newbgcolor"> 
<td height="32" width="19%" bgcolor="$newbgcolor">
[<a href="$more">more</a>]
$fullname
</td>

<td height="32" width="19%" bgcolor="$newbgcolor">
<a href="mailto:$emailaddress">$emailaddress</a></td>

<td height="32" width="25%" bgcolor="$newbgcolor">
<a href="$url">$url</a></td>
  
_EOF
	}

print<<_EOF;
</tr>
</table>
_EOF

 }

sub addaddress
{

open(BOOK,">>$Bin/users/$confdir/address.book") || die "Cannot open $installdir/users/$confdir/address.book: $!\n";

&clean;

print BOOK "$fullname!$emailaddress!$url!$info\n";

close(BOOK);
}

sub addaddressbook {

print<<_EOF;

<form method="post">
<input type="hidden" name="username" value="$username">
<input type="hidden" name="pop3host" value="$pop3host">
<br>
        <table width="100%" border="1">
          <tr bgcolor="$primarycolor"> 
            <td colspan="2" height="29"><font color="#FFFFFF"><b><font size="3" face="Verdana, Arial, Helvetica, sans-serif">Add 
              User To Address Book </font></b></font></td>
          </tr>
          <tr> 
<input type=hidden name="addaddress" value="1">
            <td width="22%" bgcolor="$secondarycolor" height="26">Full Name</td>
            <td width="78%" bgcolor="$secondarycolor" height="26">
              <input type="text" name="fullname" size="45">
            </td>
          </tr>
          <tr bgcolor="$primarycolor"> 
            <td width="22%" height="26">Email Address</td>
            <td width="78%" height="26"> 
              <input type="text" name="emailaddress" size="45">
            </td>
          </tr>
          <tr> 
            <td width="22%" bgcolor="$secondarycolor" height="26">URL</td>
            <td width="78%" bgcolor="$secondarycolor" height="26">
              <input type="text" name="url" size="45">
            </td>
          </tr>
          <tr bgcolor="$primarycolor"> 
            <td width="22%" height="26">Additional Info</td>
            <td width="78%" height="26"> 
              <textarea name="info" cols="43" rows="5"></textarea>
            </td>
          </tr>
        </table>
        <br>
        <table width="280" border="1">
          <tr bgcolor="$primarycolor"> 
      <td colspan="2" height="25">
              <div align="center"><font color="#FFFFFF"><b><font size="3" face="Verdana, Arial, Helvetica, sans-serif">Add 
                User to Address Book</font></b></font></div>
      </td>
    </tr>
    <tr bgcolor="$secondarycolor"> 
      <td width="100%" height="42" colspan="2"><center> 
        <input type="submit" name="Submit" value="Save"></center>
      </td>
    </tr>
  </table>
</form>

_EOF

&htmlend;	

}
