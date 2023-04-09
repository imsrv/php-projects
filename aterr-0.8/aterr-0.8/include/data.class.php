<?php

/*
	aterr - a threaded forum system.

	Copyright (c) 2005 Chris Jenkinson <chris@starglade.org>.
	All rights reserved.

	aterr is licensed under the GNU General Public License.
	<http://opensource.org/licenses/gpl-license.php>
*/

class data extends categories
{
	var $date;
	var $category;
	var $unix_title;
	var $id;

	function data()
	{
		$this->date = array('year' => 0, 'month' => 0, 'day' => 0);
		$this->category = array();
		$this->unix_title = '';
		$this->id = 0;
	}

	function data_exists($id)
	{
		global $db;

		$sql = 'SELECT d.id
			FROM data d
			WHERE d.id = %d';

		$sql = sprintf($sql, $id);

		$db->sql_query($sql);
		$db->sql_data($data, true);

		if (!empty($data))
		{
			return $id;
		}

		return false;
	}

	function handle_getpost()
	{
		/* handle any information on the query string or submitted via a form */

		if (!empty($_GET['year']))
		{
			$this->date['year'] = $_GET['year'];
		}
		if (!empty($_GET['month']))
		{
			$this->date['month'] = $_GET['month'];
		}
		if (!empty($_GET['day']))
		{
			$this->date['day'] = $_GET['day'];
		}
		if (!empty($_GET['cat_name']))
		{
			$this->category[] = $this->cat_unix_to_id($_GET['cat_name']);
		}
		if (!empty($_GET['title']))
		{
			$this->unix_title = $_GET['title'];
		}
		if (!empty($_GET['id']))
		{
			$this->id = $_GET['id'];
		}
	}

	function create_upper_lower_date(&$upper_date, &$lower_date)
	{
		$lower_date = mktime(0, 0, 0, $this->date['month'], $this->date['day'], $this->date['year']);

		if ($this->date['day'])
		{
			$upper_date = mktime(0, 0, 0, $this->date['month'], $this->date['day']+1, $this->date['year']);
		}
		else if ($this->date['month'])
		{
			$upper_date = mktime(0, 0, 0, $this->date['month']+1, $this->date['day'], $this->date['year']);
		}
		else if ($this->date['year'])
		{
			$upper_date = mktime(0, 0, 0, $this->date['month'], $this->date['day'], $this->date['year']+1);
		}
		else
		{
			/* no date given, do it over the entire timeframe */
			$upper_date = time();
		}
	}

	function select_raw_single_data($id_or_title)
	{
		return $this->select_single_data($id_or_title, true, false, true);
	}

	function select_single_data($id_or_title, $no_overwrite = false, $show_edit = true, $raw = false)
	{
		global $db, $session;

		/*
			there are two types of displays, single and multiple.
			if a title/id is given, it is a single type, however if we don't
			get a title/id it is multiple.

			we have a title/id, we only want to display this single thing.
			if we can use an ID number, use that as these are unique, whereas
			titles could be duplicated. select the newest one just in case there
			are two articles titled the same.
		*/

		if (is_numeric($id_or_title))
		{
			if (!$no_overwrite)
			{
				$this->id = $id_or_title;
			}
			$sql_a = 'd.id = %d';
		}
		else
		{
			if (!$no_overwrite)
			{
				$this->unix_title = $id_or_title;
			}
			$sql_a = 'd.unix_title = "%s"';
		}

		$this->create_upper_lower_date($upper_date, $lower_date);

		$sql = "SELECT d.*
			FROM data d
			WHERE $sql_a
			ORDER BY d.date DESC
			LIMIT 1";

		$sql = sprintf($sql, $id_or_title);

		$db->sql_query($sql);
		$db->sql_data($data, true);

		if (empty($data))
		{
			return false;
		}

		/* we now have an array, $data, containing the actual data requested. */

		if (!$raw)
		{
			$num_matches = preg_match('/(.*)\[\[PREVIEW\]\](.*)\[\[ENDPREVIEW\]\](.*)/ms', $data['text'], $matches);

			if ($num_matches)
			{
				$data['text'] = $matches[1] . $matches[3];
			}
		}

		$options = array();

		if ($show_edit && !$raw)
		{
			$replies = forums::count_replies($data['id']);

			$options[] = array(forums::furl('view', $data['id']), $replies . ' comment' . ($replies == 1 ? '' : 's'));
		}

		if (news::check_is_news($data['id']) && $show_edit)
		{
			/* this is a news article; check permissions */

			$categories = $this->select_categories($data['id']);

			$can_edit = $can_del = false;

			if ($data['u_id'] == $session->user_id)
			{
				$flag_edit = N_EDIT_OWN;
				$flag_del = N_DEL_OWN;
			}
			else
			{
				$flag_edit = N_EDIT_ALL;
				$flag_del = N_DEL_ALL;
			}

			foreach($categories as $key => $value)
			{
				$flags[$key] = permission::get_flags('news', $value);

				if ($flags[$key] & $flag_edit)
				{
					$can_edit = true;
				}
				if ($flags[$key] & $flag_del)
				{
					$can_del = true;
				}
			}

			if ($can_edit)
			{
				$options[] = array('/content/edit/' . $data['id'] . '/', 'edit article');
			}

			if ($can_del)
			{
				$options[] = array('/content/delete/' . $data['id'] . '/', 'delete article');
			}
		}

		if (count($options))
		{
			$str = '<p style="font-size:smaller;color: #555;">( ';

			foreach($options as $option)
			{
				$str .= '<a style="color: #555;" href="' . $option[0] . '">' . $option[1] . '</a> | ';
			}

			$str = substr($str, 0, -3);
			$str .= ' )</p>';

			$data['text'] .= $str;
		}

		return $data;
	}

	function select_multiple_data($select = '', $tables = '', $where = '', $order = 'd.date DESC', $lower_date = 0, $upper_date = 0, $start = 0, $limit = 15, $show_edit = true)
	{
		global $db, $session;

		if ($lower_date == 0 && $upper_date == 0)
		{
			$date = '';
		}
		else
		{
			$date =  ' AND (%d <= d.date AND d.date < %d)';
			$date = sprintf($date, $lower_date, $upper_date);
		}

		$sql = 'SELECT DISTINCT d.* %s
			FROM data d, data_categories dc %s
			WHERE d.id = dc.d_id %s
			%s
			ORDER BY %s
			LIMIT %s, %s';

		$sql = sprintf($sql, $select, $tables, $where, $date, $order, $start, $limit);

		$db->sql_query($sql);
		$db->sql_data($data);

		if (empty($data))
		{
			return false;
		}

		$count = count($data);

		for($i = 0; $i < $count; $i++)
		{
			$num_matches = preg_match('/(.*)\[\[PREVIEW\]\](.*)\[\[ENDPREVIEW\]\](.*)/ms', $data[$i]['text'], $matches);

			$options = array();

			if ($num_matches)
			{
				$data[$i]['text'] = $matches[1] . $matches[2];

				$options[] = array('{LINK}', 'read more...');
			}

			$replies = forums::count_replies($data[$i]['id']);

			if ($show_edit)
			{
				$options[] = array(forums::furl('view', $data[$i]['id']), $replies . ' comment' . ($replies == 1 ? '' : 's'));
			}

			if (news::check_is_news($data[$i]['id']))
			{
				/* this is a news article; check permissions */

				$categories = $this->select_categories($data[$i]['id']);

				$can_edit = $can_del = false;

				if ($data[$i]['u_id'] == $session->user_id)
				{
					$flag_edit = N_EDIT_OWN;
					$flag_del = N_DEL_OWN;
				}
				else
				{
					$flag_edit = N_EDIT_ALL;
					$flag_del = N_DEL_ALL;
				}

				foreach($categories as $key => $value)
				{
					$flags[$key] = permission::get_flags('news', $value);

					if ($flags[$key] & $flag_edit)
					{
						$can_edit = true;
					}
					if ($flags[$key] & $flag_del)
					{
						$can_del = true;
					}
				}

				if ($can_edit)
				{
					$options[] = array('/content/edit/' . $data[$i]['id'] . '/', 'edit article');
				}

				if ($can_del)
				{
					$options[] = array('/content/delete/' . $data[$i]['id'] . '/', 'delete article');
				}
			}

			if (count($options))
			{
				$str = '<p style="font-size:smaller;color: #555;">( ';

				foreach($options as $option)
				{
					$str .= '<a style="color: #555;" href="' . $option[0] . '">' . $option[1] . '</a> | ';
				}

				$str = substr($str, 0, -3);
				$str .= ' )</p>';

				$data[$i]['text'] .= $str;
			}
		}

		return $data;
	}

	function select_categories($data_id)
	{
		global $db;

		$sql = 'SELECT c.id, c.title, c.unix_title, c.description, c.image_path
			FROM categories c, data_categories dc
			WHERE c.id = dc.c_id AND dc.d_id = %d
			ORDER BY dc.order ASC';

		$sql = sprintf($sql, $data_id);

		$db->sql_query($sql);
		$db->sql_data($categories);

		/* the array $categories contains all categories the data item is put in */

		return $categories;
	}

	function add_data($title, $text, $u_id, $unix_title = '', $date = 0, $format_type = 'text')
	{
		global $db, $session;

		if (!$unix_title)
		{
			$unix_title = unixify($title);
		}

		if (!$date)
		{
			$date = time();
		}

		/* generate next ID number */

		$sql = 'SELECT d.id
			FROM data d
			ORDER BY d.id DESC
			LIMIT 1';

		$db->sql_query($sql);
		$db->sql_data($next_id, true);

		$next_id = @implode($next_id) + 1;

		$sql = "INSERT INTO data (
			id, date, title, unix_title, u_id, text, format_type, ip_addr
			) VALUES (
			%d, %d, '%s', '%s', %d, '%s', '%s', '%s'
			)";

		$sql = sprintf($sql, $next_id, $date, $title, $unix_title, $u_id, $text, $format_type, $session->ip);

		$db->sql_query($sql);

		return $next_id;
	}

	function edit_data($id, $title, $unix_title, $text, $u_id, $date, $format_type = 'text')
	{
		global $db;

		$sql = "UPDATE data SET
			title = '%s',
			unix_title = '%s',
			text = '%s',
			u_id = %d,
			date = %d,
			format_type = '%s'
			WHERE id = %d
			";

		$sql = sprintf($sql, $title, $unix_title, $text, $u_id, $date, $format_type, $id);

		$db->sql_query($sql);
	}

	function add_data_to_category($d_id, $c_id)
	{
		global $db;

		$sql = 'SELECT dc.c_id, dc.order
			FROM data_categories dc
			WHERE dc.d_id = %d';

		$sql = sprintf($sql, $d_id);

		$db->sql_query($sql);
		$db->sql_data($exists);

		foreach($exists as $value)
		{
			if ($value['c_id'] == $c_id)
			{
				/* already posted to this category */
				return;
			}
		}

		$order = end($exists);

		$order = $order['order'] + 1;

		$sql = 'INSERT INTO data_categories (
			c_id, d_id, `order`
			) VALUES (
			%d, %d, %d
			)';

		$sql = sprintf($sql, $c_id, $d_id, $order);

		$db->sql_query($sql);
	}

	function generate_format_type($selected = 'html')
	{
		$select_text = 'selected="selected" ';

		$text = '';

		$text .= '<option value="html"' . ($selected == 'html' ? $select_text : '') . '>HTML</option>';
		$text .= '<option value="plain"' . ($selected == 'plain' ? $select_text : '') . '>Plain Text</option>';

		return $text;
	}
}

?>
