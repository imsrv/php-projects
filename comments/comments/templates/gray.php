<?

// Please don't modify or delete the copyright notice. Doing that is a violation of GPL.

print<<<EOF
<style type="text/css">
div#usernotes {
	background-color: #e0e0e0;
	color: inherit;
}
div#usernotes div.head, div#usernotes div.foot {
	background-color: #d0d0d0;
	color: inherit;
	padding: 4px;
}
div#usernotes div.foot {
	text-align: right;
}
div#usernotes div.foot a, div#usernotes div.head a {
	color: black;
	background-color: transparent;
}
div#usernotes span.action {
	float: right;
}
div#usernotes div.note {
	padding: 4px;
}
div#usernotes div.text {
	background-color: #f0f0f0;
	color: inherit;
	padding: 2px;
	margin-top: 4px;
}
</style>

<div id="usernotes">
 <div class="head">
 <H3>{$COM_LANG['header']}</H3>
 </div>
EOF;

 if ($comments_count) {
  for($i=0; $i<$comments_count; $i++) {
   if ($dont_show_email[$i] != '1' && $email != '') { $author[$i] = "<a href=\"mailto:{$email[$i]}\">{$author[$i]}</a>"; }
   $text[$i] = str_replace(chr(13), '<br />', $text[$i]);
   
   print<<<EOF
 <div class="note">
  <strong>{$author[$i]}</strong><br />
  <small>{$time[$i]}</small>
  <div class="text">
  {$text[$i]}
  </div>
 </div>
EOF;
  
  }
 }
 else {
   print<<<EOF
 <div class="note">
  <div class="text">
  {$COM_LANG['no_comments_yet']}
  </div>
 </div>
EOF;
 }
 
print<<<EOF
 <div class="foot">
		<form method=POST action='{$COM_CONF['script_url']}'>
	              <input type=hidden name="action" value="add">
		      <input type=hidden name="href" value="{$_SERVER['REQUEST_URI']}">
		  <table width="290" border="0" cellspacing="1" cellpadding="2" align="center">
		    <tr> 
		      <td width="83" align="right"><font color="red">*</font>{$COM_LANG['Name']}: 
		        </td>
		      <td width="196">
		        <input type=text name="disc_name" maxlength=40 size=30>
		        <input type=hidden name="r_disc_name" value="{$COM_LANG['r_disc_name']}">
		        </td>
		    </tr>
		    <tr> 
		      <td width="83" align="right">{$COM_LANG['E-mail']}:</font></td>
		      <td width="196">
		        <input type="Text" name="disc_email" size="30" maxlength="70">
		        </td>
		    </tr>
		    <tr> 
		      <td width="83"></td>
		      <td width="196">
			<input type="checkbox" name="email_me"><font size=2>{$COM_LANG['Notify']}</font><br>
			<input type="checkbox" name="dont_show_email" CHECKED><font size=2>{$COM_LANG['Dont_show_email']}</font><br>
		        </td>
		    </tr>
		    <tr> 
		      <td valign="top" width="83" align="right"> 
		        <font color="red">*</font>{$COM_LANG['Text']}:
		      </td>
		      <td valign="top" width="196">
		        <textarea name="disc_body" cols="40" rows="13" wrap="VIRTUAL"></textarea>
		        <input type=hidden name="r_disc_body" value="{$COM_LANG['r_disc_text']}">
		        </td>
		    </tr>
		    <tr> 
		      <td valign="top" width="83" align="right">&nbsp; </td>
		      <td valign="top" width="196">
		        <div align="center">
		          <input type="submit" name="Submit" value="{$COM_LANG['Submit']}">
		          </div>
		      </td>
		    </tr>
		  </table>
		</form>
          Powered by  <a href="http://www.scriptsmill.com/comments.html">Scriptsmill Comments Script</a>
 </div>
</div>
EOF;

?>