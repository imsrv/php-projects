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
        $id = $_GET["id"];
        $page = $_GET["page"];
    }

    $id = checknum ($id);
    $page = checknum ($page);
    $website = $configs[4];

    if (!$page)
    {
        $page = 1;
    }

    HeaderBlock();

    $cache = GetCache("story", "story-$id-$page");

    if (!$cache)
    {
        dbconnect();

        $result = DBQuery("SELECT * FROM esselbach_st_stories WHERE story_id = '$id' AND story_website = '$website' AND story_hook = '0' OR story_id = '$id' AND story_website = '0' AND story_hook = '0'");

        if (!mysql_num_rows($result))
        {
            echo GetTemplate("story_error_na");
        }
        else
        {
            $insert = mysql_fetch_array($result);
            if (!$insert[story_html])
            {
                $insert[story_text] = DeChomp($insert[story_text]);
            }
            if ($insert[story_icon])
            {
                $insert[story_text] = Icons($insert[story_text]);
            }
            if ($insert[story_code])
            {
                $insert[story_text] = Code($insert[story_text]);
            }

            $insert[story_text] = eregi_replace("\\[thumb\\]([^\\[]*)\\[/thumb\\]", "<a href=\"javascript:FullWin('thumb.php?img=\\1&action=full&section=news')\"><img src=\"thumb.php?img=\\1&section=news\" border=\"0\"></a>", $insert[story_text]);

            if (!$insert[story_html])
            {
                $insert[story_extendedtext] = DeChomp($insert[story_extendedtext]);
            }
            if ($insert[story_icon])
            {
                $insert[story_extendedtext] = Icons($insert[story_extendedtext]);
            }
            if ($insert[story_code])
            {
                $insert[story_extendedtext] = Code($insert[story_extendedtext]);
            }

            $insert[story_extendedtext] = eregi_replace("\\[thumb\\]([^\\[]*)\\[/thumb\\]", "<a href=\"javascript:FullWin('thumb.php?img=\\1&action=full&section=news')\"><img src=\"thumb.php?img=\\1&section=news\" border=\"0\"></a>", $insert[story_extendedtext]);

            $query = DBQuery("SELECT category_name FROM esselbach_st_categories WHERE category_id = '$insert[story_category]'");
            list($insert[story_category]) = mysql_fetch_row($query);

            $docomment = $insert[story_comm];
            $thispage .= GetTemplate("story");

            $searchstory = addslashes(substr($insert[story_title], 0, 8));
            $result = DBQuery("SELECT * FROM esselbach_st_stories WHERE (story_title LIKE '%$searchstory%') AND story_category = '$insert[story_category]' AND story_website = '$website' AND story_hook = '0' OR (story_title LIKE '%$searchstory%') AND story_category = '$insert[story_category]' AND story_website = '0' AND story_hook = '0' ORDER BY story_id DESC LIMIT 8");

            if (mysql_num_rows($result) > 1)
            {
                $thispage .= GetTemplate("story_related_header");
                while ($insert = mysql_fetch_array($result))
                {
                    if ($insert[story_id] != $id)
                    {
                        $thispage .= GetTemplate("story_related");
                    }
                }
                $thispage .= GetTemplate("story_related_footer");
            }

            if ($docomment)
            {
                $result = DBQuery("SELECT * FROM esselbach_st_banwords");
                while ($banword = mysql_fetch_array($result)) $banwords[] = $banword[banword_word];

                $result = DBQuery("SELECT * FROM esselbach_st_comments WHERE comment_story = '$id' AND comment_category = '1' AND comment_website = '$website'");
                $entries = mysql_num_rows($result);

                $cstart = $page * 25-25;
                $result = DBQuery("SELECT * FROM esselbach_st_comments WHERE comment_story = '$id' AND comment_category = '1' AND comment_website = '$website' ORDER BY comment_id LIMIT $cstart,25");
                while ($insert = mysql_fetch_array($result))
                {
                    $cstart++;
                    $insert[comment_result] = $cstart;
                    $comment_icons = array('note', 'alert', 'question', 'star', 'idea', 'disk', 'smile', 'wink', 'sad', 'mad', 'happy', 'tongue', 'sleep', 'cool', 'ssad', 'frown', 'up', 'down');
                    for($i = 0; $i < count($comment_icons); $i++)
                    {
                        $iconnum = $i + 1;
                        if ($insert[comment_icon] == $iconnum) $insert[comment_iconimage] = "icon_".$comment_icons[$i].".png";
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
                        if ($thissig)
                        {
                            $insert[comment_text] .= GetTemplate("comments_sigline").$thissig;
                        }
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
                    $thispage .= GetTemplate("comments");
                }

                if ($cstart > 25)
                {
                    $apage = $page;
                    $apage = $apage - 1;
                    $insert[comment_url] = "story.php?id=$id&page=$apage";
                    $insert[comment_prevpage] .= GetTemplate("comments_previous_page");
                }

                if ($cstart < $entries)
                {
                    $bpage = $page;
                    $bpage++;
                    $insert[comment_url] = "story.php?id=$id&page=$bpage";
                    $insert[comment_nextpage] .= GetTemplate("comments_next_page");
                }

                if (($insert[comment_nextpage]) or ($insert[comment_prevpage]))
                {
                    $thispage .= GetTemplate("comments_nav");
                }

            }

            if ($docomment)
            {
                $insert[comments_category] = 1;
                $insert[comments_story] = $id;
                $thispage .= GetTemplate("comments_post_form");
            }
            else
            {
                $thispage .= GetTemplate("comments_error_disabled");
            }

            WriteCache("story", "story-$id-$page", $thispage, 0);

        }

    }

    FooterBlock();

?>
