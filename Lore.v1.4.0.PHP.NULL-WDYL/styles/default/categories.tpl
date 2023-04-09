{*
+----------------------------------------------------------------------
| Template: categories.tpl
|
| This template is used to generate the list of categories on the 
| front page, as well as the lists of subcategories within other
| categories.
+----------------------------------------------------------------------
*}
<table cellpadding="0" border="0" cellspacing="0" width="95%">
<tr>

{if count($categories) == 1 }
	{assign var=width value="100%"}
{elseif count($categories) == 2}
	{assign var=width value="50%"}
{else}
	{assign var=width value="33%"}
{/if}

{foreach item="category" from=$categories name="category_loop"}
	<td class="lore_category" valign="top" width="{$width}">

		<table>
		<tr>
		<td valign="top">
			<img src="{$lore_system.base_dir}/{$image_dir}/folder.gif" alt="category" />
		</td>
		<td valign="middle">
			<a class="lore_normal_link" href="{$lore_system.base_dir}/{lore_link type=category category_id="`$category.id`" category_name="`$category.name`"}">{$category.name}</a>&nbsp;({$category.total_articles})
			<br />
			<span class="lore_small_font">{$category.description}</span>
		</td>
		</tr>
		</table>
	</td>

	{if $smarty.foreach.category_loop.iteration is div by 3}
		</tr>
		<tr>
	{/if}
{/foreach}
</tr></table>