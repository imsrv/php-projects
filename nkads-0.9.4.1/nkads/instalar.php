<?
//**********************************************************************************
// NKAds                                                                                           *
//**********************************************************************************
//
// Copyright (c) 2002 NKStudios S.R.L.
// http://nkads.nkstudios.net
//
// This program is free software. You can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 2 of the License.
//
//**********************************************************************************
?>
<head>
<link rel="stylesheet" href="nkadsmin/estilos.css" type="text/css">
</head>
<body bgcolor="#FFCC00" text="#000000" link="#000000" vlink="#000000" alink="#000000">
<?
switch ($paso){
	case "1":
  		//Verifico el tipo de servidor en donde estoy instalando...
		if (strtoupper(substr(PHP_OS, 0,3) == 'WIN')){
			include("nkadsmin\\lenguajes\\$lenguaje");
		}else{
			include("nkadsmin/lenguajes/$lenguaje");
		}
?>
<form action="<? echo $PHP_SELF ?>?paso=2" method="POST">
  <table width="760" border="1" cellspacing="0" cellpadding="0" align="center" bordercolor="#D7AC00">
    <tr> 
      <td height="20"> 
        <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
          <tr> 
            <td width="100%" bgcolor="#D7AC00" height="55" valign="middle"> <font face="Verdana, Arial, Helvetica, sans-serif" size="2">
              </font> <img src="nkadsmin/imgcomunes/logo.gif" width="225" height="35"></td>
          </tr>
          <tr> 
            <td width="100%" bgcolor="#D7AC00" height="55"> 
              <table width="100%" border="1" cellspacing="0" cellpadding="0" bordercolor="#F4C400" bgcolor="#FFCC00">
                <tr> 
                  <td> 
                    <div align="center"> <font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                      <? echo $nkads_traduccion[172] ?>
                      </font></div>
                  </td>
                </tr>
                <tr> 
                  <td> <br>
                    <table width="336" border="0" cellspacing="0" cellpadding="0" align="center">
                      <tr> 
                        <td width="188"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">
                          <? echo $nkads_traduccion[171] ?>
                          </font></td>
                        <td width="148"> 
                          <input type="text" name="usuario" class="campos">
                        </td>
                      </tr>
                      <tr>
                        <td width="188"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                          <? echo $nkads_traduccion[170] ?>
                          </font></td>
                        <td width="148"> 
                          <input type="text" name="password" class="campos">
                        </td>
                      </tr>
                      <tr> 
                        <td width="188"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                          <? echo $nkads_traduccion[169] ?>
                          </font></td>
                        <td width="148"> 
                          <input type="text" name="based" value="nkads" class="campos">
                        </td>
                      </tr>
                      <tr> 
                        <td width="188"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                          <? echo $nkads_traduccion[168] ?>
                          </font></td>
                        <td width="148">
                          <input type="text" name="host" value="localhost" class="campos">
                        </td>
                      </tr>
                    </table>
                    <div align="center"><br>
                      <input type="submit" name="submit" class="botones" value="<? echo $nkads_traduccion[21] ?>">
                      <input type="hidden" name="lenguaje" value="<? echo $lenguaje ?>">
                      <br>
                      &nbsp; </div>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</form>
<?
	break;
	case "2":
		//Verifico el tipo de servidor en donde estoy instalando...
		if (strtoupper(substr(PHP_OS, 0,3) == 'WIN')){
			include("nkadsmin\\lenguajes\\$lenguaje");
		}else{
			include("nkadsmin/lenguajes/$lenguaje");
		}
if (!@$db = mysql_connect($host, $usuario,$password)){
	$control_error = $nkads_traduccion[167]."<br>";
}
if(!@mysql_select_db($based,$db)){
	$control_error = $nkads_traduccion[166]."<br>";
}

if ($control_error <> "") {
?>
<table width="760" border="1" cellspacing="0" cellpadding="0" align="center" bordercolor="#D7AC00">
  <tr>
    <td height="20">
      <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
        <tr>
          <td width="100%" bgcolor="#D7AC00" height="55"> <img src="nkadsmin/imgcomunes/logo.gif" width="225" height="35"></td>
        </tr>
        <tr>
          <td width="100%">
            <table width="100%" border="1" cellspacing="0" cellpadding="0" bordercolor="#F4C400">
              <tr>
                <td>
                  <div align="center"> <font face="Verdana, Arial, Helvetica, sans-serif" size="1">
                    <? echo $nkads_traduccion[151] ?>
                    </font></div>
                </td>
              </tr>
              <tr>
                <td>
                  <div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><br>
<?
echo $control_error;
?>
                    <br>
                    <br>
                    <a href="javascript:history.back();" class="negro">
                    <? echo $nkads_traduccion[33] ?>
                    </a> </font> </div>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<?
exit;
}
?>
<form action="<? echo $PHP_SELF ?>?paso=3" method="POST">
  <table width="760" border="1" cellspacing="0" cellpadding="0" align="center" bordercolor="#D7AC00">
    <tr>
      <td height="20">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
          <tr>
            <td width="100%" bgcolor="#D7AC00" height="55"> <img src="nkadsmin/imgcomunes/logo.gif" width="225" height="35"></td>
          </tr>
          <tr>
            <td width="100%">
              <table width="100%" border="1" cellspacing="0" cellpadding="0" bordercolor="#F4C400">
                <tr>
                  <td>
                    <div align="center"> <font face="Verdana, Arial, Helvetica, sans-serif" size="1">
                      <? echo $nkads_traduccion[164] ?>
                      </font></div>
                  </td>
                </tr>
                <tr>
                  <td> <br>
                    <table width="334" border="0" cellspacing="0" cellpadding="0" align="center">
                      <tr>
                        <td width="185"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">URL</font></td>
                        <td width="149">
                          <input type="text" name="url_instalacion" value="http://" class="campos" size="30">
                        </td>
                      </tr>
                      <tr>
                        <td width="185"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo $nkads_traduccion[237] ?></font></td>
                        <td width="149">
                          <input type="text" name="mail_administrador" class="campos" size="30">
                        </td>
                      </tr>
                      <tr>
                        <td width="185"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">
                          <? echo $nkads_traduccion[163] ?>
                          </font></td>
                        <td width="149">
                          <select name="fecha" class="select">
                            <option value="A-M-D">
                            <? echo $nkads_traduccion[62] ."-". $nkads_traduccion[61] ."-". $nkads_traduccion[60] ?>
                            </option>
                            <option value="M-D-A">
                            <? echo $nkads_traduccion[61] ."-". $nkads_traduccion[60] ."-". $nkads_traduccion[62] ?>
                            </option>
                            <option value="D-M-A">
                            <? echo $nkads_traduccion[60] ."-". $nkads_traduccion[61] ."-". $nkads_traduccion[62] ?>
                            </option>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td width="185"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">
                          <? echo $nkads_traduccion[162] ?>
                          </font></td>
                        <td width="149">
                          <input type="text" name="usuario_admin" class="campos">
                        </td>
                      </tr>
                      <tr>
                        <td width="185"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">
                          <? echo $nkads_traduccion[183] ?>
                          </font></td>
                        <td width="149">
                          <input type="text" name="password_admin" class="campos">
                        </td>
                      </tr>
                    </table>
                    <div align="center"><br>
                      <input type="submit" name="submit" class="botones" value="<? echo $nkads_traduccion[21] ?>">
                      <input type="hidden" name="lenguaje" value="<? echo $lenguaje ?>">
                      <input type="hidden" name="host" value="<? echo $host ?>">
                      <input type="hidden" name="password" value="<? echo $password ?>">
                      <input type="hidden" name="usuario" value="<? echo $usuario ?>">
                      <input type="hidden" name="based" value="<? echo $based ?>">
                      <br>
                      &nbsp; </div>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</form>
<?
	break;
	case "3":
  		//Verifico el tipo de servidor en donde estoy instalando...
		if (strtoupper(substr(PHP_OS, 0,3) == 'WIN')){
			include("nkadsmin\\lenguajes\\$lenguaje");
		}else{
			include("nkadsmin/lenguajes/$lenguaje");
		}
?>
<?
$db = mysql_connect($host, $usuario,$password);
mysql_select_db($based,$db);
$tablas[ads_banners]="CREATE TABLE ads_banners (
  id int(9) NOT NULL auto_increment,
  id_cliente int(6) NOT NULL default '0',
  tipo char(1) NOT NULL default '',
  contenido varchar(255) NOT NULL default '',
  link varchar(255) NOT NULL default '',
  nombre varchar(255) NOT NULL default '',
  alt varchar(60) NOT NULL default '',
  target char(1) NOT NULL default '',
  url char(1) NOT NULL default '',
  fecha_inicio date NOT NULL default '0000-00-00',
  fecha_fin date NOT NULL default '0000-00-00',
  imp_compradas int(9) NOT NULL default '0',
  activo char(1) NOT NULL default '0',
  PRIMARY KEY  (id),
  KEY id_cliente (id_cliente)
) TYPE=MyISAM;";

$tablas[ads_clientes]="CREATE TABLE ads_clientes (
  id int(6) NOT NULL auto_increment,
  empresa varchar(100) NOT NULL default '',
  domicilio varchar(100) NOT NULL default '',
  ciudad varchar(50) NOT NULL default '',
  provincia varchar(30) NOT NULL default '',
  pais varchar(30) NOT NULL default '',
  telefono varchar(25) NOT NULL default '',
  fax varchar(25) NOT NULL default '',
  email varchar(60) NOT NULL default '',
  url varchar(120) NOT NULL default '',
  user varchar(20) NOT NULL default '',
  pass varchar(20) NOT NULL default '',
  acceso int(1) NOT NULL default '0',
  PRIMARY KEY  (id)
) TYPE=MyISAM;";

$tablas[ads_master]="CREATE TABLE ads_master (
  usuario varchar(100) NOT NULL default '',
  password varchar(100) NOT NULL default ''
) TYPE=MyISAM;";

$tablas[ads_zonas]="CREATE TABLE ads_zonas (
  id int(6) NOT NULL auto_increment,
  id_banner int(9) NOT NULL default '0',
  nombre varchar(50) NOT NULL default '',
  id_cliente int(6) NOT NULL default '0',
  PRIMARY KEY  (id),
  UNIQUE KEY nombre (nombre),
  KEY id_banner (id_banner)
) TYPE=MyISAM;";

$tablas[ads_zonas_banners]="CREATE TABLE ads_zonas_banners (
  id_zona int(6) NOT NULL default '0',
  id_banner int(9) NOT NULL default '0',
  KEY id_zona (id_zona),
  KEY id_banner (id_banner)
) TYPE=MyISAM;";


$tablas[ads_estadisticas]="CREATE TABLE ads_estadisticas (
  fecha date NOT NULL default '0000-00-00',
  id_banner int(6) NOT NULL default '0',
  impresiones int(9) NOT NULL default '0',
  clicks int(9) NOT NULL default '0',
  KEY fecha (fecha,id_banner)
) TYPE=MyISAM;";

while (list ($indice, $valor) = each ($tablas)) {
	if(!@$result = mysql_query($valor,$db)){
		$control_error = $nkads_traduccion[165]. "<b>" . $indice . "</b>" . $nkads_traduccion[241] . "<br>";
	}
}

if ($control_error <> "") {
?>
<table width="760" border="1" cellspacing="0" cellpadding="0" align="center" bordercolor="#D7AC00">
  <tr>
    <td height="20">
      <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
        <tr>
          <td width="100%" bgcolor="#D7AC00" height="55"> <img src="nkadsmin/imgcomunes/logo.gif" width="225" height="35"></td>
        </tr>
        <tr>
          <td width="100%">
            <table width="100%" border="1" cellspacing="0" cellpadding="0" bordercolor="#F4C400">
              <tr>
                <td>
                  <div align="center"> <font face="Verdana, Arial, Helvetica, sans-serif" size="1">
                    <? echo $nkads_traduccion[151] ?>
                    </font></div>
                </td>
              </tr>
              <tr>
                <td>
                  <div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><br>
<?
echo $control_error;
?>
                    <br>
                    <br>
                    <a href="javascript:history.back();" class="negro">
                    <? echo $nkads_traduccion[33] ?>
                    </a> </font> </div>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<?
exit;
}
if(!@$archivo = fopen("nkads.conf.php",w)){
	echo $nkads_traduccion[161];
	exit;
}else{
	$ubicacion = addslashes(realpath ("."));
	fwrite($archivo,"<?
//////////////////////////////////////////////////////
//   $nkads_traduccion[173]   //
////////////////////////////////////////////////////

// $nkads_traduccion[174] \n" .
'$idioma' ."= \"$lenguaje\";


///////////////////////////////////////////////////////////
//   $nkads_traduccion[175]   //
//////////////////////////////////////////////////////////

". '$db'. " = mysql_connect(\"". $host ."\", \"". $usuario ."\",\"". $password ."\");
mysql_select_db(\"$based\",". '$db'. ");
//////////////////////////////////////////////////////
//    $nkads_traduccion[176]   //
///////////////////////////////////////////////////

// $nkads_traduccion[177] : \"A-M-D\" - \"M-D-A\" - \"D-M-A\"\n".
'$formato_fecha'. "= \"$fecha\";

//////////////////////////////////////////////////////
//   // $nkads_traduccion[178]             //
///////////////////////////////////////////////////

// $nkads_traduccion[179]
// $nkads_traduccion[180] \n". '$url_nkads'. " = \"$url_instalacion\";
". '$mail_administrador' ."=\"$mail_administrador\";
". '$path_absoluto' ."=\"$ubicacion\";

?>");
fclose($archivo);
$nombre_archivo = "muestra.php";
$id_archivo = fopen ($nombre_archivo, "r");
$contenido = fread ($id_archivo, filesize($nombre_archivo));
fclose ($id_archivo);
$contenido = substr($contenido,2,strlen($contenido));
if(!@$id_archivo = fopen($nombre_archivo,w)){
	echo $nkads_traduccion[161];
	exit;
}else{
	if (strtoupper(substr(PHP_OS, 0,3) <> 'WIN')){
		$donde = "include(\"$ubicacion/nkads.conf.php\");
//funciones
include(\"$ubicacion/funciones.inc.php\");";
	}else{
		// Si alguien conoce alguna forma mejor de poner doble barras invertidas nkads@nkstudios.net
		$donde = "include(\"$ubicacion". '\\' .'\\'. "nkads.conf.php\");
//funciones
include(\"$ubicacion\\\funciones.inc.php\");";
	}
	$contenido = trim($contenido);
	fwrite($id_archivo,
"<?
//cargo configuracion
$donde\n$contenido");
fclose($id_archivo);
}

$nombre_archivo = "muestrajs.php";
$id_archivo = fopen ($nombre_archivo, "r");
$contenido = fread ($id_archivo, filesize ($nombre_archivo));
fclose ($id_archivo);
$contenido = substr($contenido,2,strlen($contenido));
if(!@$id_archivo = fopen($nombre_archivo,w)){
	echo $nkads_traduccion[161];
	exit;
}else{
	if (strtoupper(substr(PHP_OS, 0,3) <> 'WIN')){
		$donde = "include(\"$ubicacion/nkads.conf.php\");
//funciones
include(\"$ubicacion/funciones.inc.php\");";
	}else{
		// Si alguien conoce alguna forma mejor de poner doble barras invertidas nkads@nkstudios.net
		$donde = "include(\"$ubicacion". '\\' .'\\'. "nkads.conf.php\");
//funciones
include(\"$ubicacion\\\funciones.inc.php\");";
	}
	$contenido = trim($contenido);
	fwrite($id_archivo,
"<?
//cargo configuracion
$donde\n$contenido");
fclose($id_archivo);
}
$sql = "INSERT INTO ads_master VALUES ('$usuario_admin','$password_admin')";
$result = mysql_query($sql,$db);

//No remover Por Favor!!! Esto es solo para tener una referencia de las copias instaladas (gracias)
mail("nkads@nkstudios.net","NKAds 0.9.4 se instalo en $url_instalacion","NKAds Instalado","From: $mail_administrador");
}
?>
<table width="760" border="1" cellspacing="0" cellpadding="0" align="center" bordercolor="#D7AC00">
  <tr>
    <td height="20">
      <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
        <tr>
          <td width="100%" bgcolor="#D7AC00" height="55">
            <div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">
              </font> <img src="nkadsmin/imgcomunes/logo.gif" width="225" height="35"></div>
          </td>
        </tr>
        <tr>
          <td width="100%">
            <div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><br>
              <? echo $nkads_traduccion[182] ?>
              <br>
              &nbsp; </font></div>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<?
	break;
	default:
?>
<form action="<? echo $PHP_SELF ?>?paso=1" method="POST">
  <table width="760" border="1" cellspacing="0" cellpadding="0" align="center" bordercolor="#D7AC00">
    <tr>
      <td height="20">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
          <tr>
            <td width="100%" bgcolor="#D7AC00" height="55" valign="middle"> <img src="nkadsmin/imgcomunes/logo.gif" width="225" height="35"></td>
          </tr>
          <tr>
            <td width="100%">
              <table width="100%" border="1" cellspacing="0" cellpadding="0" bordercolor="#F4C400">
                <tr>
                  <td>
                    <div align="center"> <font face="Verdana, Arial, Helvetica, sans-serif" size="1">Lenguaje
                      - Language - L&iacute;ngua - Langage - Linguaggio - Sprache
                      </font></div>
                  </td>
                </tr>
                <tr>
                  <td>
                    <div align="center"><br>
                      <select name="lenguaje" class="select">
		<option value="espaniol.inc.php">Español</option>
		<option value="english.inc.php">English</option>
		<option value="french.inc.php">Les français</option>
		<option value="german.inc.php">Deutscher</option>
		<option value="hungarian.inc.php">Hungarian</option>
		<option value="indonesian.inc.php">Indonesian</option>
		<option value="italiano.inc.php">Italiano</option>
		<option value="portuguese_br.inc.php">Portugues (BR)</option>
		<option value="portuguese_pt.inc.php">Portugues (PT)</option>
                      </select><br><br>
                      <input type="submit" name="submit" value="OK" class="botones">
                      <br>
                      &nbsp; </div>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</form>
<?
break;
}
?>
</body>
</html>