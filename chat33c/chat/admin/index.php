<?
session_start();
session_register('login');
session_register('vsenha');

include "../config.php";
?>
<html>
<head>
<title>Romano Chat</title>
<META HTTP-EQUIV="expires" CONTENT="Tue, 20 Aug 1996 4:25:27">
<META HTTP-EQUIV="Cache Control" Content="No-cache">
<link href="../romano.css" rel="stylesheet" type="text/css">
</head>
<body>
<p align="center"><img border="0" src="../images/logo.jpg" width="300" height="83"></p>
<form method="POST" action="admin.php" name="frmLogin">
<table width="235" border="1" cellspacing="0" cellpadding="0" bordercolor="#000000" align="center">
  <tr>
    <td width="234">
      <table cellpadding="0" cellspacing="3" width="256" height="118">
<tbody>
            <tr> 
              <td width="73"  class="campos" align="center" height="25"> 
<p align="center"><b> 
                  Login :</b></p></td>
              <td width="509"  class="campos" align="center" height="25"> 
				<p align="center"> 
                  <INPUT size=20 name=login>
                </p></td>
            </tr>
            <tr> 
              <td width="73"  class="campos" align="center" height="32"> 
<p align="center"><b> 
                  Senha :</b></p></td>
              <td width="497"  class="campos" align="center" height="32"> 
				<p align="center"> 
                  <INPUT type=password size=20 name=vsenha>
                </p></td>
            </tr>
            <tr> 
              <td  class="campos" align="center" height="25" colspan="2"> 
<table border="0" width="80" cellpadding="0" cellspacing="0" bgcolor="<? echo botao_up ?>" align="center">
<tr onMouseOver="this.bgColor='<? echo botao_over ?>'" onMouseOut="this.bgColor='<? echo botao_up ?>'" onClick="document.frmLogin.submit();">
					<td width="10" align="left" class="button"><img src="../images/dobra.gif"></td>
                    <td align="center" class="button"><b>Entrar</b></td>
					<td width="10" align="right" class="button"><img src="../images/dobra2.gif"></td>
                  </tr>
                </table>
                
              </td>
            </tr>
          </tbody>
        </table>
    </td>
  </tr>
</table>
</form>
<p align="center"><font color="#FF0000">A senha administrativa e login, são os 
  mesmos da sua conta no MySQL .&nbsp;</font></p>
</body>
</html>