<?

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
    ?>
    <table width="100%" border="0" cellspacing="1" cellpadding="0" bgcolor="<? echo $bgcolor2; ?>"><tr><td>
    <table width="100%" border="0" cellspacing="1" cellpadding="8" bgcolor="<? echo $bgcolor1; ?>"><tr><td>
    <?
}

function CloseTable() {
    ?>
    </td></tr></table></td></tr></table>
    <?
}

function OpenTable2() {
    global $bgcolor1, $bgcolor2;
    ?>
    <table border="0" cellspacing="1" cellpadding="0" bgcolor="<? echo $bgcolor2; ?>"><tr><td>
    <table border="0" cellspacing="1" cellpadding="8" bgcolor="<? echo $bgcolor1; ?>"><tr><td>
    <?
}

function CloseTable2() {
    ?>
    </td></tr></table></td></tr></table>
    <?
}

?>