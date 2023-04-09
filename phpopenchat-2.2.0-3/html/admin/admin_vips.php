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
    // create vip
    case create:

        // read all channel-names from database
        $SQL = "SELECT Name FROM channels WHERE User_Channel = 0";
        $db_result = mysql_query ($SQL, $db_handle);

        // write data from database to an array ($ar_vip_channels)
        $counter = 0;
        while ($dbdata = mysql_fetch_array($db_result))
        {
            $ar_vip_channellist[$counter] = $dbdata[Name];
            $counter++;
        }

        // include template
        include ("admin_vips_create.tpl.$FILE_EXTENSION");


        break;

    // save vip
    case save:

        // check, if the moderator is a registrated chatter
        $SQL = "SELECT Nick FROM chat_data WHERE Nick='$data_moderator'";
        $db_result = mysql_query ($SQL, $db_handle);
        if (mysql_num_rows ($db_result) == 0) { $err_message = $MSG_ADM_VIPS_ERROR_MODERATOR2; }

        // Check input field moderator
        if ($data_moderator == "") { $err_message = $MSG_ADM_VIPS_ERROR_MODERATOR1; }

        // check, if the vip is already in the database
        $SQL = "SELECT Nick FROM vip WHERE Nick='$data_nick'";
        $db_result = mysql_query ($SQL, $db_handle);
        if (mysql_num_rows ($db_result) != 0) { $err_message = $MSG_ADM_VIPS_ERROR_VIP2; }

        // Check input field VIP
        if ($data_nick == "") { $err_message = $MSG_ADM_VIPS_ERROR_VIP1; }

        if ($err_message == "")
        {
            $SQL = "INSERT INTO vip (Nick, Moderator, Channel) VALUES ('$data_nick', '$data_moderator', '$data_channel')";
            $db_result = mysql_query ($SQL, $db_handle);
            header ("location: admin_vips.$FILE_EXTENSION");
        }
        else
        {
            // read all channel-names from database
            $SQL = "SELECT Name FROM channels WHERE User_Channel = 0";
            $db_result = mysql_query ($SQL, $db_handle);

            // write data from database to an array ($ar_vip_channels)
            $counter = 0;
            while ($dbdata = mysql_fetch_array($db_result))
            {
                $ar_vip_channellist[$counter] = $dbdata[Name];
                $counter++;
            }

            // include template until data is correct
            include ("admin_vips_create.tpl.$FILE_EXTENSION");
        }

        break;


    // Delete vip
    case delete:

        $SQL = "DELETE FROM vip WHERE Nick='$data_nick'";
        $db_result = mysql_query ($SQL, $db_handle);
        header ("location: admin_vips.$FILE_EXTENSION");
        break;


    // Default view for moderator-administration
    default:

        // select all vips form database
        $SQL = 'SELECT Nick, Moderator, Channel FROM vip';
        $db_result = mysql_query ($SQL, $db_handle);

        // write data from database to an array ($ar_moderators)
        $counter = 0;
        while ($dbdata = mysql_fetch_array($db_result))
        {
            $ar_vip_nick[$counter] = $dbdata[Nick];
            $ar_vip_moderator[$counter] = $dbdata[Moderator];
            $ar_vip_channel[$counter] = $dbdata[Channel];
            $counter++;
        }

        // include template
        include ("admin_vips.tpl.$FILE_EXTENSION");
}


?>