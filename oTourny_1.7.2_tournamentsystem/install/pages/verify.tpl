<form action="install.php?page=install&cmd=config" method="POST">
<table width="500" class="setup">
 <tr>
  <th width="30%">
  </th>
  <th width="70%">
  </th>
 </tr>
 <tr>
  <td colspan="2">
   Setup has checked your settings:
  </td>
 </tr>
 <tr>
  <td>
   Tournament Database
  </td>
  <td>
   <template name="DB_STATUS">
    <template name="DB_STATUS_GOOD">
     Connected Successfully
    </template name="DB_STATUS_GOOD">
    <template name="DB_STATUS_FAIL">
     <span class="error">
      Connection Failed
     </span>
     <br>
     <span class="requiredtxt">
      Reported Database Error:
     </span>
     <span class="error">
      {ERROR}
     </span>
    </template name="DB_STATUS_FAIL">
   </template name="DB_STATUS">
  </td>
 </tr>
 <tr>
  <td>
   Tournament Database Tables
  </td>
  <td>
   <template name="DB_TABLE">
    <template name="DB_TABLE_GOOD">
     Appears Valid (Tables Present)
    </template name="DB_TABLE_GOOD">
    <template name="DB_TABLE_FAIL">
     <span class="error">
      Tables not present.
     </span>
     <br>
     <span class="requiredtxt">
      Reported Database Error:
     </span>
     <span class="error">
      {ERROR}
     </span>
    </template name="DB_TABLE_FAIL">
   </template name="DB_TABLE">
  </td>
 </tr>
 <template name="DBF">
  <tr>
   <td>
    Forum Database
   </td>
   <td>
    <template name="DBF_STATUS">
     <template name="DBF_STATUS_GOOD">
      Connected Successfully
     </template name="DBF_STATUS_GOOD">
     <template name="DBF_STATUS_FAIL">
      <span class="error">
       Connection Failed
      </span>
      <br>
      <span class="requiredtxt">
       Reported Database Error:
      </span>
      <span class="error">
       {ERROR}
      </span>
     </template name="DBF_STATUS_FAIL">
    </template name="DBF_STATUS">
   </td>
  </tr>
  <tr>
   <td>
    Forum Database Tables
   </td>
   <td>
    <template name="DBF_TABLE">
     <template name="DBF_TABLE_GOOD">
      Appears Valid (Tables Present)
     </template name="DBF_TABLE_GOOD">
     <template name="DBF_TABLE_FAIL">
      <span class="error">
       Tables not present.
      </span>
      <br>
      <span class="requiredtxt">
       Reported Database Error:
      </span>
      <span class="error">
       {ERROR}
      </span>
     </template name="DBF_TABLE_FAIL">
    </template name="DBF_TABLE">
   </td>
  </tr>
  <template name="DBF_NEWS">
   <tr>
    <td>
     News Forum
     <br>
     <span class="requiredtxt">
      This is the name of the forum that you will use for news posts on the front page of the tournament.
     </span>
    </td>
    <td>
     <template name="FORUM_NEWS_LIST">
      <template name="FORUM_SELECT">
       <select size="1" name="{FIELD_NEWS_FORUM}">
        <template name="FORUM_LIST">
         <option value="{ID}">
          {NAME}
         </option>
        </template name="FORUM_LIST">
       </select>
      </template name="FORUM_SELECT">
      <template name="FORUM_NEWS_ERROR">
       <span class="requiredtxt">
        Unable to find forum list.
        <br>
        Reported Errors:
         <span class="error">
          {ERROR}
         </span>
       </span>
      </template name="FORUM_NEWS_ERROR">
     </template name="FORUM_NEWS_LIST">
    </td>
   </tr>
  </template name="DBF_NEWS">
 </template name="DBF">
 <tr>
  <td colspan="2" align="center">
   <template name="STATUS">
    <template name="STATUS_GOOD">
     <input type="hidden" name="{FIELD_HIDDEN}" value="{FIELD_HIDDEN_VALUE}">
     <input type="submit" name="{FIELD_SUBMIT}" value="Submit">
    </template name="STATUS_GOOD">
    <template name="STATUS_FAIL">
     <span class="error">
      Unable to Connect to Database. Please Setup Config again.
     </span>
     <br>
     Click the Back Button on your Browser and Verify all your entrys.
    </template name="STATUS_FAIL">
   </template name="STATUS">
  </td>
 </tr>
</table>
</form>