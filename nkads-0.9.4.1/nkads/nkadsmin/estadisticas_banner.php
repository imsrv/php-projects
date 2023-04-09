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
                <td> 
                  <div align="center"> <font face="Verdana, Arial, Helvetica, sans-serif" size="1"><b> 
                    <? echo $nkads_traduccion[209] ?></b><br><? echo date(Y) ?> </font></div>
                </td>
              </tr>
              <tr>
                <td bgcolor="#FFD735">
                  <div align="center"> <br>
                    <?
			   //Funcion que muestra los banners
			   include("../funciones.inc.php");


			    //Busco los datos del banner
			    $sql_b = "Select * from ads_banners where id = $id_banner";
			    $result_b = mysql_query($sql_b);
			    $row_b = mysql_fetch_array($result_b);

			    muestra_banner($row_b["id"],$row_b["alt"],$row_b["contenido"],$row_b["tipo"],$row_b["target"],$row_b["url"],$url_nkads,0);
?>
                    <table width="600" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td valign="middle" width="14"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><img src="imgcomunes/barra_imp.gif" width="10" height="10" border="0"></font></td>
                        <td valign="middle" width="586"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">Impresiones</font></td>
                      </tr>
                      <tr> 
                        <td valign="middle" width="14"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><img src="imgcomunes/barra_clicks.gif" width="10" height="10" border="0"></font></td>
                        <td valign="middle" width="586"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">Clicks 
                          </font><font face="Verdana, Arial, Helvetica, sans-serif" size="-2"></font></td>
                      </tr>
                    </table>
                    <?
			//Junto las impresiones y los clicks de todo el año
			//("maldito" leo y sus cochinos arrays)
			$sql_a = "Select impresiones, clicks, fecha from ads_estadisticas where id_banner = $id_banner AND year(fecha) = ". date("Y") ." order by fecha";
			$result_a = mysql_query($sql_a);
			$row_a = mysql_fetch_array($result_a);
			do{
				$mes = substr($row_a["fecha"],5,2);

				$impresiones[$mes] = $impresiones[$mes] + $row_a["impresiones"];
				$clicks[$mes] = $clicks[$mes] + $row_a["clicks"];

				$total_imp_a = $total_imp_a + $row_a["impresiones"];
				$total_clicks_a = $total_clicks_a + $row_a["clicks"];

			}while($row_a = mysql_fetch_array($result_a));
			?>
                    <br>
                  </div>
                  <div align="center"> 
                    <table border="0" cellspacing="0" cellpadding="0" width="600">
                      <tr> 
                        <td colspan="4" valign="middle">
                          <hr noshade color="#D7AC00" size="1" align="center">
                        </td>
                      </tr>
                      <?
		//Listo los valores de todos los meses del año
		while (list ($indice, $valor) = each ($impresiones)) {
			if ($impresiones[$indice] <> 0){
				$porc_ctr = ($clicks[$indice] * 100) / $impresiones[$indice];
				$porc_imp = round(($impresiones[$indice] * 100) / $total_imp_a);
                               	}else{
				$porc_ctr = 0;
				$porc_imp = 0;
			}
		?>
                      <tr> 
                        <td rowspan="2" valign="middle" width="30"> 
                          <div align="center"><font size="1"><b><font face="Verdana, Arial, Helvetica, sans-serif"> 
                            <a class="negro" href="estadisticas_banner_mes.php?id_banner=<? echo $id_banner ?>&id_mes=<? echo $indice ?>"> 
<?
if(!empty($indice)){
	$indice_traduccion = $indice + 210;
	echo $nkads_traduccion[$indice_traduccion];
}
?>
                            </a> </font></b></font></div>
                        </td>
                        <td width="80" valign="bottom"> 
                          <div align="right"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                            <? echo $impresiones[$indice] ?>
                            &nbsp; </font></div>
                        </td>
                        <td width="410" valign="middle"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><img src="imgcomunes/barra_imp.gif" width="<? echo $porc_imp  ?>%" height="10" border="0"> 
                          </font></td>
                        <td rowspan="2" valign="bottom" width="80"> 
                          <div align="center"><b> <font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                            <? echo $nkads_traduccion[206] ?>
                            </font></b><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><br>
			<?
			echo number_format($porc_ctr,3) . "%";
			?>
                            </font> </div>
                        </td>
                      </tr>
                      <tr> 
                        <td width="80" valign="top"> 
                          <div align="right"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"> 
                            <? echo $clicks[$indice] ?>
                            &nbsp; </font></div>
                        </td>
                        <td width="370" valign="middle"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><img src="imgcomunes/barra_clicks.gif" width="<? echo (($porc_imp  / 100) * $porc_ctr) ?>%" height="10" border="0"> 
                          </font></td>
                      </tr>
                      <tr> 
                        <td colspan="4" valign="middle"> 
                          <hr noshade color="#D7AC00" size="1" align="center">
                        </td>
                      </tr>
                      <?
		}
		?>
                    </table>
                    &nbsp;</div>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</body>