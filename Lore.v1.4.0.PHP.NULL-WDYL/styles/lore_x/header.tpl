{*
+----------------------------------------------------------------------
| Template: header.tpl
| 
| This template is displayed at the top of every regular page in
| the knowledge base. It contains the search box, category drop-down
| menu, category tree, and other header elements.
+----------------------------------------------------------------------
*}
{include file="html_header.tpl"}

<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr><td width="100%">

<div class="lore_top">
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr>
<td class="lore_splash_header" width="60%" align="left" valign="bottom">
	{$lore_system.settings.knowledge_base_name}
</td>
<td class="lore_top_buttons" width="40%" align="right" valign="bottom">

	{if $lore_system.settings.enable_glossary}
		<a class="lore_light_link" href="{$lore_system.base_dir}/{$lore_system.scripts.index}?action=glossary"><img src="{$lore_system.base_dir}/{$image_dir}/glossary.gif" alt="" border="0" align="middle" /> Glossary</a>
	{/if}

	&nbsp;&nbsp;

	{if $lore_system.settings.show_contact_link }
		<a class="lore_light_link" href="{$lore_system.base_dir}/{$lore_system.scripts.contact}"><img src="{$lore_system.base_dir}/{$image_dir}/contact.gif" alt="" border="0" align="middle" /> Contact Us</a>
	{/if}
</td>
</tr>
</table>
</div>

<div class="lore_option_tab">
	<form method="get" action="{$lore_system.base_dir}/{$lore_system.scripts.search}">
		Search <input class="lore_input" type="text" name="query" maxlength="100" size="30" />&nbsp;<input type="submit" name="submit" value="Go" class="lore_button" />
	</form>

	{if count($category_tree) }
		&nbsp;&nbsp;&nbsp;
	
		<form method="get" action="{$lore_system.base_dir}/{$lore_system.scripts.category}" onsubmit="{literal}if(document.category_jump.id.value == -1){return false;}{/literal}" name="category_jump">
			Browse by Category
	
			<select class="lore_input" name="id" onchange="{literal}if(this.options[this.selectedIndex].value != -1){ document.category_jump.submit() }{/literal}">
		
			<option selected="selected" value="-1"></option>
			{include file="category_select.tpl" category_tree=$category_tree depth=1}
			</select>
			<input type="submit" value="Go" class="lore_button" />
		</form>
	{/if}
</div>

<table width="100%" cellspacing="0" cellpadding="0" border="0">
<tr>
	<td class="lore_left_panel" width="180" valign="top">
		<div class="lore_category_tree_base"><a href="{$lore_system.base_dir}/">{$lore_system.settings.knowledge_base_name}</a></div>
		{include file="category_tree.tpl" category_tree=$category_tree depth=1}
	</td>
	<td valign="top">
		<table width="100%">
		<tr>
		<td class="lore_breadcrumb" width="100%">
			<a href="{$lore_system.base_dir}/" class="lore_small_link">{$lore_system.settings.knowledge_base_name}</a>
			{foreach item="category" from=$category_path}
				{if $category.id != 0}
					.: <a href="{$lore_system.base_dir}/{lore_link type=category category_id="`$category.id`" category_name="`$category.name`"}" class="lore_small_link">{$category.name}</a>
				{/if}
			{/foreach}
			{if $article && $action}
				.: <a class="lore_small_link" href="{lore_link type="article" article_id="`$article.id`" category_id="`$article.category_id`" category_name="`$article.category_name`"}">{$article.title}</a>
			{elseif $article}
				.: <span class="lore_breadcrumb_current">{$article.title}</span>
			{/if}
			{if $action}
				.: <span class="lore_breadcrumb_current">{$action}</span>
			{/if}

		</td>
		</tr>
		<tr>
		<td class="lore_content" width="*">
