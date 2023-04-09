<?php
if($login=='jobseeker' || $HTTP_GET_VARS['login']=="jobseeker")
{
   ?>
   <form action="<?php echo bx_make_url(HTTP_SERVER.FILENAME_LOGIN_PROCESS."?login=jobseeker", "auth_sess", $bx_session);?>" method="post">
    <?php if(!$HTTP_POST_VARS['redirect']) {?>
          <input type="hidden" name="redirect" value="<?php echo $HTTP_SERVER_VARS["REQUEST_URI"];?>">
    <?php
    }//end if (!redirect)
    while (list($header, $value) = each($HTTP_GET_VARS)) {
         echo "<input type=\"hidden\" name=\"".$header."\" value=\"".$value."\">";
     }//end while (list($header, $value) = each($HTTP_POS
   ?>
  <table width="100%" border="0" bgcolor="<?php echo LEFT_NAV_BG_COLOR;?>" cellspacing="0" cellpadding="2" height="100%">
  <TR>
        <TD colspan="2" align="center" valign="middle" width="100%" class="headertdjob"><?php echo TEXT_PLEASE_LOGIN_FIRST;?></FONT></TD>
  </TR>
  <tr><td colspan="2"><table cellpadding="0" cellspacing="0" border="0" width="100%">
                <tr>
                    <td bgcolor="<?php echo TABLE_HEADING_BGCOLOR;?>" height="1"><?php echo bx_image_width(HTTP_IMAGES.$language."/pix-t.gif",1,1,0,"");?></td>
                </tr>
       </table>
       </td>
  </tr>
  <tr>
  <td bgcolor="<?php echo TABLE_BGCOLOR;?>" width="100%">
   <table bgcolor="<?php echo TABLE_BGCOLOR;?>" align="center" valign="middle" width="75%" border="0" cellspacing="0" cellpadding="4">
   <tr>
     <td width="30%"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><SMALL><?php echo TEXT_USER_NAME;?>:</SMALL></B></FONT></td>
     <td><input type="text" name="users_seek" size=18></td>
   </tr>
   <tr>
     <td width="30%"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><SMALL><?php echo TEXT_PASSWORD;?>:</B></SMALL></font></td>
     <td><input type="password" name="passw_seek" size=18></td>
   </tr>
   <tr>
      <td width="30%">&nbsp;</td>
      <td><?php echo bx_image_submit_nowidth(HTTP_IMAGES.$language."/login.gif",0,TEXT_LOGIN);?></td>
   </tr>
   <tr>
      <td width="30%">&nbsp;</td>
      <td align="right"><a href="<?php echo bx_make_url(HTTP_SERVER.FILENAME_FORGOT_PASSWORDS."?jobseeker=true", "auth_sess", $bx_session);?>"><?php echo TEXT_FORGOT_PASSWORD;?></a></td>
   </tr>
   <tr>
     <td colspan="2" width="100%" align="center"><a href="<?php echo bx_make_url(HTTP_SERVER.FILENAME_PERSONAL."?action=new", "auth_sess", $bx_session);?>"><?php echo TEXT_REGISTER_FREE;?></a></td>
   </tr>
   </table>
  </td></tr></table>
  </form>
<?php
}
else if($login=='employer' || $HTTP_GET_VARS['login']=="employer") {
 ?>
 <form action="<?php echo bx_make_url(HTTP_SERVER.FILENAME_LOGIN_PROCESS."?login=employer", "auth_sess", $bx_session);?>" method="post"><center>
 <?php
  if (!$HTTP_POST_VARS['redirect']) {
      ?>
       <input type="hidden" name="redirect" value="<?php echo $HTTP_SERVER_VARS["REQUEST_URI"];?>">
       <?php
   }//end if (!$redirect)
   while (list($header, $value) = each($HTTP_GET_VARS)) {
     echo "<input type=\"hidden\" name=\"".$header."\" value=\"".$value."\">";
     }//end while (list($header, $value) = each($HTTP_POS
   ?>
   <table width="100%" border="0" bgcolor="<?php echo LEFT_NAV_BG_COLOR;?>" cellspacing="0" cellpadding="2" height="100%">
  <TR>
        <TD colspan="2" align="center" valign="middle" width="100%" class="headertdjob"><?php echo TEXT_PLEASE_LOGIN_FIRST;?></FONT></TD>
    </TR>
    <tr><td colspan="5"><table cellpadding="0" cellspacing="0" border="0" width="100%">
                <tr>
                    <td bgcolor="<?php echo TABLE_EMPLOYER;?>" height="1"><?php echo bx_image_width(HTTP_IMAGES.$language."/pix-t.gif",1,1,0,"");?></td>
                </tr>
       </table>
   </td>
   </tr>
   <tr>
   <td bgcolor="<?php echo TABLE_BGCOLOR;?>" width="100%">
   <table bgcolor="<?php echo TABLE_BGCOLOR;?>" width="75%" align ="center" valign="middle" border="0" cellspacing="0" cellpadding="4">
   <tr>
     <td width="30%"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><b><SMALL><?php echo TEXT_USER_NAME;?>:</SMALL></b></font></td>
     <td><input type="text" name="users_empl" size="18"></td>
   </tr>
   <tr>
     <td width="30%"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><b><SMALL><?php echo TEXT_PASSWORD;?>:</SMALL></b></font></td>
     <td><input type="password" name="passw_empl" size="18"></td>
   </tr>
   <tr>
      <td width="30%">&nbsp;</td>
      <td><?php echo bx_image_submit_nowidth(HTTP_IMAGES.$language."/login.gif",0,TEXT_LOGIN);?></td>
   </tr>
   <tr>
      <td width="30%">&nbsp;</td>
      <td align="right"><a href="<?php echo bx_make_url(HTTP_SERVER.FILENAME_FORGOT_PASSWORDS."?employer=true", "auth_sess", $bx_session);?>"><?php echo TEXT_FORGOT_PASSWORD;?></a></td>
   </tr>
   <tr>
     <td colspan="2" width="100%" align="center"><a href="<?php echo bx_make_url(HTTP_SERVER.FILENAME_COMPANY."?action=new", "auth_sess", $bx_session);?>"><?php echo TEXT_REGISTER_FREE;?></a></td>
   </tr>
   </table>
   </td></tr></table>
 </center>
 </form>
<?php
}
else {
?>
<form action="<?php echo bx_make_url(HTTP_SERVER.FILENAME_LOGIN_PROCESS."?login=".$HTTP_GET_VARS['log'], "auth_sess", $bx_session);?>" method="post"><center>
<table width="100%" border="0" bgcolor="<?php echo LEFT_NAV_BG_COLOR;?>" cellspacing="0" cellpadding="2" height="100%">
  <TR>
        <TD colspan="2" align="center" valign="middle" width="100%" class="headertdjob"><?php echo TEXT_SESSION_EXPIRED;?></FONT></TD>
  </TR>
    <tr><td colspan="5"><table cellpadding="0" cellspacing="0" border="0" width="100%">
                <tr>
                    <td bgcolor="<?php echo TABLE_EMPLOYER;?>" height="1"><?php echo bx_image_width(HTTP_IMAGES.$language."/pix-t.gif",1,1,0,"");?></td>
                </tr>
       </table>
   </td>
   </tr>
   <TR>
   <td bgcolor="<?php echo TABLE_BGCOLOR;?>" width="100%">
   <table bgcolor="<?php echo TABLE_BGCOLOR;?>" width="75%" align ="center" valign="middle" border="0" cellspacing="0" cellpadding="4">
   <tr>
     <td width="50%" colspan="2"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><?php echo TEXT_SESSION_EXPIRED_EXPLAIN;?></font></td>
   </tr>
   <tr>
     <td width="30%"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><b><SMALL><?php echo TEXT_USER_NAME;?>:</SMALL></b></font></td>
     <td><input type="text" name="<?php if($HTTP_GET_VARS['log']=="employer") {echo "users_empl";} else if ($HTTP_GET_VARS['log']=="jobseeker") {echo "users_seek";}?>" size="18"></td>
   </tr>
   <tr>
     <td width="30%"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><b><SMALL><?php echo TEXT_PASSWORD;?>:</SMALL></b></font></td>
     <td><input type="password" name="<?php if($HTTP_GET_VARS['log']=="employer") {echo "passw_empl";} else if ($HTTP_GET_VARS['log']=="jobseeker") {echo "passw_seek";}?>" size="18"></td>
   </tr>
   <tr>
      <td width="30%">&nbsp;</td>
      <td><?php echo bx_image_submit_nowidth(HTTP_IMAGES.$language."/login.gif",0,TEXT_LOGIN);?></td>
   </tr>
   </table>
   </td></tr></table>
 </center></form>
<?php
}
?>