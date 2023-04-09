{*
+----------------------------------------------------------------------
| Template: message_redirect.tpl
| 
| This template is used to display a short message, and automatically
| redirect the user back to the specified page. For example, it is 
| used to display "Your comment has been posted" when a user posts a 
| comment on an article.
+----------------------------------------------------------------------
*}
<html>
<head>
	<title>{$lore_system.settings.knowledge_base_name}</title>
	<link rel="stylesheet" type="text/css" href="{$lore_system.base_dir}/{$style_dir}/stylesheets/{$stylesheet}" />
	<meta http-equiv="refresh" content="2;URL={$redirect_url}">
</head>

<body>
<br /><br /><br /><br /><br /><br /><br />
<div class="lore_message">
	{include file="msg_`$message`.tpl"}
	<br /><br />
	<a class="lore_normal_link" href="{$lore_system.base_dir}/{$redirect_url}">(Click here to proceed)</a>
</div>

</body>
</html>
