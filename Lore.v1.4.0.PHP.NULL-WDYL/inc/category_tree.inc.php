<?php
/*
+-------------------------------------------------------------------------
| Lore
| (c)2003-2004 Pineapple Technologies
| http://www.pineappletechnologies.com
| ------------------------------------------------------------------------
| This code is the proprietary product of Pineapple Technologies and is
| protected by international copyright and intellectual property laws.
| ------------------------------------------------------------------------
| Your usage of this software is bound by the agreement set forth in the
| software license that was packaged with this software as LICENSE.txt.
| A copy of this license agreement can be located at
| http://www.pineappletechnologies.com/products/lore/license.php
| By installing and/or using this software you agree to the terms
| stated in the license.
| ------------------------------------------------------------------------
| You may modify the code below at your own risk. However, the software
| cannot be redistributed, whether altered or not altered, in whole or in
| part, in any way, shape, or form.
+-------------------------------------------------------------------------
| Software Version: 1.4.0
+-------------------------------------------------------------------------
*/

//////////////////////////////////////////////////////////////
/**
* Category tree
* Class for working with a recurisve tree of categories
* stored in a database, supporting unlimited depth.
*/
//////////////////////////////////////////////////////////////
class pt_category_tree
{
	var $db;
	var $category_table;
	var $blackboard_table;
	
	function is_parent_of( $category_1, $category_2 )
	{
		return ( $category_1 == $this->db->query_one_result("SELECT parent_category_id FROM $this->category_table WHERE id='$category_2'") ) ? true : false;
	}

	function is_child_of( $category_1, $category_2 )
	{
		return ( $category_1 == $this->db->query_one_result("SELECT id FROM $this->category_table WHERE parent_category_id='$category_2'") ) ? true : false;
	}

	function update_category_tree()
	{
		$this->db->query("REPLACE INTO $this->blackboard_table (name,content) VALUES ('CATEGORY_TREE', '" . addslashes(serialize($this->generate_category_tree(ROOT_CATEGORY_ID, false))) . "')");
	}

	function generate_category_tree( $parent_category_id = ROOT_CATEGORY_ID, $show_unpublished = true )
	{
		if( $show_unpublished )
		{
			$result = $this->db->query("SELECT id,name FROM $this->category_table WHERE parent_category_id = $parent_category_id ORDER BY name ASC");
		}
		else
		{
			$result = $this->db->query("SELECT id,name FROM $this->category_table WHERE parent_category_id = $parent_category_id AND published = 1 ORDER BY name ASC");
		}
		while( $category_row = $this->db->fetch_array($result) )
		{
			extract( $category_row );
			$categories[$name] = $id;
			$subcategories = $this->generate_category_tree( $id, $show_unpublished );
			if( is_array( $subcategories ) )
			{
				$categories[] = $subcategories;
			}
		}
		return $categories;
	}

	function get_category_tree()
	{
		return @unserialize($this->db->query_one_result("SELECT content FROM $this->blackboard_table WHERE name='CATEGORY_TREE'"));
	}

	function get_category_options( $categories, $depth=-1 )
	{
		$depth++;
		foreach( $categories AS $key => $value )
		{
			if( is_array( $value ) )
			{
				$options = array_merge( $options, $this->get_category_options( $value, $depth ) );
			}
			else
			{
				$options[] = array('array_key' => str_repeat('.....', $depth) . $key, 'array_value' => $value);
			}
		}
		return $options;
	}
}
?>
