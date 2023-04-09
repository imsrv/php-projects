<?php

/*
	aterr - a threaded forum system.

	Copyright (c) 2005 Chris Jenkinson <chris@starglade.org>.
	All rights reserved.

	aterr is licensed under the GNU General Public License.
	<http://opensource.org/licenses/gpl-license.php>
*/

class categories
{
	function cat_unix_to_id($c_unix_title)
	{
		global $db;

		$sql = 'SELECT c.id
			FROM categories c
			WHERE c.unix_title = "%s"';

		$sql = sprintf($sql, $c_unix_title);

		$db->sql_query($sql);
		$db->sql_data($data, true);

		if (empty($data))
		{
			return false;
		}

		return $data['id'];
	}

	function cat_title_to_id($title)
	{
		global $db;

		$sql = 'SELECT c.id
			FROM categories c
			WHERE c.title = "%s"';

		$sql = sprintf($sql, $title);

		$db->sql_query($sql);
		$db->sql_data($data, true);

		if (empty($data))
		{
			return false;
		}

		return $data['id'];
	}

	function cat_id_to_title($c_id)
	{
		global $db;

		$sql = 'SELECT c.title
			FROM categories c
			WHERE c.id = %d';

		$sql = sprintf($sql, $c_id);

		$db->sql_query($sql);
		$db->sql_data($data, true);

		if (empty($data))
		{
			return false;
		}

		return $data['title'];
	}

	function get_category_data($c_id)
	{
		global $db;

		$sql = 'SELECT c.*
			FROM categories c
			WHERE c.id = %d';

		$sql = sprintf($sql, $c_id);

		$db->sql_query($sql);
		$db->sql_data($data, true);

		return $data;
	}

	function categories_make_checkboxes($a_selected = null, $columns = 3)
	{
		global $db;

		if ($a_selected == null)
		{
			$a_selected = array();
		}

		$sql = 'SELECT c.id, c.title, c.unix_title
			FROM categories c
			ORDER BY c.title';

		$db->sql_query($sql);
		$db->sql_data($data);

		$str = '<tr>';
		$count = count($data);
		$count_selected = count($a_selected);

		$j = 0;

		for ($i = 0; $i < $count; $i++)
		{
			/*
			TODO: come up with a better way of doing it than this

			/*if (!permission::has_flag('news', $data[$i]['id'], F_POST))
			{
				continue;
			}*/

			$j++;

			$checked = '';

			for ($k = 0; $k < $count_selected; $k++)
			{
				if (isset($a_selected[$k]) && $a_selected[$k] == $data[$i]['id'])
				{
					$checked = 'checked="checked" ';
					break;
				}
			}

			$str .= '<td align="left" width="' . round(100 / $columns) . '%"><span style="font-size:smaller;"><input ' . $checked . 'type="checkbox" id="cat_' . $data[$i]['id'] .'" name="categories[' . $data[$i]['id'] . ']" />';
			$str .= '<label for="cat_' . $data[$i]['id'] . '">' . $data[$i]['title'] . '</label></span></td>';

			if (!(($j+1) % $columns))
			{
				/*
					have to use $j as the counter as $i is sometimes skipped if
					the person does not have the reqd. permission.
				*/

				$str .= '</tr><tr>';
			}
		}

		$str .= '</tr>';

		return $str;
	}

	function generate_dropdown($selected = array(0))
	{
		global $db;

		$sql = 'SELECT c.id, c.title, c.unix_title
			FROM categories c
			ORDER BY c.title';

		$db->sql_query($sql);
		$db->sql_data($data);

		$str = '';

		$selected_text = 'selected="selected" ';

		foreach ($data as $category)
		{
			/*
			 TODO: again come up with a better way than this

			if (!permission::has_flag('news', $data[$i]['id'], F_POST))
			{
				continue;
			}
			*/

			$str .= '<option ' . (in_array($category['id'], $selected) ? $selected_text : '') . 'value="' . $category['id'] . '">' . $category['title'] . '</option>';
		}

		return $str;
	}

	function add_category($title, $description, $unix_title = '')
	{
		global $db;

		if (!$unix_title)
		{
			$unix_title = unixify($title);
		}

		/* generate next ID number */

		$sql = 'SELECT c.id
			FROM categories c
			ORDER BY c.id DESC
			LIMIT 1';

		$db->sql_query($sql);
		$db->sql_data($next_id, true);

		$next_id = @implode($next_id) + 1;

		$sql = 'INSERT INTO categories (
			id, title, unix_title, description
			) VALUES (
			%d, "%s", "%s", "%s"
			)';

		$sql = sprintf($sql, $next_id, $title, $unix_title, $description);

		$db->sql_query($sql);

		return $next_id;
	}

	function edit_category($id, $title = '', $description = '', $unix_title = '')
	{
		global $db;

		if ($title)
		{
			$title = "title = '$title'";
		}

		if ($description)
		{
			$description = "description = '$description'";

			if ($title)
			{
				$description = ', ' . $description;
			}
		}

		if ($unix_title)
		{
			$unix_title = "unix_title = '$unix_title'";

			if ($title || $description)
			{
				$unix_title = ', ' . $unix_title;
			}
		}

		$sql = 'UPDATE categories SET
			%s
			%s
			%s
			WHERE id = %d';

		$sql = sprintf($sql, $title, $description, $unix_title, $id);

		$db->sql_query($sql);
	}
}

?>
