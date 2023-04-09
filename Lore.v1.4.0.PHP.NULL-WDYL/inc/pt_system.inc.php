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
* Encapsulates basic functionality of the software system
* (such as the database, template engine, session, etc.)
* @package pt_common_lib
*/
//////////////////////////////////////////////////////////////
class pt_system
{
	/**
	* name of software system
	* @var string
	*/
	var $system_name;
	
	/**
	* database object
	* @var reference
	*/
	var $db;

	/**
	* Template engine object
	* @var reference
	*/
	var $te;

	/**
	* Array of program settings
	* @var array
	*/
	var $settings;

	/**
	* Software version
	* @var string
	*/
	var $version;

	/**
	* Script start time
	* @var int
	*/
	var $start_time;

	/**
	* Script end time
	* @var int
	*/
	var $end_time;

	/**
	* List of PHP scripts
	* @var array
	*/
	var $scripts;

	/**
	* Whether to send email when an error occurs
	* @var bool
	*/
	var $email_on_error = false;
	
	/**
	* Email to send errors to
	* @var string
	*/
	var $error_email;
	
	/**
	* Whether to show script execution times
	* @var bool
	*/
	var $show_run_time = false;
	
	//////////////////////////////////////////////////////////////
	/**
	* Constructor
	*/
	//////////////////////////////////////////////////////////////
	function pt_system()
	{
		list($usec, $sec) = explode(' ', microtime()); 
		$this->start_time = ((float)$usec + (float)$sec); 
	}

	//////////////////////////////////////////////////////////////
	/**
	* Wrapper around mail function
	* @param string to
	* @param string subject
	* @param string body
	* @param array extra_headers
	* @param bool send_as_html
	*/
	//////////////////////////////////////////////////////////////
	function mail($to, $from, $subject, $body, $send_as_html=false, $extra_headers=array())
	{
		$extra_headers[] = 'From: ' . $from;
		if( $send_as_html )
		{
			$extra_headers[] = "MIME-Version: 1.0\r\n";
			$extra_headers[] = "Content-type: text/html; charset=iso-8859-1\r\n";
		}
		mail($to, $subject, $body, implode("\r\n", $extra_headers));
	}

	//////////////////////////////////////////////////////////////
	/**
	* Take offsetted timestamp and make it GMT
	* @param int $timestamp
	*/
	//////////////////////////////////////////////////////////////
	function timestamp_to_gmt($timestamp)
	{
		return $timestamp + (-(int)($this->settings['default_time_offset']*3600));
	}

	//////////////////////////////////////////////////////////////
	/**
	* Take GMT timestamp and offset it based on the default time
	* offset setting
	* @param int $timestamp
	*/
	//////////////////////////////////////////////////////////////
	function offset_timestamp($timestamp)
	{
		return $timestamp + ((int)$this->settings['default_time_offset']*3600);
	}

	//////////////////////////////////////////////////////////////
	/**
	* Date formatting function
	*/
	//////////////////////////////////////////////////////////////
	function format_date($timestamp, $format)
	{
		$timestamp = $this->offset_timestamp($timestamp);	
		return @gmdate($format, $timestamp);
	}

	//////////////////////////////////////////////////////////////
	/**
	* Retrieves program settings from database
	*/
	//////////////////////////////////////////////////////////////
	function get_settings()
	{
		$this->settings = unserialize($this->db->query_one_result("SELECT content FROM $this->blackboard_table WHERE name='SETTINGS'"));
		my_array_walk($this->settings, 'stripslashes');
	}

	function edit_settings( $setting_values )
	{
		$settings		= unserialize($this->db->query_one_result("SELECT content FROM $this->blackboard_table WHERE name='SETTINGS'"));
		$default_settings	= unserialize($this->db->query_one_result("SELECT content FROM $this->blackboard_table WHERE name='DEFAULT_SETTINGS'"));
	
		$settings		= array_merge($settings, $setting_values);
		$default_settings	= array_merge($default_settings, $setting_values);
	
		$content = addslashes(serialize($settings));
		$this->db->query("UPDATE $this->blackboard_table SET content='$content' WHERE name='SETTINGS'");
		$content = addslashes(serialize($default_settings));
		$this->db->query("UPDATE $this->blackboard_table SET content='$content' WHERE name='DEFAULT_SETTINGS'");
	}

	//////////////////////////////////////////////////////////////
	/**
	* Script run time
	*/
	//////////////////////////////////////////////////////////////
	function get_script_time()
	{
		list($usec, $sec) = explode(' ', microtime()); 
		return ((float)$usec + (float)$sec) - (float)$this->start_time;
	}

	//////////////////////////////////////////////////////////////
	/**
	* Show system warning
	*
	* @param string $message
	*/
	//////////////////////////////////////////////////////////////
	function trigger_warning( $message, $email_to = NULL )
	{
		echo	'<div style="color: black;font-family: verdana, sans-serif, arial; font-size: 12px; background-color: #f5f5f5; border: 1px dotted #cccccc; padding: 5px; margin: 10px;">'
			.'<strong>' . $this->system_name .' System Error</strong>'
			.'<br /><br />'
			.nl2br($message)
			.'</div>';
				
		if( $this->email_on_error )
		{
			$this->mail( $this->error_email, $this->system_name, $this->system_name . ' System Error', $message);
		}
	}

	//////////////////////////////////////////////////////////////
	/**
	* Show system error, and exit script
	*
	* @param string $message
	*/
	//////////////////////////////////////////////////////////////
	
	function trigger_error( $message )
	{
		echo	'<html><body>'
			.'<div style="color: black;font-family: verdana, sans-serif, arial; font-size: 12px; background-color: #f5f5f5; border: 1px dotted #cccccc; padding: 5px; margin: 10px;">'
			.'<strong>' . $this->system_name .' System Error</strong>'
			.'<br /><br />'
			.nl2br($message)
			.'</div></body></html>';
			
		if( $this->email_on_error )
		{
			$this->mail( $this->error_email, $this->system_name, $this->system_name . ' System Error', $message);
		}
		exit;
	}
	
	//////////////////////////////////////////////////////////////
	/**
	* Get specified variable from the blackboard
	*
	* @param string $name
	*/
	//////////////////////////////////////////////////////////////
	function get_blackboard_value( $name )
	{
		return $this->db->query_one_result("SELECT content FROM $this->blackboard_table WHERE name = '$name'");
	}

	//////////////////////////////////////////////////////////////
	/**
	* Set specified blackboard variable
	*
	* @param string $name
	* @param string $content
	*/
	//////////////////////////////////////////////////////////////
	function set_blackboard_value( $name, $content )
	{
		$this->db->query("REPLACE INTO $this->blackboard_table (name, content) VALUES ('$name', '$content')");
	}
	
	//////////////////////////////////////////////////////////////
	/**
	* Standard shutdown function run at end of script
	*/
	//////////////////////////////////////////////////////////////
	function __shutdown()
	{
	}
}
?>
