
<table width="770" border="1" cellspacing="0" cellpadding="0" bordercolor="#003366">
  <tr> 
    <td bgcolor="#FFFFFF" bordercolor="#FFFFFF" valign="top"> 
      <table width="98%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td><img src="../images/admin/folder_open.png" width="24" height="22"><font class="directory">{directory}</font></td>
        </tr>
        <tr> 
          <td align="right" bordercolor="#99CCCC"> {add_class} {add_type}</td>
        </tr>
      </table>
         
      &nbsp;&nbsp;&nbsp;
<center>
        <table width="98%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td height="2" bgcolor="#666666"><img src="../images/spot.gif" width="1" height="1"></td>
          </tr>
          <tr> 
            <td> 
              <table width="100%" border="0" cellspacing="1" cellpadding="0" bgcolor="#CCCCCC" bordercolor="#CCCCCC">
                <tr> 
                  <th width="9%" bgcolor="#EBEBEB">id</th>
                  <th width="27%" bgcolor="#EBEBEB">名稱</th>
                  <th width="20%" bgcolor="#EBEBEB">帖子總數</th>
                  <th width="14%" bgcolor="#EBEBEB">管理員</th>
                  <th width="30%" align="center" bgcolor="#EBEBEB">操作</th>
                </tr>
                <!-- BEGIN type -->
                <tr bgcolor="#FFFFFF" onMouseOver ="this.style.backgroundColor='#F5F5F5'" onMouseOut ="this.style.backgroundColor='#ffffff'"> 
                  <td width="9%" height="15"><font color="#990000">{id}</font></td>
                  <td width="27%" height="15">&nbsp;<a href="?action=modify_file_type&type_id={id}"><font color="#990000"><img src="../images/admin/folder.png" width="24" height="22" border="0"></font>{name}</a></td>
                  <td width="20%" height="15"> &nbsp;{file_num} </td>
                  <td width="14%" height="15">&nbsp;{moderator} </td>
                  <td width="30%" height="15" align="center"> <a href="index.php?action=del_file_type&type_id={id}"  onClick="return confirm('Are you sure??')"><img src="../images/admin/delete.gif" width="27" height="17" border="0"></a>&nbsp;&nbsp;<a href="index.php?action=modify_file_type&type_id={id}"><img src="../images/admin/edit.gif" width="27" height="17" border="0"></a>&nbsp;&nbsp;<a href="index.php?action=move_type&back_id={back_id}&type_id={id}&order_num={order_num}&move=down"><img src="../images/admin/down.gif" width="27" height="17" border="0"></a>&nbsp;&nbsp;<a href="index.php?action=move_type&back_id={back_id}&type_id={id}&order_num={order_num}&move=up"> 
                    <img src="../images/admin/up.gif" width="27" height="17" border="0"></a></td>
                </tr>
                <!-- END type -->
              </table>
            </td>
          </tr>
          <tr> 
            <td height="2" bgcolor="#666666"><img src="../images/spot.gif" width="1" height="1"></td>
          </tr>
        </table>
      </center>
    </td>
  </tr>
  <tr> 
    <td bgcolor="#FFFFFF" bordercolor="#FFFFFF" align="center"> 
      <table width="98%" border="0" cellspacing="0" cellpadding="0">
        <form name="form1" method="get" action="">
          <tr> 
            <td bordercolor="#FFFFFF" bgcolor="#FFFFFF">&nbsp; </td>
          </tr>
        </form>
      </table>
      <p>&nbsp;</p>
    </td>
  </tr>
</table>
