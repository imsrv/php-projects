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
    // save hints
    case save:

        $SQL  = "UPDATE chat_messages SET Message_0='$data_Message_0', Message_1='$data_Message_1', Message_2='$data_Message_2', Message_3='$data_Message_3', Message_4='$data_Message_4',";
        $SQL .= "Message_5='$data_Message_5', Message_6='$data_Message_6', Message_7='$data_Message_7', Message_8='$data_Message_8', Message_9='$data_Message_9'";
        $db_result = mysql_query ($SQL, $db_handle);

        header ("location: admin_hints.$FILE_EXTENSION");
        break;

    // Default view for hints-administration
    default:

        // select all moderators form database
        $SQL = 'SELECT * FROM chat_messages';
        $db_result = mysql_query ($SQL, $db_handle);
        $dbdata = mysql_fetch_array($db_result);

        $data_Message[0] = $dbdata[Message_0];
        $data_Message[1] = $dbdata[Message_1];
        $data_Message[2] = $dbdata[Message_2];
        $data_Message[3] = $dbdata[Message_3];
        $data_Message[4] = $dbdata[Message_4];
        $data_Message[5] = $dbdata[Message_5];
        $data_Message[6] = $dbdata[Message_6];
        $data_Message[7] = $dbdata[Message_7];
        $data_Message[8] = $dbdata[Message_8];
        $data_Message[9] = $dbdata[Message_9];

        // include template
        include ("admin_hints.tpl.$FILE_EXTENSION");
}


?>