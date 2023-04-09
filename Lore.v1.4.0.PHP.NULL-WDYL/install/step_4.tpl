{include file="header.tpl"}

Creating database structure. This creates the MySQL database tables that Lore will use.
<br /><br />

{include file="checks.tpl"}

{if $errors}
	<div class="alert">
		Unable to initialize your database. Please verify that your
		database configuration in <strong>/inc/config.inc.php</strong> is correct:
		
		<br /><br />
		<strong>Hostname:</strong> {$db_host}<br />
		<strong>Username:</strong> {$db_username}<br />
		<strong>Password:</strong> {$db_password}<br />
		<strong>Database:</strong> {$db_database}<br />
		<br /><br />

		Please correct these errors and click
		the "Retry" button below, or restart installation.
	</div>
{/if}

<div class="buttons">
	<form method="POST" action="{$php_self}">
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
	</form>
</div>

{include file="footer.tpl"}

