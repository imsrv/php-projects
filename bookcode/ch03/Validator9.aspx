<!-- MyAspNets\Simple\Validator9.aspx -->
<%@ Page Language="VB" Debug="true" %>
<html><head</head>
<title>Example on Validating Patterned Strings, Passwords and Dates </title>
<body>
<form runat="server">
Phone Number? (ddd)ddd-dddd or dd.dd.dd.dd &nbsp;
<asp:TextBox id="txtPhone" rows="1 " width="100" 
           runat="server"/>
           
<asp:RequiredFieldValidator id="validTxtName" 
         runat="server" 
         controlToValidate="txtPhone"
         errorMessage="Name must be entered"
         display = "dynamic">
</asp:RequiredFieldValidator>

<asp:RegularExpressionValidator id="regvPhone"
         runat="server"
         display = "dynamic"
         controlToValidate = "txtPhone"
         errorMessage="Incorrect Phone Number"
         validationExpression=
            "(\(\d{3}\)\d{3}\-\d{4})|(\d{2}\.\d{2}\.\d{2}\.\d{2})">
 </asp:RegularExpressionValidator></br>
 
Date of Birth? (mm/dd/yyyy) :
  <asp:TextBox id="txtDateOfBirth" rows="1 " 
           width="100" runat="server"/>
           
 <asp:RangeValidator id="ranvDob" runat="server"     	
 	  type = "Date" display = "dynamic"
          controlToValidate = "txtDateOfBirth"
          errorMessage=
           "Must be within 1/1/1940 and 12/1/1985"
          minimumValue="1/1/1940"	
          maximumValue="12/1/1985">
</asp:RangeValidator></br>

Hire Date?
<asp:TextBox id="txtDateHired" rows="1 " 
          width="100" runat="server"/>
         <asp:CompareValidator id="compDateHired"
		          runat="server"  display = "dynamic"
		          controlToValidate = "txtDateHired"
		          controlToCompare = "txtDateOfBirth"
		          errorMessage="Hire Date must be after Date of Birth"
		          type = "String"
		          operator="GreaterThan">
        </asp:CompareValidator><br/>
        
 <asp:RangeValidator id="ranvDateHired"
    runat="server" type = "Date"
    display = "dynamic" 
    controlToValidate = "txtDateHired"
    errorMessage="Hire date must be before 6/1/2001" 
    minimumValue="1/1/1900"
    maximumValue="6/15/2001" >
</asp:RangeValidator><br/>

Password? 
<asp:TextBox id="txtPassword" textmode="password"  
         width="100" runat="server"/><br/>
         
Confirm Password:  
<asp:TextBox id="txtConfirmPassword" textMode="password" width="100"
	runat="server" />
	
<asp:CompareValidator id="comvConfirmPassword"
         runat="server"  display = "static"
         controlToValidate = "txtConfirmPassword"
         controlToCompare = "txtPassword"
         errorMessage="Both passwords must be same"
         type = "String"
         operator="Equal">
</asp:CompareValidator><br/>
                    
<asp:Button id="btnSubmit" runat="server" 
                 text="Submit"  /></br></br></br>
 </form></body></html>
