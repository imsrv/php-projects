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
        $n_password = trim($n_password);
        $n_password2 = trim($n_password2);
        if(strlen($n_password) < 4){
                $error_pass = $nkads_traduccion[197] .".";
        }
        if($n_password <> $n_password2){
                $error_pass = $nkads_traduccion[198] .".";
        }
        if(($n_user == "") OR ($n_user2 == "")){
                $error_user = $nkads_traduccion[202] .".";
        }else{
                if($n_user <> $n_user2){
                        $error_user = $nkads_traduccion[201] .".";
                }else{
		$sql = "Select user from ads_clientes where user = '$n_user'";
		$result = mysql_query($sql);
		if ($row = mysql_fetch_array($result)){
			$error_user = $nkads_traduccion[184];
		}
		$sql = "SELECT usuario FROM ads_master WHERE usuario = '$n_user'";
		$result = mysql_query($sql);
		if ($row = mysql_fetch_array($result)){
			$error_user = $nkads_traduccion[184];
		}
	}
        }
        if (($error_pass == "") AND ($error_user == "")){
                //guardo los datos
                        $sql = "UPDATE ads_clientes SET pass = '$n_password', user = '$n_user' WHERE id = '$id_usuario_session'";
                        $result = mysql_query($sql);
                        header("Location: index.php");
        }
}
?>

<link rel="stylesheet" href="estilos.css" type="text/css">
<body bgcolor="#FFCC00" text="#000000" link="#000000" vlink="#000000" alink="#000000" leftmargin="0" topmargin="0">
<form enctype="multipart/form-data" name="ti" method="post" action="password_n.php?enviado=1">
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
<? echo $nkads_traduccion[194] ?>
                      </b></font></div>
                  </td>
                </tr>
                <tr>
                  <td>
                    <table width="100%" border="0" cellspacing="0" cellpadding="5" bgcolor="#FFD735">
                      <tr valign="middle">
                        <td>
                          <div align="center"><font size="-2" face="Verdana, Arial, Helvetica, sans-serif">
                            <? echo $nkads_traduccion[195] ?>
                            <br>
                            <input type="password" name="n_password" size="30" value="<? echo $n_password ?>" class="campos">
                            </font></div>
                        </td>
                        <td>
                          <div align="center"><font size="-2" face="Verdana, Arial, Helvetica, sans-serif">
                            <? echo $nkads_traduccion[199] ?>
                            <br>
                            </font><font size="-2" face="Verdana, Arial, Helvetica, sans-serif">
                            <input type="text" name="n_user" size="30" value="<? echo $n_user ?>" class="campos">
                            </font></div>
                        </td>
                      </tr>
                      <tr valign="middle">
                        <td>
                          <div align="center"><font size="-2" face="Verdana, Arial, Helvetica, sans-serif">
                            <? echo $nkads_traduccion[196] ?>
                            <br>
                            <input type="password" name="n_password2" size="30" value="<? echo $n_password2 ?>" class="campos">
                            </font></div>
                        </td>
                        <td>
                          <div align="center"><font size="-2" face="Verdana, Arial, Helvetica, sans-serif">
                            <? echo $nkads_traduccion[200] ?>
                            <br>
                            </font><font size="-2" face="Verdana, Arial, Helvetica, sans-serif">
                            <input type="text" name="n_user2" size="30" value="<? echo $n_user2 ?>" class="campos">
                            </font></div>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <div align="center"><font size="-2" face="Verdana, Arial, Helvetica, sans-serif" color='#FF0000'>
                            <?echo $error_pass;				?>
                            </font></div>
                        </td>
                        <td>
                          <div align="center"><font size="-2" face="Verdana, Arial, Helvetica, sans-serif" color='#FF0000'>
                            <?echo $error_user;						?>
                            </font></div>
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
