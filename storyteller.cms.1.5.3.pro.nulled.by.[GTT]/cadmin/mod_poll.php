<?php

   /*
    ########################
    # |//////////////////| #
    # NULLED by [GTT] =)   #
    # |\\\\\\\\\\\\\\\\\\| #
    ########################
    */

    function AdminPoll($opts)
    {

        global $words, $admin, $midas;
        dbconnect();

        $options = explode("-", $opts);

        if (($options[0]) and ($admin[user_canpoll] == 2))
        {
            $result = DBQuery("SELECT poll_author FROM esselbach_st_polls WHERE poll_id = '$options[1]'");
            list($pollauthor) = mysql_fetch_row($result);

            if ($pollauthor != $admin[user_name])
            {
                MkHeader("_self");
                MkTabHeader ("$words[ERR]");
                echo "$words[RPOLL]";
                MkTabFooter();
                MkFooter();
            }
        }

        if ($options[0] == "deletepoll")
        {

            RemoveCache("polls/polls");
            RemoveCache("news/mainpage");

            $result = DBQuery("SELECT poll_comments FROM esselbach_st_polls WHERE poll_id = '$options[1]'");
            list($comments) = mysql_fetch_row($result);
            $pages = $comments/25;
            $pages++;
            for($p = 1; $p < $pages; $p++)
            {
                RemoveCache ("polls/poll-$zid-$p");
            }

            $result = DBQuery("DELETE FROM esselbach_st_polls WHERE poll_id='$options[1]'");

            MkHeader("_self");
            MkTabHeader ("$words[DO]");
            echo "$words[OSR]";
            MkTabFooter();
            MkFooter();

        }

        if ($options[0] == "editpoll")
        {

            $result = DBQuery("SELECT * FROM esselbach_st_polls WHERE poll_id='$options[1]'");
            $poll = mysql_fetch_array($result);

            MkHeader("_self");
            MkTabHeader("$words[EOO]");
            echo "<table><form name=\"poll\" action=\"index.php\" method=\"post\">";

            $query = DBQuery("SELECT website_id, website_name FROM esselbach_st_websites");
            if (mysql_num_rows($query) > 1)
            {

                echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\">$words[WBS]</font></td><td></td><td><face face=\"Arial\" size=\"2\"><select size=\"1\" name=\"website\">";

                $query = DBQuery("SELECT website_id, website_name FROM esselbach_st_websites");

                echo "<option value=\"0\">$words[ALL]</option>";

                while (list($website_id, $website_name) = mysql_fetch_row($query))
                {
                    ($website_id == $poll['poll_website']) ? $select = "selected" :
                     $select = "";
                    echo "<option value=\"$website_id\">$website_name</option>";
                }

                echo "</select></font></td></tr>";
            }

            if ($midas)
            {
                echo "<script type=\"text/javascript\" src=\"wysiwyg/htmlarea3.js\"></script>";
            }
            else
            {
            echo "<script language=\"JavaScript\">
                <!--
                function AutoInsert1(tag) {
                document.poll.newstext1.value =
                document.poll.newstext1.value + tag;
                }
                //-->
                </script>";
            }

            MkOption ("$words[OQE]", "", "newstitle", "$poll[poll_title]");

            if (!$midas) QuickHTML(1);

            MkArea ("$words[OIT]", "newstext1", "$poll[poll_text]");

            MkSelect ("$words[EHT]", "htmlen", "$poll[poll_html]");
            MkSelect ("$words[EIS]", "iconen", "$poll[poll_icon]");
            MkSelect ("$words[EBC]", "codeen", "$poll[poll_code]");

            MkOption ("$words[P01]", "", "extra1", "$poll[poll_option1]");
            MkOption ("$words[P02]", "", "extra2", "$poll[poll_option2]");
            MkOption ("$words[P03]", "", "extra3", "$poll[poll_option3]");
            MkOption ("$words[P04]", "", "extra4", "$poll[poll_option4]");
            MkOption ("$words[P05]", "", "extra5", "$poll[poll_option5]");
            MkOption ("$words[P06]", "", "extra6", "$poll[poll_option6]");

            MkOption ("$words[P07]", "", "extra7", "$poll[poll_option7]");
            MkOption ("$words[P08]", "", "extra8", "$poll[poll_option8]");
            MkOption ("$words[P09]", "", "extra9", "$poll[poll_option9]");
            MkOption ("$words[P10]", "", "extra10", "$poll[poll_option10]");
            MkOption ("$words[P11]", "", "extra11", "$poll[poll_option11]");
            MkOption ("$words[P12]", "", "extra12", "$poll[poll_option12]");

            MkSelect ("$words[OMP]", "mainnewsonly", "$poll[poll_main]");
            MkSelect ("$words[ECO]", "commen", "$poll[poll_comm]");
            MkOption ("$words[RAS]", "", "extra13", "$poll[poll_editreason]");

            echo "<input type=\"hidden\" name=\"aform\" value=\"editpoll\"><input type=\"hidden\" name=\"zid\" value=\"$poll[poll_id]\"><td><font face=\"Arial\" size=\"2\"><input type=\"submit\" value=\"$words[SND]\"></font></td></tr></table>";
            MkTabFooter();

            if ($midas)
            {
                EnableMidas("newstext1");
            }

            MkFooter();

        }

        MkHeader("_self");
        MkTabHeader("$words[ELO]");
        echo "$words[ELD]";
        MkTabFooter();

        TblHeader("$words[OID]", "$words[OQV]");

        $result = DBQuery("SELECT poll_id, poll_title, poll_votes FROM esselbach_st_polls ORDER BY poll_id");

        while (list($poll_id, $poll_title, $poll_votes) = mysql_fetch_row($result))
        {
            TblMiddle2("$poll_id", "$poll_title ($poll_votes)", "polls&opts=editpoll-$poll_id", "polls&opts=deletepoll-$poll_id");
        }
        TblFooter();

        MkTabHeader("$words[AAO]");
        echo "<table><form name=\"poll\" action=\"index.php\" method=\"post\">";

        $query = DBQuery("SELECT website_id, website_name FROM esselbach_st_websites");
        if (mysql_num_rows($query) > 1)
        {

            echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\">$words[WBS]</font></td><td></td><td><face face=\"Arial\" size=\"2\"><select size=\"1\" name=\"website\">";

            $query = DBQuery("SELECT website_id, website_name FROM esselbach_st_websites");

            echo "<option value=\"0\">$words[ALL]</option>";

            while (list($website_id, $website_name) = mysql_fetch_row($query))
            {
                ($website_id == $poll['poll_website']) ? $select = "selected" :
                 $select = "";
                echo "<option value=\"$website_id\">$website_name</option>";
            }

            echo "</select></font></td></tr>";
        }

        if ($midas)
        {
            echo "<script type=\"text/javascript\" src=\"wysiwyg/htmlarea3.js\"></script>";
        }
        else
        {
        echo "<script language=\"JavaScript\">
            <!--
            function AutoInsert1(tag) {
            document.poll.newstext1.value =
            document.poll.newstext1.value + tag;
            }
            //-->
            </script>";
        }

        MkOption ("$words[OQE]", "", "newstitle", "");

        if (!$midas) QuickHTML(1);

        MkArea ("$words[OIT]", "newstext1", "");

        if ($midas)
        {
            MkSelect ("$words[EHT]", "htmlen", "1");
            MkSelect ("$words[EIS]", "iconen", "0");
            MkSelect ("$words[EBC]", "codeen", "0");
        }
        else
        {
            MkSelect ("$words[EHT]", "htmlen", "0");
            MkSelect ("$words[EIS]", "iconen", "1");
            MkSelect ("$words[EBC]", "codeen", "1");
        }

        MkOption ("$words[P01]", "", "extra1", "");
        MkOption ("$words[P02]", "", "extra2", "");
        MkOption ("$words[P03]", "", "extra3", "");
        MkOption ("$words[P04]", "", "extra4", "");
        MkOption ("$words[P05]", "", "extra5", "");
        MkOption ("$words[P06]", "", "extra6", "");

        MkOption ("$words[P07]", "", "extra7", "");
        MkOption ("$words[P08]", "", "extra8", "");
        MkOption ("$words[P09]", "", "extra9", "");
        MkOption ("$words[P10]", "", "extra10", "");
        MkOption ("$words[P11]", "", "extra11", "");
        MkOption ("$words[P12]", "", "extra12", "");

        MkSelect ("$words[OMP]", "mainnewsonly", "1");
        MkSelect ("$words[ECO]", "commen", "1");

        echo "<input type=\"hidden\" name=\"aform\" value=\"addpoll\"><td><font face=\"Arial\" size=\"2\"><input type=\"submit\" value=\"$words[SND]\"></font></td></tr></table>";
        MkTabFooter();

        if ($midas)
        {
            EnableMidas("newstext1");
        }

        MkFooter();

    }

    //  ##########################################################

    function AddPoll ()
    {

        global $words, $website, $admin, $newstitle, $newstext1, $extra1, $extra2, $extra3, $extra4, $extra5, $extra6, $extra7, $extra8, $extra9, $extra10, $extra11, $extra12, $htmlen, $iconen, $codeen, $ipaddr, $ipaddr, $mainnewsonly, $commen;

        DBQuery("INSERT INTO esselbach_st_polls VALUES (NULL, '$website', '$admin[user_name]', '$newstitle', '$newstext1',
            '0', '$extra1', '0', '$extra2', '0', '$extra3', '0', '$extra4', '0', '$extra5', '0', '$extra6', '0', '$extra7', '0', '$extra8',
            '0', '$extra9', '0', '$extra10', '0', '$extra11', '0', '$extra12', '0', '0', '$htmlen', '$iconen', '$codeen', '$ipaddr', '$ipaddr',
            '', '0', '$mainnewsonly', '$commen')");

        RemoveCache("polls/polls");
        RemoveCache("news/mainnews");

        MkHeader("_self");
        MkTabHeader ("$words[DO]");
        echo $words[OA];
        MkTabFooter();
        MkFooter();

    }

    //  ##########################################################

    function EditPoll()
    {

        global $words, $website, $newstitle, $newstext1, $extra1, $extra2, $extra3, $extra4, $extra5, $extra6, $extra7, $extra8, $extra9, $extra10, $extra11, $extra12, $htmlen, $iconen, $codeen, $extra13, $ipaddr, $mainnewsonly, $commen, $zid;

        DBQuery("UPDATE esselbach_st_polls SET poll_website='$website', poll_title='$newstitle', poll_text='$newstext1',
            poll_option1='$extra1', poll_option2='$extra2', poll_option3='$extra3', poll_option4='$extra4', poll_option5='$extra5',
            poll_option6='$extra6', poll_option7='$extra7', poll_option8='$extra8', poll_option9='$extra9', poll_option10='$extra10',
            poll_option11='$extra11', poll_option12='$extra12', poll_html='$htmlen', poll_icon='$iconen', poll_code='$codeen',
            poll_editreason='$extra13', poll_editip='$ipaddr', poll_main='$mainnewsonly', poll_comm='$commen' WHERE poll_id = '$zid'");

        RemoveCache ("polls/polls");
        RemoveCache ("news/mainnews");
        RemoveCache ("news/comments");

        $result = DBQuery("SELECT poll_comments FROM esselbach_st_polls WHERE poll_id = '$zid'");
        list($comments) = mysql_fetch_row($result);
        $pages = $comments/25;
        $pages++;
        for($p = 1; $p < $pages; $p++)
        {
            RemoveCache ("polls/poll-$zid-$p");
        }

        RemoveCache ("polls/poll-$zid-1");

        MkHeader("_self");
        MkTabHeader ("$words[DO]");
        echo $words[OC];
        MkTabFooter();
        MkFooter();
    }

    //  ##########################################################

    function AdminSearchPoll()
    {

        global $words;

        MkHeader("_self");
        MkTabHeader("$words[NEWPL]");
        echo "<form action=\"index.php\" method=\"post\"><font size=\"2\" face=\"Verdana, Arial\">$words[FOS]</font><br />";
        echo "<input type=\"hidden\" name=\"aform\" value=\"searchreplacepoll\"><textarea cols=\"100%\" name=\"zid\" rows=\"2\"></textarea><br />";
        echo "$words[INFLD] <select size=\"1\" name=\"extra2\"><option value=\"title\">title</option><option value=\"text\">text</option>";
        for($i = 1; $i < 13; $i++)
        {
            echo "<option value=\"extra".$i."\">option".$i."</option>";
        }
        echo "</select> ";
        echo "$words[AREP]</font><textarea cols=\"100%\" name=\"extra1\" rows=\"2\"></textarea><br /><input type=\"submit\" value=\"$words[SUB]\"></form>";
        MkTabFooter();
        MkFooter();
    }

   //  ##########################################################

    function PollSearchReplace ()
    {

        global $words, $zid, $extra1, $extra2, $ipaddr;

        MkHeader("_self");
        MkTabHeader ("$words[DO]");

        $search_field = "poll_".$extra2;
        $query = DBQuery("SELECT * FROM esselbach_st_polls WHERE ($search_field LIKE '%$zid%')");

        $totalrows = 0;
        while ($rows = mysql_fetch_array($query))
        {
            $out_field = str_replace("$zid", "$extra1", $rows[$search_field]);
            DBQuery("UPDATE esselbach_st_polls SET $search_field = '$out_field', poll_editip = '$ipaddr' WHERE poll_id = '$rows[poll_id]'");
            $totalrows++;
        }

        echo $totalrows." ".$words[ENTCH];

        ClearCache("news");
        ClearCache("polls");
        ClearCache("tags");

        MkTabFooter();
        MkFooter();

    }

?>
