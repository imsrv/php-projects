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

    if (!preg_match("/Free/i", $rows[1]))
        {
        MkHeader("_self");
        MkTabHeader("$words[TUPGR]");
        echo $words[YSTIX];
        MkTabFooter();
        MkFooter();
    }

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
        ) TYPE = $rows[7]");

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
        ) TYPE = $rows[7]");

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
        ) TYPE = $rows[7]");

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
        ) TYPE = $rows[7]");

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
        ) TYPE = $rows[7]");

    DBQuery("CREATE TABLE esselbach_st_reviewcat (
        reviewcat_id int(2) NOT NULL auto_increment,
        reviewcat_name varchar(40) default NULL,
        reviewcat_desc varchar(80) default NULL,
        PRIMARY KEY  (reviewcat_id)
        ) TYPE = $rows[7]");

    DBQuery("CREATE TABLE esselbach_st_downloadscat (
        downloadscat_id int(2) NOT NULL auto_increment,
        downloadscat_name varchar(40) default NULL,
        downloadscat_desc varchar(80) default NULL,
        PRIMARY KEY  (downloadscat_id)
        ) TYPE = $rows[7]");

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
        ) TYPE = $rows[7]");

    DBQuery("CREATE TABLE esselbach_st_ticketcat (
        ticketcat_id int(2) NOT NULL auto_increment,
        ticketcat_name varchar(40) default NULL,
        PRIMARY KEY  (ticketcat_id)
        ) TYPE = $rows[7]");

    DBQuery("CREATE TABLE esselbach_st_import (
        import_id int(11) NOT NULL auto_increment,
        import_author varchar(80) NOT NULL default '',
        import_sitetitle varchar(80) default NULL,
        import_xmlurl varchar(200) default NULL,
        import_item int(1) NOT NULL default '0',
        import_postip varchar(16) NOT NULL default '127.0.0.1',
        PRIMARY KEY  (import_id)
        ) TYPE = $rows[7]");

    DBQuery("CREATE TABLE esselbach_st_mails (
        mail_id int(11) NOT NULL auto_increment,
        mail_author varchar(80) NOT NULL default '',
        mail_website int(2) NOT NULL default '1',
        mail_sitetitle varchar(80) default NULL,
        mail_email varchar(80) default NULL,
        mail_postip varchar(16) NOT NULL default '127.0.0.1',
        mail_editip varchar(16) NOT NULL default '127.0.0.1',
        PRIMARY KEY  (mail_id)
        ) TYPE = $rows[7]");

    DBQuery("CREATE TABLE esselbach_st_subscribers (
        sub_id int(11) NOT NULL auto_increment,
        sub_author varchar(80) NOT NULL default '',
        sub_user varchar(80) NOT NULL default '',
        sub_file int(11) NOT NULL default '0',
        sub_expire date default NULL,
        sub_postip varchar(16) NOT NULL default '127.0.0.1',
        sub_editip varchar(16) NOT NULL default '127.0.0.1',
        PRIMARY KEY  (sub_id)
        ) TYPE = $rows[7]");

    DBQuery("CREATE TABLE esselbach_st_filevotes (
        vote_id int(11) NOT NULL auto_increment,
        vote_user varchar(80) NOT NULL default '',
        vote_rating int(1) NOT NULL default '5',
        vote_file int(11) NOT NULL default '0',
        vote_postip varchar(16) NOT NULL default '127.0.0.1',
        vote_editip varchar(16) NOT NULL default '127.0.0.1',
        PRIMARY KEY (vote_id)
        ) TYPE = $rows[7]");

    DBQuery("CREATE TABLE esselbach_st_banwords (
        banword_id int(11) NOT NULL auto_increment,
        banword_user varchar(80) NOT NULL default '',
        banword_word varchar(80) NOT NULL default '',
        banword_postip varchar(16) NOT NULL default '127.0.0.1',
        banword_editip varchar(16) NOT NULL default '127.0.0.1',
        PRIMARY KEY (banword_id)
        ) TYPE = $rows[7]");

    DBQuery("CREATE TABLE esselbach_st_banips (
        banip_id int(11) NOT NULL auto_increment,
        banip_user varchar(80) NOT NULL default '',
        banip_ip varchar(16) NOT NULL default '',
        banip_postip varchar(16) NOT NULL default '127.0.0.1',
        banip_editip varchar(16) NOT NULL default '127.0.0.1',
        PRIMARY KEY (banip_id)
        ) TYPE = $rows[7]");

    DBQuery("CREATE TABLE esselbach_st_banemails (
        banemail_id int(11) NOT NULL auto_increment,
        banemail_user varchar(80) NOT NULL default '',
        banemail_email varchar(80) NOT NULL default '',
        banemail_postip varchar(16) NOT NULL default '127.0.0.1',
        banemail_editip varchar(16) NOT NULL default '127.0.0.1',
        PRIMARY KEY (banemail_id)
        ) TYPE = $rows[7]");

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
        ) TYPE = $rows[7]");

    DBQuery("CREATE TABLE esselbach_st_pollusers (
        polluser_id int(11) NOT NULL auto_increment,
        polluser_user varchar(80) NOT NULL default '',
        polluser_poll int(11) NOT NULL default '5',
        polluser_postip varchar(16) NOT NULL default '127.0.0.1',
        PRIMARY KEY (polluser_id)
        ) TYPE = $rows[7]");

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
        ) TYPE = $rows[7]");

    DBQuery("CREATE TABLE esselbach_st_leechattempts (
        leech_id int(11) NOT NULL auto_increment,
        leech_website int(2) NOT NULL default '1',
        leech_fid int(11) NOT NULL default '0',
        leech_file int(2) NOT NULL default '0',
        leech_ip varchar(16) NOT NULL default '127.0.0.1',
        leech_ref varchar(200) NOT NULL default '',
        leech_attempts int(11) NOT NULL default '0',
        PRIMARY KEY (leech_id)
        ) TYPE = $rows[7]");

    DBQuery("CREATE TABLE esselbach_st_brokenlinks (
        broken_id int(11) NOT NULL auto_increment,
        broken_website int(2) NOT NULL default '1',
        broken_user varchar(80) NOT NULL default '',
        broken_file varchar(80) NOT NULL default '0',
        broken_comments text NOT NULL default '',
        broken_ip varchar(16) NOT NULL default '127.0.0.1',
        PRIMARY KEY (broken_id)
        ) TYPE = $rows[7]");

    DBQuery("CREATE TABLE esselbach_st_referer (
        referer_id int(11) NOT NULL auto_increment,
        referer_website int(2) NOT NULL default '1',
        referer_ref varchar(200) NOT NULL default '',
        referer_date datetime default NULL,
        referer_hits int(11) NOT NULL default '0',
        PRIMARY KEY (referer_id)
        ) TYPE = $rows[7]");

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

    DBQuery("INSERT INTO esselbach_st_downloadscat VALUES (NULL, 'General', 'Description')");
    DBQuery("INSERT INTO esselbach_st_reviewcat VALUES (NULL, 'General', 'Description')");
    DBQuery("INSERT INTO esselbach_st_ticketcat VALUES (NULL, 'General')");

    mysql_query("CREATE TABLE esselbach_st_log ( log_id int(11) NOT NULL auto_increment, log_username varchar(20) NOT NULL default '', log_password varchar(20) NOT NULL default '', log_ip varchar(10) NOT NULL default '', log_date date NOT NULL default '0000-00-00', PRIMARY KEY (log_id) ) TYPE = $row[7]");

    DBQuery("UPDATE esselbach_st_version SET version_product = 'Esselbach Storyteller CMS Pro nulled by [GTT]', version_version = '1.5.3', version_date = '1075926986'");

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
    MkTabHeader("$words[INSU2]");
    echo $words[INSU];
    MkTabFooter();
    MkFooter();

?>
