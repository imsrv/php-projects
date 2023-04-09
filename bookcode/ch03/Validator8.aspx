<!-- MyAspNets\Simple\Validator8.aspx -->
<!-- Mesbah U. Ahmed -->
<%@ Page Language="VB" Debug="true" %>
<html><head</head>
<title>Example on ValidationSummary control </title>
<body><form runat="server">
Enter Your Name:
<asp:TextBox id="txtName" rows="1 " width="100" 
           runat="server"/>
<asp:RequiredFieldValidator id="validTxtName" 
         runat="server" 
         controlToValidate="txtName"
         errorMessage="Name must be entered"
         display = "static">*
</asp:RequiredFieldValidator><br>
Hours worked?
<asp:TextBox id="txtH" width ="60"
	   runat="server" />
<asp:RequiredFieldValidator id="validTxtH" 
         runat="server" 
         controlToValidate="txtH"
         errorMessage="Hours must be entered"
         display = "static">*
</asp:RequiredFieldValidator>
<asp:RegularExpressionValidator id="regvH"
         runat="server"
         display = "static"
         controlToValidate = "txtH"
         errorMessage="Hours must be 1-3 digits only"
         validationExpression="\d{1,3}">*
</asp:RegularExpressionValidator></br>
Hourly Rate?          
<asp:TextBox id="txtR" width ="60"
	   runat="server" />
<asp:CompareValidator id="comvR"
         runat="server"
         display = "static"
         controlToValidate = "txtR"
         errorMessage="Rate must be numeric"
         type = "Double"
         operator="DataTypeCheck">*
</asp:CompareValidator></br>
Number of Dependents: 
<asp:TextBox id="txtDependents" width ="60"
	   runat="server" />
<asp:RangeValidator id="ranvDependents"
         runat="server"     	backcolor="salmon" 
         forecolor = "blue"	bordercolor="green" 
	 borderstyle="Solid"	borderwidth="5" 
	 font-bold="True" 	font-italic="True" 
	 font-size="14" 	height="20" 
	 tooltip="Cannot have more than 20 dependents." 
	 text="Bad Number. Must be less than 21" 
	 width="250"          display = "dynamic"
         controlToValidate = "txtDependents"
         errorMessage=
          "Number of dependents must be from 0 to 20"
         type = "Integer" 	minimumValue="0"	
         maximumValue="10">*
</asp:RangeValidator><br>
What is your Department Number?
<asp:TextBox id="txtDeptNum" width ="60"
	   runat="server" />
<asp:CustomValidator id="cusvDeptNum"
         runat="server"
         display = "dynamic"
         controlToValidate = "txtDeptNum"
         onServerValidate = "validateDeptNum"
         ClientValidationFunction = "checkModTen"
         errorMessage=
            "Dept. Number must be a multiple of 10" >* 
         </asp:CustomValidator><br>
<asp:Button id="btnSubmit" runat="server" 
                 text="Submit"  /><br>
 <asp:ValidationSummary id="valSummary"
          runat="server"
          headerText="Please correct the following errors"
          display = "static"
          showSummary= "True" /></br>
 </br>
 </form></body></html>
<script language="VB" runat="server">
Sub validateDeptNum _ 
      (source As Object, s as ServerValidateEventArgs) 
  If (CInt(s.Value) Mod 10) = 0 Then
     s.IsValid= True
  Else
    s.IsValid =False
  End If
End Sub
</script>
<script language="javascript">
function checkModTen(source, s)
{  

	var y = parseInt(s.Value);
    if (isNaN(y) && !((y % 10) == 0)) 
         s.IsValid=false;
    else
        s.IsValid=true;
}
</script>
