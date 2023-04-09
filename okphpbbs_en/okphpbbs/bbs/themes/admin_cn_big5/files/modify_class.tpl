
<table width="770" border="1" cellspacing="0" cellpadding="0" bordercolor="#003366">
  <tr> 
    <td bgcolor="#FFFFFF" bordercolor="#FFFFFF" align="center" valign="top"> 
      <table width="98%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td><b>修改 </b><font class="directory">{type_name}</font><b> 的屬性</b></td>
        </tr>
        <tr> 
          <td align="right" bordercolor="#99CCCC">[ <a href="index.php?action=list_file&type_id={back_id}">返回</a> 
            ] </td>
        </tr>
      </table>
      <table width="98%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td height="2" bgcolor="#666666"><img src="../images/spot.gif" width="1" height="1"></td>
        </tr>
        <tr> 
          <td> 
            <table width="100%" border="0" cellspacing="1" cellpadding="0" bgcolor="#CCCCCC">
              <form>
                <input type="hidden" name="newsContent" value="{body}">
              </form>
              <form name="form" method="post" action="index.php">
                <tr> 
                  <th colspan="2">基本信息 </th>
                </tr>
                <tr> 
                  <td width="40%" bgcolor="#FFFFFF">類別名稱：</td>
                  <td width="60%" bgcolor="#FFFFFF"> 
                    <input type="text" name="name" size="30" value="{type_name}">
                  </td>
                </tr>
                <tr align="center"> 
                  <td colspan="2" bgcolor="#FFFFFF"> 
                    <p>&nbsp;</p>
                    <p> 
                      <input type="hidden" name="type_class" value="{type_class}">
                      <input type="hidden" name="action" value="modify_file_type">
                      <input type="hidden" name="step" value="2">
                      <input type="hidden" name="type_id" value="{type_id}">
                      <input type=submit name="submit" value="Submit">
                    </p>
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
