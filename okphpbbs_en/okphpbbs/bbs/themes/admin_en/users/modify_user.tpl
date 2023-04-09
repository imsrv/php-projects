
<table width="770" border="1" cellspacing="0" cellpadding="0" bordercolor="#999999">
  <tr> 
    <td bgcolor="#FFFFFF" bordercolor="#FFFFFF" align="center" valign="top"> 
      <table width="98%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td><b>Modify </b><font class="directory">{user_name}</font></td>
        </tr>
        <tr> 
          <td align="right" bordercolor="#99CCCC">[ <a href="{url}">Go Back</a> 
            ]</td>
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
                  <td width="27%" height="26" align="right">UserName:</td>
                  <td width="73%" height="26"> 
                    <input type="text" name="username" size="50" value="{username}">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF"> 
                  <td width="27%" height="26" align="right">New PassWord:</td>
                  <td width="73%" height="26"> 
                    <input type="password" name="password" size="50">
                  </td>
                </tr>
				<tr bgcolor="#FFFFFF"> 
                  <td width="27%" height="26" align="right">Honor:</td>
                  <td width="73%" height="26"> 
                    <input type="text" name="honor" size="50" value="{honor}">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF"> 
                  <td width="27%" height="26" align="right">E-mail:</td>
                  <td width="73%" height="26"> 
                    <input type="text" name="email" size="50" value="{email}">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF"> 
                  <td width="27%" height="26" align="right">Score:</td>
                  <td width="73%" height="26"> 
                    <input type="text" name="score" size="50" value="{score}">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF"> 
                  <td width="27%" height="26" align="right">Groups:</td>
                  <td width="73%" height="26"> {group_list}</td>
                </tr>
                <tr bgcolor="#FFFFFF"> 
                  <td width="27%" height="25" align="right">Brief:</td>
                  <td width="73%" height="25"> 
                    <textarea name="intr" cols="70" rows="7">{intr}</textarea>
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF"> 
                  <td width="27%" height="25" align="right">Hidden Info:<br>
                    (Members cannot see it him/herself)</td>
                  <td width="73%" height="25"> 
                    <textarea name="hidden_info" cols="70" rows="7">{hidden_info}</textarea>
                  </td>
                </tr>
		<tr bgcolor="#FFFFFF"> 
                  <td width="27%" height="26" align="right">Ban this member?<br>(1:Yes, 0:No)</td>
                  <td width="73%" height="26"> 
                    <input type="text" name="banned" size="50" value="{banned}">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF"> 
                  <td colspan="2" align="center"> 
                    <input type="hidden" name="url" value="{url}">
                    <input type="hidden" name="action" value="modify_user">
                    <input type="hidden" name="step" value="2">
                    <input type="hidden" name="group_id" value="{group_id}">
                    <input type="hidden" name="user_id" value="{user_id}">
                    <input type="submit" name="Submit" value=" Modify ">
                    <input type="reset" name="Submit2" value=" Reset ">
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
