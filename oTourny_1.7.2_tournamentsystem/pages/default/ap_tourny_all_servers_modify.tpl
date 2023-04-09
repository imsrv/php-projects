{ERRORS}
<form method=POST>
 <template name="CMDS_XTRA">
  <input type="hidden" name="forcesavenew" value="1">
 </template name="CMDS_XTRA">

 <a href="?page=admin&cmd=tourny&cmdd=servers&tournyid={TOURNY_ID}">
  Back to Server Selection
 </a>

 <table width=100% align="center">
  <tr><td colspan="2" class="serverinfohead" align="center">Server Data Input</td></tr>
  <tr><td colspan="2" height=10> </td></tr>
  <tr>
   <td colspan="2" class="text" width=90% align="center">
    Enter in the Server Data. Make sure to fill everything needed.You have the option to make one server or make several at a time.
    Use 'Save Server Data' to make one, 'New Server' to save and goto a new clean server, 'Clone Server' clones your data and allows
    you to make a new server fast and easy.
   </td>
  </tr>
  <tr><td colspan="2" height=10> </td></tr>
  <tr>
   <td align="right" colspan="2">
    <input type="submit" name="{FIELD_CMDTYPE_NAME}" value="{FIELD_CMDTYPE_VALUE_SAVE}">
    <input type="submit" name="{FIELD_CMDTYPE_NAME}" value="{FIELD_CMDTYPE_VALUE_NEW}">
    <input type="submit" name="{FIELD_CMDTYPE_NAME}" value="{FIELD_CMDTYPE_VALUE_CLONE}">
   </td>
  </tr>
 </table>
 <table width=100% align="center" class="serveroutter"> <!-- Outer Table / Start Tags -->
  <tr><td colspan="2" height=10> </td></tr>
  <tr>
   <td width=50% valign="top">
    <table cellspacing="0" cellpadding="0" width=95% border="0" align="center">
     <tr><td class="text">Server Information:</td></tr>
     <tr>
      <td class="qstat">
       <table cellspacing="0" cellpadding="0" width=99% border="0" align="center">
        <tr><td height=5></td></tr>
        <tr>
         <td class="text">Server Name:</td>
         <td width=80%>
          <input type="text" maxlength="{FIELD_SRVNAME_MAX}" size="25" name="{FIELD_SRVNAME_NAME}" value="{FIELD_SRVNAME_VALUE}">
         </td>
        </tr>
        <tr>
         <td class="text">Server IP:</td>
         <td>
          <input type="text" maxlength="{FIELD_SRVIP_MAX}" size="25" name="{FIELD_SRVIP_NAME}" value="{FIELD_SRVIP_VALUE}">
         </td>
        </tr>
        <tr>
         <td class="text">Server Port:</td>
         <td>
          <input type="text" maxlength="{FIELD_SRVPORT_MAX}" size="25" name="{FIELD_SRVPORT_NAME}" value="{FIELD_SRVPORT_VALUE}">
         </td>
        </tr>
        <tr>
         <td class="text">Server Location: </td>
         <td>
          <select size="1" name="{FIELD_SRVLOC_NAME}">{FIELD_SRVLOC_VALUE}</select>
         </td>
        </tr>
       </table>
      </td>
     </tr>
     <tr><td height=10></td></tr>
     <tr><td class="text">Server Administration Information:</td></tr>
     <tr>
      <td class="qstat">
       <table cellspacing="0" cellpadding="0" width=99% border="0" align="center">
        <tr><td height=5></td></tr>
        <tr>
         <td class="text">Super Admin Password: </td>
         <td><input type="text" maxlength="{FIELD_SAPASS_MAX}" size="25" name="{FIELD_SAPASS_NAME}" value="{FIELD_SAPASS_VALUE}"></td>
        </tr>
        <tr>
         <td class="text">Admin Password: </td>
         <td width=70%> <input type="text" maxlength="{FIELD_APASS_MAX}" size="25" name="{FIELD_APASS_NAME}" value="{FIELD_APASS_VALUE}"></td>
        </tr>
        <tr>
         <td class="text">Server Join Password: </td>
         <td><input type="text" maxlength="{FIELD_JPASS_MAX}" size="25" name="{FIELD_JPASS_NAME}" value="{FIELD_JPASS_VALUE}"></td>
        </tr>
       </table>
      </td>
     </tr>
     <tr><td height=10></td></tr>
     <tr><td class="text">Enter Message to Administrators:</td></tr>
     <tr>
      <td>
       <textarea cols="135" rows="15" name="{FIELD_AMSG_NAME}">{FIELD_AMSG_VALUE}</textarea>
      </td>
     </tr>
     <tr><td height=10></td></tr>
     <tr><td class="text">Enter Message to Captains:</td></tr>
     <tr>
      <td>
       <textarea cols="135" rows="15" name="{FIELD_CMSG_NAME}">{FIELD_CMSG_VALUE}</textarea>
      </td>
     </tr>
     <tr><td height=10></td></tr>
     <tr><td class="text">Enter Message to Players:</td></tr>
     <tr>
      <td>
       <textarea cols="135" rows="15" name="{FIELD_PMSG_NAME}">{FIELD_PMSG_VALUE}</textarea>
      </td>
     </tr>
     <tr><td height=10></td></tr>
     <tr><td class="text">Enter Server Description:</td></tr>
     <tr>
      <td>
       <textarea cols="135" rows="15" name="{FIELD_SRVDESC_NAME}">{FIELD_SRVDESC_VALUE}</textarea>
      </td>
     </tr>
     <tr><td height=10></td></tr>
    </table>
   </td>
  </tr>
 </table>
</form>