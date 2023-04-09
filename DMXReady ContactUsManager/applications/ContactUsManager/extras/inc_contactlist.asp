<!--#include virtual="/Connections/contactusmanager.asp" -->
<%
Dim list_contact
Dim list_contact_numRows

Set list_contact = Server.CreateObject("ADODB.Recordset")
list_contact.ActiveConnection = MM_contactusmanager_STRING
list_contact.Source = "SELECT tblContactUs.*, tblContactUsCategory.*  FROM tblContactUs INNER JOIN tblContactUsCategory ON tblContactUs.CategoryID = tblContactUsCategory.CategoryID  WHERE Activated = 'True'"
list_contact.CursorType = 0
list_contact.CursorLocation = 2
list_contact.LockType = 1
list_contact.Open()

list_contact_numRows = 0
%>
<%
Dim list_contacts_HLooper1__numRows
list_contacts_HLooper1__numRows = -3
Dim list_contacts_HLooper1__index
list_contacts_HLooper1__index = 0
list_contact_numRows = list_contact_numRows + list_contacts_HLooper1__numRows
%>
<script language="JavaScript" type="text/JavaScript">
<!--
function openPictureWindow_Fever(imageName,imageWidth,imageHeight,alt,posLeft,posTop) {
	newWindow = window.open("","newWindow","width="+imageWidth+",height="+imageHeight+",left="+posLeft+",top="+posTop);
	newWindow.document.open();
	newWindow.document.write('<html><title>'+alt+'</title><body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginheight="0" marginwidth="0" onBlur="self.close()">'); 
	newWindow.document.write('<img src='+imageName+' width='+imageWidth+' height='+imageHeight+' alt='+alt+'>'); 
	newWindow.document.write('</body></html>');
	newWindow.document.close();
	newWindow.focus();
}
//-->
</script>

<table width="100%" align="center" class="tableborder">
  <%
startrw = 0
endrw = list_contacts_HLooper1__index
numberColumns = 3
numrows = -1
while((numrows <> 0) AND (Not list_contact.EOF))
	startrw = endrw + 1
	endrw = endrw + numberColumns
 %>
  <tr align="center" valign="top">
    <%
While ((startrw <= endrw) AND (Not list_contact.EOF))
%>
    <td>      <table width="250" border="0" align="center" cellpadding="5" cellspacing="0">
        <tr>
		 <% if list_contact.Fields.Item("ImageFile").Value <> "" then %>
          <td width="20%" valign="top">
		  
            <% if list_contact.Fields.Item("ImageFile").Value <> "" then %>
                     <a href="javascript:;"><img src="images/<%=(list_contact.Fields.Item("ImageFile").Value)%>" alt="Click to Zoom" border="0" onClick="openPictureWindow_Fever('images/<%=(list_contact.Fields.Item("ImageFile").Value)%>','400','400','<%=(list_contact.Fields.Item("ImageFile").Value)%>','','')"></a>
			      <% end if%>
</td>
		  <%end if%>
          <td width="80%" height="82" valign="top">
            <% If list_contact.Fields.Item("Salutation").Value <> "" Then %>           <strong><%=(list_contact.Fields.Item("Salutation").Value)%></strong>
            <%end if%>
			<% If list_contact.Fields.Item("FirstName").Value <> "" Then %>
           <strong><%=(list_contact.Fields.Item("FirstName").Value)%>&nbsp;<%=(list_contact.Fields.Item("LastName").Value)%></strong>
            <%end if%> 
<% If list_contact.Fields.Item("JobTitle").Value <> "" Then %><br><%=(list_contact.Fields.Item("JobTitle").Value)%><%end if%>
<% If list_contact.Fields.Item("OrgName1").Value <> "" Then %><br><%=(list_contact.Fields.Item("OrgName1").Value)%><%end if%>
<% If list_contact.Fields.Item("OrgName2").Value <> "" Then %><br><%=(list_contact.Fields.Item("OrgName2").Value)%><%end if%>
            <% If list_contact.Fields.Item("Address1").Value <> "" Then %>	
            <br><%=(list_contact.Fields.Item("Address1").Value)%><%end if%><% If list_contact.Fields.Item("Address2").Value <> "" Then %>	
            , <%=(list_contact.Fields.Item("Address2").Value)%><%end if%>
            <% If list_contact.Fields.Item("City").Value <> "" Then %>  
            <br><%=(list_contact.Fields.Item("City").Value)%>&nbsp;<%end if%><% If list_contact.Fields.Item("State").Value <> "" Then %>            
            &nbsp;<%=(list_contact.Fields.Item("State").Value)%>
            <%end if%><% If list_contact.Fields.Item("Country").Value <> "" Then %>            <br>
            <%=(list_contact.Fields.Item("Country").Value)%><%end if%><% If list_contact.Fields.Item("PostalCode").Value <> "" Then %>&nbsp;            <%=(list_contact.Fields.Item("PostalCode").Value)%><%end if%>  
			 <% If list_contact.Fields.Item("Map").Value <> "" Then %>
            <br> 
            <strong>Map: </strong><a href="<%=(list_contact.Fields.Item("Map").Value)%>">View
            Map</a>            <%end if%>              
            <% If list_contact.Fields.Item("Phone").Value <> "" Then %>
            <br> 
            <strong>Tel:</strong> <%=(list_contact.Fields.Item("Phone").Value)%>            <%end if%>
            <% If list_contact.Fields.Item("CellPhone").Value <> "" Then %>
            <br> 
            <strong>Cell:</strong> <%=(list_contact.Fields.Item("CellPhone").Value)%>          <%end if%>
            <% If list_contact.Fields.Item("Fax").Value <> "" Then %>
            <br> 
            <strong>Fax:</strong> <%=(list_contact.Fields.Item("Fax").Value)%><%end if%>
						<% If list_contact.Fields.Item("EmailAddress").Value <> "" Then %>
            <br>         <strong>Email Address:</strong>   <a href="mailto:<%=(list_contact.Fields.Item("EmailAddress").Value)%>"><%=(list_contact.Fields.Item("EmailAddress").Value)%></a>
            <%end if%>  
			<% If list_contact.Fields.Item("WebsiteURL").Value <> "" Then %>
            <br> <strong>URL: 
            </strong><a href="http://<%=(list_contact.Fields.Item("WebsiteURL").Value)%>"><%=(list_contact.Fields.Item("WebsiteURL").Value)%></a>            <%end if%>
          </td>
	    </tr>
        <% If list_contact.Fields.Item("Profile").Value <> "" Then %>
		<tr>
          <td height="82" colspan="2" valign="top">
            <em><strong>Profile: </strong></em><%=(list_contact.Fields.Item("Profile").Value)%>       
          </td>
        </tr><%end if%>  
      </table>
    </td>
    <%
	startrw = startrw + 1
	list_contact.MoveNext()
	Wend
	%>
  </tr>
  <%
 numrows=numrows-1
 Wend
 %>
</table>
<%
list_contact.Close()
Set list_contact = Nothing
%>
