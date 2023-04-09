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
        $query = $_POST["query"];
        $where = $_POST["where"];
        $for = $_GET["for"];
        $cat = $_GET["cat"];
        $start = $_GET["start"];
    }

    if ($for)
    {
        $query = $for;
    }
    if ($cat)
    {
        $where = $cat;
    }
    if (!$start)
    {
        $start = 0;
    }

    $query = ScriptEx(checkvar($query));
    $where = checknum($where);
    $start = checknum($start);
    $website = $configs[4];

    HeaderBlock();

    if (!$query)
    {
        echo GetTemplate("search_page");
    }
    else
    {
        dbconnect();

        $result = DBQuery("SELECT version_table FROM esselbach_st_version");
        list($table) = mysql_fetch_row($result);

        $insert[search_query] = stripslashes($query);

        echo GetTemplate("search_list_header");

        if ((!$where) or ($where > 5))
        {
            echo GetTemplates ("search_error_nomatch");
            echo GetTemplate("search_list_footer");
            FooterBlock();
            exit;
        }

        if (($table == "MyISAM") or ($table == "ISAM"))
        {
            if ($where == "1")
            {
                $result = DBQuery("SELECT * FROM esselbach_st_stories WHERE (story_text LIKE '%$query%') AND story_hook = '0' AND story_website = '$website' OR (story_text LIKE '%$query%') AND story_hook = '0' AND story_website = '0' ORDER BY story_time DESC LIMIT $start,100");
            }
            if ($where == "2")
            {
                $result = DBQuery("SELECT * FROM esselbach_st_review WHERE (review_text LIKE '%$query%') AND review_hook = '0' AND review_website = '$website' AND review_page = '1' OR (review_text LIKE '%$query%') AND review_hook = '0' AND review_website = '0' AND review_page = '1' ORDER BY review_id DESC LIMIT $start,100");
            }
            if ($where == "3")
            {
                $result = DBQuery("SELECT * FROM esselbach_st_faq WHERE (faq_question LIKE '%$query%') AND faq_website = '$website' OR (faq_question LIKE '%$query%') AND faq_website = '0' ORDER BY faq_id DESC LIMIT $start,100");
            }
            if ($where == "4")
            {
                $result = DBQuery("SELECT * FROM esselbach_st_downloads WHERE (download_title LIKE '%$query%') AND download_hook = '0' AND download_website = '$website' OR (download_title LIKE '%$query%') AND download_hook = '0' AND download_website = '0' ORDER BY download_time DESC LIMIT $start,100");
            }
            if ($where == "5")
            {
                $result = DBQuery("SELECT * FROM esselbach_st_pages WHERE (page_text LIKE '%$query%') AND page_website = '$website' OR (page_text LIKE '%$query%') AND page_website = '0' ORDER BY page_id DESC LIMIT $start,100");
            }
        }

        if ($table == "InnoDB")
        {
            $result = DBQuery("SELECT * FROM esselbach_st_searchindex WHERE search_website = '$website' AND search_category = '$where' AND MATCH(search_text) AGAINST ('$query' IN BOOLEAN MODE) OR search_website = '0' AND search_category = '$where' AND MATCH(search_text) AGAINST ('$query' IN BOOLEAN MODE) ORDER BY search_time DESC LIMIT $start,100");
        }

        if (!mysql_num_rows($result))
        {
            echo GetTemplate ("search_error_nomatch");
        }
        else
        {
            while ($insert = mysql_fetch_array($result))
            {

                if ($table == "InnoDB")
                {
                    if ($where == "1")
                    {
                        $insert[story_title] = $insert[search_title];
                        $insert[story_text] = $insert[search_text];
                        $insert[story_time] = $insert[search_time];
                        $insert[story_id] = $insert[search_oid];
                        $insert[story_author] = $insert[search_author];
                    }
                    if ($where == "2")
                    {
                        $insert[review_title] = $insert[search_title];
                        $insert[review_text] = $insert[search_text];
                        $insert[review_time] = $insert[search_time];
                        $insert[review_id] = $insert[search_oid];
                        $insert[review_author] = $insert[search_author];
                    }
                    if ($where == "3")
                    {
                        $insert[faq_question] = $insert[search_title];
                        $insert[faq_answer] = $insert[search_text];
                        $insert[faq_time] = $insert[search_time];
                        $insert[faq_id] = $insert[search_oid];
                        $insert[faq_author] = $insert[search_author];
                    }
                    if ($where == "4")
                    {
                        $insert[download_title] = $insert[search_title];
                        $insert[download_text] = $insert[search_text];
                        $insert[download_time] = $insert[search_time];
                        $insert[download_id] = $insert[search_oid];
                        $insert[download_author] = $insert[search_author];
                    }
                    if ($where == "5")
                    {
                        $insert[page_title] = $insert[search_title];
                        $insert[page_text] = $insert[search_text];
                        $insert[page_time] = $insert[search_time];
                        $insert[page_id] = $insert[search_oid];
                        $insert[page_author] = $insert[search_author];
                    }
                }

                if ($where == "1")
                {
                    echo GetTemplate("search_list_news");
                }
                if ($where == "2")
                {
                    echo GetTemplate("search_list_reviews");
                }
                if ($where == "3")
                {
                    echo GetTemplate("search_list_faq");
                }
                if ($where == "4")
                {
                    echo GetTemplate("search_list_files");
                }
                if ($where == "5")
                {
                    echo GetTemplate("search_list_pages");
                }
            }
        }

        if (mysql_num_rows($result) == 100)
        {
            $insert[search_start] = $start + 100;
            $insert[search_query] = $query;
            $insert[search_where] = $where;
            echo GetTemplate("search_next_page");
        }

        echo GetTemplate("search_list_footer");
    }

    FooterBlock();

?>
