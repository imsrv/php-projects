<?php

    /*
    ########################
    # |//////////////////| #
    # NULLED by [GTT] =)   #
    # |\\\\\\\\\\\\\\\\\\| #
    ########################
    */

    function AdminCatReview($opts)
    {

        global $words;
        dbconnect();

        $options = explode("-", $opts);
        if ($options[0] == "deletecat")
        {

            if ($options[1] > 1)
            {
                $result = DBQuery("DELETE FROM esselbach_st_reviewcat WHERE reviewcat_id='$options[1]'");

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

            $result = DBQuery("SELECT * FROM esselbach_st_reviewcat WHERE reviewcat_id='$options[1]'");
            $cat = mysql_fetch_array($result);

            MkHeader("_self");
            MkTabHeader("$words[EDC]");
            echo "<table><form action=\"index.php\" method=\"post\">";
            MkOption ("$words[CNA]", "", "category", "$cat[reviewcat_name]");
            MkOption ("$words[DSC]", "", "categorydsc", "$cat[reviewcat_desc]");
            echo "<input type=\"hidden\" name=\"aform\" value=\"editreviewcat\"><input type=\"hidden\" name=\"zid\" value=\"$cat[reviewcat_id]\"><td><font face=\"Arial\" size=\"2\"><input type=\"submit\" value=\"$words[SND]\"></font></td></tr></table>";
            MkTabFooter();
            MkFooter();

        }

        MkHeader("_self");
        MkTabHeader("$words[EDC]");
        echo "$words[EDD]";
        MkTabFooter();

        TblHeader("$words[CID]", "$words[CNA]");

        $result = DBQuery("SELECT reviewcat_id, reviewcat_name FROM esselbach_st_reviewcat ORDER BY reviewcat_id");

        while (list($category_id, $category_title) = mysql_fetch_row($result))
        {
            TblMiddle("$category_id", "$category_title", "reviewcat&opts=editcat-$category_id", "reviewcat&opts=deletecat-$category_id");

        }

        TblFooter();

        MkTabHeader("$words[AAC]");
        echo "<table><form action=\"index.php\" method=\"post\">";
        MkOption ("$words[CET]", "", "category", "");
        MkOption ("$words[DSC]", "", "categorydsc", "");
        echo "<input type=\"hidden\" name=\"aform\" value=\"addreviewcat\"><td><font face=\"Arial\" size=\"2\"><input type=\"submit\" value=\"$words[SND]\"></font></td></tr></table>";
        MkTabFooter();

        MkFooter();

    }


    //  ##########################################################

    function AdminEditReview($opts)
    {

        global $words, $admin, $midas;
        dbconnect();

        $options = explode("-", $opts);

        if (($options[0]) and ($admin[user_canreview] == 2))
        {
            $result = DBQuery("SELECT review_poster FROM esselbach_st_review WHERE reviewpage_id = '$options[1]'");
            list($reviewposter) = mysql_fetch_row($result);

            if ($reviewposter != $admin[user_name])
            {
                MkHeader("_self");
                MkTabHeader ("$words[ERR]");
                echo "$words[RREVI]";
                MkTabFooter();
                MkFooter();
            }
        }

        if ($options[0] == "deletereview")
        {

            $result = DBQuery("SELECT review_page, review_id FROM esselbach_st_review WHERE reviewpage_id='$options[1]'");
            list($review_page, $review_id) = mysql_fetch_row ($result);

            $query = DBQuery("SELECT * FROM esselbach_st_review WHERE review_id = '$review_id'");
            $rpages = mysql_num_rows($query);
            if ($rpages > $review_page)
            {

                MkHeader("_self");
                MkTabHeader ("$words[ERR]");
                echo "$words[ATOR]";
                MkTabFooter();
                MkFooter();

            }
            else
            {

                for($z = 1; $z < $rpages; $z++)
                {
                    RemoveCache ("reviews/review-$review_id-$z");
                    RemoveCache ("reviews/reviewp-$review_id-$z");
                }
                RemoveCache ("tags/review-$review_id");
                RemoveCache ("xml/xmlnews-110");
                RemoveCache ("xml/xmlhelp");

                $result = DBQuery("DELETE FROM esselbach_st_review WHERE reviewpage_id='$options[1]'");
                if ($options[1] == 1) RemoveIndex ($review_id, 2);

                MkHeader("_self");
                MkTabHeader ("$words[DO]");
                echo "$words[RPR]";
                MkTabFooter();
                MkFooter();
            }
        }

        if ($options[0] == "editreview")
        {

            $result = DBQuery("SELECT * FROM esselbach_st_review WHERE reviewpage_id='$options[1]'");
            $review = mysql_fetch_array($result);

            MkHeader("_self");
            MkTabHeader("$words[ERE] $options[1]");

            echo "<table><form name=\"review\" action=\"index.php\" method=\"post\">";

            $query = DBQuery("SELECT website_id, website_name FROM esselbach_st_websites");
            if (mysql_num_rows($query) > 1)
            {

                echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\">$words[WBS]</font></td><td></td><td><face face=\"Arial\" size=\"2\"><select size=\"1\" name=\"website\">";

                echo "<option value=\"0\">$words[ALL]</option>";
                while (list($website_id, $website_name) = mysql_fetch_row($query))
                {
                    ($website_id == $review['review_website']) ? $select = "selected" :
                    $select = "";
                    echo "<option $select value=\"$website_id\">$website_name</option>";
                }

                echo "</select></font></td></tr>";
            }

            $review[review_title] = ReChomp($review[review_title]);
            $review[review_author] = ReChomp($review[review_author]);
            $review[review_text] = ReChomp($review[review_text]);
            $review[review_pagesub] = ReChomp($review[review_pagesub]);

            MkOption ("$words[RTI]", "", "newstitle", "$review[review_title]");
            MkSelect ("$words[PUBLI]", "extrag13", "$review[review_hook]");

            echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\">$words[CAT]</font></td><td></td><td><face face=\"Arial\" size=\"2\"><select size=\"1\" name=\"category\">";

            $query = DBQuery("SELECT reviewcat_id, reviewcat_name FROM esselbach_st_reviewcat");
            while (list($reviewcat_id, $reviewcat_name) = mysql_fetch_row($query))
            {
                ($reviewcat_id == $review['review_category']) ? $select = "selected" :
                $select = "";
                echo "<option $select value=\"$reviewcat_id\">$reviewcat_name</option>";
            }

            echo "</select></font></td></tr>";

            MkOption ("$words[AUT]", "", "extra2", "$review[review_author]");
            MkOption ("$words[RESU]", "", "extra3", "$review[review_pagesub]");

            if ($midas)
            {
                echo "<script type=\"text/javascript\" src=\"wysiwyg/htmlarea3.js\"></script>";
            }
            else
            {
                echo "<script language=\"JavaScript\">
                <!--
                function AutoInsert1(tag) {
                document.review.newstext1.value =
                document.review.newstext1.value + tag;
                }
                function OpenWin() {
                var newWinObj = window.open('index.php?action=showreviewimg','newWin','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=1,copyhistory=0,width=800,height=600')
                }
                //-->
                </script>";

                QuickHTML(1);
            }

            MkArea ("$words[RTX]", "newstext1", "$review[review_text]");

            MkSelect ("$words[EHT]", "htmlen", "$review[review_html]");
            MkSelect ("$words[EIS]", "iconen", "$review[review_icon]");
            MkSelect ("$words[EBC]", "codeen", "$review[review_code]");

            $query = DBQuery("SELECT * FROM esselbach_st_fields WHERE field_id='4'");
            $field = mysql_fetch_array($query);

            for($i = 1; $i < 21; $i++)
            {
                if ($field['field_enabled'.$i] == 1)
                {
                    echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\">".$field['field_extra'.$i].":</font>";
                    echo "</td><td></td><td><font face=\"Arial\" size=\"2\"><input name=\"extrae$i\" size=\"32\" value=\"".$review['review_extra'.$i]."\"></font></td></tr>";
                }
                if ($field['field_enabled'.$i] == 2)
                {
                    $fieldoptions = explode(",", $field['field_extra'.$i]);
                    echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\">$fieldoptions[0]:</font>";
                    echo "</td><td></td><td><face face=\"Arial\" size=\"2\"><select size=\"1\" name=\"extrae$i\">";
                    for($z = 1; $z < count($fieldoptions); $z++)
                    {
                        ($fieldoptions[$z] == $review['review_extra'.$i]) ? $select = "selected" :
                        $select = "";
                        echo "<option $select value=\"$fieldoptions[$z]\">$fieldoptions[$z]</option>";
                    }
                    echo "</select></font></td></tr>";
                }
            }

            echo "<input type=\"hidden\" name=\"aform\" value=\"reviewedit\"><input type=\"hidden\" name=\"extra1\" value=\"$review[review_id]\"><input type=\"hidden\" name=\"zid\" value=\"$review[reviewpage_id]\"><td><font face=\"Arial\" size=\"2\"><input type=\"submit\" value=\"$words[SND]\"></form></font></td></tr></table>";
            MkTabFooter();

        if ($midas)
        {
            EnableMidas("newstext1");
        }
        else
        {
            MkTabHeader("$words[SRI]");
            echo "$words[UPV]";
            MkTabFooter();
        }

            MkFooter();
        }

        MkHeader("_self");
        MkTabHeader("$words[ERP]");
        echo "<form action=\"index.php\" method=\"post\"><font size=\"2\" face=\"Verdana, Arial\">$words[SRC]</font>";
        echo "<input type=\"hidden\" name=\"aform\" value=\"searchreviews\"><input name=\"zid\" size=\"32\"><input type=\"submit\" value=\"$words[SUB]\"></form>";
        MkTabFooter();

        TblHeader("$words[PSI]", "$words[RTP]");

        $result = DBQuery("SELECT review_website, review_title, reviewpage_id, review_page, review_hook FROM esselbach_st_review ORDER BY reviewpage_id DESC LIMIT 100");

        while (list($review_website, $review_title, $reviewpage_id, $review_page, $review_hook) = mysql_fetch_row($result))
        {
            if ($review_hook)
            {
                $review_title = "<font color=\"red\">$review_title</font>";
            }
            TblMiddle2("$reviewpage_id / $review_website", "$review_title ($review_page)", "editreview&opts=editreview-$reviewpage_id", "editreview&opts=deletereview-$reviewpage_id");
        }

        MkFooter();

    }

    //  ##########################################################

    function AdminAddReview()
    {

        global $words, $admin, $midas;
        dbconnect();

        MkHeader("_self");
        MkTabHeader ("$words[ARP]");

        echo "<table><form name=\"review\" action=\"index.php\" method=\"post\">";

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

        MkOption ("$words[RTI]", "", "newstitle", "");
        MkSelect ("$words[PUBLI]", "extrag13", "0");

        echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\">$words[APT]</font></td><td></td><td><face face=\"Arial\" size=\"2\"><select size=\"4\" name=\"extra1\">";
        echo "<option selected value=\"0\">$words[NRE]</option>";

        $query = DBQuery("SELECT review_id, review_title FROM esselbach_st_review WHERE review_page = '1'");
        while (list($review_id, $review_title) = mysql_fetch_row($query))
        {
            echo "<option value=\"$review_id\">$words[ABT] $review_title</option>";
        }

        echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\">$words[CAT]</font></td><td></td><td><face face=\"Arial\" size=\"2\"><select size=\"1\" name=\"category\">";

        $query = DBQuery("SELECT reviewcat_id, reviewcat_name FROM esselbach_st_reviewcat");
        while (list($reviewcat_id, $reviewcat_name) = mysql_fetch_row($query))
        {
            echo "<option value=\"$reviewcat_id\">$reviewcat_name</option>";
        }

        echo "</select></font></td></tr>";

        MkOption ("$words[AUT]", "", "extra2", "");
        MkOption ("$words[RESU]", "", "extra3", "");

        if ($midas)
        {
            echo "<script type=\"text/javascript\" src=\"wysiwyg/htmlarea3.js\"></script>";
        }
        else
        {
            echo "<script language=\"JavaScript\">
            <!--
            function AutoInsert1(tag) {
            document.review.newstext1.value =
            document.review.newstext1.value + tag;
            }
            function OpenWin() {
            var newWinObj = window.open('index.php?action=showreviewimg','newWin','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=1,copyhistory=0,width=800,height=600')
            }
            //-->
            </script>";

            QuickHTML(1);
        }

        MkArea ("$words[RTX]", "newstext1", "");

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

        $query = DBQuery("SELECT * FROM esselbach_st_fields WHERE field_id='4'");
        $field = mysql_fetch_array($query);

        for($i = 1; $i < 21; $i++)
        {
            if ($field['field_enabled'.$i] == 1)
            {
                echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\">".$field['field_extra'.$i].":</font>";
                echo "</td><td></td><td><font face=\"Arial\" size=\"2\"><input name=\"extrae$i\" size=\"32\"></font></td></tr>";
            }
            if ($field['field_enabled'.$i] == 2)
            {
                $fieldoptions = explode(",", $field['field_extra'.$i]);
                echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\">$fieldoptions[0]:</font>";
                echo "</td><td></td><td><face face=\"Arial\" size=\"2\"><select size=\"1\" name=\"extrae$i\">";
                for($z = 1; $z < count($fieldoptions); $z++)
                {
                    echo "<option value=\"$fieldoptions[$z]\">$fieldoptions[$z]</option>";
                }
                echo "</select></font></td></tr>";
            }
        }

        echo "<input type=\"hidden\" name=\"aform\" value=\"doaddreview\"><td><font face=\"Arial\" size=\"2\"><input type=\"submit\" value=\"$words[SUB]\"></form></font></td></tr></table>";

        MkTabFooter();

        if ($midas)
        {
            EnableMidas("newstext1");
        }
        else
        {
            MkTabHeader("$words[SRI]");
            echo "$words[UPV]";
            MkTabFooter();
        }

        MkFooter();
    }

    //  ##########################################################

    function AdminQuickReview()
    {

        global $words, $admin;
        dbconnect();

        MkHeader("_self");
        MkTabHeader ("$words[ADDQR]");

        echo "<table><form name=\"review\" action=\"index.php\" method=\"post\">";

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

        MkOption ("$words[RTI]", "", "newstitle", "");
        MkSelect ("$words[PUBLI]", "extrag13", "0");

        echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\">$words[CAT]</font></td><td></td><td><face face=\"Arial\" size=\"2\"><select size=\"1\" name=\"category\">";

        $query = DBQuery("SELECT reviewcat_id, reviewcat_name FROM esselbach_st_reviewcat");
        while (list($reviewcat_id, $reviewcat_name) = mysql_fetch_row($query))
        {
            echo "<option value=\"$reviewcat_id\">$reviewcat_name</option>";
        }

        echo "</select></font></td></tr>";

        MkOption ("$words[AUT]", "", "extra2", "");

        echo "<script language=\"JavaScript\">
            <!--
            function AutoInsert1(tag) {
            document.review.newstext1.value =
            document.review.newstext1.value + tag;
            }
            function OpenWin() {
            var newWinObj = window.open('index.php?action=showreviewimg','newWin','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=1,copyhistory=0,width=800,height=600')
            }
            // -->
            </script>";

        QuickHTML(1);

        MkArea ("$words[RTX]", "newstext1", "");
        echo "<tr><td></td><td></td><td><font face=\"Arial\" size=\"2\"><center><a href=\"javascript:AutoInsert1('[NEWPAGE]')\">$words[NEWPA]</a></center></font></td></tr>";

        MkSelect ("$words[EHT]", "htmlen", "0");
        MkSelect ("$words[EIS]", "iconen", "1");
        MkSelect ("$words[EBC]", "codeen", "1");

        $query = DBQuery("SELECT * FROM esselbach_st_fields WHERE field_id='4'");
        $field = mysql_fetch_array($query);

        for($i = 1; $i < 21; $i++)
        {
            if ($field['field_enabled'.$i] == 1)
            {
                echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\">".$field['field_extra'.$i].":</font>";
                echo "</td><td></td><td><font face=\"Arial\" size=\"2\"><input name=\"extrae$i\" size=\"32\"></font></td></tr>";
            }
            if ($field['field_enabled'.$i] == 2)
            {
                $fieldoptions = explode(",", $field['field_extra'.$i]);
                echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\">$fieldoptions[0]:</font>";
                echo "</td><td></td><td><face face=\"Arial\" size=\"2\"><select size=\"1\" name=\"extrae$i\">";
                for($z = 1; $z < count($fieldoptions); $z++)
                {
                    echo "<option value=\"$fieldoptions[$z]\">$fieldoptions[$z]</option>";
                }
                echo "</select></font></td></tr>";
            }
        }


        echo "<input type=\"hidden\" name=\"aform\" value=\"doqreview\"><td><font face=\"Arial\" size=\"2\"><input type=\"submit\" value=\"$words[SUB]\"></form></font></td></tr></table>";

        MkTabFooter();

        MkTabHeader("$words[URP]");
        echo "$words[UPV]";
        MkTabFooter();

        MkFooter();
    }

    //  ##########################################################

    function AdminReviewImages ($opts)
    {
        global $words, $admin;

        MkHeader("_self");
        MkTabHeader("$words[SRI]");
        echo "<form action=\"index.php\" method=\"post\"><font size=\"2\" face=\"Verdana, Arial\">$words[SRC]</font>";
        echo "<input type=\"hidden\" name=\"aform\" value=\"searchreviewimgs\"><input name=\"zid\" size=\"32\"><input type=\"submit\" value=\"$words[SUB]\"></form>";
        echo "<font size=\"2\" face=\"Verdana, Arial\">$words[SID]</font>";
        MkTabFooter();

        $image_dir = GetDir("../images/review");

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
                echo "<a href=\"index.php?action=showreviewimg&opts=$img_array[$z]\">$words[INDEX] $img_array[$z]</a> ($timages $words[IMAGE]) <br />";
            }
            MkTabFooter();

            if ((phpversion() >= "4.1.0") and ($admin[user_canreview] == 1))
            {
                MkTabHeader("$words[UPLIM]");
                echo "<form action=\"index.php\" method=\"post\" enctype=\"multipart/form-data\"><font size=\"2\" face=\"Verdana, Arial\">$words[IMF]</font>";
                echo "<input type=\"hidden\" name=\"aform\" value=\"reviewimgup\"><input type=\"file\" name=\"reviewifile\"><input type=\"submit\" value=\"Upload\"></form>";
                MkTabFooter();
            }

        }
        else
        {

            echo "<br />
                <script language=\"JavaScript\">
                <!--
                function AutoInsert(tag) {
                opener.document.review.newstext1.value =
                opener.document.review.newstext1.value + tag;
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
                            echo "<center><img src=\"../images/review/$image_dir[$i]\" border=\"0\" alt=\"\"><br /><br /><a href=\"javascript:AutoInsert('[img]images/review/$image_dir[$i][/img]')\">$words[XSI1]</a> | <a href=\"javascript:AutoInsert('[thumb]$image_dir[$i][/thumb]')\">$words[ITHUM]</a></center>";
                            MkTabFooter();
                        }
                    }
                    else
                    {
                        if (strtoupper(substr($image_dir[$i],0,1)) == $opts)
                        {
                            MkTabHeader("$image_dir[$i]");
                            echo "<center><img src=\"../images/review/$image_dir[$i]\" border=\"0\" alt=\"\"><br /><br /><a href=\"javascript:AutoInsert('[img]images/review/$image_dir[$i][/img]')\">$words[XSI1]</a> | <a href=\"javascript:AutoInsert('[thumb]$image_dir[$i][/thumb]')\">$words[ITHUM]</a></center>";
                            MkTabFooter();
                        }
                    }
                }
            }
            echo "<center><font face=\"Arial\" size=\"2\">[<a href=\"index.php?action=showreviewimg\">$words[IMGBA]</a>]</font></center>";

        }
        echo "<center><font face=\"Arial\" size=\"2\">[<a href=\"javascript:self.close()\">$words[XSIC]</a>]</font></center>";
        MkFooter();

    }

    //  ##########################################################

    function AdminReviewImgSearch ()
    {

        global $words, $zid;

        MkHeader("_self");
        MkTabHeader("$words[SRI]");
        echo "<form action=\"index.php\" method=\"post\"><font size=\"2\" face=\"Verdana, Arial\">$words[SRC]</font>";
        echo "<input type=\"hidden\" name=\"aform\" value=\"searchreviewimgs\"><input name=\"zid\" size=\"32\"><input type=\"submit\" value=\"$words[SUB]\"></form>";
        echo "<font size=\"2\" face=\"Verdana, Arial\">$words[SID]</font>";
        MkTabFooter();

        $image_dir = GetDir("../images/review");

        echo "<br />
            <script language=\"JavaScript\">
            <!--
            function AutoInsert(tag) {
            opener.document.review.newstext1.value =
            opener.document.review.newstext1.value + tag;
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
                    echo "<center><img src=\"../images/review/$image_dir[$i]\" border=\"0\" alt=\"\"><br /><br /><a href=\"javascript:AutoInsert('[img]images/review/$image_dir[$i][/img]')\">$words[XSI1]</a> | <a href=\"javascript:AutoInsert('[thumb]$image_dir[$i][/thumb]')\">$words[ITHUM]</a></center>";
                    MkTabFooter();
                }
            }
        }
        echo "<center><font face=\"Arial\" size=\"2\">[<a href=\"index.php?action=showreviewimg\">$words[IMGBA]</a>]</font></center>";
        echo "<center><font face=\"Arial\" size=\"2\">[<a href=\"javascript:self.close()\">$words[XSIC]</a>]</font></center>";
        MkFooter();

    }

    //  ##########################################################

    function AddReviewCat ()
    {

        global $words, $category, $categorydsc;

        DBQuery("INSERT INTO esselbach_st_reviewcat VALUES (NULL, '$category', '$categorydsc')");

        MkHeader("_self");
        MkTabHeader ("$words[DO]");
        echo $words[CA];
        MkTabFooter();
        MkFooter();

    }

    //  ##########################################################

    function EditReviewCat ()
    {

        global $words, $category, $categorydsc, $zid;

        DBQuery("UPDATE esselbach_st_reviewcat SET reviewcat_name='$category', reviewcat_desc='$categorydsc' WHERE reviewcat_id = '$zid'");

        MkHeader("_self");
        MkTabHeader ("$words[DO]");
        echo $words[CU];
        MkTabFooter();
        MkFooter();
    }

    //  ##########################################################

    function ReviewEdit ()
    {

        global $words, $admin, $zid, $newstitle, $website, $category, $extra1, $extra2, $htmlen, $codeen, $iconen, $ipaddr, $newstext1, $extra3, $extrae1, $extrae2, $extrae3, $extrae4, $extrae5, $extrae6, $extrae7, $extrae8, $extrae9, $extrae10, $extrae11, $extrae12, $extrae13, $extrae14, $extrae15, $extrae16, $extrae17, $extrae18, $extrae19, $extrae20, $extrag13;

        if ($admin[user_canreview] == 2)
        {
            $result = DBQuery("SELECT review_poster FROM esselbach_st_review WHERE reviewpage_id = '$zid'");
            list($reviewposter) = mysql_fetch_row($result);

            if ($reviewposter != $admin[user_name])
            {
                MkHeader("_self");
                MkTabHeader ("$words[ERR]");
                echo "$words[RREVI]";
                MkTabFooter();
                MkFooter();
            }
        }

        DBQuery("UPDATE esselbach_st_review SET review_title='$newstitle', review_website='$website', review_category='$category', review_author='$extra2', review_html='$htmlen', review_icon='$iconen', review_code='$codeen', review_editip='$ipaddr', review_hook='$extrag13' WHERE review_id = '$extra1'");
        DBQuery("UPDATE esselbach_st_review SET review_text='$newstext1', review_pagesub='$extra3', review_extra1='$extrae1', review_extra2='$extrae2', review_extra3='$extrae3', review_extra4='$extrae4', review_extra5='$extrae5', review_extra6='$extrae6', review_extra7='$extrae7', review_extra8='$extrae8', review_extra9='$extrae9', review_extra10='$extrae10', review_extra11='$extrae11', review_extra12='$extrae12', review_extra13='$extrae13', review_extra14='$extrae14', review_extra15='$extrae15', review_extra16='$extrae16', review_extra17='$extrae17', review_extra18='$extrae18', review_extra19='$extrae19', review_extra20='$extrae20' WHERE reviewpage_id = '$zid'");

        $result = DBQuery("SELECT review_page, review_title, review_author, review_category, review_website FROM esselbach_st_review WHERE review_id='$extra1' ORDER BY review_page DESC");
        list ($page, $newstitle, $extra2, $category, $website) = mysql_fetch_row($result);
        $page++;
        $reviewid = $extra1;
        for($z = 1; $z < $page; $z++)
        {
            RemoveCache ("reviews/review-$reviewid-$z");
            RemoveCache ("reviews/reviewp-$reviewid-$z");
        }
        RemoveCache ("reviews/review-$reviewid-1");
        RemoveCache ("reviews/reviewp-$reviewid-1");
        RemoveCache ("tags/review-$reviewid");

        RemoveCache ("reviews/reviews");
        RemoveCache ("xml/xmlnews-110");
        RemoveCache ("xml/xmlhelp");

        if (($zid == 1) and (!$extrag13))
        {
            UpdateIndex ($reviewid, $website, 2, $newstitle, $newstext1);
        }

        MkHeader("_self");
        MkTabHeader ("$words[DO]");
        echo $words[RC];
        MkTabFooter();
        MkFooter();

    }

    //  ##########################################################

    function ReviewAdd ()
    {

        global $words, $extra1, $extra2, $admin, $website, $category, $newstitle, $newstext1, $extra3, $htmlen, $iconen, $codeen, $ipaddr, $extrae1, $extrae2, $extrae3, $extrae4, $extrae5, $extrae6, $extrae7, $extrae8, $extrae9, $extrae10, $extrae11, $extrae12, $extrae13, $extrae14, $extrae15, $extrae16, $extrae17, $extrae18, $extrae19, $extrae20, $extrag13;

        if (!$extra1)
        {
            $result = DBQuery("SELECT review_id FROM esselbach_st_review ORDER BY review_id DESC");
            if ($result)
                {
                list($reviewid) = mysql_fetch_row($result);
            }
            $reviewid++;
            $page = 1;
        }
        else
        {
            $result = DBQuery("SELECT review_page, review_title, review_author, review_category, review_website FROM esselbach_st_review WHERE review_id='$extra1' ORDER BY review_page DESC");
            list ($page, $newstitle, $extra2, $category, $website) = mysql_fetch_row($result);
            $page++;
            $reviewid = $extra1;
            for($z = 1; $z < $page; $z++)
            {
                RemoveCache ("reviews/review-$reviewid-$z");
                RemoveCache ("reviews/reviewp-$reviewid-$z");
            }
            DBQuery("UPDATE esselbach_st_review SET review_hook = '$extrag13' WHERE review_id = '$reviewid'");
        }

        DBQuery("INSERT INTO esselbach_st_review VALUES (NULL, '$reviewid', '$extra2', '$admin[user_name]', '$website', '$category', '$newstitle', '$newstext1', '$page', '$extra3', now(), '$extrae1', '$extrae2', '$extrae3', '$extrae4', '$extrae5', '$extrae6', '$extrae7', '$extrae8', '$extrae9', '$extrae10', '$extrae11', '$extrae12', '$extrae13', '$extrae14', '$extrae15', '$extrae16', '$extrae17', '$extrae18', '$extrae19', '$extrae20', '$htmlen', '$iconen', '$codeen', '$ipaddr', '$ipaddr', '$extrag13')");

        if ($page == 1)
        {
            $result = DBQuery("SELECT review_id, review_date FROM esselbach_st_review ORDER BY review_id DESC LIMIT 1");
            list($id, $time) = mysql_fetch_row($result);

            if (!$extrag13)
            {
                AddIndex ($id, $website, 2, $admin[user_name], $newstitle, $newstext1, $time);
            }
        }

        RemoveCache ("reviews/reviews");
        RemoveCache ("xml/xmlnews-110");
        RemoveCache ("xml/xmlhelp");

        MkHeader("_self");
        MkTabHeader ("$words[DO]");
        echo $words[RA];
        MkTabFooter();
        MkFooter();

    }

    //  ##########################################################

    function ReviewQuick ()
    {

        global $words, $extra1, $extra2, $admin, $website, $category, $newstitle, $newstext1, $extra3, $htmlen, $iconen, $codeen, $ipaddr, $extrae1, $extrae2, $extrae3, $extrae4, $extrae5, $extrae6, $extrae7, $extrae8, $extrae9, $extrae10, $extrae11, $extrae12, $extrae13, $extrae14, $extrae15, $extrae16, $extrae17, $extrae18, $extrae19, $extrae20, $extrag13;

        $result = DBQuery("SELECT review_id FROM esselbach_st_review ORDER BY review_id DESC");
        if ($result)
        {
            list($reviewid) = mysql_fetch_row($result);
        }
        $reviewid++;
        $page = 1;

        if (preg_match("/[NEWPAGE]/i", $newstext1))
        {
            $htmlpage = explode("[NEWPAGE]", $newstext1);
            for($i = 0; $i < count($htmlpage); $i++)
            {
                DBQuery("INSERT INTO esselbach_st_review VALUES (NULL, '$reviewid', '$extra2', '$admin[user_name]', '$website', '$category', '$newstitle', '$htmlpage[$i]', '$page', '$extra3', now(), '$extrae1', '$extrae2', '$extrae3', '$extrae4', '$extrae5', '$extrae6', '$extrae7', '$extrae8', '$extrae9', '$extrae10', '$extrae11', '$extrae12', '$extrae13', '$extrae14', '$extrae15', '$extrae16', '$extrae17', '$extrae18', '$extrae19', '$extrae20', '$htmlen', '$iconen', '$codeen', '$ipaddr', '$ipaddr', '$extrag13')");
                if ($page == 1)
                {
                    $result = DBQuery("SELECT review_id, review_date FROM esselbach_st_review ORDER BY review_id DESC LIMIT 1");
                    list($id, $time) = mysql_fetch_row($result);

                    if (!$extrag13)
                    {
                        AddIndex ($id, $website, 2, $admin[user_name], $newstitle, $htmlpage[0], $time);
                    }
                }
                $page++;
            }
        }
        else
        {
            DBQuery("INSERT INTO esselbach_st_review VALUES (NULL, '$reviewid', '$extra2', '$admin[user_name]', '$website', '$category', '$newstitle', '$newstext1', '$page', '$extra3', now(), '$extrae1', '$extrae2', '$extrae3', '$extrae4', '$extrae5', '$extrae6', '$extrae7', '$extrae8', '$extrae9', '$extrae10', '$extrae11', '$extrae12', '$extrae13', '$extrae14', '$extrae15', '$extrae16', '$extrae17', '$extrae18', '$extrae19', '$extrae20', '$htmlen', '$iconen', '$codeen', '$ipaddr', '$ipaddr', '$extrag13')");
            $result = DBQuery("SELECT review_id, review_date FROM esselbach_st_review ORDER BY review_id DESC LIMIT 1");
            list($id, $time) = mysql_fetch_row($result);

            if (!$extrag13)
            {
                AddIndex ($id, $website, 2, $admin[user_name], $newstitle, $newstext1, $time);
            }
        }

        RemoveCache ("reviews/reviews");
        RemoveCache ("xml/xmlnews-110");
        RemoveCache ("xml/xmlhelp");

        MkHeader("_self");
        MkTabHeader ("$words[DO]");
        echo $words[RA];
        MkTabFooter();
        MkFooter();

    }

    //  ##########################################################

    function ReviewImgUp ()
    {

        global $words;

        if (phpversion() >= "4.1.0")
        {
            $upfile = strtolower($_FILES[reviewifile][name]);
            if (!preg_match("/(.gif|.jpg|.jpeg|.png)/i", substr($upfile,-4)))
            {
                MkHeader("_self");
                MkTabHeader ("$words[ERR]");
                echo $words[IA];
                MkTabFooter();
                echo "<center><font face=\"Arial\" size=\"2\">[<a href=\"index.php?action=showreviewimg\">$words[IMGBA]</a>]</font></center>";
                echo "<center><font face=\"Arial\" size=\"2\">[<a href=\"javascript:self.close()\">$words[XSIC]</a>]</font></center>";
                MkFooter();
            }
            if ($_FILES[reviewifile][size] > 250000)
            {
                MkHeader("_self");
                MkTabHeader ("$words[ERR]");
                echo $words[WB];
                MkTabFooter();
                echo "<center><font face=\"Arial\" size=\"2\">[<a href=\"index.php?action=showreviewimg\">$words[IMGBA]</a>]</font></center>";
                echo "<center><font face=\"Arial\" size=\"2\">[<a href=\"javascript:self.close()\">$words[XSIC]</a>]</font></center>";
                MkFooter();
            }
            if (move_uploaded_file($_FILES[reviewifile][tmp_name], "../images/review/".$upfile))
            {
                @chmod ("../images/review/$upfile", 0777);
                MkHeader("_self");
                MkTabHeader ("$words[DO]");
                echo $words[IS];
                MkTabFooter();
                echo "<center><font face=\"Arial\" size=\"2\">[<a href=\"index.php?action=showreviewimg\">$words[IMGBA]</a>]</font></center>";
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

    function AdminRReviewQueue()
    {

        global $words;
        dbconnect();

        DBQuery("DELETE FROM esselbach_st_reviewqueue");

        MkHeader("_self");
        MkTabHeader ("$words[DO]");
        echo "$words[QED]";
        MkTabFooter();
        MkFooter();

    }

    //  ##########################################################

    function AdminReviewQueue($opts)
    {

        global $words;
        dbconnect();

        $options = explode("-", $opts);
        if ($options[0] == "deleteqreview")
        {

            $result = DBQuery("DELETE FROM esselbach_st_reviewqueue WHERE reviewq_id='$options[1]'");

            MkHeader("_self");
            MkTabHeader ("$words[DO]");
            echo "$words[QSR]";
            MkTabFooter();
            MkFooter();

        }

        if ($options[0] == "addqreview")
        {

            $result = DBQuery("SELECT * FROM esselbach_st_reviewqueue WHERE reviewq_id='$options[1]'");
            $reviewdata = mysql_fetch_array($result);

            $reviewdata[reviewq_author] = htmlentities(ScriptEx($reviewdata[reviewq_author]));

            if ($reviewdata[reviewq_authormail])
            {
                $reviewdata[reviewq_authormail] = htmlentities(ScriptEx($reviewdata[reviewq_authormail]));
                $amail = "<a href=\"mailto:$reviewdata[reviewq_authormail]\"><img src=\"../images/email.png\" border=\"0\"></a>";
            }

            MkHeader("_self");
            MkTabHeader ("$words[ADDQR]");

            echo "<table><form name=\"review\" action=\"index.php\" method=\"post\">";
            echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\">$words[SMY]</font></td><td></td><td><font face=\"Arial\" size=\"2\">$reviewdata[reviewq_author] $amail ($words[TIP] $reviewdata[reviewq_authorip]) $reviewdata[reviewq_time]</font></td></tr>";

            $query = DBQuery("SELECT website_id, website_name FROM esselbach_st_websites");
            if (mysql_num_rows($query) > 1)
            {

                echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\">$words[WBS]</font></td><td></td><td><face face=\"Arial\" size=\"2\"><select size=\"1\" name=\"website\">";

                echo "<option value=\"0\">$words[ALL]</option>";
                while (list($website_id, $website_name) = mysql_fetch_row($query))
                {
                    ($website_id == $story['reviewq_website']) ? $select = "selected" :
                    $select = "";
                    echo "<option $select value=\"$website_id\">$website_name</option>";
                }

                echo "</select></font></td></tr>";
            }

            MkOption ("$words[RTI]", "", "newstitle", "$reviewdata[reviewq_title]");
            MkSelect ("$words[PUBLI]", "extrag13", "0");

            echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\">$words[CAT]</font></td><td></td><td><face face=\"Arial\" size=\"2\"><select size=\"1\" name=\"category\">";

            $query = DBQuery("SELECT reviewcat_id, reviewcat_name FROM esselbach_st_reviewcat");
            while (list($reviewcat_id, $reviewcat_name) = mysql_fetch_row($query))
            {
                echo "<option value=\"$reviewcat_id\">$reviewcat_name</option>";
            }

            echo "</select></font></td></tr>";

            MkOption ("$words[AUT]", "", "extra2", "$reviewdata[reviewq_author]");

            echo "<script language=\"JavaScript\">
                <!--
                function AutoInsert1(tag) {
                document.review.newstext1.value =
                document.review.newstext1.value + tag;
                }
                function OpenWin() {
                var newWinObj = window.open('index.php?action=showreviewimg','newWin','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=1,copyhistory=0,width=800,height=600')
                }
                // -->
                </script>";

            QuickHTML(1);

            MkArea ("$words[RTX]", "newstext1", "$reviewdata[reviewq_text]");
            echo "<tr><td></td><td></td><td><font face=\"Arial\" size=\"2\"><center><a href=\"javascript:AutoInsert1('[NEWPAGE]')\">$words[NEWPA]</a></center></font></td></tr>";

            MkSelect ("$words[EHT]", "htmlen", "0");
            MkSelect ("$words[EIS]", "iconen", "1");
            MkSelect ("$words[EBC]", "codeen", "1");

            $query = DBQuery("SELECT * FROM esselbach_st_fields WHERE field_id='4'");
            $field = mysql_fetch_array($query);

            for($i = 1; $i < 21; $i++)
            {
                if ($field['field_enabled'.$i] == 1)
                {
                    echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\">".$field['field_extra'.$i].":</font>";
                    echo "</td><td></td><td><font face=\"Arial\" size=\"2\"><input name=\"extrae$i\" size=\"32\"></font></td></tr>";
                }
                if ($field['field_enabled'.$i] == 2)
                {
                    $fieldoptions = explode(",", $field['field_extra'.$i]);
                    echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\">$fieldoptions[0]:</font>";
                    echo "</td><td></td><td><face face=\"Arial\" size=\"2\"><select size=\"1\" name=\"extrae$i\">";
                    for($z = 1; $z < count($fieldoptions); $z++)
                    {
                        echo "<option value=\"$fieldoptions[$z]\">$fieldoptions[$z]</option>";
                    }
                    echo "</select></font></td></tr>";
                }
            }


            echo "<input type=\"hidden\" name=\"aform\" value=\"doqreview\"><td><font face=\"Arial\" size=\"2\"><input type=\"submit\" value=\"$words[SUB]\"></form></font></td></tr></table>";

            MkTabFooter();
            MkTabHeader("$words[SRI]");
            echo "$words[UPV]";
            MkTabFooter();
            MkFooter();
        }

        MkHeader("_self");
        MkTabHeader("$words[REVQR] <a href=\"index.php?action=removerqueue\"><img src=\"../images/delete.png\" border=\"0\" alt=\"$words[DSFRQ]\"></a>");
        echo "$words[DQIR5]";
        MkTabFooter();

        TblHeader("$words[RSI]", "$words[RTI]");

        $result = DBQuery("SELECT reviewq_website, reviewq_title, reviewq_id FROM esselbach_st_reviewqueue ORDER BY reviewq_id DESC LIMIT 100");

        while (list($reviewq_website, $reviewq_title, $reviewq_id) = mysql_fetch_row($result))
        {
            TblMiddle("$reviewq_id / $reviewq_website", "$reviewq_title", "reviewqueue&opts=addqreview-$reviewq_id", "reviewqueue&opts=deleteqreview-$reviewq_id");
        }

        MkFooter();

    }

    //  ##########################################################

    function SearchReviews()
    {

        global $words, $zid;

        MkHeader("_self");
        MkTabHeader("$words[ERP]");
        echo "<form action=\"index.php\" method=\"post\"><font size=\"2\" face=\"Verdana, Arial\">$words[SR]:</font>";
        echo "<input name=\"zid\" size=\"32\" value=\"$zid\"><input type=\"submit\" value=\"$words[SM]\"><input type=\"hidden\" name=\"aform\" value=\"searchreviews\"></form>";
        MkTabFooter();

        $szid = stripslashes($zid);

        TblHeader("$words[PSI]", "$words[REVTW] $szid");

        $result = DBQuery("SELECT review_website, review_title, reviewpage_id, review_page, review_hook FROM esselbach_st_review WHERE (review_title like '%$zid%') ORDER BY reviewpage_id DESC LIMIT 100");

        while (list($review_website, $review_title, $reviewpage_id, $review_page, $review_hook) = mysql_fetch_row($result))
        {
            if ($review_hook)
            {
                $review_title = "<font color=\"red\">$review_title</font>";
            }
            TblMiddle("$reviewpage_id / $review_website", "$review_title ($review_page)", "editreview&opts=editreview-$reviewpage_id", "editreview&opts=deletereview-$reviewpage_id");
        }

        MkFooter();

    }

    //  ##########################################################

    function AdminReviewNews($opts)
    {

        global $configs, $admin, $words, $midas;

        $options = explode("-", $opts);
        if ($options[0] == "now")
        {
            $result = DBQuery("SELECT * FROM esselbach_st_review WHERE review_hook = '0' AND review_page = '1' AND review_id = '$options[1]'");
            $review = mysql_fetch_array($result);

            $reviewsplit = explode("\n", $review[review_text]);
            $review[review_text] = eregi_replace("\\[([^\\[]*)\\]", "", $reviewsplit[0]);

            if ($midas)
            {
                $review[review_text] .= "<br /><br /><a href=\"review.php?id=$review[review_id]\">$words[REM]</a>";
            }
            else
            {
                $review[review_text] .= "\n\n<a href=\"review.php?id=$review[review_id]\">$words[REM]</a>";
            }

            MkHeader("_self");
            MkTabHeader("$words[ADS]");

            echo "<table><form name=\"newsstory\" action=\"index.php\" method=\"post\">";

            $query = DBQuery("SELECT website_id, website_name FROM esselbach_st_websites");
            if (mysql_num_rows($query) > 1)
            {

                echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\">$words[WBS]</font></td><td></td><td><face face=\"Arial\" size=\"2\"><select size=\"1\" name=\"website\">";

                echo "<option value=\"0\">$words[ALL]</option>";

                while (list($website_id, $website_name) = mysql_fetch_row($query))
                {
                    ($website_id == $review['review_website']) ? $select = "selected" :
                     $select = "";
                    echo "<option $select value=\"$website_id\">$website_name</option>";
                }
            }

            echo "</select></font></td></tr>";

            MkOption ("$words[TIT]", "", "newstitle", "$review[review_title]");
            MkSelect ("$words[PUBLI]", "extrag13", "0");
            echo "<tr><td></td><td></td><td><input type=\"checkbox\" name=\"extrag12\" value=\"1\"><font face=\"Arial\" size=\"2\">$words[FEATU]</font>";

            echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\">$words[CAT]</font></td><td></td><td><face face=\"Arial\" size=\"2\"><select size=\"1\" name=\"category\">";

            $query = DBQuery("SELECT category_id, category_name FROM esselbach_st_categories");
            while (list($category_id, $category_name) = mysql_fetch_row($query))
            {
                echo "<option value=\"$category_id\">$category_name</option>";
            }

            echo "</select></font></td></tr>";

        if ($midas)
        {
            echo "\n\n<script type=\"text/javascript\" src=\"wysiwyg/htmlarea3.js\"></script>\n\n";
        }

        echo "<script language=\"JavaScript\">
            <!--
            ";

        if (!$midas)
        {
            echo "function AutoInsert1(tag) {
            document.newsstory.newstext1.value =
            document.newsstory.newstext1.value + tag;
            }
            function AutoInsert2(tag) {
            document.newsstory.newstext2.value =
            document.newsstory.newstext2.value + tag;
            }
            function OpenWin() {
            var newWinObj = window.open('index.php?action=shownewsimg','newWin','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=1,copyhistory=0,width=800,height=600')
            }";
        }
            echo "            function TeaserWin() {
            var newWinObj = window.open('index.php?action=viewteaser','newWin','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=1,copyhistory=0,width=200,height=600')
            }
            function TeaserUpload() {
            var newWinObj = window.open('index.php?action=upteaser','newWin','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=1,copyhistory=0,width=400,height=100')
            }
            //-->
            </script>";

            if (!$midas) QuickHTML(1);

            MkArea ("$words[MNS]", "newstext1", "$review[review_text]");

            if (!$midas) QuickHTML(2);

            MkArea ("$words[EMN]", "newstext2", "");

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

            MkOption ("$words[SOU]", "", "source", "$words[HOUSE]");
            MkSelect ("$words[SNM]", "mainnewsonly", "1");
            MkSelect ("$words[ECO]", "commen", "1");

            if ($admin[user_cannews] == 1)
            {
                (phpversion() >= "4.1.0") ? $teaserup = " [<a href=\"javascript:TeaserUpload()\">$words[UPL]</a>]" :
                 $teaserup = "";
            }

            if (file_exists("../images/teaser"))
            {

                echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\">$words[tim]$teaserup:<br /><br /><a href=\"javascript:TeaserWin()\">$words[NTVA]</a></font></td><td></td><td><face face=\"Arial\" size=\"2\"><select size=\"4\" name=\"teaser\"><option selected value=\"\">$words[NTP]</option>";

                if ($configs[12])
                {
                    $thisdate = date("m-Y");
                    if (!file_exists("../images/teaser/$thisdate"))
                    {
                        mkdir("../images/teaser/$thisdate", 0777);
                    }
                    $teaser_dir = GetDir("../images/teaser/$thisdate");
                }
                else
                {
                    $teaser_dir = GetDir("../images/teaser");
                }

                for($i = 1; $i < count($teaser_dir); $i++)
                {
                    if (preg_match("/(.gif|.jpeg|.jpg|.png)/i", $teaser_dir[$i]))
                    {
                        echo "<option value=\"$teaser_dir[$i]\">$teaser_dir[$i]</option>";
                    }
                }
                echo "</select></font></td></tr>";

            }

            $query = DBQuery("SELECT * FROM esselbach_st_fields WHERE field_id='1'");
            $field = mysql_fetch_array($query);

            for($i = 1; $i < 21; $i++)
            {
                if ($field['field_enabled'.$i] == 1)
                {
                    echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\">".$field['field_extra'.$i]."</font>";
                    echo "</td><td></td><td><font face=\"Arial\" size=\"2\"><input name=\"extra$i\" size=\"32\"></font></td></tr>";
                }
                if ($field['field_enabled'.$i] == 2)
                {
                    $fieldoptions = explode(",", $field['field_extra'.$i]);
                    echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\">$fieldoptions[0]</font>";
                    echo "</td><td></td><td><face face=\"Arial\" size=\"2\"><select size=\"1\" name=\"extra$i\">";
                    for($z = 1; $z < count($fieldoptions); $z++)
                    {
                        echo "<option value=\"$fieldoptions[$z]\">$fieldoptions[$z]</option>";
                    }
                    echo "</select></font></td></tr>";
                }
            }

            echo "<input type=\"hidden\" name=\"aform\" value=\"doadd\"><td><font face=\"Arial\" size=\"2\"><input type=\"submit\" value=\"$words[SUB]\"></form></font></td></tr></table>";

            MkTabFooter();

            if ($midas)
            {
                EnableMidas("newstext2");
                EnableMidas("newstext1");
            }
            else
            {
                MkTabHeader("$words[SRI2]");
                echo "$words[UPV2]";
                MkTabFooter();
            }

            MkFooter();
        }

        MkHeader("_self");
        MkTabHeader("$words[RTONW]");
        echo "$words[RTOND]";
        MkTabFooter();

        echo "<table border=\"0\" cellpadding=\"1\" cellspacing=\"1\" width=\"100%\">
            <tr bgcolor=\"#003399\">
            <td>
            <table border=\"0\" cellpadding=\"3\" cellspacing=\"0\" width=\"100%\">
            <tr bgcolor=\"#003399\">
            <td align=\"left\" width=\"90%\">
            <font size=\"2\" color=\"#FFFFFF\" face=\"Verdana, Arial\"><b>$words[REVWS]</b></font>
            </td>
            <td align=\"left\" width=\"10%\">

            </td>
            </tr>";

        $result = DBQuery("SELECT review_title, review_id, review_website FROM esselbach_st_review WHERE review_hook = '0' AND review_page = '1' ORDER BY review_id DESC LIMIT 100");

        while (list($review_title, $review_id, $review_website) = mysql_fetch_row($result))
        {
            ($bgcolor == "#ffffff") ? $bgcolor = "#eeeeee" :
             $bgcolor = "#ffffff";

                 echo <<<Middle
<tr bgcolor="$bgcolor">
        <td align="left" width="90%">
            <font size="2" color="#000000" face="Verdana, Arial">
                $review_title ($review_website)
                </font>
        </td>
      <td align="center" width="10%">
                <font size="2" color="#000000" face="Verdana, Arial">
            <a href="index.php?action=reviewtonews&opts=now-$review_id"><img src="../images/quote.png" border="0"></a>
            <a href="index.php?action=reviewtonews&opts=now-$review_id&midas=1"><img src="../images/quote.png" border="0"></a>
            </font>
      </td>
</tr>
Middle;

        }
        echo "</table>
            </td>
            </tr>
            </table>
            <br />";
        MkFooter();

    }

    //  ##########################################################

    function AdminSearchReview()
    {

        global $words;

        MkHeader("_self");
        MkTabHeader("$words[NEWRV]");
        echo "<form action=\"index.php\" method=\"post\"><font size=\"2\" face=\"Verdana, Arial\">$words[FOS]</font><br />";
        echo "<input type=\"hidden\" name=\"aform\" value=\"searchreplacereview\"><textarea cols=\"100%\" name=\"zid\" rows=\"2\"></textarea><br />";
        echo "$words[INFLD] <select size=\"1\" name=\"extra2\"><option value=\"title\">title</option><option value=\"text\">text</option>";
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

    function ReviewSearchReplace ()
    {

        global $words, $zid, $extra1, $extra2, $ipaddr;

        MkHeader("_self");
        MkTabHeader ("$words[DO]");

        $search_field = "review_".$extra2;
        $query = DBQuery("SELECT * FROM esselbach_st_review WHERE ($search_field LIKE '%$zid%')");

        $totalrows = 0;
        while ($rows = mysql_fetch_array($query))
        {
            $out_field = str_replace("$zid", "$extra1", $rows[$search_field]);
            DBQuery("UPDATE esselbach_st_review SET $search_field = '$out_field', review_editip = '$ipaddr' WHERE review_id = '$rows[review_id]'");
            $totalrows++;
        }

        echo $totalrows." ".$words[ENTCH];

        ClearCache("news");
        ClearCache("reviews");
        ClearCache("tags");

        MkTabFooter();
        MkFooter();

    }
?>
