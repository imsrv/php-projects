<?php
/* Nullified by WDYL-WTN */
	require("include/everything.php");
	
	session_register("UserID");

	$db = new DB_Sql;

	// determinam ce buton a fost apasat
	if (isset($btn_select) && $btn_select != "" && 
		isset($messageid) && $messageid != "")
	{
		// ** SELECT newsletter ** 
		redirect("newsletters_edit.php?selected=$messageid");
	}
	else
	if (isset($btn_remove) && $btn_remove != "" && 
		isset($messageid) && $messageid != "")
	{
		// ** REMOVE newsletter ** 
		$query = "DELETE FROM messages 
					WHERE 
						messages_user_id = '$UserID' AND 
						messages_id = '$messageid'";
		$db->query($query);

		redirect("newsletters_edit.php");
	}
	else
	if (isset($btn_disable_enable) && $btn_disable_enable != "" && 
		isset($messageid) && $messageid != "")
	{
		// ** DISABLE / ENABLE newsletter **
		$query = "UPDATE messages 
					SET messages_disabled = (messages_disabled + 1) % 2
					WHERE 
						messages_user_id = '$UserID' AND
						messages_id = '$messageid'";
		$db->query($query);

		redirect("newsletters_edit.php");
	}

	redirect("newsletters_edit.php");
?>