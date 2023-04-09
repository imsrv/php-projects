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
        $lcookie = $_COOKIE["esselbachst"];
        $id = $_GET["id"];
        $file = $_GET["file"];
        $evp = $_GET["evp"];
        $referer = $_SERVER["HTTP_REFERER"];
    }
    else
    {
        $lcookie = $esselbachst;
        $referer = getenv("HTTP_REFERER");
    }

    $id = checknum($id);
    $file = checknum($file);
    $evp = checkvar($evp);
    $referer = checkvar($referer);
    $website = $configs[4];
    $downloadkey = $configs[7];
    $ipaddr = GetIP();

    if ($lcookie)
    {
        $ldata = base64_decode($lcookie);
        $ldata = explode (":!:", $ldata);
    }

    if ($evp)
    {

        $redirect = md5($downloadkey.date("HhY", mktime()));
        $getlink = md5($downloadkey."GeT-$id");

        if ($evp == $redirect)
        {
            dbconnect();

            $result = DBQuery("SELECT * FROM esselbach_st_downloads WHERE download_id = '$id' AND download_website = '$website' OR download_id = '$id' AND download_website = '0'");

            if (!$result)
            {
                echo GetTemplate("download_na");
            }
            else
            {
                $insert = mysql_fetch_array($result);

                if ($insert[download_sub])
                {
                    if ($lcookie)
                    {
                        $ldata = base64_decode($lcookie);
                        $ldata = explode (":!:", $ldata);

                        if (!file_exists("bbwrapper.php"))
                        {
                            dbconnect();

                            $query = DBQuery("SELECT * FROM esselbach_st_users WHERE user_name = '$ldata[0]'");
                            $userd = mysql_fetch_array($query);
                        }
                    }

                    if (!file_exists("bbwrapper.php"))
                    {
                        if (($ldata[1] != $userd[user_password]) or (!$lcookie))
                        {
                            echo GetTemplate("download_error_notlogged");
                            FooterBlock();
                            exit;
                        }
                    }
                    else
                    {
                        if ((!BBGetUser($ldata[0], $ldata[1])) or (!$lcookie))
                        {
                            echo GetTemplate("download_error_notlogged");
                            FooterBlock();
                            exit;
                        }
                        dbconnect();
                    }

                    $query = DBQuery("SELECT * FROM esselbach_st_subscribers WHERE sub_user = '$ldata[0]' AND sub_file = '$id' OR sub_user = '$ldata[0]' AND sub_file = '0'");

                    if (!mysql_num_rows($query))
                    {
                        echo GetTemplate("download_error_subscribersonly");
                        FooterBlock();
                        echo GetTemplate("footer");
                        exit;
                    }

                    $subinfo = mysql_fetch_array($query);
                    $ddate = explode("-", $subinfo[sub_expire]);
                    $uedate = mktime (0, 0, 0, $ddate[2], $ddate[1], $ddate[0]);
                    $udate = time();

                    if ($udate > $uedate)
                    {
                        echo GetTemplate("download_error_subscribersonly");
                        FooterBlock();
                        echo GetTemplate("footer");
                        exit;
                    }

                }

                $location = $insert['download_url'.$file];

                if (!preg_match("/al:/i",$location))
                {
                    header ("Location: $location");
                }
                else
                {
                    $query = DBQuery("SELECT website_leech FROM esselbach_st_websites WHERE website_id = '$website'");
                    list($leechdir) = mysql_fetch_row($query);

                    $fileloc = explode(":",$location);

                    ParseFile ("$leechdir/$fileloc[1]","$fileloc[1]");
                }


            }

            exit;
        }

        if ($evp == $getlink)
        {

            if ((phpversion() >= "4.0.5") and (extension_loaded("zlib")) and (!ini_get("output_handler")) and (!ini_get("zlib.output_compression")) and (!$configs[10])) ob_start("ob_gzhandler");
                dbconnect();

            HeaderBlock($website);

            $result = DBQuery("SELECT * FROM esselbach_st_downloads WHERE download_id = '$id' AND download_website = '$website' OR download_id = '$id' AND download_website = '0'");

            if (!$result)
            {
                echo GetTemplate("download_na");
            }
            else
            {
                $insert = mysql_fetch_array($result);

                if ($insert[download_sub])
                {
                    if ($lcookie)
                    {
                        $ldata = base64_decode($lcookie);
                        $ldata = explode (":!:", $ldata);

                        $query = DBQuery("SELECT * FROM esselbach_st_users WHERE user_name = '$ldata[0]'");
                        $userd = mysql_fetch_array($query);
                    }

                    if (($ldata[1] != $userd[user_password]) or (!$lcookie))
                    {
                        echo GetTemplate("download_error_notlogged");
                        FooterBlock();
                        exit;
                    }

                    $query = DBQuery("SELECT * FROM esselbach_st_subscribers WHERE sub_user = '$ldata[0]' AND sub_file = '$id' OR sub_file = '0'");

                    if (!mysql_num_rows($query))
                    {
                        echo GetTemplate("download_error_subscribersonly");
                        FooterBlock();
                        exit;
                    }

                    $subinfo = mysql_fetch_array($query);
                    $ddate = explode("-", $subinfo[sub_expire]);
                    $uedate = mktime (0, 0, 0, $ddate[2], $ddate[1], $ddate[0]);
                    $udate = time();

                    if ($udate > $uedate)
                    {
                        echo GetTemplate("download_error_subscribersonly");
                        FooterBlock();
                        exit;
                    }

                }

                if (!$insert[download_html])
                {
                    $insert[download_text] = DeChomp($insert[download_text]);
                }
                if ($insert[download_icon])
                {
                    $insert[download_text] = Icons($insert[download_text]);
                }
                if ($insert[download_code])
                {
                    $insert[download_text] = Code($insert[download_text]);
                }
                $insert[download_text] = eregi_replace("\\[thumb\\]([^\\[]*)\\[/thumb\\]", "<a href=\"javascript:FullWin('thumb.php?img=\\1&action=full&section=downloads')\"><img src=\"thumb.php?img=\\1&section=downloads\" border=\"0\"></a>", $insert[download_text]);

                if (!$insert[download_html])
                {
                    $insert[download_extendedtext] = DeChomp($insert[download_extendedtext]);
                }
                if ($insert[download_icon])
                {
                    $insert[download_extendedtext] = Icons($insert[download_extendedtext]);
                }
                if ($insert[download_code])
                {
                    $insert[download_extendedtext] = Code($insert[download_extendedtext]);
                }
                $insert[download_extendedtext] = eregi_replace("\\[thumb\\]([^\\[]*)\\[/thumb\\]", "<a href=\"javascript:FullWin('thumb.php?img=\\1&action=full&section=downloads')\"><img src=\"thumb.php?img=\\1&section=downloads\" border=\"0\"></a>", $insert[download_extendedtext]);

                $insert[download_timestamp] = md5($downloadkey.date("HhY", mktime()));
                $insert[download_location] = "downloadget.php?id=$insert[download_id]&file=$file&evp=$insert[download_timestamp]";

                echo GetTemplate("download_get");
                DBQuery("UPDATE esselbach_st_downloads SET download_count=download_count+1 WHERE download_id = '$id'");

                FooterBlock();

            }

        }

        if (($evp != $getlink) or ($evp != $redirect))
        {
            if ($referer)
            {
                $igreferer = str_replace("/","\/",$configs[6]);
                if (!preg_match("/$igreferer/i",$referer))
                {
                    dbconnect();
                    $query = DBQuery("SELECT * FROM esselbach_st_leechattempts WHERE leech_ref = '$referer'");

                    if (mysql_num_rows($query))
                    {
                        DBQuery("UPDATE esselbach_st_leechattempts SET leech_attempts=leech_attempts+1 WHERE leech_ref = '$referer'");
                    }
                    else
                    {
                        DBQuery("INSERT INTO esselbach_st_leechattempts VALUES (NULL, '$website', '$id', '$file', '$ipaddr', '$referer', '1')");
                    }
                }

            }

            HeaderBlock();
            echo GetTemplate("download_expired");
            FooterBlock();
        }

    }
    else
    {

        header ("Location: $siteurl");
    }

    function ParseFile ($var, $var2)
    {

        if (is_readable($var))
        {
            $fp = fopen($var, "r");
            $thisfile = fread($fp, filesize($var));
            fclose($fp);

            header("Content-disposition: filename=$var2");
            header("Content-Length: ".filesize($var));
            header("Content-type: unknown/unknown");

            echo $thisfile;
        }

    }

?>
