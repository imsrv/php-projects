<?
session_start();
include ("./config.php");
?>
<HTML>
<HEAD><title>Enviar Imagem</title>
<META HTTP-EQUIV="expires" CONTENT="Tue, 20 Aug 1996 4:25:27">
<META HTTP-EQUIV="Cache Control" Content="No-cache">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="romano.css" rel="stylesheet" type="text/css">
</HEAD>
<BODY leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<form method="POST" action="imagem.php" name="frmImagem">
<input type="hidden" name="PHPSESSID" value="5abe7a46faa396ec28905b8ae3be15cf">
  <table width="100%" border="0" cellspacing="2" cellpadding="2">
	<tr class="campos"> 
<td width="30" rowspan="4" align="center"><img src="images/arquivo_anim.gif" width="80" height="50"></td>
	  <td colspan="4"><font size="2"><b>Coloque o caminho da imagem na caixa de 
		texto abaixo:</b></font></td>
	</tr>
	<tr> 
<td colspan="4"><font color="#009999" size="2"><b><font color="#FF0000">Exemplo:</font> 
<font color="#0000FF">http://www.webestudos.com.br/infologo.jpg</font></b></font></td>
	</tr>
	<tr> 
<td width="30" rowspan="2">&nbsp; </td>
	  <td width="743" colspan="3"><b><font size="2">Para: 
<select size=1 name=b>
		  <?
$user= new perfil;

$user->conect($host,$id,$senha,$db,$sala);

$user->imprimir($sel); //imprime o menu suspenso com nome dos usuarios do chat.

$user->close();

unset($user); //Destroi a variavel $user.
?>
		</select>
		&nbsp;&nbsp; </font> <font size="2"> 
<input type=checkbox value=ON name=d>
		<font color="#000000"> Reservadamente</font></font></b></td>
	</tr>
	<tr> 
<td width="120"><b><font size="2">Endere&ccedil;o:&nbsp; </font></b> <input size=40 name=e>
		&nbsp; 
	  </td>
	  <td align="left"> <table border="0" width="80" cellpadding="0" cellspacing="0" bgcolor="<? echo botao_up ?>">
		  <tr onMouseOver="this.style.backgroundColor='<? echo botao_over ?>'" onMouseOut="this.style.backgroundColor='<? echo botao_up ?>'" onClick="document.frmImagem.submit();"> 

<td class="button" align="left" width="10"><img src="images/dobra.gif"></td>
			<td class="button"><b>Enviar</b></td>
			<td class="button" align="right" width="10"><img src="images/dobra2.gif"></td>
		  </tr>
		</table></td>
	  <td align="left"><table border="0" width="80" cellpadding="0" cellspacing="0" bgcolor="<? echo botao_up ?>">
		  <tr onMouseOver="this.style.backgroundColor='<? echo botao_over ?>'" onMouseOut="this.style.backgroundColor='<? echo botao_up ?>'" onClick="window.close();"> 
			<td class="button" align="left" width="10"><img src="images/dobra.gif"></td>
			<td class="button"><b>Fechar</b></td>
			<td class="button" align="right" width="10"><img src="images/dobra2.gif"></td>
		  </tr>
		</table></td>
	</tr>
  </table>
</form>
</BODY>
</HTML>