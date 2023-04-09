<?
// mcNews 1.3 Marc Cagninacci marc@phpforums.net
session_start();
if ( !session_is_registered("password") )
{
include "./sess.php";
exit;
}

include ("header.php");
if($voir!='') {
  $skinfile=strstr($skinfile, 'skin');
include("$skinfile");

}

elseif($valid!='')
{
$connect= mysql_connect($host,$login,$pass);
mysql_select_db($base, $connect);
$query = "UPDATE mcnews_design SET skin='$skinfile'";
mysql_query($query, $connect);
?>
   <script language="JavaScript">
   document.location.replace("index.php");
   </script>
<?
}
else {
$connect= mysql_connect($host,$login,$pass);
mysql_select_db($base, $connect);
$query = "SELECT skin FROM mcnews_design";
$row=mysql_fetch_array(mysql_query($query, $connect));
$skinfile=$row['skin'];
include("$skinfile");
}
echo '<div align="right"><font face="verdana" size="3"><b>'.$lDesignParam.'</b></font><br><font size="2"><a href="index.php">'.$lSommaire.'</a></font></div>';

 echo '<form action="design.php" method="post">';
 echo '<font face="verdana" size="1">'.$lChoisir.'</font>&nbsp;<select name="skinfile" size="1">';
$arySkins = array();
$dirCurrent = dir(skin);
while($strFile=$dirCurrent->read()) {
  if (is_file('skin/'.$strFile)) {
    $arySkins[] = 'skin/'.$strFile;
  }
}
$dirCurrent->close();

if (count($arySkins) > 1) { sort ($arySkins); }

$file = current($arySkins);
while ($file) {
  if($file!="skin/blank.php"){
    $intStartSkin = strpos($file, '/') + 1;
    $intLengthSkin = strrpos($file, '.') - $intStartSkin;
    $text=ucwords(substr($file,$intStartSkin,$intLengthSkin));
    echo '<option value="'.$file.'"';
    if($file==$skinfile) echo ' selected';
    echo '>'.$text.'</option>';
  }
  $file = next($arySkins);
}

?>
</select>
<input type="submit" name="voir" value="<? echo $lVoirSkin; ?>">&nbsp;
<input type="submit" name="valid" value="<? echo $lSubmit; ?>">
</form>


<table width="99%" border="0" cellspacing="0" cellpadding="20" bgcolor="<? echo $BodyBgcolor; ?>" align="center">
<tr><td>
 <table width="440" border="0" cellspacing="1" cellpadding="2" bgcolor="<? echo $TableBgcolor; ?>" align="left">
 <tr><td bgcolor="<? echo $TDBgcolorTitre; ?>"><font face="<? echo $FontFace; ?>" color="<? echo $FontColorTitre; ?>" size="<? echo $FontSizeTitre; ?>"><b>2002-03-12&nbsp;&nbsp;Fjygubkrtf gurt lkeitl</b></font>
 </td></tr>
 <tr><td bgcolor="<? echo $TDBgcolorAuteur; ?>"><font face="<? echo $FontFace; ?>" color="<? echo $FontColorAuteur; ?>" size="<? echo $FontSizeAuteur; ?>"><? echo $lAuteur; ?> : <b>Gdvd Kretfcd&nbsp</b>&nbsp;&nbsp;<img src="../images/ecrire.gif" border="0" alt="">&nbsp;<img src="../images/home.gif" border="0" alt=""></font>
 </td></tr>
 <tr><td bgcolor="<? echo $TDBgcolorTexte; ?>"><font face="<? echo $FontFace; ?>" color="<? echo $FontColorTexte; ?>" size="<? echo $FontSizeTexte; ?>"><br>&nbsp;uihtg ts rtfcijrth crthiu rethix srti rstligh rtui dtriu drsti drthi thu srt rdtsiu dtilluthg rtiu dt<br>
 otyoitf rtoiu dctiht rtiu dctiuhg tç fr<br>
 rt ptu ptyu rt(yu drtpu tu c).<br>&nbsp;
 <br><font size="1"><? echo $lLiensRapp; ?> :</font><br>
 <a href="#">http://www.somewhere.com</a>&nbsp;&nbsp;Gtgc cthv h fdh djhh<br>

 </font>
 </td></tr>
 <tr><td bgcolor="<? echo $TDBgcolorAuteur; ?>"><font face="<? echo $FontFace; ?>" color="<? echo $FontColorAuteur; ?>" size="<? echo $FontSizeAuteur; ?>">
 <? echo $lComments; ?> : &nbsp;&nbsp;<a href="#"><? echo $lLire; ?></a>&nbsp;&nbsp;&nbsp;<a href="#"><? echo $lEcrire; ?></a></font>
 </td></tr>



 <tr><td bgcolor="<? echo $TDBgcolorTitre; ?>"><font face="<? echo $FontFace; ?>" color="<? echo $FontColorTitre; ?>" size="<? echo $FontSizeAuteur; ?>">&nbsp;2002-03-15<br></font>
 </td></tr><tr><td bgcolor="<? echo $TDBgcolorAuteur; ?>"><font face="<? echo $FontFace; ?>" color="<? echo $FontColorAuteur; ?>" size="<? echo $FontSizeAuteur; ?>"><? echo $lComment; ?> : <b>Mrc Vcrnekdx</b>&nbsp;&nbsp;&nbsp;<img src="../images/ecrire.gif" border="0" alt="">&nbsp;<img src="../images/home.gif" border="0" alt=""></font>
 </td></tr>
 <tr><td bgcolor="<? echo $TDBgcolorTexte; ?>"><font face="<? echo $FontFace; ?>" color="<? echo $FontColorTexte; ?>" size="<? echo $FontSizeTexte; ?>"><br>&nbsp;uihtg ts rtfcijrth crthiu rethix srti rstligh rtui dtriu drsti drthi thu srt rdtsiu dtilluthg rtiu dt<br>
 kjrdg rdghkdgh lgt dfyjh dfyh fdyh cd jh dfy ryd vdyhvd ycvh dthcdh kydtr cfj<br>
 rt ptu ptyu rt(yu drtpu tu c).<br>&nbsp;
 <br><font size="1"><? echo $lLiensRapp; ?> :</font><br>
 <a href="#">http://www.mysite.com</a>&nbsp;&nbsp;Grctu tgu rt<br>

  </font>
 </td></tr>
 </table>

</td>

<td valign="top">
   <form action="">
   <table bgcolor="<? echo $TableBgcolor; ?>" border="0" cellspacing="1">
   <tr><td align="center" colspan="2" bgcolor="<? echo $TDBgcolorTitre; ?>"><font face="<? echo $FontFace; ?>" color="<? echo $FontColorTitre; ?>" size="<? echo $FontSizeTitre; ?>"><b><? echo $lPropo; ?></b></font>
   </td></tr>
   <tr><td bgcolor="<? echo $TDBgcolorTexte; ?>"><font face="<? echo $FontFace; ?>" color="<? echo $FontColorTexte; ?>" size="<? echo $FontSizeTexte; ?>"><? echo $lLogin; ?> :</font>
   </td>
   <td bgcolor="<? echo $TDBgcolorTexte; ?>"><input type="text" name="t" size="20" value=" ">
   </td></tr>
   <tr><td bgcolor="<? echo $TDBgcolorTexte; ?>"><font face="<? echo $FontFace; ?>" color="<? echo $FontColorTexte; ?>" size="<? echo $FontSizeTexte; ?>"><? echo $lEmail; ?> :</font>
   </td>
   <td bgcolor="<? echo $TDBgcolorTexte; ?>"><input type="text" name="r" size="20" value=" ">
   </td></tr>
   <tr><td bgcolor="<? echo $TDBgcolorTexte; ?>"><font face="<? echo $FontFace; ?>" color="<? echo $FontColorTexte; ?>" size="<? echo $FontSizeTexte; ?>"><? echo $lTexte; ?> :</font>
   </td>
   <td bgcolor="<? echo $TDBgcolorTexte; ?>"><textarea cols="20" rows="5"> </textarea>
   </td></tr>
   <tr><td bgcolor="<? echo $TDBgcolorTexte; ?>"><font face="<? echo $FontFace; ?>" color="<? echo $FontColorTexte; ?>" size="<? echo $FontSizeTexte; ?>">&nbsp;</font>
   </td>
   <td bgcolor="<? echo $TDBgcolorTexte; ?>"><input type="submit" value="<?echo $lSubmit; ?>">
   </td></tr>
   </table>
   </form>
</td></tr>
</table>

<?
include ("footer.php");
?>
