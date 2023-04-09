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
<script>
function eliminar_banner(){
        if (form_banner.id_banner.value == "no")
        {
                alert("<? echo $nkads_traduccion[160] ?>");
                return false;
        }else{
                if (confirm("<? echo $nkads_traduccion[159] ?>"))
                {
                //acepto
                }else{
                        return false;
                }
        }
}
</script>
<link rel="stylesheet" href="estilos.css" type="text/css">
<body bgcolor="#FFCC00" text="#000000" link="#000000" vlink="#000000" alink="#000000" leftmargin="0" topmargin="0">
<form name="form_banner" action="banners_e2.php" method="post" OnSubmit="return eliminar_banner()">
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
	//busco los datos del cliente
                $sql_cliente = "Select empresa from ads_clientes WHERE id = '$id_cliente'";
                $result_cliente = mysql_query($sql_cliente);
                $row_cliente = mysql_fetch_array($result_cliente);

                echo $nkads_traduccion[154] . $row_cliente["empresa"] . ")"
                ?>
                    </b> </font></div>
                </td>
              </tr>
              <tr>
                <td bgcolor="#FFD735">
                  <div align="center"><br>
                    <select name="id_banner" class="select" >
                        <?
                        //listo los banners del cliente
                        $sql_listo = "Select id, nombre from ads_banners WHERE id_cliente = $id_cliente ORDER BY id asc";
                        $result_listo = mysql_query($sql_listo);
                        If ($row_listo = mysql_fetch_array($result_listo)){
                                echo "<option value='no' selected>".$nkads_traduccion[188]."</option>";
                                $b = 1;
                                do{
                        ?>
                                        <option value="<? echo $row_listo["id"] ?>" >
                                        <? echo $row_listo["nombre"] ?>
                                        </option>
                        <?
                                }while($row_listo = mysql_fetch_array($result_listo));
                        }else{
                                $b = 0;
                        ?>
                                <option value="no" selected>
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
                                <input type="hidden" name="id_cliente" value="<? echo $id_cliente ?>">
                                <input type="submit" name="Submit" value="<? echo $nkads_traduccion[32] ?>" class="botones">
                                <?
                                        if ($alerta_browser == 1){
                                                echo "<font face='Verdana, Arial, Helvetica, sans-serif' size='-2'>";
                                                echo "<br><br>" . $nkads_traduccion[185];
                                                echo "</font>";
                                        }
                        }else{
                                echo "<font face='Verdana, Arial, Helvetica, sans-serif' size='1'><br><a href='banners_e.php' class='negro'>$nkads_traduccion[15]</a></font><br>";
                        }
                        ?>
                    <br>
                    &nbsp; </div>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
