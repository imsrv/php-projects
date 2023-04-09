<?php

    /*
    ########################
    # |//////////////////| #
    # NULLED by [GTT] =)   #
    # |\\\\\\\\\\\\\\\\\\| #
    ########################
    */

    function AdminAddNews()
    {

        global $words, $admin, $configs, $midas;
        dbconnect();

        MkHeader("_self");
        MkTabHeader ("$words[ADS]");

        echo "<table><form name=\"newsstory\" action=\"index.php\" method=\"post\">";

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

        MkOption ("$words[TIT]", "", "newstitle", "");
        MkSelect ("$words[PUBLI]", "extrag13", "0");

        echo "<tr><td></td><td></td><td><input type=\"checkbox\" name=\"extrag12\" value=\"1\"><font face=\"Arial\" size=\"2\">$words[FEATU]</font>";

        echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\">$words[CAT]</font></td><td></td><td><font face=\"Arial\" size=\"2\"><select size=\"1\" name=\"category\">";

        $query = DBQuery("SELECT category_id, category_name FROM esselbach_st_categories");
        while (list($category_id, $category_name) = mysql_fetch_row($query))
        {
            echo "<option value=\"$category_id\">$category_name</option>";
        }

        echo "</select></font></td></tr>";

        if ($midas)
        {
            echo "\n\n<script type=\"text/javascript\" src=\"wysiwyg/htmlarea3.js\"></script>\n\n";
        }

        echo "<script language=\"JavaScript\">
            <!--
            ";

        if (!$midas)
        {
            echo "function AutoInsert1(tag) {
            document.newsstory.newstext1.value =
            document.newsstory.newstext1.value + tag;
            }
            function AutoInsert2(tag) {
            document.newsstory.newstext2.value =
            document.newsstory.newstext2.value + tag;
            }
            function OpenWin() {
            var newWinObj = window.open('index.php?action=shownewsimg','newWin','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=1,copyhistory=0,width=800,height=600')
            }";
        }
            echo "            function TeaserWin() {
            var newWinObj = window.open('index.php?action=viewteaser','newWin','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=1,copyhistory=0,width=200,height=600')
            }
            function TeaserUpload() {
            var newWinObj = window.open('index.php?action=upteaser','newWin','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=1,copyhistory=0,width=400,height=100')
            }
            //-->
            </script>";

        if (!$midas) QuickHTML(1);

        MkArea ("$words[MNS]", "newstext1", "");

        if (!$midas) QuickHTML(2);

        MkArea ("$words[EMN]", "newstext2", "");

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

        MkOption ("$words[SOU]", "", "source", "Email");
        MkSelect ("$words[SNM]", "mainnewsonly", "1");
        MkSelect ("$words[ECO]", "commen", "1");

        if ($admin[user_cannews] == 1)
        {
            (phpversion() >= "4.1.0") ? $teaserup = " [<a href=\"javascript:TeaserUpload()\">$words[UPL]</a>]" :
             $teaserup = "";
        }

        if (file_exists("../images/teaser"))
        {

            echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\">$words[TIM]$teaserup:<br /><br /><a href=\"javascript:TeaserWin()\">$words[NTVA]</a></font></td><td></td><td><face face=\"Arial\" size=\"2\"><select size=\"4\" name=\"teaser\"><option selected value=\"\">$words[NTP]</option>";

            if ($configs[12])
            {
                $thisdate = date("m-Y");
                if (!file_exists("../images/teaser/$thisdate"))
                {
                    mkdir("../images/teaser/$thisdate", 0777);
                }
                $teaser_dir = GetDir("../images/teaser/$thisdate");
            }
            else
            {
                $teaser_dir = GetDir("../images/teaser");
            }

            for($i = 1; $i < count($teaser_dir); $i++)
            {
                if (preg_match("/(.gif|.jpeg|.jpg|.png)/i", $teaser_dir[$i]))
                {
                    ($configs[12]) ? $file = $thisdate."/".$teaser_dir[$i] :
                     $file = $teaser_dir[$i];
                    echo "<option value=\"$file\">$teaser_dir[$i]</option>";
                }
            }
            echo "</select></font></td></tr>";

        }

        $query = DBQuery("SELECT * FROM esselbach_st_fields WHERE field_id='1'");
        $field = mysql_fetch_array($query);

        for($i = 1; $i < 21; $i++)
        {
            if ($field['field_enabled'.$i] == 1)
            {
                echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\">".$field['field_extra'.$i].":</font>";
                echo "</td><td></td><td><font face=\"Arial\" size=\"2\"><input name=\"extra$i\" size=\"32\"></font></td></tr>";
            }
            if ($field['field_enabled'.$i] == 2)
            {
                $fieldoptions = explode(",", $field['field_extra'.$i]);
                echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\">$fieldoptions[0]:</font>";
                echo "</td><td></td><td><face face=\"Arial\" size=\"2\"><select size=\"1\" name=\"extra$i\">";
                for($z = 1; $z < count($fieldoptions); $z++)
                {
                    echo "<option value=\"$fieldoptions[$z]\">$fieldoptions[$z]</option>";
                }
                echo "</select></font></td></tr>";
            }
        }

        echo "<input type=\"hidden\" name=\"aform\" value=\"doadd\"><td><font face=\"Arial\" size=\"2\"><input type=\"submit\" value=\"$words[SUB]\"></font></form></td></tr></table>";

        MkTabFooter();

        if ($midas)
        {
            EnableMidas("newstext2");
            EnableMidas("newstext1");
        }
        else
        {
            MkTabHeader("$words[SRI2]");
            echo "$words[UPV2]";
            MkTabFooter();
        }

        MkFooter();
    }

    //  ##########################################################

    function AdminCatNews($opts)
    {

        global $words;
        dbconnect();

        $options = explode("-", $opts);
        if ($options[0] == "deletecat")
        {

            if ($options[1] > 1)
            {
                $result = DBQuery("DELETE FROM esselbach_st_categories WHERE category_id='$options[1]'");

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

            $result = DBQuery("SELECT * FROM esselbach_st_categories WHERE category_id='$options[1]'");
            $cat = mysql_fetch_array($result);

            MkHeader("_self");
            MkTabHeader("$words[EDC]");
            echo "<table><form action=\"index.php\" method=\"post\">";
            MkOption ("$words[CNA]", "", "category", "$cat[category_name]");
            MkOption ("$words[DSC]", "", "categorydsc", "$cat[category_desc]");
            echo "<input type=\"hidden\" name=\"aform\" value=\"editcat\"><input type=\"hidden\" name=\"zid\" value=\"$cat[category_id]\"><td><font face=\"Arial\" size=\"2\"><input type=\"submit\" value=\"$words[SND]\"></font></td></tr></table>";
            MkTabFooter();
            MkFooter();

        }

        MkHeader("_self");
        MkTabHeader("$words[EDC]");
        echo "$words[EDD]";
        MkTabFooter();

        TblHeader("$words[CID]", "$words[CNA]");

        $result = DBQuery("SELECT category_id, category_name FROM esselbach_st_categories ORDER BY category_id");

        while (list($category_id, $category_title) = mysql_fetch_row($result))
        {
            TblMiddle("$category_id", "$category_title", "editcat&opts=editcat-$category_id", "editcat&opts=deletecat-$category_id");
        }
        TblFooter();

        MkTabHeader("$words[AAC]");
        echo "<table><form action=\"index.php\" method=\"post\">";
        MkOption ("$words[CET]", "", "category", "");
        MkOption ("$words[DSC]", "", "categorydsc", "");
        echo "<input type=\"hidden\" name=\"aform\" value=\"addcat\"><td><font face=\"Arial\" size=\"2\"><input type=\"submit\" value=\"$words[SND]\"></font></td></tr></table>";
        MkTabFooter();

        MkFooter();

    }


    //  ##########################################################

    function AdminEditNews($opts)
    {

        global $words, $admin, $configs, $midas;
        dbconnect();

        $options = explode("-", $opts);

        if (($options[0]) and ($admin[user_cannews] == 2))
        {
            $result = DBQuery("SELECT story_author FROM esselbach_st_stories WHERE story_id = '$options[1]'");
            list($storyauthor) = mysql_fetch_row($result);

            if ($storyauthor != $admin[user_name])
            {
                MkHeader("_self");
                MkTabHeader ("$words[ERR]");
                echo "$words[RNEWS]";
                MkTabFooter();
                MkFooter();
            }
        }

        if ($options[0] == "deletestory")
        {

            $result = DBQuery("SELECT DISTINCT SUBSTRING_INDEX(story_time,'-','2'), story_category FROM esselbach_st_stories WHERE story_id='$options[1]'");
            list($story_time, $story_category) = mysql_fetch_row($result);
            $story_time_array = explode("-", $story_time);
            $archiveid = $story_time_array[0].$story_time_array[1];

            RemoveCache ("archive/archive-$archiveid");
            RemoveCache ("categories/category-$story_category");
            RemoveCache ("categories/category");
            RemoveCache ("xml/xmlnews-$story_category");
            RemoveCache ("xml/xmlnews-0");

            $result = DBQuery("SELECT story_comments FROM esselbach_st_stories WHERE story_id = '$options[1]'");
            list($comments) = mysql_fetch_row($result);
            $pages = $comments/25;
            $pages++;

            for($p = 1; $p < $pages; $p++)
            {
                RemoveCache ("story/story-$options[1]-$p");
            }

            RemoveCache ("story/storyp-$options[1]");
            RemoveCache ("news/mainnews");
            RemoveCache ("xml/xmlhelp");
            RemoveCache ("news/mobilenews");
            RemoveCache ("news/comments");
            RemoveCache ("tags/story-$options[1]");

            $result = DBQuery("DELETE FROM esselbach_st_stories WHERE story_id='$options[1]'");
            RemoveIndex ($options[1], 1);

            MkHeader("_self");
            MkTabHeader ("$words[DO]");
            echo "$words[SSR]";
            MkTabFooter();
            MkFooter();

        }

        if ($options[0] == "editstory")
        {

            $result = DBQuery("SELECT * FROM esselbach_st_stories WHERE story_id='$options[1]'");
            $story = mysql_fetch_array($result);

            MkHeader("_self");
            MkTabHeader("$words[ESX] $options[1]");

            echo "<table><form name=\"newsstory\" action=\"index.php\" method=\"post\">";

            $query = DBQuery("SELECT website_id, website_name FROM esselbach_st_websites");
            if (mysql_num_rows($query) > 1)
            {
                echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\">$words[WBS]</font></td><td></td><td><face face=\"Arial\" size=\"2\"><select size=\"1\" name=\"website\">";
                echo "<option value=\"0\">$words[ALL]</option>";

                while (list($website_id, $website_name) = mysql_fetch_row($query))
                {
                    ($website_id == $story['story_website']) ? $select = "selected" :
                     $select = "";
                    echo "<option $select value=\"$website_id\">$website_name</option>";
                }

                echo "</select></font></td></tr>";
            }

            MkOption ("$words[TIT]", "", "newstitle", "$story[story_title]");
            MkSelect ("$words[PUBLI]", "extrag13", "$story[story_hook]");

            if ($story[story_sticky]) $checked = "checked";
            echo "<tr><td></td><td></td><td><input type=\"checkbox\" name=\"extrag12\" value=\"1\" $checked><font face=\"Arial\" size=\"2\">$words[FEATU]</font>";

            echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\">$words[CAT]</font></td><td></td><td><face face=\"Arial\" size=\"2\"><select size=\"1\" name=\"category\">";

            $query = DBQuery("SELECT category_id, category_name FROM esselbach_st_categories");
            while (list($category_id, $category_name) = mysql_fetch_row($query))
            {
                ($category_id == $story['story_category']) ? $select = "selected" :
                 $select = "";
                echo "<option $select value=\"$category_id\">$category_name</option>";
            }

            echo "</select></font></td></tr>";

            if ($midas)
            {
                echo "<script type=\"text/javascript\" src=\"wysiwyg/htmlarea3.js\"></script>";
            }

            echo "<script language=\"JavaScript\">
                <!--";

            if (!$midas)
            {
                echo "                function AutoInsert1(tag) {
                document.newsstory.newstext1.value =
                document.newsstory.newstext1.value + tag;
                }
                function AutoInsert2(tag) {
                document.newsstory.newstext2.value =
                document.newsstory.newstext2.value + tag;
                }
                function OpenWin() {
                var newWinObj = window.open('index.php?action=shownewsimg','newWin','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=1,copyhistory=0,width=800,height=600')
                }";
            }
                echo "                function TeaserWin() {
                var newWinObj = window.open('index.php?action=viewteaser','newWin','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=1,copyhistory=0,width=200,height=600')
                }
                function TeaserUpload() {
                var newWinObj = window.open('index.php?action=upteaser','newWin','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=1,copyhistory=0,width=400,height=100')
                }
                //-->
                </script>";

            if (!$midas) QuickHTML(1);

            MkArea ("$words[MNS]", "newstext1", "$story[story_text]");

            if (!$midas) QuickHTML(2);

            MkArea ("$words[EMN]", "newstext2", "$story[story_extendedtext]");

            MkSelect ("$words[EHT]", "htmlen", "$story[story_html]");
            MkSelect ("$words[EIS]", "iconen", "$story[story_icon]");
            MkSelect ("$words[EBC]", "codeen", "$story[story_code]");

            MkOption ("$words[SOU]", "", "source", "$story[story_source]");
            MkOption ("$words[RAS]", "", "extrae12", "$story[story_editreason]");
            MkSelect ("$words[SNM]", "mainnewsonly", "$story[story_main]");
            MkSelect ("$words[ECO]", "commen", "$story[story_comm]");

            if (file_exists("../images/teaser"))
            {
                if ($admin[user_cannews] == 1)
                {
                    (phpversion() >= "4.1.0") ? $teaserup = " [<a href=\"javascript:TeaserUpload()\">$words[UPL]</a>]" :
                     $teaserup = "";
                }

                (!$story[story_teaser]) ? $select = "selected" :
                 $select = "";
                echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\">$words[TIM]$teaserup:<br /><br /><a href=\"javascript:TeaserWin()\">$words[NTVA]</a></font></td><td></td><td><face face=\"Arial\" size=\"2\"><select size=\"4\" name=\"teaser\"><option $select value=\"\">$words[NTP]</option>";

                $teaser_dir = GetDir("../images/teaser");
                for($i = 1; $i < count($teaser_dir); $i++)
                {
                    if (preg_match("/(.gif|.jpeg|.jpg|.png)/i", $teaser_dir[$i]))
                    {
                        ($story[story_teaser] == $teaser_dir[$i]) ? $select = "selected" :
                         $select = "";
                        echo "<option $select value=\"$teaser_dir[$i]\">$teaser_dir[$i]</option>";
                    }
                }

                if ($configs[12])
                {
                    $thisdate = date("m-Y");
                    $teaser_dir = GetDir("../images/teaser/$thisdate");
                    for($i = 1; $i < count($teaser_dir); $i++)
                    {
                        if (preg_match("/(.gif|.jpeg|.jpg|.png)/i", $teaser_dir[$i]))
                        {
                            ($story[story_teaser] == "$thisdate/$teaser_dir[$i]") ? $select = "selected" :
                             $select = "";
                            echo "<option $select value=\"$thisdate/$teaser_dir[$i]\">$teaser_dir[$i]</option>";
                        }
                    }
                }
            }

            $query = DBQuery("SELECT * FROM esselbach_st_fields WHERE field_id='1'");
            $field = mysql_fetch_array($query);

            for($i = 1; $i < 21; $i++)
            {
                if ($field['field_enabled'.$i] == 1)
                {
                    echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\">".$field['field_extra'.$i].":</font>";
                    echo "</td><td></td><td><font face=\"Arial\" size=\"2\"><input name=\"extra$i\" size=\"32\" value=\"".$story['story_extra'.$i]."\"></font></td></tr>";
                }
                if ($field['field_enabled'.$i] == 2)
                {
                    $fieldoptions = explode(",", $field['field_extra'.$i]);
                    echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\">$fieldoptions[0]:</font>";
                    echo "</td><td></td><td><face face=\"Arial\" size=\"2\"><select size=\"1\" name=\"extra$i\">";
                    for($z = 1; $z < count($fieldoptions); $z++)
                    {
                        ($fieldoptions[$z] == $story['story_extra'.$i]) ? $select = "selected" :
                         $select = "";
                        echo "<option $select value=\"$fieldoptions[$z]\">$fieldoptions[$z]</option>";
                    }
                    echo "</select></font></td></tr>";
                }
            }

            echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\"><input type=\"checkbox\" name=\"bump\" value=\"1\">$words[BMP]</font></td></tr> <input type=\"hidden\" name=\"aform\" value=\"doedit\"><input type=\"hidden\" name=\"zid\" value=\"$story[story_id]\"><td><font face=\"Arial\" size=\"2\"><input type=\"submit\" value=\"$words[SND]\"></form></font></td></tr></table>";
            MkTabFooter();

            if ($midas)
            {
                EnableMidas("newstext2");
                EnableMidas("newstext1");
            }
            else
            {
                MkTabHeader("$words[SRI2]");
                echo "$words[UPV2]";
                MkTabFooter();
            }
            MkFooter();
        }

        MkHeader("_self");
        MkTabHeader("$words[EDN]");
        echo "<form action=\"index.php\" method=\"post\"><font size=\"2\" face=\"Verdana, Arial\">$words[SRC]</font>";
        echo "<input type=\"hidden\" name=\"aform\" value=\"searchnews\"><input name=\"zid\" size=\"32\"><input type=\"submit\" value=\"$words[SUB]\"></form>";
        MkTabFooter();

        TblHeader("$words[SSI]", "$words[TIT]");

        $result = DBQuery("SELECT story_website, story_title, story_id, story_sticky, story_hook FROM esselbach_st_stories ORDER BY story_id DESC LIMIT 100");

        while (list($story_website, $story_title, $story_id, $story_sticky, $story_hook) = mysql_fetch_row($result))
        {
            ($story_sticky) ? $featured = "<b>$words[FEATR]</b>" :
             $featured = "";

            if ($story_hook)
            {
                $story_title = "<font color=\"red\">$story_title</font>";
            }

            TblMiddle2("$story_id / $story_website", "$story_title $featured", "editnews&opts=editstory-$story_id", "editnews&opts=deletestory-$story_id");
        }

        MkFooter();

    }

    //  ##########################################################

    function AdminNewsQueue($opts)
    {

        global $words, $admin;
        dbconnect();

        $options = explode("-", $opts);
        if ($options[0] == "deleteqstory")
        {

            $result = DBQuery("DELETE FROM esselbach_st_storyqueue WHERE storyq_id='$options[1]'");

            MkHeader("_self");
            MkTabHeader ("$words[DO]");
            echo "$words[QSR]";
            MkTabFooter();
            MkFooter();

        }

        if ($options[0] == "addqstory")
        {

            $result = DBQuery("SELECT * FROM esselbach_st_storyqueue WHERE storyq_id='$options[1]'");
            $story = mysql_fetch_array($result);

            $story[storyq_author] = htmlentities(ScriptEx($story[storyq_author]));

            if ($story[storyq_authormail])
            {
                $story[storyq_authormail] = htmlentities(ScriptEx($story[storyq_authormail]));
                $amail = "<a href=\"mailto:$story[storyq_authormail]\"><img src=\"../images/email.png\" border=\"0\"></a>";
            }

            MkHeader("_self");
            MkTabHeader("$words[ADS] $options[1]");

            echo "<table><form name=\"newsstory\" action=\"index.php\" method=\"post\">";
            echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\">$words[SMY]</font></td><td></td><td><font face=\"Arial\" size=\"2\">$story[storyq_author] $amail ($words[TIP] $story[storyq_authorip]) $story[storyq_time]</font></td></tr>";

            $query = DBQuery("SELECT website_id, website_name FROM esselbach_st_websites");
            if (mysql_num_rows($query) > 1)
            {

                echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\">$words[WBS]</font></td><td></td><td><face face=\"Arial\" size=\"2\"><select size=\"1\" name=\"website\">";

                echo "<option value=\"0\">$words[ALL]</option>";

                while (list($website_id, $website_name) = mysql_fetch_row($query))
                {
                    ($website_id == $story['storyq_website']) ? $select = "selected" :
                     $select = "";
                    echo "<option $select value=\"$website_id\">$website_name</option>";
                }
            }

            echo "</select></font></td></tr>";

            MkOption ("$words[TIT]", "", "newstitle", "$story[storyq_title]");
            MkSelect ("$words[PUBLI]", "extrag13", "0");

            echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\">$words[CAT]</font></td><td></td><td><face face=\"Arial\" size=\"2\"><select size=\"1\" name=\"category\">";

            $query = DBQuery("SELECT category_id, category_name FROM esselbach_st_categories");
            while (list($category_id, $category_name) = mysql_fetch_row($query))
            {
                echo "<option value=\"$category_id\">$category_name</option>";
            }

            echo "</select></font></td></tr>";

            echo "<script language=\"JavaScript\">
                <!--
                function AutoInsert1(tag) {
                document.newsstory.newstext1.value =
                document.newsstory.newstext1.value + tag;
                }
                function AutoInsert2(tag) {
                document.newsstory.newstext2.value =
                document.newsstory.newstext2.value + tag;
                }
                function OpenWin() {
                var newWinObj = window.open('index.php?action=shownewsimg','newWin','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=1,copyhistory=0,width=800,height=600')
                }
                function TeaserWin() {
                var newWinObj = window.open('index.php?action=viewteaser','newWin','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=1,copyhistory=0,width=200,height=600')
                }
                function TeaserUpload() {
                var newWinObj = window.open('index.php?action=upteaser','newWin','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=1,copyhistory=0,width=400,height=100')
                }
                //-->
                </script>";

            QuickHTML(1);

            MkArea ("$words[MNS]", "newstext1", "$story[storyq_text]");

            QuickHTML(2);

            MkArea ("$words[EMN]", "newstext2", "");

            MkSelect ("$words[EHT]", "htmlen", "0");
            MkSelect ("$words[EIS]", "iconen", "1");
            MkSelect ("$words[EBC]", "codeen", "1");

            MkOption ("$words[SOU]", "", "source", "$story[storyq_author]");
            MkSelect ("$words[SNM]", "mainnewsonly", "1");
            MkSelect ("$words[ECO]", "commen", "1");

            (phpversion() >= "4.1.0") ? $teaserup = " [<a href=\"javascript:TeaserUpload()\">$words[UPL]</a>]" :
             $teaserup = "";

            if (file_exists("../images/teaser"))
            {

                echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\">$words[tim]$teaserup:<br /><br /><a href=\"javascript:TeaserWin()\">$words[NTVA]</a></font></td><td></td><td><face face=\"Arial\" size=\"2\"><select size=\"4\" name=\"teaser\"><option selected value=\"\">$words[NTP]</option>";

                if ($configs[12])
                {
                    $thisdate = date("m-Y");
                    if (!file_exists("../images/teaser/$thisdate"))
                    {
                        mkdir("../images/teaser/$thisdate", 0777);
                    }
                    $teaser_dir = GetDir("../images/teaser/$thisdate");
                }
                else
                {
                    $teaser_dir = GetDir("../images/teaser");
                }

                for($i = 1; $i < count($teaser_dir); $i++)
                {
                    if (preg_match("/(.gif|.jpeg|.jpg|.png)/i", $teaser_dir[$i]))
                    {
                        echo "<option value=\"$teaser_dir[$i]\">$teaser_dir[$i]</option>";
                    }
                }
                echo "</select></font></td></tr>";

            }

            $query = DBQuery("SELECT * FROM esselbach_st_fields WHERE field_id='1'");
            $field = mysql_fetch_array($query);

            for($i = 1; $i < 21; $i++)
            {
                if ($field['field_enabled'.$i] == 1)
                {
                    echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\">".$field['field_extra'.$i]."</font>";
                    echo "</td><td></td><td><font face=\"Arial\" size=\"2\"><input name=\"extra$i\" size=\"32\"></font></td></tr>";
                }
                if ($field['field_enabled'.$i] == 2)
                {
                    $fieldoptions = explode(",", $field['field_extra'.$i]);
                    echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\">$fieldoptions[0]</font>";
                    echo "</td><td></td><td><face face=\"Arial\" size=\"2\"><select size=\"1\" name=\"extra$i\">";
                    for($z = 1; $z < count($fieldoptions); $z++)
                    {
                        echo "<option value=\"$fieldoptions[$z]\">$fieldoptions[$z]</option>";
                    }
                    echo "</select></font></td></tr>";
                }
            }

            echo "<input type=\"hidden\" name=\"aform\" value=\"doadd\"><td><font face=\"Arial\" size=\"2\"><input type=\"submit\" value=\"$words[SUB]\"></form></font></td></tr></table>";

            MkTabFooter();
            MkTabHeader("$words[SRI2]");
            echo "$words[UPV2]";
            MkTabFooter();
            MkFooter();
        }

        MkHeader("_self");
        MkTabHeader("$words[NQR] <a href=\"index.php?action=removenqueue\"><img src=\"../images/delete.png\" border=\"0\" alt=\"$words[DNQ]\"></a>");
        echo "$words[DQI]";
        MkTabFooter();

        TblHeader("$words[SSI]", "$words[TIT]");

        $result = DBQuery("SELECT storyq_website, storyq_title, storyq_id FROM esselbach_st_storyqueue ORDER BY storyq_id DESC LIMIT 100");

        while (list($storyq_website, $storyq_title, $storyq_id) = mysql_fetch_row($result))
        {
            TblMiddle("$storyq_id / $storyq_website", "$storyq_title", "newsqueue&opts=addqstory-$storyq_id", "newsqueue&opts=deleteqstory-$storyq_id");
        }

        MkFooter();

    }

    //  ##########################################################

    function AdminNewsImport($opts)
    {
        global $otitle, $odescription, $olink, $words;

        dbconnect();

        $options = explode("-", $opts);
        if ($options[0] == "deleteis")
        {

            $result = DBQuery("DELETE FROM esselbach_st_import WHERE import_id='$options[1]'");

            MkHeader("_self");
            MkTabHeader ("$words[DO]");
            echo "$words[WCR]";
            MkTabFooter();
            MkFooter();

        }

        if ($options[0] == "getis")
        {

            $result = DBQuery("SELECT * FROM esselbach_st_import WHERE import_id='$options[1]'");
            $import = mysql_fetch_array($result);

            $xml = xml_parser_create();

            xml_set_element_handler($xml, "xmlstart", "xmlend");
            xml_set_character_data_handler($xml, "xmlparse");

            $fp = fopen("$import[import_xmlurl]", "r");
            while ($xmldata = fread($fp, 4096)) xml_parse($xml, $xmldata, feof($fp));
            fclose($fp);

            xml_parser_free($xml);

            $query = DBQuery("SELECT category_id, category_name FROM esselbach_st_categories");
            while (list($category_id, $category_name) = mysql_fetch_row($query))
            {
                $catopts .= "<option value=\"$category_id\">$category_name</option>";
            }

            MkHeader("_self");
            MkTabHeader("$words[NIF] $import[import_sitetitle]");
            echo "<table><form action=\"index.php\" method=\"post\">";

            if ($import[import_item])
            {
                for($n = 0; $n < count($otitle); $n++)
                {
                    if ($odescription[$n])
                    {
                        $item .= "[b]$otitle[$n][/b]\n\n$odescription[$n]\n\n[url=$olink[$n]]$words[REM][/url]\n\n";
                    }
                    else
                    {
                        $item .= "[b]$otitle[$n][/b]\n[url=$olink[$n]]$words[REM][/url]\n\n";
                    }
                }

                MkOption ("$words[TIT]", "", "newstitle[0]", "$words[NFR] $import[import_sitetitle]");

                MkArea ("$words[MNS]", "newstext1[0]", "$item");

                echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\">$words[CAT]</font></td><td></td><td><face face=\"Arial\" size=\"2\"><select size=\"1\" name=\"category[0]\">$catopts</select></font></td></tr>";

            }
            else
            {

                for($n = 0; $n < count($otitle); $n++)
                {

                    MkOption ("$words[TIT]", "", "newstitle[$n]", "$otitle[$n]");

                    if ($odescription[$n])
                    {
                        MkArea ("$words[NE]", "newstext1[$n]", "$odescription[$n]\n\n[url=$olink[$n]]$words[REM][/url]");
                        $oplink = "";
                    }
                    else
                    {
                        MkArea ("$words[NE]", "newstext1[$n]", "[url=$olink[$n]]$words[REM][/url]");
                        $oplink = "<a href=\"#\" onClick=\"window.open('$olink[$n]','newWin','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=1,copyhistory=0,width=800,height=600'); return false;\"><b>$words[LINKS]</a>";
                    }

                    echo "<tr><td> </td><td></td><td><font face=\"Arial\" size=\"2\"><b>$words[XTN]</b> <input type=\"radio\" name=\"extra1[$n]\" value=\"0\" /> $words[Y] <input type=\"radio\" name=\"extra1[$n]\" value=\"1\" checked=\"checked\" /> $words[N] <b>$words[CAT]</b><select size=\"1\" name=\"category[$n]\">$catopts</select> $oplink</font></td></tr>";
                    echo "<tr><td><br /></td><td><br /></tr>";

                }
            }

            $query = DBQuery("SELECT website_id, website_name FROM esselbach_st_websites");
            if (mysql_num_rows($query) > 1)
            {

                echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\">$words[WBS]</font></td><td></td><td><face face=\"Arial\" size=\"2\"><select size=\"1\" name=\"website\">";

                $query = DBQuery("SELECT website_id, website_name FROM esselbach_st_websites");

                echo "<option value=\"0\">$words[ALL]</option>";

                while (list($website_id, $website_name) = mysql_fetch_row($query))
                {
                    echo "<option value=\"$website_id\">$website_name</option>";
                }

                echo "</select></font></td></tr>";
            }

            MkSelect ("$words[PUBLI]", "extrag13", "0");

            MkSelect ("$words[EHT]", "htmlen", "0");
            MkSelect ("$words[EIS]", "iconen", "1");
            MkSelect ("$words[EBC]", "codeen", "1");

            MkOption ("$words[SOU]", "", "source", "$import[import_sitetitle]");
            MkSelect ("$words[SNM]", "mainnewsonly", "1");
            MkSelect ("$words[ECO]", "commen", "1");

            (phpversion() >= "4.1.0") ? $teaserup = " [<a href=\"javascript:TeaserUpload()\">$words[UPL]</a>]" :
             $teaserup = "";

            if (file_exists("../images/teaser"))
            {

                echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\">$words[TIM]$teaserup:<br /><br /><a href=\"index.php?action=viewteaser\">View all teaser images</a></font></td><td></td><td><face face=\"Arial\" size=\"2\"><select size=\"4\" name=\"teaser\"><option selected value=\"\">$words[NTP]</option>";

                if ($configs[12])
                {
                    $thisdate = date("m-Y");
                    if (!file_exists("../images/teaser/$thisdate"))
                    {
                        mkdir("../images/teaser/$thisdate", 0777);
                    }
                    $teaser_dir = GetDir("../images/teaser/$thisdate");
                }
                else
                {
                    $teaser_dir = GetDir("../images/teaser");
                }

                for($i = 1; $i < count($teaser_dir); $i++)
                {
                    if (preg_match("/(.gif|.jpeg|.jpg|.png)/i", $teaser_dir[$i]))
                    {
                        echo "<option value=\"$teaser_dir[$i]\">$teaser_dir[$i]</option>";
                    }
                }
                echo "</select></font></td></tr>";
            }

            echo "<input type=\"hidden\" name=\"aform\" value=\"doqadd\"><td><font face=\"Arial\" size=\"2\"><input type=\"submit\" value=\"$words[SND]\"></font></td></tr></table>";
            MkTabFooter();
            MkFooter();

        }

        MkHeader("_self");
        MkTabHeader("$words[IMP]");
        echo "$words[IMD]";
        MkTabFooter();

        TblHeader("$words[WID]", "$words[WNA]");

        $result = DBQuery("SELECT import_id, import_sitetitle FROM esselbach_st_import ORDER BY import_id");

        while (list($import_id, $import_title) = mysql_fetch_row($result))
        {
            TblMiddle("$import_id", "$import_title", "newsimport&opts=getis-$import_id", "newsimport&opts=deleteis-$import_id");
        }
        TblFooter();

        MkTabHeader("$words[AAW]");
        echo "<table><form action=\"index.php\" method=\"post\">";
        MkOption ("$words[WNA]", "", "category", "");
        MkOption ("$words[XML]", "", "categorydsc", "");

        MkSelect ("$words[X11]", "htmlen", "0");

        echo "<input type=\"hidden\" name=\"aform\" value=\"addimport\"><td><font face=\"Arial\" size=\"2\"><input type=\"submit\" value=\"$words[SND]\"></font></td></tr></table>";
        MkTabFooter();

        MkFooter();

    }

    //  ##########################################################

    function xmlstart($parser, $name, $attrs)
    {
        global $item, $tag, $title, $description, $link;
        if ($item) $tag = $name;
        if ($name == "ITEM") $item = 1;
    }

    function xmlparse($parser, $data)
    {
        global $item, $tag, $title, $description, $link;
        if ($item)
        {
            if ($tag == "TITLE")
            {
                $title .= $data;
            }
            elseif ($tag == "DESCRIPTION")
            {
                $description .= $data;
            }
            elseif ($tag == "LINK")
            {
                $link .= $data;
            }
        }
    }

    function xmlend($parser, $name)
    {
        global $item, $tag, $title, $description, $link, $otitle, $odescription, $olink;
        if ($name == "ITEM")
        {
            $otitle[] = htmlentities(trim($title));
            $odescription[] = htmlentities(trim($description));
            $olink[] = htmlentities(trim($link));
            $title = "";
            $description = "";
            $link = "";
            $item = 0;
        }
    }

    //  ##########################################################

    function AdminPOPNews()
    {

        global $words, $wsperfs, $configs;

        MkHeader("_self");

        MkTabHeader("$words[POP3I]");

        if (extension_loaded("imap"))
        {

            $mailserver = @imap_open ("{".$wsperfs[website_newsmailserver].":110/pop3/notls}INBOX", "$wsperfs[website_newsmailuser]", "$wsperfs[website_newsmailpw]") or die ("$words[MERRO]");
            $emails = imap_num_msg($mailserver);

            echo $emails." $words[FEMAI]<br /><br />";

            if ($emails)
            {
                for($i = $emails; $i > 0; $i--)
                {

                    $headers = imap_header($mailserver, $i);
                    $message = addslashes(imap_body($mailserver, $i));

                    $subject = addslashes($headers->Subject);
                    $from = addslashes($headers->fromaddress);
                    $email = addslashes($headers->reply_toaddress);

                    echo $words[IEMAI]." $subject (".stripslashes($from).")<br />";

                    $message = str_replace("=\n", "", $message);
                    $message = str_replace("=2E", ".", $message);
                    $message = str_replace("=20", "\n", $message);
                    $message = str_replace("=91", "'", $message);
                    $message = str_replace("=92", "'", $message);
                    $message = str_replace("=93", "\"", $message);
                    $message = str_replace("=94", "\"", $message);
                    $message = str_replace("=3D", "=", $message);
                    $message = str_replace("=85", ",", $message);

                    DBQuery("INSERT INTO esselbach_st_storyqueue VALUES (NULL, '$configs[4]', '$from', '$email', '127.0.0.1', '$subject', '$message', now())");
                    imap_delete($mailserver, $i);
                }

                imap_expunge ($mailserver);
            }
            imap_close($mailserver);

        }
        else
        {
            echo $words[IMAPN];
        }

        MkTabFooter();
        MkFooter();
    }

    //  ##########################################################

    function AdminNewsTeaser()
    {

        global $words;

        MkHeader("_self");
        MkTabHeader("$words[UTS]");
        if (phpversion() >= "4.1.0")
        {
            echo "<form action=\"index.php\" method=\"post\" enctype=\"multipart/form-data\"><font size=\"2\" face=\"Verdana, Arial\">$words[IMF]</font>";
            echo "<input type=\"hidden\" name=\"aform\" value=\"teaserup\"><input type=\"file\" name=\"teaserfile\"><input type=\"submit\" value=\"Upload\"></form>";
        }
        else
        {
            echo "$words[PHP]";
        }
        MkTabFooter();
        echo "<center><font face=\"Arial\" size=\"2\">[<a href=\"javascript:self.close()\">$words[XSIC]</a>]</font></center>";
        MkFooter();
    }

    //  ##########################################################

    function AdminTeaserPreview ()
    {

        global $words, $configs;

        MkHeader("_self");

        ($configs[12]) ? $tpath = "../images/teaser/".date("m-Y") :
         $tpath = "../images/teaser";

        $image_dir = GetDir($tpath);

        for($i = 1; $i < count($image_dir); $i++)
        {
            if (preg_match("/(.gif|.jpeg|.jpg|.png)/i", $image_dir[$i]))
            {
                MkTabHeader("$image_dir[$i]");
                echo "<center><img src=\"$tpath/$image_dir[$i]\" border=\"0\" alt=\"\"></center>";
                MkTabFooter();
            }
        }

        echo "<font face=\"Arial\" size=\"2\"><center>[<a href=\"javascript:self.close()\">$words[XSIC]</a>]</center></font>";
        MkFooter();

    }

    //  ##########################################################

    function AdminRNewsQueue()
    {

        global $words;
        dbconnect();

        DBQuery("DELETE FROM esselbach_st_storyqueue");

        MkHeader("_self");
        MkTabHeader ("$words[DO]");
        echo "$words[QED]";
        MkTabFooter();
        MkFooter();

    }

    //  ##########################################################

    function AdminQuickNews()
    {

        global $words;
        dbconnect();

        MkHeader("_self");
        MkTabHeader ("$words[ADS]");

        $query = DBQuery("SELECT category_id, category_name FROM esselbach_st_categories");
        while (list($category_id, $category_name) = mysql_fetch_row($query))
        {
            $catopts .= "<option value=\"$category_id\">$category_name</option>";
        }

        echo "<script language=\"JavaScript\">
            <!--
            function TeaserWin() {
            var newWinObj = window.open('index.php?action=viewteaser','newWin','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=1,copyhistory=0,width=200,height=600')
            }
            function TeaserUpload() {
            var newWinObj = window.open('index.php?action=upteaser','newWin','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=1,copyhistory=0,width=400,height=100')
            }
            //-->
            </script>";

        echo "<table><form action=\"index.php\" method=\"post\">";

        for($n = 0; $n < 20; $n++)
        {
            $nn = $n;
            $nn++;
            echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\"><b>$words[NWS] #$nn</b></font></td><td><br /></tr>";

            MkOption ("$words[TIT]", "", "newstitle[$n]", "");
            echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\">$words[CAT]</font></td><td></td><td><face face=\"Arial\" size=\"2\"><select size=\"1\" name=\"category[$n]\">$catopts </select></font></td></tr>";

            MkArea ("$words[NE]", "newstext1[$n]", "");
            echo "<tr><td><br /></td><td><br /></tr>";

        }


        $query = DBQuery("SELECT website_id, website_name FROM esselbach_st_websites");
        if (mysql_num_rows($query) > 1)
        {

            echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\">$words[WBS]</font></td><td></td><td><face face=\"Arial\" size=\"2\"><select size=\"1\" name=\"website\">";

            $query = DBQuery("SELECT website_id, website_name FROM esselbach_st_websites");

            echo "<option value=\"0\">$words[ALL]</option>";

            while (list($website_id, $website_name) = mysql_fetch_row($query))
            {
                echo "<option value=\"$website_id\">$website_name</option>";
            }

            echo "</select></font></td></tr>";
        }

        MkSelect ("$words[PUBLI]", "extrag13", "0");

        MkSelect ("$words[EHT]", "htmlen", "0");
        MkSelect ("$words[EIS]", "iconen", "1");
        MkSelect ("$words[EBC]", "codeen", "1");

        MkOption ("$words[SOU]", "", "source", "Email");
        MkSelect ("$words[SNM]", "mainnewsonly", "1");
        MkSelect ("$words[ECO]", "commen", "1");

        (phpversion() >= "4.1.0") ? $teaserup = " [<a href=\"javascript:TeaserUpload()\">$words[UPL]</a>]" :
         $teaserup = "";

        if (file_exists("../images/teaser"))
        {

            echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\">$words[TIM]$teaserup:<br /><br /><a href=\"javascript:TeaserWin()\">$words[NTVA]</a></font></td><td></td><td><face face=\"Arial\" size=\"2\"><select size=\"4\" name=\"teaser\"><option selected value=\"\">$words[NTP]</option>";

            if ($configs[12])
            {
                $thisdate = date("m-Y");
                if (!file_exists("../images/teaser/$thisdate"))
                {
                    mkdir("../images/teaser/$thisdate", 0777);
                }
                $teaser_dir = GetDir("../images/teaser/$thisdate");
            }
            else
            {
                $teaser_dir = GetDir("../images/teaser");
            }

            for($i = 1; $i < count($teaser_dir); $i++)
            {
                if (preg_match("/(.gif|.jpeg|.jpg|.png)/i", $teaser_dir[$i]))
                {
                    echo "<option value=\"$teaser_dir[$i]\">$teaser_dir[$i]</option>";
                }
            }
            echo "</select></font></td></tr>";
        }

        echo "<input type=\"hidden\" name=\"aform\" value=\"doqadd\"><td><font face=\"Arial\" size=\"2\"><input type=\"submit\" value=\"$words[SND]\"></font></td></tr></table>";
        MkTabFooter();
        MkFooter();

    }

    //  ##########################################################

    function AdminNewsImages ($opts)
    {

        global $words, $admin;

        MkHeader("_self");
        MkTabHeader("$words[SRI2]");
        echo "<form action=\"index.php\" method=\"post\"><font size=\"2\" face=\"Verdana, Arial\">$words[SRC]</font>";
        echo "<input type=\"hidden\" name=\"aform\" value=\"searchnewsimgs\"><input name=\"zid\" size=\"32\"><input type=\"submit\" value=\"$words[SUB]\"></form>";
        echo "<font size=\"2\" face=\"Verdana, Arial\">$words[SID2]</font>";
        MkTabFooter();

        $image_dir = GetDir("../images/news");

        if (!$opts)
        {
            MkTabHeader("$words[AVAII]");
            $img_array = array("0-9","A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");

            for($z = 0; $z < count($img_array); $z++)
            {
                $images["$img_array[$z]"] = 0;
            }

            for($i = 1; $i < count($image_dir); $i++)
            {
                if (preg_match("/(.gif|.jpeg|.jpg|.png)/i", $image_dir[$i]))
                {
                    for($z = 1; $z < count($img_array); $z++)
                    {
                        if (strtoupper(substr($image_dir[$i],0,1)) == $img_array[$z])
                        {
                            $images["$img_array[$z]"]++;
                        }
                    }
                    if (preg_match("/[0-9]/i",substr($image_dir[$i],0,1)))
                    {
                        $images["0-9"]++;
                    }
                }
            }

            for($z = 0; $z < count($img_array); $z++)
            {
                $timages = $images["$img_array[$z]"];
                echo "<a href=\"index.php?action=shownewsimg&opts=$img_array[$z]\">$words[INDEX] $img_array[$z]</a> ($timages $words[IMAGE]) <br />";
            }
            MkTabFooter();


            if ((phpversion() >= "4.1.0") and ($admin[user_cannews] == 1))
            {
                MkTabHeader("$words[UPLIM]");
                echo "<form action=\"index.php\" method=\"post\" enctype=\"multipart/form-data\"><font size=\"2\" face=\"Verdana, Arial\">$words[IMF]</font>";
                echo "<input type=\"hidden\" name=\"aform\" value=\"newsimgup\"><input type=\"file\" name=\"newsifile\"><input type=\"submit\" value=\"Upload\"></form>";
                MkTabFooter();
            }

        }
        else
        {

            echo "<br />
                <script language=\"JavaScript\">
                <!--
                function AutoInsert(tag) {
                opener.document.newsstory.newstext1.value =
                opener.document.newsstory.newstext1.value + tag;
                }
                function AutoInsertExt(tag) {
                opener.document.newsstory.newstext2.value =
                opener.document.newsstory.newstext2.value + tag;
                }
                // -->
                </script>";

            for($i = 1; $i < count($image_dir); $i++)
            {
                if (preg_match("/(.gif|.jpeg|.jpg|.png)/i", $image_dir[$i]))
                {
                    if ($opts == "0-9")
                    {
                        if (preg_match("/[0-9]/i",strtoupper(substr($image_dir[$i],0,1))))
                        {
                            MkTabHeader("$image_dir[$i]");
                            echo "<center><img src=\"../images/news/$image_dir[$i]\" border=\"0\" alt=\"\"><br /><br /><a href=\"javascript:AutoInsert('[img]images/news/$image_dir[$i][/img]')\">$words[XSI2]</a> (<a href=\"javascript:AutoInsertExt('[img]images/news/$image_dir[$i][/img]')\">$words[EXTEN]</a>) | <a href=\"javascript:AutoInsert('[thumb]$image_dir[$i][/thumb]')\">$words[ITHUM]</a> (<a href=\"javascript:AutoInsertExt('[thumb]$image_dir[$i][/thumb]')\">$words[EXTEN]</a>)</center>";
                            MkTabFooter();
                        }
                    }
                    else
                    {
                        if (strtoupper(substr($image_dir[$i],0,1)) == $opts)
                        {
                            MkTabHeader("$image_dir[$i]");
                            echo "<center><img src=\"../images/news/$image_dir[$i]\" border=\"0\" alt=\"\"><br /><br /><a href=\"javascript:AutoInsert('[img]images/news/$image_dir[$i][/img]')\">$words[XSI2]</a> (<a href=\"javascript:AutoInsertExt('[img]images/news/$image_dir[$i][/img]')\">$words[EXTEN]</a>) | <a href=\"javascript:AutoInsert('[thumb]$image_dir[$i][/thumb]')\">$words[ITHUM]</a> (<a href=\"javascript:AutoInsertExt('[thumb]$image_dir[$i][/thumb]')\">$words[EXTEN]</a>)</center>";
                            MkTabFooter();
                        }
                    }
                }
            }
            echo "<center><font face=\"Arial\" size=\"2\">[<a href=\"index.php?action=shownewsimg\">$words[IMGBA]</a>]</font></center>";

        }
        echo "<center><font face=\"Arial\" size=\"2\">[<a href=\"javascript:self.close()\">$words[XSIC]</a>]</font></center>";
        MkFooter();

    }

    //  ##########################################################

    function AdminNewsImgSearch ()
    {

        global $words, $zid;

        MkHeader("_self");
        MkTabHeader("$words[SRI2]");
        echo "<form action=\"index.php\" method=\"post\"><font size=\"2\" face=\"Verdana, Arial\">$words[SRC]</font>";
        echo "<input type=\"hidden\" name=\"aform\" value=\"searchnewsimgs\"><input name=\"zid\" size=\"32\"><input type=\"submit\" value=\"$words[SUB]\"></form>";
        echo "<font size=\"2\" face=\"Verdana, Arial\">$words[SID2]</font>";
        MkTabFooter();

        $image_dir = GetDir("../images/news");

        echo "<br />
            <script language=\"JavaScript\">
            <!--
            function AutoInsert(tag) {
            opener.document.newsstory.newstext1.value =
            opener.document.newsstory.newstext1.value + tag;
            }
            function AutoInsertExt(tag) {
            opener.document.newsstory.newstext2.value =
            opener.document.newsstory.newstext2.value + tag;
            }
            // -->
            </script>";

        for($i = 1; $i < count($image_dir); $i++)
        {
            if (preg_match("/(.gif|.jpeg|.jpg|.png)/i", $image_dir[$i]))
            {
                if (preg_match("/$zid/i",$image_dir[$i]))
                {
                    MkTabHeader("$image_dir[$i]");
                    echo "<center><a href=\"javascript:AutoInsert('[img]images/news/$image_dir[$i][/img]')\"><img src=\"../images/news/$image_dir[$i]\" border=\"0\" alt=\"\"><br /><br />$words[XSI2]</a> (<a href=\"javascript:AutoInsertExt('[img]images/news/$image_dir[$i][/img]')\">$words[EXTEN]</a>) | <a href=\"javascript:AutoInsert('[thumb]$image_dir[$i][/thumb]')\">$words[ITHUM]</a> (<a href=\"javascript:AutoInsertExt('[thumb]$image_dir[$i][/thumb]')\">$words[EXTEN]</a>)</center>";
                    MkTabFooter();
                }
            }
        }
        echo "<center><font face=\"Arial\" size=\"2\">[<a href=\"index.php?action=shownewsimg\">$words[IMGBA]</a>]</font></center>";
        echo "<center><font face=\"Arial\" size=\"2\">[<a href=\"javascript:self.close()\">$words[XSIC]</a>]</font></center>";
        MkFooter();

    }

    //  ##########################################################

    function SearchNews()
    {

        global $words, $zid;

        MkHeader("_self");
        MkTabHeader("$words[EDN]");
        echo "<form action=\"index.php\" method=\"post\"><font size=\"2\" face=\"Verdana, Arial\">$words[SR]:</font>";
        echo "<input name=\"zid\" size=\"32\" value=\"$zid\"><input type=\"submit\" value=\"$words[SM]\"><input type=\"hidden\" name=\"aform\" value=\"searchnews\"></form>";
        MkTabFooter();

        $szid = stripslashes($zid);

        $result = DBQuery("SELECT story_website, story_title, story_id, story_sticky, story_hook FROM esselbach_st_stories WHERE (story_title like '%$zid%') ORDER BY story_id DESC LIMIT 100");

        TblHeader("$words[SSI]", "$words[STW] $szid");

        while (list($story_website, $story_title, $story_id, $story_sticky, $story_hook) = mysql_fetch_row($result))
        {
            $story_title = ReChomp($story_title);
            ($story_sticky) ? $featured = "<b>$words[FEATR]</b>" :
             $featured = "";

            if ($story_hook)
            {
                $story_title = "<font color=\"red\">$story_title</font>";
            }
            TblMiddle("$story_id / $story_website", "$story_title $featured", "editnews&opts=editstory-$story_id", "editnews&opts=deletestory-$story_id");
        }

        MkFooter();

    }

    //  ##########################################################

    function TeaserUpload ()
    {

        global $words, $configs;

        if (phpversion() >= "4.1.0")
        {
            $upfile = strtolower($_FILES[teaserfile][name]);
            if (!preg_match("/(gif|jpg|jpeg|png)/i", substr($upfile,-4)))
            {
                MkHeader("_self");
                MkTabHeader ("$words[ERR]");
                echo $words[IA];
                MkTabFooter();
                echo "<center><font face=\"Arial\" size=\"2\">[<a href=\"javascript:self.close()\">$words[XSIC]</a>]</font></center>";
                MkFooter();
            }
            if ($_FILES[teaserfile][size] > 25000)
            {
                MkHeader("_self");
                MkTabHeader ("$words[ERR]");
                echo $words[WB];
                MkTabFooter();
                echo "<center><font face=\"Arial\" size=\"2\">[<a href=\"javascript:self.close()\">$words[XSIC]</a>]</font></center>";
                MkFooter();
            }
            ($configs[12]) ? $uppath = date("m-Y")."/".$upfile :
             $uppath = $upfile;
            if (move_uploaded_file($_FILES[teaserfile][tmp_name], "../images/teaser/".$uppath))
            {
                @chmod ("../images/teaser/$uppath", 0777);
                MkHeader("_self");
                MkTabHeader ("$words[DO]");
                echo $words[IS];
                MkTabFooter();
                echo "<center><font face=\"Arial\" size=\"2\">[<a href=\"javascript:self.close()\">$words[XSIC]</a>]</font></center>";
                MkFooter();
            }
            else
            {
                MkHeader("_self");
                MkTabHeader ("$words[ERR]");
                echo $words[UF];
                MkTabFooter();
                echo "<center><font face=\"Arial\" size=\"2\">[<a href=\"javascript:self.close()\">$words[XSIC]</a>]</font></center>";
                MkFooter();
            }
        }
        else
        {
            MkHeader("_self");
            MkTabHeader ("$words[ERR]");
            echo $words[PHP];
            echo "<center><font face=\"Arial\" size=\"2\">[<a href=\"javascript:self.close()\">$words[XSIC]</a>]</font></center>";
            MkFooter();
            MkTabFooter();
        }
    }

    //  ##########################################################

    function NewsImgUp ()
    {

        global $words;

        if (phpversion() >= "4.1.0")
        {
            $upfile = strtolower($_FILES[newsifile][name]);
            if (!preg_match("/(.gif|.jpg|.jpeg|.png)/i", substr($upfile,-4)))
            {
                MkHeader("_self");
                MkTabHeader ("$words[ERR]");
                echo $words[IA];
                MkTabFooter();
                echo "<center><font face=\"Arial\" size=\"2\">[<a href=\"index.php?action=shownewsimg\">$words[IMGBA]</a>]</font></center>";
                echo "<center><font face=\"Arial\" size=\"2\">[<a href=\"javascript:self.close()\">$words[XSIC]</a>]</font></center>";
                MkFooter();
            }
            if ($_FILES[newsifile][size] > 250000)
            {
                MkHeader("_self");
                MkTabHeader ("$words[ERR]");
                echo $words[WB];
                MkTabFooter();
                echo "<center><font face=\"Arial\" size=\"2\">[<a href=\"index.php?action=shownewsimg\">$words[IMGBA]</a>]</font></center>";
                echo "<center><font face=\"Arial\" size=\"2\">[<a href=\"javascript:self.close()\">$words[XSIC]</a>]</font></center>";
                MkFooter();
            }
            if (move_uploaded_file($_FILES[newsifile][tmp_name], "../images/news/".$upfile))
            {
                @chmod ("../images/news/$upfile", 0777);
                MkHeader("_self");
                MkTabHeader ("$words[DO]");
                echo $words[IS];
                MkTabFooter();
                echo "<center><font face=\"Arial\" size=\"2\">[<a href=\"index.php?action=shownewsimg\">$words[IMGBA]</a>]</font></center>";
                echo "<center><font face=\"Arial\" size=\"2\">[<a href=\"javascript:self.close()\">$words[XSIC]</a>]</font></center>";
                MkFooter();
            }
            else
            {
                MkHeader("_self");
                MkTabHeader ("$words[ERR]");
                echo $words[UF];
                MkTabFooter();
                echo "<center><font face=\"Arial\" size=\"2\">[<a href=\"javascript:self.close()\">$words[XSIC]</a>]</font></center>";
                MkFooter();
            }
        }
        else
        {
            MkHeader("_self");
            MkTabHeader ("$words[ERR]");
            echo $words[PHP];
            MkTabFooter();
            echo "<center><font face=\"Arial\" size=\"2\">[<a href=\"javascript:self.close()\">$words[XSIC]</a>]</font></center>";
            MkFooter();
        }
    }

    //  ##########################################################

    function AddNewsCat ()
    {

        global $words, $category, $categorydsc;

        DBQuery("INSERT INTO esselbach_st_categories VALUES (NULL, '$category', '$categorydsc')");

        MkHeader("_self");
        MkTabHeader ("$words[DO]");
        echo $words[CA];
        MkTabFooter();
        MkFooter();

    }

    //  ##########################################################

    function EditNewsCat ()
    {

        global $words, $category, $categorydsc, $zid;

        DBQuery("UPDATE esselbach_st_categories SET category_name='$category', category_name='$categorydsc' WHERE category_id = '$zid'");

        MkHeader("_self");
        MkTabHeader ("$words[DO]");
        echo $words[CU];
        MkTabFooter();
        MkFooter();
    }

    //  ##########################################################

    function EditNews ()
    {

        global $words, $admin, $newstitle, $website, $category, $newstext1, $newstext2, $mainnewsonly, $source, $teaser, $extra1, $extra2, $extra3, $extra4, $extra5, $extra6, $extra7, $extra8, $extra9, $extra10, $extra11, $extra12, $extra13, $extra14, $extra15, $extra16, $extra17, $extra18, $extra19, $extra20, $extrag12, $htmlen, $iconen, $codeen, $ipaddr, $extrae12, $extrag13, $commen, $zid, $bump;

        if ($admin[user_cannews] == 2)
        {
            $result = DBQuery("SELECT story_author FROM esselbach_st_stories WHERE story_id = '$zid'");
            list($storyauthor) = mysql_fetch_row($result);

            if ($storyauthor != $admin[user_name])
            {
                MkHeader("_self");
                MkTabHeader ("$words[ERR]");
                echo "$words[RNEWS]";
                MkTabFooter();
                MkFooter();
            }
        }

        DBQuery("UPDATE esselbach_st_stories SET
            story_title='$newstitle', story_website='$website', story_category='$category',
            story_text='$newstext1', story_extendedtext='$newstext2',
            story_main='$mainnewsonly', story_source='$source', story_teaser='$teaser',
            story_extra1='$extra1', story_extra2='$extra2', story_extra3='$extra3',
            story_extra4='$extra4', story_extra5='$extra5', story_extra6='$extra6',
            story_extra7='$extra7', story_extra8='$extra8', story_extra9='$extra9',
            story_extra10='$extra10', story_extra11='$extra11', story_extra12='$extra12',
            story_extra13='$extra13', story_extra14='$extra14', story_extra15='$extra15',
            story_extra16='$extra16', story_extra17='$extra17', story_extra18='$extra18',
            story_extra19='$extra19', story_extra20='$extra20', story_html='$htmlen',
            story_icon='$iconen', story_code='$codeen', story_editip='$ipaddr',
            story_editreason = '$extrae12', story_sticky = '$extrag12',
            story_comm='$commen', story_hook='$extrag13' WHERE story_id='$zid'");

        if ($bump)
        {
            DBQuery("UPDATE esselbach_st_stories SET story_time=now() WHERE story_id=$zid");
        }

        if (!$extrag13)
        {
            UpdateIndex ($zid, $website, 1, $newstitle, $newstext1.$newstext2);
        }

        $result = DBQuery("SELECT DISTINCT SUBSTRING_INDEX(story_time,'-','2'), story_category FROM esselbach_st_stories WHERE story_id='$zid'");
        list($story_time, $story_category) = mysql_fetch_row($result);
        $story_time_array = explode("-", $story_time);
        $archiveid = $story_time_array[0].$story_time_array[1];

        RemoveCache ("archive/archive-$archiveid");
        RemoveCache ("categories/category-$story_category");
        RemoveCache ("categories/category");
        RemoveCache ("xml/xmlnews-$story_category");
        RemoveCache ("xml/xmlnews-0");
        RemoveCache ("xml/xmlhelp");
        RemoveCache ("news/sidebar");

        $result = DBQuery("SELECT story_comments FROM esselbach_st_stories WHERE story_id = '$zid'");
        list($comments) = mysql_fetch_row($result);
        $pages = $comments/25;
        $pages++;

        for($p = 1; $p < $pages; $p++)
        {
            RemoveCache ("story/story-$zid-$p");
        }

        RemoveCache ("story/story-$zid-1");
        RemoveCache ("story/storyp-$zid");
        RemoveCache ("tags/story-$zid");
        RemoveCache ("news/mainnews");
        RemoveCache ("news/mobilenews");
        RemoveCache ("news/comments");
        RemoveCache ("news/header_block");
        RemoveCache ("news/footer_block");

        MkHeader("_self");
        MkTabHeader ("$words[DO]");
        echo $words[SC];
        MkTabFooter();
        MkFooter();

    }

    //  ##########################################################

    function AddNews()
    {

        global $words, $website, $category, $admin, $newstitle, $newstext1, $newstext2, $mainnewsonly, $source, $teaser, $extra1, $extra2, $extra3, $extra4, $extra5, $extra6, $extra7, $extra8, $extra9, $extra10, $extra11, $extra12, $extra13, $extra14, $extra15, $extra16, $extra17, $extra18, $extra19, $extra20, $extrag12, $extrag13, $htmlen, $iconen, $codeen, $ipaddr, $commen;

        DBQuery("INSERT INTO esselbach_st_stories VALUES (NULL, '$website', '$category', '$admin[user_name]', '$newstitle', '$newstext1', '$newstext2', '$mainnewsonly', now(), '0', '$source', '$teaser',
            '$extra1', '$extra2', '$extra3', '$extra4', '$extra5', '$extra6', '$extra7', '$extra8', '$extra9', '$extra10', '$extra11', '$extra12', '$extra13', '$extra14', '$extra15', '$extra16', '$extra17', '$extra18', '$extra19', '$extra20', '$htmlen', '$iconen', '$codeen', '$ipaddr', '$ipaddr', '', '$extrag13', '$extrag12', '$commen')");

        $result = DBQuery("SELECT story_id, story_time FROM esselbach_st_stories ORDER BY story_id DESC LIMIT 1");
        list($id, $time) = mysql_fetch_row($result);

        if (!$extrag13)
        {
            AddIndex ($id, $website, 1, $admin[user_name], $newstitle, $newstext1.$newstext2, $time);
        }

        $archivedate = date("Y").date("m");
        RemoveCache ("archive/archive");
        RemoveCache ("archive/archive-$archivedate");
        RemoveCache ("category/category-$category");
        RemoveCache ("category/category");
        RemoveCache ("news/mainnews");
        RemoveCache ("xml/xmlnews-0");
        RemoveCache ("xml/xmlhelp");
        RemoveCache ("xml/xmlnews-$category");
        RemoveCache ("news/mobilenews");
        RemoveCache ("news/sidebar");
        RemoveCache ("xml/xmlnews-200");
        RemoveCache ("news/header_block");
        RemoveCache ("news/footer_block");

        MkHeader("_self");
        MkTabHeader ("$words[DO]");
        echo $words[SA];
        MkTabFooter();
        MkFooter();

    }

    //  ##########################################################

    function AddQuickNews ()
    {

        global $words, $website, $category, $admin, $newstitle, $newstext1, $mainnewsonly, $source, $teaser, $htmlen, $iconen, $codeen, $ipaddr, $commen, $extra1, $extrag13;

        if (count($newstitle) > 0)
        {
            for($n = 0; $n < count($newstitle); $n++)
            {
                if (($newstitle[$n]) and (!$extra1[$n]))
                {
                    DBQuery("INSERT INTO esselbach_st_stories VALUES (NULL, '$website', '$category[$n]', '$admin[user_name]', '$newstitle[$n]', '$newstext1[$n]', '', '$mainnewsonly', now(), '0', '$source', '$teaser', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '$htmlen', '$iconen', '$codeen', '$ipaddr', '$ipaddr', '', '$extrag13', '0', '$commen')");
                    if (!$id)
                    {
                        $result = DBQuery("SELECT story_id, story_time FROM esselbach_st_stories ORDER BY story_id DESC LIMIT 1");
                        list($id, $time) = mysql_fetch_row($result);
                    }
                    else
                    {
                        $id++;
                    }
                    if (!$extrag13)
                    {
                        AddIndex ($id, $website, 1, $admin[user_name], $newstitle[$n], $newstext1[$n], $time);
                    }
                }
            }
        }
        else
        {
            DBQuery("INSERT INTO esselbach_st_stories VALUES (NULL, '$website', '$category[0]', '$admin[user_name]', '$newstitle[0]', '$newstext1[0]', '', '$mainnewsonly', now(), '0', '$source', '$teaser', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '$htmlen', '$iconen', '$codeen', '$ipaddr', '$ipaddr', '', '0', '0', '$commen')");
            $result = DBQuery("SELECT story_id, story_time FROM esselbach_st_stories ORDER BY story_id DESC LIMIT 1");
            list($id, $time) = mysql_fetch_row($result);
            AddIndex ($id, $website, 1, $admin[user_name], $newstitle[0], $newstext1[0], $time);
        }


        $archivedate = date("Y").date("m");
        RemoveCache ("archive/archive");
        RemoveCache ("archive/archive-$archivedate");
        RemoveCache ("categories/category-$category");
        RemoveCache ("categories/category");
        RemoveCache ("xml/xmlnews-$category");
        RemoveCache ("news/sidebar");
        RemoveCache ("news/mainnews");
        RemoveCache ("xml/xmlnews-0");
        RemoveCache ("xml/xmlhelp");
        RemoveCache ("news/mobilenews");
        RemoveCache ("news/header_block");
        RemoveCache ("news/footer_block");

        MkHeader("_self");
        MkTabHeader ("$words[DO]");
        echo $words[SA];
        MkTabFooter();
        MkFooter();

    }

    //  ##########################################################

    function AddImport ()
    {

        global $words, $admin, $category, $categorydsc, $htmlen, $ipaddr;

        $iwebsite = @fopen("$categorydsc", "r");

        if (!$iwebsite)
        {
            MkHeader("_self");
            MkTabHeader ("$words[ERR]");
            echo $words[IE];
            MkTabFooter();
            MkFooter();
        }

        DBQuery("INSERT INTO esselbach_st_import VALUES (NULL, '$admin[user_name]', '$category', '$categorydsc', '$htmlen', '$ipaddr')");

        MkHeader("_self");
        MkTabHeader ("$words[DO]");
        echo $words[WA];
        MkTabFooter();
        MkFooter();

    }

    //  ##########################################################

    function AdminSearchNews()
    {

        global $words;

        MkHeader("_self");
        MkTabHeader("$words[NEWSR]");
        echo "<form action=\"index.php\" method=\"post\"><font size=\"2\" face=\"Verdana, Arial\">$words[FOS]</font><br />";
        echo "<input type=\"hidden\" name=\"aform\" value=\"searchreplacenews\"><textarea cols=\"100%\" name=\"zid\" rows=\"2\"></textarea><br />";
        echo "$words[INFLD] <select size=\"1\" name=\"extra2\"><option value=\"title\">title</option><option value=\"text\">text</option><option value=\"extendedtext\">extendedtext</option>";
        for($i = 1; $i < 21; $i++)
        {
            echo "<option value=\"extra".$i."\">extra".$i."</option>";
        }
        echo "</select> ";
        echo "$words[AREP]</font><textarea cols=\"100%\" name=\"extra1\" rows=\"2\"></textarea><br /><input type=\"submit\" value=\"$words[SUB]\"></form>";
        MkTabFooter();
        MkFooter();
    }

   //  ##########################################################

    function NewsSearchReplace ()
    {

        global $words, $zid, $extra1, $extra2, $ipaddr;

        MkHeader("_self");
        MkTabHeader ("$words[DO]");

        $search_field = "story_".$extra2;
        $query = DBQuery("SELECT * FROM esselbach_st_stories WHERE ($search_field LIKE '%$zid%')");

        $totalrows = 0;
        while ($rows = mysql_fetch_array($query))
        {
            $out_field = str_replace("$zid", "$extra1", $rows[$search_field]);
            DBQuery("UPDATE esselbach_st_stories SET $search_field = '$out_field', story_editip = '$ipaddr' WHERE story_id = '$rows[story_id]'");
            $totalrows++;
        }

        echo $totalrows." ".$words[ENTCH];

        ClearCache("news");
        ClearCache("categories");
        ClearCache("archive");
        ClearCache("story");
        ClearCache("xml");

        MkTabFooter();
        MkFooter();

    }

?>
