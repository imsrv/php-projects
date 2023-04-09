<?php

   /*
    ########################
    # |//////////////////| #
    # NULLED by [GTT] =)   #
    # |\\\\\\\\\\\\\\\\\\| #
    ########################
    */

    function AdminEditTicket($opts)
    {

        global $words;
        dbconnect();

        $options = explode("-", $opts);
        if ($options[0] == "deleteticket")
        {

            DBQuery("DELETE FROM esselbach_st_ticket WHERE ticket_id='$options[1]'");

            MkHeader("_self");
            MkTabHeader ("$words[DO]");
            echo "$words[TTR]";
            MkTabFooter();
            MkFooter();

        }

        if ($options[0] == "editticket")
        {

            $result = DBQuery("SELECT * FROM esselbach_st_ticket WHERE ticket_id='$options[1]'");
            $ticket = mysql_fetch_array($result);

            MkHeader("_self");
            MkTabHeader("$words[TTT] $options[1] - $ticket[ticket_title] $words[CBY] $ticket[ticket_user]");

            echo "<table><form name=\"editticket\" action=\"index.php\" method=\"post\">";

            $query = DBQuery("SELECT website_id, website_name FROM esselbach_st_websites");
            if (mysql_num_rows($query) > 1)
            {

                echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\">$words[WBS]</font></td><td></td><td><face face=\"Arial\" size=\"2\"><select size=\"1\" name=\"website\">";
                echo "<option value=\"0\">$words[ALL]</option>";
                while (list($website_id, $website_name) = mysql_fetch_row($query))
                {
                    ($website_id == $ticket['ticket_website']) ? $select = "selected" :
                     $select = "";
                    echo "<option $select value=\"$website_id\">$website_name</option>";
                }

                echo "</select></font></td></tr>";
            }

            MkOption ("$words[TIT]", "", "newstitle", "$ticket[ticket_title]");

            echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\">$words[CAT]</font></td><td></td><td><face face=\"Arial\" size=\"2\"><select size=\"1\" name=\"category\">";

            $query = DBQuery("SELECT ticketcat_id, ticketcat_name FROM esselbach_st_ticketcat");
            while (list($ticketcat_id, $ticketcat_name) = mysql_fetch_row($query))
            {
                ($ticket_id == $ticket['ticket_category']) ? $select = "selected" :
                 $select = "";
                echo "<option $select value=\"$ticketcat_id\">$ticketcat_name</option>";
            }

            echo "</select></font></td></tr>";

            if (!file_exists("../bbwrapper.php"))
            {
                $query = DBQuery("SELECT user_cconfig FROM esselbach_st_users WHERE user_name = '$ticket[ticket_user]'");

                if (mysql_num_rows($query))
                {
                    list($cconfig) = mysql_fetch_row($query);
                    $cconfig = DeChomp(ScriptEx(htmlentities($cconfig)));
                    echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\">$words[COC]</font></td><td></td><td><font size=\"2\" face=\"Verdana, Arial\">$cconfig</font></td></tr>";
                }
            }

            MkArea ("$words[TIC]", "newstext1", "$ticket[ticket_text]");

            MkArea ("$words[TIO]", "newstext2", "");

            echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\">$words[PIO]</font></td><td></td><td><face face=\"Arial\" size=\"2\"><select size=\"1\" name=\"extra1\">";

            for($z = 0; $z < 6; $z++)
            {
                ($z == $ticket['ticket_priority']) ? $select = "selected" :
                 $select = "";
                $prio = $z;
                if (!$prio) $prio = "$words[CLO]";
                echo "<option $select value=\"$z\">$prio</option>";
            }

            echo "</select></font></td></tr>";

            echo "<tr><td></td></tr> <input type=\"hidden\" name=\"aform\" value=\"doticketedit\"><input type=\"hidden\" name=\"zid\" value=\"$ticket[ticket_id]\"><td><font face=\"Arial\" size=\"2\"><input type=\"submit\" value=\"$words[SND]\"></font></td></tr></table>";
            MkTabFooter();
            MkFooter();
        }

        MkHeader("_self");
        MkTabHeader("$words[TTE]");
        echo "<form action=\"index.php\" method=\"post\"><font size=\"2\" face=\"Verdana, Arial\">$words[SRC]</font>";
        echo "<input type=\"hidden\" name=\"aform\" value=\"searchtickets\"><input name=\"zid\" size=\"32\"><input type=\"submit\" value=\"$words[SUB]\"></form>";
        MkTabFooter();

        TblHeader("$words[TSI]", "$words[TTI]");


        $result = DBQuery("SELECT ticket_website, ticket_title, ticket_id, ticket_priority, ticket_user FROM esselbach_st_ticket ORDER BY ticket_id DESC LIMIT 100");

        while (list($ticket_website, $ticket_title, $ticket_id, $ticket_priority, $ticket_user) = mysql_fetch_row($result))
        {
            if (!$ticket_priority) $ticket_priority = "$words[CLO]";
            TblMiddle("$ticket_id / $ticket_website", "$ticket_title $words[CBY] $ticket_user ($ticket_priority)", "editticket&opts=editticket-$ticket_id", "editticket&opts=deleteticket-$ticket_id");
        }

        MkFooter();

    }

    //  ##########################################################

    function AdminCatTicket($opts)
    {

        global $words;
        dbconnect();

        $options = explode("-", $opts);
        if ($options[0] == "deletecat")
        {

            if ($options[1] > 1)
            {
                $result = DBQuery("DELETE FROM esselbach_st_ticketcat WHERE ticketcat_id='$options[1]'");

                MkHeader("_self");
                MkTabHeader ("$words[DO]");
                echo "$words[CSR]";
                MkTabFooter();
                MkFooter();

            }
            else
            {

                MkHeader("_self");
                MkTabHeader ("$words[ERR]");
                echo "$words[ATOC]";
                MkTabFooter();
                MkFooter();
            }

        }

        if ($options[0] == "editcat")
        {

            $result = DBQuery("SELECT * FROM esselbach_st_ticketcat WHERE ticketcat_id='$options[1]'");
            $cat = mysql_fetch_array($result);

            MkHeader("_self");
            MkTabHeader("$words[EDC]");
            echo "<table><form action=\"index.php\" method=\"post\">";
            MkOption ("$words[CNA]", "", "category", "$cat[ticketcat_name]");
            echo "<input type=\"hidden\" name=\"aform\" value=\"editticketcat\"><input type=\"hidden\" name=\"zid\" value=\"$cat[downloadscat_id]\"><td><font face=\"Arial\" size=\"2\"><input type=\"submit\" value=\"$words[SND]\"></font></td></tr></table>";
            MkTabFooter();
            MkFooter();

        }

        MkHeader("_self");
        MkTabHeader("$words[EDC]");
        echo "$words[EDD]";
        MkTabFooter();

        TblHeader("$words[CID]", "$words[CNA]");

        $result = DBQuery("SELECT ticketcat_id, ticketcat_name FROM esselbach_st_ticketcat ORDER BY ticketcat_id");

        while (list($ticket_id, $ticket_title) = mysql_fetch_row($result))
        {
            TblMiddle("$ticket_id", "$ticket_title", "editticketcat&opts=editcat-$ticket_id", "editticketcat&opts=deletecat-$ticket_id");
        }
        TblFooter();

        MkTabHeader("$words[AAC]");
        echo "<table><form action=\"index.php\" method=\"post\">";
        MkOption ("Category", "", "category", "");
        echo "<input type=\"hidden\" name=\"aform\" value=\"addticketcat\"><td><font face=\"Arial\" size=\"2\"><input type=\"submit\" value=\"$words[SND]\"></font></td></tr></table>";
        MkTabFooter();

        MkFooter();

    }

    //  ##########################################################

    function SearchTickets ()
    {

        global $words, $zid;

        MkHeader("_self");
        MkTabHeader("$words[TTE]");
        echo "<form action=\"index.php\" method=\"post\"><font size=\"2\" face=\"Verdana, Arial\">$words[SRC]</font>";
        echo "<input type=\"hidden\" name=\"aform\" value=\"searchtickets\"><input name=\"zid\" size=\"32\"><input type=\"submit\" value=\"$words[SUB]\"></form>";
        MkTabFooter();

        TblHeader("$words[TSI]", "$words[TWQ] $zid");

        $result = DBQuery("SELECT ticket_website, ticket_title, ticket_id, ticket_priority, ticket_user FROM esselbach_st_ticket WHERE (ticket_title like '%$zid%') ORDER BY ticket_id DESC LIMIT 100");

        while (list($ticket_website, $ticket_title, $ticket_id, $ticket_priority, $ticket_user) = mysql_fetch_row($result))
        {
            if (!$ticket_priority) $ticket_priority = "$words[CLO]";
            TblMiddle("$ticket_id / $ticket_website", "$ticket_title $words[CBY] $ticket_user ($ticket_priority)", "editticket&opts=editticket-$ticket_id", "editticket&opts=deleteticket-$ticket_id");
        }

        MkFooter();

    }

    //  ##########################################################

    function TicketEdit ()
    {

        global $words, $newstext1, $newstext2, $admin, $category, $zid, $extra1, $newstitle, $ipaddr;

        if ($newstext2)
        {
            $ttext = "$newstext1\n\n<b>$words[UDY] $admin[user_name] ($words[SUP])</b>\n$newstext2";
        }
        else
        {
            $ttext = $newstext1;
        }

        $result = DBQuery("UPDATE esselbach_st_ticket SET ticket_text='$ttext', ticket_editip='$ipaddr', ticket_category='$category', ticket_title='$newstitle', ticket_priority='$extra1' WHERE ticket_id='$zid'");

        MkHeader("_self");
        MkTabHeader ("$words[DO]");
        echo $words[TU];
        MkTabFooter();
        MkFooter();

    }

    //  ##########################################################

    function AddTicketCat ()
    {

        global $words, $category;

        DBQuery("INSERT INTO esselbach_st_ticketcat VALUES (NULL, '$category')");

        MkHeader("_self");
        MkTabHeader ("$words[DO]");
        echo $words[CA];
        MkTabFooter();
        MkFooter();

    }

    //  ##########################################################

    function EditTicketCat ()
    {

        global $words, $category, $zid;

        DBQuery("UPDATE esselbach_st_ticketcat SET ticketcat_name='$category' WHERE ticketcat_id = '$zid'");

        MkHeader("_self");
        MkTabHeader ("$words[DO]");
        echo $words[CU];
        MkTabFooter();
        MkFooter();
    }

?>
