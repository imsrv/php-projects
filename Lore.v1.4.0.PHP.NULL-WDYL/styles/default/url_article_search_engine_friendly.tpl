idx/{$category_id|default:0}/{$article_id}/{if $lore_system.settings.enable_category_name_in_article_urls && $category_name }{$category_name|alphanumeric}/{/if}article/{if $lore_system.settings.enable_article_title_urls}{$article_title|alphanumeric}.html{/if}