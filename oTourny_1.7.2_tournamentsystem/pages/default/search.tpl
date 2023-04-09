<template name="SEARCH_DATA">
 <input type="hidden" name="{FIELD_HIDDEN_TYPE}"      value="{FIELD_HIDDEN_TYPE_VALUE}">
 <input type="hidden" name="{FIELD_HIDDEN_SEARCHTXT}" value="{FIELD_HIDDEN_SEARCHTXT_VALUE}">
 <input type="hidden" name="{FIELD_HIDDEN_CLICKCMD}"  value="{FIELD_HIDDEN_CLICKCMD_VALUE}">
</template name="SEARCH_DATA">

<table width=100% class="news" align="center" border=0>
<tr>
 <td align="center" colspan="3">
  Enter the {TYPE} you are searching for.
  <template name="MSGS">
   <template name="MSG_ADMIN">
    Use "%" as a wildcard.
   </template name="MSG_ADMIN">
   <template name="MSG_PLAYER">
    You must have atleast <b>3 letters</b> for the search.
   </template name="MSG_PLAYER">
  </template name="MSGS">

  <form method=POST> {SEARCH_DATA}
   {TYPE}:
    <input type="text" maxlength="255" size="25" name="{FIELD_SEARCHTXT}" value="{FIELD_SEARCHTXT_VALUE}">
    <input type="submit" name="Search" value="Search">
  </form>
 </td>
</tr>
<tr><td height="10"></td></tr>
 <tr>
  <template name="PAGE_BACK">
   <td align="right">
    <form method="POST"> {SEARCH_DATA}
     <input type="hidden" name="{FIELD_HIDDEN_PAGENUM}" value="{FIELD_HIDDEN_PAGENUM_VALUE}">
     <input type="submit" value="First Page">
    </form>
   </td>
  </template name="PAGE_BACK">
  <template name="PAGE_LAST">
   <td align="right">
    <form method=POST>
     <input type="hidden" name="{FIELD_HIDDEN_PAGENUM}" value="{FIELD_HIDDEN_PAGENUM_VALUE}">
     <input type="submit" value="Last Page">
    </form>
   </td>
  </template name="PAGE_LAST">
  <template name="PAGE_NEXT">
   <td align="right">
    <form method="POST"> {SEARCH_DATA}
     <input type="hidden" name="{FIELD_HIDDEN_PAGENUM}" value="{FIELD_HIDDEN_PAGENUM_VALUE}">
     <input type="submit" value="Next Page">
    </form>
   </td>
  </template name="PAGE_NEXT">
 </tr>
</table>

<table cellspacing="0" cellpadding="0" width=100% border="0" align="center">
 <tr>
  <td align="center" class="headline">
   <table width=100% class="news">
    <tr>
     <td width=50%>
      Showing {COUNT} {TYPE}s
     </td>
     <td width=50% align=right>
      Page {PAGE_NUM}
     </td>
    </tr>
   </table>
  </td>
 </tr>
</table>

<table width=100%>
 <template name="LIST">
  <template name="ROW_NONE">
   <tr>
    <td align=center>
     <span class="error">No {TYPE}s have been found.</span>
    </td>
   </tr>
  </template name="ROW_NONE">

  <template name="ROW">
   <tr>
    <template name="COL">
     <td width="33%" align="center">
      <a href="{A_LINK}">{TEXT}</a>
     </td>
    </template name="COL">
   </tr>
  </template name="ROW">
 </template name="LIST">
</table>

<table cellspacing="0" cellpadding="0" width=100% border="0" align="center">
 <tr><td class="subsubheader"></td></tr>
</table>