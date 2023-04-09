<rdf:RDF
  xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
  xmlns="http://purl.org/rss/1.0/"
  xmlns:dc="http://purl.org/dc/elements/1.1/"
>
  <channel rdf:about="{$lore_system.settings.knowledge_base_domain}{$lore_system.settings.knowledge_base_path}">
    <title>{$lore_system.settings.knowledge_base_name}</title>
    <link>{$lore_system.settings.knowledge_base_domain}{$lore_system.settings.knowledge_base_path}</link>
    <description>{$lore_system.settings.knowledge_base_description|strip_tags:false|strip}</description>
    <language>en-us</language>
    <items>
      <rdf:Seq>
{foreach item=article from=$articles}
        <rdf:li rdf:resource="{$lore_system.settings.knowledge_base_domain}{$lore_system.settings.knowledge_base_path}/{lore_link type=article category_id="`$article.category_id`" category_name="`$article.category_name`" article_title="`$article.title`" article_id="`$article.id`"}"/>
{/foreach}
      </rdf:Seq>
    </items>
  </channel>
{foreach item=article from=$articles}
    <item rdf:about="{$lore_system.settings.knowledge_base_domain}{$lore_system.settings.knowledge_base_path}/{lore_link type=article category_id="`$article.category_id`" category_name="`$article.category_name`" article_title="`$article.title`" article_id="`$article.id`"}">
      <title>{$article.title|strip_tags:false}</title>
      <link>{$lore_system.settings.knowledge_base_domain}{$lore_system.settings.knowledge_base_path}/{lore_link type=article category_id="`$article.category_id`" category_name="`$article.category_name`" article_title="`$article.title`" article_id="`$article.id`"}</link>
      <description>{$article.preview|strip_tags:false|strip|truncate:"`$lore_system.settings.article_short_preview_length`":"..."}</description>
      <dc:creator>{$article.username}</dc:creator>
      <dc:date>{$article.created_time|format_date:"`$lore_system.settings.date_format`"}</dc:date>
    </item>
{/foreach}
</rdf:RDF>