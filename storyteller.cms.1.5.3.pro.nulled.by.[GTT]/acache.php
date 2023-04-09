<?php

    /*
    ########################
    # |//////////////////| #
    # NULLED by [GTT] =)   #
    # |\\\\\\\\\\\\\\\\\\| #
    ########################
    */

    require("core.php");
    require("cadmin/mod_words.php");

    if (phpversion() >= "4.1.0") $id = $_GET["id"];

    $id = checkvar($id);

    $key = substr($pw, 0, 8);

    if ($id == md5($key."news"))
    {
        ClearCache("news");
        ClearCache("categories");
        ClearCache("archive");
        ClearCache("story");
        ClearCache("xml");
        ClearCache("tags");
        ClearImageCache("news");
    }
    if ($id == md5($key."faq"))
    {
        ClearCache("faq");
        ClearCache("xml");
        ClearCache("tags");
        ClearImageCache("faq");
    }
    if ($id == md5($key."review"))
    {
        ClearCache("reviews");
        ClearCache("xml");
        ClearCache("tags");
        ClearImageCache("review");
    }
    if ($id == md5($key."page"))
    {
        ClearCache("pages");
    }
    if ($id == md5($key."glossary"))
    {
        ClearCache("glossary");
    }
    if ($id == md5($key."download"))
    {
        ClearCache("download");
        ClearCache("downloaddet");
        ClearCache("xml");
        ClearCache("tags");
        ClearImageCache("downloads");
    }
    if ($id == md5($key."link"))
    {
        ClearCache("links");
    }
    if ($id == md5($key."plans"))
    {
        ClearCache("plans");
    }

    MkHeader("_self");
    MkTabHeader ("$words[DO]");
    echo $words[CC];
    MkTabFooter();
    MkFooter();

    //  ##########################################################

    function MkHeader($var)
    {

        echo <<<Header
<html>

<head>
<title>Esselbach Storyteller CMS</title>
<base target="$var" />
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

//  ##########################################################

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

?>
