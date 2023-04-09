<!-- Aspbook\Chapter8\XmlDom1.aspx -->
<%@ Page Language = "VB"  Debug ="True" %>
<%@ Import Namespace="System.Xml" %>
<html><head></head><body><form runat="server">
Select a Product: <br/>
<asp:ListBox id="lstProducts" runat="server" rows = "2" /><br/><br/>
Quantity Desired: 
<asp:TextBox id="txtQty" runat="server" text="1" width="40" /> <br/>
<asp:Button id="cmdShowPrice" Text= "Show Price" 
 					runat="server" onclick="showPrice" /><br/><br/>
Unit Price : <asp:Label id="lblPrice"  runat="server" /> <br/>
Amount Due: <asp:Label id="lblAmount"  runat="server" /> <br/>
</body></form><html>
<Script Language="vb" runat="server">
Private Sub Page_Load(s As Object,  e As EventArgs)
        If Not Page.IsPostBack Then
            Dim myDoc As New XmlDocument()
            Dim myRdr As New XmlTextReader(Server.MapPath("Catalog2.xml"))
            myRdr.WhitespaceHandling = WhitespaceHandling.None
            myDoc.Load(myRdr)
            Session("sessionDoc") = myDoc
            Dim i As Integer
            For i = 0 To myDoc.DocumentElement.ChildNodes.Count - 1
                lstProducts.Items.Add _
                        (myDoc.DocumentElement.ChildNodes(i).ChildNodes(1).InnerText)
            Next i
            myRdr.Close()
        End If
    End Sub
    Private Sub showPrice(s As Object,  e As EventArgs)
        Dim i As Integer
        Dim qty As Integer = 1
        Dim price As Double
        Dim myDoc As New XmlDocument()
        myDoc = Session("sessionDoc")
        i = lstProducts.SelectedIndex  ' The Row number selected
        qty = Integer.Parse(txtQty.Text)
        price = Double.Parse _
                     (myDoc.DocumentElement.ChildNodes(i).ChildNodes(2).InnerText)
        lblPrice.Text = FormatCurrency(price)
        lblAmount.Text = FormatCurrency(qty * price)
    End Sub
</Script>
				