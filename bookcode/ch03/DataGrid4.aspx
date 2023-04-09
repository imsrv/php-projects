<!-- Chapter3/DataGrid4.aspx -->
<%@ Page Language="VB" Debug="true" %>
<%@ Import Namespace="System.Data" %>
<%@ Import Namespace="System.Data.OleDb" %>
<script language="VB" Debug="true" runat="server">
Sub Page_Load(Source As Object, E As EventArgs)
 If Not IsPostBack Then
  	bindDataGrid
 End If
End Sub
Sub bindDataGrid
   Dim myConn As OleDbConnection
   Dim myOleDbAdapter As OleDbDataAdapter
   Dim connStr, sqlStr As String
   Dim myDataSet As New Dataset
   connStr="Provider=Microsoft.Jet.OLEDB.4.0; " _
                + "Data Source=D:\Products.mdb"
   
   sqlStr = "SELECT  ProductId, ProductName, Price " _
              +   " FROM Products ORDER BY ProductId"
   myConn= New OleDbConnection(connStr)
   myConn.Open()
   myOleDbAdapter =New OleDbDataAdapter(sqlStr,myConn)
   myOleDbAdapter.Fill(myDataSet,"dtProducts")
   dataGrid1.DataSource = myDataSet.Tables("dtProducts")
   dataGrid1.DataBind()
   myConn.Close()
 End Sub
 Sub doPaging(s As Object, e As DataGridPageChangedEventArgs)
     dataGrid1.CurrentPageIndex = e.NewPageIndex
     bindDataGrid
  End Sub
</script>
<html><head></head><form runat="server">
<asp:DataGrid runat="server" id="dataGrid1"
     AutoGenerateColumns="true"
     AllowPaging="true"
     PageSize="5"
     PagerStyle-HorizontalAlign="Center"
     OnPageIndexChanged="doPaging"
     BackColor="White"
     BorderWidth="1px" BorderStyle="Solid" 
     Width="100%"
     BorderColor="Salmon"
     CellPadding="2" CellSpacing="0"
     Font-Name="Verdana" Font-Size="8pt">
    <HeaderStyle Font-Size="8" Font-Names="Arial" 
             Font-Bold="True" BackColor="Yellow"
             HorizontalAlign="center">
    </HeaderStyle> 
    <AlternatingItemStyle BackColor="Beige"/>
</asp:DataGrid>
</center></form></html>
	