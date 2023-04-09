<!-- Chapter8\DataSet2.aspx -->
<%@ Page Language = "VB"  Debug ="True" %>
<%@ Import Namespace="System.Xml" %>
<%@ Import Namespace="System.Data" %>
<%@ Import Namespace="System.IO" %>
<%@ Import Namespace="System.Data.SqlClient" %>

<html><head></head><body><form runat="server">
 <b>Products Data  From XML File:</b> <br/><br/>
<asp:DataGrid id="myGrid"  runat="server"/><br/><br/>
</body></form></html>

<Script Language="vb" runat="server">

Sub Page_Load(s As Object, e As EventArgs)
    If Not Page.IsPostBack Then
         Dim myDataSet As New DataSet("myXMLProduct")
         Dim myFs As New FileStream(Server.MapPath("myXMLData.xml"),FileMode.Open,FileShare.ReadWrite)
         myDataSet.ReadXml(myFs)
         myGrid.DataSource=myDataSet.Tables(0)
         myGrid.DataBind
         myFs.Close
         
    End If
End Sub
</Script>
