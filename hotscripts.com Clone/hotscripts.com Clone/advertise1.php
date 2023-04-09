<?
include_once "config.php";
include_once "left_index.php";
include_once "right_index.php";

function main()
{

$rs_a=mysql_query ("select * from sbwmd_config ");
$rs_a=mysql_fetch_array($rs_a);

$sql="select * from sbwmd_plans where id=" . $_POST["plan"];
$rs0_query=mysql_query ($sql);
$rs0=mysql_fetch_array($rs0_query);


$sql1="insert into sbwmd_ads (url,bannerurl,email,credits,displays,approved,paid) Values(" .
" '" . str_replace("'","''",$_POST["url"]) . "',"  .
" '" . str_replace("'","''",$_POST["bannerurl"]) . "',"  .
"'" . str_replace("'","''",$_POST["email"]) . "'," .
" " . $rs0["credits"] . " , " .
"0,'yes' , 'no')";

mysql_query($sql1);

$sql_t="select max(id) from sbwmd_ads ";
$rs_t=mysql_fetch_array(mysql_query ($sql));
$custom=$rs_t[0];

?>

<SCRIPT language=javascript> 
<!--
  function formValidate(form) {
	if ( form.url.value == "" ) {
       	   alert('Website Url is required!');
	   return false;
	   }

        if(!form.email.value.match(/[a-zA-Z\.\@\d\_]/)) {
           alert('Invalid e-mail address.');
           return false;
           }

  
        if(form.bannerurl.value == ""){
	   alert('Banner url is required.');
           return false; 
           }
	return true;
  }
// -->
</SCRIPT>
<table width="95%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td></td>
  </tr>
  <tr> 
    <td height="25"> <a href="index.php"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font color="#000000">HOME</font></strong></font></a> 
      <font color="#000000" size="2" >&gt; ADVERTISE</font>
      <hr size="1"></td>
  </tr>
  <tr> 
    <td> 
      <?
if ( isset($_REQUEST["msg"])&&$_REQUEST['msg']<>"")
{
?>
      <br> <table align="center" bgcolor="#FEFCFC"   border="0" cellpadding="5" >
        <tr> 
          <td><b><font face="verdana, arial" size="1" color="#666666"> 
            <?
print($_REQUEST['msg']); 

?>
            </font></b></td>
        </tr>
      </table>
      <?
}//end if
?>
      <FORM name=register onsubmit=return(formValidate(this)); 
                  method=post action="https://www.paypal.com/cgi-bin/webscr">
        <TABLE width=95% border=0 align="center" cellPadding=1 cellSpacing=1 class="onepxtable">
          <TBODY>
            <TR> 
              <TD height="25" align=left valign="top"><div align="center">You 
                  have decided to buy <? echo  $rs0["credits"]; ?> Impressions 
                  For $<? echo $rs0["price"]; ?></font></div></TD>
            </TR>
            <TR> 
              <TD height="25" align=left valign="top"><div align="center">&nbsp;</font> 
                  <input type="hidden" name="cmd" value="_xclick">
                  <input type="hidden" name="business" value="<?php echo $rs_a["pay_pal"]; ?>">
                  <input type="hidden" name="item_name" value="Purchase (<? echo  $rs0["credits"]; ?> Credits For $<? echo $rs0["price"]; ?> )">
                  <input type="hidden" name="item_number" value="P1">
                  <input type="hidden" name="amount" value="<?php echo $rs0["price"]; ?>">
                  <input type="hidden" name="custom" value="<?php echo $custom ; ?>">
                  <input type="hidden" name="return" value="<?php echo $rs_a["site_root"]; ?>/thanks.php">
                  <input type="hidden" name="cancel_return" value="<?php echo $rs_a["site_root"]; ?>/cancelpurchase.php">
                  <input type="hidden" name="no_note" value="1">
                  <input type="hidden" name="currency_code" value="USD">
                  <input type="hidden" name="rm" value="2">
                  <input type="hidden" name="notify_url" value="<?php echo $rs_a["site_root"]; ?>/ipn.php">
                  <input type="submit" name="Submit" value="Pay through Paypal" class="input">
                  &nbsp; </div></TD>
            </TR>
          </TBODY>
        </TABLE>
      </form></td>
  </tr>
</table>
<?
}// end main
include "template.php";
?>
