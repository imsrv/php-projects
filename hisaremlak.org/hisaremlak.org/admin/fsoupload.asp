<!-- #include file = "../config.asp" -->

<%
'###############################
' Upload Script v1.0           #
'  Powered by www.boldluck.at  #
'    Christopher Söllinger     #
'###############################

FontSize  = 11 ' Write in the font size in pixel (Example: 11 = 11px)
FontColor = "#000000" ' Write in the font color with Hexa Numbers (Example: #000000)
FontTyp   = "Arial" ' Write in the font name (Example: Arial)

TableBackGround = "#FFFFCC" ' Write in the Hex-Code for the table background
TableBorder = 1 ' Write in the border width (Example: 1 = 1px; 0 = 0px)
TableBorderStyle = "solid" ' Write in the border style with CSS properties (Example: solid)
TableBorderColor = "#000000" ' Write in the Hex-Code for the border color (Example: #000000)

UploadFieldSize = 500 ' Write in the field size from the upload fields (Example: 500 = 500px)
UploadFieldBackGround = "#FFFFFF" ' Write in the background color from the upload fields (Example: #FFFFFF)
UploadFields = 1 ' Write in how many upload fields you want

SubmitButtonText = "Resimleri Yükle" ' Write in the text that stand on the Submit Button

if request.QueryString("action")="resim" then 
SavePath = resimklasoru  ' Write in the path where you want save the uploads
end if
if request.QueryString("action")="video" then 
SavePath = videoklasoru  ' Write in the path where you want save the uploads
end if


MaxSize = 409600 ' Write in the maximum upload size in Byte(s) (max. Beispiel: 5242880)
FileTypen = ".jpg;.png;.psd;.JPG;.GIF;.PNG;.PSD;.flv;.FLV;" ' Write in the filtypes that you can upload. So write a "." (Point), than the filetyp (Exp: gif) and than a ";" (Semikolon)

MyFileTypes = Split(FileTypen,";")
%>

<%
Class FileUploader
	Public  Files
	Private mcolFormElem

	Private Sub Class_Initialize()
		Set Files = Server.CreateObject("Scripting.Dictionary")
		Set mcolFormElem = Server.CreateObject("Scripting.Dictionary")
	End Sub
	
	Private Sub Class_Terminate()
		If IsObject(Files) Then
			Files.RemoveAll()
			Set Files = Nothing
		End If
		If IsObject(mcolFormElem) Then
			mcolFormElem.RemoveAll()
			Set mcolFormElem = Nothing
		End If
	End Sub

	Public Property Get Form(sIndex)
		Form = ""
		If mcolFormElem.Exists(LCase(sIndex)) Then Form = mcolFormElem.Item(LCase(sIndex))
	End Property

	Public Default Sub Upload()
		Dim biData, sInputName
		Dim nPosBegin, nPosEnd, nPos, vDataBounds, nDataBoundPos
		Dim nPosFile, nPosBound

		biData = Request.BinaryRead(Request.TotalBytes)
		nPosBegin = 1
		nPosEnd = InstrB(nPosBegin, biData, CByteString(Chr(13)))
		
		If (nPosEnd-nPosBegin) <= 0 Then Exit Sub
		 
		vDataBounds = MidB(biData, nPosBegin, nPosEnd-nPosBegin)
		nDataBoundPos = InstrB(1, biData, vDataBounds)
		
		Do Until nDataBoundPos = InstrB(biData, vDataBounds & CByteString("--"))
			
			nPos = InstrB(nDataBoundPos, biData, CByteString("Content-Disposition"))
			nPos = InstrB(nPos, biData, CByteString("name="))
			nPosBegin = nPos + 6
			nPosEnd = InstrB(nPosBegin, biData, CByteString(Chr(34)))
			sInputName = CWideString(MidB(biData, nPosBegin, nPosEnd-nPosBegin))
			nPosFile = InstrB(nDataBoundPos, biData, CByteString("filename="))
			nPosBound = InstrB(nPosEnd, biData, vDataBounds)
			
			If nPosFile <> 0 And  nPosFile < nPosBound Then
				Dim oUploadFile, sFileName
				Set oUploadFile = New UploadedFile
				
				nPosBegin = nPosFile + 10
				nPosEnd =  InstrB(nPosBegin, biData, CByteString(Chr(34)))
				sFileName = CWideString(MidB(biData, nPosBegin, nPosEnd-nPosBegin))
				oUploadFile.FileName = Right(sFileName, Len(sFileName)-InStrRev(sFileName, "\"))

				nPos = InstrB(nPosEnd, biData, CByteString("Content-Type:"))
				nPosBegin = nPos + 14
				nPosEnd = InstrB(nPosBegin, biData, CByteString(Chr(13)))
				
				oUploadFile.ContentType = CWideString(MidB(biData, nPosBegin, nPosEnd-nPosBegin))
				
				nPosBegin = nPosEnd+4
				nPosEnd = InstrB(nPosBegin, biData, vDataBounds) - 2
				oUploadFile.FileData = MidB(biData, nPosBegin, nPosEnd-nPosBegin)
				
				If oUploadFile.FileSize > 0 Then Files.Add LCase(sInputName), oUploadFile
			Else
				nPos = InstrB(nPos, biData, CByteString(Chr(13)))
				nPosBegin = nPos + 4
				nPosEnd = InstrB(nPosBegin, biData, vDataBounds) - 2
				If Not mcolFormElem.Exists(LCase(sInputName)) Then mcolFormElem.Add LCase(sInputName), CWideString(MidB(biData, nPosBegin, nPosEnd-nPosBegin))
			End If

			nDataBoundPos = InstrB(nDataBoundPos + LenB(vDataBounds), biData, vDataBounds)
		Loop
	End Sub

	'String to byte string conversion
	Private Function CByteString(sString)
		Dim nIndex
		For nIndex = 1 to Len(sString)
		   CByteString = CByteString & ChrB(AscB(Mid(sString,nIndex,1)))
		Next
	End Function

	'Byte string to string conversion
	Private Function CWideString(bsString)
		Dim nIndex
		CWideString =""
		For nIndex = 1 to LenB(bsString)
		   CWideString = CWideString & Chr(AscB(MidB(bsString,nIndex,1))) 
		Next
	End Function
End Class

Class UploadedFile
	Public ContentType
	Public FileName
	Public FileData
	
	Public Property Get FileSize()
		FileSize = LenB(FileData)
	End Property

	Public Sub SaveToDisk(sPath)
		Dim oFS, oFile
		Dim nIndex
	
		If sPath = "" Or FileName = "" Then Exit Sub
		If Mid(sPath, Len(sPath)) <> "\" Then sPath = sPath & "\"
	
		Set oFS = Server.CreateObject("Scripting.FileSystemObject")
		If Not oFS.FolderExists(sPath) Then Exit Sub
		
		Set oFile = oFS.CreateTextFile(sPath & FileName, True)
		
		For nIndex = 1 to LenB(FileData)
		    oFile.Write Chr(AscB(MidB(FileData,nIndex,1)))
		Next

		oFile.Close
	End Sub
End Class

Function CheckFileTyp(FileName)
	CheckFileTyp = false
	
	For intI = 0 to Ubound(MyFileTypes)
		If instr(FileName,MyFileTypes(intI)) > 0 Then
			CheckFileTyp = true
		End If
	Next
End Function

Function CheckSize(FileSize)
	CheckSize = false
	
	If FileSize < MaxSize Then
		CheckSize = true
	End If
End Function
%>




<%
' Make the file uploader
Dim Uploader, File
Set Uploader = New FileUploader

' we start the upload process
Uploader.Upload()

' We check if a file was upload else we have an error
If Uploader.Files.Count = 0 Then
	Fehler = 1
Else
	' We start with a For
	For Each File In Uploader.Files.Items
		' Check if the filetyp is correct
		If CheckFileTyp(File.FileName) = false Then
			Fehler = 2
		Else
			FileName = File.FileName
		End If

		' Check if the file is smaller than the maximum size
		If CheckSize(File.FileSize) = false Then
			Fehler = 3
			FileSize = File.FileSize
		End If

		If Fehler = "" Then
			File.SaveToDisk SavePath
		End If
	Next
End If

Select Case Fehler
	Case 1
		FehlerMessage = FehlerMessage & "<b>Resim seçmemiþsiniz!</b>"
		response.write FehlerMessage
		response.write "<a href='uploadstart.asp'> Geri </a>"
		response.end		
	Case 2
		FehlerMessage = FehlerMessage & "<b>Dosya tanýnmýyor! Yükleyebileceðiniz dosya tipleri: " & FileTypen & "!</b>"
		response.write FehlerMessage
		response.write "<a href='uploadstart.asp'> Geri </a>"
		response.end
	Case 3
		FehlerMessage = FehlerMessage & "<b>Dosya çok büyük!<br>Maximum büyüklük: " & MaxSize & " olmalý... <br>Sizin dosyanýz: " & FileSize
		response.write FehlerMessage
		response.write "<a href='uploadstart.asp'> Geri </a>"
		response.end
End Select

If Fehler = "" Then
	FehlerMessage = FehlerMessage & "Seçilen Resim >> " & FileName & " yüklendi"
	HeaderTitle = "Yükleme tamamlandý!"
Else
	HeaderTitle = "Hata!!!"
End If
%>

<% 
session("dosya")=FileName

if request.QueryString("action")="resim" then 
response.Redirect("actions.asp?step=emlak&action=thumb&emlakid="&request.querystring("emlakid"))
end if

if request.QueryString("action")="video" then 
response.Redirect("actions.asp?step=emlak&action=video&emlakid="&request.querystring("emlakid"))
end if

%>
