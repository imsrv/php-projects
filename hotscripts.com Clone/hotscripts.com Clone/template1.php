<?
include_once "config.php";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Software Downloads- Members Area</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="styles.css" rel="stylesheet" type="text/css">
</head>

<body topmargin="0">
<table width="716" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="459" background="images/t_bg.gif"><table width="754" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td width="77" valign="top"><img src="images/logo.gif"></td>
          <td width="223"><font color="#FFFFFF" size="4" face="Tahoma, Verdana, Arial, Helvetica, sans-serif"><strong><?php echo $site_name ?></strong></font></td>
          <td width="454"><div align="right"> 
              <?
$rs_t=mysql_fetch_array(mysql_query("select count(*)  from sbwmd_ads where paid='yes'  and credits>displays"));


$cnt= $rs_t[0];

if ($cnt==0)
{
echo "<a href='advertise.php'><img src='images/default_banner.gif' width=468 height=60 border=0></a>";
}
else
{

$rs_t_query=mysql_query("select *  from sbwmd_ads where paid='yes'  and credits>displays");

$rnum=abs( mt_rand(1,$cnt) ) ;

for ($i=0;$i<$rnum;$i++)
{
$rs_t=mysql_fetch_array($rs_t_query);
}
$id=$rs_t["id"];
$url=$rs_t["url"];
$bannerurl=$rs_t["bannerurl"];
echo "<a href='$url'><img src='$bannerurl' width=468 height=60 border=0></a>";
mysql_query("update sbwmd_ads set displays=displays+1 where id=$id");
}						
			?>
            </div></td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td width="755" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td width="6%"><img src="images/end.gif" width="44" height="36"></td>
                <td width="10%"><a href="index.php"><img src="images/home.gif" width="75" height="36" border="0"></a></td>
                <td width="9%"><a href="signinform.php"><img src="images/login.gif" width="71" height="36" border="0"></a></td>
                <td width="12%"><a href="signup.php"><img src="images/register.gif" width="90" height="36" border="0"></a></td>
                <td width="12%"><a href="feedback.php"><img src="images/feedback.gif" width="92" height="36" border="0"></a></td>
                <td width="14%"><a href="linktous.php"><img src="images/link.gif" width="102" height="36" border="0"></a></td>
                <td width="20%"><a href="add_soft.php"><img src="images/submit.gif" width="147" height="36" border="0"></a></td>
                <td width="7%"><a href="advertise.php"><img src="images/advertise.gif" width="152" height="36" border="0"></a></td>
              </tr>
            </table></td>
        </tr>
        <tr background="images/bg.gif"> 
          <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td valign="top" background="images/bg2.gif"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr> 
                      <td width="161" valign="top"> 
                        <?php
			if (isset($_REQUEST["cid"]) && $_REQUEST["cid"]!="")
			{
			$cid=$_REQUEST["cid"];
		
			}
			else
			{
			$cid=0;
			}
				left($cid); 
			?>
                        <br> </td>
                      <td width="612" valign="top"> <div align="center"> 
                          <table width="574" border="0" align="center" cellpadding="0" cellspacing="0">
                            <tr> 
                              <td width="462"> <div align="center"><br>
                                  <? main();?>
                                </div></td>
                            </tr>
                          </table>
                        </div></td>
                    </tr>
                  </table></td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td bgcolor="#000000"> <div align="center"> 
        <table width="100%" border="0" cellspacing="0" cellpadding="4">
          <tr> 
            <td><div align="center"><font color="#FFFFFF"><a href="index.php" class="smlink">home</a> 
                | <a href="signinform.php" class="smlink">login</a> | <a href="signup.php" class="smlink">register</a> 
                | <a href="feedback.php" class="smlink">feedback</a> | <a href="linktous.php" class="smlink">link 
                to us</a> | <a href="add_soft.php" class="smlink">submit software</a> 
                | <a href="advertise.php" class="smlink">advertise</a> </font></div></td>
          </tr>
        </table>
      </div></td>
  </tr>
  <tr> 
    <td  height="4"></td>
  </tr>
  <tr> 
    <td><div align="center"><span class="keyword"><font face="Tahoma, Verdana, Arial, Helvetica, sans-serif">Copyright 
        2004. <?php echo $site_name  ?> </font></span> 
        <map name="Map2Map">
          <area shape="rect" coords="1,0,43,12" href="privacy.php">
          <area shape="rect" coords="63,-1,96,9" href="legal.php">
          <area shape="rect" coords="115,-3,152,10" href="termsandconditions.php">
        </map>
      </div></td>
  </tr>
</table>
<p align="center" class="smlink"></p>
<p>&nbsp;</p>
</body>
</html>
