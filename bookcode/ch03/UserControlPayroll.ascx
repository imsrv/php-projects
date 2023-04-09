<!-- AspNet/UserControls/UserControlPayroll.ascx -->
<table border='2' bordercolor="blue">
<tr><td>
Here is a title that is loaded from the parent Form: <br/>
<asp:Label id="lblTitle" backcolor="yellow" Height=15 runat="server"/> <br/>
How many hours have you worked?
<asp:TextBox id="txtH" rows="1 " width="50"  runat="server"/></br>
Your Hourly Rate? <asp:TextBox id="txtR" rows="1" width="80" runat="server" /></br>
<asp:Button id="btnCompute" runat="server" text="Compute Pay" onclick="computePay" />
<p/><asp:Label id="lblPayMsg" runat="server" />
<asp:Label id="lblPay" runat="server" /><br/>
</tr></td></table>
<script language=vb runat="server">

Public Property  Title() As String
	Set
	  lblTitle.Text=value
	End Set
	Get 
		return lblTitle.Text
	End Get
End Property

Private grWage As Single
Public  ReadOnly Property grossWage() As Single
	Get
		return cSng(lblPay.Text)
	End Get
End Property

Protected Sub computePay (Sender As Object, E As EventArgs)
        Dim h As Single
        Dim r As Single
        Dim g As Single
        h = CSng(txtH.Text)
        r = CSng(txtR.Text)
        lblPayMsg.Text = "Your Gross Wage is : "
        g = h * r
        lblPay.Text=FormatCurrency(g)
        grWage = g
 End Sub 
 </script>