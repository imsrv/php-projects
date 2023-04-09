<?php
/**
 *
 * Mysql database abstraction layer
 * 
 * @author Karolis Tamutis
 * @date 2005-08-16
 * @file database-mysql.php
 *
 * Copyright (C) 2005  Karolis Tamutis
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA. 
 */ 
 
if (!defined('MAIN')) {

    die('No direct access.');

}

class sDatabase {
    /**
     * 
     * Database resource id
     *
     * @var object
     */
    var $_dbId;
    
    /**
     *
     * Constructor
     *
     * @param array $_config array with configurational data
     */
    function sDatabase($_config) {

        $this->_dbId = mysql_connect($_config['DB_HOST'].$_config['DB_SOCK'], $_config['DB_USER'], $_config['DB_PASS']);

        mysql_select_db($_config['DB_NAME'], $this->_dbId); 

        /* $this->query('SET NAMES "utf8"'); Mysql utf-8 fix */

    }

    /**
     *
     * Method to execute sql queries
     *
     * @TODO implement error handling
     * @param string $query sql query to be executed
     */    
    function query($query) {
    
        $rs = mysql_query($query,$this->_dbId) or die('Error: '.mysql_error());
        return $rs;
        
    }
    
    /**
     *
     * Method to return an array from query resource
     *
     * @param mixed $rs database query resource
     * @param string $type result type
     */
     function getArray($rs, $type = MYSQL_ASSOC) {
     
        $arr = null;
        while($row = mysql_fetch_array($rs, $type)) {
            $arr[] = $row; 
        }           
        return $arr;
        
     }
     
    /**
     *
     * Method to return a single row from query resource
     *
     * @param mixed $rs database query resource
     * @param int $rowNr row number to be returned
     */ 
     function getRow($rs, $rowNr = MYSQL_ASSOC) {
     
        $row = $this->getArray($rs);
        $row = $row[$rowNr];
        
        return $row;
     
     }
     
    /**
     *
     * Method to cound rows returned by the query
     *
     * @param mixed $rs database query resource
     */ 
     function countRows($rs) {
     
        return mysql_num_rows($rs);
     
     }

    /**
     * 
     * Method to free result memory. Check comments on php.net - don't use with PHP 4. 
     *
     * @param mixed $rs database query resource
     */
    function free($rs) {

        mysql_free_result($rs);

    }

    /**
     *
     * Method to close database connection
     *
     */    
    function close() {

        @mysql_close($this->_dbId);
    } 
}
?>