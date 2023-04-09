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
        $cache = GetCache("archive", "archive");

        if (!$cache)
        {
            dbconnect();

            $archive = GetTemplate("archive_header");
            $result = DBQuery("SELECT DISTINCT SUBSTRING_INDEX(story_time,'-','2') FROM esselbach_st_stories WHERE story_website = '$website' AND story_hook = '0' OR story_website = '0' AND story_hook = '0' ORDER BY story_time DESC");
            $entries = mysql_num_rows($result);

            if ($entries)
            {
                while (list($story_time) = mysql_fetch_row ($result))
                {
                    $story_time_array = explode("-", $story_time);
                    $insert[archive_date] = date("F Y", mktime(0, 0, 0, $story_time_array[1]+1, 0, $story_time_array[0]));
                    $insert[archive_url] = $story_time_array[0].$story_time_array[1];
                    $archive .= GetTemplate("archive_list");
                }
            }
            else
            {
                $archive .= GetTemplate("archive_list_na");
            }
            $archive .= GetTemplate("archive_footer");
            WriteCache("archive", "archive", $archive, 0);
        }

    }
    else
    {

        $cache = GetCache("archive", "archive-$id");

        if (!$cache)
        {
            dbconnect();

            $insert[archive_year] = substr($id, 0, 4);
            $insert[archive_month] = substr($id, 4, 6);

            $archive = GetTemplate("archive_details_header");

            $result = DBQuery("SELECT * FROM esselbach_st_stories WHERE (story_time LIKE '%$insert[archive_year]-$insert[archive_month]%') AND story_website = '$website' AND story_hook = '0' OR (story_time LIKE '%$insert[archive_year]-$insert[archive_month]%') AND story_website = '0' AND story_hook = '0' ORDER BY story_id DESC");

            while ($insert = mysql_fetch_array($result))
            {
                $archive .= GetTemplate("archive_details_list");
            }
            $archive .= GetTemplate("archive_details_footer");
            WriteCache("archive", "archive-$id", $archive, 0);
        }
    }

    FooterBlock();

?>
