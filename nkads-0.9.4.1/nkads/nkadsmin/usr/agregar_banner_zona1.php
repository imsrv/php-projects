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


//Cargo archivo de seguridad
include("seguridad.inc.php");
if($acceso_usuario == 0){
	header("Location: index.php");
	exit;
}
//verifico que el banner no se encuentre en la zona y guardo los datos en ads_zonas_banners
$error = 0;

$sql = "Select * from ads_zonas_banners where (id_zona = $id_zona) AND (id_banner = $id_banner)";
$result = mysql_query($sql);
if ($row = mysql_fetch_array($result)){
	$error = 1;
}else{
	$sql = "Insert into ads_zonas_banners values ($id_zona, $id_banner)";
	$result = mysql_query($sql);
}
?>
<link rel="stylesheet" href="../estilos.css" type="text/css">
<body bgcolor="#FFCC00" text="#000000" link="#000000" vlink="#000000" alink="#000000" leftmargin="0" topmargin="0">
<div align="center"> <font face="Verdana, Arial, Helvetica, sans-serif" size="-2" color="#000000"><br>
  <br>
  <?
    if ($error == 1){
    	echo "<b>".$nkads_traduccion[151]. "</b><br>" . $nkads_traduccion[41] . " " . $id_banner . " " . $nkads_traduccion[150] . " " . $nombre_zona;
    }else{
    	echo "<b>".$nkads_traduccion[153]. "</b><br>" . $nkads_traduccion[41] . " " . $id_banner . " " . $nkads_traduccion[44]  . " " . $nombre_zona;
    }
    ?>
  <br>
  <br>
  <a class="negro" href="javascript:window.close()">
  <?
    	if ($error == 1){
    		echo $nkads_traduccion[152];
    	}else{
    		echo $nkads_traduccion[40];
    	}
    	?>
  </a> <br>
  </font> </div>
</body>
