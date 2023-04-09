      </td>
     </tr>
	 </table>
 </td>
 <!-- end body_navigation //-->
 <!-- right_navigation //-->
 <!-- kactus_man2003[WST] -->
 <?php
  if (!$HTTP_SESSION_VARS['userid']) {
 ?>
 <td valign="top" width="<?php echo RIGHT_NAVIGATION_WIDTH;?>">
  <table border="0" cellspacing="0" cellpadding="1" width="100%" height="100%">
     <tr>
      <td width="100%" align="center" bgcolor="#000000">
      <?php
      include(DIR_LANGUAGES.$language."/".FILENAME_RIGHT_NAVIGATION);
      if ($HTTP_SESSION_VARS['employerid'] || (!$HTTP_SESSION_VARS['employerid'] && $HTTP_POST_VARS['compid'])) {
          include(DIR_LANGUAGES.$language.'/html/right_navigation_logged.php');
      }
      else {
          include(DIR_LANGUAGES.$language.'/html/right_navigation_notlogged.php');
      }
      ?>
      </td>
     </tr>
  </table>
 </td>
 <?php
 }
 ?>
 <!-- end right_navigation //-->
 </tr>
 </table>
<table border="0" width="<?php echo HTML_WIDTH;?>" cellspacing="0" cellpadding="0" align="center">
 <tr>
 <td width="100%">
 <?php
 @include(DIR_LANGUAGES.$language.'/html/footer.html');
?>
 </td>
 </tr>
</table>
</body>
</html>
<?php
include (DIR_SERVER_ROOT.'application_parse_time_log.php');
?>