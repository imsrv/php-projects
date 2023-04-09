<!-- Aspbook\Chapter8\xmlTextReader2.aspx -->
<%@ Page Language = "VB"  Debug ="True" %>
<%@ Import Namespace="System.Xml" %>
<html><head></head><body><form runat="server">
Select a Product: <br/>
<asp:ListBox id="lstProducts" runat="server" rows = "2" /><br/><br/>
Quantity Desired: 
<asp:TextBox id="txtQty" runat="server" text="1" width="40" /> <br/>
<asp:Button id="cmdShowPrice" Text= "Show Price" 
 					runat="server" onclick="showPrice" /><br/><br/>
<asp:Label id="lblPrice"  runat="server" /> <br/>
<asp:Label id="lblAmount"  runat="server" /> <br/>
</body></form><html>
<Script Language="vb" runat="server">
Sub Page_Load(s As Object, e As EventArgs)
    If Not Page.IsPostBack Then
	Dim myRdr As New XmlTextReader(Server.MapPath("Catalog2.xml"))
	While myRdr.Read() 
		If  XmlNodeType.Element
			If myRdr.Name="ProductName" Then
				myRdr.Read()  ' go to its text node
				lstProducts.Items.Add(myRdr.ReadString)
			End If
		End If	
	End While
	myRdr.Close()
   End If
End Sub
Sub showPrice(s As Object, e As EventArgs)
   	Dim myRdr2 As New XmlTextReader(Server.MapPath("Catalog2.xml"))
   	Dim unitPrice As Double
	Dim qty AS Integer
	Do While Not myRdr2.EOF() 
		If (myRdr2.MoveToContent() = XmlNodeType.Element _ 
					And myRdr2.Name ="ProductName" _ 
	             	And myRdr2.ReadString()=lstProducts.SelectedItem.ToString()) 
	               	myRdr2.Read()
	       		If (myRdr2.MoveToContent() = XmlNodeType.Element _ 
	       		                              And myRdr2.Name ="ListPrice")
                    unitPrice=Double.Parse(myRdr2.ReadString())
                    lblPrice.Text= "Unit Price = " + FormatCurrency(unitPrice)
					Exit Do
		       End If
		End If
	 	myRdr2.Read() 
	Loop
	qty = Integer.Parse(txtQty.Text)
	lblAmount.Text = "Amount Due = " + FormatCurrency(qty * unitPrice)
	myRdr2.Close()
End Sub
</Script>
				