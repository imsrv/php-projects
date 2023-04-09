<?php

/*
	aterr - a threaded forum system.

	Copyright (c) 2005 Chris Jenkinson <chris@starglade.org>.
	All rights reserved.

	aterr is licensed under the GNU General Public License.
	<http://opensource.org/licenses/gpl-license.php>
*/

define('INCLUDE_PATH', 'include/');
include INCLUDE_PATH . 'common.inc.php';

$forums = new forums(false);

$op = (!empty($_GET['op']) ? $_GET['op'] : '');
$sub = (!empty($_GET['sub']) ? $_GET['sub'] : '');

$item = <<<ITEM

		<item>
		        <title><![CDATA[%s]]></title>
			<link>%s</link>
			<description><![CDATA[%s]]></description>
			<category>%s</category>
			<pubDate>%s</pubDate>
			<guid isPermaLink="true">%s</guid>
			<dc:creator>%s</dc:creator>
		</item>

ITEM;

if ($forums->f_id)
{
	$f_array = array($forums->f_id);
}
else
{
	$f_array = explode(', ', $config['stats_forums']);
}

foreach ($f_array as $key => $f_id)
{
	$flags = permission::get_default_flags('forums', $f_id);

	if (!$flags & (F_FORUM_VIEW | F_POST_READ))
	{
		unset($f_array[$key]);
	}
}

if (empty($f_array))
{
	header('HTTP/1.1 404 Not Found');
	die();
}

$sql = 'SELECT f.*, c.*
	FROM forums f, categories c
	WHERE c.id = f.id
	AND f.id IN (%s)';

$sql = sprintf($sql, implode(', ', $f_array));

$db->sql_query($sql);
$db->sql_data($f_data);

if (false !== ($posts = $forums->select_forum_posts($f_array, 'd.date DESC', 15)))
{
	header('Content-type: text/xml');
?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">
	<channel>
		<title><?php echo $config['site_name']; ?></title>
		<link><?php echo 'http://' . $config['domain_name'] . $config['install_path'] . forums::furl(); ?></link>
		<description><![CDATA[<?php echo $config['site_desc']; ?>]]></description>
		<webMaster><?php echo $config['contact_email'] . ' (' . $config['contact_name'] . ')'; ?></webMaster>
		<managingEditor><?php echo $config['contact_email'] . ' (' . $config['contact_name'] . ')'; ?></managingEditor>
		<generator>aterr (http://chimaera.starglade.org/aterr/)</generator>
<?php
	foreach ($f_data as $forum)
	{
		printf("\t\t<category>%s</category>\n", $forum['title']);
	}

	foreach ($posts as $post)
	{
		if ($post['is_unapproved'])
		{
			continue;
		}

		printf($item,
			$post['title'],
			'http://' . $config['domain_name'] . $config['install_path'] . forums::furl('view', $post['fp_id']) . '#' . $post['d_id'],
			format_text($post['text']),
			$post['forum_title'],
			date('r', $post['date']),
			'http://' . $config['domain_name'] . $config['install_path'] . forums::furl('view', $post['fp_id']) . '#' . $post['d_id'],
			$post['username']
		);
	}
		?>

	</channel>
</rss>
<?php
}

?>
