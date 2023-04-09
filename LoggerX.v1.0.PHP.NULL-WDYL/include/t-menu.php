<?

$username = $HTTP_GET_VARS["a"];
$password = $HTTP_GET_VARS["p"];

if (!($username)) {
  $username = $HTTP_POST_VARS["a"];
  $password = $HTTP_POST_VARS["p"]; 
}

?>

<script language="Javascript"> 
 <!-- 
 function GoTo(src){ 
 if(event.srcElement.tagName=='TD'){ 
 src.children.tags('A')[0].click(); 
 } 
 } 
 
 //--> 
</script>
	<TR>
		<TD COLSPAN=4  vAlign=Top >
			<TABLE BORDER=0 CELLPADDING=0 CELLSPACING=0 WIDTH=100% height=100%>

						<TABLE BORDER=0 CELLPADDING=1 CELLSPACING=1 width=80% >	
<form action="user.php" name="actionform" method=post>
<input type=hidden name="action" value="visitors">
<input type=hidden name="a" value="<? echo $username; ?>"
							<TR>
<table cellSpacing=1 cellPadding=1 bgcolor="#000000" border=0>
								<TD onmouseover="this.style.background = '#4776AF'" style="CURSOR: hand" onclick=GoTo(this); onmouseout="this.style.background = '#D5D5D5'" class=text bgcolor="#D5D5D5" ><a href="" class=ac onclick="document.actionform.action.value='visitors'; document.actionform.submit(); return false;">Visitors</a></TD><TR>
								<TD onmouseover="this.style.background = '#4776AF'" style="CURSOR: hand" onclick=GoTo(this); onmouseout="this.style.background = '#D5D5D5'" class=text bgcolor="#D5D5D5"><a href="" class=ac onclick="document.actionform.action.value='visitors_of_the_day'; document.actionform.submit(); return false;">Daily</a></TD></TR><TR>
								<TD onmouseover="this.style.background = '#4776AF'" style="CURSOR: hand" onclick=GoTo(this); onmouseout="this.style.background = '#D5D5D5'" class=text bgcolor="#D5D5D5" ><a href="" class=ac onclick="document.actionform.action.value='visitors_of_the_month'; document.actionform.submit(); return false;">Monthly</a></TD></TR><TR>
								<TD onmouseover="this.style.background = '#4776AF'" style="CURSOR: hand" onclick=GoTo(this); onmouseout="this.style.background = '#D5D5D5'" class=text bgcolor="#D5D5D5" ><a href="" class=ac onclick="document.actionform.action.value='referrers'; document.actionform.submit(); return false;">Referrers</a></TD></TR><TR>
								<TD onmouseover="this.style.background = '#4776AF'" style="CURSOR: hand" onclick=GoTo(this); onmouseout="this.style.background = '#D5D5D5'" class=text bgcolor="#D5D5D5" ><a href="" class=ac onclick="document.actionform.action.value='search_engine'; document.actionform.submit(); return false;">Search Engine</a></TD></TR><TR>
								<TD onmouseover="this.style.background = '#4776AF'" style="CURSOR: hand" onclick=GoTo(this); onmouseout="this.style.background = '#D5D5D5'" class=text bgcolor="#D5D5D5" ><a href="" class=ac onclick="document.actionform.action.value='search_query'; document.actionform.submit(); return false;">Search Query</a></TD></TR><TR>
								<TD onmouseover="this.style.background = '#4776AF'" style="CURSOR: hand" onclick=GoTo(this); onmouseout="this.style.background = '#D5D5D5'" class=text bgcolor="#D5D5D5" ><a href="" class=ac onclick="document.actionform.action.value='java_and_javascript'; document.actionform.submit(); return false;">Java and JavaScript</a></TD></TR><TR>
								<TD onmouseover="this.style.background = '#4776AF'" style="CURSOR: hand" onclick=GoTo(this); onmouseout="this.style.background = '#D5D5D5'" class=text bgcolor="#D5D5D5" ><a href="" class=ac onclick="document.actionform.action.value='screen_resolution'; document.actionform.submit(); return false;">Screen Resolution</a></TD></TR><TR>
								<TD onmouseover="this.style.background = '#4776AF'" style="CURSOR: hand" onclick=GoTo(this); onmouseout="this.style.background = '#D5D5D5'" class=text bgcolor="#D5D5D5" ><a href="" class=ac onclick="document.actionform.action.value='color_depth'; document.actionform.submit(); return false;">Color Depth</a></TD></TR><TR>
								<TD onmouseover="this.style.background = '#4776AF'" style="CURSOR: hand" onclick=GoTo(this); onmouseout="this.style.background = '#D5D5D5'" class=text bgcolor="#D5D5D5" ><a href="" class=ac onclick="document.actionform.action.value='operating_system'; document.actionform.submit(); return false;">Operating System</a></TD></TR><TR>
								<TD onmouseover="this.style.background = '#4776AF'" style="CURSOR: hand" onclick=GoTo(this); onmouseout="this.style.background = '#D5D5D5'" class=text bgcolor="#D5D5D5" ><a href="" class=ac onclick="document.actionform.action.value='browser'; document.actionform.submit(); return false;">Browser</a></TD></TR><TR>
								<TD onmouseover="this.style.background = '#4776AF'" style="CURSOR: hand" onclick=GoTo(this); onmouseout="this.style.background = '#D5D5D5'" class=text bgcolor="#D5D5D5" ><a href="" class=ac onclick="document.actionform.action.value='country'; document.actionform.submit(); return false;">Country</a></TD></TR><TR>
								<TD onmouseover="this.style.background = '#4776AF'" style="CURSOR: hand" onclick=GoTo(this); onmouseout="this.style.background = '#D5D5D5'" class=text bgcolor="#D5D5D5" ><a href="" class=ac onclick="document.actionform.action.value='language'; document.actionform.submit(); return false;">Language</a></TD>
							</TR>
</form>
						</TABLE>
						</TABLE>
					</TD>
					<TD VALIGN=TOP align=center width=100%>