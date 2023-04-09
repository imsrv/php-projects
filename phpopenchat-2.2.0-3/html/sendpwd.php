<?// -*- C++ -*-
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

include("defaults_inc.php");

if($sendpwd&&$nickname)
{
    include("connect_db_inc.php");
    $db_handle=connect_db($DATABASEHOST,$DATABASEUSER,$DATABASEPASSWD);
    if(!$db_handle){ exit; }

    // check, if user is in the database
    $result = mysql_query("SELECT Email,Passwort FROM chat_data WHERE Nick='$nickname'",$db_handle);
    $numrows = mysql_num_rows ($result);
    if ($numrows == 0) { $status_message = $MSG_SENDPWD_NONICK; }

    // get data from database and check, if a password for the user is in the database
    if ($status_message == "")
    {
        $dbdata = mysql_fetch_array($result);
        $sendpw_email = $dbdata[Email];
        $sendpw_password =$dbdata[Passwort];



        if ($sendpw_email == "") { $status_message = $MSG_SENDPWD_NOEMAIL; }
    }

    // all data is okay .. send password to user
    if ($status_message == "")
    {
        mail($sendpw_email, $MSG_SENDPWD_SUBJECT, $MSG_SENDPWD_MSGTXT.$sendpw_password,
        "From: $TEAM_MAIL_ADDR\nReply-To: $TEAM_MAIL_ADDR\nOrganization: PHPOpenChat, For more information visit http://www.ortelius.de/PHPOpenChat/\nX-Mailer: PHP/".phpversion());

        $status_message = $MSG_SENDPWD_SUCCESS;
    }

    // Output $status_message
    echo "
    <HTML>
    <HEAD>
    <TITLE>$MSG_SENDPWD</TITLE>
    </HEAD>
    <BODY  BACKGROUND=\"$BG_IMAGE\" bgcolor=white>
    <p align=\"center\">
<!-- start table -->
<table cellSpacing=\"0\" cellPadding=\"1\" border=\"0\">
<tr>
<td width=\"100%\" bgColor=#468e31>
<table cellSpacing=\"0\" cellPadding=\"4\" border=\"0\">
<tr>
<td background=\"images/bg.gif\" align=\"center\">
<font size=\"+1\">
<b>$MSG_SENDPWD</b>
</font>
</td>
</tr>
<tr>
<td bgColor=\"#ffffff\" align=\"center\">
<img src=\"images/leer.gif\" alt=\"\" width=\"480\" height=\"1\" border=\"0\"><br>
    <P>
    $MSG_SENDPWD_NICKNAME<b>$nickname</b>
    </P>
    <P>
    $status_message
    </P>
    <P>
    <A HREF=\"$INSTALL_DIR\">Chat-Homepage</A>
    </P>

 </td>
</tr>
</table>
</td>
</tr>
</table>
<!-- end table -->
    </p>
    </BODY>
    </HTML>
    ";

    mysql_close($db_handle);
    exit;
}

else
{
    echo "
    <HTML>
    <HEAD>
    <TITLE>$MSG_SENDPWD</TITLE>
    </HEAD>
    <BODY BACKGROUND=\"$BG_IMAGE\" bgcolor=\"#FFFFFF\">
    <CENTER>
<!-- start table -->
<table cellSpacing=\"0\" cellPadding=\"1\" border=\"0\">
<tr>
<td width=\"100%\" bgColor=#468e31>
<table cellSpacing=\"0\" cellPadding=\"4\" border=\"0\">
<tr>
<td background=\"images/bg.gif\" align=\"center\">
<font size=\"+1\">
<b>$MSG_SENDPWD</b>
</font>
</td>
</tr>
<tr>
<td bgColor=\"#ffffff\" align=\"center\">
<img src=\"images/leer.gif\" alt=\"\" width=\"480\" height=\"1\" border=\"0\"><br>
    <form method=\"post\" action=\"sendpwd.php\"> 
    $NICK_NAME: <INPUT NAME=\"nickname\" VALUE=\"$nickname\" TYPE=\"text\" SIZE=\"20\" MAXLENGTH=\"20\" />
    <INPUT NAME=\"sendpwd\" VALUE=\"1\" TYPE=\"hidden\" />
    <INPUT VALUE=\"$MSG_SENDPWD_SUBMIT\" TYPE=\"submit\" />
    </form>
 </td>
</tr>
</table>
</td>
</tr>
</table>
<!-- end table -->
    </CENTER>
    </BODY>
    </HTML>
    ";
}

?>
