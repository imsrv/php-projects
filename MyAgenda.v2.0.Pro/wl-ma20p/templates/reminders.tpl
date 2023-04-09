<html>
<head>
<META http-equiv="content-type" content="text/html; charset=windows-1254">
<META http-equiv="content-type" content="text/html; charset=ISO-8859-1">
<title>myAgenda</title>
<script LANGUAGE="javascript" src="js/jslib.js"></script>
<link rel="StyleSheet" href="css/style.css" type="text/css">
</head>
<body bgcolor="#FFFFFF">
<br>
<br>
<table border=0 cellpadding=1 cellspacing=0 width="100%" align="center">
 <tr>
	<td><font class="text">{strReminders}</font></td>
 </tr><tr>
	<td>{errMsg}{noteMsg}</td>
</tr>
</table>
<form name="myAgenda" action="{SELF}" method="post">
					<table width="100%" border="0" cellspacing="0" cellpadding="2">
					<tr>
					 	<td colspan="8"><hr width="100%" size="1" color="#000000" noshade></td>
					 </tr><tr>
						<td align="center"><input type="checkbox" name="checkall" value="checkbox" onClick="checkAll(this.form);"></td>
						<td><b><a href="?order=TYPE&page={page}&sort={n_sort}">{strType}</a></b></td>
						<td><b>{strReminderNote}</b></td>
						<td><b><a href="?order=REPEAT&page={page}&sort={n_sort}">{strRepeat}</a></b></td>
						<td align="center"><b><a href="?order=ADVANCE&page={page}&sort={n_sort}">{strAdvance}</a></b></td>
						<td align="center"><b><a href="?order=DATE&page={page}&sort={n_sort}">{strReminderDate}</a></b></td>
						<td align="center"><b>{strAction}</b></td>
					 </tr><tr>
					 	<td colspan="8"><hr width="100%" size="1" color="#000000" noshade></td>
					 </tr>
<!-- reminders -->
 <TR bgcolor="{bgColor}">
	<td valign="top" align="center"><input type="checkbox" name="IDS[]" value="{ID_value}" onClick="javascript:checkCtrl(this.form)"></td>
	<TD valign="top"><font class="small">{TYPE}</font></TD>
	<TD valign="top"><font class="small"><b>{REMINDER}</b></font></TD>
	<TD valign="top"><font class="small">{REPEAT}</font></TD>
	<TD valign="top" align="center"><font class="small">{ADVANCE}</font></TD>
	<TD valign="top" align="center"><font class="small"><b>{DATE} {HOUR}</b></font></TD>
	<TD valign="top" align="center"><a href="#" onclick="edit('{ID_value}','edit')"><img src="images/edit_pencil.gif" width="16" height="16" border="0" alt="{strEdit}"></a>&nbsp;<a href="#" onclick="edit('{ID_value}','delete')"><img src="images/delete_can.gif" width="16" height="16" border="0" alt="{strDelete}"></a></TD>
 </TR>
<!-- /reminders -->
 <TR>
	<TD colspan="8"><hr width="100%" size="1" color="#000000" noshade></TD>
  </TR><TR>
	<TD colspan="8"><a href="#" onClick="edit(null,'deleteall')"><b>{strDelSelected}</a></b></td></TD>
  </TR><TR>
	<TD colspan="8"><hr width="100%" size="1" color="#000000" noshade></TD>
 </TR>
 </TABLE>
<input type="hidden" name="page" value="{page}">
<input type="hidden" name="ID">
 </form>
<Script language="JavaScript">
function edit(id,what) {
	var f = document.myAgenda;
	if(what=="deleteall") {
	var j = 0;
		for(var i=0 ; i<f.elements.length; i++) {
			var e = f.elements[i];
			if((e.type == 'checkbox') && (e.name != 'checkall') && (e.checked==true) )
			j++
		}
		if(j != 0) {
			if(confirm('{strJSConfirm}')) {
				f.submit();
			}
		}else{
			alert('{strSelectOne}')
		}
	}
	if( (what=="edit") && (id != null || id != "") ) {
		f.action = "edit.php";
		f.ID.value = id
		f.submit();
	}
	if(what=='delete'){
		if(confirm('{strJSConfirm}')) {
			popUP("delete.php?ID="+id, 300, 100, "");
		}
	}

}
</SCRIPT>
</BODY>
</HTML>
