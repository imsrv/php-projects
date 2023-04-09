<?PHP

/* ====================
Land Down Under - Website engine
Copyright Neocrome
http://www.neocrome.net

[BEGIN_LDU]
File=plug.php
Version=801
Updated=2005-aug-26
Type=Core
Author=Neocrome
Description=Plugin loader
[END_LDU]
==================== */

define('LDU_CODE', TRUE);
define('LDU_PLUG', TRUE);
$location = 'Plugins';
$z = 'plug';

require('system/functions.php');
require('system/templates.php');
require('datas/config.php');
require('system/common.php');

ldu_dieifdisabled($cfg['disableplug']);

switch($m)
	{
	default:
	require('system/core/plug/plug.inc.php');
	break;
	}

?>
