 
<table width="770" border="1" cellpadding="0" cellspacing="0" bordercolor="#999999">
  <tr>
    <td align="center" bordercolor="#FFFFFF" bgcolor="#FFFFFF"> 
      <p>&nbsp;</p><table width="98%" border="0" cellspacing="1" cellpadding="0" bgcolor="#CCCCCC">
        <tr> 
          <th>����ģ����ʽ</th>
        </tr>
        <tr> 
          <td bgcolor="#FFFFFF"> 
            <!-- BEGIN theme -->
            <ul>
              <li>{theme} 
                <ul>
                  <!-- BEGIN style -->
                  <li> [<a href="?action=system_themes&step=del&sid={sid}" onClick="return confirm('��ȷ��Ҫɾ���𣿣���')">ɾ��</a>] 
                    [<a href="?action=system_themes&step=load&sid={sid}">����</a>] <b>{flag}</b><font color="#666666"><ul><li>ͼƬ·����{img}</li><li>CSS·����{css}</li></ul></font>
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
          <th>����ģ����ʽ</th>
        </tr>
        <tr> 
            <td align="center" bgcolor="#FFFFFF">���ƻ��飺 
              <input name="flag" type="text" id="flag">
              <br>
              ģ��Ŀ¼·���� 
              <input name="theme" type="text" id="theme">
              <br>
              ͼƬĿ¼·���� 
              <input name="img" type="text" id="img">
              <br>
              CSSĿ¼·���� 
              <input name="css" type="text" id="css">
              <br>
              <input type="submit" name="Submit" value="�ύ">
              <input name="step" type="hidden" id="step" value="add">
              <input name="action" type="hidden" id="action" value="system_themes">
              {add}</td>
        </tr>
		</form>
      </table>
      <p>&nbsp;</p></td>
  </tr>
</table>





