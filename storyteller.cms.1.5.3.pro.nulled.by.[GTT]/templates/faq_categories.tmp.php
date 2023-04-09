<?php
global $insert;
$EST_TEMPLATE = <<<TEMPLATE

<!-- Template faq_categories -->
<li><a href="faq.php?id=$insert[faq_category_id]">$insert[faq_category_name]</a> ($insert[faq_faqs])<br />

TEMPLATE;
?>