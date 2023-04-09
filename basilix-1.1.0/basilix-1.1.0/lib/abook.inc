<?php
/*
+----------------------------------------------------------------------+
| BasiliX - Copyright (C) 2000-2002 Murat Arslan <arslanm@basilix.org> |
+----------------------------------------------------------------------+
*/

// -----------------------------------------------------------------------

// --
// IF YOU UPGRADE FROM v0.9.7 set the following:
$old_dbhost = "localhost";
$old_dbuser = "basilix";
$old_dbpass = "bsxpass";
// --

// get the nickname of the user
function abook_uid2nick($uid) {
    global $sql, $customerID;
    $sql->open();
    $nick = $sql->addr_uid2nick($customerID, $uid);
    $sql->close();
    return $nick;
}

// add a new user to the addressbook
function abook_addentry() {
    global $customerID, $sql, $lng;
    global $addItem, $err_msg, $info_msg, $BODY_ONLOAD;
    global $add_nick, $add_name, $add_email, $add_tel, $add_fax, $add_note;

    $add_name = ereg_replace(",", "", $add_name);

    if(empty($add_nick) || empty($add_email)) {
       if(empty($add_nick)) $BODY_ONLOAD = "onLoad='document.addrAddEdt.add_nick.focus();'";
       else if(empty($add_email)) $BODY_ONLOAD = "onLoad='document.addrAddEdt.add_email.focus();'";
       $err_msg = $lng->p(313);
       return;
    }
    $sql->open();
    $rc = $sql->addr_add($customerID, $add_nick, $add_email, $add_name, $add_tel, $add_fax, $add_note);
    $sql->close();
    if($rc == false) $err_msg = $lng->p(314);
    else {
       $info_msg = $lng->p(315);
       $addItem = "";
    }
}

// modify user
function abook_modentry() {
    global $customerID, $sql, $lng;
    global $modItem, $addrID;
    global $err_msg, $info_msg, $BODY_ONLOAD;
    global $add_nick, $add_name, $add_email, $add_tel, $add_fax, $add_note;


    $add_name = ereg_replace(",", "", $add_name);
    if(empty($add_nick) || empty($add_email) || !$addrID) {
       if(empty($add_nick)) $BODY_ONLOAD = "onLoad='document.addrAddEdt.add_nick.focus();'";
       else if(empty($add_email)) $BODY_ONLOAD = "onLoad='document.addrAddEdt.add_email.focus();'";
       $err_msg = $lng->p(313);
       $modItem = "evetlutfen";
       return;
    }
    $sql->open();
    $rc = $sql->addr_update($customerID, $addrID, $add_nick, $add_email, $add_name, $add_tel, $add_fax, $add_note);
    $sql->close();
    if($rc == false) $err_msg = $lng->p(319);
    else {
       $info_msg = $lng->p(320);
       $modItem = "";
    }
}

function abook_moditem() {
    global $customerID, $sql, $lng;
    global $modItem, $addrID;
    global $err_msg, $info_msg;
    global $add_nick, $add_name, $add_email, $add_tel, $add_fax, $add_note;

    if(!$addrID) {
       $err_msg = $lng->p(318);
       $modItem = "";
    } else {
       $sql->open();
       $addr_values = $sql->addr_getitem($customerID, $addrID);
       $sql->close();
       list($a_key, $a_val) = each($addr_values);
       $add_nick = htmlspecialchars($a_val["NICKNAME"]);
       $add_name = htmlspecialchars($a_val["NAME"]);
       $add_email = htmlspecialchars($a_val["EMAIL"]);
       $add_tel = htmlspecialchars($a_val["TELEPHONE"]);
       $add_fax = htmlspecialchars($a_val["FAX"]);
       $add_note = htmlspecialchars($a_val["NOTE"]);
    }
}
    
// delete a user from the addressbook
function abook_delitem() {
    global $customerID, $sql, $lng;
    global $delItem, $addrID, $confirmed;
    global $err_msg, $info_msg;
    global $del_nick, $del_groups;

    if(!$addrID) {
       $err_msg = $lng->p(321);
       $delItem = "";
    } else {
       $sql->open();
       if($confirmed) {
          $rc = $sql->addr_delitem($customerID, $addrID);
          if($rc == false) $err_msg = $lng->p(323);
          else {
             $info_msg = $lng->p(324);
             $delItem = "";
          }
       } else {
          $del_nick_tmp = $sql->addr_getitem($customerID, $addrID);
          $del_nick = $del_nick_tmp[0]["NICKNAME"];
          $del_groups = $sql->addr_uid2grps($customerID, $addrID);
       }
       $sql->close();
    }
}

// show the groups that a contact is a member of
function abook_showgrps($id) {
    global $customerID, $sql;

    $sql->open();
    $item_showgrps = $sql->addr_uid2grps($customerID, $id);
    if(empty($item_showgrps)) {
	$sql->close();
	return;
    }

    $glue = "";
    $str = "";
    for($i = 0 ; $i < count($item_showgrps) ; $i++) {
	$str .= $glue . $item_showgrps[$i]["GRPNAME"];
	$glue = ", ";
    }
    echo $str;
    $sql->close();
}

// show the members of a group
function abook_grpshowmembers() {
    global $customerID, $sql, $lng;
    global $grpShowMembers, $grpID;
    global $err_msg, $BODY_ONLOAD;
    global $grp_members, $grp_basename;

    if(!$grpID) {
       $err_msg = $lng->p(338);
       $grpShowMembers = "";
    } else {
       $sql->open();
       $grp_members = $sql->addr_grpmem($customerID, $grpID);
       $grp_basename = $sql->addr_getgrpname($customerID, $grpID);
       $sql->close();
    }
}

// add a new user to a group
function abook_grpaddmember() {
    global $customerID, $sql, $lng;
    global $grpShowMembers, $aaddrID, $grpID;
    global $err_msg, $info_msg, $BODY_ONLOAD;

    if(!$aaddrID) {
       $err_msg = $lng->p(342);
       $BODY_ONLOAD = "onLoad='document.grpEdit.aaddrID.focus();'";
    } else {
       $sql->open();
       $rc = $sql->addr_grpaddmem($customerID, $grpID, $aaddrID);
       $sql->close();
       if($rc == false) $err_msg = $lng->p(343);
       else {
         $info_msg = $lng->p(344);
         $grpShowMembers = "";
       }
    }
}

// update the memberlist (via javascript)
function abook_grpupdatemembers() {
    global $customerID, $sql, $grpID, $memberlist, $grpShowMembers, $info_msg, $lng;
   
    $sql->open();
    $rc = $sql->addr_update_memberlist($customerID, $grpID, $memberlist);
    $sql->close();
    $grpShowMembers = "";
    $info_msg = $lng->p(362);
    return $rc;
}

// delete an user from a group
function abook_grpdelmember() {
    global $customerID, $sql, $lng;
    global $grpShowMembers, $daddrID, $grpID;
    global $err_msg, $info_msg, $BODY_ONLOAD;

    if(!$daddrID) {
       $err_msg = $lng->p(348);
       $BODY_ONLOAD = "onLoad='document.grpEdit.daddrID.focus();'";
    } else {
       $sql->open();
       $rc = $sql->addr_grpdelmem($customerID, $grpID, $daddrID);
       $sql->close();
       if($rc == false) $err_msg = $lng->p(349);
       else {
          $info_msg = $lng->p(350);
          $grpShowMembers = "";
       }
    }
}

// create a new group
function abook_grpadd() {
    global $customerID, $sql, $lng;
    global $grpName;
    global $err_msg, $info_msg, $BODY_ONLOAD;
   
    if(empty($grpName)) {
       $err_msg = $lng->p(329);
       $BODY_ONLOAD = "onLoad='document.grpList.grpName.focus();'";
    } else {
       $sql->open();
       $rc = $sql->addr_addgrp($customerID, $grpName);
       $sql->close();
       if($rc == false) $err_msg = $lng->p(330);
       else $info_msg = $lng->p(331);
    }
}

// delete an existing group
function abook_grpdel() {
    global $customerID, $sql, $lng;
    global $grpID, $confirmed;
    global $err_msg, $info_msg, $BODY_ONLOAD;
    global $grp_members, $grp_delname;
    global $grpDel;

    if(!$grpID) {
       $err_msg = $lng->p(332);
       $BODY_ONLOAD = "onLoad='document.grpList.grpID.focus();'";
    } else {
       $sql->open();
       if($confirmed) {
          $rc = $sql->addr_delgrp($customerID, $grpID);
          if($rc == false) $err_msg = $lng->p(334);
          else $info_msg = $lng->p(335);
	  $grpDel = "";
       } else {
          $grp_members = $sql->addr_grpmem($customerID, $grpID);
          $grp_delname = $sql->addr_getgrpname($customerID, $grpID);
       }
       $sql->close();
    }
}

// functions used in htx file
// --
function is_delitem() {
    global $lng, $addrID;
    global $delItem, $del_nick, $del_groups;
  
    if(!empty($delItem)) {
	echo "<div align='center' class='normalbg'>\n";
       echo "<b>$del_nick:</b> " . $lng->p(322) . "<br>\n";
       if(!empty($del_groups)) {
          echo "<br><b><u>" . $lng->p(347) . "</u> ";
          for($i = 0 ; $i < count($del_groups) ; $i++) {
              $cur_grp = $del_groups[$i];
              $cur_grpname = $cur_grp["GRPNAME"];
              if(!$i) echo $cur_grpname;
              else echo ", " . $cur_grpname;
          }
          echo "</b><br><br>\n";
       }
       put_ahref("RequestID=ABOOK&delItem=1&addrID=" . $addrID . "&confirmed=yes", $lng->p(1));
       echo "&nbsp;|&nbsp;";
       put_ahref("RequestID=ABOOK", $lng->p(2));
	echo "</div>\n";
    }
}

function is_modadditem(&$out) {
    global $addItem, $modItem, $lng;

    if(!empty($addItem) || !empty($modItem)) {
       if(!empty($addItem)) {
          $out[0] = "addEntry";
          $out[1] = $lng->p(311);
          $out[2] = "addItem";
          $out[3] = $lng->p(312);
       } else {
          $out[0] = "modEntry";
          $out[1] = $lng->p(316);
          $out[2] = "updateItem";
          $out[3] = $lng->p(317);
       }
       return true;
    }
    return false;
}


// load the addressbook items
function load_abookn($cid, &$cnt) {
    global $sql;
    
    $data = $sql->get_allabook($cid);
    if(empty($data)) return array();
    $cnt = 0;
    while(list($key, $val) = each($data)) {
          $ret[$cnt]["id"] = $val["ROWID"];
          $ret[$cnt]["nick"] = $val["NICKNAME"];
          $ret[$cnt]["email"] = $val["EMAIL"];
          $ret[$cnt]["name"] = $val["NAME"];
          $ret[$cnt]["tel"] = $val["TELEPHONE"];
          $ret[$cnt]["fax"] = $val["FAX"];
          $ret[$cnt]["note"] = $val["NOTE"];
	  $cnt++;
    }
    return $ret;  
}

// load the addressbook group items
function load_abookgrp($cid, &$cnt) {
    global $sql;
    
    $data = $sql->get_allabookgrp($cid);
    if(empty($data)) return array();
    $cnt = 0;
    while(list($key, $val) = each($data)) {
          $ret[$cnt]["id"] = $val["ROWID"];
          $ret[$cnt]["grpname"] = $val["GRPNAME"];
          $ret[$cnt]["member"] = $val["MEMBERS"];
	  $cnt++;
    }
    return $ret;  
}
function load_abook() {
    global $customerID, $sql;
    global $abook_items, $abook_items_cnt;
    global $abook_grpitems, $abook_grpitems_cnt;

    $sql->open();
    $abook_items = load_abookn($customerID, $abook_items_cnt);
    $abook_grpitems = load_abookgrp($customerID, $abook_grpitems_cnt);
    $sql->close();
}

function push_abook() {
    global $customerID, $RequestID, $sql, $lng;
    global $BSX_HTXDIR, $BSX_THEMEDIR, $BSX_VERSION;
    global $BSX_BASEHREF, $BSX_LAUNCHER;
    global $BSX_SENTMAIL_NAME, $BSX_TRASH_NAME;
    global $BODY_ONLOAD;
    global $SESSID, $is_js, $is_ssl;
    global $abook_items, $abook_items_cnt;
    global $abook_grpitems, $abook_grpitems_cnt;
    global $addItem, $modItem, $delItem, $grpItem;
    global $add_nick, $add_email, $add_name, $add_tel, $add_fax, $add_note;
    global $del_nick, $del_groups, $addrID, $aaddrID, $daddrID, $grpID, $grpDel;
    global $grpName, $grp_members, $grp_delname, $grpShowMembers, $grp_basename;

    include("$BSX_HTXDIR/header.htx");
    include("$BSX_HTXDIR/menu.htx");
    include("$BSX_HTXDIR/addressbook.htx");
    include("$BSX_HTXDIR/footer.htx");
}

// import old addressbook entries from 0.9.7
function is_importolddb() {
    global $username, $domain_name;
    global $BSX_BASEHREF, $BSX_LAUNCHER, $is_js, $is_ssl, $SESSID;
    global $lng;
 
    global $old_dbhost, $old_dbuser, $old_dbpass;

    $i = @mysql_connect($old_dbhost, $old_dbuser, $old_dbpass);
    if($i) {
    	if(@mysql_select_db("basilix", $i)) {
	    $str = $username . "@" . $domain_name;
	    $query = "SELECT COUNT(*) CNT FROM AddressBook WHERE OwnerUD='$str'";
	    $ret = mysql_query($query, $i);
   
	    if($ret || !emtpy($ret)) {
		    $row = mysql_fetch_array($ret);
		    $cnt = $row["CNT"];
		    if($cnt) {
			echo "&lt;";
			put_ahref("RequestID=ABOOK&importold=yes", $lng->p(353));
			echo "&gt;";
		    }
		    mysql_free_result($ret);
	     }
	}
        mysql_close($i);
    }

}

function do_import() {
    global $username, $domain_name;
    global $BSX_BASEHREF, $BSX_LAUNCHER, $is_js, $is_ssl, $SESSID;
    global $lng, $sql, $customerID, $info_msg, $err_msg;

    global $old_dbhost, $old_dbuser, $old_dbpass;

    $i = @mysql_connect($old_dbhost, $old_dbuser, $old_dbpass);
    $j = 0;
    if($i) {
    	if(@mysql_select_db("basilix", $i)) {
	    $str = $username . "@" . $domain_name;
	    $query = "SELECT * FROM AddressBook WHERE OwnerUD='$str'";
	    $ret = mysql_query($query, $i);
   
	    if($ret || !emtpy($ret)) {
		    while($row = mysql_fetch_array($ret)) {
			$olds[$j]["nick"] = stripslashes($row["Nickname"]);
			$olds[$j]["email"] = stripslashes($row["Email"]);
			$olds[$j]["name"] = stripslashes($row["Name"]);
			$olds[$j]["note"] = stripslashes($row["Note"]);
			$j++;
		    }
		    mysql_free_result($ret);
		    if($j) {
			$query = "DELETE FROM AddressBook WHERE OwnerUD='$str'";
			mysql_query($query, $i);
		    }
	     }
	
	}
        mysql_close($i);
    }
    $sql->open();
    for($i = 0 ; $i < $j ; $i++) {
	$rc = $sql->addr_add($customerID, $olds[$i]["nick"], $olds[$i]["email"], 
			     $olds[$i]["name"], "", "", $olds[$i]["note"]);
    }
    $lng->sb(354); $lng->sr("%d", $j); $info_msg = $lng->sp();
    $sql->close();
}
?>
