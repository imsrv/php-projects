<?php
/* nulled by [GTT] :) */ 
@session_start();
if(session_is_registered("admin"))
{
include("functions.php");
include ('header.php');
db_connect();

if ($rebuild)
 echo "<br><br><center>".create_matrix()." affiliates where successfully inserted into the matrix tree!</center><br><br>";

if(@$update) $r= mysql_query("update admininfo set defurl='$defurl',topaffp='$topaffp',botaffp='$botaffp',affdir='$affdir',setaffpt='$setaffpt',payfreq='$payfreq',calctype='$calctype',minbal='$minbal',cookex='$cookex',leveld='7',cooloff='$cooloff', paypaladdr='$paypaladdr', linklifehours='$linklifehours', path='$path', terms='$terms', contactus='$contactus', faq='$faq', adminpath='$adminpath', testmode='$testmode', matrix_deep='$matrix_deep', matrix_width='$matrix_width'") or die(mysql_error());
$result=mysql_query("select * from admininfo");
$result=mysql_fetch_array($result);
?>
<?admin_menu();?>

<center>
<form method="post" action="admpref.php">
<input type="hidden" name="update" value="1">
    <table width="800" border="0">
      <tr>
        <td width="152">&nbsp;</td>
        <td width="334"> <h3><b>Current Settings</b></h3></td>
        <td width="300"> <h3><b>New Settings</b></h3></td>
      </tr>
      <tr>
        <td width="152">Default Website URL <small>(type "/" at the end)</small>:</td>
        <td width="334">http://<?echo @$result['defurl'];?></td>
        <td width="300">http://
          <input type="text" name="defurl" maxlength="300" value="<?echo @$result['defurl'];?>">
        </td>
      </tr>
      <tr>
        <td width="152">Affiliate Directory:</td>
        <td width="334">http://<?echo @$result['defurl'];?><?echo @$result['affdir'];?>
        </td>
        <td width="300">http://&lt;Default Website URL&gt;/
          <input type="text" name="affdir" size="25" maxlength="300" value="<?echo @$result['affdir'];?>">
        </td>
      </tr>
      <tr>
        <td width="152">Admin Directory:</td>
        <td width="334">http://<?echo @$result['defurl'];?><?echo @$result['adminpath'];?>
        </td>
        <td width="300">http://&lt;Default Website URL&gt;/
          <input type="text" name="adminpath" size="25" maxlength="300" value="<?echo @$result['adminpath'];?>">
        </td>
      </tr>
      <tr>
        <td width="152">Script path on the server:</td>
        <td width="334"><?echo @$result['path'];?> </td>
        <td width="300"> <input type="text" name="path" size="25" maxlength="300" value="<?echo @$result['path'];?>">
        </td>
      </tr>
      <tr>
        <td width="152">&nbsp;</td>
        <td width="334">&nbsp;</td>
        <td width="300">&nbsp;</td>
      </tr>
      <tr>
        <td width="152"><b>TEST MODE</b> <small>(to try the transactions online
          using a paypal emulator)</small>:</td>
        <td width="334">
          <?if (@$result['testmode']) echo "Test mode is <b>ON</b>! No real transactions would take place!"; else echo "Test mode is now <b>OFF</b>! You have to be sure that all is configured right, now script is operaiting with <b>REAL</b> money!"?>
        </td>
        <td width="300"><select name="testmode">
            <option value="0" <?if (!@$result['testmode']) echo "selected" ;?>>NO
            <option    value="1" <?if (@$result['testmode']) echo "selected" ;?>>YES</select>
        </td>
      </tr>
      <tr>
        <td width="152">&nbsp;</td>
        <td width="334">&nbsp;</td>
        <td width="300">&nbsp;</td>
      </tr>
      <tr>
        <td width="152">PayPal e-mail address:</td>
        <td width="334"><?echo @$result['paypaladdr'];?> </td>
        <td width="300"> <input type="text" name="paypaladdr" size="25" maxlength="300" value="<?echo @$result['paypaladdr'];?>">
        </td>
      </tr>
      <tr>
        <td width="152">Minimum withdraw Balance:</td>
        <td width="334"><?echo "$";
                echo @$result['minbal'];?> </td>
        <td width="300"><?echo "$";?> <input type="text" name="minbal" size="4" value="<?echo @$result['minbal'];?>">
          (whole numbers only)</td>
      </tr>
      <tr>
        <td width="152">Cookies Expiry:</td>
        <td width="334"><?echo @$result['cookex'];?> days</td>
        <td width="300"> <input type="text" name="cookex" size="2" maxlength="2" value="<?echo @$result['cookex'];?>">
          days</td>
      </tr>
      <tr>
        <td width="152">Cooling Off Period:</td>
        <td width="334"><?echo @$result['cooloff'];?> days </td>
        <td width="300"> <input type="text" name="cooloff" size="2" maxlength="2" value="<?echo @$result['cooloff'];?>">
          days </td>
      </tr>
      <tr>
        <td width="152">Link life in hours:</td>
        <td width="334"><?echo @$result['linklifehours'];?> hours </td>
        <td width="300"> <input type="text" name="linklifehours" size="2" maxlength="2" value="<?echo @$result['linklifehours'];?>">
          hours </td>
      </tr>
      <tr>
        <td width="152">&nbsp;</td>
        <td width="334">&nbsp;</td>
        <td width="300">&nbsp;</td>
      </tr>
      <tr>
        <td width="152">Matrix Deep (affiliate levels): <small>(if set to 0, direct affiliate commision would be still on)</small></td>
        <td width="334"><?echo @$result['matrix_deep'];?> </td>
        <td width="300"> <input type="text" name="matrix_deep" size="2" maxlength="1" value="<?echo @$result['matrix_deep'];?>" >
        </td>
      </tr>
      <tr>
        <td width="152">Matrix Width: <small>(if set to 0, the matrix woul have place (direct, line) structure)</small></td>
        <td width="334"><?echo @$result['matrix_width'];?> </td>
        <td width="300"> <input type="text" name="matrix_width" size="2" maxlength="1" value="<?echo @$result['matrix_width'];?>" >
        </td>
      </tr>
      <tr>
        <td width="152">RE-BUILD matrix: <small>(this is necessary after you have changed the width)</small></td>
        <td width="334" colspan=2 align=center><a href=admpref.php?rebuild=yes>RE-BUILD</a></td>
      </tr>
      <tr align="center">
        <td colspan="3">&nbsp;</td>
      </tr>
    </table>

    <br>
    <table width="800" border="0">
      <tr>
        <td align="center"><div align="center"><strong>Terms & Conditions page:
            <small>(Supports HTML)</small><br>
            </strong><?echo @$result['terms'];?> <br>
            <textarea name="terms" cols=40 rows=20 ><?echo @$result['terms'];?></textarea>
          </div></td>
      </tr>
      <tr>
        <td align="center"><div align="center"><br>
            <strong>Contact us page: <small>(Supports HTML)</small></strong><br>
            <?echo @$result['contactus'];?> <br>
            <textarea name="contactus" cols=40 rows=20 ><?echo @$result['contactus'];?></textarea>
          </div></td>
      </tr>
      <tr>
        <td align="center"><div align="center"><br>
            <strong>FAQ page: <small>(Supports HTML)</small></strong><br>
            <?echo @$result['faq'];?> <br>
            <textarea name="faq" cols=40 rows=20 ><?echo @$result['faq'];?></textarea>
          </div></td>
      </tr>
    </table>
    <p>
      <input name="submit" type="submit" value="Update Preferences">
      <input type="reset" value="Clear Form" name="Reset">
      <br>
     </p>
  </form>
    <br>
  <form method="post" action="adminlogin.php">
  <input type="submit" name="Submit" value="Click here to return to Main Menu">
</form>

  </center>
<?}
else echo "You are not logged in";

function create_matrix()
{
 db_connect();
 mysql_query("delete from matrix");
 $users=db_result_to_array("select id, referer from users where disabled=0 order by id");
 for ($i=0; $i<count($users); $i++)
 {
  $r=add_new_matrix_entry($users[$i]['id']);
  if ($r) $inserted_users++;
 }
 return $inserted_users;
}

?>