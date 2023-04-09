<?php

    /*
    ########################
    # |//////////////////| #
    # NULLED by [GTT] =)   #
    # |\\\\\\\\\\\\\\\\\\| #
    ########################
    */

    require("core.php");

    if (phpversion() >= "4.1.0")
    {
        $lcookie = $_COOKIE["esselbachst"];
        $icon = $_POST["icon"];
        $message = $_POST["message"];
        $category = $_POST["category"];
        $story = $_POST["story"];
        $signature = $_POST["signature"];
        $smilies = $_POST["smilies"];
        $bcode = $_POST["bcode"];
        $cid = $_POST["cid"];
        $action = $_GET["action"];
        $id = $_GET["id"];

    }
    else
    {
        $lcookie = $esselbachst;
    }

    $icon = checknum($icon);
    $category = checknum($category);
    $story = checknum($story);
    $message = checkvar($message);
    $smilies = checknum($smilies);
    $bcode = checknum($bcode);
    $action = checkvar($action);

    $ipaddr = GetIP();
    $tdate = date ("l dS of F Y h:i:s A", time());
    $website = $configs[4];

    HeaderBlock();

    if ((!$action) or (!$message))
    {
        $cache = GetCache("news", "comments");

        if (!$cache)
        {
            dbconnect();

            $list = GetTemplate("comments_header");

            $result = DBQuery("SELECT * FROM esselbach_st_comments WHERE comment_website = '$website' AND comment_plonk = '0' OR comment_website = '0' AND comment_plonk = '0' ORDER BY comment_id DESC LIMIT 100");

            $commlist = mysql_num_rows($result);

            if ($commlist > 0)
            {
                while ($insert = mysql_fetch_array($result))
                {
                              if ($insert[comment_category] == 1)
                                {
                                       $query = DBQuery("SELECT story_title FROM esselbach_st_stories WHERE story_id = '$insert[comment_story]'");
                                       list($story) = mysql_fetch_row($query);
                                       $insert[comment_url] = "story.php?id=$insert[comment_story]";
                                       $insert[comment_title] = $story;
                              }
                              if ($comment_array[comment_category] == 2)
                              {
                                       $query = DBQuery("SELECT poll_title FROM esselbach_st_polls WHERE poll_id = '$insert[comment_story]'");
                                       list($poll) = mysql_fetch_row($query);
                                       $insert[comment_url] = "poll.php?id=$insert[comment_story]";
                                       $insert[comment_title] = $poll;
                              }
                              if ($comment_array[comment_category] == 3)
                              {
                                       $query = DBQuery("SELECT download_title FROM esselbach_st_downloads WHERE download_id = '$insert[comment_story]'");
                                       list($download) = mysql_fetch_row($query);
                                       $insert[comment_url] = "download.php?det=$insert[comment_story]";
                                       $insert[comment_title] = $download;
                              }
                    $list .= GetTemplate("comments_list");
                }
            }
            else
            {
                $list .= GetTemplate("comments_list_na");
            }
            $list .= GetTemplate("comments_footer");

            WriteCache("news", "comments", $list, 0);
        }

        FooterBlock();
    }

    if ($lcookie)
    {
        $ldata = base64_decode($lcookie);
        $ldata = explode (":!:", $ldata);

        if (!file_exists("bbwrapper.php"))
        {
            dbconnect();

            $query = DBQuery("SELECT * FROM esselbach_st_users WHERE user_name = '$ldata[0]' AND user_banned = '0'");
            $userd = mysql_fetch_array($query);
        }
    }

    if (!file_exists("bbwrapper.php"))
    {
        if (($ldata[1] != $userd[user_password]) or (!$lcookie))
        {
            echo GetTemplate("comments_error_notlogged");
            FooterBlock();
            exit;
        }
    }
    else
    {
        if ((!BBGetUser($ldata[0], $ldata[1])) or (!$lcookie))
        {
            echo GetTemplate("comments_error_notlogged");
            FooterBlock();
            exit;
        }
        dbconnect();
    }

    $ipaddy = explode(".", $ipaddr);
    $ipaddx = $ipaddy[0].".".$ipaddy[1].".".$ipaddy[2];
    $result = DBQuery("SELECT * FROM esselbach_st_banips WHERE (banip_ip LIKE '%$ipaddx%')");
    if (mysql_num_rows($result))
    {
        echo GetTemplate("comments_error_bannedip");
        FooterBlock();
    }

    if (($action == "quote") and ($id))
    {
        $query = DBQuery("SELECT * FROM esselbach_st_comments WHERE comment_id='$id'");
        $insert = mysql_fetch_array($query);

        $insert[comments_category] = $insert[comment_category];
        $insert[comments_story] = $insert[comment_story];
        $insert[comments_quote] = GetTemplate("comments_quote");
        echo GetTemplate("comments_post_form");
        FooterBlock();
    }

    if (($action == "delete") and ($id))
    {
        $query = DBQuery("SELECT * FROM esselbach_st_users WHERE user_name = '$ldata[0]' AND user_admin = '1'");
        $admind = mysql_fetch_array($query);

        if ($admind[user_cancomment])
        {
            $query = DBQuery("SELECT * FROM esselbach_st_comments WHERE comment_id='$id'");
            $insert = mysql_fetch_array($query);

            if ($insert[comment_category] == 1)
            {
                DBQuery("UPDATE esselbach_st_stories SET story_comments=story_comments-1 WHERE story_id = '$insert[comment_story]'");
            }
            if ($insert[comment_category] == 2)
            {
                DBQuery("UPDATE esselbach_st_polls SET poll_comments=poll_comments-1 WHERE poll_id = '$insert[comment_story]'");
            }
            if ($insert[comment_category] == 3)
            {
                DBQuery("UPDATE esselbach_st_downloads SET download_comments=download_comments-1 WHERE download_id = '$insert[comment_story]'");
            }

            DBQuery("DELETE FROM esselbach_st_comments WHERE comment_id='$id' AND comment_website='$website'");

            $result = DBQuery("SELECT story_comments FROM esselbach_st_stories WHERE story_id = '$insert[comment_story]'");
            list($comments) = mysql_fetch_row($result);
            $pages = $comments/25;
            $pages++;
            if ($insert[comment_category] == 1)
            {
                for($p = 0; $p < $pages; $p++)
                {
                    $tp = $p + 1;
                    RemoveCache ("story/story-$insert[comment_story]-$tp");
                }
                RemoveCache ("news/mainnews");
            }
            if ($insert[comment_category] == 2)
            {
                for($p = 0; $p < $pages; $p++)
                {
                    $tp = $p + 1;
                    RemoveCache ("polls/poll-$insert[comment_story]-$tp");
                }
                RemoveCache ("news/mainnews");
            }
            if ($insert[comment_category] == 3)
            {
                for($p = 0; $p < $pages; $p++)
                {
                    $tp = $p + 1;
                    RemoveCache ("downloaddet/download-$insert[comment_story]-$tp");
                }
            }
            RemoveCache ("news/comments");
            echo GetTemplate("comments_delete_done");
        }
        else
        {
            echo GetTemplate("comments_error_adminonly");
        }
    }

    if (($action == "edit") and ($id))
    {
        $query = DBQuery("SELECT * FROM esselbach_st_comments WHERE comment_id='$id'");
        $insert = mysql_fetch_array($query);

        if (mysql_num_rows($query))
        {
            if (!file_exists("bbwrapper.php"))
            {
                if (($insert[comment_author] == $userd[user_name]) or ($userd[user_cancomment]))
                {
                    PrepareForm();
                }
                else
                {
                    echo GetTemplate("comments_error_notallowed");
                }
            }
            else
            {
                if (BBGetUser($insert[comment_author], $ldata[1]))
                {
                    PrepareForm();
                }
                else
                {
                    echo GetTemplate("comments_error_notallowed");
                }
            }
        }
    }

    if (($cid) and ($message))
    {
        $query = DBQuery("SELECT * FROM esselbach_st_comments WHERE comment_id='$cid'");
        $insert = mysql_fetch_array($query);

        if (mysql_num_rows($query))
        {
            if (!file_exists("bbwrapper.php"))
            {
                if (($insert[comment_author] == $userd[user_name]) or ($userd[user_cancomment]))
                {
                    DoTheEdit();
                }
                else
                {
                    echo GetTemplate("comments_error_notallowed");
                }
            }
            else
            {
                if (BBGetUser($insert[comment_author], $ldata[1]))
                {
                    dbconnect();
                    DoTheEdit();
                }
                else
                {
                    echo GetTemplate("comments_error_notallowed");
                }
            }
        }
    }

    if (($message) and ($story) and ($category))
    {
        ($signature) ? $signature = 1 :
         $signature = 0;
        ($smilies) ? $smilies = 1 :
         $smilies = 0;
        ($bcode) ? $bcode = 1 :
         $bcode = 0;

        $query = DBQuery("SELECT website_flood FROM esselbach_st_websites WHERE website_id = '$website'");
        list($flood) = mysql_fetch_row($query);

        $query = DBQuery("SELECT comment_time FROM esselbach_st_comments WHERE comment_author = '$ldata[0]' ORDER BY comment_time DESC");
        list($lasttime) = mysql_fetch_row($query);

        $datetime = explode (" ", $lasttime);
        $tdate = explode("-", $datetime[0]);
        $ttime = explode(":", $datetime[1]);
        $oldstamp = mktime($ttime[0], $ttime[1], $ttime[2], $tdate[1], $tdate[2], $tdate[0]);
        $newstamp = mktime();

        $floodtime = $oldstamp + $flood;

        if ($newstamp < $floodtime)
        {
            echo GetTemplate("comments_error_flood");
        }
        else
        {

            if ($category == 1)
            {
                $query = DBQuery("SELECT * FROM esselbach_st_stories WHERE story_id = '$story' AND story_website = '$website' OR story_id = '$story' AND story_website = '0'");
                if (mysql_num_rows($query))
                {
                    DBQuery("INSERT INTO esselbach_st_comments VALUES (NULL, '$website', '$category', '$ldata[0]', '$story', '$icon', '$message', '0', '$signature', '$smilies', '$bcode', now(), '$ipaddr', '$ipaddr')");
                    DBQuery("UPDATE esselbach_st_stories SET story_comments=story_comments+1 WHERE story_id = '$story'");
                    if (!file_exists("bbwrapper.php"))
                    {
                        DBQuery("UPDATE esselbach_st_users SET user_posts=user_posts+1 WHERE user_name = '$ldata[0]' AND user_password = '$ldata[1]'");
                    }
                    else
                    {
                        BBUserCount($ldata[0]);
                    }
                    $insert[comments_return] = "story.php?id=$story";
                    $result = DBQuery("SELECT story_comments FROM esselbach_st_stories WHERE story_id = '$story'");
                    list($comments) = mysql_fetch_row($result);
                    $pages = $comments/25;
                    $pages++;
                    for($p = 1; $p < $pages; $p++)
                    {
                        RemoveCache ("story/story-$story-$p");
                    }
                    RemoveCache ("news/mainnews");
                    RemoveCache ("news/comments");
                    echo GetTemplate("comments_post_done");
                }
            }
            if ($category == 2)
            {
                $query = DBQuery("SELECT * FROM esselbach_st_polls WHERE poll_id = '$story' AND poll_website = '$website' OR poll_id = '$story' AND poll_website = '0'");
                if (mysql_num_rows($query))
                {
                    DBQuery("INSERT INTO esselbach_st_comments VALUES (NULL, '$website', '$category', '$ldata[0]', '$story', '$icon', '$message', '0', '$signature', '$smilies', '$bcode', now(), '$ipaddr', '$ipaddr')");
                    DBQuery("UPDATE esselbach_st_polls SET poll_comments=poll_comments+1 WHERE poll_id = '$story'");
                    if (!file_exists("bbwrapper.php"))
                    {
                        DBQuery("UPDATE esselbach_st_users SET user_posts=user_posts+1 WHERE user_name = '$ldata[0]' AND user_password = '$ldata[1]'");
                    }
                    else
                    {
                        BBUserCount($ldata[0]);
                    }
                    $insert[comments_return] = "poll.php?id=$story";
                    $result = DBQuery("SELECT poll_comments FROM esselbach_st_polls WHERE poll_id = '$story'");
                    list($comments) = mysql_fetch_row($result);
                    $pages = $comments/25;
                    $pages++;
                    for($p = 1; $p < $pages; $p++)
                    {
                        RemoveCache ("polls/poll-$story-$p");
                    }
                    RemoveCache ("polls/polls");
                    RemoveCache ("news/mainnews");
                    RemoveCache ("news/comments");
                    echo GetTemplate("comments_post_done");
                }
            }
            if ($category == 3)
            {
                $query = DBQuery("SELECT * FROM esselbach_st_downloads WHERE download_id = '$story' AND download_website = '$website' OR download_id = '$story' AND download_website = '0'");
                if (mysql_num_rows($query))
                {
                    DBQuery("INSERT INTO esselbach_st_comments VALUES (NULL, '$website', '$category', '$ldata[0]', '$story', '$icon', '$message', '0', '$signature', '$smilies', '$bcode', now(), '$ipaddr', '$ipaddr')");
                    DBQuery("UPDATE esselbach_st_downloads SET download_comments=download_comments+1 WHERE download_id = '$story'");
                    if (!file_exists("bbwrapper.php"))
                    {
                        DBQuery("UPDATE esselbach_st_users SET user_posts=user_posts+1 WHERE user_name = '$ldata[0]' AND user_password = '$ldata[1]'");
                    }
                    else
                    {
                        BBUserCount($ldata[0]);
                    }
                    $insert[comments_return] = "download.php?det=$story";
                    $result = DBQuery("SELECT download_comments, download_category FROM esselbach_st_downloads WHERE download_id = '$story'");
                    list($comments, $catid) = mysql_fetch_row($result);
                    $pages = $comments/25;
                    $pages++;
                    for($p = 1; $p < $pages; $p++)
                    {
                        RemoveCache ("downloaddet/download-$story-$p");
                    }
                    for($a = 1; $a < 27; $a++)
                    {
                        RemoveCache ("download/download-$catid-$a");
                    }

                    RemoveCache ("download/download");
                    RemoveCache ("news/mainnews");
                    RemoveCache ("news/comments");
                    echo GetTemplate("comments_post_done");
                }
            }
        }
    }

    FooterBlock();

    function PrepareForm ()
    {

        global $insert, $userd, $website;

        $query = DBQuery("SELECT website_editmsg, website_editexp FROM esselbach_st_websites WHERE website_id = '$website'");
        list($editexp) = mysql_fetch_row($query);

        $datetime = explode (" ", $insert[comment_time]);
        $tdate = explode("-", $datetime[0]);
        $ttime = explode(":", $datetime[1]);
        $oldstamp = mktime($ttime[0], $ttime[1], $ttime[2], $tdate[1], $tdate[2], $tdate[0]);
        $newstamp = mktime();

        $edittime = $oldstamp + $editexp;

        if ($newstamp > $edittime)
        {
            echo GetTemplate("comments_error_editxpr");
        }
        else
        {

            for($i = 1; $i < 19; $i++)
            {
                ($insert[comment_icon] == $i) ? $insert['comment_icon'.$i] = "checked" :
                 $insert['comment_icon'.$i] = "";
            }
            $insert[comment_sige] = "";
            $insert[comment_sme] = "checked";
            $insert[comment_bce] = "checked";

            $insert[comment_edittext] = $insert[comment_text];
            if ($insert[comment_signature])
            {
                if (!file_exists("bbwrapper.php"))
                {
                    $thissig = $userd[user_signature];
                }
                else
                {
                    $thissig = BBGrabSig($insert[comment_author]);
                }
                if ($thissig) $insert[comment_text] .= GetTemplate("comments_sigline").$thissig;
                $insert[comment_sige] = "checked";
            }
            $insert[comment_text] = ScriptEx(htmlentities($insert[comment_text]));
            $insert[comment_text] = DeChomp($insert[comment_text]);

            if (!$insert[comment_smilies])
            {
                $insert[comment_text] = Icons($insert[comment_text]);
                $insert[comment_sme] = "";
            }

            if (!$insert[comment_bcode])
            {
                $insert[comment_text] = Code($insert[comment_text]);
                $insert[comment_bce] = "";
            }

            $comment_icons = array('note', 'alert', 'question', 'star', 'idea', 'disk', 'smile', 'wink', 'sad', 'mad', 'happy', 'tongue', 'sleep', 'cool', 'ssad', 'frown', 'up', 'down');
            for($i = 0; $i < count($comment_icons); $i++)
            {
                $iconnum = $i + 1;
                if ($insert[comment_icon] == $iconnum) $insert[comment_iconimage] = "icon_".$comment_icons[$i].".png";
            }

            echo GetTemplate("comments_edit");
        }

    }

    function DoTheEdit ()
    {

        global $message, $icon, $signature, $smilies, $bcode, $cid, $insert, $ldata, $website;

        $query = DBQuery("SELECT website_editmsg, website_editexp FROM esselbach_st_websites WHERE website_id = '$website'");
        list($editmsg, $editexp) = mysql_fetch_row($query);

        $datetime = explode (" ", $insert[comment_time]);
        $tdate = explode("-", $datetime[0]);
        $ttime = explode(":", $datetime[1]);
        $oldstamp = mktime($ttime[0], $ttime[1], $ttime[2], $tdate[1], $tdate[2], $tdate[0]);
        $newstamp = mktime();

        $editmstime = $oldstamp + $editmsg;

        if ($newstamp > $editmstime)
        {
            $thisdate = date("Y-m-d H:i:s", mktime());
            $insert[edit_user] = $ldata[0];
            $insert[edit_date] = $thisdate;
            $message .= GetTemplate("comments_edit_by");
        }

        $edittime = $oldstamp + $editexp;

        if ($newstamp > $edittime)
        {
            echo GetTemplate("comments_error_editxpr");
        }
        else
        {
            DBQuery("UPDATE esselbach_st_comments SET comment_text = '$message', comment_icon = '$icon', comment_signature = '$signature', comment_smilies = '$smilies', comment_bcode = '$bcode' WHERE comment_id = '$cid'");
            if ($insert[comment_category] == 1)
            {
                $result = DBQuery("SELECT story_comments FROM esselbach_st_stories WHERE story_id = '$insert[comment_story]'");
            }
            if ($insert[comment_category] == 2)
            {
                $result = DBQuery("SELECT poll_comments FROM esselbach_st_polls WHERE poll_id = '$insert[comment_story]'");
            }
            if ($insert[comment_category] == 3)
            {
                $result = DBQuery("SELECT download_comments FROM esselbach_st_downloads WHERE download_id = '$insert[comment_story]'");
            }
            list($comments) = mysql_fetch_row($result);
            $pages = $comments/25;
            $pages++;
            if ($insert[comment_category] == 1)
            {
                for($p = 0; $p < $pages; $p++)
                {
                    $tp = $p + 1;
                    RemoveCache ("story/story-$insert[comment_story]-$tp");
                }
            }
            if ($insert[comment_category] == 2)
            {
                for($p = 0; $p < $pages; $p++)
                {
                    $tp = $p + 1;
                    RemoveCache ("polls/poll-$insert[comment_story]-$tp");
                }
            }
            if ($insert[comment_category] == 3)
            {
                for($p = 0; $p < $pages; $p++)
                {
                    $tp = $p + 1;
                    RemoveCache ("downloaddet/download-$insert[comment_story]-$tp");
                }
            }
            if ($insert[comment_category] == 1)
            {
                $insert[comments_return] = "story.php?id=$insert[comment_story]";
            }
            if ($insert[comment_category] == 2)
            {
                $insert[comments_return] = "poll.php?id=$insert[comment_story]";
            }
            if ($insert[comment_category] == 3)
            {
                $insert[comments_return] = "download.php?det=$insert[comment_story]";
            }

            echo GetTemplate("comments_edit_done");
        }

    }

?>
