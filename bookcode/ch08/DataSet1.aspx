<!-- Chapter8\DataSet1.aspx -->
<%@ Page Language = "VB"  Debug ="True" %>
<%@ Import Namespace="System.Xml" %>
<%@ Import Namespace="System.Data" %>
<%@ Import Namespace="System.IO" %>
<%@ Import Namespace="System.Data.SqlClient" %>

<html><head></head><body><form runat="server">
 <b>Cheap Products:</b> <br/><br/>
<asp:DataGrid id="myGrid"  runat="server"/><br/><br/>
<asp:Button id="cmdWriteXML" Text="Create XML File" runat="server"  onclick="writeXML"/>

</body></form></html>

<Script Language="vb" runat="server">

Sub Page_Load(s As Object, e As EventArgs)
    If Not Page.IsPostBack Then
         Dim myDataSet As New DataSet("myXMLProduct")
         Dim myConn As New SqlConnection("server=ora07;uid=sa;pwd=ahmed;database=Northwind")
         Dim mydataAdapter As New SqlDataAdapter("SELECT ProductID,ProductName,UnitPrice FROM Products WHERE UnitPrice <7.00",myConn)
         mydataAdapter.Fill(myDataSet,"dtProducts")
         myGrid.DataSource=myDataSet.Tables(0)
         myGrid.DataBind
         Session("sessDs")=myDataSet
    End If
End Sub

Sub writeXML(s As Object, e As EventArgs)
     Dim myFs1 As New FileStream(Server.MapPath("myXMLData.xml"),FileMode.Create,FileShare.ReadWrite)
      Dim myFs2 As New FileStream(Server.MapPath("myXMLData.xsd"),FileMode.Create,FileShare.ReadWrite)
     Dim myDataSet As New DataSet
     myDataSet=Session("sessDs")
     ' Use the WriteXml method of DataSet object to write an XML file from the DataSet
     myDataSet.WriteXml(myFs1)
     myFs1.Close()
     myDataSet.WriteXmlSchema(myFs2)
     myFs2.Close()

End Sub
</Script>
