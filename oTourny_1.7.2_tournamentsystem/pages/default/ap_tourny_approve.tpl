<template name="TOURNY">
 <table width="100%">
  <tr>
   <td width="50%">
    Tournament:
   </td>
   <td width="50%">
    {TOURNY_NAME}
   </td>
  </tr>
  <tr>
   <td width="50%">
    Request Time:
   </td>
   <td width="50%">
    {TOURNY_TIME}
   </td>
  </tr>
  <tr>
   <td width="50%">
    Type:
   </td>
   <td width="50%">
    <template name="TYPE">
     <template name="TYPE_SINGLE">
      Single
     </template name="TYPE_SINGLE">
     <template name="TYPE_TEAM">
      <template name="TYPE_DRAFT">
       Draft -
      </template name="TYPE_DRAFT">
      Team
     </template name="TYPE_TEAM">
    </template name="TYPE">
   </td>
  </tr>
  <tr>
   <td width="50%">
    User:
   </td>
   <td width="50%">
    {TOURNY_FOUNDER}
   </td>
  </tr>
  <template name="OTOURNY">
   <tr>
    <td colspan="2">
     User's Other Tournaments:
    </td>
   </tr>
   <tr>
    <td colspan="2">
     <template name="FTOURNY">
      {FOUNDER_TOURNY} <br>
     </template name="FTOURNY">
    </td>
   </tr>
  </template name="OTOURNY">
  <template name="DETAILS">
   <tr>
    <td colspan="2">
     Tournament Purpose:
    </td>
   </tr>
   <tr>
    <td colspan="2">
     {TOURNY_DETAIL}
    </td>
   </tr>
  </template name="DETAILS">
  <tr>
   <td width="50%" align="right" colspan="2">
    <form method=POST>
     Reason for Decision/Msg to Founder:
     <textarea cols="40" rows="10" name="{FIELD_TEXT}"></textarea>
     <br><br>
     <center>
      <input type="submit" name="submit" value="{SUBMIT_APPROVE}">
      <input type="submit" name="submit" value="{SUBMIT_DENY}">
     </center>
    </form>
   </td>
  </tr>
 </table>
</template name="TOURNY">

<template name="NONE">
 No more Tournaments Left.
</template name="NONE">