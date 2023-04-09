<?php
global $insert;
$EST_TEMPLATE = <<<TEMPLATE

		<item>
			<title>$insert[story_title]</title>
			<link>$insert[story_link]</link>
			<description>$insert[story_text]</description>
		</item>

TEMPLATE;
?>