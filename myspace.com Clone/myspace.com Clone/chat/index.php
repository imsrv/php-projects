<?
/*
           .ÜÜÜÜÜÜÜÜÜÜÜÜ,                                  .ÜÜÜÜÜÜÜÜÜ:     ,ÜÜÜÜÜÜÜÜ:
         ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ                             .ÜÜÜÜÜÜÜÜÜÜÜÜÜÜ ,ÜÜÜÜÜÜÜÜÜÜÜÜÜ
        ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ             D O N          ;ÜÜÜÜÜÜÜÜÜÜÜÜÜÜ:ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ
        ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ                           ;ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ.
         ÜÜÜÜÜÜÜÜÜÜ  ÜÜÜÜÜÜÜÜÜ          ÜÜÜÜÜÜÜ;        .ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ ÜÜÜÜÜÜÜÜÜÜ;
         ,ÜÜÜÜÜÜÜÜÜ  ÜÜÜÜÜÜÜÜÜ        ÜÜÜÜÜÜÜÜÜÜÜ        ,ÜÜÜÜÜÜÜÜÜÜÜÜÜÜ ;ÜÜÜÜÜÜÜÜ;
          ÜÜÜÜÜÜÜÜÜ :ÜÜÜÜÜÜÜÜÜ      ÜÜÜÜÜÜÜÜÜÜÜÜÜÜ        ÜÜÜÜÜÜÜÜÜÜÜÜÜÜ;;ÜÜÜÜÜÜÜÜ
          ÜÜÜÜÜÜÜÜ: ÜÜÜÜÜÜÜÜÜÜ    .ÜÜÜÜÜÜÜ;;ÜÜÜÜÜÜ;      :ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ;ÜÜÜÜÜÜ.
         ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ   ;ÜÜÜÜÜÜÜ  .ÜÜÜÜÜÜÜ     .ÜÜÜÜÜÜÜÜ;ÜÜÜÜÜÜÜ;ÜÜÜÜÜÜ
        :ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ  ÜÜÜÜÜÜÜÜ,,,ÜÜÜÜÜÜÜÜ    .ÜÜÜÜÜÜÜÜ  ÜÜÜÜÜÜÜÜÜÜÜÜÜÜ
        ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ ;ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ    ÜÜÜÜÜÜÜÜÜ  ÜÜÜÜÜÜÜÜÜÜÜÜÜÜ
       ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ, ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ  .ÜÜÜÜÜÜÜÜÜÜÜ ÜÜÜÜÜÜÜÜÜÜÜÜÜÜ:
     .ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ  ÜÜÜÜÜÜÜÜÜÜÜÜÜ ÜÜÜÜÜÜÜÜÜÜÜÜÜÜ;
    ,ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ .ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ :ÜÜÜÜÜÜÜÜÜÜÜÜÜ ÜÜÜÜÜÜÜÜÜÜÜÜÜÜ;
   ;ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ  :ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ ,ÜÜÜÜÜÜÜÜÜÜÜÜÜÜ ÜÜÜÜÜÜÜÜÜÜÜÜÜÜ;
  ;ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ.  :ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ:ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ;
 ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ;     ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ:
 ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ.      ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ,  ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ ÜÜÜÜÜÜÜÜÜÜÜÜÜÜ
 ,ÜÜÜÜLiquidIceÜÜÜÜÜÜ          ÜÜÜÜÜÜÜÜÜÜÜÜÜÜ    ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ  ÜÜÜÜÜÜÜÜÜÜÜÜÜ
    .ÜÜÜÜÜÜÜÜÜÜ;                 ÜÜÜÜÜÜÜÜÜ        .ÜÜÜÜÜÜÜÜÜÜÜ    .ÜÜÜÜÜÜÜÜÜÜ,

*/

require('../data.php');
require('functions.php');
sql_connect();
global $main_url,$base_path;
$mode=form_get("mode");
$act=form_get("act");
if(!empty($mode) or !empty($act))	{
	header("Location:../index.php?mode=$mode&act=$act");
	exit;
}
$m_id=cookie_get("mem_id");
$m_pass=cookie_get("mem_pass");
$m_em=cookie_get("mem_em");
login_test($m_id,$m_pass);
include_once("../templates/chat_header.php");
echo "<br><br><div align='center'>";
$username=$m_em;
$modpass=$m_pass;
$usePhpNuke = false;
$use = false;
$usePostNuke = false;
if ( $usePhpNuke )
{
	if ( !eregi( "modules.php", $_SERVER['PHP_SELF'] ) ) {
		die ( "You cannot access this file directly..." );
	}
	require_once( "mainfile.php" );
	$module_name = basename( dirname( __FILE__ ) );
	$chatModulePath = "modules/" . $module_name;
}
else if ( $usePostNuke )
{
	if ( !defined( "LOADED_AS_MODULE" ) ) {
		die ( "You can't access this file directly..." );
	}
	$module_name = basename( dirname( __FILE__ ) );
	$chatModulePath = "modules/" . $module_name;
	if ( !pnUserLoggedIn() ) {
		die( "You must be logged-in to use the chat" );
	}
	$username = pnUserGetVar('uname');
}
else if ( $use )
{
	include_once( "config.php" );
	$lang = $defaultLanguage;
	$connection = new DBConnection();
	$username = !empty($xoopsUser) ? $xoopsUser->getVar('uname','E') : 'Anonymous';
	$xoopsOption['template_main'] = 'file_template.html';

	// Include the page header
//	include_once("header.php");

	$xoopsTpl->assign('username', $username);

	if ( $xoopsUser && $xoopsUser->isAdmin() ) {
		$modpass = $moderatorPassword;
	}

	$xoopsTpl->assign('modpass', $modpass);

	$xoopsTpl->assign('profilePopup', "$profilePopup");
	$xoopsTpl->assign('backgroundColor', "$backgroundColor");
	$xoopsTpl->assign('chatModulePath', ".");
	$xoopsTpl->assign('lang', "$lang");

	$xoopsTpl->assign('profilePopup', $profilePopup);
	$xoopsTpl->assign('popupPath', $popupPath);
	$xoopsTpl->assign('popupHeight', $popupHeight);
	$xoopsTpl->assign('popupWidth', $popupWidth);
	$xoopsTpl->assign('popupLeftOffset', $popupLeftOffset);
	$xoopsTpl->assign('popupTopOffset', $popupTopOffset);
	$xoopsTpl->assign('popupOptions', $popupOptions);
//	include_once("footer.php");
	exit;
}
else
{
	$chatModulePath = ".";
}
include_once( $chatModulePath . "/config.php" );
if ( $usePhpNuke || $usePostNuke )
{
	$profilePopup = 0;	// profile popup windows not permitted when using PHP/POST Nuke

	if ( !$lang )
		$lang = $defaultLanguage;
}

// determine which state we should start in: login or chat

if ( !$username )
	$startMode = "login";
else
	$startMode = "chat";

function login() {

	global $usePhpNuke, $usePostNuke, $languageList, $moderatorPassword, $spyPassword, $username, $lang, $_SERVER;

	if ( $usePhpNuke || $usePostNuke ) {
//   		include_once("header.php");
   		OpenTable();

   		// put the login form left-aligned when using PHP-Nuke
   		$align = "left";
	}
	else
		$align = "center";

	$languageList = explode( ",", $languageList );

	$languageSelectList = "<select style=\"font-size: 12px; font-family: Arial;\" name=lang>\n";

	// get the language list from the $languages Array in config file

	foreach( $languageList as $language )
	{
		if ( trim( $language ) != "" )	// in case user accidentally adds a comma at end of language list in config.php
			$languageSelectList .= "<option value=\"$language\">" . ucfirst( $language ) . "</option>\n";
	}

	$languageSelectList .= "</select>\n";


	if ( sizeof( $languageList ) > 1 )
		$languageTableRow = "<tr><td><font size=2 face=\"Arial, Helvetica, sans-serif\">Select Language:</font></td><td>$languageSelectList</td></tr>";
	else
		$languageTableRow = "<input type=hidden name=lang value=\"$language\">";

	if ( $usePostNuke )
		$modloadVariable = "<input type=hidden name=op value=modload>";

	$action = $_SERVER['PHP_SELF'];
?>
<div align=<?=$align?>>
<script language="Javascript">
<!--
function validateLogin( loginForm )
{
	if ( loginForm.username.value == "" ) {
		alert( "Please enter a valid user name." );
	}
	else {
		loginForm.submit();
	}
}
//-->
</script>
<br><br><br><br>
<form name=chatForm method=POST action="<?=$action?>">
  <table width="460" border="0" cellpadding="1" cellspacing="0">
    <tr>
      <td><table width="100%" height=100% border="0" cellpadding="4" cellspacing="0">
            <tr> 
              <td colspan="2"><b>Chat Login</b></td>
            </tr>
            <tr> 
              <td width="44%" align="center">Username</td>
              <td width="56%"><input type=text name=username size=20 maxlength=20></td>
            </tr>
            <tr> 
              <td align="center">Password</td>
              <td><input name=modpass type=password id="modpass" size=20 maxlength=20></td>
            </tr>
            <tr> 
              <td align="center">&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <?php
//		$languageTableRow
?>
            <tr> 
              <td colspan="2" align="center"> <input type=hidden name=bypass value="Bypass"> 
                <input type=button name=Identity value="Enter Chat Room" onClick="javascript:validateLogin(document.chatForm);"> 
              </td>
            </tr>
            <tr>
              <td colspan="2" align="center">&nbsp;</td>
            </tr>
          </table></td>
    </tr>
  </table>
  <?=$modloadVariable?>
  </form>
</div>
<?php
	if ( $usePhpNuke || $usePostNuke ) {
    	CloseTable();
//    	include_once("footer.php");
    }
}


function chat() {
    global $lang, $connection, $usePhpNuke, $usePostNuke, $username, $backgroundColor, $chatModulePath, $modpass, $popupWidth,$popupHeight,$popupLeftOffset,$popupTopOffset,$popupOptions, $popupPath, $banTime;
	if ( $usePhpNuke || $usePostNuke ) {
//    	include_once("header.php");
		OpenTable();
	}
	$connection = new DBConnection();
	$username = trim( $username );
?>
<SCRIPT LANGUAGE=JavaScript1.1>
function getChatProfile( username )
{
	window.open( "<?=$popupPath?>?username=" + username, "userProfile", "width=<?=$popupWidth?>,height=<?=$popupHeight?>,top=<?=$popupTopOffset?>,left=<?=$popupLeftOffset?>,<?=$popupOptions?>" );
}
function getHelp()
{
	window.open( "<?=$chatModulePath?>/help.php", "helpWindow", "width=<?=$popupWidth?>,height=<?=$popupHeight?>,left=<?=$popupLeftOffset?>,top=<?=$popupTopOffset?>,<?=$popupOptions?>" );
}
var MM_contentVersion = 6;
var plugin = (navigator.mimeTypes && navigator.mimeTypes["application/x-shockwave-flash"]) ? navigator.mimeTypes["application/x-shockwave-flash"].enabledPlugin : 0;
if ( plugin ) {
		var words = navigator.plugins["Shockwave Flash"].description.split(" ");
	    for (var i = 0; i < words.length; ++i)
	    {
		if (isNaN(parseInt(words[i])))
		continue;
		var MM_PluginVersion = words[i];
	    }
	var MM_FlashCanPlay = MM_PluginVersion >= MM_contentVersion;
}
if ( MM_FlashCanPlay || navigator.userAgent.indexOf('MSIE') != -1 ) {
	document.write(' <OBJECT classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" ');
	document.write('  codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,79,0" ');
	document.write(' ID="FlashChat" WIDTH="540" HEIGHT="540" ALIGN="">');
	document.write(' <PARAM NAME=movie ');
	document.write(' VALUE="<?=$chatModulePath?>/FlashChat.swf?path=<?=$chatModulePath?>&bgcolor=<?=$backgroundColor?>&name=<?=$username?>&modpass=<?=$modpass?>&lang=<?=$lang?>"> ');
	document.write(' <PARAM NAME=name VALUE="<?=$username?>"> ');
	document.write(' <PARAM NAME=quality VALUE=high> ');
	document.write(' <PARAM NAME=bgcolor VALUE="<?=$backgroundColor?>"> ');
	document.write(' <PARAM NAME=path VALUE="<?=$chatModulePath?>"> ');
	document.write(' <PARAM NAME=modpass VALUE="<?=$modpass?>"> ');
	document.write(' <PARAM NAME=lang VALUE="<?=$lang?>"> ');
	document.write(' <EMBED src="<?=$chatModulePath?>/FlashChat.swf?path=<?=$chatModulePath?>&bgcolor=<?=$backgroundColor?>&name=<?=$username?>&modpass=<?=$modpass?>&lang=<?=$lang?>" ');
	document.write(' quality=high bgcolor=<?=$backgroundColor?> ');
	document.write(' swLiveConnect=FALSE WIDTH="540" HEIGHT="540" NAME="FlashChat" ALIGN="" ');
	document.write(' TYPE="application/x-shockwave-flash" PLUGINSPAGE="http://www.macromedia.com/go/getflashplayer"> ');
	document.write(' </EMBED> ');
	document.write(' </OBJECT> ');
} else{
	document.location.href = "<?=$chatModulePath?>/noFlash.php";
}
//-->
</SCRIPT>
<?php
	if ( !$usePhpNuke && !$usePostNuke )
//		print "<P><font face=Arial size=2><a href=$chatModulePath/logout.php>Login as a different user</a>";

	if ( $usePhpNuke || $usePostNuke ) {
    	CloseTable();
//    	include_once("footer.php");
    }
}

switch( $startMode ) {

    case "chat":
		chat();
    	break;
    default:
    	login();
    	break;
}
echo "<br><br></div>";
include_once("../templates/footer.php");
?>