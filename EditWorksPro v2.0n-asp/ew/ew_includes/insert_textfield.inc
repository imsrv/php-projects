<script language=JavaScript>
window.onload = this.focus
var error
function InsertTextField() {
	var sel = window.opener.document.selection;
	if (sel!=null) {
		var rng = sel.createRange();
	   	if (rng!=null) {
			name = document.textForm.text_name.value
			width = document.textForm.text_width.value
			max = document.textForm.text_max.value
			value = document.textForm.text_value.value
			type = document.textForm.text_type[textForm.text_type.selectedIndex].text

		error = 0
		if (isNaN(width) || width < 0) {
				alert("[sTxtCharWidthErr]")
				error = 1
				textForm.text_width.select()
				textForm.text_width.focus()
		} else if (isNaN(max) || max < 0) {
				alert("[sTxtMaxCharsErr]")
				error = 1
				textForm.text_max.select()
				textForm.text_max.focus()
		}

		if (error != 1) {
				if (value != "") {
					value = ' value="' + value + '"'
				} else {
					value = ""
				}

				if (name != "") {
					name = ' name="' + name + '"'
				} else {
					name = ""
				}

				if (width != "") {
					width = ' size="' + width + '"'
				} else {
					width = ""
				}

				if (max != "") {
					max = ' maxlength="' + max + '"'
				} else {
					max = ""
				}

        			HTMLTextField = '<input type="' + type + '"' + name + value + width + max + '>'
					window.opener.foo.focus();
         			rng.pasteHTML(HTMLTextField)
		} // End if
		} // End if
	} // End If

	if (error != 1) {
		self.close();
	}
} // End function

document.onkeydown = function () { 
			if (event.keyCode == 13) {	// ENTER
				InsertTextField()
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
	  <td class="heading1">[sTxtInsertTextField]</td>
  </tr>
  <tr>
	<td>&nbsp;</td>
	  <td class="body">[sTxtInsertTextFieldInst]<br>
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
		    <td>&nbsp;&nbsp;[sTxtInsertTextField]</td>
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
			<td class="body" width="80">[sTxtMaxChars]:</td>
			<td class="body">
			  <input type="text" name="text_max" size="3" class="Text50" maxlength="3">
			</td>
		  </tr>
		  <tr>
			<td class="body" width="80">[sTxtType]:</td>
			<td class="body">
			  <select name="text_type" class=text70>
			  <option selected>Text
			  <option>Password</option>
			  </select>
			</td>
			<td class="body" width="80">&nbsp;</td>
			<td class="body">&nbsp;</td>
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
	    <input type="button" name="insertTextField" value="[sTxtInsertTextField]" class="Text90" onClick="javascript:InsertTextField();">
	<input type="button" name="Submit" value="[sTxtCancel]" class="Text50" onClick="javascript:window.close()">
	</td>
  </tr>
</table>
</form>