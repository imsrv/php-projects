<%@LANGUAGE="VBSCRIPT"%>
<!--#include virtual="/Connections/accountlistmanager.asp" -->
<%
'*** Pure ASP File Upload 2.1.8
Dim GP_uploadAction,UploadQueryString
PureUploadSetup
If (CStr(Request.QueryString("GP_upload")) <> "") Then
  Dim pau_thePath,pau_Extensions,pau_Form,pau_Redirect,pau_storeType,pau_sizeLimit,pau_nameConflict,pau_requireUpload,pau_minWidth,pau_minHeight,pau_maxWidth,pau_maxHeight,pau_saveWidth,pau_saveHeight,pau_timeout,pau_progressBar,pau_progressWidth,pau_progressHeight
  pau_thePath = """../../applications/AccountListManager/images"""
  pau_Extensions = "GIF,JPG,JPEG,BMP,PNG"
  pau_Form = "account_details"
  pau_Redirect = ""
  pau_storeType = "file"
  pau_sizeLimit = ""
  pau_nameConflict = "over"
  pau_requireUpload = "true"
  pau_minWidth = ""
  pau_minHeight = "" 
  pau_maxWidth = ""
  pau_maxHeight = ""
  pau_saveWidth = ""
  pau_saveHeight = ""
  pau_timeout = "600"
  pau_progressBar = ""
  pau_progressWidth = "300"
  pau_progressHeight = "100"
  
  Dim RequestBin, UploadRequest
  CheckPureUploadVersion 2.18
  ProcessUpload pau_thePath,pau_Extensions,pau_Redirect,pau_storeType,pau_sizeLimit,pau_nameConflict,pau_requireUpload,pau_minWidth,pau_minHeight,pau_maxWidth,pau_maxHeight,pau_saveWidth,pau_saveHeight,pau_timeout
end if
%>
<SCRIPT LANGUAGE="VBSCRIPT" RUNAT="SERVER">
'*** Pure ASP File Upload -----------------------------------------------------
' Copyright 2001-2004 (c) George Petrov, www.DMXzone.com
' Version: 2.18
'------------------------------------------------------------------------------


'Current version
Function getPureUploadVersion()
  getPureUploadVersion = 2.18
End Function


'Set the querystring correctly
Sub PureUploadSetup()
	If (CStr(Request.QueryString("GP_upload")) <> "") Then
		UploadQueryString = Replace(Request.QueryString,"GP_upload=true","")
		if left(UploadQueryString,1) = "&" or left(UploadQueryString,1) = "?" then
			UploadQueryString = Mid(UploadQueryString,2)
		end if
		if right(UploadQueryString,1) = "&" then
			UploadQueryString = Mid(UploadQueryString,1,len(UploadQueryString)-1)
		end if	
	else  
		UploadQueryString = Request.QueryString
		If (UploadQueryString <> "") Then  
			UploadQueryString = UploadQueryString & "&GP_upload=true"
		else
			UploadQueryString = "GP_upload=true"
		end if	
		GP_uploadAction = CStr(Request.ServerVariables("URL")) & "?" & UploadQueryString
	end if  
End Sub


'Read the form(actual upload)
Sub ProcessUpload(pau_thePath,pau_Extensions,pau_Redirect,pau_storeType,pau_sizeLimit,pau_nameConflict,pau_requireUpload,pau_minWidth,pau_minHeight,pau_maxWidth,pau_maxHeight,pau_saveWidth,pau_saveHeight,pau_timeout)
	Server.ScriptTimeout = pau_timeout
	pau_doPreUploadChecks pau_sizeLimit
	RequestBin = Request.BinaryRead(Request.TotalBytes)
	Set UploadRequest = CreateObject("Scripting.Dictionary")  
	pau_BuildUploadRequest RequestBin, pau_thePath, pau_storeType, pau_sizeLimit, pau_nameConflict, pau_Extensions
	If pau_Redirect <> "" Then
		If UploadQueryString <> "" Then
			pau_Redirect = pau_Redirect & "?" & UploadQueryString
		End If
		Response.Redirect(pau_Redirect)  
	end if  
End Sub


'Some checks before actual upload
Sub pau_doPreUploadChecks(sizeLimit)
	Dim checkADOConn, AdoVersion, Length
	'Check ADO Version
	set checkADOConn = Server.CreateObject("ADODB.Connection")
	on error resume next
	adoVersion = CSng(checkADOConn.Version)
	if err then 
		adoVersion = Replace(checkADOConn.Version,".",",")  
		adoVersion = CSng(adoVersion)
	end if	
	err.clear
	on error goto 0	
	set checkADOConn = Nothing
	if adoVersion < 2.5 then
		Response.Write "<strong>You don't have ADO 2.5 installed on the server.</strong><br/>"
		Response.Write "The File Upload extension needs ADO 2.5 or greater to run properly.<br/>"
		Response.Write "You can download the latest MDAC (ADO is included) from <a href=""www.microsoft.com/data"">www.microsoft.com/data</a><br/>"
		Response.End
	end if
	'Check content length if needed
	Length = CLng(Request.ServerVariables("Content_Length")) 'Get Content-Length header
	If sizeLimit <> "" Then
		sizeLimit = CLng(sizeLimit) * 1024
		If Length > sizeLimit Then
			Response.Write "Upload size " & FormatNumber(Length, 0) & "B exceeds limit of " & FormatNumber(sizeLimit, 0) & "B<br/>"
			Response.Write "Please correct and <a href=""javascript:history.back(1)"">try again</a>"      
			Response.End
		End If
	End If
End Sub


'Check if version is uptodate
Sub CheckPureUploadVersion(pau_version)
	Dim foundPureUploadVersion
	foundPureUploadVersion = getPureUploadVersion()
	if err or pau_version > foundPureUploadVersion then
		Response.Write "<strong>You don't have latest version of ScriptLibrary/incPureUpload.asp uploaded on the server.</strong><br/>"
		Response.Write "This library is required for the current page. It is fully backwards compatible so old pages will work as well.<br/>"
		Response.End    
	end if
End Sub


'Get fieldname
function pau_Name(FormInfo)
	Dim PosBeg, PosLen
	PosBeg = InStr(FormInfo, "name=")+6
	PosLen = InStr(PosBeg, FormInfo, Chr(34))-PosBeg
	pau_Name = Mid(FormInfo, PosBeg, PosLen)
end function


'Get filename
function pau_FileName(FormInfo)
	Dim PosBeg, PosLen
	PosBeg = InStr(FormInfo, "filename=")+10
	PosLen = InStr(PosBeg, FormInfo, Chr(34))-PosBeg
	pau_FileName = Mid(FormInfo, PosBeg, PosLen)
end function


'Get contentType
function pau_ContentType(FormInfo)
	Dim PosBeg
	PosBeg = InStr(FormInfo, "Content-Type: ")+14
	pau_ContentType = Mid(FormInfo, PosBeg)
end function


'Compatibility with older versions
Sub BuildUploadRequest(RequestBin,UploadDirectory,storeType,sizeLimit,nameConflict)
	pau_BuildUploadRequest RequestBin,UploadDirectory,storeType,sizeLimit,nameConflict,""
End Sub


Sub pau_BuildUploadRequest(RequestBin,UploadDirectory,storeType,sizeLimit,nameConflict,Extensions)
	Dim Boundary, FormInfo, TypeArr, BoundaryArr, BoundaryPos, PosBeg, PosEnd, Pos, PosLen, Extension, ExtArr, i
	Dim PosFile, Name, PosBound, FileName, ContentType, Value, ValueBeg, ValueEnd, ValueLen, ExtChk
	'Check content type
	TypeArr = Split(Request.ServerVariables("Content_Type"), ";")
	if Trim(TypeArr(0)) <> "multipart/form-data" then
		Response.Write "<strong>Form was submitted with no ENCTYPE=""multipart/form-data""</strong><br/>"
		Response.Write "Please correct and <a href=""javascript:history.back(1)"">try again</a>"      
		Response.End
	end if
	'Get the boundary
	  PosBeg = 1
	  PosEnd = InstrB(PosBeg,RequestBin,pau_getByteString(chr(13)))
	  if PosEnd = 0 then
		Response.Write "<strong>Form was submitted with no ENCTYPE=""multipart/form-data""</strong><br/>"
		Response.Write "Please correct and <a href=""javascript:history.back(1)"">try again</a>"    
		Response.End
	  end if
	  boundary = MidB(RequestBin,PosBeg,PosEnd-PosBeg)
	  boundaryPos = InstrB(1,RequestBin,boundary)
	  'Get all data inside the boundaries
	  Do until (boundaryPos=InstrB(RequestBin,boundary & pau_getByteString("--")))
		'Members variable of objects are put in a dictionary object
		Dim UploadControl
		Set UploadControl = CreateObject("Scripting.Dictionary")
		'Get an object name
		Pos = InstrB(BoundaryPos,RequestBin,pau_getByteString("Content-Disposition"))
		Pos = InstrB(Pos,RequestBin,pau_getByteString("name="))
		PosBeg = Pos+6
		PosEnd = InstrB(PosBeg,RequestBin,pau_getByteString(chr(34)))
		Name = LCase(pau_getString(MidB(RequestBin,PosBeg,PosEnd-PosBeg)))
		PosFile = InstrB(BoundaryPos,RequestBin,pau_getByteString("filename="))
		PosBound = InstrB(PosEnd,RequestBin,boundary)
		'Test if object is of file type
		If  PosFile<>0 AND (PosFile<PosBound) Then
		  'Get Filename, content-type and content of file
		  PosBeg = PosFile + 10
		  PosEnd =  InstrB(PosBeg,RequestBin,pau_getByteString(chr(34)))
		  FileName = pau_getString(MidB(RequestBin,PosBeg,PosEnd-PosBeg))
		  FileName = pau_RemoveInvalidChars(Mid(FileName,InStrRev(FileName,"\")+1))
		  'Check extension
		  Extension = Mid(FileName,InStrRev(FileName,".")+1)
		  If Extensions <> "" And FileName <> "" Then
		  	ExtChk = true
		  	ExtArr = Split(Extensions, ",")
		  	For i = 0 to UBound(ExtArr)
		  		If LCase(ExtArr(i)) = LCase(Extension) Then
		  			ExtChk = false
					End If
		  	Next
		  	If ExtChk Then
					Response.Write "Filename: " & FileName & "<br/>"
					Response.Write "Filetype is not allowed, only " & Extensions & " are allowed<br/>"
					Response.Write "Please correct and <a href=""javascript:history.back(1)"">try again</a>"
					Response.End
				End If
		  End If
		  'Add filename to dictionary object
		  UploadControl.Add "FileName", FileName
		  Pos = InstrB(PosEnd,RequestBin,pau_getByteString("Content-Type:"))
		  PosBeg = Pos+14
		  PosEnd = InstrB(PosBeg,RequestBin,pau_getByteString(chr(13)))
		  'Add content-type to dictionary object
		  ContentType = pau_getString(MidB(RequestBin,PosBeg,PosEnd-PosBeg))
		  UploadControl.Add "ContentType",ContentType
		  'Get content of object
		  PosBeg = PosEnd+4
		  PosEnd = InstrB(PosBeg,RequestBin,boundary)-2
		  Value = FileName
		  ValueBeg = PosBeg-1
		  ValueLen = PosEnd-Posbeg
		Else
		  'Get content of object
		  Pos = InstrB(Pos,RequestBin,pau_getByteString(chr(13)))
		  PosBeg = Pos+4
		  PosEnd = InstrB(PosBeg,RequestBin,boundary)-2
		  Value = pau_getString(MidB(RequestBin,PosBeg,PosEnd-PosBeg))
		  ValueBeg = 0
		  ValueEnd = 0
		End If
		'Add content to dictionary object
		UploadControl.Add "Value" , Value	
		UploadControl.Add "ValueBeg" , ValueBeg
		UploadControl.Add "ValueLen" , ValueLen	
		'Add dictionary object to main dictionary
		if UploadRequest.Exists(name) then
		  UploadRequest(name).Item("Value") = UploadRequest(name).Item("Value") & "," & Value
		else
		  UploadRequest.Add name, UploadControl 
		end if    
		'Loop to next object
		BoundaryPos=InstrB(BoundaryPos+LenB(boundary),RequestBin,boundary)
	  Loop
	Dim GP_keys, GP_i, GP_curKey, GP_value, GP_valueBeg, GP_valueLen, GP_curPath, GP_FullPath
	Dim GP_CurFileName, GP_FullFileName, fso, GP_BegFolder, GP_RelFolder, GP_FileExist, Begin_Name_Num
	Dim orgUploadDirectory
	if InStr(UploadDirectory,"""") > 0 then 
		on error resume next
		orgUploadDirectory = UploadDirectory
		UploadDirectory = eval(UploadDirectory)  
		if err then
			Response.Write "<strong>Upload folder is invalid</strong><br/><br/>"      
			Response.Write "Upload Folder: " & Trim(orgUploadDirectory) & "<br/>"
			Response.Write "Please correct and <a href=""javascript:history.back(1)"">try again</a>"
			err.clear
			response.End
		end if    
		on error goto 0
	end if  
	GP_keys = UploadRequest.Keys
	for GP_i = 0 to UploadRequest.Count - 1
		GP_curKey = GP_keys(GP_i)
		'Save all uploaded files
		if UploadRequest.Item(GP_curKey).Item("FileName") <> "" then
			GP_value = UploadRequest.Item(GP_curKey).Item("Value")
			GP_valueBeg = UploadRequest.Item(GP_curKey).Item("ValueBeg")
			GP_valueLen = UploadRequest.Item(GP_curKey).Item("ValueLen")
			'Get the path
			if InStr(UploadDirectory,"\") > 0 then
				GP_curPath = UploadDirectory
				if Mid(GP_curPath,Len(GP_curPath),1) <> "\" then
					GP_curPath = GP_curPath & "\"
				end if         
				GP_FullPath = GP_curPath
			else
				if Left(UploadDirectory,1) = "/" then
					GP_curPath = UploadDirectory
				else
					GP_curPath = Request.ServerVariables("PATH_INFO")
					GP_curPath = Trim(Mid(GP_curPath,1,InStrRev(GP_curPath,"/")) & UploadDirectory)
					while InStr(GP_curPath, "/./") > 0
						pos = InStr(GP_curPath, "/./")
						GP_curPath = Trim(Mid(GP_curPath,1,pos) & Mid(GP_curPath,pos+3))
					wend
					while InStr(GP_curPath, "/../") > 0
						pos = InStr(GP_curPath, "/../")
						if pos > 1 then
							GP_curPath = Trim(Mid(GP_curPath,1,InStrRev(GP_curPath, "/", pos-1)) & Mid(GP_curPath,pos+4))
						else
							GP_curPath = Trim(Mid(GP_curPath,1,pos) & Mid(GP_curPath,pos+4))
						end if
					wend
					if Mid(GP_curPath,Len(GP_curPath),1)  <> "/" then
						GP_curPath = GP_curPath & "/"
					end if 
				end if
				GP_FullPath = Trim(Server.mappath(GP_curPath))				
			end if
			if GP_valueLen = 0 then
				Response.Write "<strong>An error has occurred while saving the uploaded file!</strong><br/><br/>"
				Response.Write "Filename: " & Trim(GP_curPath) & UploadRequest.Item(GP_curKey).Item("FileName") & "<br/>"
				Response.Write "The file does not exists or is empty.<br/>"
				Response.Write "Please correct and <a href=""javascript:history.back(1)"">try again</a>"
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
			GP_CurFileName = UploadRequest.Item(GP_curKey).Item("FileName")      
			GP_FullFileName = GP_FullPath & "\" & GP_CurFileName
			Set fso = CreateObject("Scripting.FileSystemObject")
			pau_AutoCreatePath GP_FullPath
			'Check if the file already exist
			GP_FileExist = false
			If fso.FileExists(GP_FullFileName) Then
				GP_FileExist = true
			End If      
			if nameConflict = "error" and GP_FileExist then
				Response.Write "<strong>The file already exists on the server!</strong><br/><br/>"
				Response.Write "Please correct and <a href=""javascript:history.back(1)"">try again</a>"
				GP_strm1.Close
				GP_strm2.Close
				response.End
			end if
			if ((nameConflict = "over" or nameConflict = "uniq") and GP_FileExist) or (NOT GP_FileExist) then
				if nameConflict = "uniq" and GP_FileExist then
					Begin_Name_Num = 0
					while GP_FileExist    
						Begin_Name_Num = Begin_Name_Num + 1
						GP_FullFileName = Trim(GP_FullPath)& "\" & fso.GetBaseName(GP_CurFileName) & "_" & Begin_Name_Num & "." & fso.GetExtensionName(GP_CurFileName)
						GP_FileExist = fso.FileExists(GP_FullFileName)
					wend  
					UploadRequest.Item(GP_curKey).Item("FileName") = fso.GetBaseName(GP_CurFileName) & "_" & Begin_Name_Num & "." & fso.GetExtensionName(GP_CurFileName)
					UploadRequest.Item(GP_curKey).Item("Value") = UploadRequest.Item(GP_curKey).Item("FileName")
				end if
				on error resume next
				GP_strm2.SaveToFile GP_FullFileName,2
				if err then
					err.clear
					Dim txt_stream, file_bin
					Set txt_stream = fso.CreateTextFile(GP_FullFileName, True)
					file_bin = pau_getString(MidB(RequestBin, GP_ValueBeg+1, GP_ValueLen))
					txt_stream.Write file_bin
					txt_stream.Close
					if err then
						GP_strm1.Close
						GP_strm2.Close
						Response.Write "<strong>An error has occurred while saving uploaded file!</strong><br/><br/>"
						Response.Write "Filename: " & GP_FullFileName & "<br/><br/>"
						if fso.FileExists(GP_FullFileName) then
							Dim f
							Response.Write "The file already exists on the server!<br/>"
							Set f = fso.GetFile(GP_FullFileName)
							Response.Write "Attributes(" & f.attributes & "|" & f.parentfolder.attributes & "): "
							if f.attributes and 1 then
								Response.Write "ReadOnly "
							end if
							if f.attributes and 2 then
								Response.Write "Hidden "
							end if
							if f.attributes and 4 then
								Response.Write "System "
							end if
							if f.attributes and 16 then
								Response.Write "Directory "
							end if
							Response.Write "<br/><br/>"
						end if
						response.End
					end if
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


'Create folders if they do not exist
Sub pau_AutoCreatePath(PAU_FullPath)
	Dim FL_fso, FL_EndPos, PAU_NewPath
	Set FL_fso = CreateObject("Scripting.FileSystemObject")  
	if not FL_fso.FolderExists(PAU_FullPath) then
	FL_EndPos = InStrRev(PAU_FullPath,"\")
	if FL_EndPos > 0 then
		PAU_NewPath = Left(PAU_FullPath,FL_EndPos-1)
		pau_AutoCreatePath PAU_NewPath
		on error resume next
		FL_fso.CreateFolder PAU_FullPath
		if err.number <> 0 then
			Response.Write "<strong>Can not create upload folder path: " & PAU_FullPath & "!</strong><br/>"
			Response.Write "Maybe you don't have the proper permissions<br/><br/>"        
			Response.Write "Error # " & CStr(Err.Number) & " " & Err.Description & "<br/><br/>"
			Response.Write "Please correct and <a href=""javascript:history.back(1)"">try again</a>"
			Response.End        
		end if
		on error goto 0
		end if  
	end if
	Set FL_fso = nothing
End Sub


'String to byte string conversion
Function pau_getByteString(StringStr)
	Dim i, char
	For i = 1 to Len(StringStr)
		char = Mid(StringStr,i,1)
		pau_getByteString = pau_getByteString & chrB(AscB(char))
	Next
End Function


'Byte string to string conversion (with double-byte support now)
Function pau_getString(StringBin)
	Dim intCount,get1Byte
	pau_getString = ""
	For intCount = 1 to LenB(StringBin)
		get1Byte = MidB(StringBin,intCount,1)
		pau_getString = pau_getString & chr(AscB(get1Byte)) 
	Next
End Function


'Replacement for the requests
Function UploadFormRequest(name)
	Dim keyName
	keyName = LCase(name)
	if IsObject(UploadRequest) then
		if UploadRequest.Exists(keyName) then
			if UploadRequest.Item(keyName).Exists("Value") then
				UploadFormRequest = UploadRequest.Item(keyName).Item("Value")
			end if  
		end if  
	end if  
End Function


'Invalid characters
'Dollar sign ($) 
'At sign (@) 
'Angle brackets (< >), brackets ([ ]), braces ({ }), and parentheses (( )) 
'Colon (:) and semicolon (;) 
'Equal sign (=) 
'Caret sign (^) 
'Pipe (vertical bar) (|) 
'Asterisk (*) 
'Exclamation point (!) 
'Forward (/) and backward slash (\) 
'Percent sign (%) 
'Question mark (?) 
'Comma (,) 
'Quotation mark (single or double) (' ") 
'Tab 
Function pau_RemoveInvalidChars(str)
	Dim newStr, ci, curChar, Invalid
	Invalid = "$@<>[]{}():;=^|*!/\%?,'""	"
	for ci = 1 to Len(str)
		curChar = Mid(str,ci,1)
		if InStr(Invalid, curChar) = 0 then
			newStr = newStr & curChar
		end if
	next
	pau_RemoveInvalidChars = Trim(newStr)
End Function


'Fix for the update record
Function FixFieldsForUpload(GP_fieldsStr, GP_columnsStr)
	Dim GP_counter, GP_Fields, GP_Columns, GP_FieldName, GP_FieldValue, GP_CurFileName, GP_CurContentType
	GP_Fields = Split(GP_fieldsStr, "|")
	GP_Columns = Split(GP_columnsStr, "|") 
	GP_fieldsStr = ""
	' Get the form values
	For GP_counter = LBound(GP_Fields) To UBound(GP_Fields) Step 2
		GP_FieldName = LCase(GP_Fields(GP_counter))
		GP_FieldValue = GP_Fields(GP_counter+1)
		if UploadRequest.Exists(GP_FieldName) then
			GP_CurFileName = UploadRequest.Item(GP_FieldName).Item("FileName")
			GP_CurContentType = UploadRequest.Item(GP_FieldName).Item("ContentType")
		else  
			GP_CurFileName = ""
			GP_CurContentType = ""
		end if	
		if (GP_CurFileName = "" and GP_CurContentType = "") or (GP_CurFileName <> "" and GP_CurContentType <> "") then
			GP_fieldsStr = GP_fieldsStr & GP_FieldName & "|" & GP_FieldValue & "|"
		end if 
	Next
	if GP_fieldsStr <> "" then
		GP_fieldsStr = Mid(GP_fieldsStr,1,Len(GP_fieldsStr)-1)
	else  
		Response.Write "<strong>An error has occured during record update!</strong><br/><br/>"
		Response.Write "There are no fields to update ...<br/>"
		Response.Write "If the file upload field is the only field on your form, you should make it required.<br/>"
		Response.Write "Please correct and <a href=""javascript:history.back(1)"">try again</a>"
		Response.End
	end if
	FixFieldsForUpload = GP_fieldsStr    
End Function


'Fix for the update record
Function FixColumnsForUpload(GP_fieldsStr, GP_columnsStr)
	Dim GP_counter, GP_Fields, GP_Columns, GP_FieldName, GP_ColumnName, GP_ColumnValue,GP_CurFileName, GP_CurContentType
	GP_Fields = Split(GP_fieldsStr, "|")
	GP_Columns = Split(GP_columnsStr, "|") 
	GP_columnsStr = "" 
	' Get the form values
	For GP_counter = LBound(GP_Fields) To UBound(GP_Fields) Step 2
		GP_FieldName = LCase(GP_Fields(GP_counter))  
		GP_ColumnName = GP_Columns(GP_counter)  
		GP_ColumnValue = GP_Columns(GP_counter+1)
		if UploadRequest.Exists(GP_FieldName) then
			GP_CurFileName = UploadRequest.Item(GP_FieldName).Item("FileName")
			GP_CurContentType = UploadRequest.Item(GP_FieldName).Item("ContentType")	  
		else  
			GP_CurFileName = ""
			GP_CurContentType = ""
		end if  
		if (GP_CurFileName = "" and GP_CurContentType = "") or (GP_CurFileName <> "" and GP_CurContentType <> "") then
			GP_columnsStr = GP_columnsStr & GP_ColumnName & "|" & GP_ColumnValue & "|"
		end if 
	Next
	if GP_columnsStr <> "" then
		GP_columnsStr = Mid(GP_columnsStr,1,Len(GP_columnsStr)-1)    
	end if
	FixColumnsForUpload = GP_columnsStr
End Function

</SCRIPT>
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
  MM_editConnection = MM_accountlistmanager_STRING
  MM_editTable = "tblAM_Accounts"
  MM_editRedirectUrl = "admin.asp"
  MM_fieldsStr  = "Activated|value|OrgName1|value|OrgName12|value|WebsiteURL|value|Address1|value|Phone|value|Address2|value|CellPhone|value|City|value|Fax|value|PostalCode|value|AccountEmailAddress|value|State|value|Country|value|Map|value|Profile|value|ImageFile|value|CategoryID|value|AccountLookuptxt1|value|AccountLookuptxt2|value|AccountLookuptxt3|value|AccountLookuptxt4|value|AccountLookuptxt5|value"
  MM_columnsStr = "AccountActivated|',none,''|AccountName1|',none,''|AccountName2|',none,''|AccountWebsiteURL|',none,''|AccountAddress1|',none,''|AccountPhone|',none,''|AccountAddress2|',none,''|AccountCellPhone|',none,''|AccountCity|',none,''|AccountFax|',none,''|AccountPostalCode|',none,''|AccountEmailAddress|',none,''|AccountState|',none,''|AccountCountry|',none,''|AccountMap|',none,''|AccountProfile|',none,''|AccountImageFile|',none,''|AccountCategoryID|none,none,NULL|AccountLookuptxt1|',none,''|AccountLookuptxt2|',none,''|AccountLookuptxt3|',none,''|AccountLookuptxt4|',none,''|AccountLookuptxt5|',none,''"
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
set account_details = Server.CreateObject("ADODB.Recordset")
account_details.ActiveConnection = MM_accountlistmanager_STRING
account_details.Source = "SELECT *  FROM tblAM_Accounts"
account_details.CursorType = 0
account_details.CursorLocation = 2
account_details.LockType = 3
account_details.Open()
account_details_numRows = 0
%>
<%
set Category = Server.CreateObject("ADODB.Recordset")
Category.ActiveConnection = MM_accountlistmanager_STRING
Category.Source = "SELECT *  FROM tblAM_AccountsCategory  ORDER BY CategoryID"
Category.CursorType = 0
Category.CursorLocation = 2
Category.LockType = 3
Category.Open()
Category_numRows = 0
%>
<%
Dim AccountLookuptxt1
Dim AccountLookuptxt1_numRows

Set AccountLookuptxt1 = Server.CreateObject("ADODB.Recordset")
AccountLookuptxt1.ActiveConnection = MM_accountlistmanager_STRING
AccountLookuptxt1.Source = "SELECT *  FROM tblAM_AccountLookuptxt1"
AccountLookuptxt1.CursorType = 0
AccountLookuptxt1.CursorLocation = 2
AccountLookuptxt1.LockType = 1
AccountLookuptxt1.Open()

AccountLookuptxt1_numRows = 0
%>
<%
Dim AccountLookuptxt2
Dim AccountLookuptxt2_numRows

Set AccountLookuptxt2 = Server.CreateObject("ADODB.Recordset")
AccountLookuptxt2.ActiveConnection = MM_accountlistmanager_STRING
AccountLookuptxt2.Source = "SELECT *  FROM tblAM_AccountLookuptxt2"
AccountLookuptxt2.CursorType = 0
AccountLookuptxt2.CursorLocation = 2
AccountLookuptxt2.LockType = 1
AccountLookuptxt2.Open()

AccountLookuptxt2_numRows = 0
%>
<%
Dim AccountLookuptxt3
Dim AccountLookuptxt3_numRows

Set AccountLookuptxt3 = Server.CreateObject("ADODB.Recordset")
AccountLookuptxt3.ActiveConnection = MM_accountlistmanager_STRING
AccountLookuptxt3.Source = "SELECT *  FROM tblAM_AccountLookuptxt3"
AccountLookuptxt3.CursorType = 0
AccountLookuptxt3.CursorLocation = 2
AccountLookuptxt3.LockType = 1
AccountLookuptxt3.Open()

AccountLookuptxt3_numRows = 0
%>
<%
Dim AccountLookuptxt4
Dim AccountLookuptxt4_numRows

Set AccountLookuptxt4 = Server.CreateObject("ADODB.Recordset")
AccountLookuptxt4.ActiveConnection = MM_accountlistmanager_STRING
AccountLookuptxt4.Source = "SELECT *  FROM tblAM_AccountLookuptxt4"
AccountLookuptxt4.CursorType = 0
AccountLookuptxt4.CursorLocation = 2
AccountLookuptxt4.LockType = 1
AccountLookuptxt4.Open()

AccountLookuptxt4_numRows = 0
%>
<%
Dim AccountLookuptxt5
Dim AccountLookuptxt5_numRows

Set AccountLookuptxt5 = Server.CreateObject("ADODB.Recordset")
AccountLookuptxt5.ActiveConnection = MM_accountlistmanager_STRING
AccountLookuptxt5.Source = "SELECT *  FROM tblAM_AccountLookuptxt5"
AccountLookuptxt5.CursorType = 0
AccountLookuptxt5.CursorLocation = 2
AccountLookuptxt5.LockType = 1
AccountLookuptxt5.Open()

AccountLookuptxt5_numRows = 0
%>
<%
Dim Lookup_State
Dim Lookup_State_numRows

Set Lookup_State = Server.CreateObject("ADODB.Recordset")
Lookup_State.ActiveConnection = MM_accountlistmanager_STRING
Lookup_State.Source = "SELECT *  FROM tblLookupState"
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
Lookup_Country.ActiveConnection = MM_accountlistmanager_STRING
Lookup_Country.Source = "SELECT *  FROM tblLookupCountry"
Lookup_Country.CursorType = 0
Lookup_Country.CursorLocation = 2
Lookup_Country.LockType = 1
Lookup_Country.Open()

Lookup_Country_numRows = 0
%>
<html>
<head>
<title>Insert</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../styles.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
<script language="javascript">
// --- Pure ASP File Upload -----------------------------------------------------
// Copyright 2001-2004 (c) George Petrov, www.DMXzone.com
// Version: 2.18
// ------------------------------------------------------------------------------

function checkFileUpload(form, extensions, requireUpload, sizeLimit, minWidth, minHeight, maxWidth, maxHeight, saveWidth, saveHeight) {
	var allUploadsOK = true;
	document.MM_returnValue = false;
	for (var i = 0; i < form.elements.length; i++) {
		field = form.elements[i];
		if (!field.type || field.type.toUpperCase() != 'FILE') {
			continue;
		}
		checkOneFileUpload(field,extensions,requireUpload,sizeLimit,minWidth,minHeight,maxWidth,maxHeight,saveWidth,saveHeight);
		if (!field.uploadOK) {
			allUploadsOK = false;
			break;
		}
	}
	if (allUploadsOK) {
		document.MM_returnValue = true;
	}
}

function checkOneFileUpload(field, extensions, requireUpload, sizeLimit, minWidth, minHeight, maxWidth, maxHeight, saveWidth, saveHeight) {
	var fileName = field.value.replace(/"/gi,'');
	field.uploadOK = false;
	if (fileName == '') {
		if (requireUpload) {
			alert('File is required!');
			field.focus();
			return;
		} else {
			field.uploadOK = true;
		}
	} else {
		if (extensions != '') {
			checkFileExtension(field, fileName, extensions);
		} else {
			field.uploadOK = true;
		}
		if (!document.layers && field.uploadOK) {  
			document.PU_uploadForm = field.form;
			re = new RegExp("\.(gif|jpg|png|bmp|jpeg)$","i");
			if(re.test(fileName)) { // && (sizeLimit != '' || minWidth != '' || minHeight != '' || maxWidth != '' || maxHeight != '' || saveWidth != '' || saveHeight != '')) {
				checkImageDimensions(field,sizeLimit,minWidth,minHeight,maxWidth,maxHeight,saveWidth,saveHeight);
			}
		}
	}
	return;
}

function checkFileExtension(field, fileName, extensions) {
	var re = new RegExp("\\.(" + extensions.replace(/,/gi,"|").replace(/\s/gi,"") + ")$","i");
	var agt = navigator.userAgent.toLowerCase();
	var is_mac = (agt.indexOf("mac") != -1);
	var is_op = (agt.indexOf("opera") != -1);
	if (is_op) {
		var ext = fileName.substring(fileName.lastIndexOf('.')+1, fileName.length);
		var extArr = extensions.split(',');
		var extCheck = false;
		for (var i = 0; i < extArr.length; i++) {
			if (extArr[i].toLowerCase() == ext.toLowerCase()) {
				extCheck = true;
				break;
			}
		}
		if (extCheck == false) {
			alert('This file type is not allowed for uploading.\nOnly the following file extensions are allowed: ' + extensions + '.\nPlease select another file and try again.');
			field.focus();
			field.uploadOK = false;
			return;
		}
	} else {
		if (!re.test(fileName)) {
			alert('This file type is not allowed for uploading.\nOnly the following file extensions are allowed: ' + extensions + '.\nPlease select another file and try again.');
			field.focus();
			field.uploadOK = false;
			return;
		}
	}
	field.uploadOK = true;
}

function checkImageDimensions(field,sizeL,minW,minH,maxW,maxH,saveW,saveH) {
	var agt = navigator.userAgent.toLowerCase();
	var is_mac = (agt.indexOf("mac") != -1);
  var is_ie = document.all;
	var is_ns6 = (!document.all && document.getElementById ? true : false);
	var fileURL = field.value;
	if (is_ie && is_mac) {
		begPos = fileURL.indexOf('/',1);
		if (begPos != -1) {
			fileURL = fileURL.substring(begPos+1,fileURL.length);
		}
	}
	fileURL = 'file:///' + fileURL.replace(/:\\/gi,'|/').replace(/\\/gi,'/').replace(/:([^|])/gi,'/$1').replace(/"/gi,'').replace(/^\//,'');
	if (!field.gp_img || (field.gp_img && field.gp_img.src != fileURL) || is_ns6) {
		if (is_ie && is_mac) {
			var dummyImage;
			dummyImage = document.createElement('IMG');
			dummyImage.src = 'dummy.gif';
			dummyImage.name = 'PPP';
			field.gp_img = dummyImage;
		} else {
			field.gp_img = new Image();
		}
		with (field) {
			gp_img.field = field;
			gp_img.sizeLimit = sizeL*1024;
			gp_img.minWidth = minW;
			gp_img.minHeight = minH;
			gp_img.maxWidth = maxW;
			gp_img.maxHeight = maxH;
			gp_img.saveWidth = saveW;
			gp_img.saveHeight = saveH;
			gp_img.onload = showImageDimensions;
			gp_img.src = fileURL+'?a=123'; // +(Math.round(Math.random()*998)+1);
		}
	}
}

function showImageDimensions(fieldImg) {
	var is_ns6 = (!document.all && document.getElementById ? true : false);
	var img = (fieldImg && !is_ns6 ? fieldImg : this);
	if (img.width > 0 && img.height > 0) {
		if ((img.minWidth != '' && img.minWidth > img.width) || (img.minHeight != '' && img.minHeight > img.height)) {
			alert('Uploaded Image is too small!\nShould be at least ' + img.minWidth + ' x ' + img.minHeight);
			img.field.uploadOK = false;
			return;
		}
		if ((img.maxWidth != '' && img.width > img.maxWidth) || (img.maxHeight != '' && img.height > img.maxHeight)) {
			alert('Uploaded Image is too big!\nShould be max ' + img.maxWidth + ' x ' + img.maxHeight);
			img.field.uploadOK = false;
			return;
		}
		if (img.sizeLimit != '' && img.fileSize > img.sizeLimit) {
			alert('Uploaded Image File Size is too big!\nShould be max ' + (img.sizeLimit/1024) + ' KBytes');
			img.field.uploadOK = false;
			return;
		}
		if (img.saveWidth != '') {
			document.PU_uploadForm[img.saveWidth].value = img.width;
		}
		if (img.saveHeight != '') {
			document.PU_uploadForm[img.saveHeight].value = img.height;
		}
		if (document.PU_uploadForm[img.field.name+'_width']) {
			document.PU_uploadForm[img.field.name+'_width'].value = img.width;
		}
		if (document.PU_uploadForm[img.field.name+'_height']) {
			document.PU_uploadForm[img.field.name+'_height'].value = img.height;
		}
		img.field.uploadOK = true;
	}
}


function showProgressWindow(progressFile,popWidth,popHeight) {
	var showProgress = false, form, field;
	for (var f = 0; f<document.forms.length; f++) {
		form = document.forms[f];
		for (var i = 0; i<form.elements.length; i++) {
			field = form.elements[i];
			if (!field.type || field.type.toUpperCase() != 'FILE') {
				continue;
			}
			if (field.value != '') {
				showProgress = true;
				break;
			}
		}
	}
	if (showProgress && document.MM_returnValue) {
		var w = 480, h = 340;
		if (document.all || document.layers || document.getElementById) {
			w = screen.availWidth; h = screen.availHeight;
		}
		var leftPos = (w-popWidth)/2, topPos = (h-popHeight)/2;
		document.progressWindow = window.open(progressFile,'ProgressWindow','toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=' + popWidth + ',height='+popHeight);
		document.progressWindow.moveTo(leftPos, topPos);
		document.progressWindow.focus();
		window.onunload = function () {
			document.progressWindow.close();
		};
	}
}
</script>
</head>
<body>
<!--#include file="header.asp" -->
<form action="<%=MM_editAction%>" method="post" enctype="multipart/form-data" name="account_details" id="account_details" onSubmit="checkFileUpload(this,'GIF,JPG,JPEG,BMP,PNG',true,'','','','','','','');return document.MM_returnValue">
  <table width="100%" height="272" align="center" cellpadding="5" cellspacing="0" class="tableborder">
    <tr>
      <td width="49%" height="270" valign="top">     
        <table width="100%" border="0" cellpadding="3" cellspacing="0" class="tableborder">
          <tr class="tableheader">
            <td colspan="3">Company Details:</td>
            <td>Activated: 
            <input name="Activated" type="checkbox" id="Activated" value="True" checked></td>
          </tr>
          <tr class="row2">
            <td width="19%"> Name 1:</td>
            <td width="28%"><input name="OrgName1" type="text" id="OrgName12">
            </td>
            <td width="16%">Name 2:</td>
            <td width="37%"><input name="OrgName12" type="text" id="OrgName122">
            </td>
          </tr>
          <tr class="row2">
            <td colspan="4"> Web Site URL: http://
              <input name="WebsiteURL" type="text" id="WebsiteURL2">
            </td>
          </tr>
        </table>
        <br>
        <table width="100%" border="0" cellpadding="3" cellspacing="0" class="tableborder">
          <tr class="tableheader">
            <td colspan="4"> Address Details</td>
          </tr>
          <tr class="row2">
            <td width="21%">Address 1: </td>
            <td width="32%"><input name="Address1" type="text" id="Address1">
            </td>
            <td width="16%">Phone:</td>
            <td width="31%"><input name="Phone" type="text" id="Phone" >
            </td>
          </tr>
          <tr class="row2">
            <td>Address 2:</td>
            <td><input name="Address2" type="text" id="Address2" >
            </td>
            <td>Cell:</td>
            <td><input name="CellPhone" type="text" id="CellPhone" >
            </td>
          </tr>
          <tr class="row2">
            <td>City:</td>
            <td><input name="City" type="text" id="City">
            </td>
            <td>Fax:</td>
            <td><input name="Fax" type="text" id="Fax" >
            </td>
          </tr>
          <tr class="row2">
            <td>Postal Code:</td>
            <td><input name="PostalCode" type="text" id="PostalCode">
            </td>
            <td>Email:</td>
            <td><input name="AccountEmailAddress" type="text" id="JobTitle3"></td>
          </tr>
          <tr class="row2">
            <td>Province/State:</td>
            <td><select name="State" id="select5">
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
            <td><select name="Country" id="select6">
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
            <td colspan="3"><input name="Map" type="text" id="Map" size="30">
      | <a href="http://ca.maps.yahoo.com" target="_blank">Get URL from Yahoo
      Maps</a></td>
          </tr>
        </table>
        <br>                
        <br>        
        <input name="submit" type="submit" value="Insert Record">
        <br>
      </td>
      <td width="49%" valign="top"><table width="100%" border="0" cellpadding="3" cellspacing="0" class="tableborder">
        <tr>
          <td colspan="2" class="tableheader">Profile Details:</td>
        </tr>
        <tr class="row2">
          <td width="24%">Profile:</td>
          <td width="76%"><textarea name="Profile" cols="40" rows="6" id="textarea"></textarea>
          </td>
        </tr>
        <tr class="row2">
          <td height="27">Image/Logo:</td>
          <td>
            <input name="ImageFile" type="file" id="ImageFile" onChange="checkOneFileUpload(this,'GIF,JPG,JPEG,BMP,PNG',true,'','','','','','','')">
          </td>
        </tr>
      </table>        
        <br>
        <table width="100%" border="0" cellpadding="3" cellspacing="0" class="tableborder">
          <tr class="tableheader">
            <td colspan="2">Additional Details</td>
          </tr>
          <tr class="row2">
            <td width="25%"><%=(Category.Fields.Item("CategoryLabel").Value)%></td>
            <td width="75%"><select name="CategoryID" id="CategoryID">
            <%
While (NOT Category.EOF)
%>
            <option value="<%=(Category.Fields.Item("CategoryID").Value)%>"><%=(Category.Fields.Item("CategoryValue").Value)%></option>
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
      | <a href="javascript:;" onClick="MM_openBrWindow('add_category.asp','Category','scrollbars=yes,width=600,height=400')">Add/Edit
      Category</a> </td>
          </tr>
          <tr class="row2">
            <td>
              <% If Not AccountLookuptxt1.EOF Or Not AccountLookuptxt1.BOF Then %>
              <%=(AccountLookuptxt1.Fields.Item("AccountLookuptxt1ItemName").Value)%>
              <% End If ' end Not AccountLookuptxt1.EOF Or NOT AccountLookuptxt1.BOF %>
            </td>
            <td><select name="AccountLookuptxt1" id="AccountLookuptxt1">
            <%
While (NOT AccountLookuptxt1.EOF)
%>
            <option value="<%=(AccountLookuptxt1.Fields.Item("AccountLookuptxt1ItemValue").Value)%>"><%=(AccountLookuptxt1.Fields.Item("AccountLookuptxt1ItemValue").Value)%></option>
                <%
  AccountLookuptxt1.MoveNext()
Wend
If (AccountLookuptxt1.CursorType > 0) Then
  AccountLookuptxt1.MoveFirst
Else
  AccountLookuptxt1.Requery
End If
%>
              </select>
      | <a href="javascript:;" onClick="MM_openBrWindow('LookupManager/edit_lookuptxt1.asp','Category','scrollbars=yes,width=600,height=400')">Add/Edit
      List</a> </td>
          </tr>
          <tr class="row2">
            <td>
              <% If Not AccountLookuptxt2.EOF Or Not AccountLookuptxt2.BOF Then %>
              <%=(AccountLookuptxt2.Fields.Item("AccountLookuptxt2ItemName").Value)%>
              <% End If ' end Not AccountLookuptxt2.EOF Or NOT AccountLookuptxt2.BOF %>
            </td>
            <td><select name="AccountLookuptxt2" id="AccountLookuptxt2">
            <%
While (NOT AccountLookuptxt2.EOF)
%>
            <option value="<%=(AccountLookuptxt2.Fields.Item("AccountLookuptxt2ItemValue").Value)%>"><%=(AccountLookuptxt2.Fields.Item("AccountLookuptxt2ItemValue").Value)%></option>
                <%
  AccountLookuptxt2.MoveNext()
Wend
If (AccountLookuptxt2.CursorType > 0) Then
  AccountLookuptxt2.MoveFirst
Else
  AccountLookuptxt2.Requery
End If
%>
              </select>
      | <a href="javascript:;" onClick="MM_openBrWindow('LookupManager/edit_lookuptxt2.asp','Category','scrollbars=yes,width=600,height=400')">Add/Edit
      List</a> </td>
          </tr>
          <tr class="row2">
            <td>
              <% If Not AccountLookuptxt3.EOF Or Not AccountLookuptxt3.BOF Then %>
              <%=(AccountLookuptxt3.Fields.Item("AccountLookuptxt3ItemName").Value)%>
              <% End If ' end Not AccountLookuptxt3.EOF Or NOT AccountLookuptxt3.BOF %>
            </td>
            <td><select name="AccountLookuptxt3" id="AccountLookuptxt3">
              <%
While (NOT AccountLookuptxt3.EOF)
%>
              <option value="<%=(AccountLookuptxt3.Fields.Item("AccountLookuptxt3ItemValue").Value)%>"><%=(AccountLookuptxt3.Fields.Item("AccountLookuptxt3ItemValue").Value)%></option>
              <%
  AccountLookuptxt3.MoveNext()
Wend
If (AccountLookuptxt3.CursorType > 0) Then
  AccountLookuptxt3.MoveFirst
Else
  AccountLookuptxt3.Requery
End If
%>
              </select>
      | <a href="javascript:;" onClick="MM_openBrWindow('LookupManager/edit_lookuptxt3.asp','Category','scrollbars=yes,width=600,height=400')">Add/Edit
      List</a> </td>
          </tr>
          <tr class="row2">
            <td>
              <% If Not AccountLookuptxt4.EOF Or Not AccountLookuptxt4.BOF Then %>
              <%=(AccountLookuptxt4.Fields.Item("AccountLookuptxt4ItemName").Value)%>
              <% End If ' end Not AccountLookuptxt4.EOF Or NOT AccountLookuptxt4.BOF %>
            </td>
            <td><select name="AccountLookuptxt4" id="AccountLookuptxt4">
            <%
While (NOT AccountLookuptxt4.EOF)
%>
            <option value="<%=(AccountLookuptxt4.Fields.Item("AccountLookuptxt4ItemValue").Value)%>"><%=(AccountLookuptxt4.Fields.Item("AccountLookuptxt4ItemValue").Value)%></option>
                <%
  AccountLookuptxt4.MoveNext()
Wend
If (AccountLookuptxt4.CursorType > 0) Then
  AccountLookuptxt4.MoveFirst
Else
  AccountLookuptxt4.Requery
End If
%>
              </select>
      | <a href="javascript:;" onClick="MM_openBrWindow('LookupManager/edit_lookuptxt4.asp','Category','scrollbars=yes,width=600,height=400')">Add/Edit
      List</a> </td>
          </tr>
          <tr class="row2">
            <td>
              <% If Not AccountLookuptxt5.EOF Or Not AccountLookuptxt5.BOF Then %>
              <%=(AccountLookuptxt5.Fields.Item("AccountLookuptxt5ItemName").Value)%>
              <% End If ' end Not AccountLookuptxt5.EOF Or NOT AccountLookuptxt5.BOF %>
            </td>
            <td><select name="AccountLookuptxt5" id="AccountLookuptxt5">
            <%
While (NOT AccountLookuptxt5.EOF)
%>
            <option value="<%=(AccountLookuptxt5.Fields.Item("AccountLookuptxt5ItemValue").Value)%>"><%=(AccountLookuptxt5.Fields.Item("AccountLookuptxt5ItemValue").Value)%></option>
                <%
  AccountLookuptxt5.MoveNext()
Wend
If (AccountLookuptxt5.CursorType > 0) Then
  AccountLookuptxt5.MoveFirst
Else
  AccountLookuptxt5.Requery
End If
%>
              </select>
      | <a href="javascript:;" onClick="MM_openBrWindow('LookupManager/edit_lookuptxt5.asp','Category','scrollbars=yes,width=600,height=400')">Add/Edit
      List</a> </td>
          </tr>
        </table>
        <br>
      </td>
    </tr>
  </table>
  <br>
  <input type="hidden" name="MM_insert" value="account_details">
</form>
</body>
</html>
<%
account_details.Close()
Set account_details = Nothing
%>
<%
Category.Close()
Set Category = Nothing
%>
<%
AccountLookuptxt1.Close()
Set AccountLookuptxt1 = Nothing
%>
<%
AccountLookuptxt2.Close()
Set AccountLookuptxt2 = Nothing
%>
<%
AccountLookuptxt3.Close()
Set AccountLookuptxt3 = Nothing
%>
<%
AccountLookuptxt4.Close()
Set AccountLookuptxt4 = Nothing
%>
<%
AccountLookuptxt5.Close()
Set AccountLookuptxt5 = Nothing
%>
<%
Lookup_State.Close()
Set Lookup_State = Nothing
%>
<%
Lookup_Country.Close()
Set Lookup_Country = Nothing
%>

