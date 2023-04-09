<?

//=============================================================
// execute command
function execute_cmd($cmd) {
    global $commands, $modes, $php_errormsg;
    if ($cmd[0] == $GLOBALS['cmd_prefix']) $cmd = substr($cmd, 1);
    if ($cmd[0] == $GLOBALS['cmd_quite']) {
        $m = $modes['quite'];
        $modes['quite'] = 1;
        $cmd = substr($cmd, 1);
    }
    $a = explode(' ', trim($cmd), 2);
    //to_log("command: $a[0], params: $a[1]");
    if (in_array($a[0], $commands)) {
        $fname = 'cmd_'.$a[0];
        @$fname($a[1]);
        if ($php_errormsg) {
            client_smcwrite(strip_tags($php_errormsg));
            $php_errormsg = false;
        }
    } else
    if (is_numeric($a[0])) {
        trim_brackets($a[1]);
        for($i=1;$i<=ceil($a[0]);$i++) process_input($a[1]);
    } else
        client_smcwrite("Unknown command $a[0]");
    if (isset($m)) $modes['quite'] = $m;
}

//=============================================================
// execute alias
function execute_alias($al) {
    global $aliases, $vars;
    $a = explode(' ', $al, 2);
    if (!array_key_exists($a[0], $aliases)) return false;
    //to_log("Alias $a[0] => $a[1]");
    $cmd = $aliases[$a[0]];
    if (!empty($a[1])) { // add arguments %0-%9
        $cmd = str_replace('%0', trim($a[1]), $cmd);
        $v = explode(' ', $a[1]);
        for ($i=1;$i<=count($v);$i++) $cmd = str_replace('%'.$i, $v[$i-1], $cmd);
    }
    process_input($cmd, true); // echoed process
    return true;
}

//=============================================================
// do highlights
function execute_highlight($l) {
    global $highlights, $freg;
    if (!count($highlights)) return $l;
    foreach ($highlights as $expr => $p) {
        $expr = parse_vars($expr);
        if ($expr)
        if (@$freg($expr, $l, $regs))
            $l = str_replace($regs[0], highlight($regs[0], $p[0], $p[1]), $l);
    }
    return $l;
}

//=============================================================
// do triggers
function execute_trigger($l, $onprompt, $prompt_n = 0) {
    global $vars, $triggers, $freg;
    if (!count($triggers)) return;
    $mode = ($onprompt == false?0:1);
    $pr = false;
    foreach ($triggers as $expr => $p) {
        $n++;
        if ($p[1] == $mode) {
            //if ($mode) to_log("block trigger: $expr");
            if (@$freg($expr, $l, $regs)) {
                for ($i=0;$i<count($regs);$i++) if ($regs[$i]) $vars["reg[$i]"] = $regs[$i];
                process_input($p[0], true);
                if ($prompt_n == $n) $pr = true;
            }
        }
    }
    return $pr;
}

//=============================================================
// do actions
function execute_action($l, $prompt_n = 0) {
    global $vars, $actions, $freg;
    if (!count($actions)) return;
    $pr = false;
    foreach ($actions as $expr => $p) {
        $n++;
        if ($v = parse_str_vars($l, $expr)) {
            if (is_array($v)) $vars = array_merge($vars, $v);
            process_input($p, true);
            if ($prompt_n == $n) $pr = true;
        }
    }
    return $pr;
}

//=============================================================
// do substitutions
function execute_substitution(&$l, $mode = 'after') {
    global $vars, $subs, $freg, $parsed_str;
    if (!count($subs)) return;
    $mode = ($mode == 'before'?0:1);
    foreach ($subs as $expr => $p)
    if ($p[1] == $mode) {
        if ($v = parse_str_vars($l, $expr)) {
            if (is_array($v)) $vars = array_merge($vars, $v);
            $l = str_replace($parsed_str, parse_vars($p[0]), $l);
            return true;
        }
    }
    return false;
}

//=============================================================
// do gags
function execute_gag($l) {
    global $modes, $gags, $freg;
    if (!count($gags)) return $l;
    foreach ($gags as $expr => $p) {
        $expr = parse_vars($expr);
        if (@$freg($expr, $l, $regs)) {
            if ($p[0] == 'hidden') $l = false;
            if ($p[1] == 'hidden') $modes['gag'] = 1; else $modes['gag'] = 0;
            break;
        }
    }
    return $l;
}

//=============================================================
// process all user input
function process_input($ret, $echoed = false) {
    global $modes, $log, $in_line, $aliases, $mud_connected;
    $in_line = trim($ret);
    $a = nonbracketed_explode($GLOBALS['cmd_delimiter'], $in_line);
    //if (is_array($a))
    foreach ($a as $k => $cmd) {
        $cmd = trim($cmd);
        if ($cmd[0] == $GLOBALS['cmd_prefix']) execute_cmd($cmd);
        else
        if (!execute_alias($cmd)) {
            if (!$modes['verbatium']) $cmd = parse_vars($cmd);
            $in_line = $cmd;
            call_events('oninput');
            if ($in_line === false) return;
            //to_log("user: $in_line");
            if ($echoed) client_smcwrite($in_line);
            if ($mud_connected) {
                mud_writeln($in_line);
                if ($GLOBALS['log_input']) $log .= $in_line."\n";
            } else
                client_smcwrite("You aren't connected");
        }
    }
}

//=============================================================
// process all MUD output
function process_output($ret) {
    global $ignore, $modes, $log, $out_cline, $out_line, $out, $block, $prompt, $flprompt;
    //to_log($ret);
    $GLOBALS['processing_out'] = 1;
    $out = '';
    $ret = str_replace("\r", '', $ret);
    $log .= $ret;
    if (strlen($log) > $GLOBALS['maxlogsize']) autosave_log();
    if ($ret[strlen($ret)] == "\n") $nl = true;
    $pr = explode(' ', $prompt);
    $lines = explode("\n", $ret);
    for ($i=0;$i<count($lines);$i++) {
        $out_cline = $lines[$i];
        if (!$ignore['subs']) execute_substitution($out_cline, 'before');
        $out_line = remove_ansi($out_cline);
        if (strlen($out_line) > 0) {
            if (!$ignore['triggers'])
                if (execute_trigger($out_line, false, $pr[1])) if ($pr[0] == 'trigger') $flprompt = true;
            if (!$ignore['actions'])
                if (execute_action($out_line, $pr[1])) if ($pr[0] == 'action') $flprompt = true;
        }
        //to_log("before: $out_cline");
        //to_log("after: $out_cline");
        if (!$ignore['subs']) execute_substitution($out_cline, 'after');
        $oldgag = $modes['gag'];
        if (!$ignore['gags']) $out_cline = execute_gag($out_cline);
        if (!$ignore['hls'] and !$modes['gag'] or !$oldgag) $out_cline = execute_highlight($out_cline);
        if ((!$modes['gag'] or !$oldgag) and ($out_cline !== false)) {
            $out .= $out_cline."\n";
            $block .= $out_cline."\n";
        }
        if ($flprompt) {
            $flprompt = false;
            $modes['gag'] = 0;
            execute_trigger($block, true);
            call_events('onprompt');
            //client_smcwrite('PROMPT!');
            $block = '';
            if ($i<>count($lines)-1) {
                client_write($out);
                $out = '';
            }
        }
    }
    if (strlen($block) > 65535) $block = ''; // overflow check
    if (!$nl) $out = substr($out, 0, strlen($out)-1);
    call_events('onoutput');
    $GLOBALS['processing_out'] = 0;
    client_write($out);
}



?>