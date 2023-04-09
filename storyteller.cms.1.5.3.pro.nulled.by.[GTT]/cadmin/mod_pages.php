<?php

    /*
    ########################
    # |//////////////////| #
    # NULLED by [GTT] =)   #
    # |\\\\\\\\\\\\\\\\\\| #
    ########################
    */

    function AdminEditPages($opts)
    {

        global $words, $admin, $midas;
        dbconnect();

        $options = explode("-", $opts);

        if (($options[0]) and ($admin[user_canpage] == 2))
        {
            $result = DBQuery("SELECT page_author FROM esselbach_st_pages WHERE page_id = '$options[1]'");
            list($pageauthor) = mysql_fetch_row($result);

            if ($pageauthor != $admin[user_name])
            {
                MkHeader("_self");
                MkTabHeader ("$words[ERR]");
                echo "$words[RPAGE]";
                MkTabFooter();
                MkFooter();
            }
        }

        if ($options[0] == "deletepage")
        {

            $result = DBQuery("DELETE FROM esselbach_st_pages WHERE page_id='$options[1]'");

            RemoveCache ("pages/page-$gid");
            RemoveIndex ($options[1], 5);

            MkHeader("_self");
            MkTabHeader ("$words[DO]");
            echo "$words[PSR]";
            MkTabFooter();
            MkFooter();

        }

        if ($options[0] == "editpage")
        {

            $result = DBQuery("SELECT * FROM esselbach_st_pages WHERE page_id='$options[1]'");
            $page = mysql_fetch_array($result);

            MkHeader("_self");
            MkTabHeader("$words[EDP] $options[1]");

            echo "<table><form name=\"page\" action=\"index.php\" method=\"post\">";

            $query = DBQuery("SELECT website_id, website_name FROM esselbach_st_websites");
            if (mysql_num_rows($query) > 1)
            {

                echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\">$words[WBS]</font></td><td></td><td><face face=\"Arial\" size=\"2\"><select size=\"1\" name=\"website\">";

                echo "<option value=\"0\">$words[ALL]</option>";
                while (list($website_id, $website_name) = mysql_fetch_row($query))
                {
                    ($website_id == $page['page_website']) ? $select = "selected" :
                     $select = "";
                    echo "<option $select value=\"$website_id\">$website_name</option>";
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
                document.page.newstext1.value =
                document.page.newstext1.value + tag;
                }
                //-->
                </script>";
            }

            MkOption ("$words[TIT]", "", "newstitle", "$page[page_title]");

            if (!$midas) QuickHTML(1);

            MkArea ("$words[PEG]", "newstext1", "$page[page_text]");

            MkSelect ("$words[EHT]", "htmlen", "$page[page_html]");
            MkSelect ("$words[EIS]", "iconen", "$page[page_icon]");
            MkSelect ("$words[EBC]", "codeen", "$page[page_code]");

            echo "<input type=\"hidden\" name=\"aform\" value=\"dopageedit\"><input type=\"hidden\" name=\"zid\" value=\"$page[page_id]\"><td><font face=\"Arial\" size=\"2\"><input type=\"submit\" value=\"$words[SND]\"></font></td></tr></table>";
            MkTabFooter();

            if ($midas)
            {
                EnableMidas("newstext1");
            }

            MkFooter();
        }

        MkHeader("_self");
        MkTabHeader("$words[APG]");
        echo "$words[APD]";
        MkTabFooter();

        TblHeader("$words[PSI]", "$words[PAT]");

        $result = DBQuery("SELECT page_website, page_title, page_id FROM esselbach_st_pages ORDER BY page_id DESC");

        while (list($page_website, $page_title, $page_id) = mysql_fetch_row($result))
        {
            TblMiddle2("$page_id / $page_website", "$page_title", "editpages&opts=editpage-$page_id", "editpages&opts=deletepage-$page_id");
        }

        TblFooter();

        MkTabHeader("$words[APA]");
        echo "<table><form name=\"page\" action=\"index.php\" method=\"post\">";

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

        if ($midas)
        {
            echo "<script type=\"text/javascript\" src=\"wysiwyg/htmlarea3.js\"></script>";
        }
        else
        {
        echo "<script language=\"JavaScript\">
            <!--
            function AutoInsert1(tag) {
            document.page.newstext1.value =
            document.page.newstext1.value + tag;
            }
            //-->
            </script>";
        }

        MkOption ("$words[TIT]", "", "newstitle", "");

        if (!$midas) QuickHTML(1);

        MkArea ("$words[PEG]", "newstext1", "");

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

        echo "<input type=\"hidden\" name=\"aform\" value=\"addpage\"><td><font face=\"Arial\" size=\"2\"><input type=\"submit\" value=\"$words[SND]\"></font></td></tr></table>";
        MkTabFooter();

        if ($midas)
        {
            EnableMidas("newstext1");
        }

        MkFooter();

    }

    //  ##########################################################

    function PageEdit ()
    {

        global $admin, $words, $zid, $newstitle, $website, $newstext1, $htmlen, $codeen, $iconen, $ipaddr;

        if ($admin[user_canpage] == 2)
        {
            $result = DBQuery("SELECT page_author FROM esselbach_st_pages WHERE page_id = '$zid'");
            list($pageauthor) = mysql_fetch_row($result);

            if ($pageauthor != $admin[user_name])
            {
                MkHeader("_self");
                MkTabHeader ("$words[ERR]");
                echo "$words[RPAGE]";
                MkTabFooter();
                MkFooter();
            }
        }

        DBQuery("UPDATE esselbach_st_pages SET page_title='$newstitle', page_website='$website', page_text='$newstext1', page_html='$htmlen', page_icon='$iconen', page_code='$codeen', page_editip='$ipaddr' WHERE page_id='$zid'");
        UpdateIndex ($zid, $website, 5, $newstitle, $newstext1);

        RemoveCache ("pages/page-$zid");

        MkHeader("_self");
        MkTabHeader ("$words[DO]");
        echo $words[PC];
        MkTabFooter();
        MkFooter();

    }

    //  ##########################################################

    function PageAdd ()
    {

        global $words, $admin, $newstitle, $newstext1, $htmlen, $codeen, $iconen, $ipaddr;

        DBQuery("INSERT INTO esselbach_st_pages VALUES (NULL, '$admin[user_name]', '$website', '$newstitle', '$newstext1', '$htmlen', '$iconen', '$codeen', '$ipaddr', '$ipaddr')");
        $result = DBQuery("SELECT page_id FROM esselbach_st_pages ORDER BY page_id DESC LIMIT 1");
        list($id) = mysql_fetch_row($result);
        AddIndex ($id, $website, 1, $admin[user_name], $newstitle[0], $newstext1[0], "");

        MkHeader("_self");
        MkTabHeader ("$words[DO]");
        echo $words[PA];
        MkTabFooter();
        MkFooter();

    }

    //  ##########################################################

    function AdminSearchPage()
    {

        global $words;

        MkHeader("_self");
        MkTabHeader("$words[NEWPG]");
        echo "<form action=\"index.php\" method=\"post\"><font size=\"2\" face=\"Verdana, Arial\">$words[FOS]</font><br />";
        echo "<input type=\"hidden\" name=\"aform\" value=\"searchreplacepage\"><textarea cols=\"100%\" name=\"zid\" rows=\"2\"></textarea><br />";
        echo "$words[INFLD] <select size=\"1\" name=\"extra2\"><option value=\"title\">title</option><option value=\"text\">text</option></select> ";

        echo "$words[AREP]</font><textarea cols=\"100%\" name=\"extra1\" rows=\"2\"></textarea><br /><input type=\"submit\" value=\"$words[SUB]\"></form>";
        MkTabFooter();
        MkFooter();
    }

   //  ##########################################################

    function PageSearchReplace ()
    {

        global $words, $zid, $extra1, $extra2, $ipaddr;

        MkHeader("_self");
        MkTabHeader ("$words[DO]");

        $search_field = "page_".$extra2;
        $query = DBQuery("SELECT * FROM esselbach_st_pages WHERE ($search_field LIKE '%$zid%')");

        $totalrows = 0;
        while ($rows = mysql_fetch_array($query))
        {
            $out_field = str_replace("$zid", "$extra1", $rows[$search_field]);
            DBQuery("UPDATE esselbach_st_pages SET $search_field = '$out_field', page_editip = '$ipaddr' WHERE page_id = '$rows[page_id]'");
            $totalrows++;
        }

        echo $totalrows." ".$words[ENTCH];

        ClearCache("news");
        ClearCache("pages");
        ClearCache("tags");

        MkTabFooter();
        MkFooter();

    }

?>
