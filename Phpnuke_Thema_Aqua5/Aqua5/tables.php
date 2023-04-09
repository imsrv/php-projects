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
						<TD background="themes/Aqua5/images/cadre/coinsupg.gif"><IMG src="themes/Aqua5/images/space15_15.gif"  height="15" width="15"></TD>
						<TD background="themes/Aqua5/images/cadre/sup.gif"><IMG src="themes/Aqua5/images/space15_15.gif"  height="15" width="15"></TD>
						<TD background="themes/Aqua5/images/cadre/coinsupd.gif"><IMG src="themes/Aqua5/images/space15_15.gif"  height="15" width="15"></TD>
					</TR>
					<TR>
						<TD WIDTH=15 background="themes/Aqua5/images/cadre/g.gif"><IMG src="themes/Aqua5/images/space15_15.gif"  height="15" width="15"></TD>
						<TD align="left"  background="themes/Aqua5/images/cadre/fond.gif">
		<?
}

function CloseTable() {
    ?>
						</TD>
						<TD background="themes/Aqua5/images/cadre/d.gif"><IMG src="themes/Aqua5/images/space15_15.gif"  height="15" width="15"></TD>
					</TR>
					<TR>
						<TD background="themes/Aqua5/images/cadre/coininfg.gif"><IMG src="themes/Aqua5/images/space15_15.gif"  height="15" width="15"></TD>
						<TD background="themes/Aqua5/images/cadre/inf.gif"><IMG src="themes/Aqua5/images/space15_15.gif"  height="15" width="15"></TD>
						<TD background="themes/Aqua5/images/cadre/coininfd.gif"><IMG src="themes/Aqua5/images/space15_15.gif"  height="15" width="15"></TD>
					</TR>
				</TABLE>
			</TD>
		</TR>
	</TABLE>
	<?
}


function OpenTable2() {
    global $bgcolor1, $bgcolor2;
    ?>
    <table width="100%" border="0" cellspacing="5" cellpadding="0" ><tr><td>
		<TR>
			<TD align="left">
				<TABLE  CELLPADDING="0" BORDER="0"  CELLSPACING="0">
					<TR>
						<TD background="themes/Aqua5/images/cadre/coinsupg.gif"><IMG src="themes/Aqua5/images/space15_15.gif"  height="15" width="15"></TD>
						<TD background="themes/Aqua5/images/cadre/sup.gif"><IMG src="themes/Aqua5/images/space15_15.gif"  height="15" width="15"></TD>
						<TD background="themes/Aqua5/images/cadre/coinsupd.gif"><IMG src="themes/Aqua5/images/space15_15.gif"  height="15" width="15"></TD>
					</TR>
					<TR>
						<TD WIDTH=15 background="themes/Aqua5/images/cadre/g.gif"><IMG src="themes/Aqua5/images/space15_15.gif"  height="15" width="15"></TD>
						<TD align="left"  background="themes/Aqua5/images/cadre/fond.gif">
    <?
}

function CloseTable2() {
    ?>
						</TD>
						<TD background="themes/Aqua5/images/cadre/d.gif"><IMG src="themes/Aqua5/images/space15_15.gif"  height="15" width="15"></TD>
					</TR>
					<TR>
						<TD background="themes/Aqua5/images/cadre/coininfg.gif"><IMG src="themes/Aqua5/images/space15_15.gif"  height="15" width="15"></TD>
						<TD background="themes/Aqua5/images/cadre/inf.gif"><IMG src="themes/Aqua5/images/space15_15.gif"  height="15" width="15"></TD>
						<TD background="themes/Aqua5/images/cadre/coininfd.gif"><IMG src="themes/Aqua5/images/space15_15.gif"  height="15" width="15"></TD>
					</TR>
				</TABLE>
			</TD>
		</TR>
	</TABLE>
	<?
}


?>