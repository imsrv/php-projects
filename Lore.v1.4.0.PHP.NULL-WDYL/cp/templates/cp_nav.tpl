{include file="cp_html_header.tpl"}

<center>
<br />
<img src="templates/images/lore.gif"><br />
	<b>Control Panel</b><br />
	<small>Logged in: <b>{$lore_user_session.username}</b><br />
	<a href="{$lore_system.scripts.cp_index}?action=logout" target="_top">logout</a>
</center>

<br />

{foreach name="cp_module_group_loop" item="module_group" from=$module_groups}
	<div class="module_group_header">
		<div class="module_group_header_caption" style="width: 90px">
			{$module_group.name}
		</div>
	</div>

	<div class="modules">
		{foreach name="cp_module_loop" key="module_name" item="module_link" from=$module_group.modules}
			» <a href="{$module_link}" target="main">{$module_name}</a>
			<br />
		{/foreach}
	</div>
{/foreach}

{include file="cp_html_footer.tpl"}