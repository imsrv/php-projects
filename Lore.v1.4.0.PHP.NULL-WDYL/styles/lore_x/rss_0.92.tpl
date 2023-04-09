<rss version="0.92">
  <channel>
    <title>{$lore_system.settings.knowledge_base_name}</title>
    <link>{$lore_system.settings.knowledge_base_domain}{$lore_system.settings.knowledge_base_path}</link>
    <description>{$lore_system.settings.knowledge_base_description|strip_tags:false}</description>
    <language>en-us</language>
    <copyright>{$lore_system.settings.copyright_notice|strip_tags:false|strip}</copyright>
{foreach item=article from=$articles}
    <item>
      <title>{$article.title|strip_tags:false}</title>
      <link>{$lore_system.settings.knowledge_base_domain}{$lore_system.settings.knowledge_base_path}/{lore_link type=article category_id="`$article.category_id`" category_name="`$article.category_name`" article_title="`$article.title`" article_id="`$article.id`"}</link>
      <description>{$article.preview|strip_tags:false|strip|truncate:"`$lore_system.settings.article_short_preview_length`":"..."}</description>
    </item>
{/foreach}
  </channel>
</rss>