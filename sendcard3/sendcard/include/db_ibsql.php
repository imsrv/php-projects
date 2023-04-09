<?php
/*
 *
 * (C) Copyright 2000, Gregor Ibic (gregor.ibic@intelicom.si)
 *     Interbase database module.
 *     Intelicom d.o.o., www.intelicom.si
 *
 * $Id: db_ibsql.inc,v 0.7.1 2000/10/15
 */
# echo "<BR>This is using the IBSQL class<BR>";

class DB_Sql {
  var $Host     = "";
  var $Database = "";
  var $User     = "";
  var $Password = "";
  var $Charset  = "WIN1250";
  var $Buffers  = 0;
  var $Dialect  = 3;
  var $Role     = "";

  var $Link_ID  = 0;
  var $Query_ID = 0;
  var $Record   = array();
  var $Row      = 0;

  var $Errno    = 0;
  var $Error    = "";

  var $Auto_Free = 0;     ## set this to 1 to automatically free results

  var $QueryStmt = "";


  function connect() {
    if ( 0 == $this->Link_ID ) {
      // Chose your preffered connect method, Apache SAPI now supports IB properly
      $this->Link_ID=ibase_pconnect($this->Host . ":" . $this->Database, $this->User, $this->Password,
                                    $this->Charset, $this->Buffers , $this->Dialect,
                                    $this->Role);
/*      $this->Link_ID=ibase_connect($this->Host . ":" . $this->Database,
                                   $this->User, $this->Password,
                                   $this->Charset, $this->Buffers , $this->Dialect,
                                   $this->Role);
*/

      if (!$this->Link_ID)
        $this->halt("Link_ID == false, ibsql_pconnect failed");
    }
  }

  function free_result(){
      ibase_free_result($this->Query_ID);
      $this->Query_ID = 0;
  }

  function query($Query_String) {
      if (!$this->Link_ID)
        $this->connect();

      $Query_String = str_replace("password", "\"PASSWORD\"", $Query_String);
//      echo $Query_String . "\n <br><hl>";
//      $this->Query_ID = ibase_query($this->Link_ID, $Query_String);
      $this->Query_ID = ibase_query($Query_String);
      $this->Row = 0;
      if (!$this->Query_ID) {
        $this->Errno = 1;
        $this->Error = "General Error (The IBSQL interface cannot return detailed error messages).";
        $this->halt("Invalid SQL: ".$Query_String);
      }
      $this->$QueryStmt = $Query_String;
      // COMMIT
      if ((stristr($Query_String, "INSERT") != "") ||
          (stristr($Query_String, "UPDATE") != "") ||
          (stristr($Query_String, "CREATE") != "")) {
//         echo "Commiting!" . "\n <br><hl>";
         ibase_commit();
      }
//      echo "Affected rows: " . $this->affected_rows() . "\n <br><hl>";
      return $this->Query_ID;
  }

  function next_record() {

    if ($this->Record = ibase_fetch_row($this->Query_ID)) {
      // add to Record[<key>]
      $count = ibase_num_fields($this->Query_ID);
      for ($i=0; $i<$count; $i++){
        $fieldinfo = ibase_field_info($this->Query_ID, $i);
        $this->Record[strtolower($fieldinfo["name"])] = $this->Record[$i];
      }
      $this->Row += 1;
      $stat = 1;
    } else {
      if ($this->Auto_Free) {
            $this->free_result();
          }
      $stat = 0;
    }
    return $stat;
  }

  function seek($pos) {
      $this->Row = $pos;
  }

  function metadata($table) {
    $count = 0;
    $id    = 0;
    $res   = array();

    $this->connect();
    $id = ibase_query("select * from $table", $this->Link_ID);
    if (!$id) {
      $this->Errno = 1;
      $this->Error = "General Error (The IBSQL interface cannot return detailed error messages).";
      $this->halt("Metadata query failed.");
    }
    $count = ibase_num_fields($id);

    for ($i=0; $i<$count; $i++) {
      $info = ibase_field_info($id, $i);
      $res[$i]["table"] = $table;
      $res[$i]["name"]  = $info["name"];
      $res[$i]["len"]   = $info["length"];
      $res[$i]["flags"] = $info["type"];
    }
    $this->free_result();
    return $res;
  }

  function affected_rows() {
    $nrows = 0;
    $SqlStmt = "";
    if ( stristr($this->$QueryStmt, 'UPDATE') != "" ) {
      $this->QueryStmt = trim($this->$QueryStmt);
      $pieces = explode (" ", $this->$QueryStmt);
      $table_name = $pieces[1];
      $SqlStmt2 = stristr ($this->$QueryStmt, 'WHERE');
      $SqlStmt = "SELECT COUNT(1) FROM " . $table_name . " " . $SqlStmt2;
    }

    if ( stristr($this->$QueryStmt, 'SELECT') != "" ) {
      $SqlStmt = stristr ($this->$QueryStmt, 'FROM');
      $SqlStmt2 = stristr ($this->$QueryStmt, 'WHERE');
      $SqlStmt = "SELECT COUNT(1) " . $SqlStmt;
    }

    if ( stristr($this->$QueryStmt, 'DELETE') != "" ) {
      $SqlStmt = stristr ($this->$QueryStmt, 'FROM');
      $SqlStmt2 = stristr ($this->$QueryStmt, 'WHERE');
      $SqlStmt = "SELECT COUNT(1) " . $SqlStmt;
    }


    if ($SqlStmt != "") {
      $this->connect();
      $id = ibase_query($SqlStmt, $this->Link_ID);

      if (!$id) {
        $this->Errno = 1;
        $this->Error = "General Error (The IBSQL interface cannot return detailed error messages).";
        $this->halt("COUNT query failed.");
      }
      if ($row = ibase_fetch_row($id)) {
        $count = ibase_num_fields($id);
        $nrows = $row[0];
      }
      ibase_free_result($id);
    }

    return $nrows;
  }

  function num_rows() {
    return $this->affected_rows();
  }

  function num_fields() {
    return ibase_num_fields($this->Query_ID);
  }

  function nf() {
    return $this->num_rows();
  }

  function np() {
    print $this->num_rows();
  }

  function f($Field_Name) {
    return $this->Record[strtolower($Field_Name)];
  }

  function p($Field_Name) {
    print $this->f($Field_Name);
  }

  function halt($msg) {
    printf("</td></tr></table><b>Database error:</b> %s<br>\n", $msg);
    printf("<b>IBSQL Error</b>: %s (%s)<br>\n",
      $this->Errno,
      $this->Error);
    die("Session halted.");
  }
}
?>