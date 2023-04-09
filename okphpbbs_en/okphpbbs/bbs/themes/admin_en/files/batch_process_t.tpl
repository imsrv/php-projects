
<table width="770" border="1" cellspacing="0" cellpadding="0" bordercolor="#999999">
  <tr> 
    <td bgcolor="#FFFFFF" bordercolor="#FFFFFF" align="center" valign="top"> 
      <table width="98%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td> <font class="directory">Batch Process</font> 
            <p>After all the batch processing, do not forget to <a href="?action=fix_count">Fix 
              Count</a>.</p>
          </td>
        </tr>
      </table>
      <br>
      <!-- BEGIN find_threads -->
      <table width="98%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td height="2" bgcolor="#666666"><img src="../images/spot.gif" width="1" height="1"></td>
        </tr>
        <tr> 
          <td> 
            <table width="100%" border="0" cellspacing="1" cellpadding="3" bgcolor="#CCCCCC">
              <form name="form1" method="post" action="index.php" enctype="multipart/form-data">
                <tr> 
                  <th colspan="2">Match Rules</th>
                </tr>
                <tr> 
                  <td colspan="2" class="type">Where in</td>
                </tr>
                <tr> 
                  <td width="24%" height="25" bgcolor="#FFFFFF" align="right">Belong 
                    Classes:</td>
                  <td height="25" bgcolor="#FAFAFA" width="76%"> 
                    <select name="move_from">
                      <option value="0" selected>Please Select</option>
					  {selection}
                    </select>
                  </td>
                </tr>
                <tr> 
                  <td width="24%" height="25" bgcolor="#FFFFFF" align="right">Region:</td>
                  <td height="25" bgcolor="#FAFAFA" width="76%"> 
                    <input type="radio" name="folder" value="topic">
                    Active 
                    <input type="radio" name="folder" value="faq">
                    FAQ 
                    <input type="radio" name="folder" value="cream">
                    Cream 
                    <input type="radio" name="folder" value="recovery" checked>
                    Recovery</td>
                </tr>
                <tr> 
                  <td colspan="2" class="type">Date</td>
                </tr>
                <tr> 
                  <td width="24%" height="25" bgcolor="#FFFFFF" align="right">Original 
                    post date is </td>
                  <td height="25" bgcolor="#FAFAFA" width="76%"> at least 
                    <input type="text" name="thread_min" size="10" value="0">
                    days ago, at most 
                    <input type="text" name="thread_max" size="10" value="0">
                    days ago</td>
                </tr>
                <tr> 
                  <td width="24%" height="25" bgcolor="#FFFFFF" align="right">Last 
                    post date is </td>
                  <td height="25" bgcolor="#FAFAFA" width="76%">at least 
                    <input type="text" name="post_min" size="10" value="0">
                    days ago, at most 
                    <input type="text" name="post_max" size="10" value="0">
                    days ago</td>
                </tr>
                <tr> 
                  <td colspan="2" class="type">Views&amp;Replies</td>
                </tr>
                <tr> 
                  <td width="24%" height="25" bgcolor="#FFFFFF" align="right">Thread 
                    has</td>
                  <td height="25" bgcolor="#FAFAFA" width="76%">at Least 
                    <input type="text" name="view_min" size="10" value="0">
                    Views, at Most 
                    <input type="text" name="view_max" size="10" value="0">
                    Views</td>
                </tr>
                <tr> 
                  <td width="24%" height="25" bgcolor="#FFFFFF" align="right">Thread 
                    has</td>
                  <td height="25" bgcolor="#FAFAFA" width="76%">at Least 
                    <input type="text" name="reply_min" size="10" value="0">
                    Replies, at Most 
                    <input type="text" name="reply_max" size="10" value="0">
                    Replies</td>
                </tr>
                <tr> 
                  <td colspan="2" class="type">Threads</td>
                </tr>
                <tr> 
                  <td width="24%" height="25" bgcolor="#FFFFFF" align="right">Subject 
                    like</td>
                  <td height="25" bgcolor="#FAFAFA" width="76%"> 
                    <input type="text" name="subject" size="40">
                  </td>
                </tr>
                <tr> 
                  <td width="24%" height="25" bgcolor="#FFFFFF" align="right">Author 
                    is</td>
                  <td height="25" bgcolor="#FAFAFA" width="76%"> 
                    <input type="text" name="author" size="15">
                  </td>
                </tr>
                <tr> 
                  <td width="24%" height="25" bgcolor="#FFFFFF" align="right">Include 
                    threads that are Sticky?</td>
                  <td height="25" bgcolor="#FAFAFA" width="76%"> 
                    <input type="radio" name="top_thread" value="1">
                    Yes, 
                    <input type="radio" name="top_thread" value="0" checked>
                    No</td>
                </tr>
                <tr> 
                  <td colspan="2" align="center" bgcolor="#FFFFFF"> ('0' means 
                    no limit)<br>
                    <input type="submit" name="Submit" value="Submit">
                    <input type="hidden" name="action" value="batch_process_t">
                    <input type="hidden" name="step" value="2">
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
      <!-- END find_threads -->
      <!-- BEGIN threads_list -->
      Manage<b></b> 
      <table width="98%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td height="2" bgcolor="#666666"><img src="../images/spot.gif" width="1" height="1"></td>
        </tr>
        <tr> 
          <td> 
            <table width="100%" border="0" cellspacing="1" cellpadding="0" bgcolor="#CCCCCC">
              <form name="form1" method="post" action="index.php" enctype="multipart/form-data">
                <tr> 
                  <td align="center" class="type">Result</td>
                </tr>
                <tr> 
                  <td height="25" bgcolor="#FFFFFF">Found <font color="#990000"><b><font color="#FF0000">{searchnums}</font></b></font> 
                    threads, <b><font color="#FF0000">{replies}</font></b>Posts.</td>
                </tr>
                <tr> 
                  <td align="center" class="type">Opration</td>
                </tr>
                <tr> 
                  <td align="center" bgcolor="#FFFFFF"> 
                    <p> 
                      <input type="radio" name="batch" value="del">
                      Delete 
                      <input type="radio" name="batch" value="move" checked>
                      Move to: 
                      <select name="move_to">
                        <option value="0" selected>Please Select</option>
     {move_to}
                      
                      </select>
                    </p>
                    <p> 
                      <input type="submit" name="Submit2" value="Submit">
                      <input type="hidden" name="action" value="batch_process_t">
                      <input type="hidden" name="step" value="4">
                      <input type="hidden" name="searchid" value="{searchid}">
                      <input type="hidden" name="thread_table" value="{thread_table}">
                      <input type="hidden" name="post_table" value="{post_table}">
                      <input type="hidden" name="folder" value="{folder}">
                      <input type="hidden" name="searchnums" value="{searchnums}">
                      [<a href="?action=batch_process_t">Go Back</a>]</p>
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
      <!-- END threads_list -->
      <p>&nbsp; </p>
    </td>
  </tr>
</table>
