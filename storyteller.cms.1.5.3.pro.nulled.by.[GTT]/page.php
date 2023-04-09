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

        $cache = GetCache("pages", "pages");

        if (!$cache)
        {
            dbconnect();

            $page = GetTemplate("pages_header");

            $result = DBQuery("SELECT * FROM esselbach_st_pages WHERE page_website = '$website' OR page_website = '0' ORDER BY page_title");

            $pages = mysql_num_rows($result);

            if ($pages > 0)
            {
                while ($insert = mysql_fetch_array($result))
                {
                    $page .= GetTemplate("pages_list");
                }
            }
            else
            {
                $page .= GetTemplate("pages_list_na");
            }
            $page .= GetTemplate("pages_footer");

            WriteCache("pages", "pages", $page, 0);
        }

    }
    else
    {

        $cache = GetCache("pages", "page-$id");

        if (!$cache)
        {
            dbconnect();

            $result = DBQuery("SELECT * FROM esselbach_st_pages WHERE page_id = '$id' AND page_website = '$website' OR page_id = '$id' AND page_website = '0'");
            $rows = mysql_num_rows($result);

            if (!$rows)
            {
                echo GetTemplate("page_na");
            }
            else
            {
                $insert = mysql_fetch_array($result);
                if (!$insert[page_html])
                {
                    $insert[page_text] = DeChomp($insert[page_text]);
                }
                if ($insert[page_icon])
                {
                    $insert[page_text] = Icons($insert[page_text]);
                }
                if ($insert[page_code])
                {
                    $insert[page_text] = Code($insert[page_text]);
                }
                $page .= GetTemplate("page");

                WriteCache("pages", "page-$id", $page, 0);
            }

        }

    }

    FooterBlock();

?>
