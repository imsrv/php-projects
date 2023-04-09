<!-- Chapter8/XPathDoc2.aspx -->
<%@ Page Language="VB" Debug="True"%>
<%@ Import Namespace="System.Xml"%>
<%@ Import Namespace="System.Xml.XPath"%>
<%@ Import Namespace="System.Xml.Xsl"%>
<html><head></head><body>
<form runat="server"><h4>
Balance Inquiry Screen</h4>
Select an Account Number:
<asp:DropdownList id="cboAcno" runat="server" width="100" />&nbsp;&nbsp;
<br/><br/>
Balance from Account Number Search:&nbsp;
<asp:Textbox id="txtBalance1" runat="server" width="80" />&nbsp;&nbsp;
<br/><br/><hr/>

Select an Customer Name:
<asp:DropdownList id="cboName" runat="server" width="110" />&nbsp;&nbsp;
<br/><br/>
Balance from Customer Name Search :&nbsp;
<asp:Textbox id="txtBalance2" runat="server" width="80" />&nbsp;&nbsp;
<br/><br/>

<asp:Button id="cmdDetails" Text="Show Balances" runat="server" 
                   onClick="showNames"/><br/>
</form></body></html>
<Script Language="vb" runat="server">
 
 Sub Page_Load(s As Object, e As EventArgs)
  If Not Page.IsPostBack Then
      Dim myDoc As New XPathDocument(Server.MapPath("Bank3.xml"))
      Dim myNav As XPathNavigator
      myNav=myDoc.CreateNavigator()
      Dim myIter As XPathNodeIterator
      ' Populate the DropDownList with Account Number values
       myIter=myNav.Select("//@*")  ' Load all attributes
      While (myIter.MoveNext())
         cboAcno.Items.Add(myIter.Current.Value)
      End While
     
     ' Populate the  DropDown list with the name values
     myIter=myNav.Select("/Bank/Account/Name") 
     While (myIter.MoveNext())
              cboName.Items.Add(myIter.Current.Value)
     End While
 End If    
 End Sub
 
 
 Sub showNames(s As Object, e As EventArgs)
   'Get the value of the selected Item
   Dim accNo As String = cboAcno.SelectedItem.Text.Trim()
   Dim accName As String = cboName.SelectedItem.Text.Trim()

   Dim myDoc As New XPathDocument(Server.MapPath("Bank3.xml"))
   Dim myNav As XPathNavigator
   myNav=myDoc.CreateNavigator()
   Dim myIter As XPathNodeIterator
  
  '  Query to get the balance from AccountNo
   myIter=myNav.Select("Bank/Account[@AccountNo='"+accNo+"']/Balance")  
   myIter.MoveNext()
   'Display the values of  Balance
    txtBalance1.Text=FormatCurrency(myIter.Current.Value)
      
   ' Query to get the balance from Name
    myIter=myNav.Select("descendant::Account[child::Name='"+accName+"']/Balance") 
    myIter.MoveNext()
    'Display the values of  Balance
    txtBalance2.Text=FormatCurrency(myIter.Current.Value)

     
 End Sub
</Script>
