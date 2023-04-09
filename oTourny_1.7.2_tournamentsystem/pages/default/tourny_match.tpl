<form method=POST>
<template name="SAVE">
 <div align="right"><input type="submit" name="submit" value="Save"></div>
</template name="SAVE">

<center>Tournament Match:</center>

<table width="100%" border=".1px">
 <tr><td width="100%">
  <table width="100%">
   <tr>
    <td colspan="2" width="100%" align="center">
     <a href="{MODULE_LINK}">{MODULE_NAME}</a>
    </td>
   </tr>
   <tr>
    <td width="50%" align="left">
     Round: {ROUND}
    </td>
    <td width="50%" align="right">
     Match: {MATCH_ID}
    </td>
   </tr>
  </table>
 <td></tr><tr><td>
  <template name="STATUS_EDIT">
   IM LOADED FROM MODULE TPL - DONT CHANGE ME
  </template name="STATUS_EDIT">
 </td></tr><tr><td>
  <template name="SCORE">
   {TYPE} Scores:
    <template name="SET_TEAM_NOTICE">
     <span class="requiredtxt">
      Click on {TYPE} name to select different {TYPE}.
     </span>
    </template name="SET_TEAM_NOTICE">
   <table width="100%">
     <tr>
     <th width="20%">
      {TYPE}
    </th>
    <template name="HEADER_MAP">
      <th align="left">
      <template name="MAP_NAME">
       Map {MAP_ID}
      </template name="MAP_NAME">
     </th>
    </template name="HEADER_MAP">
   </tr>
   <template name="TEAM_LIST">
    <tr>
     <td>
      <a href="{A_SET_TEAM}">
       <template name="TEAM_LIST_NAME">
        {TYPE} Not Set
       </template name="TEAM_LIST_NAME">:
      </a>
     </td>
     <template name="TEAM_LIST_MAP">
      <template name="TEAM_LIST_MAP_EDIT">
       <td>
        <input type="text" maxlength="10" size="4" name="{FIELD_SCORE_NAME}" value="{FIELD_SCORE_VALUE}">
       </td>
      </template name="TEAM_LIST_MAP_EDIT">
      <template name="TEAM_LIST_MAP_VIEW">
       <td>
        {SCORE}
       </td>
      </template name="TEAM_LIST_MAP_VIEW">
     </template name="TEAM_LIST_MAP">
    </tr>
   </template name="TEAM_LIST">
  </table>
 </template name="SCORE">
</td></tr><tr><td>
 <template name="TIME">
  Expected Match Start Time:
  <template name="TIME_LIST">
   <template name="TIME_EDIT">
     <input type="text" maxlength="250" size="50" name="{FIELD_TIME_NAME}" value="{FIELD_TIME_VALUE}">
     <span class="requiredtxt">
      Format: 11:45 PM March 10, 2004
      <br>
      Set time in your timezone. Time will be adjusted automatically for each player. Make sure you have setup your time zone in <a href="?page=playercontrol&cmd=profile">Your Profile</a>.
     </span>
   </template name="TIME_EDIT">
   <template name="TIME_NONE">
    Time Not Specified
   </template name="TIME_NONE">
   <template name="TIME_DISPLAY">
    {TIME}
   </template name="TIME_DISPLAY">
  </template name="TIME_LIST">
 </template name="TIME">
</td></tr><tr><td>
 <template name="SIDES">
  Tournament Sides:
  <template name="SIDES_LIST">
   <template name="SIDES_EDIT_TABLE">
     <table width="100%">
      <template name="SIDES_EDIT_SIDE">
       <tr>
         <td width="45%">
         {TEAM_NAME}'s Side:
         </td>
        <td width="55%">
          <input type="text" maxlength="250" size="50" name="{FIELD_SIDE_NAME}" value="{FIELD_SIDE_VALUE}">
        </td>
       </tr>
      </template name="SIDES_EDIT_SIDE">
     </table>
   </template name="SIDES_EDIT_TABLE">

   <template name="SIDES_SIDE_TEAM_NONE">{TYPE} not set</template name="SIDES_SIDE_TEAM_NONE">

   <template name="SIDES_SIDE_NONE">
    Side Not Specified
   </template name="SIDES_SIDE_NONE">

   <template name="SIDES_TABLE">
    <table width="100%">
      <template name="SIDES_SIDE">
       <tr>
        <td width="30%">
         {TEAM_NAME}'s Side:
        </td>
        <td width="70%">
         {SIDE_NAME}
        </td>
       </tr>
      </template name="SIDES_SIDE">
     </table>
   </template name="SIDES_TABLE">
  </template name="SIDES_LIST">
 </template name="SIDES">
</td></tr><tr><td>
 <template name="MAPS">
  Tournament Maps:
  <template name="MAPS_LIST">
   <template name="MAPS_EDIT_TABLE">
     <table width="100%">
      <template name="MAPS_EDIT_MAP">
       <tr>
        <td width="10%">
         Map {MAP_ID}:
        </td>
        <td width="90%">
         <input type="text" maxlength="250" size="75" name="{FIELD_MAP_NAME}" value="{FIELD_MAP_VALUE}">
        </td>
       </tr>
      </template name="MAPS_EDIT_MAP">
     </table>
     </template name="MAPS_EDIT_TABLE">
   <template name="MAPS_MAP_NONE">
    Map not specified.
   </template name="MAPS_MAP_NONE">

   <template name="MAPS_TABLE">
    <table width="100%">
      <template name="MAPS_MAP">
       <tr>
        <td width="10%">
         Map {MAP_ID}:
        </td>
        <td width="90%">
         {MAP_NAME}
        </td>
       </tr>
      </template name="MAPS_MAP">
     </table>
   </template name="MAPS_TABLE">
  </template name="MAPS_LIST">
 </template name="MAPS">
</td></tr><tr><td>
 <template name="SERVER">
  Selected Server:
   <template name="SERVER_SELECT">
    <a href="{HREF_SEL_SERVER}">Select Server</a>
   </template name="SERVER_SELECT">

   <template name="SERVER_INFO">
    <template name="SERVER_NONE">
     <center>
      Server Not Set
     </center>
    </template name="SERVER_NONE">
   </template name="SERVER_INFO">
 </template name="SERVER">
</td></tr></table>
</form>