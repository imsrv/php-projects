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

if ($id_banner <> "no"){

        $sql = "SELECT id, nombre FROM ads_zonas WHERE id_banner = '$id_banner'";
        $result = mysql_query($sql);
        $alerta = 0;
        if ($myrow = mysql_fetch_array($result)){
                $alerta = 1;
                do{
                        $alerta_zonas .= "[".$myrow["nombre"] ."] ";
                }while($myrow = mysql_fetch_array($result));
        }
        $sql = "DELETE FROM ads_zonas_banners WHERE id_banner = '$id_banner'";
        $result = mysql_query($sql);

        $sql = "DELETE FROM ads_banners WHERE id = '$id_banner'";
        $result = mysql_query($sql);

        if ($alerta == 1){
                header("Location: exito_eliminar.php?alerta_zonas=$alerta_zonas&id_cliente=$id_cliente&opcion_menu=banner");
                exit;
        }else{
                header("Location: exito_eliminar.php?id_cliente=$id_cliente&opcion_menu=banner");
                exit;
        }

}else{
?>
        <script>
        alert("<? echo $nkads_traduccion[189] ?>");
        location.href="banners_e1.php?id_cliente=<? echo $id_cliente ?>";
        </script>
<?
}
?>