<?php

/************************************************************************/
/* PHP-NUKE: Web Portal System                                          */
/* ===========================                                          */
/*                                                                      */
/* Copyright (c) 2001 by Francisco Burzi (fbc@mandrakesoft.com)         */
/* http://phpnuke.org                                                   */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/

/* this is a module to show ADSL statistics as collected by PvE's logger */
/*                                                                       */
/* version 1.0      06 Jun 2002  Release version with status display     */
/*                  Courtesy of Jasper Boot, http://boot.xs4all.nl/      */
/*                                                                       */
/* version 0.3      01 Oct 2001, Improvements                            */
/*                  Show last 31 days in this month overview             */
/*                  Show last 12 months in year overview                 */
/*                                                                       */
/* version 0.2      24 Sep 2001, Improvements                            */
/*                  Better Konqueror compatibility                       */
/*                  Changes for use with php 4.0                         */
/*                                                                       */
/*                                                                       */
/* version 0.1      31 Aug 2001, Initial release                         */
/*                                                                       */
/*                                                                       */
/* Install this file under phpNuke in                                    */
/* /home/httpd/html/modules/ADSLLog/index.php                            */
/* Ensure "display_errors" in php.ini is "Off"                           */
/*                                                                       */
/* Copyright Peter van Es, 2002                                          */
/*                                                                       */


  // checking for ADSL-connection
  if (file_exists("/var/run/ppp0.pid")) {
#    $fpid_mxstream = fopen("/var/run/ppp0.pid", "r");
#    do {
#      $mx_line = fgets($fpid_mxstream,255);
#    } while ((strncmp($mx_line,"ppp",3) != 0) && (feof($fpid_mxstream) == 0));
#    fclose($fpid_mxstream);
    $mx_line = "ppp0";
    if (strncmp($mx_line,"ppp",3) == 0) {
      $dev_ppp = rtrim($mx_line);
      $fdate = filemtime("/var/run/".$dev_ppp.".pid");
      $ppp_uptime = time() - $fdate;
      $ppp_up = datestr($fdate); 
    }
    $fnetdevs = fopen("/proc/net/dev","r");
    $found = 0;
    while (feof($fnetdevs) == 0) {
      $dev_line = ltrim(fgets($fnetdevs,1024));
      if (strncmp($dev_line,"ppp",3) == 0) {
       $found = 1;
      }
    }
    fclose($fnetdevs);
    if ($found != 1) {
      $dev_ppp = "";
      $ppp_up = "";
    }
  }

  // checking for ethernet interface connected to the ADSL-modem (ip: 10.0.0.138)
  $froutetab = fopen("/proc/net/route","r");
  while (feof($froutetab) == 0) {
    $route_line = ltrim(fgets($froutetab,4096));
    $route_ent = explode("\t", $route_line);
    if ($route_ent[1] == "8A00000A") {
      $dev_adsl = $route_ent[0];
    } else {
      if ($route_ent[1] == "0000000A") {
        $dev_adsl = $route_ent[0];
      }
    }
  }
  fclose($froutetab);

  // checking for ethernet interface connected to (the) local network(s)
  $fnetdevs = fopen("/proc/net/dev","r");
  while (feof($fnetdevs) == 0) {
    $dev_line = ltrim(fgets($fnetdevs,4096));
    if ((strncmp($dev_line,"eth",3) == 0) && (strncmp($dev_line,$dev_adsl,4) != 0)) {
      if ($devs_local == "") {
        $devs_local = substr($dev_line,0,4);
      } else {
        $dev_local = substr($dev_line,0,4);
        $devs_local = "$devs_local $dev_local";
      }      
    }    
  }
  fclose($fnetdevs);
 
  // checking for SNAT
  $fipfwd = fopen("/proc/sys/net/ipv4/ip_forward","r");
  $ipfwd = fgetc($fipfwd);
  fclose($fipfwd);

  // getting ppp-dev stats
  $fnetdevs = fopen("/proc/net/dev","r");
  while (feof($fnetdevs) == 0) {
    $dev_line = ltrim(fgets($fnetdevs,1024));
    if (strncmp($dev_line,$dev_ppp,4) == 0) {
      $dev_line = str_replace(":"," ",$dev_line);
      while (str_replace("  "," ",$dev_line) != $dev_line) {
        $dev_line = str_replace("  "," ",$dev_line);
      } 
      $dev_ent = explode(" ",$dev_line);
      $ppp_rx_data = $dev_ent[1];
      $ppp_rx_packets = $dev_ent[2];
      $ppp_rx_errors = $dev_ent[3];
      $ppp_rx_drop = $dev_ent[4]; 
      $ppp_tx_data = $dev_ent[9];
      $ppp_tx_packets = $dev_ent[10];
      $ppp_tx_errors = $dev_ent[11];
      $ppp_tx_cols = $dev_ent[14]; 
    }
  }
  fclose($fnetdevs);
  
  // fix-up errors
  $devs_local = ltrim($devs_local);
  if ($ppp_simple == 1) {
    $ppp_extended = 0;
  }


// used routines
function datestr($unix_date) {
  return date("j M, H:i",$unix_date);
}

function getbytes($bytes) {
  $mile = 0;
  while ($bytes > 1024) {
    $bytes = $bytes / 1024;
    $mile++;
  }
  switch ($mile) {
    case 0: $xb = "bytes";
            break;
    case 1: $xb = "KB";
            break;
    case 2: $xb = "MB";
            break;
    case 3: $xb = "GB";
            break;
    case 4: $xb = "TB";
            break;
    case 5: $xb = "PB";    
            break;
  }
  $bytes = round((($bytes > 0) ? ($bytes - 0.05) : ($bytes)),2);
  return "$bytes $xb";
}

function struptime($unix_uptime) {
  $tmptime = $unix_uptime;
  while ($tmptime >= 86400) {
     $tmptime = $tmptime - 86400;
     $day++;
  }
  while ($tmptime >= 3600) {
     $tmptime = $tmptime - 3600;
     $hour++;
  }
  while ($tmptime >= 60) {
     $tmptime = $tmptime - 60;
     $minute++;
  }
  $seconds = $tmptime;
  $strreturn = (($day > 0) ? (($day > 1) ? "$day days " : "$day day ") : "");
  $strreturn = $strreturn . (($hour > 0) ? "$hour hours " : "");
  $strreturn = $strreturn . (($minute > 0) ? (($minute > 1) ? "$minute minutes " : "$minute minute ") : "");
  $strreturn = $strreturn . (($seconds > 1) ? "$seconds seconds" : "$seconds second"); 
  $tmptime = ($day * 24) + $hour;
  $strreturn = $strreturn . " ($tmptime hours)";
  return $strreturn;
}

function strshortuptime($unix_uptime) {
  $tmptime = $unix_uptime;
  while ($tmptime >= 86400) {
     $tmptime = $tmptime - 86400;
     $day++;
  }
  while ($tmptime >= 3600) {
     $tmptime = $tmptime - 3600;
     $hour++;
  }
  while ($tmptime >= 60) {
     $tmptime = $tmptime - 60;
     $minute++;
  }
  $seconds = $tmptime;
  if ($hour == "") $hour = 0;
  if ($minute == "") $minute = 0;
  if ($day >= 14) {
    $strreturn = "$day days";
  } elseif ($day > 1) {
    if ($minute < 10 ) {
      $minute = "0" . $minute;
    }
    $strreturn = "$day days, $hour:$minute";
  } elseif (($day > 0) || ($hour > 0)) {
    $hour = $hour + ($day * 24);
    $strreturn = "$hour hours";
    $strreturn = $strreturn . " " . (($minute > 0) ? (($minute > 1) ? "$minute minutes" : "$minute minute") : "");
  } else {
    $strreturn = (($minute > 0) ? (($minute > 1) ? "$minute minutes" : "$minute minute") : "");
    $strreturn = $strreturn . " " . (($seconds > 1) ? "$seconds seconds" : "$seconds second");
  }
  return $strreturn;
}

// displaying functions

function all_info_graph() {
  global $devs_local, $dev_adsl, $dev_ppp, $ppp_up, $ppp_uptime, $ipfwd;
  global $sure_local, $sure_adsl, $sure_ppp, $no_eth, $ppp_simple, $ppp_extended, $ppp_data, $nojs;
  global
    $ppp_tx_data,
    $ppp_tx_packets,
    $ppp_tx_errors,
    $ppp_tx_cols, 
    $ppp_rx_data,
    $ppp_rx_packets,
    $ppp_rx_errors,
    $ppp_rx_drop;
  global $fill_width;
echo '
<table width="345" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
';
print "<td width=\"160\" valign=\"middle\" align=\"center\"><div class=\"interfaces\"><center>";
if ($devs_local != "") {
  print "$devs_local";
} else {
  if ($sure_local != 1) {
    print "(not present)";
  } else {
    print "<font color=\"#BB0000\">(not working)</font>";
  }
}
print "</center></div></td>\n";
print "<td width=\"8\"></td>";
print "<td align=\"left\"><div class=\"interfaces\">";
if ($dev_adsl != "") {
  print "$dev_adsl";
} else {
  if ($sure_adsl != 1) {
    print "(not present)";
  } else {
    print "<font color=\"#BB0000\">(not working)</font>";
  }
}
print "</div></td>";
echo '
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td><img src="modules/ADSLLog/desc.jpg" width="345" height="40"></td>
  </tr>
  <tr>
    <td height="2"> 
      <table border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><img src="modules/ADSLLog/localnet.jpg"></td>
';
print "<td><img src=\"modules/ADSLLog/local_";
if (strlen($devs_local) > 0) {
   print "ok";
} else {
  if ($sure_local != 1) {
    print "na";
  } else {
    print "er";
  }
}
print ".jpg\"";
if (($no_graph != 1) && ($nojs != 1)) {
  print "onmouseover=\"popUp(0)\" onmouseout=\"popOut()\" onfocus=\"if(this.blur)this.blur()\"";
}
print "></td>\n";
print "<td><img src=\"modules/ADSLLog/gateway_";
if ($ipfwd == 1) {
   print "ok";
} else {
   print "er";
}
print ".jpg\"";
if (($no_graph != 1) && ($nojs != 1)) {
  print "onmouseover=\"popUp(1)\" onmouseout=\"popOut()\" onfocus=\"if(this.blur)this.blur()\"";
}
print "></td>\n";
echo '
          <td height="15"> 
            <table border="0" cellspacing="0" cellpadding="0" height="40">
              <tr>
';
echo '<td valign="middle" align="left"><img src="modules/ADSLLog/adsl_';
if (strlen($dev_adsl) > 0) {
   print "ok";
} else {
  if ($sure_adsl != 1) {
    print "na";
  } else {
    print "er";
  }
}
echo '.jpg"';
if (($no_graph != 1) && ($nojs != 1)) {
  print " onmouseover=\"popUp(2)\" onmouseout=\"popOut()\" onfocus=\"if(this.blur)this.blur()\"";
}
print "></td>\n";
echo '
                <td align="left"><img src="modules/ADSLLog/adslmodem.jpg"></td>
              </tr>
              <tr> 
                <td colspan="2">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td><img src="modules/ADSLLog/connection.jpg"></td>
';
echo '<td align="right">';
if (($no_graph != 1) && ($nojs != 1) && ($dev_ppp != "")) {
 echo '<a href="#" align="center" onmouseover="popmousemove()" onmousedown="popOut(); popup(0)" onmouseout="popout()">';
}
echo '<img border="0" src="modules/ADSLLog/ppp_';
if (strlen($dev_ppp) > 0) {
   print "ok";
} else {
  if ($sure_ppp != 1) {
    print "na";
  } else {
    print "er";
  }
}
echo '.jpg"';
if (($no_graph != 1) && ($nojs != 1)) {
  print "onmouseover=\"popUp(3)\" onmouseout=\"popOut()\" onfocus=\"if(this.blur)this.blur()\"";
}
print ">";
if (($no_graph != 1) && ($nojs != 1)) {
  print "</a>";
}
print "</td>\n";
echo '
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
          </td>
          <td><img src="modules/ADSLLog/internet.jpg"></td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="225"></td>
          <td width="32"><img src="modules/ADSLLog/ppp-arrow.jpg" width="32" height="19"></td>
';
print "<td><div class=\"interfaces\">";
if ($dev_ppp != "") {
  print "$dev_ppp";
} else {
  if ($sure_ppp != 1) {
    print "(not present)";
  } else {
    print "<font color=\"#BB0000\">(not working)</font>";
  }
}
print "</div></td>\n";
echo '
        </tr>
      </table>
    </td>
  </tr>
</table>
';
}

function all_info_text() {
  global $devs_local, $dev_adsl, $dev_ppp, $ppp_up, $ppp_uptime, $ipfwd;
  global $sure_local, $sure_adsl, $sure_ppp, $no_eth, $ppp_simple, $ppp_extended, $ppp_data;
  global
    $ppp_tx_data,
    $ppp_tx_packets,
    $ppp_tx_errors,
    $ppp_tx_cols, 
    $ppp_rx_data,
    $ppp_rx_packets,
    $ppp_rx_errors,
    $ppp_rx_drop;
  global $fill_width;

  print "<table cols=\"2\"";
  print ($fill_width == 1) ? " width=\"100%\"" : "";
  print">\n";
  print "<th colspan=\"2\" align=\"";
  print ($fill_width == 1) ? "center" : "left";
  print "\">Network details</th>\n";
  if ($ppp_simple != 1) {
    print "<tr><td><hr></td><td></td></tr>\n";
  }

  if ($no_eth != 1) {
    print "<tr>";
    if (strlen($devs_local) > 4) {
      print "<td><b>Network cards connected to local networks:</b></td><td>$devs_local</td>";
    } else {
      if (strlen($devs_local) > 0) {
        print "<td><b>Network card connected to local network:</b></td><td>$devs_local</td>";
      } else {
        if ($sure_local != 1) { 
          print "<td colspan=\"2\"><i>There is no (working) local network.</i></td>";
        } else {
          print "<td colspan=\"2\"><b><font color=\"#BB0000\">The connection with the local network does not work!</font></b></td>";
        }
      }  
    }
    print "</tr>\n";

    print "<tr>";
    if (strlen($dev_adsl) > 0) {
      print "<td><b>Network card connected to the ADSL-modem:</b></td>";
      print "<td>$dev_adsl</td>";
    } else {
      if ($sure_adsl != 1) {
        print "<td colspan=\"2\"><i>There is no (working) ADSL-modem.</i></td>";
      } else {
        print "<td colspan=\"2\"><b><font color=\"#BB0000\">The connection with the ADSL-modem does not work!</font></b></td>";
      }
    }
    print "</tr>\n";
  }

  print "<tr>";
  if (strlen($dev_ppp) > 0) {
    if ($ppp_simple != 1) {
     print "<tr><td><hr></td><td></td></tr>\n";
     print "<td><b>Connection to the Internet:</b></td><td>$dev_ppp</td></tr>\n";
    } else {
       print "<td colspan=\"2\"><b>There is a connection to the Internet</b></td></tr>\n";
    }
    print "<tr><td><B>Connection online since:</b></td><td>$ppp_up</td></tr>\n";
    if ($ppp_simple != 1) {
      print "<td><b>Connection uptime:</b></td><td>";
      print struptime($ppp_uptime);
      print "</td></tr>\n";
    }
    print "<tr>";
    if ($ipfwd == 1) {
      print "<td><b>Connection sharing:</b></td><td><font color=\"#00AA00\">enabled</font></td>";
    } else {
      print "<td><b>Connection sharing:</b></td><td><font color=\"#BB0000\">disabled</font></td>";
    }
  } else {
    if ($sure_ppp != 1) {
    print "<td colspan=\"2\"><i>There is no (working) connection with the Internet.</i></td>";
    } else {
      print "<td colspan=\"2\"><b><font color=\"#BB0000\">The connection with the Internet does not work!</font></b></td>";
    }
  }
  print "</tr>\n";

  if (strlen($dev_ppp) > 0) {
    if ($ppp_simple != 1) {
      print "<tr><td><hr></td><td></td></tr>\n";
    }
    if (($ppp_simple != 1) || ($ppp_data == 1)) {
      print "<tr><td><b>Sent:</b></td><td>";
      print getbytes($ppp_tx_data);
      print "</td></tr>\n";
    }
    if ($ppp_simple != 1) {
      print "<tr><td><b>Packets:</b></td><td>";
      print ($ppp_tx_packets);
      print "</td></tr>\n";
    }
    if ($ppp_extended == 1) {
      print "<tr><td><b>Errors:</b></td><td>";
      print ($ppp_tx_errors);
      print "</td></tr>\n";
      print "<tr><td><b>Collisions:</b></td><td>";
      print ($ppp_tx_cols);
      print "</td></tr>\n";
    }
    if ($ppp_simple != 1) {
      print "<tr><td><hr></td><td></td></tr>\n";
    }
    if (($ppp_simple != 1) || ($ppp_data == 1)) {
      print "<tr><td><b>Received:</b></td><td>";
      print getbytes($ppp_rx_data);
      print "</td></tr>\n";
    }
    if ($ppp_simple != 1) {
      print "<tr><td><b>Packets:</b></td><td>";
      print ($ppp_rx_packets);
      print "</td></tr>\n";
    }
    if ($ppp_extended == 1) {
      print "<tr><td><b>Errors:</b></td><td>";
      print ($ppp_rx_errors);
      print "</td></tr>\n";
      print "<tr><td><b>Dropped:</b></td><td>";
      print ($ppp_rx_drop);
      print "</td></tr>\n";
    }
  }

  print "</table>\n";
}
?>
<link rel="stylesheet" href="/themes/Bali/style/style.css" type="text/css">
<style type="text/css">
.interfaces	{ font-family: Verdana, Arial, Helvetica, sans-serif;
                  font-weight: bold;
                  font-size:   10px; 
                  text-align: left }
.copy		{ font-family: Verdana, Arial, Helvetica, sans-serif;
                  font-weight: normal;
		  color: #888888; 
                  font-size:   10px; }
h2              { font-family: Verdana, Arial, Helvetica, sans-serif;
		  font-size:   14px; }
A:link          { text-decoration: none; 
                  color: #000000; }
A:visited       { text-decoration: none; 
                  color: #000000; }
A:hover         { text-decoration: underline; 
                  color: #000000; }
<?php
  if (($no_graph != 1) && ($nojs != 1)) {
?>
<!-- BEGIN JavaScript-only style -->
.clDescriptionCont { position: absolute;  
                     width:250px; 
                     visibility:hidden; 
                     layer-background-color:#cccccc; 
                     z-index:200; }
.clDescription     { width:250px; 
                     left:0px; 
                     top:0px; 
                     font-family: verdana,arial,helvetica,sans-serif; 
                     overflow: hidden; 
                     border: 1px solid #999999; 
                     padding: 3px; 
                     font-size:11px; 
                     background-color: #cccccc; 
                     layer-background-color: #cccccc; }
.clLinks           { position: absolute; 
                     left:100px; top:200px; z-index:1; }
.clCaption         { position: absolute; 
                     left:0px; top:0px; width:250px; height:15px; 
                     clip:rect(0px 250px 15px 0px); 
                     font-size:11px; 
                     font-family:verdana,arial,helvetica,sans-serif; 
                     background-color:#999999; 
                     layer-background-color:#999999; } 
#divTooltip	   { position: absolute; 
                     top:0px; width:280px; 
                     visibility:hidden; 
                     z-index:200; 
                     background-color:#f3f3f3; 
                     layer-background-color:#f3f3f3; }
.normalStyle       { padding: 2px; 
                     text-align: center; 
                     font-weight: 500; 
                     width:175px; 
                     color:#000000; 
                     top:100px; 
                     font-family: verdana,arial,helvetica; 
                     font-size:11px; 
                     background-color:#f3f3f3;
                     layer-background-color:#f3f3f3; 
                     border-width: 1px; 
                     border-style:solid; 
                     border-color:#000000; 
                     cursor:default; }
.netscape4Style    { padding: 0px; 
                     font-weight:500; 
                     width:175px; 
                     color:#000000; 
                     top:100px; 
                     font-family: verdana,arial,helvetica; 
                     font-size:11px; 
                     background-color:#f3f3f3; 
                     layer-background-color:#f3f3f3; 
                     border:1px solid #000000; }  
<!-- END JavaScript-only style -->
<?php
}
?>
</style>
<?php
  if (($no_graph != 1) && ($nojs != 1)) {
?>

<!-- BEGIN JavaScript-only part -->
<script language="JavaScript" type="text/javascript">
/**********************************************************************************   
PopupDescriptions 
*   Copyright (C) 2001 <a href="/dhtmlcentral/thomas_brattli.asp">Thomas Brattli</a>
Dynamic Tooltips 
*   Copyright (C) 2001 <a href="/dhtmlcentral/michael_van_ouwerkerk.asp">Michael van Ouwerkerk</a>
*   This script was released at DHTMLCentral.com
*   Visit for more great scripts!
*   This may be used and changed freely as long as this msg is intact!
*   We will also appreciate any links you could give us.
*
*   Made by <a href="/dhtmlcentral/thomas_brattli.asp">Thomas Brattli</a> 
*********************************************************************************/

// shared lib for browser checking
function lib_bwcheck(){ //Browsercheck (needed)
	this.ver=navigator.appVersion
	this.agent=navigator.userAgent
	this.dom=document.getElementById?1:0
	this.opera5=this.agent.indexOf("Opera 5")>-1
	this.ie5=(this.ver.indexOf("MSIE 5")>-1 && this.dom && !this.opera5)?1:0; 
	this.ie6=(this.ver.indexOf("MSIE 6")>-1 && this.dom && !this.opera5)?1:0;
	this.ie4=(document.all && !this.dom && !this.opera5)?1:0;
	this.ie=this.ie4||this.ie5||this.ie6
	this.mac=this.agent.indexOf("Mac")>-1
	this.ns6=(this.dom && parseInt(this.ver) >= 5) ?1:0; 
	this.ns4=(document.layers && !this.dom)?1:0;
	this.bw=(this.ie6 || this.ie5 || this.ie4 || this.ns4 || this.ns6 || this.opera5)
	return this
}
var bw=new lib_bwcheck()

/***************************************************************************************
Variables to set:
***************************************************************************************/
pmessages = new Array()
messages = new Array()
<?php
  }
  if (($no_graph != 1) && ($nojs != 1)) {
    print "messages[0]='";
    if (strlen($devs_local) > 4) {
      print "<b>Connections to Local Area Networks:</b> $devs_local";
    } else {
      if (strlen($devs_local) > 0) {
        print "<b>Connection to the Local Area Network:</b> $devs_local";
      } else {
        if ($sure_local != 1) { 
          print "<i>There is no (working) Local Area Network</i>";
        } else {
          print "<b><font color=\"#BB0000\">The connection to the Local Area Network does not work!</font></b>";
        }
      }  
    }
	print "'\n";
    print "messages[1]='<b>Internet connection sharing:</b> ";
    if ($ipfwd == 1) {
      print "<font color=\"#00AA00\">enabled</font>";
    } else {
      print "<font color=\"#BB0000\">disabled</font>";
    }
    print "<br><font color=\"#888888\">Windows: Internet Connection Sharing<br>Linux: Network Address Translation</font>'\n";

    print "messages[2]='";
    if (strlen($dev_adsl) > 0) {
      print "<b>Connection to the ADSL-modem:</b> $dev_adsl";
    } else {
      if ($sure_adsl != 1) { 
        print "<i>There is no (working) ADSL-modem</i>";
      } else {
        print "<b><font color=\"#BB0000\">The connection with the ADSL-modem does not work!</font></b>";
      }
    }
    print "'\n";

    print "messages[3]='";
    if (strlen($dev_ppp) > 0) {
      if ($ppp_simple != 1) {
        print "<b>Connection to the Internet:</b> ppp0<br><font color=\"#888888\">Windows: VPN<br> Linux: PPTP</font>";
      } else {
        print "<b>There is a connection to the Internet</b>";
      }
      print "<BR><i>Click for more information</i>";
    } else {
      if ($sure_ppp != 1) {
        print "<i>There is no (working) connection to the Internet</i></td>";
      } else {
        print "<b><font color=\"#BB0000\">The connection to the Internet does not work!</font></b>";
      }
    } 
    print "'\n";
    print "pmessages[0]='<div class=\"clCaption\"><b>&nbsp;Internetconnection</b></div><br>";
    print "<b>Info</b><br>";
    print "Online since: $ppp_up<br>";
    print "Uptime: ".strshortuptime($ppp_uptime)."<br>";
    if (($ppp_simple != 1) || ($ppp_data == 1)) {
      print "<b>Sent</b><br>";
      print "Bytes: $ppp_tx_data (".getbytes($ppp_tx_data).")<br>";
    }
    if ($ppp_simple != 1) {
      print "Packets: $ppp_tx_packets<br>";
      if ($ppp_extended == 1) {
        print "Errors: $ppp_tx_errors<br>";
        print "Collisions: $ppp_tx_cols<br>";
      }
    }
    if (($ppp_simple != 1) || ($ppp_data == 1)) {
      print "<b>Received</b><br>";
      print "Bytes: $ppp_rx_data (".getbytes($ppp_rx_data).")<br>";
    }
    if ($ppp_simple != 1) {
      print "Packets: $ppp_rx_packets<br>";
      if ($ppp_extended == 1) {
        print "Errors: $ppp_rx_errors<br>";
        print "Dropped: $ppp_rx_drop<br>";
      }
    }
    print "'\n";
  }

  if (($no_graph != 1) && ($nojs != 1)) {
?>

fromX = 20 //How much from the actual mouse X should the description box appear?
fromY = -2 //How much from the actual mouse Y should the description box appear?
ns4center= 1        // Centering the text in ns4 doesn't work with css, use this variable instead... the value is 1 or 0
useFading= 0        // 1 for a fading effect in windows explorer 5+ and all platforms ns6, 0 for no fading effect.
animation= 0        // 1 if you want animation, 0 for no animation.
detectiontype=1    // 1 for 'smooth' window size detection, 0 for 'flip' window size detection.
delay= 300          // The time before showing the popup, in milliseconds.

//To set the font size, font type, border color or remove the border or whatever,
//change the clDescription class in the stylesheet.

/*******************
// PopUpDescriptions
*******************/

//Makes crossbrowser object.
function makeObj(obj){								
   	this.evnt=bw.dom? document.getElementById(obj):bw.ie4?document.all[obj]:bw.ns4?document.layers[obj]:0;
	if(!this.evnt) return false
	this.css=bw.dom||bw.ie4?this.evnt.style:bw.ns4?this.evnt:0;	
   	this.wref=bw.dom||bw.ie4?this.evnt:bw.ns4?this.css.document:0;		
	this.writeIt=b_writeIt;																
	return this
}

// A unit of measure that will be added when setting the position of a layer.
var px = bw.ns4||window.opera?"":"px";

function b_writeIt(text){
	if (bw.ns4){this.wref.write(text);this.wref.close()}
	else this.wref.innerHTML = text
}

//Capturing mousemove
var descx = 1
var descy = 1
function popmousemove(e){descx=bw.ns4||bw.ns6?e.pageX:event.x; descy=bw.ns4||bw.ns6?e.pageY:event.y}

var oDesc;
//Shows the messages
function popup(num){
    if(oDesc){
		oDesc.writeIt('<div class="clDescription">'+pmessages[num]+'</div>')
		if(bw.ie5||bw.ie6) descy = descy+document.body.scrollTop
		oDesc.css.left = (descx+fromX)+px
		oDesc.css.top = (descy+fromY
<?php
  }
  if (($no_graph != 1) && ($nojs != 1)) {
    if ($tiny == 1) {
      print "-70";
    }
  }
  if (($no_graph != 1) && ($nojs != 1)) {
?>)+px
		oDesc.css.visibility = "visible"
    }
}
//Hides it
function popout(){
	if(oDesc) oDesc.css.visibility = "hidden"
}
function setPopup(){
   	if(bw.ns4)document.captureEvents(Event.MOUSEMOVE)
    document.onmousemove = popmousemove;
	oDesc = new makeObj('divDescription')
}

/*****************
//Dynamic Tooltips
*****************/ 

// A unit of measure that will be added when setting the position of a layer.
var px = bw.ns4||window.opera?"":"px";

if(document.layers){ //NS4 resize fix.
    scrX= innerWidth; scrY= innerHeight;
    onresize= function(){if(scrX!= innerWidth || scrY!= innerHeight){history.go(0)} };
}

// object constructor...
function makeTooltip(obj){								
   	this.elm= document.getElementById? document.getElementById(obj):bw.ie4?document.all[obj]:bw.ns4?document.layers[obj]:0;
   	this.css= bw.ns4?this.elm:this.elm.style;
   	this.wref= bw.ns4?this.elm.document:this.elm;
	this.obj= obj+'makeTooltip'; eval(this.obj+'=this');
	this.w= bw.ns4? this.elm.clip.width: this.elm.offsetWidth;
	this.h= bw.ns4? this.elm.clip.height: this.elm.offsetHeight;
};
makeTooltip.prototype.measureIt= function(){
	this.w= bw.ns4? this.elm.clip.width: this.elm.offsetWidth;
	this.h= bw.ns4? this.elm.clip.height: this.elm.offsetHeight;
};
makeTooltip.prototype.writeIt= function(text){
	if (bw.ns4) {this.wref.write(text); this.wref.close()}
	else this.wref.innerHTML= text;
};

// Mousemove detection

var mouseX=0,mouseY=0,setX=0,setY=0;
function getMousemove(e){
	mouseX= (bw.ns4||bw.ns6)? e.pageX: bw.ie&&bw.win&&!bw.ie4? (event.clientX-2)+document.body.scrollLeft : event.clientX+document.body.scrollLeft;
	mouseY= (bw.ns4||bw.ns6)? e.pageY: bw.ie&&bw.win&&!bw.ie4? (event.clientY-2)+document.body.scrollTop : event.clientY+document.body.scrollTop;
	if (isLoaded && hovering && animation) placeIt();
};
function placeIt(){
	if (detectiontype==1) setX= mouseX+fromX+tooltip.w > screenWscrolled ? screenWscrolled-tooltip.w: mouseX+fromX;
	if (detectiontype==1) setY= mouseY+fromY+tooltip.h > screenHscrolled ? screenHscrolled-tooltip.h: mouseY+fromY;
	if (detectiontype==0) setX= mouseX+fromX+tooltip.w > screenWscrolled ? mouseX-fromX-tooltip.w: mouseX+fromX;
	if (detectiontype==0) setY= mouseY+fromY+tooltip.h > screenHscrolled ? mouseY-fromY-tooltip.h: mouseY+fromY;
	if (setX<0) setX= 0;
	if (setY<0) setY= 0;
	tooltip.css.left= setX+px;
	tooltip.css.top= setY+px;
};

// Main popUp function.
var hovering=false, screenWscrolled=0, screenHscrolled=0;
makeTooltip.prototype.showTimer= null;
function popUp(num){
	if(isLoaded){
		clearTimeout(tooltip.popTimer);
		dopopOut();
		if (bw.ns4){
			var text= '<span class="netscape4Style">' + (ns4center?'<center>':"") + messages[num] + (ns4center?'</center>':"") + '</span>';
			tooltip.writeIt(text);
		}
		if (!bw.ns4) tooltip.writeIt(messages[num]);
		screenWscrolled= screenW + (bw.ie?document.body.scrollLeft:pageXOffset);
		screenHscrolled= screenH + (bw.ie?document.body.scrollTop:pageYOffset);
		hovering= true;
		
		/* I'm using a timeout for ie4 here, because it doesn't store the measurements quickly enough. Does anybody know why this happens? */
		if (bw.ie4) setTimeout('tooltip.measureIt(); placeIt();', delay/2);
		else { tooltip.measureIt(); placeIt(); }
		if (useFading) tooltip.showTimer= setTimeout('tooltip.blendIn()', delay);
		if (!useFading) tooltip.showTimer= setTimeout('tooltip.css.visibility="visible"', delay);
    }
};

// Hiding routines
makeTooltip.prototype.popTimer= null;
function popOut(){
	if (isLoaded) tooltip.popTimer= setTimeout('dopopOut()', 30)
};
function dopopOut(){
	hovering= false;
	clearTimeout(tooltip.showTimer);
	tooltip.css.visibility= 'hidden';
	clearTimeout(tooltip.fadeTimer);
	tooltip.i= 0;
};

// Measure screensize.
var scrollbarWidth= bw.ns6&&bw.win?14:bw.ns6&&!bw.win?16:bw.ns4?16:0;
function measureScreen() {
	tooltip.css.top= 0+px;
	tooltip.css.left= 0+px;
	screenW= (bw.ie?document.body.clientWidth:innerWidth) - scrollbarWidth;
	screenH= (bw.ie?document.body.clientHeight:innerHeight);
};

// Opacity methods.
makeTooltip.prototype.blendIn= function(){
	if (bw.ie && bw.win && !bw.ie4) {
		this.css.filter= 'blendTrans(duration=0.5)';
		this.elm.filters.blendTrans.apply();
		this.css.visibility= 'visible';
		this.elm.filters.blendTrans.play();
	}
	else {
		this.css.visibility= 'visible';
		if (!bw.ns4) this.fadeIt();
	}
};
makeTooltip.prototype.step= 8;
makeTooltip.prototype.i= 0;
makeTooltip.prototype.fadeTimer= null;
makeTooltip.prototype.fadeIt= function(){
	this.i+= this.step;
	//this.css.filter= 'alpha(opacity='+this.i+')';
	this.css.MozOpacity= this.i/100;
	if (this.i<100) this.fadeTimer= setTimeout(this.obj+'.fadeIt()', 40);
	else this.i= 0;
};

// Init function...
var isLoaded= false;
function popupInit(){
	//Fixing the browsercheck for opera... this can be removed if the browsercheck has been updated!!
	bw.opera5 = (navigator.userAgent.indexOf("Opera")>-1 && document.getElementById)?true:false
	if (bw.opera5) bw.ns6 = 0
	
	//Extending the browsercheck to add windows platform detection.
	bw.win= (navigator.userAgent.indexOf('Windows')>-1)

	tooltip= new makeTooltip('divTooltip');
	tooltip.elm.onmouseover= function(){ clearTimeout(tooltip.popTimer); if(bw.ns4){setTimeout('clearTimeout(tooltip.popTimer)',20)}; };
	tooltip.elm.onmouseout= dopopOut;
	if (bw.ns4) document.captureEvents(Event.MOUSEMOVE);
	document.onmousemove= getMousemove;
	measureScreen();
	if (!bw.ns4) onresize= measureScreen;
	if (!bw.ns4) tooltip.elm.className= 'normalStyle';
	if (bw.ie && bw.win && !bw.ie4) tooltip.css.filter= 'alpha(opacity=100)'; //Preloads the windows filters.
	isLoaded= true;
};

// Initiates page on pageload if the browser is ok.
if(bw.bw && !isLoaded) onload= popupInit;
</script>
<!-- END JavaScript-only part -->
<?php
}
?>
</head>

<body>
<?php

include("header.php");



  // create graph
  if ($no_graph != 1) {
   all_info_graph();
  }
  // write text-info
  if ($no_text != 1) {
    all_info_text();
  }
  // write some JS-shit for graphical part
  if (($no_graph != 1) && ($nojs != 1)) {
    print "<div id=\"divTooltip\"></div>\n<div id=\"divDescription\" class=\"clDescriptionCont\"></div>\n<script type=\"text/javascript\">setPopup()</script>";
  }

if (($tiny != 1) && (($ppp_simple != 1) && ($no_eth != 1))) {  
  if ($pp_simple != 1) {
   print "<HR align=\"left\" width=\"135\">";
  }
}

echo "<small>Original software from <a href=\"http://boot.xs4all.nl/\" TARGET=_blank>Jasper Boot</a>, Thundersoft ICT used with his permission.</small>";

/* Print the menu choices at the bottom of each page */
echo "<br><br>\n";
OpenTable2();
echo "<table cellspacing=\"4\" cellpadding=\"2\" border=\"0\" align=\"center\"><tr>\n";
echo "<td>";
echo "<a href=\"modules.php?op=modload&amp;name=ADSLLog&amp;file=data&amp;func=today\">Today's statistics</a>";
echo "</td>";
echo "<td>";
echo "<a href=\"modules.php?op=modload&amp;name=ADSLLog&amp;file=data&amp;func=month\">This month's statistics</a>";
echo "</td>";
echo "<td>";
echo "<a href=\"modules.php?op=modload&amp;name=ADSLLog&amp;file=data&amp;func=year\">This year's statistics</a>";
echo "</td>";
echo "<td>";
echo "<a href=\"modules.php?op=modload&amp;name=ADSLLog&amp;file=data&amp;func=average\">Average daily profile</a>";
echo "</td>";
echo "</tr></table><br><br>\n";
CloseTable2();

include ("footer.php");

?>
