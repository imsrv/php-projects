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

//verifico algunos datos

if ($enviado == 1){
	$todo_ok = 1;

	if ($empresa == ""){
		$error_empresa = $nkads_traduccion[107];
		$todo_ok = 0;
	}

	if ($user == ""){
		$error_user = $nkads_traduccion[109];
		$todo_ok = 0;
	}else{
		//verifico que el user no se repita
		$sql = "Select user from ads_clientes where user = '$user'";
		$result = mysql_query($sql);
		if ($row = mysql_fetch_array($result)){
			$error_user = $nkads_traduccion[184];
			$todo_ok = 0;
		}else{
			//Verifico ke el user no sea igual al admin
			$sql = "Select usuario from ads_master where usuario = '$user'";
			$result = mysql_query($sql);
			if ($row = mysql_fetch_array($result)){
				$error_user = $nkads_traduccion[184];
				$todo_ok = 0;
			}
		}
	}

	if ($pass == ""){
		$error_pass = $nkads_traduccion[110];
		$todo_ok = 0;
	}

	if ($todo_ok == 1){
		//guardo los datos
		$sql = "Insert into ads_clientes values ('', '$empresa', '$domicilio', '$ciudad', '$provincia', '$pais', '$telefono', '$fax', '$email', '$url', '$user', '$pass','$acceso')";
		$result = mysql_query($sql);

		$id_cliente = mysql_insert_id();

		$url_destino = "exito_alta.php?opcion_menu=cliente&id_cliente=".$id_cliente;
		header("Location: $url_destino");
	}
}
?>

<link rel="stylesheet" href="estilos.css" type="text/css">
<body bgcolor="#FFCC00" text="#000000" link="#000000" vlink="#000000" alink="#000000" leftmargin="0" topmargin="0">
<form enctype="multipart/form-data" name="ti" method="post" action="clientes_n.php?enviado=1">
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
                      <? echo $nkads_traduccion[99] ?>
                      </b></font></div>
                  </td>
                </tr>
                <tr> 
                  <td> 
                    <table width="100%" border="0" cellspacing="0" cellpadding="5" bgcolor="#FFD735">
                      <tr valign="middle"> 
                        <td> 
                          <div align="center"><font size="-2" face="Verdana, Arial, Helvetica, sans-serif"> 
                            <? echo $nkads_traduccion[112] ?>
                            <br>
                            <input type="text" name="empresa" size="30" value="<? echo $empresa ?>" class="campos">
                            <br>
                            <font color='#FF0000'> 
                            <?
						echo $error_empresa;
						?>
                            </font></font></div>
                        </td>
                        <td> 
                          <div align="center"><font size="-2" face="Verdana, Arial, Helvetica, sans-serif"> 
                            <? echo $nkads_traduccion[113] ?>
                            <br>
                            </font><font size="-2" face="Verdana, Arial, Helvetica, sans-serif"> 
                            <input type="text" name="domicilio" size="30" value="<? echo $domicilio ?>" class="campos">
                            </font></div>
                        </td>
                      </tr>
                      <tr> 
                        <td colspan="2"> 
                          <hr color="#D7AC00" size="1" align="center" width="100%">
                        </td>
                      </tr>
                      <tr> 
                        <td valign="middle"> 
                          <p align="center"><font size="-2" face="Verdana, Arial, Helvetica, sans-serif"> 
                            <? echo $nkads_traduccion[114] ?>
                            <br>
                            </font><font size="-2" face="Verdana, Arial, Helvetica, sans-serif"> 
                            <input type="text" name="ciudad" size="30" value="<? echo $ciudad ?>" class="campos">
                            </font></p>
                        </td>
                        <td valign="middle"> 
                          <div align="center"><font size="-2" face="Verdana, Arial, Helvetica, sans-serif"> 
                            <? echo $nkads_traduccion[115] ?>
                            <br>
                            </font><font size="-2" face="Verdana, Arial, Helvetica, sans-serif"> 
                            <input type="text" name="provincia" size="30" value="<? echo $provincia ?>" class="campos">
                            </font></div>
                        </td>
                      </tr>
                      <tr> 
                        <td colspan="2"> 
                          <hr color="#D7AC00" size="1" align="center" width="100%">
                        </td>
                      </tr>
                      <tr> 
                        <td valign="middle"> 
                          <p align="center"><font size="-2" face="Verdana, Arial, Helvetica, sans-serif"> 
                            <? echo $nkads_traduccion[116] ?>
                            <br>
                            </font><font size="-2" face="Verdana, Arial, Helvetica, sans-serif"> 
                            <input type="text" name="pais" size="30" value="<? echo $pais ?>" class="campos">
                            </font></p>
                        </td>
                        <td valign="middle"> 
                          <div align="center"><font size="-2" face="Verdana, Arial, Helvetica, sans-serif"> 
                            <? echo $nkads_traduccion[117] ?>
                            <br>
                            </font><font size="-2" face="Verdana, Arial, Helvetica, sans-serif">
                            <input type="text" name="telefono" size="30" value="<? echo $telefono ?>" class="campos">
                            </font></div>
                        </td>
                      </tr>
                      <tr> 
                        <td colspan="2"> 
                          <hr color="#D7AC00" size="1" align="center" width="100%">
                        </td>
                      </tr>
                      <tr> 
                        <td valign="middle"> 
                          <div align="center"><font size="-2" face="Verdana, Arial, Helvetica, sans-serif"> 
                            <? echo $nkads_traduccion[119] ?>
                            <br>
                            </font><font size="-2" face="Verdana, Arial, Helvetica, sans-serif"> 
                            <input type="text" name="fax" size="30" value="<? echo $fax ?>" class="campos">
                            </font></div>
                        </td>
                        <td valign="middle"> 
                          <div align="center"><font size="-2" face="Verdana, Arial, Helvetica, sans-serif"> 
                            <? echo $nkads_traduccion[120] ?>
                            <br>
                            </font><font size="-2" face="Verdana, Arial, Helvetica, sans-serif">
                            <input type="text" name="email" size="30" value="<? echo $email ?>" class="campos">
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
                            <input type="text" name="url" size="45" value="<? echo $url ?>" class="campos">
                            </font></div>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr> 
                  <td> 
                    <div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><b> 
                      <? echo $nkads_traduccion[121] ?>
                      </b></font></div>
                  </td>
                </tr>
                <tr> 
                  <td> 
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#FFD735">
                      <tr> 
                        <td valign="middle" width="50%" height="32"> 
                          <div align="center"><font size="-2" face="Verdana, Arial, Helvetica, sans-serif"> 
                            <? echo $nkads_traduccion[122] ?>
                            <br>
                            </font><font size="-2" face="Verdana, Arial, Helvetica, sans-serif"> 
                            <input type="text" name="user" size="30" value="<? echo $user ?>" class="campos">
                            <br>
                            <font color='#FF0000'> 
                            <?
						echo $error_user;
						?>
                            </font> </font></div>
                        </td>
                        <td width="305" valign="middle" height="32"> 
                          <div align="center"><font size="-2" face="Verdana, Arial, Helvetica, sans-serif"> 
                            <? echo $nkads_traduccion[123] ?>
                            <br>
                            </font><font size="-2" face="Verdana, Arial, Helvetica, sans-serif"> 
                            <input type="text" name="pass" size="30" value="<? echo $pass ?>" class="campos">
                            <br>
                            <font color='#FF0000'> 
			<?
			echo $error_pass;
			?>
                            </font> </font></div>
                        </td>
                      </tr>
                      <tr> 
                        <td valign="middle" colspan="2"> 
                          <div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><b><br>
                            <? echo $nkads_traduccion[234] ?></b></font></div>
                        </td>
                      </tr>
                      <tr> 
                        <td valign="middle" colspan="2">
                          <table width="101" border="0" cellspacing="0" cellpadding="0" align="center">
                            <tr>
                              <td width="24"> 
                                <input type="radio" name="acceso" value="0" checked>
                              </td>
                              <td width="131"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo $nkads_traduccion[235] ?></font>
                              </td>
                            </tr>
                            <tr>
                              <td width="24">
                                <input type="radio" name="acceso" value="1">
                              </td>
                              <td width="131"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo $nkads_traduccion[236] ?></font>
                              </td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr> 
                  <td>
                    <div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><b> 
                      <? echo $nkads_traduccion[97] ?>
                      </b></font></div>
                  </td>
                </tr>
                <tr>
                  <td>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#FFD735" height="59">
                      <tr> 
                        <td valign="middle" height="52"> 
                          <div align="center"> 
                            <input type="submit" name="Submit" value="<? echo $nkads_traduccion[17] ?>" class="botones">
                          </div>
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
