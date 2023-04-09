<?php
/* Nullified by WDYL-WTN */
	require("include/everything.php");
	require("include/affiliate_functions.php");
	
	$db = new DB_Sql;

	// determinam care buton de submit s-a apasat

	if (isset($modify))
	{
		// ** trebuie modificate preturile
		
		foreach ($level_price as $level => $price)
		{
			$query = "UPDATE affiliatelevels 
						SET affiliatelevels_price = '$price'
						WHERE affiliatelevels_level = '$level' ";
			$db->query($query);
		}
	}

	if (isset($add))
	{
		// ** trebuie adaugat un nivel (la coada)

		$new_level = GetMaxAffiliateLevel() + 1;

		$query = "INSERT INTO affiliatelevels 
					(affiliatelevels_level, affiliatelevels_price)
					VALUES
					('$new_level', '0.00') ";
		$db->query($query);
	}

	if (isset($remove))
	{
		// ** trebuie sters nivelul de ordin maxim
		$max_level = GetMaxAffiliateLevel();
		
		$query = "DELETE FROM affiliatelevels
					WHERE affiliatelevels_level = '$max_level' ";
		$db->query($query);
	}

	redirect("edit_settings.php");
?>
