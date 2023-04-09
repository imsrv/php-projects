<?php
include("functions.php");
include ('header.php');
?>
<table width="788" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
    <td align="center" bgcolor="#FFFFFF">
      <?php
/* nulled by [GTT] :) */
db_connect();
if (@$email)
{
$result=db_result_to_array("select frstname, lstname, password, id from users where email='$email'");
if ($result)
 {
$frstname=$result[0][0];
$lstname=$result[0][1];
$password=$result[0][2];
$usid=$result[0][3];
$result=db_result_to_array("select fromperson, fromemail, subject, message from letters where action='lostpass'");
$fromperson=$result[0][0];
$fromemail=$result[0][1];
$subject=$result[0][2];
$message=$result[0][3];
$message=str_replace("[fullname]", "$frstname $lstname", $message);
$message=str_replace("[fname]", $frstname, $message);
$message=str_replace("[lname]", $lstname, $message);
$message=str_replace("[affid]", "$usid", $message);
$message=str_replace("[password]", "$password", $message);
mail($email, $subject, $message, "FROM: $fromperson <$fromemail>");
echo "The requested info was sent to $email.";
 }
else echo "This e-mail was not found in our database.";
}
else
echo "Enter here the e-mail you specified during the registration:<br><form action=forgot.php><input name=email><input type=submit value=\"Send!\"></form>";

?>
      <?php
include ('footer.php');
?>
    </td>
  </tr>
</table>
