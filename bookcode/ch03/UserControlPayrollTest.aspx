<!-- Chapter3\UserControlPayrollTest.aspx -->
<!-- Uses the UserControlPayroll.ascx -->
<%@ Register tagprefix="usrCtrlPayroll" Tagname="payroll" src="UserControlPayroll.ascx" %>
<html><head</head>
<title>Example on User Controls</title>
<body>
<form runat="server">
Hello there, here we are in our main page. 
Now, let us instantiate the payroll user control <br>
<usrCtrlPayroll:payroll id="usrPayCtrl" runat="server" Title="University of Toledo	" />
<br>
<asp:Button id="btnShowTax" runat="server" text="Show Tax" onclick="computeTax" />
<br><asp:Label id="lblTaxMsg" runat="server" />
<asp:Label id="lblTax" runat="server" /><br>
</form></body></html>
<script language=vb runat="server">

  Sub computeTax (Sender As Object, E As EventArgs)
        Dim t As Single
        Dim gWage As Single
        gWage = usrPayCtrl.grossWage()
        t = gWage * 0.10
        lblTaxMsg.Text = "Your Tax  is : " 
        lblTax.Text=FormatCurrency(t)
 End Sub 
 </script>