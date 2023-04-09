<?php
global $insert;
$EST_TEMPLATE = <<<TEMPLATE

<!-- Template ticket_list -->
<li><a href="ticket.php?tracking=$insert[ticket_pass]">$insert[ticket_title]</a> ($insert[ticket_priority])<br />

TEMPLATE;
?>