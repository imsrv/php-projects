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
$SQL = "SELECT ID, NICK, TIME, SUBJECT, BODY FROM chat_mail WHERE SENDER='system_message'";
$db_result = mysql_query ($SQL, $db_handle);

// write data from database to an array's
$counter = 0;
while ($dbdata = mysql_fetch_array($db_result))
{
    $ar_mailall_ID[$counter] = $dbdata[ID];
    $ar_mailall_time[$counter] = $dbdata[TIME];
    $ar_mailall_body[$counter] = $dbdata[BODY];
    $ar_mailall_reciever[$counter] = $dbdata[NICK];
    $ar_mailall_subject[$counter] = substr ($dbdata[SUBJECT], 0,25);
    if (strlen($dbdata[SUBJECT]) > 25) { $ar_mailall_subject[$counter] .= "  [...]"; }

    if ($ar_mailall_reciever[$counter] == "all") { $ar_mailall_reciever[$counter] = $MSG_ADM_MAILALL_ALLUSERS; }
    if ($ar_mailall_reciever[$counter] == "operators") { $ar_mailall_reciever[$counter] = $MSG_ADM_MAILALL_OPERATORS; }
    if ($ar_mailall_reciever[$counter] == "comoderators") { $ar_mailall_reciever[$counter] = $MSG_ADM_MAILALL_COMODERATORS; }

    $counter++;
}

switch ($action)
{
    // Create new mass-mail
    case create:

        // include template
        include ("admin_mailall_create.tpl.$FILE_EXTENSION");

        break;

    // send messages
    case send:

        // check the validty of the input
        if ($data_body == "") { $err_message =$MSG_ADM_MAILALL_ERROR_BODY; }
        if ($data_subject == "") { $err_message =$MSG_ADM_MAILALL_ERROR_SUBJECT; }

        if ($err_message != "")
        {
            // include template
            include ("admin_mailall_create.tpl.$FILE_EXTENSION");
        }
        else
        {
            $data_subject = strip_tags($data_subject);
            $data_subject = str_replace("'","&#39",$data_subject);

            // select all nicks from database
            if ($data_reciever == $MSG_ADM_MAILALL_ALLUSERS)
            {
                $system_reciever = "all";
                $SQL_nicks = "SELECT Nick FROM chat_data WHERE Nick <> '$TEAM_NAME'";
            }

            if ($data_reciever == $MSG_ADM_MAILALL_OPERATORS)
            {
                $system_reciever = "operators";
                $SQL_nicks = "SELECT Nick FROM paten";
            }

            if ($data_reciever == $MSG_ADM_MAILALL_COMODERATORS)
            {
                $system_reciever = "comoderators";
                $SQL_nicks = "SELECT Nick FROM comoderators";
            }

            // execute SQL-Statement
            $db_result_nicks = mysql_query ($SQL_nicks, $db_handle);

            $data_sender = $TEAM_NAME;

            while ($data_nicks = mysql_fetch_array($db_result_nicks))
            {
                $data_nick = $data_nicks[Nick];
                $SQL_mail = "INSERT INTO chat_mail (NICK,SENDER,BODY,TIME,SUBJECT,UNREAD)VALUES('$data_nick','$data_sender','$data_body',CURRENT_TIMESTAMP(),'$data_subject', 1)";
                $db_result_mail = mysql_query ($SQL_mail, $db_handle);
            }


            // write mail in administrator mailbox
            $SQL = "INSERT INTO chat_mail (NICK,SENDER,BODY,TIME,SUBJECT,UNREAD)VALUES('$system_reciever','system_message','$data_body',CURRENT_TIMESTAMP(),'$data_subject',6)";
            $db_result = mysql_query ($SQL, $db_handle);

            header ("location: admin_mailall.$FILE_EXTENSION");
        }

        break;

    // Show written mass-mail
    case show:

        $SQL = "SELECT NICK, TIME, SUBJECT, BODY FROM chat_mail WHERE ID=$ID";
        $db_result = mysql_query ($SQL, $db_handle);

        // write data from database to an array's
        while ($dbdata = mysql_fetch_array($db_result))
        {
            $data_date = $dbdata[TIME];
            $data_body = nl2br($dbdata[BODY]);
            $data_reciever = $dbdata[NICK];
            $data_subject = $dbdata[SUBJECT];
        }

        if ($data_reciever == "all") { $data_reciever = $MSG_ADM_MAILALL_ALLUSERS; }
        if ($data_reciever == "operators") { $data_reciever = $MSG_ADM_MAILALL_OPERATORS; }
        if ($data_reciever == "comoderators") { $data_reciever = $MSG_ADM_MAILALL_COMODERATORS; }

        // include template
        include ("admin_mailall_show.tpl.$FILE_EXTENSION");

        break;

    // Delete written mass-mail
    case delete:

        $SQL ="delete from chat_mail where ID=$ID";
        $db_result = mysql_query ($SQL, $db_handle);
        header ("location: admin_mailall.$FILE_EXTENSION");
        break;


    // Default view for Mass-mail interface
    default:

        // include template
        include ("admin_mailall.tpl.$FILE_EXTENSION");
}


?>