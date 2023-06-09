<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $sg->pageTitle() ?></title>
<link rel="stylesheet" type="text/css" href="<?php echo $sg->config->pathto_admin_template ?>main.css" />
<!-- 
  This page was generated by singapore <http://singapore.sourceforge.net>
  singapore is free software licensed under the terms of the GNU GPL.
-->
</head>

<body>

<div id="crumb">
<?php echo $sg->i18n->_g("crumb line|You are here:") ?> <?php echo $sg->crumbLineText() ?>
</div>

<div id="header"><img src="<?php echo $sg->config->pathto_admin_template ?>images/header.gif" alt="<?php echo $sg->config->gallery_name ?>" /></div>

<div id="sgAdminBar">
  <?php
    $sections = $sg->adminLinksArray(); 
    foreach($sections[0] as $text => $url): ?>
  <a href="<?php echo $url ?>"><?php echo $text ?></a>
  <?php endforeach; ?>
  <?php for($i=1;$i<count($sections);$i++): ?>
  <span class="sgAdminBarSeparator"></span>
  <?php foreach($sections[$i] as $text => $url): ?>
  <a href="<?php echo $url ?>"><?php echo $text ?></a>
  <?php endforeach; ?>
  <?php endfor; ?>
</div>

<?php if(isset($adminMessage)): ?>
<div id="sgAdminMessages">
  <?php 
    echo $sg->i18n->_g("Admin message:");
    echo "<br />\n&nbsp;&nbsp;";
    echo $adminMessage; 
  ?>
</div>
<?php endif; ?>

<!-- start of generated content -->

