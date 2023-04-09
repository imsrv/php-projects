<?php
/*
+-------------------------------------------------------------------------
| Lore
| (c)2003-2004 Pineapple Technologies
| http://www.pineappletechnologies.com
| ------------------------------------------------------------------------
| This code is the proprietary product of Pineapple Technologies and is
| protected by international copyright and intellectual property laws.
| ------------------------------------------------------------------------
| Your usage of this software is bound by the agreement set forth in the
| software license that was packaged with this software as LICENSE.txt.
| A copy of this license agreement can be located at
| http://www.pineappletechnologies.com/products/lore/license.php
| By installing and/or using this software you agree to the terms
| stated in the license.
| ------------------------------------------------------------------------
| You may modify the code below at your own risk. However, the software
| cannot be redistributed, whether altered or not altered, in whole or in
| part, in any way, shape, or form.
+-------------------------------------------------------------------------
| Software Version: 1.4.0
+-------------------------------------------------------------------------
*/

//////////////////////////////////////////////////////////////
/**
* User session object -
* Used to track all user sessions, variables, etc.
* Encapsulates functionality to validate users, check user
* permissions, etc.
*
* @package pt_common_lib
*/
//////////////////////////////////////////////////////////////
class pt_user_session
{
	/**
	* Reference to database object
	* @var reference
	*/
	var $db;
	
	/**
	* Array of session variables
	* @var array
	*/
	var $session_vars;

	/**
	* Name of user table in database
	* @var string
	*/
	var $user_table;

	/**
	* Path to use when setting session cookie
	* @var string
	*/
	var $cookie_path;

	/**
	* Domain to use when setting session cookie
	* @var string
	*/
	var $cookie_domain;
		
	//////////////////////////////////////////////////////////////
	/**
	* Constructor
	*/
	//////////////////////////////////////////////////////////////
	function pt_user_session()
	{
	}
	
	//////////////////////////////////////////////////////////////
	/**
	* Start session
	* @param string $id Session id (MD5 hash)
	*/
	//////////////////////////////////////////////////////////////
	function start()
	{
		if( !ereg("\/$", $this->cookie_path ) )
		{
			$this->cookie_path .= '/';
		}

		@ini_set('session.use_trans_sid', 0);
		@ini_set('session.use_cookies', 1);
		@ini_set('session.use_only_cookies', 1);
		@session_set_cookie_params(0, $this->cookie_path, $this->cookie_domain);
		@session_name('pt_sid');
		session_start();

		$this->session_vars =& $_SESSION;
		if( !isset( $this->session_vars['validated'] ) )
		{
			$this->session_vars['validated'] = false;
		}
	}

	//////////////////////////////////////////////////////////////
	/**
	* Validate login
	* @param string $username
	* @param string $password
	*/
	//////////////////////////////////////////////////////////////
	function validate_login( $username, $password, $md5_password=false )
	{
		$password = ( $md5_password ) ? $password : md5($password);
		$this->username = $username;
		$this->password = $password;

		$result = $this->db->query("SELECT id,username,email,level FROM $this->user_table WHERE username='$username' AND password='$password'");
		if( $this->db->num_rows($result) )
		{
			$this->session_vars['user_info'] = $this->db->fetch_array($result);
			$this->session_vars['validated'] = true;
			return true;
		}
		else
		{
			return false;
		}			
	}

	//////////////////////////////////////////////////////////////
	/**
	* Returns true if this user session is for a validated
	* (logged in) user
	*/
	//////////////////////////////////////////////////////////////
	function is_validated()
	{
		return $this->session_vars['validated'];
	}

	//////////////////////////////////////////////////////////////
	/**
	* Returns true if this user is an administrator
	*/
	//////////////////////////////////////////////////////////////
	function is_administrator()
	{
		return ( 'Administrator' == $this->session_vars['user_info']['level'] ) ? true : false;
	}

	//////////////////////////////////////////////////////////////
	/**
	* Destroy current session
	*/
	//////////////////////////////////////////////////////////////
	function destroy()
	{
		session_destroy();
	}
}
?>
