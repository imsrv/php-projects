{*
+----------------------------------------------------------------------
| Template: error_message.tpl
| 
| This template is used to display a regular knowledge base error
| message (not a fatal error). It includes the specified error
| message template (templates that start with "err_")
+----------------------------------------------------------------------
*}
{include file="header.tpl"}

<div class="lore_error_message">
	<h3>
		{$lore_system.settings.knowledge_base_name} Error
	</h3>
	{include file="err_`$error_message`.tpl"}
	<br /><br />
	<a class="lore_normal_link" href="javascript:history.go(-1);">&lt;&lt; Back</a>
</div>
{include file="footer.tpl"}