<!-- Chapter3/DataGrid2.aspx -->
<%@ Import Namespace="System.Data" %>
<%@ Import Namespace="System.Data.OleDb" %>
<html><head></head>
<script language="VB" Debug="true" runat="server">
Sub Page_Load(Source As Object, E As EventArgs)
 If Not IsPostBack Then
   bindListControl
 End If
End Sub
Sub bindListControl()
 Dim myConn As OleDbConnection
 Dim myOleDbAdapter As OleDbDataAdapter
 Dim myDataSet As New DataSet
 Dim connStr, sqlStr As String
 connStr="Provider=Microsoft.Jet.OLEDB.4.0;Data Source=D:\Products.mdb"
 sqlStr = "SELECT  ProductId, ProductName, Price " _
        + " FROM Products WHERE Price > 40 ORDER BY Price"
 myConn= New OleDbConnection(connStr)
 myConn.Open()
 myOleDbAdapter =New OleDbDataAdapter(sqlStr,myConn)
 myOleDbAdapter.Fill(myDataSet,"dtProducts")
 DataGrid1.DataSource = myDataSet.Tables("dtProducts")
 DataGrid1.DataBind()
 myConn.Close()
End Sub
</script>
<asp:DataGrid runat="server" id="DataGrid1" AutoGenerateColumns="false"
   Width="75%" BackColor="White" BorderWidth="1px" BorderStyle="Solid" 
   CellPadding="2" CellSpacing="0" BorderColor="Salmon"
   Font-Name="Verdana" Font-Size="8pt">
   <HeaderStyle Font-Size="8" Font-Names="Arial" Font-Bold="True" 
      BackColor="Yellow" HorizontalAlign="center">
   </HeaderStyle> 
   <Columns>
     <asp:BoundColumn HeaderText="Product ID" DataField="ProductId" >
        <ItemStyle HorizontalAlign="Right"/>
     </asp:BoundColumn>
     <asp:BoundColumn HeaderText="Unit Price" DataField="price" 
          DataFormatString="{0:c}">
          <ItemStyle HorizontalAlign="Right"/>
     </asp:BoundColumn>
     <asp:BoundColumn HeaderText="Description" DataField="ProductName">
        <ItemStyle Width="130"/>
     </asp:BoundColumn>
   </Columns>
   <AlternatingItemStyle BackColor="Beige"/>
</asp:DataGrid>
</center></body></html>

