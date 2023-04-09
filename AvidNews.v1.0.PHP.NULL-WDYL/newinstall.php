<?PHP
if($agree == "yes")
{
	header("Location: install.php");
}
if($agree == "no")
{
	echo("I'm sorry, but you must agree to the License Agreement, in order to use<br>AvidNews.<p>Please use your back button and accept the agreement.");
}
?>