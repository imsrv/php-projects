<?php
/* Nullified by WDYL-WTN */

	function GetMaxAffiliateLevel()
	{
		// determinam nivelul maxim actual
		$db = new DB_Sql;

		$query = "SELECT MAX(affiliatelevels_level) AS MAX_LEVEL
					FROM affiliatelevels ";
		$db->query($query);

		if ($db->num_rows() != 1)
			$max_level = 0;
		else
		{
			$db->next_record();
			$max_level = $db->f("MAX_LEVEL");
		}

		return $max_level;
	}

?>