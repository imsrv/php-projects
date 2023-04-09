<html>
<head>
	<title>Lore {$lore_system.version} Control Panel</title>
</head>

<frameset cols="135,*"  framespacing="0" border="0" frameborder="0" frameborder="no" border="0">
	<frame src="{$lore_system.scripts.cp_index}?action=nav" name="nav" scrolling="yes" frameborder="0" marginwidth="0" marginheight="0" border="no" noresize="noresize" />
	<frame src="{$goto|default:"`$lore_system.scripts.cp_index`?action=index"}" name="main" scrolling="auto" frameborder="0" marginwidth="10" marginheight="10" border="no" noresize="noresize" />
</frameset>


</html>