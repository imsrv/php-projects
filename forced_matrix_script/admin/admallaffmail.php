<?php

/* nulled by [GTT] :) */    

@session_start();

include("functions.php");
include ('header.php');

db_connect();

if (session_is_registered("admin"))

{

$result=db_result_to_array("select email from admininfo");

$defualtmail=$result[0][0];

if (@$send&&@$from&&@$fromemail&&@$subject&&@$message)

 {

 $affs=db_result_to_array("select email, frstname, lstname from users");

 $c=count($affs);

 if (@$toself) $affs[$c][0]=$defualtmail;

 $c=count($affs);

 for ($i=0; $i<$c; $i++)

  {

  $affemail=$affs[$i][0];

  @$afffname=$affs[$i][1];

  @$afflname=$affs[$i][2];

  $message=str_replace("[fname]", $afffname, $message);

  $message=str_replace("[lname]", $afflname, $message);

  mail($affemail, $subject, $message, "FROM: $from <$fromemail>");

  }

 echo "<br>Your message have been sent!<br>";

 }



$result=db_result_to_array("select count(id) from users");

?>

<?admin_menu();?>

<center>

<h3>Send Email to all your affiliates<br>

    (

    <?echo $result[0][0];?>   people total)</h3>

  <form method="post" action="admallaffmail.php">

  <input type="hidden" name=send value=1>

    <table width="600" border="0" cellspacing="0" cellpadding="4">

      <tr>

        <td width="94">From:</td>

        <td width="490">

          <input type="text" name="from" maxlength="250" value="Affiliate Update">

          (enter name here, not email address)</td>

      </tr>

      <tr>

        <td width="94">Email:</td>

        <td width="490">

          <input type="text" name="fromemail" maxlength="250" value="<?echo $defualtmail;?>">

          (enter email address here)</td>

      </tr>

      <tr>

        <td width="94">Subject:</td>

        <td width="490">

          <input type="text" name="subject" maxlength="250" size="40" value="Latest updates at yourdomain.com">

        </td>

      </tr>

      <tr>

        <td colspan="2" valign="top">

        <b>KEY for message area:</b><br>

        Affiliate First name - [fname]<br>

        Affiliate Last name - [lname]

        </td>

      </tr>

      <tr>

        <td width="94" valign="top">Message:</td>

        <td width="490">

          <textarea name="message" rows="10" cols="50">Dear [fname],



This is our latest update.



Please visit us soon.



Thank you

YourDomain.com Management</textarea>

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

          <input type="submit" name="sendemail" value="Send email now">

        </td>

      </tr>

    </table>

  </form>

  <br>



  <form method="post" action="adminlogin.php">

  <input type="submit" name="Submit" value="Click here to return to Main Menu">

</form>

</center>

<?

}

else echo "You are not logged in";

?>



