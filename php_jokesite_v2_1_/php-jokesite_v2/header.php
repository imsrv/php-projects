<html>
<head>
	<title><?=$site_title;?> WST release rulez </title>
	<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET_OPTION;?>">
	<meta name="description" content="<?php echo META_DESCRIPTION;?>">
	<meta name="keywords" content="<?php echo META_KEYWORDS;?>"> 
	<link rel="stylesheet" href="<?=HTTP_SERVER?>css.css">
	<script language="Javascript">
	<!--
	function printitWindow(newwidth,newheight)
    {   
        navigv = parseInt(navigator.appVersion);
        if (navigv < 4) {
        alert('Your navigator cannot accept printing !');
        }else{
        window.open ('printit.php?joke_id=<?=$HTTP_GET_VARS['joke_id']?>&cat_id=<?=$HTTP_GET_VARS['cat_id']?>','Printer_Friendly', 'scrollbars=no,toolbar=no,status=no,locationbar=no,location=no,directories=no,width='+newwidth+',height='+newheight);
        }
    } 
	//-->
	</script>
	</head>

<body bgcolor="<?=SITE_BGCOLOR?>" marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0">

<img src="<?=DIR_IMAGES?>0.gif" border="0" height="<?=DISTANCE_BETWEEN_TOP_AND_BANNER?>"><br>
<?
include(DIR_SERVER_ROOT."banner_random_banner.php");
?>

<table align="center" border="0" cellspacing="0" cellpadding="1" width="<?=HTML_WIDTH?>">
<tr>
	<td bgcolor="<?=SITE_BGCOLOR?>">
	<table border="0" cellpadding="<?=LOGO_BANNER_CELLPADDING?>" cellspacing="0" width="<?echo HTML_WIDTH;?>" align="center" bgcolor="<?=SITE_BGCOLOR?>">
	<tr>
		<td width="260" height="60"><a href="<?=HTTP_SERVER?>"><img src="<?=DIR_IMAGES?>sitelogo.gif" border="0" alt="" width="260" height="60"></a></td>
<?
if ($random_top)
{	
?>
		<!-- Top banner start here -->
		<td align="center" width="<?=HTML_WIDTH-260?>"><?echo fread(fopen(BANNER_DIR."top_banner".$random_top.".html","r"), filesize(BANNER_DIR."top_banner".$random_top.".html"));?></td>
<?
}
else{
?>
	<td align="center" width="<?=HTML_WIDTH-260?>"> place your banner here</td>
<?}
?>

	</tr>
	</table>
	</td>
</tr>
</table>

<? if(USE_EXTRA_HEADER=='yes'){?>
<table align="center" border="0" cellspacing="0" cellpadding="1" width="<?=HTML_WIDTH?>"><tr><td colspan="2"><?=EXTRA_HEADER;?></td></tr></table>
<?}?>

<img src="<?=DIR_IMAGES?>0.gif" border="0" alt="" height="<?=DISTANCE_BETWEEN_BANNER_AND_MENU?>"><br>

<!-- menu start here-->
<table align="center" border="0" cellspacing="0" cellpadding="1" width="<?=HTML_WIDTH?>">
<tr>
	<td bgcolor="<?=MENU_BORDERCOLOR?>">
<?
	include (DIR_SERVER_ROOT."menu.php");
?>
	</td>
</tr>
</table>
<!-- menu end here-->
<img src="<?=DIR_IMAGES?>0.gif" border="0" alt="" height="<?=DISTANCE_BETWEEN_MENU_AND_MAIN?>"><br>

<table align="center" border="0" cellspacing="0" cellpadding="1" width="<?=HTML_WIDTH?>">
<tr valign="top" align="center">
	<td bgcolor="<?=SITE_INTERNAL_BORDERCOLOR?>">
	   <table align="center" border="0" cellspacing="0" cellpadding="0" width="100%">
	   <tr valign="top">
			<td bgcolor="<?=SITE_INTERNAL_BGCOLOR?>" width="<?=LEFT_PART_WIDTH?>">
				<table align="center" border="0" cellspacing="0" cellpadding="0" width="<?=LEFT_PART_WIDTH?>">
<?
if (MULTILANGUAGE_SUPPORT == "on") 
{	echo "<tr><td><font style=\"font-size:3px\"><br></font>";
   $dirs = getFiles(DIR_FLAG);
   for ($i=0; $i<count($dirs); $i++) 
   {
		$lngname = split("\.",$dirs[$i]);
		echo "<a href=\"".HTTP_SERVER.basename($HTTP_SERVER_VARS['PHP_SELF'])."?language=".$lngname[0].""."\" onmouseover=\"window.status='".BROWSE_THIS_PAGE_IN." ".$lngname[0]."'; return true;\" onmouseout=\"window.status=''; return true;\"><img src=".HTTP_FLAG.$dirs[$i]." border=\"0\" alt=".$lngname[0]." hspace=\"3\"></a>";	
		
   }
	echo "<font style=\"font-size:4px\"><br></font></td></tr>";
}  

if ($show_statistic_form=="yes"){
?>
				<tr>
					<td width="100%">
<br><?	include (DIR_FORMS."stats.php");?>				
					</td>
				</tr>
<?}?>

<?
if ($show_quick_search_form=="yes"){
?>
				<tr>
					<td width="<?=QUICK_SEARCH_TABLE_WIDTH?>">
<font style="font-size:5px"><br></font><?	include (DIR_FORMS."quick_search_form.php");?>				
					</td>
				</tr>
<?
}

	if ($show_newsletter_form=="yes"){
?>
				<tr>
					<td width="<?=NEWSLETTER_TABLE_WIDTH?>">
<font style="font-size:5px"><br></font><?	include (DIR_FORMS."newsletter_form.php");?>
					</td>
				</tr>
<?}?>
				<tr>
					<td width="100%">
<?
		if ($show_joke_categories=="yes")
		{
			echo "<font style=\"font-size:5px\"><br></font>";
			include (DIR_FORMS."joke_categories_form.php");	
		}elseif ($show_picture_categories=="yes")
		{
			echo "<font style=\"font-size:5px\"><br></font>";
			include (DIR_FORMS."picture_categories_form.php");	
		}	
	?>				
					</td>
				</tr>
				</table>
			</td>
			<td bgcolor="<?=SITE_INTERNAL_BGCOLOR?>">
				<table align="center" border="0" cellspacing="0" cellpadding="0" width="100%" bgcolor="<?=SITE_INTERNAL_BGCOLOR?>">
<?
if ($message_to_user)
{
?>
				<tr>
					<td >
<?	include (DIR_FORMS."message_form.php");?>
					</td>
				</tr>
<?
}
?>
				<tr>
					<td>
						<table align="center" border="0" cellspacing="4" cellpadding="4" width="100%">
