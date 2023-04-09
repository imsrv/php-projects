{*
+----------------------------------------------------------------------
| Template: category_select.tpl
| 
| This template is used to generate the category drop-down menu
| displayed at the top of every page on the knowledge base.
| If you need to change the depth of the categories in the menu,
| go to "Edit Settings" in the control panel and change
| "Category Select Depth". It is not recommended that you modify this
| template.
+----------------------------------------------------------------------
*}
{foreach key=key item=value from=$category_tree}
	{if $depth <= $lore_system.settings.category_select_depth }
		{if is_array( $value ) }
			{include file="category_select.tpl" category_tree=$value depth="`$depth+1`"}
		{else}
			<option value="{$value}">{"....."|str_repeat:$depth} {$key}</option>	
		{/if}
	{/if}
{/foreach}
