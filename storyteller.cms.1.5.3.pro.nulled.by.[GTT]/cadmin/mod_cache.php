<?php

    /*
    ########################
    # |//////////////////| #
    # NULLED by [GTT] =)   #
    # |\\\\\\\\\\\\\\\\\\| #
    ########################
    */

    function AdminCache($opts)
    {

        global $words, $pw;

        $options = explode("-", $opts);

        if ($options[1] == "deletecache")
        {

            $result = DBQuery("SELECT website_url FROM esselbach_st_websites WHERE website_id = '$options[0]'");
            list($url) = mysql_fetch_row($result);
            $key = substr($pw, 0, 8);
            $fkey = md5($key.$options[2]);
            $turl = $url."/acache.php?id=$fkey";

            header ("Location: $turl");
            exit;
        }

        MkHeader("_self");
        MkTabHeader("$words[CN]");
        echo "$words[SELC] $opts $words[SELD]";
        MkTabFooter();

        TblHeader("$words[WID]", "$words[WNA]");

        $result = DBQuery("SELECT website_id, website_name FROM esselbach_st_websites ORDER BY website_id");

        while (list($website_id, $website_title) = mysql_fetch_row($result))
        {
            ($bgcolor == "#ffffff") ? $bgcolor = "#eeeeee" :
             $bgcolor = "#ffffff";

            echo <<<Middle
        <tr bgcolor="$bgcolor">
        <td align="left" width="15%">
              <font size="2" color="#000000" face="Verdana, Arial">
                $website_id
                </font>
        </td>
        <td align="left" width="75%">
            <font size="2" color="#000000" face="Verdana, Arial">
                $website_title
                </font>
        </td>
      <td align="center" width="10%">
                <font size="2" color="#000000" face="Verdana, Arial">
            <a href="index.php?action=clearcache&opts=$website_id-deletecache-$opts"><img src="../images/delete.png" border="0"></a>
            </font>
      </td>
</tr>
Middle;
}
        TblFooter();
}

?>
