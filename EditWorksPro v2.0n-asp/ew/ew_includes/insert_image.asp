<%

	On Error Resume next
	
	'Get a list of images from the directory
	set objFSO = Server.CreateObject("Scripting.FileSystemObject")

	validImageTypes = array("image/pjpeg", "image/jpeg", "image/gif", "image/x-png")
	ImageDirectory = Request("imgDir")
	
	URL = Request.ServerVariables("server_name")
	scriptName = "class.editworks.asp"

	'Workout the location of class.editworks.asp
	scriptDir = strreverse(Request.ServerVariables("path_info"))
	slashPos = instr(1, scriptDir, "/")
	scriptDir = strreverse(mid(scriptDir, slashPos, len(scriptDir)))
	
	if Request("imgSrc") <> "" then
	
		'Delete the image
		imgPath = ImageDirectory & "/" & Request("imgSrc")
		objFSO.DeleteFile Server.MapPath(imgPath)

	end if
	
	if request.querystring("ToDo") = "UploadImage" then
	
		'Upload the image to the images directory
		set objFile = new Loader
		objFile.Initialize

		newFileName = objFile.GetFileName("upload")
		newFileType = objFile.GetContentType("upload")
		newFileData = objFile.GetFileData("upload")
		validFileType = false
		errorText = ""

		'Is this a valid file type?
		for i = 0 to uBound(validImageTypes)
			if(newFileType = validImageTypes(i)) then
				validFileType = true
			end if
		next
	
		if validFileType = false then
			'Invalid file type
			statusText = sTxtImageErr
		else
		
			uploadSuccess = objFile.SaveToFile("upload", Server.MapPath(ImageDirectory & "/" & newFileName))
			statusText = newFileName & " " & sTxtImageSuccess & "!"
		
		end if
	
	end if

	SImageDirectory = Server.MapPath(ImageDirectory)

	If (objFSO.FolderExists(SImageDirectory) = true) Then
		set objImageDir = objFSO.GetFolder(SImageDirectory)
	else
		response.write "Your image directory has not been configured correctly"
		response.end
	End if

	' set objImageDir = objFSO.GetFolder(SImageDirectory)
	set objImageList = objImageDir.Files
	counter = 0
	
%>

<script language=JavaScript>
window.onload = this.focus

function deleteImage(imgSrc)
{
	var delImg = confirm("<%=sTxtImageDelete%>");

	if (delImg == true) {
		document.location.href = 'http://<%=Request.ServerVariables("server_name")%><%=scriptDir%>class.editworks.asp?ToDo=DeleteImage&imgDir=<%=ImageDirectory%>&tn=<%=Request.QueryString("tn")%>&imgSrc='+imgSrc;
	}

}

function setBackground(imgSrc)
{
	var setBg = confirm("<%=sTxtImageSetBackgd%>?");

	if (setBg == true) {
		window.opener.setBackgd('http://<%=Request.ServerVariables("server_name")%><%=ImageDirectory%>/' + imgSrc);
		self.close();
	}
}

function viewImage(imgSrc)
{
	var sWidth =  screen.availWidth;
	var sHeight = screen.availHeight;
	
	window.open('<%=ImageDirectory%>/' + imgSrc, 'image', 'width=700, height=500,left='+(sWidth/2-350)+',top='+(sHeight/2-500));
}

function grey(tr) {
		tr.className = 'b4';
}

function ungrey(tr) {
		tr.className = '';
}

function insertImage(imgSrc) {
	error = 0

	var sel = window.opener.foo.document.selection;
	if (sel!=null) {
		var rng = sel.createRange();
	   	if (rng!=null) {

			HTMLTextField = '<img src="http://<%=Request.ServerVariables("server_name")%><%=ImageDirectory%>/'+imgSrc+'">';
			rng.pasteHTML(HTMLTextField)
		} // End if
	} // End If

	if (error != 1) {
		window.opener.foo.focus();
		self.close();
	}
} // End function

</script>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
	<td width="15"><img src="_images/1x1.gif" width="15" height="1"></td>
	  <td class="heading1"><%=sTxtInsertImage%></td>
  </tr>
  <tr>
	<form enctype="multipart/form-data" action="http://<%=Request.ServerVariables("server_name")%><%=scriptDir%>class.editworks.asp?ToDo=UploadImage&imgDir=<%=ImageDirectory%>&tn=<%=Request.QueryString("tn")%>" method="post">
	<td>&nbsp;</td>
	  <td class="body"><%=sTxtInsertImageInst%><br>
		<%=sTxtCloseWin%>
		<br><br>
		<% if Request("du") <> "1" then %>
			<%=sTxtUploadImage%>: <input type="file" name="upload" class="Text220"> <input type="submit" value="Upload" class="Text50">
			<br><br><span class="err"><%=statusText%></span>
		<% end if %>
	  </td>
	</form>
  </tr>
  <tr>
	<td>&nbsp;</td>
	<td class="body">
	  <table width="98%" border="0" cellspacing="0" cellpadding="0" class="bevel1">
  		<tr>
		    <td>&nbsp;&nbsp;<%=sTxtInsertImage%></td>
		</tr>
	  </table>
	</td>
  </tr>
  <tr>
	<td colspan="2"><img src="ew_images/1x1.gif" width="1" height="10"></td>
  </tr>
  <tr>
	<td>&nbsp;</td>
	<td class="body">

	<% if Request.QueryString("tn") = 1 then %>
	    <table border="0" cellspacing="0" cellpadding="10" width="98%" class="bevel2">
	<% else %>
		<table border="0" cellspacing="0" cellpadding="3" width="98%" class="bevel2">
	<% end if %>

		  <tr>

		<% if Request.QueryString("tn") = 1 then

			for each imageFile in objImageList
			%>
				<td width="25%">
					<span class="body"><%=imageFile.name%><br></span>
					<img align="left" src="<%=ImageDirectory & "/" & imageFile.name %>" width="80" height="80" border=1>
					<br><a href="javascript:viewImage('<%=imageFile.name%>')" class="imagelink"><%=sTxtImageView%></a><br>
					<a href="javascript:insertImage('<%=imageFile.name%>')" class="imagelink"><%=sTxtImageInsert%></a><br>
					<% if Request("dt") <> "0" then %>
						<a href="javascript:setBackground('<%=imageFile.name%>')" class="imagelink"><%=sTxtImageBackgd%></a><br>
					<% end if %>
					<% if Request("dd") <> "1" then %>
						<a href="javascript:deleteImage('<%=Server.URLEncode(imageFile.name)%>')" class="imagelink"><%=sTxtImageDel%></a><br>
					<% end if %>
				</td>
			<%
			
				counter = counter + 1
				
				if counter MOD 4 = 0 then
					response.write "</tr><tr>"
				end if
			
			next
		%>
	    
	    <% else
	    
			%>
			
				</tr>
				<tr>
					<td width="40%">
						<span class="body"><b>&nbsp;<%=sTxtImageName%></b></span>
					</td>
					<td width="20%">
						<span class="body"><b><%=sTxtFileSize%></b></span>
					</td>
					<td width="10%">
						<span class="body"><b><%=sTxtImageView%></b></span>
					</td>
					<td width="10%">
						<span class="body"><b><%=sTxtImageInsert%></b></span>
					</td>
					<% if Request("dt") <> "0" then %>
						<td width="10%">
							<span class="body"><b><%=sTxtImageBackgd%></b></span>
						</td>
					<% end if %>
					<% if Request("dd") <> "1" then %>
						<td width="10%">
							<span class="body"><b><%=sTxtImageDel%></b></span>
						</td>
					<% end if %>
				</tr>
			<%
			
			for each imageFile in objImageList
			%>
				<tr onmouseover="grey(this)" onmouseout="ungrey(this)">
					<td width="40%" class="body">
						&nbsp;<%=imageFile.name%>
					</td>
					<td width="20%" class="body">
						<%=imageFile.size%> Bytes
					</td>
					<td width="10%">
						<a href="javascript:viewImage('<%=imageFile.name%>')" class="imagelink"><%=sTxtImageView%></a>
					</td>
					<td width="10%">
						<a href="javascript:insertImage('<%=imageFile.name%>')" class="imagelink"><%=sTxtImageInsert%></a>
					</td>
					<% if Request("dt") <> "0" then %>
						<td width="10%">
						<a href="javascript:setBackground('<%=imageFile.name%>')" class="imagelink"><%=sTxtImageBackgd%></a>
						</td>
					<% end if %>
					<% if Request("dd") <> "1" then %>
						<td width="10%">
							<a href="javascript:deleteImage('<%=Server.URLEncode(imageFile.name)%>')" class="imagelink"><%=sTxtImageDel%></a>
						</td>
					<% end if %>
				</tr>
			<%
			next
	    
	    end if %>

	    </table>
	</td>
  </tr>
  <tr>
	<td colspan="2"><img src="ew_images/1x1.gif" width="1" height="10"></td>
  </tr>
  <tr>
  <td></td>
	<td>
	<input type="button" name="Submit" value="<%=sTxtCancel%>" class="Text50" onClick="javascript:window.close()">
	</td>
  </tr>
</table>
