<!-- $Id: import.body.tpl,v 1.4 2000/07/05 16:20:47 prenagha Exp $ -->
<form enctype="multipart/form-data" method="post" action="{FORM_ACTION}">
 <input type="hidden" name="MAX_FILE_SIZE" value="10000000">
 <table border=0 bgcolor="#EEEEEE" align="center" width=60%>
 <tr>
  <td colspan=2>Enter the name of the Netscape bookmark file
   <br>that you want imported into bookmarker below.
   <br>&nbsp;
  </td>
 </tr>
 <tr>
  <td align=left>Netscape Bookmark File</td>
  <td align=left><input type="file" name="bkfile"></td>
 </tr>
 <tr>
  <td colspan=2 align=right>
   <input type="submit" name="bk_import" value="Import Bookmarks">
  </td>
 </tr>
 <tr>
  <td colspan=2 align=left>
<p><small><strong>NOTE:</strong> bookmarker can only import Netscape bookmark/Favorites. bookmarker cannot (and will never b/c of the format of this data) import Microsoft Internet Explorer bookmarks. There are however <a href="http://help.netscape.com/kb/consumer/19980914-23.html">tools</a> that can convert MSIE Favorites into Netscape bookmarks which you can then import into bookmarker.
<p>Additionally, newer versions of MSIE have a built-in Export function that will export MSIE Favorites into a Netscape bookmarks .htm file which can then be imported into bookmarker.</small>
  </td>
 </tr>
</table>
</form>
