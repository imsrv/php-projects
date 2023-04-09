{include file="header.tpl"}

Fill in the fields below to create an administrator account. This is the information
you will use to log in to the control panel.
<br /><br />

{if $error}
	<font color="red"><u>{$error}</u></font>
	<br /><br />
{/if}

<form method="post" action="{$php_self}">
<input type="hidden" name="action" value="{$form.submit_action}" />

Administrator Username:<br />
<small>Choose a username for the administrative user account.</small><br />
<input type="text" value="{$username}" name="username" size="40" maxlength="255" />
<br /><br />

Administrator Password:<br />
<small>Choose a password for the administrative user account.</small><br />
<input type="text" value="{$password}" name="password" size="40" maxlength="255" />
<br /><br />

Administrator Email Address:<br />
<small>Enter the email address of the administrative user.</small><br />
<input type="text" value="{$email}" name="email" size="40" maxlength="255" />
<br /><br />

<div class="buttons">
		<input name="step" value="{$step}" type="hidden" />
		{if $show_back_button}
			<input type="submit" name="back" value="<< Back" />
		{/if}
		{if $show_retry_button}
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="submit" name="retry" value="Retry" />
		{/if}
		{if $show_next_button}
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="submit" name="next" value="Next >>" />
		{/if}
</div>

</forn>

{include file="footer.tpl"}
