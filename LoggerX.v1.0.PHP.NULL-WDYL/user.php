<?

  $username = $HTTP_POST_VARS["a"];
  $action = $HTTP_POST_VARS["action"];
  if ($action != "") {
  include ("./$action.php");
 }

?>
