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

if ($id_cliente <> "no"){

        //elimino el cliente
        $sql = "Delete from ads_clientes where id = $id_cliente";
        $result = mysql_query($sql);

        //elimino los banners del cliente
        $sql = "Delete from ads_banners where id_cliente = $id_cliente";
        $result = mysql_query($sql);

        header("Location: exito_eliminar.php?opcion_menu=cliente");
        exit;
}else{
?>
        <script>
        alert("<? echo $nkads_traduccion[127] ?>");
        location.href="clientes_e.php";
        </script>
<?
}
?>