
<table width="770" border="1" cellspacing="0" cellpadding="0" bordercolor="#999999">
  <tr> 
    <td bgcolor="#FFFFFF" bordercolor="#FFFFFF" align="center" valign="top"> 
      <table width="98%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td><font class="directory">修改</font><b>{user_name}</b>：</td>
        </tr>
        <tr> 
          <td align="right" bordercolor="#99CCCC">[ <a href="{url}">返回</a> ]</td>
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
                  <th colspan="2">基本信息 </th>
                </tr>
                <tr bgcolor="#FFFFFF"> 
                  <td width="27%" height="26" align="right">会员名：</td>
                  <td width="73%" height="26"> 
                    <input type="text" name="username" size="50" value="{username}">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF"> 
                  <td width="27%" height="26" align="right">新密码（留空为不更改）：</td>
                  <td width="73%" height="26"> 
                    <input type="password" name="password" size="50">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF"> 
                  <td width="27%" height="26" align="right">头衔：</td>
                  <td width="73%" height="26"> 
                    <input type="text" name="honor" size="50" value="{honor}">
                  </td>
                </tr>
				<tr bgcolor="#FFFFFF"> 
                  <td width="27%" height="26" align="right">电子邮件：</td>
                  <td width="73%" height="26"> 
                    <input type="text" name="email" size="50" value="{email}">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF"> 
                  <td width="27%" height="26" align="right">积分：</td>
                  <td width="73%" height="26"> 
                    <input type="text" name="score" size="50" value="{score}">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF"> 
                  <td width="27%" height="26" align="right">加入成员组：</td>
                  <td width="73%" height="26"> {group_list}</td>
                </tr>
                <tr bgcolor="#FFFFFF"> 
                  <td width="27%" height="25" align="right">会员介绍：</td>
                  <td width="73%" height="25"> 
                    <textarea name="intr" cols="70" rows="7">{intr}</textarea>
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF"> 
                  <td width="27%" height="25" align="right">隐藏信息（会员无法自己看到或修改该项）：</td>
                  <td width="73%" height="25"> 
                    <textarea name="hidden_info" cols="70" rows="7">{hidden_info}</textarea>
                  </td>
                </tr>
		 <tr bgcolor="#FFFFFF"> 
                  <td width="27%" height="26" align="right">是否禁止该会员访问：</td>
                  <td width="73%" height="26"> 
                    <input type="text" name="banned" size="5" value="{banned}">
                    （1:是， 0:否）</td>
                </tr>
                <tr bgcolor="#FFFFFF"> 
                  <td colspan="2" align="center"> 
                    <input type="hidden" name="url" value="{url}">
                    <input type="hidden" name="action" value="modify_user">
                    <input type="hidden" name="step" value="2">
                    <input type="hidden" name="group_id" value="{group_id}">
                    <input type="hidden" name="user_id" value="{user_id}">
                    <input type="submit" name="Submit" value="  修改  ">
                    <input type="reset" name="Submit2" value="  清除  ">
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
