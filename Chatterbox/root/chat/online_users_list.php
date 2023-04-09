<?php
include ("config.php");
include ("chat.php");
include ("db_file.php");
?>
<HTML><HEAD><link REL='StyleSheet' TYPE='text/css' HREF='style.css'></HEAD>
<script language="JavaScript">
function AddTextToMain(text) {
   f=top.frames['main'].document.forms[0];
   f.msg.value=f.msg.value+text;
   f.msg.focus();
}
function process()
{
	document.location = "online_users_list.php";
}
setTimeout("process()",3000);
</script>
<body bgcolor="#EBE7E7">
Send to:<br/><br/>
<?php
DB_connect();
$res = GLOB_getusersconnected_query();
while( $row = mysql_fetch_array( $res ) )
{
   echo "<A href='javascript:AddTextToMain(\"" . $row['user'] . ", \")'>" . $row['user'] ."</A><br/>";
}
?>
</body>
</HTML>
