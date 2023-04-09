<?php
/*
 * Session Management for PHP3
 *
 * Copyright (c) 1998,1999 SH Online Dienst GmbH
 *                    Boris Erdmann, Kristian Koehntopp
 *
 * $Id: db_pgsql.inc.php,v 1.11 1999/07/29 11:12:46 negro Exp $
 *
 */ 

class DB_Sql {
  var $Host     = "";
  var $Database = "";
  var $User     = "";
  var $Password = "";

  var $Link_ID  = 0;
  var $Query_ID = 0;
  var $Record   = array();
  var $Row      = 0;

  var $Errno    = 0;
  var $Error    = "";

  var $Auto_Free = 0; # Set this to 1 for automatic pg_freeresult on 
                      # last record.
					  
function DB_Sql()
{
  	global $db_name,$db_host,$db_username,$db_password;
	
	$this->Database = $db_name;
	$this->Host 	= $db_host;
	$this->User		= $db_username;
	$this->Password = $db_password;
}

  function ifadd($add, $me) {
	  if("" != $add) return " ".$me.$add;
  }
  
  function connect() {
	  if ( 0 == $this->Link_ID ) {
		  $cstr = "dbname=".$this->Database.
		  $this->ifadd($this->Host, "host=").
		  $this->ifadd($this->Port, "port=").
		  $this->ifadd($this->User, "user=").
		  $this->ifadd($this->Password, "password=");
		  $this->Link_ID=pg_pconnect($cstr);
		  if (!$this->Link_ID) {
			  $this->halt("Link-ID == false, pconnect failed");
		  }
	  }
  }

  function query($Query_String) {
    $this->connect();

#   printf("<br>Debug: query = %s<br>\n", $Query_String);

    $this->Query_ID = pg_Exec($this->Link_ID, $Query_String);
    $this->Row   = 0;

    $this->Error = pg_ErrorMessage($this->Link_ID);
    $this->Errno = ($this->Error == "")?0:1;
    if (!$this->Query_ID) {
      $this->halt("Invalid SQL: ".$Query_String);
    }

    return $this->Query_ID;
  }
  
  function next_record() {
    $this->Record = @pg_fetch_array($this->Query_ID, $this->Row++);
    
    $this->Error = pg_ErrorMessage($this->Link_ID);
    $this->Errno = ($this->Error == "")?0:1;

    $stat = is_array($this->Record);
    if (!$stat && $this->Auto_Free) {
      pg_freeresult($this->Query_ID);
      $this->Query_ID = 0;
    }
    return $stat;
  }

  function seek($pos) {
    $this->Row = $pos;
  }

  function lock($table, $mode = "write") {
    if ($mode == "write") {
      $result = pg_Exec($this->Link_ID, "lock table $table");
    } else {
      $result = 1;
    }
    return $result;
  }
  
  function unlock() {
    return pg_Exec($this->Link_ID, "commit");
  }

  function metadata($table) {
    $count = 0;
    $id    = 0;
    $res   = array();

    $this->connect();
    $id = pg_exec($this->Link_ID, "select * from $table");
    if ($id < 0) {
      $this->Error = pg_ErrorMessage($id);
      $this->Errno = 1;
      $this->halt("Metadata query failed.");
    }
    $count = pg_NumFields($id);
    
    for ($i=0; $i<$count; $i++) {
      $res[$i]["table"] = $table;
      $res[$i]["name"]  = pg_FieldName  ($id, $i); 
      $res[$i]["type"]  = pg_FieldType  ($id, $i);
      $res[$i]["len"]   = pg_FieldSize  ($id, $i);
      $res[$i]["flags"] = "";
    }
    
    pg_FreeResult($id);
    return $res;
  }

  function affected_rows() {
    return pg_cmdtuples($this->Query_ID);
  }

  function num_rows() {
    return pg_numrows($this->Query_ID);
  }

  function num_fields() {
    return pg_numfields($this->Query_ID);
  }

  function nf() {
    return $this->num_rows();
  }

  function np() {
    print $this->num_rows();
  }

  function f($Name) {
    return $this->Record[$Name];
  }

  function p($Name) {
    echo $this->Record[$Name];
  }
  
  function halt($msg) {
    printf("</td></tr></table><b>Database error:</b> %s<br>\n", $msg);
    printf("<b>PostgreSQL Error</b>: %s (%s)<br>\n",
      $this->Errno,
      $this->Error);
    die("Session halted.");
  }

  function table_names() {
    $this->query("select relname from pg_class where relkind = 'r' and not relname like 'pg_%'");
    $i=0;
    while ($this->next_record())
     {
      $return[$i]["table_name"]= $this->f(0);
      $return[$i]["tablespace_name"]=$this->Database;
      $return[$i]["database"]=$this->Database;
      $i++;
     }
    return $return;
  }

// function currid() added by Jeremy Rempel for Relata
// after doing an insert, use this function to return the
// value of the id added by a specified sequence ($seq_name)
	function currid($seq_name)
	{
		$result = $this->query("SELECT currval('$seq_name')");
		return pg_result($result,0,0);
	}
	
// function nextid() added by Jeremy Rempel for Relata
// use this before an insert to determine the next_id returned
// by a specified sequence. If you run this function you must
// insert the id explictly with the INSERT command
	function nextid($seq_name)
	{
		$result = $this->query("SELECT nextval('$seq_name')");
		return pg_result($result,0,0);
	}
}

?>