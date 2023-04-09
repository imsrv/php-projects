<?php
/**************************************************************************
 *                                                                        *
 *    4images - A Web Based Image Gallery Management System               *
 *    ----------------------------------------------------------------    *
 *                                                                        *
 *             File: search_utils.php                                     *
 *        Copyright: (C) 2002 Jan Sorgalla                                *
 *            Email: jan@4homepages.de                                    *
 *              Web: http://www.4homepages.de                             *
 *    Scriptversion: 1.7.2                                                *
 *                                                                        *
 *    Never released without support from: Nicky (http://www.nicky.net)   *
 *                                                                        *
 **************************************************************************
 *                                                                        *
 *    Dieses Script ist KEINE Freeware. Bitte lesen Sie die Lizenz-       *
 *    bedingungen (Lizenz.txt) für weitere Informationen.                 *
 *    ---------------------------------------------------------------     *
 *    This script is NOT freeware! Please read the Copyright Notice       *
 *    (Licence.txt) for further information.                              *
 *                                                                        *
 *************************************************************************/
if (!defined('ROOT_PATH')) {
  die("Security violation");
}

$search_match_fields = array(
  "image_name" => "name_match",
  "image_description" => "desc_match",
  "image_keywords" => "keys_match"
);

function convert_special($text) {
  return strtr(
    $text,
    array(
      "Ä" => "AE",
      "Ö" => "OE",
      "Ü" => "UE",
      "ä" => "ae",
      "ö" => "oe",
      "ü" => "ue",
      "ß" => "ss"
    )
  );
}

function prepare_searchwords($val)
{
  $val = strip_tags(trim($val));
  $val = convert_special($val);
  $val = strtolower($val);

  $search_array = array(
    "/&(?!(#[0-9]+|[a-z]+);)/si",
    "#([^]_a-z0-9-=\"'\/])([a-z]+?)://([^, \(\)<>\n\r]+)#si",
    "#([^]_a-z0-9-=\"'\/])www\.([a-z0-9\-]+)\.([a-z0-9\-.\~]+)((?:/[^, \(\)<>\n\r]*)?)#si",
    "#[-_'`´]+#s",
    "#[\*\n\t\r^\$\(\)<>\"\|,@\?%~\+\.\[\]{}:\/=!§\\\\]+#s"
  );

  $replace_array = array(
    " ",
    " ",
    " ",
    "",
    " "
  );
  $val = preg_replace($search_array, $replace_array, $val);

  if (empty($val)) {
    return array();
  }

  $stopword_list = get_stopwords();
  $split_words = preg_split("/\s+/", $val);
  $clean_words = array();

  foreach ($split_words as $word) {
    $len = strlen(preg_replace("/&(#[0-9]+|[a-z]+);/siU", "_", $word));
    if ($word != "" && $len >= MIN_SEARCH_KEYWORD_LENGTH && $len <= MAX_SEARCH_KEYWORD_LENGTH && !in_array($word, $stopword_list)) {
      $clean_words[] = $word;
    }
  }

  return $clean_words;
}

function add_searchwords($image_id = 0, $raw_words = array()) {
  global $site_db, $search_match_fields;

  if (!$image_id || empty($raw_words)) {
    return false;
  }

  $match_table_fields = $site_db->get_table_fields(WORDMATCH_TABLE);

  $clean_words = array();
  $allwords_sql = "";
  foreach ($raw_words as $key => $val) {
    $split_words = prepare_searchwords($val);

    if (empty($split_words)) {
      continue;
    }

    $word_cache = array();
    foreach ($split_words as $word) {
      $word_cache[$word] = 1;
      $allwords_sql .= ($allwords_sql != "") ? ", '".$word."'" : "'".$word."'";
    }
    if (!empty($word_cache)) {
      $clean_words[$key] = $word_cache;
    }
  }

  $word_exists = array();
  if ($allwords_sql != "") {
    $sql = "SELECT word_text, word_id
            FROM ".WORDLIST_TABLE."
            WHERE word_text IN ($allwords_sql)";
    $result = $site_db->query($sql);

    while ($row = $site_db->fetch_array($result)) {
      $word_exists[$row['word_text']] = $row['word_id'];
    }
    $site_db->free_result();
  }

  $word_done = array();
  $new_words = array();
  $word_insert_sql = "";
  foreach ($clean_words as $key => $val) {
    foreach ($val as $key2 => $val2) {
      if (!isset($word_done[$key2])) {
        $word_done[$key2] = 1;
        if (isset($word_exists[$key2])) {
          $word_insert_sql .= (($word_insert_sql != "" ) ? ", " : "")."(".$image_id.", ".$word_exists[$key2];
          foreach ($search_match_fields as $key3 => $val3) {
            if (isset($match_table_fields[$val3])) {
              $match = (isset($clean_words[$key3][$key2])) ? 1 : 0;
              $word_insert_sql .= ", ".$match;
            }
          }
          $word_insert_sql .= ")";
        }
        else {
          $new_words[$key2] = array();
          foreach ($search_match_fields as $key3 => $val3) {
            $match = (isset($clean_words[$key3][$key2])) ? 1 : 0;
            $new_words[$key2][$val3] = $match;
          }
        }
      }
    }
  }

  if ($word_insert_sql != "") {
    $match_image_fields_sql = "";
    foreach ($search_match_fields as $field) {
      $match_image_fields_sql .= ", ".$field;
    }
    $sql = "REPLACE INTO ".WORDMATCH_TABLE."
            (image_id, word_id".$match_image_fields_sql.")
            VALUES
            $word_insert_sql";
    $site_db->query($sql);
  }

  if (!empty($new_words)) {
    $value_sql = "";
    foreach ($new_words as $key => $val) {
      $value_sql .= (($value_sql != "") ? ", " : "")."('".addslashes($key)."', NULL)";
    }
    if ($value_sql != "") {
      $sql = "INSERT IGNORE INTO ".WORDLIST_TABLE." (word_text, word_id)
              VALUES $value_sql";
      $site_db->query($sql);
    }

    foreach ($new_words as $key => $val) {
      $match_insert_key_sql = "";
      $match_insert_val_sql = "";
      foreach ($search_match_fields as $field) {
        if (isset($match_table_fields[$field])) {
          $match_insert_key_sql .= ", ".$field;
          $match_insert_val_sql .= ", ".$val[$field];
        }
      }
      $sql = "INSERT INTO ".WORDMATCH_TABLE." (image_id, word_id".$match_insert_key_sql.")
              SELECT DISTINCT $image_id, word_id".$match_insert_val_sql."
                FROM ".WORDLIST_TABLE."
                WHERE word_text = '$key'";
      $site_db->query($sql);
    }
  }
  return true;
}

function remove_searchwords($image_ids_sql = "") {
  global $site_db;

  if (empty($image_ids_sql)) {
    return false;
  }

  $sql = "SELECT word_id
          FROM ".WORDMATCH_TABLE."
          WHERE image_id IN ($image_ids_sql)";
  $result = $site_db->query($sql);
  $all_word_id_sql = "";
  while ($row = $site_db->fetch_array($result)) {
    $all_word_id_sql .= (($all_word_id_sql != "") ? ", " : "").$row['word_id'];
  }

  $word_id_delete_sql = "";
  if ($all_word_id_sql != "") {
    $sql = "SELECT word_id, COUNT(word_id) as word_id_count
            FROM ".WORDMATCH_TABLE."
            WHERE word_id IN ($all_word_id_sql)
            GROUP BY word_id";
    $result = $site_db->query($sql);
    while ($row = $site_db->fetch_array($result)) {
      if ($row['word_id_count'] == 1) {
        $word_id_delete_sql .= (($word_id_delete_sql != "") ? ", " : "").$row['word_id'];
      }
    }
  }

  if ($word_id_delete_sql != "") {
    $sql = "DELETE FROM ".WORDLIST_TABLE."
            WHERE word_id IN ($word_id_delete_sql)";
    $site_db->query($sql);
  }

  $sql = "DELETE FROM ".WORDMATCH_TABLE."
          WHERE image_id IN ($image_ids_sql)";
  $site_db->query($sql);

  return true;
}

function get_stopwords() {
  global $config, $stopwords;
  if (empty($stopwords)) {
    $stopword_list = @file(ROOT_PATH."lang/".$config['language_dir']."/search_stopterms.txt");
    $stopwords = array();
    if (!empty($stopword_list)) {
      foreach ($stopword_list as $word) {
        $stopwords[] = trim($word);
      }
    }
  }
  return $stopwords;
}
?>