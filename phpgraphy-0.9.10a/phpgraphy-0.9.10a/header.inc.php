<?php
// Start the counter to calculate the page's generation time
$timegen=gettimeofday();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $language_file_info['country_code'] ?>" <?php if ($language_file_info['direction']) echo 'dir="'.$language_file_info['direction'].'"'?>>
  <head>
    <meta http-equiv="Content-Script-Type" content="text/javascript" />
    <meta http-equiv="Content-Type" content="text/html; charset=<?php echo $language_file_info['charset'] ?>" />
    <link rel="stylesheet" href="phpgraphy.css" type="text/css" />
    <link rel="icon" href="<? echo $icons_dir ?>favico.ico" type="image/ico" />
    <link rel="shortcut icon" href="<? echo $icons_dir ?>favico.ico" type="image/ico" />
    <script src="phpgraphy.js" type="text/javascript"></script>
    <title><?php echo $txt_site_title ?></title>
  </head>
<body>
<div <?php if (!$_GET['popup']) echo "class=\"main\""; ?>>
<a href="<?php echo basename($_SERVER['SCRIPT_NAME']); ?>"><img src="<?php echo $icons_dir ?>phpgraphy-banner.gif" alt="phpGraphy banner" id="banner" /></a>
