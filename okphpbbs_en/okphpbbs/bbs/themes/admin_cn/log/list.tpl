
<table width="770" border="1" cellspacing="0" cellpadding="0" bordercolor="#999999">
  <tr> 
    <td bgcolor="#FFFFFF" bordercolor="#FFFFFF" align="center" valign="top"> 
      <table width="98%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td><font class="directory">安全日志</font></td>
        </tr>
        <tr> 
          <td align="right" bordercolor="#99CCCC">&nbsp;</td>
        </tr>
      </table>
      <table width="98%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td height="2" bgcolor="#666666"><img src="../images/spot.gif" width="1" height="1"></td>
        </tr>
        <tr> 
          <td> 
            <table width="100%" border="0" cellspacing="1" cellpadding="0" bgcolor="#CCCCCC">
              <form action="index.php" method="post" name="itemslist">
                <tr> 
                  <th width="4%">&nbsp;</th>
                  <th width="9%">操作者</th>
                  <th width="13%">操作者IP</th>
                  <th width="25%"> 操作内容</th>
                  <th width="8%">操作结果</th>
                  <th width="23%">对象/详细内容</th>
                  <th width="18%">操作时间</th>
                </tr>
                <!-- BEGIN log -->
                <tr bgcolor="#FFFFFF" onMouseOver ="this.style.backgroundColor='#F5F5F5'" onMouseOut ="this.style.backgroundColor='#ffffff'"> 
                  <td width="4%"> 
                    <input type="checkbox" name="log_id[]" value="{id}">
                  </td>
                  <td width="9%">{user} </td>
                  <td width="13%">&nbsp;{ip} </td>
                  <td width="25%">&nbsp;{action} </td>
                  <td width="8%">&nbsp;{result}</td>
                  <td width="23%">&nbsp;{reason}</td>
                  <td width="18%">{time_added}</td>
                </tr>
                <!-- END log -->
                <tr> 
                  <td colspan="7" bgcolor="#FFFFFF"><img src="../images/admin/003.gif" width="38" height="22"> 
                    <input type="submit" name="Submit" value=" 删除 ">
                    <input type="hidden" name="action" value="list_log">
                    <input type="hidden" name="del_log" value="1">
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
      <p>&nbsp;</p>
    </td>
  </tr>
</table>
