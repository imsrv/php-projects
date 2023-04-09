<template name="ERRORS">
 <template name="ERRORS_NAME">
  Tournament name has already been taken or requested.
 </template name="ERRORS_NAME">
 <template name="ERRORS_NAME_LEN">
  Tournament name must be less than 150 and more than 10 characters.
 </template name="ERRORS_NAME_LEN">
 <template name="ERRORS_TYPE">
  Select a Tournament Type.
 </template name="ERRORS_TYPE">
 <template name="ERRORS_PURPOSE_LEN">
  Tournament purpose is too long. Must be less than 1500 characters.
 </template name="ERRORS_PURPOSE_LEN">
</template name="ERRORS">

<template name="FINISH">
 <center>
  Your tournament request has been recieved. An admin will approve or disapprove your Tourament in due time.
  <br>
  <a href="?page=news">Click Here</a>
 </center>
</template name="FINISH">
<table width=100% align="center"><tr><td class="headline" align="center">
 Request A Tournament
</td></tr></table>
This form will allow you to give us all the information we require for a tournament. All tournaments are judged individually by a site Admin. You will become the tournament Founder/Director, if it is approved. A link to the tournament control console will appear in a window to the right, when it is approved.
<form method=POST>
 <table width=100% class="news">
  <tr>
   <td colspan="2" align="center">
    <span class="requiredtxt">Tournament Name will be the name that is used to refered to the Tournament.</span>
   </td>
  </tr>
  <tr>
   <td width="165" align="right">
    Tournament Name:
   </td>
   <td width="318" align="left">
    <input type="text" size="25" maxlength="75" name="{FIELD_NAME_NAME}" value="{FIELD_NAME_VALUE}">
   </td>
  </tr>
  <tr>
   <td colspan="2" align="center">
    <span class="requiredtxt">
     A tournament has two types: Single Player and Teams.
     <br>
     Single Player: Player vs Player Tournament.
     <br>
     Team: Team vs Team Tournament.
    </span>
   </td>
  </tr>
  <tr>
   <td align="right">
    Max Number of Teams/Players Per Match:
   </td>
   <td align="left">
    <input type="text" size="25" maxlength="3" name="{FIELD_MAX_NAME}" value="{FIELD_MAX_VALUE}">
   </td>
  </tr>
  <tr>
   <td colspan="2" align="center">
    <span class="requiredtxt">
     The engine supports muplitple teams/players per match. You need to specify the max number of teams/players will be in a single match in the tourny. This is a max, you can use less later. You must have atleast 2 teams/players per match.
    </span>
   </td>
  </tr>
  <tr>
   <td align="right">
    Tournament Type:
   </td>
   <td align="left">
    <input type="radio" name="{FIELD_TYPE_0}" value="{FIELD_TYPE_0_VALUE}" {FIELD_TYPE_0_CHECKED}>Single</input>
     <br>
    <input type="radio" name="{FIELD_TYPE_1}" value="{FIELD_TYPE_1_VALUE}" {FIELD_TYPE_1_CHECKED}>Team</input>
     <br>
    <input type="checkbox" name="{FIELD_DRAFT_NAME}" value="{FIELD_DRAFT_VALUE}" {FIELD_DRAFT_CHECK}> Draft <span class="requiredtxt">Only for team tournaments.</span>
   </td>
  </tr>
  <tr>
   <td colspan="2" align="center">
    <span class="requiredtxt">Enter in all Information you feel we need to judge your Tournament.<br>Most Tournaments will be Created.</span>
   </td>
  </tr>
  <tr>
   <td align="right" valign="top">
    Purpose/Comments:
   </td>
   <td align="left">
    <textarea cols="50" rows="15" name="{FIELD_TEXT}">{FIELD_TEXT_VALUE}</textarea>
   </td>
  </tr>
  <tr>
   <td colspan="2" align="center">
    <input type="Submit" value="Request Tournament">&nbsp;<input type="reset" value="Reset">
   </td>
  </tr>
 </table>
</form>