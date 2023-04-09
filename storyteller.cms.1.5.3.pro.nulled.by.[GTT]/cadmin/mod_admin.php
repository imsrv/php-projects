<?php

    /*
    ########################
    # |//////////////////| #
    # NULLED by [GTT] =)   #
    # |\\\\\\\\\\\\\\\\\\| #
    ########################
    */

    function AdminShowLog($log)
    {

        global $words;

        MkHeader("_self");

        $ipaddr = GetIP();

        MkTabHeader("$words[SIL]");
        echo "$words[YIS] $ipaddr";
        MkTabFooter();

        echo "<table border=\"0\" cellpadding=\"1\" cellspacing=\"1\" width=\"100%\">
            <tr bgcolor=\"#003399\">
            <td>
            <table border=\"0\" cellpadding=\"3\" cellspacing=\"0\" width=\"100%\">
            <tr bgcolor=\"#003399\">
            <td align=\"left\" width=\"50%\">
            <font size=\"2\" color=\"#FFFFFF\" face=\"Verdana, Arial\"><b>$words[TIT]</b></font>
            </td>
            <td align=\"center\" width=\"25%\">
            <font size=\"2\" color=\"#FFFFFF\" face=\"Verdana, Arial\"><b>$words[PIP]</b></font>
            </td>
            <td align=\"center\" width=\"25%\">
            <font size=\"2\" color=\"#FFFFFF\" face=\"Verdana, Arial\"><b>$words[EIP]</b></font>
            </td>
            </tr>";

        if ($log == "1")
        {
            $syx = "story";
            $query = DBQuery("SELECT * FROM esselbach_st_stories ORDER BY story_id DESC LIMIT 100");
        }
        if ($log == "2")
        {
            $syx = "faq";
            $query = DBQuery("SELECT * FROM esselbach_st_faq ORDER BY faq_id DESC LIMIT 100");
        }
        if ($log == "3")
        {
            $syx = "review";
            $query = DBQuery("SELECT * FROM esselbach_st_review ORDER BY review_id DESC LIMIT 100");
        }
        if ($log == "4")
        {
            $syx = "page";
            $query = DBQuery("SELECT * FROM esselbach_st_pages ORDER BY page_id DESC LIMIT 100");
        }
        if ($log == "5")
        {
            $syx = "glossary";
            $query = DBQuery("SELECT * FROM esselbach_st_glossary ORDER BY glossary_id DESC LIMIT 100");
        }
        if ($log == "6")
        {
            $syx = "download";
            $query = DBQuery("SELECT * FROM esselbach_st_downloads ORDER BY download_id DESC LIMIT 100");
        }
        if ($log == "7")
        {
            $syx = "link";
            $query = DBQuery("SELECT * FROM esselbach_st_links ORDER BY link_id DESC LIMIT 100");
        }
        if ($log == "8")
        {
            $syx = "ticket";
            $query = DBQuery("SELECT * FROM esselbach_st_ticket ORDER BY ticket_id DESC LIMIT 100");
        }
        if ($log == "9")
        {
            $syx = "poll";
            $query = DBQuery("SELECT * FROM esselbach_st_polls ORDER BY poll_id DESC LIMIT 100");
        }
        if ($log == "10")
        {
            $syx = "plan";
            $query = DBQuery("SELECT * FROM esselbach_st_plans ORDER BY plan_id DESC LIMIT 100");
        }

        while ($data = mysql_fetch_array($query))
        {

            ($syx == "faq") ? $title = "faq_question" :
             $title = $syx."_title";
            if ($syx == "plan") $title = "plan_user";
            $postip = $syx."_postip";
            $editip = $syx."_editip";
            ($bgcolor == "#ffffff") ? $bgcolor = "#eeeeee" :
             $bgcolor = "#ffffff";
            echo <<<Middle
        <tr bgcolor="$bgcolor">
        <td align="left" width="50%">
            <font size="2" color="#000000" face="Verdana, Arial">
                $data[$title]
                </font>
        </td>
      <td align="center" width="25%">
                <font size="2" color="#000000" face="Verdana, Arial">
            $data[$postip]
            </font>
      </td>
      <td align="center" width="25%">
                <font size="2" color="#000000" face="Verdana, Arial">
            $data[$editip]
            </font>
      </td>
        </tr>
Middle;

        }
 MkFooter();

}

//  ##########################################################

function AdminEditAdminUsers($opts) {

global $words;

dbconnect();

      $options = explode("-",$opts);
      if ($options[0] == "deleteuser") {

        if ($options[1] > 1) {
                $result = DBQuery("DELETE FROM esselbach_st_users WHERE user_id='$options[1]'");
        }

        MkHeader("_self");

        if ($options[1] > 1) {
        MkTabHeader ("$words[DO]");
                echo "$words[USR]";
        } else {
        MkTabHeader ("$words[ERR]");
                echo "$words[NRM]";
        }
        MkTabFooter();
        MkFooter();

      }

      if ($options[0] == "edituser") {

        $result = DBQuery("SELECT * FROM esselbach_st_users WHERE user_id='$options[1]'");
        $user = mysql_fetch_array($result);

      MkHeader("_self");
      MkTabHeader("$words[EAM] $options[1]");

        echo "<table><form action=\"index.php\" method=\"post\">";

    echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\">$words[PEM]</font></td></td></td>";

    TblWhere2("$words[NE]","extrad3","$user[user_cannews]");
    TblWhere2("$words[DL]","extrad8","$user[user_candownload]");
    TblWhere2("$words[CO]","extra4","$user[user_cancomment]");
    TblWhere ("$words[ML]","extra8","$user[user_canmail]");
    TblWhere ("$words[PO]","extra9","$user[user_canpoll]");
    TblWhere2("$words[FQ]","extrad4","$user[user_canfaq]");
    TblWhere2("$words[RW]","extrad5","$user[user_canreview]");
    TblWhere2("$words[PG]","extrad6","$user[user_canpage]");
    TblWhere2("$words[GO]","extrad7","$user[user_canglossary]");
    TblWhere ("$words[TI]","extra10","$user[user_canticket]");
    TblWhere2("$words[LI]","extra2","$user[user_canlink]");
    TblWhere ("$words[PLA]","extra11","$user[user_canplan]");
    TblWhere ("$words[US]","extra5","$user[user_canuser]");
    TblWhere ("$words[BAN]","extra12","$user[user_canban]");
    TblWhere ("$words[TM]","extra6","$user[user_cantemp]");
    TblWhere ("$words[SD]","extra7","$user[user_canspider]");
    TblWhere ("$words[STA]","extra13","$user[user_canstats]");

    echo "<input type=\"hidden\" name=\"aform\" value=\"updateauser\"><input type=\"hidden\" name=\"extra3\" value=\"$user[user_password]\"><input type=\"hidden\" name=\"zid\" value=\"$user[user_id]\"><td><font face=\"Arial\" size=\"2\"><input type=\"submit\" value=\"$words[SND]\"></font></td></tr></table>";
      MkTabFooter();
      MkFooter();
      }

        MkHeader("_self");
       MkTabHeader("$words[EDU]");
        echo "$words[ED3]";
       MkTabFooter();

        TblHeader("$words[EID]","$words[UN]");

$result = DBQuery("SELECT user_name, user_id FROM esselbach_st_users WHERE user_admin = '1' ORDER BY user_id");

        while(list($user_name, $user_id) = mysql_fetch_row($result)) {
                TblMiddle("$user_id","$user_name","editausers&opts=edituser-$user_id","editausers&opts=deleteuser-$user_id");
        }

    MkFooter();

}

//  ##########################################################

function AdminWebsiteCat($var, $var2, $var3) {

global $words;

    echo "<tr><td><font size=\"1\" face=\"Verdana, Arial\">$var3:</font></td><td></td>";
    echo "<td><face face=\"Arial\" size=\"2\"><select size=\"1\" name=\"$var2\">";

    ($var == "0") ? $output = "<option selected value=\"0\">$words[NAL]</option>" : $output = "<option value=\"0\">$words[NAL]</option>";

    $query = DBQuery("SELECT category_id, category_name FROM esselbach_st_categories");
    while(list($category_id, $category_name) = mysql_fetch_row($query)) {
    ($var == "$category_id") ? $output .= "<option selected value=\"$category_id\">$words[NCU] $category_name</option>" : $output .= "<option value=\"$category_id\">$words[NCU] $category_name</option>";
    }

    ($var == "100") ? $output .= "<option selected value=\"100\">$words[UCB]</option>" : $output .= "<option value=\"100\">$words[UCB]</option>";
    ($var == "110") ? $output .= "<option selected value=\"110\">$words[FQ]</option>" : $output .= "<option value=\"110\">$words[FQ]</option>";
    ($var == "120") ? $output .= "<option selected value=\"120\">$words[RW]</option>" : $output .= "<option value=\"120\">$words[RW]</option>";
    ($var == "130") ? $output .= "<option selected value=\"130\">$words[DLN]</option>" : $output .= "<option value=\"130\">$words[DLN]</option>";
    ($var == "131") ? $output .= "<option selected value=\"131\">$words[DLT]</option>" : $output .= "<option value=\"131\">$words[DLT]</option>";
    ($var == "140") ? $output .= "<option selected value=\"140\">$words[PLA]</option>" : $output .= "<option value=\"140\">$words[PLA]</option>";

    if (file_exists("../bbwrapper.php")) {
            ($var == "200") ? $output .= "<option selected value=\"200\">$words[BBW]</option>" : $output .= "<option value=\"200\">$words[BBW]</option>";
    }

    echo $output;
    echo "</select></font></td></tr>";
}

function AdminBlockOption($var, $var2) {

global $words;

                ($var2 == 3) ? $check3 = "checked" : $check2 = "checked";
   echo "<tr><td> </td><td></td><td>
                      <input type=\"radio\" name=\"$var\" value=\"2\" $check2 /> <font size=\"2\" face=\"Verdana, Arial\">$words[BROW2]</font>
                              <input type=\"radio\" name=\"$var\" value=\"3\" $check3 /> <font size=\"2\" face=\"Verdana, Arial\">$words[BROW3]</font>
                              </td></tr>";

}

function AdminWebsites($opts) {

global $words;

dbconnect();

      $options = explode("-",$opts);
      if ($options[0] == "deletews") {

        if ($options[1] > 1) {
        $result = DBQuery("DELETE FROM esselbach_st_websites WHERE website_id='$options[1]'");

        MkHeader("_self");
        MkTabHeader ("$words[DO]");
                echo "$words[WCR]";
        MkTabFooter();
        MkFooter();

        } else {

        MkHeader("_self");
        MkTabHeader ("$words[ERR]");
                echo "$words[WCR]";
        MkTabFooter();
        MkFooter();

        }

      }

      if ($options[0] == "editws") {

        $result = DBQuery("SELECT * FROM esselbach_st_websites WHERE website_id='$options[1]'");
        $ws = mysql_fetch_array($result);

        $ipaddr = GetIP();

      MkHeader("_self");
       MkTabHeader("$words[CWS]");
        echo "<table><form name=\"website\" action=\"index.php\" method=\"post\">";
          echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\"><b>$words[WBZ]</b></font><br /><font size=\"1\" face=\"Verdana, Arial\">$words[WBT]</font><hr></td><td></td>";
        MkOption ("$words[WNA]","","extra19","$ws[website_name]");
          MkOption ("$words[WUR]","","extra20","$ws[website_url]");
        echo "<tr><td></td><td></td>";
          echo "<tr><td><br /><font size=\"2\" face=\"Verdana, Arial\"><b>$words[ANC]</b></font><br /><font size=\"1\" face=\"Verdana, Arial\">$words[AND]</font><hr></td><td></td>";

    TblWhere ("$words[EANE]","extrad1","$ws[website_textenabled]");

    echo "<script language=\"JavaScript\">
<!--
function AutoInsert1(tag) {
   document.website.newstext1.value =
   document.website.newstext1.value + tag;
}
//-->
</script>";

    MkOption ("$words[ATI]","","newstext2","$ws[website_texttitle]");

    QuickHTML(1);
    MkArea ("$words[ATX]","newstext1","$ws[website_text]");

    MkSelect ("$words[EHT]","htmlen","$ws[website_html]");
    MkSelect ("$words[EIS]","iconen","$ws[website_icon]");
    MkSelect ("$words[EBC]","codeen","$ws[website_code]");

    echo "<tr><td></td><td></td>";
    echo "<tr><td><br /><font size=\"2\" face=\"Verdana, Arial\"><b>$words[NWS]</b></font><br /><font size=\"1\" face=\"Verdana, Arial\">$words[NWD]</font><hr></td><td></td>";

    TblWhere ("$words[SMN]","extrag11","$ws[website_mainnews]");
    MkOption ("$words[MXD]","","extrae11","$ws[website_daymax]");
    MkOption ("$words[MXN]","","extrae12","$ws[website_newsmax]");
    echo "<tr><td><br /><font size=\"2\" face=\"Verdana, Arial\"><b>$words[NBH]</b></font><br /><font size=\"1\" face=\"Verdana, Arial\">$words[NHD]</font><hr></td><td></td>";
    TblWhere ("$words[EB1]","extrad2","$ws[website_blockrow1]");
    AdminBlockOption("extrae20","$ws[website_blockmode1]");
    MkOption ("$words[BT1]","","extrae1","$ws[website_blocktitle11]");
    AdminWebsiteCat("$ws[website_block11]","extrad3","$words[BL1]");
    MkOption ("$words[BF1]","","extrad4","$ws[website_blockfile11]");
    MkOption ("$words[BT2]","","extrae2","$ws[website_blocktitle12]");
    AdminWebsiteCat("$ws[website_block12]","extrad5","$words[BL2]");
    MkOption ("$words[BF2]","","extrad6","$ws[website_blockfile12]");
    MkOption ("$words[BT3]","","extrae3","$ws[website_blocktitle13]");
    AdminWebsiteCat("$ws[website_block13]","extrad7","$words[BL3]");
    MkOption ("$words[BF3]","","extrad8","$ws[website_blockfile13]");

    TblWhere ("$words[EB2]","extrae10","$ws[website_blockrow4]");
    AdminBlockOption("extraf1","$ws[website_blockmode4]");
    MkOption ("$words[BT1]","","extrag5","$ws[website_blocktitle41]");
    AdminWebsiteCat("$ws[website_block41]","extrag7","$words[BL1]");
    MkOption ("$words[BF1]","","extrag6","$ws[website_blockfile41]");
    MkOption ("$words[BT2]","","extrae14","$ws[website_blocktitle42]");
    AdminWebsiteCat("$ws[website_block42]","extrae15","$words[BL2]");
    MkOption ("$words[BF2]","","extrae16","$ws[website_blockfile42]");
    MkOption ("$words[BT3]","","extrae17","$ws[website_blocktitle43]");
    AdminWebsiteCat("$ws[website_block43]","extrae18","$words[BL3]");
    MkOption ("$words[BF3]","","extrae19","$ws[website_blockfile43]");

    echo "<tr><td></td><td></td>";
    echo "<tr><td><br /><font size=\"2\" face=\"Verdana, Arial\"><b>$words[NBF]</b></font><br /><font size=\"1\" face=\"Verdana, Arial\">$words[NFD]</font><hr></td><td></td>";
    TblWhere ("$words[EB1]","extra1","$ws[website_blockrow2]");
    AdminBlockOption("extraf2","$ws[website_blockmode3]");
    MkOption ("$words[BT1]","","extrae4","$ws[website_blocktitle21]");
    AdminWebsiteCat("$ws[website_block21]","extra2","$words[BL1]");
    MkOption ("$words[BF1]","","extra3","$ws[website_blockfile21]");
    MkOption ("$words[BT2]","","extrae5","$ws[website_blocktitle22]");
    AdminWebsiteCat("$ws[website_block22]","extra4","$words[BL2]");
    MkOption ("$words[BF2]","","extra5","$ws[website_blockfile22]");

    MkOption ("$words[BT3]","","extraf5","$ws[website_blocktitle23]");
    AdminWebsiteCat("$ws[website_block23]","extraf6","$words[BL3]");
    MkOption ("$words[BF3]","","extraf7","$ws[website_blockfile23]");

    TblWhere ("$words[EB2]","extra6","$ws[website_blockrow3]");
    AdminBlockOption("extraf3","$ws[website_blockmode3]");
    MkOption ("$words[BT1]","","extrae6","$ws[website_blocktitle31]");
    AdminWebsiteCat("$ws[website_block31]","extra7","$words[BL1]");
    MkOption ("$words[BF1]","","extra8","$ws[website_blockfile31]");
    MkOption ("$words[BT2]","","extrae7","$ws[website_blocktitle32]");
    AdminWebsiteCat("$ws[website_block32]","extrae8","$words[BL2]");
    MkOption ("$words[BF2]","","extrae9","$ws[website_blockfile32]");
    MkOption ("$words[BT3]","","extraf8","$ws[website_blocktitle33]");
    AdminWebsiteCat("$ws[website_block33]","extraf9","$words[BL3]");
    MkOption ("$words[BF3]","","extraf10","$ws[website_blockfile33]");

    echo "<tr><td></td><td></td>";

    echo "<tr><td><br /><font size=\"2\" face=\"Verdana, Arial\"><b>$words[MAILO]</b></font><br /><font size=\"1\" face=\"Verdana, Arial\">$words[MAILC]</font><hr></td><td></td>";

    if (extension_loaded("imap")) {
                        MkOption ("$words[MAINS]","","extraf11","$ws[website_newsmailserver]");
                        MkOption ("$words[UN]","","extraf12","$ws[website_newsmailuser]");
                        MkSOption("$words[PW]","","extraf13","$ws[website_newsmailpw]");
                        MkOption ("$words[MAIDS]","","extraf14","$ws[website_dlmailserver]");
                        MkOption ("$words[UN]","","extraf15","$ws[website_dlmailuser]");
                        MkSOption("$words[PW]","","extraf16","$ws[website_dlmailpw]");
                        } else {
   echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\">$words[IMAPN]</b></font></td><td></td>";
                        }

    echo "<tr><td></td><td></td>";

    echo "<tr><td><br /><font size=\"2\" face=\"Verdana, Arial\"><b>$words[WEBSH]</b></font><br /><font size=\"1\" face=\"Verdana, Arial\">$words[WEBSC]</font><hr></td><td></td>";

                        MkOption ("$words[SITIT]","","extrag2","$ws[website_dtitle]");
                        MkArea ("$words[SITKW]","extrag4","$ws[website_dkeywords]");
    echo "<tr><td></td><td></td>";

    echo "<tr><td><br /><font size=\"2\" face=\"Verdana, Arial\"><b>$words[COMME]</b></font><br /><font size=\"1\" face=\"Verdana, Arial\">$words[COMMC]</font><hr></td><td></td>";

                        MkOption ("$words[CENSO]","","extraf17","$ws[website_censor]");
                        MkOption ("$words[FLOOD]","","extraf19","$ws[website_flood]");
                        MkOption ("$words[EDITM]","","extraf20","$ws[website_editmsg]");
                        MkOption ("$words[EDITX]","","extrag1","$ws[website_editexp]");
    echo "<tr><td></td><td></td>";

    echo "<tr><td><br /><font size=\"2\" face=\"Verdana, Arial\"><b>$words[WSEM0]</b></font><br /><font size=\"1\" face=\"Verdana, Arial\">$words[WSEMC]</font><hr></td><td></td>";

                        MkOption ("$words[WSEM1]","","extrag8","$ws[website_email1]");
                        MkOption ("$words[WSEM2]","","extrag9","$ws[website_email2]");
                        MkOption ("$words[WSEM4]","","extrag14","$ws[website_email4]");
                        MkOption ("$words[WSEM3]","","extrag10","$ws[website_email3]");
                        MkOption ("$words[WSEM5]","","extrag15","$ws[website_email5]");
                        MkOption ("$words[WSEM6]","","extrag16","$ws[website_email6]");
    echo "<tr><td></td><td></td>";

    echo "<tr><td><br /><font size=\"2\" face=\"Verdana, Arial\"><b>$words[ANTL0]</b></font><br /><font size=\"1\" face=\"Verdana, Arial\">$words[ANTL1]</font><hr></td><td></td>";

                        MkOption ("$words[ANTLD]","","extrag13","$ws[website_leech]");
    echo "<tr><td></td><td></td>";

    echo "<tr><td><br /><font size=\"2\" face=\"Verdana, Arial\"><b>$words[OTHER]</b></font><br /><font size=\"1\" face=\"Verdana, Arial\">$words[OTHES]</font><hr></td><td></td>";

                        MkOption ("$words[IPRES]","($words[IPREC] $ipaddr)","extrag3","$ws[website_masterip]");
                        MkSelect ("$words[ANNOY]","extraf18","$ws[website_annoy]");
    echo "<tr><td></td><td></td>";

        echo "<input type=\"hidden\" name=\"aform\" value=\"editws\"><input type=\"hidden\" name=\"zid\" value=\"$ws[website_id]\"><td><font face=\"Arial\" size=\"2\"><input type=\"submit\" value=\"$words[SND]\"></font></td></tr></table>";
       MkTabFooter();
      MkFooter();

      }

        MkHeader("_self");
       MkTabHeader("$words[EDWS]");
        echo "$words[EDWD]";
       MkTabFooter();

        TblHeader("$words[WID]","$words[WNA]");

$result = DBQuery("SELECT website_id, website_name FROM esselbach_st_websites ORDER BY website_id");

        while(list($website_id, $website_title) = mysql_fetch_row($result)) {
                TblMiddle("$website_id","$website_title","websites&opts=editws-$website_id","websites&opts=deletews-$website_id");
        }
        TblFooter();

       MkTabHeader("$words[AAW]");
        echo "<table><form action=\"index.php\" method=\"post\">";
        MkOption ("Website","","extra1","");

        echo "<input type=\"hidden\" name=\"aform\" value=\"addws\"><td><font face=\"Arial\" size=\"2\"><input type=\"submit\" value=\"Send\"></font></td></tr></table>";
       MkTabFooter();

    MkFooter();

}

//  ##########################################################

function AdminRemoveLog() {

global $words;

dbconnect();

        DBQuery("DELETE FROM esselbach_st_log");

        MkHeader("_self");
        MkTabHeader ("$words[DO]");
                echo "$words[LESR]";
        MkTabFooter();
        MkFooter();

      }

//  ##########################################################

function AdminConfig() {

global $words, $configs;

    MkHeader("_self");
    MkTabHeader("$words[CNZ]");

        echo "<table><form action=\"index.php\" method=\"post\">";

    echo "<tr><td><br /><font size=\"2\" face=\"Verdana, Arial\"><b>$words[CN1]</b></font><br /><font size=\"1\" face=\"Verdana, Arial\">$words[CD1]</font><hr></td><td></td>";

    MkOption ("$words[C01]","","extra1","$configs[0]");
    MkOption ("$words[C02]","","extra2","$configs[1]");
    MkOption ("$words[C03]","","extra3","$configs[2]");
    MkOption ("$words[C04]","","extra4","$configs[3]");
    echo "<tr><td><br /><font size=\"2\" face=\"Verdana, Arial\"><b>$words[CN2]</b></font><br /><font size=\"1\" face=\"Verdana, Arial\">$words[CD2]</font><hr></td><td></td>";

    MkOption ("$words[C05]","","extra5","$configs[5]");
    MkOption ("$words[C06]","","extra6","$configs[6]");
    MkOption ("$words[C07]","","extra7","$configs[4]");
    echo "<tr><td><br /><font size=\"2\" face=\"Verdana, Arial\"><b>$words[CN3]</b></font><br /><font size=\"1\" face=\"Verdana, Arial\">$words[CD3]</font><hr></td><td></td>";

    MkOption ("$words[C08]","","extra8","$configs[7]");
    echo "<tr><td><br /><font size=\"2\" face=\"Verdana, Arial\"><b>$words[CN4]</b></font><br /><font size=\"1\" face=\"Verdana, Arial\">$words[CD4]</font><hr></td><td></td>";

    MkSelect ("$words[C09]","extra9","$configs[8]");

           echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\">$words[C23]:</font></td><td></td><td><face face=\"Arial\" size=\"2\"><select size=\"1\" name=\"extra19\">";
                  ($configs[18] == "1") ? $option = "<option selected value=\"1\">$words[C24]</option><option value=\"0\">$words[C25]</option>" : $option = "<option value=\"1\">$words[C24]</option><option selected value=\"0\">$words[C25]</option>";
           echo "$option</select></font></td></tr>";

    MkSelect ("$words[C10]","extra10","$configs[9]");
    MkSelect ("$words[C11]","extra11","$configs[10]");
    MkSelect ("$words[C12]","extra12","$configs[11]");
    MkSelect ("$words[C22]","extra18","$configs[17]");
    MkSelect ("$words[C17]","extra13","$configs[12]");

           echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\">$words[C18]:</font></td><td></td><td><face face=\"Arial\" size=\"2\"><select size=\"1\" name=\"extra14\">";
                  ($configs[13] == "2") ? $option = "<option selected value=\"2\">- 200%</option><option value=\"3\">- 300%</option>" : $option = "<option value=\"2\">- 200%</option><option selected value=\"3\">- 300%</option>";
           echo "$option</select></font></td></tr>";

    echo "<tr><td><br /><font size=\"2\" face=\"Verdana, Arial\"><b>$words[CN6]</b></font><br /><font size=\"1\" face=\"Verdana, Arial\">$words[CD6]</font><hr></td><td></td>";

    MkSelect ("$words[C19]","extra15","$configs[14]");
    MkOption ("$words[C20]","","extra16","$configs[15]");
    MkOption ("$words[C21]","","extra17","$configs[16]");


    echo "<tr><td><br /><br />";
    echo "<input type=\"hidden\" name=\"aform\" value=\"updatecnf\"><td><font face=\"Arial\" size=\"2\"><input type=\"submit\" value=\"$words[SND]\"></font></td></tr></table>";
      MkTabFooter();
      MkFooter();
      }

//  ##########################################################

function AdminInnoUpgrade() {

global $words;

dbconnect();

$mysqlv = explode(".",mysql_get_server_info());

$result = DBQuery("SELECT * FROM esselbach_st_version WHERE version_id='1'");
$release = mysql_fetch_array($result);

if (($mysqlv[0] == 4) and ($release[version_table] != "InnoDB")) {

        $tables = array('banemails','banips','banwords','brokenlinks','categories','comments','downloads',
        'downloadqueue','downloadscat','faq','faqcat','faqqueue','fields','filevotes','glossary','import',
        'leechattempts','links','linkscat','linksqueue','log','mails','pages','plans','polls','pollusers',
        'referer','review','reviewcat','reviewqueue','stories','storyqueue','subscribers','ticket','ticketcat',
        'users','version','websites');

        foreach ($tables as $table) DBQuery("ALTER TABLE `esselbach_st_$table` TYPE = INNODB");
        DBQuery("UPDATE esselbach_st_version SET version_table = 'InnoDB' WHERE version_id = '1'");

        MkHeader("_self");
        MkTabHeader ("$words[DO]");
                echo "$words[INNS] $words[INNY]";
        MkTabFooter();
        MkFooter();

} else {

        MkHeader("_self");
        MkTabHeader ("$words[DO]");
                echo "$words[AINN]";
        MkTabFooter();
        MkFooter();
        }

}

//  ##########################################################

function BuildSearch ($opts) {

global $words;

        $options = explode("-",$opts);

        MkHeader("_self");
        MkTabHeader ("$words[BUILS]");
                echo $words[BUILC]."<br /><br />";

        if ($options[0] == "0") {

                        mysql_query("DROP TABLE esselbach_st_searchindex");

                        DBQuery("CREATE TABLE esselbach_st_searchindex (
             search_id int(11) NOT NULL auto_increment,
             search_oid int(11) NOT NULL default '0',
             search_website int(2) NOT NULL default '0',
             search_category int(2) NOT NULL default '1',
             search_author varchar(80) NOT NULL default '',
             search_title varchar(80) default NULL,
             search_text text,
             search_time datetime default NULL,
             FULLTEXT (search_text),
             PRIMARY KEY (search_id)
             ) TYPE = MYISAM;");

                        $options[0]++;

        }

        if ($options[0] == "1") {

                $query = DBQuery("SELECT * FROM esselbach_st_stories WHERE story_hook = '0' LIMIT $options[1],100");

                if (mysql_num_rows($query)) {
                        while ($out = mysql_fetch_array($query)) {
                                $title = addslashes($out[story_title]);
                                $text = addslashes($out[story_text].$out[story_extendedtext]);
                                $time = addslashes($out[story_time]);
                                $author = addslashes($out[story_author]);
                                $ws = $out[story_website];
                                $id = $out[story_id];

                                DBQuery("INSERT INTO esselbach_st_searchindex VALUES (NULL, '$id', '$ws', '1', '$author', '$title', '$text', '$time')");
                                echo $WORDS[BUILI]." $title ($id)<br />";
                        }

                        $options[1] = $options[1] + 100;

                } else {
                        $options[0]++;
                        $options[1] = 0;
                }
 }

        if ($options[0] == "2") {

                $query = DBQuery("SELECT * FROM esselbach_st_review WHERE review_hook = '0' LIMIT $options[1],100");

                if (mysql_num_rows($query)) {
                        while ($out = mysql_fetch_array($query)) {
                                $title = addslashes($out[review_title]);
                                $text = addslashes($out[review_text]);
                                $time = addslashes($out[review_time]);
                                $author = addslashes($out[review_author]);
                                $ws = $out[review_website];
                                $id = $out[review_id];

                                DBQuery("INSERT INTO esselbach_st_searchindex VALUES (NULL, '$id', '$ws', '2', '$author', '$title', '$text', '$time')");
                                echo $WORDS[BUILI]." $title ($id)<br />";
                        }

                        $options[1] = $options[1] + 100;

                } else {
                        $options[0]++;
                        $options[1] = 0;
                }
 }

        if ($options[0] == "3") {

                $query = DBQuery("SELECT * FROM esselbach_st_faq LIMIT $options[1],100");

                if (mysql_num_rows($query)) {
                        while ($out = mysql_fetch_array($query)) {
                                $title = addslashes($out[faq_question]);
                                $text = addslashes($out[faq_answer]);
                                $time = addslashes($out[faq_time]);
                                $author = addslashes($out[faq_author]);
                                $ws = $out[faq_website];
                                $id = $out[faq_id];

                                DBQuery("INSERT INTO esselbach_st_searchindex VALUES (NULL, '$id', '$ws', '3', '$author', '$title', '$text', '$time')");
                                echo $WORDS[BUILI]." $title ($id)<br />";
                        }

                        $options[1] = $options[1] + 100;

                } else {
                        $options[0]++;
                        $options[1] = 0;
                }
 }

        if ($options[0] == "4") {

                $query = DBQuery("SELECT * FROM esselbach_st_downloads WHERE download_hook = '0' LIMIT $options[1],100");

                if (mysql_num_rows($query)) {
                        while ($out = mysql_fetch_array($query)) {
                                $title = addslashes($out[download_title]);
                                $text = addslashes($out[download_text].$out[download_extendedtext]);
                                $time = addslashes($out[download_time]);
                                $author = addslashes($out[download_author]);
                                $ws = $out[download_website];
                                $id = $out[download_id];

                                DBQuery("INSERT INTO esselbach_st_searchindex VALUES (NULL, '$id', '$ws', '4', '$author', '$title', '$text', '$time')");
                                echo $WORDS[BUILI]." $title ($id)<br />";
                        }

                        $options[1] = $options[1] + 100;

                } else {
                        $options[0]++;
                        $options[1] = 0;
                }
 }

        if ($options[0] == "5") {

                $query = DBQuery("SELECT * FROM esselbach_st_pages LIMIT $options[1],100");

                if (mysql_num_rows($query)) {
                        while ($out = mysql_fetch_array($query)) {
                                $title = addslashes($out[page_title]);
                                $text = addslashes($out[page_text]);
                                $time = addslashes($out[page_time]);
                                $author = addslashes($out[page_author]);
                                $ws = $out[page_website];
                                $id = $out[page_id];

                                DBQuery("INSERT INTO esselbach_st_searchindex VALUES (NULL, '$id', '$ws', '5', '$author', '$title', '$text', '$time')");
                                echo $WORDS[BUILI]." $title ($id)<br />";
                        }

                        $options[1] = $options[1] + 100;

                } else {
                        $options[0]++;
                        $options[1] = 0;
                }
 }

        if ($options[0] == "6") {

                echo $words[BUILZ];

                MkTabFooter();
                MkFooter();

        }

                        echo "<br /><a href=\"index.php?action=SearchIndex&opts=$options[0]-$options[1]\">$words[BUILO]</a>
<SCRIPT LANGUAGE=\"JavaScript\">
<!--
setTimeout('location.href=\"index.php?action=SearchIndex&opts=$options[0]-$options[1]\"',10);
-->
</SCRIPT>";

        MkTabFooter();
        MkFooter();
}

//  ##########################################################

function AdminLogout() {

global $words;

        setcookie ("esselbachsta","0");

        MkHeader("_self");
        MkTabHeader ("$words[DO]");
                echo "$words[CCA]";
        MkTabFooter();
        MkFooter();

      }

//  ##########################################################

function EditAdminUser () {

global $words, $extrad3, $extrad4, $extrad5, $extrad6, $extrad7, $extrad8, $extra2, $extra4, $extra5, $extra6, $extra7, $extra8, $extra9, $extra10, $extra11, $extra12, $extra13, $zid;

     DBQuery("UPDATE esselbach_st_users SET user_cannews='$extrad3', user_canfaq='$extrad4', user_canreview='$extrad5', user_canpage='$extrad6', user_canglossary='$extrad7', user_candownload='$extrad8', user_canlink='$extra2', user_cancomment='$extra4', user_canuser='$extra5', user_cantemp='$extra6', user_canspider='$extra7', user_canmail='$extra8', user_canpoll='$extra9', user_canticket='$extra10', user_canplan='$extra11', user_canban='$extra12', user_canstats='$extra13' WHERE user_id='$zid'");

        MkHeader("_self");
        MkTabHeader ("$words[DO]");
                echo $words[UC];
        MkTabFooter();
        MkFooter();

    }

//  ##########################################################

function UpdateBlackBoard () {

global $words, $newstext1, $zid, $ipaddr;

        DBQuery("UPDATE esselbach_st_version SET version_notes='$newstext1', version_noteuser='$zid',
version_noteip='$ipaddr' WHERE version_id='1'");

    }

//  ##########################################################

function AdminFields () {

global $words, $extra1, $extra2, $extra3, $extra4, $extra5, $extra6, $extra7, $extra8, $extrad1, $extrad2, $extrad3, $extrad4, $extrad5, $extrad6, $extrad7, $extrad8, $extra9, $extra10, $extra11, $extra12, $extra13, $extra14, $extra15, $extra16, $extrad9, $extrad10, $extrad11, $extrad12, $extrad13, $extrad14, $extrad15, $extrad16, $extra17, $extra18, $extra19, $extra20, $extrad17, $extrad18, $extrad19, $extrad20, $extrae1;

      $result = DBQuery("UPDATE esselbach_st_fields SET field_enabled1='$extra1', field_enabled2='$extra2', field_enabled3='$extra3', field_enabled4='$extra4', field_enabled5='$extra5', field_enabled6='$extra6', field_enabled7='$extra7', field_enabled8='$extra8', field_extra1='$extrad1', field_extra2='$extrad2', field_extra3='$extrad3', field_extra4='$extrad4', field_extra5='$extrad5', field_extra6='$extrad6', field_extra7='$extrad7', field_extra8='$extrad8',
field_enabled9='$extra9', field_enabled10='$extra10', field_enabled11='$extra11', field_enabled12='$extra12', field_enabled13='$extra13', field_enabled14='$extra14', field_enabled15='$extra15', field_enabled16='$extra16', field_extra9='$extrad9', field_extra10='$extrad10', field_extra11='$extrad11', field_extra12='$extrad12', field_extra13='$extrad13', field_extra14='$extrad14', field_extra15='$extrad15', field_extra16='$extrad16',
field_enabled17='$extra17', field_enabled18='$extra18', field_enabled19='$extra19', field_enabled20='$extra20', field_extra17='$extrad17', field_extra18='$extrad18', field_extra19='$extrad19', field_extra20='$extrad20' WHERE field_id='$extrae1'");

        MkHeader("_self");
        MkTabHeader ("$words[DO]");
                echo $words[FU];
        MkTabFooter();
        MkFooter();

    }

//  ##########################################################

function AddWebsite () {

global $words, $extra1;

      DBQuery("INSERT INTO esselbach_st_websites VALUES (NULL, '$extra1','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','0','1','1','','','','','','','','','','','','','','','','','','','')");

        MkHeader("_self");
        MkTabHeader ("$words[DO]");
                echo $words[WA];
        MkTabFooter();
        MkFooter();

}

//  ##########################################################

function EditWebsite () {

global $words, $extra19, $extrad1, $newstext1, $newstext2, $extrad2, $extrae1, $extrad3, $extrad4, $extrae2, $extrad5, $extrad6, $extrae3, $extrad7, $extrad8, $extra1, $extrae4, $extra2, $extra3, $extrae5, $extra4, $extra5, $extra6, $extrae6, $extra7, $extra8, $extrae7, $extrae8, $extrae9, $extrae10, $extrae11, $extrae12, $extra20, $htmlen, $codeen, $iconen, $extrae20, $extraf1, $extraf2, $extraf3, $extrag11, $extraf5, $extraf10, $xtrag7, $extrae15, $extrae18, $extraf17, $extraf18, $extraf11, $extraf12, $extraf13, $extraf14, $extraf15, $extraf16, $extraf7, $extraf10, $extrag6, $extrae16, $extrae19, $extraf5, $extraf8, $extrag5, $extrae14, $extrae17, $extraf20, $extrag1, $extraf19, $extrag2, $extrag4, $extrag3, $extrag8, $extrag9, $extrag10, $extrag13, $extrag14, $extrag15, $extrag16, $zid, $ipaddr;

if (!preg_match("/$extrag3/",$ipaddr)) {
        MkHeader("_self");
        MkTabHeader ("$words[ERR]");
                echo "$words[SELBA]<br /><br />$words[SELB1] $extrag3<br />$words[SELB2] $ipaddr";
        MkTabFooter();
        MkFooter();

}

      DBQuery("UPDATE esselbach_st_websites SET website_name='$extra19',
website_textenabled='$extrad1', website_text='$newstext1', website_texttitle='$newstext2', website_blockrow1='$extrad2',
website_blocktitle11='$extrae1', website_block11='$extrad3', website_blockfile11='$extrad4',
website_blocktitle12='$extrae2', website_block12='$extrad5', website_blockfile12='$extrad6',
website_blocktitle13='$extrae3', website_block13='$extrad7', website_blockfile13='$extrad8',
website_blockrow2='$extra1', website_blocktitle21='$extrae4', website_block21='$extra2',
website_blockfile21='$extra3', website_blocktitle22='$extrae5', website_block22='$extra4',
website_blockfile22='$extra5', website_blockrow3='$extra6', website_blocktitle31='$extrae6',
website_block31='$extra7', website_blockfile31='$extra8', website_blocktitle32='$extrae7',
website_block32='$extrae8', website_blockfile32='$extrae9', website_mainnews='$extrag11',
website_daymax='$extrae11', website_newsmax='$extrae12', website_url='$extra20',
website_html='$htmlen', website_code='$codeen', website_icon='$iconen',
website_blockmode1 = '$extrae20', website_blockmode4 = '$extraf1',  website_blockmode3 = '$extraf2',
website_blockmode2 = '$extraf3', website_blockrow4 = '$extrae10', website_block23 = '$extraf5',
website_block33 = '$extraf10', website_block41 = '$extrag7', website_block42 = '$extrae15',
website_block43 = '$extrae18', website_censor = '$extraf17', website_annoy = '$extraf18',
website_newsmailserver = '$extraf11', website_newsmailuser = '$extraf12', website_newsmailpw = '$extraf13',
website_dlmailserver = '$extraf14', website_dlmailuser = '$extraf15', website_dlmailpw = '$extraf16',
website_blockfile23 = '$extraf7', website_blockfile33 = '$extraf10', website_blockfile41 = '$extrag6',
website_blockfile42 = '$extrae16', website_blockfile43 = '$extrae19', website_blocktitle23 = '$extraf5',
website_blocktitle33 = '$extraf8', website_blocktitle41 = '$extrag5', website_blocktitle42 = '$extrae14',
website_blocktitle43 = '$extrae17', website_editmsg = '$extraf20', website_editexp = '$extrag1',
website_flood = '$extraf19', website_dtitle = '$extrag2', website_dkeywords = '$extrag4',
website_adminip = '$extrag3', website_email1 = '$extrag8', website_email2 = '$extrag9',
website_email3 = '$extrag10', website_email4 = '$extrag14', website_email5 = '$extrag15',
website_email6 = '$extrag16', website_leech='$extrag13' WHERE website_id = '$zid'");

        RemoveCache ("news/mainnews");
        RemoveCache ("news/sidebar");
        RemoveCache ("news/header_block");
        RemoveCache ("news/footer_block");

        MkHeader("_self");
        MkTabHeader ("$words[DO]");
                echo $words[WU];
        MkTabFooter();
        MkFooter();
}

//  ##########################################################

function UpdateConfig () {

global $words, $extra1, $extra2, $extra3, $extra4, $extra5, $extra6, $extra7 ,$extra8, $extra9, $extra10, $extra11, $extra12, $extra13, $extra14, $extra15, $extra16, $extra17, $extra18, $extra19;

        $estc = base64_encode("$extra1:_:$extra2:_:$extra3:_:$extra4:_:$extra7:_:$extra5:_:$extra6:_:$extra8:_:$extra9:_:$extra10:_:$extra11:_:$extra12:_:$extra13:_:$extra14:_:$extra15:_:$extra16:_:$extra17:_:$extra18:_:$extra19");
        $file = fopen("../config.php",w) or die("$words[ECC]");
              if (flock($file, 2)) {
                                fputs ($file, "<?php \$estc = \"$estc\"; ?>");
                }
                flock($file, 3);
        fclose ($file);

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

        MkHeader("_self");
        MkTabHeader ("$words[DO]");
                echo $words[ZUF];
        MkTabFooter();
        MkFooter();
}


//  ##########################################################

function AdminPHPCache () {

global $words;

        MkHeader("_self");
        MkTabHeader ("$words[PHCAI]");
                echo $words[PHCAT];
 if ((phpversion() >= "4.1.0") and (function_exists("mmcache"))) {
  if (!$_SERVER[HTTP_REFERER]) echo "<br /><br />".$words[PHFWL];
 }
        MkTabFooter();
        if (function_exists("mmcache")) mmcache();
        if (ini_get("apc.mode")) { echo "<br />"; apcinfo(); }
        MkFooter();

    }

//  ##########################################################

function AdminPHPCacheDone () {

global $words;

        MkHeader("_self");
        MkTabHeader ("$words[DO]");
                echo $words[PHCUP];
        MkTabFooter();
        MkFooter();

    }

//  ##########################################################

function AdminPHPConfig () {

global $words;

        MkHeader("_self");
        MkTabHeader ("$words[PHCOI]");
                echo $words[PHCOT];
        MkTabFooter();
        echo "<br />";
        phpinfo();
        MkFooter();

    }

?>
