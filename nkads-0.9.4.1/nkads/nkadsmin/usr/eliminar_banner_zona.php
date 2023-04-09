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
//Elimino los datos en ads_zonas_banners

$sql = "Delete from ads_zonas_banners where id_banner = $id_banner and id_zona = $id_zona";
$result = mysql_query($sql);

$vuelta = "listar_banners_zona.php?id_zona=" . $id_zona;
header("Location: $vuelta");
exit;
?>
