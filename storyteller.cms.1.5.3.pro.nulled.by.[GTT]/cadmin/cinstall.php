<?php

    /*
    ########################
    # |//////////////////| #
    # NULLED by [GTT] =)   #
    # |\\\\\\\\\\\\\\\\\\| #
    ########################
    */

    include("../core.php");
    include("mod_words.php");

    //  ##########################################################

    if ($estc)
    {
        MkHeader("_self");
        MkTabHeader("$words[TINS]");
        echo $words[AESI];
        MkTabFooter();
        MkFooter();
    }

    if (phpversion() >= "4.1.0")
    {
        $aform = $_POST["aform"];
        $extra1 = $_POST["extra1"];
        $extra2 = $_POST["extra2"];
        $extra3 = $_POST["extra3"];
        $extra4 = $_POST["extra4"];
        $extra5 = $_POST["extra5"];
        $extra6 = $_POST["extra6"];
        $extra7 = $_POST["extra7"];
        $extra8 = $_POST["extra8"];
        $extra9 = $_POST["extra9"];
        $extra10 = $_POST["extra10"];
        $extra11 = $_POST["extra11"];
        $extra12 = $_POST["extra12"];
        $extra13 = $_POST["extra13"];
        $extra14 = $_POST["extra14"];
        $extra15 = $_POST["extra15"];
        $extra16 = $_POST["extra16"];
        $extra17 = $_POST["extra17"];
        $extra18 = $_POST["extra18"];
        $extra19 = $_POST["extra19"];
        $extra20 = $_POST["extra20"];
        $extra21 = $_POST["extra21"];
        $extra22 = $_POST["extra22"];
        $extra23 = $_POST["extra23"];
        $action = $_GET["action"];
    }

    if ($aform != "doinstall")
    {

        if ($action != "next")
        {

            MkHeader("_self");
            MkTabHeader("$words[TINS]");
            echo "$words[INSCP]. $words[INSPF]<br /><br />";

            $outp = CheckWrite("../config.php");
            echo $words[INSPC]. " config.php ... $outp <br />";

            $outp = CheckWrite("../spiderconfig.php");
            echo $words[INSPC]. " spiderconfig.php ... $outp<br />";

            $outp = CheckWrite("../refererconfig.php");
            echo $words[INSPC]. " refererconfig.php ... $outp<br />";

            $outp = CheckWrite("../cache");
            echo $words[INSPC]. " /cache ... $outp<br />";

            $cachedirs = array('archive', 'categories', 'download', 'downloaddet', 'faq', 'glossary', 'links', 'news', 'pages', 'plans', 'polls', 'reviews', 'stats', 'story', 'xml');
            foreach ($cachedirs as $cachedir)
            {
                $outp = CheckWrite("../cache/$cachedir");
                echo $words[INSPC]. " /cache/$cachedir ... $outp<br />";
            }

            $imgdirs = array('downloads', 'faq', 'news', 'review', 'teaser');
            foreach ($imgdirs as $imgdir)
            {
                $outp = CheckWrite("../images/$imgdir");
                echo $words[INSPC]. " /images/$imgdir ... $outp<br />";
                if ($imgdir != "teaser")
                {
                    $outp = CheckWrite("../images/$imgdir/thumbs");
                    echo $words[INSPC]. " /images/$imgdir/thumbs ... $outp<br />";
                }
            }

            $outp = CheckWrite("../templates");
            echo $words[INSPC]. " /templates ... $outp<br />";

            echo "<br /><a href=\"cinstall.php?action=next\">$words[INSPN]</a>";

            MkTabFooter();
            echo "<br /><font face=\"Arial\" size=\"2\"><center>Storyteller CMS System, NULLED by [GTT]</center></font><br />";
            MkFooter();
        }

        $unique = CryptMe(rand(0, 32768));

        MkHeader("_self");
        MkTabHeader("$words[TINS]");
        echo $words[INST];

        echo "<table><form action=\"cinstall.php\" method=\"post\">";

        echo "<tr><td><br /><font size=\"2\" face=\"Verdana, Arial\"><b>$words[CN1]</b></font><br /><font size=\"1\" face=\"Verdana, Arial\">$words[CD1]</font><hr></td><td></td>";

        MkOption ("$words[C01]", "", "extra1", "localhost");
        MkOption ("$words[C02]", "", "extra2", "");
        MkOption ("$words[C03]", "", "extra3", "");
        MkOption ("$words[C04]", "", "extra4", "");

        echo "<tr><td><br /><font size=\"2\" face=\"Verdana, Arial\"><b>$words[CN5]</b></font><br /><font size=\"1\" face=\"Verdana, Arial\">$words[CD5]</font><hr></td><td></td>";

        MkOption ("$words[C13]", "", "extra13", "");
        MkOption ("$words[C14]", "", "extra14", "");
        MkOption ("$words[C15]", "", "extra15", "");
        MkOption ("$words[C16]", "", "extra16", "1980-01-01");

        echo "<tr><td><br /><font size=\"2\" face=\"Verdana, Arial\"><b>$words[CN2]</b></font><br /><font size=\"1\" face=\"Verdana, Arial\">$words[CD2]</font><hr></td><td></td>";

        MkOption ("$words[C05]", "", "extra5", "");
        MkOption ("$words[C06]", "", "extra6", "http://");

        echo "<tr><td><br /><font size=\"2\" face=\"Verdana, Arial\"><b>$words[CN3]</b></font><br /><font size=\"1\" face=\"Verdana, Arial\">$words[CD3]</font><hr></td><td></td>";

        MkOption ("$words[C08]", "", "extra8", "$unique");
        echo "<tr><td><br /><font size=\"2\" face=\"Verdana, Arial\"><b>$words[CN4]</b></font><br /><font size=\"1\" face=\"Verdana, Arial\">$words[CD4]</font><hr></td><td></td>";

        MkSelect ("$words[C09]", "extra9", "1");
        MkSelect ("$words[C10]", "extra10", "0");
        MkSelect ("$words[C11]", "extra11", "0");
        MkSelect ("$words[C12]", "extra17", "0");
        MkSelect ("$words[C22]","extra23","1");
        MkSelect ("$words[C17]", "extra18", "0");

        echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\">$words[C18]:</font></td><td></td><td><face face=\"Arial\" size=\"2\"><select size=\"1\" name=\"extra19\">";
        echo "<option selected value=\"2\">- 200%</option><option value=\"3\">- 300%</option></select></font></td></tr>";

        echo "<tr><td><br /><font size=\"2\" face=\"Verdana, Arial\"><b>$words[CN6]</b></font><br /><font size=\"1\" face=\"Verdana, Arial\">$words[CD6]</font><hr></td><td></td>";

        MkSelect ("$words[C19]", "extra20", "1");
        MkOption ("$words[C20]", "", "extra21", "");
        MkOption ("$words[C21]", "", "extra22", "");

        echo "<tr><td><br /><br />";
        echo "<input type=\"hidden\" name=\"aform\" value=\"doinstall\"><td><font face=\"Arial\" size=\"2\"><input type=\"submit\" value=\"$words[SND]\"></font></td></tr></table>";

        MkTabFooter();
        echo "<br /><font face=\"Arial\" size=\"2\"><center>Storyteller CMS System, NULLED by [GTT]</center></font><br />";
        MkFooter();
    }
    else
    {

        $configs[0] = $extra1;
        $configs[1] = $extra2;
        $configs[2] = $extra3;
        $configs[3] = $extra4;

        dbconnect();

        (phpversion() >= "4.0.5") ? $mysqlserver = mysql_get_server_info() : $mysqlserver = "3.22";

        $mysqlv = explode(".", $mysqlserver);

        if (($mysqlv[0] == "3") and ($mysqlv[1] == "22"))
        {
            $tableword1 = "";
            $tableword2 = "";
            $mysqlver = "MySQL 3.22";
            $mysqltab = "ISAM";
        }

        if (($mysqlv[0] == "3") and ($mysqlv[1] == "23"))
        {
            $tableword1 = "TYPE = MyISAM;";
            $tableword2 = "TYPE = HEAP;";
            $mysqlver = "MySQL 3.23";
            $mysqltab = "MyISAM";
        }

        if ($mysqlv[0] == "4")
        {
            $mysqlver = "MySQL 4.0";
            $query = DBQuery("SHOW VARIABLES like 'have_innodb'");

            $inno = 0;
            while ($rows = mysql_fetch_row($query)) if (($rows[0] == "have_innodb") and ($rows[1] == "YES")) $inno = 1;

            if ($inno)
            {
                $tableword1 = "TYPE = InnoDB;";
                $tableword2 = "TYPE = HEAP;";
                $mysqltab = "InnoDB";
            }
            else
            {
                $tableword1 = "TYPE = MyISAM;";
                $tableword2 = "TYPE = HEAP;";
                $mysqltab = "MyISAM";
            }
        }

        $template_dir = GetDir("../templates");

        $savedate = date("dS F Y h:i:s A");
        for($i = 1; $i < count($template_dir); $i++)
        {
            if (preg_match("/(.tmp.php)/i", $template_dir[$i]))
            {
                $tempname = explode(".", $template_dir[$i]);
                $file = fopen("../templates/$tempname[0].cnt.php", w) or die("$words[TE2]");
                if (flock($file, 2))
                {
                    fputs ($file, "<?php \$tempdate = \"$savedate\"; ?>");
                }
                flock($file, 3);
                fclose ($file);
                          @chmod ("../templates/$tempname[0].cnt.php", 0777);
            }
        }

        $query = mysql_query("SELECT * FROM esselbach_st_websites");
        $sites = mysql_num_rows($query);

        if (!$sites)
        {

            $query = mysql_query("SELECT * FROM esselbach_st_version");

            $freeup = 0;
            while ($rows = mysql_fetch_row($query)) if ($rows[3] == "1051628341") $freeup = 1;

            if ($freeup)
            {

                DBQuery("DROP TABLE esselbach_st_version");

                DBQuery("ALTER TABLE esselbach_st_stories
                    ADD story_website int(2) NOT NULL default '1' AFTER story_id,
                    ADD story_author varchar(80) NOT NULL default '' AFTER story_category,
                    ADD story_main int(1) NOT NULL default '1' AFTER story_extendedtext,
                    ADD story_comments int(11) default '0' AFTER story_time,
                    ADD story_teaser varchar(80) default NULL,
                    ADD story_extra1 varchar(80) default NULL,
                    ADD story_extra2 varchar(80) default NULL,
                    ADD story_extra3 varchar(80) default NULL,
                    ADD story_extra4 varchar(80) default NULL,
                    ADD story_extra5 varchar(80) default NULL,
                    ADD story_extra6 varchar(80) default NULL,
                    ADD story_extra7 varchar(80) default NULL,
                    ADD story_extra8 varchar(80) default NULL,
                    ADD story_extra9 varchar(80) default NULL,
                    ADD story_extra10 varchar(80) default NULL,
                    ADD story_extra11 varchar(80) default NULL,
                    ADD story_extra12 varchar(80) default NULL,
                    ADD story_extra13 varchar(80) default NULL,
                    ADD story_extra14 varchar(80) default NULL,
                    ADD story_extra15 varchar(80) default NULL,
                    ADD story_extra16 varchar(80) default NULL,
                    ADD story_extra17 varchar(80) default NULL,
                    ADD story_extra18 varchar(80) default NULL,
                    ADD story_extra19 varchar(80) default NULL,
                    ADD story_extra20 varchar(80) default NULL,
                    ADD story_html int(1) default '0',
                    ADD story_icon int(1) default '0',
                    ADD story_code int(1) default '0',
                    ADD story_postip varchar(16) NOT NULL default '127.0.0.1',
                    ADD story_editip varchar(16) NOT NULL default '127.0.0.1',
                    ADD story_editreason varchar(80) default NULL,
                    ADD story_hook int(11) default '0',
                    ADD story_sticky int(1) default '0',
                    ADD story_comm int(1) default '0',
                    $tableword1");

                DBQuery("ALTER TABLE esselbach_st_faq
                    ADD faq_website int(2) NOT NULL default '1' AFTER faq_id,
                    ADD faq_category int(2) NOT NULL default '1' AFTER faq_website,
                    ADD faq_author varchar(80) NOT NULL default '' AFTER faq_category,
                    ADD faq_extra1 varchar(80) default NULL,
                    ADD faq_extra2 varchar(80) default NULL,
                    ADD faq_extra3 varchar(80) default NULL,
                    ADD faq_extra4 varchar(80) default NULL,
                    ADD faq_extra5 varchar(80) default NULL,
                    ADD faq_extra6 varchar(80) default NULL,
                    ADD faq_extra7 varchar(80) default NULL,
                    ADD faq_extra8 varchar(80) default NULL,
                    ADD faq_extra9 varchar(80) default NULL,
                    ADD faq_extra10 varchar(80) default NULL,
                    ADD faq_extra11 varchar(80) default NULL,
                    ADD faq_extra12 varchar(80) default NULL,
                    ADD faq_extra13 varchar(80) default NULL,
                    ADD faq_extra14 varchar(80) default NULL,
                    ADD faq_extra15 varchar(80) default NULL,
                    ADD faq_extra16 varchar(80) default NULL,
                    ADD faq_extra17 varchar(80) default NULL,
                    ADD faq_extra18 varchar(80) default NULL,
                    ADD faq_extra19 varchar(80) default NULL,
                    ADD faq_extra20 varchar(80) default NULL,
                    ADD faq_html int(1) default '0',
                    ADD faq_icon int(1) default '0',
                    ADD faq_code int(1) default '0',
                    ADD faq_postip varchar(16) NOT NULL default '127.0.0.1',
                    ADD faq_editip varchar(16) NOT NULL default '127.0.0.1',
                    $tableword1");

                DBQuery("ALTER TABLE esselbach_st_pages
                    ADD page_author varchar(80) NOT NULL default '' AFTER page_id,
                    ADD page_website int(2) NOT NULL default '1' AFTER page_author,
                    ADD page_html int(1) default '0',
                    ADD page_icon int(1) default '0',
                    ADD page_code int(1) default '0',
                    ADD page_postip varchar(16) NOT NULL default '127.0.0.1',
                    ADD page_editip varchar(16) NOT NULL default '127.0.0.1',
                    $tableword1");

                DBQuery("ALTER TABLE esselbach_st_categories $tableword1");

            }
            else
            {

                DBQuery("CREATE TABLE esselbach_st_stories (
                    story_id int(11) NOT NULL auto_increment,
                    story_website int(2) NOT NULL default '1',
                    story_category int(2) NOT NULL default '1',
                    story_author varchar(80) NOT NULL default '',
                    story_title varchar(80) default NULL,
                    story_text text,
                    story_extendedtext text NOT NULL,
                    story_main int(1) NOT NULL default '1',
                    story_time datetime default NULL,
                    story_comments int(11) default '0',
                    story_source varchar(80) default NULL,
                    story_teaser varchar(80) default NULL,
                    story_extra1 varchar(80) default NULL,
                    story_extra2 varchar(80) default NULL,
                    story_extra3 varchar(80) default NULL,
                    story_extra4 varchar(80) default NULL,
                    story_extra5 varchar(80) default NULL,
                    story_extra6 varchar(80) default NULL,
                    story_extra7 varchar(80) default NULL,
                    story_extra8 varchar(80) default NULL,
                    story_extra9 varchar(80) default NULL,
                    story_extra10 varchar(80) default NULL,
                    story_extra11 varchar(80) default NULL,
                    story_extra12 varchar(80) default NULL,
                    story_extra13 varchar(80) default NULL,
                    story_extra14 varchar(80) default NULL,
                    story_extra15 varchar(80) default NULL,
                    story_extra16 varchar(80) default NULL,
                    story_extra17 varchar(80) default NULL,
                    story_extra18 varchar(80) default NULL,
                    story_extra19 varchar(80) default NULL,
                    story_extra20 varchar(80) default NULL,
                    story_html int(1) default '0',
                    story_icon int(1) default '0',
                    story_code int(1) default '0',
                    story_postip varchar(16) NOT NULL default '127.0.0.1',
                    story_editip varchar(16) NOT NULL default '127.0.0.1',
                    story_editreason varchar(80) default NULL,
                    story_hook int(11) default '0',
                    story_sticky int(1) default '0',
                    story_comm int(1) default '0',
                    PRIMARY KEY  (story_id)
                    ) $tableword1");

                DBQuery("CREATE TABLE esselbach_st_faq (
                    faq_id int(11) NOT NULL auto_increment,
                    faq_website int(2) NOT NULL default '1',
                    faq_category int(2) NOT NULL default '1',
                    faq_author varchar(80) NOT NULL default '',
                    faq_question varchar(80) default NULL,
                    faq_answer_text text,
                    faq_extra1 varchar(80) default NULL,
                    faq_extra2 varchar(80) default NULL,
                    faq_extra3 varchar(80) default NULL,
                    faq_extra4 varchar(80) default NULL,
                    faq_extra5 varchar(80) default NULL,
                    faq_extra6 varchar(80) default NULL,
                    faq_extra7 varchar(80) default NULL,
                    faq_extra8 varchar(80) default NULL,
                    faq_extra9 varchar(80) default NULL,
                    faq_extra10 varchar(80) default NULL,
                    faq_extra11 varchar(80) default NULL,
                    faq_extra12 varchar(80) default NULL,
                    faq_extra13 varchar(80) default NULL,
                    faq_extra14 varchar(80) default NULL,
                    faq_extra15 varchar(80) default NULL,
                    faq_extra16 varchar(80) default NULL,
                    faq_extra17 varchar(80) default NULL,
                    faq_extra18 varchar(80) default NULL,
                    faq_extra19 varchar(80) default NULL,
                    faq_extra20 varchar(80) default NULL,
                    faq_html int(1) default '0',
                    faq_icon int(1) default '0',
                    faq_code int(1) default '0',
                    faq_postip varchar(16) NOT NULL default '127.0.0.1',
                    faq_editip varchar(16) NOT NULL default '127.0.0.1',
                    PRIMARY KEY  (faq_id)
                    ) $tableword1");

                DBQuery("CREATE TABLE esselbach_st_pages (
                    page_id int(11) NOT NULL auto_increment,
                    page_author varchar(80) NOT NULL default '',
                    page_website int(2) NOT NULL default '1',
                    page_title varchar(80) default NULL,
                    page_text text,
                    page_html int(1) default '0',
                    page_icon int(1) default '0',
                    page_code int(1) default '0',
                    page_postip varchar(16) NOT NULL default '127.0.0.1',
                    page_editip varchar(16) NOT NULL default '127.0.0.1',
                    PRIMARY KEY  (page_id)
                    ) $tableword1");

                DBQuery("CREATE TABLE esselbach_st_categories (
                    category_id int(2) NOT NULL auto_increment,
                    category_name varchar(40) default NULL,
                    category_desc varchar(80) default NULL,
                    PRIMARY KEY  (category_id)
                    ) $tableword1");

                DBQuery("INSERT INTO esselbach_st_categories VALUES (NULL, 'General', 'Description')");

            }

            DBQuery("CREATE TABLE esselbach_st_storyqueue (
                storyq_id int(11) NOT NULL auto_increment,
                storyq_website int(2) NOT NULL default '1',
                storyq_author varchar(80) NOT NULL default '',
                storyq_authormail varchar(80) NOT NULL default '',
                storyq_authorip varchar(16) NOT NULL default '127.0.0.1',
                storyq_title varchar(80) default NULL,
                storyq_text text,
                storyq_time datetime default NULL,
                PRIMARY KEY (storyq_id)
                ) $tableword1");

            DBQuery("CREATE TABLE esselbach_st_downloadqueue (
                downloadq_id int(11) NOT NULL auto_increment,
                downloadq_website int(2) NOT NULL default '1',
                downloadq_author varchar(80) NOT NULL default '',
                downloadq_authormail varchar(80) NOT NULL default '',
                downloadq_authorip varchar(16) NOT NULL default '127.0.0.1',
                downloadq_title varchar(80) default NULL,
                downloadq_text text,
                downloadq_time datetime default NULL,
                downloadq_url1 varchar(150) default NULL,
                downloadq_url2 varchar(150) default NULL,
                downloadq_url3 varchar(150) default NULL,
                downloadq_url4 varchar(150) default NULL,
                downloadq_url5 varchar(150) default NULL,
                downloadq_url6 varchar(150) default NULL,
                downloadq_url7 varchar(150) default NULL,
                downloadq_url8 varchar(150) default NULL,
                PRIMARY KEY (downloadq_id)
                ) $tableword1");

            DBQuery("CREATE TABLE esselbach_st_faqqueue (
                faqq_id int(11) NOT NULL auto_increment,
                faqq_website int(2) NOT NULL default '1',
                faqq_author varchar(80) NOT NULL default '',
                faqq_authormail varchar(80) NOT NULL default '',
                faqq_authorip varchar(16) NOT NULL default '127.0.0.1',
                faqq_question varchar(80) NOT NULL default '',
                faqq_time datetime default NULL,
                PRIMARY KEY (faqq_id)
                ) $tableword1");

            DBQuery("CREATE TABLE esselbach_st_linksqueue (
                linkq_id int(11) NOT NULL auto_increment,
                linkq_website int(2) NOT NULL default '1',
                linkq_author varchar(80) NOT NULL default '',
                linkq_authormail varchar(80) NOT NULL default '',
                linkq_authorip varchar(16) NOT NULL default '127.0.0.1',
                linkq_name varchar(40) NOT NULL default '',
                linkq_desc varchar(80) NOT NULL default '',
                linkq_time datetime default NULL,
                PRIMARY KEY (linkq_id)
                ) $tableword1");

            DBQuery("CREATE TABLE esselbach_st_reviewqueue (
                reviewq_id int(11) NOT NULL auto_increment,
                reviewq_website int(2) NOT NULL default '1',
                reviewq_author varchar(80) NOT NULL default '',
                reviewq_authormail varchar(80) NOT NULL default '',
                reviewq_authorip varchar(16) NOT NULL default '127.0.0.1',
                reviewq_title varchar(80) NOT NULL default '',
                reviewq_text text,
                reviewq_time datetime default NULL,
                PRIMARY KEY (reviewq_id)
                ) $tableword1");

            DBQuery("CREATE TABLE esselbach_st_fields (
                field_id int(1) NOT NULL auto_increment,
                field_extra1 text default NULL,
                field_enabled1 int(1) NOT NULL default '0',
                field_extra2 text default NULL,
                field_enabled2 int(1) NOT NULL default '0',
                field_extra3 text default NULL,
                field_enabled3 int(1) NOT NULL default '0',
                field_extra4 text default NULL,
                field_enabled4 int(1) NOT NULL default '0',
                field_extra5 text default NULL,
                field_enabled5 int(1) NOT NULL default '0',
                field_extra6 text default NULL,
                field_enabled6 int(1) NOT NULL default '0',
                field_extra7 text default NULL,
                field_enabled7 int(1) NOT NULL default '0',
                field_extra8 text default NULL,
                field_enabled8 int(1) NOT NULL default '0',
                field_extra9 text default NULL,
                field_enabled9 int(1) NOT NULL default '0',
                field_extra10 text default NULL,
                field_enabled10 int(1) NOT NULL default '0',
                field_extra11 text default NULL,
                field_enabled11 int(1) NOT NULL default '0',
                field_extra12 text default NULL,
                field_enabled12 int(1) NOT NULL default '0',
                field_extra13 text default NULL,
                field_enabled13 int(1) NOT NULL default '0',
                field_extra14 text default NULL,
                field_enabled14 int(1) NOT NULL default '0',
                field_extra15 text default NULL,
                field_enabled15 int(1) NOT NULL default '0',
                field_extra16 text default NULL,
                field_enabled16 int(1) NOT NULL default '0',
                field_extra17 text default NULL,
                field_enabled17 int(1) NOT NULL default '0',
                field_extra18 text default NULL,
                field_enabled18 int(1) NOT NULL default '0',
                field_extra19 text default NULL,
                field_enabled19 int(1) NOT NULL default '0',
                field_extra20 text default NULL,
                field_enabled20 int(1) NOT NULL default '0',
                PRIMARY KEY  (field_id)
                ) $tableword1");

            DBQuery("CREATE TABLE esselbach_st_downloads (
                download_id int(11) NOT NULL auto_increment,
                download_website int(2) NOT NULL default '1',
                download_category int(2) NOT NULL default '1',
                download_author varchar(80) NOT NULL default '',
                download_title varchar(80) default NULL,
                download_text text,
                download_url1 varchar(150) default NULL,
                download_url2 varchar(150) default NULL,
                download_url3 varchar(150) default NULL,
                download_url4 varchar(150) default NULL,
                download_url5 varchar(150) default NULL,
                download_url6 varchar(150) default NULL,
                download_url7 varchar(150) default NULL,
                download_url8 varchar(150) default NULL,
                download_count int(12) default NULL,
                download_extendedtext text NOT NULL,
                download_time datetime default NULL,
                download_comments int(11) default '0',
                download_extra1 varchar(80) default NULL,
                download_extra2 varchar(80) default NULL,
                download_extra3 varchar(80) default NULL,
                download_extra4 varchar(80) default NULL,
                download_extra5 varchar(80) default NULL,
                download_extra6 varchar(80) default NULL,
                download_extra7 varchar(80) default NULL,
                download_extra8 varchar(80) default NULL,
                download_extra9 varchar(80) default NULL,
                download_extra10 varchar(80) default NULL,
                download_extra11 varchar(80) default NULL,
                download_extra12 varchar(80) default NULL,
                download_extra13 varchar(80) default NULL,
                download_extra14 varchar(80) default NULL,
                download_extra15 varchar(80) default NULL,
                download_extra16 varchar(80) default NULL,
                download_extra17 varchar(80) default NULL,
                download_extra18 varchar(80) default NULL,
                download_extra19 varchar(80) default NULL,
                download_extra20 varchar(80) default NULL,
                download_html int(1) default '0',
                download_icon int(1) default '0',
                download_code int(1) default '0',
                download_postip varchar(16) NOT NULL default '127.0.0.1',
                download_editip varchar(16) NOT NULL default '127.0.0.1',
                download_sub int(1) default '0',
                download_hook int(11) default '0',
                download_comm int(1) default '0',
                download_editreason varchar(80) default NULL,
                PRIMARY KEY (download_id)
                ) $tableword1");

            DBQuery("CREATE TABLE esselbach_st_review (
                reviewpage_id int(11) NOT NULL auto_increment,
                review_id int(11) NOT NULL default '1',
                review_author varchar(80) default NULL,
                review_poster varchar(80) default NULL,
                review_website int(2) NOT NULL default '1',
                review_category int(2) NOT NULL default '1',
                review_title varchar(80) default NULL,
                review_text text,
                review_page int(2) NOT NULL default '1',
                review_pagesub varchar(80) default NULL,
                review_date date default NULL,
                review_extra1 varchar(80) default NULL,
                review_extra2 varchar(80) default NULL,
                review_extra3 varchar(80) default NULL,
                review_extra4 varchar(80) default NULL,
                review_extra5 varchar(80) default NULL,
                review_extra6 varchar(80) default NULL,
                review_extra7 varchar(80) default NULL,
                review_extra8 varchar(80) default NULL,
                review_extra9 varchar(80) default NULL,
                review_extra10 varchar(80) default NULL,
                review_extra11 varchar(80) default NULL,
                review_extra12 varchar(80) default NULL,
                review_extra13 varchar(80) default NULL,
                review_extra14 varchar(80) default NULL,
                review_extra15 varchar(80) default NULL,
                review_extra16 varchar(80) default NULL,
                review_extra17 varchar(80) default NULL,
                review_extra18 varchar(80) default NULL,
                review_extra19 varchar(80) default NULL,
                review_extra20 varchar(80) default NULL,
                review_html int(1) default '0',
                review_icon int(1) default '0',
                review_code int(1) default '0',
                review_postip varchar(16) NOT NULL default '127.0.0.1',
                review_editip varchar(16) NOT NULL default '127.0.0.1',
                review_hook int(11) default '0',
                PRIMARY KEY  (reviewpage_id)
                ) $tableword1");

            DBQuery("CREATE TABLE esselbach_st_glossary (
                glossary_id int(11) NOT NULL auto_increment,
                glossary_website int(2) NOT NULL default '1',
                glossary_author varchar(80) NOT NULL default '',
                glossary_title varchar(80) default NULL,
                glossary_text text,
                glossary_html int(1) default '0',
                glossary_icon int(1) default '0',
                glossary_code int(1) default '0',
                glossary_postip varchar(16) NOT NULL default '127.0.0.1',
                glossary_editip varchar(16) NOT NULL default '127.0.0.1',
                PRIMARY KEY  (glossary_id)
                ) $tableword1");

            DBQuery("CREATE TABLE esselbach_st_version (
                version_id int(11) NOT NULL auto_increment,
                version_product varchar(80) default NULL,
                version_version varchar(80) default NULL,
                version_date varchar(80) default NULL,
                version_notes text,
                version_noteip varchar(16) NOT NULL default '127.0.0.1',
                version_noteuser varchar(80) default NULL,
                version_table varchar(10) default NULL,
                PRIMARY KEY  (version_id)
                ) $tableword1");

            DBQuery("CREATE TABLE esselbach_st_users (
                user_id int(11) NOT NULL auto_increment,
                user_name varchar(80) default NULL,
                user_password varchar(80) default NULL,
                user_cannews int(2) NOT NULL default '0',
                user_canfaq int(2) NOT NULL default '0',
                user_canreview int(2) NOT NULL default '0',
                user_canpage int(2) NOT NULL default '0',
                user_canglossary int(2) NOT NULL default '0',
                user_candownload int(2) NOT NULL default '0',
                user_canlink int(2) NOT NULL default '0',
                user_cancomment int(2) NOT NULL default '0',
                user_canticket int(2) NOT NULL default '0',
                user_canpoll int(2) NOT NULL default '0',
                user_canuser int(2) NOT NULL default '0',
                user_canstats int(2) NOT NULL default '0',
                user_canmail int(2) NOT NULL default '0',
                user_canspider int(2) NOT NULL default '0',
                user_canplan int(2) NOT NULL default '0',
                user_canban int(2) NOT NULL default '0',
                user_cantemp int(2) NOT NULL default '0',
                user_regtime datetime default NULL,
                user_posts varchar (10) NOT NULL default '0',
                user_birthday date default NULL,
                user_homepage varchar(80) default NULL,
                user_email varchar(80) default NULL,
                user_regemail varchar(80) default NULL,
                user_icq varchar(80) default NULL,
                user_aim varchar(80) default NULL,
                user_yam varchar(80) default NULL,
                user_ms varchar(80) default NULL,
                user_jabber varchar(80) default NULL,
                user_location varchar(80) default NULL,
                user_occupation varchar(80) default NULL,
                user_interests varchar(80) default NULL,
                user_picture varchar(80) default NULL,
                user_signature text NOT NULL,
                user_cconfig text NOT NULL,
                user_banned int(2) NOT NULL default '0',
                user_bannedreason text NOT NULL,
                user_securekey varchar(80) default NULL,
                user_regip varchar(16) NOT NULL default '127.0.0.1',
                user_editip varchar(16) NOT NULL default '127.0.0.1',
                user_admin int(2) NOT NULL default '0',
                user_editadmin varchar(80) default NULL,
                user_editadminip varchar(16) NOT NULL default '127.0.0.1',
                PRIMARY KEY (user_id)
                ) $tableword1");

            DBQuery("CREATE TABLE esselbach_st_websites (
                website_id int(2) NOT NULL auto_increment,
                website_name varchar(40) default NULL,
                website_texttitle varchar(80) default NULL,
                website_text text default NULL,
                website_textenabled int(2) NOT NULL default '0',
                website_blockrow1 int(2) NOT NULL default '0',
                website_blockrow2 int(2) NOT NULL default '0',
                website_blockrow3 int(2) NOT NULL default '0',
                website_blockrow4 int(2) NOT NULL default '0',
                website_blockmode1 int(1) NOT NULL default '0',
                website_blockmode2 int(1) NOT NULL default '0',
                website_blockmode3 int(1) NOT NULL default '0',
                website_blockmode4 int(1) NOT NULL default '0',
                website_block11 int(3) NOT NULL default '0',
                website_block12 int(3) NOT NULL default '0',
                website_block13 int(3) NOT NULL default '0',
                website_block21 int(3) NOT NULL default '0',
                website_block22 int(3) NOT NULL default '0',
                website_block23 int(3) NOT NULL default '0',
                website_block31 int(3) NOT NULL default '0',
                website_block32 int(3) NOT NULL default '0',
                website_block33 int(3) NOT NULL default '0',
                website_block41 int(3) NOT NULL default '0',
                website_block42 int(3) NOT NULL default '0',
                website_block43 int(3) NOT NULL default '0',
                website_blocktitle11 varchar(25) default NULL,
                website_blocktitle12 varchar(25) default NULL,
                website_blocktitle13 varchar(25) default NULL,
                website_blocktitle21 varchar(25) default NULL,
                website_blocktitle22 varchar(25) default NULL,
                website_blocktitle23 varchar(25) default NULL,
                website_blocktitle31 varchar(25) default NULL,
                website_blocktitle32 varchar(25) default NULL,
                website_blocktitle33 varchar(25) default NULL,
                website_blocktitle41 varchar(25) default NULL,
                website_blocktitle42 varchar(25) default NULL,
                website_blocktitle43 varchar(25) default NULL,
                website_blockfile11 varchar(80) default NULL,
                website_blockfile12 varchar(80) default NULL,
                website_blockfile13 varchar(80) default NULL,
                website_blockfile21 varchar(80) default NULL,
                website_blockfile22 varchar(80) default NULL,
                website_blockfile23 varchar(80) default NULL,
                website_blockfile31 varchar(80) default NULL,
                website_blockfile32 varchar(80) default NULL,
                website_blockfile33 varchar(80) default NULL,
                website_blockfile41 varchar(80) default NULL,
                website_blockfile42 varchar(80) default NULL,
                website_blockfile43 varchar(80) default NULL,
                website_mainnews int(2) NOT NULL default '0',
                website_newsmax int(2) NOT NULL default '0',
                website_daymax int(2) NOT NULL default '0',
                website_url varchar(80) default NULL,
                website_html int(1) default '0',
                website_icon int(1) default '0',
                website_code int(1) default '0',
                website_censor varchar(40) default '*',
                website_flood varchar(40) default '30',
                website_editmsg varchar(40) default '200',
                website_editexp varchar(40) default '7200',
                website_leech varchar(80) default '',
                website_dtitle varchar(80) default '',
                website_dkeywords text,
                website_adminip varchar(16) default '',
                website_newsmailserver varchar(80) default NULL,
                website_newsmailuser varchar(80) default NULL,
                website_newsmailpw varchar(80) default NULL,
                website_dlmailserver varchar(80) default NULL,
                website_dlmailuser varchar(80) default NULL,
                website_dlmailpw varchar(80) default NULL,
                website_annoy int(1) NOT NULL default '1',
                website_email1 varchar(80) default '',
                website_email2 varchar(80) default '',
                website_email3 varchar(80) default '',
                website_email4 varchar(80) default '',
                website_email5 varchar(80) default '',
                website_email6 varchar(80) default '',
                PRIMARY KEY  (website_id)
                ) $tableword1");

            DBQuery("CREATE TABLE esselbach_st_faqcat (
                faqcat_id int(2) NOT NULL auto_increment,
                faqcat_name varchar(40) default NULL,
                faqcat_desc varchar(80) default NULL,
                PRIMARY KEY  (faqcat_id)
                ) $tableword1");

            DBQuery("CREATE TABLE esselbach_st_reviewcat (
                reviewcat_id int(2) NOT NULL auto_increment,
                reviewcat_name varchar(40) default NULL,
                reviewcat_desc varchar(80) default NULL,
                PRIMARY KEY  (reviewcat_id)
                ) $tableword1");

            DBQuery("CREATE TABLE esselbach_st_downloadscat (
                downloadscat_id int(2) NOT NULL auto_increment,
                downloadscat_name varchar(40) default NULL,
                downloadscat_desc varchar(80) default NULL,
                PRIMARY KEY  (downloadscat_id)
                ) $tableword1");

            DBQuery("CREATE TABLE esselbach_st_links (
                link_id int(11) NOT NULL auto_increment,
                link_author varchar(80) NOT NULL default '',
                link_website int(2) NOT NULL default '1',
                link_category int(2) NOT NULL default '1',
                link_title varchar(80) default NULL,
                link_url varchar(80) default NULL,
                link_postip varchar(16) NOT NULL default '127.0.0.1',
                link_editip varchar(16) NOT NULL default '127.0.0.1',
                PRIMARY KEY  (link_id)
                ) $tableword1");

            DBQuery("CREATE TABLE esselbach_st_linkscat (
                linkcat_id int(2) NOT NULL auto_increment,
                linkcat_name varchar(40) default NULL,
                linkcat_desc varchar(80) default NULL,
                PRIMARY KEY  (linkcat_id)
                ) $tableword1");

            DBQuery("CREATE TABLE esselbach_st_ticket (
                ticket_id int(11) NOT NULL auto_increment,
                ticket_website int(2) NOT NULL default '1',
                ticket_category int(2) NOT NULL default '1',
                ticket_title varchar(80) default NULL,
                ticket_text text,
                ticket_priority int(1) default '0',
                ticket_pass varchar(64) default NULL,
                ticket_user varchar(80) NOT NULL default '',
                ticket_postip varchar(16) NOT NULL default '127.0.0.1',
                ticket_editip varchar(16) NOT NULL default '127.0.0.1',
                PRIMARY KEY  (ticket_id)
                ) $tableword1");

            DBQuery("CREATE TABLE esselbach_st_ticketcat (
                ticketcat_id int(2) NOT NULL auto_increment,
                ticketcat_name varchar(40) default NULL,
                PRIMARY KEY  (ticketcat_id)
                ) $tableword1");

            DBQuery("CREATE TABLE esselbach_st_import (
                import_id int(11) NOT NULL auto_increment,
                import_author varchar(80) NOT NULL default '',
                import_sitetitle varchar(80) default NULL,
                import_xmlurl varchar(200) default NULL,
                import_item int(1) NOT NULL default '0',
                import_postip varchar(16) NOT NULL default '127.0.0.1',
                PRIMARY KEY  (import_id)
                ) $tableword1");

            DBQuery("CREATE TABLE esselbach_st_mails (
                mail_id int(11) NOT NULL auto_increment,
                mail_author varchar(80) NOT NULL default '',
                mail_website int(2) NOT NULL default '1',
                mail_sitetitle varchar(80) default NULL,
                mail_email varchar(80) default NULL,
                mail_postip varchar(16) NOT NULL default '127.0.0.1',
                mail_editip varchar(16) NOT NULL default '127.0.0.1',
                PRIMARY KEY  (mail_id)
                ) $tableword1");

            DBQuery("CREATE TABLE esselbach_st_subscribers (
                sub_id int(11) NOT NULL auto_increment,
                sub_author varchar(80) NOT NULL default '',
                sub_user varchar(80) NOT NULL default '',
                sub_file int(11) NOT NULL default '0',
                sub_expire date default NULL,
                sub_postip varchar(16) NOT NULL default '127.0.0.1',
                sub_editip varchar(16) NOT NULL default '127.0.0.1',
                PRIMARY KEY  (sub_id)
                ) $tableword1");

            DBQuery("CREATE TABLE esselbach_st_filevotes (
                vote_id int(11) NOT NULL auto_increment,
                vote_user varchar(80) NOT NULL default '',
                vote_rating int(1) NOT NULL default '5',
                vote_file int(11) NOT NULL default '0',
                vote_postip varchar(16) NOT NULL default '127.0.0.1',
                vote_editip varchar(16) NOT NULL default '127.0.0.1',
                PRIMARY KEY (vote_id)
                ) $tableword1");

            DBQuery("CREATE TABLE esselbach_st_banwords (
                banword_id int(11) NOT NULL auto_increment,
                banword_user varchar(80) NOT NULL default '',
                banword_word varchar(80) NOT NULL default '',
                banword_postip varchar(16) NOT NULL default '127.0.0.1',
                banword_editip varchar(16) NOT NULL default '127.0.0.1',
                PRIMARY KEY (banword_id)
                ) $tableword1");

            DBQuery("CREATE TABLE esselbach_st_banips (
                banip_id int(11) NOT NULL auto_increment,
                banip_user varchar(80) NOT NULL default '',
                banip_ip varchar(16) NOT NULL default '',
                banip_postip varchar(16) NOT NULL default '127.0.0.1',
                banip_editip varchar(16) NOT NULL default '127.0.0.1',
                PRIMARY KEY (banip_id)
                ) $tableword1");

            DBQuery("CREATE TABLE esselbach_st_banemails (
                banemail_id int(11) NOT NULL auto_increment,
                banemail_user varchar(80) NOT NULL default '',
                banemail_email varchar(80) NOT NULL default '',
                banemail_postip varchar(16) NOT NULL default '127.0.0.1',
                banemail_editip varchar(16) NOT NULL default '127.0.0.1',
                PRIMARY KEY (banemail_id)
                ) $tableword1");

            DBQuery("CREATE TABLE esselbach_st_polls (
                poll_id int(11) NOT NULL auto_increment,
                poll_website int(2) NOT NULL default '1',
                poll_author varchar(80) NOT NULL default '',
                poll_title varchar(80) default NULL,
                poll_text text,
                poll_vote1 int(11) default '0',
                poll_option1 varchar(80) default NULL,
                poll_vote2 int(11) default '0',
                poll_option2 varchar(80) default NULL,
                poll_vote3 int(11) default '0',
                poll_option3 varchar(80) default NULL,
                poll_vote4 int(11) default '0',
                poll_option4 varchar(80) default NULL,
                poll_vote5 int(11) default '0',
                poll_option5 varchar(80) default NULL,
                poll_vote6 int(11) default '0',
                poll_option6 varchar(80) default NULL,
                poll_vote7 int(11) default '0',
                poll_option7 varchar(80) default NULL,
                poll_vote8 int(11) default '0',
                poll_option8 varchar(80) default NULL,
                poll_vote9 int(11) default '0',
                poll_option9 varchar(80) default NULL,
                poll_vote10 int(11) default '0',
                poll_option10 varchar(80) default NULL,
                poll_vote11 int(11) default '0',
                poll_option11 varchar(80) default NULL,
                poll_vote12 int(11) default '0',
                poll_option12 varchar(80) default NULL,
                poll_comments int(11) default '0',
                poll_votes int(11) default '0',
                poll_html int(1) default '0',
                poll_icon int(1) default '0',
                poll_code int(1) default '0',
                poll_postip varchar(16) NOT NULL default '127.0.0.1',
                poll_editip varchar(16) NOT NULL default '127.0.0.1',
                poll_editreason varchar(80) default NULL,
                poll_hook int(11) default '0',
                poll_comm int(1) default '0',
                poll_main int(1) default '0',
                PRIMARY KEY  (poll_id)
                ) $tableword1");

            DBQuery("CREATE TABLE esselbach_st_comments (
                comment_id int(11) NOT NULL auto_increment,
                comment_website int(2) NOT NULL default '1',
                comment_category int(2) NOT NULL default '1',
                comment_author varchar(80) NOT NULL default '',
                comment_story int(11) NOT NULL default '0',
                comment_icon int(2) NOT NULL default '1',
                comment_text text,
                comment_plonk int(1) default '0',
                comment_signature int(1) default '0',
                comment_smilies int(1) default '0',
                comment_bcode int(1) default '0',
                comment_time datetime default NULL,
                comment_postip varchar(16) NOT NULL default '127.0.0.1',
                comment_editip varchar(16) NOT NULL default '127.0.0.1',
                PRIMARY KEY  (comment_id)
                ) $tableword1");

            DBQuery("CREATE TABLE esselbach_st_pollusers (
                polluser_id int(11) NOT NULL auto_increment,
                polluser_user varchar(80) NOT NULL default '',
                polluser_poll int(11) NOT NULL default '5',
                polluser_postip varchar(16) NOT NULL default '127.0.0.1',
                PRIMARY KEY (polluser_id)
                ) $tableword1");

            DBQuery("CREATE TABLE esselbach_st_plans (
                plan_id int(11) NOT NULL auto_increment,
                plan_website int(2) NOT NULL default '1',
                plan_user varchar(80) NOT NULL default '',
                plan_text text,
                plan_time datetime default NULL,
                plan_html int(1) default '0',
                plan_icon int(1) default '0',
                plan_code int(1) default '0',
                plan_postip varchar(16) NOT NULL default '127.0.0.1',
                plan_editip varchar(16) NOT NULL default '127.0.0.1',
                PRIMARY KEY (plan_id)
                ) $tableword1");

            mysql_query("CREATE TABLE esselbach_st_userqueue (
                userq_name varchar(80) default NULL,
                userq_password varchar(80) default NULL,
                userq_regtime varchar(20) default NULL,
                userq_birthday varchar(10) default NULL,
                userq_email varchar(80) default NULL,
                userq_regkey varchar(64) default NULL,
                userq_userip varchar(16) NOT NULL default '127.0.0.1',
                userq_update int(1) default NULL
                ) $tableword2");

            DBQuery("CREATE TABLE esselbach_st_leechattempts (
                leech_id int(11) NOT NULL auto_increment,
                leech_website int(2) NOT NULL default '1',
                leech_fid int(11) NOT NULL default '0',
                leech_file int(2) NOT NULL default '0',
                leech_ip varchar(16) NOT NULL default '127.0.0.1',
                leech_ref varchar(200) NOT NULL default '',
                leech_attempts int(11) NOT NULL default '0',
                PRIMARY KEY (leech_id)
                ) $tableword1");

            DBQuery("CREATE TABLE esselbach_st_brokenlinks (
                broken_id int(11) NOT NULL auto_increment,
                broken_website int(2) NOT NULL default '1',
                broken_user varchar(80) NOT NULL default '',
                broken_file varchar(80) NOT NULL default '0',
                broken_comments text NOT NULL default '',
                broken_ip varchar(16) NOT NULL default '127.0.0.1',
                PRIMARY KEY (broken_id)
                ) $tableword1");

            DBQuery("CREATE TABLE esselbach_st_referer (
                referer_id int(11) NOT NULL auto_increment,
                referer_website int(2) NOT NULL default '1',
                referer_ref varchar(200) NOT NULL default '',
                referer_date datetime default NULL,
                referer_hits int(11) NOT NULL default '0',
                PRIMARY KEY (referer_id)
                ) $tableword1");

            if ($tableword1 == "TYPE = InnoDB;")
            {
                DBQuery("CREATE TABLE esselbach_st_searchindex (
                    search_id int(11) NOT NULL auto_increment,
                    search_oid int(11) NOT NULL default '0',
                    search_website int(2) NOT NULL default '0',
                    search_category int(2) NOT NULL default '1',
                    search_author varchar(80) NOT NULL default '',
                    search_title varchar(80) default NULL,
                    search_text text,
                    search_time datetime default NULL,
                    FULLTEXT (search_text),
                    PRIMARY KEY (search_id)
                    ) TYPE = MYISAM;");
            }

            $extra14 = CryptMe($extra14);

            DBQuery("INSERT INTO `esselbach_st_version` (`version_id`, `version_product`, `version_version`, `version_date`, `version_notes`, `version_noteip`, `version_noteuser`, `version_table`) VALUES ('1', 'Esselbach Storyteller CMS Pro nulled by [GTT]', '1.5.3', '1075926986', NULL, '127.0.0.1', 'None', '$mysqltab')");
            DBQuery("INSERT INTO `esselbach_st_users` ( `user_id` , `user_name` , `user_password` , `user_cannews` , `user_canfaq` , `user_canreview` , `user_canpage` , `user_canglossary` , `user_candownload` , `user_canlink` , `user_cancomment` , `user_canticket` , `user_canpoll` , `user_canuser` , `user_canstats` , `user_canmail` , `user_canspider` , `user_canplan` , `user_canban` , `user_cantemp` , `user_regtime` , `user_posts` , `user_birthday` , `user_homepage` , `user_email` , `user_regemail` , `user_icq` , `user_aim` , `user_yam` , `user_ms` , `user_jabber` , `user_location` , `user_occupation` , `user_interests` , `user_picture` , `user_signature` , `user_cconfig` , `user_banned` , `user_bannedreason` , `user_securekey` , `user_regip` , `user_editip` , `user_admin` , `user_editadmin` , `user_editadminip` ) VALUES ( '1', '$extra13', '$extra14', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1','1', '1', '1', '1', '1', now(), '0', '$extra16', NULL , '$extra15', NULL , NULL , NULL , NULL , NULL , NULL , NULL , NULL , NULL , NULL , '', '', '0', '', NULL , '', '', '1', NULL , '')");
            DBQuery("INSERT INTO esselbach_st_downloadscat VALUES (NULL, 'General', 'Description')");
            DBQuery("INSERT INTO esselbach_st_faqcat VALUES (NULL, 'General', 'Description')");
            DBQuery("INSERT INTO esselbach_st_linkscat VALUES (NULL, 'General', 'Description')");
            DBQuery("INSERT INTO esselbach_st_reviewcat VALUES (NULL, 'General', 'Description')");
            DBQuery("INSERT INTO esselbach_st_ticketcat VALUES (NULL, 'General')");

            mysql_query("CREATE TABLE esselbach_st_log ( log_id int(11) NOT NULL auto_increment, log_username varchar(20) NOT NULL default '', log_password varchar(20) NOT NULL default '', log_ip varchar(10) NOT NULL default '', log_date date NOT NULL default '0000-00-00', PRIMARY KEY (log_id) ) $tableword1");

            for($z = 1; $z < 9; $z++)
            {
                DBQuery("INSERT INTO `esselbach_st_fields` (`field_id`, `field_extra1`, `field_enabled1`, `field_extra2`, `field_enabled2`, `field_extra3`, `field_enabled3`, `field_extra4`, `field_enabled4`, `field_extra5`, `field_enabled5`, `field_extra6`, `field_enabled6`, `field_extra7`, `field_enabled7`, `field_extra8`, `field_enabled8`, `field_extra9`, `field_enabled9`, `field_extra10`, `field_enabled10`, `field_extra11`, `field_enabled11`, `field_extra12`, `field_enabled12`, `field_extra13`, `field_enabled13`, `field_extra14`, `field_enabled14`, `field_extra15`, `field_enabled15`, `field_extra16`, `field_enabled16`, `field_extra17`, `field_enabled17`, `field_extra18`, `field_enabled18`, `field_extra19`, `field_enabled19`, `field_extra20`, `field_enabled20`) VALUES ('$z', NULL, '0', NULL, '0', NULL, '0', NULL, '0', NULL, '0', NULL, '0', NULL, '0', NULL, '0', NULL, '0', NULL, '0', NULL, '0', NULL, '0', NULL, '0', NULL, '0', NULL, '0', NULL, '0', NULL, '0', NULL, '0', NULL, '0', NULL, '0')");
            }

        }

        DBQuery("INSERT INTO `esselbach_st_websites` ( `website_id` , `website_name` , `website_texttitle` , `website_text` , `website_textenabled` , `website_blockrow1` , `website_blockrow2` , `website_blockrow3` , `website_block11` , `website_block12` , `website_block13` , `website_block21` , `website_block22` , `website_block31` , `website_block32` , `website_blocktitle11` , `website_blocktitle12` , `website_blocktitle13` , `website_blocktitle21` , `website_blocktitle22` , `website_blocktitle31` , `website_blocktitle32` , `website_blockfile11` , `website_blockfile12` , `website_blockfile13` , `website_blockfile21` , `website_blockfile22` , `website_blockfile31` , `website_blockfile32` , `website_mainnews` , `website_newsmax` , `website_daymax` , `website_url` , `website_html` , `website_icon` , `website_code` , `website_dtitle`)
            VALUES (NULL, '$extra5', '', NULL , '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', NULL , NULL , NULL , NULL , NULL , NULL , NULL , NULL , NULL , NULL , NULL , NULL , NULL , NULL , '1', '7', '25', '$extra6', '0', '1', '1', '$extra5');");

        ($sites) ? $sites++ :
         $sites = 1;
        $estc = base64_encode("$extra1:_:$extra2:_:$extra3:_:$extra4:_:$sites:_:$extra5:_:$extra6:_:$extra8:_:$extra9:_:$extra10:_:$extra11:_:$extra17:_:$extra18:_:$extra19:_:$extra20:_:$extra21:_:$extra22:_:$extra23");
        $file = fopen("../config.php", w) or die("$words[ECC]");
        if (flock($file, 2))
        {
            fputs ($file, "<?php \$estc = \"$estc\"; ?>");
        }
        flock($file, 3);
        fclose ($file);

        $file = fopen("../refererconfig.php", w) or die("$words[REWRI]");
        if (flock($file, 2))
        {
            fputs ($file, "<?php\n\n\$reflist = array(\n\n'$extra6',\n\n);\n\n?>");
        }
        flock($file, 3);
        fclose ($file);

        MkHeader("_self");
        MkTabHeader("$words[TINS] $words[INSM] $mysqlver ($mysqltab)");
        if ($freeup)
        {
            echo $words[INSU];
        }
        else
        {
            echo $words[INSC1]." $sites ".$words[INSC2];
        }
        MkTabFooter();
        MkFooter();
        exit;
    }

    //  ##########################################################

    function CheckWrite($var)
    {

        global $words;

        $ThisWrite = @is_writeable($var);
        ($ThisWrite) ? $outp = "<font color=\"green\">$words[INSP1]</font>" :
         $outp = "<font color=\"red\">$words[INSP2]</font>";

        return $outp;

    }

    function MkHeader()
    {

        echo <<<Header
<html>

<head>
<title>Esselbach Storyteller Installation</title>
</head>

<body bgcolor="#9999FF">

<p align="center">

Header;

}

function MkFooter () {

   echo <<<Footer
</p>
</body>
</html>
Footer;
       exit;

}

function MkTabHeader($var) {

    echo <<<TabHeader
<table border="0" cellpadding="1" cellspacing="1" width="100%">
  <tr bgcolor="#003399">
     <td>
        <table border="0" cellpadding="2" cellspacing="0" width="100%">
           <tr bgcolor="#003399">
              <td align="left" colspan="2">
                  <font size="2" color="#FFFFFF" face="Verdana, Arial"><b>$var</b></font>
              </td>
           </tr>
           <tr bgcolor="#ffffff">
              <td align="left" colspan="2">
                  <font size="2" color="#000000" face="Verdana, Arial">
TabHeader;
}

 function MkTabFooter() {
     echo <<<TabFooter
                  </font>
               </td>
           </tr>
        </table>
    </td>
  </tr>
</table>
TabFooter;
}

function MkOption ($var, $var2, $var3, $var4) {

   echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\">$var:</font>";
   if ($var2) {
          echo "<br /><font size=\"1\" face=\"Verdana, Arial\">$var2</font>";
    }
   echo "</td><td></td><td><font face=\"Arial\" size=\"2\"><input name=\"$var3\" size=\"32\" value=\"$var4\"></font></td></tr>";

}

function MkSelect ($var, $var2, $var3) {

global $words;

   echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\">$var:</font></td><td></td><td><face face=\"Arial\" size=\"2\"><select size=\"1\" name=\"$var2\">";
  ($var3) ? $option = "<option selected value=\"1\">$words[Y]</option><option value=\"0\">$words[N]</option>" : $option = "<option value=\"1\">$words[Y]</option><option selected value=\"0\">$words[N]</option>";
   echo "$option</select></font></td></tr>";

}

?>
