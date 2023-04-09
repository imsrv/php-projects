<?php
if ($HTTP_SERVER_VARS["HTTP_X_FORWARDED_FOR"] != ""){
      $IP = $HTTP_SERVER_VARS["HTTP_X_FORWARDED_FOR"];
      $proxy = $HTTP_SERVER_VARS["REMOTE_ADDR"];
      $host = @gethostbyaddr($HTTP_SERVER_VARS["HTTP_X_FORWARDED_FOR"]);
}
else {
      $IP = $HTTP_SERVER_VARS['REMOTE_ADDR'];
      $host = @gethostbyaddr($HTTP_SERVER_VARS['REMOTE_ADDR']);
}
$iplist = split(",",trim(IP_FILTER_LIST));
for ($i=0; $i<sizeof($iplist); $i++) {
    if(trim($iplist[$i]) == $IP) {
        echo TEXT_BANNED_IP_ADDRESS;
        bx_exit();
        break;
    }
}
?>