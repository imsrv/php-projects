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

switch ($action)
{
    // add moderator
    case add:

        // check, if the Nick is generally in the database
        $SQL = "SELECT Nick FROM chat_data WHERE Nick='$data_nick'";
        $db_result = mysql_query ($SQL, $db_handle);
        if (mysql_num_rows ($db_result) == 0)
        {
            $err_message = $MSG_ADM_MODERATORS_ERROR_NONICK;
            // include template until data is correct
            include ("admin_moderators.tpl.$FILE_EXTENSION");

        }
        else
        {
            $SQL = "INSERT INTO paten (Nick) VALUES ('$data_nick')";
            //echo $SQL;
            $db_result = mysql_query ($SQL, $db_handle);
            header ("location: admin_moderators.$FILE_EXTENSION");
        }

        break;


    // Delete moderator
    case delete:

        $SQL = "DELETE FROM paten WHERE Nick='$data_nick'";
        $db_result = mysql_query ($SQL, $db_handle);
        header ("location: admin_moderators.$FILE_EXTENSION");
        break;


    // Default view for moderator-administration
    default:

        // select all moderators form database
        $SQL = 'SELECT Nick FROM paten';
        $db_result = mysql_query ($SQL, $db_handle);

        // write data from database to an array ($ar_moderators)
        $counter = 0;
        while ($dbdata = mysql_fetch_array($db_result))
        {
            $ar_moderators[$counter] = $dbdata[Nick];
            $counter++;
        }

        // include template
        include ("admin_moderators.tpl.$FILE_EXTENSION");
}


?>