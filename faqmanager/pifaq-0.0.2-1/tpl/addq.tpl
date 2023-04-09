<form>
<table width=400>
	<tr>
		<td>Question:</td><td><input size=40  type=text name=question value="{QUESTION}"></td>
	</tr>
	<tr>
		<td>Answer:</td><td><textarea name=answer cols=30 rows=7>{ANSWER}</textarea></td>
	</tr>
	<tr>
		<td colspan=2 align=center><input type=submit> <input type=reset><input type=hidden name=func value=add><input type=hidden name=id value={ID}> <!-- We don't use ID when we adding question --></td>
	</tr>
	
</table>
</form>
