<?
//**********************************************************************************
// NKAds                                                                                           *
//**********************************************************************************
//
// Copyright (c) 2002 NKStudios S.R.L.
// http://nkads.nkstudios.net
//
// This program is free software. You can redistribute it and/or modify589
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 2 of the License.
//
//**********************************************************************************

/***************************************************************************************************************************************************/
//Funcion de muestra para los banner (locales)
/***************************************************************************************************************************************************/
if (!function_exists("muestra_banner")){
	function muestra_banner($ads_id,$ads_alt,$ads_contenido,$ads_tipo,$ads_target,$ads_url,$url_nkads,$ads_suma){
		if ($ads_target == '1'){
			$ads_targeta = " target=\"_blank\"";
		}else{
			$ads_targeta = "";
		}
		//Tipo imagen??
		If ($ads_tipo == "i"){
			//Verifico si se abre en _blank
			if($ads_url == "1"){
				$url_muestra = $ads_contenido;
			}else{
				$url_muestra = $url_nkads ."/img_banners/". $ads_contenido;
			}
			//Muestro el banner
			echo "<a" .  $ads_targeta . " href=\"".$url_nkads."/click.php?id=". $ads_id ."\" alt=\"". $ads_alt ."\"><img border=\"0\" src=\"". $url_muestra ."\"></a>";

		//No es imagen... sera FLASH?
		}else if($ads_tipo == "f"){
			if($ads_url == "1"){
				$url_muestra = $ads_contenido;
				$tamanio_swf = GetImageSize($ads_contenido);
			}else{
				$url_muestra = $url_nkads ."/img_banners/". $ads_contenido;
				$tamanio_swf = GetImageSize($url_nkads ."/img_banners/". $ads_contenido);
			}
			//Muestro el banner
			echo "<embed quality=\"high\" ". $tamanio_swf[3] . " pluginspage=\"http://www.macromedia.com/shockwave/download/\" src=\"". $url_muestra ."\"></embed>";
		}else{
			//No es FLASH entonces es texto
			if($ads_url == "1"){
				echo "<a" .  $ads_targeta . " href=\"".$url_nkads."/click.php?id=". $ads_id ."\">";
				stripslashes(readfile($ads_contenido));
				echo"</a>";
			}else{
				echo "<a" .  $ads_targeta . " href=\"".$url_nkads."/click.php?id=". $ads_id ."\">";
				echo stripslashes($ads_contenido);
				echo"</a>";
			}
		}
		if ($ads_suma == 1){
			//sumoooo
			$ads_sql_update = "UPDATE ads_estadisticas SET impresiones = impresiones + 1 WHERE id_banner = $ads_id AND fecha = '". date("Y-m-d") ."'";
			$ads_result_update = mysql_query($ads_sql_update);
			if(mysql_affected_rows() <> 1){
				$ads_sql_insert = "INSERT INTO ads_estadisticas VALUES ('". date("Y-m-d") ."','$ads_id','1','0')";
				$ads_result_insert = mysql_query($ads_sql_insert);
			}
		}
	}
}
/***************************************************************************************************************************************************/
//Funcion de muestra para los banner llamados por javascript (remotos)
/***************************************************************************************************************************************************/
if (!function_exists("muestra_banner_js")){
	function muestra_banner_js($ads_id,$ads_alt,$ads_contenido,$ads_tipo,$ads_target,$ads_url,$url_nkads){
		if ($ads_target == '1'){
			$ads_targeta = " target=\"_blank\"";
		}else{
			$ads_targeta = "";
		}

		//Tipo imagen??
		If ($ads_tipo == "i"){
			//Verifico si se abre en _blank
			if($ads_url == "1"){
				$url_muestra = $ads_contenido;
			}else{
				$url_muestra = $url_nkads ."/img_banners/". $ads_contenido;
			}
			//Muestro el banner
			echo "document.write('<a" .  $ads_targeta . " href=\"".$url_nkads."/click.php?id=". $ads_id ."\" alt=\"". $ads_alt ."\"><img border=\"0\" src=\"". $url_muestra ."\"></a>')";

		//No es imagen... sera FLASH?
		}else if($ads_tipo == "f"){
			if($ads_url == "1"){
				$url_muestra = $ads_contenido;
				$tamanio_swf = GetImageSize($ads_contenido);
			}else{
				$url_muestra = $url_nkads ."/img_banners/". $ads_contenido;
				$tamanio_swf = GetImageSize($url_nkads ."/img_banners/". $ads_contenido);
			}
			//Muestro el banner
			echo "document.write('<embed quality=\"high\"  ". $tamanio_swf[3] . " pluginspage=\"http://www.macromedia.com/shockwave/download/\" src=\"". $url_muestra ."\"></embed>')";
		}else{
                	//No es FLASH entonces es texto
			if($ads_url == "1"){
				echo "document.write('<a" .  $ads_targeta . " href=\"".$url_nkads."/click.php?id=". $ads_id ."\">";
				stripslashes(readfile($ads_contenido));
				echo"</a>')";
			}else{
				echo "document.write('<a" .  $ads_targeta . " href=\"".$url_nkads."/click.php?id=". $ads_id ."\">";
				echo stripslashes($ads_contenido);
				echo"</a>')";
			}
		}
		//sumoooo
		$ads_sql_update = "UPDATE ads_estadisticas SET impresiones = impresiones + 1 WHERE id_banner = $ads_id AND fecha = '". date("Y-m-d") ."'";
		$ads_result_update = mysql_query($ads_sql_update);
		if(mysql_affected_rows() <> 1){
			$ads_sql_insert = "INSERT INTO ads_estadisticas VALUES ('". date("Y-m-d") ."','$ads_id','1','0')";
			$ads_result_insert = mysql_query($ads_sql_insert);
		}
	}
}
?>