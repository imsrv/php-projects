
<table width="770" border="1" cellspacing="0" cellpadding="0" bordercolor="#999999">
  <tr> 
    <td bgcolor="#FFFFFF" bordercolor="#FFFFFF" align="center" valign="top"> 
      <table width="98%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td><font class="directory">设定内容</font></td>
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
                  <td width="37%" align="right" bgcolor="#FFFFFF">论坛名称：</td>
                  <td width="63%" bgcolor="#FFFFFF"> 
                    <input type="text" name="bb_name" value="{bb_name}" size="40">
                  </td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">论坛首页地址：</td>
                  <td width="63%" bgcolor="#FFFFFF"> 
                    <input type="text" name="bb_url" value="{bb_url}" size="40">
                  </td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">网站名称：</td>
                  <td width="63%" bgcolor="#FFFFFF"> 
                    <input type="text" name="web_name" value="{web_name}" size="40">
                  </td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">网站首页地址：</td>
                  <td width="63%" bgcolor="#FFFFFF"> 
                    <input type="text" name="web_url" value="{web_url}" size="40">
                  </td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">管理员信箱：</td>
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
                  <td colspan="2" align="center" class="type">头尾信息（将替换模板中的header 
                    和footer）</td>
                </tr>
                <tr> 
                  <td width="37%" align="center" bgcolor="#FFFFFF">头部信息</td>
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
                  <td colspan="2" align="center" class="type">安全与维护</td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">指定IP:<br>
                    <a href="#note">（注释一）</a></td>
                  <td width="63%" bgcolor="#FFFFFF"> 
                    <textarea name="designated_ip" cols="60" rows="3">{designated_ip}</textarea>
                  </td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">对指定的IP如何处理:<br>
                    <a href="#note">（注释二）</a></td>
                  <td width="63%" bgcolor="#FFFFFF"> 
                    <input type="text" name="attitude" size="5" value="{attitude}">
                    （0：禁止其访问，1：仅允许其访问）</td>
                </tr>
		<tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">词语过滤:<br>
		  多个词语请用逗号隔开，如:word1,word2<br>
                    </td>
                  <td width="63%" bgcolor="#FFFFFF"> 
                    <textarea name="badword" cols="60" rows="3">{badword}</textarea>
                  </td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">将词语替换为:<br>
                    </td>
                  <td width="63%" bgcolor="#FFFFFF"> 
                    <input type="text" name="badword_rep" size="10" value="{badword_rep}">
                    （留空表示直接删除）</td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">暂停网站服务:<br>
                  </td>
                  <td width="63%" bgcolor="#FFFFFF"> 
                    <input type="text" name="halting" size="5" value="{halting}">
                    （0：正常运行，1：暂停服务） </td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">暂停说明:<br>
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
                  <td colspan="2" align="center" class="type">论坛设定</td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">帖子标题最大长度（字符）：</td>
                  <td width="63%" bgcolor="#FFFFFF"> 
                    <input type="text" name="limit_title_size" value="{limit_title_size}" size="10">
                  </td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">帖子内容最大长度（字符）：</td>
                  <td width="63%" bgcolor="#FFFFFF"> 
                    <input type="text" name="limit_post_size" value="{limit_post_size}" size="10">
                  </td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">每页主题数：</td>
                  <td width="63%" bgcolor="#FFFFFF"> 
                    <input type="text" name="topic_num" value="{topic_num}" size="10">
                  </td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">每页帖子数：</td>
                  <td width="63%" bgcolor="#FFFFFF"> 
                    <input type="text" name="reply_num" value="{reply_num}" size="10">
                  </td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">帖子是否允许BBCODE：</td>
                  <td width="63%" bgcolor="#FFFFFF"> 
                    <input type="text" name="allow_postbb" value="{allow_postbb}" size="10">
                    (1、表示允许，0、不允许）</td>
                </tr>
				<tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">帖子是否允许表情图标：</td>
                  <td width="63%" bgcolor="#FFFFFF"> 
                    <input type="text" name="allow_emote" value="{allow_emote}" size="10">
                    (1、表示允许，0、不允许）</td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">发贴验证码：</td>
                  <td width="63%" valign="top" bgcolor="#FFFFFF"> 
                    <p> 
                      <input type="text" name="confirm_code" value="{confirm_code}" size="10">
                      （1、表示使用，0、不使用）<br>
                      使用的话，用户发表新贴必须根据动态生成的图片输入验证信息，这样能够有效的避免恶意灌水。<br>
                      <font color="#FF0000">注意</font>：您的PHP必须支持GD库，才可以使用该功能。</p>
                  </td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">发一个主题加多少分：</td>
                  <td width="63%" bgcolor="#FFFFFF"> 
                    <input type="text" name="sc_per_topic" value="{sc_per_topic}" size="10">
                  </td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">发一个回复加多少分：</td>
                  <td width="63%" bgcolor="#FFFFFF"> 
                    <input type="text" name="sc_per_post" value="{sc_per_post}" size="10">
                  </td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">是否允许会员发布投票帖子：</td>
                  <td width="63%" bgcolor="#FFFFFF"> 
                    <input type="text" name="poll_on" value="{poll_on}" size="10">
                    (1:是, 0:否) </td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">是否允许会员在帖子中添加附件：</td>
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
                  <td width="37%" align="right" bgcolor="#FFFFFF">每个帖子最多可以带多少附件：</td>
                  <td width="63%" bgcolor="#FFFFFF"> 
                    <input type="text" name="attach_max_num" value="{attach_max_num}" size="10"> (“0”表示禁止上传)
                  </td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">每个会员每天可以添加几个附件？</td>
                  <td width="63%" bgcolor="#FFFFFF"> 
                    <input type="text" name="attach_max_days" value="{attach_max_days}" size="10"> (“0”表示禁止上传)
                  </td>
                </tr>
		<tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">是否在浏览帖子页面开启快速回帖窗口？</td>
                  <td width="63%" bgcolor="#FFFFFF"> 
                    <input type="text" name="fast_reply" value="{fast_reply}" size="10">  (1、表示开启，0、表示关闭）
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
                  <td colspan="2" align="center" class="type">用户设定</td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">头像大小：</td>
                  <td width="63%" bgcolor="#FFFFFF">长或宽不超过 
                    <input type="text" name="headpic_size" size="10" value="{headpic_size}">
                    像素</td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">上传头像文件：</td>
                  <td width="63%" bgcolor="#FFFFFF"> 小于 
                    <input type="text" name="headpic_max" size="10" value="{headpic_max}">
                    (k) </td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">签名最大长度（字符）：</td>
                  <td width="63%" bgcolor="#FFFFFF"> 
                    <input type="text" name="sig_size" size="10" value="{sig_size}">
                  </td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">签名中是否允许BBCODE：</td>
                  <td width="63%" bgcolor="#FFFFFF"> 
                    <input type="text" name="sig_bb" value="{sig_bb}" size="10">
                    (1、表示允许，0、不允许） </td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">奖章进位设定：</td>
                  <td width="63%" bgcolor="#FFFFFF"> 
                    <input type="text" name="sc_star" size="5" value="{sc_star}">
                    分=1颗星</td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF"> 
                    <p>会员短信息的长度限制: </p>
                  </td>
                  <td width="63%" bgcolor="#FFFFFF"> 
                    <input type="text" name="pm_max_content" size="10" value="{pm_max_content}">
                    （字节） </td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">会员短信息的数量限制: 
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
                  <td colspan="2" class="type">样式</td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">语言文件目录： </td>
                  <td bgcolor="#FFFFFF"> 
                    <input type="text" name="lang_folder" value="{lang_folder}">
                    <input type="hidden" name="tpl_folder" value="{tpl_folder}">
                    <input type="hidden" name="tpl_pic_folder" value="{tpl_pic_folder}">
                    <input type="hidden" name="css_folder" value="{css_folder}">
                  </td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">时间格式：</td>
                  <td bgcolor="#FFFFFF"> 
                    <input type="text" name="date_format" value="{date_format}">
                  </td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">时差：</td>
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
                  <td colspan="2" align="center" class="type">其它设定（1:开启，0:关闭）</td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">是否显示在线信息:</td>
                  <td width="63%" bgcolor="#FFFFFF"> 
                    <input type="text" name="show_online" size="5" value="{show_online}">
                  </td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">最短在线时间:<br>
                    （超过这个时间不访问被认为已经离开）</td>
                  <td width="63%" bgcolor="#FFFFFF"> 
                    <input type="text" name="refresh" size="10" value="{refresh}">
                    （分钟）</td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">提交表单的时间间隔:<br>
                    （包括发帖子、留言、短信息等）</td>
                  <td width="63%" bgcolor="#FFFFFF"> 
                    <input type="text" name="input_itvl" size="10" value="{input_itvl}">
                    （秒，0表示不限制）</td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF"> 
                    <p>提交表单限制触发点:<br>
                      <a href="#note">（注释三）</a> </p>
                  </td>
                  <td width="63%" bgcolor="#FFFFFF"> 
                    <input type="text" name="input_crigger" size="5" value="{input_crigger}">
                  </td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF">页面刷新间隔限制: </td>
                  <td width="63%" bgcolor="#FFFFFF"> 
                    <input type="text" name="view_itvl" size="10" value="{view_itvl}">
                    （秒，0表示不限制）</td>
                </tr>
                <tr> 
                  <td width="37%" align="right" bgcolor="#FFFFFF"> 
                    <p>页面刷新限制触发点: </p>
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
          <input type="submit" name="Submit" value="  确定  ">
          <input type="reset" name="Submit2" value="  取消更改  ">
        </p>
      </form>
      <table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr> 
          <td bgcolor="#F3F3F3" align="center" valign="top"> <a name="note"> </a> 
            <table width="96%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td> 
                  <p>注释一：<font color="#339900">指定IP。指定您想对其进行访问控制的IP，如：“123.123.123.123”<br>
                    多个IP用“,”或者换行分隔。<br>
                    如果想封IP段，如123.123.123.*，请用“123.123.123”表示。</font></p>
                  <p>注释二：<font color="#339900">对指定的IP如何处理。如果设定为0，指定的IP会被禁止访问，其他IP没有限制；如果设定为1，指定的IP可以访问，其他所有IP均不可访问。</font></p>
                  <p>注释三：<font color="#339900">触发点。以提交表单为例，如果出发点设为2，那么访客提交头2个表单的时间间隔不被限制，如果超过了2个（即达到触发点），那么之前设定的“表单时间间隔”将起作用。“刷新触发点”类似。</font></p>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
