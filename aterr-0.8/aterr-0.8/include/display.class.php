<?php

/*
	aterr - a threaded forum system.

	Copyright (c) 2005 Chris Jenkinson <chris@starglade.org>.
	All rights reserved.

	aterr is licensed under the GNU General Public License.
	<http://opensource.org/licenses/gpl-license.php>
*/

class display
{
	var $in_admin = false;
	var $status_num = 200;

	function display()
	{
		ob_start();
	}

	function header_nooutput()
	{
		global $config;

		/* some browsers cache .html files */
		header('Cache-Control: no-cache');

		if ($this->status_num == 200)
		{
			/* mod redirect seems to change the status header */
			header('HTTP/1.1 200 OK');
		}

		?>
<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.1//EN\" \"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd\">
<html>
	<head>
		<title><?php echo $config['site_name']; ?> - {PAGE_TITLE}</title>
		<link rel="stylesheet" type="text/css" href="http://<?php echo $config['domain_name'] . $config['install_path']; ?>style.css" />{HEAD}
	</head>
	<body>
<?php
	}

	function header()
	{
		global $config, $session, $messages, $db, $time_start;

		$time_start = microtime_float();

		$this->header_nooutput();

		echo '<div id="logo"><a href="http://' . $config['domain_name'] . $config['install_path'] . '"><img src="http://' . $config['domain_name'] . $config['install_path'] . $config['site_img'] . '" alt="' . $config['site_name'] . '" /></a></div>';

		echo '<div id="title"><h1>' . $config['site_name'] . ' Forums</h1><h2>' . $config['site_desc'] . '</h2></div>';

		if (!$session->logged_in)
		{
			echo '<div id="box-signin">';

			$from = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

			echo '<form action="' . $config['install_path'] . accounts::aurl('signin', urlencode($from)) . '" method="post">';
			echo '<h2>sign in</h2><p style="margin: 0 0 4px 0;">username: <input type="text" name="username" value="' . (isset($_POST['username']) ? $_POST['username'] : '') . '" style="width:100px" /><br />password: <input type="password" name="password" style="width:100px" /><input type="hidden" name="signin" value="true" /><br /><a href="' . $config['install_path'] . accounts::aurl('register') . '">register</a> <input type="submit" class="submit" value=" go " /></p></form></div>';
		}
		else
		{
			echo '<div id="box-signin">';

			$bookmarks = forums::select_bookmarks();

			$num_new = 0;

			foreach ($bookmarks as $bookmark)
			{
				$replies = $bookmark['replies'];

				$new_replies = 0;
				$new = '';

				if ($config['track_read'] == 'database')
				{
					if (!empty($bookmark['reply_ids']))
					{
						$reply_ids = explode(',', $bookmark['reply_ids']);
					}
					else
					{
						$reply_ids = array();
					}

					$reply_ids = array_merge(array($bookmark['d_id']), $reply_ids);

					$sql = 'SELECT COUNT(*) as count
						FROM post_read r
						WHERE r.d_id IN (%s)
						AND r.u_id = %d';

					$sql = sprintf($sql, implode(', ', $reply_ids), $session->user_id);

					$db->sql_query($sql);
					$db->sql_data($nr, true);

					if ($nr['count'] < $replies+1)
					{
						$new_replies = ($replies+1 - $nr['count']);
					}

					$num_new += $new_replies;
				}
			}

			$bookmark_count = count($bookmarks);

			echo '<h2>your account</h2><ul>';

			echo '<li>signed in as <a href="' . $config['install_path'] . accounts::aurl('viewprofile', $session->user_id) . '">' . $session->userdata['username'] . '</a></li><li>';

			if ($num_new == 0)
			{
				echo 'no new posts';
			}
			else
			{
				echo '<b>' . $num_new . ' new post' . ($num_new == 1 ? '' : 's') . '</b>';
			}

			echo ' in your ' . $bookmark_count . ' <a href="' . $config['install_path'] . forums::furl('bookmarks') . '">bookmarked thread' . ($bookmark_count == 1 ? '' : 's') . '</a></li>';

			echo '<li><a href="' . $config['install_path'] . accounts::aurl() . '">manage account</a></li>';
			echo '<li><a href="' . $config['install_path'] . accounts::aurl('signout',  $_SERVER['HTTP_HOST'] . urlencode($_SERVER['REQUEST_URI'])) . '">sign out</a></li>';

			echo '</ul></div>';
		}

		echo '<form action="' . $config['install_path'] . 'search.php" method="get">';

		echo '<div id="box-search"><h2>search</h2><p style="margin: 0 0 4px 0;">';
		echo '<input type="text" style="width: 100px;" name="q" /><br />';
		echo '<input type="submit" class="submit" value="search" />';
		echo '</p></div>';

		echo '</form>';

		$sql = 'SELECT COUNT(*) AS count
			FROM posts p';

		$db->sql_query($sql);
		$db->sql_data($num_posts, true);

		$sql = 'SELECT COUNT(*) AS count
			FROM posts p
			WHERE p.parent_id = 0';

		$db->sql_query($sql);
		$db->sql_data($num_threads, true);

		$sql = 'SELECT p.*, d.*, c.title AS forum_title
			FROM posts p, data d, categories c
			WHERE p.d_id = d.id
			AND c.id = p.forum
			AND p.forum IN (%s)
			ORDER BY d.date DESC
			LIMIT 5';

		$sql = sprintf($sql, $config['stats_forums']);

		$db->sql_query($sql);
		$db->sql_data($latest_posts);

		$sql = 'SELECT DISTINCT u.*, s.*
			FROM users u, sessions s
			WHERE s.u_id = u.user_id
			AND s.time_last > ' . (time()-300) . '
			ORDER BY s.time_last DESC';

		$db->sql_query($sql);
		$db->sql_data($whos_online);

		if ($config['guest_sessions'])
		{
			$sql = 'SELECT s.*
				FROM sessions s
				WHERE s.u_id = 0
				AND s.time_last > ' . (time()-300);

			$db->sql_query($sql);
			$db->sql_data($guests_online);
		}

		$sql = 'SELECT COUNT(*) AS count
			FROM users
			WHERE user_active = 1';

		$db->sql_query($sql);
		$db->sql_data($reg_user_count, true);

		echo '<div id="box-stats"><h2>statistics</h2><p style="margin: 0 0 4px 0;">';
		printf('%d %s in %d %s<br />%d registered users', $num_posts['count'], ($num_posts['count'] == 1 ? 'post' : 'posts'), $num_threads['count'], ($num_threads['count'] == 1 ? 'thread' : 'threads'), $reg_user_count['count']);
		echo '</p>';

		if (!empty($latest_posts))
		{
			$latest_posts = htmlspecialchars_array($latest_posts);

			echo '<ul>';
			foreach ($latest_posts as $post)
			{
				printf('<li><a href="%s">%s</a> (<a href="%s">%s</a>)</li>',
					$config['install_path'] . forums::furl('view', $post['fp_id']) . '#post' . $post['d_id'],
					$post['title'],
					$config['install_path'] . forums::furl('viewforum', $post['forum']),
					$post['forum_title']
				);
			}
			echo '</ul>';
		}

		echo '<p style="margin: 0 0 4px 0;">';

		printf('%d registered user%s', count($whos_online), (count($whos_online) == 1 ? '' : 's'));

		if ($config['guest_sessions'])
		{
			printf(', %d guest%s', count($guests_online), (count($guests_online) == 1 ? '' : 's'));
		}

		echo ' online</p>';

		if (count($whos_online))
		{
			echo '<ul>';
			$i = 0;

			foreach ($whos_online as $reg_user)
			{
				if ($i > 5)
				{
					break;
				}

				$i++;
				printf('<li><a href="%s">%s</a></li>', $config['install_path'] . accounts::aurl('viewprofile', $reg_user['user_id']), $reg_user['username']);
			}
			echo '</ul>';
		}

		echo '</div>';

		echo '<div id="main">{PAGE_LOCATION}{PAGE_TITLE_2}';
	}

	function footer()
	{
		global $session, $config, $time_start, $db;

		$time_end = microtime_float();

		$queries = count($db->queries_array);

		echo '<p class="copyright">Powered by <a href="http://chimaera.starglade.org/aterr/">aterr</a>. <a href="http://chimaera.starglade.org/copyright.html">Copyright</a> &copy; the <a href="http://chimaera.starglade.org/">Chimaera Project</a>, 2004-5.<br />';
		echo 'Generating this page used ' . $queries . ' database queries and took ' . round($time_end - $time_start, 4) . ' seconds.</p></div>';
	}

	function output($time_taken = true)
	{
		global $location, $title, $head;

		$title2 = '';

		if (!empty($location) && is_array($location))
		{
			foreach ($location as $key => $value)
			{
				$location[$key] = $value;
			}

			$location = '<p class="location">' . implode(' <strong>&raquo;</strong> ', $location);
			$location .= ' <strong>&raquo;</strong> ' . cleanup_text($title) . '</p>';

			$title2 = '<h1>' . cleanup_text($title) . '</h1>';
		}
		else
		{
			$location = '';
		}

		if (!empty($head))
		{
			$head = "\n\t\t" . implode("\n\t\t", $head);
		}

		$page = ob_get_contents();

		$page = str_replace('{PAGE_LOCATION}', $location, $page);
		$page = str_replace('{PAGE_TITLE}', cleanup_text($title), $page);
		$page = str_replace('{PAGE_TITLE_2}', $title2, $page);
		$page = str_replace('{HEAD}', $head, $page);

		ob_end_clean();

		header('Content-type: text/html');

		echo $page;

		?>

	</body>
</html>
<?php
	}
}

?>
