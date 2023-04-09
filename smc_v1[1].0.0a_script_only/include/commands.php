<?

// general purpose commands

register_cmd('about');
register_cmd('connect');
register_cmd('zap');
register_cmd('cr');
register_cmd('drop');
register_cmd('savelog');
register_cmd('textin');
register_cmd('textout');
register_cmd('simul');
register_cmd('simulvars');
register_cmd('test');
register_cmd('php');
register_cmd('show');
register_cmd('showme');
register_cmd('quite');
register_cmd('ignore');
register_cmd('verbatium');
register_cmd('null');
register_cmd('prompt');
register_cmd('load');
register_cmd('info');
register_cmd('clear');
register_cmd('colors');
register_cmd('commands');
register_cmd('loop');
register_cmd('sql');

//================================================
// about
function cmd_about($params) {
    client_smcwrite('### SOLACE MUD CLIENT (SMC) v'.SMC_VERSION.' on PHP v'.phpversion().' ###');
    client_smcwrite('    For the latest version and helps visit http://solace.allnetwork.ru/smc.php');
    client_smcwrite('    Your IP is '.$GLOBALS['remote_ip'].' host '.$GLOBALS['remote_host'].' port '.$GLOBALS['remote_port']);
    if ($GLOBALS['db_type'])
        client_smcwrite("    Database connection: ".$GLOBALS['db_types'][$GLOBALS['db_type']]." v$GLOBALS[db_version] on host $GLOBALS[db_host], base $GLOBALS[db_name] (".count($GLOBALS['db_tables'])." table(s)), user $GLOBALS[db_user]");
    client_smcwrite('');
}

//================================================
// connect to mud
function cmd_connect($params) {
    if ($GLOBALS['mud_connected']) {
        client_smcwrite('You are already connected, terminate this connection first');
        return;
    }
    mud_connection($params);
    if ($GLOBALS['mud_connected']) call_events('onconnect');
}

//================================================
// zap (terminate connection with mud)
function cmd_zap($params) {
    if (!$GLOBALS['mud_connected']) {
        client_smcwrite('No connection to terminate');
        return;
    }
    mud_close();
    call_events('ondisconnect');
    client_smcwrite('### Connection terminated by user ###');
    $GLOBALS['mud_connected'] = false;
}

//================================================
// send carriage return to mud
function cmd_cr($params) {
    mud_writeln('');
}

//================================================
// drops the current line from mud
function cmd_drop($params) {
    $GLOBALS['out_cline'] = false;
}

//================================================
// log saving
function cmd_savelog($params) {
    global $log;
    if (!$params) return;
    if (strlen($log) == 0) {
        client_smcwrite("Nothing to save.");
        return;
    }
    //client_smcwrite("Command savelog with params: $params");
    $p = explode(' ', strtolower($params));
    if (in_array('append', $p)) $mode = 'a'; else $mode = 'w';
    $spl = "\n";
    if (in_array('cr', $p)) $spl = "\r"; else
    if (in_array('crlf', $p)) $spl = "\r\n";
    if ($spl <> "\n") $l = str_replace("\n", $spl, $log); else $l = $log;
    if (in_array('html', $p)) {
        if ($mode == 'a') {
            client_smcwrite("Can't append in html format");
            return;
        }
        foreach ($GLOBALS['colors_a'] as $ansi => $color)
            $l = str_replace($ansi, "<font color=$color>", $l);
        $l = str_replace('  ', '&nbsp; ', $l); 
        $l = str_replace('  ', '&nbsp; ', $l);
        $l = str_replace("\n ", "\n&nbsp;", $l); 
        $l = nl2br($GLOBALS['log_html_header'].$l.$GLOBALS['log_html_footer']);
    } else
        if (!in_array('ansi', $p)) $l = remove_ansi($l);
    $fname = parse_vars($p[0]);
    $fname = str_replace('%d', date('d'), $fname);
    $fname = str_replace('%m', date('m'), $fname);
    $fname = str_replace('%y', date('y'), $fname);
    $fname = str_replace('%h', date('H'), $fname);
    $fname = str_replace('%i', date('i'), $fname);
    $f = @fopen($fname, $mode);
    if ($f) {
        fwrite($f, $l);
        fclose($f);
        if (!in_array('noclear', $p)) $log = '';
        $mode = ($mode=='w'?'saved':'appended');
        client_smcwrite("Log successfuly $mode to $fname");
    } else
        client_smcwrite("Unable to access destination file $fname");
}

//================================================
// load and send text from file
function cmd_textin($params) {
    $p = explode(' ', $params);
    if ($f = @fopen($p[0], 'r')) {
        $s = fread($f, @filesize($p[0]));
        fclose($f);
        if (strlen($s) > 0) {
            $l = explode("\n", $s);
            foreach ($l as $s) mud_writeln($p[1].' '.$s);
        } else
        client_smcwrite('File is empty');
    } else
        client_smcwrite("Unable to access file $p[1]");
}

//================================================
// store text or variable in file
function cmd_textout($params) {
    $p = explode(' ', $params, 2);
    if ($f = @fopen($p[0], 'a')) {
        if (strpos($p[1], '$') !== false) $s = parse_vars(stripslashes($p[1])); else $s = $p[1];
        $s .= "\n\r";
        fwrite($f, $s);
        fclose($f);
        client_smcwrite("Done. ".strlen($s)." bytes was written to $p[1].");
    } else
        client_smcwrite("Unable to access file $p[0]");
}

//================================================
// simulate string or file from mud
function cmd_simul($params) {
    $p = explode(' ', $params);
    if (strtolower($p[0] == 'file')) {
        if ($f = @fopen($p[1], 'r')) {
            $s = fread($f, @filesize($p[1]));
            fclose($f);
            if (strlen($s) > 0) process_output($s);
        } else
            client_smcwrite("Unable to access file $p[1]");
    } else
        process_output($params);
}

//================================================
// simulate string with parsed vars from mud
function cmd_simulvars($params) {
    $params = parse_vars($params);
    $p = explode(' ', $params);
    if (strtolower($p[0] == 'file')) {
        if ($f = @fopen($p[1], 'r')) {
            $s = fread($f, @filesize($p[1]));
            fclose($f);
            if ($s) process_output($s);
        } else
            client_smcwrite("Unable to access file $p[1]");
    } else
        process_output($params);
}

//================================================
// test regular expression on text
function cmd_test($params) {
    global $freg;
    $p = nonbracketed_explode(' ', $params);
    trim_brackets($p);
    if (count($p) < 2) {
        client_smcwrite("Parameters expected: <{regexp}> <{text}>");
        return;
    }
    if (@$freg($p[0], $p[1], $regs)) {
        client_smcwrite("Found matching string \"$regs[0]\"");
        for ($i=1;$i<count($regs);$i++) client_smcwrite("reg[$i] = \"$regs[$i]\"");
    }
    else
        client_smcwrite("Not found");
}

//================================================
// execute php expression
function cmd_php($params) {
    global $vars;
    if (!$params) {
        client_smcwrite("Parameters expected: <php expression>");
        return;
    }
    @eval($params.';');
}

//================================================
// system display text (with variables)
function cmd_show($params) {
    global $vars;
    if (!strlen($params)) return;
    if (strpos($params, '$') !== false) {
        $l = parse_vars(stripslashes($params), true);
    } else
        @eval("\$l = \"$params\";");
    client_smcwrite("$l");
}

//================================================
// display colored text (with variables)
function cmd_showme($params) {
    global $vars;
    if (!strlen($params)) return;
    $p = nonbracketed_explode(' ', $params);
    trim_brackets($p);
    if (strpos($p[0], '$') !== false) {
        $l = parse_vars(stripslashes($p[0]), true);
    } else
        @eval("\$l = \"$p[0]\";");
    client_writeln(highlight($l, $p[1]));
}

//================================================
// turn on/off quite mode
function cmd_quite($params) {
    global $modes;
    $m = $modes['quite'];
    $p = explode(' ', strtolower($params));
    if (!$p[0]) {
        $m = 1 - $m;
    } else {
        if ($p[0] == 'on') $m = 1; else
        if ($p[0] == 'off') $m = 0;
    }
    $modes['quite'] = 0;
    client_smcwrite("Quite mode is ".($m?'ON':'OFF'));
    $modes['quite'] = $m;
}

//================================================
// turn on/off ignore mode for commands
function cmd_ignore($params) {
    global $ignore;
    $p = explode(' ', strtolower($params));
    if (!isset($ignore[$p[0]])) { //change all
        foreach ($ignore as $k => $v) {
            $m = $v;
            if (!$p[0]) $m = 1 - $m; else {
                if ($p[0] == 'on') $m = 1; else
                if ($p[0] == 'off') $m = 0;
            }
            $ignore[$k] = $m;
            client_smcwrite("Ignore $k is ".($m?'ON':'OFF'));
        }
    } else { // change one
        $m = $ignore[$p[0]];
        if (!$p[1]) $m = 1 - $m; else {
            if ($p[1] == 'on') $m = 1; else
            if ($p[1] == 'off') $m = 0;
        }
        $ignore[$p[0]] = $m;
        client_smcwrite("Ignore $p[0] is ".($m?'ON':'OFF'));
    }
}

//================================================
// turn on/off verbatium mode
function cmd_verbatium($params) {
    global $modes;
    $m = $modes['verbatium'];
    $p = explode(' ', strtolower($params));
    if (!$p[0]) {
        $m = 1 - $m;
    } else {
        if ($p[0] == 'on') $m = 1; else
        if ($p[0] == 'off') $m = 0;
    }
    client_smcwrite("Verbatium mode is ".($m?'ON':'OFF'));
    $modes['verbatium'] = $m;
}

//================================================
// null command, do nothing
function cmd_null($params) {
    return true;
}

//================================================
// define prompt action or trigger
function cmd_prompt($params) {
    global $prompt, $actions, $triggers;
    $p = explode(' ', strtolower($params));
    if (count($p) > 1)
        if (($p[0] == 'action') or ($p[0] == 'trigger') and is_numeric($p[1]))
            $prompt = $params;
    if ($prompt) client_smcwrite("The current prompt is $prompt");
    else client_smcwrite("Parameters expected: <action|trigger> <N>");
}

//================================================
// load profile
function cmd_load($params) {
    global $profile;
    if (!$params) {
        $d = dir('.');
        while($fn = $d->read())
        if (strpos($fn, '.'.$GLOBALS['profile_extension'])) {
            $a = explode('.', $fn);
            $profiles[] = $a[0];
        }
        $d->close();
        client_smcwrite("The current profile is $profile");
        $s = "Profiles in current directory:\n".implode("\n", $profiles);
        client_smcwrite($s);
        return;
    }
    if (load_profile($params)) {
        $profile = $params;
        client_smcwrite("The current profile is $profile");
    } else
        client_smcwrite("Unable to access profile $params");
}

//================================================
// show info
function cmd_info($params) {
    $s = '';
    $s .= sprintf("%4d variables\n", count($GLOBALS['vars']));
    $s .= sprintf("%4d aliases\n", count($GLOBALS['aliases']));
    $s .= sprintf("%4d actions\n", count($GLOBALS['actions']));
    $s .= sprintf("%4d triggers\n", count($GLOBALS['triggers']));
    $s .= sprintf("%4d substitutions\n", count($GLOBALS['subs']));
    $s .= sprintf("%4d highlights\n", count($GLOBALS['highlights']));
    $s .= sprintf("%4d gags\n", count($GLOBALS['gags']));
    if (count($GLOBALS['plugins'])) {
        $s .= sprintf("%4d plugins loaded:\n", count($GLOBALS['plugins']));
        foreach ($GLOBALS['plugins'] as $name => $fname) $s .= sprintf("       %s (in %s)\n", $name, basename($fname));
    }
    client_smcwrite("Currently defined:\n".$s);
    $s = '';
    $s .= sprintf("     KBytes sent: %1.2f K\n", $GLOBALS['out_bytes']/1024);
    $s .= sprintf(" KBytes received: %1.2f K\n", $GLOBALS['in_bytes']/1024);
    $s .= sprintf("     Time online: %02d:%02d:%02d\n", $GLOBALS['ticks']/3600, $GLOBALS['ticks']%3600/60, $GLOBALS['ticks']%60);
    client_smcwrite("Connection statistics:\n".$s);
}

//================================================
// clearings
function cmd_clear($params) {
    $a = array (
        'vars' => 'variables',
        'aliases' => 'aliases',
        'hls' => 'highlights',
        'actions' => 'actions',
        'triggers' => 'triggers',
        'subs' => 'substituons',
        'gags' => 'gags',
        'all' => 'all definitions'
    );
    $params = strtolower(trim($params));
    if (array_key_exists($params, $a)) {
        if ($params <> 'all') {
            $GLOBALS[$params] = array();
        } else {
            $b = array_keys($a);
            for($i=0;$i<count($b)-1;$i++) $GLOBALS[$b[$i]] = array();
        }
        client_smcwrite('Clearing '.$a[$params]);
    } else
        client_smcwrite("Parameter expected: ".implode(',', array_keys($a)));
}

//================================================
// show all colors
function cmd_colors($params) {
    global $colors_c, $colors_a;
    $defc = $colors_a[$colors_c['default']];
    foreach ($colors_c as $name => $ansi)
    if ($name <> 'default') {
        //if ($params and (strpos($name, $params) === false)) continue;
        if ($s) $s .= "\n"; 
        if ($name <> $defc)
            $s .= highlight(sprintf("%12s ", $name), $name);
        else
            $s .= highlight(sprintf("%12s   default", $name), $name);
    }
    client_smcwrite("Available colors:\n$s");
}

//================================================
// display all commands
function cmd_commands($params) {
    global $commands;
    $s = '';
    $c = $commands; sort($c);
    foreach ($c as $k => $cmd) {
        if ($params and (strpos($name, $params) === false)) continue;
        if (!($i++%5) and $s) $s .= "\n"; 
        $s .= sprintf('%12s', $cmd);
    }
    client_smcwrite("Available commands:\n$s");
}

//================================================
// loop command
function cmd_loop($params) {
    global $vars;
    if (!$params) return;
    $p = explode(' ', $params, 2);
    // array loop
    if (($p[0][0] == '$') and (strlen($p[1]) > 0)) {
        foreach ($vars as $name => $value) @eval("\$$name = \"$value\";");
        $arr = str_replace('$', '', $p[0]);
        if (is_array($$arr)) {
            foreach($$arr as $k => $v) {
                $cmd = str_replace('%0', $k, $p[1]);
                $cmd = str_replace('%1', $v, $cmd);
                process_input($cmd, true);
            }
        } else
            client_smcwrite("No array with name $arr found.");
        return;
    }
    // indexed loop
    $p = explode(' ', $params, 3);
    if (is_numeric($p[0]) and is_numeric($p[1]) and (strlen($p[2]) > 0)) {
        $from = ceil($p[0]);
        $to = ceil($p[1]);
        if ($from > $to)
            client_smcwrite('FROM index must be greater then TO index');
        else
        for ($i=$from;$i<=$to;$i++) {
            $cmd = str_replace('%0', "$i", $p[2]);
            process_input($cmd, true);
        }
    } else
        client_smcwrite("Parameters expected: !loop <from> <to> <command> or !loop <array_name> <command>");
}

//================================================
// perform SQL query
function cmd_sql($params) {
    global $db_type, $q;
    if (!$db_type) {
        client_smcwrite('No database support detected.');
        return;
    }
    $time_start = getmicrotime();
    $qid = $q->query($params);
    $time_end = getmicrotime();
    $t = $time_end - $time_start;
    $t = sprintf('%1.2f', $t);
    if ($qid === false) return;
    if (!is_resource($qid)) {
        $r = $q->affected_rows();
        client_smcwrite("Query OK, $r rows affected ($t sec)");
    } else {
        $r = sqlprint($q);
        foreach ($r as $s) client_smcwrite($s);
        $r = $q->num_rows();
        client_smcwrite("Query OK, $r rows in set ($t sec)");
    }
}


?>