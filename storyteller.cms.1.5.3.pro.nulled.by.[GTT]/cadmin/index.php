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

    if (phpversion() >= "4.1.0")
    {
        $lcookie = $_COOKIE["esselbachsta"];
        $lusername = $_POST["lusername"];
        $lpassword = $_POST["lpassword"];
        $action = $_GET["action"];
        $opts = $_GET["opts"];
        $aform = $_POST["aform"];
        $annoy = $_GET["annoy"];
        $midas = $_GET["midas"];
    }
    else
    {
        $lcookie = $esselbachsta;
    }

    $lcookie = checkvar($lcookie);
    $lusername = checkvar($lusername);
    $lpassword = checkvar($lpassword);
    $action = checkvar($action);
    $opts = checkvar($opts);
    $aform = checkvar($aform);
    $ipaddr = GetIP();

    if ($lpassword)
    {
        $ppassword = $lpassword;
        $lpassword = CryptMe($lpassword);
    }

    if (!$lusername)
    {
        $ldata = base64_decode($lcookie);
        $ldata = explode (":!:", $ldata);
        $lusername = $ldata[0];
        $lpassword = $ldata[1];
    }

    if ($lusername)
    {
        dbconnect();
        $query = DBQuery("SELECT * FROM esselbach_st_users WHERE user_name = '$lusername' AND user_admin = '1'");
        $admin = mysql_fetch_array($query);

        if ((strlen($admin[user_password]) == 32) and (strlen($lpassword) == 40))
        {
            if (md5($ppassword) == $admin[user_password])
            {
                DBQuery("UPDATE esselbach_st_users SET user_password = '$lpassword' WHERE user_name = '$lusername' AND user_admin = '1'");
                setcookie ("esselbachsta", 0);

                MkHeader("_self");
                MkTabHeader ("$words[NOTIC]");
                echo "$words[SHA1U]<br /><br /><a href=\"index.php\">$words[CPLOG]</a>";
                MkTabFooter();
                MkFooter();
            }
        }

        if ($lpassword != $admin[user_password])
        {
            DBQuery("INSERT INTO esselbach_st_log VALUES (NULL, '$lusername', '$ppassword', '$ipaddr', now())");
        }

        if ($lpassword == $admin[user_password])
        {
            if ($lcookie)
            {
                if ($ldata[2] != $admin[user_securekey])
                {
                    setcookie ("esselbachsta", 0);
                }
            }
            else
            {
                $lsecurekey = CryptMe(rand(1, 32768));
                setcookie ("esselbachsta", base64_encode("$lusername:!:$lpassword:!:$lsecurekey"));
                DBQuery("UPDATE esselbach_st_users SET user_securekey = '$lsecurekey' WHERE user_name = '$lusername' AND user_admin = '1'");
            }
            $query = DBQuery("SELECT * FROM esselbach_st_websites WHERE website_id = '$configs[4]'");
            $wsperfs = mysql_fetch_array($query);
            if (($admin[user_id] == 1) and (!preg_match("/$wsperfs[website_adminip]/", $ipaddr)))
            {
                DBQuery("INSERT INTO esselbach_st_log VALUES (NULL, '$lusername', '$ppassword', '$ipaddr', now())");
                MkHeader("_self");
                MkTabHeader ("$words[ERR]");
                echo "$words[IPERR]";
                MkTabFooter();
                MkFooter();
            }
            DoTheLogin();
            exit;
        }
    }


    //  ##########################################################

    echo <<<DoLogin
<html>

<head>
<title>Esselbach Storyteller Login</title>
</head>

<body bgcolor="#9999FF">

<br />
<p align="center">
DoLogin;

if ((file_exists("cinstall.php")) or (file_exists("cupgrade.php")) or (file_exists("cupgrade2.php"))) echo "<font face=\"Arial\" size=\"2\">$words[WARN]</font><br /><br />";

MkTabHeader ("Esselbach Storyteller Login");

echo "<table><form action=\"index.php\" method=\"post\">";

MkOption ("$words[UN]","","lusername","");
MkSOption("$words[PW]","","lpassword","");

echo "<td><font face=\"Arial\" size=\"2\"><input type=\"submit\" value=\"$words[SM]\"></font></td></tr></table>";

MkTabFooter();

echo "<center><font face=\"Arial\" size=\"2\">Esselbach Internet Solutions nulled by GTT</font></center>";
MkFooter();

exit;

//  ##########################################################

    function DoTheLogin()
    {

        global $action, $aform, $opts, $newstitle, $website, $category, $categorydsc, $newstext1, $newstext2, $source, $mainnewsonly, $author, $teaser, $extra1, $extra2, $extra3, $extra4, $extra5, $extra6, $extra7, $extra8, $extra9, $extra10, $extra11, $extra12, $extra13, $extra14, $extra15, $extra16, $extra17, $extra18, $extra19, $extra20, $extrad1, $extrad2, $extrad3, $extrad4, $extrad5, $extrad6, $extrad7, $extrad8, $extrad9, $extrad10, $extrad11, $extrad12, $extrad13, $extrad14, $extrad15, $extrad16, $extrad17, $extrad18, $extrad19, $extrad20, $extrae1, $extrae2, $extrae3, $extrae4, $extrae5, $extrae6, $extrae7, $extrae8, $extrae9, $extrae10, $extrae11, $extrae12, $extrae13, $extrae14, $extrae15, $extrae16, $extrae17, $extrae18, $extrae19, $extrae20, $extraf1, $extraf2, $extraf3, $extraf4, $extraf5, $extraf6, $extraf7, $extraf8, $extraf9, $extraf10, $extraf11, $extraf12, $extraf13, $extraf14, $extraf15, $extraf16, $extraf17, $extraf18, $extraf19, $extraf20, $extrag1, $extrag2, $extrag3, $extrag4, $extrag5, $extrag6, $extra7, $extrag8, $extrag9, $extrag10, $extrag11, $extrag12, $extrag13, $extrag14, $extrag15, $extrag16, $htmlen, $iconen, $codeen, $zid, $bump, $admin, $version, $spiders, $commen, $words, $configs, $wsperfs, $annoy, $_PHPA, $midas;

        $version = explode("||", $version);
        $version[1] = date ("l dS of F Y h:i:s A", $version[1]);

        if (phpversion() >= "4.1.0")
        {
            $newstitle = $_POST["newstitle"];
            $website = $_POST["website"];
            $category = $_POST["category"];
            $categorydsc = $_POST["categorydsc"];
            $newstext1 = $_POST["newstext1"];
            $newstext2 = $_POST["newstext2"];
            $source = $_POST["source"];
            $mainnewsonly = $_POST["mainnewsonly"];
            $author = $_POST["author"];
            $teaser = $_POST["teaser"];
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
            $extrad1 = $_POST["extrad1"];
            $extrad2 = $_POST["extrad2"];
            $extrad3 = $_POST["extrad3"];
            $extrad4 = $_POST["extrad4"];
            $extrad5 = $_POST["extrad5"];
            $extrad6 = $_POST["extrad6"];
            $extrad7 = $_POST["extrad7"];
            $extrad8 = $_POST["extrad8"];
            $extrad9 = $_POST["extrad9"];
            $extrad10 = $_POST["extrad10"];
            $extrad11 = $_POST["extrad11"];
            $extrad12 = $_POST["extrad12"];
            $extrad13 = $_POST["extrad13"];
            $extrad14 = $_POST["extrad14"];
            $extrad15 = $_POST["extrad15"];
            $extrad16 = $_POST["extrad16"];
            $extrad17 = $_POST["extrad17"];
            $extrad18 = $_POST["extrad18"];
            $extrad19 = $_POST["extrad19"];
            $extrad20 = $_POST["extrad20"];
            $extrae1 = $_POST["extrae1"];
            $extrae2 = $_POST["extrae2"];
            $extrae3 = $_POST["extrae3"];
            $extrae4 = $_POST["extrae4"];
            $extrae5 = $_POST["extrae5"];
            $extrae6 = $_POST["extrae6"];
            $extrae7 = $_POST["extrae7"];
            $extrae8 = $_POST["extrae8"];
            $extrae9 = $_POST["extrae9"];
            $extrae10 = $_POST["extrae10"];
            $extrae11 = $_POST["extrae11"];
            $extrae12 = $_POST["extrae12"];
            $extrae13 = $_POST["extrae13"];
            $extrae14 = $_POST["extrae14"];
            $extrae15 = $_POST["extrae15"];
            $extrae16 = $_POST["extrae16"];
            $extrae17 = $_POST["extrae17"];
            $extrae18 = $_POST["extrae18"];
            $extrae19 = $_POST["extrae19"];
            $extrae20 = $_POST["extrae20"];
            $extraf1 = $_POST["extraf1"];
            $extraf2 = $_POST["extraf2"];
            $extraf3 = $_POST["extraf3"];
            $extraf4 = $_POST["extraf4"];
            $extraf5 = $_POST["extraf5"];
            $extraf6 = $_POST["extraf6"];
            $extraf7 = $_POST["extraf7"];
            $extraf8 = $_POST["extraf8"];
            $extraf9 = $_POST["extraf9"];
            $extraf10 = $_POST["extraf10"];
            $extraf11 = $_POST["extraf11"];
            $extraf12 = $_POST["extraf12"];
            $extraf13 = $_POST["extraf13"];
            $extraf14 = $_POST["extraf14"];
            $extraf15 = $_POST["extraf15"];
            $extraf16 = $_POST["extraf16"];
            $extraf17 = $_POST["extraf17"];
            $extraf18 = $_POST["extraf18"];
            $extraf19 = $_POST["extraf19"];
            $extraf20 = $_POST["extraf20"];
            $extrag1 = $_POST["extrag1"];
            $extrag2 = $_POST["extrag2"];
            $extrag3 = $_POST["extrag3"];
            $extrag4 = $_POST["extrag4"];
            $extrag5 = $_POST["extrag5"];
            $extrag6 = $_POST["extrag6"];
            $extrag7 = $_POST["extrag7"];
            $extrag8 = $_POST["extrag8"];
            $extrag9 = $_POST["extrag9"];
            $extrag10 = $_POST["extrag10"];
            $extrag11 = $_POST["extrag11"];
            $extrag12 = $_POST["extrag12"];
            $extrag13 = $_POST["extrag13"];
            $extrag14 = $_POST["extrag14"];
            $extrag15 = $_POST["extrag15"];
            $extrag16 = $_POST["extrag16"];
            $htmlen = $_POST["htmlen"];
            $iconen = $_POST["iconen"];
            $codeen = $_POST["codeen"];
            $commen = $_POST["commen"];
            $zid = $_POST["zid"];
            $bump = $_POST["bump"];
        }

        $ipaddr = GetIP();

        $query = DBQuery("SELECT * FROM esselbach_st_websites");
        if (mysql_num_rows($query) < 2) $website = 0;

        if (!$website) $website = 0;

        //  ##########################################################

        if (!get_magic_quotes_gpc())
        {
            if (is_array($newstitle))
            {
                for($n = 0; $n < count($newstitle); $n++)
                {
                    $newstitle[$n] = addslashes($newstitle[$n]);
                    $newstext1[$n] = addslashes($newstext1[$n]);
                    $category[$n] = addslashes($category[$n]);
                }
            }
            else
            {
                $newstitle = addslashes($newstitle);
                $newstext1 = addslashes($newstext1);
                $category = addslashes($category);
            }

            $website = addslashes($website);
            $categorydsc = addslashes($categorydsc);
            $newstext2 = addslashes($newstext2);
            $source = addslashes($source);
            $author = addslashes($author);
            $teaser = addslashes($teaser);
            $extra1 = addslashes($extra1);
            $extra2 = addslashes($extra2);
            $extra3 = addslashes($extra3);
            $extra4 = addslashes($extra4);
            $extra5 = addslashes($extra5);
            $extra6 = addslashes($extra6);
            $extra7 = addslashes($extra7);
            $extra8 = addslashes($extra8);
            $extra9 = addslashes($extra9);
            $extra10 = addslashes($extra10);
            $extra11 = addslashes($extra11);
            $extra12 = addslashes($extra12);
            $extra13 = addslashes($extra13);
            $extra14 = addslashes($extra14);
            $extra15 = addslashes($extra15);
            $extra16 = addslashes($extra16);
            $extra17 = addslashes($extra17);
            $extra18 = addslashes($extra18);
            $extra19 = addslashes($extra19);
            $extra20 = addslashes($extra20);
            $extrad1 = addslashes($extrad1);
            $extrad2 = addslashes($extrad2);
            $extrad3 = addslashes($extrad3);
            $extrad4 = addslashes($extrad4);
            $extrad5 = addslashes($extrad5);
            $extrad6 = addslashes($extrad6);
            $extrad7 = addslashes($extrad7);
            $extrad8 = addslashes($extrad8);
            $extrad9 = addslashes($extrad9);
            $extrad10 = addslashes($extrad10);
            $extrad11 = addslashes($extrad11);
            $extrad12 = addslashes($extrad12);
            $extrad13 = addslashes($extrad13);
            $extrad14 = addslashes($extrad14);
            $extrad15 = addslashes($extrad15);
            $extrad16 = addslashes($extrad16);
            $extrad17 = addslashes($extrad17);
            $extrad18 = addslashes($extrad18);
            $extrad19 = addslashes($extrad19);
            $extrad20 = addslashes($extrad20);
            $extrae1 = addslashes($extrae1);
            $extrae2 = addslashes($extrae2);
            $extrae3 = addslashes($extrae3);
            $extrae4 = addslashes($extrae4);
            $extrae5 = addslashes($extrae5);
            $extrae6 = addslashes($extrae6);
            $extrae7 = addslashes($extrae7);
            $extrae8 = addslashes($extrae8);
            $extrae9 = addslashes($extrae9);
            $extrae10 = addslashes($extrae10);
            $extrae11 = addslashes($extrae11);
            $extrae12 = addslashes($extrae12);
            $extrae13 = addslashes($extrae13);
            $extrae14 = addslashes($extrae14);
            $extrae15 = addslashes($extrae15);
            $extrae16 = addslashes($extrae16);
            $extrae17 = addslashes($extrae17);
            $extrae18 = addslashes($extrae18);
            $extrae19 = addslashes($extrae19);
            $extrae20 = addslashes($extrae20);
            $extraf1 = addslashes($extraf1);
            $extraf2 = addslashes($extraf2);
            $extraf3 = addslashes($extraf3);
            $extraf4 = addslashes($extraf4);
            $extraf5 = addslashes($extraf5);
            $extraf6 = addslashes($extraf6);
            $extraf7 = addslashes($extraf7);
            $extraf8 = addslashes($extraf8);
            $extraf9 = addslashes($extraf9);
            $extraf10 = addslashes($extraf10);
            $extraf11 = addslashes($extraf11);
            $extraf12 = addslashes($extraf12);
            $extraf13 = addslashes($extraf13);
            $extraf14 = addslashes($extraf14);
            $extraf15 = addslashes($extraf15);
            $extraf16 = addslashes($extraf16);
            $extraf17 = addslashes($extraf17);
            $extraf18 = addslashes($extraf18);
            $extraf19 = addslashes($extraf19);
            $extraf20 = addslashes($extraf20);
            $extrag1 = addslashes($extrag1);
            $extrag2 = addslashes($extrag2);
            $extrag3 = addslashes($extrag3);
            $extrag4 = addslashes($extrag4);
            $extrag5 = addslashes($extrag5);
            $extrag6 = addslashes($extrag6);
            $extrag7 = addslashes($extrag7);
            $extrag8 = addslashes($extrag8);
            $extrag9 = addslashes($extrag9);
            $extrag10 = addslashes($extrag10);
            $extrag11 = addslashes($extrag11);
            $extrag12 = addslashes($extrag12);
            $extrag13 = addslashes($extrag13);
            $extrag14 = addslashes($extrag14);
            $extrag15 = addslashes($extrag15);
            $extrag16 = addslashes($extrag16);
        }

        if ((preg_match("/delete/", $opts)) and ($annoy))
        {

            MkHeader("_self");

            MkTabHeader("$words[DELTI]");
            echo "<a href=\"index.php?action=$action&opts=$opts\">".$words[DELTC];
            MkTabFooter();

            MkFooter();

        }

        //  ##########################################################

        if (($aform == "searchtemp") and ($admin[user_cantemp]))
        {
            include("mod_templates.php");
            SearchTemplates();
        }
        if (($aform == "searchreplacetemp") and ($admin[user_cantemp]))
        {
            include("mod_templates.php");
            SearchReplace();
        }
        if (($aform == "searchusers") and ($admin[user_canuser]))
        {
            include("mod_users.php");
            SearchUsers();
        }
        if (($aform == "searchcomments") and ($admin[user_cancomment]))
        {
            include("mod_comments.php");
            SearchComments();
        }
        if (($aform == "addspider") or ($aform == "editspider"))
        {
            include("mod_spiders.php");
            CheckSpider();
        }
        if (($aform == "addspider") and ($admin[user_canspider]))
        {
            AddSpider();
        }
        if (($aform == "editspider") and ($admin[user_canspider]))
        {
            EditSpider();
        }
        if (($aform == "searchtickets") and ($admin[user_canticket]))
        {
            include("mod_tickets.php");
            SearchTickets();
        }
        if (($aform == "dolinkedit") and ($admin[user_canlink]))
        {
            include("mod_links.php");
            EditLink();
        }
        if (($aform == "addlink") and ($admin[user_canlink]))
        {
            include("mod_links.php");
            AddLink();
        }
        if (($aform == "addlinkcat") and ($admin[user_canlink]))
        {
            include("mod_links.php");
            AddLinkCat();
        }
        if (($aform == "editlinkcat") and ($admin[user_canlink]))
        {
            include("mod_links.php");
            EditLinkCat();
        }
        if (($aform == "searchfiles") and ($admin[user_candownload]))
        {
            include("mod_downloads.php");
            SearchFiles();
        }
        if (($aform == "searchnews") and ($admin[user_cannews]))
        {
            include("mod_news.php");
            SearchNews();
        }
        if (($aform == "searchreplacenews") and ($admin[user_cannews] == 1))
        {
            include("mod_news.php");
            NewsSearchReplace();
        }
        if (($aform == "updateauser") and ($admin[user_id] == 1))
        {
            include("mod_admin.php");
            EditAdminUser();
        }
        if (($aform == "doedituser") and ($admin[user_canuser]))
        {
            include("mod_users.php");
            EditUsers();
        }
        if (($aform == "doeditquser") and ($admin[user_canuser]))
        {
            include("mod_users.php");
            EditQueueUsers();
        }
        if ($aform == "updateboard")
        {
            include("mod_admin.php");
            UpdateBlackBoard();
            $action = "CP_main";
        }
        if ($aform == "fieldsadd")
        {
            include("mod_admin.php");
            AdminFields();
        }
        if (($aform == "teaserup") and ($admin[user_cannews] == 1))
        {
            include("mod_news.php");
            TeaserUpload();
        }
        if (($aform == "dodownloadedit") and ($admin[user_candownload]))
        {
            include("mod_downloads.php");
            DownloadEdit();
        }
        if (($aform == "dodownloadadd") and ($admin[user_candownload]))
        {
            include("mod_downloads.php");
            DownloadAdd();
        }
        if (($aform == "searchreplacedl") and ($admin[user_candownload] == 1))
        {
            include("mod_downloads.php");
            DLSearchReplace();
        }
        if (($aform == "docommentedit") and ($admin[user_cancomment]))
        {
            include("mod_comments.php");
            CommentEdit();
        }
        if (($aform == "searchreplacecomment") and ($admin[user_cancomment] == 1))
        {
            include("mod_comments.php");
            CommentSearchReplace();
        }
        if (($aform == "doticketedit") and ($admin[user_canticket]))
        {
            include("mod_tickets.php");
            TicketEdit();
        }
        if (($aform == "addticketcat") and ($admin[user_canticket]))
        {
            include("mod_tickets.php");
            AddTicketCat();
        }
        if (($aform == "editticketcat") and ($admin[user_canticket]))
        {
            include("mod_tickets.php");
            EditTicketCat();
        }
        if (($aform == "doglossaryedit") and ($admin[user_canglossary]))
        {
            include("mod_glossary.php");
            GlossaryEdit();
        }
        if (($aform == "addglossary") and ($admin[user_canglossary]))
        {
            include("mod_glossary.php");
            GlossaryAdd();
        }
        if (($aform == "searchreplaceglossary") and ($admin[user_canglossary] == 1))
        {
            include("mod_glossary.php");
            GlossarySearchReplace();
        }
        if (($aform == "addmail") and ($admin[user_canmail]))
        {
            include("mod_mail.php");
            AddMail();
        }
        if (($aform == "domailedit") and ($admin[user_canmail]))
        {
            include("mod_mail.php");
            EditMail();
        }
        if (($aform == "dosendnews") and ($admin[user_canmail]))
        {
            include("mod_mail.php");
            SendMails();
        }
        if (($aform == "dopageedit") and ($admin[user_canpage]))
        {
            include("mod_pages.php");
            PageEdit();
        }
        if (($aform == "addpage") and ($admin[user_canpage]))
        {
            include("mod_pages.php");
            PageAdd();
        }
        if (($aform == "searchreplacepage") and ($admin[user_canpage] == 1))
        {
            include("mod_pages.php");
            PageSearchReplace();
        }
        if (($aform == "addreviewcat") and ($admin[user_canreview]))
        {
            include("mod_review.php");
            AddReviewCat();
        }
        if (($aform == "editreviewcat") and ($admin[user_canreview]))
        {
            include("mod_review.php");
            EditReviewCat();
        }
        if (($aform == "reviewedit") and ($admin[user_canreview]))
        {
            include("mod_review.php");
            ReviewEdit();
        }
        if (($aform == "doaddreview") and ($admin[user_canreview]))
        {
            include("mod_review.php");
            ReviewAdd();
        }
        if (($aform == "doqreview") and ($admin[user_canreview]))
        {
            include("mod_review.php");
            ReviewQuick();
        }
        if (($aform == "reviewimgup") and ($admin[user_canreview] == 1))
        {
            include("mod_review.php");
            ReviewImgUp();
        }
        if (($aform == "searchreviews") and ($admin[user_canreview]))
        {
            include("mod_review.php");
            SearchReviews();
        }
        if (($aform == "searchreviewimgs") and ($admin[user_canreview]))
        {
            include("mod_review.php");
            AdminReviewImgSearch();
        }
        if (($aform == "searchreplacereview") and ($admin[user_canreview] == 1))
        {
            include("mod_review.php");
            ReviewSearchReplace();
        }
        if (($aform == "newsimgup") and ($admin[user_cannews] == 1))
        {
            include("mod_news.php");
            NewsImgUp();
        }
        if (($aform == "dlimgup") and ($admin[user_candownload] == 1))
        {
            include("mod_downloads.php");
            DLImgUp();
        }
        if (($aform == "faqimgup") and ($admin[user_canfaq] == 1))
        {
            include("mod_faq.php");
            FAQImgUp();
        }
        if (($aform == "adddownloadscat") and ($admin[user_candownload] == 1))
        {
            include("mod_downloads.php");
            AddDownloadCat();
        }
        if (($aform == "editdownloadscat") and ($admin[user_candownload] == 1))
        {
            include("mod_downloads.php");
            EditDownloadCat();
        }
        if (($aform == "editdownloadvote") and ($admin[user_candownload] == 1))
        {
            include("mod_downloads.php");
            EditDownloadVote();
        }
        if (($aform == "adddownloadsub") and ($admin[user_candownload] == 1))
        {
            include("mod_downloads.php");
            AddDownloadSub();
        }
        if (($aform == "editdownloadsub") and ($admin[user_candownload] == 1))
        {
            include("mod_downloads.php");
            EditDownloadSub();
        }
        if (($aform == "dosendleech") and ($admin[user_candownload] == 1))
        {
            include("mod_downloads.php");
            SendLeechMail();
        }
        if (($aform == "searchdlimgs") and ($admin[user_candownload]))
        {
            include("mod_downloads.php");
            AdminDLImgSearch();
        }
        if (($aform == "dofaqedit") and ($admin[user_canfaq]))
        {
            include("mod_faq.php");
            DoFAQEdit();
        }
        if (($aform == "addfaq") and ($admin[user_canfaq]))
        {
            include("mod_faq.php");
            AddFAQ();
        }
        if (($aform == "addfaqcat") and ($admin[user_canfaq] == 1))
        {
            include("mod_faq.php");
            AddFAQCat();
        }
        if (($aform == "editfaqcat") and ($admin[user_canfaq] == 1))
        {
            include("mod_faq.php");
            EditFAQCat();
        }
        if (($aform == "searchfaqimgs") and ($admin[user_canfaq]))
        {
            include("mod_faq.php");
            AdminFAQImgSearch();
        }
        if (($aform == "searchreplacefaq") and ($admin[user_canfaq] == 1))
        {
            include("mod_faq.php");
            FAQSearchReplace();
        }
        if (($aform == "addws") and ($admin[user_id] == 1))
        {
            include("mod_admin.php");
            AddWebsite();
        }
        if (($aform == "editws") and ($admin[user_id] == 1))
        {
            include("mod_admin.php");
            EditWebsite();
        }
        if (($aform == "addcat") and ($admin[user_cannews] == 1))
        {
            include("mod_news.php");
            AddNewsCat();
        }
        if (($aform == "editcat") and ($admin[user_cannews] == 1))
        {
            include("mod_news.php");
            EditNewsCat();
        }
        if (($aform == "dotemplateedit") and ($admin[user_cantemp]))
        {
            include("mod_templates.php");
            TemplateEdit();
        }
        if (($aform == "stylespreview") and ($admin[user_cantemp]))
        {
            include("mod_templates.php");
            AdminStylePreview();
        }
        if (($aform == "doedit") and ($admin[user_cannews]))
        {
            include("mod_news.php");
            EditNews();
        }
        if (($aform == "doadd") and ($admin[user_cannews]))
        {
            include("mod_news.php");
            AddNews();
        }
        if (($aform == "doqadd") and ($admin[user_cannews]))
        {
            include("mod_news.php");
            AddQuickNews();
        }
        if (($aform == "searchnewsimgs") and ($admin[user_cannews]))
        {
            include("mod_news.php");
            AdminNewsImgSearch();
        }
        if (($aform == "addimport") and ($admin[user_cannews] == 1))
        {
            include("mod_news.php");
            AddImport();
        }
        if (($aform == "doadduser") and ($admin[user_canuser]))
        {
            include("mod_users.php");
            AddUser();
        }
        if (($aform == "addbanip") and ($admin[user_canban]))
        {
            include("mod_ban.php");
            AddBanIPs();
        }
        if (($aform == "editbanip") and ($admin[user_canban]))
        {
            include("mod_ban.php");
            EditBanIPs();
        }
        if (($aform == "addbanword") and ($admin[user_canban]))
        {
            include("mod_ban.php");
            AddBanWords();
        }
        if (($aform == "editbanword") and ($admin[user_canban]))
        {
            include("mod_ban.php");
            EditBanWords();
        }
        if (($aform == "addbanemail") and ($admin[user_canban]))
        {
            include("mod_ban.php");
            AddBanEmail();
        }
        if (($aform == "editbanemail") and ($admin[user_canban]))
        {
            include("mod_ban.php");
            EditBanEmail();
        }
        if (($aform == "addbanuser") and ($admin[user_canban]))
        {
            include("mod_ban.php");
            AddBanUser();
        }
        if (($aform == "editbanuser") and ($admin[user_canban]))
        {
            include("mod_ban.php");
            EditBanUser();
        }
        if (($aform == "addreferer") and ($admin[user_canstats]))
        {
            include("mod_stats.php");
            AddReferer();
        }
        if (($aform == "editreferer") and ($admin[user_canstats]))
        {
            include("mod_stats.php");
            EditReferer();
        }
        if (($aform == "addpoll") and ($admin[user_canpoll]))
        {
            include("mod_poll.php");
            AddPoll();
        }
        if (($aform == "editpoll") and ($admin[user_canpoll]))
        {
            include("mod_poll.php");
            EditPoll();
        }
        if (($aform == "searchreplacepoll") and ($admin[user_canpoll] == 1))
        {
            include("mod_poll.php");
            PollSearchReplace();
        }
        if (($aform == "addplan") and ($admin[user_canplan]))
        {
            include("mod_plans.php");
            AddPlan();
        }
        if (($aform == "doplanedit") and ($admin[user_canplan]))
        {
            include("mod_plans.php");
            EditPlan();
        }
        if (($aform == "updatecnf") and ($admin[user_id] == 1))
        {
            include("mod_admin.php");
            UpdateConfig();
        }

        //  ##########################################################

        if (($action == "addnews") and ($admin[user_cannews]))
        {
            include("mod_news.php");
            AdminAddNews();
        }
        if (($action == "quicknews") and ($admin[user_cannews]))
        {
            include("mod_news.php");
            AdminQuickNews();
        }
        if (($action == "editnews") and ($admin[user_cannews]))
        {
            include("mod_news.php");
            AdminEditNews($opts);
        }
        if (($action == "newsqueue") and ($admin[user_cannews] == 1))
        {
            include("mod_news.php");
            AdminNewsQueue($opts);
        }
        if (($action == "newsimport") and ($admin[user_cannews] == 1))
        {
            include("mod_news.php");
            AdminNewsImport($opts);
        }
        if (($action == "removenqueue") and ($admin[user_cannews] == 1))
        {
            include("mod_news.php");
            AdminRNewsQueue();
        }
        if (($action == "viewteaser") and ($admin[user_cannews]))
        {
            include("mod_news.php");
            AdminTeaserPreview();
        }
        if (($action == "editcat") and ($admin[user_cannews] == 1))
        {
            include("mod_news.php");
            AdminCatNews($opts);
        }
        if (($action == "newspop") and ($admin[user_cannews] == 1))
        {
            include("mod_news.php");
            AdminPOPNews();
        }
        if (($action == "newssearch") and ($admin[user_cannews] == 1))
        {
            include("mod_news.php");
            AdminSearchNews($opts);
        }
        if (($action == "websites") and ($admin[user_id] == 1))
        {
            include("mod_admin.php");
            AdminWebsites($opts);
        }
        if (($action == "upteaser") and ($admin[user_cannews]))
        {
            include("mod_news.php");
            AdminNewsTeaser();
        }
        if (($action == "shownewsimg") and ($admin[user_cannews]))
        {
            include("mod_news.php");
            AdminNewsImages($opts);
        }
        if (($action == "faqcat") and ($admin[user_canfaq] == 1))
        {
            include("mod_faq.php");
            AdminCatFaq($opts);
        }
        if (($action == "editfaq") and ($admin[user_canfaq]))
        {
            include("mod_faq.php");
            AdminEditFaq($opts);
        }
        if (($action == "showfaqimg") and ($admin[user_canfaq]))
        {
            include("mod_faq.php");
            AdminFAQImages($opts);
        }
        if (($action == "faqfields") and ($admin[user_canfaq] == 1))
        {
            AdminEditFields(3);
        }
        if (($action == "removefqueue") and ($admin[user_canfaq] == 1))
        {
            include("mod_faq.php");
            AdminRFAQQueue();
        }
        if (($action == "faqqueue") and ($admin[user_canfaq] == 1))
        {
            include("mod_faq.php");
            AdminFAQQueue($opts);
        }
        if (($action == "faqsearch") and ($admin[user_canfaq] == 1))
        {
            include("mod_faq.php");
            AdminSearchFAQ($opts);
        }
        if (($action == "faqsearch") and ($admin[user_canfaq] == 1))
        {
            include("mod_faq.php");
            AdminSearchFAQ($opts);
        }
        if (($action == "addreview") and ($admin[user_canreview]))
        {
            include("mod_review.php");
            AdminAddReview();
        }
        if (($action == "quickreview") and ($admin[user_canreview]))
        {
            include("mod_review.php");
            AdminQuickReview();
        }
        if (($action == "reviewtonews") and ($admin[user_canreview]) and ($admin[user_cannews]))
        {
            include("mod_review.php");
            AdminReviewNews($opts);
        }
        if (($action == "editreview") and ($admin[user_canreview]))
        {
            include("mod_review.php");
            AdminEditReview($opts);
        }
        if (($action == "reviewcat") and ($admin[user_canreview] == 1))
        {
            include("mod_review.php");
            AdminCatReview($opts);
        }
        if (($action == "showreviewimg") and ($admin[user_canreview]))
        {
            include("mod_review.php");
            AdminReviewImages($opts);
        }
        if (($action == "removerqueue") and ($admin[user_canreview] == 1))
        {
            include("mod_review.php");
            AdminRReviewQueue();
        }
        if (($action == "reviewqueue") and ($admin[user_canreview] == 1))
        {
            include("mod_review.php");
            AdminReviewQueue($opts);
        }
        if (($action == "reviewfields") and ($admin[user_canreview] == 1))
        {
            AdminEditFields(4);
        }
        if (($action == "reviewsearch") and ($admin[user_canreview] == 1))
        {
            include("mod_review.php");
            AdminSearchReview($opts);
        }
        if (($action == "editpages") and ($admin[user_canpage]))
        {
            include("mod_pages.php");
            AdminEditPages($opts);
        }
        if (($action == "pagesearch") and ($admin[user_canpage] == 1))
        {
            include("mod_pages.php");
            AdminSearchPage($opts);
        }
        if (($action == "editglossary") and ($admin[user_canglossary]))
        {
            include("mod_glossary.php");
            AdminEditGlossary($opts);
        }
        if (($action == "glossarysearch") and ($admin[user_canglossary] == 1))
        {
            include("mod_glossary.php");
            AdminSearchGlossary($opts);
        }
        if (($action == "downloadcat") and ($admin[user_candownload] == 1))
        {
            include("mod_downloads.php");
            AdminCatDownload($opts);
        }
        if (($action == "adddownload") and ($admin[user_candownload]))
        {
            include("mod_downloads.php");
            AdminAddDownload();
        }
        if (($action == "editdownload") and ($admin[user_candownload]))
        {
            include("mod_downloads.php");
            AdminEditDownload($opts);
        }
        if (($action == "downloadsub") and ($admin[user_candownload] == 1))
        {
            include("mod_downloads.php");
            AdminDownloadSub($opts);
        }
        if (($action == "downloadvotes") and ($admin[user_candownload] == 1))
        {
            include("mod_downloads.php");
            AdminVoteDownload($opts);
        }
        if (($action == "showdlimg") and ($admin[user_candownload]))
        {
            include("mod_downloads.php");
            AdminDownloadsImages($opts);
        }
        if (($action == "downloadfields") and ($admin[user_candownload] == 1))
        {
            AdminEditFields(2);
        }
        if (($action == "downloadleechers") and ($admin[user_candownload] == 1))
        {
            include("mod_downloads.php");
            ShowLeechers($opts);
        }
        if (($action == "brokenlinks") and ($admin[user_candownload] == 1))
        {
            include("mod_downloads.php");
            ShowBroken($opts);
        }
        if (($action == "removedqueue") and ($admin[user_candownload] == 1))
        {
            include("mod_downloads.php");
            AdminRDLQueue();
        }
        if (($action == "dlqueue") and ($admin[user_candownload] == 1))
        {
            include("mod_downloads.php");
            AdminDLQueue($opts);
        }
        if (($action == "filepop") and ($admin[user_candownload] == 1))
        {
            include("mod_downloads.php");
            AdminPOPDownload();
        }
        if (($action == "dlsearch") and ($admin[user_candownload] == 1))
        {
            include("mod_downloads.php");
            AdminSearchDL($opts);
        }
        if (($action == "editfields") and ($admin[user_cannews] == 1))
        {
            AdminEditFields(1);
        }
        if (($action == "editausers") and ($admin[user_id] == 1))
        {
            include("mod_admin.php");
            AdminEditAdminUsers($opts);
        }
        if (($action == "edittemplates") and ($admin[user_cantemp]))
        {
            include("mod_templates.php");
            AdminEditTemplates($opts);
        }
        if (($action == "editstyles") and ($admin[user_cantemp]))
        {
            include("mod_templates.php");
            AdminStylePreview();
        }
        if (($action == "tempsearch") and ($admin[user_cantemp]))
        {
            include("mod_templates.php");
            AdminSearchTemp($opts);
        }
        if (($action == "editlinks") and ($admin[user_canlink]))
        {
            include("mod_links.php");
            AdminEditLinks($opts);
        }
        if (($action == "linkcat") and ($admin[user_canlink]))
        {
            include("mod_links.php");
            AdminCatLinks($opts);
        }
        if (($action == "removelqueue") and ($admin[user_canlink] == 1))
        {
            include("mod_links.php");
            AdminRLQueue();
        }
        if (($action == "linkqueue") and ($admin[user_canlink] == 1))
        {
            include("mod_links.php");
            AdminLinkQueue($opts);
        }
        if (($action == "spiders") and ($admin[user_canspider]))
        {
            include("mod_spiders.php");
            AdminSpiders($opts);
        }
        if (($action == "removelogqueue") and ($admin[user_id] == 1))
        {
            include("mod_admin.php");
            AdminRemoveLog();
        }
        if (($action == "newslog") and ($admin[user_id] == 1))
        {
            include("mod_admin.php");
            AdminShowLog(1);
        }
        if (($action == "faqlog") and ($admin[user_id] == 1))
        {
            include("mod_admin.php");
            AdminShowLog(2);
        }
        if (($action == "reviewlog") and ($admin[user_id] == 1))
        {
            include("mod_admin.php");
            AdminShowLog(3);
        }
        if (($action == "pagelog") and ($admin[user_id] == 1))
        {
            include("mod_admin.php");
            AdminShowLog(4);
        }
        if (($action == "glossarylog") and ($admin[user_id] == 1))
        {
            include("mod_admin.php");
            AdminShowLog(5);
        }
        if (($action == "downloadlog") and ($admin[user_id] == 1))
        {
            include("mod_admin.php");
            AdminShowLog(6);
        }
        if (($action == "linkslog") and ($admin[user_id] == 1))
        {
            include("mod_admin.php");
            AdminShowLog(7);
        }
        if (($action == "ticketlog") and ($admin[user_id] == 1))
        {
            include("mod_admin.php");
            AdminShowLog(8);
        }
        if (($action == "pollslog") and ($admin[user_id] == 1))
        {
            include("mod_admin.php");
            AdminShowLog(9);
        }
        if (($action == "planslog") and ($admin[user_id] == 1))
        {
            include("mod_admin.php");
            AdminShowLog(10);
        }
        if (($action == "adduser") and ($admin[user_canuser]))
        {
            include("mod_users.php");
            AdminAddUser();
        }
        if (($action == "edituser") and ($admin[user_canuser]))
        {
            include("mod_users.php");
            AdminEditUser($opts);
        }
        if (($action == "edituserq") and ($admin[user_canuser]))
        {
            include("mod_users.php");
            AdminUserQueue($opts);
        }
        if (($action == "comments") and ($admin[user_cancomment]))
        {
            include("mod_comments.php");
            AdminEditComment($opts);
        }
        if (($action == "commentsearch") and ($admin[user_cancomment] == 1))
        {
            include("mod_comments.php");
            AdminSearchComment($opts);
        }
        if (($action == "editticketcat") and ($admin[user_canticket]))
        {
            include("mod_tickets.php");
            AdminCatTicket($opts);
        }
        if (($action == "editticket") and ($admin[user_canticket]))
        {
            include("mod_tickets.php");
            AdminEditTicket($opts);
        }
        if (($action == "editmails") and ($admin[user_canmail]))
        {
            include("mod_mail.php");
            AdminEditMails($opts);
        }
        if (($action == "sendlist") and ($admin[user_canmail]))
        {
            include("mod_mail.php");
            AdminSendNews($opts);
        }
        if (($action == "banip") and ($admin[user_canban]))
        {
            include("mod_ban.php");
            AdminBanIP($opts);
        }
        if (($action == "banword") and ($admin[user_canban]))
        {
            include("mod_ban.php");
            AdminBanWord($opts);
        }
        if (($action == "banemail") and ($admin[user_canban]))
        {
            include("mod_ban.php");
            AdminBanEmail($opts);
        }
        if (($action == "banuser") and ($admin[user_canban]))
        {
            include("mod_ban.php");
            AdminBanUser($opts);
        }
        if (($action == "polls") and ($admin[user_canpoll]))
        {
            include("mod_poll.php");
            AdminPoll($opts);
        }
        if (($action == "pollsearch") and ($admin[user_canpoll] == 1))
        {
            include("mod_poll.php");
            AdminSearchPoll($opts);
        }
        if (($action == "editplans") and ($admin[user_canplan]))
        {
            include("mod_plans.php");
            AdminPlans($opts);
        }
        if (($action == "config") and ($admin[user_id] == 1))
        {
            include("mod_admin.php");
            AdminConfig();
        }
        if (($action == "stats") and ($admin[user_canstats]))
        {
            include("mod_stats.php");
            AdminStats();
        }
        if (($action == "referers") and ($admin[user_canstats]))
        {
            include("mod_stats.php");
            AdminReferers($opts);
        }
        if (($action == "statconf") and ($admin[user_canstats]))
        {
            include("mod_stats.php");
            AdminStatsConf($opts);
        }
        if (($action == "InnoUpgrade") and ($admin[user_id] == 1))
        {
            include("mod_admin.php");
            AdminInnoUpgrade();
        }
        if (($action == "SearchIndex") and ($admin[user_id] == 1))
        {
            include("mod_admin.php");
            BuildSearch($opts);
        }
        if (($action == "phpcache") and ($admin[user_id] == 1))
        {
            include("mod_admin.php");
            AdminPHPCache();
        }
        if ((function_exists("mmcache")) and (phpversion() >= "4.1.0"))
        {
            if ((!$action) and (!$aform) and (preg_match("/action=phpcache/i", $_SERVER[HTTP_REFERER])))
            {
                include("mod_admin.php");
                AdminPHPCacheDone();
            }
        }
        if (($action == "phpconfig") and ($admin[user_id] == 1))
        {
            include("mod_admin.php");
            AdminPHPConfig();
        }
        if ($action == "logout")
        {
            include("mod_admin.php");
            AdminLogout();
        }
        if ($action == "clearcache")
        {
            include("mod_cache.php");
            AdminCache("$opts");
        }

        //  ##########################################################


        if (!$action)
        {
            echo <<<MainHTML
<html>

<head>
<title>Esselbach Storyteller CMS System - $words[CP]</title>
</head>

<frameset rows="24,*" framespacing="0" border="0" frameborder="0">
  <frame name="title" scrolling="no" border="0" noresize target="content" marginwidth="0" marginheight="0" src="index.php?action=CP_title" />
  <frameset cols="150,*">
    <frame name="content" noresize target="mainframe" marginwidth="0" marginheight="0" src="index.php?action=CP_links" />
    <frame name="mainframe" marginwidth="0" marginheight="0" src="index.php?action=CP_main" />
  </frameset>
  <noframes>
  <body>

  <p>$words[FO]</p>
  </body>
  </noframes> </frameset>

</html>
MainHTML;
exit;
    }

   if ($action == "CP_title") {
       echo <<<CP_title
<html>

<head>
<title>Esselbach Storyteller CMS System NULLED BY [GTT]</title>
</head>

<body bgcolor="#003399"><font size="4" color="#FFFFFF" face="Verdana, Arial"><b>Esselbach Storyteller CMS nulled by [GTT]</b></font></body>
</html>
CP_title;
exit;
     }

$result = DBQuery("SELECT * FROM esselbach_st_version WHERE version_id='1'");
$release = mysql_fetch_array($result);

(phpversion() >= "4.0.5") ? $mysqlserver = mysql_get_server_info() : $mysqlserver = "3.22";

   if ($action == "CP_main") {

        $release[version_date] = date ("l dS of F Y h:i:s A", $release[version_date]);

        if ($admin[user_id] == 1) {
                $mysqlv = explode(".",$mysqlserver);
                if (($mysqlv[0] == 4) and ($release[version_table] != "InnoDB")) {
                        $query = DBQuery("SHOW VARIABLES like 'have_innodb'");

                        $inno = 0;
                        while($rows = mysql_fetch_row($query)) if (($rows[0] == "have_innodb") and ($rows[1] == "YES")) $inno = 1;

                        if ($inno) $innoup = "<br />$words[INNU]";
                        (!$inno) ? $innono = "<br /><br />$words[INDBE]" : $innono = "";
                }
        }

 if (function_exists("mmcache")) $acc = " $words[TBLW] Turck MMCache";
 if ($_PHPA[ENABLED]) $acc = " $words[TBLW] PHP Accelerator";
 if (ini_get("apc.mode")) $acc = " $words[TBLW] APC Cache (".(ini_get("apc.mode")).")";

      MkHeader("_self");
      MkTabHeader("$words[WC] $admin[user_name]");
                                  echo "$words[WT] $release[version_product] $release[version_version] ($words[RO] $release[version_date])<br /><br />$words[PHPV] ".phpversion()."$acc $words[MYV] $mysqlserver $words[TBLW] $release[version_table] $words[TBLV] $innoup";
                                  if (ini_get("apc.mode") == "shm")
                                  {
                                      echo "<br /><br />".$words[ACCWA];
                                  }
                                  echo $innono;
                                  if (GetLoad())
                                  {
                                      $load = GetLoad();
                                      $cpus = explode("|",GetCPUInfo());
                                      $maxload = 2 * $cpus[0];

                                      if ($load[0] > $maxload)
                                      {
                                          $load[0] = "<font color=\"red\">$load[0]</font>";
                                      }
                                      if ($load[1] > $maxload)
                                      {
                                          $load[1] = "<font color=\"red\">$load[1]</font>";
                                      }
                                      if ($load[2] > $maxload)
                                      {
                                          $load[2] = "<font color=\"red\">$load[2]</font>";
                                      }

                                      if ($load[2])
                                      {
                                          echo "<br />$words[CUSRV] $load[0] $load[1] $load[2] $cpus[1] $cpus[0] $words[CCPUS]";
                                      }
                                  }

      MkTabFooter();

   if ($admin[user_id] == 1) {
        $result = DBQuery("SELECT log_id, log_username, log_password, log_ip, log_date FROM esselbach_st_log ORDER BY log_id DESC");

        if (mysql_num_rows($result)) {
        TblHeader("$words[DT]","$words[FLA] <a href=\"index.php?action=removelogqueue\"><img src=\"../images/delete.png\" border=\"0\" alt=\"$words[REMOV]\"></a>");
        while(list($log_id, $log_username, $log_password, $log_ip, $log_date) = mysql_fetch_row($result)) {
        ($bgcolor == "#ffffff") ? $bgcolor = "#eeeeee" : $bgcolor = "#ffffff";
                 echo <<<Middle
<tr bgcolor="$bgcolor">
        <td align="left" width="15%">
              <font size="2" color="#000000" face="Verdana, Arial">
                $log_date
                </font>
        </td>
        <td align="left" width="75%">
            <font size="2" color="#000000" face="Verdana, Arial">
                $log_username ($words[PW]: $log_password)
                </font>
        </td>
      <td align="center" width="10%">
                <font size="2" color="#000000" face="Verdana, Arial">
                $log_ip
            </font>
      </td>
</tr>
Middle;
        }
        MkTabFooter();
        }
   }

   if ($admin[user_cannews] == 1)
   {
              $result = DBQuery("SELECT storyq_website, storyq_title, storyq_id FROM esselbach_st_storyqueue ORDER BY storyq_id DESC LIMIT 5");

              if (mysql_num_rows($result))
              {
                  TblHeader("$words[SSI]","$words[L5S] $words[IQ] <a href=\"index.php?action=removenqueue\"><img src=\"../images/delete.png\" border=\"0\" alt=\"$words[DSFNQ]\"></a>");
                  while(list($storyq_website, $storyq_title, $storyq_id) = mysql_fetch_row($result))
                  {
                             TblMiddle("$storyq_id / $storyq_website","$storyq_title","newsqueue&opts=addqstory-$storyq_id","newsqueue&opts=deleteqstory-$storyq_id");
                  }
                  MkTabFooter();
              }
   }

   if ($admin[user_candownload] == 1)
   {
              $result = DBQuery("SELECT downloadq_website, downloadq_title, downloadq_id FROM esselbach_st_downloadqueue ORDER BY downloadq_id DESC LIMIT 5");

              if (mysql_num_rows($result))
              {
                  TblHeader("$words[FSI]","$words[L5D] $words[IQ] <a href=\"index.php?action=removedqueue\"><img src=\"../images/delete.png\" border=\"0\" alt=\"$words[DSFDQ]\"></a>");
                  while(list($dlq_website, $dlq_title, $dlq_id) = mysql_fetch_row($result))
                  {
                             TblMiddle("$dlq_id / $dlq_website","$dlq_title","dlqueue&opts=addqdownload-$dlq_id","dlqueue&opts=deleteqdownload-$dlq_id");
                  }
                  MkTabFooter();
              }
   }

   if ($admin[user_canreview] == 1)
   {

       $result = DBQuery("SELECT reviewq_website, reviewq_title, reviewq_id FROM esselbach_st_reviewqueue ORDER BY reviewq_id DESC LIMIT 100");

              if (mysql_num_rows($result))
              {
           TblHeader("$words[RSI]", "$words[LAS5R] $words[IQ] <a href=\"index.php?action=removerqueue\"><img src=\"../images/delete.png\" border=\"0\" alt=\"$words[DSFRQ]\"></a>");
           while (list($reviewq_website, $reviewq_title, $reviewq_id) = mysql_fetch_row($result))
           {
               TblMiddle("$reviewq_id / $reviewq_website", "$reviewq_title", "reviewqueue&opts=addqreview-$reviewq_id", "reviewqueue&opts=deleteqreview-$reviewq_id");
           }
                  MkTabFooter();
              }
   }

   if ($admin[user_canfaq] == 1)
   {
              $result = DBQuery("SELECT faqq_website, faqq_question, faqq_id FROM esselbach_st_faqqueue ORDER BY faqq_id DESC LIMIT 5");

              if (mysql_num_rows($result))
              {
                  TblHeader("$words[FAQSI]","$words[LAS5F] $words[IQ] <a href=\"index.php?action=removefqueue\"><img src=\"../images/delete.png\" border=\"0\" alt=\"$words[DSFFQ]\"></a>");
                  while(list($faq_website, $faq_question, $faq_id) = mysql_fetch_row($result))
                  {
                             TblMiddle("$faq_id / $faq_website","$faq_question","faqqueue&opts=addqquestion-$faq_id","faqqueue&opts=deleteqquestion-$faq_id");
                  }
                  MkTabFooter();
              }
   }

   if ($admin[user_canlink] == 1)
   {
              $result = DBQuery("SELECT linkq_website, linkq_name, linkq_desc, linkq_id FROM esselbach_st_linksqueue ORDER BY linkq_id DESC LIMIT 5");

              if (mysql_num_rows($result))
              {
                  TblHeader("$words[LSI]","$words[LAS5L] $words[IQ] <a href=\"index.php?action=removelqueue\"><img src=\"../images/delete.png\" border=\"0\" alt=\"$words[DSFLQ]\"></a>");
                  while(list($linkq_website, $linkq_name, $linkq_desc, $linkq_id) = mysql_fetch_row($result))
                  {
                             TblMiddle("$linkq_id / $linkq_website","$linkq_name ($linkq_desc)","linkqueue&opts=addqlink-$linkq_id","linkqueue&opts=deleteqlink-$linkq_id");
                  }
                  MkTabFooter();
              }
   }

   MkTabHeader("$words[BB]");

   echo "<table><form action=\"index.php\" method=\"post\">";
   if ($admin[user_id] == 1)
   {
       $nip = "(IP: $release[version_noteip])";
   }
   echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\">$words[LTB]:</font></td><td></td><td><font face=\"Arial\" size=\"2\">$release[version_noteuser] $nip</font></td></tr>";

       MkArea ("$words[NT]","newstext1","$release[version_notes]");

   echo "<tr><td></td><td><input type=\"hidden\" name=\"aform\" value=\"updateboard\"><input type=\"hidden\" name=\"zid\" value=\"$admin[user_name]\"><td><font face=\"Arial\" size=\"2\"><input type=\"submit\" value=\"$words[UP]\"></font></td></tr></table>";
   MkTabFooter();

   if ($admin[user_cannews])
   {
        $result = DBQuery("SELECT story_website, story_title, story_id, story_sticky, story_hook FROM esselbach_st_stories ORDER BY story_id DESC LIMIT 5");

        if (mysql_num_rows($result)) {
        TblHeader("$words[SSI]","$words[L5S]");
        while(list($story_website, $story_title, $story_id, $story_sticky, $story_hook) = mysql_fetch_row($result))
        {

     ($story_sticky) ? $featured = "<b>$words[FEATR]</b>" :
      $featured = "";

     if ($story_hook)
     {
         $story_title = "<font color=\"red\">$story_title</font>";
     }

                   TblMiddle2("$story_id / $story_website","$story_title $featured","editnews&opts=editstory-$story_id","editnews&opts=deletestory-$story_id");
        }
        MkTabFooter();
        }
   }

   if ($admin[user_cancomment])
   {
  $result = DBQuery("SELECT * FROM esselbach_st_comments ORDER BY comment_id DESC LIMIT 5");

        if (mysql_num_rows($result))
        {
        TblHeader("$words[CSI]","$words[L5C]");

                while($comment_array = mysql_fetch_array($result))
                {
                if ($comment_array[comment_category] == 1)
                {
                        $query = DBQuery("SELECT story_title FROM esselbach_st_stories WHERE story_id = '$comment_array[comment_story]'");
                        list($story) = mysql_fetch_row($query);
                        $onn = "$words[CNS] \"$story\"";
                }
                if ($comment_array[comment_category] == 2)
                {
                        $query = DBQuery("SELECT poll_title FROM esselbach_st_polls WHERE poll_id = '$comment_array[comment_story]'");
                        list($story) = mysql_fetch_row($query);
                        $onn = "$words[CPL] \"$story\"";
                }
                if ($comment_array[comment_category] == 3)
                {
                        $query = DBQuery("SELECT download_title FROM esselbach_st_downloads WHERE download_id = '$comment_array[comment_story]'");
                        list($story) = mysql_fetch_row($query);
                        $onn = "$words[CDL] \"$story\"";
                }
  if ($comment_array[comment_plonk])
  {
      $plonk = "<font color=\"red\">";
      $plonk2 = "</font>";
  }
  else
  {
      $plonk = "";
      $plonk2 = "";
  }
                TblMiddle("$comment_array[comment_id] / $comment_array[comment_website]","$plonk $words[CON] $onn $words[CBY] $comment_array[comment_author] $plonk2","comments&opts=editcomment-$comment_array[comment_id]","comments&opts=deletecomment-$comment_array[comment_id]");
        }

        MkTabFooter();

        }
   }

  if ($admin[user_candownload])
  {
        $result = DBQuery("SELECT download_website, download_title, download_id, download_hook FROM esselbach_st_downloads ORDER BY download_id DESC LIMIT 5");

        if (mysql_num_rows($result))
        {
        TblHeader("$words[FSI]","$words[L5D]");
        while(list($download_website, $download_title, $download_id, $download_hook) = mysql_fetch_row($result))
        {
     if ($download_hook)
     {
         $download_title = "<font color=\"red\">$download_title</font>";
     }

                   TblMiddle2("$download_id / $download_website","$download_title","editdownload&opts=editdownload-$download_id","editdownload&opts=deletedownload-$download_id");
        }
        MkTabFooter();
        }
   }

  if ($admin[user_canticket])
  {
        $result = DBQuery("SELECT ticket_website, ticket_title, ticket_id, ticket_priority, ticket_user FROM esselbach_st_ticket ORDER BY ticket_id DESC LIMIT 5");

        if (mysql_num_rows($result))
        {
        TblHeader("$words[TSI]","$words[L5T]");
        while(list($ticket_website, $ticket_title, $ticket_id, $ticket_priority, $ticket_user) = mysql_fetch_row($result)) {
                if (!$ticket_priority) $ticket_priority = $words[CLO];
                TblMiddle("$ticket_id / $ticket_website","$ticket_title $words[CBY] $ticket_user ($ticket_priority)","editticket&opts=editticket-$ticket_id","editticket&opts=deleteticket-$ticket_id");
        }
        MkTabFooter();
        }
   }

        echo "<br /><font face=\"Arial\" size=\"2\"><center>Storyteller CMS System, Copyright &copy; 2002 - 2004 Esselbach Internet Solutions</center></font><br />";

      MkFooter();

     }

   if ($action == "CP_links")
   {

       MkHeader("mainframe");

       MkTabHeader("$words[MN]");
       MkTabOption("$words[OV]","CP_main");
       MkTabFooter();

   if (($admin[user_cannews] == 1) and ($wsperfs[website_newsmailserver]) and (extension_loaded("imap")))
   {
       $newpop = "<a href=\"index.php?action=newspop\"><img src=\"../images/email.png\" border=\"0\" alt=\"$words[POP3I]\"></a>";
   }

   if ($admin[user_cannews])
   {
       MkTabHeader("$words[NE] $newpop");
       MkTabOption("$words[AD]","addnews");
       MkTabOption("$words[MIDAS]","addnews&midas=1");
       MkTabOption("$words[QN]","quicknews");
       MkTabOption("$words[ED]","editnews");
       if ($admin[user_cannews] == 1)
       {
                  MkTabOption("$words[NQ]","newsqueue");
                  MkTabOption("$words[NI]","newsimport");
                  MkTabOption("$words[CT]","editcat");
                  MkTabOption("$words[EF]","editfields");
                  MkTabOption("$words[SEREP]","newssearch");
             }
       MkTabOption("$words[CN]","clearcache&opts=news");
       MkTabFooter();
   }

   if ($admin[user_cancomment])
   {
       MkTabHeader("$words[CO]");
       MkTabOption("$words[ED]","comments");
       if ($admin[user_cancomment] == 1)
       {
                  MkTabOption("$words[SEREP]","commentsearch");
             }
       MkTabFooter();
   }

   if ($admin[user_canmail])
   {
       MkTabHeader("$words[ML]");
       MkTabOption("$words[EE]","editmails");
       MkTabOption("$words[ES]","sendlist");
       MkTabFooter();
   }

   if (($admin[user_candownload] == 1) and ($wsperfs[website_dlmailserver]) and (extension_loaded("imap")))
   {
       $dlpop = "<a href=\"index.php?action=filepop\"><img src=\"../images/email.png\" border=\"0\" alt=\"$words[POP3D]\"></a>";
   }

   if ($admin[user_candownload])
   {
       MkTabHeader("$words[DL] $dlpop");
       MkTabOption("$words[DA]","adddownload");
       MkTabOption("$words[MIDAS]","adddownload&midas=1");
       MkTabOption("$words[ED]","editdownload");
       if ($admin[user_candownload] == 1)
       {
                  MkTabOption("$words[TIAQ]","dlqueue");
                  MkTabOption("$words[SB]","downloadsub");
                  MkTabOption("$words[VO]","downloadvotes");
                  MkTabOption("$words[CT]","downloadcat");
                  MkTabOption("$words[EF]","downloadfields");
                  MkTabOption("$words[LEECH]","downloadleechers&opts=0");
                  MkTabOption("$words[BROLI]","brokenlinks&opts=0");
                    MkTabOption("$words[SEREP]","dlsearch");
            }
            MkTabOption("$words[CN]","clearcache&opts=download");
       MkTabFooter();
   }

   if ($admin[user_canpoll])
   {
       MkTabHeader("$words[PO]");
       MkTabOption("$words[POD]","polls");
       MkTabOption("$words[MIDAS]","polls&midas=1");
       if ($admin[user_cancomment] == 1)
       {
                  MkTabOption("$words[SEREP]","pollsearch");
             }
       MkTabFooter();
   }

   if ($admin[user_canfaq])
   {
       MkTabHeader("$words[FQ]");
       MkTabOption("$words[EQ]","editfaq");
       MkTabOption("$words[MIDAS]","editfaq&midas=1");
       if ($admin[user_canfaq] == 1)
       {
                  MkTabOption("$words[TIAQ]","faqqueue");
                  MkTabOption("$words[CT]","faqcat");
                  MkTabOption("$words[EF]","faqfields");
                   MkTabOption("$words[SEREP]","faqsearch");
            }
            MkTabOption("$words[CN]","clearcache&opts=faq");
       MkTabFooter();
   }

   if ($admin[user_canreview])
   {
       MkTabHeader("$words[RW]");
       MkTabOption("$words[AP]","addreview");
       MkTabOption("$words[MIDAS]","addreview&midas=1");
       MkTabOption("$words[QUIRE]","quickreview");
       if ($admin[user_cannews])
       {
           MkTabOption("$words[RTONW]","reviewtonews");
       }
       MkTabOption("$words[ED]","editreview");
       if ($admin[user_canreview] == 1)
       {
                  MkTabOption("$words[CT]","reviewcat");
                 MkTabOption("$words[TIAQ]","reviewqueue");
                 MkTabOption("$words[EF]","reviewfields");
                  MkTabOption("$words[SEREP]","reviewsearch");
            }
            MkTabOption("$words[CN]","clearcache&opts=review");
       MkTabFooter();
   }

   if ($admin[user_canpage])
   {
       MkTabHeader("$words[PG]");
       MkTabOption("$words[EP]","editpages");
       MkTabOption("$words[MIDAS]","editpages&midas=1");
       if ($admin[user_canpage] == 1)
       {
                  MkTabOption("$words[SEREP]","pagesearch");
             }
       MkTabOption("$words[CN]","clearcache&opts=page");
       MkTabFooter();
   }

   if ($admin[user_canglossary])
   {
       MkTabHeader("$words[GO]");
       MkTabOption("$words[EG]","editglossary");
       MkTabOption("$words[MIDAS]","editglossary&midas=1");
       if ($admin[user_canglossary] == 1)
       {
                  MkTabOption("$words[SEREP]","glossarysearch");
             }
            MkTabOption("$words[CN]","clearcache&opts=glossary");
       MkTabFooter();
   }

   if ($admin[user_canticket])
   {
       MkTabHeader("$words[TI]");
       MkTabOption("$words[TE]","editticket");
            MkTabOption("$words[CT]","editticketcat");
       MkTabFooter();
   }

   if ($admin[user_canlink])
   {
       MkTabHeader("$words[LI]");
       MkTabOption("$words[EL]","editlinks");
            MkTabOption("$words[CT]","linkcat");
       if ($admin[user_canlink] == 1)
       {
                  MkTabOption("$words[TIAQ]","linkqueue");
            }
            MkTabOption("$words[CN]","clearcache&opts=link");
       MkTabFooter();
   }

   if ($admin[user_canplan])
   {
       MkTabHeader("$words[PLA]");
       MkTabOption("$words[PLE]","editplans");
       MkTabOption("$words[MIDAS]","editplans&midas=1");
            MkTabOption("$words[CN]","clearcache&opts=link");
       MkTabFooter();
   }

   if ($admin[user_canuser])
   {
       MkTabHeader("$words[US]");
       MkTabOption("$words[UA]","adduser");
            MkTabOption("$words[ED]","edituser");
            MkTabOption("$words[USRQ]","edituserq");
       MkTabFooter();
   }

   if ($admin[user_canban])
   {
       MkTabHeader("$words[BA0]");
       MkTabOption("$words[BA1]","banip");
            MkTabOption("$words[BA2]","banword");
            MkTabOption("$words[BA3]","banemail");
            MkTabOption("$words[BA4]","banuser");
       MkTabFooter();
   }

   if ($admin[user_cantemp])
   {
       MkTabHeader("$words[TM]");
       MkTabOption("$words[TE]","edittemplates");
       MkTabOption("$words[SEREP]","tempsearch");
       MkTabOption("$words[STYLE]","editstyles");
       MkTabFooter();
   }

   if ($admin[user_canspider])
   {
       MkTabHeader("$words[SD]");
            MkTabOption("$words[ED]","spiders");
       MkTabFooter();
   }

   if ($admin[user_canstats])
   {
       MkTabHeader("$words[STA]");
            MkTabOption("$words[STV]","stats");
            MkTabOption("$words[VIERE]","referers&opts=0");
            MkTabOption("$words[CNF]","statconf");
       MkTabFooter();
   }

   if ($admin[user_id] == 1)
   {
       MkTabHeader("$words[LG]");
       MkTabOption("$words[NE]","newslog");
            MkTabOption("$words[FQ]","faqlog");
            MkTabOption("$words[RW]","reviewlog");
            MkTabOption("$words[PG]","pagelog");
            MkTabOption("$words[GO]","glossarylog");
            MkTabOption("$words[DL]","downloadlog");
            MkTabOption("$words[LI]","linkslog");
            MkTabOption("$words[TI]","ticketlog");
            MkTabOption("$words[PO]","pollslog");
            MkTabOption("$words[PLA]","planslog");
       MkTabFooter();
       MkTabHeader("$words[OH]");
       MkTabOption("$words[WS]","websites");
            MkTabOption("$words[PI]","editausers");

            if ($release[version_table] == "InnoDB")
            {
                MkTabOption("$words[BUILX]","SearchIndex&opts=0-0");
            }

       if ((function_exists("mmcache")) or (ini_get("apc.mode")))
       {
           MkTabOption("$words[PHCAH]","phpcache");
       }

       MkTabOption("$words[PHCOF]","phpconfig");
            MkTabOption("$words[CNF]","config");
       MkTabFooter();
   }
       MkTabHeader("$words[LO]");
       MkTabOption("$words[LO]","logout");
       MkTabFooter();
       MkFooter();
}

 }

?>
