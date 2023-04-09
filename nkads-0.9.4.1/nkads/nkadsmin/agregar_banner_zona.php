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
<title>
<? echo $nkads_titulo ?>
</title>
<link rel="stylesheet" href="estilos.css" type="text/css">
<body bgcolor="#FFCC00" text="#000000" link="#000000" vlink="#000000" alink="#000000" leftmargin="0" topmargin="0">
<form method="post" action="agregar_banner_zona2.php">
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
                      <? echo $nkads_traduccion[0] ?>
                      <br>
                      <?
                    echo "( ". $nkads_traduccion[2] ;

                    //busco el nombre de la zona
                    $sql_zona = "Select nombre from ads_zonas where id = $id_zona";
                    $result_zona = mysql_query($sql_zona);
                    $row_zona = mysql_fetch_array($result_zona);
                    echo " " .$row_zona["nombre"] . " )";
                    ?>
                      </b></font></div>
                  </td>
                </tr>
                <tr>
                  <td>
                    <div align="center"><br>
                      <select name="id_cliente" size="18" class="select">
                        <?
	//Listo todos los clientes
	$sql_clientes = "Select id, empresa from ads_clientes order by user asc";
	$result_clientes = mysql_query($sql_clientes);
	$row_clientes = mysql_fetch_array($result_clientes);
	$total_clientes = mysql_affected_rows();
	do{
	?>
                        <option value="<? echo $row_clientes["id"] ?>">
                        <? echo $row_clientes["empresa"] ?>
                        </option>
                        <?
	}while($row_clientes = mysql_fetch_array($result_clientes));
?>
                      </select>
                      <br>
                      <br>
                    </div>
                    <p align="center"><font size="-2" face="Verdana, Arial, Helvetica, sans-serif">
                      <?
If ($total_clientes <> 0){
	echo $nkads_traduccion[5] . " " . $total_clientes;
}else{
	echo $nkads_traduccion[10];
}
?>
                      <br>
                      <br>
                      <input type="hidden" name="id_zona" value="<? echo $id_zona ?>">
                      <input type="hidden" name="nombre_zona" value="<? echo $row_zona["nombre"]?>">
                      <input type="submit" name="Submit" value="<? echo $nkads_traduccion[21] ?>" class="botones">
                      </font><br>
                      &nbsp; </p>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</form>
</html>
