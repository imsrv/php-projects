<!--#include file="include/UploadScript.asp"-->
<%
imgFolder = "../images" 'Locate your image folder here

if Request.QueryString("action")="del" then
	filepath = request.QueryString("file")
	Set objFSO1 = Server.CreateObject("Scripting.FileSystemObject")
	Set MyFile = objFSO1.GetFile(Server.MapPath(filepath))
	MyFile.Delete
	Response.Redirect "default_Image.asp?catid="& request.QueryString("catid")
end if

if Request.QueryString("action")="upload" then

	Set oUpload = New Upload 
	oUpload.AllowedTypes = "gif|jpg|png"
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

	Response.Redirect "default_Image.asp?catid="&ImageCateg
End If
'~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
%>
<html>
<head>
	<title>Insert/Update Image</title>
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
</head>
<%
dim objFSO
dim objMainFolder

dim strOptions
dim strHTML
dim catid

strHTML = ""

set objFSO = server.CreateObject ("Scripting.FileSystemObject")
set objMainFolder = objFSO.GetFolder(server.MapPath(imgFolder))
	     
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
	set basePath = objFSO.GetFolder(server.MapPath(imgFolder))
	PhysicalPathWithoutBase = Replace(objTempFile.path,basePath.path,"")	
	sTmp = replace(PhysicalPathWithoutBase,"\","/")'fix from physical to virtual
	sCurrImgPath = imgFolder & sTmp
	'***********

	strHTML = strHTML & "<tr bgcolor=Gainsboro>"
	strHTML = strHTML & "<td valign=top>" & objTempFile.name & "</td>"
	'strHTML = strHTML & "<td valign=top>" & objTempFile.type & "</td>"
	strHTML = strHTML & "<td valign=top>" & FormatNumber(objTempFile.size/1000,0) & " kb</td>"
	strHTML = strHTML & "<td valign=top style=""cursor:hand;"" onclick=""selectImage('" & sCurrImgPath  & "')""><u><font color=blue>select</font></u></td>"
	strHTML = strHTML & "<td valign=top style=""cursor:hand;"" onclick=""deleteImage('" & sCurrImgPath & "')""><u><font color=blue>del</font></u></td></tr>"
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
set basePath = objFSO.GetFolder(server.MapPath(imgFolder))
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

function ConstructPath(str)
    str  = mid(str,len(server.MapPath ("./"))+1)
    ConstructPath = replace(str,"\","/")
end function
%>
<body onload="checkImage()" link=Blue vlink=MediumSlateBlue alink=MediumSlateBlue leftmargin=5 rightmargin=5 topmargin=5 bottommargin=5 bgcolor=Gainsboro>



	<table border="0" cellpadding="0" cellspacing="0" ID="Table1">
	<tr>
	<td valign=top>
		<!-- Content -->

		<table border=0 cellpadding=3 cellspacing=3 align=center ID="Table2">
		<tr>
		<td align=center style="BORDER-TOP: #336699 1px solid;BORDER-LEFT: #336699 1px solid;BORDER-RIGHT: #336699 1px solid;BORDER-BOTTOM: #336699 1px solid;" bgcolor=White>
				<div id="divImg" style="overflow:auto;width:150;height:170"></div>
		</td>  
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

				<form METHOD="Post" ENCTYPE="multipart/form-data" ACTION="default_Image.asp?action=upload" ID="form1" name="form1">
				Upload Image : <br>
				<input type="file" id="inpFile" name=inpFile size=22 style="font:8pt verdana,arial,sans-serif"><br>
				<input name="inpcatid" ID="inpcatid" type=hidden>
				<input TYPE="button" value="Upload" onclick="inpcatid.value=form2.catid.value;form1.submit()" ID="Button1" NAME="Button1">
				</form>		
				
		</td>						
		</tr>
		<tr>
		<td colspan=2>
				
				<hr>	
				<table border=0 width=340 cellpadding=0 cellspacing=1 ID="Table5">
				<tr>
						<td>Image source : </td>
						<td colspan=3>
						<input type="text" id="inpImgURL" name=inpImgURL size=39>
						<!--<font color=red>(you can type your own image path here)</font>-->
						</td>		
				</tr>					
				<tr>
						<td>Alternate text : </td>
						<td colspan=3><input type="text" id="inpImgAlt" name=inpImgAlt size=39></td>		
				</tr>				
				<tr>
						<td>Alignment : </td>
						<td>
						<select ID="inpImgAlign" NAME="inpImgAlign">
								<option value="" selected>&lt;Not Set&gt;</option>
								<option value="absBottom">absBottom</option>
								<option value="absMiddle">absMiddle</option>
								<option value="baseline">baseline</option>
								<option value="bottom">bottom</option>
								<option value="left">left</option>
								<option value="middle">middle</option>
								<option value="right">right</option>
								<option value="textTop">textTop</option>
								<option value="top">top</option>						
						</select>
						</td>
						<td>Image border :</td>
						<td><select id=inpImgBorder name=inpImgBorder>
							<option value=0>0</option>
							<option value=1>1</option>
							<option value=2>2</option>
							<option value=3>3</option>
							<option value=4>4</option>
							<option value=5>5</option>
						</select>
						</td>					
				</tr>
				<tr>
						<td>Width :</td>
						<td><input type="text" ID="inpImgWidth" NAME="inpImgWidth" size=2></td>
						<td>Horizontal Spacing :</td>
						<td><input type="text" ID="inpHSpace" NAME="inpHSpace" size=2></td>
				</tr>				
				<tr>
						<td>Height :</td>
						<td><input type="text" ID="inpImgHeight" NAME="inpImgHeight" size=2></td>
						<td>Vertical Spacing :</td>
						<td><input type="text" ID="inpVSpace" NAME="inpVSpace" size=2></td>
				</tr>
				</table>

		</td>
		</tr>
		<tr>
		<td align=center colspan=2>
				<table cellpadding=0 cellspacing=0 align=center ID="Table6"><tr>
				<td><input type="button" value="Cancel" onclick="self.close();" style="height: 22px;font:8pt verdana,arial,sans-serif" ID="Button2" NAME="Button1"></td>
				<td>
				<span id="btnImgInsert" style="display:none">
				<input type="button" value="Insert" onclick="InsertImage();self.close();" style="height: 22px;font:8pt verdana,arial,sans-serif" ID="Button3" NAME="Button2">
				</span>
				<span id="btnImgUpdate" style="display:none">
				<input type="button" value="Update" onclick="UpdateImage();self.close();" style="height: 22px;font:8pt verdana,arial,sans-serif" ID="Button4" NAME="Button3">
				</span>				
				</td>
				</tr></table>
		</td>
		</tr>
		</table>

		<!-- /Content -->
		<br>
	</td>
	</tr>
	</table>



<script language="JavaScript">
function deleteImage(sURL)
	{
	if (confirm("Delete this document ?") == true) 
		{
		window.navigate("default_Image.asp?action=del&file="+sURL+"&catid="+form2.catid.value);
		}
	}
function selectImage(sURL)
	{
	inpImgURL.value = sURL;
	
	divImg.style.visibility = "hidden"
	divImg.innerHTML = "<img id='idImg' src='" + sURL + "'>";
	

	var width = idImg.width
	var height = idImg.height 
	var resizedWidth = 150;
	var resizedHeight = 170;

	var Ratio1 = resizedWidth/resizedHeight;
	var Ratio2 = width/height;

	if(Ratio2 > Ratio1)
		{
		if(width*1>resizedWidth*1)
			idImg.width=resizedWidth;
		else
			idImg.width=width;
		}
	else
		{
		if(height*1>resizedHeight*1)
			idImg.height=resizedHeight;
		else
			idImg.height=height;
		}
	
	divImg.style.visibility = "visible"
	}

/***************************************************
	If you'd like to use your own Image Library :
	- use InsertImage() method to insert image
		Params : url,alt,align,border,width,height,hspace,vspace
	- use UpdateImage() method to update image
		Params : url,alt,align,border,width,height,hspace,vspace
	- use these methods to get selected image properties :
		imgSrc()
		imgAlt()
		imgAlign()
		imgBorder()
		imgWidth()
		imgHeight()
		imgHspace()
		imgVspace()
		
	Sample uses :
		window.opener.obj1.InsertImage(...[params]...)
		window.opener.obj1.UpdateImage(...[params]...)
		inpImgURL.value = window.opener.obj1.imgSrc()
	
	Note: obj1 is the editor object.
	We use window.opener since we access the object from the new opened window.
	If we implement more than 1 editor, we need to get first the current 
	active editor. This can be done using :
	
		oName=window.opener.oUtil.oName // return "obj1" (for example)
		obj = eval("window.opener."+oName) //get the editor object
		
	then we can use :
		obj.InsertImage(...[params]...)
		obj.UpdateImage(...[params]...)
		inpImgURL.value = obj.imgSrc()
		
***************************************************/	
function checkImage()
	{
	oName=window.opener.oUtil.oName
	obj = eval("window.opener."+oName)
	
	if (obj.imgSrc()!="") selectImage(obj.imgSrc())//preview image
	inpImgURL.value = obj.imgSrc()
	inpImgAlt.value = obj.imgAlt()
	inpImgAlign.value = obj.imgAlign()
	inpImgBorder.value = obj.imgBorder()
	inpImgWidth.value = obj.imgWidth()
	inpImgHeight.value = obj.imgHeight()
	inpHSpace.value = obj.imgHspace()
	inpVSpace.value = obj.imgVspace()

	if (obj.imgSrc()!="") //If image is selected 
		btnImgUpdate.style.display="block";
	else
		btnImgInsert.style.display="block";
	}
function UpdateImage()
	{
	oName=window.opener.oUtil.oName
	eval("window.opener."+oName).UpdateImage(inpImgURL.value,inpImgAlt.value,inpImgAlign.value,inpImgBorder.value,inpImgWidth.value,inpImgHeight.value,inpHSpace.value,inpVSpace.value);	
	}
function InsertImage()
	{
	oName=window.opener.oUtil.oName
	eval("window.opener."+oName).InsertImage(inpImgURL.value,inpImgAlt.value,inpImgAlign.value,inpImgBorder.value,inpImgWidth.value,inpImgHeight.value,inpHSpace.value,inpVSpace.value);
	}	
/***************************************************/
</script>
<input type=text style="display:none;" id="inpActiveEditor" name="inpActiveEditor" contentEditable=true>
</body>
</html>