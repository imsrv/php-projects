<?php

    /*
    ########################
    # |//////////////////| #
    # NULLED by [GTT] =)   #
    # |\\\\\\\\\\\\\\\\\\| #
    ########################
    */

    require("core.php");

    $cache = GetCache("news", "sidebar");

    if (!$cache)
    {
        dbconnect();
        $website = $configs[4];
        $insert[site_name] = $configs[5];
        $insert[site_url] = $configs[6];
        $sidebarnews = GetTemplate("sidebar_header");

        $result = DBQuery("SELECT * FROM esselbach_st_stories WHERE story_website = '$website' AND story_hook = '0' OR story_website = '0' AND story_hook = '0' ORDER BY story_time DESC LIMIT 10");

        while ($insert = mysql_fetch_array($result))
        {
            $insert[site_url] = $configs[6];
            $sidebarnews .= GetTemplate("sidebar_news");
        }

        $sidebarnews .= GetTemplate("sidebar_footer");
        WriteCache("news", "sidebar", $sidebarnews, 0);

    }

?>
