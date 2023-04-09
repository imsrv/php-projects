
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

						<table cellSpacing="0" cellPadding="1" width="75%" bgColor="#ffffff" border="0">
                  <tbody>
                    <tr>
                      <td>
                        <table cellSpacing="0" cellPadding="0" width="75%" bgColor="#000000" border="0">
                          <tbody>
                            <tr>
                              <td colSpan="2">
                                <table cellSpacing="1" cellPadding="0" width="75%" border="0">
                                  <tbody>
                                    <tr>
                                      <td align="center" width="100%" bgColor="#4776AF"><b><font color="#FFFFFF" face="Verdana" size="2">Member
                                        Login</font></b></td>
                                    </tr>
                                    <tr>
                                      <td bgColor="#D5D5D5" align="center" width="100%">
                                   <form action="login.php" method="post">
                                        <p align="center">Username:<br>
                                        <input type=text name=a class=input>
<br>
                                        Password:<br>
                                       <input type=password name=p class=input><br>
                                        <input type="submit" value="Login" class=INPUT2>
					</p>Get A Free Account<A href="./sign_up.php">
					<B>Sign up</B></A><br>
				
                                      </td>
                                    </tr>
                                    <tr>
                                      <td width="100%" bgColor="#4776AF"><A HREF="./index.php" ONMOUSEOUT="popDown('HM_Menu1')" ONMOUSEOVER="popUp('HM_Menu1',event)"><IMG SRC="./images/ex.gif" width="115" height="19" BORDER="0"></A></td>
                                    </tr>
                                    <tr>
                                      <td width="100%" align="center" bgColor="#D5D5D5"><img border="0" src="./images/menspc.gif" width="115" height="1"></p>
                                      <img border="0" src="./images/stats.gif" width="88" height="31"></td>
                                    </tr>
                                  </tbody>
                                </table>
                        </table>
            </table>
						</TABLE>
					</TD>	</form>
					<TD VALIGN=TOP align=center width=100%>

	<br>