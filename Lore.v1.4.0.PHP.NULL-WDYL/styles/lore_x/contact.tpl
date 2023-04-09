{*
+----------------------------------------------------------------------
| Template: contact.tpl
| 
| This template is used to display the "Contact Us" form, as well
| as the list of articles returned by the automated reply system, if
| it is enabled.
+----------------------------------------------------------------------
*}
{include file="header.tpl" action="Contact Us"}

<h2>Contact Us</h2>

{if count($articles) }

	<h3>Inquiry not yet Submitted</h3>

	<div class="lore_content_box">

		To better assist you in finding the answer to your question as fast 
		as possible, we found the following articles that may be relevant to your
		inquiry:
		
		<br /><br />
		{include file="articles.tpl"}
		<br />


		If the above articles do not answer your question, use the form below to send your inquiry to our support team.
	</div>

	<br />
{/if}

{if !$form.readonly}
	<form method="{$form.method}" enctype="multipart/form-data" action="{$form.action}">
{/if}

<input type="hidden" name="action" value="{$form.submit_action}" />

{if count($articles) }
	<input type="hidden" name="already_viewed_relevant_articles" value="1" />
{/if}

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
				<small><strong>1 error was found</strong></small>
			{/if}
	
		</td>
		</tr>
	{/if}

	<tr>
	<td class="lore_form_field_info" width="30%" valign="top">
		<strong>Name</strong><br />
		<small>Your full name.</small>	
	</td>
	<td class="lore_form_field" width="70%" valign="middle">
		{section name=error_loop loop=$fields.name.errors}
		<span class="lore_form_error">{$fields.name.errors[error_loop]}</span><br />
		{/section}

		{if !$form.readonly}
			<input class="lore_input" type="text" name="{$fields.name.id}" value="{$fields.name.html_escaped_value}" size="30" maxlength="255" />
		{else}
			{$fields.name.display_value}
		{/if}
	</td>
	</tr>

	<tr>
	<td class="lore_form_field_info" width="30%" valign="top">		
		<strong>Email</strong><br />
		<small>Email address where you can be contacted at.</small>
	</td>
	<td class="lore_form_field" width="70%" valign="middle">
		{section name=error_loop loop=$fields.email.errors}
		<span class="lore_form_error">{$fields.email.errors[error_loop]}</span><br />
		{/section}
		{if !$form.readonly}
			<input class="lore_input" type="text" name="{$fields.email.id}" value="{$fields.email.html_escaped_value}" size="50" maxlength="255" />
		{else}
			{$fields.email.display_value}
		{/if}
	</td>
	</tr>

	<tr>
	<td class="lore_form_field_info" width="30%" valign="top">		
		<strong>Email (Re-enter)</strong>
	</td>
	<td class="lore_form_field" width="70%" valign="middle">
		{section name=error_loop loop=$fields.email_reenter.errors}
		<span class="lore_form_error">{$fields.email_reenter.errors[error_loop]}</span><br />
		{/section}
		{if !$form.readonly}
			<input class="lore_input" type="text" name="{$fields.email_reenter.id}" value="{$fields.email_reenter.html_escaped_value}" size="50" maxlength="255" />
		{else}
			{$fields.email_reenter.display_value}
		{/if}
	</td>
	</tr>

	<tr>
	<td class="lore_form_field_info" width="30%" valign="top">		
		<strong>Subject</strong><br />
		<small>Your question.</small>
	</td>
	<td class="lore_form_field" width="70%" valign="middle">
		{section name=error_loop loop=$fields.subject.errors}
		<span class="lore_form_error">{$fields.subject.errors[error_loop]}</span><br />
		{/section}

		{if !$form.readonly}
			<input class="lore_input" type="text" name="{$fields.subject.id}" value="{$fields.subject.html_escaped_value}" size="50" maxlength="255" />
		{else}
			{$fields.subject.display_value}
		{/if}

	</td>
	</tr>

	<tr>
	<td class="lore_form_field_info" width="30%" valign="top">		
		<strong>Inquiry</strong><br />
		<small>Full explanation of your inquiry.</small>
	</td>
	<td class="lore_form_field" width="70%" valign="middle">
		{section name=error_loop loop=$fields.body.errors}
		<span class="lore_form_error">{$fields.body.errors[error_loop]}</span><br />
		{/section}

		{if !$form.readonly}
			<textarea class="lore_input" name="{$fields.body.id}" rows="10" cols="60">{$fields.body.html_escaped_value}</textarea>
		{else}
			{$fields.body.display_value}
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
