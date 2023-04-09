
<table width="770" border="1" cellspacing="0" cellpadding="0" bordercolor="#999999">
  <tr> 
    <td bgcolor="#FFFFFF" bordercolor="#FFFFFF" align="center" valign="top"> 
      <table width="98%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td><font class="directory">System Settings</font></td>
        </tr>
      </table>
      <form>
        <table width="98%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td height="2" bgcolor="#666666"><img src="../images/spot.gif" width="1" height="1"></td>
          </tr>
          <tr> 
            <td> 
              <table width="100%" border="0" cellspacing="1" cellpadding="0" bgcolor="#CCCCCC">
                <tr> 
                  <td colspan="2" align="center" class="type">Basic</td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">BBS Name:</td>
                  <td width="63%" bgcolor="#FFFFFF"> 
                    <input type="text" name="bb_name" value="{bb_name}" size="40">
                  </td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">BBS Url:</td>
                  <td width="63%" bgcolor="#FFFFFF"> 
                    <input type="text" name="bb_url" value="{bb_url}" size="40">
                  </td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">Website Name:</td>
                  <td width="63%" bgcolor="#FFFFFF"> 
                    <input type="text" name="web_name" value="{web_name}" size="40">
                  </td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">Website URL</td>
                  <td width="63%" bgcolor="#FFFFFF"> 
                    <input type="text" name="web_url" value="{web_url}" size="40">
                  </td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">Administor E-mail:</td>
                  <td width="63%" bgcolor="#FFFFFF"> 
                    <input type="text" name="admin_email" value="{admin_email}" size="40">
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          <tr> 
            <td height="2" bgcolor="#666666"><img src="../images/spot.gif" width="1" height="1"></td>
          </tr>
        </table>
        <p>&nbsp;</p>
        <table width="98%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td height="2" bgcolor="#666666"><img src="../images/spot.gif" width="1" height="1"></td>
          </tr>
          <tr> 
            <td> 
              <table width="100%" border="0" cellspacing="1" cellpadding="0" bgcolor="#CCCCCC">
                <tr> 
                  <td colspan="2" align="center" class="type">Header&amp;Footer</td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">Header:</td>
                  <td bgcolor="#FFFFFF"> 
                    <textarea name="bb_header" cols="60" rows="7">{bb_header}</textarea>
                  </td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF"> 
                    <p>Footer:</p>
                  </td>
                  <td bgcolor="#FFFFFF"> 
                    <textarea name="bb_footer" cols="60" rows="7">{bb_footer}</textarea>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          <tr> 
            <td height="2" bgcolor="#666666"><img src="../images/spot.gif" width="1" height="1"></td>
          </tr>
        </table>
        <p>&nbsp;</p>
        <table width="98%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td height="2" bgcolor="#666666"><img src="../images/spot.gif" width="1" height="1"></td>
          </tr>
          <tr> 
            <td> 
              <table width="100%" border="0" cellspacing="1" cellpadding="2" bgcolor="#CCCCCC">
                <tr> 
                  <td colspan="2" align="center" class="type">Security&amp;Safeguard</td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">Destine IP:<br>
                    <a href="#note">(EXP1)</a></td>
                  <td width="63%" bgcolor="#FFFFFF"> 
                    <textarea name="designated_ip" cols="60" rows="7">{designated_ip}</textarea>
                  </td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">Attitude:<br>
                    <a href="#note">(EXP2)</a></td>
                  <td width="63%" bgcolor="#FFFFFF"> 
                    <input type="text" name="attitude" size="5" value="{attitude}">
                    (0:Banned selected IP, 1:Only access to selected IP)</td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">Halt Website:<br>
                  </td>
                  <td width="63%" bgcolor="#FFFFFF"> 
                    <input type="text" name="halting" size="5" value="{halting}">
                    (0:Normal, 1: Halt)</td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">Halting reason:<br>
                  </td>
                  <td width="63%" bgcolor="#FFFFFF"> 
                    <textarea name="h_reason" cols="60" rows="3">{h_reason}</textarea>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          <tr> 
            <td height="2" bgcolor="#666666"><img src="../images/spot.gif" width="1" height="1"></td>
          </tr>
        </table>
        <p><br>
        </p>
        <table width="98%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td height="2" bgcolor="#666666"><img src="../images/spot.gif" width="1" height="1"></td>
          </tr>
          <tr> 
            <td> 
              <table width="100%" border="0" cellspacing="1" cellpadding="2" bgcolor="#CCCCCC">
                <tr> 
                  <td colspan="2" align="center" class="type">Forums</td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">Max size of 
                    Title:</td>
                  <td width="63%" bgcolor="#FFFFFF"> 
                    <input type="text" name="limit_title_size" value="{limit_title_size}" size="10">
                  </td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">Max size of 
                    Content:</td>
                  <td width="63%" bgcolor="#FFFFFF"> 
                    <input type="text" name="limit_post_size" value="{limit_post_size}" size="10">
                  </td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">Threads per 
                    page:</td>
                  <td width="63%" bgcolor="#FFFFFF"> 
                    <input type="text" name="topic_num" value="{topic_num}" size="10">
                  </td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">Posts per page:</td>
                  <td width="63%" bgcolor="#FFFFFF"> 
                    <input type="text" name="reply_num" value="{reply_num}" size="10">
                  </td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">Allow BB Code?</td>
                  <td width="63%" bgcolor="#FFFFFF"> 
                    <input type="text" name="allow_postbb" value="{allow_postbb}" size="10">
                    (1:Yes, 0:No)</td>
                </tr>
		<tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">Allow Smiles Code?</td>
                  <td width="63%" bgcolor="#FFFFFF"> 
                    <input type="text" name="allow_emote" value="{allow_emote}" size="10">
                    (1:Yes, 0:No)</td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">Use Confirm 
                    Code?</td>
                  <td width="63%" valign="top" bgcolor="#FFFFFF"> 
                    <p> 
                      <input type="text" name="confirm_code" value="{confirm_code}" size="10">
                      (1:Yes, 0:No)</p>
                  </td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">Scores/a new 
                    thread:</td>
                  <td width="63%" bgcolor="#FFFFFF"> 
                    <input type="text" name="sc_per_topic" value="{sc_per_topic}" size="10">
                  </td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">Scores/a new 
                    post:</td>
                  <td width="63%" bgcolor="#FFFFFF"> 
                    <input type="text" name="sc_per_post" value="{sc_per_post}" size="10">
                  </td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">Allow Poll?</td>
                  <td width="63%" bgcolor="#FFFFFF"> 
                    <input type="text" name="poll_on" value="{poll_on}" size="10">
                    (1:Yes, 0:No) </td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">Allow Attachment?</td>
                  <td width="63%" bgcolor="#FFFFFF"> 
                    <input type="text" name="attach_on" value="{attach_on}" size="10">
                    (1:Yes, 0:No)</td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">Max Attachment 
                    File Size:</td>
                  <td width="63%" valign="top" bgcolor="#FFFFFF"> 
                    <p> 
                      <input type="text" name="attach_max_size" value="{attach_max_size}" size="10">
                      kb. </p>
                  </td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">How many Attachment 
                    files in one post?</td>
                  <td width="63%" bgcolor="#FFFFFF"> 
                    <input type="text" name="attach_max_num" value="{attach_max_num}" size="10">
                  </td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">How many Attachment 
                    files a day for one user?</td>
                  <td width="63%" bgcolor="#FFFFFF"> 
                    <input type="text" name="attach_max_days" value="{attach_max_days}" size="10">
                  </td>
                </tr>
		<tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">Need fast reply block?</td>
                  <td width="63%" bgcolor="#FFFFFF"> 
                    <input type="text" name="fast_reply" value="{fast_reply}" size="10"> (1: Yes, 0:No)
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          <tr> 
            <td height="2" bgcolor="#666666"><img src="../images/spot.gif" width="1" height="1"></td>
          </tr>
        </table>
        <p>&nbsp;</p>
        <table width="98%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td height="2" bgcolor="#666666"><img src="../images/spot.gif" width="1" height="1"></td>
          </tr>
          <tr> 
            <td> 
              <table width="100%" border="0" cellspacing="1" cellpadding="2" bgcolor="#CCCCCC">
                <tr> 
                  <td colspan="2" align="center" class="type">Members</td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">Max size of 
                    Avatar image:</td>
                  <td width="63%" bgcolor="#FFFFFF"> Width&amp;Height &lt; 
                    <input type="text" name="headpic_size" size="10" value="{headpic_size}">
                    (px)</td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">Upload Avatar 
                    image:</td>
                  <td width="63%" bgcolor="#FFFFFF"> Max: 
                    <input type="text" name="headpic_max" size="10" value="{headpic_max}">
                    (k) </td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">Max size of 
                    Signature: </td>
                  <td width="63%" bgcolor="#FFFFFF"> 
                    <input type="text" name="sig_size" size="10" value="{sig_size}">
                    (Bytes) </td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">Allow BB Code 
                    in Signature?</td>
                  <td width="63%" bgcolor="#FFFFFF"> 
                    <input type="text" name="sig_bb" value="{sig_bb}" size="10">
                    (1:Yes, 0:No)</td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">Stars:</td>
                  <td width="63%" bgcolor="#FFFFFF"> 
                    <input type="text" name="sc_star" size="5" value="{sc_star}">
                    Scores=1Star</td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF"> 
                    <p>Max size of PM:</p>
                  </td>
                  <td width="63%" bgcolor="#FFFFFF"> 
                    <input type="text" name="pm_max_content" size="10" value="{pm_max_content}">
                    (Bytes)</td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">Max records 
                    of PM:</td>
                  <td width="63%" bgcolor="#FFFFFF"> 
                    <input type="text" name="pm_max_num" size="10" value="{pm_max_num}">
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          <tr> 
            <td height="2" bgcolor="#666666"><img src="../images/spot.gif" width="1" height="1"></td>
          </tr>
        </table>
        <p>&nbsp; </p>
        <table width="98%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td height="2" bgcolor="#666666"><img src="../images/spot.gif" width="1" height="1"></td>
          </tr>
          <tr> 
            <td> 
              <table width="100%" border="0" cellspacing="1" cellpadding="2" bgcolor="#CCCCCC">
                <tr align="center"> 
                  <td colspan="2" class="type">Styles</td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">Language Folder:</td>
                  <td bgcolor="#FFFFFF"> 
                    <input type="text" name="lang_folder" value="{lang_folder}">
		    <input type="hidden" name="tpl_folder" value="{tpl_folder}">
                    <input type="hidden" name="tpl_pic_folder" value="{tpl_pic_folder}">
                    <input type="hidden" name="css_folder" value="{css_folder}">
                  </td>
                </tr>
                
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">Date Format</td>
                  <td bgcolor="#FFFFFF"> 
                    <input type="text" name="date_format" value="{date_format}">
                  </td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">Date Offset</td>
                  <td bgcolor="#FFFFFF"> 
                    <select name="date_offset">
                      <option value="{date_offset}" selected>no change..</option>
                      <option value="-12">(GMT -12:00) Eniwetok, Kwajalein</option>
                      <option value="-11">(GMT -11:00) Midway Island, Samoa</option>
                      <option value="-10">(GMT -10:00) Hawaii</option>
                      <option value="-9">(GMT -9:00) Alaska</option>
                      <option value="-8">(GMT -8:00) Pacific Time (US &amp; Canada), 
                      Tijuana</option>
                      <option value="-7">(GMT -7:00) Mountain Time (US &amp; Canada), 
                      Arizona</option>
                      <option value="-6">(GMT -6:00) Central Time (US &amp; Canada), 
                      Mexico City, Central America</option>
                      <option value="-5">(GMT -5:00) Eastern Time (US &amp; Canada), 
                      Bogota, Lima, Quito</option>
                      <option value="-4">(GMT -4:00) Atlantic Time (Canada), Caracas, 
                      La Paz, Santiago</option>
                      <option value="-3.5">(GMT -3:30) Newfoundland</option>
                      <option value="-3">(GMT -3:00) Brasilia, Buenos Aires, Georgetown, 
                      Greenland</option>
                      <option value="-2">(GMT -2:00) Mid-Atlantic, Ascension Islands, 
                      St. Helena</option>
                      <option value="-1">(GMT -1:00) Azores, Cape Verde Islands</option>
                      <option value="0">(GMT) Casablanca, Dublin, Edinburgh, Lisbon, 
                      London, Monrovia</option>
                      <option value="1">(GMT +1:00) Amsterdam, Berlin, Brussels, 
                      Madrid, Paris, Rome</option>
                      <option value="2">(GMT +2:00) Cairo, Helsinki, Kaliningrad, 
                      South Africa, Warsaw</option>
                      <option value="3">(GMT +3:00) Baghdad, Riyadh, Moscow, Nairobi</option>
                      <option value="3.5">(GMT +3:30) Tehran</option>
                      <option value="4">(GMT +4:00) Abu Dhabi, Baku, Muscat, Tbilisi</option>
                      <option value="4.5">(GMT +4:30) Kabul</option>
                      <option value="5">(GMT +5:00) Ekaterinburg, Islamabad, Karachi, 
                      Tashkent</option>
                      <option value="5.5">(GMT +5:30) Bombay, Calcutta, Madras, 
                      New Delhi</option>
                      <option value="6">(GMT +6:00) Almaty, Colombo, Dhaka, Novosibirsk, 
                      Sri Jayawardenepura</option>
                      <option value="6.5">(GMT +6:30) Rangoon</option>
                      <option value="7">(GMT +7:00) Bangkok, Hanoi, Jakarta, Krasnoyarsk</option>
                      <option value="8">(GMT +8:00) Beijing, Hong Kong, Perth, 
                      Singapore, Taipei</option>
                      <option value="9">(GMT +9:30) Adelaide, Darwin</option>
                      <option value="9.5">(GMT +9:30) Adelaide, Darwin</option>
                      <option value="10">(GMT +10:00) Canberra, Guam, Melbourne, 
                      Sydney, Vladivostok</option>
                      <option value="11">(GMT +11:00) Magadan, New Caledonia, 
                      Solomon Islands</option>
                      <option value="12">(GMT +12:00) Auckland, Fiji, Kamchatka, 
                      Marshall Island, Wellington</option>
                    </select>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          <tr> 
            <td height="2" bgcolor="#666666"><img src="../images/spot.gif" width="1" height="1"></td>
          </tr>
        </table>
        <p>&nbsp;</p>
        <table width="98%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td height="2" bgcolor="#666666"><img src="../images/spot.gif" width="1" height="1"></td>
          </tr>
          <tr> 
            <td> 
              <table width="100%" border="0" cellspacing="1" cellpadding="2" bgcolor="#CCCCCC">
                <tr> 
                  <td colspan="2" align="center" class="type">Other Settings</td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">Show Online 
                    info:</td>
                  <td width="63%" bgcolor="#FFFFFF"> 
                    <input type="text" name="show_online" size="5" value="{show_online}">
                    (1:Yes, 0:No)</td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">Online Time:</td>
                  <td width="63%" bgcolor="#FFFFFF"> 
                    <input type="text" name="refresh" size="10" value="{refresh}">
                    (minites)</td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">Minimum Interval 
                    Between two Submitted forms:<br>
                    (Including Comment,GuestBook,PM...)</td>
                  <td width="63%" bgcolor="#FFFFFF"> 
                    <input type="text" name="input_itvl" size="10" value="{input_itvl}">
                    (Second, '0' means no limit)</td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF"> 
                    <p>Forms Crigger:<br>
                      <a href="#note">(EXP3)</a></p>
                  </td>
                  <td width="63%" bgcolor="#FFFFFF"> 
                    <input type="text" name="input_crigger" size="5" value="{input_crigger}">
                  </td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">Minimum Interval 
                    Between two Refresh:</td>
                  <td width="63%" bgcolor="#FFFFFF"> 
                    <input type="text" name="view_itvl" size="10" value="{view_itvl}">
                    (Second, '0' means no limit)</td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF"> 
                    <p>Refresh Crigger:</p>
                  </td>
                  <td width="63%" bgcolor="#FFFFFF"> 
                    <input type="text" name="view_crigger" size="5" value="{view_crigger}">
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          <tr> 
            <td height="2" bgcolor="#666666"><img src="../images/spot.gif" width="1" height="1"></td>
          </tr>
        </table>
        <p>&nbsp;</p>
        <p> 
          <input type="hidden" name="action" value="system_basic">
          <input type="hidden" name="step" value="2">
          <input type="submit" name="Submit" value=" Submit ">
          <input type="reset" name="Submit2" value=" Reset ">
        </p>
      </form>
      <table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr> 
          <td bgcolor="#F3F3F3" align="center" valign="top"> <a name="note"> </a> 
            <table width="96%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td> EXP1:<font color="#339900">Format: <br>
                  </font> 
                  <table width="150" border="1" cellspacing="0" cellpadding="0" bordercolor="#009900">
                    <tr> 
                      <td><font color="#339900">123.123.123.123,123.123 123.123.123</font></td>
                    </tr>
                  </table>
                  <p>EXP2:<font color="#339900">Against Destined IP.</font></p>
                  <p>EXP3:<font color="#339900">Forms Crigger. For example, if 
                    you set the value '3', users can continuously submit three 
                    forms that exceeded the &quot;Minimum Interval Between two 
                    Submitted forms&quot;. <br>
                    Same rule for Refresh Crigger.</font></p>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
