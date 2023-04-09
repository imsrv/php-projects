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

//Desactivo los banners que esten pasados de fecha
$ads_sql_update = "Update ads_banners set activo = '0' where (fecha_fin < '". date("Y-m-d") . "')";
$ads_result_update = mysql_query($ads_sql_update);

//Busco los banners segun el nombre de la zona.
$ads_sql_busco = "SELECT t3.id, t3.alt, t3.contenido, t3.tipo, t3.target, t3.url FROM ads_zonas_banners as t1, ads_zonas as t2, ads_banners as t3, ads_estadisticas as t4 WHERE (t1.id_zona = t2.id) AND (t2.nombre = '$zona') AND (t3.id = t1.id_banner) AND (t3.fecha_inicio <= '" . date("Y-m-d") ."') AND (t3.activo = '1') AND ((t3.imp_compradas >= t4.impresiones) OR (t3.imp_compradas = -1)) ORDER BY rand() LIMIT 1";
$ads_result_busco = mysql_query($ads_sql_busco);
$ads_cont = -1;
if (@$ads_row_busco = mysql_fetch_array($ads_result_busco)){
	muestra_banner($ads_row_busco["id"],$ads_row_busco["alt"],$ads_row_busco["contenido"],$ads_row_busco["tipo"],$ads_row_busco["target"],$ads_row_busco["url"],$url_nkads,1);
}else{
	//Ups, esa zona no tiene banners... buscamos el banner por defecto
	$ads_sql_busco = "Select t2.id, t2.alt, t2.contenido, t2.tipo, t2.target, t2.url from ads_zonas as t1, ads_banners as t2 where (t1.nombre = '$zona') and (t2.id = t1.id_banner)";
	$ads_result_busco = mysql_query($ads_sql_busco);
	if ($ads_row_busco = mysql_fetch_array($ads_result_busco)){
		muestra_banner($ads_row_busco["id"],$ads_row_busco["alt"],$ads_row_busco["contenido"],$ads_row_busco["tipo"],$ads_row_busco["target"],$ads_row_busco["url"],$url_nkads,1);
	}else{
		//Verifico el tipo de servidor en donde estoy instalando...
		$tipo_s = similar_text(getenv("SERVER_SOFTWARE"),"Unix");
		if ($tipo_s == 4){
			include("$path_absoluto/nkadsmin/lenguajes/$idioma");
		}else{
			include("$path_absoluto\\nkadsmin\\lenguajes\\$idioma");
		}
		mail("$mail_administrador","$nkads_traduccion[238]","$nkads_traduccion[239] $zona $nkads_traduccion[240]","From: NKAds");
		exit;
	}
}
?>