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
function eliminar_zona(){
        if (form_zona.id_zona.value == "no")
        {
                alert("<? echo $nkads_traduccion[26] ?>");
                return false;
        }else{

                if (confirm("<? echo $nkads_traduccion[23] ?>"))
                {
                }else{
                        return false;
                }
        }
 }
</script>

<link rel="stylesheet" href="estilos.css" type="text/css">
<body bgcolor="#FFCC00" text="#000000" link="#000000" vlink="#000000" alink="#000000" leftmargin="0" topmargin="0">
<form name="form_zona" action="zonas_e1.php" method="POST" OnSubmit="return eliminar_zona()">
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
                      <? echo $nkads_traduccion[29] ?>
                      </b> </font></div>
                  </td>
                </tr>
                <tr>
                  <td>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFD735">
                      <tr>
                        <td>
                          <p align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><br>
                            <? echo $nkads_traduccion[30] ?>
                            </font></p>
                          <p align="center">
                            <select name="id_zona" class="select">
                              <?
     //listo las zonas
    $sql_listo = "Select id, nombre from ads_zonas order by nombre asc";
    $result_listo = mysql_query($sql_listo);
    If ($row_listo = mysql_fetch_array($result_listo)){
        echo "<option value='no' selected>Seleccionar zona</option>";
    	$b = 1;
    	do{
    ?>
                              <option value="<? echo $row_listo["id"] ?>">
                              <? echo $row_listo["nombre"] ?>
                              </option>
                              <?
    	}while($row_listo = mysql_fetch_array($result_listo));
    }else{
    ?>
                              <option value="no" selected>
                              <? echo $nkads_traduccion[31] ?>
                              </option>
                              <?
    	$b = 0;
    }
    ?>
                            </select>
                          </p>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <div align="center"> <br>
                            <?
                        If ($b == 1){
                        ?>
                            <input type="submit" name="Submit" value="<? echo $nkads_traduccion[32] ?>" class="botones">
                            <?
                                if ($alerta_browser == 1){
                                        echo "<font face='Verdana, Arial, Helvetica, sans-serif' size='-2'>";
                                        echo "<br><br>" . $nkads_traduccion[185];
                                        echo "</font>";
                                }
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
      </td>
    </tr>
  </table>
</form>
