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
if($enviado== "1"){
	$todo_ok = "1";

	$texto = trim($texto);
	$link = trim($link);
	settype ($imp_compradas, "integer");

	//Controles minimos para el alta del banner...

	If (($imagen_size == 0) AND ($flash_size == 0) AND ($texto == "") AND ($imagen_viejo == "") AND ($flash_viejo == "") AND ($url == "")){
		$todo_ok = 0;
		$error_contenido = $nkads_traduccion[131];
	}

	If (($link == "") or ($link == "http://") AND ($flash_size == 0)){
		$todo_ok = 0;
		$error_link = $nkads_traduccion[111];
	}

	If ($nombre == "") {
		$todo_ok = 0;
                                $error_nombre = $nkads_traduccion[132];
	}

	if(!checkdate($mes_i,$dia_i,$anio_i)){
		$todo_ok = 0;
		$error_fecha_inicio = $nkads_traduccion[133];
	}

	if(!checkdate($mes_c,$dia_c,$anio_c)){
		$todo_ok = 0;
		$error_fecha_fin = $nkads_traduccion[134];
	}

	if ($anio_c.$mes_c.$dia_c < $anio_i.$mes_i.$dia_i){
		$todo_ok = 0;
		$error_fechas = $nkads_traduccion[135];
	}

	if (($imp_compradas == "") OR ($imp_compradas == 0) OR (!is_int($imp_compradas))){
		$todo_ok = 0;
		$error_impresiones = $nkads_traduccion[136];
	}

	if($todo_ok == "1"){
		if ($url <> ""){
			$url_control = 1;
			$contenido = $url;
			$urltipo = substr($url, strrpos($url, ".")+1);
			switch (strtolower($urltipo)){
				case "jpeg":
                                                            $tipo = "i";
				break;
				case "bmp":
					$tipo = "i";
				break;
				case "jpg":
					$tipo = "i";
				break;
				case "html":
					$tipo = "t";
				break;
				case "htm":
					$tipo = "t";
				break;
				case "txt":
					$tipo = "t";
				break;
				case "png":
					$tipo = "i";
				break;
				case "gif":
					$tipo = "i";
				break;
				case "swf":
					$tipo = "f";
				break;
			}
		}
		if ($imagen_size <> 0){
			copy($imagen,$path_absoluto"./img_banners/".$imagen_name);
			$contenido = $imagen_name;
			$tipo = "i";
		}else if($flash_size <> 0){
			copy($flash,$path_absoluto."/img_banners/".$flash_name);
			$contenido = $flash_name;
			$tipo = "f";
			$alt = "";
		}else if($texto <> ""){
			$contenido = addslashes($texto);
			$alt = "";
			$tipo = "t";
		}else if(($imagen_viejo <> "") AND ($tipo == "")){
			$contenido = $imagen_viejo;
			$tipo = "i";
		}else if($flash_viejo <> ""){
			$contenido = $flash_viejo;
			$alt = "";
			$tipo = "f";
		}
		$sql_grabo = "UPDATE ads_banners SET id_cliente='$id_usuario_session', tipo='$tipo',contenido='$contenido',link='$link',
				nombre='$nombre',alt='$alt', target='$target', url='$url_control', fecha_inicio='$anio_i-$mes_i-$dia_i', fecha_fin='$anio_c-$mes_c-$dia_c',
				imp_compradas='$imp_compradas', activo='$activo' WHERE id = '$id_banner'";
		$result_grabo = mysql_query($sql_grabo);
		Header("Location: exito_modifica.php?opcion_menu=banner&id_cliente_opcion=$id_cliente_opcion&d_cliente=$id_cliente&id_zona=$id_zona");
	}
}else{
	$sql_banner = "SELECT * FROM ads_banners WHERE id = $id_banner";
	$result_banner = mysql_query($sql_banner);
	If (!$row_banner = mysql_fetch_array($result_banner)){
		//error!
		Header("Location: banners_m.php");
	}else{
		$id_cliente = $row_banner["id_cliente"];
		switch($row_banner["tipo"]){
		case "t":
			if($row_banner["url"] == "1"){
				$url = $row_banner["contenido"];
			}else{
				$texto = $row_banner["contenido"];
			}
		break;
		case "f":
			if($row_banner["url"] == "1"){
				$url = $row_banner["contenido"];
			}else{
				$flash_contenido = $row_banner["contenido"];
			}
		break;
		case "i":
			if($row_banner["url"] == "1"){
				$url = $row_banner["contenido"];
			}else{
				$imagen_contenido = $row_banner["contenido"];
			}
		break;
		}
		$link =  $row_banner["link"];
		$nombre =  $row_banner["nombre"];
		$alt = $row_banner["alt"];
		$target = $row_banner["target"];
		$anio_i = substr($row_banner["fecha_inicio"],0, 4);
		$mes_i = substr($row_banner["fecha_inicio"], 5, 2);
		$dia_i = substr($row_banner["fecha_inicio"],8,2);
		$anio_c = substr($row_banner["fecha_fin"],0, 4);
		$mes_c = substr($row_banner["fecha_fin"], 5, 2);
		$dia_c = substr($row_banner["fecha_fin"],8,2);
		$imp_compradas = $row_banner["imp_compradas"];
		$activo = $row_banner["activo"];
		$enviado = 1;
	}
}
?>
<script>
function ili()
{
        if (ti.imp_compradas.value == "-1"){
                ti.imp_compradas.value="";
        }else{
                ti.imp_compradas.value="-1";
        }
}

function verifica()
{
        if (ti.nombre.value == "") {
                alert("<? echo $nkads_traduccion[118] ?>");
                form1.nombre.focus();
                return false;
        }
}
</script>
<link rel="stylesheet" href="../estilos.css" type="text/css">
<body bgcolor="#FFCC00" text="#000000" link="#000000" vlink="#000000" alink="#000000" leftmargin="0" topmargin="0">
<form enctype="multipart/form-data" name="ti" method="post" action="banners_m1.php?enviado=1">
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
                <tr>
                  <td colspan="3" bgcolor="#FFCC00">
                    <div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">
                      <b>
                      <? echo $nkads_traduccion[137] ?>
                      </b></font></div>
                  </td>
                </tr>
                <tr>
                  <td colspan="2">
                    <div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">
                      </font><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><b>
                      <? echo $nkads_traduccion[53] ?>
                      </b></font><font face="Verdana, Arial, Helvetica, sans-serif" size="1">
                      </font> </div>
                  </td>
                </tr>
                <tr>
                  <td colspan="2">
                    <div align="center">
                      <table width="100%" border="0" cellspacing="0" cellpadding="5" bgcolor="#FFD735">
                        <tr valign="middle">
                          <td colspan="2">
                            <div align="center">
                              <div align="center"><font size="-2" face="Verdana, Arial, Helvetica, sans-serif">
                                <? echo $nkads_traduccion[54] ?>
                                <br>
                                <br>
                                </font></div>
                              <div align="center"> <font size="-2" face="Verdana, Arial, Helvetica, sans-serif">
                                  <?
                        //Muestro el nombre del cliente
                        $sql_listo = "Select empresa from ads_clientes WHERE id = '$id_usuario_session'";
                        $result_listo = mysql_query($sql_listo);
                        If ($row_listo = mysql_fetch_array($result_listo)){
		echo $row_listo["empresa"];
                        }else{
		//jueps
		exit;
	       }
                        ?>
                                </font> <br>
                                <font color='#FF0000' size="1"> <br>
                                </font></div>
                            </div>
                          </td>
                        </tr>
                        <tr> 
                          <td colspan="2"> 
                            <hr color="#D7AC00" size="1" align="center" width="100%">
                          </td>
                        </tr>
                        <tr> 
                          <td valign="middle" width="50%"> 
                            <p align="center"><font size="-2" face="Verdana, Arial, Helvetica, sans-serif"> 
                              <? echo $nkads_traduccion[7] ?>
                              <br>
                              <br>
                              </font><font size="-2" face="Verdana, Arial, Helvetica, sans-serif"> 
                              <input type="hidden" name="id_banner" value="<? echo $id_banner ?>">
                              <input type="hidden" name="id_cliente_opcion" value="<? echo $id_cliente_opcion ?>">
                              <input type="hidden" name="id_zona" value="<? echo $id_zona ?>">
                              <input type="text" name="nombre" size="25" value="<? echo $nombre ?>" class="campos">
                              </font> 
                              <?
if($error_nombre <> ""){
?>
                              <br>
                              <br>
                              <font color='#FF0000' size="1"> 
                              <?
	echo $error_nombre;
?>
                              </font> 
                              <?
}
?>
                            </p>
                          </td>
                          <td valign="middle" width="50%"> 
                            <div align="center"> 
                              <div align="center"> 
                                <p align="center"><font size="-2" face="Verdana, Arial, Helvetica, sans-serif">Target</font></p>
                                <table border="0" cellspacing="0" cellpadding="0" align="center" width="141">
                                  <tr> 
                                    <td> 
                                      <div align="center"><font size="-2" face="Verdana, Arial, Helvetica, sans-serif"> 
                                        <?
if(($target == "1") OR ($enviado <> "1")){
	$check = " checked";
}else{
	$check = "";
}
?>
                                        <input type="radio" name="target" value="1"<? echo $check ?>>
                                        </font></div>
                                    </td>
                                    <td> 
                                      <div align="left"><font size="-2" face="Verdana, Arial, Helvetica, sans-serif"> 
                                        <? echo $nkads_traduccion[57] ?>
                                        </font></div>
                                    </td>
                                  </tr>
                                  <tr> 
                                    <td> 
                                      <div align="center"><font size="-2" face="Verdana, Arial, Helvetica, sans-serif"> 
                                        <?
if($target == "0"){
	$check = " checked";
}else{
	$check = "";
}
?>
                                        <input type="radio" name="target" value="0"<? echo $check ?>>
                                        </font></div>
                                    </td>
                                    <td> 
                                      <div align="left"><font size="-2" face="Verdana, Arial, Helvetica, sans-serif"> 
                                        <? echo $nkads_traduccion[59] ?>
                                        </font></div>
                                    </td>
                                  </tr>
                                </table>
                              </div>
                            </div>
                          </td>
                        </tr>
                        <tr> 
                          <td colspan="2"> 
                            <hr color="#D7AC00" size="1" align="center" width="100%">
                          </td>
                        </tr>
                        <tr> 
                          <td valign="top"> 
                            <p align="center"><font size="-2" face="Verdana, Arial, Helvetica, sans-serif"> 
                              <? echo $nkads_traduccion[24] ?>
                              </font></p>
                            <div align="center"> 
                              <table border="0" cellspacing="0" cellpadding="0" align="center" width="208">
                                <tr> 
                                  <td> 
                                    <div align="center"><font size="-2" face="Verdana, Arial, Helvetica, sans-serif"> 
                                      <? echo $nkads_traduccion[60] ?>
                                      </font></div>
                                  </td>
                                  <td> 
                                    <div align="center"><font size="-2" face="Verdana, Arial, Helvetica, sans-serif"> 
                                      <? echo $nkads_traduccion[61] ?>
                                      </font></div>
                                  </td>
                                  <td> 
                                    <div align="center"><font size="-2" face="Verdana, Arial, Helvetica, sans-serif"> 
                                      <? echo $nkads_traduccion[62] ?>
                                      </font></div>
                                  </td>
                                </tr>
                                <tr> 
                                  <td>&nbsp; </td>
                                  <td>&nbsp; </td>
                                  <td>&nbsp; </td>
                                </tr>
                                <tr> 
                                  <td> 
                                    <div align="center"><font size="-2" face="Verdana, Arial, Helvetica, sans-serif"> 
                                      <select name="dia_i" class="select">
			<?
			$contd = 1;
			do {
				if($dia_i == $contd){
					$selec = "selected";
				}else{
					$selec = "";
				}
				$contd = str_pad($contd, 2, "0", STR_PAD_LEFT);
				echo "<option value=\"" . $contd . "\"". $selec .">" . $contd . "</option>";
				$contd = $contd + 1;
			}while($contd <= 31);
			?>
                                      </select>
                                      </font></div>
                                  </td>
                                  <td> 
                                    <div align="center"> <font size="-2" face="Verdana, Arial, Helvetica, sans-serif"> 
                                      <select name="mes_i" class="select">
                                        <?
if($mes_i == "01"){
	$selec = " selected";
}else{
	$selec = "";
}
?>
                                        <option value="01"<? echo $selec ?>>
                                        <? echo $nkads_traduccion[63] ?>
                                        </option>
                                        <?
if($mes_i == "02"){
	$selec = " selected";
}else{
	$selec = "";
}
?>
                                        <option value="02"<? echo $selec ?>>
                                        <? echo $nkads_traduccion[64] ?>
                                        </option>
                                        <?
if($mes_i == "03"){
	$selec = " selected";
}else{
	$selec = "";
}
?>
                                        <option value="03"<? echo $selec ?>>
                                        <? echo $nkads_traduccion[65] ?>
                                        </option>
                                        <?
if($mes_i == "04"){
	$selec = " selected";
}else{
	$selec = "";
}
?>
                                        <option value="04"<? echo $selec ?>>
                                        <? echo $nkads_traduccion[66] ?>
                                        </option>
                                        <?
if($mes_i == "05"){
	$selec = " selected";
}else{
	$selec = "";
}
?>
                                        <option value="05"<? echo $selec ?>>
                                        <? echo $nkads_traduccion[67] ?>
                                        </option>
                                        <?
if($mes_i == "06"){
	$selec = " selected";
}else{
	$selec = "";
}
?>
                                        <option value="06"<? echo $selec ?>>
                                        <? echo $nkads_traduccion[68] ?>
                                        </option>
                                        <?
if($mes_i == "07"){
	$selec = " selected";
}else{
	$selec = "";
}
?>
                                        <option value="07"<? echo $selec ?>>
                                        <? echo $nkads_traduccion[69] ?>
                                        </option>
                                        <?
if($mes_i == "08"){
	$selec = " selected";
}else{
	$selec = "";
}
?>
                                        <option value="08"<? echo $selec ?>>
                                        <? echo $nkads_traduccion[70] ?>
                                        </option>
                                        <?
if($mes_i == "09"){
	$selec = " selected";
}else{
	$selec = "";
}
?>
                                        <option value="09"<? echo $selec ?>>
                                        <? echo $nkads_traduccion[71] ?>
                                        </option>
                                        <?
if($mes_i == "10"){
	$selec = " selected";
}else{
	$selec = "";
}
?>
                                        <option value="10"<? echo $selec ?>> 
                                        <? echo $nkads_traduccion[72] ?>
                                        </option>
                                        <?
if($mes_i == "11"){
	$selec = " selected";
}else{
	$selec = "";
}
?>
                                        <option value="11"<? echo $selec ?>> 
                                        <? echo $nkads_traduccion[73] ?>
                                        </option>
                                        <?
if($mes_i == "12"){
	$selec = " selected";
}else{
	$selec = "";
}
?>
                                        <option value="12"<? echo $selec ?>> 
                                        <? echo $nkads_traduccion[74] ?>
                                        </option>
                                      </select>
                                      </font></div>
                                  </td>
                                  <td> 
                                    <div align="center"><font size="-2" face="Verdana, Arial, Helvetica, sans-serif"> 
                                      <select name="anio_i" class="select">
                                        <?
                              $cont = date(Y);
                              do {
		if($anio_i == $cont){
			$selec = " selected";
		}else{
			$selec = "";
		}
                              	echo "<option". $selec .">" . $cont . "</option>";
                              	 $cont = $cont + 1;
                              }while($cont <= (date(Y) + 10));
                              ?>
                                      </select>
                                      </font> </div>
                                  </td>
                                </tr>
                                <?
if($error_fecha_inicio <> ""){
?>
                                <tr> 
                                  <td colspan="3"> <br>
                                    <?
	echo $error_fecha_inicio;
?>
                                  </td>
                                </tr>
                                <?
}
?>
                              </table>
                            </div>
                          </td>
                          <td valign="top"> 
                            <div align="center"> 
                              <p align="center"><font size="-2" face="Verdana, Arial, Helvetica, sans-serif"> 
                                <? echo $nkads_traduccion[25] ?>
                                </font></p>
                              <div align="center"> 
                                <table width="208" border="0" cellspacing="0" cellpadding="0">
                                  <tr> 
                                    <td> 
                                      <div align="center"><font size="-2" face="Verdana, Arial, Helvetica, sans-serif"> 
                                        <? echo $nkads_traduccion[60] ?>
                                        </font></div>
                                    </td>
                                    <td> 
                                      <div align="center"><font size="-2" face="Verdana, Arial, Helvetica, sans-serif"> 
                                        <? echo $nkads_traduccion[61] ?>
                                        </font></div>
                                    </td>
                                    <td> 
                                      <div align="center"><font size="-2" face="Verdana, Arial, Helvetica, sans-serif"> 
                                        <? echo $nkads_traduccion[62] ?>
                                        </font></div>
                                    </td>
                                  </tr>
                                  <tr> 
                                    <td>&nbsp; </td>
                                    <td>&nbsp; </td>
                                    <td>&nbsp; </td>
                                  </tr>
                                  <tr> 
                                    <td> 
                                      <div align="center"><font size="-2" face="Verdana, Arial, Helvetica, sans-serif"> 
                                        <select name="dia_c" class="select">
                                          <?
                              	$contd = 1;
                              	do {
				if($dia_c == $contd){
					$selec = "selected";
				}else{
					$selec = "";
				}
				$contd = str_pad($contd, 2, "0", STR_PAD_LEFT);
				echo "<option value=\"" . $contd . "\"". $selec .">" . $contd . "</option>";
                              	 	$contd = $contd + 1;
                              	}while($contd <= 31);
                              ?>
                                        </select>
                                        </font></div>
                                    </td>
                                    <td>
                                      <div align="center"> <font size="-2" face="Verdana, Arial, Helvetica, sans-serif">
                                        <select name="mes_c" class="select">
                                          <?
if($mes_c == "01"){
	$selec = " selected";
}else{
	$selec = "";
}
?>
                                          <option value="01"<? echo $selec ?>>
                                          <? echo $nkads_traduccion[63] ?>
                                          </option>
                                          <?
if($mes_c == "02"){
	$selec = " selected";
}else{
	$selec = "";
}
?>
                                          <option value="02"<? echo $selec ?>>
                                          <? echo $nkads_traduccion[64] ?>
                                          </option>
                                          <?
if($mes_c == "03"){
	$selec = " selected";
}else{
	$selec = "";
}
?>
                                          <option value="03"<? echo $selec ?>>
                                          <? echo $nkads_traduccion[65] ?>
                                          </option>
                                          <?
if($mes_c == "04"){
	$selec = " selected";
}else{
	$selec = "";
}
?>
                                          <option value="04"<? echo $selec ?>>
                                          <? echo $nkads_traduccion[66] ?>
                                          </option>
                                          <?
if($mes_c == "05"){
	$selec = " selected";
}else{
	$selec = "";
}
?>
                                          <option value="05"<? echo $selec ?>>
                                          <? echo $nkads_traduccion[67] ?>
                                          </option>
                                          <?
if($mes_c == "06"){
	$selec = " selected";
}else{
	$selec = "";
}
?>
                                          <option value="06"<? echo $selec ?>>
                                          <? echo $nkads_traduccion[68] ?>
                                          </option>
                                          <?
if($mes_c == "07"){
	$selec = " selected";
}else{
	$selec = "";
}
?>
                                          <option value="07"<? echo $selec ?>>
                                          <? echo $nkads_traduccion[69] ?>
                                          </option>
                                          <?
if($mes_c == "08"){
	$selec = " selected";
}else{
	$selec = "";
}
?>
                                          <option value="08"<? echo $selec ?>>
                                          <? echo $nkads_traduccion[70] ?>
                                          </option>
                                          <?
if($mes_c == "09"){
	$selec = " selected";
}else{
	$selec = "";
}
?>
                                          <option value="09"<? echo $selec ?>> 
                                          <? echo $nkads_traduccion[71] ?>
                                          </option>
                                          <?
if($mes_c == "10"){
	$selec = " selected";
}else{
	$selec = "";
}
?>
                                          <option value="10"<? echo $selec ?>> 
                                          <? echo $nkads_traduccion[72] ?>
                                          </option>
                                          <?
if($mes_c == "11"){
	$selec = " selected";
}else{
	$selec = "";
}
?>
                                          <option value="11"<? echo $selec ?>> 
                                          <? echo $nkads_traduccion[73] ?>
                                          </option>
                                          <?
if($mes_c == "12"){
	$selec = " selected";
}else{
	$selec = "";
}
?>
                                          <option value="12"<? echo $selec ?>> 
                                          <? echo $nkads_traduccion[74] ?>
                                          </option>
                                        </select>
                                        </font></div>
                                    </td>
                                    <td> 
                                      <div align="center"><font size="-2" face="Verdana, Arial, Helvetica, sans-serif"> 
                                        <select name="anio_c" class="select">
                                          <?
                              $cont = date(Y);
                              do {
		if($anio_c == $cont){
			$selec = " selected";
		}else{
			$selec = "";
		}
                              	echo "<option". $selec .">" . $cont . "</option>";
                              	 $cont = $cont + 1;
                              }while($cont <= (date(Y) + 10));
                              ?>
                                        </select>
                                        </font> </div>
                                    </td>
                                  </tr>
                                  <?
if($error_fecha_fin <> ""){
?>
                                  <tr> 
                                    <td colspan="3"> <br>
                                      <?
	echo $error_fecha_fin;
?>
                                    </td>
                                  </tr>
                                  <?
}
if($error_fechas <> ""){
?>
                                  <tr> 
                                    <td colspan="3"> <br>
                                      <?
	echo $error_fechas;
?>
                                    </td>
                                  </tr>
                                  <?
}
?>
                                </table>
                              </div>
                            </div>
                          </td>
                        </tr>
                        <tr> 
                          <td colspan="2"> 
                            <hr color="#D7AC00" size="1" align="center" width="100%">
                          </td>
                        </tr>
                        <tr valign="top"> 
                          <td> 
                            <div align="center"><font size="-2" face="Verdana, Arial, Helvetica, sans-serif"> 
                              <? echo $nkads_traduccion[27] ?>
                              <br>
                              <br>
                              </font><font size="-2" face="Verdana, Arial, Helvetica, sans-serif"> 
                              <input type="text" name="imp_compradas" size="8" value="<? echo $imp_compradas ?>" class="campos">
                              <br>
                              <br>
                              <?
if($imp_compradas == "-1"){
	$check = " checked";
}else{
	$check = "";
}
?>
                              <input type="checkbox" name="ilimitadas" value="1" onClick="ili()"<? echo $check ?>>
                              <? echo $nkads_traduccion[46] ?>
                              <br>
                              </font> 
                              <?
if($error_impresiones <> ""){
	echo "<br><font color=\"#FF0000\" size=\"1\">". $error_impresiones ."</font>";
}
?>
                            </div>
                          </td>
                          <td> 
                            <div align="center"><font size="-2" face="Verdana, Arial, Helvetica, sans-serif"> 
                              <? echo $nkads_traduccion[83] ?>
                              <br>
                              </font><font size="-2" face="Verdana, Arial, Helvetica, sans-serif"> 
                              <?
if(($activo == 1) OR ($enviado <> "1")){
	$check = " checked";
}else{
	$check = "";
}
?>
                              <input type="checkbox" name="activo" value="1"<? echo $check ?>>
                              </font></div>
                          </td>
                        </tr>
                        <tr> 
                          <td colspan="2"> 
                            <hr color="#D7AC00" size="1" align="center" width="100%">
                          </td>
                        </tr>
                        <tr valign="middle"> 
                          <td colspan="2"> 
                            <div align="center"><font size="-2" face="Verdana, Arial, Helvetica, sans-serif">Link<br>
                              </font><font size="-2" face="Verdana, Arial, Helvetica, sans-serif"> 
                              <?
if($enviado <> "1"){
	$valor_link = "http://";
}else{
	$valor_link = $link;
}
?>
                              <input type="text" name="link" value="<? echo $valor_link ?>" size="50" class="select">
                              <br>
                              </font> 
                              <?
if($error_link <> ""){
	echo "<br><font color=\"#FF0000\" size=\"1\">". $error_link ."</font>";
}
?>
                              <br>
                            </div>
                          </td>
                        </tr>
                      </table>
                    </div>
                  </td>
                </tr>
                <tr> 
                  <td width="50%"> 
                    <div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="2"> 
                      <? echo $nkads_traduccion[85] ?>
                      </font><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                      </font></div>
                  </td>
                  <td width="50%"> 
                    <div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="2"> 
                      <? echo $nkads_traduccion[86] ?>
                      </font><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
                      </font></div>
                  </td>
                </tr>
                <tr> 
                  <td width="50%" bgcolor="#FFD735" height="134" valign="top"> 
                    <div align="center"> 
                      <p align="center"><font size="-2" face="Verdana, Arial, Helvetica, sans-serif"><br>
                        <? echo $nkads_traduccion[89] ?>
                        <?
if($imagen_contenido <> ""){
	echo "<br>(Actual $imagen_contenido)";
	echo "<input type=\"hidden\" name=\"imagen_viejo\" value=\"$imagen_contenido\"><br>";
}
?>
                        </font></p>
                      <p align="center"> <font size="-2" face="Verdana, Arial, Helvetica, sans-serif"> 
                        <input type="file" name="imagen" class="campos">
                        </font><br>
                        <font size="-2" face="Verdana, Arial, Helvetica, sans-serif">Alt<br>
                        </font><font size="-2" face="Verdana, Arial, Helvetica, sans-serif"> 
                        <input type="text" name="alt" value="<? echo $alt ?>" class="campos">
                        </font> 
                        <?
if($error_contenido <> ""){
?>
                        <br>
                        <font color='#FF0000' size="1"> 
                        <?
	echo $error_contenido;
?>
                        </font> 
                        <?
}
?>
                        <br>
                        &nbsp; </p>
                    </div>
                  </td>
                  <td width="50%" bgcolor="#FFD735" height="134" valign="top"> 
                    <div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="-2"><br>
                      <? echo $nkads_traduccion[88] ?>
                      <br>
                      <textarea name="texto" cols="30" rows="4" class="campos"><? echo stripslashes($texto) ?></textarea>
                      </font>
                      <?
if($error_contenido <> ""){
?>
                      <br>
                      <font color='#FF0000' size="1">
                      <?
	echo $error_contenido;
?>
                      </font>
                      <?
}
?>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>
                    <div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">
                      <? echo $nkads_traduccion[95] ?>
                      </font><font face="Verdana, Arial, Helvetica, sans-serif" size="1">
                      </font></div>
                  </td>
                  <td>
                    <div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">
                      <? echo $nkads_traduccion[141] ?>
                      </font><font face="Verdana, Arial, Helvetica, sans-serif" size="1">
                      </font></div>
                  </td>
                </tr>
                <tr>
                  <td bgcolor="#FFD735" valign="top">
                    <div align="center"><font size="-2" face="Verdana, Arial, Helvetica, sans-serif"><font face="Verdana, Arial, Helvetica, sans-serif" size="-2"><br>
                      <? echo $nkads_traduccion[98] ?>
                      <br>
                      <?
if($flash_contenido <> ""){
	echo "(Actual $flash_contenido)";
	echo "<input type=\"hidden\" name=\"flash_viejo\" value=\"$flash_contenido\"><br>";
}
?>
                      </font></font><font face="Verdana, Arial, Helvetica, sans-serif" size="-2">
                      <input type="file" name="flash" class="campos">
                      <br>
                      <br>
                      </font>
                      <?
if($error_contenido <> ""){
?>
                      <br>
                      <font color='#FF0000' size="1">
                      <?
	echo $error_contenido;
?>
                      </font>
                      <?
}
?>
                      <br>
                      &nbsp; </div>
                  </td>
                  <td bgcolor="#FFD735" valign="top">
                    <div align="center"><font size="-2" face="Verdana, Arial, Helvetica, sans-serif"><font face="Verdana, Arial, Helvetica, sans-serif" size="-2"><br>
                      <? echo $nkads_traduccion[142] ?>
                      </font><br>
                      <input type="text" name="url" value="<? echo $url ?>" size="40" class="campos">
                      </font>
<?
if($error_contenido <> ""){
?>
                      <br>
                      <font color='#FF0000' size="1">
                      <?
	echo $error_contenido;
?>
                      </font>
                      <?
}
?>
</div>
                  </td>
                </tr>
                <tr>
                  <td colspan="2">
                    <div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">
                      <? echo $nkads_traduccion[97] ?>
                      </font><font face="Verdana, Arial, Helvetica, sans-serif" size="1"></font></div>
                  </td>
                </tr>
                <tr>
                  <td colspan="2">
                    <div align="center"> <br>
                                <input type="submit" name="Submit" class="botones" value="<? echo $nkads_traduccion[17] ?>">
                      <br>
                      &nbsp; </div>
                  </td>
                </tr>
                <tr>
                  <td colspan="2">
                    <div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">
                      <? echo $nkads_traduccion[101] ?>
                      </font><font face="Verdana, Arial, Helvetica, sans-serif" size="1">
                      </font></div>
                  </td>
                </tr>
                <tr>
                  <td colspan="2">
                    <table width="98%" border="0" cellspacing="0" cellpadding="2" align="center">
                      <tr>
                        <td>
                          <div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="-2">
                            <? echo $nkads_traduccion[105] ?>
                            <br>
                            <? echo $nkads_traduccion[106] ?>
                            </font></div>
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
