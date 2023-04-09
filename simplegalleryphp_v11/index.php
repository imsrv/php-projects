<?php
//----------------------------------------------------------------------------//
//------------------------Configuration---------------------------------------//
//----------------------------------------------------------------------------//
$thumbs_prfx        = "_thumbs_"; // thumbnails prefix
$msg                = 5;        // comments per page
$thumb_size         = 160;      // thumbnail size
$pix_size           = 640;      // big picture size
$copyright          = "http://basas.ablomas.com";// text on the picture leave blank if no text
$picsperpage        = 15;       // how many pictures per page
$picsperrow         = 5;        // how many pictures in row
$converter          = "gd1";     //use "im" or "gd" or "gd2"
                                //if "im"  then sript is using Imgage Magick library for convert
                                //if 'gd1' then using GD Library version 1.x
                                //if "gd2" then using GD Library version 2.x
//----------------------------------------------------------------------------//
//------------------------Language--------------------------------------------//
//----------------------------------------------------------------------------//
$lang['next']           ="Next";
$lang['previous']       ="Previous";
$lang["back_to_pixs"]   ="Back to thumbnails";
$lang["title"]          = "Simple Gallery PHP v1.1";
$lang["comments"]       ="comments";
$lang["download"]       ="Download archive";
$lang["name"]           ="Name";
$lang["email"]          ="Email";
$lang["message"]        ="Message";
$lang["submit"]         ="Submit";
$lang["reset"]          ="Clear";
$lang["eror_perm"]      ="can't write, chek folder permisions must be: 777";
//----------------------------------------------------------------------------//
//------------------------------Html------------------------------------------//
//----------------------------------------------------------------------------//
$body='<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
 <title>'.$lang["title"].'</title>
 <meta http-equiv="Content-Type" content="text/html; charset=windows-1257">
 <meta name="Description" content="Simple Gallery">
 <meta name="keywords" content="Simle Gallery, Images, Images Gallery, PHP, PHP Scripts and Programs, PHP Images Gallery, Images Gallery, Images Gallery Script, PHP converting images, PHP convert with GD, PHP convert with Image magick, convert with GD, Image magick converting pictures,">
 <meta NAME="Author" CONTENT="Vytautas Stanaitis">
 <meta name="Copyright" content="2003 &copy; Vytautas Stanaitis">
 <meta http-equiv="imagetoolbar" content="no">
 <style TYPE="text/css">

    A:link { font-family:verdana, arial, sans-serif; font-size:8pt; COLOR: #000000; TEXT-DECORATION: none;	}
    A:visited {font-family:verdana, arial, sans-serif; font-size:8pt; color: #000000; TEXT-DECORATION: none; }
    A:active {font-family:verdana, arial, sans-serif; font-size:8pt; COLOR: #089ACB; TEXT-DECORATION: none; }
    A:hover {font-family:verdana, arial, sans-serif; font-size:8pt; COLOR: #969F79; TEXT-DECORATION: none; }
    body {
            font-family:Verdana,arial, sans-serif; font-size:7pt;
            background: #BCC4AA;
            COLOR: #000000;
            font-size: 12px;
            margin: 1px;
            padding: 0px;
            scrollbar-arrow-color: #000000;
            scrollbar-track-color: #BCC4AA;
            scrollbar-face-color: #BCC4AA;
            scrollbar-highlight-color: #BCC4AA;
            scrollbar-3dlight-color: #000000;
            scrollbar-darkshadow-color: #BCC4AA;
            scrollbar-shadow-color: #000000;
         }
    td
        {
            font-family:Verdana,arial, sans-serif; font-size:7pt;
            border-width:1px;
            border-color: #FFFFFF;
        }

    IMG {
	       border-style: solid;
	       border-width:1;
	       border-color: #000000;
        }
    .table_border
            {
                margin: 10px;
                padding: 5px;
                border: 1px solid #595959;
            }
    .comments_up
            {
	           color:inherit;
	           background-color: #B1B89C;
	           width:100%;
	           margin: 5px;
	           padding: 3px 3px 3px 3px;
	           font-weight:bold;
	           letter-spacing:1px;
            }
    .input_border
            {
               color : #000000;
               background-color : #FFFFFF;
               BORDER-STYLE : groove;
               border-left-width: 1px;
               border-right-width: 1px;
               border-top-width: 1px;
               border-bottom-width: 1px;
               BORDER-color :#595959;
               overflow: auto;
            }
    .button
            {
                background-color:#969F79;
                border: 1px;
                border-color:#595959;
                BORDER-STYLE :groove;
                color : #000000;
                FONT-FAMILY: Verdana, Arial, Sans-serif;
                FONT-SIZE:9px;
            }
 </style>
</head>
<body>';
//------------------------------------------------------------------------------
$header.='
<table class="table_border" width="90%" align="center" border="0" cellpadding="0" cellspacing="0" >
  <tr>
    <td>
<!-- End header -->
';
//------------------------------------------------------------------------------
$footer.='
<!-- Start footer -->
    </td>
  </tr>
</table>
<table align="center" width="90%" cellspacing="0" cellpadding="0" style="border: 1px #595959 solid; margin: 0px;">
    <tr>
        <td style="text-align: left;"><a href="http://basas.ablomas.com/simplegallery/" target="_self"><b>Simple Gallery from Basas v 1.1</b></a></td>
        <td style="text-align: right;"><a href="http://basas.ablomas.com/simplegallery/" target="_self">Download</a></td>
    </tr>
</table>
</body>
</html>';
//----------------------------------------------------------------------------//
//---------------------------Functions----------------------------------------//
//----------------------------------------------------------------------------//
function test_silly_safe_mode()
	{
	$file = "dummy.txt";
	@mkdir(dirname($file), 0777);
	$fd = @fopen($file, 'w');
	if (!$fd) {@rmdir(dirname($file));return true;}
	fclose($fd);
	@unlink($file);
	@rmdir(dirname($file));
	}

function convert ($pixas)
 {
global $thumbs_prfx,$thumb_size,$pix_size,$copyright,$converter;

        $pixas = trim($pixas);
        $size = getimagesize($pixas);
        $pavWidth = $size[0];
        $pavHeight = $size[1];
	    $didesnis = max($pavWidth, $pavHeight);
        $dalyba = $didesnis / $thumb_size;
        $gdydis = max($dalyba, 1.0);
	    $maz_width = (int)($pavWidth / $gdydis);
	    $maz_height = (int)($pavHeight / $gdydis);
        if ($didesnis > $pix_size)
          {
            $aaa= $didesnis/$pix_size;
            $dpixo_aukstis = (int)($pavHeight/$aaa);
            $dpixo_ilgis = (int)($pavWidth/$aaa);
          }
        else {$dpixo_ilgis = $pavWidth; $dpixo_aukstis = $pavHeight; }
        if ($converter=="gd1" || $converter=="gd2" || $converter=="gd")//if gd
                {
                    if ($converter=="gd2")
                        {
                            $spix = imagecreatetruecolor ($maz_width,$maz_height) or die ("Cannot Initialize new GD image stream");
                        }
                    else{
                            $spix = imagecreate ($maz_width,$maz_height) or die ("Cannot Initialize new GD image stream");//this is for gd 1.*
                        }
                    $image = ImageCreateFromJpeg($pixas);
                    imagecopyresized ($spix, $image, 0, 0, 0, 0, $maz_width, $maz_height, $size[0], $size[1]);
                    imagejpeg ($spix,$thumbs_prfx.$pixas,90);
                    @imagedestroy($spix);
                    @imagedestroy($image);

                    if ($converter=="gd2")
                        {
                            $bpix = imagecreatetruecolor ($dpixo_ilgis,$dpixo_aukstis) or die ("Cannot Initialize new GD image stream");
                        }
                    else{
                            $bpix = imagecreate ($dpixo_ilgis,$dpixo_aukstis) or die ("Cannot Initialize new GD image stream");//this is for gd 1.*
                        }
                    $image = ImageCreateFromJpeg($pixas);
                    imagecopyresized ($bpix, $image, 0, 0, 0, 0, $dpixo_ilgis, $dpixo_aukstis, $size[0], $size[1]);
                    $text_color = imagecolorallocate ($bpix, 255,255,255);//white text
                    imagestring ($bpix, 1, 5, 3,  $copyright, $text_color);
                    imagejpeg ($bpix,$pixas,90);
                    @imagedestroy($bpix);
                    @imagedestroy($image);
                    ob_end_clean();
                    $imginfo = getimagesize($thumbs_prfx.$pixas);
                    if ($imginfo == null){return false;}
                    else {return true;}
                }
        else// if image magick
                {
                    exec (" convert -quality 50 -antialias -geometry {$maz_width}x{$maz_height} '$pixas' '$thumbs_prfx"."$pixas'");
                    exec (" convert -quality 70 -antialias -geometry {$dpixo_ilgis}x{$dpixo_aukstis} -font Verdana -fill white  -draw 'text 5,10 $copyright' '$pixas' '$pixas'");//
                    $imginfo = getimagesize($thumbs_prfx.$pixas);
                    if ($imginfo == null){return false;}
                    else {return true;}
                }

}//end function
//----------------------------------------------------------------------------//
//---------------------------Script-------------------------------------------//
//----------------------------------------------------------------------------//
if (test_silly_safe_mode())//cheks dir permisions if not wirtible exits
	{echo $body.$header.'<center>'.$lang["eror_perm"].'</center>'.$footer;exit;}

if (isset($_GET['con']) && $_GET['con']!=='') //for converting
{
    if (convert($_GET['con']))
        {
            $file_name = $thumbs_prfx.$_GET['con'];
            header('Content-type: image/jpeg');
            echo fread(fopen($file_name, 'rb'), filesize($file_name));
        }
    else {
    header ("Content-type: image/png");
	$im = @imagecreate (25, 25) or die ("Cannot Initialize new GD image stream");
	$background_color = imagecolorallocate ($im, 255, 255, 255);
	$text_color = imagecolorallocate ($im, 233, 14, 91);
	imagestring ($im, 1, 1, 5,  "Found", $text_color);
	imagepng ($im);
	// echo $body.$header."Problems".$footer; exit;
	}
exit;
}
//------------------------------------------------------------------------------
$opdir=opendir(".");//file list
while ($file = readdir($opdir))
  {
    ereg( ".*\.([a-zA-z0-9]{0,5})$", $file, $ext );
    preg_match("/\b".$thumbs_prfx."/", $file,$qq);
    if (!$qq && $file != "." && $file != ".." && ($ext[1]== "jpg" ||
		$ext[1]== "JPG" || $ext[1]== "Jpg" || $ext[1] == "jpeg" || $ext[1] == "png"))
    $filelist[$i++] = $file;
  }
if (!$filelist) {  $html=$body.$header."can't find pictures".$footer; echo $html; exit;}
@sort ($filelist);
closedir($opdir);
//------------------------------------------------------------------------------
if ($_POST['submit']) // if posting comment
  {
    if (!$_POST['vardas'] || !$_POST['txt'] || !$_POST['pixas'])// if something is missing do nothing
      {
      header("Location: $PHP_SELF?p=".$_POST['pixas']."&amp;pg=".$_POST['page']."");
      exit;
      }
    else //else write to file
      {
        $txt = stripslashes($txt);
        $txt = str_replace("<","&lt;",$txt);
        $txt = str_replace(">","&gt;",$txt);
        $txt = str_replace("|","&brvbar;",$txt);
        $txt = str_replace("\n","<br>",$txt);
        if (getenv("HTTP_X_FORWARDED_FOR")){$tavo_ip = getenv("HTTP_X_FORWARDED_FOR");}
        else { $tavo_ip = getenv("REMOTE_ADDR");}
        $ex = substr(strrchr($_POST['pixas'],"."),0);
        $pix_txt = substr($_POST['pixas'], 0, strlen($_POST['pixas']) - strlen(strstr($_POST['pixas'],$ex)));//commens will be stored in txt file named like picture name
        $byla=fopen("".$pix_txt.".txt", "a");
        fputs($byla, "".date("YmdHis",time())."|$vardas|$mail|$txt|$tavo_ip|".date("Y-m-d-H:i:s")."|\n");
        fclose($byla);
        header("Location: $PHP_SELF?p=".$_POST['pixas']."&amp;pg=".$_POST['page']."");
      }
  }

//------------------------------------------------------------------------------
if (isset($_GET['setup'])&& $_GET['setup']=='' ) // for converting first time
  {
$html=$body.$header.'
<table style="margin: 10px;padding: 5px;" width="90%" align="center" border="0" cellpadding="0" cellspacing="0" >
  <tr>';
$pixpsl=0;
while (list ($key, $pixas) = each ($filelist))
  {
        if (!file_exists($thumbs_prfx.$pixas))
        {
        $html.= '<td align="center" valign="middle" ><A HREF="'.$PHP_SELF.'?p='.$pixas.'&amp;pg='.$pixpsl.'"><img src="'.$PHP_SELF.'?con='.$pixas.'&amp;r='.uniqid('').'" border="1" alt="show"><br /></a>';
		
	    }
        else
        {
        $html.= '<td align="center" valign="middle" ><A HREF="'.$PHP_SELF."?p=".$pixas.'&amp;pg='.$pixpsl.'">';
        $html.=  '<IMG SRC="'.$thumbs_prfx.$pixas.'" border="1" alt="show"></A>';
        }
        $html.='            </td>';
        $counter++;
        $countpixs++;
        if ($countpixs == $picsperpage) {$countpixs = 0; $pixpsl++;}
        if ($counter == $picsperrow) {$counter = 0; $html.='    </tr><tr>';}
 }
 $html.='
  </tr>
</table>
 ';
$html.=$footer;
echo $html;
exit;
}
//------------------------------------------------------------------------------
if (isset($_GET['p']) && $_GET['p']!=='' && isset($_GET['pg'])) // for big picture viewing
  {
$html=$body.$header;
foreach ( $filelist as $key => $value ) {if ($value==$p){$sek=$key+1;$atg=$key-1;}  } //navigation
$html.='
<table  border="0" cellpadding="0" cellspacing="0" align="center">
  <tr>
    <td align="center" valign="middle">
                <a href="'.$PHP_SELF.'?psl='.$_GET['pg'].'"><img src="'.$_GET['p'].'" border="0" alt="'.$_GET['p'].'"></a><br>
                <a href="'.$PHP_SELF.'?psl='.$_GET['pg'].'">'.$lang["back_to_pixs"].'</A><br>
                <a href="'.$PHP_SELF.'?p='.$filelist[$atg].'&amp;pg='.$_GET['pg'].'">'.$lang["previous"].'</a> |
                <a href="'.$PHP_SELF.'?p='.$filelist[$sek].'&amp;pg='.$_GET['pg'].'">'.$lang["next"].'</a>
    </td>
  </tr>
</table>';
    $p=trim($_GET['p']);
    $ex = substr(strrchr($p,"."),0);
    $pixas = substr($p, 0, strlen($p) - strlen(strstr($p,$ex)));
    $filename = "".$pixas.".txt";
    if (!file_exists($filename) && file_exists($p))//cheking if exists comments file
      {
        touch($filename);
        chmod($filename,0666);
      }
    $byla=file($filename);
    $max = count($byla);
$html.= '
<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" >
  <tr>
    <td>
        <br><center>'.$lang["comments"].': '.$max.'</center>';
    rsort ($byla);
    if(!$_GET['psl']){$_GET['psl']=0;}//navigation
    if($_GET['psl']==0){$html.= '<center>'.$lang["previous"];}
    else{$tmp = $psl -1; $html.= '<center> << <a href="'.$PHP_SELF.'?p='.$pixas.$ex.'&amp;pg='.$_GET['pg'].'&amp;psl='.$tmp.'">'.$lang["previous"].'</a>';}
    $tmp = $psl * $msg + $msg;
    $html.= ' | ';
    if ($max > $tmp){$tmp = $psl +1; $html.= '<a href="'.$PHP_SELF.'?p='.$pixas.$ex.'&amp;pg='.$_GET['pg'].'&amp;psl='.$tmp.'">'.$lang["next"].'</a> >></center>';}
      else {$html.= $lang["next"].'</center>';}
    $startas = $psl * $msg;
    $endaz = $psl * $msg + $msg;;
    if ($endaz > $max){$endaz=$max;}
$html.='   </td>
  </tr>
</table>';
    for ($u=$startas; $u<$endaz; $u++)// show comments
      {
        $infa = explode("|",$byla[$u]);
        $infa[3] = wordwrap( $infa[3], 95, "\n", 1);
        $html.='
<table class="table_border" width="600" border="0" cellpadding="0" cellspacing="0" align="center">
  <tr>
    <td align="left" class="comments_up" >'.$lang["name"].' : ';
                if ($infa[2]!==''){$html.= '<a href="mailto:'.$infa[2].'">'.$infa[1].'</a>';}
                else $html.= $infa[1];
        $html.='
    </td>
  </tr>';
        $html.='
  <tr>
    <td>'.$infa[3].'<br><div align="right">'.$infa[5].'<!-- '.$infa[4].' --></div>
    </td>
  </tr>
</table>';
      }//end for
$html.='
<table class="table_border" width="600" border="0" cellpadding="0" cellspacing="0" align="center">
  <tr>
    <td align="center">
        <form action="'.$PHP_SELF.'" method="post">
        <input type="hidden" name="pixas" value="'.$pixas.$ex.'">
        <input type="hidden" name="page" value="'.$pg.'">
        '.$lang["name"].':&nbsp; <input class="input_border" type="text" name="vardas" maxlength="40"><br>
        '.$lang["email"].':&nbsp; <input class="input_border" type="text" name="mail" maxlength="50"><br>
        '.$lang["message"].': <br>
        <TEXTAREA class="input_border" name="txt" rows="7" cols="50"></TEXTAREA><br>
        <input class="button" type="submit" name="submit" value="'.$lang["submit"].'">&nbsp;&nbsp;<input class="button" type="reset" value="'.$lang["reset"].'"></form>
    </td>
  </tr>
</table>';//post formt
$html.=$footer;
echo $html;
exit;
  }//---end of big picture
//------------------------------------------------------------------------------
// show all pictures
$max = count ($filelist);
if(!$psl){$psl=0;}
if($psl==0)
  {$navig = $lang["previous"];}
else{$tmp = $psl -1; $navig = '<a href="'.$PHP_SELF.'?psl='.$tmp.'"><< '.$lang["previous"].'</a>';}
$tmp = $psl * $picsperpage + $picsperpage;
$navig .= ' | ';
$puslapiu=(int)($max/$picsperpage);
for ($i=0; $i<=$puslapiu;$i++)
  {$kp++;
  $navig .=' -<a href="'.$PHP_SELF.'?psl='.$i.'">'.$kp.'</a>- ';
}
$navig .= ' | ';
if ($max > $tmp){$tmp = $psl +1; $navig .= '<a href="'.$PHP_SELF.'?psl='.$tmp.'">'.$lang["next"].' >></a>';}
else {$navig .= $lang["next"];}
    $startas = $psl * $picsperpage;
    $endaz = $psl * $picsperpage + $picsperpage;;
    if ($endaz > $max){$endaz=$max;}

$html=$body.$header;
$html.='
<table style="margin: 10px;padding: 5px;" width="90%" align="center" border="0" cellpadding="0" cellspacing="0" >
    <tr>';
for ($u=$startas; $u<$endaz;)
  {
        $pixas = $filelist[$u];
        if (!file_exists($thumbs_prfx.$pixas))
        {
        $html.='<td align="center" valign="middle" ><A HREF="'.$PHP_SELF.'?p='.$pixas.'&amp;pg='.$psl.'"><img src="'.$PHP_SELF.'?con='.$pixas.'&amp;r='.uniqid('').'" border="1" alt="show"><br /></a>';
	    }
        else
        {
        $html.= '
        <td align="center" valign="middle" ><A HREF="'.$PHP_SELF."?p=".$pixas.'&amp;pg='.$psl.'">';
        $html.=  '<IMG SRC="'.$thumbs_prfx.$pixas.'" border="1" alt="show"></A>';
    }
        $ex = substr(strrchr($pixas,"."),0);
        $tvard = substr($pixas, 0, strlen($pixas) - strlen(strstr($pixas,$ex)));
        if (file_exists("".$tvard.".txt"))
                {
                $byla=file("".$tvard.".txt");
                $max = count($byla);
                if($max==0)  $html.='';
                else $html.='<br>'.$lang["comments"].': '.$max.'';
                }
        $html.='</td>';
        $counter++;
		$u++;
		if ($u == $endaz) {$counter = 0;
$html.= '
    </tr>';}
    	if ($counter == $picsperrow) {$counter = 0; $html.= '
    </tr>
    <tr>';}


  }
$html.='
    <tr>
        <td  height="10" style="border-top: 1px #595959 solid;" colspan="5" width="100%" align="center" valign="bottom">'.$navig.'</td>
    </tr>
</table>';
$html.= $footer;
echo $html;
?>
