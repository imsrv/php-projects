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

    $website = $configs[4];
    $cache = GetCache("links", "link");

    if (!$cache)
    {
        dbconnect();

        $link = GetTemplate("link_list_header");

        $result = DBQuery("SELECT * FROM esselbach_st_links WHERE link_website = '$website' OR link_website = '0' ORDER BY link_title");
        $links = mysql_num_rows($result);

        if (!$links)
        {
            $link .= GetTemplate("link_list_na");
        }
        else
        {

            $linkcat_name_array = array();
            $linkcat_id_array = array();

            $result = DBQuery("SELECT linkcat_id, linkcat_name FROM esselbach_st_linkscat");

            while (list($linkcat_id, $linkcat_name) = mysql_fetch_row($result))
            {
                array_push ($linkcat_id_array, "$linkcat_id");
                array_push ($linkcat_name_array, "$linkcat_name");
            }

            for($i = 0; $i < count($linkcat_id_array); $i++)
            {
                $result = DBQuery("SELECT * FROM esselbach_st_links WHERE link_category = '$linkcat_id_array[$i]' AND link_website = '$website' OR link_category = '$linkcat_id_array[$i]' AND link_website = '0' ORDER BY link_title");
                $links = mysql_num_rows($result);

                if ($links > 0)
                {
                    $insert[link_categoryname] = $linkcat_name_array[$i];
                    $insert[link_linkscount] = $links;
                    $link .= GetTemplate("link_category");
                    while ($insert = mysql_fetch_array($result))
                    {
                        $link .= GetTemplate("link_list");
                    }
                    $link .= "<br />";
                }

            }
        }

        $link .= GetTemplate("link_list_footer");

        WriteCache("links", "link", $link, 0);
    }

    FooterBlock();

?>
