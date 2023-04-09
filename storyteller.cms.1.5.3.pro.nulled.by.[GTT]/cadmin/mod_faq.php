<?php

    /*
    ########################
    # |//////////////////| #
    # NULLED by [GTT] =)   #
    # |\\\\\\\\\\\\\\\\\\| #
    ########################
    */

    function AdminEditFAQ($opts)
    {

        global $words, $admin, $midas;
        dbconnect();

        $options = explode("-", $opts);

        if (($options[0]) and ($admin[user_canfaq] == 2))
            {
            $result = DBQuery("SELECT faq_author FROM esselbach_st_faq WHERE faq_id = '$options[1]'");
            list($faqauthor) = mysql_fetch_row($result);

            if ($faqauthor != $admin[user_name])
                {
                MkHeader("_self");
                MkTabHeader ("$words[ERR]");
                echo "$words[RFAQS]";
                MkTabFooter();
                MkFooter();
            }
        }

        if ($options[0] == "deletefaq")
            {

            $result = DBQuery("SELECT faq_category FROM esselbach_st_faq WHERE faq_id='$options[1]'");
            list($faq_category) = mysql_fetch_row ($result);

            RemoveCache ("faq/faq-$faq_category");
            RemoveCache ("faq/faq");

            DBQuery("DELETE FROM esselbach_st_faq WHERE faq_id='$options[1]'");
            RemoveIndex ($options[1], 3);

            RemoveCache ("faq/faqshow-$options[1]");
            RemoveCache ("xml/xmlnews-100");
            RemoveCache ("xml/xmlhelp");
            RemoveCache ("tags/faq-$options[1]");

            MkHeader("_self");
            MkTabHeader ("$words[DO]");
            echo "$words[ESR]";
            MkTabFooter();
            MkFooter();

        }

        if ($options[0] == "editfaq")
            {

            $result = DBQuery("SELECT * FROM esselbach_st_faq WHERE faq_id='$options[1]'");
            $faq = mysql_fetch_array($result);

            MkHeader("_self");
            MkTabHeader("$words[EFE] $options[1]");

            echo "<table><form name=\"addfaq\" action=\"index.php\" method=\"post\">";

            $query = DBQuery("SELECT website_id, website_name FROM esselbach_st_websites");
            if (mysql_num_rows($query) > 1)
                {

                echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\">$words[WBS]</font></td><td></td><td><face face=\"Arial\" size=\"2\"><select size=\"1\" name=\"website\">";

                echo "<option value=\"0\">$words[ALL]</option>";
                while (list($website_id, $website_name) = mysql_fetch_row($query))
                {
                    ($website_id == $faq['faq_website']) ? $select = "selected" :
                    $select = "";
                    echo "<option $select value=\"$website_id\">$website_name</option>";
                }

                echo "</select></font></td></tr>";
            }

            MkOption ("$words[QUE]", "", "newstitle", "$faq[faq_question]");

            echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\">$words[CAT]</font></td><td></td><td><face face=\"Arial\" size=\"2\"><select size=\"1\" name=\"category\">";

            $query = DBQuery("SELECT faqcat_id, faqcat_name FROM esselbach_st_faqcat");
            while (list($faqcat_id, $faqcat_name) = mysql_fetch_row($query))
            {
                ($faqcat_id == $faq['faq_category']) ? $select = "selected" :
                $select = "";
                echo "<option $select value=\"$faqcat_id\">$faqcat_name</option>";
            }

            echo "</select></font></td></tr>";

            if ($midas)
            {
                echo "<script type=\"text/javascript\" src=\"wysiwyg/htmlarea3.js\"></script>";
            }
            else
            {
                echo "<script language=\"JavaScript\">
                <!--
                function AutoInsert1(tag) {
                document.addfaq.newstext1.value =
                document.addfaq.newstext1.value + tag;
                }
                function OpenWin() {
                var newWinObj = window.open('index.php?action=showfaqimg','newWin','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=1,copyhistory=0,width=800,height=600')
                }
                //-->
                </script>";

                QuickHTML(1);
            }

            MkArea ("$words[ANS]", "newstext1", "$faq[faq_answer_text]");

            MkSelect ("$words[EHT]", "htmlen", "$faq[faq_html]");
            MkSelect ("$words[EIS]", "iconen", "$faq[faq_icon]");
            MkSelect ("$words[EBC]", "codeen", "$faq[faq_code]");

            $query = DBQuery("SELECT * FROM esselbach_st_fields WHERE field_id='3'");
            $field = mysql_fetch_array($query);

            for($i = 1; $i < 21; $i++)
            {
                if ($field['field_enabled'.$i] == 1)
                    {
                    echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\">".$field['field_extra'.$i].":</font>";
                    echo "</td><td></td><td><font face=\"Arial\" size=\"2\"><input name=\"extra$i\" size=\"32\" value=\"".$faq['faq_extra'.$i]."\"></font></td></tr>";
                }
                if ($field['field_enabled'.$i] == 2)
                    {
                    $fieldoptions = explode(",", $field['field_extra'.$i]);
                    echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\">$fieldoptions[0]:</font>";
                    echo "</td><td></td><td><face face=\"Arial\" size=\"2\"><select size=\"1\" name=\"extra$i\">";
                    for($z = 1; $z < count($fieldoptions); $z++)
                    {
                        ($fieldoptions[$z] == $faq['faq_extra'.$i]) ? $select = "selected" :
                        $select = "";
                        echo "<option $select value=\"$fieldoptions[$z]\">$fieldoptions[$z]</option>";
                    }
                    echo "</select></font></td></tr>";
                }
            }

            echo "<input type=\"hidden\" name=\"aform\" value=\"dofaqedit\"><input type=\"hidden\" name=\"zid\" value=\"$faq[faq_id]\"><td><font face=\"Arial\" size=\"2\"><input type=\"submit\" value=\"$words[SND]\"></form></font></td></tr></table>";
            MkTabFooter();

            if ($midas)
            {
                EnableMidas("newstext1");
            }
            else
            {
                MkTabHeader("$words[SRI4]");
                echo "$words[UPV4]";
                MkTabFooter();
            }
            MkFooter();
        }

        MkHeader("_self");
        MkTabHeader("$words[DAF]");
        echo "$words[DAD]";
        MkTabFooter();

        TblHeader("$words[ESI]", "$words[QUE]");

        $result = DBQuery("SELECT faq_website, faq_question, faq_id FROM esselbach_st_faq ORDER BY faq_id DESC");

        while (list($faq_website, $faq_question, $faq_id) = mysql_fetch_row($result))
        {
            TblMiddle2("$faq_id / $faq_website", "$faq_question", "editfaq&opts=editfaq-$faq_id", "editfaq&opts=deletefaq-$faq_id");
        }

        TblFooter();

        MkTabHeader("$words[AAQ]");
        echo "<table><form name=\"addfaq\" action=\"index.php\" method=\"post\">";

        $query = DBQuery("SELECT website_id, website_name FROM esselbach_st_websites");
        if (mysql_num_rows($query) > 1)
            {

            echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\">$words[WBS]</font></td><td></td><td><face face=\"Arial\" size=\"2\"><select size=\"1\" name=\"website\">";

            echo "<option value=\"0\">$words[ALL]</option>";
            while (list($website_id, $website_name) = mysql_fetch_row($query))
            {
                echo "<option value=\"$website_id\">$website_name</option>";
            }

            echo "</select></font></td></tr>";
        }

        MkOption ("$words[QUE]", "", "newstitle", "");

        echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\">$words[CAT]</font></td><td></td><td><face face=\"Arial\" size=\"2\"><select size=\"1\" name=\"category\">";

        $query = DBQuery("SELECT faqcat_id, faqcat_name FROM esselbach_st_faqcat");
        while (list($faqcat_id, $faqcat_name) = mysql_fetch_row($query))
        {
            echo "<option value=\"$faqcat_id\">$faqcat_name</option>";
        }

        echo "</select></font></td></tr>";

        if ($midas)
        {
            echo "<script type=\"text/javascript\" src=\"wysiwyg/htmlarea3.js\"></script>";
        }
        else
        {
            echo "<script language=\"JavaScript\">
            <!--
            function AutoInsert1(tag) {
            document.addfaq.newstext1.value =
            document.addfaq.newstext1.value + tag;
            }
            function OpenWin() {
            var newWinObj = window.open('index.php?action=showfaqimg','newWin','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=1,copyhistory=0,width=800,height=600')
            }
            //-->
            </script>";

            QuickHTML(1);
        }

        MkArea ("$words[ANS]", "newstext1", "");

        if ($midas)
        {
            MkSelect ("$words[EHT]", "htmlen", "1");
            MkSelect ("$words[EIS]", "iconen", "0");
            MkSelect ("$words[EBC]", "codeen", "0");
        }
        else
        {
            MkSelect ("$words[EHT]", "htmlen", "0");
            MkSelect ("$words[EIS]", "iconen", "1");
            MkSelect ("$words[EBC]", "codeen", "1");
        }

        $query = DBQuery("SELECT * FROM esselbach_st_fields WHERE field_id='3'");
        $field = mysql_fetch_array($query);

        for($i = 1; $i < 21; $i++)
        {
            if ($field['field_enabled'.$i] == 1)
                {
                echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\">".$field['field_extra'.$i].":</font>";
                echo "</td><td></td><td><font face=\"Arial\" size=\"2\"><input name=\"extra$i\" size=\"32\"></font></td></tr>";
            }
            if ($field['field_enabled'.$i] == 2)
                {
                $fieldoptions = explode(",", $field['field_extra'.$i]);
                echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\">$fieldoptions[0]:</font>";
                echo "</td><td></td><td><face face=\"Arial\" size=\"2\"><select size=\"1\" name=\"extra$i\">";
                for($z = 1; $z < count($fieldoptions); $z++)
                {
                    echo "<option value=\"$fieldoptions[$z]\">$fieldoptions[$z]</option>";
                }
                echo "</select></font></td></tr>";
            }
        }

        echo "<input type=\"hidden\" name=\"aform\" value=\"addfaq\"><td><font face=\"Arial\" size=\"2\"><input type=\"submit\" value=\"$words[SND]\"></font></form></td></tr></table>";
        MkTabFooter();

        if ($midas)
        {
            EnableMidas("newstext1");
        }
        else
        {
            MkTabHeader("$words[SRI4]");
            echo "$words[UPV4]";
            MkTabFooter();
        }

        MkFooter();

    }

    //  ##########################################################

    function AdminCatFaq($opts)
    {

        global $words;
        dbconnect();

        $options = explode("-", $opts);
        if ($options[0] == "deletecat")
            {

            if ($options[1] > 1)
                {
                $result = DBQuery("DELETE FROM esselbach_st_faqcat WHERE faqcat_id='$options[1]'");

                MkHeader("_self");
                MkTabHeader ("$words[DO]");
                echo "$words[CSR]";
                MkTabFooter();
                MkFooter();

            }
            else
                {

                MkHeader("_self");
                MkTabHeader ("$words[ERR]");
                echo "$words[ATOC]";
                MkTabFooter();
                MkFooter();
            }

        }

        if ($options[0] == "editcat")
            {

            $result = DBQuery("SELECT * FROM esselbach_st_faqcat WHERE faqcat_id='$options[1]'");
            $cat = mysql_fetch_array($result);

            MkHeader("_self");
            MkTabHeader("$words[EDC]");
            echo "<table><form action=\"index.php\" method=\"post\">";
            MkOption ("$words[CNA]", "", "category", "$cat[faqcat_name]");
            MkOption ("$words[DSC]", "", "categorydsc", "$cat[faqcat_desc]");
            echo "<input type=\"hidden\" name=\"aform\" value=\"editfaqcat\"><input type=\"hidden\" name=\"zid\" value=\"$cat[faqcat_id]\"><td><font face=\"Arial\" size=\"2\"><input type=\"submit\" value=\"$words[SND]\"></font></td></tr></table>";
            MkTabFooter();
            MkFooter();

        }

        MkHeader("_self");
        MkTabHeader("$words[EDC]");
        echo "$words[EDD]";
        MkTabFooter();

        TblHeader("$words[CID]", "$words[CNA]");

        $result = DBQuery("SELECT faqcat_id, faqcat_name FROM esselbach_st_faqcat ORDER BY faqcat_id");

        while (list($faqcat_id, $faqcat_title) = mysql_fetch_row($result))
        {
            TblMiddle("$faqcat_id", "$faqcat_title", "faqcat&opts=editcat-$faqcat_id", "faqcat&opts=deletecat-$faqcat_id");
        }
        TblFooter();

        MkTabHeader("$words[AAC]");
        echo "<table><form action=\"index.php\" method=\"post\">";
        MkOption ("$words[CNA]", "", "category", "");
        MkOption ("$words[DSC]", "", "categorydsc", "");
        echo "<input type=\"hidden\" name=\"aform\" value=\"addfaqcat\"><td><font face=\"Arial\" size=\"2\"><input type=\"submit\" value=\"$words[SND]\"></font></td></tr></table>";
        MkTabFooter();

        MkFooter();

    }

    //  ##########################################################

    function AdminFAQImages ($opts)
    {

        global $words, $admin;

        MkHeader("_self");
        MkTabHeader("$words[SRI4]");
        echo "<form action=\"index.php\" method=\"post\"><font size=\"2\" face=\"Verdana, Arial\">$words[SRC]</font>";
        echo "<input type=\"hidden\" name=\"aform\" value=\"searchfaqimgs\"><input name=\"zid\" size=\"32\"><input type=\"submit\" value=\"$words[SUB]\"></form>";
        echo "<font size=\"2\" face=\"Verdana, Arial\">$words[SID4]</font>";
        MkTabFooter();

        $image_dir = GetDir("../images/faq");

        if (!$opts)
        {
            MkTabHeader("$words[AVAII]");
            $img_array = array("0-9","A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");

            for($z = 0; $z < count($img_array); $z++)
            {
                $images["$img_array[$z]"] = 0;
            }

            for($i = 1; $i < count($image_dir); $i++)
            {
                if (preg_match("/(.gif|.jpeg|.jpg|.png)/i", $image_dir[$i]))
                {
                    for($z = 1; $z < count($img_array); $z++)
                    {
                        if (strtoupper(substr($image_dir[$i],0,1)) == $img_array[$z])
                        {
                            $images["$img_array[$z]"]++;
                        }
                    }
                    if (preg_match("/[0-9]/i",substr($image_dir[$i],0,1)))
                    {
                        $images["0-9"]++;
                    }
                }
            }

            for($z = 0; $z < count($img_array); $z++)
            {
                $timages = $images["$img_array[$z]"];
                echo "<a href=\"index.php?action=showfaqimg&opts=$img_array[$z]\">$words[INDEX] $img_array[$z]</a> ($timages $words[IMAGE]) <br />";
            }
            MkTabFooter();

            if ((phpversion() >= "4.1.0") and ($admin[user_canfaq] == 1))
            {
                MkTabHeader("$words[UPLIM]");
                echo "<form action=\"index.php\" method=\"post\" enctype=\"multipart/form-data\"><font size=\"2\" face=\"Verdana, Arial\">$words[IMF]</font>";
                echo "<input type=\"hidden\" name=\"aform\" value=\"faqimgup\"><input type=\"file\" name=\"faqifile\"><input type=\"submit\" value=\"Upload\"></form>";
                MkTabFooter();
            }

        }
        else
        {

            echo "<br />
                <script language=\"JavaScript\">
                <!--
                function AutoInsert(tag) {
                opener.document.addfaq.newstext1.value =
                opener.document.addfaq.newstext1.value + tag;
                }
                // -->
                </script>";

            for($i = 1; $i < count($image_dir); $i++)
            {
                if (preg_match("/(.gif|.jpeg|.jpg|.png)/i", $image_dir[$i]))
                {
                    if ($opts == "0-9")
                    {
                        if (preg_match("/[0-9]/i",strtoupper(substr($image_dir[$i],0,1))))
                        {
                            MkTabHeader("$image_dir[$i]");
                            echo "<center><img src=\"../images/faq/$image_dir[$i]\" border=\"0\" alt=\"\"><br /><br /><a href=\"javascript:AutoInsert('[img]images/faq/$image_dir[$i][/img]')\">$words[XSI4]</a> | <a href=\"javascript:AutoInsert('[thumb]$image_dir[$i][/thumb]')\">$words[ITHUM]</a></center>";
                            MkTabFooter();
                        }
                    }
                    else
                    {
                        if (strtoupper(substr($image_dir[$i],0,1)) == $opts)
                        {
                            MkTabHeader("$image_dir[$i]");
                            echo "<center><img src=\"../images/faq/$image_dir[$i]\" border=\"0\" alt=\"\"><br /><br /><a href=\"javascript:AutoInsert('[img]images/faq/$image_dir[$i][/img]')\">$words[XSI4]</a>  | <a href=\"javascript:AutoInsert('[thumb]$image_dir[$i][/thumb]')\">$words[ITHUM]</a></center>";
                            MkTabFooter();
                        }
                    }
                }
            }
            echo "<center><font face=\"Arial\" size=\"2\">[<a href=\"index.php?action=showfaqimg\">$words[IMGBA]</a>]</font></center>";

        }
        echo "<center><font face=\"Arial\" size=\"2\">[<a href=\"javascript:self.close()\">$words[XSIC]</a>]</font></center>";
        MkFooter();

    }

    //  ##########################################################

    function AdminFAQImgSearch ()
    {

        global $words, $zid;

        MkHeader("_self");
        MkTabHeader("$words[SRI4]");
        echo "<form action=\"index.php\" method=\"post\"><font size=\"2\" face=\"Verdana, Arial\">$words[SRC]</font>";
        echo "<input type=\"hidden\" name=\"aform\" value=\"searchfaqimgs\"><input name=\"zid\" size=\"32\"><input type=\"submit\" value=\"$words[SUB]\"></form>";
        echo "<font size=\"2\" face=\"Verdana, Arial\">$words[SID4]</font>";
        MkTabFooter();

        $image_dir = GetDir("../images/faq");

        echo "<br />
            <script language=\"JavaScript\">
            <!--
            function AutoInsert(tag) {
            opener.document.addfaq.newstext1.value =
            opener.document.addfaq.newstext1.value + tag;
            }
            // -->
            </script>";

        for($i = 1; $i < count($image_dir); $i++)
        {
            if (preg_match("/(.gif|.jpeg|.jpg|.png)/i", $image_dir[$i]))
            {
                if (preg_match("/$zid/i",$image_dir[$i]))
                {
                    MkTabHeader("$image_dir[$i]");
                    echo "<center><img src=\"../images/faq/$image_dir[$i]\" border=\"0\" alt=\"\"><br /><br /><a href=\"javascript:AutoInsert('[img]images/faq/$image_dir[$i][/img]')\">$words[XSI4]</a> | <a href=\"javascript:AutoInsert('[thumb]$image_dir[$i][/thumb]')\">$words[ITHUM]</a></center>";
                    MkTabFooter();
                }
            }
        }
        echo "<center><font face=\"Arial\" size=\"2\">[<a href=\"index.php?action=showfaqimg\">$words[IMGBA]</a>]</font></center>";
        echo "<center><font face=\"Arial\" size=\"2\">[<a href=\"javascript:self.close()\">$words[XSIC]</a>]</font></center>";
        MkFooter();

    }

    //  ##########################################################

    function FAQImgUp ()
    {

        global $words;

        if (phpversion() >= "4.1.0")
        {
            $upfile = strtolower($_FILES[faqifile][name]);
            if (!preg_match("/(.gif|.jpg|.jpeg|.png)/i", substr($upfile,-4)))
            {
                MkHeader("_self");
                MkTabHeader ("$words[ERR]");
                echo $words[IA];
                MkTabFooter();
                echo "<center><font face=\"Arial\" size=\"2\">[<a href=\"index.php?action=showfaqimg\">$words[IMGBA]</a>]</font></center>";
                echo "<center><font face=\"Arial\" size=\"2\">[<a href=\"javascript:self.close()\">$words[XSIC]</a>]</font></center>";
                MkFooter();
            }
            if ($_FILES[faqifile][size] > 250000)
            {
                MkHeader("_self");
                MkTabHeader ("$words[ERR]");
                echo $words[WB];
                MkTabFooter();
                echo "<center><font face=\"Arial\" size=\"2\">[<a href=\"index.php?action=showfaqimg\">$words[IMGBA]</a>]</font></center>";
                echo "<center><font face=\"Arial\" size=\"2\">[<a href=\"javascript:self.close()\">$words[XSIC]</a>]</font></center>";
                MkFooter();
            }
            if (move_uploaded_file($_FILES[faqifile][tmp_name], "../images/faq/".$upfile))
            {
                @chmod ("../images/faq/$upfile", 0777);
                MkHeader("_self");
                MkTabHeader ("$words[DO]");
                echo $words[IS];
                MkTabFooter();
                echo "<center><font face=\"Arial\" size=\"2\">[<a href=\"index.php?action=showfaqimg\">$words[IMGBA]</a>]</font></center>";
                echo "<center><font face=\"Arial\" size=\"2\">[<a href=\"javascript:self.close()\">$words[XSIC]</a>]</font></center>";
                MkFooter();
            }
            else
            {
                MkHeader("_self");
                MkTabHeader ("$words[ERR]");
                echo $words[UF];
                MkTabFooter();
                echo "<center><font face=\"Arial\" size=\"2\">[<a href=\"javascript:self.close()\">$words[XSIC]</a>]</font></center>";
                MkFooter();
            }
        }
        else
        {
            MkHeader("_self");
            MkTabHeader ("$words[ERR]");
            echo $words[PHP];
            MkTabFooter();
            echo "<center><font face=\"Arial\" size=\"2\">[<a href=\"javascript:self.close()\">$words[XSIC]</a>]</font></center>";
            MkFooter();
        }
    }

    //  ##########################################################

    function DoFAQEdit ()
    {

        global $words, $zid, $newstitle, $website, $category, $newstext1, $extra1, $extra2, $extra3, $extra4, $extra5, $extra6, $extra7, $extra8, $extra9, $extra10, $extra11, $extra12, $extra13, $extra14, $extra15, $extra16, $extra17, $extra18, $extra19, $extra20, $htmlen, $iconen, $codeen, $ipaddr;

        if ($admin[user_canfaq] == 2)
            {
            $result = DBQuery("SELECT faq_author FROM esselbach_st_faq WHERE faq_id = '$zid'");
            list($faqauthor) = mysql_fetch_row($result);

            if ($faqauthor != $admin[user_name])
                {
                MkHeader("_self");
                MkTabHeader ("$words[ERR]");
                echo "$words[RFAQS]";
                MkTabFooter();
                MkFooter();
            }
        }

        DBQuery("UPDATE esselbach_st_faq SET faq_question='$newstitle', faq_website='$website', faq_category='$category', faq_answer_text='$newstext1', faq_extra1='$extra1',
            faq_extra2='$extra2', faq_extra3='$extra3', faq_extra4='$extra4', faq_extra5='$extra5', faq_extra6='$extra6', faq_extra7='$extra7', faq_extra8='$extra8', faq_extra9='$extra9',
            faq_extra10='$extra10', faq_extra11='$extra11', faq_extra12='$extra12', faq_extra13='$extra13', faq_extra14='$extra14', faq_extra15='$extra15', faq_extra16='$extra16', faq_extra17='$extra17',
            faq_extra18='$extra18', faq_extra19='$extra19', faq_extra20='$extra20', faq_html='$htmlen', faq_icon='$iconen', faq_code='$codeen', faq_editip='$ipaddr' WHERE faq_id='$zid'");

        UpdateIndex ($zid, $website, 3, $newstitle, $newstext1);

        RemoveCache ("faq/faqshow-$zid");
        RemoveCache ("faq/faq-$category");
        RemoveCache ("faq/faq");
        RemoveCache ("xml/xmlnews-100");
        RemoveCache ("tags/faq-$zid");

        MkHeader("_self");
        MkTabHeader ("$words[DO]");
        echo $words[FC];
        MkTabFooter();
        MkFooter();

    }

    //  ##########################################################

    function AddFAQ ()
    {

        global $words, $website, $category, $admin, $newstitle, $newstext1, $extra1, $extra2, $extra3, $extra4, $extra5, $extra6, $extra7, $extra8, $extra9, $extra10, $extra11, $extra12, $extra13, $extra14, $extra15, $extra16, $extra17, $extra18, $extra19, $extra20, $htmlen, $iconen, $codeen, $ipaddr;

        DBQuery("INSERT INTO esselbach_st_faq VALUES (NULL, '$website', '$category', '$admin[user_name]', '$newstitle', '$newstext1', '$extra1', '$extra2', '$extra3', '$extra4', '$extra5', '$extra6', '$extra7', '$extra8', '$extra9', '$extra10', '$extra11', '$extra12', '$extra13', '$extra14', '$extra15', '$extra16', '$extra17', '$extra18', '$extra19', '$extra20', '$htmlen', '$iconen', '$codeen', '$ipaddr', '$ipaddr')");
        $result = DBQuery("SELECT faq_id FROM esselbach_st_faq ORDER BY faq_id DESC LIMIT 1");
        list($id) = mysql_fetch_row($result);
        AddIndex ($id, $website, 3, $admin[user_name], $newstitle, $newstext1, "");

        RemoveCache ("faq/faq-$category");
        RemoveCache ("faq/faq");
        RemoveCache ("xml/xmlnews-100");
        RemoveCache ("xml/xmlhelp");

        MkHeader("_self");
        MkTabHeader ("$words[DO]");
        echo $words[FA];
        MkTabFooter();
        MkFooter();

    }

    //  ##########################################################

    function AddFAQCat ()
    {

        global $words, $category, $categorydsc;

        DBQuery("INSERT INTO esselbach_st_faqcat VALUES (NULL, '$category', '$categorydsc')");

        MkHeader("_self");
        MkTabHeader ("$words[DO]");
        echo $words[CA];
        MkTabFooter();
        MkFooter();

    }

    //  ##########################################################

    function EditFAQCat ()
    {

        global $words, $category, $categorydsc, $zid;

        DBQuery("UPDATE esselbach_st_faqcat SET faqcat_name='$category', faqcat_desc='$categorydsc' WHERE faqcat_id = '$zid'");

        MkHeader("_self");
        MkTabHeader ("$words[DO]");
        echo $words[CU];
        MkTabFooter();
        MkFooter();
    }

    //  ##########################################################

    function AdminRFAQQueue()
    {

        global $words;
        dbconnect();

        DBQuery("DELETE FROM esselbach_st_faqqueue");

        MkHeader("_self");
        MkTabHeader ("$words[DO]");
        echo "$words[QED]";
        MkTabFooter();
        MkFooter();

    }

    //  ##########################################################

    function AdminFAQQueue($opts)
    {

        global $words;
        dbconnect();

        $options = explode("-", $opts);
        if ($options[0] == "deleteqquestion")
            {

            $result = DBQuery("DELETE FROM esselbach_st_faqqueue WHERE faqq_id='$options[1]'");

            MkHeader("_self");
            MkTabHeader ("$words[DO]");
            echo "$words[QSR]";
            MkTabFooter();
            MkFooter();

        }

        if ($options[0] == "addqquestion")
        {

            $result = DBQuery("SELECT * FROM esselbach_st_faqqueue WHERE faqq_id='$options[1]'");
            $faqdata = mysql_fetch_array($result);

            if ($faqdata[faqq_authormail])
            {
                $amail = "<a href=\"mailto:$faqdata[faqq_authormail]\"><img src=\"../images/email.png\" border=\"0\"></a>";
            }

            MkHeader("_self");
            MkTabHeader("$words[AAQ]");
            echo "<table><form name=\"addfaq\" action=\"index.php\" method=\"post\">";
            echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\">$words[SMY]</font></td><td></td><td><font face=\"Arial\" size=\"2\">$faqdata[faqq_author] $amail ($words[TIP] $faqdata[faqq_authorip]) $faqdata[faqq_time]</font></td></tr>";

            $query = DBQuery("SELECT website_id, website_name FROM esselbach_st_websites");
            if (mysql_num_rows($query) > 1)
                {

                echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\">$words[WBS]</font></td><td></td><td><face face=\"Arial\" size=\"2\"><select size=\"1\" name=\"website\">";

                echo "<option value=\"0\">$words[ALL]</option>";
                while (list($website_id, $website_name) = mysql_fetch_row($query))
                {
                    echo "<option value=\"$website_id\">$website_name</option>";
                }

                echo "</select></font></td></tr>";
            }

            MkOption ("$words[QUE]", "", "newstitle", "$faqdata[faqq_question]");

            echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\">$words[CAT]</font></td><td></td><td><face face=\"Arial\" size=\"2\"><select size=\"1\" name=\"category\">";

            $query = DBQuery("SELECT faqcat_id, faqcat_name FROM esselbach_st_faqcat");
            while (list($faqcat_id, $faqcat_name) = mysql_fetch_row($query))
            {
                echo "<option value=\"$faqcat_id\">$faqcat_name</option>";
            }

            echo "</select></font></td></tr>";

            echo "<script language=\"JavaScript\">
                <!--
                function AutoInsert1(tag) {
                document.addfaq.newstext1.value =
                document.addfaq.newstext1.value + tag;
                }
                function OpenWin() {
                var newWinObj = window.open('index.php?action=showfaqimg','newWin','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=1,copyhistory=0,width=800,height=600')
                }
                //-->
                </script>";

            QuickHTML(1);

            MkArea ("$words[ANS]", "newstext1", "");

            MkSelect ("$words[EHT]", "htmlen", "0");
            MkSelect ("$words[EIS]", "iconen", "1");
            MkSelect ("$words[EBC]", "codeen", "1");

            $query = DBQuery("SELECT * FROM esselbach_st_fields WHERE field_id='3'");
            $field = mysql_fetch_array($query);

            for($i = 1; $i < 21; $i++)
            {
                if ($field['field_enabled'.$i] == 1)
                    {
                    echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\">".$field['field_extra'.$i].":</font>";
                    echo "</td><td></td><td><font face=\"Arial\" size=\"2\"><input name=\"extra$i\" size=\"32\"></font></td></tr>";
                }
                if ($field['field_enabled'.$i] == 2)
                    {
                    $fieldoptions = explode(",", $field['field_extra'.$i]);
                    echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\">$fieldoptions[0]:</font>";
                    echo "</td><td></td><td><face face=\"Arial\" size=\"2\"><select size=\"1\" name=\"extra$i\">";
                    for($z = 1; $z < count($fieldoptions); $z++)
                    {
                        echo "<option value=\"$fieldoptions[$z]\">$fieldoptions[$z]</option>";
                    }
                    echo "</select></font></td></tr>";
                }
            }

            echo "<input type=\"hidden\" name=\"aform\" value=\"addfaq\"><td><font face=\"Arial\" size=\"2\"><input type=\"submit\" value=\"$words[SND]\"></font></form></td></tr></table>";
            MkTabFooter();

            MkTabHeader("$words[SRI4]");
            echo "$words[UPV4]";
            MkTabFooter();

            MkFooter();
        }

        MkHeader("_self");
        MkTabHeader("$words[FAQQR] <a href=\"index.php?action=removefqueue\"><img src=\"../images/delete.png\" border=\"0\" alt=\"$words[DSFFQ]\"></a>");
        echo "$words[DQIR3]";
        MkTabFooter();

        TblHeader("$words[FAQSI]", "$words[QUE]");

               $result = DBQuery("SELECT faqq_website, faqq_question, faqq_id FROM esselbach_st_faqqueue ORDER BY faqq_id DESC LIMIT 100");

        while (list($faq_website, $faq_question, $faq_id) = mysql_fetch_row($result))
        {
                          TblMiddle("$faq_id / $faq_website","$faq_question","faqqueue&opts=addqquestion-$faq_id","faqqueue&opts=deleteqquestion-$faq_id");
        }

        MkFooter();

    }

    //  ##########################################################

    function AdminSearchFAQ()
    {

        global $words;

        MkHeader("_self");
        MkTabHeader("$words[NEWFQ]");
        echo "<form action=\"index.php\" method=\"post\"><font size=\"2\" face=\"Verdana, Arial\">$words[FOS]</font><br />";
        echo "<input type=\"hidden\" name=\"aform\" value=\"searchreplacefaq\"><textarea cols=\"100%\" name=\"zid\" rows=\"2\"></textarea><br />";
        echo "$words[INFLD] <select size=\"1\" name=\"extra2\"><option value=\"question\">question</option><option value=\"answer_text\">answer_text</option>";
        for($i = 1; $i < 21; $i++)
        {
            echo "<option value=\"extra".$i."\">extra".$i."</option>";
        }
        echo "</select> ";
        echo "$words[AREP]</font><textarea cols=\"100%\" name=\"extra1\" rows=\"2\"></textarea><br /><input type=\"submit\" value=\"$words[SUB]\"></form>";
        MkTabFooter();
        MkFooter();
    }

   //  ##########################################################

    function FAQSearchReplace ()
    {

        global $words, $zid, $extra1, $extra2, $ipaddr;

        MkHeader("_self");
        MkTabHeader ("$words[DO]");

        $search_field = "faq_".$extra2;
        $query = DBQuery("SELECT * FROM esselbach_st_faq WHERE ($search_field LIKE '%$zid%')");

        $totalrows = 0;
        while ($rows = mysql_fetch_array($query))
        {
            $out_field = str_replace("$zid", "$extra1", $rows[$search_field]);
            DBQuery("UPDATE esselbach_st_faq SET $search_field = '$out_field', faq_editip = '$ipaddr' WHERE faq_id = '$rows[faq_id]'");
            $totalrows++;
        }

        echo $totalrows." ".$words[ENTCH];

        ClearCache("news");
        ClearCache("faq");
        ClearCache("tags");

        MkTabFooter();
        MkFooter();

    }

?>
