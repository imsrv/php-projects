 
<table width="770" border="1" cellpadding="0" cellspacing="0" bordercolor="#999999">
  <tr>
    <td align="center" bordercolor="#FFFFFF" bgcolor="#FFFFFF"> 
      <p>&nbsp;</p><table width="98%" border="0" cellspacing="1" cellpadding="0" bgcolor="#CCCCCC">
        <tr> 
          <th>已有模板样式</th>
        </tr>
        <tr> 
          <td bgcolor="#FFFFFF"> 
            <!-- BEGIN theme -->
            <ul>
              <li>{theme} 
                <ul>
                  <!-- BEGIN style -->
                  <li> [<a href="?action=system_themes&step=del&sid={sid}" onClick="return confirm('你确定要删除吗？？？')">删除</a>] 
                    [<a href="?action=system_themes&step=load&sid={sid}">启用</a>] <b>{flag}</b><font color="#666666"><ul><li>图片路径：{img}</li><li>CSS路径：{css}</li></ul></font>
                  </li>
                  <!-- END style -->
                </ul>
              </li>
            </ul>
            <!-- END theme -->
          </td>
        </tr>
      </table>
      <p>&nbsp;</p><table width="98%" border="0" cellspacing="1" cellpadding="0" bgcolor="#CCCCCC">
        <form action="index.php" method="post" enctype="multipart/form-data">
          <tr> 
          <th>增加模板样式</th>
        </tr>
        <tr> 
            <td align="center" bgcolor="#FFFFFF">名称或简介： 
              <input name="flag" type="text" id="flag">
              <br>
              模板目录路径： 
              <input name="theme" type="text" id="theme">
              <br>
              图片目录路径： 
              <input name="img" type="text" id="img">
              <br>
              CSS目录路径： 
              <input name="css" type="text" id="css">
              <br>
              <input type="submit" name="Submit" value="提交">
              <input name="step" type="hidden" id="step" value="add">
              <input name="action" type="hidden" id="action" value="system_themes">
              {add}</td>
        </tr>
		</form>
      </table>
      <p>&nbsp;</p></td>
  </tr>
</table>





