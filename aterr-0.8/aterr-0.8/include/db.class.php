<?php

/*
	aterr - a threaded forum system.

	Copyright (c) 2005 Chris Jenkinson <chris@starglade.org>.
	All rights reserved.

	aterr is licensed under the GNU General Public License.
	<http://opensource.org/licenses/gpl-license.php>
*/

class sql_db
{
	var $queries_array = array();
	var $db_connect_id;
	var $query_result;
	var $row = array();
	var $rowset = array();
	var $num_queries = 0;
	var $error = array();
	var $ignore_errors = false;

	// Constructor
	function sql_db($sqlserver, $sqluser, $sqlpassword, $database, $persistency = true)
	{
		$this->persistency = $persistency;
		$this->user = $sqluser;
		$this->password = $sqlpassword;
		$this->server = $sqlserver;
		$this->dbname = $database;

		if ($this->persistency)
		{
			$this->db_connect_id = mysql_pconnect($this->server, $this->user, $this->password);
		}
		else
		{
			$this->db_connect_id = mysql_connect($this->server, $this->user, $this->password);
		}

		if ($this->db_connect_id)
		{
			if ($database != "")
			{
				$this->dbname = $database;
				$dbselect = mysql_select_db($this->dbname);
				if (!$dbselect)
				{
					mysql_close($this->db_connect_id);

					die('Could not connect to the database: ' . mysql_error());
				}
			}
			return $this->db_connect_id;
		}
		else
		{
			$this->error = array('error' => mysql_error(), 'errno' => mysql_errno());

			die('Could not connect to the database: ' . mysql_error());
		}
	}

	//
	// Other base methods
	//
	function sql_close()
	{
		if($this->db_connect_id)
		{
			if($this->query_result)
			{
				@mysql_free_result($this->query_result);
			}
			$result = @mysql_close($this->db_connect_id);
			return $result;
		}
		else
		{
			return false;
		}
	}

	//
	// Base query method
	//
	function sql_query($query = "", $die_error = TRUE, $transaction = FALSE)
	{
		global $debug;

		/*
			2003-10-16 talrias
			a small amount of code which will hopefully stop people
			being able to use a semicolon which is not escaped to
			execute more than 1 sql query at one time.
		*/

		/*
		$query = preg_split('/[\;]/', $query);

		for ($i = 0; $i < count($query); $i++)
		{
			if (substr($query[$i], -1, 1) == '\\')
			{
				$query[$i] .= $query[$i+1];

				unset($query[$i+1]);
			}
		}

		$query = $query[0];
		*/

		// Remove any pre-existing queries
		unset($this->query_result);
		if($query != "")
		{
			$this->num_queries++;
			$this->queries_array[] = $query;
			$this->query_result = @mysql_query($query, $this->db_connect_id);

			$this->error['error'] = mysql_error();
			$this->error['errno'] = mysql_errno();
		}

		if ($this->error['errno'] && !$this->ignore_errors)
		{
			die('<p><b>SQL Error</b>: (' . $this->error['errno'] . ') ' . $this->error['error'] . '</p><p><b>DB Query</b>: ' . $query . '</p></body></html>');
		}

		if($this->query_result)
		{
			unset($this->row[$this->query_result]);
			unset($this->rowset[$this->query_result]);
			return $this->query_result;
		}
		else
		{
			return ( $transaction == TRUE ) ? true : false;
		}
	}


	//

	// Other query methods

	//

	function sql_numrows($query_id = 0)

	{

		if(!$query_id)

		{

			$query_id = $this->query_result;

		}

		if($query_id)

		{

			$result = @mysql_num_rows($query_id);

			return $result;

		}

		else

		{

			return false;

		}

	}

	function sql_affectedrows()

	{

		if($this->db_connect_id)

		{

			$result = @mysql_affected_rows($this->db_connect_id);

			return $result;

		}

		else

		{

			return false;

		}

	}

	function sql_numfields($query_id = 0)

	{

		if(!$query_id)

		{

			$query_id = $this->query_result;

		}

		if($query_id)

		{

			$result = @mysql_num_fields($query_id);

			return $result;

		}

		else

		{

			return false;

		}

	}

	function sql_fieldname($offset, $query_id = 0)

	{

		if(!$query_id)

		{

			$query_id = $this->query_result;

		}

		if($query_id)

		{

			$result = @mysql_field_name($query_id, $offset);

			return $result;

		}

		else

		{

			return false;

		}

	}

	function sql_fieldtype($offset, $query_id = 0)

	{

		if(!$query_id)

		{

			$query_id = $this->query_result;

		}

		if($query_id)

		{

			$result = @mysql_field_type($query_id, $offset);

			return $result;

		}

		else

		{

			return false;

		}

	}

	function sql_fetchrow($query_id = 0)

	{

		if(!$query_id)

		{

			$query_id = $this->query_result;

		}

		if($query_id)

		{

			$this->row[$query_id] = @mysql_fetch_assoc($query_id);

			return $this->row[$query_id];

		}

		else

		{

			return false;

		}

	}

	function sql_fetchrowset($query_id = 0)

	{

		if(!$query_id)

		{

			$query_id = $this->query_result;

		}

		if($query_id)

		{

			unset($this->rowset[$query_id]);

			unset($this->row[$query_id]);

			while($this->rowset[$query_id] = @mysql_fetch_array($query_id))

			{

				$result[] = $this->rowset[$query_id];

			}

			return $result;

		}

		else

		{

			return false;

		}

	}

	function sql_fetchfield($field, $rownum = -1, $query_id = 0)

	{

		if(!$query_id)

		{

			$query_id = $this->query_result;

		}

		if($query_id)

		{

			if($rownum > -1)

			{

				$result = @mysql_result($query_id, $rownum, $field);

			}

			else

			{

				if(empty($this->row[$query_id]) && empty($this->rowset[$query_id]))

				{

					if($this->sql_fetchrow())

					{

						$result = $this->row[$query_id][$field];

					}

				}

				else

				{

					if($this->rowset[$query_id])

					{

						$result = $this->rowset[$query_id][$field];

					}

					else if($this->row[$query_id])

					{

						$result = $this->row[$query_id][$field];

					}

				}

			}

			return $result;

		}

		else

		{

			return false;

		}

	}

	function sql_rowseek($rownum, $query_id = 0){

		if(!$query_id)

		{

			$query_id = $this->query_result;

		}

		if($query_id)

		{

			$result = @mysql_data_seek($query_id, $rownum);

			return $result;

		}

		else

		{

			return false;

		}

	}

	function sql_nextid(){

		if($this->db_connect_id)

		{

			$result = @mysql_insert_id($this->db_connect_id);

			return $result;

		}

		else

		{

			return false;

		}

	}

	function sql_freeresult($query_id = 0){

		if(!$query_id)

		{

			$query_id = $this->query_result;

		}



		if ( $query_id )

		{

			unset($this->row[$query_id]);

			unset($this->rowset[$query_id]);



			@mysql_free_result($query_id);



			return true;

		}

		else

		{

			return false;

		}

	}

	function sql_error($query_id = 0)

	{

		$this->error['error'] = @mysql_error($this->db_connect_id);

		$this->error['errno'] = @mysql_errno($this->db_connect_id);

	}



	function sql_data(&$array, $single = false)

	{

		$row = array();

		$array = array();



		if ($single)

		{

			while ($row = $this->sql_fetchrow())

			{

				$array = del_magic_quotes($row);

			}

		}

		else

		{

			while ($row = $this->sql_fetchrow())

			{

				$array[] = del_magic_quotes($row);

			}

		}

	}



}



?>
