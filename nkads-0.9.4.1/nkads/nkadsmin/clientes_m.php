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
<form name="form1" method="post" action="clientes_m1.php">
  <table width="760" border="1" cellspacing="0" cellpadding="0" align="center" bordercolor="#D7AC00">
    <tr>
      <td>
        <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
          <tr bgcolor="#F2C100">
            <td valign="top" colspan="2" height="3" bgcolor="#F2C100">
              <? include("header.inc.php"); ?>
            </td>
          </tr>
          <tr>
            <td> <br>
              <table width="100%" border="1" cellspacing="0" cellpadding="0" bordercolor="#F4C400">
                <tr bgcolor="#FFCC00">
                  <td colspan="2" bgcolor="#FFCC00">
                    <div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><b>
                      <? echo $nkads_traduccion[81] ?>
                      </b></font></div>
                  </td>
                </tr>
                <tr>
                  <td>
                    <table width="752" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td bgcolor="#FFD735" height="68" width="752"> <font size="1" face="Verdana, Arial, Helvetica, sans-serif">
                          <div align="center">
                            <? echo $nkads_traduccion[124] ?>
                            <br>
                            <br>
                            <select name="id" class="select">
                              <?
     //listo los clientes
    $sql_listo = "Select id, empresa from ads_clientes order by user asc";
    $result_listo = mysql_query($sql_listo);
    If ($row_listo = mysql_fetch_array($result_listo)){
    	$b = 1;
    	do{
    ?>
                              <option value="<? echo $row_listo["id"] ?>">
                              <? echo $row_listo["empresa"] ?>
                              </option>
                              <?
    	}while($row_listo = mysql_fetch_array($result_listo));
    }else{
    ?>
                              <option>
                              <? echo $nkads_traduccion[125] ?>
                              </option>
                              <?
    	$b = 0;
    }
    ?>
                            </select>
                          </div>
                          </font> </td>
                      </tr>
                      <tr>
                        <td bgcolor="#FFD735" width="752">
                          <div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="-2"><br>
                            </font><font face="Verdana, Arial, Helvetica, sans-serif" size="-2">
                            <?
    If ($b == 1){
    ?>
                            <input type="submit" name="Submit2" value="<? echo $nkads_traduccion[21] ?>" class="botones">
                            <?
    }
    ?>
                            </font><font face="Verdana, Arial, Helvetica, sans-serif" size="-2"></font><font face="Verdana, Arial, Helvetica, sans-serif" size="-2"><br>
                            &nbsp; </font></div>
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
  <br>
</form>
