<?PHP
  function Clean_Variable($szCleanVar, $szCleanType) { global $CONN; global $Username; global $CONFIG; if ($szCleanType == "all") { $szCleanVar = strip_tags($szCleanVar); $szCleanVar = str_replace(" ","", $szCleanVar); $szCleanVar = strtolower("$szCleanVar"); if ($szCleanVar == "" or !$szCleanVar) { Remove_User($Username); Error("ERROR_NoData"); } if (!preg_match("/^[\w\d]+$/",$szCleanVar)) { Remove_User($Username); Error("ERROR_BadData"); } } elseif ($szCleanType == "html") { $szCleanVar = strip_tags($szCleanVar); } elseif ($szCleanType == "lowercase") { $szCleanVar = strtolower("$szCleanVar"); } elseif ($szCleanType == "spaces") { $szCleanVar = str_replace(" ","", $szCleanVar); } elseif ($szCleanType == "chars") { if (!preg_match("/^[\w\d]+$/",$szCleanVar)) { Remove_User($Username); Error("ERROR_BadData"); } } elseif ($szCleanType == "empty") { if ($szCleanVar == "" or !$szCleanVar) { Remove_User($Username); Error("ERROR_NoData"); } } return($szCleanVar); } ?>
