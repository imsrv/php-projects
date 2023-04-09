<!-- Chapter8\xmlDataDocDataSet2.aspx -->
<%@ Page Language = "VB"  Debug ="True" %>
<%@ Import Namespace="System.Xml" %>
<%@ Import Namespace="System.Data" %>
<html><head></head><body><form runat="server">
Customers : <br/>
<asp:DataGrid id="myCustGrid"  runat="server"/><br/>
Accounts : <br/>
<asp:DataGrid id="myAcctGrid"  runat="server"/><br/>
</body></form></html>
<Script Language="vb" runat="server">
Sub Page_Load(s As Object, e As EventArgs)
    If Not Page.IsPostBack Then
	 Dim myDataDoc As New XmlDataDocument()
	 ' load the schema
	 myDataDoc.DataSet.ReadXmlSchema(Server.MapPath("Bank1.xsd"))
	 ' load the xmldata
	  myDataDoc.Load(Server.MapPath("Bank1.xml"))
	  myCustGrid.DataSource = myDataDoc.DataSet.Tables("Customer")          
	  myCustGrid.DataBind()
	  'load the Account grid
	  myAcctGrid.DataSource = myDataDoc.DataSet.Tables("Account")          
	  myAcctGrid.DataBind()
     End If
End Sub
</Script>
				