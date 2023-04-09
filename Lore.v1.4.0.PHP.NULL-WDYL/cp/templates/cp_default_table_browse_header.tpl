<form method="POST" action="{$action}">
{$form.current_page_input}
<input type="hidden" name="action" value="{$form.submit_action}" />
<input type="hidden" name="sid" value="{$sid}" />
<center>

<div class="table_browse_header">
	{if $icon}
	<img src="{$image_dir}/{$icon}" align="middle" /> 
	{/if}
	<b>{$name}</b><br />
	<small>{$description}</small>
</div>

<div class="table_browse_content">

	{foreach name=option_field_loop key=option_field_id item=option_field from=$option_fields}
		<div class="table_browse_controls">
			{$option_field.caption} {$form.option_fields[$option_field_id]} {$form.update_results}
		</div>
	{/foreach}

	{section name=search_field_loop loop=$search_fields}
		<div class="table_browse_controls">
			{if $search_fields[search_field_loop].type == "text" }
			Search {$form.search_by} for {$form.search_for} {$form.update_results}
			{/if}
		</div>
	{/section}
	
	{if $have_page_controls }
		<div class="table_browse_controls">
			Show {$form.results_per_page} {$row_name} per page {$form.update_results}
		</div>
	{/if}

	{if $have_order_by_controls }
		<div class="table_browse_controls">
			Order by {$form.order_by_field} in {$form.order_by_type} order {$form.order_by_submit_button}
		</div>
	{/if}

	<br />