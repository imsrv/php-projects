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
<title><? echo $nkads_titulo ?></title>
<link rel="stylesheet" href="estilos.css" type="text/css">

<body bgcolor="#FFCC00" text="#000000" link="#000000" vlink="#000000" alink="#000000" leftmargin="0" topmargin="0">
<table border="1" cellspacing="0" cellpadding="0" align="center" bordercolor="#D7AC00" width="760" height="420">
  <tr>
    <td colspan="2" valign="top">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr bgcolor="#F2C100">
          <td valign="top" colspan="2" height="3">
            <? include("header.inc.php"); ?>
          </td>
        </tr>
        <tr>
          <td valign="top" width="50%">
            <form method="post" action="listar_banners_cliente.php">
              <br>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td bgcolor="#FFCC00" width="100%">
                    <div align="center"><font face="Verdana, Arial, Helvetica, sans-serif"><b><font size="1" color="#000000">
                      <? echo $nkads_traduccion[0] ?>
                      <br>
                      &nbsp; </font></b></font></div>
                  </td>
                </tr>
                <tr bgcolor="#CCCCFF">
                  <td valign="top" width="100%" bgcolor="#FFCC00">
                    <div align="center">
                      <select name="id_cliente" size="18" class="select">
                        <?
                        //Listo todos los clientes
                        $b = 0;
                        $sql_clientes = "Select id, empresa from ads_clientes order by user asc";
                        $result_clientes = mysql_query($sql_clientes);
                        if ($row_clientes = mysql_fetch_array($result_clientes)){
                                $b = 1;
                                $total_clientes = mysql_affected_rows();
                                $cont_sel = 1;
                                do{
                                        if ($cont_sel == 1){
                                                $selected = "selected";
                                        }else{
                                                $selected = "";
                                        }
                                        ?>
                                        <option value="<? echo $row_clientes["id"] ?>" <? echo $selected ?>>
                                        <? echo $row_clientes["empresa"] ?>
                                        </option>
                                        <?
                                        $cont_sel++;
                                }while($row_clientes = mysql_fetch_array($result_clientes));
                        }
                        ?>
                      </select>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td bgcolor="#FFCC00" rowspan="2" width="100%"> 
                    <div align="center"> 
                      <p><font size="-2" face="Verdana, Arial, Helvetica, sans-serif"> 
                        <?
                        If ($total_clientes <> 0){
                                echo $nkads_traduccion[5]  .  $total_clientes;
                        }else{
                                echo $nkads_traduccion[10];
                        }
                        ?>
                        <br>
                        <br>
                        <?
                        if ($b == 1){
                        ?>
                                <input type="submit" name="Submit" value="<? echo $nkads_traduccion[48] ?>" class="botones">
                        <?
                        }
                        ?>
                        </font></p>
                    </div>
                  </td>
                </tr>
                <tr> </tr>
              </table>
            </form>
          </td>
          <td valign="top">
            <form method="post" action="listar_banners_zona.php">
              <br>
              <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                <tr>
                  <td bgcolor="#FFCC00" width="100%">
                    <div align="center"><font face="Verdana, Arial, Helvetica, sans-serif"><b><font size="1" color="#000000">
                      <? echo $nkads_traduccion[55] ?>
                      <br>
                      &nbsp; </font></b></font></div>
                  </td>
                </tr>
                <tr> 
                  <td valign="top" bgcolor="#FFCC00" width="100%"> 
                    <div align="center"> 
                      <select name="id_zona" size="18" class="select">
                        <?
                        //Listo todas las zonas
                        $b = 0;
                        $sql_zonas = "Select id, nombre from ads_zonas order by nombre asc";
                        $result_zonas = mysql_query($sql_zonas);
                        if ($row_zonas = mysql_fetch_array($result_zonas)){
                                $b = 1;
                                $total_zonas = mysql_affected_rows();
                                $cont_sel = 1;
                                do{
                                        if ($cont_sel == 1){
                                                $selected = "selected";
                                        }else{
                                                $selected = "";
                                        }
                                ?>
                                        <option value="<? echo $row_zonas["id"] ?>" <? echo $selected ?>>
                                        <? echo $row_zonas["nombre"] ?>
                                        </option>
                                <?
                                        $cont_sel++;
                                }while($row_zonas = mysql_fetch_array($result_zonas));
                        }
                        ?>
                      </select>
                    </div>
                  </td>
                </tr>
                <tr> 
                  <td bgcolor="#FFCC00" rowspan="7" width="100%"> 
                    <div align="center"> 
                      <p><font size="-2" face="Verdana, Arial, Helvetica, sans-serif"> 
                        <?
                        If ($total_zonas <> 0){
                                echo $nkads_traduccion[5] ." "  . $total_zonas;
                        }else{
                                echo $nkads_traduccion[56];
                        }
                        ?>
                        <br>
                        <br>
                        <?
                        if ($b == 1){
                        ?>
                                <input type="submit" name="Submit2" value="<? echo $nkads_traduccion[48] ?>" class="botones">
                        <?
                        }
                        ?>
                        </font></p>
                    </div>
                  </td>
                </tr>
              </table>
            </form>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</html>
