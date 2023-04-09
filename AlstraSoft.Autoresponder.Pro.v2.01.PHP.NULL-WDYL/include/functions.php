<?
/* Nullified by WDYL-WTN */

// redirect page to another page relative to the current one
function redirect ($relative_url)
{
	header("Location: $relative_url");
	exit();
}

// afiseaza o pagina cu un mesaj de eroare
function error_page($error_message)
{
	$template = new Template("templates");
	$template->set_file("tpl_error", "error.tpl");
	$template->set_var("ERRORMESSAGE", $error_message);
	$template->parse("output", "tpl_error");
	$template->p("output");
	exit(); 
}

?>