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
        $name = $_POST["name"];
        $comments = $_POST["comments"];
        $title = $_POST["title"];
        $file = $_GET["file"];
    }

    $name = checkvar($name);
    $comments = checkvar($comments);
    $file = checknum($file);

    $ipaddr = GetIP();
    $website = $configs[4];

    HeaderBlock();

    if ((!$comments) or (!$name) or (!$title))
    {
        dbconnect();
        $query = DBQuery("SELECT download_title FROM esselbach_st_downloads WHERE download_id = '$file'");
        list ($download_title) = mysql_fetch_row($query);

        $insert[broken_file] = $download_title;
        echo GetTemplate("download_brokenlink");
    }
    else
    {
        dbconnect();
        DBQuery("INSERT INTO esselbach_st_brokenlinks VALUES (NULL, '$website', '$name', '$title', '$comments', '$ipaddr')");
        echo GetTemplate("download_brokenlink_done");
    }

    FooterBlock();

?>
