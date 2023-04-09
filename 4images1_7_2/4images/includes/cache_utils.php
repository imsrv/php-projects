<?php

function create_cache_id($group, $params = null){
  $cache_id = $group;
  if (is_array($params)) {
    $cache_id .= '.' . implode('.', $params);
  } elseif (is_string($params)) {
    $cache_id .= '.' . $params;
  }
  return $cache_id;
}

function get_cache_file($cache_id, $lifetime = null) {
  global $cache_enable, $cache_lifetime, $cache_path;

  if (!$cache_enable) {
    return false;
  }

  if (!$lifetime) {
    $lifetime = $cache_lifetime;
  }

  $file = $cache_path . '/' . $cache_id;

  if (!@is_readable($file)) {
    return false;
  }

  if ($lifetime == -1 || (filemtime($file) + $lifetime) > time()) {
    if (!$fp = @fopen($file, 'rb')) {
        return false;
    }

    $data = @fread($fp, filesize($file));
    @fclose($fp);

    if (defined('PRINT_CACHE_MESSAGES') && PRINT_CACHE_MESSAGES == 1) {
      echo "Cache file '$cache_id' <span style='color:green'>used</span><br>";
    }

    // Replace session ids
    global $site_sess;
    $replace = $site_sess->mode == 'cookie' ? '' : '\1\2'.SESSION_NAME.'='.$site_sess->session_id;
    $data = preg_replace(
      '#([\?|&])+(amp;)?%%%SID%%%#',
      $replace,
      $data
    );

    return $data;
  }

  if (defined('PRINT_CACHE_MESSAGES') && PRINT_CACHE_MESSAGES == 1) {
    echo "Cache file '$cache_id' <span style='color:purple'>expired</span><br>";
  }

  return false;
}

function save_cache_file($cache_id, $data) {
  global $cache_enable, $cache_lifetime, $cache_path;

  if (!$cache_enable) {
    return false;
  }

  $file = $cache_path . '/' . $cache_id;

  if ($fp = @fopen($file, 'wb')) {
    // Replace session ids
    global $site_sess;
    $data = str_replace(
      SESSION_NAME.'='.$site_sess->session_id,
      '%%%SID%%%',
      $data
    );

    @flock($fp, LOCK_EX);
    @fwrite($fp, $data);
    @flock($fp, LOCK_UN);
    @fclose($fp);

    if (defined('PRINT_CACHE_MESSAGES') && PRINT_CACHE_MESSAGES == 1) {
      echo "Cache file '$cache_id' <span style='color:red'>stored</span><br>";
    }

    return true;
  }

  @fclose($fp);

  return false;
}

function delete_cache_file($cache_id) {
  global $cache_enable, $cache_lifetime, $cache_path;

  if (defined('PRINT_CACHE_MESSAGES') && PRINT_CACHE_MESSAGES == 1) {
    echo "Cache file '$cache_id' <span style='color:red'>deleted</span><br>";
  }

  return @unlink($cache_path . '/' . $cache_id);
}

function delete_cache_group($group) {
  global $cache_enable, $cache_lifetime, $cache_path;

  $handle = @opendir($cache_path);

  while ($file = @readdir($handle)) {
    if (is_dir($file) || $file{0} == ".") {
      continue;
    }

    if (strpos($file, $group) === 0) {
      unlink($cache_path . '/' . $file);
    }
  }

  if (defined('PRINT_CACHE_MESSAGES') && PRINT_CACHE_MESSAGES == 1) {
    echo "Cache group '$group' <span style='color:red'>deleted</span><br>";
  }
}

function clear_cache() {
  global $cache_enable, $cache_lifetime, $cache_path;

  $handle = opendir($cache_path);

  while ($file = @readdir($handle)) {
    if (is_dir($file) || $file{0} == ".") {
      continue;
    }

    unlink($cache_path . '/' . $file);
  }
}

?>