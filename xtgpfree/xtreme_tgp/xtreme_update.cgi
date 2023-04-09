#!/usr/bin/perl

######################################################################
#                        X-treme TGP v1.0
#                        Created by Relic
#                     webmaster@cyphonic.net
#####################################################################



#SCROLL DOWN AND EDIT THE SPECIFIED HTML!
###########################################################
$cnt = 0;
@months=('Jan.','Feb.','March','Apr.','May','June','July','Aug.','Sept.','Oct.','Nov.','Dec');
$time = time;
$reset_offset = $reset_offset * 3600;
$time = $time + $reset_offset;
($sec,$min,$hour,$mday,$mon,$year,$wday,$yday,$isdst) = localtime($time);
$mon++;
$year += 1900;
$now = "$mon.$mday.$year";
$sunday = $yday - $wday;

sub main {
$data_file="list.txt";
open(DAT, $data_file) || die("Could not open file!");
@raw_data=<DAT>;
close(DAT); 
$base ="xtreme_out.cgi?";   
foreach $main (@raw_data)
{
 chop($main);
 ($name,$email,$count,$url,$ip,$type)=split(/\|/,$main);
 $aname[$cnts]=$name;
 $aemail[$cnts]=$email;
 $account[$cnts]=$count;
 $aurl[$cnts]=$url;
 $atype[$cnts]=$type;
 $cnts = $cnts +1;
}

$data2="weekly.txt";
open(DAT, $data2) || die("Could not open file!");
@raw_data=<DAT>;
close(DAT);   
foreach $main (@raw_data)
{
 chop($main);
 ($img1,$down1,$img2,$down2,$mdate)=split(/\|/,$main);
}



print <<MAINHTML;

###############################################################################################################################################################################################################################EDIT THIS HTML
##############################################################################################################################################################################################################################

<html>
<head>
<title>Xtreme TGP Demo Page</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body bgcolor="#FFFFFF" text="#000000" link="#000000" vlink="#000000" alink="red">
<div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="6"><u>XTREME 
  TGP v1.0</u></font><br>
  <br>
  <table width="51%" cellspacing="1" cellpadding="2" bgcolor="#000000">
    <tr bgcolor="#F4F4F4"> 
      <td colspan="2"> 
        <div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="2"><font color="#000000">.: 
          NEW GALLERIES FOR $now :.</font></font></div>
      </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td height="278" width="50%"> 
        <p><font face="Verdana, Arial, Helvetica, sans-serif" size="2">+ <a href="http://www.elitelist.net/cgi-bin/transformer/t_out.cgi?30*$aurl%5B0%5D*" target="_blank">$account[0] 
          $atype[0] Movies</a><br>
          + <a href="http://www.elitelist.net/cgi-bin/transformer/t_out.cgi?30*$aurl[1]*" target="_blank">$account[1] 
          $atype[1] Movies</a><br>
          + <a href="cgi-bin/s2/out.cgi?reg" target="_blank">7 Teen Movies</a><br>
          + <a href="http://www.elitelist.net/cgi-bin/transformer/t_out.cgi?30*$aurl[2]*" target="_blank">$account[2] 
          $atype[2] Movies</a><br>
          + <a href="http://www.elitelist.net/cgi-bin/transformer/t_out.cgi?30*$aurl[3]*" target="_blank">$account[3] 
          $atype[3] Movies</a><br>
          + <a href="cgi-bin/s2/out.cgi?reg" target="_blank">5 Hardcore Movies</a><br>
          + <a href="http://www.elitelist.net/cgi-bin/transformer/t_out.cgi?30*$aurl[4]*" target="_blank">$account[4] 
          $atype[4] Movies</a><br>
          + <a href="http://www.elitelist.net/cgi-bin/transformer/t_out.cgi?30*$aurl[5]*" target="_blank">$account[5] 
          $atype[5] Movies</a><br>
          + <a href="cgi-bin/s2/out.cgi?reg" target="_blank">2 Hardcore Movies</a><br>
          + <a href="http://www.elitelist.net/cgi-bin/transformer/t_out.cgi?30*$aurl[6]*" target="_blank">$account[6] 
          $atype[6] Movies</a><br>
          + <a href="http://www.elitelist.net/cgi-bin/transformer/t_out.cgi?30*$aurl[7]*" target="_blank">$account[7] 
          $atype[7] Movies<br>
          </a>+ <a href="cgi-bin/s2/out.cgi?reg" target="_blank">13 Blow Job Movies</a><br>
          + <a href="http://www.elitelist.net/cgi-bin/transformer/t_out.cgi?30*$aurl[8]*" target="_blank">$account[8] 
          $atype[8] Movies</a><br>
          + <a href="http://www.elitelist.net/cgi-bin/transformer/t_out.cgi?30*$aurl[9]*" target="_blank">$account[9] 
          $atype[9] Movies</a><br>
          + <a href="cgi-bin/s2/out.cgi?reg" target="_blank">22 Teen Movies</a><br>
          + <a href="http://www.elitelist.net/cgi-bin/transformer/t_out.cgi?30*$aurl[10]*" target="_blank">$account[10] 
          $atype[10] Movies</a><br>
          + <a href="http://www.elitelist.net/cgi-bin/transformer/t_out.cgi?30*$aurl[11]*" target="_blank">$account[11] 
          $atype[11] Movies</a><br>
          + <a href="cgi-bin/s2/out.cgi?reg" target="_blank">1 Mature Movies</a><br>
          + <a href="http://www.elitelist.net/cgi-bin/transformer/t_out.cgi?30*$aurl[12]*" target="_blank">$account[12] 
          $atype[12] Movies</a><br>
          + <a href="http://www.elitelist.net/cgi-bin/transformer/t_out.cgi?30*$aurl%5B13%5D*" target="_blank">$account[13] 
          $atype[13] Movies</a><br>
          + <a href="cgi-bin/s2/out.cgi?reg" target="_blank">17 Gangbang Movies</a><br>
          + <a href="http://www.elitelist.net/cgi-bin/transformer/t_out.cgi?30*$aurl[14]*" target="_blank">$account[14] 
          $atype[14] Movies</a><br>
          + <a href="http://www.elitelist.net/cgi-bin/transformer/t_out.cgi?30*$aurl[15]*" target="_blank">$account[15] 
          $atype[15] Movies</a><br>
          + <a href="cgi-bin/s2/out.cgi?reg" target="_blank">3 Teen Movies</a></font></p>
      </td>
      <td height="278" width="50%"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">+ 
        <a href="http://www.elitelist.net/cgi-bin/transformer/t_out.cgi?30*$aurl[16]*" target="_blank">$account[16] 
        $atype[16] Movies</a><br>
        + <a href="http://www.elitelist.net/cgi-bin/transformer/t_out.cgi?30*$aurl[17]*" target="_blank">$account[17] 
        $atype[17] Movies</a><br>
        + <a href="cgi-bin/s2/out.cgi?reg" target="_blank">18 Lesbians Movies</a><br>
        + <a href="http://www.elitelist.net/cgi-bin/transformer/t_out.cgi?30*$aurl[18]*" target="_blank">$account[18] 
        $atype[18] Movies</a><br>
        + <a href="http://www.elitelist.net/cgi-bin/transformer/t_out.cgi?30*$aurl[19]*" target="_blank">$account[19] 
        $atype[19] Movies</a><br>
        + <a href="cgi-bin/s2/out.cgi?reg" target="_blank">5 Masturbation Movies</a><br>
        + <a href="http://www.elitelist.net/cgi-bin/transformer/t_out.cgi?30*$aurl[20]*" target="_blank">$account[20] 
        $atype[20] Movies</a><br>
        + <a href="http://www.elitelist.net/cgi-bin/transformer/t_out.cgi?30*$aurl[21]*" target="_blank">$account[21] 
        $atype[21] Movies</a><br>
        + <a href="cgi-bin/s2/out.cgi?reg" target="_blank">11 Softcore Movies</a><br>
        + <a href="http://www.elitelist.net/cgi-bin/transformer/t_out.cgi?30*$aurl[22]*" target="_blank">$account[22] 
        $atype[22] Movies</a><br>
        + <a href="http://www.elitelist.net/cgi-bin/transformer/t_out.cgi?30*$aurl[23]*" target="_blank">$account[23] 
        $atype[23] Movies<br>
        </a>+ <a href="cgi-bin/s2/out.cgi?reg" target="_blank">4 Asian Movies</a><br>
        + <a href="http://www.elitelist.net/cgi-bin/transformer/t_out.cgi?30*$aurl[24]*" target="_blank">$account[24] 
        $atype[24] Movies</a><br>
        + <a href="http://www.elitelist.net/cgi-bin/transformer/t_out.cgi?30*$aurl[25]*" target="_blank">$account[25] 
        $atype[25] Movies</a><br>
        + <a href="cgi-bin/s2/out.cgi?reg" target="_blank">5 Teen Movies</a><br>
        + <a href="http://www.elitelist.net/cgi-bin/transformer/t_out.cgi?30*$aurl[26]*" target="_blank">$account[26] 
        $atype[26] Movies</a><br>
        + <a href="http://www.elitelist.net/cgi-bin/transformer/t_out.cgi?30*$aurl[27]*" target="_blank">$account[27] 
        $atype[27] Movies</a><br>
        + <a href="cgi-bin/s2/out.cgi?reg" target="_blank">14 Blow JobMovies</a><br>
        + <a href="http://www.elitelist.net/cgi-bin/transformer/t_out.cgi?30*$aurl[28]*" target="_blank">$account[28] 
        $atype[28] Movies</a><br>
        + <a href="http://www.elitelist.net/cgi-bin/transformer/t_out.cgi?30*$aurl[29]*" target="_blank">$account[29] 
        $atype[29] Movies</a><br>
        + <a href="cgi-bin/s2/out.cgi?reg" target="_blank">2 Teen Movies</a><br>
        + <a href="http://www.elitelist.net/cgi-bin/transformer/t_out.cgi?30*$aurl[30]*" target="_blank">$account[30] 
        $atype[30] Movies</a><br>
        + <a href="http://www.elitelist.net/cgi-bin/transformer/t_out.cgi?30*$aurl[31]*" target="_blank">$account[31] 
        $atype[31] Movies</a><br>
        + <a href="cgi-bin/s2/out.cgi?reg" target="_blank">13 Mature Movies</a></font></td>
    </tr>
  </table>
  <br>
  <table width="51%" cellspacing="1" cellpadding="2" bgcolor="#000000">
    <tr bgcolor="#FEC650"> 
      <td height="16" bgcolor="#FFFFFF"> 
        <div align="center"><font size="4" face="Verdana, Arial, Helvetica, sans-serif"><a href="http://www.adultrevenueservice.com/re.php?s=PE&a=175364">CLICK 
          HERE FOR THE HOTTEST YOUNG PUSSY!</a></font></div>
      </td>
    </tr>
  </table>
  <br>
</div>
</body>
</html>

###############################################################################################################################################################################################################################END EDIT
##############################################################################################################################################################################################################################

MAINHTML
  

print <<DDHTML;

<div align="center">
  <table width="204" cellspacing="1" cellpadding="2" bgcolor="#000000">
    <tr> 
      <td bgcolor="#FFFFFF"> 
        <div align="center"><b><font size="2" face="Arial, Helvetica, sans-serif"><a href="http://www.cyphonic.net/script/" target="_blank"><font color="#000000">Powered 
          By Xtreme TGP v1.0</font></a></font></b> </div>
      </td>
    </tr>
  </table>
</div>

DDHTML


}




&main;


