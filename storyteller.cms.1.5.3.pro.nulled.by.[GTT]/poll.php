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
        $vote = $_POST["vote"];
        $poll = $_POST["poll"];
        $id = $_GET["id"];
        $page = $_GET["page"];

    }
    else
    {
        $lcookie = $esselbachst;
    }

    $vote = checknum($vote);
    $poll = checknum($poll);
    $id = checknum($id);
    $page = checknum($page);

    $ipaddr = GetIP();
    $tdate = date ("l dS of F Y h:i:s A", time());
    $website = $configs[4];

    HeaderBlock();

    if (!$poll)
    {
        if (!$id)
        {
            $cache = GetCache("polls", "polls");
            if (!$cache)
            {
                dbconnect();
                $polllist = GetTemplate("poll_list_header");
                $result = DBQuery("SELECT * FROM esselbach_st_polls WHERE poll_website = '$website' OR poll_website = '0'");
                if (mysql_num_rows($result))
                {
                    while ($insert = mysql_fetch_array($result)) $polllist .= GetTemplate("poll_list");
                }
                else
                {
                    $polllist .= GetTemplate("poll_list_na");
                }
                $polllist .= GetTemplate("poll_list_footer");
                WriteCache("polls", "polls", $polllist, 0);
            }
            FooterBlock();
        }
        else
        {
            if (!$page) $page = 1;
            $cache = GetCache("polls", "poll-$id-$page");
            if (!$cache)
            {
                dbconnect();
                $query = DBQuery("SELECT * FROM esselbach_st_polls WHERE poll_website = '$website' AND poll_id = '$id' OR poll_website = '0' AND poll_id = '$id'");
                if (mysql_num_rows($query))
                {
                    $insert = mysql_fetch_array($query);
                    $docomment = $insert[poll_comm];
                    if (!$insert[poll_html])
                    {
                        $insert[poll_text] = DeChomp($insert[poll_text]);
                    }
                    if ($insert[poll_icon])
                    {
                        $insert[poll_text] = Icons($insert[poll_text]);
                    }
                    if ($insert[poll_code])
                    {
                        $insert[poll_text] = Code($insert[poll_text]);
                    }
                    $poll = GetTemplate("poll_header");
                    for($y = 1; $y < 13; $y++)
                    {
                        if ($insert['poll_option'.$y])
                        {
                            $insert[poll_option] = $y;
                            $insert[poll_optiontext] = $insert['poll_option'.$y];
                            $insert[poll_optionvotes] = $insert['poll_vote'.$y];
                            $insert[poll_percent] = 100 * $insert['poll_vote'.$y] / $insert[poll_votes];
                            $insert[poll_votebar] = $insert[poll_percent] * 2;
                            if (!$insert[poll_percent])
                            {
                                $insert[poll_percent] = 0;
                            }
                            if (preg_match("/./i", $insert[poll_percent]))
                            {
                                $pollsplit = explode(".", $insert[poll_percent]);
                                $insert[poll_percent] = $pollsplit[0];
                            }
                            $poll .= GetTemplate("poll_option");
                        }
                    }
                    $poll .= GetTemplate("poll_footer");

                    if ($docomment)
                    {
                        $result = DBQuery("SELECT * FROM esselbach_st_banwords");
                        while ($banword = mysql_fetch_array($result)) $banwords[] = $banword[banword_word];

                        $result = DBQuery("SELECT * FROM esselbach_st_comments WHERE comment_story = '$id' AND comment_category = '2' AND comment_website = '$website'");
                        $entries = mysql_num_rows($result);

                        $cstart = $page * 25-25;
                        $result = DBQuery("SELECT * FROM esselbach_st_comments WHERE comment_story = '$id' AND comment_category = '2' AND comment_website = '$website' ORDER BY comment_id LIMIT $cstart,25");
                        while ($insert = mysql_fetch_array($result))
                        {
                            $cstart++;
                            $insert[comment_result] = $cstart;
                            $comment_icons = array('note', 'alert', 'question', 'star', 'idea', 'disk', 'smile', 'wink', 'sad', 'mad', 'happy', 'tongue', 'sleep', 'cool', 'ssad', 'frown', 'up', 'down');
                            for($i = 0; $i < count($comment_icons); $i++)
                            {
                                $iconnum = $i + 1;
                                if ($insert[comment_icon] == $iconnum)
                                {
                                    $insert[comment_iconimage] = "icon_".$comment_icons[$i].".png";
                                }
                            }
                            if ($insert[comment_signature])
                            {
                                if (!file_exists("bbwrapper.php"))
                                {
                                    $query = DBQuery("SELECT user_signature FROM esselbach_st_users WHERE user_name = '$insert[comment_author]'");
                                    list($thissig) = mysql_fetch_row($query);
                                }
                                else
                                {
                                    $thissig = BBGrabSig($insert[comment_author]);
                                    dbconnect();
                                }
                                if ($thissig) $insert[comment_text] .= GetTemplate("comments_sigline").$thissig;
                            }
                            $insert[comment_text] = ScriptEx(htmlentities($insert[comment_text]));
                            $insert[comment_text] = DeChomp($insert[comment_text]);

                            $query = DBQuery("SELECT website_censor FROM esselbach_st_websites WHERE website_id = '$website'");
                            list($banstring) = mysql_fetch_row($query);

                            for($b = 0; $b < count($banwords); $b++)
                            {
                                $bani = str_repeat("$banstring", strlen($banwords[$b]));
                                $insert[comment_text] = preg_replace("/$banwords[$b]/", "$bani", $insert[comment_text]);
                            }
                            if (!$insert[comment_smilies])
                            {
                                $insert[comment_text] = Icons($insert[comment_text]);
                            }
                            if (!$insert[comment_bcode])
                            {
                                $insert[comment_text] = Code($insert[comment_text]);
                            }
                            if ($insert[comment_plonk])
                            {
                            $insert[comment_text] = GetTemplate("comments_plonk");
                            }
                            $poll .= GetTemplate("comments");
                        }

                        if ($cstart > 25)
                        {
                            $apage = $page;
                            $apage = $apage - 1;
                            $insert[comment_url] = "poll.php?id=$id&page=$apage";
                            $insert[comment_prevpage] .= GetTemplate("comments_previous_page");
                        }

                        if ($cstart < $entries)
                        {
                            $bpage = $page;
                            $bpage++;
                            $insert[comment_url] = "poll.php?id=$id&page=$bpage";
                            $insert[comment_nextpage] .= GetTemplate("comments_next_page");
                        }

                        if (($insert[comment_nextpage]) or ($insert[comment_prevpage])) $poll .= GetTemplate("comments_nav");

                    }

                    if ($docomment)
                    {
                        $insert[comments_category] = 2;
                        $insert[comments_story] = $id;
                        $poll .= GetTemplate("comments_post_form");
                    }

                    WriteCache("polls", "poll-$id-$page", $poll, 0);
                }

            }
            FooterBlock();
        }
    }

    if ($lcookie)
    {
        $ldata = base64_decode($lcookie);
        $ldata = explode (":!:", $ldata);

        if (!file_exists("bbwrapper.php"))
        {
            dbconnect();

            $query = DBQuery("SELECT * FROM esselbach_st_users WHERE user_name = '$ldata[0]'");
            $userd = mysql_fetch_array($query);
        }
    }

    if (!file_exists("bbwrapper.php"))
    {
        if (($ldata[1] != $userd[user_password]) or (!$lcookie))
        {
            echo GetTemplate("poll_error_notlogged");
            FooterBlock();
            exit;
        }
    }
    else
    {
        if ((!BBGetUser($ldata[0], $ldata[1])) or (!$lcookie))
        {
            echo GetTemplate("poll_error_notlogged");
            FooterBlock();
            exit;
        }
        dbconnect();
    }

    $result = DBQuery("SELECT * FROM esselbach_st_banips");
    while ($banip = mysql_fetch_array($result))
    {
        if (preg_match("/$banip[banip_ip]/", $ipaddr))
        {
            echo GetTemplate("poll_error_bannedip");
            FooterBlock();
            exit;
        }
    }

    if (($vote) and ($poll))
    {
        $query = DBQuery("SELECT * FROM esselbach_st_pollusers WHERE polluser_poll = '$poll' AND polluser_user = '$ldata[0]'");
        if (!mysql_num_rows($query))
        {
            DBQuery("INSERT INTO esselbach_st_pollusers VALUES (NULL, '$ldata[0]', '$poll', '$ipaddr')");
            if ($vote == 1)
            {
                DBQuery("UPDATE esselbach_st_polls SET poll_vote1=poll_vote1+1, poll_votes=poll_votes+1 WHERE poll_id = '$poll'");
            }
            if ($vote == 2)
            {
                DBQuery("UPDATE esselbach_st_polls SET poll_vote2=poll_vote2+1, poll_votes=poll_votes+1 WHERE poll_id = '$poll'");
            }
            if ($vote == 3)
            {
                DBQuery("UPDATE esselbach_st_polls SET poll_vote3=poll_vote3+1, poll_votes=poll_votes+1 WHERE poll_id = '$poll'");
            }
            if ($vote == 4)
            {
                DBQuery("UPDATE esselbach_st_polls SET poll_vote4=poll_vote4+1, poll_votes=poll_votes+1 WHERE poll_id = '$poll'");
            }
            if ($vote == 5)
            {
                DBQuery("UPDATE esselbach_st_polls SET poll_vote5=poll_vote5+1, poll_votes=poll_votes+1 WHERE poll_id = '$poll'");
            }
            if ($vote == 6)
            {
                DBQuery("UPDATE esselbach_st_polls SET poll_vote6=poll_vote6+1, poll_votes=poll_votes+1 WHERE poll_id = '$poll'");
            }
            if ($vote == 7)
            {
                DBQuery("UPDATE esselbach_st_polls SET poll_vote7=poll_vote7+1, poll_votes=poll_votes+1 WHERE poll_id = '$poll'");
            }
            if ($vote == 8)
            {
                DBQuery("UPDATE esselbach_st_polls SET poll_vote8=poll_vote8+1, poll_votes=poll_votes+1 WHERE poll_id = '$poll'");
            }
            if ($vote == 9)
            {
                DBQuery("UPDATE esselbach_st_polls SET poll_vote9=poll_vote9+1, poll_votes=poll_votes+1 WHERE poll_id = '$poll'");
            }
            if ($vote == 10)
            {
                DBQuery("UPDATE esselbach_st_polls SET poll_vote10=poll_vote10+1, poll_votes=poll_votes+1 WHERE poll_id = '$poll'");
            }
            if ($vote == 11)
            {
                DBQuery("UPDATE esselbach_st_polls SET poll_vote11=poll_vote11+1, poll_votes=poll_votes+1 WHERE poll_id = '$poll'");
            }
            if ($vote == 12)
            {
                DBQuery("UPDATE esselbach_st_polls SET poll_vote12=poll_vote12+1, poll_votes=poll_votes+1 WHERE poll_id = '$poll'");
            }

            RemoveCache("news/mainnews");
            RemoveCache("polls/polls");

            $result = DBQuery("SELECT poll_comments FROM esselbach_st_polls WHERE poll_id = '$poll'");
            list($comments) = mysql_fetch_row($result);
            $pages = $comments/25;
            $pages++;
            for($p = 1; $p < $pages; $p++)
            {
                RemoveCache ("polls/poll-$poll-$p");
            }

            echo GetTemplate("poll_done");
        }
        else
        {
            echo GetTemplate("poll_error_alreadyvoted");
        }
    }

    FooterBlock();

?>
