<?php
require "../common/config.php";

if ($pw == $adminpw) {
?>
<html>
<head>
<title>Admin ClearChat</title>
<meta http-equiv="cache-control" content="no-cache">
<meta http-equiv="expires" content="0">
<meta http-equiv="pragma" content="no-cache">
</head>
<frameset rows="70,*" frameborder="0" framespacing="0" border="0">
<frame src="input.php?pw=<?php echo $pw; ?>&amp;username=<?php echo $username; ?>" name="inputframe" scrolling="no" noresize>
<frame src="view.php?pw=<?php echo $pw; ?>" name="outputframe" scrolling="auto" noresize>
</frameset>
</html>

<?php
} else {
?>

<html>
<head>
<title>Admin ClearChat</title>
<meta http-equiv="cache-control" content="no-cache">
<meta http-equiv="expires" content="0">
<meta http-equiv="pragma" content="no-cache">
<link rel="stylesheet" href="../common/clearchat.css" type="text/css">
</head>
<body bgcolor="000044" onLoad="document.pwform.pw.focus()">
<span class="nick">Password:</span><br>
<form name="pwform" action="adminchat.php" autocomplete="off" method="get">
<input type="password" name="pw" autocomplete="off">
<input type="submit" name="submit" class="saybtn" value="Ok">
<input type="text" name="username" class="usrn" value="<?php echo $username; ?>">
</form>
</body>
</html>

<?php
}
?>