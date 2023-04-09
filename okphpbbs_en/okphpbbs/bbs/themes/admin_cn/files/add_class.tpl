
<table width="770" border="1" cellspacing="0" cellpadding="0" bordercolor="#003366">
  <tr> 
    <td bgcolor="#FFFFFF" bordercolor="#FFFFFF" align="center" valign="top"> 
      <table width="98%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td><b>在 </b><font class="directory">{type_name}</font><b> 下建立新类别</b></td>
        </tr>
        <tr> 
          <td align="right" bordercolor="#99CCCC">[ <a href="index.php?action=list_file&type_id=%7Btype_id%7D">返回</a> 
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
                <input type="hidden" name="newsContent" value="">
              </form>
              <form name="form" method="post" action="index.php">
                <tr> 
                  <th colspan="2">基本信息 </th>
                </tr>
                <tr> 
                  <td width="39%" bgcolor="#FFFFFF" align="right">栏目名称：</td>
                  <td width="61%" bgcolor="#FFFFFF"> 
                    <input type="text" name="name" size="30">
                  </td>
                </tr>
                <tr> 
                  <td colspan="2" bgcolor="#FFFFFF" align="center"> 
                    <input type="hidden" name="type_class" value="{type_class}">
                    <input type="hidden" name="action" value="add_file_type">
                    <input type="hidden" name="step" value="2">
                    <input type="hidden" name="belong_id" value="{belong_id}">
                    <input type=submit name="submit" value="  Submit  ">
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
