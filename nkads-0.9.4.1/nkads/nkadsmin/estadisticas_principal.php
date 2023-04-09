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
                <td colspan="4"> 
                  <div align="center"> <font face="Verdana, Arial, Helvetica, sans-serif" size="1"><b><? echo $nkads_traduccion[208] ?></b><br>
		  <? echo $nkads_traduccion[230] ?>
                    </font></div>
                </td>
              </tr>
              <tr bgcolor="#FFCC00"> 
                <td width="388"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">&nbsp;<? echo $nkads_traduccion[112] ?></font>
                </td>
                <td width="86"> 
                  <div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo $nkads_traduccion[204] ?></font></div>
                </td>
                <td width="86"> 
                  <div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo $nkads_traduccion[205] ?></font></div>
                </td>
                <td width="49">
                  <div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo $nkads_traduccion[206] ?></font></div>
                </td>
              </tr>
                <?
                // Listado de empresas
                $sql_emp = "SELECT id, empresa FROM ads_clientes ORDER BY empresa ASC";
                $result_emp = mysql_query($sql_emp);
                if ($row_emp = mysql_fetch_array($result_emp)){
                        do{
                ?>
                                <tr valign="middle">
                                        <td bgcolor="#FFD735" width="388" height="18">
                                                <font face="Verdana, Arial, Helvetica, sans-serif" size="1">
                                                &nbsp;<a href="estadisticas_empresa.php?nom_empresa=<? echo $row_emp["empresa"] ?>&id_empresa=<? echo $row_emp["id"] ?>" class="negro"><? echo $row_emp["empresa"] ?></a>
                                                </font>
                                        </td>
                                        <td bgcolor="#FFD735" width="86" height="18">
                                                <div align="right">
                                                        <font face="Verdana, Arial, Helvetica, sans-serif" size="1">
                                                        <?
                                                        //Calculo el total de impresiones de todos los banners de la empresa
                                                        $sql_banners = "SELECT id FROM ads_banners WHERE id_cliente = " . $row_emp["id"];
                                                        $result_banners = mysql_query($sql_banners);
                                                        if ($row_banners = mysql_fetch_array($result_banners)){
                                                                do{
                                                                        $sql_datos = "SELECT id_banner, impresiones, clicks FROM ads_estadisticas where id_banner = ". $row_banners["id"];
                                                                        $result_datos = mysql_query($sql_datos);
                                                                        if ($row_datos = mysql_fetch_array($result_datos)){
                                                                                do{
                                                                                        $imp_parcial = $imp_parcial + $row_datos["impresiones"];
                                                                                        $clicks_parcial = $clicks_parcial + $row_datos["clicks"];
                                                                                }while($row_datos = mysql_fetch_array($result_datos));
                                                                        }
                                                                }while($row_banners = mysql_fetch_array($result_banners));
                                                        }
                                                        echo $imp_parcial;
                                                        ?>
                                                        &nbsp;
                                                        </font>
                                                </div>
                                        </td>
                                        <td bgcolor="#FFD735" width="86" height="18">
                                                <div align="right">
                                                        <font face="Verdana, Arial, Helvetica, sans-serif" size="1">
                                                        <?
                                                        echo $clicks_parcial;
                                                        ?>
                                                        &nbsp;
                                                        </font>
                                                </div>
                                        </td>
                                        <td bgcolor="#FFD735" width="49" height="18">
                                                <div align="center">
                                                        <font face="Verdana, Arial, Helvetica, sans-serif" size="1">
                                                        <?
                                                        @$crt = ($clicks_parcial * 100) / $imp_parcial;
                                                        echo number_format($crt, 3) ." %";
                                                        ?>
                                                        </font>
                                                </div>
                                        </td>
                                </tr>
                <?
                        $clicks_parcial = 0;
                        $imp_parcial = 0;
                        }while($row_emp = mysql_fetch_array($result_emp));
                }
              ?>
            </table>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</body>