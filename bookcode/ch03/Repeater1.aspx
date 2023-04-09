<!-- Chapter3/Repeater1.aspx -->
<%@ Import Namespace="System.Data" %>
<%@ Import Namespace="System.Data.OleDb" %>
<html><head></head>
<script language="VB" Debug="true" runat="server">
Sub Page_Load(src As Object, e As EventArgs)
    If Not IsPostBack
       bindListControl
    End If
End Sub
Sub bindListControl()
    Dim myConn As OleDbConnection
  	Dim myOleDbAdapter As OleDbDataAdapter
  	Dim connStr, sqlStr As String
  	Dim myDataSet As New Dataset
  	connStr="Provider=Microsoft.Jet.OLEDB.4.0;" _ 
  	            + "Data Source=D:\Products.mdb"
    sqlStr = "SELECT ProductId, ProductName, Price, ImagePath " _
              +  "FROM Products WHERE Price>45.00 ORDER BY Price"
    myConn= New OleDbConnection(connStr)
  	myConn.Open()
  	myOleDbAdapter =New OleDbDataAdapter(sqlStr,myConn)
  	myOleDbAdapter.Fill(myDataSet,"dtProducts")
	repeater1.DataSource = myDataSet.Tables("dtProducts")
    repeater1.DataBind()
End Sub
</script>
<body><h2><center>
Cathy's E-Shop</h2>
<asp:Repeater id="repeater1" runat="server" >
     <HeaderTemplate><table></HeaderTemplate>
     <ItemTemplate><tr>
        <td> <asp:Image height=100 width=100
                   Img src = '<%# Container.DataItem("ImagePath") %>'
                   runat="server" />
       </td>
       <td> Product ID: 
                <%# Container.DataItem("ProductId") %> <br/>
                Description: <b><i>
                <%# Container.DataItem("ProductName") %> </b></i><br/>
                <b>Unit Price: 
                <%# FormatCurrency(Container.DataItem("Price")) %> </b> <br/>
       </td></tr>
     </ItemTemplate>
     <FooterTemplate>
         </table>
      </FooterTemplate>
 </asp:Repeater>
 </center></body></html>
 
           
	