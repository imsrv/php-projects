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

//Empiezo con el backup
switch($formato_fecha){
	case "D-M-A":
		$fecha = date("d-m-Y");
	break;
	case "M-D-A":
		$fecha = date("m-d-Y");
	break;
	case "A-M-D":
		$fecha = date("Y-m-d");
	break;
}
$nombre_archivo = "NKAds_" . $fecha . ".sql";

header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=".$nombre_archivo);

//Tabla ads_banners
$sql = "SELECT * FROM ads_banners ORDER BY id ASC";
$result = mysql_query($sql);
if ($row = mysql_fetch_array($result)){
	do{
		$tbl_ads_banners .= "Insert into ads_banners values ('". addslashes($row["id"]) ."','". addslashes($row["id_cliente"]) ."','". addslashes($row["tipo"]) ."','". addslashes($row["contenido"]) ."','". addslashes($row["link"]) ."','". addslashes($row["nombre"]) ."','". addslashes($row["alt"]) ."','". addslashes($row["tipo"]) ."','". addslashes($row["target"]) ."','". addslashes($row["url"]) ."','". addslashes($row["fecha_inicio"]) ."','". addslashes($row["fecha_fin"]) ."','". addslashes($row["imp_compradas"]) ."','". addslashes($row["activo"]) ."');\n";
	}while($row = mysql_fetch_array($result));
}

//Tabla ads_clientes
$sql = "SELECT * FROM ads_clientes ORDER BY id ASC";
$result = mysql_query($sql);
if ($row = mysql_fetch_array($result)){
	do{
		$tbl_ads_clientes .= "Insert into ads_clientes values ('". addslashes($row["id"]) ."','". addslashes($row["empresa"]) ."','". addslashes($row["domicilio"]) ."','". addslashes($row["ciudad"]) ."','". addslashes($row["provincia"]) ."','". addslashes($row["pais"]) ."','". addslashes($row["telefono"]) ."','". addslashes($row["fax"]) ."','". addslashes($row["email"]) ."','". addslashes($row["url"]) ."','". addslashes($row["user"]) ."','". addslashes($row["pass"]) ."','". addslashes($row["acceso"]) ."');\n";
	}while($row = mysql_fetch_array($result));
}

//Tabla ads_estadisticas
$sql = "SELECT * FROM ads_estadisticas ORDER BY fecha ASC";
$result = mysql_query($sql);
if ($row = mysql_fetch_array($result)){
	do{
		$tbl_ads_estadisticas .= "Insert into ads_estadisticas values ('". addslashes($row["fecha"]) ."','". addslashes($row["id_banner"]) ."','". addslashes($row["impresiones"]) ."','". addslashes($row["clicks"]) ."');\n";
	}while($row = mysql_fetch_array($result));
}

//Tabla ads_master
$sql = "SELECT * FROM ads_master";
$result = mysql_query($sql);
if ($row = mysql_fetch_array($result)){
	do{
		$tbl_ads_master .= "Insert into ads_master values ('". addslashes($row["usuario"]) ."','". addslashes($row["password"]) ."');\n";
	}while($row = mysql_fetch_array($result));
}

//Tabla ads_zonas
$sql = "SELECT * FROM ads_zonas ORDER BY id ASC";
$result = mysql_query($sql);
if ($row = mysql_fetch_array($result)){
	do{
		$tbl_ads_zonas .= "Insert into ads_zonas values ('". addslashes($row["id"]) ."','". addslashes($row["id_banner"]) ."','". addslashes($row["nombre"]) ."','". addslashes($row["id_cliente"]) ."');\n";
	}while($row = mysql_fetch_array($result));
}

//Tabla ads_zonas_banners
$sql = "SELECT * FROM ads_zonas_banners ORDER BY id_zona ASC";
$result = mysql_query($sql);
if ($row = mysql_fetch_array($result)){
	do{
		$tbl_ads_zonas_banners .= "Insert into ads_zonas_banners values ('". addslashes($row["id_zona"]) ."','". addslashes($row["id_banner"]) ."');\n";
	}while($row = mysql_fetch_array($result));
}


echo "#Tabla ads_banners";
echo "\n";
echo $tbl_ads_banners;
echo "\n\n";
echo "#Tabla ads_banners";
echo "\n";
echo $tbl_ads_clientes;
echo "\n\n";
echo "#Tabla ads_estadisticas";
echo "\n";
echo $tbl_ads_estadisticas;
echo "\n\n";
echo "#Tabla ads_master";
echo "\n";
echo $tbl_ads_master;
echo "\n\n";
echo "#Tabla ads_zonas";
echo "\n";
echo $tbl_ads_zonas;
echo "\n\n";
echo "#Tabla ads_zonas_banners";
echo "\n";
echo $tbl_ads_zonas_banners;
exit;
?>