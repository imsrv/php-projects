<!-- MyAspNets\Simple\Validator1.aspx -->
<!-- Mesbah U. Ahmed -->
<!-- Required Filed Validator -->
<html><head></head>
<title>Example on RequiredFieldValidator</title><body><form runat="server"><br>
Enter Your Name:
<asp:TextBox id="txtName" rows="1 " width="50" 
           runat="server"/>
<asp:RequiredFieldValidator id="validTxtName" 
         runat="server" 
         controlToValidate="txtName"
         errorMessage="Name must be entered"
         display = "static">
</asp:RequiredFieldValidator></br>
Hours worked?
<asp:TextBox id="txtH" width ="30"
	   runat="server" />
<asp:RequiredFieldValidator id="validTxtH" 
         runat="server" 
         controlToValidate="txtH"
         errorMessage="Hours must be entered"
         display = "static">
</asp:RequiredFieldValidator></br>
<asp:Button id="btnSubmit" runat="server" 
                 text="Submit"  />
</form></body></html>
