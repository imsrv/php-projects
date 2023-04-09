<%@ Register TagPrefix="Tag1" TagName="TestControl" Src="fragment_cache.ascx" %>

<HTML>
  <SCRIPT language="VB" runat="server">
      Sub Page_Load(Src As Object, E As EventArgs)
          TimeMsg.Text = DateTime.Now.ToString("G")
      End Sub
  </SCRIPT>
  <BODY>
    <H3>Fragment Cache Example</H3>
    <Tag1:TestControl runat="server"/>
    <P>Main page generated at: <asp:label id="TimeMsg" runat="server" />
  </BODY>
</HTML>
