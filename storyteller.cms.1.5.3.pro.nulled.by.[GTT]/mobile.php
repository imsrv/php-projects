<?php

    /*
    ########################
    # |//////////////////| #
    # NULLED by [GTT] =)   #
    # |\\\\\\\\\\\\\\\\\\| #
    ########################
    */

    require("core.php");

    $cache = GetCache("news", "mobilenews");

    if (!$cache)
    {
        dbconnect();
        $website = $configs[4];
        $insert[sitename] = $configs[5];
        $mobilenews = GetTemplate("mobile_header");

        $result = DBQuery("SELECT * FROM esselbach_st_stories WHERE story_website = '$website' AND story_hook = '0' OR story_website = '0' AND story_hook = '0' ORDER BY story_time DESC LIMIT 10");

        while ($insert = mysql_fetch_array($result))
        {
            $insert[story_text] = str_replace("\n", "<br />" , $insert[story_text]);
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

            $mobilenews .= GetTemplate("mobile_news");
        }

        $mobilenews .= GetTemplate("mobile_footer");
        WriteCache("news", "mobilenews", $mobilenews, 0);

    }

?>
