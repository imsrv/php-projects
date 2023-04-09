<!-- Chapter3\BasicServerControls1.aspx -->
<html><head</head><body>
<form runat="server">
How many hours have you worked?
<asp:TextBox id="txtH" rows="1 " width="50" 
           runat="server"/></br>
Your Hourly Rate?
 <asp:TextBox id="txtR" rows="1" width="80" 
          runat="server" /></br>
 </br>Please select one of the following:</br>
 <asp:RadioButton id="rbtnNoCov" 
          groupName = "rgrInsurance"
          text="No Insurance Coverage"
          checked="true"
          runat = "server"/> &nbsp;
   <asp:RadioButton id="rbtnFamCov" 
          groupName = "rgrInsurance"
          text="Family Coverage" 
          runat = "server"/></br>
 </br> Which of the company facilities do you use?
 </br><asp:CheckBox id="chkPark" 
                   text="Parking" runat="server"/>&nbsp
  <asp:CheckBox id="chkPool" 
                   text="Swimming Pool" runat="server"/>
  </br></br>Select your employee status: &nbsp;
  <asp:DropDownList id="ddLStatus" runat="server">
         <asp:ListItem> White Collar</asp:ListItem>
        <asp:ListItem> Workhorse</asp:ListItem>
</asp:DropDownList></p>
<asp:Button id="btnCompute" runat="server" 
                 text="Compute Pay" onclick="computePay" />
</br></br>
<asp:Label id="lblPayMsg" runat="server" />
<asp:Label id="lblPay" runat="server" /></br>
<asp:Label id="lblInsMsg" runat="server" />
<asp:Label id="lblInsCharge" runat="server" /> </br>
<asp:Label id="lblFacilityMsg" runat="server" />
<asp:Label id="lblFacilityCharge" runat="server" /></br>
<asp:Label id="lblBonusMsg" runat="server" />
<asp:Label id="lblBonusPay" runat="server" /> </br>
<asp:Label id="lblNetWageMsg" runat="server" />
<asp:Label id="lblNetWage" runat="server" />
</form></body></html>
<script language=vb runat="server">
  Sub computePay (Sender As Object, E As EventArgs)
        Dim h, r, g, netWage, insCharge As Single 
        Dim facilityCharge, bonus As Single
        h = CSng(txtH.Text)
        r = CSng(txtR.Text)
        lblPayMsg.Text = "Your Gross Wage is : "
        g = h * r
        ' Compute Insurance Deduction
        If rbtnNoCov.Checked Then
            insCharge=0
        Else 
            insCharge = 40.00
        End If
       ' Compute Facility Usage Charge 
        facilityCharge=0
        If chkPark.Checked Then
           facilityCharge += 15   ' Parking
        End If
        If chKPool.Checked Then
           facilityCharge += 10   ' Swimming Pool
        End If
        ' Compute Bonus
        Select Case ddlStatus.SelectedIndex
            Case 0
                 bonus = 100.00 ' White Collar
            Case 1
                 bonus =  65.88 ' Workhorse
        End Select
        netWage = g + bonus - insCharge - facilityCharge
        lblPay.Text=FormatCurrency(g)
        lblInsMsg.Text="Your Insurance Deduction is :"
        lblInsCharge.Text = FormatCurrency(insCharge)
        lblFacilityMsg.Text= "Your Facility Usage Charge is :"
        lblFacilityCharge.Text = FormatCurrency(facilityCharge)
        lblBonusMsg.Text = "Your Bonus Pay is : "
        lblBonusPay.Text = FormatCurrency(bonus)
        lblNetWagemsg.Text = "Your Net Wage is :"
        lblNetWage.Text = FormatCurrency(netWage)
  End Sub 
</script>