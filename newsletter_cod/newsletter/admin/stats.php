<font face=verdana size=1>
<?
/* WEB - TOOLS - www.web-tools.kit.net [ Caso essa linha seja apagada
o sistema irá parar de funcionar] */
include "config.php";
$todos = @mysql_query("SELECT * FROM $tb1");
$emails = @mysql_query("SELECT * FROM $tb3");
$sql= @mysql_query("SELECT * FROM $tb2 ORDER BY posts ASC");
$menos_ativo1= @mysql_query("SELECT * FROM $tb2 ORDER BY posts DESC");
 while ($reg = @mysql_fetch_array($sql)){
 $mais_ativo = $reg['autor'];
 }
 while ($reg = mysql_fetch_array($menos_ativo1)){
 $menos_ativo = $reg['autor'];
 }
$emailsn=@mysql_num_rows($emails);
$todosn=@mysql_num_rows($todos);
echo "
<object classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0\" width=\"15\" height=\"15\">
       <param name=\"movie\" value=\"quadrado.swf\">
       <param name=\"quality\" value=\"high\">
        <embed src=\"quadrado.swf\" quality=\"high\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\" type=\"application/x-shockwave-flash\" width=\"15\" height=\"15\"></embed></object>
      <strong>Total de usuarios:</strong> $todosn<br>
      ";
	  echo "
<object classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0\" width=\"15\" height=\"15\">
       <param name=\"movie\" value=\"quadrado.swf\">
       <param name=\"quality\" value=\"high\">
        <embed src=\"quadrado.swf\" quality=\"high\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\" type=\"application/x-shockwave-flash\" width=\"15\" height=\"15\"></embed></object>
      <strong>E-mails Cadastrados:</strong> $emailsn<br>
      ";
      global $mais_ativo;
      	  echo "
<object classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0\" width=\"15\" height=\"15\">
       <param name=\"movie\" value=\"quadrado.swf\">
       <param name=\"quality\" value=\"high\">
        <embed src=\"quadrado.swf\" quality=\"high\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\" type=\"application/x-shockwave-flash\" width=\"15\" height=\"15\"></embed></object>
      <strong>Mais Ativo:</strong> $mais_ativo<br>
      ";
            global $menos_ativo;
      	  echo "
<object classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0\" width=\"15\" height=\"15\">
       <param name=\"movie\" value=\"quadrado.swf\">
       <param name=\"quality\" value=\"high\">
        <embed src=\"quadrado.swf\" quality=\"high\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\" type=\"application/x-shockwave-flash\" width=\"15\" height=\"15\"></embed></object>
      <strong>Menos Ativo:</strong> $menos_ativo<br>
      ";
mysql_close($conexao);
?>
