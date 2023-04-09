<?php
global $insert;
$EST_TEMPLATE = <<<TEMPLATE

<!-- Template search_list_news -->
<li><a href="story.php?id=$insert[story_id]">$insert[story_title]</a> ($insert[story_time])<br />

TEMPLATE;
?>