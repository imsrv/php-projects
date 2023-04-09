
<table width="770" border="1" cellspacing="0" cellpadding="0" bordercolor="#999999">
  <tr> 
    <td bgcolor="#FFFFFF" bordercolor="#FFFFFF" align="center" valign="top"> 
      <table width="98%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td><img src="../images/admin/group.png" width="24" height="22"><font class="directory">Add 
            User </font> </td>
        </tr>
        <tr> 
          <td align="right" bordercolor="#99CCCC">[ <a href="{url}">Go Back</a> 
            ]</td>
        </tr>
      </table>
      <table width="98%" border="0" cellspacing="0" cellpadding="0">
        <form name="form1" method="get" action="">
          <tr> 
            <td valign="bottom">&nbsp; </td>
          </tr>
        </form>
      </table>
      <table width="98%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td height="2" bgcolor="#666666"><img src="../images/spot.gif" width="1" height="1"></td>
        </tr>
        <tr> 
          <td> 
            <table width="100%" border="0" cellspacing="1" cellpadding="3" bgcolor="#CCCCCC">
              <form name="form1" method="post" action="index.php" enctype="multipart/form-data">
                <tr> 
                  <th colspan="2">Basic</th>
                </tr>
                <tr bgcolor="#FFFFFF"> 
                  <td width="27%" height="26" align="right">UserName</td>
                  <td width="73%" height="26"> 
                    <input type="text" name="username" size="30">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF"> 
                  <td width="27%" height="26" align="right">PassWord</td>
                  <td width="73%" height="26"> 
                    <input type="password" name="password" size="30">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF"> 
                  <td width="27%" height="26" align="right">E-mail:</td>
                  <td width="73%" height="26"> 
                    <input type="text" name="email" size="30">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF"> 
                  <td width="27%" height="26" align="right">Groups:</td>
                  <td width="73%" height="26"> {group_list}</td>
                </tr>
                <tr bgcolor="#FFFFFF"> 
                  <td width="27%" height="25" align="right">Brief:</td>
                  <td width="73%" height="25"> 
                    <textarea name="intr" cols="70" rows="7"></textarea>
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF"> 
                  <td width="27%" height="25" align="right">Hidden Info:<br>
                    (Members cannot see it him/herself)</td>
                  <td width="73%" height="25"> 
                    <textarea name="hidden_info" cols="70" rows="7"></textarea>
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF"> 
                  <td colspan="2" align="center"> 
                    <input type="hidden" name="url" value="{url}">
                    <input type="hidden" name="action" value="add_user">
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
