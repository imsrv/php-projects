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

echo $display->header();

if (!empty($_GET['q']))
{
	$q = $_GET['q'];

	$f = 0;
	$f_str = $f_sql = '';

	if (!empty($_GET['f']))
	{
		$f = $_GET['f'];

		$flags = permission::get_flags('forums', $f);

		if ($flags & (F_FORUM_VIEW | F_POST_READ))
		{
			$f_data = forums::forum_get_data($f);
			$f_str = sprintf(', in forum <a href="%s">%s</a>', $config['install_path'] . forums::furl('viewforum', $f), $f_data['title']);
			$f_sql = sprintf(' AND p.forum = %d', $f);
		}
		else
		{
			$f = 0;
		}
	}

	$title = 'Search Results';
	$location = array(
		'<a href="' . $config['install_path'] . '">' . $config['site_name'] . '</a>',
		'<a href="' . $config['install_path'] . 'search.php">Search</a>'
	);

	printf('<p>Searched for "<em>%s</em>"%s.</p>', htmlspecialchars($q), $f_str);

	$sql = 'SELECT d.*, p.*
		FROM data d, posts p
		WHERE d.id = p.d_id
		AND MATCH (title, `text`) AGAINST ("%s")
		%s';

	$sql = sprintf($sql, $q, $f_sql);

	$db->sql_query($sql);
	$db->sql_data($data);

	if (!empty($data))
	{
		echo '<p>Results are ordered by relevance.</p>';
		echo '<ul>';

		foreach ($data as $post)
		{
			printf('<li><a href="%s#%s">%s</a></li>%s', $config['install_path'] . forums::furl('view', $post['fp_id']), $post['id'], cleanup_text($post['title']), "\n");
		}

		echo '</ul>';
	}
}
else
{
	$location = array(
		'<a href="' . $config['install_path'] . '">' . $config['site_name'] . '</a>'
	);

	$f = 0;

	if (!empty($_GET['f']))
	{
		$f = $_GET['f'];

		$flags = permission::get_flags('forums', $f);

		if ($flags & (F_FORUM_VIEW | F_POST_READ))
		{
			$f_data = forums::forum_get_data($f);

			$location[] = '<a href="' . $config['install_path'] . 'search.php">Search</a>';

			$title = 'Search Forum: ' . $f_data['title'];
		}
		else
		{
			redirect('http://' . $config['domain_name'] . $config['install_path'] . 'search.php');
		}
	}
	else
	{
		$title = 'Search';
	}

?>
<form method="get" action="<?php echo $config['install_path'] . 'search.php'; ?>">
	<table class="forum">
		<tr><td><input type="text" name="q" /> <input type="submit" value="Search" /></td></tr>
	</table>
	<?php echo ($f ? '<input type="hidden" name="f" value="' . $f . '" />' : ''); ?>
</form>
<?php
}

echo $display->footer();
$display->output();

?>
