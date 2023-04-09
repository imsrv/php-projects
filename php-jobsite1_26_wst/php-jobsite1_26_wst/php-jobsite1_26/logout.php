<?php
  include ('application_config_file.php');
  bx_session_destroy();
  if($HTTP_GET_VARS['user']=='true') {
      bx_db_query("UPDATE ".$bx_table_prefix."_persons set lastlogin = NOW() where persid = '".$HTTP_SESSION_VARS['userid']."'");
      SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
      $HTTP_SESSION_VARS['userid']='';
      $userid='';
      header('Location: ' . bx_make_url(HTTP_SERVER.FILENAME_INDEX."?language=".$language, "auth_sess", $bx_session));
      bx_exit();
  }
  if($HTTP_GET_VARS['employer']=='true') {
      bx_db_query("UPDATE ".$bx_table_prefix."_companies set lastlogin = NOW() where compid = '".$HTTP_SESSION_VARS['employerid']."'");
      SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
      $HTTP_SESSION_VARS['employerid']='';
      $employerid='';
      header('Location: ' .bx_make_url(HTTP_SERVER.FILENAME_INDEX."?language=".$language, "auth_sess", $bx_session));
      bx_exit();
  }
?>