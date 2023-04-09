<?
$not_include_header=true;
include("../config_file.php");?>
<html><head><title>Select Banner Image</title><link rel="stylesheet" href="css.css"></head><body>
<table align="center" width="100%" border="0" cellspacing="2" cellpadding="4" bgcolor="#339999">
<?
$dirs = getFiles(DIR_BANNERS);
for ($i=0; $i<count($dirs); $i++) {
           echo "<form method=\"post\" action=\"admin_select_iamge\">";
           $imgsize = getimagesize(DIR_BANNERS."/".$dirs[$i]);
           $imgmodtime = filemtime (DIR_BANNERS."/".$dirs[$i]);
           $lastmodtime = date("d.m.Y - H:i:s", $imgmodtime);
           echo "<tr>";
                echo "<td width=\"50%\" bgcolor=\"#FFFFFF\" valign=\"middle\" align=\"center\">".bx_image(HTTP_BANNERS."/".$dirs[$i],0,'')."</td>";
                echo "<td bgcolor=\"#C5C7E0\"><font face=\"Verdana\" size=\"1\" color=\"#000000\">Name: <b>".$dirs[$i]."</b></font>";
                echo "<br><font face=\"Verdana\" size=\"1\" color=\"#000000\">Size: ".$imgsize[0]."x".$imgsize[1]."</font>";
                echo "<br><font face=\"Verdana\" size=\"1\" color=\"#000000\">Modified: ".$lastmodtime."</font>";
				echo "<br><br><input type=\"button\" class=\"button\" name=\"select_image\" value=\"Insert Banner Image Code\" style=\"width: 140px; font-size: 9px;\" onClick=\"opener.addImgCode('".HTTP_BANNERS.$dirs[$i]."');window.close();\">";
                echo "</td>";

           echo "</tr>";
}
?>
</table>
</body></html>