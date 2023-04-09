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
    }

    $id = checknum($id);
    $website = $configs[4];

    HeaderBlock();

    if (!$id)
    {
        $cache = GetCache("categories", "category");
        if (!$cache)
        {
            dbconnect();

            $categories = GetTemplate("category_header");

            $result = DBQuery("SELECT * FROM esselbach_st_stories WHERE story_website = '$website' AND story_hook = '0' OR story_website = '0' AND story_hook = '0'");
            $stories = mysql_num_rows($result);

            if (!$stories)
            {
                $categories .= GetTemplate("category_na");
                $categories .= GetTemplate("category_footer");
                WriteCache("categories", "category", $categories, 0);
                FooterBlock();
            }

            $category_name_array = array();
            $category_id_array = array();

            $result = DBQuery("SELECT category_id, category_name FROM esselbach_st_categories ORDER BY category_name");

            while (list($category_id, $category_name) = mysql_fetch_row($result))
            {
                array_push ($category_id_array, "$category_id");
                array_push ($category_name_array, "$category_name");
            }

            for($i = 0; $i < count($category_id_array); $i++)
            {
                $result = DBQuery("SELECT * FROM esselbach_st_stories WHERE story_category = '$category_id_array[$i]' AND story_website = '$website' AND story_hook = '0' OR story_category = '$category_id_array[$i]' AND story_website = '0' AND story_hook = '0'");
                $stories = mysql_num_rows($result);

                if ($stories > 0)
                {
                    $insert[category_id] = $category_id_array[$i];
                    $insert[category_name] = $category_name_array[$i];
                    $insert[category_news] = $stories;
                    $categories .= GetTemplate("category");
                }
            }
            $categories .= GetTemplate("category_footer");

            WriteCache("categories", "category", $categories, 0);
        }
    }
    else
    {

        $cache = GetCache("categories", "category-$id");

        if (!$cache)
        {
            dbconnect();

            $category_name_array = array();
            $category_id_array = array();

            $result = DBQuery("SELECT category_name FROM esselbach_st_categories WHERE category_id = '$id'");
            list($category_name) = mysql_fetch_row($result);

            $insert[story_category] = $category_name;
            $categorynews = GetTemplate("category_line");

            $result = DBQuery("SELECT * FROM esselbach_st_stories WHERE story_category = '$id' AND story_website = '$website' AND story_hook = '0' OR story_category = '$id' AND story_website = '0' AND story_hook = '0' ORDER BY story_time DESC LIMIT 20");

            while ($insert = mysql_fetch_array($result))
            {
                $insert[story_text] = str_replace("\n", "<br />" , $insert[story_text]);
                $insert[story_category] = $category_name;
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
                $categorynews .= GetTemplate("news");
            }

            WriteCache("categories", "category-$id", $categorynews, 0);
        }
    }

    FooterBlock();

?>
