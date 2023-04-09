<?php
global $insert;
$EST_TEMPLATE = <<<TEMPLATE
$insert[email_subject]\nby $insert[email_author]\n\n$insert[email_message]\n\nURL #1: $insert[email_url1]\nURL #2: $insert[email_url2]\nURL #3: $insert[email_url3]\nURL #4: $insert[email_url4]\nURL #5: $insert[email_url5]\nURL #6: $insert[email_url6]\nURL #7: $insert[email_url7]\nURL #8: $insert[email_url8]\n
TEMPLATE;
?>