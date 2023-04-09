<center>
 Choose the Module you would like to Admin.

 <table width="100%">
  <tr>
   <td class="headline">
   Available Modules:
   </td>
  </tr>
 </table>

 <table width="100%">
  <template name="CMODULES_LIST">
   <template name="CMODULES_NONE">
    <tr>
     <td align="center" width="100%">
      <span class="error">
       There are 0 Modules to Create.
      </span>
     </td>
    </tr>
   </template name="CMODULES_NONE">
   <template name="CMODULES_ROW">
    <tr>
     <template name="CMODULES_COL">
      <td align="center" width="33%">
       <a href="{LINK}">{NAME}</a>
      </td>
     </template name="CMODULES_COL">
    </tr>
   </template name="CMODULES_ROW">
  </template name="CMODULES_LIST">
 </table>
 <br>

 <table width="100%">
  <tr>
   <td class="headline">
   Current Modules:
   </td>
  </tr>
 </table>

 <table width="100%">
  <template name="MODULES_LIST">
   <template name="MODULES_NONE">
    <tr>
     <td align="center" width="100%">
      <span class="error">
       There are 0 Modules to Edit.
      </span>
     </td>
    </tr>
   </template name="MODULES_NONE">
   <template name="MODULES_ROW">
    <tr>
     <template name="MODULES_COL">
      <td align="center" width="33%">
       <a href="{LINK}">{NAME}</a>
      </td>
     </template name="MODULES_COL">
    </tr>
   </template name="MODULES_ROW">
  </template name="MODULES_LIST">
 </table>

 <br>

 <table width="100%">
  <tr>
   <td class="headline">
   Delete Modules: <span class="requiredtxt">Deleting a Module Is Permanent!</span>
   </td>
  </tr>
 </table>

 <table width="100%">
  <template name="DMODULES_LIST">
   <template name="DMODULES_NONE">
    <tr>
     <td align="center" width="100%">
      <span class="error">
       There are 0 Modules to Delete.
      </span>
     </td>
    </tr>
   </template name="DMODULES_NONE">
   <template name="DMODULES_ROW">
    <tr>
     <template name="DMODULES_COL">
      <td align="center" width="33%">
       <a href="{LINK}">{NAME}</a>
      </td>
     </template name="DMODULES_COL">
    </tr>
   </template name="DMODULES_ROW">
  </template name="DMODULES_LIST">
 </table>
</center>