<script type="text/javascript">
   _editor_url = "../third_party/htmlarea/";
   _editor_lang = "en";
</script>
<script type="text/javascript" src="../third_party/htmlarea/htmlarea.js"></script>


{if !$form.readonly}
	<form method="{$form.method}" enctype="multipart/form-data" action="{$form.action}">
{/if}

<input type="hidden" name="action" value="{$form.submit_action}" />

{foreach name=field_loop item=field from=$hidden_fields}
	{$field.html}
{/foreach}

{if !$form.readonly}
	<div class="form_header" colspan="2">
		{if $form.icon}
			<img src="{$image_dir}/{$form.icon}" align="middle" /> 
		{/if}
		<b>{$form.name}</b><br />
		<small>{$form.description}</small>
	</div>
{/if}

<table width="*" class="form_table">

	{if $form.has_errors }
		<tr>
		<td class="form_errors" colspan="2">
			<small>
			{if $form.num_errors > 1}
				<b>» {$form.num_errors} errors were found in your submission.</b>
			{else}
				<b>» 1 error was found in your submission.</b>
			{/if}
			<br />
	
			{section name="form_error_loop" loop=$form.errors}	
				<br />
				<font class="form_error">
					{$form.errors[form_error_loop]}
				</font>
			{/section}
			</small>
		</td>
		</tr>
	{/if}
