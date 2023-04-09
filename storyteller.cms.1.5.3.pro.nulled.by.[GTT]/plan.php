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
        $id = $_GET["id"];
        $det = $_GET["det"];
    }

    $id = checknum($id);
    $det = checknum($det);
    $website = $configs[4];

    HeaderBlock();

    if ($det)
    {
        $cache = GetCache("plans", "plan-$det");
        if (!$cache)
        {
            dbconnect();

            $result = DBQuery("SELECT * FROM esselbach_st_plans p, esselbach_st_users u WHERE u.user_name = p.plan_user AND plan_id = '$det' AND plan_website = '$website' OR u.user_name = p.plan_user AND plan_id = '$det' AND plan_website = '0'");

            $insert = mysql_fetch_array($result);
            $plan = GetTemplate("plan_details");

            WriteCache("plans", "plan-$det", $plan, 0);
        }
        FooterBlock();
        exit;
    }

    if (!$id)
    {
        $cache = GetCache("plans", "plans");
        if (!$cache)
        {
            dbconnect();

            $plan = GetTemplate("plan_list_header");

            $result = DBQuery("SELECT * FROM esselbach_st_users ORDER BY user_id");

            while ($insert = mysql_fetch_array($result))
            {
                $query = DBQuery("SELECT * FROM esselbach_st_plans WHERE plan_user = '$insert[user_name]'");
                if (mysql_num_rows($query))
                {
                    $insert[user_plans] = mysql_num_rows($query);
                    $plan .= GetTemplate("plan_list");
                }
            }

            $plan .= GetTemplate("plan_list_footer");

            WriteCache("plans", "plans", $plan, 0);
        }
    }
    else
    {
        $cache = GetCache("plans", "plans-$id");
        if (!$cache)
        {
            dbconnect();

            $result = DBQuery("SELECT * FROM esselbach_st_plans p, esselbach_st_users u WHERE u.user_name = p.plan_user AND u.user_id = '$id' ORDER BY plan_id");

            while ($insert = mysql_fetch_array($result))
            {
                if (!$plan) $plan = GetTemplate("plan_author_header");
                    $plan .= GetTemplate("plan_author_plans");
            }

            $plan .= GetTemplate("plan_author_footer");

            WriteCache("plans", "plans-$id", $plan, 0);
        }
    }

    FooterBlock();

?>
