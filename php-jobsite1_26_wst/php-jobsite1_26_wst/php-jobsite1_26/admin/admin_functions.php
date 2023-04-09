<?php
/**
* Stop running the current processed file...but first close the tables, body, html... 
*/
function exit_footer()
{
    echo "      </td>\n";
    echo "     </tr>\n";
    echo "  </table>\n";
    echo " </td>\n";
    echo " <!-- end body_navigation //-->\n";
    echo " </tr>\n";
    echo " </table>\n";
    echo "<table border=\"0\" width=\"".HTML_WIDTH."\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">\n";
    echo " <tr>\n";
    echo " <td width=\"100%\">\n";
    include("footer.html");
    echo " </td>\n";
    echo " </tr>\n";
    echo "</table>\n";
    echo "</body>\n";
    echo "</html>\n";
    bx_exit();
} // end func exit_footer()

function bx_admin_error($message) {
	     global $error_title;
         echo "<table width=\"100%\" cellspacing=\"0\" cellpadding=\"2\">";
         echo "<tr>";
         echo "     <td bgcolor=\"#000000\" align=\"center\"><font face=\"Verdana, Arial\" size=\"2\" color=\"red\"><b>Error !!!</b></font></td>";
         echo " </tr>";
         echo " <tr>";
         echo "   <td bgcolor=\"#000000\">";
         echo "<TABLE border=\"0\" cellpadding=\"4\" cellspacing=\"0\" bgcolor=\"#00CCFF\" width=\"100%\">";
         echo "        <td colspan=\"2\" align=\"center\"><font face=\"".TEXT_FONT_FACE."\" size=\"".TEXT_FONT_SIZE."\" color=\"".TEXT_FONT_COLOR."\"><h1>Errors occurred when $error_title</h1></font></td>";
         echo "</tr>";
         echo "<tr>";
         echo "        <td colspan=\"2\"><font face=\"".TEXT_FONT_FACE."\" size=\"".TEXT_FONT_SIZE."\" color=\"#000000\"><b>$message</b></font></td>";
         echo "</tr>";
         echo "<tr>";
         echo "        <td colspan=\"2\" align=\"center\"><br><input type=\"button\" name=\"back\" value=\"Back\" onClick=\"history.back();\"></td>";
         echo "</tr>";
         echo "</table>";
         echo "</td></tr></table>";
		 exit_footer();
}//end function bx_admin_error
?>