<!-- $Id: send.body.tpl,v 1.1.1.1 1999/10/24 22:45:03 prenagha Exp $ -->
{ERROR_MSG}
{MSG}
<form method="post" action="{FORM_ACTION}">
<table border=1>
<tr>
  <td>From</td>
  <td><input type="text" name="from" size=60 maxlength=255 value="{FROM}"></td>
</tr>
<tr>
  <td>To</td>
  <td><input type="text" name="to" size=60 maxlength=255 value="{TO}"></td>
</tr>
<tr>
  <td>cc</td>
  <td><input type="text" name="cc" size=60 maxlength=255 value="{CC}"></td>
</tr>
<tr>
  <td>Subject</td>
  <td><input type="text" name="subject" size=60 maxlength=255 value="{SUBJECT}"></td>
</tr>
<tr>
  <td colspan=2>
<TEXTAREA NAME="body" WRAP="physical" COLS="72" ROWS="12">{MSGBODY}</TEXTAREA>
</td>
</tr>

 <tr>
  <td colspan=2 align=center>
   <input type="submit" name="phpop_reset" value="Reset">
	 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   <input type="submit" name="phpop_send" value="Send Message">
  </td>
 </tr>
</table>
</form>
