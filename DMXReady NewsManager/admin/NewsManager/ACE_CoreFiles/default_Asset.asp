<!--#include file="include/UploadScript.asp"-->
<%
assetFolder = "/applications/assets"

if Request.QueryString("action")="del" then
	file = request.QueryString("file")
	Set objFSO1 = Server.CreateObject("Scripting.FileSystemObject")
	Set MyFile = objFSO1.GetFile(server.MapPath(file))
	MyFile.Delete
	Response.Redirect "default_Asset.asp?catid="& request.QueryString("catid")
end if

if Request.QueryString("action")="upload" then

	Set oUpload = New Upload 
	oUpload.AllowedTypes = "gif|jpg|png|swf|wmv|avi|wma|wav|mid|doc|xls|ppt|txt|zip|pdf"
	oUpload.MaxFileSize = 3000000
	If oUpload.Recieve() Then
		ImageCateg= oUpload.RequestValue("inpcatid")'Image Folder
		If oUpload.RequestFileStatus("inpFile") Then
			sPath = ImageCateg & "\" & oUpload.RequestValue("inpFile")
			sContent = oUpload.RequestFileContent("inpFile")		
			oUpload.SaveFile sPath,sContent		
		End If
	End If
	Set oUpload = Nothing

	Response.Redirect "default_Asset.asp?catid="&ImageCateg
End If


dim objFSO
dim objMainFolder

dim strOptions
dim strHTML
dim catid

strHTML = ""

set objFSO = server.CreateObject ("Scripting.FileSystemObject")
set objMainFolder = objFSO.GetFolder(server.MapPath(assetFolder))
	     
catid = CStr(request("catid"))'bisa form, bisa querystring
if catid="" then catid = objMainFolder.path

dim objTempFSO
dim objTempFolder
dim objTempFiles
dim objTempFile

set objTempFSO = server.CreateObject ("Scripting.FileSystemObject")
set objTempFolder = objTempFSO.GetFolder (catid)
set objTempFiles = objTempFolder.files

strHTML = strHTML & "<table border=0 cellpadding=3 cellspacing=0 width=240>"
for each objTempFile in objTempFiles

	'***********
	'objTempFile.path => image physical path
	'basePath => base path
	set basePath = objFSO.GetFolder(server.MapPath(assetFolder))
	PhysicalPathWithoutBase = Replace(objTempFile.path,basePath.path,"")	
	sTmp = replace(PhysicalPathWithoutBase,"\","/")'fix from physical to virtual
	sCurrImgPath = assetFolder & sTmp
	'***********

	strHTML = strHTML & "<tr bgcolor=Lavender>"
	strHTML = strHTML & "<td valign=top>" & objTempFile.name & "</td>"
	strHTML = strHTML & "<td valign=top>" & FormatNumber(objTempFile.size/1000,0) & " kb</td>"
	strHTML = strHTML & "<td valign=top style=""cursor:hand;"" onclick=""selectFile('" & sCurrImgPath   & "')""><u><font color=blue>select</font></u></td>"
	strHTML = strHTML & "<td valign=top style=""cursor:hand;"" onclick=""deleteFile('" & sCurrImgPath & "')""><u><font color=blue>del</font></u></td></tr>"

next
strHTML = strHTML & "</table>"

Function createCategoryOptions(pi_objFolder)
    dim objFolder
    dim objFolders
	
    set objFolders = pi_objfolder.SubFolders
    for each objFolder in objFolders 
		'Recursive programming starts here
		createCategoryOptions objFolder
    next
    
    if pi_objFolder.attributes and 2 then
		'hidden folder then do nothing
	else	

'***********
set basePath = objFSO.GetFolder(server.MapPath(assetFolder))
'response.Write catid & " - " & oo.path
Response.Write Replace(pi_objFolder.path,basePath.path,"")	
'***********
	
		if CStr(catid)=CStr(pi_objFolder.path) then
			strOptions = strOptions & "<option value=""" & pi_objFolder.path & """ selected>" & Replace(pi_objFolder.path,basePath.path,"")	 & "</option>" & vbCrLf
		else
			strOptions = strOptions & "<option value=""" & pi_objFolder.path & """>" & Replace(pi_objFolder.path,basePath.path,"")	  & "</option>" & vbCrLf
		end if
    end if
    
    strOptions = strOptions & vbCrLf
    createCategoryOptions = strOptions
End Function
%>
<html>
<head>
	<title>My Files</title>
	
	<style>

	BODY
		{
		FONT-FAMILY: Verdana;FONT-SIZE: xx-small;
		}
	TABLE
		{
	    FONT-SIZE: xx-small;
	    FONT-FAMILY: Tahoma
		}
	INPUT
		{
		font:8pt verdana,arial,sans-serif;
		}
	select
		{
		height: 22px; 
		top:2;
		font:8pt verdana,arial,sans-serif
		}	
	.bar 
		{
		BORDER-TOP: #99ccff 1px solid; BACKGROUND: #336699; WIDTH: 100%; BORDER-BOTTOM: #000000 1px solid; HEIGHT: 20px
		}		
	</style>
		
	<script language="JavaScript">
	function deleteFile(sURL)
		{
		if (confirm("Delete this file ?") == true) 
			{
			window.navigate("default_Asset.asp?action=del&file="+sURL+"&catid="+form2.catid.value);
			}
		}
	function selectFile(sURL)
		{
		//reset
		panel_Flash.style.display = "none"
		panel_Link.style.display = "none"
		
		inpSRC.value = sURL
		
		//get media type
		var arrTmp = inpSRC.value.split(".");
		var FileExtension = arrTmp[arrTmp.length-1]
		var MediaType = ""
		if(FileExtension=="wmv"||FileExtension=="avi") MediaType = "Video"
		if(FileExtension=="wma"||FileExtension=="wav"||FileExtension=="mid") MediaType = "Sound"
		if(FileExtension=="gif"||FileExtension=="jpg") MediaType = "Image"
		if(FileExtension=="swf") MediaType = "Flash"
				
		switch(MediaType)
			{
			case "Flash":
				inpMediaType.value = "Flash"
				panel_Flash.style.display = "block"
				break;
			case "Video":
				inpMediaType.value = "Video"
				break;
			case "Image":
				inpMediaType.value = "Image"
				break;	
			case "Sound":
				inpMediaType.value = "Sound"
				break;
			default:
				inpMediaType.value = "File"
				panel_Link.style.display = "block"
				break;
			}
		}
	function applyLink()
		{
		oName=window.opener.oUtil.oName
		if(inpInsType.value=="Hyperlink")
			{//Insert as hyperlink
			eval("window.opener."+oName).InsertAsset_Hyperlink(inpSRC.value,inpLinkText.value)
			}
		else
			{//Auto
			switch(inpMediaType.value)
				{
				case "Flash":
					eval("window.opener."+oName).InsertAsset_Flash(inpSRC.value,inpFlashWidth.value,inpFlashHeight.value)
					break;
				case "Video":
					eval("window.opener."+oName).InsertAsset_Video(inpSRC.value)	
					break;
				case "Image":
					eval("window.opener."+oName).InsertAsset_Image(inpSRC.value)	
					break;	
				case "Sound":
					eval("window.opener."+oName).InsertAsset_Sound(inpSRC.value)
					break;
				default:
					eval("window.opener."+oName).InsertAsset_Hyperlink(inpSRC.value,inpLinkText.value)
					break;
				}
			}
		}
	</script>
	
</head>
<body>
<h1>My Files</h1>

		<table border=0 cellpadding=3 cellspacing=3 ID="Table2">
		<tr>
  		<td valign=top>
				<form method=post action=<%=Request.ServerVariables("SCRIPT_NAME")%> id=form2 name=form2>
						<table border=0 height=30 cellpadding=0 cellspacing=0 ID="Table3"><tr>
						<td><b>Select folder&nbsp;:&nbsp;</b></td>
						<td>
						<select id=catid name=catid onchange="form2.submit()">
						<%=createCategoryOptions(objMainFolder)%>
						</select> 
						</td></tr></table>
				</form>
				
				<table border=0 cellpadding=0 cellspacing=0 width=260 ID="Table4">
				<tr><td>
				<div class="bar" style="padding-left: 5px;">
				<font size="2" face="tahoma" color="white"><b>File Name</b></font>
				</div>
				</td></tr>
				</table>
				
				<div style="overflow:auto;height:120;width:260;BORDER-LEFT: #316AC5 1px solid;BORDER-RIGHT: LightSteelblue 1px solid;BORDER-BOTTOM: LightSteelblue 1px solid;">
				<%=strHTML%>
				</div>

				<form METHOD="Post" ENCTYPE="multipart/form-data" ACTION="default_Asset.asp?action=upload" ID="form1" name="form1">
					Upload file : <br>
					<input type="file" id="inpFile" name=inpFile size=22><br>
					<input name="inpcatid" ID="inpcatid" type=hidden>
					<input TYPE="button" value="Upload" onclick="inpcatid.value=form2.catid.value;form1.submit()" ID="Button1" NAME="Button1">
				</form>		
				
		</td>						
		</tr>
		</table>

<hr>

<table cellpadding=3 cellspacing=0 ID="Table1">

<!-- Source -->
<tr>
<td>Source: </td><td><input type="text" ID="inpSRC" NAME="inpSRC" size=30></td>
</tr>
<!-- /Source -->

<!-- Media Type -->
<tr>
<td valign=top>Media Type: </td><td>
	<input type="text" ID="inpMediaType" NAME="inpMediaType" size=7 disabled>
	</td>
</tr>
<!-- /Media Type -->

<!-- Insert_Link -->
<tr id="panel_Link" style="display:none">
<td>Link Text: </td><td><input type="text" ID="inpLinkText" NAME="inpLinkText"></td>
</tr>
<!-- /Insert_Link -->

<!-- Insert_Flash -->
<tr id="panel_Flash" style="display:none">
<td>
	Dimension:  
</td>
<td>
	Width: <input type="text" ID="inpFlashWidth" NAME="inpFlashWidth" size=4 value=150>
	Height: <input type="text" ID="inpFlashHeight" NAME="inpFlashHeight" size=4 value=150>
</td>
</tr>
<!-- /Insert_Flash -->

<!-- Insertion Type-->
<tr>
<td valign=top>Insertion Type: </td><td>
	<select ID="inpInsType" NAME="inpInsType">
	<option value="Auto" selected>Auto</option>
	<option value="Hyperlink">As hyperlink</option>
	</select>
	</td>
</tr>
<!-- /Insertion Type-->

</table>
<br>

<input type="button" value="CANCEL" onclick="self.close();" ID="Button2" NAME="Button2">
<input type="button" value=" O K "  onclick="applyLink();self.close();" ID="Button3" NAME="Button3">

</body>
</html> 

