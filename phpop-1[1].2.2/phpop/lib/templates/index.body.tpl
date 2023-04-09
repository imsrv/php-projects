<!-- $Id: index.body.tpl,v 1.2 2000/02/18 19:46:01 prenagha Exp $ -->
{ERROR_MSG}
{MSG}
<form method=POST action="{FORM_ACTION}">
<table border=1>
<tr>
  <th>Nbr</th>
  <th>Delete</th>
  <th>From</th>
  <th>Subject</th>
  <th>Date</th>
</tr>
{MSG_LIST}
</table>
<br><input type="submit" name="phpop_delete" value="Delete Message(s)">
</form>