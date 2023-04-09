#!/usr/bin/perl
# User preferences

use CGI qw(:standard);
use CGI::Carp qw(fatalsToBrowser carpout);

# Find cwd and set to library path
use FindBin qw($Bin);
use lib "$Bin/libs";

do "$Bin/atmail.conf";
do "$Bin/html/header.phtml";
do "$Bin/html/footer.phtml";
#do "$Bin/html/settings.phtml";

require 'Common.pm';

&config;
&settings;
&htmlend;
exit;


sub settings {

#&preferences if($savesettings);

&htmlheader("Settings for $username\@$pop3host ...");

print<<_EOF;
<form method="post">
  <table width="100%" border="1">
    <tr bgcolor="$primarycolor"> 
      <td colspan="2" height="25"><font color="$headercolor"><b>
<font size="3" face="Verdana, Arial, Helvetica, sans-serif">Email
        Preferences </font></b></font></td>
    </tr>
<input type="hidden" name="savesettings" value="1">
<input type="hidden" name="username" value="$username">
<input type="hidden" name="pop3host" value="$pop3host">
    <tr> 
      <td width="29%" bgcolor="$secondarycolor" height="26">Username</td>
      <td width="71%" bgcolor="$secondarycolor" height="26">
        <input type="text" name="username" size="40" value="$username">
      </td>
    </tr>
    <tr bgcolor="$secondarycolor">
      <td height="12" width="29%" bgcolor="$primarycolor">Password</td>
      <td height="12" width="71%" bgcolor="$primarycolor">
        <input type="text" name="password" size="40" value="$password">
      </td>
    </tr>
    <tr bgcolor="$secondarycolor"> 
      <td height="12" width="29%">POP3 Hostname</td>
      <td height="12" width="71%">
        <input type="text" name="pop3host" size="40" value="$pop3host">
      </td>
    </tr>
    <tr bgcolor="$secondarycolor"> 
      <td height="12" width="29%" bgcolor="$primarycolor">Real Name</td>
      <td height="12" width="71%" bgcolor="$primarycolor">
        <input type="text" name="realname" size="40" value="$realname">
      </td>
    </tr>
    <tr bgcolor="$secondarycolor"> 
      <td height="12" width="29%">Check email every</td>
      <td height="12" width="71%"> 
        <input type="text" name="refresh" size="5" value="$refresh">
        seconds </td>
    </tr>
    <tr bgcolor="$primarycolor">
      <td height="12" width="29%">Email Signature</td>
      <td height="12" width="71%">
<textarea name="signature" cols="40" rows="5">
$signature
</textarea>

      </td>                                                         
    </tr>
  </table>
  <br>
  <table width="100%" border="1">
    <tr bgcolor="$primarycolor"> 
      <td colspan="2" height="25"><font color="$headercolor"><b>
<font size="3" face="Verdana, Arial, Helvetica, sans-serif">Layout 
        Preferences </font></b></font></td>
    </tr>
    <tr> 
      <td width="29%" bgcolor="$secondarycolor" height="26">Design type</td>
      <td width="71%" bgcolor="$secondarycolor" height="26"> 
        <select name="designtype">
          <option value="none">Select Design</option>
          <option value="standard">Blue Sky (Standard)</option>
          <option value="purplehaze">Purple Haze</option>
          <option value="grey">Grey sky</option>
          <option value="custom">Custom Design</option>
        </select>
      </td></tr><tr>
<td width="29%" bgcolor="$secondarycolor" height="26">Navigation Bar</td>
<td width="71%" bgcolor="$primarycolor" height="26"><select name="navbar">
  <option>Select Option</option>
  <option value="1">Enabled</option>
  <option value="0">Disabled</option>
</select>
</td>
    </tr>
  </table>
  <br>
  <table width="100%" border="1">
    <tr bgcolor="$primarycolor"> 
      <td colspan="2" height="25"><font color="$headercolor"><b>
<font size="3" face="Verdana, Arial, Helvetica, sans-serif">Custom 
        Layout</font></b></font></td>
    </tr>
    <tr> 
      <td width="29%" bgcolor="$secondarycolor" height="26">Primary Color</td>
      <td width="71%" bgcolor="$secondarycolor" height="26"> 
        <input type="text" name="primarycolor" size="7" value="$primarycolor">
        (e.g white, $headercolor)</td>
    </tr>
    <tr bgcolor="$secondarycolor"> 
      <td height="12" width="29%" bgcolor="$primarycolor">Secondary Color</td>
      <td height="12" width="71%" bgcolor="$primarycolor"> 
        <input type="text" name="secondarycolor" size="7" value="$secondarycolor">
      </td>
    </tr>
    <tr bgcolor="$secondarycolor"> 
      <td height="12" width="29%" bgcolor="$secondarycolor">Link Color</td>
      <td height="12" width="71%"> 
        <input type="text" name="linkcolor" size="7" value="$linkcolor">
      </td>
    </tr>
    <tr bgcolor="$secondarycolor"> 
      <td height="12" width="29%" bgcolor="$primarycolor">Text Color</td>
      <td height="12" width="71%" bgcolor="$primarycolor"> 
        <input type="text" name="textcolor" size="7" value="$textcolor">
      </td>
    </tr>
    <tr bgcolor="$secondarycolor"> 
      <td height="12" width="29%">Background Color</td>
      <td height="12" width="71%"> 
        <input type="text" name="bgcolor" size="7" value="$bgcolor">
      </td>
    </tr>
    <tr bgcolor="$primarycolor"> 
      <td height="12" width="29%">Visited Link Color</td>
      <td height="12" width="71%"> 
        <input type="text" name="vlinkcolor" size="7" value="$vlinkcolor">
      </td>
    </tr>
    <tr bgcolor="$secondarycolor"> 
      <td height="12" width="29%" bgcolor="$secondarycolor">Email Quote Color</td>
      <td height="12" width="71%"> 
        <input type="text" name="quotecolor" size="7" value=\"$quotecolor\">
      </td>
    </tr>
<tr bgcolor="$primarycolor"> 
      <td height="12" width="29%" bgcolor="$primarycolor">Header Color</td>
      <td height="12" width="71%"> 
        <input type="text" name="headercolor" size="7" value=\"$headercolor\">
      </td>
    </tr>
  </table>
  <br>
  <table width="190" border="1">
    <tr bgcolor="$primarycolor"> 
      <td colspan="2" height="25">
        <div align="center"><font color="$headercolor"><b>
<font size="3" face="Verdana, Arial, Helvetica, sans-serif">Save 
          Preferences</font></b></font></div>
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
        }
