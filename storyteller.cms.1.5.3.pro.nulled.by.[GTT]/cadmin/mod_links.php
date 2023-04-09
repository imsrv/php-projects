<?php

    /*
    ########################
    # |//////////////////| #
    # NULLED by [GTT] =)   #
    # |\\\\\\\\\\\\\\\\\\| #
    ########################
    */

    function AdminEditLinks($opts)
    {

        global $words;
        dbconnect();

        $options = explode("-", $opts);
        if ($options[0] == "deletelink")
            {

            $result = DBQuery("DELETE FROM esselbach_st_links WHERE link_id='$options[1]'");

            MkHeader("_self");
            MkTabHeader ("$words[DO]");
            echo "$words[LSR]";
            MkTabFooter();
            MkFooter();

        }

        if ($options[0] == "editlink")
            {

            $result = DBQuery("SELECT * FROM esselbach_st_links WHERE link_id='$options[1]'");
            $link = mysql_fetch_array($result);

            MkHeader("_self");
            MkTabHeader("$words[EDL] $options[1]");

            echo "<table><form action=\"index.php\" method=\"post\">";

            $query = DBQuery("SELECT website_id, website_name FROM esselbach_st_websites");
            if (mysql_num_rows($query) > 1)
                {
                echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\">$words[WBS]</font></td><td></td><td><face face=\"Arial\" size=\"2\"><select size=\"1\" name=\"website\">";
                echo "<option value=\"0\">$words[ALL]</option>";
                while (list($website_id, $website_name) = mysql_fetch_row($query))
                {
                    ($website_id == $link['link_website']) ? $select = "selected" :
                    $select = "";
                    echo "<option $select value=\"$website_id\">$website_name</option>";
                }

                echo "</select></font></td></tr>";
            }

            echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\">$words[CAT]</font></td><td></td><td><face face=\"Arial\" size=\"2\"><select size=\"1\" name=\"category\">";

            $query = DBQuery("SELECT linkcat_id, linkcat_name FROM esselbach_st_linkscat");
            while (list($linkcat_id, $linkcat_name) = mysql_fetch_row($query))
            {
                ($linkcat_id == $link['link_category']) ? $select = "selected" :
                $select = "";
                echo "<option $select value=\"$linkcat_id\">$linkcat_name</option>";
            }

            echo "</select></font></td></tr>";

            MkOption ("$words[TIT]", "", "newstitle", "$link[link_title]");
            MkOption ("$words[UWH]", "", "newstext1", "$link[link_url]");

            echo "<input type=\"hidden\" name=\"aform\" value=\"dolinkedit\"><input type=\"hidden\" name=\"zid\" value=\"$link[link_id]\"><td><font face=\"Arial\" size=\"2\"><input type=\"submit\" value=\"$words[SND]\"></font></td></tr></table>";
            MkTabFooter();
            MkFooter();
        }

        MkHeader("_self");
        MkTabHeader("$words[EAL]");
        echo "$words[AAL]";
        MkTabFooter();

        TblHeader("$words[LSI]", "$words[LIT]");

        $result = DBQuery("SELECT link_website, link_title, link_url, link_id FROM esselbach_st_links ORDER BY link_id DESC");

        while (list($link_website, $link_title, $link_url, $link_id) = mysql_fetch_row($result))
        {
            TblMiddle("$link_id / $link_website", "$link_title ($link_url)", "editlinks&opts=editlink-$link_id", "editlinks&opts=deletelink-$link_id");
        }

        TblFooter();

        MkTabHeader("$words[ANL]");
        echo "<table><form action=\"index.php\" method=\"post\">";

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

        echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\">$words[CAT]</font></td><td></td><td><face face=\"Arial\" size=\"2\"><select size=\"1\" name=\"category\">";

        $query = DBQuery("SELECT linkcat_id, linkcat_name FROM esselbach_st_linkscat");
        while (list($linkcat_id, $linkcat_name) = mysql_fetch_row($query))
        {
            echo "<option value=\"$linkcat_id\">$linkcat_name</option>";
        }

        echo "</select></font></td></tr>";

        MkOption ("$words[TIT]", "", "newstitle", "");
        MkOption ("$words[UWH]", "", "newstext1", "");

        echo "<input type=\"hidden\" name=\"aform\" value=\"addlink\"><td><font face=\"Arial\" size=\"2\"><input type=\"submit\" value=\"$words[SND]\"></font></td></tr></table>";
        MkTabFooter();

        MkFooter();

    }

    //  ##########################################################

    function AdminCatLinks($opts)
    {

        global $words;
        dbconnect();

        $options = explode("-", $opts);
        if ($options[0] == "deletecat")
            {

            if ($options[1] > 1)
                {
                $result = DBQuery("DELETE FROM esselbach_st_linkscat WHERE linkcat_id='$options[1]'");

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

            $result = DBQuery("SELECT * FROM esselbach_st_linkscat WHERE linkcat_id='$options[1]'");
            $cat = mysql_fetch_array($result);

            MkHeader("_self");
            MkTabHeader("$words[EDC]");
            echo "<table><form action=\"index.php\" method=\"post\">";
            MkOption ("$words[CNA]", "", "category", "$cat[linkcat_name]");
            MkOption ("$words[DSC]", "", "categorydsc", "$cat[linkcat_desc]");
            echo "<input type=\"hidden\" name=\"aform\" value=\"editlinkcat\"><input type=\"hidden\" name=\"zid\" value=\"$cat[linkcat_id]\"><td><font face=\"Arial\" size=\"2\"><input type=\"submit\" value=\"$words[SND]\"></font></td></tr></table>";
            MkTabFooter();
            MkFooter();

        }

        MkHeader("_self");
        MkTabHeader("$words[EDC]");
        echo "$words[EDD]";
        MkTabFooter();

        TblHeader("$words[CID]", "$words[CNA]");

        $result = DBQuery("SELECT linkcat_id, linkcat_name FROM esselbach_st_linkscat ORDER BY linkcat_id");

        while (list($linkcat_id, $linkcat_title) = mysql_fetch_row($result))
        {
            TblMiddle("$linkcat_id", "$linkcat_title", "linkcat&opts=editcat-$linkcat_id", "linkcat&opts=deletecat-$linkcat_id");
        }
        TblFooter();

        MkTabHeader("$words[AAC]");
        echo "<table><form action=\"index.php\" method=\"post\">";
        MkOption ("$words[CNA]", "", "category", "");
        MkOption ("$words[DSC]", "", "categorydsc", "");
        echo "<input type=\"hidden\" name=\"aform\" value=\"addlinkcat\"><td><font face=\"Arial\" size=\"2\"><input type=\"submit\" value=\"$words[SND]\"></font></td></tr></table>";
        MkTabFooter();

        MkFooter();

    }

    //  ##########################################################

    function EditLink ()
    {

        global $words, $newstitle, $website, $zid, $newstext1, $category, $ipaddr;

        $result = DBQuery("UPDATE esselbach_st_links SET link_title='$newstitle', link_website='$website', link_category='$category', link_url='$newstext1', link_editip='$ipaddr' WHERE link_id='$zid'");

        RemoveCache("links/link");

        MkHeader("_self");
        MkTabHeader ("$words[DO]");
        echo $words[LU];
        MkTabFooter();
        MkFooter();

    }

    //  ##########################################################

    function AddLink ()
    {

        global $words, $newstitle, $website, $admin, $newstext1, $category, $ipaddr;

        $result = DBQuery("INSERT INTO esselbach_st_links VALUES (NULL, '$admin[user_name]', '$website', '$category', '$newstitle', '$newstext1', '$ipaddr', '$ipaddr')");

        RemoveCache("links/link");

        MkHeader("_self");
        MkTabHeader ("$words[DO]");
        echo $words[LA2];
        MkTabFooter();
        MkFooter();

    }

    //  ##########################################################

    function AddLinkCat ()
    {

        global $words, $category, $categorydsc;

        $result = DBQuery("INSERT INTO esselbach_st_linkscat VALUES (NULL, '$category', '$categorydsc')");

        MkHeader("_self");
        MkTabHeader ("$words[DO]");
        echo $words[LCA];
        MkTabFooter();
        MkFooter();

    }

    //  ##########################################################

    function EditLinkCat ()
    {

        global $words, $category, $categorydsc, $zid;

        $result = DBQuery("UPDATE esselbach_st_linkscat SET linkcat_name='$category', linkcat_desc='$categorydsc' WHERE linkcat_id = '$zid'");

        MkHeader("_self");
        MkTabHeader ("$words[DO]");
        echo $words[LCU];
        MkTabFooter();
        MkFooter();
    }

    //  ##########################################################

    function AdminRLQueue()
    {

        global $words;
        dbconnect();

        DBQuery("DELETE FROM esselbach_st_linksqueue");

        MkHeader("_self");
        MkTabHeader ("$words[DO]");
        echo "$words[QED]";
        MkTabFooter();
        MkFooter();

    }

    //  ##########################################################

    function AdminLinkQueue($opts)
    {

        global $words;
        dbconnect();

        $options = explode("-", $opts);
        if ($options[0] == "deleteqlink")
        {

            $result = DBQuery("DELETE FROM esselbach_st_linksqueue WHERE linkq_id='$options[1]'");

            MkHeader("_self");
            MkTabHeader ("$words[DO]");
            echo "$words[QSR]";
            MkTabFooter();
            MkFooter();

        }

        if ($options[0] == "addqlink")
        {

            $result = DBQuery("SELECT * FROM esselbach_st_linksqueue WHERE linkq_id='$options[1]'");
            $linkdata = mysql_fetch_array($result);

            $linkdata[linkq_author] = htmlentities(ScriptEx($linkdata[linkq_author]));

            if ($linkdata[linkq_authormail])
            {
                $linkdata[linkq_authormail] = htmlentities(ScriptEx($linkdata[linkq_authormail]));
                $amail = "<a href=\"mailto:$linkdata[linkq_authormail]\"><img src=\"../images/email.png\" border=\"0\"></a>";
            }

            MkHeader("_self");

            MkTabHeader("$words[ANL]");
            echo "<table><form action=\"index.php\" method=\"post\">";
            echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\">$words[SMY]</font></td><td></td><td><font face=\"Arial\" size=\"2\">$linkdata[linkq_author] $amail ($words[TIP] $linkdata[linkq_authorip]) $linkdata[linkq_time]</font></td></tr>";

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

            echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\">$words[CAT]</font></td><td></td><td><face face=\"Arial\" size=\"2\"><select size=\"1\" name=\"category\">";

            $query = DBQuery("SELECT linkcat_id, linkcat_name FROM esselbach_st_linkscat");
            while (list($linkcat_id, $linkcat_name) = mysql_fetch_row($query))
            {
                echo "<option value=\"$linkcat_id\">$linkcat_name</option>";
            }

            echo "</select></font></td></tr>";

            MkOption ("$words[TIT]", "", "newstitle", "$linkdata[linkq_name]");
            MkOption ("$words[UWH]", "", "newstext1", "$linkdata[linkq_desc]");

            echo "<input type=\"hidden\" name=\"aform\" value=\"addlink\"><td><font face=\"Arial\" size=\"2\"><input type=\"submit\" value=\"$words[SND]\"></font></td></tr></table>";
            MkTabFooter();

            MkFooter();

        }

        MkHeader("_self");
        MkTabHeader("$words[LINQR] <a href=\"index.php?action=removelqueue\"><img src=\"../images/delete.png\" border=\"0\" alt=\"$words[DSFLQ]\"></a>");
        echo "$words[DQIR4]";
        MkTabFooter();

        TblHeader("$words[LSI]", "$words[LIT]");

        $result = DBQuery("SELECT linkq_website, linkq_name, linkq_desc, linkq_id FROM esselbach_st_linksqueue ORDER BY linkq_id DESC LIMIT 100");

        while (list($link_website, $link_title, $link_link, $link_id) = mysql_fetch_row($result))
        {
            TblMiddle("$link_id / $link_website", "$link_title ($link_link)", "linkqueue&opts=addqlink-$link_id", "linkqueue&opts=deleteqlink-$link_id");
        }

        MkFooter();

    }

?>
