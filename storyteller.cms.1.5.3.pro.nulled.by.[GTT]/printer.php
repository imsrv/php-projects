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
        $action = $_GET["action"];
        $page = $_GET["page"];
    }

    $id = checknum ($id);
    $page = checknum($page);
    $action = checkvar($action);
    $website = $configs[4];

    if ($action == "review")
    {

        $cache = GetCache("reviews", "reviewp-$id-$page");

        if (!$cache)
        {
            dbconnect();

            $result = DBQuery("SELECT * FROM esselbach_st_review WHERE review_id = '$id' AND review_page = '$page' AND review_website = '$website' OR review_id = '$id' AND review_page = '$page' AND review_website = '0'");

            if ($result)
            {
                $insert = mysql_fetch_array($result);

                if (!$insert[review_html])
                {
                    $insert[review_text] = DeChomp($insert[review_text]);
                }
                if ($insert[review_icon])
                {
                    $insert[review_text] = Icons($insert[review_text]);
                }
                if ($insert[review_code])
                {
                    $insert[review_text] = Code($insert[review_text]);
                }

                $insert[review_text] = eregi_replace("\\[thumb\\]([^\\[]*)\\[/thumb\\]", "<img src=\"thumb.php?img=\\1&section=review\" border=\"0\">", $insert[review_text]);

                $insert[review_sitename] = $configs[5];
                $insert[review_siteurl] = $configs[6];
                $output .= GetTemplate("review_printer");

                WriteCache("reviews", "reviewp-$id-$page", $output, 0);
            }

        }

    }
    else
    {

        $cache = GetCache("story", "storyp-$id");

        if (!$cache)
        {
            dbconnect();

            $result = DBQuery("SELECT * FROM esselbach_st_stories WHERE story_id = '$id' AND story_website = '$website' AND story_hook = '0' OR story_id = '$id' AND story_website = '0' AND story_hook = '0'");

            if (!$result)
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
                $insert[story_text] = eregi_replace("\\[thumb\\]([^\\[]*)\\[/thumb\\]", "<img src=\"thumb.php?img=\\1&section=news\" border=\"0\">", $insert[story_text]);

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
                $insert[story_extendedtext] = eregi_replace("\\[thumb\\]([^\\[]*)\\[/thumb\\]", "<img src=\"thumb.php?img=\\1&section=news\" border=\"0\">", $insert[story_extendedtext]);

                $query = DBQuery("SELECT category_name FROM esselbach_st_categories WHERE category_id = '$insert[story_category]'");
                list($insert[story_category]) = mysql_fetch_row($query);

                $insert[story_sitename] = $configs[5];
                $insert[story_siteurl] = $configs[6];
                $output .= GetTemplate("story_printer");

                WriteCache("story", "storyp-$id", $output, 0);
            }

        }
    }

?>
