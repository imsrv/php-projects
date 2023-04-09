<?
/* nulled by [GTT] :) */    

include("functions.php");
db_connect();
session_start();
//session_register("paidprogramid");
//$paidprogramid=2;
///////////////////////////
//
// url entrances
// $prodid = product id
//
///////////////////////////
$admin=db_result_to_array("select defurl, affdir, path, linklifehours, adminpath from admininfo");
$siteurl="http://".$admin[0][0]."/".$admin[0][1];
$siteurl=str_replace("//", "/", $siteurl);
$path["tmproot"] = $admin[0][2]."/downloads/";
$path["storage"] = $admin[0][2]."/".$admin[0][4]."storage/";
$linklifehours=$admin[0][3];
        function getRnd($len = 8)
        {
                for($i=0;$i<=$len; $i++)
                {
                        $retval .= mt_rand(0,9);
                }
                return strtolower(substr(base64_encode($retval),0 ,$len ));
        }


        ///////////////////////////////////////
        // ispaid
        ///////////////////////////////////////
        function ispaid()
        {
         global $prodid;
         global $paidprogramid;
                if (session_is_registered("paidprogramid"))
                {
                 $prodid=$paidprogramid;
                 return true;
                }
                else return false;
        }
        ///////////////////////////////////////
        // ispaid
        ///////////////////////////////////////
        include ('header.php');
?>
<?
//$page_valid = true;
//$valid["ok"] = true;
//$valid["mail"] = true;
//$valid["alsohaslink"] = true;
if (!empty($email))
{
        //validating e-mail
        if (!empty($email))
        {

                // chekin if there download for this user
                $lcheck = mysql_query("select * from temp_link where progid='$prodid' and email='$email'") or die(mysql_error());
                if (mysql_num_rows($lcheck) <=0)
                {
                        $valid["alsohaslink"] = false;
                        $page_valid = false;
                }

                if ( mysql_num_rows($lcheck) <=0)
                {
                        if(ispaid($dsuser[0])) //
                        {
                         $query_prod = "select filename, title from programs where id = '$prodid'";
                 $prod = mysql_query($query_prod) or die(mysql_error());
                 $dsprod = mysql_fetch_row($prod);
                 $filename = $dsprod[0];
                                // generating link
                                $rndfolder = getRnd(20);
                                mkdir ($path["tmproot"].$rndfolder."", 0755);
                                chmod ($path["tmproot"].$rndfolder."",0777);

                                $newpath = $path["tmproot"].$rndfolder."/".$filename;
                                if (copy($path["storage"].$filename, $newpath))
                                {
                                 //chmod($newpath, 0755); chmod($newpath, 0777);
                                        mysql_query("insert into temp_link (id, date, link, email, progid) values ('', '".time()."', '$newpath', '$email', '$prodid') ") or die(mysql_error());
                                        mail($email, "Your purchased software download link", " Your can download you software here: ".$siteurl."downloads/".$rndfolder."/".$filename." \n\n NOTE: This link is valid for $linklifehours hour(s) \n\n Sincerely yours, $siteurl" , "From: AutomaticEmail<donotreply@donotreply.com>");
                                        $page_valid = false;
                                        $valid["ok"] = true;
                                        session_unregister("paidprogramid");
                                        $paidprogramid="";
                                } else
                                {
                                        echo "An error occured while copiying file";
                                }
                        } else
                                echo "You didnt paid for this program or have already received a link!";
                } else
                {
                        $valid["alsohaslink"] = true;
                }
        } else
        {
                $page_valid = false;
                $valid["mail"] = false;
        }
}
?>
<table width="788" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
    <td bgcolor="#FFFFFF"><form name="form1" method="post" action="">
        <div align="center">
          <p><?if ($prodid){?> <font size="2" face="Verdana, Arial, Helvetica, sans-serif">
            <input name="prodid" type="hidden" id="prodid" value="<? echo $prodid ?>">
            Please enter your e-mail to get file download link<br>
            Your e-mail:
            <input name="email" type="text" id="email">
            <input name="go" type="submit" id="go" value="Get Link"><?}?>
            <? if ($valid["ok"]) { ?>
            <font color="#FF0000"><br>
            Your download link succesfully sent on your email. Thank you for purchasing!</font></font>
            <font size="2" face="Verdana, Arial, Helvetica, sans-serif">
            <? } ?>
            <? if ($valid["alsohaslink"]) { ?>
            <font color="#FF0000"><br>
            Your download link already sent to you. Please contact us if you didn't
            received it. </font></font> <font size="2" face="Verdana, Arial, Helvetica, sans-serif">
            <? } ?>
            </font></p>
        </div>
      </form></td>
  </tr>
</table>
<font size="2" face="Verdana, Arial, Helvetica, sans-serif">
<? include ('footer.php'); ?>
</font>
<p>&nbsp;</p>