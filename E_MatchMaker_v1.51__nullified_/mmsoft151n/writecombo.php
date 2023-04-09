<?
##############################################################################
#                                                                            #
#                            writecombo.php                                  #
#                                                                            #
##############################################################################
# PROGRAM : E-MatchMaker                                                     #
# VERSION : 1.51                                                             #
#                                                                            #
# NOTES   : site using default site layout and graphics                      #
##############################################################################
# All source code, images, programs, files included in this distribution     #
# Copyright (c) 2001-2002                                                    #
# Supplied by          : CyKuH [WTN]                                         #
# Nullified by         : CyKuH [WTN]                                         #
# Distribution:        : via WebForum and xCGI Forums File Dumps             #
##############################################################################
#                                                                            #
#    While we distribute the source code for our scripts and you are         #
#    allowed to edit them to better suit your needs, we do not               #
#    support modified code.  Please see the license prior to changing        #
#    anything. You must agree to the license terms before using this         #
#    software package or any code contained herein.                          #
#                                                                            #
#    Any redistribution without permission of MatchMakerSoftware             #
#    is strictly forbidden.                                                  #
#                                                                            #
##############################################################################
?>
<?

// Function to write HTML select

function writecombo($array_name, $name, $selected = "", $start = 0, $add_text = "", $add_text2 = "") {
    $length = count ($array_name);
    if (($array_name == "") || ($length == 0))
       echo "<select name=\"$name\"></select>\n";
    else
    {
       echo "<select $add_text $add_text2 name=\"$name\">\n";
       for ($i = $start; $i < $length; $i++)
       {
          $select_name = $array_name[$i];
          echo "  <option value=\"$i\"";
          if ($i == $selected)
             echo " selected";
          echo ">$select_name</option>\n";
       }
       echo "</select>\n";
    }
}

function writemulticombo($array_name, $name, $selected = array("0"), $size = 3) {
    $length = count ($array_name);
    if (($array_name == "") || ($length == 0))
       echo "<select name=\"$name\"></select>\n";
    else
    {
       echo "<select multiple size=$size name=\"$name\">\n";
       for ($i = 1; $i < $length; $i++)
       {
          $select_name = $array_name[$i];
          echo "  <option value=\"$i\"";
          if (in_array($i, $selected))
             echo " selected";
          echo ">$select_name</option>\n";
       }
       echo "</select>\n";
    }
}

function writecheckbox($array_name, $name, $selected = "", $tablesize = 665) {
    $length = count ($array_name);
    if (empty($selected))
       $selected = split(":", "0:0");
    if (($array_name == "") || ($length == 0))
       exit;
    else
    {
       $j = 0;
       echo "<table width=$tablesize><TR>";
       for ($i = 1; $i < $length; $i++)
       {
          $j++;
          if ($j > 5) {
             echo "</TR><TR>";
             $j = 1;
          }
          $check_name = $array_name[$i];
          echo "<TD><input type=checkbox value=$i name=$name id=$i";
          if (in_array($i, $selected))
             echo " checked";
          echo ">&nbsp;<label for=$i><font size=1>$check_name</font></label></TD>";
       }
       echo "</table>\n";
    }
}

function writenamecombo($array_name, $name, $selected = "", $start = 0, $add_text = "", $add_text2 = "") {
    $length = count ($array_name);
    if (($array_name == "") || ($length == 0))
       echo "<select name=\"$name\"></select>\n";
    else
    {
       echo "<select $add_text $add_text2 name=\"$name\">\n";
       for ($i = $start; $i < $length; $i++)
       {
          $select_name = $array_name[$i];
          echo "  <option value=\"$select_name\"";
          if ($select_name == $selected)
             echo " selected";
          echo ">$select_name</option>\n";
       }
       echo "</select>\n";
    }
}


?>
