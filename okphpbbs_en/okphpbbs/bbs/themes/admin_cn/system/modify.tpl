<html>
<head>
<title>modify user</title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link href="css.css" rel="stylesheet" type="text/css">
</head>

<body bgcolor="#FFFFFF" text="#000000">
<table width="770" border="1" cellspacing="0" cellpadding="0" bordercolor="#999999" bgcolor="#FFFFFF">
  <tr> 
    <td bordercolor="#FFFFFF"> 
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr > 
          <td height="26" bgcolor="#FFFFFF"> <font class="directory">修改密码</font></td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="1" cellpadding="0" bgcolor="#CCCCCC">
        <form name="form1" method="post" action="index.php" enctype="multipart/form-data">
          <tr> 
            <th colspan="2">基本信息 </th>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td width="27%" height="26" align="right">原密码：</td>
            <td width="73%" height="26"> 
              <input type="password" name="password" size="20">
            </td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td width="27%" height="26" align="right">新密码：</td>
            <td width="73%" height="26"> 
              <input type="password" name="password1" size="20">
            </td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td width="27%" height="26" align="right">重复一遍：</td>
            <td width="73%" height="26"> 
              <input type="password" name="password2" size="20">
            </td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td colspan="2" align="center"> 
              <input type="hidden" name="action" value="system_modify">
              <input type="hidden" name="step" value="{step}">
              <input type="submit" name="Submit" value="  确定  ">
            </td>
          </tr>
        </form>
      </table>
      <p>&nbsp;</p>
    </td>
  </tr>
</table>
</body>
</html>
