<?php
/****************************************************************************
This script was developed by Aero77.com .
Title: WhoIsPHP
Version: 1.2
Homepage: www.Aero77.com
Copyright (c) 2004 Aero77.com and its owners.
All rights reserved.

THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
"AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
REGENTS OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
(INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR
SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION)
HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT,
STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED
OF THE POSSIBILITY OF SUCH DAMAGE.

USAGE:
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

More Info About The Licence At http://www.gnu.org/copyleft/gpl.html
****************************************************************************/

include "whoisphp.php";
// $allowed should be a list of authorised callers seperated by commas, If you don't care leave it blank
// Be careful if you call this in a new browser window as the referer may be blank.
$allowed="";
?>

<?php
// The following line gets the url variables and is used by the demo.
if (!empty($HTTP_GET_VARS)) while(list($name, $value) = each($HTTP_GET_VARS)) $$name = $value;
?>
<html>
<head>
<title>whoisphp demo - Whois lookup</title>
</head>
<body bgcolor="#FFFFCC">

<form name="DomainForm" method="get" action="lookup.php">
    <font face="Arial"><span style="font-size:10pt;">Demo domain lookup (whois)<br>Works
    with all supported domain extensions<br></span></font><br><input type="text" value="<?php print($domain);?>" name="domain" maxlength="63">

<input type="submit" name="button1" value="Check">
</form>
<form name="form1">
<?php

if ($domain!="")
{
    $i=whoisphp($domain,$domext,$Reg);
    if ($i==4)
    {
      print("<font face=\"Arial\">Sorry but you are not allowed access to this page</font>");
    }
    if ($i==5)
    {
      print("<font face=\"Arial\">Could not contact registry for $domext domains</font>");
    }
    if (($i==0) || ($i==1) || ($i==6))
    {
      print("<font face=\"Arial\">Registration details for $domain$domext<BR><BR></font>");
      print("-----------------------------------------------------------------<BR>");
      for ($k=0;$k<count($Reg);$k++)
      {
        print ("$Reg[$k]<BR>");
      }
      print("-----------------------------------------------------------------<BR>");
    }
    if ($i==2)
    {
      print("<font face=\"Arial\">Domain extension $domext not recognised</font>");
    }
    if ($i==3)
    {
      print("<font face=\"Arial\">$domain$domext is not a valid domain name</font>");
    }
}

?>

<p>&nbsp;</p>
</body>
</html>