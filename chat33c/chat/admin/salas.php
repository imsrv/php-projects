<form action="admin.php" name="frmSalas" method="post">
<script>
function acao(v, s)
{
	document.frmSalas.val.value = v;
	document.frmSalas.vsala.value = s;
	document.frmSalas.excluir.value = s;
	document.frmSalas.submit();
}
</script>
<input type="hidden" name="val" value="">
<input type="hidden" name="vsala" value="">
<input type="hidden" name="excluir" value="">
  <table width="100%" border="0" cellpadding="0" cellspacing="2">
<tr align="center"> 
	  <td width="120" class="titulo2"><b>Sala</b></td>
	  <td width="200" class="titulo2"><b>Descrição</b></td>
	  <td width="200" class="titulo2"><b>Usuários</b></td>
	  <td width="50" class="titulo2"><b>Log</b></td>
	  <td width="50" class="titulo2"><b>Apagar</b></td>
	</tr>
	<?
$consulta = "SELECT * FROM salas ORDER BY codigo ASC";
$resultado = mysql_query($consulta,$this->conexao);
#salas
if ($resultado) {
while($linha = mysql_fetch_row($resultado))
{
?>
	<tr onMouseOver="this.bgColor='#FFFFCC'" onMouseOut="this.bgColor='#FFFFFF'"> 
	  <td width="120"> <? echo $linha[1] ?> </td>
	  <td width="200"><? echo $linha[2] ?></td>
	  <td width="200" align="center"> <table width="100%">
		  <tr> 
			<td> <select name="vip">
				<?
	$consulta2 = "SELECT * FROM users_$linha[0] ORDER BY codigo ASC";
	$resultado2 = mysql_query($consulta2,$this->conexao);
	#lista de usuarios
	while($linha2 = mysql_fetch_row($resultado2))
	{
?>
				<option value="<? echo $linha2[2] ?>"><? echo $linha2[3] ?></option>
				<?	} ?>
			  </select></td>
			<td width="70"> <table border="0" width="70" cellpadding="0" cellspacing="0" bgcolor="<? echo botao_up ?>">
				<tr onMouseOver="this.bgColor='<? echo botao_over ?>'" onMouseOut="this.bgColor='<? echo botao_up ?>'" onClick="acao(4, <? echo $linha[0] ?>)">
					<td align="left" width="10"><img src="../images/dobra.gif"></td>
					<td align="center" class="button"><b>Remover</b></td>
					<td align="right" width="10"><img src="../images/dobra2.gif"></td>
				</tr>
			  </table></td>
		  </tr>
		</table></td>
	  <td width="60" bgcolor="#FFFFCC" onMouseOver="this.bgColor='#FFFF00'" onMouseOut="this.bgColor='#FFFFCC'" onClick="acao(5, <? echo $linha[0] ?>)" style="cursor: pointer; cursor: hand">&nbsp;</td>
	  <td width="60" bgcolor="#FFFFCC" onMouseOver="this.bgColor='#FFFF00'" onMouseOut="this.bgColor='#FFFFCC'" onClick="acao(3, <? echo $linha[0] ?>);" style="cursor: pointer; cursor: hand">&nbsp;</td>
	</tr>
	<? } ?>
	<? } ?>
  </table>
</form>
