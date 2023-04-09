<?php
if($tolog=='jobseeker')
{
   ?>
   <form action="<?php echo bx_make_url(HTTP_SERVER.FILENAME_LOGIN_PROCESS."?login=jobseeker", "auth_sess", $bx_session);?>" method="post">
   <?php
    $http_jobseeker=$HTTP_GET_VARS;
    while (list($header, $value) = each($http_jobseeker)) {
         echo "<input type=\"hidden\" name=\"".$header."\" value=\"".$value."\">";
     }//end while (list($header, $value) = each($HTTP_POS
   ?>
   <table border="0" width="100%" bgcolor="<?php echo LEFT_NAV_BG_COLOR;?>" cellspacing="2" cellpadding="0">
   <tr bgcolor="<?php echo TABLE_JOBSEEKER;?>">
         <td><?php echo bx_image_width(HTTP_IMAGES.$language."/pix-t.gif",1,1,0,"");?></td>
   </tr>
   <tr>
         <td align="center"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><SMALL><?php echo TEXT_USER_NAME;?></SMALL></B><br><input type="text" name="users_seek" size="13" style="width: 130px"></font></td>
   </tr>
   <tr>
          <td align="center"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><SMALL><?php echo TEXT_PASSWORD;?></SMALL></B><br><input type="password" name="passw_seek" size="13" style="width: 130px"></font></td>
   </tr>
   <tr>
          <td align="center"><?php echo bx_image_submit_nowidth(HTTP_IMAGES.$language."/login.gif",0,TEXT_LOGIN);?></td>
   </tr>
   <tr>
          <td align="right" width="100%"><a href="<?php echo bx_make_url(HTTP_SERVER.FILENAME_FORGOT_PASSWORDS."?jobseeker=true", "auth_sess", $bx_session);?>"><?php echo TEXT_FORGOT_PASSWORD;?></a></td>
   </tr>
   <tr bgcolor="<?php echo TABLE_JOBSEEKER;?>">
         <td><?php echo bx_image_width(HTTP_IMAGES.$language."/pix-t.gif",1,1,0,"");?></td>
   </tr>
   </table>
   </form>
<?php
}
if($tolog=='employer')
{
 ?>
  <form action="<?php echo bx_make_url(HTTP_SERVER.FILENAME_LOGIN_PROCESS."?login=employer", "auth_sess", $bx_session);?>" method="post">
   <?php
    $http_employer=$HTTP_GET_VARS;
    while (list($header, $value) = each($http_employer)) {
         echo "<input type=\"hidden\" name=\"".$header."\" value=\"".$value."\">";
     }//end while (list($header, $value) = each($HTTP_POS
   ?>
   <table border="0" width="100%" bgcolor="<?php echo LEFT_NAV_BG_COLOR;?>" cellspacing="2" cellpadding="0">
   <tr bgcolor="<?php echo TABLE_EMPLOYER;?>">
         <td><?php echo bx_image_width(HTTP_IMAGES.$language."/pix-t.gif",1,1,0,"");?></td>
   </tr>
   <tr>
         <td align="center"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><SMALL><?php echo TEXT_USER_NAME;?></SMALL></B><br><input type="text" name="users_empl" size="13" style="width: 130px"></font></td>
   </tr>
   <tr>
          <td align="center"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><SMALL><?php echo TEXT_PASSWORD;?></SMALL></B><br><input type="password" name="passw_empl" size="13" style="width: 130px"></font></td>
   </tr>
   <tr>
          <td align="center"><?php echo bx_image_submit_nowidth(HTTP_IMAGES.$language."/login.gif",0,TEXT_LOGIN);?></td>
   </tr>
   <tr>
          <td align="right"><a href="<?php echo bx_make_url(HTTP_SERVER.FILENAME_FORGOT_PASSWORDS."?employer=true", "auth_sess", $bx_session);?>"><?php echo TEXT_FORGOT_PASSWORD;?></a></td>
   </tr>
   <tr bgcolor="<?php echo TABLE_EMPLOYER;?>">
         <td><?php echo bx_image_width(HTTP_IMAGES.$language."/pix-t.gif",1,1,0,"");?></td>
   </tr>
   </table>
   </form>
<?php
}
?>