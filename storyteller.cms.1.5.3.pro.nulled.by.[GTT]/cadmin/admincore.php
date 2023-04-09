<?php

    /*
    ########################
    # |//////////////////| #
    # NULLED by [GTT] =)   #
    # |\\\\\\\\\\\\\\\\\\| #
    ########################
    */

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

//  ##########################################################

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

//  ##########################################################

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

//  ##########################################################

function MkTabOption ($var,$var2) {

    echo <<<TabOption
                  <font size="1" face="Verdana, Arial">
                  &#187; <a href="index.php?action=$var2">$var</a>
                  </font>
                  <br />
TabOption;
}

//  ##########################################################

function MkOption ($var, $var2, $var3, $var4) {

   echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\">$var:</font>";
   if ($var2) {
          echo "<br /><font size=\"1\" face=\"Verdana, Arial\">$var2</font>";
    }
   echo "</td><td></td><td><font face=\"Arial\" size=\"2\"><input name=\"$var3\" size=\"32\" value=\"$var4\"></font></td></tr>";

}

//  ##########################################################

function MkSOption ($var, $var2, $var3, $var4) {

   echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\">$var:</font>";
   if ($var2) {
          echo "<br /><font size=\"1\" face=\"Verdana, Arial\">$var2</font>";
    }
   echo "</td><td></td><td><font face=\"Arial\" size=\"2\"><input type=\"password\" name=\"$var3\" size=\"32\" value=\"$var4\"></font></td></tr>";

}

//  ##########################################################

function MkSelect ($var, $var2, $var3) {

global $words;

   echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\">$var:</font></td><td></td><td><face face=\"Arial\" size=\"2\"><select size=\"1\" name=\"$var2\">";
  ($var3) ? $option = "<option selected value=\"1\">$words[Y]</option><option value=\"0\">$words[N]</option>" : $option = "<option value=\"1\">$words[Y]</option><option selected value=\"0\">$words[N]</option>";
   echo "$option</select></font></td></tr>";

}

//  ##########################################################

function MkArea ($var, $var2, $var3) {

   echo "
   <tr>
    <td vAlign=top>
     <font size=\"2\" face=\"Verdana, Arial\">$var:</font>
    </td>
    <td>
    </td>
    <td>
     <font face=\"Arial\" size=\"2\">
      <textarea name=\"$var2\" id=\"$var2\" cols=\"60\" rows=\"20\">$var3</textarea>
     </font>
    </td>
   </tr>
   ";

}

//  ##########################################################

function TblHeader ($var, $var2) {

echo "<table border=\"0\" cellpadding=\"1\" cellspacing=\"1\" width=\"100%\">
  <tr bgcolor=\"#003399\">
     <td>
        <table border=\"0\" cellpadding=\"3\" cellspacing=\"0\" width=\"100%\">
           <tr bgcolor=\"#003399\">
              <td align=\"left\" width=\"15%\">
                  <font size=\"2\" color=\"#FFFFFF\" face=\"Verdana, Arial\"><b>$var</b></font>
              </td>
              <td align=\"left\" width=\"75%\">
                  <font size=\"2\" color=\"#FFFFFF\" face=\"Verdana, Arial\"><b>$var2</b></font>
              </td>
              <td align=\"left\" width=\"10%\">

              </td>
           </tr>";
}

//  ##########################################################

function TblMiddle ($var, $var2, $var3, $var4) {

global $bgcolor, $wsperfs, $words;

($wsperfs[website_annoy]) ? $link1 = "index.php?action=$var3&annoy=1" : $link1 = "index.php?action=$var3";
($wsperfs[website_annoy]) ? $link2 = "index.php?action=$var4&annoy=1" : $link2 = "index.php?action=$var4";

($bgcolor == "#ffffff") ? $bgcolor = "#eeeeee" : $bgcolor = "#ffffff";

                 echo <<<Middle
<tr bgcolor="$bgcolor">
        <td align="left" width="15%">
              <font size="2" color="#000000" face="Verdana, Arial">
                $var
                </font>
        </td>
        <td align="left" width="75%">
            <font size="2" color="#000000" face="Verdana, Arial">
                $var2
                </font>
        </td>
      <td align="center" width="10%">
                <font size="2" color="#000000" face="Verdana, Arial">
            <a href="$link1" title="$words[EDIT1]"><img src="../images/edit.png" border="0"></a>
            <a href="$link2" title="$words[DELEE]"><img src="../images/delete.png" border="0"></a>
            </font>
      </td>
</tr>
Middle;
}

//  ##########################################################

function TblMiddle2 ($var, $var2, $var3, $var4) {

global $bgcolor, $wsperfs, $words;

($wsperfs[website_annoy]) ? $link1 = "index.php?action=$var3&annoy=1" : $link1 = "index.php?action=$var3";
($wsperfs[website_annoy]) ? $link2 = "index.php?action=$var4&annoy=1" : $link2 = "index.php?action=$var4";

($bgcolor == "#ffffff") ? $bgcolor = "#eeeeee" : $bgcolor = "#ffffff";

                 echo <<<Middle
<tr bgcolor="$bgcolor">
        <td align="left" width="15%">
              <font size="2" color="#000000" face="Verdana, Arial">
                $var
                </font>
        </td>
        <td align="left" width="75%">
            <font size="2" color="#000000" face="Verdana, Arial">
                $var2
                </font>
        </td>
      <td align="center" width="10%">
                <font size="2" color="#000000" face="Verdana, Arial">
            <a href="$link1" title="$words[EDIT1]"><img src="../images/edit.png" border="0"></a>
            <a href="$link1&midas=1" title="$words[EDIT2]"><img src="../images/edit.png" border="0"></a>
            <a href="$link2" title="$words[DELEE]"><img src="../images/delete.png" border="0"></a>
            </font>
      </td>
</tr>
Middle;
}

//  ##########################################################

function TblFooter () {

                 echo "</table>
                    </td>
                  </tr>
                </table>
          ";

}

//  ##########################################################

function TblWhere ($var, $var2, $var3) {

global $words;

    echo "<tr><td><font size=\"1\" face=\"Verdana, Arial\">$var</font></td><td></td><td><face face=\"Arial\" size=\"1\"><select size=\"1\" name=\"$var2\">";
    (!$var3) ? $select = "selected" : $select = "";
    echo "<option $select value=\"0\">$words[N]</option>";
    ($var3) ? $select = "selected" : $select = "";
    echo "<option $select value=\"1\">$words[Y]</option>";
    echo "</select></font></td></tr>";
}

//  ##########################################################

function TblWhere2 ($var, $var2, $var3) {

global $words;

    echo "<tr><td><font size=\"1\" face=\"Verdana, Arial\">$var</font></td><td></td><td><face face=\"Arial\" size=\"1\"><select size=\"1\" name=\"$var2\">";
    (!$var3) ? $select = "selected" : $select = "";
    echo "<option $select value=\"0\">$words[N]</option>";
    ($var3 == 1) ? $select = "selected" : $select = "";
    echo "<option $select value=\"1\">$words[Y]</option>";
    ($var3 == 2) ? $select = "selected" : $select = "";
    echo "<option $select value=\"2\">$words[LIMIT]</option>";
    echo "</select></font></td></tr>";
}

//  ##########################################################

function QuickHTML ($var) {

global $words;

    echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\">$words[QH]:</font></td><td></td><td><face face=\"Arial\" size=\"2\">
                        <a href=\"javascript:AutoInsert$var('[b]bold text[/b]')\"><img src=\"../images/icons/button_bold.png\" border=\"0\"></a>
                        <a href=\"javascript:AutoInsert$var('[i]italic text[/i]')\"><img src=\"../images/icons/button_italic.png\" border=\"0\"></a>
                        <a href=\"javascript:AutoInsert$var('[u]underlined text[/u]')\"><img src=\"../images/icons/button_underline.png\" border=\"0\"></a>
                        <a href=\"javascript:AutoInsert$var('[sup]sup text[/sup]')\"><img src=\"../images/icons/button_sup.png\" border=\"0\"></a>
                        <a href=\"javascript:AutoInsert$var('[sub]sub text[/sub]')\"><img src=\"../images/icons/button_sub.png\" border=\"0\"></a>
                        <a href=\"javascript:AutoInsert$var('[tt]tt text[/tt]')\"><img src=\"../images/icons/button_tt.png\" border=\"0\"></a>
                        <a href=\"javascript:AutoInsert$var('[s]s text[/s]')\"><img src=\"../images/icons/button_s.png\" border=\"0\"></a>
                        <a href=\"javascript:AutoInsert$var('[marquee]marquee text[/marquee]')\"><img src=\"../images/icons/button_marquee.png\" border=\"0\"></a>
                        <a href=\"javascript:AutoInsert$var('[center]center text[/center]')\"><img src=\"../images/icons/button_center.png\" border=\"0\"></a>
                        <a href=\"javascript:AutoInsert$var('[left]left text[/left]')\"><img src=\"../images/icons/button_left.png\" border=\"0\"></a>
                        <a href=\"javascript:AutoInsert$var(' :) ')\"><img src=\"../images/icons/button_smilie_smile.png\" border=\"0\"></a>
                        <a href=\"javascript:AutoInsert$var(' ;) ')\"><img src=\"../images/icons/button_smilie_wink.png\" border=\"0\"></a>
                        <a href=\"javascript:AutoInsert$var(' :( ')\"><img src=\"../images/icons/button_smilie_sad.png\" border=\"0\"></a>
                        <a href=\"javascript:AutoInsert$var(' :x ')\"><img src=\"../images/icons/button_smilie_ssad.png\" border=\"0\"></a>
                        <a href=\"javascript:AutoInsert$var(' ;( ')\"><img src=\"../images/icons/button_smilie_mad.png\" border=\"0\"></a><br />
                        <a href=\"javascript:AutoInsert$var('[right]right text[/right]')\"><img src=\"../images/icons/button_right.png\" border=\"0\"></a>
                        <a href=\"javascript:AutoInsert$var('[font=arial]Using arial font[/font]')\"><img src=\"../images/icons/button_font.png\" border=\"0\"></a>
                        <a href=\"javascript:AutoInsert$var('[size=10]Using font size 10[/size]')\"><img src=\"../images/icons/button_size.png\" border=\"0\"></a>
                        <a href=\"javascript:AutoInsert$var('[color=red]Using the color red[/color]')\"><img src=\"../images/icons/button_color.png\" border=\"0\"></a>
                        <a href=\"javascript:AutoInsert$var('[quote]quoted text[/quote]')\"><img src=\"../images/icons/button_quote.png\" border=\"0\"></a>
                        <a href=\"javascript:AutoInsert$var('[url]http://www. .com[/url]')\"><img src=\"../images/icons/button_url.png\" border=\"0\"></a>
                        <a href=\"javascript:AutoInsert$var('[url=http://www. .com]My Homepage[/url]')\"><img src=\"../images/icons/button_urllink.png\" border=\"0\"></a>
                        <a href=\"javascript:AutoInsert$var('[email]myemail@provider[/email]')\"><img src=\"../images/icons/button_email.png\" border=\"0\"></a>
                        <a href=\"javascript:AutoInsert$var('[email=email@provider]My Email[/email]')\"><img src=\"../images/icons/button_emaillink.png\" border=\"0\"></a>
                        <a href=\"javascript:AutoInsert$var('[img]http://url_to_../images/picture[/img]')\"><img src=\"../images/icons/button_images.png\" border=\"0\"></a>
                        <a href=\"javascript:AutoInsert$var(' :o ')\"><img src=\"../images/icons/button_smilie_frown.png\" border=\"0\"></a>
                        <a href=\"javascript:AutoInsert$var(' :p ')\"><img src=\"../images/icons/button_smilie_tongue.png\" border=\"0\"></a>
                        <a href=\"javascript:AutoInsert$var(' 8) ')\"><img src=\"../images/icons/button_smilie_cool.png\" border=\"0\"></a>
                        <a href=\"javascript:AutoInsert$var(' x) ')\"><img src=\"../images/icons/button_smilie_sleep.png\" border=\"0\"></a>
                        <a href=\"javascript:AutoInsert$var(' :D ')\"><img src=\"../images/icons/button_smilie_happy.png\" border=\"0\"></a>
 </font></td></tr>";

}

//  ##########################################################

function EnableMidas ($var) {

   echo "
   <script language=\"JavaScript1.2\">
                $var = new HTMLArea(\"$var\");
                $var.generate();
        </script>
        ";

}

//  ##########################################################

function AdminEditFields($fieldid) {

global $words;

dbconnect();

      MkHeader("_self");
      MkTabHeader("$words[EF]");

        echo "<table><form action=\"index.php\" method=\"post\">";

        $query = DBQuery("SELECT * FROM esselbach_st_fields WHERE field_id='$fieldid'");
        $field = mysql_fetch_array($query);

      for($i=1;$i<21;$i++) {
                echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\">$words[FL] $i:</font></td><td></td><td><face face=\"Arial\" size=\"2\"><select size=\"1\" name=\"extra$i\">";
                ($field['field_enabled'.$i] == 0) ? $select0 = "selected" : $select0 = "";
                ($field['field_enabled'.$i] == 1) ? $select1 = "selected" : $select1 = "";
                ($field['field_enabled'.$i] == 2) ? $select2 = "selected" : $select2 = "";
                echo "<option $select0 value=\"0\">$words[DS]</option>";
                echo "<option $select1 value=\"1\">$words[TO]</option>";
                echo "<option $select2 value=\"2\">$words[DM]</option>";
                echo "</select></font></td></tr>";
                echo "<tr><td><font size=\"2\" face=\"Verdana, Arial\">$words[FT]:</font>";
                echo "</td><td></td><td><font face=\"Arial\" size=\"2\"><input name=\"extrad$i\" size=\"32\" value=\"".$field['field_extra'.$i]."\"></font></td></tr>";
        }

    echo "<input type=\"hidden\" name=\"aform\" value=\"fieldsadd\"><input type=\"hidden\" name=\"extrae1\" value=\"$fieldid\"><td><font face=\"Arial\" size=\"2\"><input type=\"submit\" value=\"$words[SM]\"></font></td></tr></table>";

    MkTabFooter();
    MkFooter();

}

//  ##########################################################

function AddIndex ($id, $ws, $cat, $author, $title, $text, $time) {

                $result = DBQuery("SELECT version_table FROM esselbach_st_version");
                list($table) = mysql_fetch_row($result);

                if ($table == "InnoDB") DBQuery("INSERT INTO esselbach_st_searchindex VALUES (NULL, '$id', '$ws', '$cat', '$author', '$title', '$text', '$time')");

}

//  ##########################################################

function UpdateIndex ($id, $ws, $cat, $title, $text) {

                $result = DBQuery("SELECT version_table FROM esselbach_st_version");
                list($table) = mysql_fetch_row($result);

                if ($table == "InnoDB") DBQuery("UPDATE esselbach_st_searchindex SET search_title = '$title', search_text = '$text', search_website = '$ws' WHERE search_oid = '$id' AND search_category = '$cat'");

}

//  ##########################################################

function RemoveIndex ($id, $cat) {

                $result = DBQuery("SELECT version_table FROM esselbach_st_version");
                list($table) = mysql_fetch_row($result);

                if ($table == "InnoDB") DBQuery("DELETE FROM esselbach_st_searchindex WHERE search_oid = '$id' AND search_category = '$cat'");

}

?>
