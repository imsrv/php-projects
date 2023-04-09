<?

  function tpl ($template)
  {
    if (file_exists ('tpl/' . $template . '.html'))
    {
      include 'tpl/' . $template . '.html';
    }

  }

  function logfile ()
  {
    global $link_url;
    global $config;
    if ($config['log'] == 1)
    {
      $fp = fopen ('log/logfile.txt', 'a');
      fwrite ($fp, 'Forwarded to: ' . $link_url . ' - IP of User: ' . $_SERVER['REMOTE_ADDR'] . ' - Referrer: ' . $_SERVER['HTTP_REFERER'] . ' - User Agent: ' . $_SERVER['HTTP_USER_AGENT'] . '
');
      fclose ($fp);
    }

  }

  $config['prcl'] = 'http';
  $config['time'] = 5;
  $config['log'] = 1;
  $link_url = $_SERVER['QUERY_STRING'];
  if ($link_url != '')
  {
    if (substr ($link_url, 0, 7) != 'http://')
    {
      $link_url = $config['prcl'] . '://' . $link_url;
    }

    $link_head = $link_url;
    $link_time = $config['time'];
    logfile ();
    tpl ('page_redirect');
    exit ();
  }

  tpl ('page');
  exit ();
?>
