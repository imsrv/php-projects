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

//Cargo archivo de configuracion
include("nkads.conf.php");

//sumo un click al banner
$ads_sql_update = "UPDATE ads_estadisticas SET clicks = clicks + 1 WHERE id_banner = '$id' AND fecha = '". date("Y-m-d") ."'";
$ads_result_update = mysql_query($ads_sql_update);
if(mysql_affected_rows() <> 1){
	$ads_sql_insert = "INSERT INTO ads_estadisticas VALUES ('". date("Y-m-d") ."','$id','','1')";
	$ads_result_insert = mysql_query($ads_sql_insert);
}

// busco el link del banner para dirigirlo al destino
$sql_busco = "SELECT link FROM ads_banners WHERE id = '$id'";
$result_busco = mysql_query($sql_busco);
$row_busco = mysql_fetch_array($result_busco);

$destino = $row_busco["link"];

header("Location: $destino");
exit;
?>