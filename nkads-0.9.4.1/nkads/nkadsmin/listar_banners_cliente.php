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
?>
<html>
<script>
function eliminar_banner_cliente(id_banner, id_cliente){
        if (confirm("<? echo $nkads_traduccion[34] ?> " + id_banner + "<? echo $nkads_traduccion[35] ?>"))
        {
        location.href="banners_e2.php?id_cliente=" + id_cliente + "&id_banner=" + id_banner
        }
}
</script>
<link rel="stylesheet" href="estilos.css" type="text/css">
<body bgcolor="#FFCC00" text="#000000" link="#000000" vlink="#000000" alink="#000000" leftmargin="0" topmargin="0">
<table width="760" border="1" cellspacing="0" cellpadding="0" align="center" bordercolor="#D7AC00">
  <tr> 
    <td height="20">
      <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
        <tr> 
          <td bgcolor="#F2C100" width="100%"> 
            <div align="left"> 
              <? include("header.inc.php"); ?>
            </div>
          </td>
        </tr>
        <tr> 
          <td width="100%"> <font face="Verdana, Arial, Helvetica, sans-serif" size="2"> 
            </font> <br>
            <table width="100%" border="1" cellspacing="0" cellpadding="0" bordercolor="#F4C400">
              <tr> 
                <td> 
                  <div align="center"> <font face="Verdana, Arial, Helvetica, sans-serif" size="1"><b>
                    <a class="negro" href="banners_n.php?id_cliente=<? echo $id_cliente ?>">
                    <? echo $nkads_traduccion[84] ?>
                    </a></b> </font></div>
                </td>
              </tr>
<?
			    //Funcion que muestra los banners
			    include("../funciones.inc.php");

//listo todos los banners del cliente
$sql_banner = "Select * from ads_banners where id_cliente = $id_cliente";
$result_banner = mysql_query($sql_banner);
if ($row_banner = mysql_fetch_array($result_banner)){
        do {
?>
              <tr>
                <td bgcolor="#FFD735">
                  <table width="100%" cellspacing="0" cellpadding="5" align="center">
                    <tr>
                      <td valign="top"> 
                        <div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="-2"><b> 
                          </b></font> 
                          <hr color="#D7AC00" size="1" align="center" width="100%">
                          <font face="Verdana, Arial, Helvetica, sans-serif" size="-2"><b> 
                          <? echo $nkads_traduccion[145] ?>
                          </b> 
                          <? echo $row_banner["id"] ?>
                          <br>
                          <b> 
                          <? echo $nkads_traduccion[7] ?>
                          </b> 
                          <? echo $row_banner["nombre"] ?>
                          <br>
                          <b> </b> <b> 
                          <? echo $nkads_traduccion[18] ?>
                          </b> 
                          <?
                                        If ($row_banner["activo"] == 1){
                                                echo "$nkads_traduccion[42]";
                                        }else{
                                                echo "$nkads_traduccion[43]";
                                        }
                                        ?>
                          </font> 
                          <hr color="#D7AC00" size="1" align="center" width="100%">
                          <font face="Verdana, Arial, Helvetica, sans-serif" size="-2"> 
                          </font></div>
                      </td>
                    </tr>
                  </table>
                  <div align="center">
		  <?
		muestra_banner($row_banner["id"],$row_banner["alt"],$row_banner["contenido"],$row_banner["tipo"],$row_banner["target"],$row_banner["url"],$url_nkads,0);
		  ?>
	        <br>
                    <br>
                    <font face="Verdana, Arial, Helvetica, sans-serif" size="-2"> 
                    <a class="negro" href="banners_m2.php?id_cliente_opcion=<? echo $id_cliente?>&id_zona=<? echo $id_zona ?>&id_banner=<? echo $row_banner["id"] ?>">
                    <? echo $nkads_traduccion[47] ?>
                    </a> <br>
                    <br>
                    <a class="negro" href="javascript:eliminar_banner_cliente(<? echo $row_banner["id"] ?>, <? echo $id_cliente ?>)">
                    <? echo $nkads_traduccion[157] ?>
                    <br>
                    &nbsp; </a></font></div>
                </td>
              </tr>
<?
        }while($row_banner = mysql_fetch_array($result_banner));
}
?>
            </table>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</html>
