<?php
include "conf.php";

mysql_connect($db[host], $db[user], $db[pass]) or die (mysql_error());
mysql_select_db($db[nome]) or die (mysql_error());

if(isset($HTTP_COOKIE_VARS[login_login])) {
$sql = "SELECT * FROM ".$td[user]." WHERE login='$login_login' and senha='$login_pass'";
$sql = mysql_query($sql);

if (empty($act)) {
?>
<html>

<head>
<title>Administração</title>
<link href="<? echo $link[css]; ?>" type="text/css" rel="stylesheet">
</head>

<body bgcolor="#D7EDF1">
<p><font face="Verdana" size="3"><b>Centro de Administração</b></font></p>
<p><font face="Verdana" size="1">
- <a href="?act=edt&edt=mensagem">Editar Mensagens</a><br>
- <a href="?act=del&del=mensagem">Remover Mensagens</a><br>
- <a href="?act=config">Configurações gerais</a>
</font></p>

<p>

<font face="Verdana" size="1">&gt;&gt; <a href="vlogin.php?log=out">Deslogar</a></font></p>
</body>

</html>
<?
} // end if $act add
if ($act == "edt") {
if ($edt == "mensagem") {
?>
<html>

<head>
<title>Administração - Editar Mensagens</title>
<link href="style.css" type="text/css" rel="stylesheet">
</head>

<body class="admin" bgcolor="#D7EDF1">
<p><font face="Verdana" size="1"><b>Editar Mensagens</b></font></p>
<?
$sql = mysql_query("SELECT * FROM ".$td[msg]." ORDER BY id DESC");
echo "
<center>
<table border=\"1\" bordercolor=\"#000000\" cellspacing=\"0\" cellpadding=\"0\">
<tr>
<td><font face=\"Verdana\" size=\"1\"><b><center>De / Para:</center></b></font></td>
<td><font face=\"Verdana\" size=\"1\"><b><center>ID:</center></b></font></td>
<td><font face=\"Verdana\" size=\"1\"><b><center>IP:</center></b></font></td>
<td><font face=\"Verdana\" size=\"1\"><b><center>Editar:</center></b></font></td>
</tr>
";
$i = "0"; // variavel de controle dos numeros
$e = "1"; // Varia as cores da tabela
while ($valor = mysql_fetch_array($sql)) {
$msg = substr($valor[msg], 0, 60);
$msg = str_replace("<","&lt;",$msg);
if(($e % 2) == "1") { $fundo = "#FFFFFF"; } else { $fundo = "#338899"; }
if($i % 2 == 0){ //verifica se eh par, se for faz uma coisa
$e++;
echo "
<tr bgcolor=\"$fundo\">
<td width=\"150\">
<font face=\"Verdana\" size=\"1\">".$valor[de]." / ".$valor[para]."</font>
</td>
<td width=\"50\">
<font face=\"Verdana\" size=\"1\"><center>".$valor[id]."</center></font>
</td>
<td width=\"120\">
<font face=\"Verdana\" size=\"1\">".$valor[ip]."</font>
</td>
<td width=\"300\">
<font face=\"Verdana\" size=\"1\"><a href=\"?act=edt&edt=mensagem2&id=".$valor[id]."\"><justify>$msg...</justify></a></font>
</td>
</tr>";
}
}
echo "</center></table>";
?>
<br><br><font face="Verdana" size="1">&gt;&gt; <a href="admin.php">Voltar</a></font></p>
</body>
</html>
<?

} // end if edt mensagem

if ($edt == "mensagem2") {
?>
<html>

<head>
<title>Administração - Editar Mensagens</title>
<link href="<?echo $link[css]; ?>" type="text/css" rel="stylesheet">
</head>

<body bgcolor="#D7EDF1">
<p><font face="Verdana" size="2"><b>Editar Mensagens</b></font></p>
<table border="0" width="100%" cellspacing="0" cellpadding="0">
  <tr>
    <td width="100%">
      <p align="center"><font face="Verdana" size="1">Reescreva a mensagem:</font></td>
  </tr>
  <tr>
    <td width="100%">
      <form action="admin.php">
        <p align="center"><font face="Verdana" size="1">
		<? $sql = mysql_query("SELECT * FROM $td[msg] where id like '$id'");
        $valor = mysql_fetch_array($sql); ?>
        <tr>
   <td width="20%"><font size="2" face="Verdana">Seu nome*:</font></td>
   <td><input value="<? echo $valor[de]; ?>" name="de" type="text" size="20" maxlength="30" style="font-family: Verdana; font-size: 10 pt; border-style: solid; border-width: 1"></td>
  </tr>
  <tr>
   <td><font size="2" face="Verdana">Seu e-mail:</font></td>
   <td><input value="<? echo $valor[email]; ?>" name="email" type="text" size="20" maxlength="40" style="font-family: Verdana; font-size: 10 pt; border-style: solid; border-width: 1"></td>
  </tr>
  <tr>
   <td><font size="2" face="Verdana">Seu ICQ:</font></td>
   <td><input value="<? echo $valor[icq]; ?>" name="icq" type="text" size="20" maxlength="9" style="font-family: Verdana; font-size: 10 pt; border-style: solid; border-width: 1"></td>
  </tr>
  <tr>
   <td><font size="2" face="Verdana">Mensagem para*:</font></td>
   <td><input value="<? echo $valor[para]; ?>" name="para" type="text" size="20" maxlength="30"style="font-family: Verdana; font-size: 10 pt; border-style: solid; border-width: 1"></td>
  </tr>
  <tr>
   <td>
        <textarea rows="4" name="msg" cols="30" style="font-family: Verdana; font-size: 10 pt; border-style: solid; border-width: 1"><? echo "$valor[msg]"; ?></textarea><br>
        <input type="hidden" name="act" value="edt">
		<input type="hidden" name="id" value="<? echo $id ?>">
		<input type="hidden" name="edt" value="mensagem2">
		<input type="hidden" name="step" value="2">
		<input type="submit" value="Editar">
		<input type="reset" value="Redefinir">
		</font></p>
      </form>
    </td>
  </tr>
</table>
<font face="Verdana" size="1">&gt;&gt; <a href="admin.php">Voltar</a></font></p>
</body>

</html>
<?
if ($step == "2") {
if (empty($msg)) {
die ("O campo \"Mensagem\" deve ser preenchido.");
} else {
mysql_query("UPDATE $td[msg] set msg = '$msg', de = '$de', para = '$para', email = '$email', icq = '$icq' where id like '$id'") or die(mysql_error());
echo "
<script>
alert(\"Mensagem editada com sucesso!\");
window.location = 'admin.php';
</script>";

} // end else for step 2 edt mensagem

} // end if step 2 edt mensagem

} // end if edt mensagem2

} // end if $act edt
if ($del == "mensagem") {
?>
<html>

<head>
<title>Administração - Remover Mensagens</title>
<link href="<? echo $link[css]; ?>" type="text/css" rel="stylesheet">
</head>

<body bgcolor="#D7EDF1">
<p><font face="Verdana" size="1"><b>Remover mensagens</b></font></p>
<?
$sql = mysql_query("SELECT * FROM $td[msg] ORDER BY id DESC");
echo "
<center>
<form action=\"./Admin.php\" method=\"post\" onsubmit=\"document.all['BotaoSubmit'].disabled = true; \">
<table border=\"1\" bordercolor=\"#000000\" cellspacing=\"0\" cellpadding=\"0\">
<tr>
<td><font face=\"Verdana\" size=\"1\"><b><center>De / Para:</center></b></font></td>
<td><font face=\"Verdana\" size=\"1\"><b><center>ID:</center></b></font></td>
<td><font face=\"Verdana\" size=\"1\"><b><center>IP:</center></b></font></td>
<td><font face=\"Verdana\" size=\"1\"><b><center>Mensagem:</center></b></font></td>
<td><font face=\"Verdana\" size=\"1\"><b><center>Remover:</center></b></font></td>
</tr>
";
if (mysql_num_rows($sql) > "0") {
$i = "0"; // variavel de controle dos numeros
$e = "1"; // Varia as cores da tabela
while ($valor = mysql_fetch_array($sql)) {
$msg = substr($valor[msg], 0, 60);
$msg = str_replace("<","&lt;",$msg);
if(($e % 2) == "1") { $fundo = "#FFFFFF"; } else { $fundo = "#338899"; }
if($i % 2 == 0){ //verifica se eh par, se for faz uma coisa
$e++;
echo "
<tr bgcolor=\"$fundo\">
<td width=\"150\">
<font face=\"Verdana\" size=\"1\">".$valor[de]." / ".$valor[para]."</font>
</td>
<td width=\"30\">
<font face=\"Verdana\" size=\"1\"><center>".$valor[id]."</center></font>
</td>
<td width=\"120\">
<font face=\"Verdana\" size=\"1\">".$valor[ip]."</font>
</td>
<td width=\"300\">
<font face=\"Verdana\" size=\"1\"><justify>$msg</justify></font>
</td>
<td width=\"10\">
<font face=\"Verdana\" size=\"1\"><center><input type=\"radio\" name=\"id\" value=\"".$valor[id]."\"></center></font>
</td>
</tr>";
}
}
} else {
echo "<tr><td colspan=\"2\"><font face=\"Verdana\" size=\"1\"><b>Não há mensagens postadas.</b></font></td></tr>";
}
echo "</center></table>";
?>
<input type="hidden" name="act" value="del">
<input type="hidden" name="del" value="mensagem">
<input type="hidden" name="step" value="2">
<br>
<center>
<input id="BotaoSubmit" type="submit" value="Remover">
<input type="reset" value="Redefinir">
</center>
</form>
<font face="Verdana" size="1">&gt;&gt; <a href="javascript:history.back(-1)">Voltar</a></font></p>
</body>
</html>
<?
if ($step == "2") {
if (empty($id)) {
?>
<script>
alert("Nenhuma mensagem foi removida.");
window.location = 'admin.php';
</script>
<?
} else {
mysql_query("DELETE FROM $td[msg] where id like '$id'") or die(mysql_error());
echo "
<script>
alert(\"Mensagem removida com sucesso!\");
window.location = 'admin.php';
</script>";
} // end else for step 2 del mensagem

} // end if step 2 del mensagem

} // end if $act del mensagem
################################## ACT CONFIG ###############################
if($act == "config") {

$file = "conf.php";
$abrir = fopen($file, "r");
$ler = fread($abrir, filesize($file));

echo "<html><head>
<title>Administração do GB Mural 2.0 -> Por Gustavo Bissolli</title>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">
<link href=\"style.css\" rel=\"stylesheet\" type=\"text/css\">
</head>

<body leftmargin=\"0\" topmargin=\"0\" bgcolor=\"#D7EFF1\">
<form action=\"?act=configa\" method=\"POST\">
<table width=\"90%\" align=\"center\">
 <tr>
  <td colspan=\"2\"><center><font face=\"Verdana\" size=\"5\"><b>Configurações Gerais</b></font></center></td>
 </tr>
 <tr><td colspan=\"2\">&nbsp;</td></tr>
 <tr>
  <td colspan=\"2\"><font face=\"Verdana\" size=\"2\"><b>&#149;&nbsp;  Preencha os dados corretamente para o melhor funcionamento do mural!</b></font></td>
 </tr>
 <tr>
  <td><br><font face=\"Verdana\" size=\"1\"><b>&nbsp;&nbsp;&nbsp;-> Dados do MySQL</b></font></td>
  <td></td>
 </tr>
 <tr>
  <td width=\"30%\"><font face=\"Verdana\" size=\"1\">Host:</font></td>
  <td><input type=\"text\" name=\"hosta\" value=\"$db[host]\" class=\"form\"></td>
 </tr>
 <tr>
  <td width=\"30%\"><font face=\"Verdana\" size=\"1\">Banco de dados:</font></td>
  <td><input type=\"text\" name=\"dba\" value=\"$db[nome]\" class=\"form\"></td>
 </tr>
 <tr>
  <td><font face=\"Verdana\" size=\"1\">Username:</font></td>
  <td><input type=\"text\" name=\"usera\" value=\"$db[user]\" class=\"form\"></td>
 </tr>
 <tr>
  <td><font face=\"Verdana\" size=\"1\">Senha:</font></td>
  <td><input type=\"text\" name=\"passa\" value=\"$db[pass]\" class=\"form\"></td>
 </tr>
 <tr>
  <td colspan=\"2\"><br><font face=\"Verdana\" size=\"1\"><b>&nbsp;&nbsp;&nbsp;-> Dados dos links</b> - Não é aconselhável mudar o nome dos arquivos.</font></td>
 </tr>
 <tr>
  <td><font face=\"Verdana\" size=\"1\">Index.php</font></td>
  <td><input type=\"text\" name=\"u_index\" value=\"$link[index]\" class=\"form\"></td>
 </tr>
 <tr>
  <td><font face=\"Verdana\" size=\"1\">Smilie.php</font></td>
  <td><input type=\"text\" name=\"u_smilies\" value=\"$link[smiles]\" class=\"form\"></td>
 </tr>
 <tr>
  <td><font face=\"Verdana\" size=\"1\">Ubbc.js</font></td>
  <td><input type=\"text\" name=\"u_ubbc\" value=\"$link[ubbc]\" class=\"form\"></td>
 </tr>
 <tr>
  <td><font face=\"Verdana\" size=\"1\">Postar.php</font></td>
  <td><input type=\"text\" name=\"u_postar\" value=\"$link[postar]\" class=\"form\"></td>
 </tr>
 <tr>
  <td><font face=\"Verdana\" size=\"1\">Inserir.php</font></td>
  <td><input type=\"text\" name=\"u_inserir\" value=\"$link[inserir]\" class=\"form\"></td>
 </tr>
 <tr>
  <td><font face=\"Verdana\" size=\"1\">Pasta dos Smilies</font></td>
  <td><input type=\"text\" name=\"u_psm\" value=\"$link[psm]\" class=\"form\"></td>
 </tr>
 <tr>
  <td><font face=\"Verdana\" size=\"1\">Style.css</font></td>
  <td><input type=\"text\" name=\"u_css\" value=\"$link[css]\" class=\"form\"></td>
 </tr>
 <tr>
  <td><font face=\"Verdana\" size=\"1\">Link Paginação:</font></td>
  <td><input type=\"text\" name=\"u_pagina\" value=\"$paginacao[link]\" class=\"form\"></td>
 </tr>
 <tr>
  <td><br><font face=\"Verdana\" size=\"1\"><b>&nbsp;&nbsp;&nbsp;-> Outras informações</b></font></td>
  <td></td>
 </tr>
 <tr>
  <td><font face=\"Verdana\" size=\"1\">Nome do mural:</font></td>
  <td><input type=\"text\" name=\"tituloa\" value=\"$titulo\" class=\"form\"></td>
 </tr>
 <tr>
  <td><font face=\"Verdana\" size=\"1\">Número de mensagens por página:</font></td>
  <td><input type=\"text\" name=\"msgpag\" value=\"$lpp\" size=\"2\" class=\"form\"></td>
 </tr>
 <tr>
  <td><font face=\"Verdana\" size=\"1\">Total de mensagens:</font></td>
  <td><input type=\"text\" name=\"tmsg\" value=\"$tm\" size=\"4\" class=\"form\"></td>
 </tr>
 <tr>
  <td><font face=\"Verdana\" size=\"1\">Cor do tópico</font></td>
  <td><input type=\"text\" name=\"c_top\" value=\"$cor[topico]\" class=\"form\"></td>
 </tr>
 <tr>
  <td><font face=\"Verdana\" size=\"1\">ICQ não identificado.</font></td>
  <td><input type=\"text\" name=\"no_icqa\" value=\"$no_icq\" class=\"form\"></td>
 </tr>
 <tr>
  <td><font face=\"Verdana\" size=\"1\">Mensagem de sucesso:</font></td>
  <td><input type=\"text\" name=\"msgsus\" value=\"$thanks_msg\" class=\"form\"></td>
 </tr>
 <tr>
  <td><font face=\"Verdana\" size=\"1\">Mensagem de erro:</font></td>
  <td><input type=\"text\" name=\"msgerro\" value=\"$error_msg\" class=\"form\"></td>
 </tr>
 <tr>
  <td><font face=\"Verdana\" size=\"1\">Mostrar smilies?</font></td>
  <td>
  <select name=\"smylesa\" class=\"form\">
   <option value=\"1\">Sim</option>
   <option value=\"0\">Não</option>
  </select>
  </td>
 </tr>
 <tr>
  <td><font face=\"Verdana\" size=\"1\">URL do seu site:</font></td>
  <td><input type=\"text\" name=\"url_sitea\" value=\"$url_site\" class=\"form\"></td>
 </tr>
 <tr>
  <td><font face=\"Verdana\" size=\"1\">Permitir HTML?</font></td>
  <td>
  <select name=\"specialchara\" class=\"form\">
   <option value=\"1\">Sim</option>
   <option value=\"0\">Não</option>
  </select>
  </td>
 </tr>
 <tr>
  <td><font face=\"Verdana\" size=\"1\">Atual tabela de mensagens:</font></td>
  <td><input type=\"text\" name=\"tdmsg\" value=\"$td[msg]\" class=\"form\"></td>
 </tr>
 <tr>
  <td><font face=\"Verdana\" size=\"1\">Atual da tabela de usuários:</font></td>
  <td><input type=\"text\" name=\"tduser\" value=\"$td[user]\" class=\"form\"></td>
 </tr>
 <tr>
  <td colspan=\"2\"><br><center><input type=\"submit\" value=\" Continuar \" class=\"form\">&nbsp;&nbsp;&nbsp;&nbsp;<input type=\"reset\" value=\" Limpar \" class=\"form\"></center></td>
 </tr>
 <tr>
  <td colspan=\"2\"><br><br><Br><center><font face=\"Verdana\" size=\"1\"><b>Sistema desenvolvido por <a href=\"mailto:guzaum@hotmail.com\">Gustavo Bissolli</a>.</b></font></center></td>
 </tr>
</table>
</form>
</body>
</html>";
fclose($abrir);
}
if($act == "configa"){
$file = "conf.php";
$abrir = fopen($file, "w") or die ("Não foi possível abrir o arquivo $file.");
$texto = "<?php

\$db[nome] = \"$dba\";
\$db[host] = \"$hosta\";
\$db[user] = \"$usera\";
\$db[pass] = \"$passa\";

\$link[index] = \"$u_index\";
\$link[smiles] = \"$u_smilies\";
\$link[ubbc] = \"$u_ubbc\";
\$link[postar] = \"$u_postar\";
\$link[inserir] = \"$u_inserir\";
\$link[psm] = \"$u_psm\";
\$link[css] = \"$u_css\";

\$lpp = \"$msgpag\";
\$tm = \"$tmsg\";
\$paginacao[link] = \"$u_pagina\";

\$cor[topico] = \"$c_top\";

\$no_icq = \"$no_icqa\";
\$titulo = \"$tituloa\";
\$thanks_msg = \"$msgsus\";
\$error_msg = \"$msgerro\";
\$smyles = \"$smylesa\";
\$url_site = \"$url_sitea\";
\$specialchar = \"$specialchara\";

\$td[msg] = \"$tdmsg\";
\$td[user] = \"$tduser\";

?>
";
$gravar = fwrite($abrir, $texto);
fclose($abrir);
if($gravar) {
echo "<script>
alert(\"Configurações editadas com sucesso!\");
window.location = 'admin.php';
</script>";
}
}
################################ Não Logado ################################
} else {
include "login.php";
}
