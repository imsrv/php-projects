<?php
/* Nullified by WDYL-WTN */
	// verificam daca avem pornita vreo sesiune
	// in caz negativ, redirectam spre pagina de login
	session_register("Administrator");
	
	if (empty($Administrator))
		redirect("index.php");	
?>