<?php
/* Nullified by WDYL-WTN */
	require("../include/template.php");
	
	$template = new Template("templates/index");
	$template->set_file("tpl_index", "index.tpl");
	$template->parse("output", "tpl_index");
	$template->p("output");
?>