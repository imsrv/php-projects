<!-- Aspbook\Chapter8\xmlDataDocDataSet1.aspx -->
<%@ Page Language = "VB"  Debug ="True" %>
<%@ Import Namespace="System.Xml" %>
<%@ Import Namespace="System.Data" %>
<html><head></head><body><form runat="server">
Select a Product: <br/>
<asp:DataGrid id="myGrid"  runat="server"/>
</body></form></html>
<Script Language="vb" runat="server">
Sub Page_Load(s As Object, e As EventArgs)
    If Not Page.IsPostBack Then
	 	Dim myDataDoc As New XmlDataDocument()
	 	' load the schema
	 	myDataDoc.DataSet.ReadXmlSchema(Server.MapPath("Catalog3Schema.xsd"))
	 	' load the xmldata
	  	myDataDoc.Load(Server.MapPath("Catalog3.xml"))
	    myGrid.DataSource = myDataDoc.DataSet.Tables(0)          
	    myGrid.DataBind()
     End If
End Sub
</Script>
				