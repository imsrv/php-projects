<!-- Chapter8/XPathDoc1.aspx -->
<%@ Page Language="VB" Debug="True"%>
<%@ Import Namespace="System.Xml"%>
<%@ Import Namespace="System.Xml.XPath"%>
<%@ Import Namespace="System.Xml.Xsl"%>
<html><head></head><body>
<form runat="server"><h4>
Query Examples</h4>
Customers From Ohio:<br/>
<asp:ListBox id="lstName1" runat="server" width="150" rows="4"/>&nbsp;&nbsp;
<br/><br/>
<asp:Button id="cmdDetails" Text="Populate the ListBox" runat="server" 
                   onClick="showNames"/><br/>
</form></body></html>
<Script Language="vb" runat="server">
 Sub showNames(s As Object, e As EventArgs)
     Dim Doc As New XPathDocument(Server.MapPath("Bank2.xml"))
     Dim myNav As XPathNavigator
     myNav=Doc.CreateNavigator()
     Dim myIter As XPathNodeIterator
     'myIter=myNav.Select("descendant::Account[child::State='OH']/Name")
     myIter=myNav.Select("Bank/Account[child::State='OH']/Name") 
     While (myIter.MoveNext())
        lstName1.Items.Add(myIter.Current.Value)
     End While
     
     
    
     
  End Sub
</Script>
