{include file="cp_html_header.tpl"}

<div class="script_info_header">
	Lore Control Panel Access
</div>
<div class="content">
	» You must have cookies enabled on your browser.
	<br />
	» Your password is case sensitive.

	{if $error}
		<br /><br /><font color="red">» {$error}</font><br />
	{/if}
</div>





	<form method="POST" action="{$lore_system.scripts.cp_index}">
	<input type="hidden" name="action" value="login" />

	<table width="*" class="form_table">

		<tr>
			<td class="form_field_info" width="150" valign="top">		
				<b>Username</b><br />
				<small>Not case-sensitive</small>
			</td>
	
			<td class="form_field" width="*" valign="center">
				<input class="input" name="username" type="text" size="25" maxlength="25" />
			</td>
		</tr>

		<tr>
			<td class="form_field_info" width="150" valign="top">		
				<b>Password</b><br />
				<small>Case-sensitive</small>
			</td>
	
			<td class="form_field" width="*" valign="center">
				<input class="input" name="password" type="password" size="25" maxlength="25" />
			</td>
		</tr>
</table>

<div class="form_buttons">
<input class="button" type="submit" name="submit" value="Log In" />
</div>

</form>

{include file="cp_html_footer.tpl"}