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

    if (!$id)
    {
        $id = 0;
    }

    HeaderBlock();

    $cache = GetCache("glossary", "glossary-$id");

    if (!$cache)
    {
        $glossary_array = array("0-9", "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z");
        dbconnect();

        if ($id > 0)
        {
            $result = DBQuery("SELECT * FROM esselbach_st_glossary WHERE (glossary_title LIKE '$glossary_array[$id]%') AND glossary_website = '$website' OR (glossary_title LIKE '$glossary_array[$id]%') AND glossary_website = '0' ORDER BY glossary_title");
        }
        else
        {
            $result = DBQuery("SELECT * FROM esselbach_st_glossary WHERE (glossary_title REGEXP '^[0-9]') AND glossary_website = '$website' OR (glossary_title REGEXP '^[0-9]') AND glossary_website = '0' ORDER BY glossary_title");
        }
        $glossary_entries = mysql_num_rows($result);


        $insert[glossary_index] = $glossary_array[$id];
        $insert[glossary_entries] = $glossary_entries;
        $glossary = GetTemplate("glossary_header");

        if ($glossary_entries)
        {
            while ($insert = mysql_fetch_array($result))
            {
                if (!$insert[glossary_html]) $insert[glossary_text] = DeChomp($insert[glossary_text]);
                if ($insert[glossary_icon]) $insert[glossary_text] = Icons($insert[glossary_text]);
                if ($insert[glossary_code]) $insert[glossary_text] = Code($insert[glossary_text]);
                $glossary .= GetTemplate("glossary_list");
            }
        }
        else
        {
            $glossary .= GetTemplate("glossary_list_na");
        }

        $glossary .= GetTemplate("glossary_footer");
        WriteCache("glossary", "glossary-$id", $glossary, 0);

    }

    FooterBlock();

?>
