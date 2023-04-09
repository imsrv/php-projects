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

    // Create new forum topic
    case create:

        $data_initmsg = $MSG_ADM_FORUM_INITMSG_TEXT;

        // include template
        include ("admin_forum_topic.tpl.$FILE_EXTENSION");

        break;

    // Save new or edited topic
    case save:

        // check user input
        if ($data_initmsg == "") { $err_message = $MSG_ADM_FORUM_ERROR_INITMSG; }
        if ($data_topic == "") { $err_message = $MSG_ADM_FORUM_ERROR_TOPIC; }

        if ($err_message != "")
        {
            // include template
            include ("admin_forum_topic.tpl.$FILE_EXTENSION");
        }
        else
        {
            $data_date = date ("Y-m-d H:i:s");
            $data_name = 'Forum Admin';
            $data_host = $REMOTE_ADDR;

            $SQL = "insert into chat_forum (DATE, NAME, KOMMENTAR, HOST, THEMA) values ('$data_date', '$data_name', '$data_initmsg', '$data_host', '$data_topic')";
            $db_result = mysql_query ($SQL, $db_handle);
            header ("location: admin_forum.$FILE_EXTENSION");
        }

        break;

    // Save edited message
    case savemsg:

        // check the validty of the input
        if ($data_comment == "") { $err_message =$MSG_ADM_FORUM_ERROR_COMMENT; }
        if ($data_name == "") { $err_message =$MSG_ADM_FORUM_ERROR_NICK; }

        if ($err_message != "")
        {
            // include template
            include ("admin_forum_msg_edit.tpl.$FILE_EXTENSION");
        }
        else
        {
            $SQL = "UPDATE chat_forum SET NAME='$data_name', KOMMENTAR='$data_comment', EMAIL='$data_email', HOMEPAGE='$data_homepage' WHERE NUMMER=$ID";
            $db_result = mysql_query ($SQL, $db_handle);
            header ("location: admin_forum.$FILE_EXTENSION?action=messages&topic=$topic");
        }

        break;

    // edit forum-message
    case editmsg:

        // get selected message from database
        $SQL = "SELECT NAME, DATE, EMAIL, HOMEPAGE, KOMMENTAR FROM chat_forum WHERE NUMMER=$ID";
        $db_result = mysql_query ($SQL, $db_handle);

        // write data from database to arrays
        while ($dbdata = mysql_fetch_array($db_result))
        {
            $data_comment = $dbdata[KOMMENTAR];
            $data_date = $dbdata[DATE];
            $data_name = $dbdata[NAME];
            $data_email = $dbdata[EMAIL];
            $data_homepage = $dbdata[HOMEPAGE];
        }

        // include template
        include ("admin_forum_msg_edit.tpl.$FILE_EXTENSION");

        break;

    // delete existing topic
    case delete:

        $SQL = "DELETE FROM chat_forum WHERE THEMA='$topic'";
        $db_result = mysql_query ($SQL, $db_handle);
        header ("location: admin_forum.$FILE_EXTENSION");
        break;

    // delete forum-message
    case deletemsg:

        $SQL = "DELETE FROM chat_forum WHERE NUMMER=$ID";
        $db_result = mysql_query ($SQL, $db_handle);

        $SQL = "SELECT NUMMER FROM chat_forum WHERE THEMA='$dbdata[THEMA]'";
        $db_result = mysql_query ($SQL, $db_handle);
        $msgcount = mysql_num_rows ($db_result);

        if ($msgcount > 0)
            { header ("location: admin_forum.$FILE_EXTENSION?action=messages&topic=$topic"); }

        if ($msgcount == 0)
            { header ("location: admin_forum.$FILE_EXTENSION"); }

        break;

    // edit forum-messages
    case messages:

        // set the maximum number of messages shown on one page
        $msg_limit = 20;

        // get number of messages for the selected topic
        $SQL = "SELECT THEMA FROM chat_forum WHERE THEMA='$topic'";
        $db_result = mysql_query ($SQL, $db_handle);
        $msg_count = mysql_num_rows($db_result);

        // process $msgnav-Variable (not set at first page-impression)
        if ( isset ($msgnav))
        {
            switch ($msgnav)
            {
                case first:
                    $msg_start = 1;
                    break;

                case prev:
                    if ($msg_start - $msg_limit > 1) { $msg_start = $msg_start - $msg_limit; }
                    break;

                case next:
                    $msg_start = $msg_start + $msg_limit +1;
                    if ($msg_start > $msg_count) { $msg_start = 1; }
                    break;

                case last:
                    $msg_start = $msg_count - $msg_limit +1;
                    if ($msg_start < 0) {$msg_start=1; }
                    break;
            }
        }

        // set start-colum if not set (at first page impression)
        if ( ! isset ($msg_start)) { $msg_start = 1; }

        // set stop-colum
        $msg_stop = $msg_start + $msg_limit;
        if ($msg_stop > $msg_count) { $msg_stop = $msg_count; }

        $sql_start = $msg_start -1;

        // select a number of messages in range of $msg_start to $msg_stop
        $SQL = "SELECT NUMMER, NAME, DATE, KOMMENTAR FROM chat_forum WHERE THEMA='$topic' LIMIT $sql_start, $msg_limit";
        $db_result = mysql_query ($SQL, $db_handle);

        // write data from database to arrays
        $counter = 0;
        while ($dbdata = mysql_fetch_array($db_result))
        {
            $ar_msg_comment[$counter] = substr ($dbdata[KOMMENTAR], 0, 20);
            if (strlen($dbdata[KOMMENTAR]) > 20) { $ar_msg_comment[$counter] .= "  [...]"; }

            $ar_msg_number[$counter] = $dbdata[NUMMER];
            $ar_msg_topic[$counter] = $dbdata[THEMA];
            $ar_msg_date[$counter] = $dbdata[DATE];
            $ar_msg_name[$counter] = $dbdata[NAME];
            $counter++;
        }

        // include template
        include ("admin_forum_messages.tpl.$FILE_EXTENSION");

        break;

    // Default view for forum-administration
    default:

        // select all Topic's form database
        $SQL = 'SELECT distinct THEMA from chat_forum';
        $db_result = mysql_query ($SQL, $db_handle);

        // write data from database to an array ($ar_topic)
        $counter = 0;
        while ($dbdata = mysql_fetch_array($db_result))
        {
            $ar_topic[$counter] = $dbdata[THEMA];

            $SQL = "SELECT NUMMER FROM chat_forum WHERE THEMA='$dbdata[THEMA]'";
            $msgcount_result = mysql_query ($SQL, $db_handle);
            $ar_topic_msgcount[$counter] = mysql_num_rows ($msgcount_result);
            $counter++;
        }

        // include template
        include ("admin_forum.tpl.$FILE_EXTENSION");
}


?>

