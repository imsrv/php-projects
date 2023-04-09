<table width=100% cellSpacing=0 cellPadding=0 border=0>
 <tr>
  <td class="playertype" colspan="{COL_COUNT}" align="center">
   <template name="NAME">
    <template name="NAME_0">
     Elimination Bracket
    </template name="NAME_0">
    <template name="NAME_1">
     Loser Bracket {BRACKET_NUMBER}
    </template name="NAME_1">
    <template name="NAME_2">
     Final's Bracket
    </template name="NAME_2">
   </template name="NAME">
  </td>
 </tr>
 <tr>
  <template name="HCOL">
   <td class="playertype" align="center">
    <template name="ROUND">
     <a href="{A_ROUND_{ROUND}_HREF}">Round {ROUND}</a>
    </template name="ROUND">
   </td>
  </template name="HCOL">
 </tr>
 <template name="ROW">
  <tr>
   <template name="COL">
    <td class="{COL_CLASS}">&nbsp;
     <template name="COL_TEXT">
      {{ID}.{COL}.{ROW}}
     </template name="COL_TEXT">
    </td>
   </template name="COL">
  </tr>
 </template name="ROW">
</table>