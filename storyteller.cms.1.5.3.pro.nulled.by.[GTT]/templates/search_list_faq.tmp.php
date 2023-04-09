<?php
global $insert;
$EST_TEMPLATE = <<<TEMPLATE

<!-- Template search_list_faq -->
<li><a href="faqshow.php?id=$insert[faq_id]">$insert[faq_question]</a><br />

TEMPLATE;
?>