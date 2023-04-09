<!-- Chapter3/DataGrid3.aspx -->
<%@ Page Language="VB" Debug="true" %>
<%@ Import Namespace="System.Data" %>
<%@ Import Namespace="System.Data.OleDb" %>
<script language="VB" Debug="true" runat="server">
Sub Page_Load(Source As Object, E As EventArgs)
 If Not IsPostBack Then
  	Dim myDataSet As New Dataset
  	bindDataGrid
 End If
End Sub
Sub bindDataGrid(Optional  sortField As String = "ProductId")
   Dim myConn As OleDbConnection
   Dim myOleDbAdapter As OleDbDataAdapter
   Dim connStr, sqlStr As String
   Dim myDataSet As New Dataset
   connStr="Provider=Microsoft.Jet.OLEDB.4.0;Data Source=D:\Products.mdb"
   
   sqlStr = "SELECT  ProductId, ProductName, Price " _
              +   " FROM Products WHERE Price > 40 ORDER BY " + sortField
   

   myConn= New OleDbConnection(connStr)
   myConn.Open()
   myOleDbAdapter =New OleDbDataAdapter(sqlStr,myConn)
   myOleDbAdapter.Fill(myDataSet,"dtProducts")
   dataGrid1.DataSource = myDataSet.Tables("dtProducts")
   dataGrid1.DataBind()
   myConn.Close()
 End Sub
 Sub sortGrid(s As Object, e As DataGridSortCommandEventArgs)
    bindDataGrid(e.sortExpression)
  End Sub
</script>
<html><head></head><body><form runat="server"><center>
<h4>Click a column heading to sort</h4>
<asp:DataGrid runat="server" id="dataGrid1"
     AutoGenerateColumns="true"
     AllowSorting="true"
     OnSortCommand="sortGrid"
     Width="75%"
     BackColor="White"
     BorderWidth="1px" BorderStyle="Solid" 
     CellPadding="2" CellSpacing="0"
     BorderColor="Salmon"
     Font-Name="Verdana" Font-Size="8pt">
    <HeaderStyle Font-Size="8" Font-Names="Arial" 
             Font-Bold="True" BackColor="Yellow"
             HorizontalAlign="center">
    </HeaderStyle> 
    <AlternatingItemStyle BackColor="Beige"/>
</asp:DataGrid>
</center></form></body></html>
	