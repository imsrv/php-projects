<?
/* WEB - TOOLS - www.web-tools.kit.net [ Caso essa linha seja apagada
o sistema irá parar de funcionar] */
include "stop.php"; ?>
<head>
<style type="text/css">
<!--
@import url("../estilos.css");
-->
</style>
</head>
<?
include "config.php";
$acao = $_GET['acao'];
$usuario = $_POST['usuario'];
$senha = $_POST['senha'];
$nivel = $_POST['nivel'];
if ($acao==cadastrar){
$sql = mysql_query("INSERT INTO $tb2 (autor) VALUES ('$usuario')");
$sql = mysql_query("INSERT INTO $tb1 (usuario, senha, nivel) VALUES ('$usuario','$senha','$nivel')");
if (!$sql){
echo "Não foi possivel a Conexao";
}
else{
echo "<script> alert(\"Usuario cadastrado com Sucesso !!\")</script>";
echo "<meta http-equiv='refresh' content='0;URL=principal.php'>";
}
}
if ($acao==editar){
global $usuario;
$sql = mysql_query("SELECT * FROM $tb1 WHERE usuario='$usuario'");
if (!$sql){
echo "Não foi possivel a conexao";
}
else{
echo "<table>";
while ($reg = mysql_fetch_array($sql)){
$userdb = $reg['usuario'];
$senhadb = $reg['senha'];
$niveldb = $reg['nivel'];

echo "<font face=verdana size=1><form name=F1 action=usuarios_cad.php?acao=salvarreg method=POST>
<tr>
<td><font face=verdana size=1><strong>Usuário:</strong></td>
<td><input type=text name=\"usuario\" class=form value=\"$userdb\"></td>
</tr>
<tr>
<td><font face=verdana size=1><strong>Senha:</strong> </td>
<td><input type=text name=\"senha\" class=form value=\"$senhadb\"></td>
</tr>
<tr>";
if ($niveldb==1){
echo "<td><font face=verdana size=1><strong>Nivel:</strong> </td>
<td><SELECT name=\"nivel\" class=form>
		 <option value=1 SELECTED>Administrador</option>
		 <option value=0>Normal</option>
		 </select></td>
		 </tr>
		 <tr>
<td><input type=submit value=\"Atualizar >>\" class=botao></td>
		 </tr>
		 </table>
";
}
else{
echo "<td><font face=verdana size=1><strong>Nivel:</strong> </td>
<td><SELECT name=\"nivel\" class=form>
		 <option value=1>Administrador</option>
		 <option value=0 SELECTED>Normal</option>
		 </select></td>
		 </tr>
		 <tr>
<td><input type=submit value=\"Cadastrar >>\" class=botao></td>
		 </tr>
		 </table>

</form>";}
}
}
}
$acao = $_GET['acao'];
$userform = $_POST['usuario'];
if ($acao==salvarreg){
$sql = mysql_query("UPDATE $tb1 SET usuario='$usuario', senha='$senha', nivel='$nivel' WHERE usuario='$userform' LIMIT 1;");
if (!$sql){
echo "<script>alert(\"Erro, Não foi possivel atualizar seus dados\")</script>";
}
else{
echo "<script>alert(\"Dados Atualizados com  Sucesso!\")</script>";
echo "<meta http-equiv='refresh' content='0;URL=usuarios.php?op=editar'>";
}
}
?>
