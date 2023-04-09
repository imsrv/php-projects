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
<Script>
function agregar(cual)
{
window.open("agregar_banner_zona3.php?" + cual, "ventana", "height=110, width=198, scrollbars=no, resizable=no, toolbar=no, menubar=no")
}
</script>
<link rel="stylesheet" href="estilos.css" type="text/css">
<body bgcolor="#FFCC00" text="#000000" link="#000000" vlink="#000000" alink="#000000" leftmargin="0" topmargin="0">
<div align="center"> 
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
                    <div align="center"> <font face="Verdana, Arial, Helvetica, sans-serif" size="-2" color="#000000"> 
                      <?
echo $nkads_traduccion[13];

//averiguo nombre cliente
$sql_cliente = "Select * from ads_clientes where id = $id_cliente";
$result_cliente = mysql_query($sql_cliente);
$row_cliente = mysql_fetch_array($result_cliente);
echo $row_cliente["empresa"];
?>
                      <br>
                      <?
echo $nkads_traduccion[14] . " " .$nombre_zona;
?>
                      <br>
                      <br>
                      <b> <a class="negro" href="agregar_banner_zona.php?id_zona=<? echo $id_zona ?>">
                      <? echo $nkads_traduccion[15] ?>
                      </a></b> </font></div>
                  </td>
                </tr>
                <?
//Funcion que muestra los banners
include("../funciones.inc.php");

//muestro los banners del cliente
$sql = "select * from ads_banners where id_cliente = $id_cliente";
$result = mysql_query($sql);
if($row_banner = mysql_fetch_array($result)){
	do{
?>
                <tr> 
                  <td bgcolor="#FFD735"> 
                    <table width="100%" cellspacing="0" cellpadding="0" align="center">
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
                      <font face="Verdana, Arial, Helvetica, sans-serif" size="-2"> 
                      <br>
                      <br>
                      <a class="negro" href="#." onClick="agregar('id_banner=<? echo $row_banner["id"] ?>&nombre_zona=<? echo $nombre_zona ?>&id_zona=<? echo $id_zona ?>')"> 
                      <? echo $nkads_traduccion[138] ?>
                      </a> <br>
                      </font></div>
                  </td>
                </tr>
                <?
		}while($row_banner = mysql_fetch_array($result));
}else{
        echo "<div align='center'>";
        echo "<font face='Verdana, Arial, Helvetica, sans-serif' size='2'><b>";
        echo $nkads_traduccion[37];
        echo "<br>&nbsp;";
        echo "</b></font>";
        echo "</div>";
}

?>
              </table>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</div>
</html>
