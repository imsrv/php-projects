<?php
/* Nullified by WDYL-WTN */
	function put_error()
	{
		exit("error! possible crack attemption <BR> <!--mazafaka:z :)-->");
	}

	function baga_fisierul()
	{
		$path_to_file = "/home/autoresp/public_html/download/autoresponder_install.zip";
		$filename_for_user = "autoresponder_installation.zip";

		Header ("Content-Type: application/octet-stream"); 
		Header ("Content-Length: " . filesize($path_to_file)); 
		Header ("Content-Disposition: attachment; filename=$filename_for_user"); 
		readfile ($path_to_file); 
	}

	if (isset($credit_card_processed) && isset($product_id) &&
		$credit_card_processed == "Y" && $product_id == "2")
	{
		// a venit de pe site-ul: 2checkout.com sau www.2checkout.com
		// se pare ca si a platit :)
		// sa-i dam si un link de download al kit-ului de instalare
		baga_fisierul();
	} 
	else 
	{
		// se pare ca nu vrea sa plateasca :)
		// nu-i dam nimic
		put_error();
	}
?>