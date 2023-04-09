<?
/*
+----------------------------------------------------------------------+
| BasiliX - Copyright (C) 2000-2002 Murat Arslan <arslanm@basilix.org> |
+----------------------------------------------------------------------+
*/

// Simple session management for BasiliX
// -----------------------------------------------------------------------
// create a session for the user
function session_create($username, $domain_index, $password, $sessionid, &$custid) {
    global $sql, $REMOTE_HOST, $REMOTE_ADDR, $lng, $SESSID, $is_nocookie;
    global $user_set, $BSX_Lang;

    $domain = index2domain($domain_index);
    if($domain == false) my_exit();

    $data = $sql->session_checkuser($username, $domain);

    // basic encryption for the password which will be kept in the database
    $password2 = pwencrypt($password);
    $t = time();
    if(empty($data)) { // if no session entry has been found
        $password2 = addslashes($password2);
        $custid = $sql->session_create($username, $domain, $password2, $sessionid, $t,
			      $REMOTE_HOST, $REMOTE_ADDR);

        if($custid < 1) { 
		echo "Error creating a session!<br>\n";
		my_exit();
	}

        if(!$is_nocookie) SetCookie("BSX_SESSID", $sessionid);
        else $SESSID = $sessionid;
	
	// load settings
	settings_load($custid);

	$ret = array();
    } else { // we have an entry let us check it
        list($key, $val) = each($data);
	// Last connection values
        $ret["LastTime"] = $val["LASTTIME"];
	$ret["LastHost"] = $val["LASTHOST"];
        $ret["LastAddr"] = $val["LASTADDR"];
	// the customerid
	$custid = $val["CUSTOMERID"];
        $sql->session_update($custid, $password2, $sessionid, $t, $REMOTE_HOST, $REMOTE_ADDR);
        if(!$is_nocookie) SetCookie("BSX_SESSID", $sessionid);
        else $SESSID = $sessionid;

	settings_load($custid);
    }
    if(!$is_nocookie) {
      // let us know the sessionid for the further actions
      SetCookie("BSX_User", $username, $t + 63072000); // 2 years life time
      SetCookie("BSX_Domain", "$domain", $t + 63072000); // 2 years life time
    }
    return $ret;
}
?>
