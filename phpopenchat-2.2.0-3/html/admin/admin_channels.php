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

    $MSG_ADM_PAGETITLE
    $MSG_ADM_CHANNELS
    $MSG_ADM_CHANNELNAME
    $MSG_ADM_EDITCHANNEL
    $MSG_ADM_DELETECHANNEL
    $MSG_ADM_NEWCHANNEL
    $MSG_ADM_CLEAR_LINES

    $PHP_SELF
    $index
    $ar_channelname
    $ar_channelID

*/

// include all needed files
include ("defaults_inc.php");
include ("connect_db_inc.php");

// Open database connection
if ( ! $db_handle=connect_db($DATABASEHOST,$DATABASEUSER,$DATABASEPASSWD)) { exit; }

switch ($action)
{

    // Create new channel
    case create:

        $data_startyear = date ("Y");
        $data_stopyear = "9999";
        $data_Logo = $LOGO;
        $data_ExitURL = $INSTALL_DIR;
        $data_BG_Color = $DEFAULT_BG_COLOR;
        $data_NICK_COLOR = $DEFAULT_TEXT_COLOR;

        // include template
        include ("admin_channels_create.tpl.$FILE_EXTENSION");

        break;

    // edit existing channel
    case edit:

        $SQL = "SELECT Name, PASSWORD, These, Teilnehmerzahl, BG_Color, Logo, ExitURL, moderiert, starts_at, stops_at, NICK_COLOR FROM channels WHERE id=$ID";
        $db_result = mysql_query ($SQL, $db_handle);
        $fielddata = mysql_fetch_array($db_result);

        // Init variables for use in the input-fields
        $data_Name = $fielddata[Name];
        $data_PASSWORD = $fielddata[PASSWORD];
        $data_These = $fielddata[These];
        $data_Teilnehmerzahl = $fielddata[Teilnehmerzahl];
        $data_BG_Color = $fielddata[BG_Color];
        $data_NICK_COLOR = $fielddata[NICK_COLOR];
        $data_Logo = $fielddata[Logo];
        $data_ExitURL = $fielddata[ExitURL];
        $data_moderiert = $fielddata[moderiert];

        $data_startyear = date ("Y");
        $data_stopyear = "9999";

        // read date/time - information from the database
        // split year, month, day, hour, minute and second in seperate variables
        $data_startyear = substr ($fielddata[starts_at], 0, 4);
        $data_startmonth = substr ($fielddata[starts_at], 5, 2);
        $data_startday = substr ($fielddata[starts_at], 8, 2);
        $data_starthour = substr ($fielddata[starts_at], 11, 2);
        $data_startminute = substr ($fielddata[starts_at], 14, 2);
        $data_startsecond = substr ($fielddata[starts_at], 17, 2);

        $data_stopyear = substr ($fielddata[stops_at], 0, 4);
        $data_stopmonth = substr ($fielddata[stops_at], 5, 2);
        $data_stopday = substr ($fielddata[stops_at], 8, 2);
        $data_stophour = substr ($fielddata[stops_at], 11, 2);
        $data_stopminute = substr ($fielddata[stops_at], 14, 2);
        $data_stopsecond = substr ($fielddata[stops_at], 17, 2);

        // include template
        include ("admin_channels_edit.tpl.$FILE_EXTENSION");
        break;

    // Save new or edited channel
    case save:

        // check values of the input data
        if (strlen($data_stopyear) < 4) { $err_message = $MSG_ADM_CHANNEL_ERROR_YEAR; }
        if (strlen($data_startyear) < 4) { $err_message = $MSG_ADM_CHANNEL_ERROR_YEAR; }
        if ($data_Teilnehmerzahl == "") { $data_Teilnehmerzahl = 0; }
        if ($data_BG_Color == $data_NICK_COLOR) { $err_message = $MSG_ADM_CHANNEL_ERROR_SAMECOLOR; }
        if ($data_ExitURL == "") { $err_message = $MSG_ADM_CHANNEL_ERROR_EXITURL; }
        if ($data_Logo == "") { $err_message = $MSG_ADM_CHANNEL_ERROR_LOGO; }
        if ($data_NICK_COLOR == "") { $err_message = $MSG_ADM_CHANNEL_ERROR_NICKCOLOR; }
        if ($data_BG_Color == "") { $err_message = $MSG_ADM_CHANNEL_ERROR_BGCOLOR; }
        if ($data_Name == "") { $err_message = $MSG_ADM_CHANNEL_ERROR_NAME; }

        if  ($err_message == "")
        {
            // All data is correct. Save it to the database
            $data_starts_at = "$data_startyear-$data_startmonth-$data_startday $data_starthour:$data_startminute:$data_startsecond";
            $data_stops_at = "$data_stopyear-$data_stopmonth-$data_stopday $data_stophour:$data_stopminute:$data_stopsecond";

            if ($from_module == "edit")
            {
                // Update edited data
                $SQL = "UPDATE channels SET Name='$data_Name', PASSWORD='$data_PASSWORD', These='$data_These', Teilnehmerzahl=$data_Teilnehmerzahl, BG_Color='$data_BG_Color', Logo='$data_Logo', ExitURL='$data_ExitURL', moderiert=$data_moderiert, starts_at='$data_starts_at', stops_at='$data_stops_at', NICK_COLOR='$data_NICK_COLOR' WHERE id=$ID";
                $db_result = mysql_query ($SQL, $db_handle);
            }
            elseif ($from_module == "create")
            {
                // Insert new channel data
                $SQL  = "INSERT INTO channels (Name, PASSWORD, These, Teilnehmerzahl, BG_Color, Logo, ExitURL, moderiert, starts_at, stops_at, NICK_COLOR, Allow, zeile_0)";
                $SQL .= "VALUES ('$data_Name', '$data_PASSWORD', '$data_These', $data_Teilnehmerzahl, '$data_BG_Color', '$data_Logo', '$data_ExitURL', $data_moderiert, '$data_starts_at', '$data_stops_at', '$data_NICK_COLOR', '', '')";
                $db_result = mysql_query ($SQL, $db_handle);
            }

            header ("location: admin_channels.$FILE_EXTENSION");
        }
        else
        {
            // include template again, until all data is correct
            include ("admin_channels_edit.tpl.$FILE_EXTENSION");
        }

        break;

    // Delete existing channel
    case delete:

        // delete channel
        $SQL = "DELETE FROM channels WHERE id=$ID";
        $db_result = mysql_query ($SQL, $db_handle);
        header ("location: admin_channels.$FILE_EXTENSION");
        break;

    // Clean up all text-colums
    case clean;

        $SQL = "UPDATE channels SET zeile_0='',zeile_39='',zeile_38='',zeile_37='',zeile_36='',zeile_35='',zeile_34='',zeile_33='',zeile_32='',zeile_31='',zeile_30='',zeile_29='',zeile_28='',zeile_27='',zeile_26='',zeile_25='',zeile_24='',zeile_23='',zeile_22='',zeile_21='',zeile_20='',zeile_19='',zeile_18='',zeile_17='',zeile_16='',zeile_15='',zeile_14='',zeile_13='',zeile_12='',zeile_11='',zeile_10='',zeile_9='',zeile_8='',zeile_7='',zeile_6='',zeile_5='',zeile_4='',zeile_3='',zeile_2='',zeile_1='',zeile=0 WHERE Id=$ID";
        $db_result = mysql_query ($SQL, $db_handle);
        header ("location: admin_channels.$FILE_EXTENSION");
        break;

    // Default view for channel-administration
    default:

        // select all permanent channels from database
        $SQL = 'SELECT id, Name FROM channels WHERE User_Channel = 0';
        $db_result = mysql_query ($SQL, $db_handle);

        // write data from database to an array ($ar_channelname)
        $counter = 0;
        while ($dbdata = mysql_fetch_array($db_result))
        {
            $ar_channelname[$counter] = $dbdata[Name];
            $ar_channelID[$counter] = $dbdata[id];
            $counter++;
        }

        // include template
        include ("admin_channels.tpl.$FILE_EXTENSION");
}


?>

