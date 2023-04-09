<?
	include("../include/imap.inc");

if (isset($submit)){
	header("Content-Type: text/plain");
	$from_conn = iil_Connect($from_host, $from_login, $from_password);
	$to_conn = iil_Connect($to_host, $to_login, $to_password);
	if (($from_conn) && ($to_conn)){
		echo "Connected to $from_host and $to_host !<br>\n"; flush();
		$num = iil_C_CountMessages($from_conn, $from_mbox);

		echo "Got {$fromID} to {$toID}\n";
		if (empty($fromID)) $fromID=1;
		if (empty($toID)) $toID=$num;
		echo "Will sync $fromID - $toID messsages in $from_mbox with $to_mbox \n"; flush();

		for ($i=$fromID;$i<=$toID;$i++){
			echo "Fetching message $i \n";
			$message = iil_C_FetchPartHeader($from_conn, $from_mbox, $i, "");
			$message .= iil_C_FetchPartBody($from_conn, $from_mbox, $i, "");
			//echo $message."<br>\n";
			if (iil_C_Append($to_conn, $to_mbox, $message)){
				echo "Moved message $i from $from_host/$from_mbox to $to_host/$to_mbox \n";flush();
			}else{
				echo "Move failed <br>\n";
			}
		}
		iil_Close($from_conn);
		iil_Close($to_conn);
	}
}else{
?>
<html>
<body>
<form method="POST" action="synch.php">
<table><tr>
	<td>
	<b>From:</b>
	<br>Host:<input type="text" name="from_host" value="<?=$from_host?>">
	<br>Login:<input type="text" name="from_login" value="<?=$from_login?>">
	<br>Password:<input type="text" name="from_password" value="<?=$from_password?>">
	<br>Mailbox:<input type="text" name="from_mbox" value="<?=$from_mbox?>">
	<br>From <input type="text" name="fromID" value="" size=4> TO: <input type="text" name="toID" value="" size=4>
	</td>
	<td>
	<b>To:</b>
	<br>Host:<input type="text" name="to_host" value="<?=$to_host?>">
	<br>Login:<input type="text" name="to_login" value="<?=$to_login?>">
	<br>Password:<input type="text" name="to_password" value="<?=$to_password?>">
	<br>Mailbox:<input type="text" name="to_mbox" value="<?=$to_mbox?>"> 
	</td>
</tr></table>
<input type="submit" name="submit" value="Synchronize!">
</form>
</body>
</html>
<?
}
?>