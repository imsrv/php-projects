<?
//Arquico com estilo de link
include "stl.php";
// Incuindo o arquivo de configuração
include "config.php";
?>
<html>
<?
//A variavel $tituloshz define o titulo do site.
//Essa variavel pode ser alterada no config.php
?>
<title><? echo $tituloshz; ?></title>
<body bgcolor="<? echo $colorbg; ?>" onload="setTimeout ('window.location.reload(true)',900000)">

<table align='head' bgcolor='<? echo $colorbg; ?>' cellpadding='0' cellspacing='0' border='0'>
<tr>
<td align='right' bgcolor='<? echo $colorbg; ?>' nowrap>
</a>
</td>
<tr>
<td>
<table bgcolor='<? echo $colorbg; ?>' cellpadding='4' cellspacing='1' border='0'>
<tr> 
<td bgcolor='<? echo $colorbg; ?>'><b>
<font size='<? echo $sizetex1; ?>'>
| <a href='<? echo "$PHP_SELF"; ?>'><font color='<? echo $colortex; ?>'>CADASTRAR</font></a> |
 <a href='<? echo "$PHP_SELF?viewby=excluir"; ?>'><font color='<? echo $colortex; ?>'>EXCLUIR</font></a> |
 <a href='<? echo "$PHP_SELF?viewby=alterar"; ?>'><font color='<? echo $colortex; ?>'>ALTERAR</font></a> |
 <a href='<? echo "$PHP_SELF?viewby=ver"; ?>'><font color='<? echo $colortex; ?>'>VER</font></a> |
 <a href='<? echo "$PHP_SELF?viewby=back"; ?>'><font color='<? echo $colortex; ?>'>BACKUP</font></a> |
</font>
</td>
</tr>
<tr>
<td nowrap>
<br>
