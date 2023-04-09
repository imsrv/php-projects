
<table width="770" border="1" cellspacing="0" cellpadding="0" bordercolor="#003366">
  <tr> 
    <td bgcolor="#FFFFFF" bordercolor="#FFFFFF" align="center" valign="top"> 
      <table width="98%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td><b>Modify </b><font class="directory">{type_name}</font><b> </b></td>
        </tr>
        <tr> 
          <td align="right" bordercolor="#99CCCC">[ <a href="index.php?action=list_file&type_id={back_id}">Go 
            Back </a> ] </td>
        </tr>
      </table>
      <table width="98%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td height="2" bgcolor="#666666"><img src="../images/spot.gif" width="1" height="1"></td>
        </tr>
        <tr> 
          <td> 
            <table width="100%" border="0" cellspacing="1" cellpadding="3" bgcolor="#CCCCCC">
              <form>
                <input type="hidden" name="newsContent" value="{body}">
              </form>
              <form name="form" method="post" action="index.php">
                <tr align="center"> 
                  <td colspan="3" class="type">Basic</td>
                </tr>
                <tr> 
                  <td width="20%" height="27" bgcolor="#FFFFFF" align="right">Name:</td>
                  <td colspan="2" height="27" bgcolor="#FFFFFF"> 
                    <input type="text" name="name" size="30" value="{type_name}">
                  </td>
                </tr>
                <tr> 
                  <td width="15%" bgcolor="#FFFFFF" align="right">Image URL:</td>
                  <td colspan="2" bgcolor="#FFFFFF"> 
                    <input type="text" name="type_pic" size="30" value="{type_pic}">
                  </td>
                </tr>
                <tr> 
                  <td width="20%" bgcolor="#FFFFFF" align="right">Forum Brief:</td>
                  <td colspan="2" bgcolor="#FFFFFF"> 
                    <textarea name="intr" cols="60">{intr}</textarea>
                  </td>
                </tr>
                <tr align="center"> 
                  <td colspan="4" class="type">Authorize</td>
                </tr>
                <tr> 
                  <td width="20%" bgcolor="#FFFFFF">View:</td>
                  <td colspan="3" bgcolor="#FFFFFF">{protect_view} </td>
                </tr>
                <tr> 
                  <td width="20%" bgcolor="#FFFFFF">New Posts:</td>
                  <td colspan="3" bgcolor="#FFFFFF">{protect_reply}</td>
                </tr>
                <tr> 
                  <td width="20%" bgcolor="#FFFFFF">New Threads:</td>
                  <td colspan="3" bgcolor="#FFFFFF"> {protect_post} </td>
                </tr>
                <tr align="center"> 
                  <td colspan="3" class="type">Browse</td>
                </tr>
                <tr> 
                  <td width="20%" bgcolor="#FFFFFF">Order By</td>
                  <td width="26%" bgcolor="#FFFFFF"> 
                    <input type="radio" name="theme_id" value="1" {check1}>
                    Last Post Date</td>
                  <td width="54%" bgcolor="#FFFFFF"> 
                    <input type="radio" name="theme_id" value="2" {check2}>
                    Original Post Date</td>
                </tr>
                <tr align="center"> 
                  <td colspan="3" class="type">Moderators</td>
                </tr>
                <tr> 
                  <td width="20%" bgcolor="#FFFFFF">Set Moderators<br>
                  </td>
                  <td bgcolor="#FFFFFF" colspan="2"> 
                    <input type="text" name="moderator" size="70" value="{moderator}">
                    <br>
                    (use ',' to separate)</td>
                </tr>
                <tr align="center"> 
                  <td colspan="3" bgcolor="#FFFFFF"> 
                    <input type="hidden" name="type_class" value="{type_class}">
                    <input type="hidden" name="action" value="modify_file_type">
                    <input type="hidden" name="step" value="2">
                    <input type="hidden" name="type_id" value="{type_id}">
                    <input type=submit name="submit" value="Submit">
                  </td>
                </tr>
              </form>
            </table>
          </td>
        </tr>
        <tr> 
          <td height="2" bgcolor="#666666"><img src="../images/spot.gif" width="1" height="1"></td>
        </tr>
      </table>
      <p>&nbsp;</p>
    </td>
  </tr>
</table>
