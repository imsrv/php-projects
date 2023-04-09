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

    $cache = GetCache("faq", "faqshow-$id");

    if (!$cache)
    {
        dbconnect();

        $result = DBQuery("SELECT * FROM esselbach_st_faq f, esselbach_st_faqcat c WHERE f.faq_id = '$id' AND f.faq_website = '$website' AND c.faqcat_id = f.faq_category OR f.faq_id = '$id' AND f.faq_website = '0' AND c.faqcat_id = f.faq_category");

        if ($result)
        {
            $insert = mysql_fetch_array($result);
            if (!$insert[faq_html])
            {
                $insert[faq_answer_text] = DeChomp($insert[faq_answer_text]);
            }
            if ($insert[faq_icon])
            {
                $insert[faq_answer_text] = Icons($insert[faq_answer_text]);
            }
            if ($insert[faq_code])
            {
                $insert[faq_answer_text] = Code($insert[faq_answer_text]);
            }
            $insert[faq_answer_text] = eregi_replace("\\[thumb\\]([^\\[]*)\\[/thumb\\]", "<a href=\"javascript:FullWin('thumb.php?img=\\1&action=full&section=faq')\"><img src=\"thumb.php?img=\\1&section=faq\" border=\"0\"></a>", $insert[faq_answer_text]);

            $faqshow = GetTemplate("faq_show_header");
            $faqshow .= GetTemplate("faq_show");
            $faqshow .= GetTemplate("faq_show_footer");
            WriteCache("faq", "faqshow-$id", $faqshow, 0);
        }

    }

    FooterBlock();

?>


