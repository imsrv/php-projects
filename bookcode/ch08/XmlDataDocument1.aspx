<!-- Aspbook\Chapter8\xmlDataDocument1.aspx -->
<%@ Page Language = "VB"  Debug ="True" %>
<%@ Import Namespace="System.Xml" %>
<html><head></head><body><form runat="server">
Select a Product: <br/>
<asp:ListBox id="lstProducts" runat="server" rows = "2" /><br/><br/>
</body></form><html>
<Script Language="vb" runat="server">
Sub Page_Load(s As Object, e As EventArgs)
    If Not Page.IsPostBack Then
	 	Dim myDataDoc As New XmlDataDocument()
	  	myDataDoc.Load(Server.MapPath("Catalog2.xml"))
	 	Dim productNames As XmlNodeList
	 	productNames= myDataDoc.GetElementsByTagName("ProductName")
	 	Dim x As XmlNode
	 	For Each x In productNames
			 lstProducts.Items.Add (x.FirstChild().Value)
		Next
	End If
End Sub
</Script>
				