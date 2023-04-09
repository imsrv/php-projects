<?php

    /*
    ########################
    # |//////////////////| #
    # NULLED by [GTT] =)   #
    # |\\\\\\\\\\\\\\\\\\| #
    ########################
    */

    function AdminEditTemplates($opts)
    {

        global $words;

        $options = explode("-", $opts);
        if ($options[0] == "deletetemplate")
        {

            MkHeader("_self");
            MkTabHeader ("$words[ERR]");
            echo "$words[TND]";
            MkTabFooter();
            MkFooter();

        }

        if ($options[0] == "previewtemplate")
        {

            if (file_exists("../templates/$options[1].tmp.php"))
            {

                MkHeader("_self");
                require("../templates/$options[1].tmp.php");
                MkTabHeader ("$words[OUTHT]");
                $HTMLCODE = str_replace("\n", "<br />", htmlentities($EST_TEMPLATE));
                $EST_TEMPLATE = str_replace("img src=\"", "img src=\"../", $EST_TEMPLATE);
                echo $EST_TEMPLATE;
                MkTabFooter();
                MkTabHeader ("$words[OUTCO]");
                echo $HTMLCODE;
                MkTabFooter();
                echo "<center><font size=\"2\" face=\"Verdana, Arial\">[<a href=\"javascript:self.close()\">$words[XSIC]</a>]</font></center>";

                MkFooter();
            }
        }

        if ($options[0] == "restoretemplate")
        {

            if (!file_exists("../templates/$options[1].bak.php"))
            {

                MkHeader("_self");
                MkTabHeader ("$words[ERR]");
                echo "$words[NBT]";
                MkTabFooter();
                MkFooter();
            }

            if (!copy("../templates/$options[1].bak.php", "../templates/$options[1].tmp.php"))
            {
                MkHeader("_self");
                MkTabHeader ("$words[ERR]");
                echo "$words[TE2]";
                MkTabFooter();
                MkFooter();
            }

            unlink("../templates/$options[1].bak.php");

            if (file_exists("../templates/$options[1].old.php"))
            {
                if (!copy("../templates/$options[1].old.php", "../templates/$options[1].cnt.php"))
                {
                    MkHeader("_self");
                    MkTabHeader ("$words[ERR]");
                    echo $words[TE2];
                    MkTabFooter();
                    MkFooter();
                }
                unlink("../templates/$options[1].old.php");
            }

            FlushCache();

            MkHeader("_self");
            MkTabHeader ("$words[DO]");
            echo "$words[THR]";
            MkTabFooter();
            MkFooter();

        }

        if (($options[0] == "restorealltemplates") and ($options[1] == "0"))
        {

            MkHeader("_self");
            MkTabHeader ("Done");

            $template_dir = GetDir("../templates");

            for($i = 0; $i < count($template_dir); $i++)
            {
                if ((preg_match("/(.bak.php)/i", $template_dir[$i])) and (!preg_match("/(.cnt.bak.php)/i", $template_dir[$i])))
                {
                    $template_name = explode(".", $template_dir[$i]);
                    if (!copy("../templates/$template_name[0].bak.php", "../templates/$template_name[0].tmp.php"))
                    {
                        MkHeader("_self");
                        MkTabHeader ("$words[ERR]");
                        echo "$words[TE2]";
                        MkTabFooter();
                        MkFooter();
                    }
                    unlink("../templates/$template_name[0].bak.php");

                    if (file_exists("../templates/$template_name[0].old.php"))
                    {
                        if (!copy("../templates/$template_name[0].old.php", "../templates/$template_name[0].cnt.php"))
                        {
                            MkHeader("_self");
                            MkTabHeader ("$words[ERR]");
                            echo $words[TE2];
                            MkTabFooter();
                            MkFooter();
                        }
                        unlink("../templates/$template_name[0].old.php");
                    }
                    echo "$words[RED] $template_name[0]<br />";
                }
            }

            FlushCache();

            MkTabFooter();
            MkFooter();
        }

        if ($options[0] == "edittemplate")
        {

            if (!file_exists("../templates/$options[1].tmp.php"))
            {

                MkHeader("_self");
                MkTabHeader ("$words[DO]");
                echo "$words[UTE]";
                MkTabFooter();
                MkFooter();
            }

            if (file_exists("../templates/$options[1].old.php"))
            {
                include("../templates/$options[1].old.php");
                $oldtempdate = " $words[FROMM] $tempdate";
            }

            if (file_exists("../templates/$options[1].cnt.php"))
            {
                include("../templates/$options[1].cnt.php");
            }
            else
            {
                $tempdate = $words[NOTAV];
            }

            (file_exists("../templates/$options[1].bak.php")) ? $template_backup = "[<a href=\"index.php?action=edittemplates&opts=restoretemplate-$options[1]\">$words[RAT]</a>$oldtempdate]" :
             $template_backup = "";

            $template_file = file("../templates/$options[1].tmp.php");

            MkHeader("_self");
            MkTabHeader("$words[ETE] $options[1]");

            for($i = 0; $i < count($template_file); $i++)
            {
                $template_form .= $template_file[$i];
            }

            echo "<table><form action=\"index.php\" method=\"post\">";

            $template_form = htmlentities($template_form);

            echo "<tr><td vAlign=top><font face=\"Arial\" size=\"2\"><textarea cols=\"100%\" name=\"extra1\" rows=\"25\">$template_form</textarea></font></td></tr>";

            echo "<input type=\"hidden\" name=\"aform\" value=\"dotemplateedit\"><input type=\"hidden\" name=\"zid\" value=\"$options[1]\"><td><font face=\"Arial\" size=\"2\">$words[TELTS] $tempdate $template_backup<br /><input type=\"submit\" value=\"$words[SND]\"></font></td></tr></table>";
            MkTabFooter();
            MkFooter();
        }

        MkHeader("_self");
        MkTabHeader("$words[ETT]");
        echo "$words[TTD]";
        MkTabFooter();

        $template_dir = GetDir("../templates");

        for($i = 1; $i < count($template_dir); $i++)
        {
            if ((preg_match("/(.bak.php)/i", $template_dir[$i])) and (!preg_match("/(.cnt.bak.php)/i", $template_dir[$i])))
            {
                $template_restore = "<font size=\"2\" face=\"Verdana, Arial\">$words[RAL]</font>";
            }
        }

        MkTabHeader("$words[STE]");
        echo "<form action=\"index.php\" method=\"post\"><font size=\"2\" face=\"Verdana, Arial\">$words[FOS]</font>";
        echo "<input type=\"hidden\" name=\"aform\" value=\"searchtemp\"><input name=\"zid\" size=\"32\"><input type=\"submit\" value=\"$words[SUB]\"></form>$template_restore";
        MkTabFooter();

        echo "<table border=\"0\" cellpadding=\"1\" cellspacing=\"1\" width=\"100%\">
            <tr bgcolor=\"#003399\">
            <td>
            <table border=\"0\" cellpadding=\"3\" cellspacing=\"0\" width=\"100%\">
            <tr bgcolor=\"#003399\">
            <td align=\"left\" width=\"95%\">
            <font size=\"2\" color=\"#FFFFFF\" face=\"Verdana, Arial\"><b>$words[TMW]</b></font>
            </td>
            <td align=\"left\" width=\"5%\">

            </td>
            </tr>";

        echo "<script language=\"JavaScript\">
            <!--
            function TemplateWin(tag) {
            var newWinObj = window.open(tag,'newWin','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=1,copyhistory=0,width=450,height=300')
            }
            // -->
            </script>";

        for($i = 1; $i < count($template_dir); $i++)
        {
            if (preg_match("/(.tmp.php)/i", $template_dir[$i]))
            {
                $template_name = explode(".", $template_dir[$i]);
                if (file_exists("../templates/$template_name[0].bak.php"))
                {
                    if (file_exists("../templates/$template_name[0].old.php"))
                    {
                        include("../templates/$template_name[0].old.php");
                        $oldtempdate = " $words[FROMM] $tempdate";
                    }
                    else
                    {
                        $oldtempdate = "";
                    }
                    $template_backup = "[<a href=\"index.php?action=edittemplates&opts=restoretemplate-$template_name[0]\">$words[RAT]</a>$oldtempdate]";
                }
                else
                {
                    $template_backup = "";
                }

                if (($oldtemp and !preg_match("/$oldtemp[0]/i", $template_name[0])) or (!$oldtemp))
                {
                    $template_cat = explode("_", $template_name[0]);
                    $template_cat = strtoupper($template_cat[0]);

                    $template_dsc = "";
                    $br = "<br />";
                    if ($template_cat == "ARCHIVE")
                    {
                        $template_dsc = "$words[TM1]";
                        $br = "";
                    }
                    if ($template_cat == "CATEGORY") $template_dsc = "$words[TM2]";
                    if ($template_cat == "COMMENTS") $template_dsc = "$words[TM3]";
                    if ($template_cat == "DOWNLOAD") $template_dsc = "$words[TM4]";
                    if ($template_cat == "FAQ") $template_dsc = "$words[TM5]";
                    if ($template_cat == "LINK") $template_dsc = "$words[TM6]";
                    if ($template_cat == "NEWS") $template_dsc = "$words[TM7]";
                    if ($template_cat == "STORY") $template_dsc = "$words[TM8]";
                    if ($template_cat == "TICKET") $template_dsc = "$words[TM9]";
                    if ($template_cat == "SPIDER") $template_dsc = "$words[T10]";
                    if ($template_cat == "REVIEW") $template_dsc = "$words[T11]";
                    if ($template_cat == "PAGE") $template_dsc = "$words[T12]";
                    if ($template_cat == "MAIN") $template_dsc = "$words[T13]";
                    if ($template_cat == "UPANEL") $template_dsc = "$words[T14]";
                    if ($template_cat == "LOGIN") $template_dsc = "$words[T15]";
                    if ($template_cat == "SUBMIT") $template_dsc = "$words[T16]";
                    if ($template_cat == "SEARCH") $template_dsc = "$words[T17]";
                    if ($template_cat == "REGISTER") $template_dsc = "$words[T18]";
                    if ($template_cat == "GLOSSARY") $template_dsc = "$words[T19]";
                    if ($template_cat == "SITE") $template_dsc = "$words[T20]";
                    if ($template_cat == "POLL") $template_dsc = "$words[T21]";
                    if ($template_cat == "PLAN") $template_dsc = "$words[T22]";
                    if ($template_cat == "XML") $template_dsc = "$words[T23]";
                    if ($template_cat == "MAIL") $template_dsc = "$words[T24]";
                    if ($template_cat == "MOBILE") $template_dsc = "$words[T25]";
                    if ($template_cat == "SIDEBAR") $template_dsc = "$words[T26]";
                    if ($template_cat == "LIST") $template_dsc = "$words[T27]";

                    if (!$template_dsc) $template_dsc = "$words[T99]";

                    echo <<<Middle
        <tr bgcolor="#ffffff">
        <td align="left" width="95%">$br
            <font size="2" color="#000000" face="Verdana, Arial">
                <b>$template_cat</b>
                </font><br />
            <font size="1" color="#000000" face="Verdana, Arial">
                $template_dsc
                </font><br />
                <hr>
        </td>
      <td align="center" width="5%"><br />
            </font>
      </td>
        </tr>
Middle;

                }

                $oldtemp = explode("_",$template_name[0]);

                ($bgcolor == "#e0e0e0") ? $bgcolor = "#e7e7e7" : $bgcolor = "#e0e0e0";

                 echo <<<Middle
        <tr bgcolor="$bgcolor">
        <td align="left" width="95%">
            <font size="2" color="#000000" face="Verdana, Arial">
                $template_name[0] <a href="javascript:TemplateWin('index.php?action=edittemplates&opts=previewtemplate-$template_name[0]')"><img src="../images/view.png" title="$words[TEMPP]" border="0"></a> $template_backup
                </font>
        </td>
      <td align="center" width="5%">
                <font size="2" color="#000000" face="Verdana, Arial">
                                                                        <a href="index.php?action=edittemplates&opts=edittemplate-$template_name[0]"><img src="../images/edit.png" border="0"></a>
            </font>
      </td>
        </tr>
Middle;

           }
        }

    MkTabFooter();

        MkFooter();

}

    //  ##########################################################

    function SearchTemplates()
    {

        global $words, $zid;

        MkHeader("_self");

        MkTabHeader("$words[STE]");
        echo "<form action=\"index.php\" method=\"post\"><font size=\"2\" face=\"Verdana, Arial\">$words[FOS]</font>";
        echo "<input type=\"hidden\" name=\"aform\" value=\"searchtemp\"><input name=\"zid\" size=\"32\"><input type=\"submit\" value=\"$words[SUB]\"></form>";
        MkTabFooter();

        echo "<table border=\"0\" cellpadding=\"1\" cellspacing=\"1\" width=\"100%\">
            <tr bgcolor=\"#003399\">
            <td>
            <table border=\"0\" cellpadding=\"3\" cellspacing=\"0\" width=\"100%\">
            <tr bgcolor=\"#003399\">
            <td align=\"left\" width=\"95%\">
            <font size=\"2\" color=\"#FFFFFF\" face=\"Verdana, Arial\"><b>$words[TMW]</b></font>
            </td>
            <td align=\"left\" width=\"5%\">

            </td>
            </tr>";

        echo "<script language=\"JavaScript\">
            <!--
            function TemplateWin(tag) {
            var newWinObj = window.open(tag,'newWin','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=1,copyhistory=0,width=450,height=300')
            }
            // -->
            </script>";

        $zid = stripslashes($zid);
        $bzid = strtoupper($zid);

        echo <<<Middle
        <tr bgcolor="#ffffff">
        <td align="left" width="95%"><br />
            <font size="2" color="#000000" face="Verdana, Arial">
                <b>$bzid</b>
                </font><br />
            <font size="1" color="#000000" face="Verdana, Arial">
                $words[TWC] "$zid"
                </font><br />
                <hr>
        </td>
      <td align="center" width="5%"><br />
            </font>
      </td>
        </tr>
Middle;


        $template_dir = GetDir("../templates");

        for($i=1;$i<count($template_dir);$i++) {
           if(preg_match("/(.tmp.php)/i", $template_dir[$i])) {
                $template_name = explode(".",$template_dir[$i]);

                $found = 0;
                $template_file = file("../templates/$template_name[0].tmp.php");
                for($z=0;$z<count($template_file);$z++) {
                        if((stristr($template_file[$z],$zid)) and (!$found)) {
                                $found = 1;
                                ($bgcolor == "#e0e0e0") ? $bgcolor = "#e7e7e7" : $bgcolor = "#e0e0e0";

                if (file_exists("../templates/$template_name[0].bak.php"))
                {
                    if (file_exists("../templates/$template_name[0].old.php"))
                    {
                        include("../templates/$template_name[0].old.php");
                        $oldtempdate = " $words[FROMM] $tempdate";
                    }
                    else
                    {
                        $oldtempdate = "";
                    }
                    $template_backup = "[<a href=\"index.php?action=edittemplates&opts=restoretemplate-$template_name[0]\">$words[RAT]</a>$oldtempdate]";
                }
                else
                {
                    $template_backup = "";
                }

                                 echo <<<Middle
        <tr bgcolor="$bgcolor">
        <td align="left" width="95%">
            <font size="2" color="#000000" face="Verdana, Arial">
                $template_name[0] $template_backup<a href="javascript:TemplateWin('index.php?action=edittemplates&opts=previewtemplate-$template_name[0]')"><img src="../images/view.png" title="$words[TEMPP]" border="0"></a>
                </font>
        </td>
      <td align="center" width="5%">
                <font size="2" color="#000000" face="Verdana, Arial">
            <a href="index.php?action=edittemplates&opts=edittemplate-$template_name[0]"><img src="../images/edit.png" border="0"></a>
            </font>
      </td>
        </tr>
Middle;

                        }
                }

                }
}

        MkTabFooter();
        MkFooter();

}



    //  ##########################################################

    function SearchReplace ()
    {

        global $words, $zid, $extra1, $extra2;

        MkHeader("_self");
        MkTabHeader ("$words[DO]");

        $zid = stripslashes($zid);
        $extra1 = stripslashes($extra1);

        $template_dir = GetDir("../templates");

        for($i = 0; $i < count($template_dir); $i++)
        {
            if (preg_match("/(.tmp.php)/i", $template_dir[$i]))
            {
                $template_name = explode(".", $template_dir[$i]);

                $template_changed = 0;

                $template_file = fopen("../templates/$template_name[0].tmp.php", "r");
                $this_template = fread($template_file, filesize("../templates/$template_name[0].tmp.php"));
                fclose($template_file);

                if ((preg_match("/$zid/i", $this_template)) and ($extra2 == 1))
                {
                    $this_template = str_replace("$zid", "$extra1", $this_template);
                    $template_changed = 1;
                }
                if ((preg_match($zid, $this_template)) and ($extra2 == 2))
                {
                    $this_template = preg_replace("$zid", "$extra1", $this_template);
                    $template_changed = 1;
                }

                if ($template_changed == 1)
                {

                    if (!copy("../templates/$template_name[0].tmp.php", "../templates/$template_name[0].bak.php"))
                    {
                        MkHeader("_self");
                        MkTabHeader ("$words[ERR]");
                        echo $words[TE2];
                        MkTabFooter();
                        MkFooter();
                    }
                    @chmod ("../templates/$template_name[0].bak.php", 0777);

                    if (file_exists("../templates/$template_name[0].cnt.php"))
                    {
                        if (!copy("../templates/$template_name[0].cnt.php", "../templates/$template_name[0].old.php"))
                        {
                            MkHeader("_self");
                            MkTabHeader ("$words[ERR]");
                            echo $words[TE2];
                            MkTabFooter();
                            MkFooter();
                        }
                        @chmod ("../templates/$template_name[0].old.php", 0777);
                    }

                    $file = fopen("../templates/$template_name[0].tmp.php", w) or die("$words[TE2]");
                    if (flock($file, 2))
                    {
                        fputs ($file, "$this_template");
                    }
                    flock($file, 3);
                    fclose ($file);

                    $savedate = date("dS F Y h:i:s A");

                    $file = fopen("../templates/$template_name[0].cnt.php", w) or die("$words[TE2]");
                    if (flock($file, 2))
                    {
                        fputs ($file, "<?php \$tempdate = \"$savedate\"; ?>");
                    }
                    flock($file, 3);
                    fclose ($file);

                    echo "$template_name[0] $words[TSCD]<br />";
                }
            }
        }

        FlushCache();

        MkTabFooter();
        MkFooter();

    }

    //  ##########################################################

    function TemplateEdit ()
    {

        global $words, $extra1, $zid;

        $extra1 = stripslashes($extra1);

        if (!copy("../templates/$zid.tmp.php", "../templates/$zid.bak.php"))
        {
            MkHeader("_self");
            MkTabHeader ("$words[ERR]");
            echo $words[TE2];
            MkTabFooter();
            MkFooter();
        }
        @chmod ("../templates/$zid.bak.php", 0777);

        if (file_exists("../templates/$zid.cnt.php"))
        {
            if (!copy("../templates/$zid.cnt.php", "../templates/$zid.old.php"))
            {
                MkHeader("_self");
                MkTabHeader ("$words[ERR]");
                echo $words[TE2];
                MkTabFooter();
                MkFooter();
            }
            @chmod ("../templates/$zid.old.php", 0777);
        }


        $file = fopen("../templates/$zid.tmp.php", w) or die("$words[TE2]");
        if (flock($file, 2))
        {
            fputs ($file, "$extra1");
        }
        flock($file, 3);
        fclose ($file);

        $savedate = date("dS F Y h:i:s A");
        $file = fopen("../templates/$zid.cnt.php", w) or die("$words[TE2]");
        if (flock($file, 2))
        {
            fputs ($file, "<?php \$tempdate = \"$savedate\"; ?>");
        }
        flock($file, 3);
        fclose ($file);

        FlushCache();

        AdminEditTemplates("edittemplate-$zid");

    }

    //  ##########################################################

    function AdminSearchTemp()
    {

        global $words;

        MkHeader("_self");
        MkTabHeader("$words[TSR]");
        echo "<form action=\"index.php\" method=\"post\"><font size=\"2\" face=\"Verdana, Arial\">$words[FOS]</font><br />";
        echo "<input type=\"hidden\" name=\"aform\" value=\"searchreplacetemp\"><textarea cols=\"100%\" name=\"zid\" rows=\"2\"></textarea><br />$words[AREP]</font><textarea cols=\"100%\" name=\"extra1\" rows=\"2\"></textarea><br /><font size=\"2\" face=\"Verdana, Arial\">$words[INSM]</font> <select size=\"1\" name=\"extra2\"><option value=\"1\">$words[STRRL]</option><option value=\"2\">$words[PRGRL]</option></select> <input type=\"submit\" value=\"$words[SUB]\"></form>";
        MkTabFooter();
        MkFooter();
    }

    //  ##########################################################

    function AdminStylePreview()
    {

        global $words, $extrae1, $extrae2, $extrae3, $extrae4, $extrae5, $extrae6, $extrae7, $extrae8, $extrae9, $extrae10, $extrae11, $extrae12, $extrae13;

        if ($extrae13)
        {
            MkHeader("_self");
            MkTabHeader("$words[STYLE]");

            $template_dir = GetDir("../templates");

            for($i = 0; $i < count($template_dir); $i++)
            {
                if (preg_match("/(.tmp.php)/i", $template_dir[$i]))
                {
                    $template_name = explode(".", $template_dir[$i]);
                    $template_file = fopen("../templates/$template_name[0].tmp.php", "r");
                    $this_template = fread($template_file, filesize("../templates/$template_name[0].tmp.php"));
                    fclose($template_file);

                    $this_template = str_replace("#66ff99", "$extrae7",$this_template);
                    $this_template = str_replace("#000000", "$extrae8",$this_template);
                    $this_template = str_replace("#33ccff", "$extrae4",$this_template);
                    $this_template = str_replace("#000080", "$extrae5",$this_template);
                    $this_template = str_replace("#0066ff", "$extrae6",$this_template);
                    $this_template = str_replace("#008000", "$extrae1",$this_template);
                    $this_template = str_replace("#ccffcc", "$extrae2",$this_template);
                    $this_template = str_replace("#ffffff", "$extrae3",$this_template);
                    $this_template = str_replace("#004364", "$extrae9",$this_template);
                    $this_template = str_replace("#004364", "$extrae10",$this_template);
                    $this_template = str_replace("#004364", "$extrae11",$this_template);
                    $this_template = str_replace("Arial", "$extrae12",$this_template);

                    if (!copy("../templates/$template_name[0].tmp.php", "../templates/$template_name[0].bak.php"))
                    {
                        MkHeader("_self");
                        MkTabHeader ("$words[ERR]");
                        echo $words[TE2];
                        MkTabFooter();
                        MkFooter();
                    }
                    @chmod ("../templates/$template_name[0].bak.php", 0777);

                    if (file_exists("../templates/$template_name[0].cnt.php"))
                    {
                        if (!copy("../templates/$template_name[0].cnt.php", "../templates/$template_name[0].old.php"))
                        {
                            MkHeader("_self");
                            MkTabHeader ("$words[ERR]");
                            echo $words[TE2];
                            MkTabFooter();
                            MkFooter();
                        }
                        @chmod ("../templates/$template_name[0].old.php", 0777);
                    }

                    $file = fopen("../templates/$template_name[0].tmp.php", w) or die("$words[TE2]");
                    if (flock($file, 2))
                    {
                        fputs ($file, "$this_template");
                    }
                    flock($file, 3);
                    fclose ($file);

                    $savedate = date("dS F Y h:i:s A");
                    $file = fopen("../templates/$template_name[0].cnt.php", w) or die("$words[TE2]");
                    if (flock($file, 2))
                    {
                        fputs ($file, "<?php \$tempdate = \"$savedate\"; ?>");
                    }
                    flock($file, 3);
                    fclose ($file);

                    echo "$template_name[0] $words[TSCD]<br />";
                }
            }

            echo "<br /><br /><center>[ <a href=\"../index.php\" target=\"_blank\">$words[PRESI]</a> | <a href=\"index.php?action=edittemplates&opts=restorealltemplates-0\">$words[REBPO]</a> ]<br />";

            FlushCache();

            MkTabFooter();
            MkFooter();
        }

        if (!$extrae7)
        {
            $extrae7 = "#66ff99";
        }
        if (!$extrae8)
        {
            $extrae8 = "#000000";
        }
        if (!$extrae4)
        {
            $extrae4 = "#33ccff";
        }
        if (!$extrae5)
        {
            $extrae5 = "#000080";
        }
        if (!$extrae6)
        {
            $extrae6 = "#0066ff";
        }
        if (!$extrae1)
        {
            $extrae1 = "#008000";
        }
        if (!$extrae2)
        {
            $extrae2 = "#ccffcc";
        }
        if (!$extrae3)
        {
            $extrae3 = "#ffffff";
        }
        if (!$extrae9)
        {
            $extrae9 = "#004364";
        }
        if (!$extrae10)
        {
            $extrae10 = "#004364";
        }
        if (!$extrae11)
        {
            $extrae11 = "#004364";
        }
        if (!$extrae12)
        {
            $extrae12 = "Arial";
        }

        MkHeader("_self");
        MkTabHeader("$words[STYLE]");
        echo $words[STINT];
        MkTabFooter();

        MkTabHeader("$words[SPREV]");
        require("../templates/site_header.tmp.php");
        $tempout = $EST_TEMPLATE;
        $insert[story_title] = $words[EXAMP];
        $insert[story_text] = $words[EXAMT];
        $insert[story_time] = "2000-01-01 14:00:00";
        $insert[story_author] = "Admin";
        $insert[story_source] = "Email";
        require("../templates/story.tmp.php");
        $tempout .= $EST_TEMPLATE;
        $insert[powered_by] = "<center>Powered by Esselbach Storyteller CMS System</center>";
        require("../templates/site_footer.tmp.php");
        $tempout .= $EST_TEMPLATE;

        $tempout = str_replace("img src=\"", "img src=\"../", $tempout);
        $tempout = str_replace("#66ff99", "$extrae7",$tempout);
        $tempout = str_replace("#000000", "$extrae8",$tempout);
        $tempout = str_replace("#33ccff", "$extrae4",$tempout);
        $tempout = str_replace("#000080", "$extrae5",$tempout);
        $tempout = str_replace("#0066ff", "$extrae6",$tempout);
        $tempout = str_replace("#008000", "$extrae1",$tempout);
        $tempout = str_replace("#ccffcc", "$extrae2",$tempout);
        $tempout = str_replace("#ffffff", "$extrae3",$tempout);
        $tempout = str_replace("#004364", "$extrae9",$tempout);
        $tempout = str_replace("#004364", "$extrae10",$tempout);
        $tempout = str_replace("#004364", "$extrae11",$tempout);
        $tempout = str_replace("Arial", "$extrae12",$tempout);

        echo $tempout;
        MkTabFooter();
        MkTabHeader("$words[STYLE]");

        echo "<table><form action=\"index.php\" method=\"post\">";

        MkOption ("$words[COLO7]", "<font color=\"$extrae7\">Color</font>", "extrae7", "$extrae7");
        MkOption ("$words[COLO8]", "<font color=\"$extrae8\">Color</font>", "extrae8", "$extrae8");

        MkOption ("$words[COLO4]", "<font color=\"$extrae4\">Color</font>", "extrae4", "$extrae4");
        MkOption ("$words[COLO5]", "<font color=\"$extrae5\">Color</font>", "extrae5", "$extrae5");
        MkOption ("$words[COLO6]", "<font color=\"$extrae6\">Color</font>", "extrae6", "$extrae6");

        MkOption ("$words[COLO1]", "<font color=\"$extrae1\">Color</font>", "extrae1", "$extrae1");
        MkOption ("$words[COLO2]", "<font color=\"$extrae2\">Color</font>", "extrae2", "$extrae2");
        MkOption ("$words[COLO3]", "<font color=\"$extrae3\">Color</font>", "extrae3", "$extrae3");

        MkOption ("$words[COLO9]", "<font color=\"$extrae9\">Color</font>", "extrae9", "$extrae9");
        MkOption ("$words[COL10]", "<font color=\"$extrae10\">Color</font>", "extrae10", "$extrae10");
        MkOption ("$words[COL11]", "<font color=\"$extrae11\">Color</font>", "extrae11", "$extrae11");
        MkOption ("$words[COL12]", "<font face=\"$extrae12\">Font</font>", "extrae12", "$extrae12");

        echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\"></td></tr>
              <input type=\"hidden\" name=\"aform\" value=\"stylespreview\"><td><font face=\"Arial\" size=\"2\">
              <input type=\"submit\" value=\"$words[PREVI]\"> <input type=\"submit\" name=\"extrae13\" value=\"$words[APPLY]\"></font></td></tr></table>";
        MkTabFooter();
        MkFooter();
    }

    //  ##########################################################

    function FlushCache ()
    {
        ClearCache("news");
        ClearCache("categories");
        ClearCache("archive");
        ClearCache("story");
        ClearCache("xml");
        ClearCache("faq");
        ClearCache("reviews");
        ClearCache("tags");
        ClearCache("pages");
        ClearCache("polls");
        ClearCache("glossary");
        ClearCache("download");
        ClearCache("downloaddet");
        ClearCache("links");
        ClearCache("plans");
    }

?>
