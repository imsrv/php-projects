<?php

/* nulled by [GTT] :) */

include("functions.php");

@session_start();

include ('header.php');

if(session_is_registered("usid"))

{



db_connect();

if(@$remid) mysql_query("delete from grpsnclicks where id='$remid'");

if(@$addescr) mysql_query("insert into grpsnclicks (id, name, affid) values ('', '$addescr', '$usid')");





$result=db_result_to_array("select id, name, clicks from grpsnclicks where affid='$usid'");



?>
<CENTER>
  <table width="788" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
    <tr>
      <td bgcolor="#FFFFFF"><h3 align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Affiliate
          Ad Tracker</font></h3>
        <div align="center">
          <table width="600" border="0">
            <tr>
              <td width="70" align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>Ad
                ID</b></font></td>
              <td width="*"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>Ad
                Description</b></font></td>
              <td width="40" align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>Clicks</b></font></td>
              <td  width="140" align="center"> <p><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>Options</b></font></p></td>
            </tr>
            <?for ($i=0; $i<count($result); $i++)

  {

   $id=$result[$i][0];

   $name=$result[$i][1];

   $clicks=$result[$i][2];

   echo "<tr><td width=70 align=center>$id</td><td width=\"*\">$name</td><td width=40 align=center>$clicks</td>";

   echo "<td width=140 align=center><a href=\"getlink.php\">view link code</a> | <a href=\"adtrack.php?remid=$id\">remove</a></td>";

   echo "</tr>";

  }?>
          </table>
        </div>
        <P align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">**
          Removals of ad trackers cannot be undone **</font></P>
        <form method="post" action="adtrack.php">
          <div align="center">
            <table width="464" border="0">
              <tr>
                <td align="center"> <h2><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Track
                    a new Ad</font></h2></td>
              </tr>
              <tr>
                <td valign="top"> <p align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Ad
                    Description:<br>
                    <textarea name="addescr" cols="40" rows="3"></textarea>
                    </font></p>
                  <p><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><br>
                    eg. Advertising in Newsletter ABC in May 2002 edition<br>
                    eg. Link placed in FFAWebsite.com under 'Computers' on 2002-05-09</font></p></td>
              </tr>
              <tr align="center">
                <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><br>
                  <input type="submit" name="trackad" value="Track this Ad">
                  <input type="reset" value="Clear Form" name="reset">
                  </font></td>
              </tr>
            </table>
          </div>
        </form>
        <div align="center"> </div>
        <form method="post" action="login.php">
          <div align="center"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif">
            <input type="submit" name="Submit" value="Click here to return to Main Menu">
            </font></div>
        </form></td>
    </tr>
  </table>
</center>
<font size="2" face="Verdana, Arial, Helvetica, sans-serif">
<?}

else echo "You are not logged in!";



include ('footer.php');

?>
</font>
