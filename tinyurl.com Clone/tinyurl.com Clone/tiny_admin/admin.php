<?php

// -----------------------------------------------------------------------------
//
// phpFaber TinyLink v.1.0
// Copyright(C), phpFaber LLC, 2004-2005, All Rights Reserved.
// E-mail: products@phpfaber.com
//
// All forms of reproduction, including, but not limited to, internet posting,
// printing, e-mailing, faxing and recording are strictly prohibited.
// One license required per site running phpFaber TinyLink.
// To obtain a license for using phpFaber TinyLink, please register at
// http://www.phpfaber.com/i/products/tinylink/
//
// 19:59 28.07.2005
//
// -----------------------------------------------------------------------------

require_once("../tiny_includes/config.php");

if(!$HTTP_SESSION_VARS['s_page_show_all']) session_register('s_page_show_all');
if($HTTP_SESSION_VARS['s_page_show_all'] and $page_show_all=='') $page_show_all = $HTTP_SESSION_VARS['s_page_show_all'];

if($show_all) $searchurl = '';

if($HTTP_GET_VARS['search']){
  session_register('searchurl');
  $HTTP_SESSION_VARS['searchurl'] = $HTTP_GET_VARS['surl'];
}

if($change and !$remove and !$enter) changeAdd($val,$change);
if($delete and !$remove and !$enter) deleteAllRecords();
if($clear and !$remove and !$enter) clearRating();
if($set and !$remove and !$enter) setAdd(1);
if($uset and !$remove and !$enter) setAdd(0);
if($remove) removeUrls($HTTP_POST_VARS);
if($reset and !$remove and !$enter) resetAll();

$smarty = new Smarty;
$smarty->template_dir = "$dir_ws/tiny_templates/admin";
$smarty->compile_dir = "$dir_ws/tiny_templates_c";
$smarty->assign("url_to_index",$config['url_to_index']);
  
if(($login && $pwd && md5($login)==md5($config['alogin'])) and (md5($pwd)==md5($config['apwd'])) or $HTTP_SESSION_VARS['inadmin']==1){
  // ADMIN AREA
  session_register('inadmin');
  $HTTP_SESSION_VARS['inadmin'] = 1;
  $smarty->assign("page",$PHP_SELF);

  if($HTTP_SESSION_VARS['searchurl']){
    $smarty->assign("urls",findUrls($HTTP_SESSION_VARS['searchurl'],$orderby));
    $smarty->assign("pageSelector", $pageSelector);
    $smarty->assign("page_show_all",$page_show_all);
    $s_page_show_all=$page_show_all;
    $smarty->assign("maxNumb", "<font size=4>$maxNumb</font> records was found in database.");
    $smarty->assign("total", getTotal());
  }
  else{
    $smarty->assign("urls",allUrls($orderby));
    $smarty->assign("pageSelector", $pageSelector);
    $smarty->assign("page_show_all",$page_show_all);
    $s_page_show_all=$page_show_all;
    $smarty->assign("maxNumb", "Number of the records in database: <font size=4>$maxNumb</font>");
    $smarty->assign("total", getTotal());
  }
  $smarty->display("admin.htm");
}
else{
  // ACCESS DENIED
  $HTTP_SESSION_VARS['inadmin'] = 0;
  $smarty->display("login.htm");
}

?>