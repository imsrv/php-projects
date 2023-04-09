<!-- $Id: codes.delete.tpl,v 1.2 2000/01/24 03:49:19 prenagha Exp $ -->
<table border=0 bgcolor="#EEEEEE" align="center">
 <form method="post" action="{FORM_ACTION}">
 <tr>
  <td>Are you sure you want to delete {CODETABLE} {ID}</td>
 </tr>
 <tr>
  <td colspan=2 align=center>
   <input type="submit" name="bk_cancel_delete" value="Cancel">
   <input type="submit" name="bk_code_delete" value="Delete {CODETABLE}">
  </td>
 </tr>
 </form>
</table>
