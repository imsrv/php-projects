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

switch ($opcion_menu) {
        case "cliente":
                $opcion_mensaje =  $nkads_traduccion[81];
                $opciones = "<a href='clientes_m.php' class='negro'> $nkads_traduccion[82] </a><br><br>";
        break;
        case "banner":
                $opcion_mensaje =  $nkads_traduccion[47];
        if($id_zona <> ""){
                $opciones .= "<a href=\"listar_banners_zona.php?id_zona=$id_zona\" class='negro'> $nkads_traduccion[139] </a><br><br>";
        }else{
                $opciones .= "<a href='banners_m1.php?id_cliente=$id_cliente_opcion' class='negro'> $nkads_traduccion[187] </a><br>";
        }
        $opciones .= "<a href='banners_m.php' class='negro'> $nkads_traduccion[140] </a><br><br>";
        break;
        case "zona":
                $opcion_mensaje =  $nkads_traduccion[12];
                $opciones = "<a href='zonas_m.php' class='negro'> $nkads_traduccion[87] </a><br>";
                $opciones .= "<a href='agregar_banner_zona.php?id_zona=". $id_zona ."' class='negro'> $nkads_traduccion[36] </a><br><br>";

        break;
}

?>
<link rel="stylesheet" href="../estilos.css" type="text/css">
<body bgcolor="#FFCC00" text="#000000" link="#000000" vlink="#000000" alink="#000000" leftmargin="0" topmargin="0">
<table width="760" border="1" cellspacing="0" cellpadding="0" align="center" bordercolor="#D7AC00">
  <tr> 
    <td bgcolor="#F2C100"> 
      <div align="left"> 
        <? include("header.inc.php"); ?>
      </div>
    </td>
  </tr>
  <tr> 
    <td> <font face="Verdana, Arial, Helvetica, sans-serif" size="2"> </font> 
      <br>
      <table width="100%" border="1" cellspacing="0" cellpadding="0" bordercolor="#F4C400">
        <tr> 
          <td> 
            <div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><b> 
              <? echo $opcion_mensaje ?>
              </b> </font></div>
          </td>
        </tr>
        <tr> 
          <td> 
            <div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><br>
              </font><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
              <? echo $nkads_traduccion[91] ?>
              <br>
              <br>
              </font> <br>
              <br>
              <font face="Verdana, Arial, Helvetica, sans-serif" size="-2"> 
              <? echo $opciones ?>
              </font></div>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
