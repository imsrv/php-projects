{include file="cp_default_table_browse_header.tpl"}

{if count($rows) }
	<table width="100%">
		<tr>
		
		{if $have_row_checkboxes}
			<td class="table_browse_rows" width="1%" colspan=1>&nbsp;</td>
		{/if}
	
		<th class="table_browse_field_header">
			ID
		</th>	
		<th class="table_browse_field_header">
			Published
		</th>
		<th class="table_browse_field_header">
			Name
		</th>
		<th class="table_browse_field_header">
			Description
		</th>
		<th class="table_browse_field_header">
			Total Articles
		</th>
	
		{if $rows[0].links }
			<th class="table_browse_rows" width="1">&nbsp;</td>
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
			          <td class="{$td_class}" valign="center" width="1%">
				          {$form.row_checkboxes[row_loop]}
			          </td>
			{/if}
			
			<td class="{$td_class}" align="center">
				{$rows[row_loop].fields.id}
			</td>

			<td class="{$td_class}" align="center">
				{if $rows[row_loop].fields.published }
					<font color="green"><b>YES</b></font>
				{else}
					<font color="red"><b>NO</b></font>
				{/if}
			</td>

			<td class="{$td_class}" align="left">
				{$rows[row_loop].fields.name}
			</td>
			<td class="{$td_class}" align="left">
				{$rows[row_loop].fields.description}
			</td>
			<td class="{$td_class}" align="center">
				{$rows[row_loop].fields.total_articles}
			</td>
			
			<td class="{$td_class}" valign="center">
				<select class="input" name="url" onChange="window.location.href=this[selectedIndex].value;" size="1">
					<option value="-1">-</a>
					{section name=link_loop loop=$rows[row_loop].links}
						<option value="{$rows[row_loop].links[link_loop].link_to}">{$rows[row_loop].links[link_loop].link}</option>
					{/section}		
				</select>
			</td>
			</tr>
		{/section}
	
	</table>

{else}
	No {$row_name} were found.
{/if}

{include file="cp_default_table_browse_footer.tpl"}