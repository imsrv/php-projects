<?php

require "config.class.php";
require "main.class.php";
require "link.class.php";
$q = trim($q);
$ddl = new ddl();
$le = new linker();
$ddl->open();
$ddl->get($q, $types);
?>
<HTML>
<HEAD>
<TITLE>Halilwarez</TITLE>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=iso-8859-1">

<style type="text/css">
<!-- 
A:link {
	FONT-SIZE: 11px; COLOR: #197201; FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif; TEXT-DECORATION: none
}
A:active {
	FONT-SIZE: 11px; COLOR: #197201; FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif; TEXT-DECORATION: none
}
A:visited {
	FONT-SIZE: 11px; COLOR: #000000; FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif; TEXT-DECORATION: none
}
A:hover {
	FONT-SIZE: 11px; COLOR: #000000; FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif; TEXT-DECORATION: underline overline
}
TD {
	FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #000000; FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif
}
BODY {
	FONT-WEIGHT: normal; FONT-SIZE: 10px; COLOR: #ffffff; SCROLLBAR-ARROW-COLOR: #ffffff; FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif; SCROLLBAR-BASE-COLOR: #4C9D28
}
.input {
	BORDER-RIGHT: #000000 1px solid; BORDER-TOP: #000000 1px solid; FONT-SIZE: 8px; BORDER-LEFT: #000000 1px solid; COLOR: #ffffff; BORDER-BOTTOM: #000000 1px solid; FONT-FAMILY: verdana;
}
-->
</style>

<SCRIPT LANGUAGE='JAVASCRIPT' TYPE='TEXT/JAVASCRIPT'>
<!--
var navWindow=null;
function nav(mypage,myname,w,h,pos,infocus){

if (pos == 'random')
{LeftPosition=(screen.width)?Math.floor(Math.random()*(screen.width-w)):100;TopPosition=(screen.height)?Math.floor(Math.random()*((screen.height-h)-75)):100;}
else
{LeftPosition=(screen.width)?(screen.width-w)/2:100;TopPosition=(screen.height)?(screen.height-h)/2:100;}
settings='width='+ w + ',height='+ h + ',top=' + TopPosition + ',left=' + LeftPosition + ',scrollbars=no,location=no,directories=no,status=no,menubar=no,toolbar=no,resizable=no';navWindow=window.open('',myname,settings);
if(infocus=='front'){navWindow.focus();navWindow.location=mypage;}
if(infocus=='back'){navWindow.blur();navWindow.location=mypage;navWindow.blur();}

}
// -->
</script>


</HEAD>
<BODY bgcolor="#7B7B7B" LEFTMARGIN=0 TOPMARGIN=0 MARGINWIDTH=0 MARGINHEIGHT=0>



<table align="center" width="785" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="785" valign="top"> 
      <table width="100%" border="0" cellpadding="0" cellspacing="0" background="images/index_02.gif">
        <tr> 
          <td width="177" rowspan="3" valign="top"><img src="images/index_01.gif" width="177" height="52"></td>
          <td width="591" height="12" valign="top">&nbsp;</td>
          <td width="17" valign="top" rowspan="3"><img src="images/index_04.gif" width="17" height="52"></td>
        </tr>
        <tr> 
          <td valign="top" height="22" align="center"><b> ALL THE WAREZ IN ONE SITE</b> 
            .......</td>
        </tr>
        <tr> 
          <td height="18" valign="top">&nbsp;</td>
        </tr>
      </table>
    </td>
  </tr>
  <tr> 
    <td height=62 valign="top"> 
      <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr> 
          <td width="785" height="62" valign="top"><img src="images/index_05.gif" width="785" height="62"></td>
        </tr>
      </table>
    </td>
  </tr>
  <tr> 
    <td valign="top"> 
      <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr> 
          <td width="785" height="17" valign="top"><img src="images/index_06.gif" width="785" height="17"></td>
        </tr>
      </table>
    </td>
  </tr>
  <tr> 
    <td valign="top"> 
      <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr> 
          <td width="14" height="16" valign="top"><img src="images/index_07.gif" width="14" height="16"></td>
          <td width="757" valign="middle" bgcolor="#CECECE">
		  
		  <div align="center">
		  : <a href="index.php"> Home </a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		  : <a href="index.php"> Downloads </a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          : <a href="javascript:nav('join.php','Navigation','400','300','center','front');"> Join Le </a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		  : <a href="submit.php"> Submit Dls </a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		  : <a href="webmasters"> Webmasters $ </a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		  : <a href="javascript:nav('ask.php','Navigation','400','300','center','front');"> Contact Us </a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		  </div>
		  
		  </td>
          <td width="17" valign="top"><img src="images/index_09.gif" width="17" height="16"></td>
        </tr>
      </table>
    </td>
  </tr>
  <tr> 
    <td height="6" valign="top"> 
      <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr> 
          <td width="785" height="6" valign="top"><img src="images/index_10.gif" width="785" height="6"></td>
        </tr>
      </table>
    </td>
  </tr>
  <tr> 
    <td valign="top"> 
      <table width="100%" border="0" cellpadding="0" cellspacing="0" background="images/main_bg.gif">
        <tr> 
          <td width="14" valign="top">&nbsp;</td>
          <td width="183" valign="top"> 
            <table width="100%" border="0" cellpadding="0" cellspacing="0" background="images/nav_bg.gif">
              <tr> 
                <td height="35" valign="top" colspan="3"><img src="images/index_13.gif" width="183" height="35"></td>
              </tr>
              <tr> 
                <td background="images/nav_left.gif" width="13" height="3"></td>
                <td width="160" bgcolor="#F0ECF0"> 
                 
				
            <p style="margin-left:10px;"><br>&nbsp;&nbsp;::&nbsp;<a href="javascript:window.external.AddFavorite('http://www.cyberwarez.com.ar', 'CYBERDDl - FREE FULL DIRECT DLS')">Bookmark</a><br>
&nbsp;&nbsp;::&nbsp;<a href="disclaimer.php">Disclaimer</a><br>
&nbsp;&nbsp;::&nbsp;<a href="faqs.php">Faqs</a><br>
&nbsp;&nbsp;::&nbsp;<a href="topddl.php">Top Downloads</a><br>
&nbsp;&nbsp;::&nbsp;<a href="search.php">Advanced Search </a><br>
<br><div align="center">
  <table border="0" width="150" cellspacing="0" cellpadding="0">
    <tr>
      <td width="100%"><p align="left"><b>Top Sites </b></p></td>
    </tr>
  <center>
    <tr>
      <td width="100%">
        <hr>
      </td>
    </tr>
  </table>
  </center>
</div><br>
			<table><tr><td><? 

# First number is the number of links per column, second number is the total number of links
$le->get(30,30) 

?></td></tr></table><br />

<div align="center">
  <table border="0" width="150" cellspacing="0" cellpadding="0">
    <tr>
      <td width="100%"><p align="left"><b>Downloads </b></p></td>
    </tr>
  <center>
    <tr>
      <td width="100%">
        <hr>
      </td>
    </tr>
  </table>
  </center>
</div>
			</p><p style="margin-left:10px;">&nbsp;&nbsp;::&nbsp;<a href="index.php?type=App">Programs</a><br>
&nbsp;&nbsp;::&nbsp;<a href="index.php?type=Game">Games</a><br>
&nbsp;&nbsp;::&nbsp;<a href="index.php?type=mp3">Full Albums</a><br>
&nbsp;&nbsp;::&nbsp;<a href="index.php?type=movies">Movies</a><br>
&nbsp;&nbsp;::&nbsp;<a href="index.php?type=scripts">Scripts </a><br>
&nbsp;&nbsp;::&nbsp;<a href="index.php?type=template">Templates </a><br>
&nbsp;&nbsp;::&nbsp;<a href="index.php?type=other">Others </a><br>
<br><div align="center">
  <table border="0" width="150" cellspacing="0" cellpadding="0">
    <tr>
      <td width="100%"><p align="left"><b>Friends </b></p></td>
    </tr>
  <center>
    <tr>
      <td width="100%">
        <hr>
      </td>
    </tr>
  </table>
  </center>
</div><br>
			
            <p align="center">
			<a href="http://cyberddl.info"><img border="0" src="images/cyberddl6dz5qv.gif" width="88" height="31"></a><BR><BR>
			<a href="http://cyberddl.info"><img border="0" src="images/cyberddl6dz5qv.gif" width="88" height="31"></a><BR><BR>
<a href="http://cyberddl.info"><img border="0" src="images/cyberddl6dz5qv.gif" width="88" height="31"></a><BR><BR>
<a href="http://cyberddl.info"><img border="0" src="images/cyberddl6dz5qv.gif" width="88" height="31"></a><BR><BR>			
			</p>
			
				 
                </td>
                <td width="10" valign="top"><img src="images/nav_right.gif" width="10" height="3"></td>
              </tr>
              <tr> 
                <td colspan="3" height="14" valign="top"><img src="images/nav_bottom.gif" width="183" height="14"></td>
              </tr>
            </table>fdsadf
          </td>
          <td width="11" valign="top">&nbsp;</td>
          <td width="565" valign="top"><br> <center><a href="http://www.herbalaffiliateprogram.com/herbalsmokeshop/aff_manager/newaff/redirect.cfm/i/2004036034/LinkID/267/CampaignID/1828"><img alt="buy real buds online!" border=0 src="http://www.herbalsmokeshop.com/images/04banners/468x60-hss-11-04b.gif"></a></center><br>
            <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#EDEDED">
              <tr> 
                <td height="31" valign="top" colspan="3"><img src="images/index_15.gif" width="565" height="31"></td>
              </tr>
              <tr> 
                <td background="images/index_17.gif" width="5"></td>
                <td width="550"> 
                 <table  align="center" cellpadding="0" cellspacing="1" bordercolor="#F0ECF0" bgcolor="#F0ECF0">
                          <tr align="center" bgcolor="#F0ECF0" class="blacktext">
                          
                            <td width=60%>
                              <div align="center"><font color="#000000"><font size="1"><font face="Verdana, Arial, Helvetica, sans-serif"></font></font></font></div></td>
<td width=20%>
                              <div align="center"><font color="#000000"><font size="1"><font face="Verdana, Arial, Helvetica, sans-serif"></font></font></font></div></td>
                            <td width=10%>
                              <div align="center"><font color="#000000"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"></font></font></div></td>
                            
                            
                            <td width=5%><div align="center"><font color="#000000"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"></font></font></div></td>
<td width=5%><div align="center"><font color="#000000"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"></font></font></div></td>


                          </tr>
				 <table cellspacing=1 cellpadding=0 border=0 width=100%>
                                          <tr bgcolor="#F0ECF0">
                                            <td><div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Type</font></div></td>
                                            <td bgcolor="#F0ECF0"><div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Download Name </font></div></td>
                                            <td align="center"><div align="center" class="blacktext"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Downloads</font></div></td>
                                            <td align="center"><div align="center" class="blacktext"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Report</font></div></td>
                                          </tr> 
                       <?
$connection = mysql_connect("200.68.121.105:3306","cyberddl","12487400");
mysql_select_db(dbname, $connection);
$result = mysql_query("select * from downloads order by views desc limit 0, 30");
$number = mysql_num_rows($result);
if ($number > 0) {
$i=1;
while($row = mysql_fetch_array($result)) {
$t_dl = $t_dl + 1;
echo "<tr  bgcolor=\"#F0ECF0\" align=center><td align=center ><font color=\"#6EAD00\">$row[type]</font></td><td align=center><a href=\"go.php?go=Download&id=$row[id]\" target=\"_blank\">$row[title]</a></td><td align=center>$row[views]</td><td align=center><a href=\"go.php?go=Report&id=$row[id]\" target=\"_blank\">[X]</a></td></tr>";
$i++;
}
}
?>
	</table>			  
		<p align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">Found <b>
                          <?=$ddl->total?>
                      </b> Working Downloads</font></p>
					  <? 
echo "<center><br><br><b>Pages: </b>";
# Place the code below where you want the number of pages to appear
if (!$q)
	$ddl->page("index.php?page=");
else
	$ddl->page("index.php?q=$q&page="); ?><br><br><br>
<form action="index.php" method="POST">
                    <div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><b>.: Search Our Database :.</b></font>
                        <input class=box onBlur="if (value==''){value='Search Warez';}"  onFocus="if (value == 'Search Warez') {value='';}" size=20 value="Search Warez" type=text 
		  name=q>
                        <input class=box type=submit value=     Search      name="submit" size=20>
                    </div>
                  </form>		 
				 
                </td>
                <td background="images/index_19.gif" width="10"></td>
              </tr>
              <tr> 
                <td height="22" colspan="3" valign="top"><img src="images/index_24.gif" width="565" height="22"></td>
              </tr>
            </table>
          </td>
          <td width="16"></td>
        </tr>
      </table>
    </td>
  </tr>
  <tr> 
    <td height="55" valign="top">
      <table width="100%" border="0" cellpadding="0" cellspacing="0" background="images/index_28.gif">
        <tr> 
          <td width="23" valign="top" rowspan="3"><img src="images/index_27.gif" width="23" height="55"></td>
          <td width="745" height="19" valign="top">&nbsp;</td>
          <td width="17" valign="top" rowspan="3"><img src="images/index_30.gif" width="17" height="55"></td>
        </tr>
        <tr> 
          <td valign="top" height="19" align="center">
		  Copyright &copy 2005 Halil. Designed :
		  <a target=_blank href="http://www.HalilWarez.com">HalilWarez.com</a>
		  </td>
        </tr>
        <tr> 
          <td height="17" valign="top">&nbsp;</td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</BODY>
</HTML>