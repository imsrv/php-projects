
<table width="770" border="1" cellspacing="0" cellpadding="0" bordercolor="#999999">
  <tr> 
    <td bgcolor="#FFFFFF" bordercolor="#FFFFFF" align="center" valign="top"> 
      <table width="98%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td><img src="../images/admin/user.png" width="24" height="22"><font class="directory">會員管理</font></td>
        </tr>
        <tr> 
          <td align="right" bordercolor="#99CCCC"> [ <a href="?action=add_user">添加會員</a>]</td>
        </tr>
      </table>
      <!-- BEGIN find_user -->
      <table width="98%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td height="2" bgcolor="#666666"><img src="../images/spot.gif" width="1" height="1"></td>
        </tr>
        <tr> 
          <td> 
            <table width="100%" border="0" cellspacing="1" cellpadding="0" bgcolor="#CCCCCC">
              <form name="form1" method="post" action="index.php" enctype="multipart/form-data">
                <tr> 
                  <th colspan="3">查詢條件</th>
                </tr>
                <tr bgcolor="#FFFFFF"> 
                  <td width="16%" height="26" align="right">會員名：</td>
                  <td width="28%" height="26" bgcolor="#FAFAFA"> 
                    <input type="radio" name="radio_uname" value="1">
                    1、不限制<br>
                    <input type="radio" name="radio_uname" value="2">
                    2、模糊查詢 <br>
                    <input type="radio" name="radio_uname" value="3" checked>
                    3、精確匹配</td>
                  <td width="56%" height="26"> 
                    <input type="text" name="uname" size="20">
                    （例：username）</td>
                </tr>
                <tr bgcolor="#FFFFFF"> 
                  <td width="16%" height="26" align="right">所屬會員組：</td>
                  <td width="28%" height="26" bgcolor="#FAFAFA"> 
                    <input type="radio" name="radio_group" value="1" checked>
                    1、不限制，<br>
                    <input type="radio" name="radio_group" value="2">
                    2、列出所選組成員， <br>
                    <input type="checkbox" name="check_group" value="checkbox">
                    反選（僅當選擇2時有效）</td>
                  <td width="56%" height="26"> {group_list}</td>
                </tr>
                <tr bgcolor="#FFFFFF"> 
                  <td width="16%" height="26" align="right">已經註冊的天數：</td>
                  <td width="28%" height="26" bgcolor="#FAFAFA"> 『0』表示不限制</td>
                  <td width="56%" height="26"> 最短 
                    <input type="text" name="rtime_from" size="10" value="0">
                    天，最長 
                    <input type="text" name="rtime_to" size="10" value="0">
                    天</td>
                </tr>
                <tr bgcolor="#FFFFFF"> 
                  <td width="16%" height="25" align="right">積分：</td>
                  <td width="28%" height="25" bgcolor="#FAFAFA"> 『0』表示不限制</td>
                  <td width="56%" height="25"> 從 
                    <input type="text" name="score_from" size="10" value="0">
                    分到 
                    <input type="text" name="score_to" size="10" value="0">
                    分（例：100 到 300）</td>
                </tr>
                <tr bgcolor="#FFFFFF"> 
                  <td colspan="3" align="center"> 
                    <input type="hidden" name="action" value="find_user">
                    <input type="hidden" name="step" value="2">
                    <input type="submit" name="Submit" value=" 確定 ">
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
      <!-- END find_user -->
      <!-- BEGIN user_list -->
      <b>{find_num} </b> 
      <table width="98%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td height="2" bgcolor="#666666"><img src="../images/spot.gif" width="1" height="1"></td>
        </tr>
        <tr> 
          <td valign="top"> 
            <table width="100%" border="0" cellspacing="1" cellpadding="0" bgcolor="#CCCCCC">
              <form action="index.php" name="itemslist">
                <tr> 
                  <th>Id</th>
                  <th>用戶名</th>
                  <th>電子郵件</th>
                  <th>註冊時間</th>
                  <th>操作</th>
                </tr>
                <!-- BEGIN list -->
                <tr  bgcolor="#FFFFFF" onMouseOver ="this.style.backgroundColor='#F5F5F5'" onMouseOut ="this.style.backgroundColor='#ffffff'"> 
                  <td> 
                    <input type="checkbox" name="user_id[]" value="{user_id}">
                    {user_id} </td>
                  <td>&nbsp;<img src="../images/admin/user.png" width="24" height="22">{user_name}</td>
                  <td>&nbsp;{user_email}</td>
                  <td>&nbsp;{reg_time}</td>
                  <td align="center"><a href="index.php?action=del_user&user_id={user_id}&group_id={group_id}"  onClick="return confirm('你確定要刪除嗎？？？')"><img src="../images/admin/delete.gif" width="27" height="17" border="0"></a>&nbsp;&nbsp;<a href="index.php?action=modify_user&user_id={user_id}"><img src="../images/admin/edit.gif" width="27" height="17" border="0"></a></td>
                </tr>
                <!-- END list -->
                <tr bgcolor="#FFFFFF"> 
                  <td colspan="5"><img src="../images/admin/003.gif" width="38" height="22"> 
                    <input type="radio" name="batch" value="del" checked>
                    刪除 
                    <input type="submit" name="Submit4" value="Submit">
                    <input type="hidden" name="action" value="del_user">
                    <input type="hidden" name="group_id" value="{group_id}">
                    [ <a href="#" onClick="CheckAll();">全部</a> ]</td>
                </tr>
              </form>
            </table>
          </td>
        </tr>
        <tr> 
          <td height="2" bgcolor="#666666"><img src="../images/spot.gif" width="1" height="1"></td>
        </tr>
      </table>
      <!-- BEGIN cutpage -->
      <table border="0" cellspacing="0" cellpadding="0" width="100%">
        <form name="form1" method="get" action="">
          <tr> 
            <td valign="bottom" align="center"> {cutpage} &nbsp; &nbsp; {page_info} 
              &nbsp;{page_jump} 
              <input type="text" name="page" size="6">
              {get} 
              <input type="submit" name="submit" value=" &gt;&gt; " class="catbutton">
            </td>
          </tr>
        </form>
      </table>
      <!-- END cutpage -->
      <p> 
        <!-- END user_list -->
      </p>
    </td>
  </tr>
</table>
