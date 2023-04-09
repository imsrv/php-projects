<?php

	function checkLogin()
	{
		global $HTTP_SESSION_VARS;
		if($HTTP_SESSION_VARS["id"] == "")
			header("location: index.php");
	}

	function getMenu($menu)
	{
		echo '<table width="600" cellpadding="2" cellspacing="2" border="0">';
		if($menu == 'calendar')
			$bgcolor = 'bgcolor="orange"';
		else
			$bgcolor = 'bgcolor="#eeeeee"';
		echo '<tr><td '.$bgcolor.' class="link" align="center" width="20%"><a href="admin_area.php">Calendar</a></td>';
		if($menu == 'user')
			$bgcolor = 'bgcolor="orange"';
		else
			$bgcolor = 'bgcolor="#eeeeee"';
		echo '<td '.$bgcolor.' class="link" align="center" width="20%"><a href="user.php">Users</a></td>';
		if($menu == 'config')
			$bgcolor = 'bgcolor="orange"';
		else
			$bgcolor = 'bgcolor="#eeeeee"';
		echo '<td '.$bgcolor.' class="link" align="center" width="20%"><a href="config.php">Configuration</a></td>';
		if($menu == 'queue')
			$bgcolor = 'bgcolor="orange"';
		else
			$bgcolor = 'bgcolor="#eeeeee"';
		echo '<td '.$bgcolor.' class="link" align="center" width="20%"><a href="queue.php">Event Queue</a></td>';
		$bgcolor = 'bgcolor="#eeeeee"';
		echo '<td '.$bgcolor.' class="link" align="center"><a href="index.php?action=logout">Logout</a></td></tr>';
		echo '</table>';
	}

	function listUsers($rights, $id)
	{
		$output = "<table width='600' cellpadding='1' cellspacing='1' border='0' align='center'>";
		$output .= "<tr><td class='headline' align='center' bgcolor='#eeeeee'>#</td>";
		$output .= "<td align='center' class='title' bgcolor='#eeeeee'>Full Name</td>";
		$output .= "<td align='center' class='title' bgcolor='#eeeeee'>Email</td><td align='center' class='title' bgcolor='#eeeeee'>User Type</td><td align='center' class='title' bgcolor='#eeeeee'>Actions</td></tr>";

		if($rights == 1)
			$result = mysql_query("SELECT user_id, fullname, email, user_right FROM calendar_user ORDER BY fullname");
		else
			$result = mysql_query("SELECT user_id, fullname, email, user_right FROM calendar_user WHERE user_id = $id");
		
		if(mysql_num_rows($result) > 0)
		{
			$count = 0;
			while($row = mysql_fetch_array($result))
			{
				$count++;
				if($count % 2 == 0)
					$bgcolor = "white";
				else
					$bgcolor = "#eeeeee";
				$output .= "<tr><td class='data'>$count</td>";
				$output .= "<td class='data'>".$row["fullname"]."</a></td><td class='data'><a href='mailto:".$row["email"]."'>".$row["email"]."</a></td>";
				if($row["user_right"] == 1)
					$output .= "<td class='data'>Admin</td>";
				else if($row["user_right"] == 0)
					$output .= "<td class='data'>Moderator</td>";
				$output .= "<td class='data'><a href='#' onClick='javascript: window.open(\"viewUser.php?item=".$row["user_id"]."\",\"\",\"scrollbars=yes, resizable=yes, width=400, height=400\");return false;'>View</a>&nbsp;|&nbsp;<a href='#' onClick='javascript: window.open(\"editUser.php?item=".$row["user_id"]."\",\"\",\"scrollbars=yes, resizable=yes,width=400, height=400\");return false;'>Edit</a>&nbsp;";
				if($rights == 1 && $row["user_right"] == "0")
					$output .= "|&nbsp;<a href='user.php?delete=".$row["user_id"]."'>Delete</a></td></tr>";
				else
					$output .= "|&nbsp;Delete</td></tr>";
			}
		}
		else
		{
			$output .= "<tr><td colspan='5' align='center' class='nodata'>-- No Item in Database -- </td></tr><tr><td colspan='5'>&nbsp;</td></tr>";
		}
		$output .= "<tr><td colspan='5'>&nbsp;</td></tr>";
		if($rights == 1)
			$output .= "<tr><td colspan='5' align='right'><form><input type='button' value='Add User' onClick=\"javascript: window.open('addUser.php','','width=400,height=400,scrollbars=yes, resizable=yes');return false;\"></form></td></tr>";
		$output .= "</table>";
		return $output;
	}

	function listConfigs($rights, $id)
	{
		if($rights == 1)
		{
			$output = "<form action='config.php' method='post'>";
		}
		$output .= '<table width="300" cellpadding="2" cellspacing="2" border="0">';
		$output .= "<tr><td class='title' align='center' bgcolor='#eeeeee'>Configuration</td>";
		$output .= "<td align='center' class='title' bgcolor='#eeeeee'>Setting</td>";
		$output .= "</tr>";

		$result = mysql_query("SELECT * FROM calendar_config");
		$row = mysql_fetch_array($result);

		$output .= "<tr><td class='data'>Enable Public Use</td>";
		$output .= "<td align='center' class='data'>";
		if($rights == 1)
		{
			$output .= "<select name='private' class='data'>";
			$output .= "<option value='1'";
			if($row["private_flag"] == 1)
				$output .= " selected>No";
			else
				$output .= ">No";
			$output .= "<option value='0'";
			if($row["private_flag"] == 0)
				$output .= " selected>Yes";
			else
				$output .= ">Yes";
			$output .= "</select>";
		}
		else
		{
			if($row["private_flag"] == 1)
				$output .= "No";
			else
				$output .= "Yes";
		}
		$output .= "</td></tr>";

		$output .= "<tr><td class='data'>Enable Event Queue</td>";
		$output .= "<td align='center' class='data'>";
		if($rights == 1)
		{
			$output .= "<select name='queue' class='data'>";
			$output .= "<option value='0'";
			if($row["queue_flag"] == 0)
				$output .= " selected>No";
			else
				$output .= ">No";
			$output .= "<option value='1'";
			if($row["queue_flag"] == 1)
				$output .= " selected>Yes";
			else
				$output .= ">Yes";
			$output .= "</select>";
		}
		else
		{
			if($row["queue_flag"] == 0)
				$output .= "No";
			else
				$output .= "Yes";
		}
		$output .= "</td></tr>";

		$output .= "<tr><td class='data'>Enable HTML Tags</td>";
		$output .= "<td align='center' class='data'>";
		if($rights == 1)
		{
			$output .= "<select name='html' class='data'>";
			$output .= "<option value='0'";
			if($row["html_flag"] == 0)
				$output .= " selected>No";
			else
				$output .= ">No";
			$output .= "<option value='1'";
			if($row["html_flag"] == 1)
				$output .= " selected>Yes";
			else
				$output .= ">Yes";
			$output .= "</select>";
		}
		else
		{
			if($row["html_flag"] == 0)
				$output .= "No";
			else
				$output .= "Yes";
		}
		$output .= "</td></tr>";

		$output .= "<!--<tr><td class='data'>Enable Link Tags Only</td>";
		$output .= "<td align='center' class='data'>";
		if($rights == 1)
		{
			$output .= "<select name='link' class='data'>";
			$output .= "<option value='0'";
			if($row["link_flag"] == 0)
				$output .= " selected>No";
			else
				$output .= ">No";
			$output .= "<option value='1'";
			if($row["link_flag"] == 1)
				$output .= " selected>Yes";
			else
				$output .= ">Yes";
			$output .= "</select>";
		}
		else
		{
			if($row["link_flag"] == 0)
				$output .= "No";
			else
				$output .= "Yes";
		}
		$output .= "</td></tr>-->";
		if($rights == 1)
		{
			$output .= "<tr><td colspan='2' align='right'><input type='submit' name='save' value='Save' class='data'></td></tr>";
		}
		$output .= "</table>";
		if($rights == 1)
		{
			$output .= "</form>";
		}
		return $output;
	}

	function listQueue($rights, $id)
	{
		$output = "<table width='600' cellpadding='1' cellspacing='1' border='0' align='center'>";
		$output .= "<tr><td class='headline' align='center' bgcolor='#eeeeee'>#</td>";
		$output .= "<td align='center' class='title' bgcolor='#eeeeee'>Event Subject</td>";
		$output .= "<td align='center' class='title' bgcolor='#eeeeee'>Actions</td></tr>";
		$result = mysql_query("SELECT event_id, subject FROM calendar_event WHERE queue_flag = 1");
		if(mysql_num_rows($result) > 0)
		{
			$count = 0;
			while($row = mysql_fetch_array($result))
			{
				$count++;
				if($count % 2 == 0)
					$bgcolor = "white";
				else
					$bgcolor = "#eeeeee";
				$output .= "<tr><td class='data'>$count</td>";
				$output .= "<td class='data'>".$row["subject"]."</a></td>";
				$output .= "<td class='data'><a href='#' onClick='javascript: window.open(\"../viewEvent.php?e=".$row["event_id"]."\",\"\",\"scrollbars=yes, resizable=yes, width=400, height=400\");return false;'>View</a>&nbsp;|&nbsp;<a href='queue.php?update=1&item=".$row["event_id"]."'>Approve</a>&nbsp;";
				$output .= "|&nbsp;<a href='queue.php?delete=".$row["event_id"]."'>Delete</a></td></tr>";
				
			}
		}
		else
		{
			$output .= "<tr><td colspan='3' align='center' class='nodata'>-- Queue is empty -- </td></tr><tr><td colspan='3'>&nbsp;</td></tr>";
		}
		$output .= "</table>";
		return $output;
	}

	function isCalendarPublic()
	{
		$result = mysql_query("SELECT private_flag FROM calendar_config");
		$row = mysql_fetch_array($result);
		if($row[0] == "0")
			return true;
		else
			return false;
	}

	function isHTMLEnabled()
	{
		$result = mysql_query("SELECT html_flag FROM calendar_config");
		$row = mysql_fetch_array($result);
		if($row[0] == "0")
			return false;
		else
			return true;
	}

	function isQueueEnabled()
	{
		$result = mysql_query("SELECT queue_flag FROM calendar_config");
		$row = mysql_fetch_array($result);
		return $row[0];
	}
	
?>