<!—- Chapter3\Validator2.aspx -->
<%@ Page Language="VB" Debug="true" %>
<html><head</head><body>
<form runat="server"><br>
Enter Your Name:
<asp:TextBox id="txtName" rows="1 " width="60"  runat="server"/>
<asp:RequiredFieldValidator id="validTxtName"    runat="server" 
  controlToValidate="txtName" errorMessage="Name must be entered"
  display = "static">
</asp:RequiredFieldValidator></br>
Hours worked?
<asp:TextBox id="txtH" width ="40" runat="server" />
<asp:RequiredFieldValidator id="validTxtH"  runat="server" 
    controlToValidate="txtH"  errorMessage="Hours must be entered"
    display = "static">
</asp:RequiredFieldValidator>
<asp:RegularExpressionValidator id="regvH"
    runat="server"  display = "static"  controlToValidate = "txtH"
    errorMessage="Hours must be 1-3 digits only" 
    validationExpression="\d{1,3}">
</asp:RegularExpressionValidator></br>
<asp:Button id="btnSubmit" runat="server" text="Submit"  />
</form></body></html>
