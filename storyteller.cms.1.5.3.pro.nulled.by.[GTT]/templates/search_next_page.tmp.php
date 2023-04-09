<?php
global $insert;
$EST_TEMPLATE = <<<TEMPLATE

<!-- Template search_next_page -->
<br />
<a href="search.php?for=$insert[search_query]&cat=$insert[search_where]&start=$insert[search_start]">Next matches >>></a>
<br />

TEMPLATE;
?>