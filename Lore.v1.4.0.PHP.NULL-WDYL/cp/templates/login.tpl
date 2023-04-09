{include file="html_header.tpl"}

<div class="content_header">
	<div class="content_header_caption" style="width: 300px;">
		Please log in to access the control panel
	</div>
</div>
<div class="content">
	» You must have cookies enabled on your browser.
	<br />
	» Your password is case sensitive.
</div>

<div class="form_table">
	<form method="POST" action="{$lore_system.scripts.cp_index}">
		<input type="hidden" name="action" value="login" />
		<b>Username:</b> <input class="input" name="username" type="text" size="25" maxlength="25" />
		&nbsp;&nbsp;
		<b>Password:</b> <input class="input" name="password" type="password" size="25" maxlength="25" />
		&nbsp;
		<input class="button" type="submit" name="submit" value="Log In">
	</form>
</div>

{include file="html_footer.tpl"}
