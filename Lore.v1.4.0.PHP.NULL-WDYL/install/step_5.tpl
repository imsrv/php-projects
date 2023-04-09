{include file="header.tpl"}

Imported default configuration data.

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
