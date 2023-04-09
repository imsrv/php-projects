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

class db_mysql
{
	/**
	* Database name
	* @var string
	*/
	var $database;
	
	/**
	* @var string
	*/
	var $hostname;
	
	/**
	* @var string
	*/
	var $username;
	
	/**
	* @var string
	*/
	var $password;

	/**
	* connection resource
	* @var resource
	*/
	var $link;

	/**
	* Outputs queries
	* @var bool
	*/
	var $debug		= false;
	
	/**
	* Run error_out() function when a query fails
	* @var bool
	*/
	var $die_on_error	= false;

	/**
	* name of error handler function to call when a query fails
	* @var mixed
	*/
	var $error_handler_func;
	
	/**
	* whether to use MySQL persistent connections
	* @var bool
	*/
	var $use_persistent_connections 	= true;
	
	function db_mysql($hostname, $username, $password, $database)
	{
		$this->hostname = $hostname;
		$this->username = $username;
		$this->password = $password;
		$this->database = $database;
	}

	function connect()
	{
		$connect_func = ( $this->use_persistent_connections ) ? 'mysql_pconnect' : 'mysql_connect';
		if( !$this->link = @$connect_func($this->hostname,$this->username,$this->password) )
		{
			return false;
		}
		else
		{
			return true;
		}
	}

	function close()
	{
		@mysql_close( $this->link );
	}

	function select_db()
	{
		if( !@mysql_select_db($this->database, $this->link) )
		{
			return false;
		}
		else
		{
			return true;
		}
	}

	function query($query)
	{
		$result = @mysql_query($query, $this->link);
		if( !$result && $this->die_on_error )
		{
			$this->error_out($query);
		}
		return $result;
	}

	function delete_id($id, $table)
	{
		if( is_array($id) )
		{
			foreach( $id AS $i )
			{
				$this->query("DELETE FROM $table WHERE id = '$i'");
			}
		}
		else
		{
			$this->query("DELETE FROM $table WHERE id = '$id'");
		}
	}

	function fetch_array($result)
	{
		return @mysql_fetch_array($result, MYSQL_ASSOC);
	}

	function query_one_result($query)
	{
		$result = $this->query($query);
		$data = @mysql_result($result, 0);
		$this->free_result($result);
		return $data;
	}
	
	function query_all_results($query)
	{
		$result = $this->query($query);
		while( $row = $this->fetch_array($result) )
		{
			$results[] = $row[0];
		}
		$this->free_result($result);
		return $results;
	}

	function query_one_row($query)
	{
		$result = $this->query($query);
		$row = $this->fetch_array($result);
		$this->free_result($result);
		return $row;
	}

	function query_all_rows($query)
	{
		$result = $this->query($query);
		while( $row = $this->fetch_array($result) )
		{
			$rows[] = $row;
		}
		return $rows;
	}

	function query_one_array($query)
	{
		$array = array();
		$result = $this->query($query);
		while( $row = $this->fetch_array($result) )
		{
			$array_key = $row['array_key'];
			$array[$array_key] = $row['array_value'];
		}
		$this->free_result($result);
		return $array;
	}

	function id_exists($id, $table)
	{
		return $this->query_one_result("SELECT COUNT(*) FROM $table WHERE id = '$id'");
	}

	function value_exists($value, $field, $table)
	{
		return $this->query_one_result("SELECT COUNT(*) FROM $table WHERE $field = '$value'");
	}

	function insert_from_array($array, $table, $unique_field="")
	{
		if( $unique_field )
		{
			if( $this->value_exists($array[$unique_field], $unique_field, $table) )
			{
				return 0;
			}
		}

		while( @list($key,$value) = @each($array) )
		{
			$field_names[] = "$key";

			// 'SET' field, multiple values
			if( is_array($value) )
			{
				$field_values[] = "'" . implode(',', $value) . "'";
				unset($set_values);
			}
			else
			{
				$field_values[] = "'$value'";
			}
		}

		$query = "INSERT INTO $table (";
		$query .= implode(', ', $field_names);

		$query .= ') VALUES (' . implode(',', $field_values) . ')';
		$this->query($query);
 
		return $this->query_one_result("SELECT id FROM $table ORDER BY id DESC LIMIT 1");
	
	}
		
	function update_from_array($array, $table, $id)
	{
		$query = "UPDATE $table SET ";
		while(@list($key,$value) = @each($array))
			$fields[] = "$key='$value'";

		$query .= implode(', ', $fields);
		$query .= " WHERE id = '$id'";
		$this->query($query);
	
	}

	function num_rows($result)
	{
		return @mysql_num_rows($result);
	}

	function data_seek($result, $rownum)
	{
		return @mysql_data_seek($result, $rownum);
	}

	function free_result($result)
	{
		@mysql_free_result($result);
	}

	function affected_rows()
	{
		return @mysql_affected_rows($this->link);
	}

	function get_error_msg()
	{
		return @mysql_error($this->link);
	}

	function get_error_num()
	{
		return @mysql_errno($this->link);
	}

	function error_out($query)
	{
		$message = "There was an error querying the database.\n\n "
				."Query: $query\n\n"
				."Error Message: (" . $this->get_error_num() . ") " . $this->get_error_msg();
		call_user_func( $this->error_handler_func, $message );
	}
}
?>
