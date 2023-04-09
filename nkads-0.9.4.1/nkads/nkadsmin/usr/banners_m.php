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
if($acceso_usuario == 0){
	header("Location: index.php");
	exit;
}
?>
<link rel="stylesheet" href="../estilos.css" type="text/css">
<body bgcolor="#FFCC00" text="#000000" link="#000000" vlink="#000000" alink="#000000" leftmargin="0" topmargin="0">
<form enctype="multipart/form-data" name="ti" method="post" action="banners_m1.php">
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
                        <?
                        $sql_cliente = "Select empresa from ads_clientes WHERE id = '$id_usuario_session'";
                        $result_cliente = mysql_query($sql_cliente);
                        $row_cliente = mysql_fetch_array($result_cliente);
                        echo $nkads_traduccion[51] . $row_cliente["empresa"]
                        ?>
                      </b></font></div>
                  </td>
                </tr>
                <tr>
                  <td bgcolor="#FFD735"> <font size="-2" face="Verdana, Arial, Helvetica, sans-serif"><b>
                    <div align="center"><br>
                      <select name="id_banner" size="6" class="select">
                        <?
                        //listo los banners del cliente
                        $sql_listo = "Select id, nombre from ads_banners WHERE id_cliente = $id_usuario_session ORDER BY id asc";
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
                                        <? echo $row_listo["nombre"] ?>
                                        </option>
                        <?
                                $cont_sel++;
                                }while($row_listo = mysql_fetch_array($result_listo));
                        }else{
                                $b = 0;
                        ?>
                                <option>
                                <? echo $nkads_traduccion[52] ?>
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
                                <input type="hidden" name="id_cliente_opcion" value="<? echo $id_cliente ?>">
                                <input type="submit" name="Submit" value="<? echo $nkads_traduccion[21] ?>" class="botones">
                      <?
                      }else{
                                echo "<br>";
                                echo "<a href='banners_m.php' class='negro'>";
                                echo $nkads_traduccion[15];
                                echo "</a>";
                      }
                      ?>
                      <br>
                      &nbsp; </div>
                    </b></font> </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</form>
