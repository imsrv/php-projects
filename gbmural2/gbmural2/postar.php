<?php

$html = "<html>
<head>
<title>".$titulo."</title>
<link href=\"".$link[style.css]."\" rel=\"stylesheet\" type=\"text/css\">
</head>
<body>
<form name=\"mural\" action=\"".$link[inserir]."\" method=\"post\">
<table width=\"90%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
<tr>
<td><p align=\"center\"><font size=\"3\" face=\"Verdana\"><img src=\"".$link[psm]."/cool.gif\"> <b>..:: Enviar uma mensagem ::..</b> <img src=\"".$link[psm]."/grin.gif\"></font></p></td>
</tr>
<tr>
<td>
 <table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" align=\"center\">
  <tr>
   <td colspan=\"2\">&nbsp;</td>
  </tr>
  <tr>
   <td colspan=\"2\">
   <font size=\"2\" face=\"Verdana\">OBS: Todos os campos que conter um asterístico(*), é obrigatório o preenchimento do mesmo.</font>
   </td>
  </tr>
  <tr>
   <td colspan=\"2\">&nbsp;</td>
  </tr>
  <tr>
   <td width=\"20%\"><font size=\"2\" face=\"Verdana\">Seu nome*:</font></td>
   <td><input name=\"de\" type=\"text\" size=\"40\" maxlength=\"30\" style=\"font-family: Verdana; font-size: 10 pt; border-style: solid; border-width: 1\"></td>
  </tr>
  <tr>
   <td><font size=\"2\" face=\"Verdana\">Seu e-mail:</font></td>
   <td><input name=\"email\" type=\"text\" size=\"40\" maxlength=\"40\" style=\"font-family: Verdana; font-size: 10 pt; border-style: solid; border-width: 1\"></td>
  </tr>
  <tr>
   <td><font size=\"2\" face=\"Verdana\">Seu ICQ:</font></td>
   <td><input name=\"icq\" type=\"text\" size=\"40\" maxlength=\"9\" style=\"font-family: Verdana; font-size: 10 pt; border-style: solid; border-width: 1\"></td>
  </tr>
  <tr>
   <td><font size=\"2\" face=\"Verdana\">Mensagem para*:</font></td>
   <td><input name=\"para\" type=\text\" size=\"40\" maxlength=\"30\"style=\"font-family: Verdana; font-size: 10 pt; border-style: solid; border-width: 1\"></td>
  </tr>
 </table>
</td>
</tr>
<tr>
<td>&nbsp;</td>
</tr>
<tr>
<td>
 <table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" align=\"center\">
  <tr>
   <td colspan=\"2\"><p align=\"center\"><font size=\"2\" face=\"Verdana\">Mensagem*:</font></p></td>
  </tr>
  <tr>
  <td>";
// Adiciona os smiles
if ($smyles == 1){
$html .= "<script language=\"JavaScript1.2\" src=\"$link[ubbc]\" type=\"text/javascript\"></script>
<font face=\"Verdana\" color=\"#000000\" size=\"1\"><b>Smyles :</b></font>
<script language=\"JavaScript1.2\" type=\"text/javascript\">
<!--
if((navigator.appName == \"Netscape\" && navigator.appVersion.charAt(0) >= 4) || (navigator.appName == \"Microsoft Internet Explorer\" && navigator.appVersion.charAt(0) >= 4) || (navigator.appName == \"Opera\" && navigator.appVersion.charAt(0) >= 4)) {
document.write(\"<a href=javascript:smiley()><img src='".$link[psm]."/smiley.gif' align='bottom' alt='$texto_14' border='0'></a> \");
document.write(\"<a href=javascript:wink()><img src='".$link[psm]."/wink.gif' align='bottom' alt='$texto_15' border='0'></a> \");
document.write(\"<a href=javascript:cheesy()><img src='".$link[psm]."/cheesy.gif' align='bottom' alt='$texto_16' border='0'></a> \");
document.write(\"<a href=javascript:grin()><img src='".$link[psm]."/grin.gif' align='bottom' alt='$texto_17' border='0'></a> \");
document.write(\"<a href=javascript:angry()><img src='".$link[psm]."/angry.gif' align='bottom' alt='$texto_18' border='0'></a> \");
document.write(\"<a href=javascript:sad()><img src='".$link[psm]."/sad.gif' align='bottom' alt='$texto_19' border='0'></a> \");
document.write(\"<a href=javascript:shocked()><img src='".$link[psm]."/shocked.gif' align='bottom' alt='$texto_20' border='0'></a> \");
document.write(\"<a href=javascript:cool()><img src='".$link[psm]."/cool.gif' align='bottom' alt='$texto_21' border='0'></a> \");
document.write(\"<a href=javascript:huh()><img src='".$link[psm]."/huh.gif' align='bottom' alt='$texto_22' border='0'></a> \");
document.write(\"<a href=javascript:rolleyes()><img src='".$link[psm]."/rolleyes.gif' align='bottom' alt='$texto_23' border='0'></a> \");
document.write(\"<a href=javascript:tongue()><img src='".$link[psm]."/tongue.gif' align='bottom' alt='$texto_24' border='0'></a> \");
document.write(\"<a href=javascript:embarassed()><img src='".$link[psm]."/embarassed.gif' align='bottom' alt='$texto_25' border='0'></a> \");
document.write(\"<a href=javascript:lipsrsealed()><img src='".$link[psm]."/lipsrsealed.gif' align='bottom' alt='$texto_26' border='0'></a> \");
document.write(\"<a href=javascript:undecided()><img src='".$link[psm]."/undecided.gif' align='bottom' alt='$texto_27' border='0'></a> \");
document.write(\"<a href=javascript:kiss()><img src='".$link[psm]."/kiss.gif' align='bottom' alt='$texto_28' border='0'></a> \");
document.write(\"<a href=javascript:cry()><img src='".$link[psm]."/cry.gif' align='bottom' alt='$texto_29' border='0'></a> \");
document.write(\"<a href=javascript:coracao()><img src='".$link[psm]."/coracao.gif' width='15' height='15' align='bottom' alt='Coração' border='0'></a> \");
} else {
document.write(\"<font size=1>Houve algum erro ao encontrar os Smyles.</font>\");
}
//-->
</script>
<noscript>
<font size=\"1\">Houve algum erro ao encontrar os Smyles.</font>
</noscript>";
} else {
$html .= "&nbsp;";
}
if ($smyles == 1){
$html .= "<a href=\"#\" onClick=\"window.open('$link[smiles]','','width=535,height=300')\"><p align=\"center\"><font face=verdana size=1 color=red>[ mais smyles ]</font></p></a>";
} else {
$html .= "&nbsp;";
}

$html .= "</td>
  </tr>
  <tr>
  <td>
  <textarea name=\"msg\" cols=\"50\" rows=\"8\" wrap=\"VIRTUAL\" style=\"font-family: Verdana; font-size: 10 pt; border-style: solid; border-width: 1\"></textarea>
  </td>
  </tr>
 </table>
</td>
</tr>
<tr>
<td><br>
<p align=\"center\">
<input type=\"submit\" name=\"Submit\" value=\"  Enviar  \" style=\"font-family: Verdana; font-size: 10 pt; border-style: solid; border-width: 1\">
<input type=\"reset\" name=\"reset\" value=\"  Apagar  \" style=\"font-family: Verdana; font-size: 10 pt; border-style: solid; border-width: 1\">
</p><br>
</td>
</tr>
</table>
</form>
</body>
</html>";
?>
