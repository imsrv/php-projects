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
// As we only want to support some domains we will clear the full array supported by whoisphp
// and define the ones we want below. See whoisphp.php for full list

foreach($dtd as $val)
    unset($dtd);

$dtd[]=".com,whois.crsnic.net,no match";
$dtd[]=".net,whois.crsnic.net,no match";
$dtd[]=".org,whois.publicinterestregistry.net,not found";
$dtd[]=".info,whois.afilias.net,not found";
$dtd[]=".cc,whois.nic.cc,no match";
$dtd[]=".co.uk,whois.nic.uk,no match";
$dtd[]=".de,whois.denic.de,no entries";
$dtd[]=".ro,whois.rotld.ro,no entries";
$dtd[]=".com.my,*mywhois,does not exist";

// The following line gets the url variables and is used by the demo.
if (!empty($HTTP_GET_VARS)) while(list($name, $value) = each($HTTP_GET_VARS)) $$name = $value;
?>
<html>
<head>
<title>Whois demo - Domain Availability</title>
<meta name="generator" content="PHP">
</head>
<body bgcolor="#FFFFCC">

<script language="JavaScript">
<!-- JavaScript
function whois(domain)
{
  window.open("whois.php?domain="+domain,"whois","width=500,height=300,resizable=yes,scrollbars=yes");
}
// - JavaScript - -->
</script>

<br>
<font face="Arial">WhoIsPHP Demo showing how several domains can be checked at
once</font>&nbsp;
<br>&nbsp;
<?php
  // Create table with one checkbox per domain extension
  $columns=3;
  print("<form name=\"form1\"  method=\"get\" action=\"checkdomain3.php\">\n");
  print("<font face=\"Arial\">");
  print("<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"424\">\n");
  print("<tr>\n");
  print("<td width=\"424\" colspan=\"$columns\">\n");
  print("<p><input type=\"text\" name=\"domain\" value=\"$domain\"size=\"30\">&nbsp;&nbsp;<input type=\"submit\" name=\"Check\" value=\"Check\"></p>\n");
  print("<p><input type=\"hidden\" name=\"action\" value=\"check\"></p>\n");
  print("</td>\n");
  print("</tr>\n");
  print("<tr>\n");
  for ($c=1;$c<=$columns;$c++)
  {
    print("<td width=\"33%\">\n");
    print("&nbsp;\n");
    print("</td>\n");
  }
  print("</tr>\n");
  $nde=count($dtd);
  $de=1;
  while($de<=$nde)
  {
    print("<tr>\n");
    for ($c=1;$c<=$columns;$c++)
    {
      print("<td width=\"33%\">\n");
      if ($de<=$nde)
      {
        $dt=strtok($dtd[$de-1],",");
        print("<p><input type=\"checkbox\" name=\"cb$de\"");
	if ($action=="check")
	{
          $var="cb".$de;
          if (strcasecmp($$var,"on")==0)
	  print(" checked ");
	}
	print(">$dt</p>\n");
        $de++;
      }
      print("</td>\n");
    }
    print("<tr>\n");
    for ($c=1;$c<=$columns;$c++)
    {
      print("<td width=\"33%\">\n");
      print("&nbsp;\n");
      print("</td>\n");
    }
    print("</tr>\n");
    print("</tr>\n");
  }
  print("</table>");
  print("</form>\n");
  // If check clicked then create table of results
  if ($action=="check")
  {
    print("<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n");
    for ($k=1;$k<=$nde;$k++)
    {
      $var="cb".$k;
      if (strcasecmp($$var,"on")==0)
      {
        print("<tr>\n");
        $dt=strtok($dtd[$k-1],",");
				$Reg="*"; // Putting a * in $Reg flags to whoisphp not too bother getting full whois data just availablity.
    	  					// With some registry databases this can speed up the request. (optional)
        $i=whoisphp($domain,$dt,$Reg);
        print("<td width=\"33%\">\n");
        print("$domain$dt");
	print("</td>\n");
        print("<td width=\"33%\">\n");
	if ($i==0)
	  print("Available");
	if ($i==6)
	  print("Available Premium");
	if ($i==1)
	  print("Already registered");
	if ($i==2)
	  print("Domain type not supported");
	if ($i==3)
	  print("Invalid domain name");
	if ($i==5)
	  print("can't contact whois server");
	print("</td>\n");
        print("<td width=\"33%\">\n");
	if ($i==1)
	{
	  print("<a href=\"javascript: void whois('$domain$dt')\">Lookup details</a>");
	}
	print("</td>\n");
        print("</tr>\n");
      }
    }
    print("</table>");
    print("</font>");
  }

?>
<p>&nbsp;</p>
</body>
</html>