<table width="100%" cellspacing="0" cellpadding="0" class=toolbar>
	<tr>
	<td class="body" height="22">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="hide" align="center" id="toolbar_preview">
		<tr>
		  <td class="body" height="57">
		  &nbsp;&nbsp;&nbsp;<b>Preview Mode</b>
		  </td>
		 </tr>
	</table>
	 <table width="100%" border="0" cellspacing="0" cellpadding="0" class="hide" align="center" id="toolbar_code">
		<tr>
		  <td class="body" height="22">
		  <table border="0" cellspacing="0" cellpadding="1">
			  <tr id=ew>
				<td>
				  <img border="0" src="ew/ew_images/button_cut.gif" width="21" height="20" onmouseover="button_over(this);" onmouseout="button_out(this);" onmousedown="button_down(this);" onClick='document.execCommand("Cut");foo.focus();' title="<%=sTxtCut%> (Ctrl+X)" class=toolbutton>
				</td>
				<td>
				  <img border="0" src="ew/ew_images/button_copy.gif" width="21" height="20" onmouseover="button_over(this);" onmouseout="button_out(this);" onmousedown="button_down(this);" onClick='document.execCommand("Copy");foo.focus();' title="<%=sTxtCopy%> (Ctrl+C)" class=toolbutton>
				</td>
				<td>
				  <img border="0" src="ew/ew_images/button_paste.gif" width="21" height="20" onmouseover="button_over(this);" onmouseout="button_out(this);" onmousedown="button_down(this);" onClick='document.execCommand("Paste");foo.focus();' title="<%=sTxtPaste%> (Ctrl+V)" class=toolbutton>
				</td>
				<td><img src="ew/ew_images/seperator.gif" width="2" height="20"></td>
				<td>
				  <img border="0" src="ew/ew_images/button_undo.gif" width="21" height="20" onmouseover="button_over(this);" onmouseout="button_out(this);" onmousedown="button_down(this);" onClick='doCommand("Undo");' title="<%=sTxtUndo%> (Ctrl+Z)" class=toolbutton>
				</td>
				<td>
				  <img border="0" src="ew/ew_images/button_redo.gif" width="21" height="20" onmouseover="button_over(this);" onmouseout="button_out(this);" onmousedown="button_down(this);" onClick='doCommand("Redo");' title="<%=sTxtRedo%> (Ctrl+Y)" class=toolbutton>
				</td>
				</tr>
			</table>
		  </td>
		 </tr>
		 <tr>
		  <td class="body" bgcolor="#000000"><img src="ew/ew_images/1x1.gif" width="1" height="1"></td>
		</tr>
		 <tr><td height=29>&nbsp;</td></tr>
	</table>
	  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="bevel3" align="center" id="toolbar_full">
		<tr>
		  <td class="body" height="22">
			<table border="0" cellspacing="0" cellpadding="1">
			  <tr id=ew>
					<td>
						<img border="0" src="ew/ew_images/button_cut.gif" width="21" height="20" onmouseover="button_over(this);" onmouseout="button_out(this);" onmousedown="button_down(this);" onClick='doCommand("Cut");foo.focus();' title="<%=sTxtCut%> (Ctrl+X)" class=toolbutton>
					</td>
					<td>
						<img border="0" src="ew/ew_images/button_copy.gif" width="21" height="20" onmouseover="button_over(this);" onmouseout="button_out(this);" onmousedown="button_down(this);" onClick='doCommand("Copy");foo.focus();' title="<%=sTxtCopy%> (Ctrl+C)" class=toolbutton>
					</td>
					<td>
						<img border="0" src="ew/ew_images/button_paste.gif" width="21" height="20" onmouseover="button_over(this);" onmouseout="button_out(this);" onmousedown="button_down(this);" onClick='doCommand("Paste");foo.focus();' title="<%=sTxtPaste%> (Ctrl+V)" class=toolbutton>
					</td>
					<td>
						<img src="ew/ew_images/seperator.gif" width="2" height="20">
					</td>
					<td>
						<img border="0" src="ew/ew_images/button_undo.gif" width="21" height="20" onmouseover="button_over(this);" onmouseout="button_out(this);" onmousedown="button_down(this);" onClick='doCommand("Undo");' title="<%=sTxtUndo%> (Ctrl+Z)" class=toolbutton>
					</td>
					<td>
						<img border="0" src="ew/ew_images/button_redo.gif" width="21" height="20" onmouseover="button_over(this);" onmouseout="button_out(this);" onmousedown="button_down(this);" onClick='doCommand("Redo");' title="<%=sTxtRedo%> (Ctrl+Y)" class=toolbutton>
					</td>
					<td><img src="ew/ew_images/seperator.gif" width="2" height="20"></td>
				  <% if e__hideBold <> true then %>
					<td>
						<img id=bold border="0" src="ew/ew_images/button_bold.gif" width="21" height="20" onmouseover="button_over(this);" onmouseout="button_out(this);" onmousedown="button_down(this);" onClick='doCommand("Bold");foo.focus();' title="<%=sTxtBold%> (Ctrl+B)" class=toolbutton>
					</td>
				  <% end if %>
				  <% if e__hideUnderline <> true then %>
					<td>
						<img id=underline border="0" src="ew/ew_images/button_underline.gif" width="21" height="20" onmouseover="button_over(this);" onmouseout="button_out(this);" onmousedown="button_down(this);" onClick='doCommand("Underline");foo.focus();' title="<%=sTxtUnderline%> (Ctrl+U)" class=toolbutton>
					</td>
				  <% end if %>
				  <% if e__hideItalic <> true then %>
					<td>
						<img border="0" src="ew/ew_images/button_italic.gif" width="21" height="20" onmouseover="button_over(this);" onmouseout="button_out(this);" onmousedown="button_down(this);" onClick='doCommand("Italic");foo.focus();' title="<%=sTxtItalic%> (Ctrl+I)" class=toolbutton>
					</td>
					<td><img src="ew/ew_images/seperator.gif" width="2" height="20"></td>
				  <% end if %>
				  <% if e__hideNumberList <> true then %>
					<td>
						<img border="0" src="ew/ew_images/button_numbers.gif" width="21" height="20" onmouseover="button_over(this);" onmouseout="button_out(this);" onmousedown="button_down(this);" onClick='doCommand("InsertOrderedList");foo.focus();' title="<%=sTxtNumList%>" class=toolbutton>
					</td>
				  <% end if %>
				  <% if e__hideBulletList <> true then %>
					<td>
						<img border="0" src="ew/ew_images/button_bullets.gif" width="21" height="20" onmouseover="button_over(this);" onmouseout="button_out(this);" onmousedown="button_down(this);" onClick='doCommand("InsertUnorderedList");foo.focus();' title="<%=sTxtBulletList%>" class=toolbutton>
					</td>
				  <% end if %>
				  <% if e__hideDecreaseIndent <> true then %>
					<td>
					<img border="0" src="ew/ew_images/button_decrease_indent.gif" width="21" height="20" onmouseover="button_over(this);" onmouseout="button_out(this);" onmousedown="button_down(this);" onClick='doCommand("Outdent");foo.focus();' title="<%=sTxtDecreaseIndent%>" class=toolbutton>
					</td>
				  <% end if %>
				  <% if e__hideIncreaseIndent <> true then %>
					<td>
						<img border="0" src="ew/ew_images/button_increase_indent.gif" width="21" height="20" onmouseover="button_over(this);" onmouseout="button_out(this);" onmousedown="button_down(this);" onClick='doCommand("Indent");foo.focus();' title="<%=sTxtIncreaseIndent%>" class=toolbutton>
					</td>
					<td><img src="ew/ew_images/seperator.gif" width="2" height="20"></td>
				  <% end if %>
				  <% if e__hideLeftAlign <> true then %>
					<td>
						<img border="0" src="ew/ew_images/button_align_left.gif" width="21" height="20" onmouseover="button_over(this);" onmouseout="button_out(this);" onmousedown="button_down(this);" onClick='doCommand("JustifyLeft");foo.focus();' title="<%=sTxtAlignLeft%>" class=toolbutton>
					</td>
				  <% end if %>
				  <% if e__hideCenterAlign <> true then %>
					<td>
						<img border="0" src="ew/ew_images/button_align_center.gif" width="21" height="20" onmouseover="button_over(this);" onmouseout="button_out(this);" onmousedown="button_down(this);" onClick='doCommand("JustifyCenter");foo.focus();' title="<%=sTxtAlignCenter%>" class=toolbutton>
					</td>
				  <% end if %>
				  <% if e__hideRightAlign <> true then %>
					<td>
						<img border="0" src="ew/ew_images/button_align_right.gif" width="21" height="20" onmouseover="button_over(this);" onmouseout="button_out(this);" onmousedown="button_down(this);" onClick='doCommand("JustifyRight");foo.focus();' title="<%=sTxtAlignRight%>" class=toolbutton>
					</td>
				  <% end if %>
				  <% if e__hideJustify <> true then %>
					<td>
						<img border="0" src="ew/ew_images/button_align_justify.gif" width="21" height="20" onmouseover="button_over(this);" onmouseout="button_out(this);" onmousedown="button_down(this);" onClick='doCommand("JustifyFull");foo.focus();' title="<%=sTxtAlignJustify%>" class=toolbutton>
					</td>
					<td><img src="ew/ew_images/seperator.gif" width="2" height="20"></td>
				  <% end if %>
				  <% if e__hideHorizontalRule <> true then %>
					<td>
						<img border="0" src="ew/ew_images/button_hr.gif" width="21" height="20" onmouseover="button_over(this);" onmouseout="button_out(this);" onmousedown="button_down(this);" onClick='doCommand("InsertHorizontalRule");foo.focus();' title="<%=sTxtInsertHR%>" class=toolbutton>
					</td>
				  <% end if %>
				  <% if e__hideLink <> true then %>
					<td>
						<img border="0" src="ew/ew_images/button_link.gif" width="21" height="20" onmouseover="button_over(this);" onmouseout="button_out(this);" onmousedown="button_down(this);" onClick='doLink()' title="<%=sTxtHyperLink%>" class=toolbutton>
					</td>
				  <% end if %>
				  <% if e__hideAnchor <> true then %>
					<td>
						<img border="0" src="ew/ew_images/button_anchor.gif" width="21" height="20" onmouseover="button_over(this);" onmouseout="button_out(this);" onmousedown="button_down(this);" onClick='doAnchor()' title="<%=sTxtAnchor%>" class=toolbutton>
					</td>
				  <% end if %>
				  <% if e__hideMailLink <> true then %>
					<td>
						<img border="0" src="ew/ew_images/button_email.gif" width="21" height="20" onmouseover="button_over(this);" onmouseout="button_out(this);" onmousedown="button_down(this);" onClick='doEmail()' title="<%=sTxtEmail%>" class=toolbutton>
					</td>
					<td><img src="ew/ew_images/seperator.gif" width="2" height="20"></td>
				  <% end if %>
				  <% if e__hideHelp <> true then %>
					<td>
						<img border="0" src="ew/ew_images/button_help.gif" width="21" height="20" onmouseover="button_over(this);" onmouseout="button_out(this);" onmousedown="button_down(this);" onClick='doHelp()' title="<%=sTxtHelp%>" class=toolbutton>
					</td>
				  <% end if %>
			  </tr>
	  		</table>
		  </td>
		</tr>
			<tr>
				<td class="body" bgcolor="#000000"><img src="ew/ew_images/1x1.gif" width="1" height="1"></td>
			</tr>
		<% if e__numBottomHidden < 13 then %>
		<tr>
		  <td class="body">
			<table border="0" cellspacing="1" cellpadding="1">
			  <tr id=ew>
				<% if e__hideFont <> true then %>
				<td>
				  <select onChange="(isAllowed()) ? foo.document.execCommand('FontName',false,this[this.selectedIndex].value) :foo.focus();foo.focus();this.selectedIndex=0" class="Text70" unselectable="on">
			  		<option selected><%=sTxtFont%></option>
			  		<option value="Times New Roman">Default</option>
			  		<option value="Arial">Arial</option>
			  		<option value="Verdana">Verdana</option>
			  		<option value="Tahoma">Tahoma</option>
			  		<option value="Courier New">Courier New</option>
			  		<option value="Georgia">Georgia</option>
				  </select>
				</td>
				<% end if %>
				<% if e__hideSize <> true then %>
				<td>
				  <select onChange="(isAllowed()) ? foo.document.execCommand('FontSize',true,this[this.selectedIndex].value) :foo.focus();foo.focus();this.selectedIndex=0" class=Text45 unselectable="on">
			  		<option SELECTED><%=sTxtSize%>
			  		<option value="1">1
			  		<option value="2">2
			  		<option value="3">3
			  		<option value="4">4
			  		<option value="5">5
			  		<option value="6">6
			  		<option value="7">7
	  			  </select>
				</td>
				<% end if %>
				<% if e__hideFormat <> true then %>
				<td>
				  <select onChange="(isAllowed()) ? doFormat(this[this.selectedIndex].value) : foo.focus();foo.focus();this.selectedIndex=0" class="Text70" unselectable="on">
				    <option selected><%=sTxtFormat%>
				    <option value="<P>">Normal
					<option value="SuperScript">SuperScript
					<option value="SubScript">SubScript
				    <option value="<H1>">H1
				    <option value="<H2>">H2
				    <option value="<H3>">H3
				    <option value="<H4>">H4
				    <option value="<H5>">H5
				    <option value="<H6>">H6
				  </select>
				</td>
				<% end if %>
				<% if e__hideStyle <> true then %>
				<td>
				  <select id="sStyles" onChange="applyStyle(this[this.selectedIndex].value);foo.focus();this.selectedIndex=0;" class="Text90" unselectable="on">
				    <option selected><%=sTxtStyle%></option>
				    <option value="">None</option>
				  </select>
				</td>
				<td><img src="ew/ew_images/seperator.gif" width="2" height="20"></td>
				<% end if %>
				<% if e__hideForeColor <> true then %>
				<td>
				  <img border="0" src="ew/ew_images/button_font_color.gif" width="21" height="20" onmouseover="button_over(this);" onmouseout="button_out(this);" onmousedown="button_down(this);" onClick="(isAllowed()) ? showMenu('colorMenu',180,291) : foo.focus()" class=toolbutton title="<%=sTxtColour%>">
				</td>
				<% end if %>
				<% if e__hideBackColor <> true then %>
				<td>
				  <img border="0" src="ew/ew_images/button_highlight.gif" width="21" height="20" onmouseover="button_over(this);" onmouseout="button_out(this);" onmousedown="button_down(this);" onClick="(isAllowed()) ? showMenu('colorMenu2',180,291) : foo.focus()" class=toolbutton title="<%=sTxtBackColour%>">
				</td>
				<td><img src="ew/ew_images/seperator.gif" width="2" height="20"></td>
				<% end if %>
				<% if e__hideTable <> true then %>
				<td>
				  <img border="0" src="ew/ew_images/button_table_down.gif" width="21" height="20" onmouseover="button_over(this);" onmouseout="button_out(this);" onmousedown="button_down(this);" onClick="(isAllowed()) ? showMenu('tableMenu',160,284) : foo.focus()" class=toolbutton title="<%=sTxtTableFunctions%>">
				</td>
				<td><img src="ew/ew_images/seperator.gif" width="2" height="20"></td>
				<% end if %>
				<% if e__hideForm <> true then %>
				<td>
				  <img class=toolbutton onMouseDown=button_down(this); onMouseOver=button_over(this); onClick="(isAllowed()) ? showMenu('formMenu',180,189) : foo.focus()" onMouseOut=button_out(this); type=image width="21" height="20" src="ew/ew_images/button_form_down.gif" border=0 title="<%=sTxtFormFunctions%>">
				</td>
				<td><img src="ew/ew_images/seperator.gif" width="2" height="20"></td>
				<% end if %>
				<% if e__hideImage <> true then %>
				<td>
				  <img border="0" src="ew/ew_images/button_image.gif" width="21" height="20" onmouseover="button_over(this);" onmouseout="button_out(this);" onmousedown="button_down(this);" onClick="doImage()" class=toolbutton title="<%=sTxtImage%>">
				</td>
				<% end if %>
				<% if e__hideSymbols <> true then %>
				<td>
				  <img border="0" src="ew/ew_images/button_chars.gif" width="21" height="20" onmouseover="button_over(this);" onmouseout="button_out(this);" onmousedown="button_down(this);" onClick="(isAllowed()) ? showMenu('charMenu',104,111) : foo.focus()" class=toolbutton title="<%=sTxtChars%>">
				</td>
				<% end if %>
				<% if e__hideProps <> true then %>
				<td>
				  <img border="0" src="ew/ew_images/button_properties.gif" width="21" height="20" onmouseover="button_over(this);" onmouseout="button_out(this);" onmousedown="button_down(this);" onClick="ModifyProperties()" class=toolbutton title="<%=sTxtPageProperties%>">
				</td>
				<% end if %>
				<% if e__hideWord <> true then %>
				<td>				
				  <img class=toolbutton onmousedown=button_down(this); onmouseover=button_over(this); onClick=cleanCode() onmouseout=button_out(this); type=image width="21" height="20" src="ew/ew_images/button_clean_code.gif" border=0 title="<%=sTxtCleanCode%>">
				</td>
				<% end if %>
				<% if e__hideGuidelines <> true then %>
				<td>
				  <img class=toolbutton onMouseDown=button_down(this); onMouseOver=button_over(this); onClick=toggleBorders() onMouseOut=button_out(this); type=image width="21" height="20" src="ew/ew_images/button_show_borders.gif" border=0 title="<%=sTxtToggleGuidelines%>" id=guidelines>
				</td>
				<% end if %>
			  </tr>
			</table>
		  </td>
		</tr>
		<% else %>
			<tr><td><img src="ew/ew_images/1x1.gif" width="1" height="29"></td></tr>
		<% end if %>
	  </table>
	</td>
  </tr> 
</table>
<!-- table menu -->

<DIV ID="tableMenu" STYLE="display:none">
<table border="0" cellspacing="0" cellpadding="0" width=160 style="BORDER-LEFT: buttonhighlight 1px solid; BORDER-RIGHT: buttonshadow 2px solid; BORDER-TOP: buttonhighlight 1px solid; BORDER-BOTTOM: buttonshadow 1px solid;" bgcolor="threedface">
  <tr onClick="parent.ShowInsertTable()" title="<%=sTxtTable%>"> 
    <td style="cursor: hand; font:8pt tahoma; BORDER-LEFT: threedface 1px solid; BORDER-RIGHT: threedface 1px solid; BORDER-TOP: threedface 1px solid; BORDER-BOTTOM: threedface 1px solid;" onMouseOver="parent.button_over(this);" onMouseOut="parent.button_out(this);" onMouseDown="parent.button_down(this);"> 
      <img id=insertTable1 border="0" src="ew/ew_images/button_table.gif" width="21" height="20" align="absmiddle">&nbsp;<%=sTxtTable%>...&nbsp; </td>
  </tr>
  <tr onClick=parent.ModifyTable(); title="<%=sTxtTableModify%>"> 
    <td style="cursor: hand; font:8pt tahoma; BORDER-LEFT: threedface 1px solid; BORDER-RIGHT: threedface 1px solid; BORDER-TOP: threedface 1px solid; BORDER-BOTTOM: threedface 1px solid;" onMouseOver="parent.button_over(this);" onMouseOut="parent.button_out(this);" onMouseDown="parent.button_down(this);" id=modifyTable> 
	  <img id=modifyTable2 width="21" height="20" src="ew/ew_images/button_modify_table.gif" border=0 align="absmiddle">&nbsp;<%=sTxtTableModify%>...&nbsp;</td>
  </tr>
  <tr title="<%=sTxtCellModify%>" onClick=parent.ModifyCell()> 
    <td style="cursor: hand; font:8pt tahoma; BORDER-LEFT: threedface 1px solid; BORDER-RIGHT: threedface 1px solid; BORDER-TOP: threedface 1px solid; BORDER-BOTTOM: threedface 1px solid;" onMouseOver="parent.button_over(this);" onMouseOut="parent.button_out(this);" onMouseDown="parent.button_down(this);" id=modifyCell> 
	<img id=modifyCell2 width="21" height="20" src="ew/ew_images/button_modify_cell.gif" border=0 align="absmiddle">&nbsp;<%=sTxtCellModify%>...&nbsp; </td>
  </tr>
  <tr height=10> 
    <td align=center><img src="ew/ew_images/vertical_spacer.gif" width="140" height="2"></td>
  </tr>
  <tr title="<%=sTxtInsertColA%>" onClick=parent.InsertColAfter()>
    <td style="cursor: hand; font:8pt tahoma; BORDER-LEFT: threedface 1px solid; BORDER-RIGHT: threedface 1px solid; BORDER-TOP: threedface 1px solid; BORDER-BOTTOM: threedface 1px solid;" onMouseOver="parent.button_over(this);" onMouseOut="parent.button_out(this);" onMouseDown="parent.button_down(this);" id=colAfter> 
      <img id=colAfter2 width="21" height="20" src="ew/ew_images/button_insert_col_after.gif" border=0 align="absmiddle">&nbsp;<%=sTxtInsertColA%>&nbsp;
    </td>
  </tr>
  <tr title="<%=sTxtInsertColB%>" onClick=parent.InsertColBefore()>
    <td style="cursor: hand; font:8pt tahoma; BORDER-LEFT: threedface 1px solid; BORDER-RIGHT: threedface 1px solid; BORDER-TOP: threedface 1px solid; BORDER-BOTTOM: threedface 1px solid;" onMouseOver="parent.button_over(this);" onMouseOut="parent.button_out(this);" onMouseDown="parent.button_down(this);" id=colBefore> 
      <img id=colBefore2 width="21" height="20" src="ew/ew_images/button_insert_col_before.gif" border=0 align="absmiddle">&nbsp;<%=sTxtInsertColB%>&nbsp;
    </td>
  </tr>
  <tr height=10> 
    <td align=center><img src="ew/ew_images/vertical_spacer.gif" width="140" height="2"></td>
  </tr>
  <tr title="<%=sTxtInsertRowA%>" onClick=parent.InsertRowAbove()>
	<td style="cursor: hand; font:8pt tahoma; BORDER-LEFT: threedface 1px solid; BORDER-RIGHT: threedface 1px solid; BORDER-TOP: threedface 1px solid; BORDER-BOTTOM: threedface 1px solid;" onMouseOver="parent.button_over(this);" onMouseOut="parent.button_out(this);" onMouseDown="parent.button_down(this);" id=rowAbove> 
      <img id=rowAbove2 width="21" height="20" src="ew/ew_images/button_insert_row_above.gif" border=0 align="absmiddle">&nbsp;<%=sTxtInsertRowA%>&nbsp;
    </td>
  </tr>
  <tr title="<%=sTxtInsertRowB%>" onClick=parent.InsertRowBelow() >
	<td style="cursor: hand; font:8pt tahoma; BORDER-LEFT: threedface 1px solid; BORDER-RIGHT: threedface 1px solid; BORDER-TOP: threedface 1px solid; BORDER-BOTTOM: threedface 1px solid;" onMouseOver="parent.button_over(this);" onMouseOut="parent.button_out(this);" onMouseDown="parent.button_down(this);" id=rowBelow> 
      <img id=rowBelow2 width="21" height="20" src="ew/ew_images/button_insert_row_below.gif" border=0 align="absmiddle">&nbsp;<%=sTxtInsertRowB%>&nbsp;
    </td>
  </tr>
  <tr height=10> 
    <td align=center><img src="ew/ew_images/vertical_spacer.gif" width="140" height="2"></td>
  </tr>
  <tr title="<%=sTxtDeleteRow%>" onClick=parent.DeleteRow()>
    <td style="cursor: hand; font:8pt tahoma; BORDER-LEFT: threedface 1px solid; BORDER-RIGHT: threedface 1px solid; BORDER-TOP: threedface 1px solid; BORDER-BOTTOM: threedface 1px solid;" onMouseOver="parent.button_over(this);" onMouseOut="parent.button_out(this);" onMouseDown="parent.button_down(this);" id=deleteRow>
      <img id=deleteRow2 width="21" height="20" src="ew/ew_images/button_delete_row.gif" border=0 align="absmiddle">&nbsp;<%=sTxtDeleteRow%>&nbsp;
    </td>
  </tr>
  <tr title="<%=sTxtDeleteCol%>" onClick=parent.DeleteCol()>
    <td style="cursor: hand; font:8pt tahoma; BORDER-LEFT: threedface 1px solid; BORDER-RIGHT: threedface 1px solid; BORDER-TOP: threedface 1px solid; BORDER-BOTTOM: threedface 1px solid;" onMouseOver="parent.button_over(this);" onMouseOut="parent.button_out(this);" onMouseDown="parent.button_down(this);" id=deleteCol>
      <img id=deleteCol2 width="21" height="20" src="ew/ew_images/button_delete_col.gif" border=0 align="absmiddle">&nbsp;<%=sTxtDeleteCol%>&nbsp;
    </td>
  </tr>
  <tr height=10> 
    <td align=center><img src="ew/ew_images/vertical_spacer.gif" width="140" height="2" tabindex=1 HIDEFOCUS></td>
  </tr>
  <tr title="<%=sTxtIncreaseColSpan%>" onClick=parent.IncreaseColspan()>
    <td style="cursor: hand; font:8pt tahoma; BORDER-LEFT: threedface 1px solid; BORDER-RIGHT: threedface 1px solid; BORDER-TOP: threedface 1px solid; BORDER-BOTTOM: threedface 1px solid;" onMouseOver="parent.button_over(this);" onMouseOut="parent.button_out(this);" onMouseDown="parent.button_down(this);" id=increaseSpan>
      <img id=increaseSpan2 width="21" height="20" src="ew/ew_images/button_increase_colspan.gif" border=0 align="absmiddle">&nbsp;<%=sTxtIncreaseColSpan%>&nbsp;
    </td>
  </tr>
  <tr title="<%=sTxtDecreaseColSpan%>" onClick=parent.DecreaseColspan()>
    <td style="cursor: hand; font:8pt tahoma; BORDER-LEFT: threedface 1px solid; BORDER-RIGHT: threedface 1px solid; BORDER-TOP: threedface 1px solid; BORDER-BOTTOM: threedface 1px solid;" onMouseOver="parent.button_over(this);" onMouseOut="parent.button_out(this);" onMouseDown="parent.button_down(this);" id=decreaseSpan>
      <img id=decreaseSpan2 width="21" height="20" src="ew/ew_images/button_decrease_colspan.gif" border=0 align=absmiddle>&nbsp;<%=sTxtDecreaseColSpan%>&nbsp;
    </td>
  </tr>
</table>
</div>
<!-- end table menu -->

<!-- form menu -->
<DIV ID="formMenu" STYLE="display:none;">
<table border="0" cellspacing="0" cellpadding="0" width=180 style="BORDER-LEFT: buttonhighlight 1px solid; BORDER-RIGHT: buttonshadow 2px solid; BORDER-TOP: buttonhighlight 1px solid; BORDER-BOTTOM: buttonshadow 1px solid;" bgcolor="threedface">
  <tr title="<%=sTxtForm%>" onClick=parent.insertForm()> 
    <td style="cursor: hand; font:8pt tahoma; BORDER-LEFT: threedface 1px solid; BORDER-RIGHT: threedface 1px solid; BORDER-TOP: threedface 1px solid; BORDER-BOTTOM: threedface 1px solid;" onMouseOver="parent.button_over(this);" onMouseOut="parent.button_out(this);" onMouseDown="parent.button_down(this);">
      <img width="21" height="20" src="ew/ew_images/button_form.gif" border=0 align="absmiddle">&nbsp;<%=sTxtForm%>...&nbsp;</td>
  </tr>
  <tr title="<%=sTxtFormModify%>" onClick=parent.modifyForm()> 
    <td style="cursor: hand; font:8pt tahoma; BORDER-LEFT: threedface 1px solid; BORDER-RIGHT: threedface 1px solid; BORDER-TOP: threedface 1px solid; BORDER-BOTTOM: threedface 1px solid;" onMouseOver="parent.button_over(this);" onMouseOut="parent.button_out(this);" onMouseDown="parent.button_down(this);" id="modifyForm1">
      <img id="modifyForm2" width="21" height="20" src="ew/ew_images/button_modify_form.gif" border=0 align="absmiddle">&nbsp;<%=sTxtFormModify%>...&nbsp;</td>
  </tr>
  <tr height=10> 
    <td align=center><img src="ew/ew_images/vertical_spacer.gif" width="140" height="2" tabindex=1 HIDEFOCUS></td>
  </tr>
  <tr title="<%=sTxtTextField%>" onClick=parent.doTextField()> 
    <td style="cursor: hand; font:8pt tahoma; BORDER-LEFT: threedface 1px solid; BORDER-RIGHT: threedface 1px solid; BORDER-TOP: threedface 1px solid; BORDER-BOTTOM: threedface 1px solid;" onMouseOver="parent.button_over(this);" onMouseOut="parent.button_out(this);" onMouseDown="parent.button_down(this);">
      <img width="21" height="20" src="ew/ew_images/button_textfield.gif" border=0 align="absmiddle">&nbsp;<%=sTxtTextField%>...&nbsp;</td>
  </tr>
  <tr title="<%=sTxtTextArea%>" onClick=parent.doTextArea() >
    <td style="cursor: hand; font:8pt tahoma; BORDER-LEFT: threedface 1px solid; BORDER-RIGHT: threedface 1px solid; BORDER-TOP: threedface 1px solid; BORDER-BOTTOM: threedface 1px solid;" onMouseOver="parent.button_over(this);" onMouseOut="parent.button_out(this);" onMouseDown="parent.button_down(this);">
      <img type=image width="21" height="20" src="ew/ew_images/button_textarea.gif" border=0 align="absmiddle">&nbsp;<%=sTxtTextArea%>...&nbsp;</td>
  </tr>
  <tr title="<%=sTxtHidden%>" onClick=parent.doHidden();>
    <td style="cursor: hand; font:8pt tahoma; BORDER-LEFT: threedface 1px solid; BORDER-RIGHT: threedface 1px solid; BORDER-TOP: threedface 1px solid; BORDER-BOTTOM: threedface 1px solid;" onMouseOver="parent.button_over(this);" onMouseOut="parent.button_out(this);" onMouseDown="parent.button_down(this);">
      <img width="21" height="20" src="ew/ew_images/button_hidden.gif" border=0 align="absmiddle">&nbsp;<%=sTxtHidden%>...&nbsp;</td>
  </tr>
  <tr title="<%=sTxtButton%>" onClick=parent.doButton();> 
    <td style="cursor: hand; font:8pt tahoma; BORDER-LEFT: threedface 1px solid; BORDER-RIGHT: threedface 1px solid; BORDER-TOP: threedface 1px solid; BORDER-BOTTOM: threedface 1px solid;" onMouseOver="parent.button_over(this);" onMouseOut="parent.button_out(this);" onMouseDown="parent.button_down(this);">
      <img width="21" height="20" src="ew/ew_images/button_button.gif" border=0 align="absmiddle">&nbsp;<%=sTxtButton%>...&nbsp;</td>
  </tr>
  <tr title="<%=sTxtCheckbox%>" onClick=parent.doCheckbox();> 
    <td style="cursor: hand; font:8pt tahoma; BORDER-LEFT: threedface 1px solid; BORDER-RIGHT: threedface 1px solid; BORDER-TOP: threedface 1px solid; BORDER-BOTTOM: threedface 1px solid;" onMouseOver="parent.button_over(this);" onMouseOut="parent.button_out(this);" onMouseDown="parent.button_down(this);">
      <img width="21" height="20" src="ew/ew_images/button_checkbox.gif" border=0 align="absmiddle">&nbsp;<%=sTxtCheckbox%>...&nbsp;</td>
  </tr>
  <tr title="<%=sTxtRadioButton%>" onClick=parent.doRadio();> 
    <td style="cursor: hand; font:8pt tahoma; BORDER-LEFT: threedface 1px solid; BORDER-RIGHT: threedface 1px solid; BORDER-TOP: threedface 1px solid; BORDER-BOTTOM: threedface 1px solid;" onMouseOver="parent.button_over(this);" onMouseOut="parent.button_out(this);" onMouseDown="parent.button_down(this);">
      <img width="21" height="20" src="ew/ew_images/button_radio.gif" border=0 align="absmiddle">&nbsp;<%=sTxtRadioButton%>...&nbsp;</td>
  </tr>
</table>
</div>
<!-- formMenu -->
<DIV ID="colorMenu" STYLE="display:none;">
<table cellpadding="1" cellspacing="5" border="1" bordercolor="#666666" style="cursor: hand;font-family: Verdana; font-size: 7px; BORDER-LEFT: buttonhighlight 1px solid; BORDER-RIGHT: buttonshadow 2px solid; BORDER-TOP: buttonhighlight 1px solid; BORDER-BOTTOM: buttonshadow 1px solid;" bgcolor="threedface">
  <tr>
	<td colspan="10" id=color style="height=20px;font-family: verdana; font-size:12px;">&nbsp;</td>
  </tr>
  <tr>
    <td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#FF0000;width=12px">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#FFFF00;width=12px">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#00FF00;width=12px">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#00FFFF;width=12px">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#0000FF;width=12px">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#FF00FF;width=12px">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#FFFFFF;width=12px">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#F5F5F5;width=12px">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#DCDCDC;width=12px">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#FFFAFA;width=12px">&nbsp;</td>
  </tr>
  <tr>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#D3D3D3">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#C0C0C0">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#A9A9A9">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#808080">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#696969">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#000000">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#2F4F4F">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#708090">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#778899">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#4682B4">&nbsp;</td>
  </tr>
  <tr>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#4169E1">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#6495ED">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#B0C4DE">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#7B68EE">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#6A5ACD">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#483D8B">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#191970">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#000080">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#00008B">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#0000CD">&nbsp;</td>
  </tr>
  <tr>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#1E90FF">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#00BFFF">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#87CEFA">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#87CEEB">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#ADD8E6">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#B0E0E6">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#F0FFFF">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#E0FFFF">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#AFEEEE">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#00CED1">&nbsp;</td>
  </tr>
  <tr>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#5F9EA0">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#48D1CC">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#00FFFF">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#40E0D0">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#20B2AA">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#008B8B">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#008080">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#7FFFD4">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#66CDAA">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#8FBC8F">&nbsp;</td>
  </tr>
  <tr>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#3CB371">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#2E8B57">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#006400">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#008000">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#228B22">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#32CD32">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#00FF00">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#7FFF00">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#7CFC00">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#ADFF2F">&nbsp;</td>
  </tr>
  <tr>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#98FB98">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#90EE90">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#00FF7F">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#00FA9A">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#556B2F">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#6B8E23">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#808000">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#BDB76B">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#B8860B">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#DAA520">&nbsp;</td>
  </tr>
  <tr>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#FFD700">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#F0E68C">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#EEE8AA">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#FFEBCD">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#FFE4B5">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#F5DEB3">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#FFDEAD">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#DEB887">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#D2B48C">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#BC8F8F">&nbsp;</td>
  </tr>
  <tr>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#A0522D">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#8B4513">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#D2691E">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#CD853F">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#F4A460">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#8B0000">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#800000">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#A52A2A">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#B22222">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#CD5C5C">&nbsp;</td>
  </tr>
  <tr>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#F08080">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#FA8072">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#E9967A">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#FFA07A">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#FF7F50">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#FF6347">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#FF8C00">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#FFA500">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#FF4500">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#DC143C">&nbsp;</td>
  </tr>
  <tr>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#FF0000">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#FF1493">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#FF00FF">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#FF69B4">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#FFB6C1">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#FFC0CB">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#DB7093">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#C71585">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#800080">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#8B008B">&nbsp;</td>
  </tr>
  <tr>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#9370DB">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#8A2BE2">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#4B0082">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#9400D3">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#9932CC">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#BA55D3">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#DA70D6">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#EE82EE">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#DDA0DD">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#D8BFD8">&nbsp;</td>
  </tr>
  <tr>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#E6E6FA">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#F8F8FF">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#F0F8FF">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#F5FFFA">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#F0FFF0">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#FAFAD2">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#FFFACD">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#FFF8DC">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#FFFFE0">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#FFFFF0">&nbsp;</td>
  </tr>
  <tr>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#FFFAF0">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#FAF0E6">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#FDF5E6">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#FAEBD7">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#FFE4C4">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#FFDAB9">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#FFEFD5">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#FFF5EE">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#FFF0F5">&nbsp;</td>
	<td onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)" style="background-color:#FFE4E1">&nbsp;</td>
  </tr>
  <tr>
	<td colspan="10" style="height=15px;font-family: verdana; font-size:10px;" onMouseOver="parent.showColor(color,this)" onClick="parent.doColor(color)">&nbsp;None</td>
  </tr>
</table>
</DIV>
<!-- end color menu -->
<!-- Special Char Menu -->
<DIV ID="charMenu" STYLE="display:none;">
<table cellpadding="1" cellspacing="5" border="1" bordercolor="#666666" style="cursor: hand;font-family: Verdana; font-size: 14px; font-weight: bold; BORDER-LEFT: buttonhighlight 1px solid; BORDER-RIGHT: buttonshadow 2px solid; BORDER-TOP: buttonhighlight 1px solid; BORDER-BOTTOM: buttonshadow 1px solid;" bgcolor="threedface">
  <tr> 
    <td style="width=15px; cursor: hand;" onClick="parent.insertChar(this)" onMouseOver="parent.button_over(this);" onMouseOut="parent.char_out(this);" onMouseDown="parent.button_down(this);">&copy;</td>
    <td style="width=15px; cursor: hand;" onClick="parent.insertChar(this)" onMouseOver="parent.button_over(this);" onMouseOut="parent.char_out(this);" onMouseDown="parent.button_down(this);">&reg;</td>
    <td style="width=15px; cursor: hand;" onClick="parent.insertChar(this)" onMouseOver="parent.button_over(this);" onMouseOut="parent.char_out(this);" onMouseDown="parent.button_down(this);">&#153;</td>
    <td style="width=15px; cursor: hand;" onClick="parent.insertChar(this)" onMouseOver="parent.button_over(this);" onMouseOut="parent.char_out(this);" onMouseDown="parent.button_down(this);">&pound;</td>
  </tr>
  <tr> 
    <td style="width=15px; cursor: hand;" onClick="parent.insertChar(this)" onMouseOver="parent.button_over(this);" onMouseOut="parent.char_out(this);" onMouseDown="parent.button_down(this);">&#151;</td>
    <td style="width=15px; cursor: hand;" onClick="parent.insertChar(this)" onMouseOver="parent.button_over(this);" onMouseOut="parent.char_out(this);" onMouseDown="parent.button_down(this);">&#133;</td>
    <td style="width=15px; cursor: hand;" onClick="parent.insertChar(this)" onMouseOver="parent.button_over(this);" onMouseOut="parent.char_out(this);" onMouseDown="parent.button_down(this);">&divide;</td>
    <td style="width=15px; cursor: hand;" onClick="parent.insertChar(this)" onMouseOver="parent.button_over(this);" onMouseOut="parent.char_out(this);" onMouseDown="parent.button_down(this);">&aacute;</td>
  </tr>
  <tr> 
    <td style="width=15px; cursor: hand;" onClick="parent.insertChar(this)" onMouseOver="parent.button_over(this);" onMouseOut="parent.char_out(this);" onMouseDown="parent.button_down(this);">&yen;</td>
    <td style="width=15px; cursor: hand;" onClick="parent.insertChar(this)" onMouseOver="parent.button_over(this);" onMouseOut="parent.char_out(this);" onMouseDown="parent.button_down(this);">&euro;</td>
    <td style="width=15px; cursor: hand;" onClick="parent.insertChar(this)" onMouseOver="parent.button_over(this);" onMouseOut="parent.char_out(this);" onMouseDown="parent.button_down(this);">&#147;</td>
    <td style="width=15px; cursor: hand;" onClick="parent.insertChar(this)" onMouseOver="parent.button_over(this);" onMouseOut="parent.char_out(this);" onMouseDown="parent.button_down(this);">&#148;</td>
  </tr>
  <tr> 
    <td style="width=15px; cursor: hand;" onClick="parent.insertChar(this)" onMouseOver="parent.button_over(this);" onMouseOut="parent.char_out(this);" onMouseDown="parent.button_down(this);">&#149;</td>
    <td style="width=15px; cursor: hand;" onClick="parent.insertChar(this)" onMouseOver="parent.button_over(this);" onMouseOut="parent.char_out(this);" onMouseDown="parent.button_down(this);">&para;</td>
    <td style="width=15px; cursor: hand;" onClick="parent.insertChar(this)" onMouseOver="parent.button_over(this);" onMouseOut="parent.char_out(this);" onMouseDown="parent.button_down(this);">&eacute;</td>
    <td style="width=15px; cursor: hand;" onClick="parent.insertChar(this)" onMouseOver="parent.button_over(this);" onMouseOut="parent.char_out(this);" onMouseDown="parent.button_down(this);">&uacute;</td>
  </tr>
</table>
</DIV>
<!-- end char menu -->
<DIV ID="contextMenu" style="display:none;">
<table border="0" cellspacing="0" cellpadding="3" width=160 style="BORDER-LEFT: buttonhighlight 1px solid; BORDER-RIGHT: #808080 1px solid; BORDER-TOP: buttonhighlight 1px solid; BORDER-BOTTOM: #808080 1px solid;" bgcolor="threedface">
  <tr onClick ='parent.document.execCommand("Cut");parent.oPopup2.hide()'>
    <td style="cursor:default; font:8pt tahoma; BORDER-LEFT: threedface 1px solid; BORDER-RIGHT: threedface 1px solid; BORDER-TOP: threedface 1px solid; BORDER-BOTTOM: threedface 1px solid;" onMouseOver="parent.contextHilite(this);" onMouseOut="parent.contextDelite(this);">
      &nbsp&nbsp;&nbsp;&nbsp&nbsp;<%=sTxtCut%>&nbsp;</td>
  </tr>
  <tr onClick ='parent.document.execCommand("Copy");parent.oPopup2.hide()'> 
    <td style="cursor:default; font:8pt tahoma; BORDER-LEFT: threedface 1px solid; BORDER-RIGHT: threedface 1px solid; BORDER-TOP: threedface 1px solid; BORDER-BOTTOM: threedface 1px solid;" onMouseOver="parent.contextHilite(this);" onMouseOut="parent.contextDelite(this);">
      &nbsp&nbsp;&nbsp;&nbsp&nbsp;<%=sTxtCopy%>&nbsp;</td>
  </tr>
  <tr onClick ='parent.document.execCommand("Paste");parent.oPopup2.hide()'> 
    <td style="cursor:default; font:8pt tahoma; BORDER-LEFT: threedface 1px solid; BORDER-RIGHT: threedface 1px solid; BORDER-TOP: threedface 1px solid; BORDER-BOTTOM: threedface 1px solid;" onMouseOver="parent.contextHilite(this);" onMouseOut="parent.contextDelite(this);">
      &nbsp&nbsp;&nbsp;&nbsp&nbsp;<%=sTxtPaste%>&nbsp;</td>
  </tr>
</table>
</div>

<DIV ID="cmTableMenu" style="display:none">
<table border="0" cellspacing="0" cellpadding="3" width=160 style="BORDER-LEFT: buttonhighlight 1px solid; BORDER-RIGHT: #808080 1px solid; BORDER-TOP: buttonhighlight 1px solid; BORDER-BOTTOM: #808080 1px solid;" bgcolor="threedface">
  <tr onClick ='parent.ModifyTable();'> 
    <td style="cursor:default; font:8pt tahoma; BORDER-LEFT: threedface 1px solid; BORDER-RIGHT: threedface 1px solid; BORDER-TOP: threedface 1px solid; BORDER-BOTTOM: threedface 1px solid;" onMouseOver="parent.contextHilite(this);" onMouseOut="parent.contextDelite(this);">
      &nbsp&nbsp;&nbsp;&nbsp&nbsp;<%=sTxtTableModify%>...&nbsp;</td>
  </tr>
</table>
</DIV>

<DIV ID="cmTableFunctions" style="display:none">
<table border="0" cellspacing="0" cellpadding="3" width=160 style="BORDER-LEFT: buttonhighlight 1px solid; BORDER-RIGHT: #808080 1px solid; BORDER-TOP: buttonhighlight 1px solid; BORDER-BOTTOM: #808080 1px solid;" bgcolor="threedface">
  <tr onClick ='parent.ModifyCell();'> 
    <td style="cursor:default; font:8pt tahoma; BORDER-LEFT: threedface 1px solid; BORDER-RIGHT: threedface 1px solid; BORDER-TOP: threedface 1px solid; BORDER-BOTTOM: threedface 1px solid;" onMouseOver="parent.contextHilite(this);" onMouseOut="parent.contextDelite(this);">
      &nbsp&nbsp;&nbsp;&nbsp&nbsp;<%=sTxtCellModify%>...&nbsp;</td>
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="3" width=160 style="BORDER-LEFT: buttonhighlight 1px solid; BORDER-RIGHT: #808080 1px solid; BORDER-TOP: buttonhighlight 1px solid; BORDER-BOTTOM: #808080 1px solid;" bgcolor="threedface">
  <tr onClick ='parent.InsertColBefore(); parent.oPopup2.hide();'> 
    <td style="cursor:default; font:8pt tahoma; BORDER-LEFT: threedface 1px solid; BORDER-RIGHT: threedface 1px solid; BORDER-TOP: threedface 1px solid; BORDER-BOTTOM: threedface 1px solid;" onMouseOver="parent.contextHilite(this);" onMouseOut="parent.contextDelite(this);">
      &nbsp&nbsp;&nbsp;&nbsp&nbsp;<%=sTxtInsertColB%>&nbsp;</td>
  </tr>
  <tr onClick ='parent.InsertColAfter(); parent.oPopup2.hide();'> 
   <td style="cursor:default; font:8pt tahoma; BORDER-LEFT: threedface 1px solid; BORDER-RIGHT: threedface 1px solid; BORDER-TOP: threedface 1px solid; BORDER-BOTTOM: threedface 1px solid;" onMouseOver="parent.contextHilite(this);" onMouseOut="parent.contextDelite(this);">
      &nbsp&nbsp;&nbsp;&nbsp&nbsp;<%=sTxtInsertColA%>&nbsp;</td>
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="3" width=160 style="BORDER-LEFT: buttonhighlight 1px solid; BORDER-RIGHT: #808080 1px solid; BORDER-TOP: buttonhighlight 1px solid; BORDER-BOTTOM: #808080 1px solid;" bgcolor="threedface">
  <tr onClick ='parent.InsertRowAbove(); parent.oPopup2.hide();'> 
    <td style="cursor:default; font:8pt tahoma; BORDER-LEFT: threedface 1px solid; BORDER-RIGHT: threedface 1px solid; BORDER-TOP: threedface 1px solid; BORDER-BOTTOM: threedface 1px solid;" onMouseOver="parent.contextHilite(this);" onMouseOut="parent.contextDelite(this);">
      &nbsp&nbsp;&nbsp;&nbsp&nbsp;<%=sTxtInsertRowA%>&nbsp;</td>
  </tr>
  <tr onClick ='parent.InsertRowBelow(); parent.oPopup2.hide();'> 
    <td style="cursor:default; font:8pt tahoma; BORDER-LEFT: threedface 1px solid; BORDER-RIGHT: threedface 1px solid; BORDER-TOP: threedface 1px solid; BORDER-BOTTOM: threedface 1px solid;" onMouseOver="parent.contextHilite(this);" onMouseOut="parent.contextDelite(this);">
      &nbsp&nbsp;&nbsp;&nbsp&nbsp;<%=sTxtInsertRowB%>&nbsp;</td>
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="3" width=160 style="BORDER-LEFT: buttonhighlight 1px solid; BORDER-RIGHT: #808080 1px solid; BORDER-TOP: buttonhighlight 1px solid; BORDER-BOTTOM: #808080 1px solid;" bgcolor="threedface">
  <tr onClick ='parent.DeleteRow(); parent.oPopup2.hide();'> 
    <td style="cursor:default; font:8pt tahoma; BORDER-LEFT: threedface 1px solid; BORDER-RIGHT: threedface 1px solid; BORDER-TOP: threedface 1px solid; BORDER-BOTTOM: threedface 1px solid;" onMouseOver="parent.contextHilite(this);" onMouseOut="parent.contextDelite(this);">
      &nbsp&nbsp;&nbsp;&nbsp&nbsp;<%=sTxtDeleteRow%>&nbsp;</td>
  </tr>
  <tr onClick ='parent.DeleteCol(); parent.oPopup2.hide();'> 
    <td style="cursor:default; font:8pt tahoma; BORDER-LEFT: threedface 1px solid; BORDER-RIGHT: threedface 1px solid; BORDER-TOP: threedface 1px solid; BORDER-BOTTOM: threedface 1px solid;" onMouseOver="parent.contextHilite(this);" onMouseOut="parent.contextDelite(this);">
      &nbsp&nbsp;&nbsp;&nbsp&nbsp;<%=sTxtDeleteCol%>&nbsp;</td>
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="3" width=160 style="BORDER-LEFT: buttonhighlight 1px solid; BORDER-RIGHT: #808080 1px solid; BORDER-TOP: buttonhighlight 1px solid; BORDER-BOTTOM: #808080 1px solid;" bgcolor="threedface">
  <tr onClick ='parent.IncreaseColspan(); parent.oPopup2.hide();'> 
    <td style="cursor:default; font:8pt tahoma; BORDER-LEFT: threedface 1px solid; BORDER-RIGHT: threedface 1px solid; BORDER-TOP: threedface 1px solid; BORDER-BOTTOM: threedface 1px solid;" onMouseOver="parent.contextHilite(this);" onMouseOut="parent.contextDelite(this);">
      &nbsp&nbsp;&nbsp;&nbsp&nbsp;<%=sTxtIncreaseColSpan%>&nbsp;</td>
  </tr>
  <tr onClick ='parent.DecreaseColspan(); parent.oPopup2.hide();'> 
    <td style="cursor:default; font:8pt tahoma; BORDER-LEFT: threedface 1px solid; BORDER-RIGHT: threedface 1px solid; BORDER-TOP: threedface 1px solid; BORDER-BOTTOM: threedface 1px solid;" onMouseOver="parent.contextHilite(this);" onMouseOut="parent.contextDelite(this);">
      &nbsp&nbsp;&nbsp;&nbsp&nbsp<%=sTxtDecreaseColSpan%>&nbsp;</td>
  </tr>
</table>
</DIV>

<DIV ID="cmImageMenu" style="display:none">
<table border="0" cellspacing="0" cellpadding="3" width=160 style="BORDER-LEFT: buttonhighlight 1px solid; BORDER-RIGHT: #808080 1px solid; BORDER-TOP: buttonhighlight 1px solid; BORDER-BOTTOM: #808080 1px solid;" bgcolor="threedface">
  <tr onClick ='parent.doImage();'> 
    <td style="cursor:default; font:8pt tahoma; BORDER-LEFT: threedface 1px solid; BORDER-RIGHT: threedface 1px solid; BORDER-TOP: threedface 1px solid; BORDER-BOTTOM: threedface 1px solid;" onMouseOver="parent.contextHilite(this);" onMouseOut="parent.contextDelite(this);">
      &nbsp&nbsp;&nbsp;&nbsp&nbsp;<%=sTxtModifyImage%>...&nbsp;</td>
  </tr>
</table>
</DIV>

<DIV ID="cmLinkMenu" style="display:none">
<table border="0" cellspacing="0" cellpadding="3" width=160 style="BORDER-LEFT: buttonhighlight 1px solid; BORDER-RIGHT: #808080 1px solid; BORDER-TOP: buttonhighlight 1px solid; BORDER-BOTTOM: #808080 1px solid;" bgcolor="threedface">
  <tr onClick ='parent.doLink();'> 
    <td style="cursor:default; font:8pt tahoma; BORDER-LEFT: threedface 1px solid; BORDER-RIGHT: threedface 1px solid; BORDER-TOP: threedface 1px solid; BORDER-BOTTOM: threedface 1px solid;" onMouseOver="parent.contextHilite(this);" onMouseOut="parent.contextDelite(this);">
      &nbsp&nbsp;&nbsp;&nbsp&nbsp;<%=sTxtHyperLink%>...&nbsp;</td>
  </tr>
</table>
</DIV>