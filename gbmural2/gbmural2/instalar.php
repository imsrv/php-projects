<?php

if(empty($act)) {
echo "<html><head>
<title>Instalação do GB Mural 2.0 -> Por Gustavo Bissolli</title>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">
<link href=\"style.css\" rel=\"stylesheet\" type=\"text/css\">
</head>

<body leftmargin=\"0\" topmargin=\"0\" bgcolor=\"#D7EFF1\">
<table width=\"90%\" align=\"center\">
 <tr>
  <td><center><font face=\"Verdana\" size=\"5\"><b>Instalação GB Mural 2.0</b></font></center></td>
 </tr>
 <tr><td>&nbsp;</td></tr>
 <tr>
  <td><font face=\"Verdana\" size=\"4\"><b>&#149;&nbsp;Boas Vindas!</b></font></td>
 </tr>
 <tr>
  <td><font face=\"Verdana\" size=\"2\">
  &nbsp;  Mural de Recados, desenvolvido em PHP por Gustavo Bissolli. O sistema utiliza o banco de dados MySQL, grava o IP das pessoas que postam mensagens, e tem um admin onde você pode excluir ou editar mensagens do mural.
  </font></td>
 </tr>
 <tr>
  <td><font face=\"Verdana\" size=\"4\"><b><br><br>&#149;&nbsp;Instalar!</b></font>
 </tr>
 <tr>
  <td><font face=\"Verdana\" size=\"2\">
  &nbsp;  <a href=\"?act=instalar&op=1\"> >> Já uso o GB Mural 1.0, desejo fazer a atualização para a nova versão.</a><br>
  &nbsp;  <a href=\"?act=instalar&op=2\"> >> Estou instalando diretamente a versão 2.0 do GB Mural.</a>
  </font></td>
 </tr>
 <tr>
  <td><br><br><Br><center><font face=\"Verdana\" size=\"1\"><b>Sistema desenvolvido por <a href=\"mailto:guzaum@hotmail.com\">Gustavo Bissolli</a>.</b></font></center></td>
 </tr>
</table>
</body>
</html>";
}  // END ACT EMPTY

############################ ACT INSTALAR
if($act == "instalar") {

if($op == "1") {
echo "<html><head>
<title>Instalação do GB Mural 2.0 -> Por Gustavo Bissolli</title>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">
<link href=\"style.css\" rel=\"stylesheet\" type=\"text/css\">
</head>

<body leftmargin=\"0\" topmargin=\"0\" bgcolor=\"#D7EFF1\">
<form action=\"?act=instalando&op=1\" method=\"POST\">
<table width=\"90%\" align=\"center\">
 <tr>
  <td colspan=\"2\"><center><font face=\"Verdana\" size=\"5\"><b>Instalação GB Mural 2.0 -> Atualização</b></font></center></td>
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
  <td><input type=\"text\" name=\"hosta\" value=\"localhost\" class=\"form\"></td>
 </tr>
 <tr>
  <td width=\"30%\"><font face=\"Verdana\" size=\"1\">Banco de dados:</font></td>
  <td><input type=\"text\" name=\"dba\" value=\"gbmural\" class=\"form\"></td>
 </tr>
 <tr>
  <td><font face=\"Verdana\" size=\"1\">Username:</font></td>
  <td><input type=\"text\" name=\"usera\" value=\"root\" class=\"form\"></td>
 </tr>
 <tr>
  <td><font face=\"Verdana\" size=\"1\">Senha:</font></td>
  <td><input type=\"text\" name=\"passa\" value=\"\" class=\"form\"></td>
 </tr>
 <tr>
  <td colspan=\"2\"><br><font face=\"Verdana\" size=\"1\"><b>&nbsp;&nbsp;&nbsp;-> Dados dos links</b> - Não é aconselhável mudar o nome dos arquivos.</font></td>
 </tr>
 <tr>
  <td><font face=\"Verdana\" size=\"1\">Index.php</font></td>
  <td><input type=\"text\" name=\"u_index\" value=\"index.php\" class=\"form\"></td>
 </tr>
 <tr>
  <td><font face=\"Verdana\" size=\"1\">Smilie.php</font></td>
  <td><input type=\"text\" name=\"u_smilies\" value=\"img/smilies.php\" class=\"form\"></td>
 </tr>
 <tr>
  <td><font face=\"Verdana\" size=\"1\">Ubbc.js</font></td>
  <td><input type=\"text\" name=\"u_ubbc\" value=\"ubbc.js\" class=\"form\"></td>
 </tr>
 <tr>
  <td><font face=\"Verdana\" size=\"1\">Postar.php</font></td>
  <td><input type=\"text\" name=\"u_postar\" value=\"?page=postar\" class=\"form\"></td>
 </tr>
 <tr>
  <td><font face=\"Verdana\" size=\"1\">Inserir.php</font></td>
  <td><input type=\"text\" name=\"u_inserir\" value=\"?page=inserir\" class=\"form\"></td>
 </tr>
 <tr>
  <td><font face=\"Verdana\" size=\"1\">Pasta dos Smilies</font></td>
  <td><input type=\"text\" name=\"u_psm\" value=\"img\" class=\"form\"></td>
 </tr>
 <tr>
  <td><font face=\"Verdana\" size=\"1\">Style.css</font></td>
  <td><input type=\"text\" name=\"u_css\" value=\"style.css\" class=\"form\"></td>
 </tr>
 <tr>
  <td><font face=\"Verdana\" size=\"1\">Link Paginação:</font></td>
  <td><input type=\"text\" name=\"u_pagina\" value=\"\$PHP_SELF?\" class=\"form\"></td>
 </tr>
 <tr>
  <td><br><font face=\"Verdana\" size=\"1\"><b>&nbsp;&nbsp;&nbsp;-> Outras informações</b></font></td>
  <td></td>
 </tr>
 <tr>
  <td><font face=\"Verdana\" size=\"1\">Nome do mural:</font></td>
  <td><input type=\"text\" name=\"tituloa\" value=\"GB Mural 2.0\" class=\"form\"></td>
 </tr>
 <tr>
  <td><font face=\"Verdana\" size=\"1\">Número de mensagens por página:</font></td>
  <td><input type=\"text\" name=\"msgpag\" value=\"8\" size=\"2\" class=\"form\"></td>
 </tr>
 <tr>
  <td><font face=\"Verdana\" size=\"1\">Total de mensagens:</font></td>
  <td><input type=\"text\" name=\"tmsg\" value=\"300\" size=\"4\" class=\"form\"></td>
 </tr>
 <tr>
  <td><font face=\"Verdana\" size=\"1\">Cor do tópico</font></td>
  <td><input type=\"text\" name=\"c_top\" value=\"#FFFFFF\" class=\"form\"></td>
 </tr>
 <tr>
  <td><font face=\"Verdana\" size=\"1\">ICQ não identificado.</font></td>
  <td><input type=\"text\" name=\"no_icqa\" value=\"--------\" class=\"form\"></td>
 </tr>
 <tr>
  <td><font face=\"Verdana\" size=\"1\">Mensagem de sucesso:</font></td>
  <td><input type=\"text\" name=\"msgsus\" value=\"Mensagem enviada com sucesso!\" class=\"form\"></td>
 </tr>
 <tr>
  <td><font face=\"Verdana\" size=\"1\">Mensagem de erro:</font></td>
  <td><input type=\"text\" name=\"msgerro\" value=\"Não foi possível enviar a mensagem. Tente novamente.\" class=\"form\"></td>
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
  <td><input type=\"text\" name=\"url_sitea\" value=\"http://www.meusite.com.br\" class=\"form\"></td>
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
  <td><input type=\"text\" name=\"tdmsg\" value=\"mensagens\" class=\"form\"></td>
 </tr>
 <tr>
  <td><font face=\"Verdana\" size=\"1\">Atual da tabela de usuários:</font></td>
  <td><input type=\"text\" name=\"tduser\" value=\"usuarios\" class=\"form\"></td>
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
} // END OP 1
elseif($op == "2") {
echo "
<html><head>
<title>Instalação do GB Mural 2.0 -> Por Gustavo Bissolli</title>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">
<link href=\"style.css\" rel=\"stylesheet\" type=\"text/css\">
</head>

<body leftmargin=\"0\" topmargin=\"0\" bgcolor=\"#D7EFF1\">
<form action=\"?act=instalando&op=2\" method=\"POST\">
<table width=\"90%\" align=\"center\">
 <tr>
  <td colspan=\"2\"><center><font face=\"Verdana\" size=\"5\"><b>Instalação GB Mural 2.0</b></font></center></td>
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
  <td><input type=\"text\" name=\"hosta\" value=\"localhost\" class=\"form\"></td>
 </tr>
 <tr>
  <td width=\"30%\"><font face=\"Verdana\" size=\"1\">Banco de dados:</font></td>
  <td><input type=\"text\" name=\"dba\" value=\"gbmural\" class=\"form\"></td>
 </tr>
 <tr>
  <td><font face=\"Verdana\" size=\"1\">Username:</font></td>
  <td><input type=\"text\" name=\"usera\" value=\"root\" class=\"form\"></td>
 </tr>
 <tr>
  <td><font face=\"Verdana\" size=\"1\">Senha:</font></td>
  <td><input type=\"text\" name=\"passa\" value=\"\" class=\"form\"></td>
 </tr>
 <tr>
  <td colspan=\"2\"><br><font face=\"Verdana\" size=\"1\"><b>&nbsp;&nbsp;&nbsp;-> Dados dos links</b> - Não é aconselhável mudar o nome dos arquivos.</font></td>
 </tr>
 <tr>
  <td><font face=\"Verdana\" size=\"1\">Index.php</font></td>
  <td><input type=\"text\" name=\"u_index\" value=\"index.php\" class=\"form\"></td>
 </tr>
 <tr>
  <td><font face=\"Verdana\" size=\"1\">Smilie.php</font></td>
  <td><input type=\"text\" name=\"u_smilies\" value=\"img/smilies.php\" class=\"form\"></td>
 </tr>
 <tr>
  <td><font face=\"Verdana\" size=\"1\">Ubbc.js</font></td>
  <td><input type=\"text\" name=\"u_ubbc\" value=\"ubbc.js\" class=\"form\"></td>
 </tr>
 <tr>
  <td><font face=\"Verdana\" size=\"1\">Postar.php</font></td>
  <td><input type=\"text\" name=\"u_postar\" value=\"?page=postar\" class=\"form\"></td>
 </tr>
 <tr>
  <td><font face=\"Verdana\" size=\"1\">Inserir.php</font></td>
  <td><input type=\"text\" name=\"u_inserir\" value=\"?page=inserir\" class=\"form\"></td>
 </tr>
 <tr>
  <td><font face=\"Verdana\" size=\"1\">Pasta dos Smilies</font></td>
  <td><input type=\"text\" name=\"u_psm\" value=\"img\" class=\"form\"></td>
 </tr>
 <tr>
  <td><font face=\"Verdana\" size=\"1\">Style.css</font></td>
  <td><input type=\"text\" name=\"u_css\" value=\"style.css\" class=\"form\"></td>
 </tr>
 <tr>
  <td><font face=\"Verdana\" size=\"1\">Link Paginação:</font></td>
  <td><input type=\"text\" name=\"u_pagina\" value=\"\$PHP_SELF?\" class=\"form\"></td>
 </tr>
 <tr>
  <td><br><font face=\"Verdana\" size=\"1\"><b>&nbsp;&nbsp;&nbsp;-> Outras informações</b></font></td>
  <td></td>
 </tr>
 <tr>
  <td><font face=\"Verdana\" size=\"1\">Nome do mural:</font></td>
  <td><input type=\"text\" name=\"tituloa\" value=\"GB Mural 2.0\" class=\"form\"></td>
 </tr>
 <tr>
  <td><font face=\"Verdana\" size=\"1\">Número de mensagens por página:</font></td>
  <td><input type=\"text\" name=\"msgpag\" value=\"8\" size=\"2\" class=\"form\"></td>
 </tr>
 <tr>
  <td><font face=\"Verdana\" size=\"1\">Total de mensagens:</font></td>
  <td><input type=\"text\" name=\"tmsg\" value=\"300\" size=\"4\" class=\"form\"></td>
 </tr>
 <tr>
  <td><font face=\"Verdana\" size=\"1\">Cor do tópico</font></td>
  <td><input type=\"text\" name=\"c_top\" value=\"#FFFFFF\" class=\"form\"></td>
 </tr>
 <tr>
  <td><font face=\"Verdana\" size=\"1\">ICQ não identificado.</font></td>
  <td><input type=\"text\" name=\"no_icqa\" value=\"--------\" class=\"form\"></td>
 </tr>
 <tr>
  <td><font face=\"Verdana\" size=\"1\">Mensagem de sucesso:</font></td>
  <td><input type=\"text\" name=\"msgsus\" value=\"Mensagem enviada com sucesso!\" class=\"form\"></td>
 </tr>
 <tr>
  <td><font face=\"Verdana\" size=\"1\">Mensagem de erro:</font></td>
  <td><input type=\"text\" name=\"msgerro\" value=\"Não foi possível enviar a mensagem. Tente novamente.\" class=\"form\"></td>
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
  <td><input type=\"text\" name=\"url_sitea\" value=\"http://www.meusite.com.br\" class=\"form\"></td>
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
  <td><input type=\"text\" name=\"tdmsg\" value=\"mensagens\" class=\"form\"></td>
 </tr>
 <tr>
  <td><font face=\"Verdana\" size=\"1\">Atual da tabela de usuários:</font></td>
  <td><input type=\"text\" name=\"tduser\" value=\"usuarios\" class=\"form\"></td>
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
</html>
";
} // END OP 2

} // END ACT INSTALAR
############################### INSTALANDO ############################
if($act == "instalando"){
if($op == "1"){

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
echo "
<html><head>
<title>Instalação do GB Mural 2.0 -> Por Gustavo Bissolli</title>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">
<link href=\"style.css\" rel=\"stylesheet\" type=\"text/css\">
</head>

<body leftmargin=\"0\" topmargin=\"0\" bgcolor=\"#D7EFF1\">
<table width=\"90%\" align=\"center\">
 <tr>
  <td><center><font face=\"Verdana\" size=\"5\"><b>Instalação GB Mural 2.0 -> Parte 2</b></font></center></td>
 </tr>
 <tr><td>&nbsp;</td></tr>
 <tr>
  <td><font face=\"Verdana\" size=\"4\"><b>&#149;&nbsp;Sucesso!</b></font></td>
 </tr>
 <tr>
  <td><font face=\"Verdana\" size=\"2\">
  &nbsp;  Operação exercida anteriormente concluida com sucesso!
  </font></td>
 </tr>
 <tr>
  <td><font face=\"Verdana\" size=\"4\"><b><br><br>&#149;&nbsp;Segunda parte da instalação!</b></font>
 </tr>
 <tr>
  <td><font face=\"Verdana\" size=\"2\">
  &nbsp; Os campos abaixo se referem ao gerenciamento do seu mural, coloque os dados para logar como administrador.
  </font></td>
 </tr>
 <tr>
  <td><font face=\"Verdana\" size=\"2\">
  <form action=\"?act=concluir&op=1\" method=\"POST\"><center>
  <br><br>Nome: &nbsp;&nbsp;<input type=\"text\" name=\"nome\" class=\"form\"><br>
  Usuário: <input type=\"text\" name=\"login\" class=\"form\"><br>
  Senha: &nbsp;<input type=\"text\" name=\"pass\" class=\"form\"><br><br>
  <input type=\"submit\" value=\" Concluir \" class=\"form\">&nbsp;&nbsp;&nbsp;<input type=\"reset\" value=\"  Limpar  \" class=\"form\">
  </center></form>
  </font></td>
 </tr>
 <tr>
  <td><br><br><Br><center><font face=\"Verdana\" size=\"1\"><b>Sistema desenvolvido por <a href=\"mailto:guzaum@hotmail.com\">Gustavo Bissolli</a>.</b></font></center></td>
 </tr>
</table>
</body>
</html>
";
}

} // END OP 1
elseif($op == "2"){

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
echo "
<html><head>
<title>Instalação do GB Mural 2.0 -> Por Gustavo Bissolli</title>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">
<link href=\"style.css\" rel=\"stylesheet\" type=\"text/css\">
</head>

<body leftmargin=\"0\" topmargin=\"0\" bgcolor=\"#D7EFF1\">
<table width=\"90%\" align=\"center\">
 <tr>
  <td><center><font face=\"Verdana\" size=\"5\"><b>Instalação GB Mural 2.0 -> Parte 2</b></font></center></td>
 </tr>
 <tr><td>&nbsp;</td></tr>
 <tr>
  <td><font face=\"Verdana\" size=\"4\"><b>&#149;&nbsp;Sucesso!</b></font></td>
 </tr>
 <tr>
  <td><font face=\"Verdana\" size=\"2\">
  &nbsp;  Operação exercida anteriormente concluida com sucesso!
  </font></td>
 </tr>
 <tr>
  <td><font face=\"Verdana\" size=\"4\"><b><br><br>&#149;&nbsp;Segunda parte da instalação!</b></font>
 </tr>
 <tr>
  <td><font face=\"Verdana\" size=\"2\">
  &nbsp; Os campos abaixo se referem ao gerenciamento do seu mural, coloque os dados para logar como administrador.
  </font></td>
 </tr>
 <tr>
  <td><font face=\"Verdana\" size=\"2\">
  <form action=\"?act=concluir&op=2\" method=\"POST\"><center>
  <br><br>Nome: &nbsp;&nbsp;<input type=\"text\" name=\"nome\" class=\"form\"><br>
  Usuário: <input type=\"text\" name=\"login\" class=\"form\"><br>
  Senha: &nbsp;<input type=\"text\" name=\"pass\" class=\"form\"><br><br>
  <input type=\"submit\" value=\" Concluir \" class=\"form\">&nbsp;&nbsp;&nbsp;<input type=\"reset\" value=\"  Limpar  \" class=\"form\">
  </center></form>
  </font></td>
 </tr>
 <tr>
  <td><br><br><Br><center><font face=\"Verdana\" size=\"1\"><b>Sistema desenvolvido por <a href=\"mailto:guzaum@hotmail.com\">Gustavo Bissolli</a>.</b></font></center></td>
 </tr>
</table>
</body>
</html>
";
}

} // END OP 2

} // END ACT INSTALANDO
################################## ACT CONCLUIr #############################
if($act == "concluir"){
include "conf.php";
$conexao = mysql_connect($db[host], $db[user], $db[pass]);
$selectdb = mysql_select_db($db[nome]);

if($op == "1"){
if($nome == "" || $login == "" || $pass == "") {
echo "<script>
alert(\"Volte e preencha os campos corretamente.\");
window.location = 'javascript:history.back(-1)';
</script>";
} else {

mysql_query("DROP TABLE $td[user]");
mysql_query("ALTER TABLE $td[msg] ADD COLUMN ip VARCHAR(20) NOT NULL");
mysql_query("ALTER TABLE $td[msg] CHANGE `msg` `msg` text NOT NULL");
mysql_query("CREATE TABLE  ".$td[user]." (
        id int NOT NULL auto_increment,
        login text NOT NULL,
        pass text NOT NULL,
        nome text NOT NULL,
        PRIMARY KEY (id),
    UNIQUE id (id),
    KEY id_2 (id)
        )");
        $pass = crypt($pass,"xxxhuanklomnrppdsa");
mysql_query("INSERT INTO $td[user] (id, nome, login, pass) VALUES ('$id', '$nome', '$login', '$pass')");

echo "
<html><head>
<title>Instalação do GB Mural 2.0 -> Por Gustavo Bissolli</title>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">
<link href=\"style.css\" rel=\"stylesheet\" type=\"text/css\">
</head>

<body leftmargin=\"0\" topmargin=\"0\" bgcolor=\"#D7EFF1\">
<table width=\"90%\" align=\"center\">
 <tr>
  <td><center><font face=\"Verdana\" size=\"5\"><b>Instalação GB Mural 2.0 -> Concluído</b></font></center></td>
 </tr>
 <tr><td>&nbsp;</td></tr>
 <tr>
  <td><font face=\"Verdana\" size=\"4\"><b>&#149;&nbsp;`Parabéns!</b></font></td>
 </tr>
 <tr>
  <td><font face=\"Verdana\" size=\"2\">
  &nbsp;  Atualização do GBMural realizada com sucesso! Agora você já pode acessar a página pricipal que estará funcionando tudo normalmente!
  Não foi perdida nenhuma mensagem, agora tem uma administração mais complexa, basta digitar $url_site/gbmural/admin.php e se logar com os dados informados na operação anterior.
  Você pode mudar totalmente o layout do site, basta abrir o arquivo template.htm em qualquer editor de HTML, e adaptá-lo de acordo com as necessidades do seu site!
  Não se esqueça que no lugar onde deve aparecer o conteudo do mural você deve deixar o código html: <i> &lt;!--html --> </i>.<br> Para sua maior segurança, exclua o arquivo instalar.php!
  <br><br><b>OBS:</b> Eu ficaria grato se recebesse e-mails com dicas e opiniões sobre o mural para que a próxima versão seja melhor ainda! Obrigado.
  </font></td>
 </tr>
 <tr>
  <td><font face=\"Verdana\" size=\"4\"><b><br><br>&#149;&nbsp;Obrigado pela escolha!</b></font>
 </tr>
 <tr>
  <td><br><br><Br><center><font face=\"Verdana\" size=\"1\"><b>Sistema desenvolvido por <a href=\"mailto:guzaum@hotmail.com\">Gustavo Bissolli</a>.</b></font></center></td>
 </tr>
</table>
</body>
</html>
";

}
} // END OP 1
if($op == "2"){

if($nome == "" || $login == "" || $pass == "") {
echo "<script>
alert(\"Volte e preencha os campos corretamente.\");
window.location = 'javascript:history.back(-1)';
</script>";

} else {

mysql_query("CREATE TABLE ".$td[msg]." (
        id int NOT NULL auto_increment,
        de text NOT NULL,
        para text NOT NULL,
        icq text NOT NULL,
        email text NOT NULL,
        msg text NOT NULL,
        ip text NOT NULL,
        PRIMARY KEY (id),
        UNIQUE id (id),
        KEY id_2 (id)
        )") or die (mysql_error());

mysql_query("CREATE TABLE ".$td[user]." (
        id int NOT NULL auto_increment,
        login text NOT NULL,
        pass text NOT NULL,
        nome text NOT NULL,
        PRIMARY KEY (id),
        UNIQUE id (id),
        KEY id_2 (id)
        )") or die (mysql_error());
$pass = crypt($pass,"xxxhuanklomnrppdsa");
mysql_query("INSERT INTO $td[user] (id, nome, login, pass) VALUES ('$id', '$nome', '$login', '$pass')") or die (mysql_error());

echo "
<html><head>
<title>Instalação do GB Mural 2.0 -> Por Gustavo Bissolli</title>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">
<link href=\"style.css\" rel=\"stylesheet\" type=\"text/css\">
</head>

<body leftmargin=\"0\" topmargin=\"0\" bgcolor=\"#D7EFF1\">
<table width=\"90%\" align=\"center\">
 <tr>
  <td><center><font face=\"Verdana\" size=\"5\"><b>Instalação GB Mural 2.0 -> Concluído</b></font></center></td>
 </tr>
 <tr><td>&nbsp;</td></tr>
 <tr>
  <td><font face=\"Verdana\" size=\"4\"><b>&#149;&nbsp;`Parabéns!</b></font></td>
 </tr>
 <tr>
  <td><font face=\"Verdana\" size=\"2\">
  &nbsp;  Instalação do GBMural realizada com sucesso! Agora você já pode acessar a página pricipal que estará funcionando tudo normalmente!
  Não foi perdida nenhuma mensagem, agora tem uma administração mais complexa, basta digitar $url_site/gbmural/admin.php e se logar com os dados informados na operação anterior.
  Você pode mudar totalmente o layout do site, basta abrir o arquivo template.htm em qualquer editor de HTML, e adaptá-lo de acordo com as necessidades do seu site!
  Não se esqueça que no lugar onde deve aparecer o conteudo do mural você deve deixar o código html: <i> &lt;!--html --> </i>.<br> Para sua maior segurança, exclua o arquivo instalar.php!
  <br><br><b>OBS:</b> Eu ficaria grato se recebesse e-mails com dicas e opiniões sobre o mural para que a próxima versão seja melhor ainda! Obrigado.
  </font></td>
 </tr>
 <tr>
  <td><font face=\"Verdana\" size=\"4\"><b><br><br>&#149;&nbsp;Obrigado pela escolha!</b></font>
 </tr>
 <tr>
  <td><br><br><Br><center><font face=\"Verdana\" size=\"1\"><b>Sistema desenvolvido por <a href=\"mailto:guzaum@hotmail.com\">Gustavo Bissolli</a>.</b></font></center></td>
 </tr>
</table>
</body>
</html>
";

}

} // END OP 2
} // END ACT CONCLUIR
?>
