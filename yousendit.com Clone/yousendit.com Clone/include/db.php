<?php
require('dbinfo.php');
class MySQLDB
{
        var $dbhost;
        var $dbuser;
        var $dbpass;
        var $dbname;
        var $dblink;
        var $qrystr;
        var $result;
        var $dbprefix;
        
        function MySQLDB($dbhost, $dbuser, $dbpass, $dbname, $dbprefix)
        {
                $this->dbhost=$dbhost;
                $this->dbuser=$dbuser;
                $this->dbpass=$dbpass;
                $this->dbname=$dbname;
                $this->dbprefix=$dbprefix;
        }
        
        function connectdb()
        {
                $this->dblink=mysql_connect($this->dbhost,$this->dbuser,$this->dbpass) or die($this->show_error());
        }
        
        function selectdb()
        {
                mysql_select_db($this->dbname) or die($this->show_error());
        }
        
        function show_error()
        {
                print mysql_error($this->dblink);
        }
        
        function query($qry="")
        {
                if(!empty($qry)) $this->qrystr=$qry;
                if(empty($this->qrystr)) die("Error: Query string is empty.");
                else $this->result=mysql_query($this->qrystr,$this->dblink) or die($this->show_error());                
        }
        
        function setqrystr($qry)
        {
                $this->qrystr=$qry;
        }
        
        function get_insert_id()
        {
                return mysql_insert_id($this->dblink);
        }
        
        function getrow()
        {
                return mysql_fetch_row($this->result);
        }
        
        function getarr()
        {
                return mysql_fetch_array($this->result,MYSQL_ASSOC);
        }
        
        function getobj()
        {
                return mysql_fetch_object($this->result);
        }
        
        function getaffectedrows()
        {
                return mysql_affected_rows($this->dblink);
        }
        
        function getrownum()
        {
                return mysql_num_rows($this->result);
        }
        
        function freeresult()
        {
                mysql_free_result($this->result);
        }
        
        function closedb()
        {
                mysql_close($this->dblink);
        }
        
        function __destruct()
        {
                mysql_close($this->dblink);
        }
        
        function tb($tablename)
        {
                if(empty($this->dbprefix))        return $tablename;
                else return $this->dbprefix."_".$tablename;
        }
}
//Hostname,Username,Password,Database,table prefix
$db=new MySQLDB($db['host'], $db['username'], $db['password'], $db['db'], $db['prefix']);
//$db=new MySQLDB("localhost","werdabest","werthebest","werdabest","");
$db->connectdb();
$db->selectdb();
?>
