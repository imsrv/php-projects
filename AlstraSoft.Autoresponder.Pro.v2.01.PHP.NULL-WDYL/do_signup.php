<?php
/* Nullified by WDYL-WTN */
	require("include/globals.php");
	require("include/db_mysql.php");
	require("include/template.php");
	require("include/functions.php");
	require("include/validation.php");
	
	$db = new DB_Sql;

	// obtinem variabilele din form
	AssumeIsNotEmpty($name, "You must specify a name");
	AssumeIsNotEmpty($username, "You must specify name");
	AssumeIsEmailAddress($email, "You must specify a valid email address");

	if (!isset($affiliate))
		$affiliate = "";
	if (trim($affiliate) == "")
		$affiliate = "NULL";
	else
		$affiliate = "'" . $affiliate . "'";

	$md5password = md5($password);

	// vedem daca nu avem deja un user cu username-ul dat
	$query = "SELECT * 
				FROM users
				WHERE users_username = '$username'";
	$db->query($query);
	
	if ($db->num_rows() != 0)
	{
		// exista deja
		error_page("{sitename} of this name already exists. Please chose another responder name.");
		redirect("index.php");
	}
	else
	{
		// nu exista inca un user cu username-ul dat
		// il cream

		$query = "INSERT INTO users (users_username, users_password, users_email, users_name, users_affiliate_boss,users_accounttype_id)
					VALUES ('$username', '$md5password', '$email', '$name', '$affiliate', '$paid')";
		$db->query($query);

		// logam automat userul nou adaugat
		$user_id = mysql_insert_id($db->link_id());
		$query="update users set users_general_id='$user_id' where users_id='$user_id'";
		//echo $query;
		$db->query($query);

		UpdateAffiliateEarnedAmmounts($user_id);

		session_start();
		session_register("UserID");
		$UserID = $user_id;
		
		// redirectare catre pagina principala (de lucru)
		redirect("login/controlpanel.php");
	}
?>

<?php
	function UpdateAffiliateEarnedAmmounts($new_user_id)
	{
		$db = new DB_Sql;

		// determinam numarul de nivele de afiliati
		$query = "SELECT COUNT(*) AS LEVEL_COUNT
					FROM affiliatelevels ";
		$db->query($query);
		$db->next_record();
		$nr_levels = $db->f("LEVEL_COUNT");

		if ($nr_levels < 1)
			return;

		// urcam in sus (in arborele de afiliati) 
		// pina dam de un user care nu are "affiliate boss"
		// sau pina nu se termina numarul de nivele de afiliati
		$i = 1;
		$finished = false;
		$current_user_id = $new_user_id;

		while (! $finished)
		{
			$boss_id = AffiliateBossForUser($current_user_id);

			if ($boss_id != "" && $i <= $nr_levels)
			{
				// dam bani la boss
				$level_price = PriceForAffiliateLevel($i);
				GiveMoney2User($boss_id, $level_price);

				// avansam in sus in arbore
				$current_user_id = $boss_id;
				$i++;
			}
			else
				$finished = true;
		}
	}

	function GiveMoney2User($user_id, $price)
	{
		$db = new DB_Sql;

		// dam $price bani la $user_id
		$query = "UPDATE users
					SET users_earned_ammount = users_earned_ammount + '$price'
					WHERE users_id = '$user_id' ";
		$db->query($query);
	}

	function AffiliateBossForUser($user_id)
	{
		$db = new DB_Sql;

		// determinam cine e "affiliate boss" pt $user_id
		$query = "SELECT users_affiliate_boss
					FROM users
					WHERE users_id = '$user_id' ";
		$db->query($query);

		if ($db->num_rows() == 0)
			return ""; // nu ar trebui sa se intimple

		$db->next_record();
		return $db->f("users_affiliate_boss");
	}

	function PriceForAffiliateLevel($level_id)
	{
		$db = new DB_Sql;

		// determinam cati bani se dau pt afiliere de nivel $i
		$query = "SELECT affiliatelevels_price
					FROM affiliatelevels
					WHERE affiliatelevels_level = '$level_id' ";
		$db->query($query);

		if ($db->num_rows() != 1)
			return 0; // nu ar trebui sa se intimple

		$db->next_record();
		return $db->f("affiliatelevels_price");
	}
?>