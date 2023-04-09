<?php

    /*
    ########################
    # |//////////////////| #
    # NULLED by [GTT] =)   #
    # |\\\\\\\\\\\\\\\\\\| #
    ########################
    */

    function AdminSpiders($opts)
    {

        global $spiders, $words;

        $options = explode("-", $opts);
        if ($options[0] == "deletespider")
        {

            $file = fopen("../spiderconfig.php", w) or die ("$words[SCE]");
            if (flock($file, 2))
            {
                fputs ($file, "<?php\n\n\$spiders = array(\n\n");
                for($i = 0; $i < count($spiders); $i++)
                {
                    if ($i != $options[1])
                    {
                        fputs($file, "'$spiders[$i]',\n");
                    }
                }
                fputs ($file, "\n);\n\n?>");
            }
            flock($file, 3);
            fclose ($file);

            MkHeader("_self");
            MkTabHeader ("$words[DO]");
            echo "$words[CNS2]";
            MkTabFooter();
            MkFooter();

        }

        if ($options[0] == "editspider")
        {
            $spider_number = $options[1]+1;
            $spider_numb2 = $options[1];

            MkHeader("_self");
            MkTabHeader("$words[ESS] $spider_number");

            echo "<table><form action=\"index.php\" method=\"post\">";

            MkOption ("$words[SIG]", "", "newstitle", "$spiders[$spider_numb2]");

            echo "<input type=\"hidden\" name=\"aform\" value=\"editspider\"><input type=\"hidden\" name=\"zid\" value=\"$options[1]\"><td><font face=\"Arial\" size=\"2\"><input type=\"submit\" value=\"$words[SND]\"></font></td></tr></table>";
            MkTabFooter();
            MkFooter();
        }

        MkHeader("_self");
        MkTabHeader("$words[ERS]");
        echo "$words[ERD0]";
        MkTabFooter();

        TblHeader("$words[ID]", "$words[SSG]");

        for($i = 0; $i < count($spiders); $i++)
        {
            $id = $i+1;
            TblMiddle("$id", "$spiders[$i]", "spiders&opts=editspider-$i", "spiders&opts=deletespider-$i");
        }

        TblFooter();

        MkTabHeader("$words[ASG]");
        echo "<table><form action=\"index.php\" method=\"post\">";

        MkOption ("$words[SIG]", "", "newstitle", "");

        echo "<input type=\"hidden\" name=\"aform\" value=\"addspider\"><td><font face=\"Arial\" size=\"2\"><input type=\"submit\" value=\"$words[SND]\"></font></td></tr></table>";
        MkTabFooter();

        MkFooter();

    }

    //  ##########################################################

    function CheckSpider ()
    {

        global $words, $newstitle;

        (phpversion() >= "4.1.0") ? $agent = $_SERVER["HTTP_USER_AGENT"] :
         $agent = getenv("HTTP_USER_AGENT");
        if (preg_match("/$newstitle/i", $agent))
        {

            MkHeader("_self");
            MkTabHeader ("$words[ERR]");
            echo $words[SE];
            MkTabFooter();
            MkFooter();
        }
    }

    //  ##########################################################

    function AddSpider ()
    {

        global $words, $newstitle, $spiders;

        array_push ($spiders, "$newstitle");

        $file = fopen("../spiderconfig.php", w) or die ("$words[SCE]");
        if (flock($file, 2))
        {
            fputs ($file, "<?php\n\n\$spiders = array(\n\n");
            for($i = 0; $i < count($spiders); $i++)
            {
                fputs($file, "'$spiders[$i]',\n");
            }
            fputs ($file, "\n);\n\n?>");
        }
        flock($file, 3);
        fclose ($file);

        MkHeader("_self");
        MkTabHeader ("$words[DO]");
        echo $words[SA2];
        MkTabFooter();
        MkFooter();

    }

    //  ##########################################################

    function EditSpider ()
    {

        global $words, $newstitle, $spiders, $zid;

        $file = fopen("../spiderconfig.php", w) or die ("$words[SCE]");
        if (flock($file, 2))
        {
            fputs ($file, "<?php\n\n\$spiders = array(\n\n");
            for($i = 0; $i < count($spiders); $i++)
            {
                if ($i == $zid)
                {
                    fputs($file, "'$newstitle',\n");
                }
                else
                {
                    fputs($file, "'$spiders[$i]',\n");
                }
            }
            fputs ($file, "\n);\n\n?>");
        }
        flock($file, 3);
        fclose ($file);

        MkHeader("_self");
        MkTabHeader ("$words[DO]");
        echo $words[SU];
        MkTabFooter();
        MkFooter();

    }

?>
