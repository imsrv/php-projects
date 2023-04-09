<?php
require("./PicSql.inc.php");
$db = new PicSQL($DBName);
include("./usercheck.php");

$PicturePath = "../photo/";

if (empty($page)){
$page = 0;
}
$record = 20;

if ($Delpic==$admin_yes) {
$db->delpic($picid,$PicturePath);
}

if (!empty($addpic)) {
$picid = $db->addpic($title,$catalogid,$isdisplay);
   if ((!empty($userfile)) && (!empty($userfile_name))) {
   $prefix = time();
   $userfile_name = $prefix.$userfile_name;
   $dest1 = $PicturePath.$userfile_name;
   copy($userfile, $dest1);
   $db->add_Picture($picid,$userfile_name,$PicturePath);
   }
}

if (!empty($editpic)) {
   if ((!empty($userfile)) && (!empty($userfile_name))) {   
   $prefix = time();
   $userfile_name = $prefix.$userfile_name;
   $dest1 = $PicturePath.$userfile_name;
   copy($userfile, $dest1);
   $db->add_Picture($picid,$userfile_name,$PicturePath);
   }
$db->editpic($title,$catalogid,$isdisplay,$picid);
   
}

if (!empty($DP1)) {
   $db->del_Picture($picid,$PicturePath);
}

$result = $db->getallpics($page,$record);
?>
<html>
<head>
<title><?php print "$admin_picturesadmin"; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=<?php print "$admin_charset"; ?>">
<link rel="stylesheet" href="style/style.css" type="text/css">
</head>

<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0">
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
              <tr bgcolor="#CCCCCC"> 
                <td>&nbsp;</td>
                <td><?php print "$admin_title"; ?></td>
                <td><?php print "$admin_catalog"; ?></td>                
                <td colspan="2"><?php print "$admin_opreation"; ?></td>
              </tr>
              <?php
              if (!empty($result)) {
	        while ( list($key,$val)=each($result) ) {
	        $picid = stripslashes($val["picid"]);
	        $catalogid = stripslashes($val["catalogid"]);
	        $title = stripslashes($val["title"]);	        
	        $cataname = $db->getcatalognamebyid($catalogid);
              ?>
              <tr bgcolor="#FFFFFF">
              <td><?php print "$picid"; ?></td>
                <td><?php print "$title"; ?></td>
                <td><?php print "$cataname"; ?></td>                
                <td><a href="editpic.php?picid=<?php print "$picid"; ?>" class="en_b"><?php print "$admin_edit"; ?></a></td>
                <td><a href="delpic.php?picid=<?php print "$picid"; ?>" class="en_b"><?php print "$admin_del"; ?></a></td>                              
              </tr>
              <?php
              }
              }
              ?>                       
            <tr bgcolor="#FFFFFF">
            <td align="right" colspan="5">
            <?php
              $pagenext = $page+1;
		$result1 = $db->getallpics($pagenext,$record);
		if ($page!=0)
		{
		$pagepre = $page-1;		
		print "<a href=\"$PHP_SELF?page=$pagepre\"><font color=\"#FF0000\">$admin_previouspage</font></a>&nbsp;&nbsp;&nbsp;";
		}
		if (!empty($result1))
		{
		print "<a href=\"$PHP_SELF?page=$pagenext\"><font color=\"#FF0000\">$admin_nextpage</font></a>&nbsp;";
		}
		?>
            </td>
            </tr>
            </table>            
            </td>
        </tr>    
        <tr>
        <td align="center">
        <form action="<?php print "$PHP_SELF"; ?>" method="POST" ENCTYPE="multipart/form-data">                
        <table width="300" border="0" cellspacing="1" cellpadding="4" bgcolor="#F2F2F2">
             <tr bgcolor="#FFFFFF"> 
                <td width="83"><?php print "$admin_title"; ?> :</td>
                <td width="198"><input type="text" name="title"></td>
              </tr>              
              <tr bgcolor="#FFFFFF"> 
                <td><?php print "$admin_catalog"; ?> :</td>
                <td>
                <select name="catalogid">
                <?php
                $nameinfo = $db->getallcatalogname(); 
                if (!empty($nameinfo)){
	            while (list($key,$val)=each($nameinfo)) {
		    $catalogid = stripslashes($val["catalogid"]);
		    $catalogname = stripslashes($val["catalogname"]);
		    print "<option value=\"$catalogid\">$catalogname</option>";
		 }
		}
                ?>
                </select>
                </td>
              </tr>
              <tr bgcolor="#FFFFFF"> 
                <td><?php print "$admin_picture"; ?> :</td>
                <td><input type="file" name="userfile"></td>
              </tr>              
              <tr bgcolor="#FFFFFF"> 
                <td><?php print "$admin_isdisplay"; ?> :</td>
                <td>
                <select name="isdisplay">
                <option value="1" selected><?php print "$admin_yes"; ?></option>
                <option value="0"><?php print "$admin_no"; ?></option>
                </select>
                </td>
              </tr>
              <tr bgcolor="#FFFFFF"> 
                <td>&nbsp;</td>
                <td><input type="submit" name="addpic" value="<?php print "$admin_add"; ?>"></td>
              </tr>
        </table>
        <p><a href="admin_index.php"><?php print "$admin_back"; ?></a>
            </p>
        </form>
        </td>
        </tr>    
      </table>
      
    </td>
</tr>
<tr>
    <td align="center" valign="top" height="40">&nbsp;</td>
  </tr>
</table>
<?php
include("bottom.php3");
?>
</body>
</html>
