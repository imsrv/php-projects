<?php
include("functions.php");
include ('header.php');
?>
<table width="788" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
    <td bgcolor="#FFFFFF">
<?php
/* nulled by [GTT] :) */    

@session_start();
if(session_is_registered("usid"))
{


db_connect();
$defaff=db_result_to_array("select defurl, affdir from admininfo");
$defurl=$defaff[0][0];
$affdir=$defaff[0][1];
$banner=db_result_to_array("select id, imgsrc, text from banners");
$stpage=db_result_to_array("select id, url from startpages");
$adttrack=db_result_to_array("select id, name from grpsnclicks where affid='$usid'");
?><CENTER><?
if (@$adid)
{
 $bannersrc=db_result_to_array("select id, imgsrc, text from banners where id='$adid'");
 if ($bannersrc[0][1]) $imgsrc="\n<img src=\"".$bannersrc[0][1]."\">"; else $text="\n".$bannersrc[0][2];
 if (@$startpageid) $startpage=db_result_to_array("select id from startpages where id='$startpageid'");
 if (@$adtrackid) $adttrackid=db_result_to_array("select id, name from grpsnclicks where id='$adtrackid'");
 echo "<textarea cols=55 rows =5><a href=\"http://$defurl$affdir"."show.php?adid=$adid&affid=$usid&stp=";
 if (!@$startpage) echo "0"; else echo $startpage[0][0];
 if (@$adttrackid) echo "&adtr=".$adttrackid[0][0]; echo "\">";
 if (@$imgsrc) echo $imgsrc; else echo $text; echo "\n</a>";
 echo "</textarea>";
}

?>
<center>
<h3>Available Banner(s) and Code(s)</h3><p><a href="adtrack.php">Setup an Ad tracking campaign here.</a>
<br><br><b>To refer new users use this code:</b><br>
<center><?echo "http://$defurl$affdir"."register.php?affid=$usid";?></center><br>
  <table width="788" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
    <tr>
      <td bgcolor="#FFFFFF"><form method="post" action="getlink.php">
          <p align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Please
            select a banner/text ad below:</font></p>
          <div align="center">
            <table>
              <?for ($i=0; $i<count($banner); $i++)
{
 $id=$banner[$i][0];
 $imgsrc=$banner[$i][1];
 $text=$banner[$i][2];
?>
              <tr>
                <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
                  <input type=radio name=adid value=<?echo $id; if ($i==0) echo " checked";?>>
                  </font></td>
                <td> <P> <font size="2" face="Verdana, Arial, Helvetica, sans-serif">
                    <?if ($imgsrc) echo "<img src=\"$imgsrc\" border=o><br>$imgsrc"; else echo $text;?>
                    </font></p></td>
              </tr>
              <tr>
                <td colspan=2><hr width="200" size="1"></td>
              </tr>
              <?}?>
            </table>
            <table width="700" border="0">
              <tr>
                <td width="209"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Link
                  to which URL?<br>
                  (default is the home page)</font></td>
                <td width="481"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif">
                  <select name="startpageid">
                    <option value="">Select a pre-defined URL below</option>
                    <option value="">------------------------------</option>
                    <?for ($i=0; $i<count($stpage); $i++)
  {
   $id=$stpage[$i][0];
   $url=$stpage[$i][1];
   echo "<option value=\"$id\">$url</option>";
  }?>
                  </select>
                  </font></td>
              </tr>
              <tr>
                <td width="209"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Select
                  ad tracker? (optional)</font></td>
                <td width="481"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif">
                  <select name="adtrackid">
                    <option value="">Select a campaign</option>
                    <option value="">-----------------</option>
                    <?for ($i=0; $i<count($adttrack); $i++)
  {
   $id=$adttrack[$i][0];
   $name=$adttrack[$i][1];
   echo "<option value=\"$id\">$id : $name</option>";
  }?>
                  </select>
                  <br>
                  (<a href="adtrack.php">click here if you need to set up a campaign</a>)
                  </font></td>
              </tr>
              <tr>
                <td colspan="2" align=center><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><br>
                  <input type="submit" name="Generate" value="Generate Link Code">
                  </font></td>
              </tr>
            </table>
          </div>
        </form>
        <form method="post" action="login.php">
          <div align="center"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif">
            <input type="submit" name="Submit" value="Click here to return to Main Menu">
            </font></div>
        </form></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <br>
  </CENTER>
<?}
else echo "You are not logged in!";
?>
<?php
include ('footer.php');
?>
        </td>
  </tr>
</table>