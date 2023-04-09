<?
include_once "logincheck.php"; 
include_once "../config.php";
function main()
{

$id=$_REQUEST["id"];
$rs0=mysql_fetch_array(mysql_query("select * from sbwmd_sideads where id=$id"));
?>
<script language="javascript">
   	  function Validate(form) {
         if(form.url.value == "") {
            alert('Please enter URL.');
            return false;
         }
         if(form.linktext.value == "") {
            alert('Please enter Link Text!');
            return false;
         }
         
         return true;
      }
   </script>
<div align="center">
  <table width="400" border="0" cellspacing="0" cellpadding="0">
    <tr> 
      <td colspan=2><div align="left"> 
          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <p><font color="666666" size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>Edit 
            Sponsered Advertisements' Contents:</strong></font></p>
        </div></td>
    </tr>
    <tr> 
      <td height="1" colspan="2" bgcolor="666666"></td>
    </tr>
    <form onsubmit="return Validate(this);" action="update_sponsered.php" name="form">
      <input type="hidden"  name="id" value="<? echo $_REQUEST["id"]?>">
      <input type="hidden"  name="pg" value="<? echo $_REQUEST["pg"]?>">
      <tr> 
        <td width="122"><strong><font color="#666666" size="2" face="Verdana, Arial, Helvetica, sans-serif">URL:</font></strong></td>
        <td width="278"><font size="2" face="Arial, Helvetica, sans-serif">http://</font> 
          <input name="url" type="text" size="36" value="<? echo $rs0["url"];?>"></td>
      </tr>
      <tr> 
        <td><strong><font color="#666666" size="2" face="Verdana, Arial, Helvetica, sans-serif">URL 
          Text:</font></strong></td>
        <td><input name="linktext" type="text" value="<? echo $rs0["linktext"];?>" size="36"></td>
      </tr>
      <tr> 
        <td>&nbsp;</td>
        <td><input type="submit" name="Submit" value="Update"></td>
      </tr>
    </form>
    <tr> 
      <td height="1" colspan="2" bgcolor="666666"></td>
    </tr>
  </table>

</div>
<?
}// end main
include "template.php";
?>