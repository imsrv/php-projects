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

if ($id_zona <> "no"){
        //elimino la zona
        $sql_borro = "Delete from ads_zonas where id = $id_zona";
        $result_borro = mysql_query($sql_borro);
        header("Location: exito_eliminar.php?opcion_menu=zona");
        exit;
}else{
?>
        <script>
        alert("<? echo $nkads_traduccion[26] ?>");
        location.href="zonas_e.php";
        </script>
<?
}
?>