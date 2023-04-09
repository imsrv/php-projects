
<table width="770" border="1" cellspacing="0" cellpadding="0" bordercolor="#999999">
  <tr> 
    <td bgcolor="#FFFFFF" bordercolor="#FFFFFF" align="center" valign="top"> 
      <table width="98%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td><font class="directory">设定内容</font></td>
        </tr>
      </table>
      <form>
        <table width="98%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td height="2" bgcolor="#666666"><img src="../images/spot.gif" width="1" height="1"></td>
          </tr>
          <tr> 
            <td> 
              <table width="100%" border="0" cellspacing="1" cellpadding="0" bgcolor="#CCCCCC">
                <tr> 
                  <th>选择需要备份的表（如不清楚请全部选中）</th>
                </tr>
                <!-- BEGIN table_name -->
                <tr bgcolor="#FFFFFF"> 
                  <td align="center" bgcolor="#FFFFFF"> 
                    <table width="100%" border="0" cellspacing="0" cellpadding="3">
                      <tr> 
                        <td align="right" width="41%"> 
                          <input type="checkbox" name="table_arr[]" value="{table_name}" checked>
                        </td>
                        <td width="59%">{table_name} </td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <!-- END table_name -->
              </table>
            </td>
          </tr>
          <tr> 
            <td height="2" bgcolor="#666666"><img src="../images/spot.gif" width="1" height="1"></td>
          </tr>
        </table>
        <p> 
          <input type="hidden" name="action" value="system_backup">
          <input type="hidden" name="step" value="2">
          <input type="submit" name="Submit" value="  确定  ">
        </p>
      </form>
      <p>&nbsp;</p>
    </td>
  </tr>
</table>
