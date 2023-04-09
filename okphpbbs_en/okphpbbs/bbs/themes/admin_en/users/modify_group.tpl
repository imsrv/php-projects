
<table width="770" border="1" cellspacing="0" cellpadding="0" bordercolor="#999999">
  <tr> 
    <td bgcolor="#FFFFFF" bordercolor="#FFFFFF" align="center" valign="top"> 
      <table width="98%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td><b>Modify </b><font class="directory">{group_name}</font></td>
        </tr>
        <tr> 
          <td align="right" bordercolor="#99CCCC">[ <a href="?action=add_group">Go 
            Back </a> ]</td>
        </tr>
      </table>
      <table width="98%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td>&nbsp;</td>
        </tr>
      </table>
      <table width="98%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td height="2" bgcolor="#666666"><img src="../images/spot.gif" width="1" height="1"></td>
        </tr>
        <tr> 
          <td valign="top"> 
            <table width="100%" border="0" cellspacing="1" cellpadding="0" bgcolor="#CCCCCC">
              <form name="form1" method="post" action="index.php" enctype="multipart/form-data">
                <tr> 
                  <th colspan="2">Basic</th>
                </tr>
                <tr bgcolor="#FFFFFF"> 
                  <td width="27%" height="26" align="right">Group Name:</td>
                  <td width="73%" height="26"> 
                    <input type="text" name="group_name" size="50" value="{group_name}">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF"> 
                  <td width="27%" height="26" align="right">Allow Join?</td>
                  <td width="73%" height="26"> 
                    <input type="radio" name="is_reg" value="yes" {is_reg}>
                    <font color="#006600">Yes</font>, 
                    <input type="radio" name="is_reg" value="no" {no_reg}>
                    <font color="#FF0000">No </font></td>
                </tr>
                <tr bgcolor="#FFFFFF"> 
                  <td width="27%" height="25" align="right">Brief:</td>
                  <td width="73%" height="25"> 
                    <textarea name="group_intr" cols="70" rows="7">{group_intr}</textarea>
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF"> 
                  <td colspan="2" align="center"> 
                    <input type="hidden" name="action" value="modify_group">
                    <input type="hidden" name="step" value="2">
                    <input type="hidden" name="group_id" value="{group_id}">
                    <input type="submit" name="Submit" value="Submit">
                    <input type="reset" name="Submit2" value="Reset">
                  </td>
                </tr>
              </form>
            </table>
          </td>
        </tr>
        <tr> 
          <td height="2" bgcolor="#666666"><img src="../images/spot.gif" width="1" height="1"></td>
        </tr>
      </table>
      <p>&nbsp;</p>
    </td>
  </tr>
</table>
<p>&nbsp;</p>
