<center>
 All {TYPE}s are currently listed
 <br>
 <a href="?page=admin&cmd=tourny&cmdd=adminjoin&tournyid={TOURNY_ID}">Add {TYPE}</a>
</center>

<table cellspacing="0" cellpadding="0" width=100% border="0" align="center">
 <tr><td class="subsubheader">{TYPE}s ({TEAM_COUNT}):</td></tr>
</table>
<template name="TEAM_LIST">
 <template name="ERROR">
  <center>
   <span class="error">
    There are no {TYPE}s assigned to tournament.
   </span>
  </center>
 </template name="ERROR">
 <template name="TEAM_TABLE">
  <table width=100%>
   <template name="ROW">
    <tr class="{CLASS}">
     <td width=95%>
      {NAME}
     </td>
     <td width=5%>
      <a href="?page=admin&cmd=tourny&cmdd=teamsetup&tournyid={TOURNY_ID}&delteam={TEAM_ID}"><span class="requiredtxt">Delete</span></a>
     </td>
    </tr>
   </template name="ROW">
  </table>
 </template name="TEAM_TABLE">
</template name="TEAM_LIST">

<template name="DRAFT_LIST">
 <br><br>
 <center>
  All Users and Captains are currently listed
  <br>
  <template name="DRAFT_EDIT_USER">
   <a href="?page=admin&cmd=tourny&cmdd=captjoin&tournyid={TOURNY_ID}">Add Captain</a>
   <a href="?page=admin&cmd=tourny&cmdd=draftjoin&tournyid={TOURNY_ID}">Add Player</a>
  </template name="DRAFT_EDIT_USER">
 </center>
 <table cellspacing="0" cellpadding="0" width=100% border="0" align="center">
  <tr><td class="subsubheader">Draft Players ({DRAFT_COUNT}) + Captains ({CAPT_COUNT}):</td></tr>
 </table>
 <template name="DRAFT_USER_LIST">
  <template name="DRAFT_ERROR">
   <center>
    <span class="error">
     There are Draft Players or Captains assigned to tournament.
    </span>
   </center>
  </template name="DRAFT_ERROR">
  <template name="DRAFT_TABLE">
   <table width=100%>
    <template name="DRAFT_ROW">
     <tr class="{CLASS}">
      <td width="80%">
       {NAME}
      </td>
      <td width="5%" align="left">
       <template name="TEAM_STATUS">
        <template name="TEAM_STATUS_DONE">
         READY
        </template name="TEAM_STATUS_DONE">
        <template name="TEAM_STATUS_NONE">
         *
        </template name="TEAM_STATUS_NONE">
       </template name="TEAM_STATUS">
      </td>
      <td width="10%">
       <template name="DRAFT_TYPE">
        <template name="DRAFT_USER">
         Player
        </template name="DRAFT_USER">
        <template name="DRAFT_CAPT">
         Captain
        </template name="DRAFT_CAPT">
       </template name="DRAFT_TYPE">
      </td>
      <td width="5%">
       <a href="?page=admin&cmd=tourny&cmdd=teamsetup&tournyid={TOURNY_ID}&deldraft={TEAM_ID}"><span class="requiredtxt">Delete</span></a>
      </td>
     </tr>
    </template name="DRAFT_ROW">
   </table>
  </template name="DRAFT_TABLE">
 </template name="DRAFT_USER_LIST">
</template name="DRAFT_LIST"> 