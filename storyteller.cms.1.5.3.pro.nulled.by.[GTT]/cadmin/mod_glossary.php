<?php

    /*
    ########################
    # |//////////////////| #
    # NULLED by [GTT] =)   #
    # |\\\\\\\\\\\\\\\\\\| #
    ########################
    */

    function AdminEditGlossary($opts)
    {

        global $words, $admin, $midas;
        dbconnect();

        $options = explode("-", $opts);

        if (($options[0]) and ($admin[user_canglossary] == 2))
        {
            $result = DBQuery("SELECT glossary_author FROM esselbach_st_glossary WHERE glossary_id = '$options[1]'");
            list($glossaryauthor) = mysql_fetch_row($result);

            if ($glossaryauthor != $admin[user_name])
            {
                MkHeader("_self");
                MkTabHeader ("$words[ERR]");
                echo "$words[RGLOS]";
                MkTabFooter();
                MkFooter();
            }
        }
        if ($options[0] == "deleteglossary")
        {

            $query = DBQuery("SELECT glossary_title FROM esselbach_st_glossary WHERE glossary_id = '$options[1]'");
            list($glotitle) = mysql_fetch_row($query);

            $result = DBQuery("DELETE FROM esselbach_st_glossary WHERE glossary_id='$options[1]'");

            $glossary_array = array("0-9", "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z");


            for($i = 1; $i < count($glossary_array); $i++)
            {
                if ($glossary_array[$i] == substr($glotitle, 0, 1)) $gid = $i;
            }

            RemoveCache ("glossary/glossary-0");
            RemoveCache ("glossary/glossary-$gid");

            MkHeader("_self");
            MkTabHeader ("$words[DO]");
            echo "$words[GSR]";
            MkTabFooter();
            MkFooter();

        }

        if ($options[0] == "editglossary")
        {

            $result = DBQuery("SELECT * FROM esselbach_st_glossary WHERE glossary_id='$options[1]'");
            $glossary = mysql_fetch_array($result);

            MkHeader("_self");
            MkTabHeader("$words[EGE] $options[1]");

            echo "<table><form name=\"glossary\" action=\"index.php\" method=\"post\">";

            $query = DBQuery("SELECT website_id, website_name FROM esselbach_st_websites");
            if (mysql_num_rows($query) > 1)
            {

                echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\">$words[WBS]</font></td><td></td><td><face face=\"Arial\" size=\"2\"><select size=\"1\" name=\"website\">";

                echo "<option value=\"0\">$words[ALL]</option>";
                while (list($website_id, $website_name) = mysql_fetch_row($query))
                {
                    ($website_id == $glossary['glossary_website']) ? $select = "selected" :
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
                document.glossary.newstext1.value =
                document.glossary.newstext1.value + tag;
                }
                //-->
                </script>";
            }

            MkOption ("$words[TIT]", "", "newstitle", "$glossary[glossary_title]");

            if (!$midas) QuickHTML(1);

            MkArea ("$words[DSC]", "newstext1", "$glossary[glossary_text]");

            MkSelect ("$words[EHT]", "htmlen", "$glossary[glossary_html]");
            MkSelect ("$words[EIS]", "iconen", "$glossary[glossary_icon]");
            MkSelect ("$words[EBC]", "codeen", "$glossary[glossary_code]");

            echo "<input type=\"hidden\" name=\"aform\" value=\"doglossaryedit\"><input type=\"hidden\" name=\"zid\" value=\"$glossary[glossary_id]\"><td><font face=\"Arial\" size=\"2\"><input type=\"submit\" value=\"$words[SND]\"></font></td></tr></td>";
            MkTabFooter();

            if ($midas)
            {
                EnableMidas("newstext1");
            }

            MkFooter();
        }

        MkHeader("_self");
        MkTabHeader("$words[EDG]");
        echo "$words[ED4]";
        MkTabFooter();

        TblHeader("$words[ESI]", "$words[GLE]");

        $result = DBQuery("SELECT glossary_website, glossary_title, glossary_id FROM esselbach_st_glossary ORDER BY glossary_id DESC");

        while (list($glossary_website, $glossary_title, $glossary_id) = mysql_fetch_row($result))
        {
            TblMiddle2("$glossary_id / $glossary_website", "$glossary_title", "editglossary&opts=editglossary-$glossary_id", "editglossary&opts=deleteglossary-$glossary_id");
        }

        TblFooter();

        MkTabHeader("$words[ANE]");
        echo "<table><form name=\"glossary\" action=\"index.php\" method=\"post\">";

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
            document.glossary.newstext1.value =
            document.glossary.newstext1.value + tag;
            }
            //-->
            </script>";
        }

        MkOption ("$words[TIT]", "", "newstitle", "");

        if (!$midas) QuickHTML(1);

        MkArea ("$words[DSC]", "newstext1", "");

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

        echo "<input type=\"hidden\" name=\"aform\" value=\"addglossary\"><td><font face=\"Arial\" size=\"2\"><input type=\"submit\" value=\"$words[SND]\"></font></td></tr></table>";
        MkTabFooter();

        if ($midas)
        {
            EnableMidas("newstext1");
        }

        MkFooter();

    }

    //  ##########################################################

    function GlossaryEdit ()
    {

        global $words, $admin, $zid, $newstitle, $website, $newstext1, $htmlen, $iconen, $codeen, $ipaddr;

        if ($admin[user_canglossary] == 2)
        {
            $result = DBQuery("SELECT glossary_author FROM esselbach_st_glossary WHERE glossary_id = '$zid'");
            list($glossaryauthor) = mysql_fetch_row($result);

            if ($glossaryauthor != $admin[user_name])
            {
                MkHeader("_self");
                MkTabHeader ("$words[ERR]");
                echo "$words[RGLOS]";
                MkTabFooter();
                MkFooter();
            }
        }

        DBQuery("UPDATE esselbach_st_glossary SET glossary_title='$newstitle', glossary_website='$website', glossary_text='$newstext1', glossary_html='$htmlen', glossary_icon='$iconen', glossary_code='$codeen', glossary_editip='$ipaddr' WHERE glossary_id='$zid'");

        $glossary_array = array("0-9", "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z");

        for($i = 1; $i < count($glossary_array); $i++)
        {
            if ($glossary_array[$i] == substr($newstitle, 0, 1))
            {
                $gid = $i;
            }
        }

        RemoveCache ("glossary/glossary-0");
        RemoveCache ("glossary/glossary-$gid");

        MkHeader("_self");
        MkTabHeader ("$words[DO]");
        echo $words[GC];
        MkTabFooter();
        MkFooter();

    }

    //  ##########################################################

    function GlossaryAdd ()
    {

        global $words, $website, $admin, $newstitle, $newstext1, $htmlen, $iconen, $codeen, $ipaddr;

        DBQuery("INSERT INTO esselbach_st_glossary VALUES (NULL, '$website', '$admin[user_name]', '$newstitle', '$newstext1', '$htmlen', '$iconen', '$codeen', '$ipaddr', '$ipaddr')");

        $glossary_array = array("0-9", "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z");

        for($i = 1; $i < count($glossary_array); $i++)
        {
            if ($glossary_array[$i] == substr($newstitle, 0, 1))
            {
                $gid = $i;
            }
        }

        RemoveCache ("glossary/glossary-0");
        RemoveCache ("glossary/glossary-$gid");

        MkHeader("_self");
        MkTabHeader ("$words[DO]");
        echo $words[GA];
        MkTabFooter();
        MkFooter();

    }

    //  ##########################################################

    function AdminSearchGlossary()
    {

        global $words;

        MkHeader("_self");
        MkTabHeader("$words[NEWGL]");
        echo "<form action=\"index.php\" method=\"post\"><font size=\"2\" face=\"Verdana, Arial\">$words[FOS]</font><br />";
        echo "<input type=\"hidden\" name=\"aform\" value=\"searchreplaceglossary\"><textarea cols=\"100%\" name=\"zid\" rows=\"2\"></textarea><br />";
        echo "$words[INFLD] <select size=\"1\" name=\"extra2\"><option value=\"title\">title</option><option value=\"text\">text</option></select> ";
        echo "$words[AREP]</font><textarea cols=\"100%\" name=\"extra1\" rows=\"2\"></textarea><br /><input type=\"submit\" value=\"$words[SUB]\"></form>";
        MkTabFooter();
        MkFooter();
    }

   //  ##########################################################

    function GlossarySearchReplace ()
    {

        global $words, $zid, $extra1, $extra2, $ipaddr;

        MkHeader("_self");
        MkTabHeader ("$words[DO]");

        $search_field = "glossary_".$extra2;
        $query = DBQuery("SELECT * FROM esselbach_st_glossary WHERE ($search_field LIKE '%$zid%')");

        $totalrows = 0;
        while ($rows = mysql_fetch_array($query))
        {
            $out_field = str_replace("$zid", "$extra1", $rows[$search_field]);
            DBQuery("UPDATE esselbach_st_glossary SET $search_field = '$out_field', glossary_editip = '$ipaddr' WHERE glossary_id = '$rows[glossary_id]'");
            $totalrows++;
        }

        echo $totalrows." ".$words[ENTCH];

        ClearCache("news");
        ClearCache("glossary");

        MkTabFooter();
        MkFooter();

    }

?>
