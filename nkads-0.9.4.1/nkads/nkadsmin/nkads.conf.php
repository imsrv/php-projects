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


include("../nkads.conf.php");
include("lenguajes/$idioma");

//Verificamos el tipo de cliente para saber si mostramos o no los mensajes de alerta
// (por la compatibilidad con los browsers)
$tipo_cliente = getenv ("HTTP_USER_AGENT");
$cliente_mozilla = similar_text($tipo_cliente,"Mozilla");
$cliente_ie = similar_text($tipo_cliente,"MSIE");
$cliente_k = similar_text($tipo_cliente,"Konqueror");

if (($cliente_mozilla == 7) AND ($cliente_ie <> 4) AND ($cliente_k <> 9)){
        $alerta_browser = 1;
}else{
        $alerta_browser = 0;
}
?>