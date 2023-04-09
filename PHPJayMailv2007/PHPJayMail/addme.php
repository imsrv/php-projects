<?php

//**THIS SCRIPT IS PART OF PHPJayMail v1.0.**

//**PLEASE READ THE README FIRST!**

?>

<html>
<head>
<title>PHPJayMail</title>
</head>
<body>
<center><font face="Arial">
<img src="images/logo.jpg" alt="PHPJayMail"><br>
<br>

<?php

//Create the conditional that checks for form submission
if (isset($_POST['submit'])) { //If the form has been submitted...
	require_once ('config.php'); //Include definitions, connect to MySQL and make the escape_data function
	
	//Validate the name
	if (eregi ("^[[:alpha:].' -]{2,40}$", stripslashes(trim($_POST['name'])))) { //If the last name (stripped of slashes and trimmed of white space) starts with a letter, can contain a dot, apostrophe, space or hyphen and is 2 to 40 chars in length then...
		$n = escape_data($_POST['name']); //Store last name to $n with my escape data function
	} else { //If the conditional returns false
		$n = FALSE; //Set the name variable to FALSE
		$message .= '<p><font color="red">Please enter a valid last name!</font></p>'; //Set the message
	}

	//Validate the email address
	if (eregi ("^[[:alnum:]][a-z0-9_.-]*@[a-z0-9.-]+\.[a-z]{2,4}$", stripslashes(trim($_POST['email'])))) { //If the email (stripped of slashes and trimmed of white space) starts with an alphanumeric char, can contain an underscore, dot or hyphen then has an at symbol, followed by alpha numeric chars or a dot or hyphen, the followed by a dot and letters 2 to 4 chars in length...
		$e = escape_data($_POST['email']); //Store email to $e with my escape data function
	} else { //If the conditional returns FALSE
		$e = FALSE; //Set the email variable to FALSE
		$message .= '<p><font color="red">Please enter a valid email address!</font></p>'; //Set the message
	}

	//If both entries are valid...
	if ($n && $e) { //If both the storage variables contain something (are not FALSE)...

		$query = "SELECT email FROM " . TBL_NAME . " WHERE email='$e'"; //Make the query to check for an existing email
		$result = @mysql_query ($query); //Execute the query

		if (mysql_num_rows($result) == 0) { //If the email does not already exist in the mailing list...
			
			$query = "INSERT INTO " . TBL_NAME . " (email, name) VALUES ('$e', '$n')"; //Make the query to insert the new record
			$result = @mysql_query ($query); //Execute the query

			//If the query was executed successfully (and $result returned TRUE)...
			if ($result) {
				$message .=  '<font color="green">You have been successfully added to our mailing list!</font><br>'; //Set the success message
			} else { //If the conditional returned FALSE
				$message .= '<p><font color="red">Sorry, you could not be registered due to a system error, please try again tomorrow.</font><br>'; //Set the failure message
			}
		
		} else { //If the email already exists...
			$message .= '<font color="red">Sorry, that email is already on the mailing list!</font><br>'; //Set the message
		}
		
	} else { //If either variable was not set...
		$message .= '<font color="red">Please try again.</font><br>'; //Set the message
	}
		
		mysql_close(); //Close the MySQL connection

} //End of the submit conditional
?>

<img src="images/addme.jpg" alt="Add Me!"><br>

<?php

//Show the message if there is one
if (isset($message)) {
	echo $message;
}

?>

<form action="addme.php" method="post">
	<table>
	<tr>
		<td><b>Name: </b></td>
		<td><input type="text" name="name" size="30" maxlength="40"></td>
	</tr>
	<tr>
		<td><b>Email: </b></td>
		<td><input type="text" name="email" size="30" maxlength="40"></td>
	</tr>
	<tr>
		<td colspan="2" align="center"><input type="submit" name="submit" value="Submit"></td>
	</tr>
	</table>
</form>
<br>
<font size="-2">PHPJayMail is © Copyright 2005 <a href="http://www.jay-designs.co.uk">Jay-Designs.co.uk</a>.</font>
</center>
</body>
</html>