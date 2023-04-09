<?php

require_once( "config.php" );
require_once( "db_file.php" );
require_once( "chat.php" );
session_start();

?>
<html>
<head>
    <title>Chatter Box by Liquid Frog -  Admin</title>
</head>
<link rel="StyleSheet" type="text/css" href="style.css">
<body>
<?php

if(
    ( !isset( $_GET['op'] ) && !isset( $_SESSION[ 'logged_in' ] ) )
    ||
    ( isset( $_GET['op'] ) && $_GET['op'] != 'login' && !isset( $_SESSION[ 'logged_in' ] ) )
    ||
    ( !isset( $_SESSION[ 'logged_in' ] ) && ( !isset( $_POST[ 'passwd' ] ) || $_POST[ 'passwd' ] != $GLOBALS['admin_password'] ) )
    )
{
?>
<p>Please log in:</p>
<form action="admin.php?op=login" method="post">
<p><label>Administrator password: <input type="password" name="passwd"/></label></p>
<p><input type="submit" value="Login"/></p>
</form>
<?php
    if( $_GET[ 'op' ] == "login" && ( !isset( $_POST[ 'passwd' ] ) || $_POST[ 'passwd' ] != $GLOBALS['admin_password'] ) )
    {
?>
<p>Wrong password.</p>
<?php
    }
}
else
{
?>
<table border=0 width=100% height=560>
    <tr>
        <td valign=top width=150 bgcolor="#EBE7E7">
        <!-- Menu -->
        <a href="admin.php">Main</a><br/>  <br>
        Banners:<br/>
        <a href="admin.php?op=banner_add">Add banner</a><br/>
        <a href="admin.php?op=banner_del">Delete banner</a><br/>
        <a href="admin.php?op=banner_view">View Banners</a><br/><br>
        IP Banning:<br/>
        <a href="admin.php?op=ipban_add">Add IP</a><br/>
        <a href="admin.php?op=ipban_del">Delete IP</a><br/>
        <a href="admin.php?op=ipban_view">View all IPs</a><br/><br>
        Users:<br/>
        <a href="admin.php?op=kick">Kick User</a><br/>
        <a href="admin.php?op=ban">Ban User</a><br/><br>
        Other:<br/>
        <a href="admin.php?op=logout">Log out</a><br/><br>
        <hr size=1/>
        <a href="admin.php?op=enter_chat">Enter Chat</a>
        <hr size=1/> <br>
        <a href="admin.php?op=admin_help">Admin Help</a> <br>
        <a href="http://liquidfrog.bestdirectbuy.com" target="_new">Liquid Frog site</a>
        </td>
        <td valign=top>
        <!-- Content -->
<?php
    switch( $_GET[ 'op' ] )
    {
        //--------------------------------------------------------------------------------------------------------------
        // Logout
        //--------------------------------------------------------------------------------------------------------------
        case 'logout':
            session_unregister( 'logged_in' );
?>
<p>Succesfully logged out. Click <a href="admin.php">here</a> to re-login.</p>
<?php
            break;

        //--------------------------------------------------------------------------------------------------------------
        // Show help
        //--------------------------------------------------------------------------------------------------------------
         case 'admin_help':
            include ("admin_help.php");
            break;

        //--------------------------------------------------------------------------------------------------------------
        // Add Banner
        //--------------------------------------------------------------------------------------------------------------
        case 'banner_add':
?>
<form enctype="multipart/form-data" method="post" action="admin.php?op=banner_add_2nd">
    <p><label>Banner file: <input type="file" name="userfile"/></label></p>
    <p><label>URL: <input type="text" name="url"/ size=80></label></p>
    <p><label>Details:<br/><textarea rows=5 cols=70 name="details"></textarea><label></p>
    <p><input type="submit" value="Add"/></p>
</form>
<?php
            break;

        //--------------------------------------------------------------------------------------------------------------
        // Add Banner Second Step
        //--------------------------------------------------------------------------------------------------------------
        case 'banner_add_2nd':
            $error_msg = "";

            if( !isset( $_FILES['userfile'] ) || !isset( $_POST['url'] ) || !isset( $_POST['details'] ) )
                $error_msg .= "<p>POST data error - please re-send form!</p>";
            else if( !is_dir( $dir_to_chat . '/banners' ) )
                $error_msg .= "<p>Could not find the banners dir!</p>";
            else if( !move_uploaded_file( $_FILES['userfile']['tmp_name'], $dir_to_chat . '/banners/' . $_FILES['userfile']['name'] ) )
                $error_msg .= "<p>Could not upload file!</p>";
            else
            {
                DB_connect();
                @mysql_query( "INSERT INTO LFchat_banners( filename, url, details, impressions, hits ) VALUES( \"" . addslashes( $_FILES['userfile']['name'] ) . "\", \"" . addslashes( $_POST['url'] ) . "\", \"" . addslashes( $_POST[ 'details' ] ) . "\", 0, 0 )" );
                $error_msg .= mysql_error();

                if( $error_msg != "" )
                    unlink( $dir_to_chat . '/banners/' . $_FILES['userfile']['name'] );
            }

            if( $error_msg == "" )
                $error_msg = "Succesfully added the new banner.";

            echo $error_msg;

            break;

        //--------------------------------------------------------------------------------------------------------------
        // Delete Banner
        //--------------------------------------------------------------------------------------------------------------
        case 'banner_del':
            DB_connect();
            $res = @mysql_query( "SELECT id, filename FROM LFchat_banners" );
?>
<form action="admin.php?op=banner_del_2nd" method="post">
<p><label>Select banner to remove:
    <select name="id">
<?php
            while( $row = mysql_fetch_array( $res ) )
            {
                echo "<option value=\"" . $row[ 'id' ] . "\">" . $row[ 'filename' ] . "</option>\n";
            }
?>
    </select>
</label></p>
<p><input type="submit" value="Delete"/></p>
</form>
<?php

            break;

        //--------------------------------------------------------------------------------------------------------------
        // Delete Banner Second Step
        //--------------------------------------------------------------------------------------------------------------
        case 'banner_del_2nd':
            $error_msg = "";

            if( !isset( $_POST['id'] ) )
                $error_msg .= "<p>POST data error - please re-send form!</p>";
            else
            {
                DB_connect();

                $res = @mysql_query( "SELECT filename FROM LFchat_banners WHERE id = " . $_POST[ 'id' ] );
                $error_msg .= mysql_error();

                if( $error_msg == "" )
                {
                    $row = mysql_fetch_array( $res );
                    if( is_file( $dir_to_chat . '/banners/' . $row['filename'] ) )
                        if( !unlink( $dir_to_chat . '/banners/' . $row['filename'] ) )
                        {
                            $error_msg .= "<p>Could not delete banner file!</p>";
                        }

                    if( $error_msg == "" )
                    {
                        @mysql_query( "DELETE FROM LFchat_banners WHERE id = " . $_POST['id'] );
                        $error_msg .= mysql_error();
                    }
                }
            }

            if( $error_msg == "" )
                $error_msg .= "Banner removed succesfully!";

            echo $error_msg;

            break;

        //--------------------------------------------------------------------------------------------------------------
        // View Banners
        //--------------------------------------------------------------------------------------------------------------
        case 'banner_view':
            $error_msg = "";

            DB_connect();
            $res = mysql_query( "SELECT * FROM LFchat_banners" );
            $error_msg .= mysql_error();

            if( $error_msg == "" )
            {
?>
<table border=1>
    <tr>
        <th width=80% nowrap>Filename/Details</th>
        <th width=60>Impressions</th>
        <th width=60>Hits</th>
    </tr>
<?php
                while( $row = mysql_fetch_array( $res ) )
                {
?>
    <tr>
        <td width=80% nowrap><?=$row['filename']?><br/><?=$row['details']?></td>
        <td><?=$row['impressions']?></td>
        <td><?=$row['hits']?></td>
    </tr>
<?php
                }
?>
</table>
<?php
            }
            break;

        //--------------------------------------------------------------------------------------------------------------
        // Add IP Ban
        //--------------------------------------------------------------------------------------------------------------
        case 'ipban_add':
?>
<form method="post" action="admin.php?op=ipban_add_2nd">
    <p><label>IP Address: <input type="text" name="remote_addr"/></label></p>
    <p><input type="submit" value="Add"/></p>
</form>
<?php
            break;

        //--------------------------------------------------------------------------------------------------------------
        // Add IP Ban Second Step
        //--------------------------------------------------------------------------------------------------------------
        case 'ipban_add_2nd':
            $error_msg = "";

            if( !isset( $_POST['remote_addr'] ) )
                $error_msg .= "<p>Missing POST data.</p>";
            else if( strlen( $_POST['remote_addr'] ) < 1 )
                $error_msg .= "<p>Invalid field length.</p>";
            else
            {
                DB_connect();
                @mysql_query( "INSERT INTO LFchat_banned_ips( remote_addr ) VALUES( '" . $_POST['remote_addr'] ."' )" );
                $error_msg .= mysql_error();
            }

            if( $error_msg == "" )
                $error_msg = "<p>IP <b>" . $_POST['remote_addr'] . "</b> was succesfully added to the baned IPs list.</p>";

            echo $error_msg;

            break;

        //--------------------------------------------------------------------------------------------------------------
        // Delete IP Ban
        //--------------------------------------------------------------------------------------------------------------
        case 'ipban_del':
            DB_connect();
            $res = @mysql_query( "SELECT id, remote_addr FROM LFchat_banned_ips" );
?>
<form action="admin.php?op=ipban_del_2nd" method="post">
<p><label>Select IP to remove:
    <select name="id">
<?php
            while( $row = mysql_fetch_array( $res ) )
            {
                echo "<option value=\"" . $row[ 'id' ] . "\">" . $row[ 'remote_addr' ] . "</option>\n";
            }
?>
    </select>
</label></p>
<p><input type="submit" value="Delete"/></p>
</form>
<?php

            break;

        //--------------------------------------------------------------------------------------------------------------
        // Delete IP Ban Second Step
        //--------------------------------------------------------------------------------------------------------------
        case 'ipban_del_2nd':
            $error_msg = "";

            if( !isset( $_POST['id'] ) )
                $error_msg .= "<p>Missing POST data.</p>";
            else
            {
                DB_connect();
                @mysql_query( "DELETE FROM LFchat_banned_ips WHERE id = " . $_POST['id'] );
                $error_msg .= mysql_error();
            }

            if( $error_msg == "" )
                $error_msg = "<p>IP removed succesfully!</p>";

            echo $error_msg;

            break;

        //--------------------------------------------------------------------------------------------------------------
        // View IP Bans
        //--------------------------------------------------------------------------------------------------------------
        case 'ipban_view':
            DB_connect();
            $res = @mysql_query( "SELECT * FROM LFchat_banned_ips" );
?>
<table border=1 width=100%">
    <tr>
        <th>
            IP Address
        </th>
    </tr>
<?php
            while( $row = mysql_fetch_array( $res ) )
            {
?>
    <tr>
        <td><?=$row['remote_addr']?></td>
    </tr>
<?php
            }
?>
</table>
<?php
            break;

        //--------------------------------------------------------------------------------------------------------------
        // Kick User
        //--------------------------------------------------------------------------------------------------------------
        case 'kick':
            DB_connect();
            $res = mysql_query( "SELECT user FROM LFchat_room" );

?>
<p>Click on a user to kick them.</p>
<table>
    <tr>
        <th>
            User Name
        </th>
    </tr>
<?php
            while( $row = mysql_fetch_row( $res ) )
            {
?>
    <tr>
        <td><a href="admin.php?op=kick_2nd&user=<?=$row[0]?>"><?=$row[0]?></a></td>
    </tr>
<?php
            }
?>
</table>
<?php
            break;

        //--------------------------------------------------------------------------------------------------------------
        // Kick User Second Step
        //--------------------------------------------------------------------------------------------------------------
        case 'kick_2nd':
            $error_msg = "";

            if( !isset( $_GET['user'] ) )
                $error_msg .= "<p>Missing GET data!</p>";
            else
            {
                $past_time =date("YmdHis",mktime(date("H"),date("i"),date("s")-$connection_delay*2-1,date("m"),date("d"),date("Y")));

                DB_connect();
                @mysql_query( "UPDATE LFchat_room SET d8=" . $past_time . " WHERE user='".$_GET['user']."'" );

                $error_msg = mysql_error();
            }

            if( $error_msg == "" )
                $error_msg = "<p>User " . $_GET['user'] . " was succesfully kicked!</p>";

            echo $error_msg;

            break;

        //--------------------------------------------------------------------------------------------------------------
        // Ban User
        //--------------------------------------------------------------------------------------------------------------
        case 'ban':
            DB_connect();
            $res = mysql_query( "SELECT user, remote_addr FROM LFchat_room" );

?>
<p>Click on a user to ban them.</p>
<table>
    <tr>
        <th>
            User Name (IP)
        </th>
    </tr>
<?php
            while( $row = mysql_fetch_row( $res ) )
            {
?>
    <tr>
        <td><a href="admin.php?op=ban_2nd&user=<?=$row[0]?>&remote_addr=<?=$row[1]?>"><?=$row[0]?> (<?=$row[1]?>)</a></td>
    </tr>
<?php
            }
?>
</table>
<?php
            break;

        //--------------------------------------------------------------------------------------------------------------
        // Ban User Second Step
        //--------------------------------------------------------------------------------------------------------------
        case 'ban_2nd':
            $error_msg = "";

            if( !isset( $_GET['user'] ) )
                $error_msg .= "<p>Missing GET data!</p>";
            else
            {
                $past_time =date("YmdHis",mktime(date("H"),date("i"),date("s")-$connection_delay*2-1,date("m"),date("d"),date("Y")));

                DB_connect();
                @mysql_query( "UPDATE LFchat_room SET d8=" . $past_time . " WHERE user='".$_GET['user']."'" );
                $error_msg = mysql_error();

                if( $error_msg == "" )
                {
                    if( $_GET['remote_addr'] == "" )
                    {
                        $error_msg = "<p>User was kicked but wasn't banned since no IP information was found.</p>";
                    }
                    else
                    {
                        @mysql_query( "INSERT INTO LFchat_banned_ips( remote_addr ) VALUES( '" . $_GET['remote_addr'] ."' )" );
                        $error_msg .= mysql_error();
                    }
                }
            }

            if( $error_msg == "" )
                $error_msg = "<p>User " . $_GET['user'] . " was succesfully banned!</p>";

            echo $error_msg;

            break;

        //--------------------------------------------------------------------------------------------------------------
        // Enter Chat
        //--------------------------------------------------------------------------------------------------------------
        case 'enter_chat':
            $error_msg = "";
            $today=date("YmdHis");

            DB_connect();

            $res = @mysql_query( "SELECT * FROM LFchat_room WHERE user = '". $admin_chat_username ."'" );
            $error_msg .= mysql_error();

            if( $error_msg == "" )
            {
                if( mysql_num_rows( $res ) > 0 )
                    $error_msg .= "<p>You have already logged in. Please log out before attempting to log in again.</p>";
            }

            if( $error_msg == "" )
            {
                @mysql_query( "UPDATE LFchat_admin SET d8_end_use = ".$today );
                $error_msg .= mysql_error();
            }

            if( $error_msg == "" )
            {
                @mysql_query( "INSERT INTO LFchat_room (user,user_ID,remote_addr,d8_init) VALUES ('". $admin_chat_username . "','". $admin_chat_username ."', '".( isset( $_SERVER['REMOTE_ADDR'] ) ? $_SERVER['REMOTE_ADDR'] : "" )."', $today)" );
                $error_msg .= mysql_error();
            }

            GLOB_addshout( $admin_has_entered_the_room_message, "", "", "" );

            if( $error_msg == "" )
            {
?>
<p>Admin succesfully connected to chat.</p>
<script language="JavaScript">
window.open('connect.php?user=<?=$admin_chat_username?>&tempstore=<?=$today?>',null,'width=635,height=635,resizeable=no,status=no');
</script>
<?php
            }
            else
                echo $error_msg;

            break;

        //--------------------------------------------------------------------------------------------------------------
        // Default/Log In
        //--------------------------------------------------------------------------------------------------------------
        case 'login':
        default:
            $_SESSION[ 'logged_in' ] = true;

?>
<p>Welcome to the Admin Section!</p>
<?php

    }
?>
        </td>
    </tr>
</table>
<?php
}

?>
<pre>
<?php //print_r( $GLOBALS ); ?>
</pre>
</body>
</html>