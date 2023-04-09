<?php

/*
	aterr - a threaded forum system.

	Copyright (c) 2005 Chris Jenkinson <chris@starglade.org>.
	All rights reserved.

	aterr is licensed under the GNU General Public License.
	<http://opensource.org/licenses/gpl-license.php>
*/

define('F_POST_READ',		0x00000001);
define('F_POST_NEW',		0x00000002);
define('F_POST_EDIT',		0x00000004);
define('F_POST_DELETE',		0x00000008);
define('F_POST_REPLY',		0x00000010);

define('F_FORUM_VIEW',		0x00000020);
define('F_FORUM_CREATE',	0x00000040);
define('F_FORUM_EDIT',		0x00000080);
define('F_FORUM_DELETE',	0x00000100);

define('F_POST_EDITALL',	0x00000200);
define('F_POST_DELETEALL',	0x00000400);

define('F_FORUM_MOD',		0x00000800);

define('F_POST_APPROVE',	0x00001000); /* user permission to approve posts */
define('F_FORUM_APPROVAL',	0x00002000); /* forum permission, all posts will be unapproved by default */

define('F_GLOBAL_CONFIG',	0x00004000);

define('F_POST_REPORT',		0x00008000);

class forums extends data
{
	var $f_id;
	var $p_id;

	var $f_data;

	var $redirect;

	function forums($redirect = true)
	{
		$this->f_id = 0;
		$this->p_id = 0;

		$this->redirect = $redirect;

		$this->data();

		$this->parse_qs();
	}

	function select_forum_posts($f_id, $order_sql = 'p.is_sticky DESC, p.last_reply DESC', $limit = 0)
	{
		global $db;

		if (is_array($f_id))
		{
			$f_id = implode(',', $f_id);
		}

		$limit_sql = '';

		if ($limit)
		{
			$limit_sql = 'LIMIT ' . $limit;
		}

		$sql = 'SELECT p.*, d.*, u.username, c.title as forum_title
			FROM posts p, data d, users u, categories c
			WHERE p.d_id = d.id
			AND p.forum IN (%s)
			AND p.parent_id = 0
			AND u.user_id = d.u_id
			AND p.forum = c.id
			ORDER BY %s
			%s';

		$sql = sprintf($sql, $f_id, $order_sql, $limit_sql);

		$db->sql_query($sql);
		$db->sql_data($data);

		if (empty($data))
		{
			return false;
		}

		return $data;
	}

	function select_posts($parent = 0)
	{
		global $db, $session;

		$sql = 'SELECT p.*, d.*, u.username, u2.username as edited_username, pr.u_id as post_read
			FROM posts p, data d, users u
			LEFT JOIN users u2 ON p.edited_by = u2.user_id
			LEFT JOIN post_read pr ON p.d_id = pr.d_id
			AND (
				pr.u_id = NULL
				OR pr.u_id = %d
			)
			WHERE p.d_id = d.id
			AND d.u_id = u.user_id
			AND p.parent_id = %d
			ORDER BY d.date ASC';

		$sql = sprintf($sql, $session->user_id, $parent);

		$db->sql_query($sql);
		$db->sql_data($data);

		if (empty($data))
		{
			return false;
		}

		return $data;
	}

	function update_posts($post_id, $update_sql)
	{
		/* update $post_id, then update all child posts of $post_id */

		global $db;

		$total = 1;

		$sql = 'UPDATE posts
			SET %s
			WHERE d_id = %d';

		$sql = sprintf($sql, $update_sql, $post_id);

		$db->sql_query($sql);

		$sql = 'SELECT p.d_id
			FROM posts p
			WHERE p.parent_id = %d';

		$sql = sprintf($sql, $post_id);

		$db->sql_query($sql);
		$db->sql_data($data);

		if (!empty($data))
		{
			foreach ($data as $post)
			{
				$total += $this->update_posts($post['d_id'], $update_sql);
			}
		}

		return $total;
	}

	function count_replies($post_id)
	{
		global $db;

		$sql = 'SELECT p.replies
			FROM posts p
			WHERE p.d_id = %d';

		$sql = sprintf($sql, $post_id);

		$db->sql_query($sql);
		$db->sql_data($data, true);

		return $data['replies'];
	}

	function get_reply_ids($post_id)
	{
		global $db;

		$sql = 'SELECT p.d_id
			FROM posts p
			WHERE p.parent_id = %d
			AND p.is_unapproved = 0';

		$sql = sprintf($sql, $post_id);

		$db->sql_query($sql);
		$db->sql_data($data);

		$arr = array();

		if (!empty($data))
		{
			foreach ($data as $value)
			{
				$arr = array_merge($arr, forums::get_reply_ids($value['d_id']), array($value['d_id']));
			}
		}

		return $arr;
	}

	function display_sub_posts($parent, $fp, $level = 1, $flags = 0)
	{
		global $config, $session;

		if (false === ($posts = $this->select_posts($parent)))
		{
			return false;
		}

		foreach ($posts as $post)
		{
			if ($session->logged_in)
			{
				$read = ($post['post_read'] == null ? false : true);
			}
			else
			{
				$read = null;
			}

			echo $this->display_single_post(array(
			    'id' => $post['id'],
			    'title' => $post['title'],
			    'date' => $post['date'],
			    'u_id' => $post['u_id'],
			    'username' => $post['username'],
			    'signature' => $this->get_sig($post['u_id']),
			    'text' => $post['text'],
			    'replies' => $post['replies'],
			    'parent' => $post['parent_id'],
			    'first_post' => $fp,
			    'read' => $read,
			    'fromleft' => 30 * $level,
			    'format_type' => $post['format_type'],
			    'is_unapproved' => $post['is_unapproved'],
			    'is_reported' => $post['is_reported'],
			    'flags' => $flags,
			    'edited' => (!empty($post['edited_by']) ? array('uid' => $post['edited_by'], 'date' => $post['edited_time'], 'username' => $post['edited_username']) : false)
			));

			$this->display_sub_posts($post['id'], $fp, $level+1, $flags);
		}
	}

	function forum_get_parent($f_id)
	{
		global $db;

		$sql = 'SELECT f.parent_id
			FROM forums f
			WHERE f.id = %d';

		$sql = sprintf($sql, $f_id);

		$db->sql_query($sql);
		$db->sql_data($parent, true);

		if (empty($parent))
		{
			return false;
		}

		$parent_id = $parent['parent_id'];

		$sql = 'SELECT f.*, c.*
			FROM forums f, categories c
			WHERE f.id = c.id
			AND f.id = %d';

		$sql = sprintf($sql, $parent_id);

		$db->sql_query($sql);
		$db->sql_data($data, true);

		if (empty($data))
		{
			return false;
		}

		return $data;
	}

	function forum_get_data($f_id)
	{
		global $db;

		$sql = 'SELECT f.*, c.*
			FROM forums f, categories c
			WHERE f.id = c.id
			AND f.id = %d';

		$sql = sprintf($sql, $f_id);

		$db->sql_query($sql);
		$db->sql_data($data, true);

		if (empty($data))
		{
			return false;
		}

		return $data;
	}

	function post_get_data($p_id)
	{
		global $db, $session;

		$sql = 'SELECT p.*, d.*, u.username, u2.username as edited_username, pr.u_id as post_read
			FROM posts p, data d, users u
			LEFT JOIN users u2 ON p.edited_by = u2.user_id
			LEFT JOIN post_read pr ON p.d_id = pr.d_id
			AND (
				pr.u_id = NULL
				OR pr.u_id = %d
			)
			WHERE p.d_id = d.id
			AND d.u_id = u.user_id
			AND p.d_id = %d';

		$sql = sprintf($sql, $session->user_id, $p_id);

		$db->sql_query($sql);
		$db->sql_data($data, true);

		if (empty($data))
		{
			return false;
		}

		return $data;
	}

	function get_forum_list($parent = 0)
	{
		global $db, $session;

		$sql = 'SELECT f.*, c.*, p.default_flags, up.flags
			FROM forums f, categories c
			LEFT JOIN permissions p ON p.sub_id = f.id
			LEFT JOIN user_permission up ON (
				up.sub_id = p.sub_id
				AND (
					up.u_id = NULL
					OR up.u_id = %d
				)
			)
			WHERE f.id = c.id
			AND p.name = "forums"
			AND f.parent_id = %d
			ORDER BY f.position ASC';

		$sql = sprintf($sql, $session->user_id, $parent);

		$db->sql_query($sql);
		$db->sql_data($data);

		return $data;
	}

	function get_all_forum_children($parent = 0)
	{
		global $db;

		$sql = 'SELECT f.id
			FROM forums f
			WHERE f.parent_id = %d';

		$sql = sprintf($sql, $parent);

		$db->sql_query($sql);
		$db->sql_data($data);

		$arr = array();

		if (!empty($data))
		{
			foreach ($data as $forum)
			{
				$arr = array_merge($arr, forums::get_all_forum_children($forum['id']), array($forum['id']));
			}
		}

		return $arr;
	}

	function resync_forum_post_count($f_id)
	{
		global $db;

		$sql = 'SELECT f.*
			FROM forums f
			WHERE f.parent_id = %d';

		$sql = sprintf($sql, $f_id);

		$db->sql_query($sql);
		$db->sql_data($data);

		$posts = 0;

		foreach ($data as $forum)
		{
			$posts += $this->resync_forum_post_count($forum['id']);
		}

		$sql = 'SELECT count(*) as post_count
			FROM posts p
			WHERE p.forum = %d
			AND p.is_unapproved = 0';

		$sql = sprintf($sql, $f_id);

		$db->sql_query($sql);
		$db->sql_data($data, true);

		$posts += $data['post_count'];

		$sql = 'UPDATE forums
			SET posts = %d
			WHERE id = %d';

		$sql = sprintf($sql, $posts, $f_id);

		$db->sql_query($sql);

		return $posts;
	}

	function resync_post_reply_count($post_id)
	{
		global $db;

		$sql = 'SELECT p.*
			FROM posts p
			WHERE p.parent_id = %d
			AND p.is_unapproved = 0';

		$sql = sprintf($sql, $post_id);

		$db->sql_query($sql);
		$db->sql_data($data);

		$posts = 0;

		foreach ($data as $post)
		{
			$posts += $this->resync_post_reply_count($post['d_id']);
			$posts++;
		}

		$reply_ids = $this->get_reply_ids($post_id);

		$reply_ids = implode(',', $reply_ids);

		$sql = 'UPDATE posts
			SET replies = %d,
			reply_ids = "%s"
			WHERE d_id = %d';

		$sql = sprintf($sql, $posts, $reply_ids, $post_id);

		$db->sql_query($sql);

		return $posts;
	}

	function resync_post_count()
	{
		global $db;

		$sql = 'SELECT f.*
			FROM forums f
			WHERE f.parent_id = 0
			ORDER BY f.id';

		$db->sql_query($sql);
		$db->sql_data($data);

		foreach($data as $forum)
		{
			$this->resync_forum_post_count($forum['id']);
		}

		$sql = 'SELECT p.*
			FROM posts p
			WHERE p.parent_id = 0
			ORDER BY p.d_id';

		$db->sql_query($sql);
		$db->sql_data($data);

		foreach ($data as $post)
		{
			$this->resync_post_reply_count($post['d_id']);
		}
	}

	function update_post_replies($post_id, $time, $decrease = false)
	{
		global $db;

		$reply_ids = $this->get_reply_ids($post_id);

		$reply_ids = implode(',', $reply_ids);

		$sql = 'UPDATE posts SET
			reply_ids = "%s"
			WHERE d_id = %d';

		$sql = sprintf($sql, $reply_ids, $post_id);

		$db->sql_query($sql);

		$p = $post_id;

		$symbol = ($decrease ? '-' : '+');

		while (0 != ($p = $this->post_get_parent($p)))
		{
			$reply_ids = $this->get_reply_ids($p);

			$reply_ids = implode(',', $reply_ids);

			$sql = 'UPDATE posts SET
				reply_ids = "%s",
				last_reply = %d,
				replies = replies %s 1
				WHERE d_id = %d';

			$sql = sprintf($sql, $reply_ids, $time, $symbol, $p);

			$db->sql_query($sql);
		}
	}

	function update_forum_replies($forum_id, $decrease = false)
	{
		global $db;

		$f = $forum_id;

		$symbol = ($decrease ? '-' : '+');

		do
		{
			$sql = 'UPDATE forums SET
				posts = posts %s 1
				WHERE id = %d';

			$sql = sprintf($sql, $symbol, $f);

			$db->sql_query($sql);
		}
		while (0 != ($f = $this->forum_get_parent($f)));
	}

	function delete_post($post_id)
	{
		global $db;

		$sql = 'SELECT p.d_id
			FROM posts p
			WHERE p.parent_id = %d';

		$sql = sprintf($sql, $post_id);

		$db->sql_query($sql);
		$db->sql_data($data);

		if (!empty($data))
		{
			foreach ($data as $child_post)
			{
				$this->delete_post($child_post['d_id']);
			}
		}

		$sql = 'SELECT p.parent_id, p.forum, p.is_unapproved
			FROM posts p
			WHERE p.d_id = %d';

		$sql = sprintf($sql, $post_id);

		$db->sql_query($sql);
		$db->sql_data($data, true);

		$parent_id = $data['parent_id'];
		$forum = $data['forum'];

		$p = $post_id;

		while (0 != ($p = $this->post_get_parent($p)))
		{
			$reply_ids = $this->get_reply_ids($p);

			$reply_ids = array_diff($reply_ids, array($post_id));

			$reply_ids = implode(',', $reply_ids);

			$sql = 'UPDATE posts
				SET replies = replies - 1,
				reply_ids = "%s"
				WHERE d_id = %d';

			$sql = sprintf($sql, $reply_ids, $p);

			$db->sql_query($sql);
		}

		$f = $forum;

		do
		{
			$sql = 'UPDATE forums
				SET posts = posts - 1
				WHERE id = %d';

			$sql = sprintf($sql, $f);

			$db->sql_query($sql);
		}
		while (0 != ($f = $this->forum_get_parent($f)));

		$sql = 'DELETE FROM posts
			WHERE d_id = %d';

		$sql = sprintf($sql, $post_id);
		$db->sql_query($sql);

		$sql = 'DELETE FROM data
			WHERE id = %d';

		$sql = sprintf($sql, $post_id);
		$db->sql_query($sql);

		$sql = 'DELETE FROM post_read
			WHERE d_id = %d';

		$sql = sprintf($sql, $post_id);
		$db->sql_query($sql);

		$sql = 'DELETE FROM reports
			WHERE p_id = %d';

		$sql = sprintf($sql, $post_id);
		$db->sql_query($sql);
	}

	function forum_location(&$location)
	{
		global $config;

		$f_id = $this->f_id;

		$reverse_location = array();

		while (false !== ($parent = $this->forum_get_parent($f_id)))
		{
			$reverse_location[] = '<a href="' . $config['install_path'] . forums::furl('viewforum', $parent['id']) . '">' . $parent['title'] . '</a>';
			$f_id = $parent['id'];
		}

		$reverse_location = array_reverse($reverse_location);

		foreach ($reverse_location as $value)
		{
			$location[] = $value;
		}
	}

	function display_single_post($data = array())
	{
		/* required fields in $data: title, u_id, username, date, format_type, text */

		global $config, $session, $count_unapproved;

		$str = <<<TEMPLATE

<div class="post[[IS_APPROVED]][[IS_READ]][[REPORTED]]" style="position: relative; left: [[FROMLEFT]]px; margin-right: [[FROMLEFT]]px;">
	<div class="head">
		<h2>[[TITLE]]</h2>
		<p class="info">[[REPORTED_TEXT]][[UNAPPROVED_TEXT]]posted by <a href="[[L_PROFILE]]">[[USERNAME]]</a> on [[DATE]][[EDITED]].</p>
	</div>
	<div class="body">
		[[TEXT]][[SIGNATURE]][[OPTIONS]][[APPROVE]]
	</div>
</div>

TEMPLATE;

		$options = $approve = '';
		$reported = false;

		if (!empty($data['id']) && empty($data['no_footer']))
		{
			$id = $data['id'];

			if ($data['flags'] & F_POST_APPROVE && !empty($data['is_unapproved']))
			{
				$count_unapproved++;

				$approve = '<p class="approve">';

				$approve .= sprintf('<input checked="checked" type="radio" name="approve[%d]" value="leave" id="a_l_%d"><label for="a_l_%d">Leave</label> ', $id, $id, $id);

				/*if ($data['flags'] & F_POST_DELETEALL)
				{
					$approve .= sprintf('<input type="radio" name="approve[%d]" value="delete" id="a_d_%d"><label for="a_d_%d">Delete</label> ', $id, $id, $id);
				}*/

				$approve .= sprintf('<input type="radio" name="approve[%d]" value="approve" id="a_a_%d"><label for="a_a_%d">Approve</label>', $id, $id, $id);

				$approve .= '</p>';
			}
			else if (!empty($data['is_unapproved']) && $session->user_id != $data['u_id'])
			{
				/*
					don't display anything if the post needs to be approved
					and the viewer doesn't have the appropriate permission.
				*/

				return;
			}

			if ($data['is_reported'] && (($data['flags'] & F_POST_EDITALL) || ($data['flags'] & F_POST_DELETEALL)))
			{
				$reported = true;
			}

			$opts = array();

			if ($data['parent'])
			{
				$opts[] = '<a href="' . $config['install_path'] . forums::furl('view', $data['first_post']) . '#post' . $data['parent'] . '">Parent</a>';
			}

			if ($data['flags'] & F_POST_REPLY && empty($data['is_unapproved']))
			{
				$opts[] = '<a href="' . $config['install_path'] . forums::furl('post', 'p', $id) . '">Reply To This</a>';
			}

			if (($data['flags'] & F_POST_EDIT && $data['u_id'] == $session->user_id && !$data['replies']) || ($data['flags'] & F_POST_EDITALL))
			{
				$opts[] = '<a href="' . $config['install_path'] . forums::furl('edit', $id) . '">Edit Post</a>';
			}

			if (($data['flags'] & F_POST_DELETE && $data['u_id'] == $session->user_id && !$data['replies']) || ($data['flags'] & F_POST_DELETEALL))
			{
				$opts[] = '<a href="' . $config['install_path'] . forums::furl('delete', $id) . '">Delete Post</a>';
			}

			if ($data['flags'] & F_FORUM_MOD)
			{
				$opts[] = '<a href="' . $config['install_path'] . forums::furl('move', $id) . '">Move/Merge Post</a>';
			}

			if ($data['flags'] & F_POST_REPORT && $session->logged_in)
			{
				$opts[] = '<a href="' . $config['install_path'] . forums::furl('report', $id) . '">Report Post</a>';
			}

			if (!empty($opts))
			{
				$options = '<p class="smaller footer">' . implode(' | ', $opts) . '</p>';
			}
		}

		$search = array('FROMLEFT', 'TITLE', 'L_PROFILE', 'USERNAME', 'DATE', 'EDITED', 'TEXT', 'SIGNATURE', 'OPTIONS', 'APPROVE', 'IS_APPROVED', 'UNAPPROVED_TEXT', 'IS_READ', 'REPORTED', 'REPORTED_TEXT');

		$replace = array(
			(!empty($data['fromleft']) ? $data['fromleft'] : 0),
			(!empty($data['id']) ? '<a id="post' . $data['id'] . '" href="' . $config['install_path'] . forums::furl('view', $data['first_post']) . '#post' . $data['id'] . '">' . $data['title'] . '</a>' : $data['title']),
			$config['install_path'] . accounts::aurl('viewprofile', $data['u_id']),
			$data['username'],
			date('D, F jS, H:i', $data['date']),
			(!empty($data['edited']) ? '; last edited by <a href="' . $config['install_path'] . accounts::aurl('viewprofile', $data['edited']['uid']) . '">' . $data['edited']['username'] . '</a> on ' . date('D, F jS, H:i', $data['edited']['date']) : ''),
			($data['format_type'] == 'text' ? format_text($data['text']) : unhtmlspecialchars($data['text'])),
			(!empty($data['signature']) ? '<div style="text-align: left; width: 30%;"><hr /></div><p class="signature">' . $data['signature'] . '</p>' : ''),
			$options,
			$approve,
			(!empty($data['is_unapproved']) ? ' unapproved' : ' approved'),
			(!empty($data['is_unapproved']) ? '<b>unapproved</b>; ' : ''),
			(isset($data['read']) ? ($data['read'] ? '' : ' unread') : ''),
			($reported ? ' reported' : ''),
			($reported ? '<b>reported</b> (<a href="' . $config['install_path'] . forums::furl('reports', $data['id']) . '">view reports</a>); ' : '')
		);

		foreach ($search as $key => $value)
		{
		    $search[$key] = '[[' . $value . ']]';
		}

		$str = str_replace($search, $replace, $str);

		return $str;
	}

	function display_forums($parent = 0)
	{
		global $config, $session, $db;

		$forums = $this->get_forum_list($parent);

		if (!count($forums))
		{
			return false;
		}

		$str = '<table class="forum" cellspacing="0" cellpadding="0" width="100%">';

		$str .= '<tr class="forum-top"><th>&nbsp;</th><th>Posts</th></tr>';

		$i = 0;

		foreach($forums as $forum)
		{
			$canview = false;

			if ($forum['flags'] == '')
			{
				if ($forum['default_flags'] & F_FORUM_VIEW)
				{
					$canview = true;
				}
			}
			else if ($forum['flags'] & F_FORUM_VIEW)
			{
				$canview = true;
			}

			if (!$canview)
			{
				continue;
			}

			$i++;

			$str .= '<tr><td class="' . ($i % 2 ? 'odd' : 'even') . '">';

			$children = $this->get_forum_list($forum['id']);

			$new = '';

			if ($session->logged_in && $config['track_read'] == 'database')
			{
				$children_ids = $this->get_all_forum_children($forum['id']);
				array_unshift($children_ids, $forum['id']);

				$sql = 'SELECT COUNT(*) as count
					FROM posts p
					LEFT JOIN post_read pr ON p.d_id = pr.d_id
					WHERE p.forum IN (%s)
					AND pr.u_id = %d';

				$sql = sprintf($sql, implode(', ', $children_ids), $session->user_id);

				$db->sql_query($sql);
				$db->sql_data($data, true);

				$new_posts = $forum['posts'] - $data['count'];

				if ($new_posts)
				{
					$new = '<span style="font-size: 90%";><br />(<b>' . $new_posts . ' new</b>)</span>';
				}
			}

			$str .= '<p class="forum-title"><a href="' . $config['install_path'] . forums::furl('viewforum', $forum['id']) . '">' . $forum['title'] . '</a></p>';
			$str .= '<p class="forum-description">' . $forum['description'] . '</p>';

			if (0 !== ($num_children = count($children)))
			{
				$sub = 0;

				$s_subforum = '<p class="forum-subforums">Subforum' . ($num_children == 1 ? '' : 's') . ': ';

				foreach ($children as $child)
				{
					$c_canview = false;

					if ($child['flags'] == '')
					{
						if ($child['default_flags'] & F_FORUM_VIEW)
						{
							$c_canview = true;
						}
					}
					else if ($child['flags'] & F_FORUM_VIEW)
					{
						$c_canview = true;
					}

					if (!$c_canview)
					{
						continue;
					}

					$sub++;

					$s_subforum .= '<a href="' . $config['install_path'] . forums::furl('viewforum', $child['id']) . '">' . $child['title'] . '</a>, ';
				}

				$s_subforum = substr($s_subforum, 0, -2);

				$s_subforum .= '</p>';

				if ($sub)
				{
					$str .= $s_subforum;
				}
			}

			$str .= '</td>';

			$str .= '<td width="70px" align="center" class="' . ($i % 2 ? 'odd' : 'even') . '"><p class="forum-description">' . $forum['posts'] . $new . '</p></td>';

			$str .= '</tr>';
		}

		$str .= '</table>';

		if ($i)
		{
			return $str;
		}

		return false;
	}

	function check_forum_exists($f_id)
	{
		global $db;

		$sql = 'SELECT f.is_forum
			FROM forums f
			WHERE f.id = %d';

		$sql = sprintf($sql, $f_id);

		$db->sql_query($sql);
		$db->sql_data($data, true);

		if (isset($data['is_forum']) && $data['is_forum'] == 1)
		{
			return true;
		}

		return false;
	}

	function check_post_exists($p_id)
	{
		global $db;

		$sql = 'SELECT p.is_post
			FROM posts p
			WHERE p.d_id = %d';

		$sql = sprintf($sql, $p_id);

		$db->sql_query($sql);
		$db->sql_data($data, true);

		if (isset($data['is_post']) && $data['is_post'] == 1)
		{
			return true;
		}

		return false;
	}

	function parse_qs()
	{
		global $config;

		$redirect = $this->redirect;

		if (isset($_GET['f']))
		{
			$f_id = $_GET['f'];

			if (!$this->check_forum_exists($f_id))
			{
				if ($redirect)
				{
					redirect('http://' . $config['domain_name'] . $config['install_path'] . forums::furl());
				}

				return;
			}

			$this->f_id = $f_id;

			$this->f_data = htmlspecialchars_array($this->forum_get_data($this->f_id));
		}
		else if (isset($_GET['f_unix']))
		{
			if (false === ($f_id = $this->cat_unix_to_id($_GET['f_unix'])))
			{
				/* no such forum exists */
				if ($redirect)
				{
					redirect('http://' . $config['domain_name'] . $config['install_path'] . forums::furl());
				}

				return;
			}

			if (!$this->check_forum_exists($f_id))
			{
				/* category exists but isn't a forum */
				if ($redirect)
				{
					redirect('http://' . $config['domain_name'] . $config['install_path'] . forums::furl());
				}

				return;
			}

			$this->f_id = $f_id;

			$this->f_data = htmlspecialchars_array($this->forum_get_data($this->f_id));
		}

		if (isset($_GET['p']))
		{
			$p_id = $_GET['p'];

			if (!$this->check_post_exists($p_id))
			{
				/* post does not exist */
				if ($redirect)
				{
					redirect('http://' . $config['domain_name'] . $config['install_path'] . forums::furl());
				}

				return;
			}

			$this->p_id = $p_id;

			$this->p_data = htmlspecialchars_array($this->post_get_data($this->p_id));
			$this->f_data = htmlspecialchars_array($this->forum_get_data($this->p_data['forum']));
			$this->f_id = $this->f_data['id'];
		}
	}

	function get_sig($u_id)
	{
		global $db;

		$sql = 'SELECT u.user_sig
			FROM users u
			WHERE u.user_id = %d';

		$sql = sprintf($sql, $u_id);

		$db->sql_query($sql);
		$db->sql_data($data, true);

		if (!empty($data['user_sig']))
		{
			$signature = format_text($data['user_sig']);

			$signature = str_replace('<p>', '', $signature);
			$signature = str_replace('</p>', "<br /><br />", $signature);

			$signature = trim($signature);
			$signature = substr($signature, 0, -12);

			return trim($signature);
		}

		return false;
	}

	function create_as_forum($id, $parent = 0)
	{
		global $db;

		$sql = 'SELECT 1
			FROM forums f
			WHERE f.id = %d';

		$sql = sprintf($sql, $id);

		$db->sql_query($sql);
		$db->sql_data($forum_exists, true);

		if (!empty($forum_exists))
		{
			return true;
		}

		$sql = 'SELECT f.position
			FROM forums f
			WHERE f.parent_id = %d
			ORDER BY f.position DESC
			LIMIT 1';

		$sql = sprintf($sql, $parent);

		$db->sql_query($sql);
		$db->sql_data($pos);

		$pos = @implode('', $pos) + 1;

		$sql = 'INSERT INTO forums (
			id, is_forum, position, parent_id, posts
			) VALUES (
			%d, 1, %d, %d, 0
			)';

		$sql = sprintf($sql, $id, $pos, $parent);

		$db->sql_query($sql);

		return true;
	}

	function forum_dropdown($selected = 0, $parent = 0, $level = 0)
	{
		$list = forums::get_forum_list($parent);
		$str = '';

		if (!is_array($selected))
		{
			$selected = array($selected);
		}

		foreach ($list as $forum)
		{
			$str_selected = '';

			while (list($key, $val) = each($selected))
			{
				if ($val == $forum['id'])
				{
					$str_selected = ' selected="selected"';
				}
			}

			$str .= '<option' . $str_selected . ' value="' . $forum['id'] . '">' . str_repeat('&nbsp;', $level*4) . $forum['title'] . '</option>';
			$str .= forums::forum_dropdown($selected, $forum['id'], $level+1);
		}

		return $str;
	}

	function report_list($selected = 0)
	{
		global $db;

		$sql = 'SELECT r.id, r.title
			FROM report_categories r
			ORDER BY r.title ASC';

		$db->sql_query($sql);
		$db->sql_data($data);

		$str = '';

		foreach ($data as $rc)
		{
			$str .= sprintf('<option value="%d"%s>%s</option>', $rc['id'], ($selected == $rc['id'] ? ' selected="selected"' : ''), trim($rc['title']));
		}

		return $str;
	}

	function furl($op1 = '', $op2 = '', $op3 = '', $op4 = '', $op5 = '')
	{
		switch ($op1)
		{
			case 'view':
			case 'edit':
			case 'delete':
			case 'bookmark':
			case 'unbookmark':
			case 'lock':
			case 'unlock':
			case 'stick':
			case 'unstick':
			case 'move':
			case 'report':
			case 'reports':

				return (REWRITE ? "forums/$op1/$op2" : "forums.php?op=$op1&amp;p=$op2");

			case 'post':

				if (REWRITE)
				{
					if ($op2 == 'p')
					{
						return "forums/reply/$op3";
					}

					return "forums/new/$op3";
				}

				return "forums.php?op=post&amp;$op2=$op3";

			case 'resync':

				return (REWRITE ? "forums/resync?from=$op2" : "forums.php?op=resync&amp;from=$op2");

			case 'addforum':
			case 'bookmarks':
			case 'redirview':

				return (REWRITE ? "forums/$op1" : "forums.php?op=$op1");

			case 'approve':

				return (REWRITE ? "forums/$op1/$op2" : "forums.php?op=$op1&amp;f=$op2");

			case 'markread':
			case 'search':

				if ($op2)
				{
					return (REWRITE ? "forums/$op1/$op2" : "forums.php?op=$op1&amp;f=$op2");
				}

				return (REWRITE ? "forums/$op1" : "forums.php?op=$op1");

			case 'viewforum':

				if (is_numeric($op2))
				{
					return (REWRITE ? "forums/$op2" : "forums.php?op=viewforum&amp;f=$op2");
				}

				return (REWRITE ? "forums/$op2/" : "forums.php?op=viewforum&amp;f_unix=$op2");

			case 'admin':

				if ($op2 == 'report_categories')
				{
					if ($op4)
					{
						return (REWRITE ? "forums/admin/$op2/$op3/$op4" : "forums.php?op=admin&amp;sub=$op2&amp;action=$op3&amp;rc=$op4");
					}

					if ($op3)
					{
						return (REWRITE ? "forums/admin/$op2/$op3" : "forums.php?op=admin&amp;sub=$op2&amp;action=$op3");
					}
				}

				if ($op5)
				{
					return (REWRITE ? "forums/admin/$op2/$op3/$op4/$op5" : "forums.php?op=admin&amp;sub=$op2&amp;f=$op3&amp;action=$op4&u_id=$op5");
				}
				else if ($op4)
				{
					return (REWRITE ? "forums/admin/$op2/$op3/$op4" : "forums.php?op=admin&amp;sub=$op2&amp;f=$op3&amp;action=$op4");
				}
				else if ($op3)
				{
					return (REWRITE ? "forums/admin/$op2/$op3" : "forums.php?op=admin&amp;sub=$op2&amp;f=$op3");
				}
				else if ($op2)
				{
					return (REWRITE ? "forums/admin/$op2" : "forums.php?op=admin&amp;sub=$op2");
				}
				else
				{
					return (REWRITE ? "forums/admin" : "forums.php?op=admin");
				}

			default:

				return (REWRITE ? 'forums' : 'forums.php');
		}
	}

	function post_get_parent($post_id)
	{
		global $db;

		$sql = 'SELECT p.parent_id
			FROM posts p
			WHERE p.d_id = %d';

		$sql = sprintf($sql, $post_id);

		$db->sql_query($sql);
		$db->sql_data($data, true);

		return $data['parent_id'];
	}

	function first_post($post_id)
	{
		global $db;

		$sql = 'SELECT p.fp_id
			FROM posts p
			WHERE p.d_id = %d';

		$sql = sprintf($sql, $post_id);

		$db->sql_query($sql);
		$db->sql_data($data, true);

		if (!$data['fp_id'])
		{
			$initial_id = $post_id;

			while(0 != ($parent = forums::post_get_parent($post_id)))
			{
				$post_id = $parent;
			}

			$sql = 'UPDATE posts
				SET fp_id = %d
				WHERE d_id = %d';

			$sql = sprintf($sql, $post_id, $initial_id);

			$db->sql_query($sql);

			return $post_id;
		}

		return $data['fp_id'];
	}

	function bookmarked($post_id, $user_id = 0)
	{
		global $db, $session;

		$sql = 'SELECT b.*
			FROM bookmarks b
			WHERE b.user_id = %d
			AND b.post_id = %d';

		$sql = sprintf($sql, ($user_id ? $user_id : $session->user_id), $post_id);

		$db->sql_query($sql);
		$db->sql_data($data, true);

		if (!empty($data))
		{
			return $data;
		}

		return false;
	}

	function bookmark($post_id)
	{
		global $db, $session;

		if ($this->bookmarked($post_id, $session->user_id))
		{
			return;
		}

		$sql = 'INSERT INTO bookmarks (
			user_id, post_id
			) VALUES (
			%d, %d
			)';

		$sql = sprintf($sql, $session->user_id, $post_id);

		$db->sql_query($sql);
	}

	function unbookmark($post_id)
	{
		global $db, $session;

		if (!$this->bookmarked($post_id, $session->user_id))
		{
			return;
		}

		$sql = 'DELETE FROM bookmarks
			WHERE user_id = %d
			AND post_id = %d';

		$sql = sprintf($sql, $session->user_id, $post_id);

		$db->sql_query($sql);
	}

	function change($field, $value, $post_id)
	{
		global $db;

		$sql = 'UPDATE posts
			SET %s = %d
			WHERE d_id = %d';

		$sql = sprintf($sql, $field, $value, $post_id);

		$db->sql_query($sql);
	}

	function stick($post_id)
	{
		$this->change('is_sticky', 1, $post_id);
	}

	function unstick($post_id)
	{
		$this->change('is_sticky', 0, $post_id);
	}

	function lock($post_id)
	{
		$this->change('is_locked', 1, $post_id);
	}

	function unlock($post_id)
	{
		$this->change('is_locked', 0, $post_id);
	}

	function select_bookmarks($user_id = 0)
	{
		global $db, $session;

		$sql = 'SELECT b.*, p.*, d.*
			FROM bookmarks b, posts p, data d
			WHERE p.d_id = d.id
			AND b.post_id = d.id
			AND b.user_id = %d';

		$sql = sprintf($sql, ($user_id ? $user_id : $session->user_id));

		$db->sql_query($sql);
		$db->sql_data($data);

		return $data;
	}
}

?>
