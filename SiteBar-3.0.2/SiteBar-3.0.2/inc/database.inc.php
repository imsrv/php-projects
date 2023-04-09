<?
/******************************************************************************
 *  SiteBar 3 - The Bookmark Server for Personal and Team Use.                *
 *  Copyright (C) 2003  Ondrej Brablc <sitebar@brablc.com>                    *
 *                                                                            *
 *  This program is free software; you can redistribute it and/or modify      *
 *  it under the terms of the GNU General Public License as published by      *
 *  the Free Software Foundation; either version 2 of the License, or         *
 *  (at your option) any later version.                                       *
 *                                                                            *
 *  This program is distributed in the hope that it will be useful,           *
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of            *
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             *
 *  GNU General Public License for more details.                              *
 *                                                                            *
 *  You should have received a copy of the GNU General Public License         *
 *  along with this program; if not, write to the Free Software               *
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA *
 ******************************************************************************/

define ( "CURRENT_RELEASE", "3.0.2");

class Database
{
    var $connection = null;
    var $name;
    var $user;
    var $lastsql;

    function Database($ignoreError=false)
    {
        include('./inc/config.inc.php');
        $config = $SITEBAR['db'];
        $this->name = $config['name'];
        $this->connection = $this->connect($config['host'], $config['username'], $config['password']);

        if (!$this->connection)
        {
            if (!$ignoreError)
            {
                echo mysql_error();
                die('Cannot connect to database server!');
            }
            return;
        }

        if (!@mysql_select_db($config['name']))
        {
            if (!$ignoreError)
            {
                die('Database <b>'. $this->name . '</b> does not exist!');
            }
            $this->connection = null;
            return;
        }
    }

    function currentRelease()
    {
        return CURRENT_RELEASE;
    }

    function & staticInstance()
    {
        static $db;

        if (!$db)
        {
            $db = new Database();
        }

        return $db;
    }

    function close()
    {
        mysql_close($this->connection);
        $this->connection = null;
    }

    function dieOnError($result, $ignore = null)
    {
        if (!$result && (!$ignore || !in_array($this->getErrorCode(), $ignore)))
        {
            echo('<b>Invalid query:</b> ' . $this->getErrorCode() . ': ' .
                mysql_error());
            echo '<p>';
            echo '<pre>';
            echo  htmlspecialchars($this->lastsql);
            echo '</pre>';
            die();
        }
    }

    function getErrorCode()
    {
        return mysql_errno();
    }

    function getErrorText()
    {
        return mysql_error();
    }

    function getAffectedRows()
    {
        return mysql_affected_rows();
    }

    function getLastId()
    {
        return mysql_insert_id();
    }

    function hasTable($table)
    {
        $fields = @mysql_list_fields($this->name,$table);
        return $fields;
    }

    function hasDB($db)
    {
        return @mysql_select_db($db);
    }

    function createDB($db)
    {
        return mysql_query('CREATE DATABASE ' . $db);
    }

    function raw($sql)
    {
        return mysql_query($sql);
    }

    function connect($host, $user, $pass)
    {
        return @mysql_connect($host, $user, $pass);
    }

    function select( $columns, $table, $where=null, $order=null)
    {
        $sql  = 'SELECT ' .
            ($columns?(is_array($columns)?implode(',',$columns):$columns):'*') .
            "\nFROM " . $table;
        $sql .= $this->buildWhere($where);

        if ($order)
        {
            $sql .= "\nORDER BY " . $order . "\n";
        }

        $this->lastsql = $sql;
        $result = mysql_query($sql);
        $this->dieOnError($result);
        return $result;
    }

    function insert( $table, $pairs, $ignore = null)
    {
        $values = array();

        foreach (array_values($pairs) as $value)
        {
            $values[] = $this->quoteValue($value);
        }

        $sql  = 'INSERT INTO ' . $table . ' ';
        $sql .= '(' . implode(', ',array_keys($pairs)) . ")\n";
        $sql .= 'VALUES ('. implode(', ', $values) .  ')';

        $this->lastsql = $sql;
        $result = mysql_query($sql);
        $this->dieOnError($result, $ignore);
        return $result;
    }

    function delete( $table, $where)
    {
        $sql  = 'DELETE FROM ' . $table . "\n";
        $sql .= $this->buildWhere($where);

        $this->lastsql = $sql;
        $result = mysql_query($sql);
        $this->dieOnError($result);
        return $result;
    }

    function update( $table, $pairs, $where=null, $ignore=null)
    {
        $sql = 'UPDATE ' . $table. "\nSET ";
        $set = array();

        if (is_array($pairs))
        {
            foreach ($pairs as $column => $value)
            {
                $set[] = $column . '=' . $this->quoteValue($value);
            }
        }
        else
        {
            $set[] = $pairs;
        }

        $sql .= implode(', ', $set);
        $sql .= $this->buildWhere($where);

        $this->lastsql = $sql;
        $result = mysql_query($sql);
        $this->dieOnError($result, $ignore);
        return $result;
    }

    function buildWhere($where)
    {
        $sql = '';

        if ($where)
        {
            $sql .= "\nWHERE ";
            foreach ($where as $filter => $value)
            {
                if (substr($filter,0,1) == '^')
                {
                    $sql .= ' ' . $value . ' ';
                }
                else
                {
                    $qval = $this->quoteValue($value);
                    $sql .= ' ' . $filter . ($qval==='NULL'?' is ':'=') . $qval;
                }
            }
        }

        return $sql;
    }

    function quoteValue($value)
    {
        if (is_numeric($value))
        {
            return $value;
        }
        elseif (is_array($value))
        {
            $val  = key($value) . '(';
            $val .= $value[key($value)]
                    ?$this->quoteValue($value[key($value)]):'';
            $val .= ') ';
            return $val;
        }
        elseif ($value === null)
        {
            return 'NULL';
        }
        else
        {
            return "'" . mysql_escape_string($value) . "'";
        }
    }

    function _unescape(&$item, $key)
    {
        if (!is_numeric($item))
        {
            $item = stripslashes($item);
        }
    }

    function fetchRecord($request)
    {
        $record = mysql_fetch_array($request, MYSQL_ASSOC);
        if (!$record)
        {
            return false;
        }
        else
        {
            array_walk($record, array( $this, '_unescape'));
            return $record;
        }
    }

    function fetchRecords($request)
    {
        $records = array();

        while (($record = mysql_fetch_array($request, MYSQL_ASSOC)))
        {
            array_walk($record, array( $this, '_unescape'));
            $records[] = $record;
        }

        return $records;
    }
}

?>