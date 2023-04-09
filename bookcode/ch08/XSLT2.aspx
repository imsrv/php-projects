<!--Chapter8/XSLT2.aspx-->
<%@ Page Language="VB" Debug="True"%>
<%@ Import Namespace="System.Xml"%>
<%@ Import Namespace="System.Xml.XPath"%>
<%@ Import Namespace="System.Xml.Xsl"%>
<%@Import Namespace="System.IO"%>
<html><head></head><body><form runat="server">
<b>XSL Transformation Example&nbsp;</b><br/>
<asp:ListBox id="lstInitial" runat="server" rows="9" width=250/>&nbsp;&nbsp;&nbsp;
<asp:ListBox id="lstFinal" runat="server" rows="9" width=250/><br/><br/>
<br/><br/>
<asp:Button id="cmdTransform" Text="Transform the XML" runat="server"
                    onClick="showTransformed" />&nbsp;&nbsp;
<asp:Button id="cmdDisplayTgt" Text="Show Transformed XML in IE" runat="server"
                    onClick="showTarget" />
</form></body></html>

<Script Language="vb" runat="server">
 
 Sub Page_Load(sender As Object, e As EventArgs)
    If Not Page.IsPostBack Then
     Dim myDoc As New XPathDocument(Server.MapPath("OrderA.xml"))
     Dim myNav As XPath.XPathNavigator
     Dim myIterator As XPath.XPathNodeIterator
     ' Set nav object
      myNav = myDoc.CreateNavigator()
     ' Iterate through all the attributes of the descendants
      myIterator =myNav.Select("/Order")
      myIterator=myNav.SelectDescendants(XPathNodeType.Element,false)
      myIterator.MoveNext()
      While myIterator.MoveNext()
 	 ' Add the Items to the DropdownList
         lstInitial.Items.Add(myIterator.Current.Name+" :"+myIterator.Current.Value)
     End While
 End If    
 End Sub
 
 Sub showTransformed(sender As Object,e As EventArgs)
   
   ' Load the XML Document
   Dim myDoc As New XPathDocument(Server.MapPath("OrderA.xml"))
   ' Declare the XSLTransform Object
   Dim myXsltDoc As New XSLTransform
   ' Create the filestream to write a XML file
   Dim myfileStream As New FileStream(Server.MapPath("OrderB.xml"),FileMode.Create,FileShare.ReadWrite)
   ' Load the XSL file
   myXsltDoc.Load(Server.MapPath("order.xsl"))
   ' Tranform the XML file according to XSL Document
   myXsltDoc.Transform(myDoc,Nothing,myfileStream)
   myfileStream.Close()
   
   lstFinal.Items.Clear
   
   Dim myDoc2 As New XPathDocument(Server.MapPath("OrderB.xml"))
   Dim myNav As XPath.XPathNavigator
   Dim myIterator As XPath.XPathNodeIterator
    ' Set nav object
    myNav = myDoc2.CreateNavigator()
   ' Iterate through all the attributes of the descendants
    myIterator =myNav.Select("/Order")
    myIterator=myNav.SelectDescendants(XPathNodeType.Element,false)
    myIterator.MoveNext()
    While myIterator.MoveNext()
      ' Add the Items to the DropdownList
      lstFinal.Items.Add(myIterator.Current.Name+" :"+myIterator.Current.Value)
    End While
 End Sub
 
  Sub showTarget(sender As Object,e As EventArgs)
    Response.Redirect(Server.MapPath("OrderB.xml"))
 End Sub
 </Script>
