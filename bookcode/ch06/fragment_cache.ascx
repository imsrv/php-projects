<%@ OutputCache Duration="120" VaryByParam="none" %>

  <SCRIPT language="VB" runat="server">
    Sub Page_Load(Src As Object, E As EventArgs)
        TimeMsg.Text = DateTime.Now.ToString("G")
    End Sub
  </SCRIPT>
  <P>
  <TABLE border=1 bordercolor=brown>
     <TR bgcolor=lightyellow>
        <TH>First Name</TH>
        <TH>Last Name</TH>
        <TH>Number</TH>
     </TR>
     <TR>
        <TD>Bob</TD>
        <TD>Marly</TD>
        <TD>555-1234</TD>
     </TR>
     <TR>
        <TD>Lee</TD>
        <TD>Young</TD>
        <TD>555-1235</TD>
     </TR>
   </TABLE>
  <P>Table last generated on: <asp:label id="TimeMsg" runat="server" />
