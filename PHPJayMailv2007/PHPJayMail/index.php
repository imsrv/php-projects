<?php

/* ------------------------------------------ *
 * -------------[  PHPJayMail ]-------------- *
 * -------------[  version1.0 ]-------------- *
 * ------------------------------------------ *
 * All aspects of this script were designed   *
 * and created by Jay Shields. You can email  *
 * me with any questions at                   *
 * jay@jay-designs.co.uk. I would also be     *
 * grateful if you paid a visit to my website *
 * at http://www.jay-designs.co.uk. If you    *
 * would like to use my script please leave   *
 * the copyright footer and logo intact as    *
 * it is copyright Jay-Designs.co.uk 2005.    *
 * ------------------------------------------ *
 *    PLEASE READ THE README FOR MORE INFO    *
 * ------------------------------------------ *
 *    Thanks, and have fun using my script!   *
 * ------------------------------------------ */

//**DO NOT EDIT ANYTHING IN THIS FILE UNLESS YOU KNOW WHAT YOU ARE DOING!**

//Include the definitions, connect to MySQL and define my escape_data function
require_once ('config.php');

//Include the HTML header
include ('includes/header.html');

//***LOGIN***

//Start the main login conditional
if ((!isset($_SESSION['username'])) || (!isset($_SESSION['password']))) { //If the username or password are not set...
	
	if (isset($_POST['login'])) { //If the login button was clicked...

		if (($_POST['username'] == PJMUSER) && ($_POST['password'] == PJMPASS)) { //If the username and password are correct...

			//Register the values of the session
			$_SESSION['username'] = $_POST['username'];
			$_SESSION['password'] = $_POST['password'];

			//Redirect the user
			header ("Location: http://" . URL . "/index.php");
		
		} else { //If the username or password are incorrect...

			$message = "<font color=\"red\">Sorry, your username and password were incorrect.<br>Please try again!</font><br>"; //Set a failure message

		}

	}

	//Display the title image
	echo "<img src=\"images/login.jpg\" alt=\"Login!\"><br>";

	//Display the failure message if there is one
	if (isset($message)) { //If the message is set...
		echo $message; //Print it!
	}

	//Start the login form/table
	echo '<form action="index.php" method="post">';
	echo '<table border="0">';
	echo '<tr>';
	echo '<td><b>Username: </b></td>';
	echo '<td><input type="text" name="username" size="20" value="'; 
	if (isset($_POST['username'])) { //If a username has already been entered...
			echo $_POST['username']; //Fill the box in automatically!
	}
	echo '"></td>';
	echo '</tr>';
	echo '<tr>';
	echo '<td><b>Password: </b></td>';
	echo '<td><input type="password" name="password" size="20"></td>';
	echo '</tr>';
	echo '<tr>';
	echo '<td colspan="2" align="center"><input type="submit" name="login" value="Login"></td>';
	echo '</tr>';
	echo '</table>';
	echo '</form>';

} else { //If the sessions are set run the rest of the script for the logged in user...

//*********

//***LOGOUT***

if ($_GET['page'] == "logout") {
	
	//if (isset($_SESSION['username'])) {
		//Log the user out
		$_SESSION = array(); //Destroy the variables in the $_SESSION array
		session_destroy(); //Destroy the session itself
		setcookie (session_name(), '', time()-300, '/', '', 0); //Destroy the cookie
	//}

	//Show the image header
	echo '<img src="images/logout.jpg" alt="Logout!"><br><br>';

	//Show the success message
	echo 'You are now logged out.<br><br>';

}

//*********

//***ERROR PAGE***

if ($_GET['page'] != "" && $_GET['page'] != "sendmail" && $_GET['page'] != "recipients" && $_GET['page'] != "logout") {
	echo "<font color=\"red\">You are trying to access a page which doesn't exist!</font>";
}

//*********

//***HOME***
if ($_GET['page'] == "") {

	//Print the content
	echo '<img src="images/welcome.jpg" alt="Welcome!"><br><br>';
	echo 'Please select a page from the list below:<br>';
	echo '<a href="index.php?page=recipients">Recipients</a><br>';
	echo '<a href="index.php?page=sendmail">Send Mail</a><br>';

}
//*********

//***SENDMAIL***

if ($_GET['page'] == "sendmail") {
	
	//Start the if send conditional
	if (isset($_POST['send'])) {
		
		//Fetch the mailing list
		$query = "SELECT * FROM " . TBL_NAME; //Build the query to select all the info
		$result = @mysql_query ($query); //Execute the query
		
		//Initialize an approved check variable and an email amount variable
		$approvedchk = "wrong";
		$emailamount = 0;

		//Send the mail
		while ($row = mysql_fetch_array ($result, MYSQL_NUM)) { //while there are records being fetched from the table
			if ($row['3'] == 'Y') { //if the user has been approved

				//Set the approved check variable to right
				$approvedchk = "right";
				
				//Set the first 2 mail params
				$to = $row['1']; //Store the users email in the to parameter
				$subject = $_POST['subject']; //Set the subject from the form input
				
				//Make the headers param
				if ($_POST['templates'] == "None") { //If no template is being used...
					echo ""; //Do nothing
				} else { //If a template is being used
					$headers = 'MIME-Version: 1.0' . "\r\n"; //Set the headers to enable HTML email
					$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				}

				$from = "From: " . NAME . ' <' . EMAILADD . '>' . "\r\n"; //Make the from section of the headers param
				if (REPLYNAME == '' && REPLYEMAILADD == '') { //If there isnt a replyname or replyemail set...
					echo ""; //Do nothing
				} else { //If there is a reply name or a replay email set
					$replyto = "Reply-To: " . REPLYNAME . ' <' . REPLYEMAILADD . '>' . "\r\n"; //Make the reply to section of the headers param
				}
				$headers .= $from . $replyto; //combine the from and reply to sections and add them to the headers param
				
				//Variables which can be used in templates
				$toname = $row['2']; //Set the persons name
				$date = date("d.m.y"); //Set the current date

				//Build the message
				if ($_POST['templates'] == "none") { //If no template is being used...
					$message = nl2br($_POST['newsletterbody']); //Just send the newsletter body
				} elseif ($_POST['templates'] == "WrightandShields") { //If the WrightandShields template is being used...
					$message = file_get_contents ('templates/' . $_POST['templates'] . '/header1.html'); //Send the top of the header
					$message .= $date; //Then the date
					$message .= file_get_contents ('templates/' . $_POST['templates'] . '/header2.html'); //Then the middle of the header
					$message .= $toname; //Then the name
					$message .= file_get_contents ('templates/' . $_POST['templates'] . '/header3.html'); //Then the bottom of the header
					$message .= $_POST['newsletterbody']; //Then the newsletter body
					$message .= file_get_contents ('templates/' . $_POST['templates'] . '/footer.html'); //Then the footer
				} else { //If any other template is being used...
					$message = file_get_contents ('templates/' . $_POST['templates'] . '/header.html'); //Send the header
					$message .= $_POST['newsletterbody']; //Then the newsletter body
					$message .= file_get_contents ('templates/' . $_POST['templates'] . '/footer.html'); //Then the footer
				}
				
				//Send the email
				mail ($to, $subject, $message, $headers);

				//Add to the email amount variable
				$emailamount++;

				//Set a success message
				$success = "<font color=\"green\">You have successfully sent <b>" . $emailamount . "</b> emails!</font><br>";

			}
		}

	} //End the if send conditional

	//Print the title
	echo '<img src="images/sendmail.jpg" alt="Send Mail!"><br>';

	//Show the messages if there are any...
	if ($approvedchk == "wrong") {
		echo '<font color="red">No emails were sent because no one on your mailing list has been approved!<br>Please go to the <a href="index.php?page=recipients">Recipients page</a> and approve some people!</font><br>';
	}
	
	if (isset($success)) {
		echo $success;
	}

	//Get the templates
	$dir = "templates/";
	
	//Start the form
	echo '<form action="index.php?page=sendmail" method="post">';

	//Start the table
	echo '<table border="0">';

	//Start the drop down selection box
	echo '<tr><td><b>Select a template: </b></td>';
	echo '<td align="left"><select align="left" name="templates">';
	echo '<option value="none">None</option>';

	// Open a known directory, and proceed to read its contents
	if (is_dir($dir)) {
	   if ($dh = opendir($dir)) {
		   while (($file = readdir($dh)) !== false) {
			    if ($file == ".." || $file == ".") {
					echo "";
				} else {
					echo "<option value=\"$file\">$file</option>\n";
				}
		   }
		   echo '</select></td></tr>';
		   closedir($dh);
	   }
	}
	
	//Show the subject entry input box
	echo '<tr><td><b>Subject: </b></td><td align="left"><input align="left" type="text" name="subject" size="20" maxlength="30"></td>';

	//Show the main email input
	echo '<tr><td colspan="2"><b>Newsletter Body: </b></td></tr>';
	echo '<tr><td colspan="2" align="left"><textarea cols="60" rows="20" name="newsletterbody"></textarea></td></tr>';

	//Show the Send button and finish the form
	echo '<tr><td colspan="2" align="center"><input type="submit" name="send" value="Send!"></td></tr>';
	echo '</table>';
	echo '</form>';

}

//*********

//***RECIPIENTS***
if ($_GET['page'] == "recipients") {

	//If records need to be changed...
	if ($_POST['delete'] || $_POST['approve'] || $_POST['unapprove']) {
		
		if (isset($_POST['box'])) { //If a checkbox has been ticked...
			
			//Make and set the values of the boxArray
			$boxArray = array();
			$boxArray = $_POST['box'];

			foreach ($boxArray as $x) { //For each value in the boxArray
				
				if ($_POST['delete']) { //If the user wants to delete a record...
					$query = "DELETE FROM " . TBL_NAME . " WHERE user_id = " . $x; //Make a query to delete the record
					$result = @mysql_query ($query); //Execute the query
					$message = "<font color=\"green\">You successfully deleted the record(s)!</font><br>"; //Set the message
				}

				if ($_POST['approve']) { //If the user wants to approve a record...
					$query = "UPDATE " . TBL_NAME . " SET approved = 'Y' WHERE user_id = " . $x; //Make a query to approve a record
					$result = @mysql_query ($query); //Execute the query
					$message = "<font color=\"green\">You successfully approved the record(s)!</font><br>"; //Set the message
				}

				if ($_POST['unapprove']) { //If the user wants to unapprove a record...
					$query = "UPDATE " . TBL_NAME . " SET approved = 'N' WHERE user_id = " . $x; //Make a query to unapprove a record
					$result = @mysql_query ($query); //Execute the query
					$message = "<font color=\"green\">You successfully unapproved the record(s)!</font><br>"; //Set the message
				}

			}

		}

	} //End of the change records conditional

	//Print the title
	echo '<img src="images/recipients.jpg" alt="Recipients!">';

	//Print the message if there is one
	if (isset($message)) {
		echo '<br><br>' . $message;
	}

	//Fetch the mailing list
	$query = "SELECT * FROM " . TBL_NAME . " ORDER BY name ASC";
	$result = @mysql_query ($query);

	if ($row = mysql_fetch_array ($result)) { //If no records are in the table make an empty one...
		echo "";
	} else {
		echo '<form action="index.php?page=recipients" method="post">';
		echo '<table border="1" bordercolor="black">';
		echo '<tr bgcolor="black">';
		echo '<td><b><font color="white">Name</font></b></td><td><b><font color="white">Email</font></b></td><td><b><font color="white">Approved?</font></b></td><td><b><font color="white">Select</font></b></td>';
		echo '</tr>';
		echo '<tr>';
		echo '<td colspan="4" align="center">';
		echo 'There are no records to display!';
		echo '</td>';
		echo '</tr>';
	}

	//Initialise the $first variable
	$first = 1;
	
	//Print the mailing list
	while ($row = mysql_fetch_array ($result, MYSQL_NUM)) {
		if ($first) {
			echo '<form action="index.php?page=recipients" method="post">';
			echo '<table border="1" bordercolor="black">';
			echo '<tr bgcolor="black">';
			echo '<td><b><font color="white">Name</font></b></td><td><b><font color="white">Email</font></b></td><td><b><font color="white">Approved?</font></b></td><td><b><font color="white">Select</font></b></td>';
			echo '</tr>';
		}
		echo '<tr';
		if ($row['3'] == "N") { //If the record is not approved...
			echo ' bgcolor="#FF6666"'; //Make the background of the row red
		} elseif ($row['3'] == "Y") { //If the record is approved...
			echo ' bgcolor="white"'; //Make the background of the row white
		}
		echo '>';
		echo '<td>' . $row['2'] . '</td>';
		echo '<td>' . $row['1'] . '</td>';
		echo '<td align="center">' . $row['3'] . '</td>';
		echo '<td align="center"><input type="checkbox" name="box[' . $row[0] . ']" value="' . $row[0] . '">';
		echo '</tr>';
		$first = 0;
	}
	echo '<tr>';
	echo '<td colspan="4" align="center">With selected: <input type="submit" name="delete" value="Delete"> <input type="submit" name="approve" value="Approve"> <input type="submit" name="unapprove" value="Unapprove"></td>';
	echo '</tr>';
	echo '</form>';
	echo '</table>';
	echo '<a href="http://' . URL . '/addme.php">Add a recipient manually here.</a>';

} 
//*********

//Close the MySQL connection
mysql_close();

//Include the HTML footer
include ('includes/footer.html');

} //End the login conditional

?>