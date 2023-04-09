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

define('LORE_VERSION', '1.4.0');
define('LORE_ROOT_CATEGORY_ID', 1);
define('ROOT_CATEGORY_ID', 1);

//////////////////////////////////////////////////////////////
/**
* Encapsulates basic functionality of the software system
* (such as the database, template engine, session, etc.)
*/
//////////////////////////////////////////////////////////////
class lore_system extends pt_system
{
	var $blackboard_table = "lore_blackboard";

	//////////////////////////////////////////////////////////////
	/**
	* Constructor
	*/
	//////////////////////////////////////////////////////////////
	function lore_system()
	{
		list($usec, $sec) = explode(' ', microtime()); 
		$this->start_time = ((float)$usec + (float)$sec); 

		$this->system_name = "Lore";

		$this->scripts = array(
			'index'			=> 'index.php',
			'article'		=> 'article.php',
			'category'		=> 'category.php',
			'comment'		=> 'comment.php',
			'user'			=> 'user.php',
			'rate'			=> 'rate.php',
			'attachment'		=> 'attachment.php',
			'email_article'		=> 'email_article.php',
			'search'		=> 'search.php',
			'global'		=> 'global.php',
			'contact'		=> 'contact.php',
			'rss'			=> 'rss.php',
			'lib'			=> 'lib.inc.php',
			'cp_lib'		=> 'cp_lib.inc.php',
		
			'cp_index'		=> 'index.php',
			'cp_article'		=> 'cp_article.php',
			'cp_attachment'		=> 'cp_attachment.php',
			'cp_category'		=> 'cp_category.php',
			'cp_user'		=> 'cp_user.php',
			'cp_user_group'		=> 'cp_user_group.php',
			'cp_settings'		=> 'cp_settings.php',
			'cp_comment'		=> 'cp_comment.php',
			'cp_glossary'		=> 'cp_glossary.php',
			'cp_maintenance'	=> 'cp_maintenance.php',
			'cp_search_log'		=> 'cp_search_log.php',
			'cp_template'		=> 'cp_template.php',
			'cp_style'		=> 'cp_style.php'
			);

	}
	
	function edit_settings( $setting_values )
	{
		$settings		= unserialize($this->db->query_one_result("SELECT content FROM $this->blackboard_table WHERE name='SETTINGS'"));
		$default_settings	= unserialize($this->db->query_one_result("SELECT content FROM $this->blackboard_table WHERE name='DEFAULT_SETTINGS'"));

		$settings		= array_merge($settings, $setting_values);
		$default_settings	= array_merge($default_settings, $setting_values);

		$content = addslashes(serialize($settings));
		$this->db->query("UPDATE $this->blackboard_table SET content='$content' WHERE name='SETTINGS'");
		$content = addslashes(serialize($default_settings));
		$this->db->query("UPDATE $this->blackboard_table SET content='$content' WHERE name='DEFAULT_SETTINGS'");
	}
}

class lore_user_session extends pt_user_session
{
	var $user_table = 'lore_users';
	
	//////////////////////////////////////////////////////////////
	/**
	* Check control panel permissions for specified script
	* and action.
	* @var string $script Control panel script
	* @var string $action Script action
	*/
	//////////////////////////////////////////////////////////////
	function check_cp_permission($script, $action='')
	{
		switch( $this->session_vars['user_info']['level'] )
		{
			case 'Administrator':
				return true;
			break;

			case 'Writer':
				switch( $script )
				{
					case 'index':
					case 'cp_article':
					case 'cp_comment':
					case 'cp_attachment':
					case 'cp_glossary':
						return true;
					break;

					case 'cp_user':
						return ( 'edit' == $action ) ? true : false;
					break;

					default:
						return false;
				}
			break;

			case 'Moderator':
				switch( $script )
				{
					case 'index':
					case 'cp_comment':
						return true;
					break;

					case 'cp_user':
						return ( 'edit' == $action ) ? true : false;
					break;

					default:
						return false;
				}
			break;

			default:
				return false;

		} // end switch
	}

	//////////////////////////////////////////////////////////////
	/**
	* Returns true if user has permission to edit specified article
	* @var int $article_id
	*/
	//////////////////////////////////////////////////////////////
	function has_article_write_permission( $article_id )
	{
		switch( $this->session_vars['user_info']['level'] )
		{
			case 'Administrator':
				return true;
			break;

			case 'Writer':

				if( is_array($article_id) )
				{
					foreach( $article_id AS $id )
					{
						if( $this->session_vars['user_info']['id'] == $this->db->query_one_result("SELECT user_id FROM lore_articles WHERE id='$id'") )
						{
							return true;
						}
						else
						{
							return false;
						}
					}
				}
				else
				{
					if( $this->session_vars['user_info']['id'] == $this->db->query_one_result("SELECT user_id FROM lore_articles WHERE id='$article_id'") )
					{
						return true;
					}
					else
					{
						return false;
					}
				}			
			break;

			case 'moderator':
			default:
				return false;
		}
	}
	
}


//////////////////////////////////////////////////////////////
/**
* Database interface - functions to do common queries on the
* database.
*/
//////////////////////////////////////////////////////////////
class lore_db_interface
{
	var $lore_system;
	
	function log_search( $query )
	{
		$this->lore_system->db->query("INSERT INTO lore_search_log (search, the_time) VALUES ('$query', '" . time() . "')");
	}
	function category_is_published($id)
	{
		return ( 1 == $this->lore_system->db->query_one_result("SELECT published FROM lore_categories WHERE id = '$id'") ) ? true : false;
	}
	
	function article_is_published($id)
	{
		return ( 1 == $this->lore_system->db->query_one_result("SELECT published FROM lore_articles WHERE id = '$id'") ) ? true : false;
	}
	
	function get_glossary_terms()
	{
		return $this->lore_system->db->query_all_rows("SELECT * FROM lore_glossary ORDER BY term ASC");
	}

	function can_comment_on_article( $article_id )
	{
		if( $this->lore_system->settings['allow_comments'] )
		{
			if( $this->lore_system->db->query_one_result("SELECT allow_comments FROM lore_articles WHERE id=$article_id") )
			{
				return true;
			}
		}
		return false;
	}

	function get_attachment( $attachment_id )
	{
		return $this->lore_system->db->query_one_row("SELECT * FROM lore_attachments WHERE id = '$attachment_id'");
	}

	function increment_attachment_downloads( $attachment_id )
	{
		$this->lore_system->db->query("UPDATE lore_attachments SET num_downloads = num_downloads + 1 WHERE id = '$attachment_id'");
	}

	function get_article_comments( $article_id, $limit=99999 )
	{
		$comments = $this->lore_system->db->query_all_rows("SELECT id,name,email,title,comment,created_time "
							."FROM lore_comments "
							."WHERE article_id = '$article_id' "
							."AND approved = 1 "
							."ORDER BY created_time "
							.$this->lore_system->settings['comment_order']
							." LIMIT $limit");

		if( $this->lore_system->settings['use_comment_censor'] && count($this->lore_system->settings['censor_word_list']) )
		{
			$num_comments = count($comments);
			for( $i = 0; $i < $num_comments; $i++ )
			{
				foreach( $this->lore_system->settings['censor_word_list'] AS $word )
				{	
					$comments[$i]['name'] = eregi_replace($word, str_repeat('*', strlen($word)), $comments[$i]['name']);			
					$comments[$i]['title'] = eregi_replace($word, str_repeat('*', strlen($word)), $comments[$i]['title']);
					$comments[$i]['comment'] = eregi_replace($word, str_repeat('*', strlen($word)), $comments[$i]['comment']);
				}
			}
		}

		return $comments;
	}

	function get_article_info( $article_id )
	{
		$article = $this->lore_system->db->query_one_row("SELECT lore_articles.*,lore_articles.total_rating/lore_articles.num_ratings AS rating,lore_users.username,lore_users.email "
							."FROM lore_articles,lore_users "
							."WHERE lore_articles.user_id = lore_users.id "
							."AND lore_articles.id= '$article_id' ");
		if( $article['header_id'] )
		{
			$article['content'] = $this->lore_system->db->query_one_result("SELECT content FROM lore_articles WHERE id = $article[header_id]") . $article['content'];
		}
		if( $article['footer_id'] )
		{
			$article['content'] .= $this->lore_system->db->query_one_result("SELECT content FROM lore_articles WHERE id = $article[footer_id]");
		}
		return $article;
	}

	function get_article_attachments( $article_id )
	{
		return $this->lore_system->db->query_all_rows("SELECT id,filename,filetype,filesize,num_downloads "
								."FROM lore_attachments "
								."WHERE article_id = '$article_id'");
	}

	function increment_article_views( $article_id )
	{
		$this->lore_system->db->query("UPDATE lore_articles SET num_views=num_views+1 WHERE id='$article_id'");
	}

	function get_category_info( $category_id )
	{
		return $this->lore_system->db->query_one_row("SELECT * FROM lore_categories WHERE id='$category_id'");
	}

	function get_category_article_list( $category_id )
	{
		$preview_length = $this->lore_system->settings['article_short_preview_length']*4;
		return $this->lore_system->db->query_all_rows("SELECT lore_articles.id,lore_articles.title,lore_articles.created_time,lore_articles.num_views,lore_articles.num_ratings,total_rating/num_ratings AS rating, lore_articles.featured, LEFT(content, $preview_length) AS preview, lore_categories.name AS category_name, lore_users.username AS username "
								."FROM lore_articles,lore_categories,lore_users "
								."WHERE lore_articles.category_id = '$category_id' "
								."AND lore_articles.category_id = lore_categories.id "
								."AND lore_articles.user_id = lore_users.id "
								."AND lore_articles.published = 1 "
								."AND lore_categories.published = 1 "
								."ORDER BY lore_articles." . $this->lore_system->settings['article_index_order'] . " " . $this->lore_system->settings['article_index_order_asc_or_desc']);
	}

	function get_subcategories( $category_id )
	{
		return $this->lore_system->db->query_all_rows("SELECT id,name,description,total_articles "
								."FROM lore_categories "
								."WHERE parent_category_id= '$category_id' "
								."AND published = 1 "
								."ORDER BY " . $this->lore_system->settings['category_index_order'] . ' ' . $this->lore_system->settings['category_index_order_asc_or_desc']);
	}

	function get_latest_articles($num=NULL)
	{
		$limit = ( $num ) ? $num : $this->lore_system->settings['num_top_articles'];
		$preview_length = $this->lore_system->settings['article_short_preview_length']*4;
		return $this->lore_system->db->query_all_rows("SELECT lore_articles.id,lore_articles.featured,lore_articles.created_time,lore_articles.num_views,lore_articles.title,lore_categories.name AS category_name,lore_categories.id AS category_id, LEFT(lore_articles.content, $preview_length) AS preview, "
							."lore_articles.num_ratings, lore_articles.total_rating/lore_articles.num_ratings AS rating "
							."FROM lore_articles,lore_categories "
							."WHERE lore_articles.category_id = lore_categories.id "
							."AND lore_articles.published = 1 "
							."AND lore_categories.published = 1 "
							."ORDER BY id DESC LIMIT "
							.$limit);
	}

	function get_most_viewed_articles($num=NULL)
	{
		$limit = ( $num ) ? $num : $this->lore_system->settings['num_top_articles'];
		$preview_length = $this->lore_system->settings['article_short_preview_length']*4;
		return $this->lore_system->db->query_all_rows("SELECT lore_articles.id,lore_articles.featured,lore_articles.created_time,lore_articles.num_views,lore_articles.title,lore_categories.name AS category_name,lore_categories.id AS category_id, LEFT(lore_articles.content, $preview_length) AS preview, "
							."lore_articles.num_ratings, lore_articles.total_rating/lore_articles.num_ratings AS rating "
							."FROM lore_articles,lore_categories "
							."WHERE lore_articles.category_id = lore_categories.id "
							."AND lore_articles.num_views > 0 "
							."AND lore_articles.published = 1 "
							."AND lore_categories.published = 1 "
							."ORDER BY lore_articles.num_views DESC LIMIT "
							.$limit);
	}

	function get_highest_rated_articles($num=NULL)
	{
		$limit = ( $num ) ? $num : $this->lore_system->settings['num_top_articles'];
		$preview_length = $this->lore_system->settings['article_short_preview_length']*4;
		return $this->lore_system->db->query_all_rows("SELECT lore_articles.id,lore_articles.featured,lore_articles.created_time,lore_articles.num_views,lore_articles.title,lore_categories.name AS category_name,lore_categories.id AS category_id, LEFT(lore_articles.content, $preview_length) AS preview, "
							."lore_articles.num_ratings, lore_articles.total_rating/lore_articles.num_ratings AS rating "
							."FROM lore_articles,lore_categories "
							."WHERE lore_articles.category_id = lore_categories.id "
							."AND lore_articles.num_views > 0 "
							."AND lore_articles.num_ratings > 0 "
							."AND lore_articles.published = 1 "
							."AND lore_categories.published = 1 "
							."ORDER BY rating DESC LIMIT "
							.$limit);
	}

	function get_category_path( $category_id, $ids_only = false )
	{
		if( LORE_ROOT_CATEGORY_ID != $category_id )
		{
			$row = $this->lore_system->db->query_one_row("SELECT id,name,parent_category_id FROM lore_categories WHERE id='$category_id'");
			$parent_category_id = $row['parent_category_id'];
			
			if( !$ids_only )
			{
				$categories[] = $row;
			}
			else
			{
				$categories[] = $row['id'];
			}
		}
		while( $parent_category_id > LORE_ROOT_CATEGORY_ID )
		{
			$row = $this->lore_system->db->query_one_row("SELECT id,name,parent_category_id FROM lore_categories WHERE id='$parent_category_id'");
			
			if( !$ids_only )
			{
				$categories[] = $row;
			}
			else
			{
				$categories[] = $row['id'];
			}
			$parent_category_id = $row['parent_category_id'];
		}
		return @array_reverse( $categories );
	}

	function add_article_rating( $article_id, $rating )
	{
		$this->lore_system->db->query("UPDATE lore_articles SET total_rating=total_rating+'$rating', num_ratings=num_ratings+1 WHERE id = '$article_id'");
	}

	function search_articles( $query, $title_and_keywords_only = false, $limit = false )
	{
		$preview_length = $this->lore_system->settings['article_short_preview_length']*4;

		if( false === $title_and_keywords_only )
		{
			$query = "SELECT lore_articles.*, lore_categories.id AS category_id, lore_categories.name AS category_name, LEFT(content, $preview_length) AS preview, total_rating/num_ratings AS rating  FROM lore_articles,lore_categories WHERE MATCH(title,content,keywords) AGAINST('$query') AND lore_articles.category_id=lore_categories.id AND lore_categories.published = 1 AND lore_articles.published = 1";
			$query .= ( $limit ) ? ' LIMIT ' . $limit : '';
			return $this->lore_system->db->query_all_rows($query);
		}
		else
		{
			$query = "SELECT lore_articles.*, lore_categories.id AS category_id, lore_categories.name AS category_name, LEFT(content, $preview_length) AS preview, total_rating/num_ratings AS rating  FROM lore_articles,lore_categories WHERE MATCH(title,keywords) AGAINST('$query') AND lore_articles.category_id=lore_categories.id AND lore_categories.published = 1 AND lore_articles.published = 1";
			$query .= ( $limit ) ? ' LIMIT ' . $limit : '';
			return $this->lore_system->db->query_all_rows($query);
		}
	}

	function search_categories( $query )
	{
		return $this->lore_system->db->query_all_rows("SELECT * FROM lore_categories WHERE MATCH(name,description) AGAINST('$query') AND lore_categories.published = 1" );
	}

	function get_related_articles( $id )
	{
		$query = addslashes($this->lore_system->db->query_one_result("SELECT title FROM lore_articles WHERE id='$id'"));
		$preview_length = $this->lore_system->settings['article_short_preview_length']*4;
		return $this->lore_system->db->query_all_rows("SELECT lore_articles.*,LEFT(content, $preview_length) AS preview, total_rating/num_ratings AS rating FROM lore_articles,lore_categories WHERE MATCH(title,keywords) AGAINST('$query') AND lore_articles.id != '$id' AND lore_articles.category_id=lore_categories.id AND lore_categories.published = 1 AND lore_articles.published = 1 LIMIT " . $this->lore_system->settings['num_related_articles']);
	}
}


//////////////////////////////////////////////////////////////
/**
* Category tree
*/
//////////////////////////////////////////////////////////////
class lore_category_tree extends pt_category_tree
{
	var $category_table = "lore_categories";
	var $blackboard_table = "lore_blackboard";

	function update_category_article_counts()
	{
		$result = $this->db->query("SELECT id FROM lore_categories");
		while( $row = $this->db->fetch_array($result) )
		{
			$this->db->query("UPDATE $this->category_table SET total_articles='" . $this->get_articles_in_category( $row['id'] ) . "' WHERE id='$row[id]'");
		}
	}

	function get_articles_in_category( $category_id, $total_articles=0 )
	{	
		$total_articles += $this->db->query_one_result("SELECT COUNT(*) FROM lore_articles WHERE category_id = '$category_id' AND published = 1");
		$result = $this->db->query("SELECT id FROM $this->category_table WHERE parent_category_id = '$category_id'");
		while( $category_row = $this->db->fetch_array($result) )
		{
			$total_articles = $this->get_articles_in_category( $category_row['id'], $total_articles );
		}
		return $total_articles;
	}
	
}


function lore_normal_url($params, &$smarty)
{
	global $lore_system;

	$script = $params['type'];
	switch( $script )
	{
		case 'article':
			echo $lore_system->scripts[$script] . '?id=' . $params['article_id'];
			if( $category_id )
			{
				echo '&category_id=' . $params['category_id'];
			}
		break;

		case 'category':
			echo $lore_system->scripts[$script] . '?id=' . $params['category_id'];
		break;
	}
}

function lore_search_engine_friendly_url($params, &$smarty)
{
	$smarty->assign($params);
	switch( $params['type'] )
	{
		case 'category':
			echo $smarty->fetch('url_category_search_engine_friendly.tpl');
		break;

		case 'article':
			echo $smarty->fetch('url_article_search_engine_friendly.tpl');
		break;
	}
}

?>
