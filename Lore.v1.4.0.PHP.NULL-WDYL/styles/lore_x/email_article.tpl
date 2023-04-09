{*
+----------------------------------------------------------------------
| Template: email_article.tpl
| 
| This template is used to display the "email article" form.
+----------------------------------------------------------------------
*}
{include file="header.tpl" action="Email Article"}

<h2>Email Article</h2>
{$article.title}
<br /><br />

{if !$form.readonly}
	<form method="{$form.method}" enctype="multipart/form-data" action="{$form.action}">
{/if}

<input type="hidden" name="action" value="{$form.submit_action}" />

{foreach name=hidden_field_loop item=hidden_field from=$hidden_fields}
	{$hidden_field.html}
{/foreach}

<table class="lore_form_table" width="450" cellpadding="0" cellspacing="2" border="0">

	{if $form.has_errors }
		<tr>
		<td class="lore_form_errors" colspan="2" width="100%">
	
			{if $form.num_errors > 1}
				<small><strong>{$form.num_errors} errors were found.</strong></small>
			{else}
				<small><strong>1 error was found.</strong></small>
			{/if}
	
		</td>
		</tr>
	{/if}

	<tr>
	<td class="lore_form_field_info" width="30%" valign="top">
		<strong>From Name</strong>		
	</td>
	<td class="lore_form_field" width="70%" valign="middle">
		{section name=error_loop loop=$fields.from_name.errors}
		<span class="lore_form_error">{$fields.from_name.errors[error_loop]}</span><br />
		{/section}

		{if !$form.readonly}
			<input class="lore_input" type="text" name="{$fields.from_name.id}" value="{$fields.from_name.html_escaped_value}" size="30" maxlength="255" />
		{else}
			{$fields.name.display_value}
		{/if}
	</td>
	</tr>

	<tr>
	<td class="lore_form_field_info" width="30%" valign="top">		
		<strong>From Email</strong>
	</td>
	<td class="lore_form_field" width="70%" valign="middle">
		{section name=error_loop loop=$fields.from_email.errors}
		<span class="lore_form_error">{$fields.from_email.errors[error_loop]}</span><br />
		{/section}
		{if !$form.readonly}
			<input class="lore_input" type="text" name="{$fields.from_email.id}" value="{$fields.from_email.html_escaped_value}" size="50" maxlength="255" />
		{else}
			{$fields.from_email.display_value}
		{/if}
	</td>
	</tr>

	<tr>
	<td class="lore_form_field_info" width="30%" valign="top">		
		<strong>Send to Email</strong>
	</td>
	<td class="lore_form_field" width="70%" valign="middle">
		{section name=error_loop loop=$fields.to_email.errors}
		<span class="lore_form_error">{$fields.to_email.errors[error_loop]}</span><br />
		{/section}
		{if !$form.readonly}
			<input class="lore_input" type="text" name="{$fields.to_email.id}" value="{$fields.to_email.html_escaped_value}" size="50" maxlength="255" />
		{else}
			{$fields.to_email.display_value}
		{/if}
	</td>
	</tr>

	<tr>
	<td class="lore_form_field_info" width="30%" valign="top">		
		<strong>Comment</strong>
	</td>
	<td class="lore_form_field" width="70%" valign="middle">
		{section name=error_loop loop=$fields.comment.errors}
		<span class="lore_form_error">{$fields.comment.errors[error_loop]}</span><br />
		{/section}

		{if !$form.readonly}
			<textarea class="lore_input" name="{$fields.comment.id}" rows="10" cols="60">{$fields.comment.html_escaped_value}</textarea>
		{else}
			{$fields.comment.display_value}
		{/if}
	</td>
	</tr>

</table>

{if !$form.readonly}
	<div class="lore_form_buttons">
		<input class="lore_button" name="{$buttons.submit.id}" type="submit" value="Send Email" />
		<input class="lore_button" type="reset" value="Reset" />
	</div>
{/if}

{if !$form.readonly}
	</form>
{/if}

{include file="footer.tpl"}
