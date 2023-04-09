{*
+----------------------------------------------------------------------
| Template: email_article_body.tpl
| 
| This template is used to generate the body of the email message
| sent through the "Email Article" feature.
+----------------------------------------------------------------------
*}
Sent by: {$from_name} <{$from_email}>
--------------------------------------------------
{$comment}
--------------------------------------------------

{$article.title}
{$lore_system.settings.knowledge_base_domain}{$lore_system.settings.knowledge_base_path}/{lore_link type=article category_id="`$article.category_id`" category_name="`$article.category_name`" article_title="`$article.title`" article_id="`$article.id`"}

--------------------------------------------------
{$lore_system.knowledge_base_name}
{$lore_system.knowledge_base_domain}{$lore_system.knowledge_base_path}
