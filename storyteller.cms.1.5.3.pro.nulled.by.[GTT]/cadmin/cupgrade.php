<?php

    /*
    ########################
    # |//////////////////| #
    # NULLED by [GTT] =)   #
    # |\\\\\\\\\\\\\\\\\\| #
    ########################
    */

    include("../core.php");
    include("admincore.php");
    include("mod_words.php");

    //  ##########################################################

    dbconnect();

    $query = mysql_query("SELECT * FROM esselbach_st_version");

    if (!mysql_num_rows($query))
    {
        MkHeader("_self");
        MkTabHeader("$words[TUPGR]");
        echo $words[NOSTF];
        MkTabFooter();
        MkFooter();
    }

    $rows = mysql_fetch_row($query);

    if (preg_match("/Free/i",$rows[1]))
    {
        MkHeader("_self");
        MkTabHeader("$words[TUPGR]");
        echo $words[YSTIX];
        MkTabFooter();
        MkFooter();
    }

    if ($rows[3] == "1071409935")
    {
        MkHeader("_self");
        MkTabHeader("$words[TUPGR]");
        echo $words[YALRY];
        MkTabFooter();
        MkFooter();
    }
    if ($rows[3] == "1051628341")
    {
        MkHeader("_self");
        MkTabHeader("$words[TUPGR]");
        echo $words[YSTIS];
        MkTabFooter();
        MkFooter();
    }

    if ($rows[2] < "1.3.1")
    {
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

    }

    if ($rows[2] == "1.0")
    {
        DBQuery("ALTER TABLE esselbach_st_websites
            ADD website_blockrow4 int(2) NOT NULL default '0' AFTER website_blockrow3,
            ADD website_blockmode1 int(1) NOT NULL default '0' AFTER website_blockrow4,
            ADD website_blockmode2 int(1) NOT NULL default '0' AFTER website_blockmode1,
            ADD website_blockmode3 int(1) NOT NULL default '0' AFTER website_blockmode2,
            ADD website_blockmode4 int(1) NOT NULL default '0' AFTER website_blockmode3,
            ADD website_block23 int(3) NOT NULL default '0' AFTER website_block22,
            ADD website_block33 int(3) NOT NULL default '0' AFTER website_block32,
            ADD website_block41 int(3) NOT NULL default '0' AFTER website_block33,
            ADD website_block42 int(3) NOT NULL default '0' AFTER website_block41,
            ADD website_block43 int(3) NOT NULL default '0' AFTER website_block42,
            ADD website_blockfile23 varchar(80) default NULL AFTER website_blockfile22,
            ADD website_blockfile33 varchar(80) default NULL AFTER website_blockfile32,
            ADD website_blockfile41 varchar(80) default NULL AFTER website_blockfile33,
            ADD website_blockfile42 varchar(80) default NULL AFTER website_blockfile41,
            ADD website_blockfile43 varchar(80) default NULL AFTER website_blockfile42,
            ADD website_blocktitle23 varchar(25) default NULL AFTER website_blocktitle22,
            ADD website_blocktitle33 varchar(25) default NULL AFTER website_blocktitle32,
            ADD website_blocktitle41 varchar(25) default NULL AFTER website_blocktitle33,
            ADD website_blocktitle42 varchar(25) default NULL AFTER website_blocktitle41,
            ADD website_blocktitle43 varchar(25) default NULL AFTER website_blocktitle42,
            ADD website_censor varchar(40) default '*',
            ADD website_flood varchar(40) default '30',
            ADD website_editmsg varchar(40) default '200',
            ADD website_editexp varchar(40) default '720',
            ADD website_dtitle varchar(80) default '',
            ADD website_dkeywords text,
            ADD website_adminip varchar(16) default '',
            ADD website_newsmailserver varchar(80) default NULL,
            ADD website_newsmailuser varchar(80) default NULL,
            ADD website_newsmailpw varchar(80) default NULL,
            ADD website_dlmailserver varchar(80) default NULL,
            ADD website_dlmailuser varchar(80) default NULL,
            ADD website_dlmailpw varchar(80) default NULL,
            ADD website_annoy int(1) NOT NULL default '1';");

        DBQuery("ALTER TABLE esselbach_st_review
            ADD review_poster varchar(80) default NULL AFTER review_author;");
    }

    if (($rows[2] == "1.0") or ($rows[2] == "1.1"))
    {

        DBQuery("ALTER TABLE esselbach_st_storyquere RENAME TO esselbach_st_storyqueue");
        DBQuery("ALTER TABLE esselbach_st_downloadquere RENAME TO esselbach_st_downloadqueue");
        DBQuery("ALTER TABLE esselbach_st_userquere RENAME TO esselbach_st_userqueue");

        DBQuery("ALTER TABLE esselbach_st_websites
            ADD website_email1 varchar(80) default '',
            ADD website_email2 varchar(80) default '',
            ADD website_email3 varchar(80) default '';");

        if ($rows[7] == "InnoDB")
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

    }

    if (($rows[2] == "1.0") or ($rows[2] == "1.1") or ($rows[2] == "1.2"))
    {
        DBQuery("ALTER TABLE esselbach_st_websites CHANGE website_text website_text TEXT default '';");
    }

    if ($rows[2] < "1.3")
    {
        DBQuery("ALTER TABLE esselbach_st_stories ADD story_sticky int(1) NOT NULL default '0' AFTER story_hook;");
    }

    if ($rows[2] < "1.4")
    {

        $template_dir = GetDir("../templates");

        for($i = 1; $i < count($template_dir); $i++)
        {
            if (preg_match("/(.cnt.bak.php)/i", $template_dir[$i]))
            {
                unlink($template_dir[$i]);
            }
        }

        DBQuery("ALTER TABLE esselbach_st_websites
            ADD website_leech varchar(80) default NULL AFTER website_editexp,
            ADD website_email4 varchar(80) default NULL AFTER website_email3,
            ADD website_email5 varchar(80) default NULL AFTER website_email4,
            ADD website_email6 varchar(80) default NULL AFTER website_email5;");
        DBQuery("ALTER TABLE esselbach_st_comments ADD comment_plonk int(1) default '0' AFTER comment_text;");
        DBQuery("CREATE TABLE esselbach_st_leechattempts (
            leech_id int(11) NOT NULL auto_increment,
            leech_website int(2) NOT NULL default '1',
            leech_fid int(11) NOT NULL default '0',
            leech_file int(2) NOT NULL default '0',
            leech_ip varchar(16) NOT NULL default '127.0.0.1',
            leech_ref varchar(200) NOT NULL default '',
            leech_attempts int(11) NOT NULL default '0',
            PRIMARY KEY (leech_id)
            ) TYPE = $rows[7];");
        DBQuery("CREATE TABLE esselbach_st_brokenlinks (
            broken_id int(11) NOT NULL auto_increment,
            broken_website int(2) NOT NULL default '1',
            broken_user varchar(80) NOT NULL default '',
            broken_fid int(11) NOT NULL default '0',
            broken_file varchar(80) NOT NULL default '0',
            broken_comments text NOT NULL default '',
            broken_ip varchar(16) NOT NULL default '127.0.0.1',
            PRIMARY KEY (broken_id)
            ) TYPE = $rows[7];");
        DBQuery("CREATE TABLE esselbach_st_referer (
            referer_id int(11) NOT NULL auto_increment,
            referer_website int(2) NOT NULL default '1',
            referer_ref varchar(200) NOT NULL default '',
            referer_date datetime default NULL,
            referer_hits int(11) NOT NULL default '0',
            PRIMARY KEY (referer_id)
            ) TYPE = $rows[7];");
        DBQuery("CREATE TABLE esselbach_st_faqqueue (
            faqq_id int(11) NOT NULL auto_increment,
            faqq_website int(2) NOT NULL default '1',
            faqq_author varchar(80) NOT NULL default '',
            faqq_authormail varchar(80) NOT NULL default '',
            faqq_authorip varchar(16) NOT NULL default '127.0.0.1',
            faqq_question varchar(80) NOT NULL default '',
            faqq_time datetime default NULL,
            PRIMARY KEY (faqq_id)
            ) TYPE = $rows[7];");
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
            ) TYPE = $rows[7];");
        DBQuery("ALTER TABLE esselbach_st_review
                   ADD review_extra1 varchar(80) default NULL AFTER review_date,
            ADD review_extra2 varchar(80) default NULL AFTER review_extra1,
                   ADD review_extra3 varchar(80) default NULL AFTER review_extra2,
                   ADD review_extra4 varchar(80) default NULL AFTER review_extra3,
                   ADD review_extra5 varchar(80) default NULL AFTER review_extra4,
                   ADD review_extra6 varchar(80) default NULL AFTER review_extra5,
                   ADD review_extra7 varchar(80) default NULL AFTER review_extra6,
            ADD review_extra8 varchar(80) default NULL AFTER review_extra7,
                   ADD review_extra9 varchar(80) default NULL AFTER review_extra8,
                   ADD review_extra10 varchar(80) default NULL AFTER review_extra9,
                   ADD review_extra11 varchar(80) default NULL AFTER review_extra10,
                   ADD review_extra12 varchar(80) default NULL AFTER review_extra11,
                   ADD review_extra13 varchar(80) default NULL AFTER review_extra12,
                   ADD review_extra14 varchar(80) default NULL AFTER review_extra13,
                   ADD review_extra15 varchar(80) default NULL AFTER review_extra14,
                   ADD review_extra16 varchar(80) default NULL AFTER review_extra15,
                   ADD review_extra17 varchar(80) default NULL AFTER review_extra16,
                   ADD review_extra18 varchar(80) default NULL AFTER review_extra17,
                   ADD review_extra19 varchar(80) default NULL AFTER review_extra18,
                   ADD review_extra20 varchar(80) default NULL AFTER review_extra19,
                   ADD review_hook int(11) default '0' AFTER review_editip;");
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
            ) TYPE = $rows[7];");
        DBQuery("ALTER TABLE esselbach_st_storyqueue ADD storyq_authormail varchar(80) default NULL AFTER storyq_author;");
        DBQuery("ALTER TABLE esselbach_st_downloadqueue ADD downloadq_authormail varchar(80) default NULL AFTER downloadq_author;");
    }

    if ($rows[2] < "1.5.3")
    {
        DBQuery("ALTER TABLE esselbach_st_brokenlinks DROP broken_fid");
        DBQuery("UPDATE esselbach_st_version SET version_product = 'Esselbach Storyteller CMS Pro nulled by [GTT]', version_version = '1.5.3', version_date = '1075926986'");
    }

    ClearCache ("archive");
    ClearCache ("categories");
    ClearCache ("download");
    ClearCache ("downloaddet");
    ClearCache ("faq");
    ClearCache ("glossary");
    ClearCache ("links");
    ClearCache ("news");
    ClearCache ("pages");
    ClearCache ("plans");
    ClearCache ("polls");
    ClearCache ("reviews");
    ClearCache ("story");
    ClearCache ("xml");

    MkHeader("_self");
    MkTabHeader("$words[TUPGR]");
    echo $words[INSU];
    MkTabFooter();
    MkFooter();

?>
