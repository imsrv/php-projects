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
<form method="post" action="banners_e1.php">
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
                    <div align="center"> <font face="Verdana, Arial, Helvetica, sans-serif" size="1">
                      <b>
                      <? echo $nkads_traduccion[45] ?>
                      </b> </font></div>
                  </td>
                </tr>
                <tr>
                  <td bgcolor="#FFD735"> <font size="-2" face="Verdana, Arial, Helvetica, sans-serif">
                    <div align="center"><br>
                      <select name="id_cliente" size="6" class="select">
                        <?
                        //listo los clientes
                        $sql_listo = "Select id, empresa from ads_clientes order by user asc";
                        $result_listo = mysql_query($sql_listo);
                        If ($row_listo = mysql_fetch_array($result_listo)){
                                $cont_sel = 1;
                                $b = 1;
                                do{
                                        if ($cont_sel == 1){
                                                $selected = "selected";
                                        }else{
                                                $selected = "";
                                        }
                        ?>
                                        <option value="<? echo $row_listo["id"] ?>" <? echo $selected ?>>
                                        <? echo $row_listo["empresa"] ?>
                                        </option>
                        <?
                                $cont_sel++;
                                }while($row_listo = mysql_fetch_array($result_listo));
                        }else{
                                $b = 0;
                        ?>
                                <option>
                                <? echo $nkads_traduccion[10] ?>
                                </option>
                        <?
                        }
                        ?>
                      </select>
                      <br>
                      <br>
                        <?
                        if ($b == 1){
                        ?>
                                <input type="submit" name="Submit" value="<? echo $nkads_traduccion[21] ?>" class="botones">
                        <?
                        }else{

                        }
                        ?>

                      <br>
                      &nbsp; </div>
                    </font> </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</form>
