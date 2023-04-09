<?

include "logincheck.php";
include_once "../config.php";
function main()
{
$rs0=mysql_fetch_array(mysql_query("select * from sbwmd_config"));
?>
<script language="JavaScript1.1">
function Validator()
{
return (true);
}

</script>
<?
if ( isset($_REQUEST["msg"])&&$_REQUEST['msg']<>"")
{
?>
<br>
<table align="center" bgcolor="#FEFCFC"   border="0" cellpadding="5" >
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
<br>
<form action="updateconfig.php" method="post" name="frm1" id="frm1"  onSubmit="return Validator();" >
  <table width="539" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#666666">
    <tr> 
      <td width="100%" bgcolor="#666666"><strong><font color="#FFFFFF" size="3" face="Arial, Helvetica, sans-serif">Configure 
        Site Parameters</font></strong></td>
    </tr>
    <tr> 
      <td> <div align="center"> 
          <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr class="row1"> 
              <td> <div align="right"><font color="#666666" face="Verdana, Arial, Helvetica, sans-serif"><strong></strong></font></div></td>
              <td>&nbsp;</td>
              <td> <font color="#666666" face="Verdana, Arial, Helvetica, sans-serif"><strong> 
                </strong></font></td>
            </tr>
            <tr class="row2"> 
              <td height="24"><div align="right"><font color="#666666" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2">Records 
                  Per Page:</font></strong></font></div></td>
              <td>&nbsp;</td>
              <td><select name="rec" id="select5">
                  <?
				 for ($i=1; $i<=50; $i++)
				 {
				 ?>
                  <option value="<? echo $i;?>"
				  <?
				  if ($rs0["recperpage"]==$i)
				  echo " selected ";
				  ?>
				  ><? echo $i; ?></option>
                  <?
				 }// for
				 ?>
                </select></td>
            </tr>
            <tr class="row2"> 
              <td height="24"><div align="right"><font color="#666666" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2">Min. 
                  UserName Length:</font></strong></font></div></td>
              <td>&nbsp;</td>
              <td><select name="username_len" id="select4">
                  <?
				 for ($i=1; $i<=10; $i++)
				 {
				 ?>
                  <option value="<? echo $i;?>"
				  <?
				  if ($rs0["username_len"]==$i)
				  echo " selected ";
				  ?>
				  ><? echo $i; ?></option>
                  <?
				 }// for
				 ?>
                </select></td>
            </tr>
            <tr class="row2"> 
              <td height="24"><div align="right"><font color="#666666" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2">Min. 
                  P</font><font size="2">assword Length:</font></strong></font></div></td>
              <td>&nbsp;</td>
              <td><select name="pwd_len" id="select6">
                  <?
				 for ($i=1; $i<=10; $i++)
				 {
				 ?>
                  <option value="<? echo $i;?>"
				  <?
				  if ($rs0["pwd_len"]==$i)
				  echo " selected ";
				  ?>
				  ><? echo $i; ?></option>
                  <?
				 }// for
				 ?>
                </select></td>
            </tr>
            <tr class="row2"> 
              <td height="24"><div align="right"><font color="#666666" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2">No. 
                  of Friends allowed:</font></strong></font></div></td>
              <td>&nbsp;</td>
              <td><font color="#666666" face="Verdana, Arial, Helvetica, sans-serif"><strong> 
                <select name="no_of_friends" id="select3">
                  <?
				 for ($i=1; $i<=10; $i++)
				 {
				 ?>
                  <option value="<? echo $i;?>"
				  <?
				  if ($rs0["no_of_friends"]==$i)
				  echo " selected ";
				  ?>
				  ><? echo $i; ?></option>
                  <?
				 }// for
				 ?>
                </select>
                </strong></font></td>
            </tr>
            <tr class="row2"> 
              <td height="24"><div align="right"><font color="#666666" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2">Records 
                  in Side Panel:</font></strong></font></div></td>
              <td>&nbsp;</td>
              <td><select name="recinpanel" id="select2">
                  <?
				 for ($i=1; $i<=50; $i++)
				 {
				 ?>
                  <option value="<? echo $i;?>"
				  <?
				  if ($rs0["recinpanel"]==$i)
				  echo " selected ";
				  ?>
				  ><? echo $i; ?></option>
                  <?
				 }// for
				 ?>
                </select></td>
            </tr>
            <tr class="row2"> 
              <td height="24"> <div align="right"><font color="#666666" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2">Null 
                  char:</font></strong></font></div></td>
              <td>&nbsp;</td>
              <td> <input cols=35 name="null_char" type="text" class="box1" id="newpassword" value="<? echo $rs0["null_char"];?>" size="35" ></td>
            </tr>
            <tr class="row2"> 
              <td height="24"> <div align="right"><font color="#666666" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2">Admin 
                  Email :</font></strong></font></div></td>
              <td>&nbsp;</td>
              <td> <input name="adminemail" type="text" class="box1" id="newpassword" value="<? echo $rs0["admin_email"];?>" size="35" ></td>
            </tr>
            <tr class="row1"> 
              <td><div align="right"><font color="#666666" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2">Website 
                  Name :</font></strong></font></div></td>
              <td>&nbsp;</td>
              <td><input name="sitename" type="text" class="box1" id="retypepassword2" value="<? echo $rs0["site_name"];?>" size="35"></td>
            </tr>
            <tr class="row1"> 
              <td><div align="right"><font color="#666666" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2">Website 
                  Address :</font></strong></font></div></td>
              <td>&nbsp;</td>
              <td> <input name="siteaddrs" type="text" class="box1" id="retypepassword" value="<? echo $rs0["site_addrs"];?>" size="35"></td>
            </tr>
            <tr class="row1"> 
              <td><div align="right"><font color="#666666" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2">Paypal 
                  ID :</font></strong></font></div></td>
              <td>&nbsp;</td>
              <td> <input name="pay_pal" type="text" class="box1" id="retypepassword" value="<? echo $rs0["pay_pal"];?>" size="35"></td>
            </tr>
            <tr class="row1"> 
              <td><div align="right"><font color="#666666" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2">Agreement:</font></strong></font></div></td>
              <td>&nbsp;</td>
              <td> <textarea name="agreement" cols="35" rows="5" class="box1" id="retypepassword"><? echo $rs0["agreement"];?></textarea></td>
            </tr>
            <tr class="row1"> 
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr class="row1"> 
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr class="row1"> 
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr class="row1"> 
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
          </table>
        </div></td>
    </tr>
  </table>
  <table width="400" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr> 
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td><div align="center"> 
          <input name="Submit" type="submit" class="submit" value="Update Configuration">
        </div></td>
    </tr>
  </table>
</form>

<?
}// end main
include "template.php";?>
