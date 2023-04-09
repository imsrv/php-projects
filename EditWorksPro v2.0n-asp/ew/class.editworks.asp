<%
  '///////////////////////////////////////////////////////////////////////
  '//                                                                   //
  '//  Program Name    : EditWorks Professional                         //
  '//  Release Version : 2.0                                            //
  '//  Program Author  : SiteCubed Pty. Ltd.                            //
  '//  Supplied by     : CyKuH [WTN]                                    //
  '//  Packaged by     : WTN Team                                       //
  '//  Distribution    : via WebForum, ForumRU and associated file dumps//
  '//                                                                   //
  '//                      WTN Team `2000 - `2002                       //
  '///////////////////////////////////////////////////////////////////////
%>

<% if Request.QueryString("ToDo") = "" then %>
	<link rel="stylesheet" href="ew/ew_includes/ew_styles.css" type="text/css">
<% else %>
	<link rel="stylesheet" href="ew_includes/ew_styles.css" type="text/css">
<% end if %>
<!--#include file="ew_lang/language.asp"-->
<!-- #INCLUDE file="class.fileupload.asp" -->
<%

	'Constant variables to make function calling more logical
	const ew_PATH_TYPE_FULL = 0
	const ew_PATH_TYPE_ABSOLUTE = 1
	const ew_DOC_TYPE_SNIPPET = 0
	const ew_DOC_TYPE_HTML_PAGE = 1
	const ew_IMAGE_TYPE_ROW = 0
	const ew_IMAGE_TYPE_THUMBNAIL = 1


	private sub DisplayIncludes (file, errorMsg)
		
		Const ForReading = 1, ForWriting = 2, ForAppending = 8 
		dim fso, f, ts, fileContent, includeFile
		set fso = server.CreateObject("Scripting.FileSystemObject") 

		includeFile = Server.mapPath("ew_includes/" & file)

		if (fso.FileExists(includeFile)=true) Then
				
			set f = fso.GetFile(includeFile)
			set ts = f.OpenAsTextStream(ForReading, -2) 
				
			Do While not ts.AtEndOfStream
				fileContent = fileContent & ts.ReadLine & vbCrLf
			Loop

			URL = Request.ServerVariables("server_name")
			scriptName = "ew/class.editworks.asp"
				
			'Workout the location of class.editworks.asp
			scriptDir = strreverse(Request.ServerVariables("path_info"))
			slashPos = instr(1, scriptDir, "/")
			scriptDir = strreverse(mid(scriptDir, slashPos, len(scriptDir)))
				
			scriptName = scriptDir & scriptName
				
			fileContent = replace(fileContent,"$URL",URL)
			fileContent = replace(fileContent,"$SCRIPTNAME",ScriptName)
				
			Dim re
			Set re = New RegExp
			re.global = true

			re.Pattern = "\[sTxt(\w*)\]"

			For Each oMatch in re.Execute(fileContent)
			 	fileContent = replace(fileContent,oMatch,eval("sTxt" & oMatch.SubMatches(0)))
			Next

			response.write(fileContent)

		else
			response.write("file not found:" & file)
		End if
		
	End Sub

	' Examine the value of the ToDo argument and proceed to correct sub
	ToDo = Request("ToDo")
			
	if ToDo = "InsertImage" Then
		' pass to imsert image screen
		%><!-- #INCLUDE file="ew_includes/insert_image.asp" --><%
	elseif ToDo = "DeleteImage" Then
		%><!-- #INCLUDE file="ew_includes/insert_image.asp" --><%
	elseif ToDo = "UploadImage" Then
		%><!-- #INCLUDE file="ew_includes/insert_image.asp" --><%
	elseif ToDo = "InsertTable" Then
		DisplayIncludes "insert_table.inc","Insert Table"
	elseif ToDo = "ModifyTable" Then
		DisplayIncludes "modify_table.inc","Modify Table"
	elseif ToDo = "ModifyCell" Then
		DisplayIncludes "modify_cell.inc","Modify Cell"
	elseif ToDo = "ModifyImage" Then
		DisplayIncludes "modify_image.inc","Modify Image"
	elseif ToDo = "InsertForm" Then
		DisplayIncludes "insert_form.inc","Insert Form"
	elseif ToDo = "ModifyForm" Then
		DisplayIncludes "modify_form.inc","Modify Form"
	elseif ToDo = "InsertTextField" Then
		DisplayIncludes "insert_textfield.inc","Insert Text Field"
	elseif ToDo = "ModifyTextField" Then
		DisplayIncludes "modify_textfield.inc","Modify Text Field"
	elseif ToDo = "InsertTextArea" Then
		DisplayIncludes "insert_textarea.inc","Insert Text Area"
	elseif ToDo = "ModifyTextArea" Then
		DisplayIncludes "modify_textarea.inc","Modify Text Area"
	elseif ToDo = "InsertHidden" Then
		DisplayIncludes "insert_hidden.inc","Insert Hidden Field"
	elseif ToDo = "ModifyHidden" Then
		DisplayIncludes "modify_hidden.inc","Modify Hidden Field"
	elseif ToDo = "InsertButton" Then
		DisplayIncludes "insert_button.inc","Insert Button"
	elseif ToDo = "ModifyButton" Then
		DisplayIncludes "modify_button.inc","Modify Button"
	elseif ToDo = "InsertCheckbox" Then
		DisplayIncludes "insert_checkbox.inc","Insert Checkbox"
	elseif ToDo = "ModifyCheckbox" Then
		DisplayIncludes "modify_checkbox.inc","Modify CheckBox"
	elseif ToDo = "InsertRadio" Then
		DisplayIncludes "insert_radio.inc","Insert Radio"
	elseif ToDo = "ModifyRadio" Then
		DisplayIncludes "modify_radio.inc","Modify Radio"
	elseif ToDo = "PageProperties" Then
		DisplayIncludes "page_properties.inc","Page Properties"
	elseif ToDo = "InsertLink" Then
		DisplayIncludes "insert_link.inc","Insert HyperLink"
	elseif ToDo = "InsertEmail" Then
		DisplayIncludes "insert_email.inc","Insert Email Link"
	elseif ToDo = "InsertAnchor" Then
		DisplayIncludes "insert_anchor.inc","Insert Email Link"
	elseif ToDo = "ModifyAnchor" Then
		DisplayIncludes "modify_anchor.inc","Insert Email Link"
	elseif ToDo = "ShowHelp" Then
		DisplayIncludes "help.inc","Help"
	End if

	class ew
	
		private e__controlWidth
		private e__controlHeight
		private e__initialValue
		private e__langPack
		private e__hideBold
		private e__hideUnderline
		private e__hideItalic
		private e__hideNumberList
		private e__hideBulletList
		private e__hideDecreaseIndent
		private e__hideIncreaseIndent
		private e__hideLeftAlign
		private e__hideCenterAlign
		private e__hideRightAlign
		private e__hideJustify
		private e__hideHorizontalRule
		private e__hideLink
		private e__hideAnchor
		private e__hideMailLink
		private e__hideHelp
		private e__hideFont
		private e__hideSize
		private e__hideFormat
		private e__hideStyle
		private e__hideForeColor
		private e__hideBackColor
		private e__hideTable
		private e__hideForm
		private e__hideImage
		private e__hideSymbols
		private e__hideProps
		private e__hideWord
		private e__hideGuidelines
		private e__disableSourceMode
		private e__disablePreviewMode
		private e__guidelinesOnByDefault
		private e__imagePathType
		private e__docType
		private e__imageDisplayType
		private e__disableImageUploading
		private e__disableImageDeleting
		
		'Keep track of how many buttons are hidden in the top row.
		'If they are all hidden, then we dont show that row of the menu.
		private e__numTopHidden
		private e__numBottomHidden
	
		public sub Class_Initialize()

			'Set the default value of all private variables for the class
			 e__controlWidth = 0
			 e__controlHeight = 0
			 e__initialValue = 0
			 e__langPack = 0
			 e__hideBold = 0
			 e__hideUnderline = 0
			 e__hideItalic = 0
			 e__hideNumberList = 0
			 e__hideBulletList = 0
			 e__hideDecreaseIndent = 0
			 e__hideIncreaseIndent = 0
			 e__hideLeftAlign = 0
			 e__hideCenterAlign = 0
			 e__hideRightAlign = 0
			 e__hideJustify = 0
			 e__hideHorizontalRule = 0
			 e__hideLink = 0
			 e__hideAnchor = 0
			 e__hideMailLink = 0
			 e__hideHelp = 0
			 e__hideFont = 0
			 e__hideSize = 0
			 e__hideFormat = 0
			 e__hideStyle = 0
			 e__hideForeColor = 0
			 e__hideBackColor = 0
			 e__hideTable = 0
			 e__hideForm = 0
			 e__hideImage = 0
			 e__hideSymbols = 0
			 e__hideProps = 0
			 e__hideWord = 0
			 e__hideGuidelines = 0
			 e__disableSourceMode = 0
			 e__disablePreviewMode = 0
			 e__guidelinesOnByDefault = 0
 			 e__numTopHidden = 0
			 e__numBottomHidden = 0
			 e__imagePathType = 0
			 e__docType = 0
			 e__imageDisplayType = 0
			 e__disableImageUploading = 0
			 e__disableImageDeleting = 0

		end sub

		public sub SetWidth(Width)
			e__controlWidth = Width
		end sub
		
		public sub SetHeight(Height)
			e__controlHeight = Height
		end sub
		
		public sub SetValue(HTMLValue)

			'Format the initial text so that we can set the content of the iFrame to its value
			e__initialValue = HTMLValue

			if e__initialValue <> "" then

				if isIE55OrAbove = true then
					e__initialValue = HTMLValue
        				e__initialValue = replace(e__initialValue, "'", "\'")
        				e__initialValue = replace(e__initialValue, chr(13)+chr(10), "\r\n")
				else
					e__initialValue = HTMLValue
				end if

			end if

		end sub

		public function GetValue(ConvertQuotes)
		
			dim tmpVal
			
			tmpVal = Request.Form("ew_control_html")

			if ConvertQuotes = true then
				tmpVal = Replace(tmpVal, "'", "''")
				tmpVal = Replace(tmpVal, """", """""")
			end if
			
			GetValue = tmpVal
		
		end function
		
		public sub HideBoldButton()
		
			'Hide the bold button
			e__hideBold = true
			e__numTopHidden = e__numTopHidden + 1
		
		end sub
		
		public sub HideUnderlineButton()
		
			'Hide the underline button
			e__hideUnderline = true
			e__numTopHidden = e__numTopHidden + 1
		
		end sub
		
		public sub HideItalicButton()
		
			'Hide the italic button
			e__hideItalic = true
			e__numTopHidden = e__numTopHidden + 1
		
		end sub

		public sub HideNumberListButton()
		
			'Hide the number list button
			e__hideNumberList = true
			e__numTopHidden = e__numTopHidden + 1
		
		end sub
		
		public sub HideBulletListButton()
		
			'Hide the bullet list button
			e__hideBulletList = true
			e__numTopHidden = e__numTopHidden + 1
		
		end sub

		public sub HideDecreaseIndentButton()
		
			'Hide the decrease indent button
			e__hideDecreaseIndent = true
			e__numTopHidden = e__numTopHidden + 1
		
		end sub
		
		public sub HideIncreaseIndentButton()
		
			'Hide the increase indent button
			e__hideIncreaseIndent = true
			e__numTopHidden = e__numTopHidden + 1
		
		end sub

		public sub HideLeftAlignButton()
		
			'Hide the left align button
			e__hideLeftAlign = true
			e__numTopHidden = e__numTopHidden + 1
		
		end sub
		
		public sub HideCenterAlignButton()
		
			'Hide the center align button
			e__hideCenterAlign = true
			e__numTopHidden = e__numTopHidden + 1
		
		end sub

		public sub HideRightAlignButton()
		
			'Hide the right align button
			e__hideRightAlign = true
			e__numTopHidden = e__numTopHidden + 1
		
		end sub

		public sub HideJustifyButton()
		
			'Hide the left align button
			e__hideJustify = true
			e__numTopHidden = e__numTopHidden + 1
		
		end sub

		public sub HideHorizontalRuleButton()
		
			'Hide the horizontal rule button
			e__hideHorizontalRule = true
			e__numTopHidden = e__numTopHidden + 1
		
		end sub

		public sub HideLinkButton()
		
			'Hide the link button
			e__hideLink = true
			e__numTopHidden = e__numTopHidden + 1
		
		end sub

		public sub HideAnchorButton()
		
			'Hide the anchor button
			e__hideAnchor = true
			e__numTopHidden = e__numTopHidden + 1
		
		end sub

		public sub HideMailLinkButton()
		
			'Hide the mail link button
			e__hideMailLink = true
			e__numTopHidden = e__numTopHidden + 1
		
		end sub

		public sub HideHelpButton()
		
			'Hide the help button
			e__hideHelp = true
			e__numTopHidden = e__numTopHidden + 1
		
		end sub
		
		public sub HideFontList()
		
			'Hide the font list
			e__hideFont = true
			e__numBottomHidden = e__numBottomHidden + 1
		
		end sub

		public sub HideSizeList()
		
			'Hide the size list
			e__hideSize = true
			e__numBottomHidden = e__numBottomHidden + 1
		
		end sub
		
		public sub HideFormatList()
		
			'Hide the format list
			e__hideFormat = true
			e__numBottomHidden = e__numBottomHidden + 1
		
		end sub

		public sub HideStyleList()
		
			'Hide the style list
			e__hideStyle = true
			e__numBottomHidden = e__numBottomHidden + 1
		
		end sub

		public sub HideForeColorButton()
		
			'Hide the forecolor button
			e__hideForeColor = true
			e__numBottomHidden = e__numBottomHidden + 1
		
		end sub
		
		public sub HideBackColorButton()
		
			'Hide the backcolor button
			e__hideBackColor = true
			e__numBottomHidden = e__numBottomHidden + 1
		
		end sub
		
		public sub HideTableButton()
		
			'Hide the table button
			e__hideTable = true
			e__numBottomHidden = e__numBottomHidden + 1
		
		end sub
		
		public sub HideFormButton()
		
			'Hide the form button
			e__hideForm = true
			e__numBottomHidden = e__numBottomHidden + 1
		
		end sub

		public sub HideImageButton()
		
			'Hide the image button
			e__hideImage = true
			e__numBottomHidden = e__numBottomHidden + 1
		
		end sub

		public sub HideSymbolButton()
		
			'Hide the symbol button
			e__hideSymbols = true
			e__numBottomHidden = e__numBottomHidden + 1
		
		end sub

		public sub HidePropertiesButton()
		
			'Hide the properties button
			e__hideProps = true
			e__numBottomHidden = e__numBottomHidden + 1
		
		end sub

		public sub HideCleanHTMLButton()
		
			'Hide the clean HTML button
			e__hideWord = true
			e__numBottomHidden = e__numBottomHidden + 1
		
		end sub

		public sub HideGuidelinesButton()
		
			'Hide the guidelines button
			e__hideGuidelines = true
			e__numBottomHidden = e__numBottomHidden + 1
		
		end sub
		
		public sub DisableSourceMode()
		
			'Hide the source mode button
			e__disableSourceMode = true
		
		end sub
		
		public sub DisablePreviewMode()
		
			'Hide the preview mode button
			e__disablePreviewMode = true
		
		end sub
		
		public sub EnableGuidelines()

			'Set the table guidelines on by default
			e__guidelinesOnByDefault = true

		end sub

		public sub SetPathType(PathType)

			'How do we want to include the path to the images? 0 = Full, 1 = Absolute
			e__imagePathType = PathType

		end sub

		public sub SetDocumentType(DocType)

			'Is the user editing a full HTML document
			e__docType = DocType

		end sub

		public sub SetImageDisplayType(DisplayType)

			'How should the images be displayed in the image manager? 0 = Line / 1 = Thumbnails
			e__imageDisplayType = DisplayType
		
		end sub

		public sub DisableImageUploading()

			'Do we need to stop images being uploaded?
			e__disableImageUploading = 1

		end sub

		public sub DisableImageDeleting()

			'Do we need to stop images from being delete?
			e__disableImageDeleting = 1
		
		end sub

		public function isIE55OrAbove()

			' Is it MSIE?
			browserCheck1 = instr(1, Request.ServerVariables("HTTP_USER_AGENT"), "MSIE")

			if browserCheck1 > 0 then
				browserCheck1 = true
			else
				browserCheck1 = false
			end if

			' Is it version 5.5 or above?
			browserCheck2 = instr(1, Request.ServerVariables("HTTP_USER_AGENT"), "5.5") + instr(1, Request.ServerVariables("HTTP_USER_AGENT"), "6.0")

			if browserCheck2 > 0 then
				browserCheck2 = true
			else
				browserCheck2 = false
			end if

			' Is it NOT Opera?
			browserCheck3 = instr(1, Request.ServerVariables("HTTP_USER_AGENT"), "Opera")

			if browserCheck3 = 0 then
				browserCheck3 = true
			else
				browserCheck3 = false
			end if

			if browserCheck1 = true AND browserCheck2 = true AND browserCheck3 = true then
				isIE55OrAbove = true
			else
				isIE55OrAbove = false
			end if

		end function

		public sub ShowControl(Width, Height, ImagePath)

			SetWidth(Width)
			SetHeight(Height)

			' If the browser isn't IE5.5 or above, show a <textarea> tag and die
			if isIE55OrAbove = false then
			%>
				<span style="background-color: lightyellow"><font face="verdana" size="1" color="red"><b>Your browser must be IE5.5 or above to display the EditWorks control. A plain text box will be displayed instead.</b></font></span><br>
				<textarea style="width:<%=e__controlWidth %>; height:<%=e__controlHeight%>" rows="10" cols="30" name="ew_control_html"><%=e__initialValue%></textarea>
			<%
			else
        
        			'Do we need to hide the page properties button?
        			if e__hideProps <> 0 or e__docType = 0 then
        				HidePropertiesButton
        			end if
        			
        			Dim re
        			Set re = New RegExp
        			re.global = true
        
        			re.Pattern = "\[sTxt(\w*)\]"
        
        			Dim oMatches, oMatch
        
        			Const ForReading = 1, ForWriting = 2, ForAppending = 8 
        			dim fso, f, ts, fileContent, includeFile
        
        			' Print JSFunctions
        			set fso = server.CreateObject("Scripting.FileSystemObject") 
        
        			includeFile = Server.mapPath("ew/ew_includes/jsfunctions.inc")
        
        			if (fso.FileExists(includeFile)=true) Then
        				set f = fso.GetFile(includeFile)
        				set ts = f.OpenAsTextStream(ForReading, -2) 
        				Do While not ts.AtEndOfStream
        				 		fileContent = fileContent & ts.ReadLine & vbCrLf
        				Loop
        				
        				URL = Request.ServerVariables("server_name")
        				scriptName = "ew/class.editworks.asp"
        				
        				'Workout the location of class.editworks.asp
        				scriptDir = strreverse(Request.ServerVariables("path_info"))
        				slashPos = instr(1, scriptDir, "/")
        				scriptDir = strreverse(mid(scriptDir, slashPos, len(scriptDir)))
        				
        				scriptName = scriptDir & scriptName
        
        				fileContent = replace(fileContent,"$URL", URL)
        				fileContent = replace(fileContent,"$SCRIPTNAME", scriptName)
        				fileContent = replace(fileContent,"$IMAGEDIR", Server.URLEncode(ImagePath))
        				fileContent = replace(fileContent,"$SHOWTHUMBNAILS", e__imageDisplayType)
        				fileContent = replace(fileContent,"$EDITINGHTMLDOC", e__docType)
        				fileContent = replace(fileContent,"$PATHTYPE", e__imagePathType)
        				fileContent = replace(fileContent,"$GUIDELINESDEFAULT", e__guidelinesOnByDefault)
        				fileContent = replace(fileContent,"$DISABLEIMAGEUPLOADING", e__disableImageUploading)
        				fileContent = replace(fileContent,"$DISABLEIMAGEDELETING", e__disableImageDeleting)
        								
        				For Each oMatch in re.Execute(fileContent)
        				 	fileContent = replace(fileContent,oMatch,eval("sTxt" & oMatch.SubMatches(0)))
        				Next
        
        				response.write(fileContent)
        			else
        				response.write("jsfunctions.inc: file not found")
        				response.end
        			End if
        
        			%>
        			<table id="fooContainer" width="<%=e__controlWidth%>" height="<%=e__controlHeight%>" border="1" cellspacing="0" cellpadding="0">
        					<tr>
        						<td height=1>
        			<%
        
        			'Include the toolbar
        			%><!-- #INCLUDE file="ew_includes/toolbar.asp" -->
        			
        							</td></tr>
        							<tr><td>
        							<table class=iframe height=100% width=100%>
        								<tr height=100%>
        									<td>
        										<iFrame onBlur="updateValue()" SECURITY="restricted" contenteditable HEIGHT=100% id="foo" style="width:100%;"></iFrame>
        										<iframe onBlur="updateValue()" id=previewFrame height=100% style="width=100%; display:none"></iframe>
        										<input type="hidden" name="ew_control_html" value="">
        									</td>
        								</tr>
        							</table>
        							</td></tr>
        							<tr><td height=1>
        							<table cellpadding=0 cellspacing=0 width=100% style="background-color: threedface" class=status>
        								<tr>
        									<td background=ew/ew_images/status_border.gif height=22><img style="cursor:hand;" id=editTab src=ew/ew_images/status_edit_up.gif width=98 height=22 border=0 onClick=editMe()><img style="cursor:hand; <% if e__disableSourceMode = true then %>display:none<% end if %>" id=sourceTab src=ew/ew_images/status_source.gif width=98 height=22 border=0 onClick=sourceMe()><img style="cursor:hand; <% if e__disablePreviewMode = true then %>display:none<% end if %>" id=previewTab src=ew/ew_images/status_preview.gif width=98 height=22 border=0 onClick=previewMe()></td>
        									<td background=ew/ew_images/status_border.gif id=statusbar align=right>&nbsp;</td>
        								</tr>
        							</table>
        						</td>
        					</tr>
        				</table>
        
        				<script language="JavaScript">
        							
        					var fooWidth = "<%=e__controlWidth %>";
        					var fooHeight = "<%=e__controlHeight %>";
        
        					function setValue()
        					{
        						<% if e__docType = 0 then %>
        							foo.document.write('');
        							foo.document.close()
									foo.document.body.innerHTML = '<%=e__initialValue%>'
        						<% else %>
        							foo.document.write('<%=e__initialValue%>');
        							foo.document.close()
        						<% end if %>
        					}
        
        					function updateValue()
        					{
									if (document.activeElement) {
										if (document.activeElement.parentElement.id == "ew") {
											return false;
										} else {
											document.all.ew_control_html.value = SaveHTMLPage();
										}
									}
        					}
        							
        				</script>
        
        			<%

			end if
			
		end sub
		
	end class
%>

