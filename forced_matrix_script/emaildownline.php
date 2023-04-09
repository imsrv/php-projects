<?
/* nulled by [GTT] :) */    

include("functions.php");
db_connect();
@session_start();
include ('header.php');
if(session_is_registered("usid"))
{

$result=db_result_to_array("select email from users where id='$usid'");
$email=$result[0][0];

$quant=0;
$affs[0]=db_result_to_array("select id, email from users where referer='$usid'");
if (@$affs[0])
{
 for ($k=0; $k<6; $k++)
 {
  @$c=count($affs[$k]);
  $quant+=$c;
  for ($i=0; $i<$c; $i++)
  {
   if (@$affs[$k+1])$t=count($affs[$k+1]); else $t=0;
   $affss=db_result_to_array("select id, email from users where referer='".$affs[$k][$i][0]."'");
   for ($j=0; $j<count($affss); $j++, $t++)
    {$affs[$k+1][$t][0]=$affss[$j][0];
        $affs[$k+1][$t][1]=$affss[$j][1];}
  }
 }
 @$c=count($affs[$k]);
 $quant+=$c;
}

if ($quant){
 if (@$go&&@$from&&@$subject&&@$message)
 {
  for ($k=0; $k<=6; $k++)
  {
   $c=count($affs[$k]);
   for ($i=0; $i<$c; $i++)
        mail($affs[$k][$i][1], $subject, $message, "FROM: $from <$email>");
  }
  if (@$toself) mail($email, $subject, $message, "FROM: $from <$email>");
  echo "<br>Your message have been sent!<br>";
 }
?>
<CENTER> <h3>Send Email to your downline<br>
                  (<?echo $quant;?> people total)</h3>
                <form method="post" action="emaildownline.php">
                                <input type="hidden" name=go value=1>
                  <table width="600" border="0" cellspacing="0" cellpadding="4">
                    <tr>
                      <td width="94">From:</td>
                      <td width="490">
                        <input type="text" name="from" maxlength="250">
                        (enter name here, not email address)</td>
                    </tr>
                    <tr>
                      <td width="94">Subject:</td>
                      <td width="490">
                        <input type="text" name="subject" maxlength="250">
                      </td>
                    </tr>
                    <tr>
                      <td width="94" valign="top">Message:</td>
                      <td width="490">
                        <textarea name="message" rows="10" cols="50"></textarea>
                      </td>
                    </tr>
                    <tr>
                      <td width="94" valign="top">Send copy to yourself?</td>
                      <td width="490">
                        <input type="checkbox" name="toself" value="yes">
                        Yes </td>
                    </tr>
                    <tr>
                      <td colspan="2" valign="top" align="CENTER">
                        <input type="submit" name="Submit" value="Send email now">
                      </td>
                    </tr>
                  </table>
                </form>
</CENTER>
<?
 }
 else echo "<center>You do not have any subaffiliates yet!</center>";
?>
                <center>
  <form method="post" action="login.php">
  <input type="submit" name="Submit" value="Click here to return to Main Menu">
</form>
</CENTER>
<?
}

else
echo "Access denied";

include ('footer.php');
?>