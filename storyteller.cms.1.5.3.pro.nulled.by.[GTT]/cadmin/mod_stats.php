<?php

    /*
    ########################
    # |//////////////////| #
    # NULLED by [GTT] =)   #
    # |\\\\\\\\\\\\\\\\\\| #
    ########################
    */

    function AdminStats()
    {

        global $words;

        MkHeader("_self");

        echo "
            <table border=\"0\" cellpadding=\"1\" cellspacing=\"1\" width=\"100%\">
            <tr bgcolor=\"#003399\">
            <td>
            <table border=\"0\" cellpadding=\"4\" cellspacing=\"0\" width=\"100%\">
            <tr bgcolor=\"#003399\">
            <td align=\"left\" width=\"33%\">
            <font size=\"2\" color=\"#FFFFFF\" face=\"Verdana, Arial\"><b>$words[MOY]</b></font>
            </td>
            <td align=\"center\" width=\"33%\">
            <font size=\"2\" color=\"#FFFFFF\" face=\"Verdana, Arial\"><b>$words[PAY]</b></font>
            </td>
            <td align=\"center\" width=\"33%\">
            <font size=\"2\" color=\"#FFFFFF\" face=\"Verdana, Arial\"><b>$words[AAY]</b></font>
            </td>
            </tr>";

        $sd = opendir("../cache/stats");
        while ($file = readdir($sd))
        {
            if (preg_match("/stats/i", $file))
            {
                if (file_exists("../cache/stats/$file"))
                {
                    $tdate = explode("-", $file);
                    $ydate = explode(".", $tdate[2]);
                    $fd = fopen("../cache/stats/$file", "r");
                    if (flock($fd, 2))
                    {
                        $mystats = fgets($fd, 100);
                        $daystats = $mystats/date("j");
                    }
                    flock($fd, 3);
                    fclose($fd);

                    if (preg_match("/./", $daystats))
                    {
                        $daystat = explode(".", $daystats);
                        $daystats = $daystat[0];
                    }

                    ($bgcolor == "#ffffff") ? $bgcolor = "#eeeeee" :
                     $bgcolor = "#ffffff";

                    echo "<tr bgcolor=\"$bgcolor\">
                        <td align=\"left\" width=\"33%\">
                        <font size=\"2\" color=\"#000000\" face=\"Verdana, Arial\">
                        $tdate[1]/$ydate[0]
                        </font>
                        </td>
                        <td align=\"center\" width=\"33%\">
                        <font size=\"2\" color=\"#000000\" face=\"Verdana, Arial\">
                        $mystats
                        </font>
                        </td>
                        <td align=\"center\" width=\"33%\">
                        <font size=\"2\" color=\"#000000\" face=\"Verdana, Arial\">
                        $daystats
                        </font>
                        </td>
                        </tr>";
                }
            }
        }
        closedir ($sd);

        MkFooter();

    }

    //  ##########################################################

    function AdminStatsConf ($opts)
    {

        global $reflist, $words;

        $options = explode("-", $opts);
        if ($options[0] == "deletereferer")
        {

            $file = fopen("../refererconfig.php", w) or die ("$words[REWRI]");
            if (flock($file, 2))
            {
                fputs ($file, "<?php\n\n\$reflist = array(\n\n");
                for($i = 0; $i < count($reflist); $i++)
                {
                    if ($i != $options[1])
                    {
                        fputs($file, "'$reflist[$i]',\n");
                    }
                }
                fputs ($file, "\n);\n\n?>");
            }
            flock($file, 3);
            fclose ($file);

            MkHeader("_self");
            MkTabHeader ("$words[DO]");
            echo "$words[REFDL]";
            MkTabFooter();
            MkFooter();

        }

        if ($options[0] == "editreferer")
        {
            $ref_num1 = $options[1]+1;
            $ref_num2 = $options[1];

            MkHeader("_self");
            MkTabHeader("$words[REFED] $ref_num1");

            echo "<table><form action=\"index.php\" method=\"post\">";

            MkOption ("$words[SIG]", "", "newstitle", "$reflist[$ref_num2]");

            echo "<input type=\"hidden\" name=\"aform\" value=\"editreferer\"><input type=\"hidden\" name=\"zid\" value=\"$options[1]\"><td><font face=\"Arial\" size=\"2\"><input type=\"submit\" value=\"$words[SND]\"></font></td></tr></table>";
            MkTabFooter();
            MkFooter();
        }

        MkHeader("_self");
        MkTabHeader("$words[REFO1]");
        echo "$words[REFO2]";
        MkTabFooter();

        TblHeader("$words[ID]", "$words[REFSG]");

        for($i = 0; $i < count($reflist); $i++)
        {
            $id = $i+1;
            TblMiddle("$id", "$reflist[$i]", "statconf&opts=editreferer-$i", "statconf&opts=deletereferer-$i");
        }

        TblFooter();

        MkTabHeader("$words[REFAD]");
        echo "<table><form action=\"index.php\" method=\"post\">";

        MkOption ("$words[SIG]", "", "newstitle", "");

        echo "<input type=\"hidden\" name=\"aform\" value=\"addreferer\"><td><font face=\"Arial\" size=\"2\"><input type=\"submit\" value=\"$words[SND]\"></font></td></tr></table>";
        MkTabFooter();

        MkFooter();

    }

    //  ##########################################################

    function AddReferer ()
    {

        global $words, $newstitle, $reflist;

        array_push ($reflist, "$newstitle");

        $file = fopen("../refererconfig.php", w) or die ("$words[REWRI]");
        if (flock($file, 2))
        {
            fputs ($file, "<?php\n\n\$reflist = array(\n\n");
            for($i = 0; $i < count($reflist); $i++)
            {
                fputs($file, "'$reflist[$i]',\n");
            }
            fputs ($file, "\n);\n\n?>");
        }
        flock($file, 3);
        fclose ($file);

        MkHeader("_self");
        MkTabHeader ("$words[DO]");
        echo $words[READD];
        MkTabFooter();
        MkFooter();

    }

    //  ##########################################################

    function EditReferer ()
    {

        global $words, $newstitle, $reflist, $zid;

        $file = fopen("../refererconfig.php", w) or die ("$words[REWRI]");
        if (flock($file, 2))
        {
            fputs ($file, "<?php\n\n\$reflist = array(\n\n");
            for($i = 0; $i < count($reflist); $i++)
            {
                if ($i == $zid)
                {
                    fputs($file, "'$newstitle',\n");
                }
                else
                {
                    fputs($file, "'$reflist[$i]',\n");
                }
            }
            fputs ($file, "\n);\n\n?>");
        }
        flock($file, 3);
        fclose ($file);

        MkHeader("_self");
        MkTabHeader ("$words[DO]");
        echo $words[REEDI];
        MkTabFooter();
        MkFooter();

    }

    //  ##########################################################

    function AdminReferers ($opts)
    {

        global $words;
        dbconnect();

        if ($opts == "clear")
        {

            DBQuery("DELETE FROM esselbach_st_referer");

            MkHeader("_self");
            MkTabHeader ("$words[DO]");
            echo "$words[REFSL]";
            MkTabFooter();
            MkFooter();

        }

        MkHeader("_self");
        MkTabHeader("$words[REFEE]");
        echo "$words[REFDS]";
        MkTabFooter();

        TblHeader("$words[REHIT]", "$words[REFFF] <a href=\"index.php?action=referers&opts=clear\"><img src=\"../images/delete.png\" border=\"0\" alt=\"$words[CLLIS]\"></a>");

        $result = DBQuery("SELECT referer_website, referer_ref, referer_hits, referer_date FROM esselbach_st_referer ORDER BY referer_hits DESC LIMIT 500");

        while (list($referer_website, $referer_ref, $referer_hits, $referer_date) = mysql_fetch_row($result))
        {
            ($bgcolor == "#ffffff") ? $bgcolor = "#eeeeee" :
             $bgcolor = "#ffffff";
            echo "<tr bgcolor=\"$bgcolor\">
                <td align=\"left\" width=\"15%\">
                <font size=\"2\" color=\"#000000\" face=\"Verdana, Arial\">
                $referer_hits
                </font>
                </td>
                <td align=\"left\" width=\"84%\">
                <font size=\"2\" color=\"#000000\" face=\"Verdana, Arial\">
                <a href=\"$referer_ref\" target=\"_blank\">
                $referer_ref</a>
                ($referer_website / $referer_date)
                </font>
                </td>
                <td align=\"center\" width=\"1%\">
                </td>
                </tr>";
        }
        echo "</table>
            </td>
            </tr>
            </table>
            <br />";
        MkFooter();

    }

?>
