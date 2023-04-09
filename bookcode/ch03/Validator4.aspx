<!-- MyAspNets\Simple\Validator4.aspx -->
<!-- Mesbah U. Ahmed -->
<%@ Page Language="VB" Debug="true" %>
<html><head</head>
<title>Example on RegularExpressionValidator</title>
<body>
<form runat="server">
Enter Your Name:
<asp:TextBox id="txtName" rows="1 " width="60" 
           runat="server"/>
<asp:RequiredFieldValidator id="validTxtName" 
         runat="server" 
         controlToValidate="txtName"
         errorMessage="Name must be entered"
         display = "static">
</asp:RequiredFieldValidator></br>
Hours worked?
<asp:TextBox id="txtH" width ="40"
	   runat="server" />
<asp:RequiredFieldValidator id="validTxtH" 
         runat="server" 
         controlToValidate="txtH"
         errorMessage="Hours must be entered"
         display = "static">
</asp:RequiredFieldValidator>
<asp:RegularExpressionValidator id="regvH"
         runat="server"
         display = "static"
         controlToValidate = "txtH"
         errorMessage="Hours must be 1-3 digits only"
         validationExpression="\d{1,3}">
</asp:RegularExpressionValidator></br>
Hourly Rate?          
<asp:TextBox id="txtR" width ="40"
	   runat="server" />
<asp:CompareValidator id="comvR"
         runat="server"
         display = "static"
         controlToValidate = "txtR"
         errorMessage="Rate must be numeric"
         type = "Double"
         operator="DataTypeCheck">
</asp:CompareValidator></br>
Number of Dependents: 
<asp:TextBox id="txtDependents" width ="40"
	   runat="server" />
<asp:RangeValidator id="ranvDependents"
         runat="server"
         display = "static"
         controlToValidate = "txtDependents"
         errorMessage="Must be from 0 to 10"
         type = "Integer"
         minimumValue=0
         maximumValue=10>
</asp:RangeValidator></br>
<asp:Button id="btnSubmit" runat="server" 
                 text="Submit"  />
</form></body></html>
