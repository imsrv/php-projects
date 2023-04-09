<?php

    /*
    ########################
    # |//////////////////| #
    # NULLED by [GTT] =)   #
    # |\\\\\\\\\\\\\\\\\\| #
    ########################
    */

    function AdminEditMails($opts)
    {

        global $words;
        dbconnect();

        $options = explode("-", $opts);
        if ($options[0] == "deletemail")
        {

            $result = DBQuery("DELETE FROM esselbach_st_mails WHERE mail_id='$options[1]'");

            MkHeader("_self");
            MkTabHeader ("$words[DO]");
            echo "$words[EER]";
            MkTabFooter();
            MkFooter();

        }

        if ($options[0] == "editmail")
        {

            $result = DBQuery("SELECT * FROM esselbach_st_mails WHERE mail_id='$options[1]'");
            $mail = mysql_fetch_array($result);

            MkHeader("_self");
            MkTabHeader("$words[EME] $options[1]");

            echo "<table><form action=\"index.php\" method=\"post\">";

            $query = DBQuery("SELECT website_id, website_name FROM esselbach_st_websites");
            if (mysql_num_rows($query) > 1)
            {

                echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\">$words[WBS]</font></td><td></td><td><face face=\"Arial\" size=\"2\"><select size=\"1\" name=\"website\">";

                echo "<option value=\"0\">$words[ALL]</option>";
                while (list($website_id, $website_name) = mysql_fetch_row($query))
                {
                    ($website_id == $mail['mail_website']) ? $select = "selected" :
                     $select = "";
                    echo "<option $select value=\"$website_id\">$website_name</option>";
                }

                echo "</select></font></td></tr>";
            }

            MkOption ("$words[WNA]", "", "newstitle", "$mail[mail_sitetitle]");
            MkOption ("$words[NEA]", "", "newstext1", "$mail[mail_email]");

            echo "<input type=\"hidden\" name=\"aform\" value=\"domailedit\"><input type=\"hidden\" name=\"zid\" value=\"$mail[mail_id]\"><td><font face=\"Arial\" size=\"2\"><input type=\"submit\" value=\"$words[SND]\"></font></td></tr></td>";
            MkTabFooter();

            MkFooter();
        }

        MkHeader("_self");
        MkTabHeader("$words[NML]");
        echo "$words[NMD]";
        MkTabFooter();

        TblHeader("$words[EMI]", "$words[WTE]");

        $result = DBQuery("SELECT mail_id, mail_website, mail_sitetitle, mail_email FROM esselbach_st_mails ORDER BY mail_id DESC");

        while (list($mail_id, $mail_website, $mail_sitetitle, $mail_email) = mysql_fetch_row($result))
        {
            TblMiddle("$mail_id / $mail_website", "$mail_sitetitle ($mail_email)", "editmails&opts=editmail-$mail_id", "editmails&opts=deletemail-$mail_id");
        }

        TblFooter();

        MkTabHeader("$words[AEL]");
        echo "<table><form action=\"index.php\" method=\"post\">";

        $query = DBQuery("SELECT website_id, website_name FROM esselbach_st_websites");
        if (mysql_num_rows($query) > 1)
        {

            echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\">$words[WBS]</font></td><td></td><td><face face=\"Arial\" size=\"2\"><select size=\"1\" name=\"website\">";

            echo "<option value=\"0\">$words[ALL]</option>";
            while (list($website_id, $website_name) = mysql_fetch_row($query))
            {
                echo "<option value=\"$website_id\">$website_name</option>";
            }

            echo "</select></font></td></tr>";
        }

        MkOption ("$words[WNA]", "", "newstitle", "");
        MkOption ("$words[NEA]", "", "newstext1", "");

        echo "<input type=\"hidden\" name=\"aform\" value=\"addmail\"><td><font face=\"Arial\" size=\"2\"><input type=\"submit\" value=\"$words[SND]\"></font></td></tr></table>";
        MkTabFooter();

        MkFooter();

    }

    //  ##########################################################

    function AdminSendNews($opts)
    {

        global $configs, $words;

        $options = explode("-", $opts);
        if ($options[0] == "send")
        {

            $result = DBQuery("SELECT * FROM esselbach_st_stories WHERE story_id='$options[1]'");
            $mail = mysql_fetch_array($result);

            MkHeader("_self");
            MkTabHeader("$words[SDM]");

            echo "<table><form action=\"index.php\" method=\"post\">";

            $query = DBQuery("SELECT website_id, website_name FROM esselbach_st_websites");
            if (mysql_num_rows($query) > 1)
            {
                echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\">$words[WBS]</font></td><td></td><td><face face=\"Arial\" size=\"2\"><select size=\"1\" name=\"website\">";
                echo "<option value=\"0\">$words[ALL]</option>";

                while (list($website_id, $website_name) = mysql_fetch_row($query))
                {
                    ($website_id == $mail['story_website']) ? $select = "selected" :
                     $select = "";
                    echo "<option $select value=\"$website_id\">$website_name</option>";
                }

                echo "</select></font></td></tr>";
            }

            MkOption ("$words[TIT]", "", "newstitle", "News: $mail[story_title]");

            MkArea ("$words[MNS]", "newstext1", "$mail[story_text]\n\n$configs[6]/story.php?id=$mail[story_id]\n\n$words[TWM] $configs[5]");

            echo "<tr><td></td></tr> <input type=\"hidden\" name=\"aform\" value=\"dosendnews\"><input type=\"hidden\" name=\"zid\" value=\"$mail[story_id]\"><td><font face=\"Arial\" size=\"2\"><input type=\"submit\" value=\"$words[SND]\"></font></td></tr></table>";
            MkTabFooter();
            MkFooter();
        }


        MkHeader("_self");
        MkTabHeader("$words[NML]");
        echo "$words[NMM]";
        MkTabFooter();

        echo "<table border=\"0\" cellpadding=\"1\" cellspacing=\"1\" width=\"100%\">
            <tr bgcolor=\"#003399\">
            <td>
            <table border=\"0\" cellpadding=\"3\" cellspacing=\"0\" width=\"100%\">
            <tr bgcolor=\"#003399\">
            <td align=\"left\" width=\"98%\">
            <font size=\"2\" color=\"#FFFFFF\" face=\"Verdana, Arial\"><b>$words[NE]</b></font>
            </td>
            <td align=\"left\" width=\"2%\">

            </td>
            </tr>";

        $result = DBQuery("SELECT story_title, story_id FROM esselbach_st_stories ORDER BY story_id DESC LIMIT 100");

        while (list($story_title, $story_id) = mysql_fetch_row($result))
        {
            ($bgcolor == "#ffffff") ? $bgcolor = "#eeeeee" :
             $bgcolor = "#ffffff";
            echo "<tr bgcolor=\"$bgcolor\">
                <td align=\"left\" width=\"98%\">
                <font size=\"2\" color=\"#000000\" face=\"Verdana, Arial\">
                $story_title
                </font>
                </td>
                <td align=\"center\" width=\"2%\">
                <font size=\"2\" color=\"#000000\" face=\"Verdana, Arial\">
                <a href=\"index.php?action=sendlist&opts=send-$story_id\">
                <img src=\"../images/email.png\" border=\"0\">
                </a>
                </font>
                </td>
                </tr>";
        }
        echo "</table>
            </td>
            </tr>
            </table>
            <br />";
        MkFooter();

    }

    //  ##########################################################

    function AddMail ()
    {

        global $words, $admin, $website, $newstitle, $newstext1, $ipaddr;

        DBQuery("INSERT INTO esselbach_st_mails VALUES (NULL, '$admin[user_name]', '$website', '$newstitle', '$newstext1', '$ipaddr', '$ipaddr')");

        MkHeader("_self");
        MkTabHeader ("$words[DO]");
        echo $words[EA];
        MkTabFooter();
        MkFooter();

    }

    //  ##########################################################

    function EditMail ()
    {

        global $words, $website, $newstitle, $newstext1, $ipaddr, $zid;

        DBQuery("UPDATE esselbach_st_mails SET mail_website='$website', mail_sitetitle='$newstitle', mail_email='$newstext1', mail_editip='$ipaddr' WHERE mail_id='$zid'");

        MkHeader("_self");
        MkTabHeader ("$words[DO]");
        echo $words[EC];
        MkTabFooter();
        MkFooter();

    }

    //  ##########################################################

    function SendMails ()
    {

        global $words, $admin, $website, $newstitle, $newstext1;

        $query = DBQuery("SELECT * FROM esselbach_st_mails WHERE mail_website = '$website' OR mail_website = '0'");

        while ($emails = mysql_fetch_array($query))
        {
            $newstitle = stripslashes($newstitle);
            $newstext1 = str_replace("\r","",stripslashes($newstext1));
            $headers = MailHeader("$admin[user_name]","$admin[user_email]","$emails[mail_sitetitle]","$emails[mail_email]");
            mail($emails[mail_email], $newstitle, $newstext1, $headers);

        }

        MkHeader("_self");
        MkTabHeader ("$words[DO]");
        echo $words[EX];
        MkTabFooter();
        MkFooter();

    }

?>
