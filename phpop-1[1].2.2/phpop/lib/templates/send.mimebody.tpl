<!-- $Id: send.mimebody.tpl,v 1.1 2000/04/11 16:27:34 prenagha Exp $ -->
{ERROR_MSG}
{MSG}
<form method="post" action="{FORM_ACTION}" ENCTYPE="multipart/form-data">
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
  <td>Attachment</td>
  <td><INPUT TYPE="HIDDEN" NAME="MAX_FILE_SIZE" VALUE="2000000">
  <INPUT TYPE="FILE" NAME="attachment" SIZE="50" MAXLENGTH="255">
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
