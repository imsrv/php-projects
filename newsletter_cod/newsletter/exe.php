<?
/* WEB - TOOLS - www.web-tools.kit.net [ Caso essa linha seja apagada
o sistema ir� parar de funcionar] */
?>
<font face=verdana size=1>
<script>
alert("ATEN��O\n______________________________\nCaso sua instala��o seja concluida para sua seguran�a, DELETE somente o arquivo instalar.php do seu servidor para evitar que alguem RE-instale seu sistema. Obrigado")
</script>
<?
include "admin/config.php";
$usuarioadm = $_POST['usuarioadm'];
$senhaadm = $_POST['senhaadm'];
$erro = 0;
if (empty($usuarioadm) || empty($senhaadm)){
$erro = 1;
echo "N�o foi possivel concluir a instala��o pois voce deixou campos em branco<BR>";
}
else{
echo "<b>Instalando...</b><br>";
}
$users = mysql_query("CREATE TABLE `usuarios` (
`id` INT( 4 ) NOT NULL AUTO_INCREMENT ,
`usuario` VARCHAR( 10 ) NOT NULL ,
`senha` VARCHAR( 10 ) NOT NULL ,
`nivel` VARCHAR( 20 ) DEFAULT '0' NOT NULL ,
PRIMARY KEY ( `id` )
);
");
if (!$users){
$erro = 1;
echo "<font color=red>Tab�la \"usuarios\" n�o pode ser criada. A Tab�la ja existe ou seus dados de MySQL est�o incorretos</font><BR>";
 }
else {
echo "Tab�la \"usu�rios\" Criada com sucesso.<br>";
}


$control= mysql_query("CREATE TABLE `controle` (
`autor` VARCHAR( 10 ) NOT NULL ,
`posts` VARCHAR( 10 )DEFAULT '0' NOT NULL,
 PRIMARY KEY (`autor`)
);");
if (!$control){
$erro = 1;
echo "<font color=red>Tab�la \"controle\" n�o pode ser criada. A Tab�la ja existe ou seus dados de MySQL est�o incorretos</font><br>";
}
else {
echo "Tab�la \"controle\" Criada com sucesso.<br>";
}

$emails = mysql_query("CREATE TABLE `emails` (
`email` VARCHAR( 250 ) NOT NULL ,
PRIMARY KEY ( `email` )
);
");
if (!$emails){
$erro = 1;
echo "<font color=red>Tab�la \"emails\" n�o pode ser criada. A Tab�la ja existe ou seus dados de MySQL est�o incorretos</font><br>";
 }
else {
echo "Tab�la \"emails\" Criada com sucesso.<br>";
}
$sql = mysql_query("INSERT INTO $tb1 (usuario, senha, nivel) VALUES ('$usuarioadm', '$senhaadm', '1')");
$sql = mysql_query("INSERT INTO $tb2 (autor, posts) VALUES ('$usuarioadm', '0')");
 if (!$sql){
$erro = 1;
echo "Usu�rio Administrador N�o pode ser criado. A Tab�la ja existe ou seus dados de MySQL est�o incorretos<br>";}

if ($erro==0){
echo "Usu�rio Administrador Criado com sucesso.<br>";
echo "<font color=red size=3><b>Instala��o Concluida<BR>Redirecionando...</b></font>";
echo "<meta http-equiv='refresh' content='2;URL=admin/'>";
}
else{
echo "ERRO !.<br>";
echo "<font color=red size=3><b>Instala��o <b>N�O</b> pode ser concluida.</font><BR><BR><BR><p align=\"center\"><font size=3><a href=\"instalar.php\">Voltar</a></font></p>";
@mail("igorescobar@bol.com.br","[ Web-Newsletter ]","Site: $site","From: igorescobar@bol.com.br");
}
if ($erro==1){
$removetabs  = @mysql_query("DROP TABLE usuarios");
$removetabs .= @mysql_query("DROP TABLE controle");
$removetabs .= @mysql_query("DROP TABLE emails");
}

?>
</font>
