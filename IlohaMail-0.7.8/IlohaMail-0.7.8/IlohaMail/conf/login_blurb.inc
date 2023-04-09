<?
/********************************************************
	conf/defaults.inc
		
	PURPOSE:
		Provide central location for specifying text to be display below login form

********************************************************/

if ($v_stat=="Dev"){
?>
	This program is still under development.
	<br>Parts of it may break or change suddenly without warning.
	<br>USE AT YOUR OWN RISK
	<p>File bug reports <a href="http://ilohamail.org/imbuss/new.php">here</a>
	<p>View dev logs: 
	<a href="http://ilohamail.org/mail-dev/IlohaMail.log.txt" target=_blank>Text</a>|
	<a href="http://ilohamail.org/main.php?page=DevLog" target=_blank>HTML</a>
<?
}else{
	/*
	?>
	Visit <a href="http://ilohamail.org">IlohaMail.org</a> for more information on this program.
	<?
	*/
}

?>

