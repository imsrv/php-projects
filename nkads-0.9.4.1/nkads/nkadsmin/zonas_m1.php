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

if ($enviado == 1){
        //verifico los datos
        $todo_ok = 1;

        if ($nombre == "") {
                $todo_ok = 0;
                $error_nombre = $nkads_traduccion[1];
        }else{
                if (strlen($nombre) < 3) {
                        $todo_ok = 0;
                        $error_nombre = $nkads_traduccion[3];
                }
        }

        if ($id_banner == "no") {
                $todo_ok = 0;
                $error_banner = $nkads_traduccion[4];
        }

        if ($todo_ok == 1){
                //guardo los datos
                $sql_guardo = "Update ads_zonas set nombre = '$nombre', id_banner = '$id_banner', id_cliente = '$id_cliente' where id = $id_zona";
                $result_guardo = mysql_query($sql_guardo);

                $url_destino = "exito_modifica.php?opcion_menu=zona&id_zona=".$id_zona;
                header("Location: $url_destino");
        }

}else{
	//busco los datos de la zona
	$sql_busco = "Select * from ads_zonas where id = $id_zona";
	$result_busco = mysql_query($sql_busco);
	$row_busco = mysql_fetch_array($result_busco);

	$nombre = $row_busco["nombre"];
	$id_banner = $row_busco["id_banner"];
	$id_cliente = $row_busco["id_cliente"];
}

?>
<link rel="stylesheet" href="estilos.css" type="text/css">
<body bgcolor="#FFCC00" text="#000000" link="#000000" vlink="#000000" alink="#000000" leftmargin="0" topmargin="0">
<form name="form1" method="post" action="zonas_m1.php?enviado=1">
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
                      <? echo $nkads_traduccion[12] ?>
                      </b> </font></div>
                  </td>
                </tr>
                <tr>
                  <td>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFD735">
                      <tr>
                        <td>
                          <div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><br>
                            <? echo $nkads_traduccion[7] ?>
                            <br>
                            <input type="text" name="nombre" maxlength="50" value="<? echo $nombre ?>" class="campos">
                            <br>
                            <font color='#FF0000' size="-2" face="Verdana, Arial, Helvetica, sans-serif">
                                <?
                                echo $error_nombre;
                                ?>
                            </font>
                            </font> </div>
                          <hr color="#D7AC00" size="1" align="center" width="100%">
                          <div align="center"><br>
                            <font face="Verdana, Arial, Helvetica, sans-serif" size="-2">
                            <? echo $nkads_traduccion[8] ?>
                            </font><br>
                            <select name="id_banner" class="select">
			<?
			//listo los banners
			$sql_listo = "Select id, nombre from ads_banners WHERE activo = '1' order by alt asc";
			$result_listo = mysql_query($sql_listo);
			If ($row_listo = mysql_fetch_array($result_listo)){
				$b = 1;
				do{
					if ($row_listo["id"] == $id_banner){
						$select = " selected";
					}else{
						$select = "";
					}
			?>
					<option value="<? echo $row_listo["id"] ?>"<? echo $select ?>>
					<? echo $row_listo["nombre"] ?>
					</option>
			<?
				}while($row_listo = mysql_fetch_array($result_listo));
		    	}else{
				$b = 0;
		    	?>
				<option value="no">
				<? echo $nkads_traduccion[9] ?>
				</option>
			<?
			}
			?>
                            </select>
                          </div>
		<hr color="#D7AC00" size="1" align="center" width="100%">
		  <div align="center"><br>
                            <font face="Verdana, Arial, Helvetica, sans-serif" size="-2">
                            <? echo $nkads_traduccion[232] ?>
                            </font><br>
		  <select name="id_cliente" class="select">
			<?
			//listo los clientes
			$sql_listo = "Select id, empresa from ads_clientes order by user asc";
			$result_listo = mysql_query($sql_listo);
			If ($row_listo = mysql_fetch_array($result_listo)){
				do{
     					if ($row_listo["id"] == $id_cliente){
						$selected = "selected";
					}else{
						$selected = "";
					}
			?>
      				<option <? echo $selected ?> value="<? echo $row_listo["id"] ?>">
				<? echo $row_listo["empresa"] ?>
				</option>
			<?
				}while($row_listo = mysql_fetch_array($result_listo));
    				if ($id_cliente == "0"){
					echo "<option value='' selected>". $nkads_traduccion[233]  ."</option>";
				}else{
					echo "<option value=''>". $nkads_traduccion[233]  ."</option>";
				}
			}
			?>
		</select>
		</div>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="-2"><br>
                                <?
                                If ($b == 1){
                                ?>
                                        <input type="submit" name="Submit2" value="<? echo $nkads_traduccion[17] ?>" class="botones">
                                <?
                                }
                                ?>
                                <input type="hidden" name="id_zona" value="<? echo $id_zona ?>">
                            </font><font face="Verdana, Arial, Helvetica, sans-serif" size="-2"><br>
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
</form>
