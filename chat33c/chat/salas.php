<?
include ("./config.php");
?>
<html>
<head>
<title>Salas</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="romano.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<p align="center"><img border="0" src="images/logo.jpg" width="300" height="83"></p>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="10" class="titulo" align="left"><img src="images/dobra.gif"></td>
    <td class="titulo" width="99%"><b>Salas</b></td>
    <td width="10" class="titulo" align="right"><img src="images/dobra2.gif"></td>
  </tr>
  <tr> 
    <td colspan="3" align="center"> <table width="95%" bgcolor="#000000" cellpadding="1" cellspacing="0">
        <tr>
          <td> <table width="100%" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
              <tr>
                <td> 
                  <?
		$cria= new tab;
		$cria->conect($host,$id,$senha,$db);
		$cria->salas ($apelido,$careta,$cor);//Imprimi as tabelas com as salas
		$cria->close();
		unset($cria);//Destroi a variavel $cria
		?>
                </td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
  <tr>
  	<td colspan="3" height="30">
<table border="0" width="80" cellpadding="0" cellspacing="0" bgcolor="<? echo botao_up ?>" align="center">
  <tr onClick="window.close();" onMouseOver="this.style.backgroundColor='<? echo botao_over ?>'" onMouseOut="this.style.backgroundColor='<? echo botao_up ?>'"> 
    <td width="10" align="left" class="button"><img src="images/dobra.gif" width="10" height="20"></td>
    <td class="button"><b>Fechar</b></td>
    <td width="10" class="button"><img src="images/dobra2.gif" width="10" height="20"></td>
  </tr>
</table>
	
	</td>
  </tr>
</table>
</body>
</html>