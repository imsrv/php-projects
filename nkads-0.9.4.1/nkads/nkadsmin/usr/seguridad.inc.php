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


session_start();
include("../../nkads.conf.php");
include("../lenguajes/$idioma");
function autentificar() {
	Header( "WWW-authenticate: basic realm='NKAds'");
	Header( "HTTP/1.0 401 Unauthorized");
	exit;
}

if(!session_is_registered("seguridad_usr")) {
	$sql = "SELECT id,acceso FROM ads_clientes WHERE pass = '$PHP_AUTH_PW' AND user = '$PHP_AUTH_USER'";
	$result = mysql_query($sql,$db);
	if ($myrow = mysql_fetch_array($result)){
		session_register('seguridad_usr');
		$seguridad_usr = 1;
		session_register("id_usuario_session");
		$id_usuario_session = $myrow["id"];
		$acceso_usuario = $myrow["acceso"];
	}else{
		autentificar();
	}
}else{
	$sql = "SELECT id,acceso FROM ads_clientes WHERE pass = '$PHP_AUTH_PW' AND user = '$PHP_AUTH_USER'";
	$result = mysql_query($sql,$db);
	if ($myrow = mysql_fetch_array($result)){
		$id_usuario_session = $myrow["id"];
		$acceso_usuario = $myrow["acceso"];
	}else{
		autentificar();
	}
}
?>