{*
+----------------------------------------------------------------------
| Template: upgrade.tpl
| 
| This template is used when running an upgrade script.
| Don't mess with it :-)
+----------------------------------------------------------------------
*}
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title>Lore Upgrade Wizard</title>
	
	<link rel="stylesheet" type="text/css" href="templates/stylesheet.css" />
	
	<style type="text/css">
	{literal}
	body {
	 margin: 10px;
	 font-size: 12px;
	 font-family: verdana,arial,helvetica;
	}
	{/literal}
	</style>
</head>

<body>

<h1 style="background-color:#f0f0f0;font-size:24px;border-bottom:1 dotted black;">
	Lore Upgrade Wizard
</h1>

This wizard will upgrade your Lore version. <b>Please ensure that you have uploaded the latest files to complete the upgrade.</b>
<br />

<br /><br />

{section name=message_loop loop=$messages}
	{$messages[message_loop]}<br /><br />
{/section}

<div style="text-align: center; font-size: 10px;color:#aaaaaa;border-top: 1 solid #808080">
	<br />
</div>

</body>
</html>