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
    <table width="100%" border="0" cellspacing="5" cellpadding="0" ><tr><td>
    <TR>
	<TD align="center">
	<TABLE  CELLPADDING="0" BORDER="0"  CELLSPACING="0">
	<TR>
	<TD background="themes/Aqua3/images/Cadre/coinsupg.gif"><IMG src="themes/Aqua3/images/space15_15.gif"  height="15" width="15"></TD>
	<TD background="themes/Aqua3/images/Cadre/sup.gif"><IMG src="themes/Aqua3/images/space15_15.gif"  height="15" width="15"></TD>
	<TD background="themes/Aqua3/images/Cadre/coinsupd.gif"><IMG src="themes/Aqua3/images/space15_15.gif"  height="15" width="15"></TD>
	</TR>
	<TR>
	<TD WIDTH=15 background="themes/Aqua3/images/Cadre/g.gif"><IMG src="themes/Aqua3/images/space15_15.gif"  height="15" width="15"></TD>
	<TD align="center"  background="themes/Aqua3/images/Cadre/fond.gif">
    <?
}

function CloseTable() {
    ?>
    </TD>
<TD background="themes/Aqua3/images/Cadre/d.gif"><IMG src="themes/Aqua3/images/space15_15.gif"  height="15" width="15"></TD>
</TR>
<TR>
<TD background="themes/Aqua3/images/Cadre/coininfg.gif"><IMG src="themes/Aqua3/images/space15_15.gif"  height="15" width="15"></TD>
<TD background="themes/Aqua3/images/Cadre/inf.gif"><IMG src="themes/Aqua3/images/space15_15.gif"  height="15" width="15"></TD>
<TD background="themes/Aqua3/images/Cadre/coininfd.gif"><IMG src="themes/Aqua3/images/space15_15.gif"  height="15" width="15"></TD>
</TR>
</TABLE>
</TD>
</TR>
</TABLE><?
}


function OpenTable2() {
    global $bgcolor1, $bgcolor2;
    ?>
    <table width="100%" border="0" cellspacing="5" cellpadding="0" ><tr><td>
    <TR>
	<TD align="left">
	<TABLE  CELLPADDING="0" BORDER="0"  CELLSPACING="0">
	<TR>
	<TD background="themes/Aqua3/images/Cadre/coinsupg.gif"><IMG src="themes/Aqua3/images/space15_15.gif"  height="15" width="15"></TD>
	<TD background="themes/Aqua3/images/Cadre/sup.gif"><IMG src="themes/Aqua3/images/space15_15.gif"  height="15" width="15"></TD>
	<TD background="themes/Aqua3/images/Cadre/coinsupd.gif"><IMG src="themes/Aqua3/images/space15_15.gif"  height="15" width="15"></TD>
	</TR>
	<TR>
	<TD WIDTH=15 background="themes/Aqua3/images/Cadre/g.gif"><IMG src="themes/Aqua3/images/space15_15.gif"  height="15" width="15"></TD>
	<TD align="center"  background="themes/Aqua3/images/Cadre/fond.gif">
    <?
}

function CloseTable2() {
    ?>
    </TD>
<TD background="themes/Aqua3/images/Cadre/d.gif"><IMG src="themes/Aqua3/images/space15_15.gif"  height="15" width="15"></TD>
</TR>
<TR>
<TD background="themes/Aqua3/images/Cadre/coininfg.gif"><IMG src="themes/Aqua3/images/space15_15.gif"  height="15" width="15"></TD>
<TD background="themes/Aqua3/images/Cadre/inf.gif"><IMG src="themes/Aqua3/images/space15_15.gif"  height="15" width="15"></TD>
<TD background="themes/Aqua3/images/Cadre/coininfd.gif"><IMG src="themes/Aqua3/images/space15_15.gif"  height="15" width="15"></TD>
</TR>
</TABLE>
</TD>
</TR>
</TABLE><?
}


?>