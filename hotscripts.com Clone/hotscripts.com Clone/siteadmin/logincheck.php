<?
include "session.php";  
if (!isset($_SESSION["adminid"])  && !isset($_REQUEST["pg"])  )
{
 header("Location: ". "signinform.php?msg=" .urlencode("You must be logged to access this page!") );
 die();
}
?>