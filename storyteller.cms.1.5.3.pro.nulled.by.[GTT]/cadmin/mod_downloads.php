<?php

    /*
    ########################
    # |//////////////////| #
    # NULLED by [GTT] =)   #
    # |\\\\\\\\\\\\\\\\\\| #
    ########################
    */

    function AdminEditDownload($opts)
    {

        global $words, $admin, $midas;
        dbconnect();

        $options = explode("-", $opts);

        if (($options[0]) and ($admin[user_candownload] == 2))
        {
            $result = DBQuery("SELECT download_author FROM esselbach_st_downloads WHERE download_id = '$options[1]'");
            list($dlauthor) = mysql_fetch_row($result);

            if ($dlauthor != $admin[user_name])
            {
                MkHeader("_self");
                MkTabHeader ("$words[ERR]");
                echo "$words[RDOWN]";
                MkTabFooter();
                MkFooter();
            }
        }

        if ($options[0] == "deletedownload")
        {

            $result = DBQuery("SELECT download_category FROM esselbach_st_downloads WHERE download_id='$options[1]'");
            list ($catid) = mysql_fetch_row($result);

            DBQuery("DELETE FROM esselbach_st_downloads WHERE download_id='$options[1]'");
            RemoveIndex ($options[1], 4);

            RemoveCache ("downloaddet/download-$options[1]");
            RemoveCache ("tags/download-$options[1]");

            for($a = 1; $a < 27; $a++)
            {
                RemoveCache ("download/download-$catid-$a");
            }

            RemoveCache ("download/download");
            RemoveCache ("xml/xmlnews-120");
            RemoveCache ("xml/xmlhelp");

            MkHeader("_self");
            MkTabHeader ("$words[DO]");
            echo "$words[FSR]";
            MkTabFooter();
            MkFooter();

        }

        if ($options[0] == "editdownload")
        {

            $result = DBQuery("SELECT * FROM esselbach_st_downloads WHERE download_id='$options[1]'");
            $download = mysql_fetch_array($result);

            MkHeader("_self");
            MkTabHeader("$words[EDF2] $options[1]");

            echo "<table><form name=\"adddownload\" action=\"index.php\" method=\"post\">";

            $query = DBQuery("SELECT website_id, website_name FROM esselbach_st_websites");
            if (mysql_num_rows($query) > 1)
            {

                echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\">$words[WBS]</font></td><td></td><td><face face=\"Arial\" size=\"2\"><select size=\"1\" name=\"website\">";
                echo "<option value=\"0\">$words[ALL]</option>";
                while (list($website_id, $website_name) = mysql_fetch_row($query))
                {
                    ($website_id == $download['download_website']) ? $select = "selected" :
                     $select = "";
                    echo "<option $select value=\"$website_id\">$website_name</option>";
                }

                echo "</select></font></td></tr>";
            }

            MkOption ("$words[TIT]", "", "newstitle", "$download[download_title]");
            MkSelect ("$words[PUBLI]", "extrag13", "$download[download_hook]");

            echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\">$words[CAT]</font></td><td></td><td><face face=\"Arial\" size=\"2\"><select size=\"1\" name=\"category\">";

            $query = DBQuery("SELECT downloadscat_id, downloadscat_name FROM esselbach_st_downloadscat");
            while (list($downloadscat_id, $downloadscat_name) = mysql_fetch_row($query))
            {
                ($downloadscat_id == $download['download_category']) ? $select = "selected" :
                 $select = "";
                echo "<option $select value=\"$downloadscat_id\">$downloadscat_name</option>";
            }

            echo "</select></font></td></tr>";

            if ($midas)
            {
                echo "<script type=\"text/javascript\" src=\"wysiwyg/htmlarea3.js\"></script>";
            }

            echo "<script language=\"JavaScript\">
                <!--";

            if (!$midas)
            {
                echo "
                function AutoInsert1(tag) {
                document.adddownload.newstext1.value =
                document.adddownload.newstext1.value + tag;
                }
                function AutoInsert2(tag) {
                document.adddownload.newstext2.value =
                document.adddownload.newstext2.value + tag;
                }";
            }
                echo "
                function OpenWin() {
                var newWinObj = window.open('index.php?action=showdlimg','newWin','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=1,copyhistory=0,width=800,height=600')
                }
                //-->
                </script>";

            if (!$midas) QuickHTML(1);

            MkArea ("$words[DSC]", "newstext1", "$download[download_text]");

            if (!$midas) QuickHTML(2);

            MkArea ("$words[XDC]", "newstext2", "$download[download_extendedtext]");

            MkOption ("$words[RAS]", "", "extrae12", "$download[download_editreason]");

            MkSelect ("$words[EHT]", "htmlen", "$download[download_html]");
            MkSelect ("$words[EIS]", "iconen", "$download[download_icon]");
            MkSelect ("$words[EBC]", "codeen", "$download[download_code]");

            MkOption ("$words[UR1]", "", "extrae1", "$download[download_url1]");
            MkOption ("$words[UR2]", "", "extrae2", "$download[download_url2]");
            MkOption ("$words[UR3]", "", "extrae3", "$download[download_url3]");
            MkOption ("$words[UR4]", "", "extrae4", "$download[download_url4]");
            MkOption ("$words[UR5]", "", "extrae5", "$download[download_url5]");
            MkOption ("$words[UR6]", "", "extrae6", "$download[download_url6]");
            MkOption ("$words[UR7]", "", "extrae7", "$download[download_url7]");
            MkOption ("$words[UR8]", "", "extrae8", "$download[download_url8]");

            MkSelect ("$words[SUO]", "extrad1", "$download[download_sub]");
            MkSelect ("$words[ECO]", "commen", "$download[download_comm]");

            $query = DBQuery("SELECT * FROM esselbach_st_fields WHERE field_id='2'");
            $field = mysql_fetch_array($query);

            for($i = 1; $i < 21; $i++)
            {
                if ($field['field_enabled'.$i] == 1)
                {
                    echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\">".$field['field_extra'.$i].":</font>";
                    echo "</td><td></td><td><font face=\"Arial\" size=\"2\"><input name=\"extra$i\" size=\"32\" value=\"".$download['download_extra'.$i]."\"></font></td></tr>";
                }
                if ($field['field_enabled'.$i] == 2)
                {
                    $fieldoptions = explode(",", $field['field_extra'.$i]);
                    echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\">$fieldoptions[0]:</font>";
                    echo "</td><td></td><td><face face=\"Arial\" size=\"2\"><select size=\"1\" name=\"extra$i\">";
                    for($z = 1; $z < count($fieldoptions); $z++)
                    {
                        ($fieldoptions[$z] == $download['download_extra'.$i]) ? $select = "selected" :
                         $select = "";
                        echo "<option $select value=\"$fieldoptions[$z]\">$fieldoptions[$z]</option>";
                    }
                    echo "</select></font></td></tr>";
                }
            }

            echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\"><input type=\"checkbox\" name=\"bump\" value=\"1\">$words[BMP] / <input type=\"checkbox\" name=\"extrae9\" value=\"1\">$words[RCO]</font></td></tr> <input type=\"hidden\" name=\"aform\" value=\"dodownloadedit\"><input type=\"hidden\" name=\"zid\" value=\"$download[download_id]\"><td><font face=\"Arial\" size=\"2\"><input type=\"submit\" value=\"$words[SND]\"></form></font></td></tr></table>";
            MkTabFooter();

            MkTabHeader("$words[ASD] $download[download_title]");
            echo "<table><form action=\"index.php\" method=\"post\">";
            MkOption ("$words[UN]", "", "extra1", "");
            MkOption ("$words[EXD]", "$words[DAT]", "extra2", "2009-12-31");
            echo "<input type=\"hidden\" name=\"extra3\" value=\"$download[download_id]\"><input type=\"hidden\" name=\"aform\" value=\"adddownloadsub\"><td><font face=\"Arial\" size=\"2\"><input type=\"submit\" value=\"$words[SND]\"></form></font></td></tr></table>";
            MkTabFooter();

            if ($midas)
            {
                EnableMidas("newstext2");
                EnableMidas("newstext1");
            }
            else
            {
                MkTabHeader("$words[SRI3]");
                echo "$words[UPV3]";
                MkTabFooter();
            }
            MkFooter();
        }

        MkHeader("_self");
        MkTabHeader("$words[EDF]");
        echo "<form action=\"index.php\" method=\"post\"><font size=\"2\" face=\"Verdana, Arial\">$words[SRC]</font>";
        echo "<input type=\"hidden\" name=\"aform\" value=\"searchfiles\"><input name=\"zid\" size=\"32\"><input type=\"submit\" value=\"$words[SUB]\"></form>";
        MkTabFooter();

        TblHeader("$words[FSI]", "$words[TIT]");


        $result = DBQuery("SELECT download_website, download_title, download_id, download_hook FROM esselbach_st_downloads ORDER BY download_id DESC LIMIT 100");

        while (list($download_website, $download_title, $download_id, $download_hook) = mysql_fetch_row($result))
        {
            if ($download_hook)
            {
                $download_title = "<font color=\"red\">$download_title</font>";
            }

            TblMiddle2("$download_id / $download_website", "$download_title", "editdownload&opts=editdownload-$download_id", "editdownload&opts=deletedownload-$download_id");
        }

        MkFooter();

    }

    //  ##########################################################

    function AdminAddDownload()
    {

        global $words, $admin, $midas;

        dbconnect();

        MkHeader("_self");
        MkTabHeader ("$words[ADL]");

        echo "<table><form name=\"adddownload\" action=\"index.php\" method=\"post\">";

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

        MkOption ("$words[TIT]", "", "newstitle", "");
        MkSelect ("$words[PUBLI]", "extrag13", "0");

        echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\">$words[CAT]</font></td><td></td><td><face face=\"Arial\" size=\"2\"><select size=\"1\" name=\"category\">";

        $query = DBQuery("SELECT downloadscat_id, downloadscat_name FROM esselbach_st_downloadscat");
        while (list($downloadscat_id, $downloadscat_name) = mysql_fetch_row($query))
        {
            echo "<option value=\"$downloadscat_id\">$downloadscat_name</option>";
        }

        echo "</select></font></td></tr>";

        if ($midas)
        {
            echo "<script type=\"text/javascript\" src=\"wysiwyg/htmlarea3.js\"></script>";
        }

        echo "<script language=\"JavaScript\">
            <!--";

        if (!$midas)
        {
            echo "
            function AutoInsert1(tag) {
            document.adddownload.newstext1.value =
            document.adddownload.newstext1.value + tag;
            }
            function AutoInsert2(tag) {
            document.adddownload.newstext2.value =
            document.adddownload.newstext2.value + tag;
            }";
        }
            echo "
            function OpenWin() {
            var newWinObj = window.open('index.php?action=showdlimg','newWin','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=1,copyhistory=0,width=800,height=600')
            }
            //-->
            </script>";

        if (!$midas) QuickHTML(1);

        MkArea ("$words[DSC]", "newstext1", "");

        if (!$midas) QuickHTML(2);

        MkArea ("$words[XDC]", "newstext2", "");

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

        MkOption ("$words[UR1]", "", "extrae1", "");
        MkOption ("$words[UR2]", "", "extrae2", "");
        MkOption ("$words[UR3]", "", "extrae3", "");
        MkOption ("$words[UR4]", "", "extrae4", "");
        MkOption ("$words[UR5]", "", "extrae5", "");
        MkOption ("$words[UR6]", "", "extrae6", "");
        MkOption ("$words[UR7]", "", "extrae7", "");
        MkOption ("$words[UR8]", "", "extrae8", "");

        MkSelect ("$words[SUO]", "extrad1", "");
        MkSelect ("$words[ECO]", "commen", "1");

        $query = DBQuery("SELECT * FROM esselbach_st_fields WHERE field_id='2'");
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

        echo "<input type=\"hidden\" name=\"aform\" value=\"dodownloadadd\"><td><font face=\"Arial\" size=\"2\"><input type=\"submit\" value=\"$words[SUB]\"></font></form></td></tr></table>";

        MkTabFooter();

        if ($midas)
        {
            EnableMidas("newstext2");
            EnableMidas("newstext1");
        }
        else
        {
            MkTabHeader("$words[SRI3]");
            echo "$words[UPV3]";
            MkTabFooter();
        }

        MkFooter();
    }

    //  ##########################################################

    function AdminCatDownload($opts)
    {

        global $words;

        dbconnect();

        $options = explode("-", $opts);
        if ($options[0] == "deletecat")
        {

            if ($options[1] > 1)
            {
                $result = DBQuery("DELETE FROM esselbach_st_downloadscat WHERE downloadscat_id='$options[1]'");

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

            $result = DBQuery("SELECT * FROM esselbach_st_downloadscat WHERE downloadscat_id='$options[1]'");
            $cat = mysql_fetch_array($result);

            MkHeader("_self");
            MkTabHeader("$words[EDC]");
            echo "<table><form action=\"index.php\" method=\"post\">";
            MkOption ("$words[CAN]", "", "category", "$cat[downloadscat_name]");
            MkOption ("$words[DSC]", "", "categorydsc", "$cat[downloadscat_desc]");
            echo "<input type=\"hidden\" name=\"aform\" value=\"editdownloadscat\"><input type=\"hidden\" name=\"zid\" value=\"$cat[downloadscat_id]\"><td><font face=\"Arial\" size=\"2\"><input type=\"submit\" value=\"$words[SND]\"></font></td></tr></table>";
            MkTabFooter();
            MkFooter();

        }

        MkHeader("_self");
        MkTabHeader("$words[EDC]");
        echo $words[EDD];
        MkTabFooter();

        TblHeader("$words[CID]", "$words[CNA]");

        $result = DBQuery("SELECT downloadscat_id, downloadscat_name FROM esselbach_st_downloadscat ORDER BY downloadscat_id");

        while (list($category_id, $category_title) = mysql_fetch_row($result))
        {
            TblMiddle("$category_id", "$category_title", "downloadcat&opts=editcat-$category_id", "downloadcat&opts=deletecat-$category_id");
        }
        TblFooter();

        MkTabHeader("$words[AAC]");
        echo "<table><form action=\"index.php\" method=\"post\">";
        MkOption ("$words[CET]", "", "category", "");
        MkOption ("$words[DSC]", "", "categorydsc", "");
        echo "<input type=\"hidden\" name=\"aform\" value=\"adddownloadscat\"><td><font face=\"Arial\" size=\"2\"><input type=\"submit\" value=\"$words[SND]\"></font></td></tr></table>";
        MkTabFooter();

        MkFooter();

    }

    //  ##########################################################

    function AdminDownloadSub($opts)
    {

        global $words;
        dbconnect();

        $options = explode("-", $opts);
        if ($options[0] == "deletesub")
        {

            $result = DBQuery("DELETE FROM esselbach_st_subscribers WHERE sub_id='$options[1]'");

            MkHeader("_self");
            MkTabHeader ("$words[DO]");
            echo "$words[SSR3]";
            MkTabFooter();
            MkFooter();

        }

        if ($options[0] == "editsub")
        {

            $result = DBQuery("SELECT * FROM esselbach_st_subscribers WHERE sub_id='$options[1]'");
            $sub = mysql_fetch_array($result);

            MkHeader("_self");
            MkTabHeader("$words[ESB]");
            echo "<table><form action=\"index.php\" method=\"post\">";
            MkOption ("$words[UN]", "", "extra1", "$sub[sub_user]");
            MkOption ("$words[EXD]", "", "extra2", "$sub[sub_expire]");
            MkOption ("$words[FID]", "", "extra3", "$sub[sub_file]");
            echo "<input type=\"hidden\" name=\"aform\" value=\"editdownloadsub\"><input type=\"hidden\" name=\"zid\" value=\"$sub[sub_id]\"><td><font face=\"Arial\" size=\"2\"><input type=\"submit\" value=\"$words[SND]\"></font></td></tr></table>";
            MkTabFooter();
            MkFooter();

        }

        MkHeader("_self");
        MkTabHeader("$words[SEA]");
        echo "$words[SED]";
        MkTabFooter();

        TblHeader("$words[SUD]", "$words[SUN]");

        $result = DBQuery("SELECT sub_id, sub_user, sub_file, sub_expire FROM esselbach_st_subscribers ORDER BY sub_id");

        while (list($sub_id, $sub_user, $sub_file, $sub_expire) = mysql_fetch_row($result))
        {
            TblMiddle("$sub_id", "$sub_user ($sub_file / $sub_expire)", "downloadsub&opts=editsub-$sub_id", "downloadsub&opts=deletesub-$sub_id");
        }
        TblFooter();

        MkTabHeader("$words[AGL]");
        echo "<table><form action=\"index.php\" method=\"post\">";
        MkOption ("$words[UN]", "", "extra1", "");
        MkOption ("$words[EXD]", "$words[DAT]", "extra2", "2009-12-31");
        echo "<input type=\"hidden\" name=\"extra3\" value=\"0\"><input type=\"hidden\" name=\"aform\" value=\"adddownloadsub\"><td><font face=\"Arial\" size=\"2\"><input type=\"submit\" value=\"$words[SND]\"></form></font></td></tr></table>";
        MkTabFooter();

        MkFooter();

    }

    //  ##########################################################

    function AdminVoteDownload($opts)
    {

        global $words;
        dbconnect();

        $options = explode("-", $opts);
        if ($options[0] == "deletevote")
        {

            $result = DBQuery("DELETE FROM esselbach_st_filevotes WHERE vote_id='$options[1]'");

            MkHeader("_self");
            MkTabHeader ("$words[DO]");
            echo "$words[VSR]";
            MkTabFooter();
            MkFooter();

        }

        if ($options[0] == "editvote")
        {

            $result = DBQuery("SELECT * FROM esselbach_st_filevotes WHERE vote_id='$options[1]'");
            $vote = mysql_fetch_array($result);

            MkHeader("_self");
            MkTabHeader("$words[EDV]");
            echo "<table><form action=\"index.php\" method=\"post\">";
            MkOption ("$words[UN]", "", "extra1", "$vote[vote_user]");

            echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\">$words[RAD]</font></td><td></td><td><face face=\"Arial\" size=\"2\"><select size=\"5\" name=\"extra2\">";
            for($i = 1; $i < 6; $i++)
            {
                ($i == $vote[vote_rating]) ? $sel = "selected" :
                 $sel = "";
                echo "<option $sel value=\"$i\">$i</option>";
            }
            echo "</select></font></td></tr>";

            echo "<input type=\"hidden\" name=\"aform\" value=\"editdownloadvote\"><input type=\"hidden\" name=\"zid\" value=\"$vote[vote_id]\"><td><font face=\"Arial\" size=\"2\"><input type=\"submit\" value=\"$words[SND]\"></font></td></tr></table>";
            MkTabFooter();
            MkFooter();

        }

        MkHeader("_self");
        MkTabHeader("$words[DLV]");
        echo "$words[DLD]";
        MkTabFooter();

        TblHeader("$words[VID]", "$words[FUR]");

        $result = DBQuery("SELECT vote_id, vote_file, vote_user, vote_rating FROM esselbach_st_filevotes ORDER BY vote_id DESC LIMIT 100");

        while (list($vote_id, $vote_file, $vote_user, $vote_rating) = mysql_fetch_row($result))
        {
            TblMiddle("$vote_id", "$vote_file ($vote_user / $vote_rating)", "downloadvotes&opts=editvote-$vote_id", "downloadvotes&opts=deletevote-$vote_id");
        }
        TblFooter();

        MkFooter();

    }

    //  ##########################################################

    function AdminDownloadsImages ($opts)
    {

       global $words, $admin;

        MkHeader("_self");
        MkTabHeader("$words[SRI3]");
        echo "<form action=\"index.php\" method=\"post\"><font size=\"2\" face=\"Verdana, Arial\">$words[SRC]</font>";
        echo "<input type=\"hidden\" name=\"aform\" value=\"searchdlimgs\"><input name=\"zid\" size=\"32\"><input type=\"submit\" value=\"$words[SUB]\"></form>";
        echo "<font size=\"2\" face=\"Verdana, Arial\">$words[SID3]</font>";
        MkTabFooter();

        $image_dir = GetDir("../images/downloads");

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
                echo "<a href=\"index.php?action=showdlimg&opts=$img_array[$z]\">$words[INDEX] $img_array[$z]</a> ($timages $words[IMAGE]) <br />";
            }
            MkTabFooter();

            if ((phpversion() >= "4.1.0") and ($admin[user_candownload] == 1))
            {
                MkTabHeader("$words[UPLIM]");
                echo "<form action=\"index.php\" method=\"post\" enctype=\"multipart/form-data\"><font size=\"2\" face=\"Verdana, Arial\">$words[IMF]</font>";
                echo "<input type=\"hidden\" name=\"aform\" value=\"dlimgup\"><input type=\"file\" name=\"dlifile\"><input type=\"submit\" value=\"Upload\"></form>";
                MkTabFooter();
            }

        }
        else
        {

            echo "<br />
                <script language=\"JavaScript\">
                <!--
                function AutoInsert(tag) {
                opener.document.adddownload.newstext1.value =
                opener.document.adddownload.newstext1.value + tag;
                }
                function AutoInsertExt(tag) {
                opener.document.adddownload.newstext2.value =
                opener.document.adddownload.newstext2.value + tag;
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
                            echo "<center><img src=\"../images/downloads/$image_dir[$i]\" border=\"0\" alt=\"\"><br /><br /><a href=\"javascript:AutoInsert('[img]images/downloads/$image_dir[$i][/img]')\">$words[XSI3]</a> (<a href=\"javascript:AutoInsertExt('[img]images/downloads/$image_dir[$i][/img]')\">$words[EXTEN]</a>) | <a href=\"javascript:AutoInsert('[thumb]$image_dir[$i][/thumb]')\">$words[ITHUM]</a> (<a href=\"javascript:AutoInsertExt('[thumb]$image_dir[$i][/thumb]')\">$words[EXTEN]</a>)</center>";
                            MkTabFooter();
                        }
                    }
                    else
                    {
                        if (strtoupper(substr($image_dir[$i],0,1)) == $opts)
                        {
                            MkTabHeader("$image_dir[$i]");
                            echo "<center><img src=\"../images/downloads/$image_dir[$i]\" border=\"0\" alt=\"\"><br /><br /><a href=\"javascript:AutoInsert('[img]images/downloads/$image_dir[$i][/img]')\">$words[XSI3]</a> (<a href=\"javascript:AutoInsertExt('[img]images/downloads/$image_dir[$i][/img]')\">$words[EXTEN]</a>) | <a href=\"javascript:AutoInsert('[thumb]$image_dir[$i][/thumb]')\">$words[ITHUM]</a> (<a href=\"javascript:AutoInsertExt('[thumb]$image_dir[$i][/thumb]')\">$words[EXTEN]</a>)</center>";
                            MkTabFooter();
                        }
                    }
                }
            }
            echo "<center><font face=\"Arial\" size=\"2\">[<a href=\"index.php?action=showdlimg\">$words[IMGBA]</a>]</font></center>";

        }
        echo "<center><font face=\"Arial\" size=\"2\">[<a href=\"javascript:self.close()\">$words[XSIC]</a>]</font></center>";
        MkFooter();

    }

    //  ##########################################################

    function AdminDLImgSearch ()
    {

        global $words, $zid;

        MkHeader("_self");
        MkTabHeader("$words[SRI33]");
        echo "<form action=\"index.php\" method=\"post\"><font size=\"2\" face=\"Verdana, Arial\">$words[SRC]</font>";
        echo "<input type=\"hidden\" name=\"aform\" value=\"searchdlimgs\"><input name=\"zid\" size=\"32\"><input type=\"submit\" value=\"$words[SUB]\"></form>";
        echo "<font size=\"2\" face=\"Verdana, Arial\">$words[SID3]</font>";
        MkTabFooter();

        $image_dir = GetDir("../images/downloads");

        echo "<br />
            <script language=\"JavaScript\">
            <!--
            function AutoInsert(tag) {
            opener.document.adddownload.newstext1.value =
            opener.document.adddownload.newstext1.value + tag;
            }
            function AutoInsertExt(tag) {
            opener.document.adddownload.newstext2.value =
            opener.document.adddownload.newstext2.value + tag;
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
                    echo "<center><a href=\"javascript:AutoInsert('[img]images/downloads/$image_dir[$i][/img]')\"><img src=\"../images/downloads/$image_dir[$i]\" border=\"0\" alt=\"\"><br /><br />$words[XSI3]</a> (<a href=\"javascript:AutoInsertExt('[img]images/downloads/$image_dir[$i][/img]')\">$words[EXTEN]</a>) | <a href=\"javascript:AutoInsert('[thumb]$image_dir[$i][/thumb]')\">$words[ITHUM]</a> (<a href=\"javascript:AutoInsertExt('[thumb]$image_dir[$i][/thumb]')\">$words[EXTEN]</a>)</center>";
                    MkTabFooter();
                }
            }
        }
        echo "<center><font face=\"Arial\" size=\"2\">[<a href=\"index.php?action=showdlimg\">$words[IMGBA]</a>]</font></center>";
        echo "<center><font face=\"Arial\" size=\"2\">[<a href=\"javascript:self.close()\">$words[XSIC]</a>]</font></center>";
        MkFooter();

    }

    //  ##########################################################

    function AdminPOPDownload()
    {

        global $words, $wsperfs, $configs;

        MkHeader("_self");

        MkTabHeader("$words[POP3D]");

        if (extension_loaded("imap"))
        {

            $mailserver = @imap_open ("{".$wsperfs[website_dlmailserver].":110/pop3/notls}INBOX", "$wsperfs[website_dlmailuser]", "$wsperfs[website_dlmailpw]") or die ("$words[MERRO]");
            $emails = imap_num_msg($mailserver);

            echo $emails." $words[FEMAI]<br /><br />";

            if ($emails)
            {
                for($i = $emails; $i > 0; $i--)
                {

                    $headers = imap_header($mailserver, $i);
                    $message = addslashes(imap_body($mailserver, $i));

                    $subject = addslashes($headers->Subject);
                    $from = addslashes($headers->fromaddress);
                    $email = addslashes($headers->reply_toaddress);

                    $message = str_replace("=\n", "", $message);
                    $message = str_replace("=2E", ".", $message);
                    $message = str_replace("=20", "\n", $message);
                    $message = str_replace("=91", "'", $message);
                    $message = str_replace("=92", "'", $message);
                    $message = str_replace("=93", "\"", $message);
                    $message = str_replace("=94", "\"", $message);
                    $message = str_replace("=3D", "=", $message);
                    $message = str_replace("=85", ",", $message);

                    echo $words[IEMAI]." $subject (".stripslashes($from).")<br />";
                    DBQuery("INSERT INTO esselbach_st_downloadqueue VALUES (NULL, '$configs[4]', '$from', '$email', '127.0.0.1', '$subject', '$message', now(), '', '', '', '', '', '', '', '')");

                    imap_delete($mailserver, $i);
                }

                imap_expunge ($mailserver);
            }
            imap_close($mailserver);

        }
        else
        {
            echo $words[IMAPN];
        }

        MkTabFooter();
        MkFooter();
    }

    //  ##########################################################

    function AdminRDLQueue()
    {

        global $words;
        dbconnect();

        DBQuery("DELETE FROM esselbach_st_downloadqueue");

        MkHeader("_self");
        MkTabHeader ("$words[DO]");
        echo "$words[QED]";
        MkTabFooter();
        MkFooter();

    }

    //  ##########################################################

    function AdminDLQueue($opts)
    {

        global $words;
        dbconnect();

        $options = explode("-", $opts);
        if ($options[0] == "deleteqdownload")
        {

            $result = DBQuery("DELETE FROM esselbach_st_downloadqueue WHERE downloadq_id='$options[1]'");

            MkHeader("_self");
            MkTabHeader ("$words[DO]");
            echo "$words[QSR]";
            MkTabFooter();
            MkFooter();

        }

        if ($options[0] == "addqdownload")
        {

            $result = DBQuery("SELECT * FROM esselbach_st_downloadqueue WHERE downloadq_id='$options[1]'");
            $dldata = mysql_fetch_array($result);

            $dldata[downloadq_author] = htmlentities(ScriptEx($dldata[downloadq_author]));

            if ($dldata[downloadq_authormail])
            {
                $dldata[downloadq_authormail] = htmlentities(ScriptEx($dldata[downloadq_authormail]));
                $amail = "<a href=\"mailto:$dldata[downloadq_authormail]\"><img src=\"../images/email.png\" border=\"0\"></a>";
            }

            MkHeader("_self");
            MkTabHeader ("$words[ADL]");

            echo "<table><form name=\"adddownload\" action=\"index.php\" method=\"post\">";
            echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\">$words[SMY]</font></td><td></td><td><font face=\"Arial\" size=\"2\">$dldata[downloadq_author] $amail ($words[TIP] $dldata[downloadq_authorip]) $dldata[downloadq_time]</font></td></tr>";

            $query = DBQuery("SELECT website_id, website_name FROM esselbach_st_websites");
            if (mysql_num_rows($query) > 1)
            {

                echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\">$words[WBS]</font></td><td></td><td><face face=\"Arial\" size=\"2\"><select size=\"1\" name=\"website\">";

                echo "<option value=\"0\">$words[ALL]</option>";
                while (list($website_id, $website_name) = mysql_fetch_row($query))
                {
                    ($website_id == $dldata['downloadq_website']) ? $select = "selected" :
                     $select = "";
                    echo "<option $select value=\"$website_id\">$website_name</option>";
                }

                echo "</select></font></td></tr>";
            }

            MkOption ("$words[TIT]", "", "newstitle", "$dldata[downloadq_title]");
            MkSelect ("$words[PUBLI]", "extrag13", "0");

            echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\">$words[CAT]</font></td><td></td><td><face face=\"Arial\" size=\"2\"><select size=\"1\" name=\"category\">";

            $query = DBQuery("SELECT downloadscat_id, downloadscat_name FROM esselbach_st_downloadscat");
            while (list($downloadscat_id, $downloadscat_name) = mysql_fetch_row($query))
            {
                echo "<option value=\"$downloadscat_id\">$downloadscat_name</option>";
            }

            echo "</select></font></td></tr>";

            echo "<script language=\"JavaScript\">
                <!--
                function AutoInsert1(tag) {
                document.adddownload.newstext1.value =
                document.adddownload.newstext1.value + tag;
                }
                function AutoInsert2(tag) {
                document.adddownload.newstext2.value =
                document.adddownload.newstext2.value + tag;
                }
                function OpenWin() {
                var newWinObj = window.open('index.php?action=showdlimg','newWin','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=1,copyhistory=0,width=800,height=600')
                }
                //-->
                </script>";

            QuickHTML(1);

            MkArea ("$words[DSC]", "newstext1", "$dldata[downloadq_text]");

            QuickHTML(2);

            MkArea ("$words[XDC]", "newstext2", "");

            MkSelect ("$words[EHT]", "htmlen", "0");
            MkSelect ("$words[EIS]", "iconen", "1");
            MkSelect ("$words[EBC]", "codeen", "1");

            MkOption ("$words[UR1]", "", "extrae1", "$dldata[downloadq_url1]");
            MkOption ("$words[UR2]", "", "extrae2", "$dldata[downloadq_url2]");
            MkOption ("$words[UR3]", "", "extrae3", "$dldata[downloadq_url3]");
            MkOption ("$words[UR4]", "", "extrae4", "$dldata[downloadq_url4]");
            MkOption ("$words[UR5]", "", "extrae5", "$dldata[downloadq_url5]");
            MkOption ("$words[UR6]", "", "extrae6", "$dldata[downloadq_url6]");
            MkOption ("$words[UR7]", "", "extrae7", "$dldata[downloadq_url7]");
            MkOption ("$words[UR8]", "", "extrae8", "$dldata[downloadq_url8]");

            MkSelect ("$words[SUO]", "extrad1", "");
            MkSelect ("$words[ECO]", "commen", "1");

            $query = DBQuery("SELECT * FROM esselbach_st_fields WHERE field_id='2'");
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

            echo "<input type=\"hidden\" name=\"aform\" value=\"dodownloadadd\"><td><font face=\"Arial\" size=\"2\"><input type=\"submit\" value=\"$words[SUB]\"></font></form></td></tr></table>";

            MkTabFooter();
            MkTabHeader("$words[SRI3]");
            echo "$words[UPV3]";
            MkTabFooter();
            MkFooter();
        }

        MkHeader("_self");
        MkTabHeader("$words[DQR] <a href=\"index.php?action=removedqueue\"><img src=\"../images/delete.png\" border=\"0\" alt=\"$words[DNQ2]\"></a>");
        echo "$words[DQI2]";
        MkTabFooter();

        TblHeader("$words[FSI]", "$words[TIT]");

        $result = DBQuery("SELECT downloadq_website, downloadq_title, downloadq_id FROM esselbach_st_downloadqueue ORDER BY downloadq_id DESC LIMIT 100");

        while (list($dlq_website, $dlq_title, $dlq_id) = mysql_fetch_row($result))
        {
            TblMiddle("$dlq_id / $dlq_website", "$dlq_title", "dlqueue&opts=addqdownload-$dlq_id", "dlqueue&opts=deleteqdownload-$dlq_id");
        }

        MkFooter();

    }

    //  ##########################################################

    function SearchFiles ()
    {

        global $words, $zid;

        MkHeader("_self");
        MkTabHeader($words[EDF]);
        echo "<form action=\"index.php\" method=\"post\"><font size=\"2\" face=\"Verdana, Arial\">$words[SR]:</font>";
        echo "<input name=\"zid\" size=\"32\" value=\"$zid\"><input type=\"submit\" value=\"$words[SM]\"><input type=\"hidden\" name=\"aform\" value=\"searchfiles\"></form>";
        MkTabFooter();

        $szid = stripslashes($zid);

        TblHeader("$words[FSI]", "$words[FTW] $szid");

        $result = DBQuery("SELECT download_website, download_title, download_id, download_hook FROM esselbach_st_downloads WHERE (download_title like '%$zid%') ORDER BY download_id DESC LIMIT 100");

        while (list($download_website, $download_title, $download_id, $download_hook) = mysql_fetch_row($result))
        {
            $download_title = ReChomp($download_title);
            if ($download_hook)
            {
                $download_title = "<font color=\"red\">$download_title</font>";
            }
            TblMiddle("$download_id / $download_website", "$download_title", "editdownload&opts=editdownload-$download_id", "editdownload&opts=deletedownload-$download_id");
        }

        MkFooter();

    }

    //  ##########################################################

    function DownloadEdit ()
    {

        global $words, $admin, $zid, $newstitle, $website, $category, $newstext1, $extrae1, $extrae2, $extrae3, $extrae4, $extrae5, $extrae6, $extrae7, $extrae8, $newstext2, $extra1, $extra2, $extra3, $extra4, $extra5, $extra6, $extra7, $extra8, $extra9, $extra10, $extra11, $extra12, $extra13, $extra14, $extra15, $extra16, $extra17, $extra18, $extra19, $extra20, $htmlen, $iconen, $codeen, $ipaddr, $extrad1, $commen, $extrae12, $extrae9, $extrag13, $bump;

        if ($admin[user_candownload] == 2)
        {
            $result = DBQuery("SELECT download_author FROM esselbach_st_downloads WHERE download_id = '$zid'");
            list($dlauthor) = mysql_fetch_row($result);

            if ($dlauthor != $admin[user_name])
            {
                MkHeader("_self");
                MkTabHeader ("$words[ERR]");
                echo "$words[RDOWN]";
                MkTabFooter();
                MkFooter();
            }
        }

        DBQuery("UPDATE esselbach_st_downloads SET
            download_title='$newstitle', download_website='$website', download_category='$category',
            download_text='$newstext1', download_url1='$extrae1', download_url2='$extrae2', download_url3='$extrae3',
            download_url4='$extrae4', download_url5='$extrae5', download_url6='$extrae6',
            download_url7='$extrae7', download_url8='$extrae8', download_extendedtext='$newstext2',
            download_extra1='$extra1', download_extra2='$extra2', download_extra3='$extra3',
            download_extra4='$extra4', download_extra5='$extra5', download_extra6='$extra6',
            download_extra7='$extra7', download_extra8='$extra8', download_extra9='$extra9',
            download_extra10='$extra10', download_extra11='$extra11', download_extra12='$extra12',
            download_extra13='$extra13', download_extra14='$extra14', download_extra15='$extra15',
            download_extra16='$extra16', download_extra17='$extra17', download_extra18='$extra18',
            download_extra19='$extra19', download_extra20='$extra20', download_html='$htmlen',
            download_icon='$iconen', download_code='$codeen', download_editip='$ipaddr',
            download_sub='$extrad1', download_comm='$commen', download_editreason='$extrae12',
            download_hook='$extrag13' WHERE download_id='$zid'");

        if (!$extrag13)
        {
            UpdateIndex ($zid, $website, 4, $newstitle, $newstext1.$newstext2);
        }

        if ($extrae9)
        {
            DBQuery("UPDATE esselbach_st_downloads SET download_count='0' WHERE download_id=$zid");
        }

        if ($bump)
        {
            DBQuery("UPDATE esselbach_st_downloads SET download_time=now() WHERE download_id=$zid");
        }

        $result = DBQuery("SELECT download_comments FROM esselbach_st_downloads WHERE download_id = '$zid'");
        list($comments) = mysql_fetch_row($result);
        $pages = $comments/25;
        $pages++;
        for($p = 0; $p < $pages; $p++)
        {
            $tp = $p + 1;
            RemoveCache ("downloaddet/download-$zid-$tp");
        }

        for($a = 1; $a < 27; $a++)
        {
            RemoveCache ("download/download-$category-$a");
        }

        RemoveCache ("downloaddet/download-$zid-1");
        RemoveCache ("tags/download-$zid");
        RemoveCache ("xml/xmlnews-120");
        RemoveCache ("news/comments");

        MkHeader("_self");
        MkTabHeader ("$words[DO]");
        echo "$words[FSC]";
        MkTabFooter();
        MkFooter();

    }

    //  ##########################################################

    function DownloadAdd ()
    {

        global $words, $website, $category, $admin, $newstitle, $newstext1, $extrae1, $extrae2, $extrae3, $extrae4, $extrae5, $extrae6, $extrae7, $extrae8, $newstext2, $extra1, $extra2, $extra3, $extra4, $extra5, $extra6, $extra7, $extra8, $extra9, $extra10, $extra11, $extra12, $extra13, $extra14, $extra15, $extra16, $extra17, $extra18, $extra19, $extra20, $htmlen, $iconen, $codeen, $ipaddr, $extrad1, $extrag13, $commen;

        DBQuery("INSERT INTO esselbach_st_downloads VALUES (NULL, '$website', '$category', '$admin[user_name]','$newstitle', '$newstext1', '$extrae1', '$extrae2', '$extrae3', '$extrae4', '$extrae5', '$extrae6', '$extrae7', '$extrae8', '0',
            '$newstext2', now(), '0', '$extra1', '$extra2', '$extra3', '$extra4', '$extra5', '$extra6', '$extra7', '$extra8', '$extra9', '$extra10', '$extra11', '$extra12', '$extra13', '$extra14', '$extra15', '$extra16', '$extra17', '$extra18', '$extra19', '$extra20', '$htmlen', '$iconen', '$codeen', '$ipaddr', '$ipaddr', '$extrad1', '$extrag13', '$commen', '')");

        $result = DBQuery("SELECT download_id, download_time FROM esselbach_st_downloads ORDER BY download_id DESC LIMIT 1");
        list($id, $time) = mysql_fetch_row($result);

        if (!$extrag13)
        {
            AddIndex ($id, $website, 4, $admin[user_name], $newstitle, $newstext1.$newstext2, $time);
        }

        RemoveCache ("downloaddet/download-$zid");

        for($a = 1; $a < 27; $a++)
        {
            RemoveCache ("download/download-$category-$a");
        }

        RemoveCache ("download/download");
        RemoveCache ("xml/xmlnews-120");
        RemoveCache ("xml/xmlhelp");

        MkHeader("_self");
        MkTabHeader ("$words[DO]");
        echo $words[FS];
        MkTabFooter();
        MkFooter();

    }

    //  ##########################################################

    function DLImgUp()
    {

        global $words;

        if (phpversion() >= "4.1.0")
        {
            $upfile = strtolower($_FILES[dlifile][name]);
            if (!preg_match("/(.gif|.jpg|.jpeg|.png)/i", substr($upfile,-4)))
            {
                MkHeader("_self");
                MkTabHeader ("$words[ERR]");
                echo $words[IA];
                MkTabFooter();
                echo "<center><font face=\"Arial\" size=\"2\">[<a href=\"index.php?action=showdlimg\">$words[IMGBA]</a>]</font></center>";
                echo "<center><font face=\"Arial\" size=\"2\">[<a href=\"javascript:self.close()\">$words[XSIC]</a>]</font></center>";
                MkFooter();
            }
            if ($_FILES[dlifile][size] > 250000)
            {
                MkHeader("_self");
                MkTabHeader ("$words[ERR]");
                echo $words[WB];
                MkTabFooter();
                echo "<center><font face=\"Arial\" size=\"2\">[<a href=\"index.php?action=showdlimg\">$words[IMGBA]</a>]</font></center>";
                echo "<center><font face=\"Arial\" size=\"2\">[<a href=\"javascript:self.close()\">$words[XSIC]</a>]</font></center>";
                MkFooter();
            }
            if (move_uploaded_file($_FILES[dlifile][tmp_name], "../images/downloads/".$upfile))
            {
                @chmod ("../images/downloads/$upfile", 0777);
                MkHeader("_self");
                MkTabHeader ("$words[DO]");
                echo $words[IS];
                MkTabFooter();
                echo "<center><font face=\"Arial\" size=\"2\">[<a href=\"index.php?action=showdlimg\">$words[IMGBA]</a>]</font></center>";
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

    function AddDownloadCat ()
    {

        global $words, $category, $categorydsc;

        DBQuery("INSERT INTO esselbach_st_downloadscat VALUES (NULL, '$category', '$categorydsc')");

        MkHeader("_self");
        MkTabHeader ("$words[DO]");
        echo $words[CA];
        MkTabFooter();
        MkFooter();

    }

    //  ##########################################################

    function EditDownloadCat ()
    {

        global $words, $category, $categorydsc, $zid;

        DBQuery("UPDATE esselbach_st_downloadscat SET downloadscat_name='$category', downloadscat_desc='$categorydsc' WHERE downloadscat_id = '$zid'");

        MkHeader("_self");
        MkTabHeader ("$words[DO]");
        echo $words[CU];
        MkTabFooter();
        MkFooter();
    }

    //  ##########################################################

    function EditDownloadVote ()
    {

        global $words, $zid, $extra1, $extra2;

        DBQuery("UPDATE esselbach_st_filevotes SET vote_user='$extra1', vote_rating='$extra2' WHERE vote_id = '$zid'");

        $result = DBQuery("SELECT download_comments, download_category FROM esselbach_st_downloads WHERE download_id = '$zid'");
        list($comments, $cat) = mysql_fetch_row($result);
        $pages = $comments/25;
        $pages++;
        for($p = 0; $p < $pages; $p++)
        {
            $tp = $p + 1;
            RemoveCache ("downloaddet/download-$vfile-$tp");
        }
        for($a = 1; $a < 27; $a++)
        {
            RemoveCache ("download/download-$cat-$a");
        }
        MkHeader("_self");
        MkTabHeader ("$words[DO]");
        echo $words[FX];
        MkTabFooter();
        MkFooter();
    }

    //  ##########################################################

    function AddDownloadSub ()
    {

        global $words, $admin, $extra1, $extra2, $extra3, $ipaddr;

        $ddate = explode("-", $extra2);
        if ($ddate[0] > 2030) $ddate[0] = "2030";
        $extra2 = "$ddate[0]-$ddate[1]-$ddate[2]";

        DBQuery("INSERT INTO esselbach_st_subscribers VALUES (NULL, '$admin[user_name]', '$extra1', '$extra3', '$extra2', '$ipaddr', '$ipaddr')");

        MkHeader("_self");
        MkTabHeader ("$words[DO]");
        echo $words[BA];
        MkTabFooter();
        MkFooter();

    }

    //  ##########################################################

    function EditDownloadSub ()
    {

        global $words, $extra1, $extra2, $extra3, $ipaddr, $zid;

        $ddate = explode("-", $extra2);
        if ($ddate[0] > 2030) $ddate[0] = "2030";
        $extra2 = "$ddate[0]-$ddate[1]-$ddate[2]";

        DBQuery("UPDATE esselbach_st_subscribers SET sub_user='$extra1', sub_file='$extra3', sub_expire='$extra2', sub_editip='$ipaddr' WHERE sub_id = '$zid'");

        MkHeader("_self");
        MkTabHeader ("$words[DO]");
        echo $words[BU];
        MkTabFooter();
        MkFooter();
    }

    //  ##########################################################

    function ShowLeechers($opts)
    {

        global $words;
        dbconnect();

        if ($opts == "clear")
        {

            DBQuery("DELETE FROM esselbach_st_leechattempts");

            MkHeader("_self");
            MkTabHeader ("$words[DO]");
            echo "$words[DLLSL]";
            MkTabFooter();
            MkFooter();

        }

        if ($opts)
        {

            $result = DBQuery("SELECT leech_ref FROM esselbach_st_leechattempts WHERE leech_id='$opts'");
            list ($leech_site) = mysql_fetch_row($result);
            $sitesplit = explode("/",$leech_site);

            $result = DBQuery("SELECT * FROM esselbach_st_leechattempts WHERE (leech_ref LIKE '%$sitesplit[2]%')");
            $prepmessage = $words[DLEML];

            while ($out = mysql_fetch_array($result))
            {
                $prepmessage .= $out[leech_ref]." (".$out[leech_attempts]." ".$words[DLLAT].")\n";
            }

            $prepmessage .= $words[DLEME];

            MkHeader("_self");
            MkTabHeader("$words[DLSND] webmaster@$sitesplit[2]");

            echo "<table><form action=\"index.php\" method=\"post\">";

            MkOption ("$words[DLSUB]", "", "newstitle", "$leech_site");

            MkArea ("$words[DLMSG]", "newstext1", "$prepmessage");

            echo "<tr><td></td></tr> <input type=\"hidden\" name=\"aform\" value=\"dosendleech\"><input type=\"hidden\" name=\"zid\" value=\"$sitesplit[2]\"><td><font face=\"Arial\" size=\"2\"><input type=\"submit\" value=\"$words[SND]\"></font></td></tr></table>";
            MkTabFooter();
            MkFooter();

        }


        MkHeader("_self");
        MkTabHeader("$words[DLLEE]");
        echo "$words[DLLDS]";
        MkTabFooter();

        TblHeader("$words[DLATT]", "$words[DLREF] <a href=\"index.php?action=downloadleechers&opts=clear\"><img src=\"../images/delete.png\" border=\"0\" alt=\"$words[CLLIS]\"></a>");

        $result = DBQuery("SELECT leech_id, leech_website, leech_fid, leech_file, leech_ref, leech_attempts FROM esselbach_st_leechattempts ORDER BY leech_attempts DESC LIMIT 100");

        while (list($leech_id, $leech_website, $leech_fid, $leech_file, $leech_ref, $leech_attempts) = mysql_fetch_row($result))
        {
            ($bgcolor == "#ffffff") ? $bgcolor = "#eeeeee" :
             $bgcolor = "#ffffff";
            echo "<tr bgcolor=\"$bgcolor\">
                <td align=\"left\" width=\"15%\">
                <font size=\"2\" color=\"#000000\" face=\"Verdana, Arial\">
                $leech_attempts
                </font>
                </td>
                <td align=\"left\" width=\"75%\">
                <font size=\"2\" color=\"#000000\" face=\"Verdana, Arial\">
                $leech_ref ($leech_website / $leech_fid / $leech_file)
                </font>
                </td>
                <td align=\"center\" width=\"10%\">
                <font size=\"2\" color=\"#000000\" face=\"Verdana, Arial\">
                <a href=\"index.php?action=downloadleechers&opts=$leech_id\">
                <img src=\"../images/email.png\" border=\"0\">
                </a>
                </font>
                </td>
                </tr>";
        }
        echo "</table>
            </td>
            </tr>
            </table>
            <br />";
        MkFooter();

    }

    //  ##########################################################

    function SendLeechMail ()
    {

        global $words, $admin, $website, $newstitle, $newstext1, $zid;

        $email = "webmaster@".$zid;
        $headers = MailHeader("$admin[user_name]","$admin[user_email]","$email","$email");

        mail($email, $newstitle, $newstext1, $headers);

        MkHeader("_self");
        MkTabHeader ("$words[DO]");
        echo $words[DLMES];
        MkTabFooter();
        MkFooter();

    }

    //  ##########################################################

    function ShowBroken($opts)
    {

        global $words;
        dbconnect();

        if ($opts == "clear")
        {

            DBQuery("DELETE FROM esselbach_st_brokenlinks");

            MkHeader("_self");
            MkTabHeader ("$words[DO]");
            echo "$words[BROSL]";
            MkTabFooter();
            MkFooter();

        }

        MkHeader("_self");
        MkTabHeader("$words[BROIN] <a href=\"index.php?action=brokenlinks&opts=clear\"><img src=\"../images/delete.png\" border=\"0\" alt=\"$words[CLLIS]\"></a>");
        echo "$words[BRODS]";
        MkTabFooter();

        $result = DBQuery("SELECT broken_id, broken_website, broken_file, broken_user, broken_comments, broken_ip FROM esselbach_st_brokenlinks ORDER BY broken_id DESC LIMIT 100");

        while (list($broken_id, $broken_website, $broken_file, $broken_user, $broken_comments, $broken_ip) = mysql_fetch_row($result))
        {
            MkTabHeader("<b>$broken_file</b> ($broken_website) $words[BRORP] $broken_user");
            echo "$broken_comments<br /><br />IP: $broken_ip";
            MkTabFooter();
        }

        MkFooter();

    }

    //  ##########################################################

    function AdminSearchDL()
    {

        global $words;

        MkHeader("_self");
        MkTabHeader("$words[NEWDL]");
        echo "<form action=\"index.php\" method=\"post\"><font size=\"2\" face=\"Verdana, Arial\">$words[FOS]</font><br />";
        echo "<input type=\"hidden\" name=\"aform\" value=\"searchreplacedl\"><textarea cols=\"100%\" name=\"zid\" rows=\"2\"></textarea><br />";
        echo "$words[INFLD] <select size=\"1\" name=\"extra2\"><option value=\"title\">title</option><option value=\"text\">text</option><option value=\"extendedtext\">extendedtext</option>";
        for($i = 1; $i < 9; $i++)
        {
            echo "<option value=\"url".$i."\">url".$i."</option>";
        }
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

    function DLSearchReplace ()
    {

        global $words, $zid, $extra1, $extra2, $ipaddr;

        MkHeader("_self");
        MkTabHeader ("$words[DO]");

        $search_field = "download_".$extra2;
        $query = DBQuery("SELECT * FROM esselbach_st_downloads WHERE ($search_field LIKE '%$zid%')");

        $totalrows = 0;
        while ($rows = mysql_fetch_array($query))
        {
            $out_field = str_replace("$zid", "$extra1", $rows[$search_field]);
            DBQuery("UPDATE esselbach_st_downloads SET $search_field = '$out_field', download_editip = '$ipaddr' WHERE download_id = '$rows[download_id]'");
            $totalrows++;
        }

        echo $totalrows." ".$words[ENTCH];

        ClearCache("news");
        ClearCache("download");
        ClearCache("downloaddet");
        ClearCache("tags");

        MkTabFooter();
        MkFooter();

    }

?>
