<?
/********************************************************
	include/backend.MySQL.inc
	
	(C)Copyright 2002 Ryo Chijiiwa <Ryo@IlohaMail.org>

	This file is part of IlohaMail, and released under GPL.
	See COPYING, or http://www.fsf.org/copyleft/gpl.html
	
	PURPOSE:
		Module for accessing MySQL back end
    PRE-CONDITION:
        $backend_table : Table name
        $backend_operation : Operation to perform {"INSERT","UPDATE","DELETE"}
        $backend_array : Associative array containing field name/values, for INSERT and UPDATE
        $backend_dataID : Used in UPDATE and DELETE operations
        $backend_where: Options "where" clause for UPDATE operations
    POST-CONDITION:
        Updated backend
        $error - Error(s) encountered.

********************************************************/
    include_once("../conf/mysqlrc.inc");
    include_once("../include/array2sql.inc");
    
	//figure out what to do
    if (strcasecmp($backend_operation, "INSERT")==0) $opCode = 1;
    else if (strcasecmp($backend_operation, "UPDATE")==0) $opCode = 2;
    else if (strcasecmp($backend_operation, "DELETE")==0) $opCode = 3;

	//validate input
    $be_error="";
    if (empty($backend_table)) $be_error.="Backend table unspecified: Programmer error.<br>\n";
    if (empty($backend_operation)) $be_error .= "Backend operation unspecified: Programmer error.<br>\n";
    if (($opCode!=3) && (empty($backend_array))) $be_error .= "Backend array empty: programmer error<br>\n";
    
    if (empty($be_error)){
		//connect to database
		$mysql_conn = false;
		if ($mysql_persistent) $mysql_conn = mysql_pconnect($mysql_host, $mysql_user, $mysql_password);
        if (!$mysql_conn) $mysql_conn = mysql_connect($mysql_host, $mysql_user, $mysql_password);
		
		//do stuff
        if ($mysql_conn){
            if (mysql_select_db($mysql_db)){
				//format sql statement
                if (($opCode==1) || ($opCode==2)){
                    $sql = Array2SQL($backend_table, $backend_array, $backend_operation);
                    if ($opCode==2){	
                        if (($backend_dataID > 0) && (empty($backend_where)))
                            $sql .= " WHERE id='$backend_dataID'";
                        else if (!empty($backend_where)){
                            $sql .= " WHERE $backend_where";
                        }else{
                            $sql = "";
                        }
                    }
                }else if ($opCode==3) $sql = "DELETE FROM $backend_table WHERE id='$backend_dataID'";
                else $sql = "";
                                
				//run query
                if (!empty($sql))
                    if (!mysql_query($sql)) $error.="MySQL: $backend_operation failed:".$sql."<br>\n";
            
            }else{
                $error.="MySQL: Couldn't select DB '$mysql_db' (".mysql_error().")<br>\n";
            }
            //mysql_close($mysql_conn);
        }else{
            $error.="MySQL: Couldn't access DB at $mysql_host (".mysql_error().")<br>\n";
        }
    }else{
        $error .= $be_error;
    }
?>
