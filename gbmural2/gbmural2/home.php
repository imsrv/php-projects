<?
$sql = "SELECT * FROM ".$td[msg]." WHERE id order by id desc LIMIT 0, 30";
$conex = mysql_db_query($db[nome], $sql, $conexao);
$oSQL = "SELECT * FROM $td[msg] LIMIT 0, ".$tm."";
$conexa = mysql_db_query($db[nome], $oSQL, $conexao);
$ordem = mysql_num_rows($conexa);

// Faz os calculos da paginação
$sql2 = mysql_query("SELECT * FROM ".$td[msg]." WHERE id ORDER BY id DESC LIMIT 0, ".$tm."");
$total = mysql_num_rows($sql2); // Esta função irá retornar o total de linhas na tabela
$paginas = ceil($total / $lpp); // Retorna o total de páginas
if(!isset($pagina)) { $pagina = 0; } // Especifica uma valor para variavel pagina caso a mesma não esteja setada
$inicio = $pagina * $lpp; // Retorna qual será a primeira linha a ser mostrada no MySQL
$sql2 = mysql_query("SELECT * FROM $td[msg] WHERE id order by id desc LIMIT $inicio, $lpp"); // Executa a query no MySQL com o limite de linhas.

$html = "<html><head>
<title>Principal</title>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">
<link href=\"".$link[css]."\" rel=\"stylesheet\" type=\"text/css\">
</head>

<body>
<p align=center><font face=\"Verdana\" size=\"2\"><b>";
  if($pagina == "" || $pagina == "0") {
$html .= "Últimas mensagens postadas.";
  } else {
$html .= "Página número ".$pagina.".";
  }
$html .= " $titulo</b></font></p>
<p align=center><font face=\"Verdana\" size=\"1\"><a href=\"$link[postar]\"><b>// Postar uma mensagem \\\\</b></a></font></p> <b>
</center>
<p>
";
if ($total == 0) {
$html .= "<p align=\"center\"><font size=\"1\" face=\"Verdana\">Não há nenhuma mensagem postada até o presente momento.</font></p>";
} else {

while($valor = mysql_fetch_array($sql2)) {

$html .= "<table align=\"center\" border=\"0\" width=\"95%\">
 <tr>
  <td>
  <table align=\"center\" border=\"0\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\">
  <tr valign=\"middle\" height=\"20\">
  <td bgcolor=\"".$cor[topico]."\" width=\"10%\"><font face=\"Verdana\" size=\"1\">";
  if($valor[icq] != "") {
$html .= "<center><img src=\"http://web.icq.com/whitepages/online?icq=".$valor[icq]."&img=7\"></center>  ";
   } else {
$html .= "<center><font face=\"Verdana\" size=\"1\">".$no_icq."</font></center>";
}
$html .= "</font></td>
  <td bgcolor=\"".$cor[topico]."\">
  <font face=\"Verdana\" size=\"1\">";
  if($valor[email] != "") {
$html .= "<a href=\"mailto:".$valor[email]."\"><b>".$valor[de]."</b></a>";
  } else {
$html .= "<b>".$valor[de]."</b>";
  }
if($valor[icq] != "") {
$html .= " (ICQ#:".$valor[icq].")";
   }
$html .= " mandou uma mensagem para <b>".$valor[para]."</b>.
  </td>
 </tr>
 <tr>
  <td colspan=\"2\">
   <font face=\"Verdana\" size=\"1\"><b>Mensagem: </b></a> ".$valor[msg]."</font>
  </td>
 </tr>
 <tr>
  <td colspan=\"2\"><center><font face=\"Verdana\" size=\"1\">---------------------------------------------------</font></center></td>
 </tr>
</table>
  </td>
 </tr>
</table>
</p>";
}
}
// Paginação
$html .= "<center>";
if($pagina > 0) {
   $menos = $pagina - 1;
   $url = "$paginacao[link]&pagina=$menos";
   $html .= "<a href=\"$url\"><font face=\"Verdana\" size=\"1\">Anterior</font></a>"; // Vai para a página anterior
}
for($i=0;$i<$paginas;$i++) { // Gera um loop com o link para as páginas
   $url = "$paginacao[link]pagina=$i";
   $html .= " | <a href=\"$url\"><font face=\"Verdana\" size=\"1\">$i</font></a>";
}
if($pagina < ($paginas - 1)) {
   $mais = $pagina + 1;
   $url = "$paginacao[link]pagina=$mais";
   $html .= " | <a href=\"$url\"><font face=\"Verdana\" size=\"1\">Próxima</font></a>";
}

$html .= "</center>
<font face=\"Verdana\" size=\"1\">
<p align=\"center\">
Temos um total de <b>".$ordem." </b>";
if ($ordem == "1") { $html .= "mensagem "; } else { $html .= "mensagens "; }
if ($ordem == "1") { $html .= "postada!"; } else { $html .= "postadas!"; }
$html .= "
</p>
</font>
</body>
</html>";
?>
