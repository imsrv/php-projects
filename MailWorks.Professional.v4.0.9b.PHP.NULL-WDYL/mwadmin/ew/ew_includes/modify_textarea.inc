<script language=JavaScript>
var myPage = window.opener;
window.onload = setValues;

var textName = myPage.selectedTextArea.name;
var textWidth = myPage.selectedTextArea.cols;
var textLines = myPage.selectedTextArea.rows;
var textValue = myPage.selectedTextArea.value;
var textClass = myPage.selectedTextArea.className;

function setValues() {

	// if (textMax == "2147483647") {
	// 	textMax = ""
	// }

	// if (textWidth == "0") {
	//	textWidth = ""
	// }

	if (textClass != "") {
		textClass = " class=" + textClass
	}

	textForm.text_lines.value = textLines;
	textForm.text_value.value = textValue;
	textForm.text_name.value = textName;
	textForm.text_width.value = textWidth;
	this.focus();
}

function doModify() {
	var sel = window.opener.document.selection;
		if (sel!=null) {
			var rng = sel.createRange();
		}

		name = document.textForm.text_name.value
		width = document.textForm.text_width.value
		rows = document.textForm.text_lines.value
		value = document.textForm.text_value.value

		error = 0
		if (isNaN(width) || width < 0) {
				alert("[sTxtCharWidthErr]")
				error = 1
				textForm.text_width.select()
				textForm.text_width.focus()
		} else if (isNaN(rows) || rows < 0) {
				alert("[sTxtLinesErr]")
				error = 1
				textForm.text_lines.select()
				textForm.text_lines.focus()
		}

		if (error != 1) {
				if (value != "") {
					value =  value
				} else {
					value = ""
				}

				if (name != "") {
					name = ' name="' + name + '"'
				} else {
					name = ""
				}

				if (width != "") {
					width = ' cols="' + width + '"'
				} else {
					width = ""
				}

				if (rows != "") {
					rows = ' rows="' + rows + '"'
				} else {
					rows = ""
				}

        			HTMLTextField = '<textarea' + name + width + rows + '>' + value + '</textarea>'
         			myPage.selectedTextArea.outerHTML = HTMLTextField
		}
    
    window.close()
}

document.onkeydown = function () { 
			if (event.keyCode == 13) {	// ENTER
				doModify()
			}
};

document.onkeypress = onkeyup = function () {
	if (event.keyCode == 13) {	// ENTER
	event.cancelBubble = true;
	event.returnValue = false;
	return false;			
	}
};

</script>

<form name=textForm>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
	<td width="15"><img src="_images/1x1.gif" width="15" height="1"></td>
	  <td class="heading1">[sTxtModifyTextArea]</td>
  </tr>
  <tr>
	<td>&nbsp;</td>
	  <td class="body">[sTxtModifyTextAreaInst]<br>
		[sTxtCloseWin]</td>
  </tr>
  <tr>
	<td>&nbsp;</td>
	<td class="body">&nbsp;</td>
  </tr>
  <tr>
	<td>&nbsp;</td>
	<td class="body">
	  <table width="98%" border="0" cellspacing="0" cellpadding="0" class="bevel1">
  		<tr>
		    <td>&nbsp;&nbsp;[sTxtModifyTextArea]</td>
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
	 	  
	    <table border="0" cellspacing="0" cellpadding="5" width="98%" class="bevel2">
		
		
		  <tr>
		    <td class="body" width="80">[sTxtName]:</td>
			<td class="body" width="200">
			  <input type="text" name="text_name" size="10" class="Text90" maxlength="50">
		  </td>
			<td class="body" width="80">[sTxtInitialValue]:</td>
			<td class="body">
			  <input type="text" name="text_value" size="10" class="Text150">
			</td>
		  </tr>
		  <tr>
			<td class="body" width="80">[sTxtCharWidth]:</td>
			<td class="body">
			  <input type="text" name="text_width" size="3" class="Text50" maxlength="3">
			</td>
			<td class="body" width="80">[sTxtLines]:</td>
			<td class="body">
			  <input type="text" name="text_lines" size="3" class="Text50" maxlength="3">
			</td>
		  </tr>
	    </table>
	</td>
  </tr>
  <tr>
	<td colspan="2"><img src="ew_images/1x1.gif" width="1" height="10"></td>
  </tr>
  <tr>
	<td>&nbsp;</td>
	<td>
	    <input type="button" name="insertTextField" value="[sTxtModifyTextArea]" class="Text90" onClick="javascript:doModify();">
	<input type="button" name="Submit" value="[sTxtCancel]" class="Text50" onClick="javascript:window.close()">
	</td>
  </tr>
</table>
</form>