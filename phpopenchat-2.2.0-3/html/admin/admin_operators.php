<?//-*- C++ -*-
/*   ********************************************************************   **
**   Copyright (C) 1995-2000 Michael Oertel                                 **
**   Copyright (C) 2000-     PHPOpenChat Development Team                   **
**   http://www.ortelius.de/phpopenchat/                                    **
**                                                                          **
**   This program is free software. You can redistribute it and/or modify   **
**   it under the terms of the PHPOpenChat License Version 1.0              **
**                                                                          **
**   This program is distributed in the hope that it will be useful,        **
**   but WITHOUT ANY WARRANTY, without even the implied warranty of         **
**   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.                   **
**                                                                          **
**   You should have received a copy of the PHPOpenChat License             **
**   along with this program.                                               **
**   ********************************************************************   */

/*
    Used variables in this module :

*/

// include all needed files
include ("defaults_inc.php");
include ("connect_db_inc.php");

// Open database connection
if ( ! $db_handle=connect_db($DATABASEHOST,$DATABASEUSER,$DATABASEPASSWD)) { exit; }

// select all moderators form database
$SQL = 'SELECT Nick FROM paten';
$db_result = mysql_query ($SQL, $db_handle);

// write data from database to an array ($ar_moderators)
$counter = 0;
while ($dbdata = mysql_fetch_array($db_result))
{
    $ar_operators[$counter] = $dbdata[Nick];
    $counter++;
}

switch ($action)
{
    // add operator
    case add:

        // check, if the Nick is generally in the database
        if ($data_nick != "")
        {
            $SQL = "SELECT Nick FROM chat_data WHERE Nick='$data_nick'";
            $db_result = mysql_query ($SQL, $db_handle);
            if (mysql_num_rows ($db_result) == 0) { $err_message = $MSG_ADM_OPERATORS_ERROR_NONICK; }
        }

        if ($data_nick == "") { $err_message = $MSG_ADM_OPERATORS_ERROR_EMPTY ; }

        if ($err_message != "")
        {
            // include template until data is correct
            include ("admin_operators.tpl.$FILE_EXTENSION");
        }
        else
        {
            $SQL = "INSERT INTO paten (Nick) VALUES ('$data_nick')";
            //echo $SQL;
            $db_result = mysql_query ($SQL, $db_handle);
            header ("location: admin_operators.$FILE_EXTENSION");
        }

        break;


    // Delete operator
    case delete:

        $SQL = "DELETE FROM paten WHERE Nick='$data_nick'";
        $db_result = mysql_query ($SQL, $db_handle);
        header ("location: admin_operators.$FILE_EXTENSION");
        break;


    // Default view for operator-administration
    default:

        // include template
        include ("admin_operators.tpl.$FILE_EXTENSION");
}


?>