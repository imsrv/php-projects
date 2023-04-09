{*
+----------------------------------------------------------------------
| Template: footer.tpl
| 
| This template is displayed at the bottom of every regular page
| in your knowledge base.
+----------------------------------------------------------------------
*}
 	</td>
	</tr>
	</table>
</td>
</tr>
</table>

<br /><br />
<div style="text-align: right; font-size: 10px;color:#999999;margin-right:25px;">
	<br />

	{if $lore_user_session.is_validated}
		Logged in as: <strong>{$lore_user_session.username}</strong>
		<br />
		[ <a class="lore_small_link" href="{$lore_system.base_dir}/cp/" target="_blank">Control Panel</a> ]
		<br />
		[ <a class="lore_small_link" href="{$lore_system.base_dir}/cp/?action=logout">Logout</a> ]
	{elseif $lore_system.settings.show_admin_login_link }
		[ <a class="lore_small_link" href="{$lore_system.base_dir}/cp/" target="_blank">Admin Login</a> ]
	{/if}
</div>

{if $lore_system.settings.copyright_notice }
	<div style="margin-top: 10px; text-align: center;">
		{$lore_system.settings.copyright_notice}
	</div>
{/if}

</td></tr></table>

{include file="html_footer.tpl"}