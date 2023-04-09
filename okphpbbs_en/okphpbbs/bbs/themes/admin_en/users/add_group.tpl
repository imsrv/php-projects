
<table width="770" border="1" cellspacing="0" cellpadding="0" bordercolor="#999999">
  <tr> 
    <td bgcolor="#FFFFFF" bordercolor="#FFFFFF" align="center" valign="top"> 
      <table width="98%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td><img src="../images/admin/group.png" width="24" height="22"><font class="directory">Group</font></td>
        </tr>
        <tr> 
          <td align="right" bordercolor="#99CCCC">[ <a href="#add">Add Group</a> 
            ]</td>
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
                <th width="9%">id</th>
                <th width="8%">Allow Join</th>
                <th width="19%">Group Name</th>
                <th width="42%">Brief</th>
                <th width="22%">Opration</th>
              </tr>
              <tr bgcolor="#FFFFFF" onMouseOver ="this.style.backgroundColor='#F5F5F5'" onMouseOut ="this.style.backgroundColor='#ffffff'"> 
                <td width="9%">1</td>
                <td width="8%" align="center">-</td>
                <td width="19%"><img src="../images/admin/group.png" width="24" height="22">Guest/Not 
                  login </td>
                <td width="42%">Members also have the authority of this Group.</td>
                <td align="center" width="22%">-</td>
              </tr>
              <tr bgcolor="#FFFFFF" onMouseOver ="this.style.backgroundColor='#F5F5F5'" onMouseOut ="this.style.backgroundColor='#ffffff'"> 
                <td width="9%">2</td>
                <td width="8%" align="center">-</td>
                <td width="19%"><img src="../images/admin/group.png" width="24" height="22" border="0">Normal 
                  Members </td>
                <td width="42%">All members</td>
                <td align="center" width="22%">-</td>
              </tr>
              <tr bgcolor="#FFFFFF" onMouseOver ="this.style.backgroundColor='#F5F5F5'" onMouseOut ="this.style.backgroundColor='#ffffff'"> 
                <td width="9%">3</td>
                <td width="8%" align="center">-</td>
                <td width="19%"><img src="../images/admin/group.png" width="24" height="22" border="0">Super 
                  Adminstor</td>
                <td width="42%">Has the authority of ADMIN</td>
                <td align="center" width="22%">-</td>
              </tr>
              <!-- BEGIN list -->
              <tr bgcolor="#FFFFFF" onMouseOver ="this.style.backgroundColor='#F5F5F5'" onMouseOut ="this.style.backgroundColor='#ffffff'"> 
                <td width="9%">{group_id}</td>
                <td width="8%" align="center">{is_reg}</td>
                <td width="19%"><a href="index.php?action=modify_group&group_id={group_id}"><img src="../images/admin/group.png" width="24" height="22" border="0">{group_name}</a></td>
                <td width="42%">{group_intr}</td>
                <td align="center" width="22%"><a href="index.php?action=del_group&group_id={group_id}"  onClick="return confirm('Are you sure to delete this Group? ')"><img src="../images/admin/delete.gif" width="27" height="17" border="0"></a>&nbsp;&nbsp;<a href="index.php?action=modify_group&group_id={group_id}"><img src="../images/admin/edit.gif" width="27" height="17" border="0"></a></td>
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
            <td valign="bottom" height="47"> 
              <p>&nbsp;</p>
              <p><a name="add">Add Group:</a></p>
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
                  <th colspan="2">Basic</th>
                </tr>
                <tr bgcolor="#FFFFFF"> 
                  <td width="27%" height="26" align="right"><img src="../images/admin/group.png" width="24" height="22">Group 
                    Name:</td>
                  <td width="73%" height="26"> 
                    <input type="text" name="name" size="50">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF"> 
                  <td width="27%" height="26" align="right">Allow Join?</td>
                  <td width="73%" height="26"> 
                    <input type="radio" name="is_reg" value="yes">
                    <font color="#006600">Yes</font>,&nbsp; 
                    <input type="radio" name="is_reg" value="no" checked>
                    <font color="#FF0000"> No</font></td>
                </tr>
                <tr bgcolor="#FFFFFF"> 
                  <td width="27%" height="25" align="right">Brief:</td>
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
