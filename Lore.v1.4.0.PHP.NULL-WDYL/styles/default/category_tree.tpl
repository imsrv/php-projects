{*
+----------------------------------------------------------------------
| Template: category_tree.tpl
| 
| This template is used to generate the category tree that is
| displayed in the left panel on every page of your knowledge base.
| It is not recommended that you modify this template. If you need
| to change the look of menu, edit the CSS stylesheet (stylesheet.css)
+----------------------------------------------------------------------
*}
{foreach key="name" item="id" from=$category_tree}
	{if is_array( $id ) }
		{if @in_array( $last_category_id, $category_path_ids ) }
			{include file="category_tree.tpl" category_tree=$id depth="`$depth+1`"}
		{/if}
	{else}
		{assign var="last_category_id" value=$id}
		{if $id == $category.id}
			<div class="lore_category_tree_current_category"><a style="padding-left:{$depth*10}px;" href="{$lore_system.base_dir}/{lore_link type=category category_id="`$id`" category_name="`$name`"}"><img src="{$lore_system.base_dir}/{$image_dir}/arrow_down.gif" alt="" border="0" />&nbsp;{$name}</a></div>
		{else}
			<div class="lore_category_tree_category" ><a style="padding-left:{$depth*10}px;" href="{$lore_system.base_dir}/{lore_link type=category category_id="`$id`" category_name="`$name`"}"><img src="{$lore_system.base_dir}/{$image_dir}/arrow.gif" alt="" border="0" />&nbsp;{$name}</a></div>
		{/if}
		
	{/if}
{/foreach}
