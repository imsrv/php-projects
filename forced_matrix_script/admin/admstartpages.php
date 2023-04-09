<?php
 /* nulled by [GTT] :) */ 

@session_start();

if(session_is_registered("admin"))

{

include("functions.php");
include ('header.php');

db_connect();

?>

<?admin_menu();?>



<?



if(@$add&&@$url) mysql_query("insert into startpages (id, url) values ('', '$url')");

if(@$removeid) mysql_query("delete from startpages where id='$removeid'");

if(@$editquery&&@$editurl) mysql_query("update startpages set url='$editurl' where id='$editquery'");



if (@$editid)

{

$result=db_result_to_array("select url from startpages where id='$editid'");

?>



<center>

<form method="post" action="admstartpages.php">

  <input type=hidden name=editquery value=<?echo $editid;?>>

<center>

<table width="392" border="0">

      <tr>

        <td align="center">

          <h2>Edit a start page with id <?echo $editid;?></h2>

        </td>

      </tr>

      <tr>

        <td valign="top">

          <p align="center">Start Page URL:<br>

            <input type="text" name="editurl" size="50" value="<?echo $result[0][0];?>" maxlength="250">

        </td>

      </tr>

      <tr align="center">

        <td><br>

          <input type="submit" name="createstart" value="Edit start page" >

          <input type="reset" value="Clear Form" name="reset">

        </td>

      </tr>

    </table>

 </form>



</CENTER><?



}

else{

$result=db_result_to_array("select id, url from startpages");



?>

<center>

<h3>Create available start page</h3>

  <table width="600" border="0">

    <tr>

      <td width="100" align="center"><b>Start Page ID</b></td>

      <td width="*"><b>Start Page URL</b></td>

      <td width="90"><b>Options</b></td>

    </tr>

<?for ($i=0; $i<count($result); $i++)

{

 $id=$result[$i][0];

 $url=$result[$i][1];

?>

<tr>

      <td width=70 align=center><?echo $id;?></td>

      <td width="*"><?echo $url;?></td>

      <td width=140 align=center><a href="admstartpages.php?editid=<?echo $id;?>">edit</a> | <a href="admstartpages.php?removeid=<?echo $id;?>">remove</a></td>

    </tr>

<?}?>

  </table>



  <P>** Removals of start page URLs cannot be undone.<br>

    We recommend you edit the start pages as there may be affiliates already linking

    to that Start Page ID.**</P>

  <form method="post" action="admstartpages.php">

  <input type=hidden name=add value=1>

    <table width="392" border="0">

      <tr>

        <td align="center">

          <h2>Create a start page</h2>

        </td>

      </tr>

      <tr>

        <td valign="top">

          <p align="center">Start Page URL:<br>

            <input type="text" name="url" size="50" value="http://" maxlength="250">

          </p>

          <p>eg. http://www.yourdomain.com/products/tv.html<br>

            eg. http://www.yourdomain.com/products/radio.html</p>

        </td>

      </tr>

      <tr align="center">

        <td><br>

          <input type="submit" name="createstart" value="Create start page" >

          <input type="reset" value="Clear Form" name="reset">

        </td>

      </tr>

    </table>

 </form>

  <br>

  <form method="post" action="adminlogin.php">

  <input type="submit" name="Submit" value="Click here to return to Main Menu">

</form>

</CENTER>



<?}}

else echo "You are not logged in!";

?>
