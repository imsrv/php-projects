<?
include('include/vars.php');
include('include/misc.php');
include('include/commands.php');
include('include/commands2.php');
include('include/userfunc.php');

$fdr = socket_fd_alloc();
$fdz = socket_fd_alloc();

//================================================
function socket_canread($sock) {
    global $fdr, $fdz;
    socket_fd_set($fdr, $sock);
    socket_select($fdr, $fdz, $fdz, 0, 10);
    $r = socket_fd_isset($fdr, $sock);
    socket_fd_zero($fdr);
    socket_fd_zero($fdz);
    return $r;
}

//================================================
function sread($sock) {
    if (!$sock) return;
    $r = socket_canread($sock);
    if ($r) {
        $buf = @socket_read($sock, 2048);
        //to_log("buf=$buf");
    } else
        $buf = '';
    if ($r and !$buf) $buf = false;
    if ($buf !== false) $buf = ereg_replace("\xFF.\x01", '', $buf);
    return $buf;
}

//================================================
function swrite($sock, $s) {
    if (!$sock) return;
    $response = @socket_write($sock, $s, strlen($s));
    return $response;
}

//================================================
function sclose($sock) {
    if (!$sock) return;
    @socket_shutdown($sock);
    return @socket_close($sock);
}

//================================================
function mud_read() {
    global $s_client;
    return sread($s_client);
}

//================================================
function mud_write($s) {
    global $s_client;
    return swrite($s_client, $s);
}

//================================================
function mud_writeln($s) {
    return mud_write($s."\n");
}

//================================================
function mud_close() {
    return sclose($GLOBALS['s_client']);
}

//================================================
function client_read() {
    global $s_serv;
    return sread($s_serv);
}

//================================================
function client_write($s) {
    global $s_serv;
    return swrite($s_serv, $s);
}

//================================================
function client_close() {
    return sclose($GLOBALS['s_serv']);
}

//================================================
function client_bufwrite($s) {
    global $s_serv, $out;
    if ($GLOBALS['processing_out']) $out .= $s; else
    return client_write($s);
}

//================================================
function client_writeln($s) {
    return client_bufwrite($s."\n");
}

//================================================
function client_smcwrite($s) {
    global $modes;
    if ($modes['quite']) return;
    if ($GLOBALS['script_prefix'] <> '') {
         $s = str_replace("\n", "\n".$GLOBALS['script_prefix'], $s);
         $s = $GLOBALS['script_prefix'].rtrim($s);
    }
    client_writeln(highlight($s, $GLOBALS['cmd_color']));
}


//=============================================================
// load profile
function load_profile($pname) {
    $pname .= '.'.$GLOBALS['profile_extension'];
    if ($f = @fopen($pname, 'r')) {
        while (!feof($f)) {
            $l = fgets($f, 2048);
            if ($l[0] == $GLOBALS['cmd_prefix']) execute_cmd($l);
        }
        fclose($f);
        return true;
    } else
        return false;
}

//=============================================================
// save profile
function save_profile($pname) {
    global $brackets, $vars, $aliases, $highlights, $triggers, $actions, $subs, $gags;
    $pname .= '.'.$GLOBALS['profile_extension'];
    $b1 = $brackets[0];
    $b2 = $brackets[1];
    $pref = $GLOBALS['cmd_prefix'];
    if ($f = @fopen($pname, 'w')) {
        if (count($vars) > 0)
        foreach ($vars as $name => $value)
            if (strlen($value))
            fwrite($f, $pref."var $name '$value'\r\n");
        if (count($aliases) > 0)
        foreach ($aliases as $name => $value)
            fwrite($f, stripslashes($pref."alias $b1$name$b2 $b1$value$b2\r\n"));
        if (count($highlights) > 0)
        foreach ($highlights as $name => $value)
            fwrite($f, $pref."hl $b1$name$b2 $value[0] $value[1]\r\n");
        if (count($triggers) > 0)
        foreach ($triggers as $name => $value)
            fwrite($f, $pref."trigger $b1$name$b2 $b1$value[0]$b2 ".($value[1]?'block':'')."\r\n");
        if (count($actions) > 0)
        foreach ($actions as $name => $value)
            fwrite($f, $pref."action $b1$name$b2 $b1$value$b2\r\n");
        if (count($subs) > 0)
        if ($GLOBALS['prompt']) fwrite($f, $pref."prompt $GLOBALS[prompt]\r\n");
        foreach ($subs as $name => $value)
            fwrite($f, $pref."sub $b1$name$b2 $b1$value[0]$b2 ".($value[1]?'later':'')."\r\n");
        if (count($gags) > 0)
        foreach ($gags as $name => $value)
            fwrite($f, $pref."gag $b1$name$b2 $value[0] $value[1]\r\n");
        fclose($f);
    }
}

//=============================================================
// register command, return FALSE on error (already exists)
function register_cmd($cmdname) {
    global $commands;
    if (!in_array($cmdname, $commands)) {
        $commands[] = $cmdname;
        return true;
    } else
        return false;
}

//=============================================================
// register event function, return FALSE on error (already exists)
function register_event($funcname, $calltype) {
    global $funcs;
    if (!array_key_exists($funcname, $funcs)) {
        $funcs[$funcname] = $calltype;
        return true;
    } else
        return false;
}

//=============================================================
// call event function, return FALSE on error (already exists)
function call_events($calltype) {
    global $funcs, $ret, $ticks, $out_line, $out_cline, $in_line, $block;
    $params = false;
    switch ($calltype) {
        case 'ontimer': $params = $ticks; break;
        case 'online': $params = $out_line; break;
        case 'oncline': $params = $out_cline; break;
        case 'onprompt': $params = $block; break;
        case 'oninput': $params = $in_line; break;
        case 'onoutput': $params = $ret; break;
    }
    foreach ($funcs as $funcname => $ct)
    if ($calltype == $ct) {
        $funcname($params);
    }
}

//=============================================================
// initialize databases
function initialize_db($dbt) {
    global $q, $db_name, $db_tables, $db_version;
    switch ($dbt) {
        case 'mysql':
            $q->query('show databases');
            $c = true;
            while ($q->next_record()) if ($q->f(0) == $db_name) $c = false;
            if ($c) $q->query("create database $db_name");
            $q->query("use $db_name");
            $q->query('show tables');
            while ($q->next_record()) $db_tables[] = $q->f(0);
            $q->query('show variables');
            while ($q->next_record()) if ($q->f(0) == 'version') $db_version = $q->f(1);
        break;
        case 'mssql':
            $q->connect('master');
            $q->query('select name from dbo.sysdatabases');
            $c = true;
            while ($q->next_record()) if ($q->f(0) == $db_name) $c = false;
            if ($c) $q->query("create database $db_name");
            $q->query("use $db_name");
            $q->query('SELECT o.name FROM sysobjects o, sysindexes i WHERE o.sysstat & 0xf = 3 AND i.id = o.id AND i.indid < 2 AND o.name NOT LIKE "#%" ORDER BY o.name');
            while ($q->next_record()) $db_tables[] = $q->f(0);
        break;
    }
}

//=============================================================
// delete from array
function del_array($a, $key) {
    //if (in_array($key, $a)) {
        $b = array();
        foreach ($a as $k => $v) if ($k <> $key) $b[$k] = $v;
        return $b;
    //} else
    //    return $a;
}

//=============================================================
// highlight string with colors
function highlight($s, $c1, $c2 = '') {
    global $colors_c;
    if (!$c2 or !array_key_exists($c2, $colors_c)) $c2 = 'silver';
    return $colors_c[$c1].$s.$colors_c[$c2];
}

//=============================================================
// remove ANSI
function remove_ansi($s) {
    global $ansi_format;
    return ereg_replace($ansi_format, '', $s);
}

//=============================================================
// delete variable
function delete_var($v) {
    global $vars;
    $vars = del_array($vars, $v);
    ksort($vars);
}

//=============================================================
// explode string excepting quoted parts
function quote_explode($spl, $l, $limit = '') {
    //$a = explode($split, $l, $limit);
    if ($spl == '"') return false;
    if ($l[0] == '"') $i = 1; else $i = 0;
    $a = explode('"', $l);
    foreach ($a as $k => $s)
    if ($s) {
        if ($i++%2) $b[] = $s;
        else {
            $aa = explode($spl, trim($s, $spl));
            $b = array_merge($b, $aa);
        }
    }
    $a = array();
    for ($i=0;$i<count($b);$i++) if ($b[$i]) $a[] = $b[$i];
    return $a;
}

//=============================================================
// explode string excepting quoted parts
function nonquoted_explode($spl, $l, $quotes = '"') {
    $a = explode($spl, $l);
    $qn = substr_count($l, $quotes);
    if (!$qn) return $a;
    foreach($a as $k => $s) {
        if (!($n%2)) $b[] = $s;
            else $b[count($b)-1] .= $spl.$s;
        $n += substr_count($s, $quotes);
    }
    return $b;
}

//=============================================================
// explode string excepting bracketed parts
function nonbracketed_explode($spl, $l, $br = '') {
    global $brackets;
    if (!$br) $br = $brackets;
    $n = 0;
    $a = explode($spl, $l);
    foreach($a as $k => $s) {
        for ($i=0;$i<strlen($s);$i++) {
            if ($s[$i] == $br[0]) $n++; else
            if ($s[$i] == $br[1]) $n--;
        }
        $ss .= $spl.$s;
        if ($n == 0) {
            $b[] = trim($ss, $spl);
            $ss = '';
        }
    }
    if ($ss) $b[] = trim($ss, $spl);
    return $b;
}

//=============================================================
// trim brackets from array items or string
function trim_brackets(&$a, $br = '') {
    global $brackets;
    if (!$br) $br = $brackets;
    if (is_array($a))
        foreach($a as $k => $s) $a[$k] = trim($s, $br);
    else
        $a = ereg_replace('['.$br.']', '', $a);
    return $a;
}

//=============================================================
// parse all variables into string (and execute)
function parse_vars($s, $execute = false) {
    global $vars;
    if (count($vars) and (strpos($s, '$') !== false))
        foreach ($vars as $name => $value) @eval("\$$name = \"$value\";");
    if ($execute) $exec_str = "\$l = $s;"; else $exec_str = "\$l = \"$s\";";
    @eval($exec_str);
    return $l;
}

//=============================================================
// parse formatted string into vars
function parse_str_vars($s, $f) {
    global $varformat, $varvalue, $freg, $parsed_str;
    while (@$freg($varformat, $f, $v)) {
        $f = str_replace($v[0], str_replace('\$', '', "($varvalue)"), $f);
        $names[] = str_replace('$', '', $v[0]);
    }
    //echo "$s\n$f\n";
    //var_dump($names);
    //$s = stripslashes($s);
    if (ereg($f, $s, $v)) {
        $parsed_str = $v[0];
        for ($i=0;$i<count($names);$i++) $a[$names[$i]] = $v[$i+1];
        if (is_array($a)) return $a; else return true;
    } else
        return false;
}

?>