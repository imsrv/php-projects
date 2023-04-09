<?php
global $insert;
$EST_TEMPLATE = <<<TEMPLATE

<!-- Template plan_list -->
<li><a href="plan.php?id=$insert[user_id]">$insert[user_name]</a> ($insert[user_plans])<br />

TEMPLATE;
?>