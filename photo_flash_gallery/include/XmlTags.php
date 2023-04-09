<?
function imageTagDir($idImg, $url, $urlBig){
	$tag = '<image idImg="'.$idImg.'" url="'.$url.'" urlBig="'.$urlBig.'"/>';
	return $tag."\n";
}
function imageTag($idImg, $imgFileName, $cat, $subcat, $isDirImage = 0){
	$url = $cat.'/'.(!$isDirImage?($subcat.'/'):'');
	$tag = '<image idImg="'.$idImg.'" url="'.($url.'th_'.$imgFileName).'" urlBig="'.($url.$imgFileName).'"/>';
	return $tag."\n";
}
function subCatTag($idSubcat, $subcat, $count, $isDirImage){
	$tag = '<subCategory name="'.$subcat.'" count="'.$count.'" idSubcategory="'.$idSubcat.'" directImg="'.$isDirImage.'">';
	return $tag."\n";
}
function subCatShortTag($idSubcat){
	$tag = '<subcat idSubcategory="'.$idSubcat.'">';
	return $tag."\n";
}
function subCatTagEnd($idSubcat, $subcat, $count, $isDirImage){
	$tag = '<subCategory name="'.$subcat.'" count="'.$count.'" idSubcategory="'.$idSubcat.'" directImg="'.$isDirImage.'" />';
	return $tag."\n";
}
function catTag($cat, $count){
	$tag = '<category name="'.$cat.'" count="'.$count.'">';
	return $tag."\n";
}
function subCatEndTag(){
	return "</subCategory>\n";
}
function subCatEndShortTag(){
	return "</subcat>\n";
}
function catEndTag(){
	return "</category>\n";
}
function imageDetailTag($idImg, $idSubcategory, $url, $urlBig, $name, $desc, $width, $height, $date, $kb, $isDirImage){
	$tag = '<image idImg="'.$idImg.'" url="'.$url.'" urlBig="'.$urlBig.'" name="'.$name.'" desc="'.$desc.'" width="'.$width.'" height="'.$height.'" date="'.$date.'" kb="'.$kb.'" idSubcategory="'.$idSubcategory.'" directImg="'.$isDirImage.'"/>';
	return $tag."\n";
}
function imageDetailTagAll($idImg, $idSubcategory, $url, $urlBig, $name, $desc, $width, $height, $date, $kb, $isDirImage){
	$tag = '<image idImg="'.$idImg.'" url="'.$url.'" urlBig="'.$urlBig.'" name="'.$name.'" desc="'.$desc.'" width="'.$width.'" height="'.$height.'" date="'.$date.'" kb="'.$kb.'" idSubcategory="'.$idSubcategory.'" directImg="'.$isDirImage.'"/>';
	return $tag."\n";
}
function imagesAllCount($count){
	$tag = '<images count="'.$count.'">';
	return $tag."\n";
}
function endImagesAllCount(){
	$tag = '</images>';
	return $tag."\n";
}

function getInfo($file){
	$ar = array(0,0,0);
	if (is_file($file)){
		$ar = getimagesize($file);
		return($ar);
	}
}
function convert_from_bytes( $bytes, $to=NULL )
{
  $float = floatval( $bytes );
  switch( $to )
  {
    case 'Kb' :
      $float = ( $float*8 ) / 1024;
      break;
    case 'b' :
      $float *= 8;
      break;
    case 'GB' :
      $float /= 1024;
    case 'MB' :
      $float /= 1024;
    case 'KB' :
      $float /= 1024;
    default :
  }
  unset( $bytes, $to );
  return( $float );
}
function extensionMatch($str){
	$exts = array("jpeg","jpg","gif","jpe","png");
	return (in_array(strtolower(substr($str,1+strrpos($str,"."))),$exts) && substr($str,0,3)!="th_");
}
function display_perms( $mode )
  {
  echo $mode;
 /* Determine Type */
 if(($mode & 0xC000) === 0xC000)       // Unix domain socket
   $type = 's';
 elseif(($mode & 0x4000) === 0x4000)   // Directory
   $type = 'd';
 elseif(($mode & 0xA000) === 0xA000)   // Symbolic link
   $type = 'l';
 elseif(($mode & 0x8000) === 0x8000)   // Regular file
   $type = '-';
 elseif(($mode & 0x6000) === 0x6000)   // Block special file
   $type = 'b';
 elseif(($mode & 0x2000) === 0x2000)   // Character special file
   $type = 'c';
 elseif(($mode & 0x1000) === 0x1000)   // Named pipe
   $type = 'p';
 else                                  // Unknown
   $type = '?';

     /* Determine permissions */
     $owner["read"]    = ($mode & 00400) ? 'r' : '-';
     $owner["write"]   = ($mode & 00200) ? 'w' : '-';
     $owner["execute"] = ($mode & 00100) ? 'x' : '-';
     $group["read"]    = ($mode & 00040) ? 'r' : '-';
     $group["write"]   = ($mode & 00020) ? 'w' : '-';
     $group["execute"] = ($mode & 00010) ? 'x' : '-';
     $world["read"]    = ($mode & 00004) ? 'r' : '-';
     $world["write"]   = ($mode & 00002) ? 'w' : '-';
     $world["execute"] = ($mode & 00001) ? 'x' : '-';
     /* Adjust for SUID, SGID and sticky bit */
     if( $mode & 0x800 )
        $owner["execute"] = ($owner[execute]=='x') ? 's' : 'S';
     if( $mode & 0x400 )
        $group["execute"] = ($group[execute]=='x') ? 's' : 'S';
     if( $mode & 0x200 )
        $world["execute"] = ($world[execute]=='x') ? 't' : 'T';
     printf("%1s", $type);
     printf("%1s%1s%1s", $owner[read], $owner[write], $owner[execute]);
     printf("%1s%1s%1s", $group[read], $group[write], $group[execute]);
     printf("%1s%1s%1s\n", $world[read], $world[write], $world[execute]);
  }
?>