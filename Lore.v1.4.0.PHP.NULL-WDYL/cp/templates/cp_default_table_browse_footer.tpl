<br />
{if $rows }
{if $have_row_checkboxes OR $have_page_controls }

	{if $have_row_checkboxes }
		<div class="table_browse_controls">
			<img src="{$image_dir}/with_selected.gif" align="middle" /> 
			With selected {$row_name}: {$form.action} {$form.action_submit_button} &nbsp;

			{section name=action_argument_field_loop loop=$action_argument_fields}
				{$action_argument_fields[action_argument_field_loop].html}
			{/section}

			</b></big>
	
		{$next_page} {$last_page} &nbsp;
		
		</div>
	{/if}

	{if $have_page_controls }
		<div class="table_browse_controls">
			<center>
			&nbsp; {$form.first_page} {$form.prev_page}
		
			&nbsp;&nbsp; {$total_results} {$row_name} found. &nbsp; » &nbsp; Page <b>{$current_page}</b> of <b>{$num_pages}</b> &nbsp;&nbsp;
		
			{$form.next_page} {$form.last_page} &nbsp;
			</center>
		</div>
	{/if}
{/if}
{/if}