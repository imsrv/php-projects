<template name="XTRA">
 From: {SITE_EMAIL}
 Reply-To: webmaster
 X-Mailer: {SITE_DNS}
</template name="XTRA">

<template name="GENERATION">
 <center>
  {COUNT} emails have been generated.
  <br>
  <a href="?page=admin&cmd=email&cmdd=send">Click here to send emails</a>
  <br>
  The browser will keep refreshing several times depending how many emails are being sent.
 </center>
</template name="GENERATION">

<template name="FINISH">
 <center>
  All the emails have been sent.
 </center>
</template name="FINISH">

<template name="CREATION">
 <form method="POST">
  <table width="100%" align="center" cellspacing="0" cellpadding="0">
   <tr><td align="center" class="headline" align="center">Choose who to send Email To:</td></tr>
   <tr><td align="center" class="bottomhalf" bgcolor="B7B7B7">
    <select name="type">
     <option value="all" selected>All Players</option>
     <option value="teams">Every Team Email</option>
     <option value="team_leaders">Every Team Captain And Founder</option>
     <option value="admins">Every Site Admin</option>
     <template name="TOURNY">
      <option value="tourny_{TOURNY_ID}_admins">{NAME}'s Admins</option>
      <option value="tourny_{TOURNY_ID}_players">{NAME}'s Players</option>
      <template name="TOURNY_TEAM">
       <option value="tourny_{TOURNY_ID}_leaders">{NAME}'s Team Captains and Founder</option>
       <option value="tourny_{TOURNY_ID}_team">{NAME}'s Team Email</option>
      </template name="TOURNY_TEAM">
      <template name="TOURNY_DRAFT">
       <option value="tourny_{TOURNY_ID}_draft_users">{NAME}'s Draft Players</option>
       <option value="tourny_{TOURNY_ID}_draft_captss">{NAME}'s Draft Captains</option>
      </template name="TOURNY_DRAFT">
     </template name="TOURNY">
    </select>
   </td></tr>
   <tr><td align="center" class="headline" align="center">Enter in the Email Title.</td></tr>
   <tr><td align="center" class="bottomhalf" bgcolor="B7B7B7">
    Title: <input type="text" maxlength="{FIELD_TITLE_MAX}" size="50" name="{FIELD_TITLE_NAME}">
   </td></tr>
   <tr><td height="10" colspan="2"></td></tr>
   <tr><td align="center" class="headline" align="center">Enter in the Email Content.</td></tr>
   <tr><td align="center" class="bottomhalf" bgcolor="#B7B7B7">
     <textarea cols="70" rows="15" name="{FIELD_EMAILCNT_NAME}"></textarea>
   </td></tr>
   <tr><td height="10"></td></tr>
   <tr><td align="center"> <input type="submit" name="submit" value="Send Emails"></td></tr>
  </table>
 </form>
</template name="CREATION">