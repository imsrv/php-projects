 
<table width="770" border="1" cellpadding="0" cellspacing="0" bordercolor="#999999">
  <tr>
    <td align="center" bordercolor="#FFFFFF" bgcolor="#FFFFFF"> 
      <p>&nbsp;</p><table width="98%" border="0" cellspacing="1" cellpadding="0" bgcolor="#CCCCCC">
        <tr> 
          <th>Themes/Style list</th>
        </tr>
        <tr> 
          <td bgcolor="#FFFFFF"> 
            <!-- BEGIN theme -->
            <ul>
              <li>{theme} 
                <ul>
                  <!-- BEGIN style -->
                  <li> [<a href="?action=system_themes&step=del&sid={sid}" onClick="return confirm('Are sure to delete? ')">Delete</a>] 
                    [<a href="?action=system_themes&step=load&sid={sid}">Load</a>] <b>{flag}</b><font color="#666666"><ul><li>Images directory:{img}</li><li>CSS directory:{css}</li></ul></font>
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
          <th>Add New theme/style</th>
        </tr>
        <tr> 
            <td align="center" bgcolor="#FFFFFF">Name:
              <input name="flag" type="text" id="flag">
              <br>
              Theme directory:
              <input name="theme" type="text" id="theme">
              <br>
              Images directory:
              <input name="img" type="text" id="img">
              <br>
              CSS directory:
              <input name="css" type="text" id="css">
              <br>
              <input type="submit" name="Submit" value="Submit">
              <input name="step" type="hidden" id="step" value="add">
              <input name="action" type="hidden" id="action" value="system_themes">
              {add}</td>
        </tr>
		</form>
      </table>
      <p>&nbsp;</p></td>
  </tr>
</table>





