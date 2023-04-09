<%@LANGUAGE="VBSCRIPT"%>
<!--#include virtual="/Connections/eventlistingmanager.asp"-->
<%
'*** Pure ASP File Upload 2.1.8
Dim GP_uploadAction,UploadQueryString
PureUploadSetup
If (CStr(Request.QueryString("GP_upload")) <> "") Then
  Dim pau_thePath,pau_Extensions,pau_Form,pau_Redirect,pau_storeType,pau_sizeLimit,pau_nameConflict,pau_requireUpload,pau_minWidth,pau_minHeight,pau_maxWidth,pau_maxHeight,pau_saveWidth,pau_saveHeight,pau_timeout,pau_progressBar,pau_progressWidth,pau_progressHeight
  pau_thePath = """../../applications/EventListingManager/images"""
  pau_Extensions = ""
  pau_Form = "form1"
  pau_Redirect = ""
  pau_storeType = "file"
  pau_sizeLimit = ""
  pau_nameConflict = "over"
  pau_requireUpload = "false"
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
  MM_editConnection = MM_eventlistingmanager_STRING
  MM_editTable = "tblEventListings"
  MM_editRedirectUrl = "admin.asp"
  MM_fieldsStr  = "CategoryID|value|ItemName|value|ItemDesc|value|ItemDescShort|value|EventLocation|value|LocationMap|value|EventStartDate|value|EventEndDate|value|EventStartTime|value|EventEndTime|value|EventPresenter|value|ItemPrice|value|UnitOfMeasure|value|ImageFileA|value|ImageFileB|value|Feature1|value|Feature2|value|Feature3|value|Feature4|value|Feature5|value|Activated|value"
  MM_columnsStr = "CategoryID|none,none,NULL|ItemName|',none,''|ItemDesc|',none,''|ItemDescShort|',none,''|EventLocation|',none,''|LocationMap|',none,''|EventStartDate|',none,NULL|EventEndDate|',none,NULL|EventStartTime|',none,NULL|EventEndTime|',none,NULL|EventPresenter|',none,''|ItemPrice|none,none,NULL|UnitOfMeasure|',none,''|ImageFileA|',none,''|ImageFileB|',none,''|Feature1|',none,''|Feature2|',none,''|Feature3|',none,''|Feature4|',none,''|Feature5|',none,''|Activated|',none,''"
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
set List_Events = Server.CreateObject("ADODB.Recordset")
List_Events.ActiveConnection = MM_eventlistingmanager_STRING
List_Events.Source = "SELECT *  FROM tblEventListings"
List_Events.CursorType = 0
List_Events.CursorLocation = 2
List_Events.LockType = 3
List_Events.Open()
List_Events_numRows = 0
%>
<%
set Category = Server.CreateObject("ADODB.Recordset")
Category.ActiveConnection = MM_eventlistingmanager_STRING
Category.Source = "SELECT *  FROM tblEventCategory  ORDER BY CategoryID"
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
      <form ACTION="<%=MM_editAction%>" METHOD="post" enctype="multipart/form-data" name="form1" onSubmit="checkFileUpload(this,'',false,'','','','','','','');return document.MM_returnValue">
        <table width="100%" align="center" class="tableborder">
          <tr align="right" valign="top">
            <td colspan="2" class="tableheader">Insert New </td>
          </tr>
          <tr align="right" valign="top">
            <td class="tableheader">Category:</td>
            <td align="left">
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
      category</a> <img src="questionmark.gif" alt="Select a category that best describes the Event i.e. Sporting Event" width="15" height="15"></td>
          </tr>
          <tr align="right" valign="top">
            <td class="tableheader">Event name:</td>
            <td align="left">
              <input name="ItemName" type="text" id="ItemName" value="Enter name of event" size="50">
            <img src="questionmark.gif" alt="Enter the name of the event" width="15" height="15">            </td>
          </tr>
          <tr align="right" valign="top">
            <td class="tableheader">Event Description:</td>
            <td align="left">
              <textarea name="ItemDesc" cols="50" rows="5" id="ItemDesc">Enter Description of Event</textarea>
            <img src="questionmark.gif" alt="Enter a description of the event" width="15" height="15">            </td>
          </tr>
          <tr align="right" valign="top">
            <td class="tableheader">Event Short Description:</td>
            <td align="left">
            <textarea name="ItemDescShort" cols="50" rows="5" id="ItemDescShort"></textarea>
            <img src="questionmark.gif" alt="Enter a short description of the event" width="15" height="15"></td>
          </tr>
          <tr align="right" valign="top">
            <td class="tableheader">Event Location:</td>
            <td align="left"><textarea name="EventLocation" cols="30" id="EventLocation"></textarea>
            <img src="questionmark.gif" alt="Enter the location of the event including Address Details" width="15" height="15"></td>
          </tr>
		   <tr align="right" valign="top">
            <td class="tableheader">Link to Map:</td>
            <td align="left">            <input name="LocationMap" type="text" id="LocationMap" size="50">              
            <img src="questionmark.gif" alt="Enter the URL to yahoo Maps" width="15" height="15"> <a href="http://ca.maps.yahoo.com" target="_blank">Visit
            Yahoo Maps</a></td>
          </tr>
          <tr align="right" valign="top">
            <td class="tableheader">Event Date:</td>
            <td align="left"> Start Date 
            <input name="EventStartDate" type="text" id="EventStartDate" value="<% =Date()%>"> 
            End date
            <input name="EventEndDate" type="text" id="EventEndDate" value="<% =Date()%>">
            <img src="questionmark.gif" alt="Enter the start/end date of the event" width="15" height="15"></td>
          </tr>
          <tr align="right" valign="top">
            <td class="tableheader">Event Time:</td>
            <td align="left">Start Time 
              <input name="EventStartTime" type="text" id="EventStartTime" value="<% =Time()%>">
End Time
<input name="EventEndTime" type="text" id="EventEndTime" value="<% =Time()%>">
<img src="questionmark.gif" alt="Enter the start/end time of the event" width="15" height="15"></td>
          </tr>
          <tr align="right" valign="top">
            <td class="tableheader">Event Presented By:</td>
            <td align="left"><input name="EventPresenter" type="text" id="EventPresenter">
            <img src="questionmark.gif" alt="Enter the presenter/sponsor of the event" width="15" height="15"></td>
          </tr>
          <tr align="right" valign="top">
            <td class="tableheader">Price:</td>
            <td align="left"><input name="ItemPrice" type="text" id="EventStartDate3"> 
              /              
                <select name="UnitOfMeasure" id="UnitOfMeasure">
                <option value="Person">Person</option>
                </select>
                <img src="questionmark.gif" alt="Enter a price associated with the event" width="15" height="15"></td>
          </tr>
          <tr align="right" valign="top">
            <td class="tableheader">Image A:</td>
            <td align="left">            <input name="ImageFileA" type="file" id="ImageFileA" onChange="checkOneFileUpload(this,'',false,'','','','','','','')" value="" size="32"></td>
          </tr>
          <tr align="right" valign="top">
            <td class="tableheader">Image B:</td>
            <td align="left"><input name="ImageFileB" type="file" id="ImageFileB" onChange="checkOneFileUpload(this,'',false,'','','','','','','')" value="" size="32"></td>
          </tr>
          <tr align="right" valign="top">
            <td class="tableheader">Feature 1: </td>
            <td align="left"><input name="Feature1" type="text" id="Feature1">
            <img src="questionmark.gif" alt="Enter a special feature of the event" width="15" height="15"></td>
          </tr>
          <tr align="right" valign="top">
            <td class="tableheader">Feature 2: </td>
            <td align="left"><input name="Feature2" type="text" id="Feature2">
              <img src="questionmark.gif" alt="Enter a special feature of the event" width="15" height="15"></td>
          </tr>
          <tr align="right" valign="top">
            <td class="tableheader">Feature 3: </td>
            <td align="left"><input name="Feature3" type="text" id="Feature3">
              <img src="questionmark.gif" alt="Enter a special feature of the event" width="15" height="15"></td>
          </tr>
          <tr align="right" valign="top">
            <td class="tableheader">Feature 4: </td>
            <td align="left"><input name="Feature4" type="text" id="Feature4">
            <img src="questionmark.gif" alt="Enter a special feature of the event" width="15" height="15"></td>
          </tr>
          <tr align="right" valign="top">
            <td class="tableheader">Feature 5: </td>
            <td align="left"><input name="Feature5" type="text" id="Feature5">
            <img src="questionmark.gif" alt="Enter a special feature of the event" width="15" height="15"></td>
          </tr>
          <tr align="right" valign="top">
            <td class="tableheader">Activated:</td>
            <td align="left">
              <input type="checkbox" name="Activated" value=True checked>
            <img src="questionmark.gif" alt="(Check if you want this link to be visible to the public)(Ucheck if you wish to hide)" width="15" height="15">            </td>
          </tr>
          <tr align="right" valign="top">
            <td class="tableheader">&nbsp;</td>
            <td align="left"><input name="submit" type="submit" value="Publish to Event Listings page">
</td>
          </tr>
        </table>     
        <input type="hidden" name="MM_insert" value="form1">
      </form>
</body>
</html>
<%
List_Events.Close()
%>
<%
Category.Close()
%>



