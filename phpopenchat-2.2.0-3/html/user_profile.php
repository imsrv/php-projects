<?//-*- C -*-
/*   ********************************************************************   **
**   Copyright (C) 1995-2000 Michael Oertel                                 **
**   Copyright (C) 2000-     PHPOpenChat Development Team                   **
**   http://www.ortelius.de/phpopenchat/                                    **
**                                                                          **
**   This program is free software. You can redistribute it and/or modify   **
**   it under the terms of the PHPOpenChat License Version 1.0              **
**                                                                          **
**   This program is distributed in the hope that it will be useful,        **
**   but WITHOUT ANY WARRANTY, without even the implied warranty of         **
**   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.                   **
**                                                                          **
**   You should have received a copy of the PHPOpenChat License             **
**   along with this program.                                               **
**   ********************************************************************   */

include("defaults_inc.php");

/*
 * Open a database connection
 * The following include returns a database handle
 */
include ("connect_db_inc.php");
$db_handle=connect_db($DATABASEHOST,$DATABASEUSER,$DATABASEPASSWD);
if(!$db_handle){
  exit;//the error message is printed in connect_db_inc.php
}

if(!$pruef){
  $Passwort2=$Passwort;
}else{
  //Check for access permissions of this page
  if($nick && !check_permissions($nick,$pruef)){
    //the user has no access permission for this page
    header("Status: 204");//browser don't refresh his content
    mysql_close($db_handle);
    exit;
  }
}

Function login (){
  global $nick,$FILE_EXTENSION,$INSTALL_DIR,$NICK_NAME,$PASSWORD,$USERPROFILE;
  echo '
<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML//EN">
<html>
<head>
<title>'.$USERPROFILE.'</title>
</head>

<body BACKGROUND="'.$BG_IMAGE.'" bgcolor="#FFFFFF">
<DIV ALIGN="CENTER">
 <!-- start table -->
<table cellSpacing="0" cellPadding="1" border="0">
<tr>
<td width="100%" bgColor=#468e31>
<table cellSpacing="0" cellPadding="4" border="0">
<tr>
<td background="images/bg.gif" align="center">
<font size="+1">
<b>'.$USERPROFILE.'</b>
</font>
</td>
</tr>
<tr>
<td bgColor="#ffffff" align="center">
<img src="images/leer.gif" alt="" width="480" height="1" border="0"><br>

<P align="center">
<FORM ACTION="'.$INSTALL_DIR.'/user_profile.'.$FILE_EXTENSION.'" METHOD="POST">
 <TABLE boder=0 align="center">
  <TR>
    <TD ALIGN=RIGHT>'.$NICK_NAME.':</TD>
    <TD><INPUT NAME="Nick" TYPE="text" VALUE="'.$nick.'"></TD>
  </TR>
    <TD ALIGN=RIGHT>'.$PASSWORD.':</TD>
    <TD><INPUT NAME="Passwort" TYPE="password" VALUE=""></TD>
  </TR>
 </TABLE>
</P>
<P>
 <INPUT TYPE="submit" VALUE="login!">
</P>
<H4 align="center">
 <A HREF="'.$INSTALL_DIR.'/">back</A>
</H4>
</FORM>
 </td>
</tr>
</table>
</td>
</tr>
</table>
<!-- end table -->
</DIV>
</BODY>
</HTML>
  ';
  exit;
}
function print_file($file,$type,$mode){
  
  if($file){
    if(ereg("image", $type)){
      $site_img = '<img src="' . $file . '" border="0" ';
    }else{
      $userfile = fopen($file, "r");
      while(!feof($userfile)) {
	$line = fgets($userfile, 255);
	switch($mode){
	case 1:
	  $site .= $line;
	  break;
	case 2:
	  $site .= nl2br(ereg_replace("\t", "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;", htmlentities($line)));
	  break;
	}	
      }
    }
  }
}

function UploadImage(){
  global $SEND_IMG,$CHOOSE_IMG,$ENABLE_SESSION,$SCRIPT_NAME,$Nick,$pruef;
  echo '<table><tr valign="middle"><td>
	<form enctype="multipart/form-data" action="'.$SCRIPT_NAME.'" method="post">
        <input type="hidden" name="img" value="">';
  if(!$ENABLE_SESSION){
    global $nick,$pruef;
    echo '<input type="hidden" name="nick"  value="$nick">
          <input type="hidden" name="pruef" value="$pruef">';
    
  }
  echo '
        <INPUT TYPE="hidden" NAME="Nick" VALUE="'.$Nick.'">
        <INPUT TYPE="hidden" NAME="pruef" VALUE="'.$pruef.'">


	<b>'.$CHOOSE_IMG.'</b>: <input name="incom_img" type="file">&nbsp;&nbsp;&nbsp;&nbsp;
	<input type="hidden" name="op" value="PreviewUpload" >
	<INPUT type="submit" value="'.$SEND_IMG.'">
	</form></td></tr></table>';
}

function PreviewUpload($img,$incom_img){
  global $nick;
  
  $PATH = "images/chatter/";

  if($incom_img != "none"){	
    require("fileupload_class.php");
    
    $FILENAME = "incom_img";
    //$ACCEPT = "image/gif,image/jpeg";
    $ACCEPT = "image/gif";
    $EXTENSION = "";
    $SAVE_MODE = 1;
    
    $upload = new uploader;
    global $USERIMG_MAX_BYTES,$USERIMG_IMGSIZE_X,$USERIMG_IMGSIZE_Y;
    $upload->max_filesize($USERIMG_MAX_BYTES);
    $upload->max_image_size($USERIMG_IMGSIZE_X,$USERIMG_IMGSIZE_Y);
    $upload->save_name(strtolower(str_replace(' ','_',$nick)));
    
  }else{
    $image_name = $img;
  }

  $site = '';
  if ($incom_img != "none") {
    $file_accepted = $upload->upload("$FILENAME", "$ACCEPT", "$EXTENSION");
    if($file_accepted) {
      if($upload->save_file("$PATH", $SAVE_MODE)) {
	print_file($upload->new_file, $upload->file["type"], 2);
	$image_name = $upload->file["name"];
	//$site .= "new file: <img src='$PATH$image_name' border=0>";
	global $NEW_IMG_HINT;
	$site .= $NEW_IMG_HINT;
      }
    }elseif($file_accepted==-1){
      
    }elseif($file_accepted==-2){
      
    }
  } elseif ($img != "") {
    $site .= "<img src='$PATH$img' border=0>";
  } 
  
  /* if errors on upload - start */
  if($upload->errors){
    global $MAX_FILE_EXCEEDED,$MAX_SIZE_EXCEEDED,$HINT_IMG_SIZE,$USERIMG_IMGSIZE_X,$USERIMG_IMGSIZE_Y,$ALLOWED,$MIME_ERROR;
    while(list($key, $var) = each($upload->errors)){
      $var = str_replace('[FS_ERROR]',$MAX_SIZE_EXCEEDED.' ('.$ALLOWED.': '.$USERIMG_IMGSIZE_X.'x'.$USERIMG_IMGSIZE_Y.') '.$HINT_IMG_SIZE.' ',$var);
      $var = str_replace('[KB_ERROR]',$MAX_FILE_EXCEEDED.' ',$var);
      $var = str_replace('[MIME_ERROR]',$MIME_ERROR.' ',$var);
      $site .= "<font color=red><p>" . $var . "<br></font>";
    }
  }
  if($NEW_NAME){
    $site .= "<p>Name of image save: <b>$NEW_NAME</b></p>";
  }
  /* if errors on upload - end */
  
  $site .= "$site_img<br><br>";
  echo $site;
  
  UploadImage();
}

if(!$Nick && !$nick){
  login();
}else{
  if(!$Nick){$Nick=$nick;}
  $result=mysql_query("SELECT * FROM chat_data WHERE Nick='$Nick'",$db_handle);
  if(mysql_num_rows($result)<1){
    login();
    exit;
  }
  $passwort_db=mysql_result($result,0,"Passwort");
  if($passwort_db==$SPERRPASSWORT){
         echo '
         <!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML//EN">
         <html>
         <head>
      <title>'.$USERPROFILE.'</title>
         </head>

      <body BACKGROUND="'.$BG_IMAGE.'" bgcolor="#FFFFFF">
         <DIV ALIGN="CENTER">
   <h1>'.$USERPROFILE.'</h1>
         ';
    echo $BANNED_MSG,"</BODY></HTML>";
    exit;
  }
  if(($passwort_db!=$Passwort)&&(!$pruef)){
    login();
  }else{
    $pruef=Crypt($Nick,$salt_nick);
    $nick = $Nick;
    if($$ENABLE_SESSION){
		session_register('pruef','nick');
	}
   echo '
         <!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML//EN">
         <html>
         <head>
      <title>'.$USERPROFILE.'</title>
         </head>

      <body BACKGROUND="'.$BG_IMAGE.'" bgcolor="#FFFFFF">
         <DIV ALIGN="CENTER">
   <h1>'.$USERPROFILE.'</h1>
         ';

    $feldnamen=mysql_list_fields($DATABASENAME,"chat_data");
    $i=0;$num=mysql_Num_Fields($feldnamen);
    echo "\n<TABLE BORDER=0 width=100%><FORM ACTION=\"$INSTALL_DIR/user_profile.$FILE_EXTENSION\" METHOD=\"POST\">\n";
    while($i<$num){
      echo "<TR><TD BGCOLOR=#DDDDDD>";
      $feldname=mysql_Field_Name($result,$i);
      $feldinhalt=mysql_result($result,0,$feldname);
      if($pruef && $eintragen && ($feldname=="Email" || $feldname=="PictureURL")){
	$update=mysql_query("UPDATE chat_data SET $feldname='${$feldname}' WHERE Nick='$Nick'",$db_handle);
      }
      if($feldname=="PictureURL" || $feldname=="Email"){
	echo "$feldname: <TD><INPUT NAME=\"$feldname\" TYPE=\"text\" VALUE=\"";
	if($pruef){
	  if(${$feldname}){
	    echo ${$feldname};
	  }else{
	    echo $feldinhalt;
	  }
	}else{
	  echo $feldinhalt;
	}
	echo "\" SIZE=\"50\"><BR>\n";
      }
      if($feldname=="Nick"){echo "$feldname: <TH BGCOLOR=#DDDDDD>$feldinhalt\n";}
      if($feldname=="Passwort"){
	if($Passwort && ($Passwort==$Passwort2)){
	  $update=mysql_query("UPDATE chat_data SET Passwort='$Passwort' WHERE Nick='$Nick'",$db_handle);
	}elseif($eintragen){
	  echo "<FONT COLOR=#FF0000>$FEHLER:</FONT> $PWD_DONT_MATCH<BR>";
	}elseif($eintragen && !$Passwort){
	  echo "<FONT COLOR=#FF0000>$FEHLER:</FONT> $NO_EMPTY_PWD<BR>";
	}
	echo $TBL_FIELDS["PASSWORD"].": <TD><INPUT NAME=\"$feldname\" TYPE=\"password\" VALUE=\"";
	if($pruef){
	  if(${$feldname}){
	    echo ${$feldname};
	  }else{
	    echo $feldinhalt;
	  }
	}else{
	  echo $feldinhalt;
	}
	echo "\" MAXLENGTH=\"8\" SIZE=\"8\"><BR>\n<TR><TD BGCOLOR=#DDDDDD>$PWD_REPEATE: <TD><INPUT NAME=\"Passwort2\" TYPE=\"password\" VALUE=\"";
	if($Passwort2){echo $Passwort2;}else{echo $feldinhalt;}
	echo "\" MAXLENGTH=\"8\" SIZE=\"8\">\n";
      }
      $i++;
    }
    echo "<TR><TD BGCOLOR=#DDDDDD>$USER_ICON:</TD><TD>";
    $smileydir="images/chatter/";
    if(file_exists($smileydir.strtolower(str_replace(" ","_",$nick)).".gif")){
      echo '<IMG WIDTH=16 HIGHT=16 SRC="'.$smileydir.urlencode(strtolower(str_replace(" ","_",$nick))).'.gif">';
    }else{
      echo '<IMG WIDTH=16 HIGHT=1 SRC="images/dot_clear.gif">';
    }
    echo "</TD></TR>";

    echo "<TR><TD><FONT COLOR=#FF0000 SIZE=+2>$HINT:</FONT> $URL_FORMAT_HINT<TD>";
    echo "<INPUT TYPE=\"submit\" NAME=\"eintragen\" VALUE=\"OK\">";
    echo "</TABLE><INPUT TYPE=\"hidden\" NAME=\"Nick\" VALUE=\"$Nick\">";
    echo "<INPUT TYPE=\"hidden\" NAME=\"pruef\" VALUE=\"";
    echo $pruef;
    echo "\">";
    echo "</FORM></DIV>\n";
    
    //user pic upload
    $result=mysql_query("SELECT Nick,Online FROM chat_data ORDER by Online desc LIMIT 0,30",$db_handle);
    while($row=mysql_fetch_array($result)){
      if($row[Nick]==$nick){
        switch($op){
          case "PreviewUpload":
            PreviewUpload($img, $incom_img);
            break;
          default:
            UploadImage();
            break;   
        }
      }
    }
  }
}
mysql_close($db_handle);
?>
<A HREF="<?echo$INSTALL_DIR?>/"><H3>back</H3></A>
<HR>
</body>
</html>
