{*
+----------------------------------------------------------------------
| Template: comment.tpl
| 
| This template is used to display the form which allows a user to
| post a comment on an article.
+----------------------------------------------------------------------
*}
{include file="header.tpl" action="Add Comment"}

<h2>Add Comment</h2>
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
		<strong>Name</strong>		
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
		<strong>Email (optional)</strong>
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
		<strong>Title (optional)</strong>
		{if !$form.readonly}
			<br />
			<small>Subject/title of your comment.</small>
		{/if}
		
	</td>
	<td class="lore_form_field" width="70%" valign="middle">
		{section name=error_loop loop=$fields.title.errors}
		<span class="lore_form_error">{$fields.title.errors[error_loop]}</span><br />
		{/section}

		{if !$form.readonly}
			<input class="lore_input" type="text" name="{$fields.title.id}" value="{$fields.title.html_escaped_value}" size="50" maxlength="255" />
		{else}
			{$fields.title.display_value}
		{/if}

	</td>
	</tr>

	<tr>
	<td class="lore_form_field_info" width="30%" valign="top">		
		<strong>Comment</strong>
	</td>
	<td class="lore_form_field" width="70%" valign="middle">
		{section name=error_loop loop=$fields.comment.errors}
		<span id="form_error">{$fields.comment.errors[error_loop]}</span><br />
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
		<input class="lore_button" name="{$buttons.submit.id}" type="submit" value="Submit" />
		<input class="lore_button" type="reset" value="Reset" />
	</div>
{/if}

{if !$form.readonly}
	</form>
{/if}

<br /><br />

{if $article.comments}
	<h3>
		Previously Posted Comments
	</h3>
	<div class="lore_article_comments" style="height:150px;overflow:auto;border: 1px inset;padding:3px;">
		{include file="comments.tpl"}
	</div>
{/if}

{include file="footer.tpl"}
