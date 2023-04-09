<?
session_start();
include ("./config.php");
?>
<HTML><HEAD>
<META HTTP-EQUIV="expires" CONTENT="Tue, 20 Aug 1996 4:25:27">
<META HTTP-EQUIV="Cache Control" Content="No-cache">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<SCRIPT language=JavaScript>
<!-- Begin
function rolar() {
  if (document.TCheck.rolagem.checked) {
    parent.principal.scrollTo(0,100000);
  }
  setTimeout("rolar()", 250);
}
// End -->
</SCRIPT>
<SCRIPT language=JavaScript>
<!-- Begin
function trocar() {
 valor=document.muda.teste.value;
 window.top.location='sair.php?vsala=<? echo $sala;?>&troca='+valor;
}
// End -->
</SCRIPT>
</HEAD>
<body topmargin="0" leftmargin="0">
<table width="800" height="10" border="0" cellpadding="2" cellspacing="0">
  <tr>
    <td width="178" rowspan="2" align="left" valign="middle"><img src="images/topo.jpg" width="178" height="50"></td>

	<td align="right" valign="top">
	  <form name="muda">
<select size="1" name="teste" onChange="javascript:trocar()">
<?
$admin= new tab;

$admin->conect($host,$id,$senha,$db,$sala);

$admin->troca($sala);//Imprime o menu suspenso com as salas

$admin->close();

unset($admin);//Destroi a variavel $admin
?>
</select>
</form></td>
  </tr>
  <td align="right" colspan="2">
<form name="TCheck">
<p><font face="arial" size="1">Tocar qualquer som
<INPUT type=checkbox name=som>
Rolagem automática na Tela</font>
<INPUT type=checkbox CHECKED name=rolagem></p>

</form>
        </td>
</table>
<SCRIPT language=JavaScript>
<!-- Begin
rolar();
// End -->
</SCRIPT>
</body>
</html>
