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
        $id = $_GET["id"];
        $det = $_GET["det"];
        $sort = $_GET["sort"];
        $page = $_GET["page"];
        $vote = $_POST["vote"];
        $vfile = $_POST["vfile"];
    }
    else
    {
        $lcookie = $esselbachst;
    }

    $id = checknum($id);
    $det = checknum($det);
    $sort = checknum($sort);
    $vote = checknum($vote);
    $vfile = checknum($vfile);
    $page = checknum($page);
    $website = $configs[4];
    $downloadkey = $configs[7];

    HeaderBlock();

    if ($vote)
    {
        if (($vote > 5) or ($vote < 1)) exit;

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
                echo GetTemplate("download_error_notlogged");
                FooterBlock();
                exit;
            }
        }
        else
        {
            if ((!BBGetUser($ldata[0], $ldata[1])) or (!$lcookie))
            {
                echo GetTemplate("download_error_notlogged");
                FooterBlock();
                exit;
            }
            dbconnect();
        }

        $query = DBQuery("SELECT * FROM esselbach_st_filevotes WHERE vote_file = '$vfile' AND vote_user = '$ldata[0]'");

        if (mysql_num_rows($query))
        {
            echo GetTemplate("download_error_alreadyvoted");
            FooterBlock();
            exit;
        }

        $query = DBQuery("SELECT * FROM esselbach_st_downloads WHERE download_id = '$vfile' AND download_hook = '0'");
        if (!mysql_num_rows($query)) exit;

        $ipaddr = GetIP();
        $ipaddy = explode(".", $ipaddr);
        $ipaddx = $ipaddy[0].".".$ipaddy[1].".".$ipaddy[2];
        $result = DBQuery("SELECT * FROM esselbach_st_banips WHERE (banip_ip LIKE '%$ipaddx%')");
        if (mysql_num_rows($result))
        {
            echo GetTemplate("download_error_bannedip");
        }
        else
        {
            DBQuery("INSERT INTO esselbach_st_filevotes VALUES (NULL, '$ldata[0]', '$vote', '$vfile', '$ipaddr', '$ipaddr')");

            $result = DBQuery("SELECT download_comments, download_category FROM esselbach_st_downloads WHERE download_id = '$vfile'");
            list($comments, $cat) = mysql_fetch_row($result);
            $pages = $comments/25;
            $pages++;
            for($p = 0; $p < $pages; $p++)
            {
                $tp = $p + 1;
                RemoveCache ("downloaddet/download-$vfile-$tp");
            }
            for($a = 1; $a < 27; $a++)
            {
                RemoveCache ("download/download-$cat-$a");
            }

            echo GetTemplate("download_vote");
        }
        FooterBlock();
    }

    if ($det)
    {
        if (!$page) $page = 1;
        $cache = GetCache("downloaddet", "download-$det-$page");
        if (!$cache)
        {
            dbconnect();

            $result = DBQuery("SELECT * FROM esselbach_st_filevotes WHERE vote_file = '$det'");
            $votes = mysql_num_rows($result);

            if ($votes)
            {
                while ($votedata = mysql_fetch_array($result))
                {
                    $currentvote = $votedata[vote_rating];
                    $rating = $rating + $currentvote;
                }
                $arating = $rating / $votes;
            }
            else
            {
                $arating = GetTemplate("download_rating_na");
            }

            $result = DBQuery("SELECT * FROM esselbach_st_downloads d, esselbach_st_downloadscat c WHERE d.download_id = '$det' AND c.downloadscat_id = d.download_category AND d.download_website = '$website' AND d.download_hook = '0' OR d.download_id = '$det' AND c.downloadscat_id = d.download_category AND d.download_website = '0' AND d.download_hook = '0'");

            while ($insert = mysql_fetch_array($result))
            {

                $docomment = $insert[download_comm];

                $insert[download_timestamp] = md5($downloadkey."GeT-$det");
                for($a = 1; $a < 9; $a++)
                {
                    if ($insert['download_url'.$a])
                    {
                        $insert['download_url'.$a] = GetTemplate("download_url$a");
                    }
                }

                $insert[download_rating] = substr($arating, 0, 4);
                $insert[download_votes] = $votes;

                if (!$insert[download_html])
                {
                    $insert[download_text] = DeChomp($insert[download_text]);
                }
                if ($insert[download_icon])
                {
                    $insert[download_text] = Icons($insert[download_text]);
                }
                if ($insert[download_code])
                {
                    $insert[download_text] = Code($insert[download_text]);
                }
                $insert[download_text] = eregi_replace("\\[thumb\\]([^\\[]*)\\[/thumb\\]", "<a href=\"javascript:FullWin('thumb.php?img=\\1&action=full&section=downloads')\"><img src=\"thumb.php?img=\\1&section=downloads\" border=\"0\"></a>", $insert[download_text]);

                if (!$insert[download_html])
                {
                    $insert[download_extendedtext] = DeChomp($insert[download_extendedtext]);
                }
                if ($insert[download_icon])
                {
                    $insert[download_extendedtext] = Icons($insert[download_extendedtext]);
                }
                if ($insert[download_code])
                {
                    $insert[download_extendedtext] = Code($insert[download_extendedtext]);
                }
                $insert[download_extendedtext] = eregi_replace("\\[thumb\\]([^\\[]*)\\[/thumb\\]", "<a href=\"javascript:FullWin('thumb.php?img=\\1&action=full&section=downloads')\"><img src=\"thumb.php?img=\\1&section=downloads\" border=\"0\"></a>", $insert[download_extendedtext]);

                $download .= GetTemplate("download_details");
            }

            if ($docomment)
            {
                $result = DBQuery("SELECT * FROM esselbach_st_banwords");
                while ($banword = mysql_fetch_array($result))
                {
                    $banwords[] = $banword[banword_word];
                }

                $result = DBQuery("SELECT * FROM esselbach_st_comments WHERE comment_story = '$det' AND comment_category = '3' AND comment_website = '$website'");
                $entries = mysql_num_rows($result);

                $cstart = $page * 25-25;
                $result = DBQuery("SELECT * FROM esselbach_st_comments WHERE comment_story = '$det' AND comment_category = '3' AND comment_website = '$website' ORDER BY comment_id LIMIT $cstart,25");
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
                    $download .= GetTemplate("comments");
                }

                if ($cstart > 25)
                {
                    $apage = $page;
                    $apage = $apage - 1;
                    $insert[comment_url] = "download.php?det=$det&page=$apage";
                    $insert[comment_prevpage] .= GetTemplate("comments_previous_page");
                }

                if ($cstart < $entries)
                {
                    $bpage = $page;
                    $bpage++;
                    $insert[comment_url] = "download.php?det=$id&page=$bpage";
                    $insert[comment_nextpage] .= GetTemplate("comments_next_page");
                }

                if (($insert[comment_nextpage]) or ($insert[comment_prevpage]))
                {
                    $download .= GetTemplate("comments_nav");
                }

            }

            if ($docomment)
            {
                $insert[comments_category] = 3;
                $insert[comments_story] = $det;
                $download .= GetTemplate("comments_post_form");
            }

            WriteCache("downloaddet", "download-$det-$page", $download, MkTime()+3600);

        }

        FooterBlock();
        exit;
    }

    if (!$id)
    {
        $cache = GetCache("download", "download");
        if (!$cache)
        {
            dbconnect();

            $download = GetTemplate("download_header");

            $result = DBQuery("SELECT * FROM esselbach_st_downloads WHERE download_website = '$website' AND download_hook = '0' OR download_website = '0' AND download_hook = '0'");
            $downloads = mysql_num_rows($result);

            if (!$downloads)
            {
                $download .= GetTemplate("download_list_na");
                $download .= GetTemplate("download_footer");
                WriteCache("download", "download", $download, 0);
                FooterBlock();
            }

            $downloadscat_name_array = array();
            $downloadscat_id_array = array();

            $result = DBQuery("SELECT downloadscat_id, downloadscat_name FROM esselbach_st_downloadscat");

            while (list($downloadscat_id, $downloadscat_name) = mysql_fetch_row($result))
            {
                array_push ($downloadscat_id_array, "$downloadscat_id");
                array_push ($downloadscat_name_array, "$downloadscat_name");
            }

            for($i = 0; $i < count($downloadscat_id_array); $i++)
            {
                $result = DBQuery("SELECT * FROM esselbach_st_downloads WHERE download_category = '$downloadscat_id_array[$i]' AND download_website = '$website' AND download_hook = '0' OR download_category = '$downloadscat_id_array[$i]' AND download_website = '0' AND download_hook = '0'");
                $downloads = mysql_num_rows($result);

                if ($downloads > 0)
                {
                    $insert[download_category_id] = $downloadscat_id_array[$i];
                    $insert[download_category_name] = $downloadscat_name_array[$i];
                    $insert[download_files] = $downloads;
                    $download .= GetTemplate("download_list");
                }
            }

            $download .= GetTemplate("download_footer");

            WriteCache("download", "download", $download, 0);
        }
    }
    else
    {

        $cache = GetCache("download", "download-$id-$sort");

        if (!$cache)
        {
            dbconnect();

            $fields = array('d.download_title', 'd.download_id', 'd.download_category', 'd.download_author', 'd.download_time', 'd.download_extra1', 'd.download_extra2', 'd.download_extra3', 'd.download_extra4', 'd.download_extra5', 'd.download_extra6', 'd.download_extra7', 'd.download_extra8', 'd.download_extra9', 'd.download_extra10', 'd.download_extra11', 'd.download_extra12', 'd.download_extra13', 'd.download_extra14', 'd.download_extra15', 'd.download_extra16', 'd.download_extra17', 'd.download_extra18', 'd.download_extra19', 'd.download_extra20', 'd.download_count');
            ($sort) ? $order = $fields[$sort] :
             $order = $fields[0];

            $result = DBQuery("SELECT * FROM esselbach_st_downloads d, esselbach_st_downloadscat c WHERE d.download_category = '$id' AND c.downloadscat_id = d.download_category AND d.download_website = '$website' AND d.download_hook = '0' OR d.download_category = '$id' AND c.downloadscat_id = d.download_category AND d.download_website = '0' AND d.download_hook = '0' ORDER BY $order");

            while ($insert = mysql_fetch_array($result))
            {
                if (!$headersend)
                {
                    $download .= GetTemplate("download_cat_header");
                    $headersend = 1;
                }
                if (!$insert[download_html])
                {
                    $insert[download_text] = DeChomp($insert[download_text]);
                }
                if ($insert[download_icon])
                {
                    $insert[download_text] = Icons($insert[download_text]);
                }
                if ($insert[download_code])
                {
                    $insert[download_text] = Code($insert[download_text]);
                }
                $insert[download_text] = eregi_replace("\\[thumb\\]([^\\[]*)\\[/thumb\\]", "<a href=\"javascript:FullWin('thumb.php?img=\\1&action=full&section=downloads')\"><img src=\"thumb.php?img=\\1&section=downloads\" border=\"0\"></a>", $insert[download_text]);
                $download .= GetTemplate("download_cat_page");
            }
            $download .= GetTemplate("download_cat_footer");

            if (!$sort) $sort = 1;
            WriteCache("download", "download-$id-$sort", $download, MkTime()+3600);
        }
    }

    FooterBlock();

?>
