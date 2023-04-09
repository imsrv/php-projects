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
        $cache = GetCache("faq", "faq");
        if (!$cache)
        {
            dbconnect();

            $faq = GetTemplate("faq_categories_header");

            $result = DBQuery("SELECT * FROM esselbach_st_faq WHERE faq_website = '$website' OR faq_website = '0'");
            $faqs = mysql_num_rows($result);

            if (!$faqs)
            {
                $faq .= GetTemplate("faq_categories_na");
                $faq .= GetTemplate("faq_categories_footer");
                WriteCache("faq", "faq", $faq, 0);
                FooterBlock();
            }

            $faqcat_name_array = array();
            $faqcat_id_array = array();

            $result = DBQuery("SELECT faqcat_id, faqcat_name FROM esselbach_st_faqcat");

            while (list($faqcat_id, $faqcat_name) = mysql_fetch_row($result))
            {
                array_push ($faqcat_id_array, "$faqcat_id");
                array_push ($faqcat_name_array, "$faqcat_name");
            }

            for($i = 0; $i < count($faqcat_id_array); $i++)
            {
                $result = DBQuery("SELECT * FROM esselbach_st_faq WHERE faq_category = '$faqcat_id_array[$i]' AND faq_website = '$website' OR faq_category = '$faqcat_id_array[$i]' AND faq_website = '0'");
                $faqs = mysql_num_rows($result);

                if ($faqs)
                {
                    $insert[faq_category_id] = $faqcat_id_array[$i];
                    $insert[faq_category_name] = DeChomp($faqcat_name_array[$i]);
                    $insert[faq_faqs] = $faqs;
                    $faq .= GetTemplate("faq_categories");
                }
            }
            $faq .= GetTemplate("faq_categories_footer");
            WriteCache("faq", "faq", $faq, 0);
        }
    }
    else
    {

        $cache = GetCache("faq", "faq-$id");

        if (!$cache)
        {
            dbconnect();

            $result = DBQuery("SELECT faqcat_name FROM esselbach_st_faqcat WHERE faqcat_id = '$id'");
            list($insert[faqcat_name]) = mysql_fetch_row($result);

            $faq = GetTemplate("faq_details_header");

            $result = DBQuery("SELECT * FROM esselbach_st_faq WHERE faq_category = '$id' AND faq_website = '$website' OR faq_category = '$id' AND faq_website = '0'");

            while ($insert = mysql_fetch_array($result))
            {
                $faq .= GetTemplate("faq_list");
            }
            $faq .= GetTemplate("faq_details_footer");
            WriteCache("faq", "faq-$id", $faq, 0);
        }
    }

    FooterBlock();

?>
