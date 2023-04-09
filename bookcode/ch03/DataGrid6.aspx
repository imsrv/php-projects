<!-- Chapter3/DataGrid6.aspx -->
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
              +   " FROM Products WHERE Price > 40 ORDER BY ProductId"
   myConn= New OleDbConnection(connStr)
   myConn.Open()
   myOleDbAdapter =New OleDbDataAdapter(sqlStr,myConn)
   myOleDbAdapter.Fill(myDataSet,"dtProducts")
   dataGrid1.DataSource = myDataSet.Tables("dtProducts")
   dataGrid1.DataBind()
   myConn.Close()
 End Sub
 Sub setEditMode(s As Object, e As DataGridCommandEventArgs)
     dataGrid1.EditItemIndex= e.Item.ItemIndex
     bindDataGrid
  End Sub
  Sub cancelEdit(s As Object, e As DataGridCommandEventArgs)
     dataGrid1.EditItemIndex = -1
     bindDataGrid
  End Sub
  Sub updateDatabase(s as Object, e As DataGridCommandEventArgs)
  	Dim myConn As OleDbConnection
  	Dim connStr, sqlStr, strPName  As String
  	Dim myUpdateCommand As OleDbCommand
   	Dim intPid As Integer
  	Dim dblPrice As Double
   	intPid = dataGrid1.DataKeys.Item(e.Item.ItemIndex)
   	strPName = (CType(e.Item.Cells(2).Controls(0), Textbox)).Text
  	dblPrice=cDbl((CType(e.Item.Cells(3).Controls(0), Textbox)).Text)
  	sqlStr = "UPDATE Products SET ProductName = ' " + strPName _
  	            +  " ', Price = "  + dblPrice.ToString _ 
  	            + " WHERE ProductID = " + intPid.ToString
  
  	connStr="Provider=Microsoft.Jet.OLEDB.4.0; " _
                + "Data Source=D:\Products.mdb"
    myConn= New OleDbConnection(connStr)
    myConn.Open()
  	myUpdateCommand = New OleDbCommand(sqlStr, myConn)  
  	myUpdateCommand.ExecuteNonQuery
  	myConn.Close()
  	dataGrid1.EditItemIndex=-1
  	BindDataGrid
  End Sub
</script>
<html><head></head><form runat="server">
<asp:DataGrid 
     id="dataGrid1"
     AutoGenerateColumns="False"
     DataKeyField="ProductId"
     OnEditCommand="setEditMode"
     OnCancelCommand="cancelEdit"
     OnUpdateCommand="updateDataBase"
     CellPadding="2" 
	 Font-Name="Verdana" Font-Size="8pt"
     runat="server" >
     <HeaderStyle Font-Size="8" Font-Names="Arial" 
	              Font-Bold="True" BackColor="Yellow"
	              HorizontalAlign="center">
    </HeaderStyle> 
    <Columns>
      <asp:EditCommandColumn 
           EditText="Edit"
           UpdateText="Update"
           CancelText="Cancel">
      </asp:EditCommandColumn>
      <asp:BoundColumn HeaderText="Product ID"
	        DataField="ProductId"
	        ReadOnly="True"
	    />
	  <asp:BoundColumn HeaderText="Description"
                  DataField="ProductName"/>
      <asp:BoundColumn HeaderText="Unit Price"  
	              DataField="price" 
	              DataFormatString="{0:c}" />
	  </Columns>   
</asp:DataGrid>
</form></html>
	