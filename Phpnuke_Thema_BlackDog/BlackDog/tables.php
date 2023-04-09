<?php

/************************************************************/
/* OpenTable Functions                                      */
/*                                                          */
/* Define the tables look&feel for you whole site. For this */
/* we have two options: OpenTable and OpenTable2 functions. */
/* Then we have CloseTable and CloseTable2 function to      */
/* properly close our tables. The difference is that        */
/* OpenTable has a 100% width and OpenTable2 has a width    */
/* according with the table content                         */
/************************************************************/

function OpenTable() {
    global $bgcolor1, $bgcolor2;
    echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
  <tr>
    <td width=\"20\"><img src=\"themes/BlackDog/images/center_hg.gif\" width=\"20\" height=\"20\"></td>
    <td background=\"themes/BlackDog/images/center_h_fd.gif\"><img src=\"themes/BlackDog/images/pixel.gif\" width=\"20\" height=\"20\"></td>
    <td width=\"20\"><img src=\"themes/BlackDog/images/center_hd.gif\" width=\"20\" height=\"20\"></td>
  </tr>
  <tr>
    <td width=\"20\" background=\"themes/BlackDog/images/center_g_fd.gif\"><img src=\"themes/BlackDog/images/pixel.gif\" width=\"20\" height=\"20\"></td>
    <td background=\"themes/BlackDog/images/center_fd.gif\">";
}

function CloseTable() {
    echo "</td>
    <td width=\"20\" background=\"themes/BlackDog/images/center_d_fd.gif\"><img src=\"themes/BlackDog/images/pixel.gif\" width=\"20\" height=\"20\"></td>
  </tr>
  <tr>
    <td width=\"20\"><img src=\"themes/BlackDog/images/center_bg.gif\" width=\"20\" height=\"20\"></td>
    <td background=\"themes/BlackDog/images/center_b_fd.gif\"><img src=\"themes/BlackDog/images/pixel.gif\" width=\"20\" height=\"20\"></td>
    <td width=\"20\"><img src=\"themes/BlackDog/images/center_b_d.gif\" width=\"20\" height=\"20\"></td>
  </tr>
</table>";
}

function OpenTable2() {
    global $bgcolor1, $bgcolor2;
    echo "<table border=\"0\" cellspacing=\"1\" cellpadding=\"0\" bgcolor=\"$bgcolor2\" align=\"center\"><tr><td>\n";
    echo "<table border=\"0\" cellspacing=\"1\" cellpadding=\"8\" bgcolor=\"$bgcolor1\"><tr><td>\n";
}

function CloseTable2() {
    echo "</td></tr></table></td></tr></table>\n";
}

?>