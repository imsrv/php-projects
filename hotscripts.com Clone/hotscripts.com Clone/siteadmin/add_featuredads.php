<?
include_once "logincheck.php"; 
include_once "../config.php";
function main()
{
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
          <p><font color="666666" size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>Add 
            Featured Advertisements' Contents:</strong></font></p>
        </div></td>
    </tr>
    <tr> 
      <td height="1" colspan="2" bgcolor="666666"></td>
    </tr>
    <form onsubmit="return Validate(this);" action="insert_featuredads.php" name="form">
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr> 
        <td><strong><font color="#666666" size="2" face="Verdana, Arial, Helvetica, sans-serif">Name:</font></strong></td>
        <td><input name="name_url" type="text" id="name_url" size="36"></td>
      </tr>
      <tr> 
        <td width="122"><strong><font color="#666666" size="2" face="Verdana, Arial, Helvetica, sans-serif">URL:</font></strong></td>
        <td width="278"><input name="url" type="text" size="36"></td>
      </tr>
      <tr> 
        <td><strong><font color="#666666" size="2" face="Verdana, Arial, Helvetica, sans-serif">Description:</font></strong></td>
        <td><textarea name="desc" cols="29"></textarea></td>
      </tr>
      <tr> 
        <td>&nbsp;</td>
        <td><input type="submit" name="Submit" value="Add"></td>
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