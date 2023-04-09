<html>
<head>
<title>Database Error</title>

{literal}
	<style type="text/css">
	body {
	 background-color: #f5f5f5;
	 color: #404040;
	 font-family: verdana,arial,helvetica;
	 font-size: 10px;
	}
	</style>
{/literal}

</head>

<body>

There was an error querying the database:<br /><br />

<font color="red">({$error_num}) {$error_msg}</font>

<br /><br />

The following query was attempted:

<div style="width: 450px; padding: 5px; border: 1 solid black;background-color: #ffffff;">
	{$query}
</div>

</body>
</html>