<?php
/**
 *
 * Database abstraction class
 * 
 * @author Karolis Tamutis <karolis.t@NO_SPAM_TO_THIS_EMAIL.gmail.com>
 * @date 2005-08-16
 * @file database.php
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

class Database {
    /**
     * 
     * Variable to hold the initialized database object
     *
     * @var object
     */
    var $_db;
    
    /**
     *
     * Constructor, selects the defined database type and initializes its object
     *
     * @param array $config engine config
     */
    function Database($config) {
        
        switch($config['DB_TYPE']) {
            case 'mysql':
                require_once('database-mysql.php');
                break;
            case 'pgsql':
                require_once('database-pgsql.php');
                break;
            default:
                require_once('database-mysql.php');
                break;
        }

        $this->_db = & new sDatabase($config);
    
    }
    
    /**
     *
     * Method to execute sql queries
     *
     * @param string $query sql query to be executed
     */
    function query($query) {
    
        return $this->_db->query($query);
        
    }
    
    /**
     *
     * Method to return an array from query resource
     *
     * @param mixed $rs database query resource
     * @param string $type result type
     */
     function getArray($rs, $type = MYSQL_ASSOC) {
     
        return $this->_db->getArray($rs, $type);
             
     }
     
    /**
     *
     * Method to return a single row from query resource
     *
     * @param mixed $rs database query resource
     * @param int $rowNr row number to be returned
     */ 
     function getRow($rs, $rowNr = 0) {

        return $this->_db->getRow($rs, $rowNr);     
     
     }
     
    /**
     *
     * Method to cound rows returned by the query
     *
     * @param mixed $rs database query resource
     */ 
     function countRows($rs) {
     
        return $this->_db->countRows($rs);
     
     }

    /**
     * 
     * Method to free result memory. Check comments on php.net - don't use with PHP 4. 
     *
     * @param mixed $rs database query resource
     */
    function free($rs) {

        return $this->_db->free($rs);

    }
    
    /**
     *
     * Method to close database connection
     *
     */
    function close() {

        $this->_db->close();

    }
    
}
?>