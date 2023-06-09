<%@LANGUAGE="VBSCRIPT"%>
<!--#include virtual="/Connections/photogallerymanager.asp" -->
<%
'*** File Upload to: ../../applications/PhotoGalleryManager/images, Extensions: "GIF,JPG,JPEG,BMP,PNG", Form: form1, Redirect: "", "file", "", "over"
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
  BuildUploadRequest RequestBin, "../../applications/PhotoGalleryManager/images", "file", "", "over"
  
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
  MM_editConnection = MM_photogallerymanager_STRING
  MM_editTable = "tblPhotoGallery"
  MM_editRedirectUrl = "admin.asp"
  MM_fieldsStr  = "CategoryID|value|ItemName|value|ItemDesc|value|ItemDescShort|value|DateAdded|value|ImageFileA|value|ImageThumbFileA|value|ImageFileB|value|ImageThumbFileB|value|Activated|value"
  MM_columnsStr = "CategoryID|none,none,NULL|ItemName|',none,''|ItemDesc|',none,''|ItemDescShort|',none,''|DateAdded|',none,NULL|ImageFileA|',none,''|ImageThumbFileA|',none,''|ImageFileB|',none,''|ImageThumbFileB|',none,''|Activated|',none,''"
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
set Category = Server.CreateObject("ADODB.Recordset")
Category.ActiveConnection = MM_photogallerymanager_STRING
Category.Source = "SELECT *  FROM tblPhotoGalleryCategory  ORDER BY CategoryID"
Category.CursorType = 0
Category.CursorLocation = 2
Category.LockType = 3
Category.Open()
Category_numRows = 0
%>
<html>
<head>
<title>Insert</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../styles.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
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
      <form ACTION="<%=MM_editAction%>" METHOD="POST" enctype="multipart/form-data" name="form1">
        <table width="100%" align="center" class="tableborder">
          <tr align="right" valign="top">
            <td colspan="3" class="tableheader">Insert New </td>
          </tr>
          <tr align="right" valign="top">
            <td width="29%" class="tableheader">Category:</td>
            <td colspan="2" align="left">
              <select name="CategoryID">
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
      | <a href="javascript:;" onClick="MM_openBrWindow('add_category.asp','Category','scrollbars=yes,width=400,height=300')">add/edit
      category</a> <img src="questionmark.gif" alt="Select a category that best describes the Image i.e. Sporting Image" width="15" height="15"></td>
          </tr>
          <tr align="right" valign="top">
            <td class="tableheader">Image Name:</td>
            <td colspan="2" align="left">
              <input name="ItemName" type="text" id="ItemName" value="Enter name of Image" size="50">
            <img src="questionmark.gif" alt="Enter the name of the Image" width="15" height="15">            </td>
          </tr>
          <tr align="right" valign="top">
            <td class="tableheader">Image Description:</td>
            <td colspan="2" align="left">
              <textarea name="ItemDesc" cols="50" rows="5" id="ItemDesc">Enter Description of Image</textarea>
            <img src="questionmark.gif" alt="Enter a description of the Image" width="15" height="15">            </td>
          </tr>
          <tr align="right" valign="top">
            <td class="tableheader">Image Short Description:</td>
            <td colspan="2" align="left">
            <textarea name="ItemDescShort" cols="50" rows="5" id="ItemDescShort"></textarea>
            <img src="questionmark.gif" alt="Enter a short description of the Image" width="15" height="15"></td>
          </tr>
          <tr align="right" valign="top">
            <td class="tableheader">Date Added:</td>
            <td colspan="2" align="left"><input name="DateAdded" type="text" id="DateAdded" value="<%= Date() %>">              
            <img src="questionmark.gif" alt="Date the image was added" width="15" height="15"></td>
          </tr>
          <tr align="right" valign="top">
            <td class="tableheader">Image A:</td>
            <td width="31%" align="left">            Large Size:
              <input name="ImageFileA" type="file" id="ImageFileA" value="" size="32">
              <img src="questionmark.gif" alt="Upload Large Size image" width="15" height="15"></td>
            <td width="40%" align="left">Thumbnail Size: 
              <input name="ImageThumbFileA" type="file" id="ImageThumbFileA" value="" size="32">
              <img src="questionmark.gif" alt="Upload Thumbnail Size image" width="15" height="15"></td>
          </tr>
          <tr align="right" valign="top">
            <td class="tableheader">Image B:</td>
            <td align="left">Large Size:              
              <input name="ImageFileB" type="file" id="ImageFileB" value="" size="32">
              <img src="questionmark.gif" alt="Upload Large Size image" width="15" height="15"></td>
            <td align="left">Thumbnail Size: 
              <input name="ImageThumbFileB" type="file" id="ImageThumbFileB" value="" size="32">
              <img src="questionmark.gif" alt="Upload Thumbnail Size image" width="15" height="15"></td>
          </tr>
          <tr align="right" valign="top">
            <td class="tableheader">Activated:</td>
            <td colspan="2" align="left">
              <input type="checkbox" name="Activated" value=True checked>
            <img src="questionmark.gif" alt="(Check if you want this link to be visible to the public)(Ucheck if you wish to hide)" width="15" height="15">            </td>
          </tr>
          <tr align="right" valign="top">
            <td class="tableheader">&nbsp;</td>
            <td colspan="2" align="left"><input name="submit" type="submit" value="Insert">
</td>
          </tr>
        </table>     
        <input type="hidden" name="MM_insert" value="form1">
      </form>
</body>
</html>
<%
Category.Close()
%>



