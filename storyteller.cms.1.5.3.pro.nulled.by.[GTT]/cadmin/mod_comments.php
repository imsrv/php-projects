<?php

    /*
    ########################
    # |//////////////////| #
    # NULLED by [GTT] =)   #
    # |\\\\\\\\\\\\\\\\\\| #
    ########################
    */

    function AdminEditComment($opts)
    {

        global $words;
        dbconnect();

        $options = explode("-", $opts);
        if ($options[0] == "deletecomment")
        {

            $result = DBQuery("SELECT * FROM esselbach_st_comments WHERE comment_id='$options[1]'");
            $crows = mysql_num_rows($result);
            $data = mysql_fetch_array($result);
            $pages = substr($crows/25, 0, 1);

            if ($data[comment_category] == 1)
            {
                if ($pages > 1)
                {
                    $pages++;
                    for($a = 1; $a < $pages; $a++)
                    {
                        RemoveCache ("story/story-$data[comment_story]-$a");
                    }
                }
                else
                {
                    RemoveCache ("story/story-$data[comment_story]-1");
                }

                DBQuery("UPDATE esselbach_st_stories SET story_comments=story_comments-1 WHERE story_id = '$data[comment_story]'");
                RemoveCache ("news/mainnews");
            }

            if ($data[comment_category] == 2)
            {
                if ($pages > 1)
                {
                    $pages++;
                    for($a = 1; $a < $pages; $a++)
                    {
                        RemoveCache ("polls/poll-$data[comment_story]-$a");
                    }
                }
                else
                {
                    RemoveCache ("polls/poll-$data[comment_story]-1");
                }

                DBQuery("UPDATE esselbach_st_polls SET poll_comments=poll_comments-1 WHERE poll_id = '$data[comment_story]'");
            }

            if ($data[comment_category] == 3)
            {
                if ($pages > 1)
                {
                    $pages++;
                    for($a = 1; $a < $pages; $a++)
                    {
                        RemoveCache ("downloaddet/download-$data[comment_story]-$a");
                    }
                }
                else
                {
                    RemoveCache ("downloaddet/download-$data[comment_story]-1");
                }

                DBQuery("UPDATE esselbach_st_downloads SET download_comments=download_comments-1 WHERE download_id = '$data[comment_story]'");
            }

            DBQuery("DELETE FROM esselbach_st_comments WHERE comment_id='$options[1]'");

            MkHeader("_self");
            MkTabHeader ("$words[DO]");
            echo "$words[ZSR]";
            MkTabFooter();
            MkFooter();

        }

        if ($options[0] == "editcomment")
        {

            $result = DBQuery("SELECT * FROM esselbach_st_comments WHERE comment_id='$options[1]'");
            $comment = mysql_fetch_array($result);

            MkHeader("_self");
            MkTabHeader("$words[ED1] $options[1]");

            echo "<table><form name=\"editcomment\" action=\"index.php\" method=\"post\">";

            echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\">$words[ICO]</font></td><td></td><td><face face=\"Arial\" size=\"2\">";

            $icon_array = array("note", "alert", "question", "star", "idea", "disk", "smile", "wink", "sad", "mad", "happy", "tongue", "sleep", "cool", "ssad", "frown", "up", "down");
            for($z = 0; $z < count($icon_array); $z++)
            {
                $y = $z;
                $y++;
                ($comment[comment_icon] == $y) ? $checked = "checked" :
                 $checked = "";
                if ($y == 10) echo "<br />";
                echo "<input type=\"radio\" name=\"extra1\" value=\"$y\" $checked /><img src=\"../images/icons/icon_$icon_array[$z].png\" />&nbsp;";
            }

            echo "</font></td></tr>";

            echo "<script language=\"JavaScript\">
                <!--
                function AutoInsert1(tag) {
                document.editcomment.newstext1.value =
                document.editcomment.newstext1.value + tag;
                }
                //-->
                </script>";

            QuickHTML(1);

            MkArea ("$words[PST]", "newstext1", "$comment[comment_text]");

            MkSelect ("$words[ESG]", "htmlen", "$comment[comment_signature]");
            MkSelect ("$words[DSM]", "iconen", "$comment[comment_smilies]");
            MkSelect ("$words[DBC]", "codeen", "$comment[comment_bcode]");

            MkSelect ("$words[COMMO]", "extrag13", "$comment[comment_plonk]");

            echo "<tr><td> </td></tr> <input type=\"hidden\" name=\"aform\" value=\"docommentedit\"><input type=\"hidden\" name=\"zid\" value=\"$comment[comment_id]\"><td><font face=\"Arial\" size=\"2\"><input type=\"submit\" value=\"$words[SND]\"></font></td></tr></table>";
            MkTabFooter();
            MkFooter();
        }

        MkHeader("_self");
        MkTabHeader("$words[ED2]");
        echo "<form action=\"index.php\" method=\"post\"><font size=\"2\" face=\"Verdana, Arial\">$words[SRC]</font>";
        echo "<input type=\"hidden\" name=\"aform\" value=\"searchcomments\"><input name=\"zid\" size=\"32\"><input type=\"submit\" value=\"$words[SUB]\"></form>";
        MkTabFooter();

        TblHeader("$words[CSI]", "$words[TIT]");


        $result = DBQuery("SELECT * FROM esselbach_st_comments ORDER BY comment_id DESC LIMIT 100");

        while ($comment_array = mysql_fetch_array($result))
        {
            if ($comment_array[comment_category] == 1)
            {
                $query = DBQuery("SELECT story_title FROM esselbach_st_stories WHERE story_id = '$comment_array[comment_story]'");
                list($story) = mysql_fetch_row($query);
                $onn = "$words[CNS] \"$story\"";
            }
            if ($comment_array[comment_category] == 2)
            {
                $query = DBQuery("SELECT poll_title FROM esselbach_st_polls WHERE poll_id = '$comment_array[comment_story]'");
                list($story) = mysql_fetch_row($query);
                $onn = "$words[CPL] \"$story\"";
            }
            if ($comment_array[comment_category] == 3)
            {
                $query = DBQuery("SELECT download_title FROM esselbach_st_downloads WHERE download_id = '$comment_array[comment_story]'");
                list($story) = mysql_fetch_row($query);
                $onn = "$words[CDL] \"$story\"";
            }
            if ($comment_array[comment_plonk])
            {
                $plonk = "<font color=\"red\">";
                $plonk2 = "</font>";
            }
            else
            {
                $plonk = "";
                $plonk2 = "";
            }
            TblMiddle("$comment_array[comment_id] / $comment_array[comment_website]", "$plonk $words[CON] $onn $words[CBY] $comment_array[comment_author] $plonk2", "comments&opts=editcomment-$comment_array[comment_id]", "comments&opts=deletecomment-$comment_array[comment_id]");
        }

        MkFooter();

    }

    //  ##########################################################

    function SearchComments()
    {

        global $words, $zid;

        MkHeader("_self");
        MkTabHeader("$words[ED2]");
        echo "<form action=\"index.php\" method=\"post\"><font size=\"2\" face=\"Verdana, Arial\">$words[SRC]</font>";
        echo "<input name=\"zid\" size=\"32\" value=\"$zid\"><input type=\"submit\" value=\"$words[SUB]\"><input type=\"hidden\" name=\"aform\" value=\"searchcomments\"></form>";
        MkTabFooter();

        TblHeader("$words[CSI]", "$words[COTW] $zid");

        $result = DBQuery("SELECT * FROM esselbach_st_comments WHERE (comment_text like '%$zid%') ORDER BY comment_id DESC LIMIT 100");

        while ($comment_array = mysql_fetch_array($result))
        {
           if ($comment_array[comment_category] == 1)
            {
                $query = DBQuery("SELECT story_title FROM esselbach_st_stories WHERE story_id = '$comment_array[comment_story]'");
                list($story) = mysql_fetch_row($query);
                $onn = "$words[CNS] \"$story\"";
            }
            if ($comment_array[comment_category] == 2)
            {
                $query = DBQuery("SELECT poll_title FROM esselbach_st_polls WHERE poll_id = '$comment_array[comment_story]'");
                list($story) = mysql_fetch_row($query);
                $onn = "$words[CPL] \"$story\"";
            }
            if ($comment_array[comment_category] == 3)
            {
                $query = DBQuery("SELECT download_title FROM esselbach_st_downloads WHERE download_id = '$comment_array[comment_story]'");
                list($story) = mysql_fetch_row($query);
                $onn = "$words[CDL] \"$story\"";
            }
            if ($comment_array[comment_plonk])
            {
                $plonk = "<font color=\"red\">";
                $plonk2 = "</font>";
            }
            else
            {
                $plonk = "";
                $plonk2 = "";
            }
            TblMiddle("$comment_array[comment_id] / $comment_array[comment_website]", "$plonk $words[CON] $onn $words[CBY] $comment_array[comment_author] $plonk2", "comments&opts=editcomment-$comment_array[comment_id]", "comments&opts=deletecomment-$comment_array[comment_id]");
        }

        MkFooter();

    }

    //  ##########################################################

    function CommentEdit ()
    {

        global $words, $newstext1, $zid, $ipaddr, $extra1, $htmlen, $iconen, $codeen, $extrag13;

        DBQuery("UPDATE esselbach_st_comments SET comment_text='$newstext1', comment_editip='$ipaddr', comment_icon='$extra1', comment_signature='$htmlen', comment_smilies='$iconen', comment_bcode='$codeen', comment_plonk='$extrag13' WHERE comment_id='$zid'");

        $result = DBQuery("SELECT * FROM esselbach_st_comments WHERE comment_id='$zid'");
        $crows = mysql_num_rows($result);
        $data = mysql_fetch_array($result);
        $pages = substr($crows/25, 0, 1);

        if ($data[comment_category] == 1)
        {
            if ($pages > 1)
            {
                $pages++;
                for($a = 1; $a < $pages; $a++)
                {
                    RemoveCache ("story/story-$data[comment_story]-$a");
                }
            }
            else
            {
                RemoveCache ("story/story-$data[comment_story]-1");
            }

        }

        if ($data[comment_category] == 2)
        {
            if ($pages > 1)
            {
                $pages++;
                for($a = 1; $a < $pages; $a++)
                {
                    RemoveCache ("polls/poll-$data[comment_story]-$a");
                }
            }
            else
            {
                RemoveCache ("polls/poll-$data[comment_story]-1");
            }

        }

        if ($data[comment_category] == 3)
        {
            if ($pages > 1)
            {
                $pages++;
                for($a = 1; $a < $pages; $a++)
                {
                    RemoveCache ("downloaddet/download-$data[comment_story]-$a");
                }
            }
            else
            {
                RemoveCache ("downloaddet/download-$data[comment_story]-1");
            }

        }

        MkHeader("_self");
        MkTabHeader ("$words[DO]");
        echo $words[TU2];
        MkTabFooter();
        MkFooter();

    }

    //  ##########################################################

    function AdminSearchComment()
    {

        global $words;

        MkHeader("_self");
        MkTabHeader("$words[NEWCM]");
        echo "<form action=\"index.php\" method=\"post\"><font size=\"2\" face=\"Verdana, Arial\">$words[FOS]</font><br />";
        echo "<input type=\"hidden\" name=\"aform\" value=\"searchreplacecomment\"><textarea cols=\"100%\" name=\"zid\" rows=\"2\"></textarea><br />";
        echo "$words[AREP]</font><textarea cols=\"100%\" name=\"extra1\" rows=\"2\"></textarea><br /><input type=\"submit\" value=\"$words[SUB]\"></form>";
        MkTabFooter();
        MkFooter();
    }

   //  ##########################################################

    function CommentSearchReplace ()
    {

        global $words, $zid, $extra1, $ipaddr;

        MkHeader("_self");
        MkTabHeader ("$words[DO]");

        $query = DBQuery("SELECT * FROM esselbach_st_comments WHERE (comment_text LIKE '%$zid%')");

        $totalrows = 0;
        while ($rows = mysql_fetch_array($query))
        {
            $out_field = str_replace("$zid", "$extra1", $rows[comment_text]);
            DBQuery("UPDATE esselbach_st_comments SET comment_text = '$out_field', comment_editip = '$ipaddr' WHERE comment_id = '$rows[comment_id]'");
            $totalrows++;
        }

        echo $totalrows." ".$words[ENTCH];

        ClearCache("news");
        ClearCache("categories");
        ClearCache("archive");
        ClearCache("story");
        ClearCache("xml");
        ClearCache("faq");
        ClearCache("polls");
        ClearCache("tags");
        ClearCache("download");
        ClearCache("downloaddet");

        MkTabFooter();
        MkFooter();

    }

?>
