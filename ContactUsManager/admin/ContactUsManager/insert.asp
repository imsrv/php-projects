<%@LANGUAGE="VBSCRIPT"%>
<!--#include virtual="/Connections/contactusmanager.asp" -->
<%
'*** File Upload to: ../../applications/contactusmanager/images, Extensions: "GIF,JPG,JPEG,BMP,PNG", Form: contact_details, Redirect: "", "file", "", "over"
'*** Pure ASP File Upload -----------------------------------------------------
' Copyright 2000 (c) George Petrov
'
' Script partially based on code from Philippe Collignon 
'              (http://www.asptoday.com/articles/20000316.htm)
'
' New features from GP:
'  * Fast file save with ADO 2.5 stream object
'  * new wrapper functions, extra error checking
'  * UltraDev Server Behavior extension
'
' Version: 2.0.0 Beta
'------------------------------------------------------------------------------
Sub BuildUploadRequest(RequestBin,UploadDirectory,storeType,sizeLimit,nameConflict)
  'Get the boundary
  PosBeg = 1
  PosEnd = InstrB(PosBeg,RequestBin,getByteString(chr(13)))
  if PosEnd = 0 then
    Response.Write "<b>Form was submitted with no ENCTYPE=""multipart/form-data""</b><br>"
    Response.Write "Please correct the form attributes and try again."
    Response.End
  end if
  'Check ADO Version
	set checkADOConn = Server.CreateObject("ADODB.Connection")
	adoVersion = CSng(checkADOConn.Version)
	set checkADOConn = Nothing
	if adoVersion < 2.5 then
    Response.Write "<b>You don't have ADO 2.5 installed on the server.</b><br>"
    Response.Write "The File Upload extension needs ADO 2.5 or greater to run properly.<br>"
    Response.Write "You can download the latest MDAC (ADO is included) from <a href=""www.microsoft.com/data"">www.microsoft.com/data</a><br>"
    Response.End
	end if		
  'Check content length if needed
	Length = CLng(Request.ServerVariables("HTTP_Content_Length")) 'Get Content-Length header
	If "" & sizeLimit <> "" Then
    sizeLimit = CLng(sizeLimit)
    If Length > sizeLimit Then
      Request.BinaryRead (Length)
      Response.Write "Upload size " & FormatNumber(Length, 0) & "B exceeds limit of " & FormatNumber(sizeLimit, 0) & "B"
      Response.End
    End If
  End If
  boundary = MidB(RequestBin,PosBeg,PosEnd-PosBeg)
  boundaryPos = InstrB(1,RequestBin,boundary)
  'Get all data inside the boundaries
  Do until (boundaryPos=InstrB(RequestBin,boundary & getByteString("--")))
    'Members variable of objects are put in a dictionary object
    Dim UploadControl
    Set UploadControl = CreateObject("Scripting.Dictionary")
    'Get an object name
    Pos = InstrB(BoundaryPos,RequestBin,getByteString("Content-Disposition"))
    Pos = InstrB(Pos,RequestBin,getByteString("name="))
    PosBeg = Pos+6
    PosEnd = InstrB(PosBeg,RequestBin,getByteString(chr(34)))
    Name = getString(MidB(RequestBin,PosBeg,PosEnd-PosBeg))
    PosFile = InstrB(BoundaryPos,RequestBin,getByteString("filename="))
    PosBound = InstrB(PosEnd,RequestBin,boundary)
    'Test if object is of file type
    If  PosFile<>0 AND (PosFile<PosBound) Then
      'Get Filename, content-type and content of file
      PosBeg = PosFile + 10
      PosEnd =  InstrB(PosBeg,RequestBin,getByteString(chr(34)))
      FileName = getString(MidB(RequestBin,PosBeg,PosEnd-PosBeg))
      FileName = Mid(FileName,InStrRev(FileName,"\")+1)
      'Add filename to dictionary object
      UploadControl.Add "FileName", FileName
      Pos = InstrB(PosEnd,RequestBin,getByteString("Content-Type:"))
      PosBeg = Pos+14
      PosEnd = InstrB(PosBeg,RequestBin,getByteString(chr(13)))
      'Add content-type to dictionary object
      ContentType = getString(MidB(RequestBin,PosBeg,PosEnd-PosBeg))
      UploadControl.Add "ContentType",ContentType
      'Get content of object
      PosBeg = PosEnd+4
      PosEnd = InstrB(PosBeg,RequestBin,boundary)-2
      Value = FileName
      ValueBeg = PosBeg-1
      ValueLen = PosEnd-Posbeg
    Else
      'Get content of object
      Pos = InstrB(Pos,RequestBin,getByteString(chr(13)))
      PosBeg = Pos+4
      PosEnd = InstrB(PosBeg,RequestBin,boundary)-2
      Value = getString(MidB(RequestBin,PosBeg,PosEnd-PosBeg))
      ValueBeg = 0
      ValueEnd = 0
    End If
    'Add content to dictionary object
    UploadControl.Add "Value" , Value	
    UploadControl.Add "ValueBeg" , ValueBeg
    UploadControl.Add "ValueLen" , ValueLen	
    'Add dictionary object to main dictionary
    UploadRequest.Add name, UploadControl	
    'Loop to next object
    BoundaryPos=InstrB(BoundaryPos+LenB(boundary),RequestBin,boundary)
  Loop

  GP_keys = UploadRequest.Keys
  for GP_i = 0 to UploadRequest.Count - 1
    GP_curKey = GP_keys(GP_i)
    'Save all uploaded files
    if UploadRequest.Item(GP_curKey).Item("FileName") <> "" then
      GP_value = UploadRequest.Item(GP_curKey).Item("Value")
      GP_valueBeg = UploadRequest.Item(GP_curKey).Item("ValueBeg")
      GP_valueLen = UploadRequest.Item(GP_curKey).Item("ValueLen")

      if GP_valueLen = 0 then
        Response.Write "<B>An error has occured saving uploaded file!</B><br><br>"
        Response.Write "Filename: " & Trim(GP_curPath) & UploadRequest.Item(GP_curKey).Item("FileName") & "<br>"
        Response.Write "File does not exists or is empty.<br>"
        Response.Write "Please correct and <A HREF=""javascript:history.back(1)"">try again</a>"
	  	  response.End
	    end if
      
      'Create a Stream instance
      Dim GP_strm1, GP_strm2
      Set GP_strm1 = Server.CreateObject("ADODB.Stream")
      Set GP_strm2 = Server.CreateObject("ADODB.Stream")
      
      'Open the stream
      GP_strm1.Open
      GP_strm1.Type = 1 'Binary
      GP_strm2.Open
      GP_strm2.Type = 1 'Binary
        
      GP_strm1.Write RequestBin
      GP_strm1.Position = GP_ValueBeg
      GP_strm1.CopyTo GP_strm2,GP_ValueLen
    
      'Create and Write to a File
      GP_curPath = Request.ServerVariables("PATH_INFO")
      GP_curPath = Trim(Mid(GP_curPath,1,InStrRev(GP_curPath,"/")) & UploadDirectory)
      if Mid(GP_curPath,Len(GP_curPath),1)  <> "/" then
        GP_curPath = GP_curPath & "/"
      end if 
      GP_CurFileName = UploadRequest.Item(GP_curKey).Item("FileName")
      GP_FullFileName = Trim(Server.mappath(GP_curPath))& "\" & GP_CurFileName
      'Check if the file alreadu exist
      GP_FileExist = false
      Set fso = CreateObject("Scripting.FileSystemObject")
      If (fso.FileExists(GP_FullFileName)) Then
        GP_FileExist = true
      End If      
      if nameConflict = "error" and GP_FileExist then
        Response.Write "<B>File already exists!</B><br><br>"
        Response.Write "Please correct and <A HREF=""javascript:history.back(1)"">try again</a>"
				GP_strm1.Close
				GP_strm2.Close
	  	  response.End
      end if
      if ((nameConflict = "over" or nameConflict = "uniq") and GP_FileExist) or (NOT GP_FileExist) then
        if nameConflict = "uniq" and GP_FileExist then
          Begin_Name_Num = 0
          while GP_FileExist    
            Begin_Name_Num = Begin_Name_Num + 1
            GP_FullFileName = Trim(Server.mappath(GP_curPath))& "\" & fso.GetBaseName(GP_CurFileName) & "_" & Begin_Name_Num & "." & fso.GetExtensionName(GP_CurFileName)
            GP_FileExist = fso.FileExists(GP_FullFileName)
          wend  
          UploadRequest.Item(GP_curKey).Item("FileName") = fso.GetBaseName(GP_CurFileName) & "_" & Begin_Name_Num & "." & fso.GetExtensionName(GP_CurFileName)
					UploadRequest.Item(GP_curKey).Item("Value") = UploadRequest.Item(GP_curKey).Item("FileName")
        end if
        on error resume next
        GP_strm2.SaveToFile GP_FullFileName,2
        if err then
          Response.Write "<B>An error has occured saving uploaded file!</B><br><br>"
          Response.Write "Filename: " & Trim(GP_curPath) & UploadRequest.Item(GP_curKey).Item("FileName") & "<br>"
          Response.Write "Maybe the destination directory does not exist, or you don't have write permission.<br>"
          Response.Write "Please correct and <A HREF=""javascript:history.back(1)"">try again</a>"
    		  err.clear
  				GP_strm1.Close
  				GP_strm2.Close
  	  	  response.End
  	    end if
  			GP_strm1.Close
  			GP_strm2.Close
  			if storeType = "path" then
  				UploadRequest.Item(GP_curKey).Item("Value") = GP_curPath & UploadRequest.Item(GP_curKey).Item("Value")
  			end if
        on error goto 0
      end if
    end if
  next

End Sub

'String to byte string conversion
Function getByteString(StringStr)
  For i = 1 to Len(StringStr)
 	  char = Mid(StringStr,i,1)
	  getByteString = getByteString & chrB(AscB(char))
  Next
End Function

'Byte string to string conversion
Function getString(StringBin)
  getString =""
  For intCount = 1 to LenB(StringBin)
	  getString = getString & chr(AscB(MidB(StringBin,intCount,1))) 
  Next
End Function

Function UploadFormRequest(name)
  on error resume next
  if UploadRequest.Item(name) then
    UploadFormRequest = UploadRequest.Item(name).Item("Value")
  end if  
End Function

'Process the upload
UploadQueryString = Replace(Request.QueryString,"GP_upload=true","")
if mid(UploadQueryString,1,1) = "&" then
	UploadQueryString = Mid(UploadQueryString,2)
end if

GP_uploadAction = CStr(Request.ServerVariables("URL")) & "?GP_upload=true"
If (Request.QueryString <> "") Then  
  if UploadQueryString <> "" then
	  GP_uploadAction = GP_uploadAction & "&" & UploadQueryString
  end if 
End If

If (CStr(Request.QueryString("GP_upload")) <> "") Then
  GP_redirectPage = ""
  If (GP_redirectPage = "") Then
    GP_redirectPage = CStr(Request.ServerVariables("URL"))
  end if
    
  RequestBin = Request.BinaryRead(Request.TotalBytes)
  Dim UploadRequest
  Set UploadRequest = CreateObject("Scripting.Dictionary")  
  BuildUploadRequest RequestBin, "../../applications/contactusmanager/images", "file", "", "over"
  
  '*** GP NO REDIRECT
end if  
if UploadQueryString <> "" then
  UploadQueryString = UploadQueryString & "&GP_upload=true"
else  
  UploadQueryString = "GP_upload=true"
end if  


%>
<%
' *** Edit Operations: (Modified for File Upload) declare variables
MM_editAction = CStr(Request.ServerVariables("URL")) 'MM_editAction = CStr(Request("URL"))
If (UploadQueryString <> "") Then
  MM_editAction = MM_editAction & "?" & UploadQueryString
End If
' boolean to abort record edit
MM_abortEdit = false
' query string to execute
MM_editQuery = ""
%>
<%
' *** Insert Record: (Modified for File Upload) set variables
If (CStr(UploadFormRequest("MM_insert")) <> "") Then
  MM_editConnection = MM_contactusmanager_STRING
  MM_editTable = "tblContactUs"
  MM_editRedirectUrl = "admin.asp"
  MM_fieldsStr  = "Salutation|value|FirstName|value|LastName|value|CategoryID|value|EmailAddress|value|Profile|value|ImageFile|value|Activated|value|OrgName1|value|JobTitle|value|WebsiteURL|value|Address1|value|Phone|value|Address2|value|CellPhone|value|City|value|Fax|value|PostalCode|value|State|value|Country|value|Map|value|MessageSubjectAdmin|value|MessageBCAdmin|value|MessageCCAdmin|value|MessageHeaderAdmin|value|MessageFooterAdmin|value|MessageSubjectVisitor|value|MessageBodyVisitor|value|MessageHeaderVisitor|value|MessageFooterVisitorLine1|value|MessageFooterVisitorLine2|value|MessageFooterVisitorLine3|value"
  MM_columnsStr = "Salutation|',none,''|FirstName|',none,''|LastName|',none,''|CategoryID|none,none,NULL|EmailAddress|',none,''|Profile|',none,''|ImageFile|',none,''|Activated|',none,''|OrgName1|',none,''|JobTitle|',none,''|WebsiteURL|',none,''|Address1|',none,''|Phone|',none,''|Address2|',none,''|CellPhone|',none,''|City|',none,''|Fax|',none,''|PostalCode|',none,''|State|',none,''|Country|',none,''|Map|',none,''|MessageSubjectAdmin|',none,''|MessageBCAdmin|',none,''|MessageCCAdmin|',none,''|MessageHeaderAdmin|',none,''|MessageFooterAdmin|',none,''|MessageSubjectVisitor|',none,''|MessageBodyVisitor|',none,''|MessageHeaderVisitor|',none,''|MessageFooterVisitorLine1|',none,''|MessageFooterVisitorLine2|',none,''|MessageFooterVisitorLine3|',none,''"
  ' create the MM_fields and MM_columns arrays
  MM_fields = Split(MM_fieldsStr, "|")
  MM_columns = Split(MM_columnsStr, "|")
  ' set the form values
  For i = LBound(MM_fields) To UBound(MM_fields) Step 2
    MM_fields(i+1) = CStr(UploadFormRequest(MM_fields(i)))
  Next
  ' append the query string to the redirect URL

  If (MM_editRedirectUrl <> "" And UploadQueryString <> "") Then

    If (InStr(1, MM_editRedirectUrl, "?", vbTextCompare) = 0 And UploadQueryString <> "") Then

      MM_editRedirectUrl = MM_editRedirectUrl & "?" & UploadQueryString
    Else
      MM_editRedirectUrl = MM_editRedirectUrl & "&" & UploadQueryString
    End If
  End If
End If


%>
<%

' *** Insert Record: (Modified for File Upload) construct a sql insert statement and execute it

If (CStr(UploadFormRequest("MM_insert")) <> "") Then
  ' create the sql insert statement
  MM_tableValues = ""
  MM_dbValues = ""
  For i = LBound(MM_fields) To UBound(MM_fields) Step 2
    FormVal = MM_fields(i+1)
    MM_typeArray = Split(MM_columns(i+1),",")
    Delim = MM_typeArray(0)
    If (Delim = "none") Then Delim = ""
    AltVal = MM_typeArray(1)
   If (AltVal = "none") Then AltVal = ""
   EmptyVal = MM_typeArray(2)
    If (EmptyVal = "none") Then EmptyVal = ""
    If (FormVal = "") Then
      FormVal = EmptyVal
    Else
      If (AltVal <> "") Then
        FormVal = AltVal
      ElseIf (Delim = "'") Then  ' escape quotes
       FormVal = "'" & Replace(FormVal,"'","''") & "'"
      Else
       FormVal = Delim + FormVal + Delim
      End If
    End If
    If (i <> LBound(MM_fields)) Then
      MM_tableValues = MM_tableValues & ","
      MM_dbValues = MM_dbValues & ","
    End if
    MM_tableValues = MM_tableValues & MM_columns(i)
    MM_dbValues = MM_dbValues & FormVal
  Next
  MM_editQuery = "insert into " & MM_editTable & " (" & MM_tableValues & ") values (" & MM_dbValues & ")"
  If (Not MM_abortEdit) Then
    ' execute the insert
    Set MM_editCmd = Server.CreateObject("ADODB.Command")
    MM_editCmd.ActiveConnection = MM_editConnection
    MM_editCmd.CommandText = MM_editQuery
    MM_editCmd.Execute
    MM_editCmd.ActiveConnection.Close
    If (MM_editRedirectUrl <> "") Then
      Response.Redirect(MM_editRedirectUrl)
    End If
  End If
End If
%>
<%
set contact_details = Server.CreateObject("ADODB.Recordset")
contact_details.ActiveConnection = MM_contactusmanager_STRING
contact_details.Source = "SELECT *  FROM tblContactUs"
contact_details.CursorType = 0
contact_details.CursorLocation = 2
contact_details.LockType = 3
contact_details.Open()
contact_details_numRows = 0
%>
<%
set Category = Server.CreateObject("ADODB.Recordset")
Category.ActiveConnection = MM_contactusmanager_STRING
Category.Source = "SELECT *  FROM tblContactUsCategory  ORDER BY CategoryID"
Category.CursorType = 0
Category.CursorLocation = 2
Category.LockType = 3
Category.Open()
Category_numRows = 0
%>
<%
Dim Lookup_State
Dim Lookup_State_numRows

Set Lookup_State = Server.CreateObject("ADODB.Recordset")
Lookup_State.ActiveConnection = MM_contactusmanager_STRING
Lookup_State.Source = "SELECT *  FROM LookupState"
Lookup_State.CursorType = 0
Lookup_State.CursorLocation = 2
Lookup_State.LockType = 1
Lookup_State.Open()

Lookup_State_numRows = 0
%>
<%
Dim Lookup_Country
Dim Lookup_Country_numRows

Set Lookup_Country = Server.CreateObject("ADODB.Recordset")
Lookup_Country.ActiveConnection = MM_contactusmanager_STRING
Lookup_Country.Source = "SELECT *  FROM LookupCountry"
Lookup_Country.CursorType = 0
Lookup_Country.CursorLocation = 2
Lookup_Country.LockType = 1
Lookup_Country.Open()

Lookup_Country_numRows = 0
%>
<html>
<head>
<title>Contact Us Manager</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../styles.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}

function getFileExtension(filePath) { //v1.0
  fileName = ((filePath.indexOf('/') > -1) ? filePath.substring(filePath.lastIndexOf('/')+1,filePath.length) : filePath.substring(filePath.lastIndexOf('\\')+1,filePath.length));
  return fileName.substring(fileName.lastIndexOf('.')+1,fileName.length);
}

function checkFileUpload(form,extensions) { //v1.0
  document.MM_returnValue = true;
  if (extensions && extensions != '') {
    for (var i = 0; i<form.elements.length; i++) {
      field = form.elements[i];
      if (field.type.toUpperCase() != 'FILE') continue;
      if (field.value == '') {
        alert('File is required!');
        document.MM_returnValue = false;field.focus();break;
      }
      if (extensions.toUpperCase().indexOf(getFileExtension(field.value).toUpperCase()) == -1) {
        alert('This file type is not allowed for uploading.\nOnly the following file extensions are allowed: ' + extensions + '.\nPlease select another file and try again.');
        document.MM_returnValue = false;field.focus();break;
  } } }
}
//-->
</script>
</head>
<body>
<!--#include file="header.asp" -->
<form action="<%=MM_editAction%>" method="POST" enctype="multipart/form-data" name="contact_details" id="contact_details">
  <table width="100%" height="272" align="center" cellpadding="5" cellspacing="0" class="tableborder">
    <tr>
      <td width="49%" height="270" valign="top">
        <table width="100%" border="0" cellpadding="3" cellspacing="0" class="tableborder">
          <tr class="tableheader">
            <td colspan="3">Contact Details:</td>
            <td>Activated
            <input name="Activated" type="checkbox" id="Activated" value="True" checked></td>
          </tr>
          <tr class="row2">
            <td width="15%">First Name:</td>
            <td width="39%"><select name="Salutation" id="select6">
            <option value="Mr.">Mr.
              <option value="Mrs.">Mrs.
              <option value="Miss">Miss
              <option value="Dr.">Dr.
              <option value="Fr.">Fr.</option>
              <option value="Sr.">Sr.</option>
            </select>
              <input name="FirstName" type="text" id="FirstName3" size="15"></td>
            <td width="19%">Last Name:</td>
            <td width="27%"><input name="LastName" type="text" id="LastName2"></td>
          </tr>
          <tr class="row2">
            <td>Department: </td>
            <td><select name="CategoryID">
              <%
While (NOT Category.EOF)
%>
              <option value="<%=(Category.Fields.Item("CategoryID").Value)%>"><%=(Category.Fields.Item("CategoryName").Value)%></option>
              <%
  Category.MoveNext()
Wend
If (Category.CursorType > 0) Then
  Category.MoveFirst
Else
  Category.Requery
End If
%>
            </select>
        | <a href="javascript:;" onClick="MM_openBrWindow('add_category.asp','Category','scrollbars=yes,width=600,height=400')">Edit
        Dept</a></td>
            <td>Email Address:</td>
            <td><input name="EmailAddress" type="text" id="EmailAddress3"></td>
          </tr>
        </table>
        <br>        <table width="100%" border="0" cellpadding="3" cellspacing="0" class="tableborder">
          <tr>
            <td colspan="2" class="tableheader">Personal Details:</td>
          </tr>
          <tr class="row2">
            <td width="24%">Profile/Bio:</td>
            <td width="76%"><textarea name="Profile" cols="40" rows="6" id="Profile"></textarea>
            </td>
          </tr>
          <tr class="row2">
            <td height="27">Photo:</td>
            <td>                  <input name="ImageFile" type="file" id="ImageFile4">
            </td></tr>
        </table>        
        <br>                <br>        
        <input name="submit" type="submit" value="Insert Record">
        <br>
      </td>
      <td width="49%" valign="top"><table width="100%" border="0" cellpadding="3" cellspacing="0" class="tableborder">
        <tr class="tableheader">
          <td colspan="4">Company Details:</td>
        </tr>
        <tr class="row2">
          <td width="19%">Company Name:</td>
          <td width="28%"><input name="OrgName1" type="text" id="OrgName1">
          </td>
          <td width="16%">Division:</td>
          <td width="37%"><input name="OrgName12" type="text" id="OrgName13"></td>
        </tr>
        <tr class="row2">
          <td>Job Title:</td>
          <td><input name="JobTitle" type="text" id="JobTitle">
          </td>
          <td>Web Site URL:</td>
          <td>http://
            <input name="WebsiteURL" type="text" id="WebsiteURL">
          </td>
        </tr>
      </table>                
        <br>        <table width="100%" border="0" cellpadding="3" cellspacing="0" class="tableborder">
          <tr class="tableheader">
            <td colspan="4"> Address Details</td>
          </tr>
          <tr class="row2">
            <td width="21%">Address 1: </td>
            <td width="32%"><input name="Address1" type="text" id="Address12">
            </td>
            <td width="16%">Phone:</td>
            <td width="31%"><input name="Phone" type="text" id="Phone2" >
            </td>
          </tr>
          <tr class="row2">
            <td>Address 2:</td>
            <td><input name="Address2" type="text" id="Address22" >
            </td>
            <td>Cell:</td>
            <td><input name="CellPhone" type="text" id="CellPhone2" >
            </td>
          </tr>
          <tr class="row2">
            <td>City:</td>
            <td><input name="City" type="text" id="City2">
            </td>
            <td>Fax:</td>
            <td><input name="Fax" type="text" id="Fax2" >
            </td>
          </tr>
          <tr class="row2">
            <td>Postal Code:</td>
            <td><input name="PostalCode" type="text" id="PostalCode2">
            </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr class="row2">
            <td>Province/State:</td>
            <td><select name="State" id="select">
            <%
While (NOT Lookup_State.EOF)
%>
            <option value="<%=(Lookup_State.Fields.Item("StateName").Value)%>"><%=(Lookup_State.Fields.Item("StateName").Value)%></option>
                <%
  Lookup_State.MoveNext()
Wend
If (Lookup_State.CursorType > 0) Then
  Lookup_State.MoveFirst
Else
  Lookup_State.Requery
End If
%>
              </select>
            </td>
            <td>Country:</td>
            <td><select name="Country" id="select7">
            <%
While (NOT Lookup_Country.EOF)
%>
            <option value="<%=(Lookup_Country.Fields.Item("CountryName").Value)%>"><%=(Lookup_Country.Fields.Item("CountryName").Value)%></option>
                <%
  Lookup_Country.MoveNext()
Wend
If (Lookup_Country.CursorType > 0) Then
  Lookup_Country.MoveFirst
Else
  Lookup_Country.Requery
End If
%>
            </select>
</td>
          </tr>
          <tr class="row2">
            <td height="25">Map:</td>
            <td colspan="3"><input name="Map" type="text" id="Map3" size="30"> 
              |  <a href="http://ca.maps.yahoo.com" target="_blank">Get URL from
              Yahoo Maps</a></td>
          </tr>
        </table>
      <br></td>
    </tr>
  </table>
  <br>
  <table width="100%" align="center" class="tableborder">
    <tr>
      <td colspan="2" valign="top"  class="tableheader"><strong>This section
           allows you to configure the confirmation email that is automatically
          sent
          to the
        Contact and Visitor</strong></td>
      <td width="22%" align="right" valign="top"  class="tableheader">Email Message
        Preferences</td>
    </tr>
    <tr class="row2">
      <td width="21%" align="right" valign="top"><strong>Set the Subject Line
        of Confirmation Email sent to Contact:</strong></td>
      <td colspan="2" valign="top">
        <textarea name="MessageSubjectAdmin" cols="60" rows="2">Thank you, we have received your Message.</textarea>
        <img src="questionmark.gif" alt="Enter the text you wish displayed in the subject line of confirmation email sent to Contact" width="15" height="15"> </td>
    </tr>
    <tr class="row2">
      <td height="22" align="right" valign="top"><strong>Set the
        BCC of Confirmation Email sent to Contact:</strong></td>
      <td colspan="2" valign="top">
        <input type="text" name="MessageBCAdmin" size="60">
        <img src="questionmark.gif" alt="Enter an additional email address you wish to BCC" width="15" height="15"> </td>
    </tr>
    <tr class="row2">
      <td align="right" valign="top"><strong>Set the CC of Confirmation
        Email sent to Contact:</strong></td>
      <td colspan="2" valign="top">
        <input type="text" name="MessageCCAdmin" size="60">
        <img src="questionmark.gif" alt="Enter an additional email address you wish CC" width="15" height="15"> </td>
    </tr>
    <tr class="row2">
      <td height="56" align="right" valign="top"><strong>Set the
        Message Header of Confirmation Email sent to Contact:</strong></td>
      <td colspan="2" valign="top">
        <textarea name="MessageHeaderAdmin" cols="60" rows="3">Inquiry</textarea>
        <img src="questionmark.gif" alt="Enter the header text you wish displayed in the email message" width="15" height="15"> </td>
    </tr>
    <tr class="row2">
      <td align="right" valign="top"><strong>Set the Message Footer
        of Confirmation Email sent to Contact:</strong></td>
      <td colspan="2" valign="top">
        <textarea name="MessageFooterAdmin" cols="60" rows="3" id="MessageFooterAdmin">Inquiry</textarea>
        <img src="questionmark.gif" alt="Enter the footer text you wish displayed in the email message" width="15" height="15"> </td>
    </tr>
    <tr class="row2">
      <td height="24" align="right" valign="top"><strong>Set the
        Subject Line of Confirmation Email sent to Visitor:</strong></td>
      <td colspan="2" valign="top">
        <input name="MessageSubjectVisitor" type="text" value="Thank you, we have received your Message" size="60">
        <img src="questionmark.gif" alt="Enter the text you wish displayed in the subject line of the email message" width="15" height="15"> </td>
    </tr>
    <tr class="row2">
      <td align="right" valign="top"><strong>Set the Message Body
        of Confirmation Email sent to Visitor:</strong></td>
      <td colspan="2" valign="top">
        <textarea name="MessageBodyVisitor" cols="60" rows="5">This email is to confirm that we have received your comments.

Expect a reply in the next 48 hours</textarea>
        <img src="questionmark.gif" alt="Enter the text you wish displayed in the body of the email message" width="15" height="15"> </td>
    </tr>
    <tr class="row2">
      <td align="right" valign="top"><strong>Set the Message Header
        of Confirmation Email sent to Visitor:</strong></td>
      <td colspan="2" valign="top">
        <textarea name="MessageHeaderVisitor" cols="60" rows="3"></textarea>
        <img src="questionmark.gif" alt="Enter the header text you wish displayed in the email message" width="15" height="15"> </td>
    </tr>
    <tr class="row2">
      <td align="right" valign="top"><strong>Set the Message Footer
        Line1 of Confirmation Email sent to Visitor:</strong></td>
      <td colspan="2" valign="top">
        <input name="MessageFooterVisitorLine1" type="text" value="Company Name" size="60">
        <img src="questionmark.gif" alt="Enter the 1st line of text you wish displayed at the end of the email message" width="15" height="15"> </td>
    </tr>
    <tr class="row2">
      <td align="right" valign="top"><strong>Set the Message Footer
        Line2 of Confirmation Email sent to Visitor:</strong></td>
      <td colspan="2" valign="top">
        <input name="MessageFooterVisitorLine2" type="text" value="www.company.com" size="60">
        <img src="questionmark.gif" alt="Enter the 2nd line of text you wish displayed at the end of the email message" width="15" height="15"> </td>
    </tr>
    <tr class="row2">
      <td align="right" valign="top"><strong>Set the Message Footer
        Line3 of Confirmation Email sent to Visitor:</strong></td>
      <td colspan="2" valign="top">
        <input name="MessageFooterVisitorLine3" type="text" value="Telephone Number" size="60">
        <img src="questionmark.gif" alt="Enter the 3rd line of text you wish displayed at the end of the email message" width="15" height="15"> </td>
    </tr>
    <tr>
      <td align="right" valign="top"  class="tableheader">&nbsp;</td>
      <td colspan="2" valign="top">
        <input name="submit2" type="submit" value="Insert Record">
      </td>
    </tr>
  </table>
    <input type="hidden" name="MM_insert" value="contact_details">
</form>
</body>
</html>
<%
contact_details.Close()
Set contact_details = Nothing
%>
<%
Category.Close()
Set Category = Nothing
%>
<%
Lookup_Country.Close()
Set Lookup_Country = Nothing
%>
<%
Lookup_State.Close()
Set Lookup_State = Nothing
%>

