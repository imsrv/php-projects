<?php

/*
*  Copyright (C) 2000-2005 phpGraphy Development Team 
*  phpgraphy [dash] devteam [at] lists [dot] sourceforge [dot] net
*  
*  This program is free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2, or (at your option)
*  any later version.
*
*  This program is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  You should have received a copy of the GNU General Public License
*  along with this program; if not, write to the Free Software
*  Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
*
* $Id: functions_user-management.inc.php 130 2005-07-03 13:00:46Z jim $
*
*/

// USER MANAGEMENT

function get_user_information($uid) {

	if($uid==-1) return array('login'=>'', 'password'=>'', 'security_level'=>'');

	global $txt_error;

    $all_user_info = get_all_user_information();

	if(isSet($all_user_info[$uid])) {
		return $all_user_info[$uid];
	} else {
        trigger_error($txt_error["00801"], ERROR);
	}

}

function process_user_information() {

    global $txt_error;

	$user_info = array();

	if(isSet($_POST['uid'])) {

		if(is_numeric($_POST['uid'])) {
			$user_info['uid'] = $_POST['uid'];
		} else {
			$user_info['error']['uid'] = $txt_error["00802"];
		}

	} else {

		$user_info['error']['uid'] = $txt_error["00801"];

	}

	if(isSet($_POST['login'])) {
		if(preg_match('/^[\w@\.-]+$/', $_POST['login'])) {
			$user_info['login'] = $_POST['login'];
		} else {
			$user_info['login'] = $_POST['login'];
			$user_info['error']['login'] = $txt_error["00803"];
		}
	} else {
		$user_info['error']['login'] = $txt_error["00804"];
	}

	if(isSet($_POST['password'])) {
		if(preg_match('/^[\w!?^&\*@#,:;\(\)\/\.+-]+$/', $_POST['password'])) {
			$user_info['password'] = $_POST['password'];
		} else {
			$user_info['password'] = $_POST['password'];
			$user_info['error']['password'] = $txt_error["00805"];
		}
	} else {
		$user_info['error']['password'] = $txt_error["00806"];
	}

	if(isSet($_POST['security_level'])) {
		if(is_numeric($_POST['security_level']) && $_POST['security_level']>0) {
                    $user_info['security_level'] = $_POST['security_level'];
                } else {
                    $user_info['security_level'] = $_POST['security_level'];
                    $user_info['error']['security_level'] = $txt_error["00807"];
                }
	} else {
		$user_info['error']['security_level'] = $txt_error["00808"];
	}

	if($user_info['uid']==-1) {
		$user_info['cookie_value'] = generate_cookie_value();
	}
	return $user_info;
}

function generate_cookie_value() {

	return rand().rand().rand();

}

function edit_user_information($user_info) {

	$all_user_info = get_all_user_information();

	if(isSet($user_info['cookie_value'])) {

		unset($user_info['uid']);
		$all_user_info[] = $user_info;

	} else {

		$all_user_info[ $user_info['uid'] ]['login']		  = $user_info['login'];
		$all_user_info[ $user_info['uid'] ]['password']		  = $user_info['password'];
		$all_user_info[ $user_info['uid'] ]['security_level'] = $user_info['security_level'];

	}

	save_user_information($all_user_info);

}


?>
