
<table width="770" border="1" cellspacing="0" cellpadding="0" bordercolor="#999999">
  <tr> 
    <td bgcolor="#FFFFFF" bordercolor="#FFFFFF" align="center" valign="top"> 
      <table width="98%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td><img src="../images/admin/group.png" width="24" height="22"><font class="directory">会员组</font></td>
        </tr>
        <tr> 
          <td align="right" bordercolor="#99CCCC">[ <a href="#add">添加用户组</a> ]</td>
        </tr>
      </table>
      <table width="98%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td>{list_group}</td>
        </tr>
      </table>
      <table width="98%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td height="2" bgcolor="#666666"><img src="../images/spot.gif" width="1" height="1"></td>
        </tr>
        <tr> 
          <td valign="top"> 
            <table width="100%" border="0" cellspacing="1" cellpadding="0" bgcolor="#CCCCCC">
              <tr> 
                <th width="8%">id</th>
                <th width="8%">允许加入</th>
                <th width="15%">组名</th>
                <th width="40%">简介</th>
                <th width="29%">操作</th>
              </tr>
              <tr bgcolor="#FFFFFF" onMouseOver ="this.style.backgroundColor='#F5F5F5'" onMouseOut ="this.style.backgroundColor='#ffffff'"> 
                <td>1</td>
                <td>--</td>
                <td><img src="../images/admin/group.png" width="24" height="22">游客/未登陆</td>
                <td>登陆会员同样具有该组的属性</td>
                <td>〈--您不能编辑改行</td>
              </tr>
              <tr bgcolor="#FFFFFF" onMouseOver ="this.style.backgroundColor='#F5F5F5'" onMouseOut ="this.style.backgroundColor='#ffffff'"> 
                <td>2</td>
                <td>--</td>
                <td><img src="../images/admin/group.png" width="24" height="22" border="0">普通会员</td>
                <td>所有登陆会员自动获得该组属性</td>
                <td>〈--您不能编辑改行</td>
              </tr>
              <tr bgcolor="#FFFFFF" onMouseOver ="this.style.backgroundColor='#F5F5F5'" onMouseOut ="this.style.backgroundColor='#ffffff'"> 
                <td>3</td>
                <td>--</td>
                <td><img src="../images/admin/group.png" width="24" height="22" border="0">超级管理员</td>
                <td>具有该组属性的会员拥有<b>admin</b>权限</td>
                <td>〈--您不能编辑改行</td>
              </tr>
              <!-- BEGIN list -->
              <tr bgcolor="#FFFFFF" onMouseOver ="this.style.backgroundColor='#F5F5F5'" onMouseOut ="this.style.backgroundColor='#ffffff'"> 
                <td>{group_id}</td>
                <td>{is_reg}</td>
                <td><a href="index.php?action=modify_group&group_id={group_id}"><img src="../images/admin/group.png" width="24" height="22" border="0">{group_name}</a></td>
                <td>{group_intr}</td>
                <td align="center"><a href="index.php?action=del_group&group_id={group_id}"  onClick="return confirm('你确定要删除吗？？？')"><img src="../images/admin/delete.gif" width="27" height="17" border="0"></a>&nbsp;&nbsp;<a href="index.php?action=modify_group&group_id={group_id}"><img src="../images/admin/edit.gif" width="27" height="17" border="0"></a></td>
              </tr>
              <!-- END list -->
            </table>
          </td>
        </tr>
        <tr> 
          <td height="2" bgcolor="#666666"><img src="../images/spot.gif" width="1" height="1"></td>
        </tr>
      </table>
      <table width="98%" border="0" cellspacing="0" cellpadding="0">
        <form name="form1" method="get" action="">
          <tr> 
            <td valign="bottom"> 
              <p>&nbsp;</p>
              <p><a name="add">添加会员组</a>:</p>
            </td>
          </tr>
        </form>
      </table>
      <table width="98%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td height="2" bgcolor="#666666"><img src="../images/spot.gif" width="1" height="1"></td>
        </tr>
        <tr> 
          <td valign="top"> 
            <table width="100%" border="0" cellspacing="1" cellpadding="0" bgcolor="#CCCCCC">
              <form name="form1" method="post" action="index.php">
                <tr> 
                  <th colspan="2">基本信息 </th>
                </tr>
                <tr bgcolor="#FFFFFF"> 
                  <td width="27%" height="26" align="right"><img src="../images/admin/group.png" width="24" height="22">组名称：</td>
                  <td width="73%" height="26"> 
                    <input type="text" name="name" size="50">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF"> 
                  <td width="27%" height="26" align="right">是否允许会员自己加入该组：</td>
                  <td width="73%" height="26"> 
                    <input type="radio" name="is_reg" value="yes">
                    是 &nbsp; 
                    <input type="radio" name="is_reg" value="no" checked>
                    否</td>
                </tr>
                <tr bgcolor="#FFFFFF"> 
                  <td width="27%" height="25" align="right">组介绍：</td>
                  <td width="73%" height="25"> 
                    <textarea name="intr" cols="70" rows="7"></textarea>
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF"> 
                  <td colspan="2" align="center"> 
                    <input type="hidden" name="action" value="add_group">
                    <input type="hidden" name="step" value="2">
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
