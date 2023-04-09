<?
// ------------------------------------------------------------------
// generator.php
// ------------------------------------------------------------------
require('./includes/common/shared.inc.php');
require('./includes/common/project.inc.php');
require('./includes/common/generator.inc.php');
require('./includes/common/fakezilla.inc.php');

// template system
$html = new Template(get_Setting('TEMPLATES_DIR'),
	get_Setting('TEMPLATE_LOG'),
	'__admin_default_messages_and_template__.htmlt');

$html->define('generator', 'generator.htmlt');
$html->extract('generator');

Generate();
?>