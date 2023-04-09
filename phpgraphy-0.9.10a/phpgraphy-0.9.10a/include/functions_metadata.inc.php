<?php
/*
*  Copyright (C) 2002-2005 JiM / aEGIS (jim@aegis-corp.org)
*
*  This program is free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2, or (at your option)
*  any later version.
*
*  This program is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  You should have received a copy of the GNU General Public License
*  along with this program; if not, write to the Free Software
*  Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
*
* $Id: functions_metadata.inc.php 130 2005-07-03 13:00:46Z jim $
*
*/

/*
* phpGraphy metadata EXIF/IPTC functions
*   external file 'sensors.dat' highly recommended to get the 35mm equivalent
*   on more cameras
*/

function get_exif_ref() {

// EXIF -> phpGraphy reference array (Only a selection of EXIF metadata are supported)
// NOTE: This function is used during the documentation build process

  $exif_ref=array(
		'Exif.Make',			// Camera Brand
		'Exif.Model',			// Camera Model
		'Exif.ExposureTime',		// Exposure Time (in seconds)
		'Exif.FNumber',			// F Number (Aperture)
		'Exif.FocalLength',		// Focal Length (in mm)
		'Exif.FocalLengthIn35mmFilm',	// Focal Length (in mm, using the 35mm equivalent)
		'Exif.ISO',			// ISO Speed Number (numeric value)
		'Exif.Flash',			// Flash status (set if flash was fired)
		'Exif.DateTime' 		// Picture DateTime (YYYY-MM-DD HH:II:SS)
		);

return $exif_ref;

}

function get_exif_data($image_path) {

// This function read EXIF data from a picture, format the data and return a formatted array
// See get_exif_ref() for the naming convention used with the returned array

$exif_header=@exif_read_data($image_path,'EXIF');

if (!is_array($exif_header)) return false;

// Formatting Exif.Make
$Make=ucfirst(strtolower($exif_header["Make"]));
if (stristr($Make,"Nikon")) $Make="Nikon";
else if (stristr($Make,"Olympus")) $Make="Olympus";
else if (stristr($Make,"Minolta")) $Make="Minolta";
else if (stristr($Make,"Kodak")) $Make="Kodak";
else if (stristr($Make,"Asahi")) $Make="Pentax";
else if (stristr($Make,"Casio")) $Make="Casio";
if ($Make) $result['Exif.Make']=$Make;


// Getting and Formatting Exif.Model - Get camera's model and eliminate brand's double
if ($exif_header["Model"]) {
   $Model=$exif_header["Model"];
   if (stristr(strtolower($Model),strtolower($Make))) $Model=eregi_replace($Make,'',$Model);
   // Special for Nikon Coolpix
   if ($Make=="Nikon" && ereg("E([0-9])",$Model)) $Model=eregi_replace('E','CoolPix ',$Model);
   }
if ($Model) $result['Exif.Model']=trim($Model);


// Getting and Formatting Exif.ExposureTime

if ($exif_header['ExposureTime']) {
   list($div,$ExposureTime)=split("/", $exif_header['ExposureTime']);
   $ExposureTime=$div/$ExposureTime;
   if ($ExposureTime < 1) $ExposureTime="1/".round(1/$ExposureTime,2);
   }
elseif ($exif_header['ShutterSpeedValue']) {
   list($ExposureTime,$div)=split("/", $exif_header['ShutterSpeedValue']);
   $ExposureTime=($div/10)/$ExposureTime;
   if ($ExposureTime < 1) $ExposureTime="1/".round(1/$ExposureTime,2);
   }
elseif ($exif_header["COMPUTED"]["ExposureTime"]) {
	ereg(".*\((.*)\)",$exif_header["COMPUTED"]["ExposureTime"], $res);
	$WorkingExposureTime=$res[1];
	}


if ($ExposureTime) $result['Exif.ExposureTime']=$ExposureTime;


// Getting and Formatting Exif.FNumber
if ($exif_header["FNumber"]) {
    list($FNumber,$div)=split("/", $exif_header["FNumber"]);
    $FNumber=round($FNumber/$div,1);
    }
    else if ($exif_header["COMPUTED"]["ApertureFNumber"]) $FNumber=$exif_header["COMPUTED"]["ApertureFNumber"];
if ($FNumber) $result['Exif.FNumber']=$FNumber;


// Getting and Formatting Exif.FocalLength
if ($exif_header["FocalLength"]) {
   list($FocalLength,$div)=split("/", $exif_header["FocalLength"]);
   $FocalLength=round($FocalLength/$div,2);
if ($FocalLength) $result['Exif.FocalLength']=$FocalLength;

// Try to get or calculate Exif.FocalLengthIn35mmFilm (35mm film equivalent of FocalLength)
// For the calcul, the model need to be registered in sensors.dat
if ($exif_header['FocalLengthIn35mmFilm']) $result['Exif.FocalLengthIn35mmFilm']=$exif_header['FocalLengthIn35mmFilm'];
else if ($sensor_size=get_sensor_size($exif_header["Make"],$exif_header["Model"])) $result['Exif.FocalLengthIn35mmFilm']=round(($FocalLength*43.27)/$sensor_size,0);
   }

// Getting and Formatting Exif.ISO (ISO sensitivity)
if ($exif_header["ISOSpeedRatings"]) $result['Exif.ISO']=$exif_header["ISOSpeedRatings"];
else {
     // Not standard exif... trying to get Make's specific data
     // Canon Stuff
     if ($Make == "Canon") {
        if (isset($exif_header["ModeArray"][16])) {
	   switch ($exif_header["ModeArray"][16]) {
		case 15:
		  $result['Exif.ISO']="Auto";
		  break;
		case 16:
		  $result['Exif.ISO']=50;
		  break;
		case 17:
		  $result['Exif.ISO']=100;
		  break;
		case 18:
		  $result['Exif.ISO']=200;
		  break;
		case 19:
		  $result['Exif.ISO']=400;
		  break;
		} // eo switch
	   } // eo isset fi
	} // eo make fi
     } // eo else

// Getting and Formatting Exif.Flash (set to 0 or 1)
/*
   On old Digital SLR, the field was just set to 1 if flash but now it's a little bit more complicated
   Seem that the value 16 mean no flash and 24 or 25 (depending SLR) mean with flash
   This routine surely need to be optimised
   On Canon 24 mean flash not used and 25 flash used
*/
if ($exif_header["Flash"] == 1 || $exif_header["Flash"] == 25) $result['Exif.Flash']=1;
else $result['Exif.Flash']=0;

// Getting and Formatting Exif.DateTime 
if ($exif_header['DateTimeOriginal'])  {
   $result['Exif.DateTime']=ereg_replace("([0-9]{4}):([0-9]{2}):([0-9]{2})()","\\1-\\2-\\3\\4",$exif_header['DateTimeOriginal']);
   }

if (is_array($result)) return $result;
}

function get_sensor_size($Make,$Model) {
  global $data_dir, $debug_mode;

  $datname=$data_dir."sensors.dat";
  if (!is_readable($datname)) {
     if ($debug_mode) echo "<b>ERROR:</b> Could not open the sensors file to display enhanced exif information<br>";
     return false;
    }

  $fh=fopen($datname,"rt");
  while(!feof($fh)) {
    $line=fgets($fh,4096);
    if(!$line || ereg("^(#| )", $line)) continue;
    $a=explode("|",$line);
    if(trim($a[0])==trim($Make) && trim($a[1])==trim($Model)) {
      fclose($fh);
      if (ereg("[0-9]{1,10}.?[0-9]{0,10}$",$a[2])) return($a[2]); else return(0);
      }
    }
}

function reformat_exif_txt($text, $exif_header=array()) {

  global $txt_exif_missing_value, $txt_exif_flash;

// This function convert KEYWORDS into VALUES found in $exif_header
// if the value isn't found, it will replace it with $txt_exif_missing_value

// Setting default text values if not already set
if (!isset($txt_exif_missing_value)) $txt_exif_missing_value="";
if (!isset($txt_exif_flash)) $txt_exif_flash="with flash";
if (!isset($text)) $text="%Exif.Make% %Exif.Model% %Exif.ExposureTime%s f/%Exif.FNumber% at %Exif.FocalLength%mm (35mm equiv: %Exif.FocalLengthIn35mmFilm%mm) iso%Exif.ISO% %Exif.Flash%";
  $exif_ref=get_exif_ref();

  $special_char="%";
  $temp_array=explode($special_char, $text);

  for ($i=0;$i<sizeof($temp_array);$i++) {
      unset($keywordfound);
      foreach ($exif_ref as $exif_key)
	 {
	 if ($temp_array[$i] == $exif_key)
	    {
	    // Found a valid keyword, trying to get it's value and then continue to parse
	    if (isset($exif_header[$exif_key]))
		{
		if ($exif_key == "Exif.Flash")
		   {
		   if ($exif_header[$exif_key] != 0) $keywordfound=$txt_exif_flash; else $keywordfound="";
		   }
		   else {
			$keywordfound=htmlentities($exif_header[$exif_key]); 
			$okforoutput=1; // This is set so we know we have at least something interessant
			}
		}
	    	else $keywordfound=$txt_exif_missing_value;
	    break;
	    }
	 }
      if (isset($keywordfound)) $result.=$keywordfound; else $result.=$temp_array[$i];
      }

  if ($okforoutput) return $result;

}

function get_exif_data_raw($image_path) {

// This function is for debugging only

$exif_header=@exif_read_data($image_path,'EXIF');

if (is_array($exif_header)) return $exif_header;

}

function get_iptc_ref() {

// IPTC -> phpGraphy reference array (Only a selection of IPTC metadata are supported)
// NOTE: This function is used during the documentation build process

  $iptc_ref=array(
		'2#005' => 'Iptc.ObjectName',			// Title (64 chars max)
		'2#015' => 'Iptc.Category',			// (3 chars max)
		'2#020' => 'Iptc.Supplementals',		// Supplementals categories (32 chars max)
		'2#025' => 'Iptc.Keywords',			// (64 chars max)
		'2#040' => 'Iptc.SpecialsInstructions',		// (256 chars max)
		'2#055' => 'Iptc.DateCreated', 			// YYYYMMDD (8 num chars max)
		'2#060' => 'Iptc.TimeCreated', 			// HHMMSS+/-HHMM (11 chars max)
		'2#062' => 'Iptc.DigitalCreationDate', 		// YYYYMMDD (8 num chars max)
		'2#063' => 'Iptc.DigitalCreationTime', 		// HHMMSS+/-HHMM (11 chars max)
		'2#080' => 'Iptc.ByLine',			// Author (32 chars max)
		'2#085' => 'Iptc.ByLineTitle',			// Author position (32 chars max)
		'2#090' => 'Iptc.City',				// (32 chars max)
		'2#092' => 'Iptc.Sublocation',			// (32 chars max)
		'2#095' => 'Iptc.ProvinceState',		// (32 chars max)
		'2#100' => 'Iptc.CountryCode',			// (32 alpha chars max)
		'2#101' => 'Iptc.CountryName',			// (64 chars max)
		'2#105' => 'Iptc.Headline',			// (256 chars max)
		'2#110' => 'Iptc.Credits',			// (32 chars max)
		'2#115' => 'Iptc.Source',			// (32 chars max)
		'2#116' => 'Iptc.Copyright',			// Copyright Notice (128 chars max)
		'2#118' => 'Iptc.Contact',			// (128 chars max)
		'2#120' => 'Iptc.Caption',			// Caption/Abstract (2000 chars max)
		'2#122' => 'Iptc.CaptionWriter'			// Caption Writer/Editor (32 chars max)
		);

  return $iptc_ref;
}

function get_iptc_data($image_path) {

// Read the IPTC header of a picture and return an array formatted from
// a specific manner so it can be handled to print out the way you want.

// Load the IPTC reference array

  $iptc_ref=get_iptc_ref();

	$separator=",";

// Extracting IPTC header and put it in the formatted array

  getimagesize($image_path, $imageinfo);

  if (is_array($imageinfo)) {

      $iptc_header=iptcparse($imageinfo["APP13"]);
     }

  if (is_array($iptc_header)) {

     $result=array();
     foreach ($iptc_header as $key => $value) {
        if (!isset($iptc_ref[$key])) continue;
				// Getting all the values of the array into a single variable
				unset($temp_value);
				foreach ($value as $subvalue) {
					if (!$temp_value) $temp_value=$subvalue; else $temp_value.=$separator.$subvalue;
					}
				$result= $result + array($iptc_ref[$key] => trim($temp_value));
        }
     }

return $result;

}


function reformat_iptc_txt($text, $iptc_header=array()) {

  global $txt_iptc_missing_value;

// This function convert KEYWORDS into VALUES found in $iptc_header
// if the value isn't found, it will replace it with $txt_iptc_missing_value

// Setting to default value if passed as a null var
if (!isset($txt_iptc_missing_value)) $txt_iptc_missing_value="";
if (!isset($text)) $text="Caption: %Iptc.Caption%\nKeywords: %Iptc.Keywords%\nTime Created: %Iptc.TimeCreated%\n";

  $iptc_ref=get_iptc_ref();

  $special_char="%";
  $temp_array=explode($special_char, $text);

  for ($i=0;$i<sizeof($temp_array);$i++) {
      unset($keywordfound);
      foreach ($iptc_ref as $iptc_key)
	 {
	 if ($temp_array[$i] == $iptc_key)
	    {
	    // Found a vavlid keyword, trying to get it's value and then continue to parse
	    if ($iptc_header[$iptc_key] != "") {
			$keywordfound=htmlentities($iptc_header[$iptc_key]); 
			$okforoutput=1; // This is set so we know we have at least something interessant
			}
	    	else $keywordfound=$txt_iptc_missing_value;
	    break;
	    }
	 }
      if (isset($keywordfound)) $result.=$keywordfound; else $result.=$temp_array[$i];
      }
  if ($okforoutput) return $result;
}

function get_iptc_data_raw($image_path) {   

// This function is for debugging only
	 
	 $size = getimagesize ( $image_path, $info);       
   if(is_array($info)) {   
      $iptc = iptcparse($info["APP13"]);
      }
return($iptc);
}

?>
