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
require_once('global.php');

$id = $_GET['id'];
if( !$lore_system->db->id_exists( $id, 'lore_articles') )
{
	$lore_system->te->assign('error_message', 'invalid_article');
	$lore_system->te->display('error_message.tpl');
	exit;
}
if( !$lore_db_interface->article_is_published( $id ) )
{
	$lore_system->te->assign('error_message', 'article_not_published');
	$lore_system->te->display('error_message.tpl');
	exit;
}

switch( $_GET['action'] )
{
	case 'print':
		$article = $lore_db_interface->get_article_info( $id );
		$article['comments'] = $lore_db_interface->get_article_comments( $id );
		
		$lore_system->te->assign('category_path', $lore_db_interface->get_category_path( $article['category_id'] ));
		$lore_system->te->assign('article', $article);
		$lore_system->te->display('article_print.tpl');
	break;
		
	default:
		if( !@in_array( $id, $lore_user_session->session_vars['viewed_articles'] ) )
		{
			$lore_db_interface->increment_article_views( $id );
			$lore_user_session->session_vars['viewed_articles'][] = $id;
		}
		
		$article			= $lore_db_interface->get_article_info( $id );
		$article['comments']		= $lore_db_interface->get_article_comments( $id );
		$article['num_comments']	= count($article['comments']);
		$article['attachments']		= $lore_db_interface->get_article_attachments( $id );
		$article['allow_comments']	= $lore_db_interface->can_comment_on_article( $id );
		$article['related_articles']	= $lore_db_interface->get_related_articles( $id );

		if( $lore_user_session->has_article_write_permission( $id ) )
		{
			$article['display_edit_link'] = true;
		}

		if( $lore_system->settings['enable_glossary_popups'] )
		{
			$glossary_terms = $lore_db_interface->get_glossary_terms();
			if( count($glossary_terms) )
			{
				$term_c = 0;
				foreach( $glossary_terms AS $term )
				{
					$lore_system->te->assign('term', addslashes($term['term']));
					$lore_system->te->assign('definition', addslashes($term['definition']));

					@preg_match_all( "/\b" . $term['term'] . "\b/i",  $article['content'], $matches);
					for( $i = 0; $i < count($matches[0]); $i++ )
					{
						$lore_system->te->assign('original', $matches[0][$i]);
						$term_html[$term_c] = $lore_system->te->fetch('glossary_term.tpl');
						$article['content'] = preg_replace("/\b" . $matches[0][$i] . "\b/", "{{g$term_c}}", $article['content']);
						$term_c++;
					}

					if( $term['alt_term_1'] )
					{
						@preg_match_all( "/\b" . $term['alt_term_1'] . "\b/i",  $article['content'], $matches);
						for( $i = 0; $i < count($matches[0]); $i++ )
						{
							$lore_system->te->assign('original', $matches[0][$i]);
							$term_html[$term_c] = $lore_system->te->fetch('glossary_term.tpl');
							$article['content'] = preg_replace("/\b" . $matches[0][$i] . "\b/", "{{g$term_c}}", $article['content']);
							$term_c++;
						}
					}
					if( $term['alt_term_2'] )
					{
						@preg_match_all( "/\b" . $term['alt_term_2'] . "\b/i",  $article['content'], $matches);
						for( $i = 0; $i < count($matches[0]); $i++ )
						{
							$lore_system->te->assign('original', $matches[0][$i]);
							$term_html[$term_c] = $lore_system->te->fetch('glossary_term.tpl');
							$article['content'] = preg_replace("/\b" . $matches[0][$i] . "\b/", "{{g$term_c}}", $article['content']);
							$term_c++;
						}
					}
					if( $term['alt_term_3'] )
					{
						@preg_match_all( "/\b" . $term['alt_term_3'] . "\b/i",  $article['content'], $matches);
						for( $i = 0; $i < count($matches[0]); $i++ )
						{
							$lore_system->te->assign('original', $matches[0][$i]);
							$term_html[$term_c] = $lore_system->te->fetch('glossary_term.tpl');
							$article['content'] = preg_replace("/\b" . $matches[0][$i] . "\b/", "{{g$term_c}}", $article['content']);
							$term_c++;
						}
					}
				} // end foreach

				for( $i = 0; $i < count($term_html); $i++ )
				{
					$article['content'] = str_replace("{{g$i}}", $term_html[$i], $article['content']);
				}

			} // end if
		} // end if

		$lore_system->te->assign('category_path', $lore_db_interface->get_category_path( $article['category_id'] ));
		$lore_system->te->assign('category_path_ids', $lore_db_interface->get_category_path( $article['category_id'], true ));
		$lore_system->te->assign('article', $article);
		$lore_system->te->assign('category', array('id' => $article['category_id'], 'name' => $article['category_name']));
		$lore_system->te->display('article.tpl');
	break;
}

?>
