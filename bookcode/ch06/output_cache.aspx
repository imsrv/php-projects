<% @ OutputCache Duration=60 VaryByParam="button" %>

<HTML>
  <SCRIPT language="VB" runat="server">
    Sub Page_Load(Src As Object, E As EventArgs)
          TimeMsg.Text = DateTime.Now.ToString("G")
          PageName.Text = request.querystring("button")
    End Sub
   </SCRIPT>
  <BODY>
    <H3>Output Cache Example</H3>
       <FORM action=output_cache.aspx method=get>
       <P><H4>Click a button</H4>
       <INPUT type="submit" name="button" value="One">
       <INPUT type="submit" name="button" value="Two">
       <INPUT type="submit" name="button" value="Three">
       </FORM>
    <P>Page generated at: <asp:label id="TimeMsg" runat="server"/>
    <P>Page Name: <asp:label id="PageName" runat="server"/>
  </BODY>
</HTML>


 