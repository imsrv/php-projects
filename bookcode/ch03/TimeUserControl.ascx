<!-- Chapter3/TimeUserControl.ascx -->
<table border ="5" cellpadding="5" rules="none" bgcolor="lightyellow"
     bordercolor="orange">
	<tr valign="middle"><td><h3>The time in server land is </h3></td>
		<td><h3><asp:Label id="lblDateTime"  runat="server"/></h3></td>
	</tr>
</table>
<script Language="vb" runat ="server">
Sub Page_Load(s As Object, e As EventArgs)
	If Not Page.IsPostBack Then
  		' lblDateTime.Text = System.DateTime.Now.ToLongTimeString()
  		lblDateTime.Text = Format(Now,"hh:mm:ss")
	End If  
End Sub
</script>