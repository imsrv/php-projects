{include file="cp_default_form_header.tpl"}

{foreach name=field_loop item=field from=$fields}

	{if !$field.hidden}
		<tr>
		<td class="form_field_info" width="150" valign="top">		
			<b>{$field.name}</b>
	
			{if !$form.readonly}
				<br />
				<small>{$field.description}</small>
			{/if}
		
		</td>

		<td class="form_field" width="*" valign="center">

			{section name=error_loop loop=$field.errors}
			<span class="form_error">{$field.errors[error_loop]}</span><br />
			{/section}

			{$field.html}
		</td>

		</tr>
	{/if}
{/foreach}

{include file="cp_default_form_footer.tpl"}