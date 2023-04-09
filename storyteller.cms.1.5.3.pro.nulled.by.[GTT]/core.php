<?php

    /*
    ########################
    # |//////////////////| #
    # NULLED by [GTT] =)   #
    # |\\\\\\\\\\\\\\\\\\| #
    ########################
    */

    error_reporting(0);

    if (phpversion() >= "4.1.0")
    {
        $phps = $_SERVER[PHP_SELF];
        $referer = $_SERVER[HTTP_REFERER];
    }
    else
    {
       $phps = $PHP_SELF;
       $referer = getenv("HTTP_REFERER");
    }

    $phps = checkvar ($phps);
    $referer = checkvar ($referer);

    (preg_match("/cadmin/i", $phps)) ? $ext = "../" : $ext = ".";

    if (file_exists("$ext/config.php"))
    {
        require("$ext/config.php");
        $configs = explode(":_:", base64_decode($estc));
    }
    else
    {
        die ("Error: Can't find config.php");
    }

    if (!preg_match("/backend|mobile|downloadget|scode/", $phps))
    {
        if ((phpversion() >= "4.0.5") and (extension_loaded("zlib")) and (!ini_get("output_handler")) and (!ini_get("zlib.output_compression")) and (!$configs[10]))
        {
            ob_start("ob_gzhandler");
        }
    }

    if ((!$configs[11]) and ($ext == "."))
    {
        $statsfile = "cache/stats/stats-".date("m")."-".date("Y").".cgi";

        (!file_exists($statsfile)) ? $fd = fopen($statsfile, "w+") :
         $fd = fopen($statsfile, "r+");

        if (flock($fd, 2))
        {
            $mystats = fgets($fd, 100);
            if (!$mystats) {
                $mystats = 0;
            }
            $mystats++;
            rewind ($fd);
            fwrite ($fd, $mystats);
        }

        flock($fd, 3);
        fclose ($fd);
        @chmod ($statsfile, 0777);
    }

    if (file_exists("$ext/refererconfig.php"))
    {
        require("$ext/refererconfig.php");
    }

    if (($configs[17]) and ($ext == "."))
    {
        foreach ($reflist as $igreferer)
        {
            $igreferer = str_replace("/","\/",$igreferer);
            if (preg_match("/$igreferer/i", $referer))
            {
                $ireferer = 1;
            }
        }
        if (($referer) and (!$ireferer))
        {
            dbconnect();
            $query = DBQuery("SELECT * FROM esselbach_st_referer WHERE referer_ref = '$referer'");

            if (mysql_num_rows($query))
            {
                DBQuery("UPDATE esselbach_st_referer SET referer_hits=referer_hits+1, referer_date=now() WHERE referer_ref = '$referer'");
            }
            else
            {
                DBQuery("INSERT INTO esselbach_st_referer VALUES (NULL, '$configs[4]', '$referer', now(), '1')");
            }
        }
    }

    if (file_exists("$ext/spiderconfig.php"))
    {
        require("$ext/spiderconfig.php");
        (phpversion() >= "4.1.0") ? $agent = $_SERVER["HTTP_USER_AGENT"] : $agent = getenv("HTTP_USER_AGENT");
        foreach ($spiders as $spider)
        {
            if (preg_match("/$spider/i", $agent))
            {
                echo GetTemplate("$ext/spider");
                exit;
            }
        }
    }

    if (file_exists("bbwrapper.php")) include("bbwrapper.php");

    $eiv = "RXNzZWxiYWNoIFN0b3J5dGVsbGVyIDEuNS0z";

    (phpversion() >= "4.1.0") ? $logcookie = $_COOKIE[esselbachst] : $logcookie = $esselbachst;

    function dbconnect()
    {

        global $configs;

        @mysql_connect($configs[0], $configs[1], $configs[2]) or die ("Error: Can't connect to the MySQL server");
        @mysql_select_db($configs[3]) or die ("Error: Can't select the database");

    }

    function DBQuery ($var)
    {
        global $configs;

        if ($configs[9])
        {
            echo "Query: <b>$var</b><br />";
        }

        $query = mysql_query($var);

        if (!$query)
        {
            echo "Error: <b>".mysql_errno()." <i>".mysql_error()."</i></b>";
            exit;
        }

        return $query;

    }

    function GetTemplate($var)
    {

        if (file_exists("templates/$var.tmp.php"))
        {
            require("templates/$var.tmp.php");
        }
        else
        {
            die ("Error: Can't open template $var");
        }

        return $EST_TEMPLATE;

    }

    function GetCache($var, $var2)
    {
        if ($configs[18])
        {

            if (file_exists("cache/$var/$var2.cah.php"))
            {
                require("cache/$var/$var2.cah.php");
                $cache = 1;
            }
            else
            {
                $cache = 0;
            }

        }
        else
        {
            if (file_exists("cache/$var/$var2.cgi"))
            {
                $cachefile = fopen("cache/$var/$var2.cgi","r");
                $cachedata = fread($cachefile, filesize("cache/$var/$var2.cgi"));
                fclose($cachefile);

                $cachesplit = explode(":;:;:_CACHE_DATA_SPLIT_HERE_:;:;:",$cachedata);
                $cache_expire = $cachesplit[0];
                $cache_data = $cachesplit[1];
                $cache = 1;
            }
            else
            {
                $cache = 0;
            }
        }

        if ($cache_expire)
        {
            if ($cache_expire < mktime())
            {
                $cache = 0;
            }
        }

        if ($cache)
        {
            echo $cache_data;
        }

        return $cache;
    }

    function WriteCache ($var, $var2, $var3, $var4)
    {

        global $configs;

        if ($configs[8])
        {
            if ($configs[18])
            {
                $var3 = str_replace("$","\$",$var3);
                $cachefile = @fopen("cache/$var/$var2.cah.php", "w") or die ("Error: Can't write $var2 cache");
                       if (flock($cachefile, 2))
                       {
                    fputs ($cachefile, "<?php \$cache_expire = \"$var4\";\n\$cache_data = <<<CACHEDPAGEHTML\n$var3\nCACHEDPAGEHTML;\n?>");
                     }
                flock($cachefile, 3);
                fclose ($cachefile);
                @chmod ("cache/$var/$var2.cah.php", 0777);
            }
            else
            {
                $cachefile = @fopen("cache/$var/$var2.cgi", "w") or die ("Error: Can't write $var2 cache");
                       if (flock($cachefile, 2))
                       {
                    fputs ($cachefile, "$var4:;:;:_CACHE_DATA_SPLIT_HERE_:;:;:$var3");
                     }
                flock($cachefile, 3);
                fclose ($cachefile);
                @chmod ("cache/$var/$var2.cgi", 0777);
            }
        }
        echo $var3;
    }

    function MiniCache ($var, $var2)
    {

        global $configs;

        $var2 = str_replace("$","\$",$var2);
        if ($configs[8])
        {
            $cachefile = @fopen("$var.cah.php", "w") or die ("Error: Can't write cache");
            if (flock($cachefile, 2))
            {
                fputs ($cachefile, "$var2");
            }
            flock($cachefile, 3);
            fclose ($cachefile);
            @chmod ("$var.cah.php", 0777);
        }
    }

    function DeChomp ($var)
    {

        $var = stripslashes(str_replace("\n", "<br />", $var));

        return $var;
    }

    function ReChomp ($var)
    {

        $var = stripslashes(str_replace("<br />", "\n", $var));

        return $var;
    }

    function Icons ($var)
    {

        $var = str_replace(":)", "<img src=\"images/icons/icon_smile.png\" border=\"0\">", $var);
        $var = str_replace(";(", "<img src=\"images/icons/icon_mad.png\" border=\"0\">", $var);
        $var = str_replace(":(", "<img src=\"images/icons/icon_sad.png\" border=\"0\">", $var);
        $var = str_replace(";)", "<img src=\"images/icons/icon_wink.png\" border=\"0\">", $var);
        $var = str_replace(":p", "<img src=\"images/icons/icon_tongue.png\" border=\"0\">", $var);
        $var = str_replace(":o", "<img src=\"images/icons/icon_frown.png\" border=\"0\">", $var);
        $var = str_replace("x)", "<img src=\"images/icons/icon_sleep.png\" border=\"0\">", $var);
        $var = str_replace(":x", "<img src=\"images/icons/icon_ssad.png\" border=\"0\">", $var);
        $var = str_replace("8)", "<img src=\"images/icons/icon_cool.png\" border=\"0\">", $var);
        $var = str_replace(":D", "<img src=\"images/icons/icon_happy.png\" border=\"0\">", $var);

        return $var;

    }

    function Code ($var)
    {

        $var = eregi_replace("\\[img\\]([^\\[]*)\\[/img\\]", "<img src=\"\\1\" border=\"0\">", $var);
        $var = str_replace("[b]", "<b>", $var);
        $var = str_replace("[/b]", "</b>", $var);
        $var = str_replace("[i]", "<i>", $var);
        $var = str_replace("[/i]", "</i>", $var);
        $var = str_replace("[quote]", "<table border=\"1\" align=\"center\" bgcolor=\"#e5e5e5\" width=\"90%\" cellpadding=\"3\" cellspacing=\"1\"><tr><td><font color=\"#000080\">", $var);
        $var = str_replace("[/quote]", "</font></td></tr></table>", $var);
        $var = str_replace("[code]", "<table border=\"1\" align=\"center\" bgcolor=\"#e5e5e5\" width=\"90%\" cellpadding=\"3\" cellspacing=\"1\"><tr><td><tt>", $var);
        $var = str_replace("[/code]", "</tt></td></tr></table>", $var);
        $var = eregi_replace("\\[u\\]([^\\[]*)\\[/u\\]", "<u>\\1</u>", $var);
        $var = eregi_replace("\\[marquee\\]([^\\[]*)\\[/marquee\\]", "<marquee>\\1</marquee>", $var);
        $var = eregi_replace("\\[s\\]([^\\[]*)\\[/s\\]", "<s>\\1</s>", $var);
        $var = eregi_replace("\\[sup\\]([^\\[]*)\\[/sup\\]", "<sup>\\1</sup>", $var);
        $var = eregi_replace("\\[sub\\]([^\\[]*)\\[/sub\\]", "<sub>\\1</sub>", $var);
        $var = eregi_replace("\\[tt\\]([^\\[]*)\\[/tt\\]", "<tt>\\1</tt>", $var);
        $var = eregi_replace("\\[center\\]([^\\[]*)\\[/center\\]", "<center>\\1</center>", $var);
        $var = eregi_replace("\\[left\\]([^\\[]*)\\[/left\\]", "<p align=\"left\">\\1</p>", $var);
        $var = eregi_replace("\\[right\\]([^\\[]*)\\[/right\\]", "<p align=\"right\">\\1</p>", $var);
        $var = eregi_replace("\\[email\\]([^\\[]*)\\[/email\\]", "<a href=\"mailto:\\1\">\\1</a>", $var);
        $var = eregi_replace("\\[url\\]www.([^\\[]*)\\[/url\\]", "<a href=\"http://www.\\1\" target=\"_blank\">\\1</a>", $var);
        $var = eregi_replace("\\[url\\]([^\\[]*)\\[/url\\]", "<a href=\"\\1\" target=\"_blank\">\\1</a>", $var);
        $var = eregi_replace("\\[url=http://([^\\[]+)\\]([^\\[]*)\\[/url\\]", "<a href=\"http://\\1\" target=\"_blank\">\\2</a>", $var);
        $var = eregi_replace("\\[url=www.([^\\[]+)\\]([^\\[]*)\\[/url\\]", "<a href=\"http://www.\\1\" target=\"_blank\">\\2</a>", $var);
        $var = eregi_replace("\\[url=https://([^\\[]+)\\]([^\\[]*)\\[/url\\]", "<a href=\"https://\\1\" target=\"_blank\">\\2</a>", $var);
        $var = eregi_replace("\\[url=ftp://([^\\[]+)\\]([^\\[]*)\\[/url\\]", "<a href=\"ftp://\\1\">\\2</a>", $var);
        $var = eregi_replace("\\[url=ftp.([^\\[]+)\\]([^\\[]*)\\[/url\\]", "<a href=\"ftp://ftp.\\1\">\\2</a>", $var);
        $var = eregi_replace("\\[email=([^\\[]+)\\]([^\\[]*)\\[/email\\]", "<a href=\"mailto:\\1\">\\2</a>", $var);
        $var = eregi_replace("\\[size=([^\\[]+)\\]([^\\[]*)\\[/size\\]", "<font size=\"\\1\">\\2</font>", $var);
        $var = eregi_replace("\\[font=([^\\[]+)\\]([^\\[]*)\\[/font\\]", "<font face=\"\\1\">\\2</font>", $var);
        $var = eregi_replace("\\[color=([^\\[]+)\\]([^\\[]*)\\[/color\\]", "<font color=\"\\1\">\\2</font>", $var);

        return $var;

    }

    function ScriptEx ($var)
    {

        $var = preg_replace("/javascript/i", "java&nbsp;script&nbsp;", $var);
        $var = preg_replace("/vbscript/i", "vb&nbsp;script&nbsp;", $var);
        $var = preg_replace("/about:/i", "about&nbsp;:", $var);
        $var = preg_replace("/JavaScript/i", "Java&nbsp;Script&nbsp;", $var);
        $var = preg_replace("/VBScript/i", "vb&nbsp;script&nbsp;", $var);

        return $var;

    }

    function MakeXML ($var)
    {

        $var = eregi_replace("\\[([^\\[]*)\\]", "", $var);
        $var = htmlentities($var);
        $var = preg_replace("/&micro;/i", "u", $var);
        $var = preg_replace("/&uuml;/i", "ue", $var);
        $var = preg_replace("/&auml;/i", "ae", $var);
        $var = preg_replace("/&ouml;/i", "oe", $var);
        $var = preg_replace("/&szlig;/i", "ss", $var);
        $var = preg_replace("/&pound;/i", "POUND ", $var);
        $var = preg_replace("/&sup2;/i", "-2", $var);
        $var = preg_replace("/&sup3;/i", "-3", $var);
        $var = preg_replace("/&deg;/i", "o", $var);
        $var = preg_replace("/&reg;/i", "(R)", $var);
        $var = preg_replace("/&shy;/i", "", $var);
        $var = preg_replace("/&nbsp;/i", " ", $var);
        $var = preg_replace("/&euml;|&ecirc;|&egrave;|&eacute;/i", "e", $var);
        $var = preg_replace("/&acute;/i", "'", $var);

        return $var;

    }

    function GetDir ($var)
    {

        $dir = array();
        if (file_exists("$var"))
        {
            $od = opendir($var);
            while ($file = readdir($od))
            {
                array_push ($dir, "$file");
            }
            closedir ($od);
            sort($dir);
        }

        return $dir;
    }

    function ClearCache ($var)
    {

        global $ext;

        $cache_dir = GetDir("$ext/cache/$var");

        for($i = 1; $i < count($cache_dir); $i++)
        {
            if (preg_match("/(.cah.php)/i", $cache_dir[$i]))
            {
                unlink ("$ext/cache/$var/$cache_dir[$i]");
            }
            if (preg_match("/(.cgi)/i", $cache_dir[$i]))
            {
                unlink ("$ext/cache/$var/$cache_dir[$i]");
            }
        }

    }

    function ClearImageCache ($var)
    {

        global $ext;

        $cache_dir = GetDir("$ext/images/$var/thumbs");

        for($i = 1; $i < count($cache_dir); $i++)
        {
            if (preg_match("/(.gif|.jpg|.jpeg|.png)/i", $cache_dir[$i]))
            {
                unlink ("$ext/images/$var/thumbs/$cache_dir[$i]");
            }
        }

    }

    function RemoveCache ($var)
    {

        global $ext;

        if (file_exists("$ext/cache/$var.cah.php"))
        {
            unlink ("$ext/cache/$var.cah.php");
        }
        if (file_exists("$ext/cache/$var.cgi"))
        {
            unlink ("$ext/cache/$var.cgi");
        }

    }

    function DoKeywords ($var)
    {

        $words = explode(" ", eregi_replace("\\[([^\\[]*)\\]", "", $var));
        for($i = 0; $i < count($words); $i++)
        {
            if (strlen($words[$i]) > 6) $keywords[] = $words[$i];
        }
        sort($keywords);

        $linewords = 0;
        for ($i = 0; $i < count($keywords); $i++)
        {
            if ((!preg_match("/$keywords[$i]/", $returndata)) and (!preg_match("/^\W|,|\"|\.|\n|<|>|'|²|³|\/|!|\)|\(|:|;/i", $keywords[$i])))
            {
                if ($linewords < 60)
                {
                    $returndata .= $keywords[$i].", ";
                    $linewords++;
                }
            }
        }
        $returndata = substr($returndata, 0, -2);

        return $returndata;

    }

    function checknum ($var)
    {

        if ((preg_match("/[A-Z]/i", $var)) or (preg_match("/[|]/i", $var)))
        {
            die("Error.");
        }
        if (!get_magic_quotes_gpc())
        {
            $var = addslashes($var);
        }
        return $var;
    }

    function checkvar ($var)
    {

        if (preg_match("/[|]/i", $var))
        {
            die("Error.");
        }
        if (!get_magic_quotes_gpc())
        {
            $var = addslashes($var);
        }
        return $var;
    }

    function HeaderBlock ()
    {

        global $logcookie, $insert, $configs, $phps, $id, $det;

        if (preg_match("/story/", $phps))
        {
            if (file_exists("cache/tags/story-$id.cah.php"))
            {
                require("cache/tags/story-$id.cah.php");
            }
            else
            {
                dbconnect();
                $query = DBQuery("SELECT * FROM esselbach_st_stories WHERE story_id = '$id'");
                $data = mysql_fetch_array($query);
                $insert[page_title] = $data[story_title];
                $insert[page_keywords] = DoKeywords($data[story_text]);
                MiniCache("cache/tags/story-$id", "<?php \$insert[page_title] = \"$insert[page_title]\";\n\$insert[page_keywords] = \"$insert[page_keywords]\"; ?>");
            }
        }
        elseif ((preg_match("/download/", $phps)) and ($det))
        {
            if (file_exists("cache/tags/download-$det.cah.php"))
            {
                require("cache/tags/download-$det.cah.php");
            }
            else
            {
                dbconnect();
                $query = DBQuery("SELECT * FROM esselbach_st_downloads WHERE download_id = '$det'");
                $data = mysql_fetch_array($query);
                $insert[page_title] = $data[download_title];
                $insert[page_keywords] = DoKeywords($data[download_text]);
                MiniCache("cache/tags/download-$det", "<?php \$insert[page_title] = \"$insert[page_title]\";\n\$insert[page_keywords] = \"$insert[page_keywords]\"; ?>");
            }
        }
        elseif ((preg_match("/faqshow/", $phps)) and ($id))
        {
            if (file_exists("cache/tags/faq-$id.cah.php"))
            {
                require("cache/tags/faq-$id.cah.php");
            }
            else
            {
                dbconnect();
                $query = DBQuery("SELECT * FROM esselbach_st_faq WHERE faq_id = '$id'");
                $data = mysql_fetch_array($query);
                $insert[page_title] = $data[faq_question];
                $insert[page_keywords] = DoKeywords($data[faq_answertext]);
                MiniCache("cache/tags/faq-$id", "<?php \$insert[page_title] = \"$insert[page_title]\";\n\$insert[page_keywords] = \"$insert[page_keywords]\"; ?>");
            }
        }
        elseif ((preg_match("/review/", $phps)) and ($id))
        {
            if (file_exists("cache/tags/review-$id.cah.php"))
            {
                require("cache/tags/review-$id.cah.php");
            }
            else
            {
                dbconnect();
                $query = DBQuery("SELECT * FROM esselbach_st_review WHERE review_id = '$id'");
                $data = mysql_fetch_array($query);
                $insert[page_title] = $data[review_title];
                $insert[page_keywords] = DoKeywords($data[review_text]);
                MiniCache("cache/tags/review-$id", "<?php \$insert[page_title] = \"$insert[page_title]\";\n\$insert[page_keywords] = \"$insert[page_keywords]\"; ?>");
            }
        }
        else
        {
            if (file_exists("cache/tags/default.cah.php"))
            {
                require("cache/tags/default.cah.php");
            }
            else
            {
                dbconnect();
                $query = DBQuery("SELECT * FROM esselbach_st_websites WHERE website_id = '$configs[4]'");
                $data = mysql_fetch_array($query);
                $insert[page_title] = $data[website_dtitle];
                $insert[page_keywords] = $data[website_dkeywords];
                MiniCache("cache/tags/default", "<?php \$insert[page_title] = \"$insert[page_title]\";\n\$insert[page_keywords] = \"$insert[page_keywords]\"; ?>");
            }
        }

        $website = $configs[4];
        $insert[site_name] = $configs[5];
        $insert[site_url] = $configs[6];
        echo GetTemplate("site_header");

        if ($logcookie)
        {
            $ldata = base64_decode($logcookie);
            $ldata = explode (":!:", $ldata);
            $insert[login_name] = $ldata[0];
            echo GetTemplate("login_header_user");
        }
        else
        {
            echo GetTemplate("login_header_anon");
        }

        $cache = GetCache("news", "header_block");

        if (!$cache)
        {

            dbconnect();

            $result = DBQuery("SELECT * FROM esselbach_st_websites WHERE website_id = '$website'");
            $blocks = mysql_fetch_array($result);

            if ($blocks[website_blockrow1])
            {

                ($blocks[website_blockmode1] == 3) ? $blockline = 4 :
                 $blockline = 3;

                for($a = 1; $a < $blockline; $a++)
                {
                    if ($a == 1)
                    {
                        $var = $blocks[website_block11];
                        $var2 = $blocks[website_blocktitle11];
                        $var3 = $blocks[website_blockfile11];
                    }
                    if ($a == 2)
                    {
                        $var = $blocks[website_block12];
                        $var2 = $blocks[website_blocktitle12];
                        $var3 = $blocks[website_blockfile12];
                    }
                    if (($a == 3) and ($blocks[website_blockmode1] == 3))
                    {
                        $var = $blocks[website_block13];
                        $var2 = $blocks[website_blocktitle13];
                        $var3 = $blocks[website_blockfile13];
                    }

                    $insert[website_blocktitle] = $var2;
                    if ($a == 1)
                    {
                        ($blocks[website_blockmode1] == 3) ? $thisblock .= GetTemplate("main_block_header") :
                         $thisblock .= GetTemplate("main_block_buttom");
                    }
                    else
                    {
                        ($blocks[website_blockmode1] == 3) ? $thisblock .= GetTemplate("main_block_middle") :
                         $thisblock .= GetTemplate("main_block_buttom_middle");
                    }

                    if ($blocks[website_blockmode1] == 3)
                    {
                        $thisblock .= GetBlock($var, $var2, $var3, 35, 32, $website);
                    }
                    else
                    {
                        $thisblock .= GetBlock($var, $var2, $var3, 52, 49, $website);
                    }

                }
                $thisblock .= GetTemplate("main_block_footer");
            }

            if ($blocks[website_blockrow4])
            {

                ($blocks[website_blockmode4] == 3) ? $blockline = 4 :
                 $blockline = 3;

                for($a = 1; $a < $blockline; $a++)
                {
                    if ($a == 1)
                    {
                        $var = $blocks[website_block41];
                        $var2 = $blocks[website_blocktitle41];
                        $var3 = $blocks[website_blockfile41];
                    }
                    if ($a == 2)
                    {
                        $var = $blocks[website_block42];
                        $var2 = $blocks[website_blocktitle42];
                        $var3 = $blocks[website_blockfile42];
                    }
                    if (($a == 3) and ($blocks[website_blockmode4] == 3))
                    {
                        $var = $blocks[website_block43];
                        $var2 = $blocks[website_blocktitle43];
                        $var3 = $blocks[website_blockfile43];
                    }

                    $insert[website_blocktitle] = $var2;
                    if ($a == 1)
                    {
                        ($blocks[website_blockmode4] == 3) ? $thisblock .= GetTemplate("main_block_header") :
                         $thisblock .= GetTemplate("main_block_buttom");
                    }
                    else
                    {
                        ($blocks[website_blockmode4] == 3) ? $thisblock .= GetTemplate("main_block_middle") :
                         $thisblock .= GetTemplate("main_block_buttom_middle");
                    }

                    if ($blocks[website_blockmode4] == 3)
                    {
                        $thisblock .= GetBlock($var, $var2, $var3, 35, 32, $website);
                    }
                    else
                    {
                        $thisblock .= GetBlock($var, $var2, $var3, 52, 49, $website);
                    }

                }
                $thisblock .= GetTemplate("main_block_footer");
            }

            WriteCache("news", "header_block", $thisblock, MkTime()+3600);


        }
    }

    function FooterBlock ()
    {

        global $insert, $configs;
        $cache = GetCache("news", "footer_block");

        if (!$cache)
        {

            $website = $configs[4];

            dbconnect();

            $result = DBQuery("SELECT * FROM esselbach_st_websites WHERE website_id = '$website'");
            $blocks = mysql_fetch_array($result);

            if ($blocks[website_blockrow2])
            {

                ($blocks[website_blockmode2] == 3) ? $blockline = 4 :
                 $blockline = 3;

                for($a = 1; $a < $blockline; $a++)
                {
                    if ($a == 1)
                    {
                        $var = $blocks[website_block21];
                        $var2 = $blocks[website_blocktitle21];
                        $var3 = $blocks[website_blockfile21];
                    }
                    if ($a == 2)
                    {
                        $var = $blocks[website_block22];
                        $var2 = $blocks[website_blocktitle22];
                        $var3 = $blocks[website_blockfile22];
                    }
                    if (($a == 3) and ($blocks[website_blockmode3] == 3))
                    {
                        $var = $blocks[website_block23];
                        $var2 = $blocks[website_blocktitle23];
                        $var3 = $blocks[website_blockfile23];
                    }


                    $insert[website_blocktitle] = $var2;
                    if ($a == 1)
                    {
                        ($blocks[website_blockmode2] == 3) ? $thisblock .= GetTemplate("main_block_header") :
                         $thisblock .= GetTemplate("main_block_buttom");
                    }
                    else
                    {
                        ($blocks[website_blockmode2] == 3) ? $thisblock .= GetTemplate("main_block_middle") :
                         $thisblock .= GetTemplate("main_block_buttom_middle");
                    }

                    if ($blocks[website_blockmode2] == 3)
                    {
                        $thisblock .= GetBlock($var, $var2, $var3, 35, 32, $website);
                    }
                    else
                    {
                        $thisblock .= GetBlock($var, $var2, $var3, 52, 49, $website);
                    }

                }
                $thisblock .= GetTemplate("main_block_footer");
            }

            if ($blocks[website_blockrow3])
            {

                ($blocks[website_blockmode3] == 3) ? $blockline = 4 :
                 $blockline = 3;

                for($a = 1; $a < $blockline; $a++)
                {
                    if ($a == 1)
                    {
                        $var = $blocks[website_block31];
                        $var2 = $blocks[website_blocktitle31];
                        $var3 = $blocks[website_blockfile31];
                    }
                    if ($a == 2)
                    {
                        $var = $blocks[website_block32];
                        $var2 = $blocks[website_blocktitle32];
                        $var3 = $blocks[website_blockfile32];
                    }
                    if (($a == 3) and ($blocks[website_blockmode3] == 3))
                    {
                        $var = $blocks[website_block23];
                        $var2 = $blocks[website_blocktitle23];
                        $var3 = $blocks[website_blockfile23];
                    }

                    $insert[website_blocktitle] = $var2;
                    if ($a == 1)
                    {
                        ($blocks[website_blockmode3] == 3) ? $thisblock .= GetTemplate("main_block_header") :
                         $thisblock .= GetTemplate("main_block_buttom");
                    }
                    else
                    {
                        ($blocks[website_blockmode3] == 3) ? $thisblock .= GetTemplate("main_block_middle") :
                         $thisblock .= GetTemplate("main_block_buttom_middle");
                    }

                    if ($blocks[website_blockmode3] == 3)
                    {
                        $thisblock .= GetBlock($var, $var2, $var3, 35, 32, $website);
                    }
                    else
                    {
                        $thisblock .= GetBlock($var, $var2, $var3, 52, 49, $website);
                    }

                }
                $thisblock .= GetTemplate("main_block_footer");
            }

            WriteCache("news", "footer_block", $thisblock, MkTime()+3600);
        }

        $insert[site_name] = $configs[5];
        $insert[site_url] = $configs[6];

        if ($configs[14])
        {
            $insert[powered_by] = "";
            if ($configs[16])
            {
                $insert[powered_by] .= base64_decode("PGNlbnRlcj5Db3B5cmlnaHQgJmNvcHk7").$configs[16].base64_decode("PC9jZW50ZXI+");
            }
            $insert[powered_by] .= base64_decode("PGNlbnRlcj5Qb3dlcmVkIGJ5IDxhIGhyZWY9Imh0dHA6Ly93d3cuZXNzZWxiYWNoLmNvbSIgdGFyZ2V0PSJfYmxhbmsiPkVzc2VsYmFjaCBTdG9yeXRlbGxlciBDTVMgU3lzdGVtPC9hPiBWZXJzaW9uIDEuNSBQcm88L2NlbnRlcj4=");

            if ($configs[15])
            {
                $insert[powered_by] .= base64_decode("PGNlbnRlcj5MaWNlbnNlZCB0bzog").$configs[15].base64_decode("PC9jZW50ZXI+");
            }
        }
        else
        {
            $insert[powered_by] = base64_decode("PGNlbnRlcj48YSBocmVmPSJodHRwOi8vd3d3LmVzc2VsYmFjaC5jb20iIHRpdGxlPSJUaGlzIHdlYnNpdGUgaXMgcG93ZXJlZCBieSBFc3NlbGJhY2ggU3Rvcnl0ZWxsZXIgQ01TIFN5c3RlbSBWZXJzaW9uIDEuNSBQcm8iIHRhcmdldD0iX2JsYW5rIj48aW1nIHNyYz0iaW1hZ2VzL3Bvd2VyZWRieS5wbmciPjwvYT48L2NlbnRlcj4=");
        }

        echo GetTemplate("site_footer");
        exit;

    }

    function GetBlock($var, $var2, $var3, $var4, $var5, $website)
    {

        global $insert;

        ($var) ? $cat = "story_category = '$var' AND" :
         $cat = "";

        if ($var == 100)
        {
            if (file_exists("blocks/$var3"))
            {
                $blockdata = file("blocks/$var3");
                for($z = 0; $z < count($blockdata); $z++)
                {
                    $insert[story_blockline] = $blockdata[$z];
                    $thisblock .= GetTemplate("main_block_file");
                }
            }
        }
        elseif ($var == 110)
        {
            $result = DBQuery("SELECT * FROM esselbach_st_faq WHERE faq_website = '$website' OR faq_website = '0' ORDER BY faq_id DESC LIMIT 10");
            while ($insert = mysql_fetch_array($result))
            {
                (strlen($insert[faq_question]) > $var4) ? $insert[story_title] = substr($insert[faq_question], 0, $var5)."..." :
                 $insert[story_title] = $insert[faq_question];
                $insert[story_url] = "faq.php?id=$insert[faq_id]";
                $thisblock .= GetTemplate("main_block_list");
            }
        }
        elseif ($var == 120)
        {
            $result = DBQuery("SELECT * FROM esselbach_st_review WHERE review_website = '$website' AND review_hook = '0' AND review_page = '1' OR review_website = '0' AND review_hook = '0' AND review_page = '1' ORDER BY review_id DESC LIMIT 10");
            while ($insert = mysql_fetch_array($result))
            {
                (strlen($insert[review_title]) > $var4) ? $insert[story_title] = substr($insert[review_title], 0, $var5)."..." :
                 $insert[story_title] = $insert[review_title];
                $insert[story_url] = "review.php?id=$insert[review_id]";
                $thisblock .= GetTemplate("main_block_list");
            }
        }
        elseif ($var == 130)
        {
            $result = DBQuery("SELECT * FROM esselbach_st_downloads WHERE download_website = '$website' AND download_hook = '0' OR download_website = '0' AND download_hook = '0' ORDER BY download_id DESC LIMIT 10");
            while ($insert = mysql_fetch_array($result))
            {
                (strlen($insert[download_title]) > $var4) ? $insert[story_title] = substr($insert[download_title], 0, $var5)."..." :
                 $insert[story_title] = $insert[download_title];
                $insert[story_url] = "download.php?det=$insert[download_id]";
                $thisblock .= GetTemplate("main_block_list");
            }
        }
        elseif ($var == 131)
        {
            $result = DBQuery("SELECT * FROM esselbach_st_downloads WHERE download_website = '$website' AND download_hook = '0' OR download_website = '0' AND download_hook = '0' ORDER BY download_count DESC LIMIT 10");
            while ($insert = mysql_fetch_array($result))
            {
                (strlen($insert[download_title]) > $var4) ? $insert[story_title] = substr($insert[download_title], 0, $var5)."..." :
                 $insert[story_title] = $insert[download_title];
                $insert[story_url] = "download.php?det=$insert[download_id]";
                $thisblock .= GetTemplate("main_block_list");
            }
        }
        elseif ($var == 140)
        {
            $result = DBQuery("SELECT * FROM esselbach_st_plans p, esselbach_st_users u WHERE u.user_name = p.plan_user AND plan_website = '$website' OR u.user_name = p.plan_user AND plan_website = '0' ORDER BY plan_id DESC LIMIT 10");
            while ($insert = mysql_fetch_array($result))
            {
                $insert[plan_user] = $insert[plan_user]." (".$insert[plan_time].")";
                (strlen($insert[plan_user]) > $var4) ? $insert[story_title] = substr($insert[plan_user], 0, $var5)."..." :
                 $insert[story_title] = $insert[plan_user];
                $insert[story_url] = "plan.php?det=$insert[plan_id]";
                $thisblock .= GetTemplate("main_block_list");
            }
        }
        elseif ($var == 200)
        {
            if (file_exists("bbwrapper.php"))
            {
                $bbdata = BBGetTopics();
                for($t = 0; $t < count($bbdata); $t++)
                {
                    $datasplit = explode("||~||", $bbdata[$t]);
                    (strlen($datasplit[1]) > $var4) ? $insert[story_title] = substr($datasplit[1], 0, $var5)."..." :
                     $insert[story_title] = $datasplit[1];
                    $insert[story_url] = $datasplit[0];
                    $thisblock .= GetTemplate("main_block_list");
                }
                dbconnect();
            }
        }
        else
        {
            $result = DBQuery("SELECT * FROM esselbach_st_stories WHERE $cat story_website = '$website' AND story_hook = '0' OR $cat story_website = '0' AND story_hook = '0' ORDER BY story_id DESC LIMIT 10");
            while ($insert = mysql_fetch_array($result))
            {

                if (strlen($insert[story_title]) > $var4) $insert[story_title] = substr($insert[story_title], 0, $var5)."...";
                $insert[story_url] = "story.php?id=$insert[story_id]";
                $thisblock .= GetTemplate("main_block_list");
            }
        }

        return $thisblock;

    }

    function GetIP()
    {

        if (phpversion() >= "4.1.0")
        {
            ($_SERVER["HTTP_X_FORWARDED_FOR"]) ? $var = $_SERVER["HTTP_X_FORWARDED_FOR"] :
             $var = $_SERVER["REMOTE_ADDR"];
        }
        else
        {
            (getenv("HTTP_X_FORWARDED_FOR")) ? $var = getenv("HTTP_X_FORWARDED_FOR") :
             $var = getenv("REMOTE_ADDR");
        }

        return $var;
    }

    function CryptMe($var)
    {

        if (phpversion() >= "4.3.0")
        {
            $var = sha1($var);
        }
        else
        {
            $var = md5($var);
        }

        return $var;
    }

    function GetLoad()
    {

        $buffer = "0 0 0";

        if (file_exists("/proc/loadavg"))
        {
            $f = fopen("/proc/loadavg","r");

            if (!feof($f))
            {
                $buffer = fgets($f, 1024);
            }

           fclose($f);
           $load = explode(" ",$buffer);

        }

        return $load;
    }

    function GetCPUInfo()
    {

        $cpus = 0;
        $processor = "Unknown processor";

        if (file_exists("/proc/cpuinfo"))
        {
            $cpu = file("/proc/cpuinfo");

            foreach ($cpu as $line)
            {
                if (preg_match("/processor/i", $line))
                {
                    $cpus++;
                }
                if (preg_match("/model name/i", $line))
                {
                    $procline = explode(":",$line);
                    $processor = $procline[1];
                }
            }
        }

        $cpuinfo = "$cpus|$processor";
        return $cpuinfo;
    }

    function MailHeader($var, $var2, $var3, $var4)
    {

        $headers = "From: ".$var." <".$var2.">\r \n";
        $headers .= "To: ".$var3." <".$var4.">\r \n";
        $headers .= "Reply-To: ".$var." <$var2>\r \n";
        $headers .= "MIME-Version: 1.0\n";
        $headers .= "Content-type: text/plain; charset=windows-1251\n";
        $headers .= "X-Priority: 1\n";
        $headers .= "X-MSMail-Priority: High\n";
        $headers .= "X-Mailer: Esselbach Storyteller CMS";

        return $headers;
    }

?>
