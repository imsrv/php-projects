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

    $id = checknum($id);
    $page = checknum($page);
    $website = $configs[4];

    HeaderBlock();

    if (!$id)
    {
        $cache = GetCache("reviews", "reviews");
        if (!$cache)
        {
            dbconnect();

            $reviewcat_name_array = array();
            $reviewcat_id_array = array();

            $result = DBQuery("SELECT reviewcat_id, reviewcat_name FROM esselbach_st_reviewcat");

            while (list($reviewcat_id, $reviewcat_name) = mysql_fetch_row($result))
            {
                array_push ($reviewcat_id_array, "$reviewcat_id");
                array_push ($reviewcat_name_array, "$reviewcat_name");
            }

            $review = GetTemplate("review_list_header");

            for($i = 0; $i < count($reviewcat_id_array); $i++)
            {
                $result = DBQuery("SELECT * FROM esselbach_st_review WHERE review_category = '$reviewcat_id_array[$i]' AND review_page = '1' AND review_hook = '0' AND review_website = '$website' OR review_category = '$reviewcat_id_array[$i]' AND review_page = '1' AND review_hook = '0' AND review_website = '0' ORDER BY review_title");
                $reviews = mysql_num_rows($result);

                if ($reviews > 0)
                {
                    $insert[review_categoryname] = DeChomp($reviewcat_name_array[$i]);
                    $insert[review_reviewcount] = $reviews;
                    $review .= GetTemplate("review_category");
                    while ($insert = mysql_fetch_array($result))
                    {
                        $review .= GetTemplate("review_list");
                    }
                    $review .= "<br />";
                }
            }

            $review .= GetTemplate("review_list_footer");

            WriteCache("reviews", "reviews", $review, 0);
        }

    }
    else
    {

        if (!$page) $page = 1;
        $cache = GetCache("reviews", "review-$id-$page");

        if (!$cache)
        {
            dbconnect();

            $result = DBQuery("SELECT * FROM esselbach_st_review WHERE review_id = '$id' AND review_hook = '0' AND review_website = '$website' OR review_id = '$id' AND review_hook = '0' AND review_website = '0'");
            $pages = mysql_num_rows($result);

            $result = DBQuery("SELECT * FROM esselbach_st_review WHERE review_id = '$id' AND review_page = '$page' AND review_hook = '0' AND review_website = '$website' OR review_id = '$id' AND review_page = '$page' AND review_hook = '0' AND review_website = '0'");

            if ($result)
            {
                while ($insert = mysql_fetch_array($result))
                {
                    $insert[review_allpages] = $pages;
                    if ($pages > $page)
                    {
                        $page_next = $page + 1;
                        $insert[review_next_url] = "review.php?id=$id&page=$page_next";
                        $insert[review_next] = GetTemplate("review_next_page");
                    }
                    if ($page > 1)
                    {
                        $page_previous = $page - 1;
                        $insert[review_previous_url] = "review.php?id=$id&page=$page_previous";
                        $insert[review_previous] = GetTemplate("review_previous_page");
                    }

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
                    $insert[review_text] = eregi_replace("\\[thumb\\]([^\\[]*)\\[/thumb\\]", "<a href=\"javascript:FullWin('thumb.php?img=\\1&action=full&section=review')\"><img src=\"thumb.php?img=\\1&section=review\" border=\"0\"></a>", $insert[review_text]);

                    $review = GetTemplate("review_header");
                    $review .= GetTemplate("review");
                    $review .= GetTemplate("review_footer");

                    if ($insert[review_allpages] > 1)
                    {
                        $subs = DBQuery("SELECT review_pagesub, review_page FROM esselbach_st_review WHERE review_id='$id' AND review_website = '$website' OR review_id = '$id' AND review_website = '0'");
                        while ($subjects = mysql_fetch_row($subs))
                        {
                            if ($subjects[0])
                            {
                                $mysubs[] = $subjects[0];
                                $mypage[] = $subjects[1];
                            }
                        }

                        if (count($mysubs) > 1)
                        {
                            $review .= GetTemplate("review_overview_header");

                            for($z = 0; $z < count($mysubs); $z++)
                            {
                                $insert[review_pagesubject] = $mysubs[$z];
                                $insert[review_pageid] = $mypage[$z];
                                $review .= GetTemplate("review_overview_list");
                            }

                            $review .= GetTemplate("review_overview_footer");

                        }
                    }
                }
                WriteCache("reviews", "review-$id-$page", $review, 0);
            }

        }
    }

    FooterBlock();

?>
