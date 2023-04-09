<html>
<head>
<META http-equiv="content-type" content="text/html; charset=windows-1254">
<META http-equiv="content-type" content="text/html; charset=ISO-8859-1">
<title>myAgenda</title>
<script LANGUAGE="javascript" src="js/jslib.js"></script>
<link rel="StyleSheet" href="css/style.css" type="text/css">
<script LANGUAGE="javascript">
function validate() {
	var f = document.myAgenda

	if (f.REMINDER.value == ""){
	   	alert("{strJSNoNote}")
		f.REMINDER.focus()
   		return false
   	}
	if (f.REMINDER.value.length > 125){
	   	alert("{strJSToomuchChars}")
		f.REMINDER.focus()
   		return false
   	}
	return true
}

var supportsKeys = false
var maxLength

function textKey(f) {
		supportsKeys = true
		calcCharLeft(f)
}

function calcCharLeft(f) {
		maxLength = 125;
        if (f.REMINDER.value.length > maxLength){
	        f.REMINDER.value = f.REMINDER.value.substring(0,maxLength)
		    charleft = 0
        } else {
			charleft = maxLength - f.REMINDER.value.length
		}
        f.chars.value = charleft
}
</script>
</head>
<body bgcolor="#FFFFFF">
<br>
<br>
<table border=0 cellpadding=1 cellspacing=0 width="400" align="center">
 <tr>
	<td><font class="text">{strEditReminder}</font></td>
 </tr>
</table>
<table border=0 cellspacing=0 cellpadding=1 width="400" bgcolor="#333333" align="center">
 <tr>
	<td>
	<table border=0 cellspacing=0 cellpadding=0 width="100%" bgcolor="#FFFFFF">
 	 <tr>
		<td bgcolor="#f3f3f3">
<table width="100%" border="0" cellspacing="2" cellpadding="5">
 <tr>
	<td>{errMsg}{noteMsg}</td>
</tr><form action="{SELF}" method="post" name="myAgenda" OnSubmit="return(validate())">
<tr>
	<td>{strGetRemindType}</td>
 </tr><tr>
	<td><font class="small">{strMyThisReminder}</font><br>{strGetRemindRepeat}</td>
 </tr><tr>
	<td><font class="small">{strFromMyDate}<br>{strGetRemindDay} {strThisReminder}</font></td>
 </tr><tr>
	<td><font class="small">{str_At}<br>{strHourForm} {str_Oclock}</font></td>
 </tr><tr>
	<td><p><font class="small">{strWriteNote}<br>
	<textarea name="REMINDER" cols="35" rows="5" onKeyUp="textKey(this.form)">{REMINDER_value}</textarea>
	<br><input value="{strCharsLeft}" size="3" name="chars" disabled>		
	<br>{strMaxNoteChars}</font></td>
 </tr><tr>
 	<td>&nbsp;</td>
 </tr><tr>
	<td><input type="submit" value="{strUpdate}" name="update"></td>
 </tr>
 <input type="hidden" name="ID" value="{ID_value}">
<input type="hidden" name="page" value="{page}">
<input type="hidden" name="day" value="{DAY_value}">
<input type="hidden" name="month" value="{MONTH_value}">
<input type="hidden" name="year" value="{YEAR_value}">
 </form>
</table>

	</td>
 </tr>
</table>

	</td>
 </tr>
</table>
<img src="images/spacer.gif" width="1" height="2" border="0" alt=""><br>
</BODY>
</HTML>
