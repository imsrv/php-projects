{include file="cp_default_table_browse_header.tpl"}

{if count($rows) }

	<table width="100%">
		<tr>
		
		{if $have_row_checkboxes}
			<td class="table_browse_rows" width="1">&nbsp;</td>
		{/if}
		
		{section name=field_name_loop loop=$field_names}
		          <th class="table_browse_field_header">
				{$field_names[field_name_loop]}
		          </th>
		{/section}
	
		{if $rows[0].links }
			<th class="table_browse_rows" width="1%">&nbsp;</td>
		{/if}
	
		</tr>
	
		{section name=row_loop loop=$rows}

			{if $smarty.section.row_loop.rownum is even}
				{assign var="td_class" value="table_browse_rows_1"}
			{else}
				{assign var="td_class" value="table_browse_rows_2"}
			{/if}

			<tr>
			
			{if $have_row_checkboxes }
				<td class="{$td_class}" width="1" valign="center">
					{$form.row_checkboxes[row_loop]}
				</td>
			{/if}
			
			{foreach name=field_loop item=field key=field_id from=$rows[row_loop].fields}
				<td class="{$td_class}" align="center">	
					{$field}
				</td>
			{/foreach}
			
			{if count($rows[row_loop].links) }
				<td class="{$td_class}" valign="center">
					<select class="input" name="url" onChange="window.location.href=this[selectedIndex].value;" size="1">
						<option value="-1">-</a>
						{section name=link_loop loop=$rows[row_loop].links}
							<option value="{$rows[row_loop].links[link_loop].link_to}">{$rows[row_loop].links[link_loop].link}</option>
						{/section}
					</select>
				</td>
			{/if}
	
		{/section}
	
	</table>
{else}
	No {$row_name} were found.
{/if}


{include file="cp_default_table_browse_footer.tpl"}