<?php

##
## Copyright (c) 1998,1999 SH Online Dienst GmbH
##                    Boris Erdmann, Kristian Koehntopp
##
## Copyright (c) 1998,1999 Sascha Schumann <sascha@schumann.cx>
## 
## $Id: ct_sql.inc.php,v 1.14 1999/08/26 10:51:07 kk Exp $
##
## PHPLIB Data Storage Container using a SQL database
##

class CT_Sql {
  ##
  ## Define these parameters by overwriting or by
  ## deriving your own class from it (recommended)
  ##
    
  var $database_table = "active_sessions";
  var $database_class = "DB_Sql";
  var $database_lock_semaphore = "";

  var $encoding_mode = "base64";

  ## end of configuration

  var $db;

  function ac_start() {
    $name = $this->database_class;
    $this->db = new $name;
  }

  function ac_get_lock() {
    if ( "" != $this->database_lock_semaphore ) {
      $query = sprintf("SELECT get_lock('%s')", $this->database_lock_semaphore);
      while ( ! $this->db->query($query)) {
        $t = 1 + time(); while ( $t > time() ) { ; }
      }
    }
  }

  function ac_release_lock() {
    if ( "" != $this->database_lock_semaphore ) {
      $query = sprintf("SELECT release_lock('%s')", $this->database_lock_semaphore);
      $this->db->query($query);
    }
  }

  function ac_gc($gc_time, $name) {
    $timeout = time();
    $sqldate = date("YmdHis", $timeout - ($gc_time * 60));
    $this->db->query(sprintf("DELETE FROM %s WHERE changed < '%s' AND name = '%s'",
                    $this->database_table, 
                    $sqldate,
                    addslashes($name)));
    }

  function ac_store($id, $name, $str) {
    $ret = true;

    switch ( $this->encoding_mode ) {
      case "slashes":
        $str = addslashes($name . ":" . $str);
      break;

      case "base64":
      default:
        $str = base64_encode($name . ":" . $str);
    };

    $name = addslashes($name);

    ## update duration of visit
    global $HTTP_REFERER, $HTTP_USER_AGENT, $REMOTE_ADDR;

    $now = date("YmdHis", time());
	
    $uquery = sprintf("update %s set val='%s', changed='%s' where sid='%s' and name='%s'",
      $this->database_table,
      $str,
      $now,
      $id,
      $name);
	  
    $iquery = sprintf("insert into %s ( sid, name, val, changed ) values ('%s', '%s', '%s', '%s')",
      $this->database_table,
      $id,
      $name,
      $str,
      $now);
	  
	$cquery = sprintf("SELECT * FROM %s WHERE sid='%s'", $this->database_table, $id);
	$this->db->query($cquery);
	
	if($this->db->num_rows() != 0)
	{
		$this->db->query($uquery);
	}
	else
	{
		$this->db->query($iquery);
		$ret = false;
	}
    
	/*if (  $this->db->affected_rows() == 0 
      && !@$this->db->query($iquery)) {
        $ret = false;
    }
	*/
	
    return $ret;
  }

  function ac_delete($id, $name) {
    $this->db->query(sprintf("delete from %s where name = '%s' and sid = '%s'",
      $this->database_table,
      addslashes($name),
      $id));
  }

  function ac_get_value($id, $name) {
    $this->db->query(sprintf("select val from %s where sid  = '%s' and name = '%s'",
      $this->database_table,
      $id,
      addslashes($name)));
    if ($this->db->next_record()) {
      $str  = $this->db->f("val");
      $str2 = base64_decode( $str );

      if ( ereg("^".$name.":.*", $str2) ) {
         $str = ereg_replace("^".$name.":", "", $str2 );
      } else {

        $str3 = stripslashes( $str );

        if ( ereg("^".$name.":.*", $str3) ) {
          $str = ereg_replace("^".$name.":", "", $str3 );
        } else {

          switch ( $this->encoding_mode ) {
            case "slashes":
              $str = stripslashes($str);
            break;

            case "base64":
            default:
              $str = base64_decode($str);
          }
        }
      };
      return $str;
    };
    return "";
  }

  function ac_newid($str, $name) {
    return $str;
  }

  function ac_halt($s) {
    $this->db->halt($s);
  }
}
?>
