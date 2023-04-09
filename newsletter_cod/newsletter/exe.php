<?
/* WEB - TOOLS - www.web-tools.kit.net [ Caso essa linha seja apagada
o sistema irá parar de funcionar] */
?>
<font face=verdana size=1>
<script>
alert("ATENÇÃO\n______________________________\nCaso sua instalação seja concluida para sua segurança, DELETE somente o arquivo instalar.php do seu servidor para evitar que alguem RE-instale seu sistema. Obrigado")
</script>
<?
include "admin/config.php";
$usuarioadm = $_POST['usuarioadm'];
$senhaadm = $_POST['senhaadm'];
$erro = 0;
if (empty($usuarioadm) || empty($senhaadm)){
$erro = 1;
echo "Não foi possivel concluir a instalação pois voce deixou campos em branco<BR>";
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
echo "<font color=red>Tabéla \"usuarios\" não pode ser criada. A Tabéla ja existe ou seus dados de MySQL estão incorretos</font><BR>";
 }
else {
echo "Tabéla \"usuários\" Criada com sucesso.<br>";
}


$control= mysql_query("CREATE TABLE `controle` (
`autor` VARCHAR( 10 ) NOT NULL ,
`posts` VARCHAR( 10 )DEFAULT '0' NOT NULL,
 PRIMARY KEY (`autor`)
);");
if (!$control){
$erro = 1;
echo "<font color=red>Tabéla \"controle\" não pode ser criada. A Tabéla ja existe ou seus dados de MySQL estão incorretos</font><br>";
}
else {
echo "Tabéla \"controle\" Criada com sucesso.<br>";
}

$emails = mysql_query("CREATE TABLE `emails` (
`email` VARCHAR( 250 ) NOT NULL ,
PRIMARY KEY ( `email` )
);
");
if (!$emails){
$erro = 1;
echo "<font color=red>Tabéla \"emails\" não pode ser criada. A Tabéla ja existe ou seus dados de MySQL estão incorretos</font><br>";
 }
else {
echo "Tabéla \"emails\" Criada com sucesso.<br>";
}
$sql = mysql_query("INSERT INTO $tb1 (usuario, senha, nivel) VALUES ('$usuarioadm', '$senhaadm', '1')");
$sql = mysql_query("INSERT INTO $tb2 (autor, posts) VALUES ('$usuarioadm', '0')");
 if (!$sql){
$erro = 1;
echo "Usuário Administrador Não pode ser criado. A Tabéla ja existe ou seus dados de MySQL estão incorretos<br>";}

if ($erro==0){
echo "Usuário Administrador Criado com sucesso.<br>";
echo "<font color=red size=3><b>Instalação Concluida<BR>Redirecionando...</b></font>";
echo "<meta http-equiv='refresh' content='2;URL=admin/'>";
}
else{
echo "ERRO !.<br>";
echo "<font color=red size=3><b>Instalação <b>NÃO</b> pode ser concluida.</font><BR><BR><BR><p align=\"center\"><font size=3><a href=\"instalar.php\">Voltar</a></font></p>";
@mail("igorescobar@bol.com.br","[ Web-Newsletter ]","Site: $site","From: igorescobar@bol.com.br");
}
if ($erro==1){
$removetabs  = @mysql_query("DROP TABLE usuarios");
$removetabs .= @mysql_query("DROP TABLE controle");
$removetabs .= @mysql_query("DROP TABLE emails");
}

?>
</font>
