<?

include "logincheck.php";
include_once "../config.php";
function main()
{
$rs0=mysql_fetch_array(mysql_query("select * from sbwmd_admin where id=1"));
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
<form action="updateadmin.php" method="post" onSubmit="return Validator();" >
  <table width="539" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#666666">
    <tr> 
      <td width="100%" bgcolor="#666666"><strong><font color="#FFFFFF" size="3" face="Arial, Helvetica, sans-serif">Admin 
        Login </font></strong></td>
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
              <td height="24"> <div align="right"><font color="#666666" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2">Username:</font></strong></font></div></td>
              <td>&nbsp;</td>
              <td> <input cols=35 name="admin_name" type="text" class="box1" id="admin_name" value="<? echo $rs0["admin_name"];?>" size="35" ></td>
            </tr>
            <tr class="row2"> 
              <td height="24"> <div align="right"><font color="#666666" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2">Password 
                  :</font></strong></font></div></td>
              <td>&nbsp;</td>
              <td> <input name="pwd" type="text" class="box1" id="pwd" value="<? echo $rs0["pwd"];?>" size="35" ></td>
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
          <input name="Submit" type="submit" class="submit" value="Update">
        </div></td>
    </tr>
  </table>
</form>

<?
}// end main
include "template.php";?>
