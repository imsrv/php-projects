<!-- Chapter3\HtmlButton1.aspx -->
<html><form runat="server"><h4><font face="Verdana">
HtmlButton Sample With  Embedded &lt;img&gt; Tag And Rollover </font></h4>
<font face="Verdana" size="-1"><p>
<Button id="btnReel" 
     OnServerClick="btnReel_OnClick" 
     OnMouseOver="this.style.backgroundColor='yellow'"
     OnMouseOut="this.style.backgroundColor='white'"
     style="font: 8pt verdana; background-color:lightgreen;
                 border-color:blue;
                 height:100;  width:170" 
     runat="server">
    <img src="images/SmallSpinReel1.jpg"/><b> Bass Master!</b>
</Button><p>
<Span id=span1 runat="server" />
</font></form></body></html>
<script language="VB" runat="server">
      Sub btnReel_OnClick(Source As Object, e As EventArgs)
         span1.InnerHtml = "You clicked Bass Master"
      End Sub
</script>
