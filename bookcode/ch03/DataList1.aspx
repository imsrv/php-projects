<!-- Chapter3\DataList1.aspx -->
<%@ Import Namespace="System.Data" %>
<%@ Import Namespace="System.Data.OleDb" %>
<html><head></head>
<script language="VB" Debug="true" runat="server">
Sub Page_Load(src As Object, e As EventArgs)
  If Not IsPostBack Then
    bindListControl
  End If
End Sub
Sub bindListControl()
Dim myConn As OleDbConnection
	Dim myOleDbAdapter As OleDbDataAdapter
	Dim connStr, sqlStr As String
	Dim myDataSet As New Dataset
	connStr="Provider=Microsoft.Jet.OLEDB.4.0;Data Source=D:\Products.mdb"
	sqlStr = "SELECT ProductId, ProductName, Price, ImagePath " _
	              +   "FROM Products ORDER BY Price"
	myConn= New OleDbConnection(connStr)
	myConn.Open()
	myOleDbAdapter =New OleDbDataAdapter(sqlStr,myConn)
  	myOleDbAdapter.Fill(myDataSet,"dtProducts")
	dataList1.DataSource=myDataSet.Tables("dtProducts")
	dataList1.DataBind()
End Sub
</script>
<body bgcolor="white">
<asp:DataList id="dataList1" border=0
    RepeatDirection="Horizontal" RepeatColumns="3" runat="server">
 <ItemTemplate><table><tr>
    <td> <asp:Image  height=80 width=80
         ImageURL='<%# Container.DataItem("ImagePath") %>'
         runat="server" />
    </td></tr><tr>
    <td> Product ID: 
       <%# Container.DataItem("ProductId")%><br/>
       Description:<b><i><%# Container.DataItem("ProductName")%> 
       </b></i><br/><b>Unit Price: $
       <%# Container.DataItem("Price")%></b><br/>
     </td></tr></table>
 </ItemTemplate>
</asp:DataList></body></html> 
           
	