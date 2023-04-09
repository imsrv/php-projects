<?php

    /*
    ########################
    # |//////////////////| #
    # NULLED by [GTT] =)   #
    # |\\\\\\\\\\\\\\\\\\| #
    ########################
    */

    require("core.php");

    HeaderBlock();
    $cache = GetCache("news", "mainnews");

    $website = $configs[4];

    if (!$cache)
    {
        dbconnect();

        $result = DBQuery("SELECT * FROM esselbach_st_websites WHERE website_id = '$website'");
        $blocks = mysql_fetch_array($result);

        if ($blocks[website_textenabled])
        {
            $insert = $blocks;
            if (!$insert[website_html])
            {
                $insert[website_text] = DeChomp($insert[website_text]);
            }
            if ($insert[website_icon])
            {
                $insert[website_text] = Icons($insert[website_text]);
            }
            if ($insert[website_code])
            {
                $insert[website_text] = Code($insert[website_text]);
            }
            $mainnews .= GetTemplate("main_page");
        }

        $query = DBQuery("SELECT * FROM esselbach_st_polls WHERE poll_main = '1' AND poll_website = '$website' OR poll_main = '1' AND poll_website = '0' ORDER BY poll_id DESC");
        if (mysql_num_rows($query))
        {
            $insert = mysql_fetch_array($query);
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
            $mainnews .= GetTemplate("poll_mainpage_header");

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
                    $mainnews .= GetTemplate("poll_option");
                }
            }
            $mainnews .= GetTemplate("poll_mainpage_footer");
        }

        $category_name_array = array();
        $category_id_array = array();

        $result = DBQuery("SELECT category_id, category_name FROM esselbach_st_categories");

        while (list($category_id, $category_name) = mysql_fetch_row($result))
        {
            array_push ($category_id_array, "$category_id");
            array_push ($category_name_array, "$category_name");
        }

        $result = DBQuery("SELECT * FROM esselbach_st_stories WHERE story_main = '1' AND story_website = '$website' AND story_sticky = '1' AND story_hook = '0' OR story_main = '1' AND story_website = '0' AND story_sticky = '1' AND story_hook = '0' ORDER BY story_id DESC");

        if (mysql_num_rows($result))
        {
            $mainnews .= GetTemplate("news_featuredheader");

            while ($insert = mysql_fetch_array($result))
            {
                $category = $insert[story_category];
                for($i = 0; $i < count($category_id_array); $i++)
                {
                    if ($category == $category_id_array[$i])
                    {
                        $insert[story_category] = $category_name_array[$i];
                    }
                }

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

                if ($insert[story_extendedtext])
                {
                    $insert[story_text] .= GetTemplate("news_more");
                }
                $mainnews .= GetTemplate("news");
            }
            $mainnews .= GetTemplate("news_featuredfooter");
        }

        if ($blocks[website_mainnews])
        {
            $story_date_array = array();
            $result = DBQuery("SELECT DISTINCT SUBSTRING_INDEX(story_time,' ','1') FROM esselbach_st_stories WHERE story_main = '1' AND story_website = '$website' AND story_sticky = '0' AND story_hook = '0' OR story_main = '1' AND story_website = '0' AND story_sticky = '0' AND story_hook = '0' ORDER BY story_id DESC LIMIT $blocks[website_daymax]");

            while (list($story_time) = mysql_fetch_row ($result))
            {
                array_push ($story_date_array, "$story_time");
            }
        }

        if ($blocks[website_mainnews])
        {
            for($a = 0; $a < count($story_date_array); $a++)
            {

                $story_time_array = explode("-", $story_date_array[$a]);
                $insert[story_day] = date("F j, Y", mktime(0, 0, 0, $story_time_array[1], $story_time_array[2], $story_time_array[0]));
                $mainnews .= GetTemplate("news_subheader");

                $result = DBQuery("SELECT * FROM esselbach_st_stories WHERE (story_time LIKE '%$story_date_array[$a]%') AND story_main = '1' AND story_website = '$website' AND story_sticky = '0' AND story_hook = '0' OR (story_time LIKE '%$story_date_array[$a]%') AND story_main = '1' AND story_website = '0' AND story_sticky = '0' AND story_hook = '0' ORDER BY story_id DESC");

                while ($insert = mysql_fetch_array($result))
                {
                    $category = $insert[story_category];
                    for($i = 0; $i < count($category_id_array); $i++)
                    {
                        if ($category == $category_id_array[$i])
                        {
                            $insert[story_category] = $category_name_array[$i];
                        }
                    }

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

                    if ($insert[story_extendedtext])
                    {
                        $insert[story_text] .= GetTemplate("news_more");
                    }
                    $mainnews .= GetTemplate("news");
                }
                $mainnews .= GetTemplate("news_subfooter");
            }
        }
        else
        {

            $result = DBQuery("SELECT * FROM esselbach_st_stories WHERE story_main = '1' AND story_website = '$website' AND story_sticky = '0' AND story_hook = '0' OR story_main = '1' AND story_website = '0' AND story_sticky = '0' AND story_hook = '0' ORDER BY story_id DESC LIMIT $blocks[website_newsmax]");

            while ($insert = mysql_fetch_array($result))
            {
                $category = $insert[story_category];
                for($i = 0; $i < count($category_id_array); $i++)
                {
                    if ($category == $category_id_array[$i])
                    {
                        $insert[story_category] = $category_name_array[$i];
                    }
                }

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

                if ($insert[story_extendedtext])
                {
                    $insert[story_text] .= GetTemplate("news_more");
                }
                $mainnews .= GetTemplate("news");
            }
        }

        WriteCache("news", "mainnews", $mainnews, 0);

    }

    FooterBlock();

?>
