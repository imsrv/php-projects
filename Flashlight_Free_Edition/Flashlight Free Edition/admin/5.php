<div id="textbox">
<form name="settings" action="admin.php?action=u5" method="post">
<b>Flashlight Settings</b><br /><br />
Company Name (<a href="javascript:void(0)" style="cursor:help;" title="Click here for more information" onClick="alert('Enter the name of the company Flashlight is licensed to.');">?</a>):<br /><input type="text" name="cname" size="20" maxlength="50" value="<?=$company_name?>"><br /><br />
Company URL (<a href="javascript:void(0)" style="cursor:help;" title="Click here for more information" onClick="alert('Enter the URL of the company Flashlight is licensed to.');">?</a>):<br /><input type="text" name="curl" size="20" maxlength="50" value="<?=$company_url?>"><br /><br />
Message Attachments: (<a href="javascript:void(0)" style="cursor:help;" title="Click here for more information" onClick="alert('Allow users to upload files as attachments.');">?</a>)<br /><input type="checkbox" name="attachments" value="1"<? if ($message_attachments == 1) { echo ' checked'; } ?>> Activated<br /><br />
Message Attachments Maxsize (bytes) (<a href="javascript:void(0)" style="cursor:help;" title="Click here for more information" onClick="alert('Maximum size per attachment file in bytes (1MB = 1048576 bytes).');">?</a>):<br /><input type="text" size="10" name="maxsize" value="<?=$message_attachments_maxsize?>" maxlength="20"><br /><br />
Message Attachments Total (<a href="javascript:void(0)" style="cursor:help;" title="Click here for more information" onClick="alert('Maximum number of attachments allowed per message.');">?</a>):<br /><input type="text" size="3" name="maxtotal" value="<?=$message_attachments_total?>" maxlength="5"><br /><br />
<input type="submit" value="Update Settings"> <input type="reset" value=" Reset ">
</form>
</div>