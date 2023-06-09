<?php 
# ---------------------------------------------------------------
# bookmarker
# A WWW based bookmark management, retrieval, and search tool.
# Copyright (C) 1998  Padraic Renaghan
# Licensed under terms of GNU General Public License
# (see http://www.renaghan.com/bookmarker/source/LICENSE)
# ---------------------------------------------------------------
# $Id: plist.inc,v 1.30 2000/11/01 15:34:56 prenagha Exp $
# ---------------------------------------------------------------
function print_list_break (&$list_tpl, $category, $subcategory) {
  global $sess;
  
# construct URLs that include WHERE clauses for linking to the
# search page. The Category link will show a search WHERE the
# category matches. The sub-cat link will show a search WHERE
# the subcategory matches. Need to encode the URL since it contains
# single-quotes, equal sign, and possibly spaces.
# we use base64 coding rather than urlencode and rawencode since
# it seems to be more reliable.
  $cat_search = $sess->url( "search.php3?where=" . base64_encode("category.name='$category'"));
  $subcat_search = $sess->url("search.php3?where=" . base64_encode("subcategory.name='$subcategory'"));

  $list_tpl->set_var(array(
    CATEGORY           => htmlspecialchars(stripslashes($category)),
    CATEGORY_SEARCH    => $cat_search,
    SUBCATEGORY        => htmlspecialchars(stripslashes($subcategory)),
    SUBCATEGORY_SEARCH => $subcat_search
  ));
        
  $list_tpl->parse(LIST_HDR, "header");
  $list_tpl->parse(LIST_FTR, "footer");
  $list_tpl->parse(CONTENT, "list_section", TRUE);
  $list_tpl->set_var("LIST_ITEMS", "");
}

function print_list ($where_clause, $limit, $offset, $returnto, &$content, &$error_msg) {
  global $bookmarker, $sess, $auth, $bk_db_callout;
  
# if no action, then show the same list as last time
# this page was viewed. the session start variables 
# should be set by the register function
  $bk_c = new bk_db;

# every bookmarker page uses templates to generate HTML.
  $list_tpl = new bktemplate;
  $list_tpl->set_root(TEMPLATEDIR);
  $list_tpl->set_unknowns("remove");

  $list_tpl->set_file(array(
    list_section   => "common.list.section.tpl",
    header         => "common.list.hdr.tpl",
    footer         => "common.list.ftr.tpl",
    list_item      => "common.list.item.tpl",
    item_keyw      => "common.list.item_keyw.tpl"
  ));

  ## db callout to set big temporary tables option
  $bk_db_callout->set_big_temp_tables ($bk_c);

# you can see/search anything that you own, and anything that others
# have marked as public if you have indicated so on your auth_user record.
  if ($auth->auth["include_public"] == "Y" || $auth->is_nobody()) 
    $public_sql = " or bookmark.public_f='Y' ";

  $query = sprintf("select category.name as category_name, bookmark.category_id, 
    subcategory.name as subcategory_name, bookmark.subcategory_id, bookmark.id, 
    bookmark.url, bookmark.name as bookmark_name, bookmark.ldesc, bookmark.keywords, 
    rating.name as rating_name, bookmark.rating_id, bookmark.username
    from bookmark, category, subcategory, rating 
    where ( bookmark.category_id = category.id 
     and category.username = bookmark.username 
     and bookmark.subcategory_id = subcategory.id 
     and subcategory.username = bookmark.username 
     and bookmark.rating_id = rating.id 
     and rating.username = bookmark.username )
     and (   bookmark.username = '%s' %s )"
     , ($auth->is_nobody()?"":$auth->auth['uname']), $public_sql);
  
  if ($where_clause != "") {
    $where_clause_sql = " and " . $where_clause;
  } else {
    $where_clause_sql = " ";
  }

  $order_by_sql = " order by category.name, subcategory.name, bookmark.name, bookmark.id";

  ## db callout to add limit clause to sql
  $limit_sql = $bk_db_callout->get_limit_sql ($offset, $limit);
  
  $query .= $where_clause_sql.$order_by_sql.$limit_sql;
  
  $bk_c->query($query);
  if ($bk_c->Errno != 0) {
    $error_msg .= sprintf("<strong>Database Error</strong><br>Number: %s <br>Message: %s <br>SQL Stmt: %s", 
      $bk_c->Errno, $bk_c->Error, $query);
    return;
  }

  $prev_category_id = -1;
  $prev_subcategory_id = -1;
  $rows_printed = 0;

  while ($bk_c->next_record()) {
    $rows_printed ++;

    if (($bk_c->f("category_name") != $prev_category) or
      ($bk_c->f("subcategory_name") != $prev_subcategory)) {

      if ($rows_printed > 1) {
        print_list_break(&$list_tpl, $prev_category, $prev_subcategory);
      }

      $prev_category       = $bk_c->f("category_name");
      $prev_subcategory    = $bk_c->f("subcategory_name");
    }

    if ($bk_c->f("keywords") > " ") {
      $list_tpl->set_var(BOOKMARK_KEYW, htmlspecialchars(stripslashes($bk_c->f("keywords"))));
      $list_tpl->parse(KEYWORDS,"item_keyw");
    } else {
      $list_tpl->set_var(KEYWORDS, "");
    }

    # if you are the owner of this bookmark, then you get the
    # link to the maintain page, otherwise you don't.
    if (!$auth->is_nobody() 
    &&   $auth->auth['uname'] == $bk_c->f("username")) {
      $maintain_url = $sess->url(sprintf("maintain.php3?id=%s&returnto=%s", $bk_c->f("id"), base64_encode($returnto)));
      $maintain_link = sprintf("<a href=\"%s\"><img src=\"%s%s.%s\" width=24 height=24 align=top border=0 alt=\"Edit this Bookmark\"></a>", $maintain_url, $bookmarker->image_url_prefix, "edit", $bookmarker->image_ext);

      $delete_link   = sprintf("<a href=\"%s\"><img src=\"%s%s.%s\" width=17 height=16 align=top border=0 alt=\"Delete this Bookmark\"></a>", $maintain_url, $bookmarker->image_url_prefix, "delete", $bookmarker->image_ext);

    } else {
      $maintain_link = sprintf("<!-- owned by: %s -->", $bk_c->f("username"));
      $delete_link = "&nbsp;";
    }

    $list_tpl->set_var(array(
      MAINTAIN_LINK      => $maintain_link,
      DELETE_LINK        => $delete_link,
      MAIL_THIS_LINK_URL => $sess->url("maillink.php3?id=".$bk_c->f("id")),
      BOOKMARK_USERNAME  => $bk_c->f("username"),
      BOOKMARK_ID        => $bk_c->f("id"),
      BOOKMARK_URL       => $bk_c->f("url"),
      BOOKMARK_RATING    => htmlspecialchars(stripslashes($bk_c->f("rating_name"))),
      BOOKMARK_RATING_ID => $bk_c->f("rating_id"),
      BOOKMARK_NAME      => htmlspecialchars(stripslashes($bk_c->f("bookmark_name"))),
      BOOKMARK_DESC      => nl2br(htmlspecialchars(stripslashes($bk_c->f("ldesc")))),
      IMAGE_URL_PREFIX   => $bookmarker->image_url_prefix,
      IMAGE_EXT          => $bookmarker->image_ext
    ));

    $list_tpl->parse(LIST_ITEMS, "list_item", TRUE);
  }

  if ($rows_printed > 0) {
    print_list_break(&$list_tpl, $prev_category, $prev_subcategory);
    $content = $list_tpl->get("CONTENT");
  }
}
?>
