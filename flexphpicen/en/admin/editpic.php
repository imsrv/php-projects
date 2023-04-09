<?php
require("./PicSql.inc.php");
$db = new PicSQL($DBName);
include("./usercheck.php");
$PicturePath = "../photo/";
$result = $db->getpicbyid($picid);
$catalogid = $result[0]["catalogid"];
$title = $result[0]["title"];
$picture = $result[0]["picture"];
$isdisplay = $result[0]["isdisplay"];
?>
<html>
<head>
<title><?php print "$admin_picturesadmin"; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=<?php print "$admin_charset"; ?>">
<link rel="stylesheet" href="style/style.css" type="text/css">
</head>
<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0">
<form action="picsadmin.php" method="POST" ENCTYPE="multipart/form-data">
<input type="hidden" name="picid" value="<?php print "$picid"; ?>">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr> 
    <td align="center" valign="top"> 
      <?php
      include("top.php3");
      ?>
      <hr width="90%" size="1" noshade>
      <table width="90%" border="0" cellspacing="0" cellpadding="4" height="300">
        <tr> 
          <td align="center"> 
            <table width="400" border="0" cellspacing="1" cellpadding="4" bgcolor="#F2F2F2">
              <tr bgcolor="#FFFFFF"> 
                <td width="183"><?php print "$admin_title"; ?> :</td>
                <td width="198"><input type="text" name="title" value="<? print "$title"; ?>"></td>
              </tr>                           
              <tr bgcolor="#FFFFFF"> 
                <td><?php print "$admin_catalog"; ?> :</td>
                <td>
                <select name="catalogid">
                <?php
                $nameinfo = $db->getallcatalogname(); 
                if (!empty($nameinfo)){
	            while (list($key,$val)=each($nameinfo)) {
		    $tempcatalogid = stripslashes($val["catalogid"]);
		    $catalogname = stripslashes($val["catalogname"]);
		    if ($catalogid==$tempcatalogid){
		    print "<option value=\"$tempcatalogid\" selected>$catalogname</option>";
		    }else{
		    print "<option value=\"$tempcatalogid\">$catalogname</option>";
		    }
		 }
		}
                ?>
                </select>
                </td>
              </tr>                             
              <tr bgcolor="#FFFFFF"> 
                <td>
                <?php print "$admin_picture"; ?> :
                <?php
                if (!empty($picture)){
                ?>
                <br><input type="submit" name="DP1" value="<?php print "$admin_del"; ?>">
                <?php
                }
                ?>
                </td>
                <td>
                <?php
                if (!empty($picture)){
                ?>
                <img src="<?php print "$PicturePath$picture"; ?>"><br>
                <?php
                }
                ?>
                <input type="file" name="userfile">
                </td>
              </tr>              
              <tr bgcolor="#FFFFFF"> 
                <td><?php print "$admin_isdisplay"; ?> :</td>
                <td>
                <select name="isdisplay">
                <?php
                switch($isdisplay){
                
                case "1":
                ?>
                <option value="1" selected><?php print "$admin_yes"; ?></option>
                <option value="0"><?php print "$admin_no"; ?></option>                
                <?php
                break;
                
                case "0":
                ?>
                <option value="1"><?php print "$admin_yes"; ?></option>
                <option value="0" selected><?php print "$admin_no"; ?></option>
                <?php
                break;                
                }
                ?>
                </select>
                </td>
              </tr>                      
            </table> 
            <p>
            <input type="submit" name="editpic" value="<?php print "$admin_ok"; ?>">             
            </p>                      
          </td>
        </tr>
      </table>
      
    </td>
</tr>
<tr>
    <td align="center" valign="top" height="40">&nbsp;</td>
  </tr>
</table>
</form>
<?php
include("bottom.php3");
?>
</body>
</html>