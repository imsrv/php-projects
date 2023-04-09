<%
'~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
'Upload Script Version 1.0
'Copyright © 2003, Yusuf Wiryonoputro. All rights reserved.
'~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
Class Upload

	Private nFileCount
	Private dictRequest
	Private dictRequestFiles(5,5)
	
	Private sAllowedTypes
	Private nMaxFileSize
	Private sErrMsg

	Public Function Recieve()
		sContentType = Request.ServerVariables("HTTP_CONTENT_TYPE")	
		if InStr(sContentType,"multipart/form-data")=0 Then	
			sErrMsg =  ""
			Recieve = false 'return false
			Exit Function
		End If	
			
		binData = Request.BinaryRead(Request.TotalBytes) '1
		if Request.Totalbytes > nMaxFileSize then			
			sErrMsg =  "The posted data exceeds the maximum size allowed."
			Recieved = false 'return false
			Exit Function
		End If	
		'binData = Request.BinaryRead(Request.TotalBytes) '2
		
		'Kalau 1 enable => tdk error
		'Kalau 1 disable, 2 enable => error		
		
		lenBinData = lenB(binData)
		set adoRs = server.CreateObject("ADODB.Recordset")
		If lenBinData>0 Then
			adoRs.Fields.Append "UploadData", 201, lenBinData
			adoRs.Open
			adoRs.AddNew
			adoRs("UploadData").AppendChunk binData
			adoRs.Update
			sData = adoRs("UploadData")
		End If
				
		arrTemp = split(sContentType,";")
		sBoundary = Split(Trim(arrTemp(1)), "=")(1)
		arrFieldValue = Split(sData,sBoundary)
				
		set dictRequest = server.CreateObject("Scripting.Dictionary")
		sBrowser = UCase(Request.ServerVariables("HTTP_USER_AGENT"))
				
		nFileCount=0
		For i=0 To UBound(arrFieldValue)
			fieldSeparate = InStr(arrFieldValue(i), Chr(13) & Chr(10) & Chr(13) & Chr(10))
			If fieldSeparate>0 Then
				fieldEnd	= fieldSeparate-3
				valueStart	= fieldSeparate+4
				valueEnd	= Len(arrFieldValue(i)) - fieldSeparate - 4 - 3
						
				sFieldRaw	= Mid(arrFieldValue(i), 3 , fieldEnd)
				sValue		= Mid(arrFieldValue(i), valueStart , valueEnd)
						
				If InStr(sFieldRaw,"filename=")>0 Then

					sLocal = getLocal(sFieldRaw)
					If InStr(sBrowser,"WIN")>0 Then
						posStart = InStrRev(sLocal, "\") + 1
						sFileName = Mid(sLocal, posStart)
					End If					
					If InStr(sBrowser,"MAC")>0 Then
						sFileName = sLocal
					End If					
							
					dictRequestFiles(nFileCount,0) = getFieldName(sFieldRaw)
					dictRequestFiles(nFileCount,1) = sFileName
					dictRequestFiles(nFileCount,2) = sValue
					dictRequestFiles(nFileCount,3) = sLocal
					dictRequestFiles(nFileCount,4) = getFileType(sFieldRaw)
					dictRequestFiles(nFileCount,5) = IsAllowed(sFileName)
						
					nFileCount=nFileCount+1
				Else
					dictRequest.Add getFieldName(sFieldRaw),sValue			
				End If
			End If
		Next
		Recieve = true
	End Function

	'~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~	
	'	PRIVATE
	'~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~	
	Private Function getFieldName(s)
		posStart = InStr(s, "name=") + 6 '6 krn ada tambahan "
		if InStr(s,Chr(34) & ";")>0 Then 'Chr(34) = "		
			's => Content-Disposition: form-data; name="File1"; filename="C:\Documents and Settings\Ys\My Documents\mytext.txt"
			'	  Content-Type: text/plain
			posEnd = InStr( posStart , s, Chr(34) & ";" )
		Else
			's => Content-Disposition: form-data; name="inpNewFileName"
			posEnd = inStr( posStart , s, Chr(34))		
		End If	
		getFieldName = Mid(s, posStart , posEnd - posStart)
	End Function

	Private Function getLocal(s)
		posStart = InStr(s, "filename=") + 10
		posEnd = InStr(s, Chr(34) & Chr(13) & Chr(10))
		getLocal = Mid(s, posStart, posEnd-posStart)
	End Function

	Private Function getFileType(s)
		posStart = InStr(s, "Content-Type: ")
		GetFileType = Mid(s, posStart + 14)
	End Function
	
	Private Function IsAllowed(sFileName)
		For Each Item In Split(sFileName,".")
			sExtention = Item
		Next

		IsAllowed = false
		For Each Item In Split(sAllowedTypes,"|")
			If LCase(sExtention) = LCase(Item) Then
				IsAllowed = true
			End If
		Next
	End Function	
	
	'~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~	
	'	PUBLIC
	'~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~	
	Public Property Let AllowedTypes(sVal)
		sAllowedTypes = sVal
	End Property
	
	Public Property Get AllowedTypes
		AllowedTypes = sAllowedTypes
	End Property	
	
	Public Property Let MaxFileSize(nVal)
		nMaxFileSize = nVal
	End Property
	
	Public Property Get MaxFileSize
		MaxFileSize = nMaxFileSize
	End Property	

	Public Property Get ErrMsg
		ErrMsg = sErrMsg
	End Property
	
	'~~~~~~~~~~~~	
	Public Function RequestValue(s)
		if Len(CStr(nFileCount)) = 0 then 
			RequestValue = null
			exit function
		End If
		For i=0 To nFileCount
			if dictRequestFiles(i,0) = s Then
			
				RequestValue = dictRequestFiles(i,1)
				exit function
			End If
		Next	
		RequestValue = dictRequest(s)
	End Function

	Public Function RequestFileContent(s)
		if Len(CStr(nFileCount)) = 0 then 
			RequestFileContent = null
			exit function
		End If
		For i=0 To nFileCount
			if dictRequestFiles(i,0) = s Then
			
				RequestFileContent = dictRequestFiles(i,2)
				exit function
			End If
		Next
		RequestFileContent = null
	End Function

	Public Function RequestFileStatus(s)
		if Len(CStr(nFileCount)) = 0 then
			RequestFileStatus = null
			exit function
		End If
		For i=0 To nFileCount
			if dictRequestFiles(i,0) = s Then
				RequestFileStatus = dictRequestFiles(i,5)
				exit function
			End If
		Next
	End Function

	Public Function RequestFileType(s)
		if Len(CStr(nFileCount)) = 0 then 
			RequestFileType = null
			exit function
		End If
		For i=0 To nFileCount
			if dictRequestFiles(i,0) = s Then
			
				RequestFileType = dictRequestFiles(i,4)
				exit function
			End If
		Next
		RequestFileType = null
	End Function
	
	Public Function SaveFile(sPath,sContent)
		Set fso = server.CreateObject("Scripting.FileSystemObject")
		Set sFile = fso.CreateTextFile(sPath, True) 'Hati2
		sFile.Write(sContent)
		sFile.Close	
		Set fso = Nothing
	End Function
	
End Class
%>