
<table width="770" border="1" cellspacing="0" cellpadding="0" bordercolor="#999999">
  <tr> 
    <td bgcolor="#FFFFFF" bordercolor="#FFFFFF" align="center" valign="top"> 
      <table width="98%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td><font class="directory">設定內容</font></td>
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
                  <td colspan="2" align="center" class="type">基本信息</td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">論壇名稱：</td>
                  <td width="63%" bgcolor="#FFFFFF"> 
                    <input type="text" name="bb_name" value="{bb_name}" size="40">
                  </td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">論壇首頁地址：</td>
                  <td width="63%" bgcolor="#FFFFFF"> 
                    <input type="text" name="bb_url" value="{bb_url}" size="40">
                  </td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">網站名稱：</td>
                  <td width="63%" bgcolor="#FFFFFF"> 
                    <input type="text" name="web_name" value="{web_name}" size="40">
                  </td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">網站首頁地址：</td>
                  <td width="63%" bgcolor="#FFFFFF"> 
                    <input type="text" name="web_url" value="{web_url}" size="40">
                  </td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">管理員信箱：</td>
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
                  <td colspan="2" align="center" class="type">頭尾信息（將替換模板中的header 
                    和footer）</td>
                </tr>
                <tr> 
                  <td width="37%" align="center" bgcolor="#FFFFFF">頭部信息</td>
                  <td bgcolor="#FFFFFF"> 
                    <textarea name="bb_header" cols="60" rows="7">{bb_header}</textarea>
                  </td>
                </tr>
                <tr> 
                  <td width="37%" align="center" bgcolor="#FFFFFF"> 
                    <p>尾部信息</p>
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
                  <td colspan="2" align="center" class="type">安全與維護</td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">指定IP:<br>
                    <a href="#note">（註釋一）</a></td>
                  <td width="63%" bgcolor="#FFFFFF"> 
                    <textarea name="designated_ip" cols="60" rows="3">{designated_ip}</textarea>
                  </td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">對指定的IP如何處理:<br>
                    <a href="#note">（註釋二）</a></td>
                  <td width="63%" bgcolor="#FFFFFF"> 
                    <input type="text" name="attitude" size="5" value="{attitude}">
                    （0：禁止其訪問，1：僅允許其訪問）</td>
                </tr>
		<tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">詞語過濾:<br>
		  多個詞語請用逗號隔開，如:word1,word2<br>
                    </td>
                  <td width="63%" bgcolor="#FFFFFF"> 
                    <textarea name="badword" cols="60" rows="3">{badword}</textarea>
                  </td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">將詞語替換為:<br>
                    </td>
                  <td width="63%" bgcolor="#FFFFFF"> 
                    <input type="text" name="badword_rep" size="10" value="{badword_rep}">
                    （留空表示直接刪除）</td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">暫停網站服務:<br>
                  </td>
                  <td width="63%" bgcolor="#FFFFFF"> 
                    <input type="text" name="halting" size="5" value="{halting}">
                    （0：正常運行，1：暫停服務） </td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">暫停說明:<br>
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
                  <td colspan="2" align="center" class="type">論壇設定</td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">帖子標題最大長度（字符）：</td>
                  <td width="63%" bgcolor="#FFFFFF"> 
                    <input type="text" name="limit_title_size" value="{limit_title_size}" size="10">
                  </td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">帖子內容最大長度（字符）：</td>
                  <td width="63%" bgcolor="#FFFFFF"> 
                    <input type="text" name="limit_post_size" value="{limit_post_size}" size="10">
                  </td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">每頁主題數：</td>
                  <td width="63%" bgcolor="#FFFFFF"> 
                    <input type="text" name="topic_num" value="{topic_num}" size="10">
                  </td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">每頁帖子數：</td>
                  <td width="63%" bgcolor="#FFFFFF"> 
                    <input type="text" name="reply_num" value="{reply_num}" size="10">
                  </td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">帖子是否允許BBCODE：</td>
                  <td width="63%" bgcolor="#FFFFFF"> 
                    <input type="text" name="allow_postbb" value="{allow_postbb}" size="10">
                    (1、表示允許，0、不允許）</td>
                </tr>
				<tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">帖子是否允許表情圖標：</td>
                  <td width="63%" bgcolor="#FFFFFF"> 
                    <input type="text" name="allow_emote" value="{allow_emote}" size="10">
                    (1、表示允許，0、不允許）</td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">發貼驗證碼：</td>
                  <td width="63%" valign="top" bgcolor="#FFFFFF"> 
                    <p> 
                      <input type="text" name="confirm_code" value="{confirm_code}" size="10">
                      （1、表示使用，0、不使用）<br>
                      使用的話，用戶發表新貼必須根據動態生成的圖片輸入驗證信息，這樣能夠有效的避免惡意灌水。<br>
                      <font color="#FF0000">注意</font>：您的PHP必須支持GD庫，才可以使用該功能。</p>
                  </td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">發一個主題加多少分：</td>
                  <td width="63%" bgcolor="#FFFFFF"> 
                    <input type="text" name="sc_per_topic" value="{sc_per_topic}" size="10">
                  </td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">發一個回復加多少分：</td>
                  <td width="63%" bgcolor="#FFFFFF"> 
                    <input type="text" name="sc_per_post" value="{sc_per_post}" size="10">
                  </td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">是否允許會員發佈投票帖子：</td>
                  <td width="63%" bgcolor="#FFFFFF"> 
                    <input type="text" name="poll_on" value="{poll_on}" size="10">
                    (1:是, 0:否) </td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">是否允許會員在帖子中添加附件：</td>
                  <td width="63%" bgcolor="#FFFFFF"> 
                    <input type="text" name="attach_on" value="{attach_on}" size="10">
                    (1:是, 0:否) </td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">附件最大限制：</td>
                  <td width="63%" valign="top" bgcolor="#FFFFFF"> 
                    <p> 
                      <input type="text" name="attach_max_size" value="{attach_max_size}" size="10">
                      kb. </p>
                  </td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">每個帖子最多可以帶多少附件：</td>
                  <td width="63%" bgcolor="#FFFFFF"> 
                    <input type="text" name="attach_max_num" value="{attach_max_num}" size="10"> (「0」表示禁止上傳)
                  </td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">每個會員每天可以添加幾個附件？</td>
                  <td width="63%" bgcolor="#FFFFFF"> 
                    <input type="text" name="attach_max_days" value="{attach_max_days}" size="10"> (「0」表示禁止上傳)
                  </td>
                </tr>
		<tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">是否在瀏覽帖子頁面開啟快速回帖窗口？</td>
                  <td width="63%" bgcolor="#FFFFFF"> 
                    <input type="text" name="fast_reply" value="{fast_reply}" size="10">  (1、表示開啟，0、表示關閉）
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
                  <td colspan="2" align="center" class="type">用戶設定</td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">頭像大小：</td>
                  <td width="63%" bgcolor="#FFFFFF">長或寬不超過 
                    <input type="text" name="headpic_size" size="10" value="{headpic_size}">
                    像素</td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">上傳頭像文件：</td>
                  <td width="63%" bgcolor="#FFFFFF"> 小於 
                    <input type="text" name="headpic_max" size="10" value="{headpic_max}">
                    (k) </td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">簽名最大長度（字符）：</td>
                  <td width="63%" bgcolor="#FFFFFF"> 
                    <input type="text" name="sig_size" size="10" value="{sig_size}">
                  </td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">簽名中是否允許BBCODE：</td>
                  <td width="63%" bgcolor="#FFFFFF"> 
                    <input type="text" name="sig_bb" value="{sig_bb}" size="10">
                    (1、表示允許，0、不允許） </td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">獎章進位設定：</td>
                  <td width="63%" bgcolor="#FFFFFF"> 
                    <input type="text" name="sc_star" size="5" value="{sc_star}">
                    分=1顆星</td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF"> 
                    <p>會員短信息的長度限制: </p>
                  </td>
                  <td width="63%" bgcolor="#FFFFFF"> 
                    <input type="text" name="pm_max_content" size="10" value="{pm_max_content}">
                    （字節） </td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">會員短信息的數量限制: 
                  </td>
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
              <table width="100%" border="0" cellspacing="1" cellpadding="0" bgcolor="#CCCCCC">
                <tr align="center"> 
                  <td colspan="2" class="type">樣式</td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">語言文件目錄： </td>
                  <td bgcolor="#FFFFFF"> 
                    <input type="text" name="lang_folder" value="{lang_folder}">
                    <input type="hidden" name="tpl_folder" value="{tpl_folder}">
                    <input type="hidden" name="tpl_pic_folder" value="{tpl_pic_folder}">
                    <input type="hidden" name="css_folder" value="{css_folder}">
                  </td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">時間格式：</td>
                  <td bgcolor="#FFFFFF"> 
                    <input type="text" name="date_format" value="{date_format}">
                  </td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">時差：</td>
                  <td bgcolor="#FFFFFF"> 
                    <select name="date_offset">
                      <option value="{date_offset}" selected>no change..</option>
                      <option value="-12">(GMT -12:00) Eniwetok, Kwajalein</option>
                      <option value="-11">(GMT -11:00) Midway Island, Samoa</option>
                      <option value="-10">(GMT -10:00) Hawaii</option>
                      <option value="-9">(GMT -9:00) Alaska</option>
                      <option value="-8">(GMT -8:00) Pacific Time (US & Canada), 
                      Tijuana</option>
                      <option value="-7">(GMT -7:00) Mountain Time (US & Canada), 
                      Arizona</option>
                      <option value="-6">(GMT -6:00) Central Time (US & Canada), 
                      Mexico City, Central America</option>
                      <option value="-5">(GMT -5:00) Eastern Time (US & Canada), 
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
                  <td colspan="2" align="center" class="type">其它設定（1:開啟，0:關閉）</td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">是否顯示在線信息:</td>
                  <td width="63%" bgcolor="#FFFFFF"> 
                    <input type="text" name="show_online" size="5" value="{show_online}">
                  </td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">最短在線時間:<br>
                    （超過這個時間不訪問被認為已經離開）</td>
                  <td width="63%" bgcolor="#FFFFFF"> 
                    <input type="text" name="refresh" size="10" value="{refresh}">
                    （分鐘）</td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">提交表單的時間間隔:<br>
                    （包括發帖子、留言、短信息等）</td>
                  <td width="63%" bgcolor="#FFFFFF"> 
                    <input type="text" name="input_itvl" size="10" value="{input_itvl}">
                    （秒，0表示不限制）</td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF"> 
                    <p>提交表單限制觸發點:<br>
                      <a href="#note">（註釋三）</a> </p>
                  </td>
                  <td width="63%" bgcolor="#FFFFFF"> 
                    <input type="text" name="input_crigger" size="5" value="{input_crigger}">
                  </td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">頁面刷新間隔限制: </td>
                  <td width="63%" bgcolor="#FFFFFF"> 
                    <input type="text" name="view_itvl" size="10" value="{view_itvl}">
                    （秒，0表示不限制）</td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF"> 
                    <p>頁面刷新限制觸發點: </p>
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
          <input type="submit" name="Submit" value="  確定  ">
          <input type="reset" name="Submit2" value="  取消更改  ">
        </p>
      </form>
      <table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr> 
          <td bgcolor="#F3F3F3" align="center" valign="top"> <a name="note"> </a> 
            <table width="96%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td> 
                  <p>註釋一：<font color="#339900">指定IP。指定您想對其進行訪問控制的IP，如：「123.123.123.123」<br>
                    多個IP用「,」或者換行分隔。<br>
                    如果想封IP段，如123.123.123.*，請用「123.123.123」表示。</font></p>
                  <p>註釋二：<font color="#339900">對指定的IP如何處理。如果設定為0，指定的IP會被禁止訪問，其他IP沒有限制；如果設定為1，指定的IP可以訪問，其他所有IP均不可訪問。</font></p>
                  <p>註釋三：<font color="#339900">觸發點。以提交表單為例，如果出發點設為2，那麼訪客提交頭2個表單的時間間隔不被限制，如果超過了2個（即達到觸發點），那麼之前設定的「表單時間間隔」將起作用。「刷新觸發點」類似。</font></p>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
