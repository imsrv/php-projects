<?php

    /*
    ########################
    # |//////////////////| #
    # NULLED by [GTT] =)   #
    # |\\\\\\\\\\\\\\\\\\| #
    ########################
    */

    function AdminPlans($opts)
    {

        global $words, $midas;
        dbconnect();

        $options = explode("-", $opts);
        if ($options[0] == "deleteplan")
        {

            $query = DBQuery("SELECT user_id FROM esselbach_st_plans p, esselbach_st_users u WHERE p.plan_user = u.user_name AND plan_id='$options[1]'");
            list($userid) = mysql_fetch_row($result);

            DBQuery("DELETE FROM esselbach_st_plans WHERE plan_id='$options[1]'");

            RemoveCache("plans/plans-$userid");
            RemoveCache("plans/plan-$options[1]");
            RemoveCache("plans/plans");

            MkHeader("_self");
            MkTabHeader ("$words[DO]");
            echo "$words[SSR2]";
            MkTabFooter();
            MkFooter();

        }

        if ($options[0] == "editplan")
        {

            $result = DBQuery("SELECT * FROM esselbach_st_plans WHERE plan_id='$options[1]'");
            $plan = mysql_fetch_array($result);

            MkHeader("_self");
            MkTabHeader("$words[EPA] $options[1]");

            echo "<table><form name=\"plan\" action=\"index.php\" method=\"post\">";

            $query = DBQuery("SELECT website_id, website_name FROM esselbach_st_websites");
            if (mysql_num_rows($query) > 1)
            {

                echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\">$words[WBS]</font></td><td></td><td><face face=\"Arial\" size=\"2\"><select size=\"1\" name=\"website\">";
                echo "<option value=\"0\">$words[ALL]</option>";
                while (list($website_id, $website_name) = mysql_fetch_row($query))
                {
                    ($website_id == $plan['plan_website']) ? $select = "selected" :
                     $select = "";
                    echo "<option $select value=\"$website_id\">$website_name</option>";
                }

                echo "</select></font></td></tr>";
            }

            if ($midas)
            {
                echo "<script type=\"text/javascript\" src=\"wysiwyg/htmlarea3.js\"></script>";
            }
            else
            {
            echo "<script language=\"JavaScript\">
                <!--
                function AutoInsert1(tag) {
                document.plan.newstext1.value =
                document.plan.newstext1.value + tag;
                }
                //-->
                </script>";

                QuickHTML(1);
            }

            MkArea ("$words[PLA]", "newstext1", "$plan[plan_text]");

            MkSelect ("$words[EHT]", "htmlen", "$plan[plan_html]");
            MkSelect ("$words[EIS]", "iconen", "$plan[plan_icon]");
            MkSelect ("$words[EBC]", "codeen", "$plan[plan_code]");

            echo "<tr><td></td></tr> <input type=\"hidden\" name=\"aform\" value=\"doplanedit\"><input type=\"hidden\" name=\"zid\" value=\"$plan[plan_id]\"><td><font face=\"Arial\" size=\"2\"><input type=\"submit\" value=\"$words[SND]\"></font></td></tr></table>";
            MkTabFooter();

            if ($midas)
            {
                EnableMidas("newstext1");
            }

            MkFooter();
        }

        MkHeader("_self");
        MkTabHeader("$words[PED]");
        echo "$words[PDD]";
        MkTabFooter();

        TblHeader("$words[AII]", "$words[ATD]");

        $result = DBQuery("SELECT plan_website, plan_user, plan_id, plan_time FROM esselbach_st_plans ORDER BY plan_id DESC");

        while (list($plan_website, $plan_author, $plan_id, $plan_time) = mysql_fetch_row($result))
        {
            TblMiddle2("$plan_id / $plan_website", "$plan_author ($plan_time)", "editplans&opts=editplan-$plan_id", "editplans&opts=deleteplan-$plan_id");
        }

        TblFooter();

        MkTabHeader("$words[PAE]");
        echo "<table><form name=\"plan\" action=\"index.php\" method=\"post\">";

        $query = DBQuery("SELECT website_id, website_name FROM esselbach_st_websites");
        if (mysql_num_rows($query) > 1)
        {

            echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\">$words[WBS]</font></td><td></td><td><face face=\"Arial\" size=\"2\"><select size=\"1\" name=\"website\">";
            echo "<option value=\"0\">$words[ALL]</option>";
            while (list($website_id, $website_name) = mysql_fetch_row($query))
            {
                echo "<option value=\"$website_id\">$website_name</option>";
            }

            echo "</select></font></td></tr>";
        }

        if ($midas)
        {
            echo "<script type=\"text/javascript\" src=\"wysiwyg/htmlarea3.js\"></script>";
        }
        else
        {
        echo "<script language=\"JavaScript\">
            <!--
            function AutoInsert1(tag) {
            document.plan.newstext1.value =
            document.plan.newstext1.value + tag;
            }
            //-->
            </script>";

            QuickHTML(1);
        }

        MkArea ("$words[PLA]", "newstext1", "");

        if ($midas)
        {
            MkSelect ("$words[EHT]", "htmlen", "1");
            MkSelect ("$words[EIS]", "iconen", "0");
            MkSelect ("$words[EBC]", "codeen", "0");
        }
        else
        {
            MkSelect ("$words[EHT]", "htmlen", "0");
            MkSelect ("$words[EIS]", "iconen", "1");
            MkSelect ("$words[EBC]", "codeen", "1");
        }

        echo "<input type=\"hidden\" name=\"aform\" value=\"addplan\"><td><font face=\"Arial\" size=\"2\"><input type=\"submit\" value=\"$words[SND]\"></font></td></tr></table>";
        MkTabFooter();

        if ($midas)
        {
            EnableMidas("newstext1");
        }

        MkFooter();

    }

    //  ##########################################################

    function AddPlan ()
    {

        global $words, $website, $admin, $newstext1, $htmlen, $iconen, $codeen, $ipaddr;

        DBQuery("INSERT INTO esselbach_st_plans VALUES (NULL, '$website', '$admin[user_name]', '$newstext1', now(),
            '$htmlen', '$iconen', '$codeen', '$ipaddr', '$ipaddr')");

        RemoveCache("plans/plans-$admin[user_id]");
        RemoveCache("plans/plans");

        MkHeader("_self");
        MkTabHeader ("$words[DO]");
        echo $words[LA];
        MkTabFooter();
        MkFooter();

    }

    //  ##########################################################

    function EditPlan ()
    {

        global $words, $website, $newstext1, $htmlen, $iconen, $codeen, $ipaddr, $zid;

        DBQuery("UPDATE esselbach_st_plans SET plan_website='$website', plan_text='$newstext1', plan_html='$htmlen',
            plan_icon='$iconen', plan_code='$codeen', plan_editip='$ipaddr' WHERE plan_id = '$zid'");

        $query = DBQuery("SELECT user_id FROM esselbach_st_plans p, esselbach_st_users u WHERE p.plan_user = u.user_name AND plan_id='$zid'");
        list($userid) = mysql_fetch_row($result);

        RemoveCache("plans/plans-$userid");
        RemoveCache("plans/plan-$zid");
        RemoveCache("plans/plans");

        MkHeader("_self");
        MkTabHeader ("$words[DO]");
        echo $words[LC];
        MkTabFooter();
        MkFooter();
    }

?>
