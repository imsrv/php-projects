<?PHP
  function Smiles($SmileMessage) { global $CONFIG; global $STATUS; if ($CONFIG[Chat_Smiles] != "true") { return($SmileMessage); } if ($STATUS[Registered] == "yes" and $STATUS[Smiles] == "no") { return($SmileMessage); } reset($CONFIG[All_Smiles]); while (list($ArrayPointer, $SmileType) = each($CONFIG[All_Smiles])) { if (eregi(":$SmileType:", $SmileMessage)) { $SmileMessage = eregi_replace(":$SmileType:", "<IMG SRC=\"$CONFIG[MWCHAT_Images]/smiles/$SmileType.gif\">", $SmileMessage); } if (eregi("\[$SmileType\]", $SmileMessage)) { $SmileMessage = eregi_replace("\[$SmileType\]", ":$SmileType:", $SmileMessage); } } reset($CONFIG[All_Lingo]); while (list($ArrayPointer, $SmileType) = each($CONFIG[All_Lingo])) { if (ereg("$ArrayPointer", $SmileMessage)) { if (ereg("\[$ArrayPointer\]", $SmileMessage)) { $ArrayPointerDisplay = stripslashes($ArrayPointer); $SmileMessage = ereg_replace("\[$ArrayPointer\]", "$ArrayPointerDisplay", $SmileMessage); } else { $SmileMessage = ereg_replace("$ArrayPointer", "<IMG SRC=\"$CONFIG[MWCHAT_Images]/smiles/$SmileType.gif\">", $SmileMessage); } } } return($SmileMessage); } ?>
