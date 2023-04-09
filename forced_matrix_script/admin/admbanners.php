<?php
/* nulled by [GTT] :) */    
@session_start();
if(session_is_registered("admin"))
{
include("functions.php");
include ('header.php');
db_connect();
if(@$add&&@$imgsrc) mysql_query("insert into banners (id, imgsrc) values ('', 'http://$imgsrc')");
if(@$add&&@$text) mysql_query("insert into banners (id, text) values ('', '$text')");
if(@$remove&&@$bannerid) mysql_query("delete from banners where id='$bannerid'");

$result=db_result_to_array("select id, imgsrc, text from banners");

?>
<?admin_menu();?>
<CENTER>
<H3>Ad Settings</H3>
<P>Current Banners</P>
<CENTER>
<H3>Available Banner(s) and Code(s)</H3>

<?for ($i=0; $i<count($result); $i++)
{
 $id=$result[$i][0];
 $imgsrc=$result[$i][1];
 $text=$result[$i][2];
?>
<FORM action=admbanners.php method=post>
<input type=hidden name=remove value=1>
<P><?if ($imgsrc) echo "<img src=\"$imgsrc\" border=o><br>$imgsrc"; else echo $text;?></p>
<P><INPUT type=hidden value=<?echo $id;?> name=bannerid><INPUT type=submit value=Remove name=RemoveBtn></P></FORM>
<HR width=200 SIZE=1>
<?}?>

<P>&nbsp;</P>
<TABLE width=510 border=0>
  <TBODY>
  <TR>
    <TD align=middle colSpan=2>
      <H2>Add another ad</H2></TD></TR>
  <TR>
    <TD width=104>Banner URL:</TD>
    <TD width=396>
      <FORM action=admbanners.php method=post>
          <input type=hidden name=add value=1>
          http:// <INPUT size=35
      name=imgsrc> <INPUT type=submit value=Submit> </FORM></TD></TR>
  <TR>
    <TD width=104>Text Ad:<BR>(250 chars max)</TD>
    <TD width=396>
      <FORM action=admbanners.php method=post><INPUT maxLength=250 size=50
      name=text><input type=hidden name=add value=1> <INPUT type=submit value=Submit>
  </FORM></TD></TR></TBODY></TABLE>
<P>Note: Affiliates have access to these banners immediately, once
submitted.<BR></P>
</CENTER>
<br>

  <form method="post" action="adminlogin.php">
  <input type="submit" name="Submit" value="Click here to return to Main Menu">
</form>

</CENTER>

<?}
else echo "You are not logged in!";
?>