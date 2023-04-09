<?
include_once "logincheck.php"; 
include_once "../config.php";
function main()
{

$id=$_REQUEST["id"];
$rs0=mysql_fetch_array(mysql_query("select * from sbwmd_featuredads where id=$id"));
?>
<script language="javascript">
   	  function Validate(form) {
         if(form.url.value == "") {
            alert('Please enter URL.');
            return false;
         }
         if(form.desc.value == "") {
            alert('Please enter description!');
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
            Featured Advertisements' Contents:</strong></font></p>
        </div></td>
    </tr>
    <tr> 
      <td height="1" colspan="2" bgcolor="666666"></td>
    </tr>
    <form onsubmit="return Validate(this);" action="update_featuredads.php" name="form">
      <input type="hidden"  name="id" value="<? echo $_REQUEST["id"]?>">
      <input type="hidden"  name="pg" value="<? echo $_REQUEST["pg"]?>">
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr> 
        <td><strong><font color="#666666" size="2" face="Verdana, Arial, Helvetica, sans-serif">Name:</font></strong></td>
        <td><input name="name_url" type="text" size="36" value="<? echo $rs0["name_url"];?>"></td>
      </tr>
      <tr> 
        <td width="122"><strong><font color="#666666" size="2" face="Verdana, Arial, Helvetica, sans-serif">URL:</font></strong></td>
        <td width="278"><input name="url" type="text" size="36" value="<? echo $rs0["url"];?>"></td>
      </tr>
      <tr> 
        <td><strong><font color="#666666" size="2" face="Verdana, Arial, Helvetica, sans-serif">Description:</font></strong></td>
        <td><textarea name="desc" cols="29"><? echo $rs0["fd_desc"];?></textarea></td>
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