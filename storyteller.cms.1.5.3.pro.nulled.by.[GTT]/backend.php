<?php

    /*
    ########################
    # |//////////////////| #
    # NULLED by [GTT] =)   #
    # |\\\\\\\\\\\\\\\\\\| #
    ########################
    */

    require("core.php");

    $website = $configs[4];

    if (phpversion() >= "4.1.0")
    {
        $action = $_GET["action"];
        $id = $_GET["id"];
    }

    $action = checkvar($action);
    $id = checknum($id);

    if ($action == "help")
    {
        HeaderBlock();
        $cache = GetCache("xml", "xmlhelp");

        if (!$cache)
        {
            dbconnect();

            $category_name_array = array();
            $category_id_array = array();

            $result = DBQuery("SELECT category_id, category_name FROM esselbach_st_categories");

            while (list($category_id, $category_name) = mysql_fetch_row($result))
            {
                array_push ($category_id_array, "$category_id");
                array_push ($category_name_array, "$category_name");
            }

            $xmlhelp .= GetTemplate("xml_help_header");
            $xmlhelp .= GetTemplate("xml_help_news");

            for($i = 0; $i < count($category_id_array); $i++)
            {
                $result = DBQuery("SELECT * FROM esselbach_st_stories WHERE story_category = '$category_id_array[$i]' AND story_website = '$website' AND story_hook = '0' OR story_category = '$category_id_array[$i]' and story_website = '0' AND story_hook = '0'");
                $stories = mysql_num_rows($result);

                if ($stories > 0)
                {
                    $insert[category_id] = $category_id_array[$i];
                    $insert[category_name] = $category_name_array[$i];
                    $xmlhelp .= GetTemplate("xml_help_newsitem");
                }
            }

            $result = DBQuery("SELECT * FROM esselbach_st_faq WHERE faq_website = '$website' OR faq_website = '0'");
            if (mysql_num_rows($result)) $xmlhelp .= GetTemplate("xml_help_faq");

            $result = DBQuery("SELECT * FROM esselbach_st_review WHERE review_website = '$website' OR review_website = '0'");
            if (mysql_num_rows($result)) $xmlhelp .= GetTemplate("xml_help_reviews");

            $result = DBQuery("SELECT * FROM esselbach_st_downloads WHERE download_website = '$website' AND download_hook = '0' OR download_website = '0' AND download_hook = '0'");
            if (mysql_num_rows($result)) $xmlhelp .= GetTemplate("xml_help_downloads");

            if (file_exists("bbwrapper.php")) $xmlhelp .= GetTemplate("xml_help_forum");

            $xmlhelp .= GetTemplate("xml_help_footer");

            WriteCache("xml", "xmlhelp", $xmlhelp, 0);
        }

        FooterBlock();
        exit;
    }

    header("Content-Type: text/xml");

    $insert[site_name] = $configs[5];
    $insert[site_url] = $configs[6];

    echo GetTemplate("xml_header");

    if (!$id) $id = 0;

    $cache = GetCache("xml", "xmlnews-$id");

    if (!$cache)
    {
        dbconnect();

        if ($id < 100)
        {
            if ($id == 0)
            {
                $result = DBQuery("SELECT * FROM esselbach_st_stories WHERE story_website = '$website' AND story_hook = '0' OR story_website = '0' AND story_hook = '0' ORDER BY story_time DESC LIMIT 20");
            }
            else
            {
                $result = DBQuery("SELECT * FROM esselbach_st_stories WHERE story_category = '$id' AND story_website = '$website' AND story_hook = '0' OR story_category = '$id' AND story_website = '0' AND story_hook = '0' ORDER BY story_time DESC LIMIT 20");
            }

            while ($insert = mysql_fetch_array($result))
            {
                $story = explode("\n", $insert[story_text]);
                $insert[story_title] = MakeXML($insert[story_title]);
                $insert[story_text] = MakeXML($story[0]);
                $insert[story_link] = "$configs[6]/story.php?id=$insert[story_id]";
                $xmlnews .= GetTemplate("xml_output");
            }
        }
        else
        {
            if (($id == 200) and (file_exists("bbwrapper.php")))
            {
                $bbdata = BBGetXML();
                for($t = 0; $t < count($bbdata); $t++)
                {
                    $datasplit = explode("||~||", $bbdata[$t]);
                    $insert[story_title] = MakeXML($datasplit[1]);
                    $insert[story_text] = MakeXML($datasplit[2]);
                    $insert[story_link] = MakeXML($datasplit[0]);
                    $xmlnews .= GetTemplate("xml_output");
                }
                WriteCache("xml", "xmlnews-$id", $xmlnews, MkTime()+3600);
                echo GetTemplate("xml_footer");
                exit;
            }

            if ($id == 100)
            {
                $result = DBQuery("SELECT * FROM esselbach_st_faq WHERE faq_website = '$website' OR faq_website = '0' ORDER BY faq_id DESC LIMIT 20");
            }
            if ($id == 110)
            {
                $result = DBQuery("SELECT * FROM esselbach_st_review WHERE review_page = '1' AND review_website = '$website' OR review_page = '1' AND review_website = '0' ORDER BY review_id DESC LIMIT 20");
            }
            if ($id == 120)
            {
                $result = DBQuery("SELECT * FROM esselbach_st_downloads WHERE download_website = '$website' AND download_hook = '0' OR download_website = '0' AND download_hook = '0' ORDER BY download_id DESC LIMIT 20");
            }

            while ($insert = mysql_fetch_array($result))
            {
                if ($id == 100)
                {
                    $insert[story_title] = MakeXML($insert[faq_question]);
                    $insert[story_text] = MakeXML($insert[faq_question]);
                    $insert[story_link] = "$configs[6]/faqshow.php?id=$insert[faq_id]";
                }
                if ($id == 110)
                {
                    $insert[story_title] = MakeXML($insert[review_title]);
                    $reviewsnip = explode("\n", $insert[review_text]);
                    $insert[story_text] = MakeXML($reviewsnip[0]);
                    $insert[story_link] = "$configs[6]/review.php?id=$insert[review_id]";
                }
                if ($id == 120)
                {
                    $insert[story_title] = MakeXML($insert[download_title]);
                    $dlsnip = explode("\n", $insert[download_text]);
                    $insert[story_text] = MakeXML($dlsnip[0]);
                    $insert[story_link] = "$configs[6]/download.php?det=$insert[download_id]";
                }
                $xmlnews .= GetTemplate("xml_output");
            }
        }

        WriteCache("xml", "xmlnews-$id", $xmlnews, 0);
    }

    echo GetTemplate("xml_footer");

?>
