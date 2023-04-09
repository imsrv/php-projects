<?

/***********************************************
    Solace MUD Client (SMC)
    Author: Ilya Zubov
    E-Mail: solace@ezmail.ru
            zilav@allnetwork.ru
    Web: http://solace.allnetwork.ru/smc.php

    Plugin Affects v1.0
    Author: Ilya Zubov
    E-Mail: solace@ezmail.ru
            zilav@allnetwork.ru
    Web: http://solace.allnetwork.ru/smc.php
************************************************/

// This plugin is MUD specific. If you are not playing Solace, you MUST modify it
// yourself. Almost every MUD has its own syntax in affects list, dispelling and
// others, so it is rather hard to make this plugin universal.

$affects = array();

register_event('affects_onstart', 'onstart');
register_event('affects_onprompt', 'onprompt');
register_cmd('affects');

//================================================
// load affects
function load_affects($fname) {
    global $affects;
    if ($f = fopen('affects', 'r+')) {
        $l = fread($f, 65535);
        fclose($f);
        $affects = array();
    } else
        return false;
    $b = explode('#', $l);
    if (!is_array($b)) exit;
    foreach ($b as $l) {
        $a = explode("\n", $l);
        $pr = 9;
        if (is_array($a))
        foreach ($a as $l) {
            $l = trim($l);
            if (!$name) $name = strtolower($l);
            $c = explode(' ', $l, 2);
            switch (strtolower($c[0])) {
                case 'type': if (eregi('(spell|song|skill)', $c[1])) $type = strtolower($c[1]); else $type = 'spell'; break;
                case 'priority' : if (is_numeric($c[1]) and ($c[1]>0) and ($c[1]<10)) $pr = $c[1]; break;
                case 'cmd' : $cmd = $c[1]; break;
                case 'on'  : if ($on) $on .= '|'.$c[1]; else $on = $c[1]; break;
                case 'off' : if ($off) $off .= '|'.$c[1]; else $off = $c[1]; break;
            }
            if (!$cmd)
                switch ($type) {
                    case 'spell': $cmd = "cast '$name'"; break;
                    case 'song' : $cmd = "sing '$name'"; break;
                    case 'skill': $cmd = $name; break;
                }
        }
        if ($name and $type) {
            $affects[$name]['active'] = 0;
            $affects[$name]['type'] = $type;
            $affects[$name]['priority'] = $pr;
            $affects[$name]['cmd'] = $cmd;
            if ($on) $affects[$name]['on'] = "($on)";
            if ($off) $affects[$name]['off'] = "($off)";
        }
        $name = ''; $type = ''; $cmd = ''; $on = ''; $off = '';
    }
    return true;
}

//================================================
// command affects
function cmd_affects($params) {
    global $affects;
    if (!is_array($affects)) {
        client_smcwrite('No affects defined');
        return;
    }
    $p = explode(' ', strtolower($params));
    switch ($p[0]) {
        case 'load':
            if (load_affects($p[1]))
                client_smcwrite('Affects loaded. Total '.count($affects).' affects');
            break;
        case 'clear':
            foreach ($affects as $name => $v)
                $affects[$name]['active'] = 0;
            client_smcwrite("Affects cleared.");
            break;
        case 'list':
            foreach ($affects as $name => $v) {
                $s .= ucfirst($v['type']). " $name:\n";
                $s .= ' priority: '.$v['priority']."\n";
                $s .= '  command: '.$v['cmd']."\n";
                $s .= '       on: '.trim($v['on'], '()')."\n";
                $s .= '      off: '.trim($v['off'], '()')."\n\n";
            }
            client_smcwrite("Defined affects:\n".$s);
            break;
        case 'need':
            foreach ($affects as $name => $v)
                if (!$v['active']) $s .= ucfirst($v['type'])." $name\n";
            client_smcwrite("The following affects are absent:\n".$s);
            break;
        case 'up':
            $pr = ((is_numeric($p[1]) and ($p[1]>0) and ($p[1]<10))?$p[1]:9);
            foreach ($affects as $name => $v)
                if (!$v['active'] and ($v['priority'] <= $pr)) {
                    if ($s) $s .= $GLOBALS['cmd_delimiter'];
                    $s .= $v['cmd'];
                }
            process_input($s, true);
            break;
        default:
            $act = 0;
            foreach ($affects as $name => $v)
                if ($v['active']) {
                    $s .= ucfirst($v['type'])." $name\n";
                    $act++;
                }
            client_smcwrite("You are currently under $act/".count($affects)." affects:\n".$s);
            break;
    }
}

//================================================
// event on prompt
function affects_onprompt($l) {
    global $affects;
    if (!is_array($affects)) return;
    // affects list
    if (strpos($l, 'You are affected by') !== false) {
        foreach ($affects as $name => $v) {
            if (strpos($l, ucfirst($v['type'])." $name modifies") !== false) $affects[$name]['active'] = 1;
                else $affects[$name]['active'] = 0;
        }
    }
    // dispell
    if (ereg('Spell (.+) unravels', $l, $regs)) {
        if (array_key_exists($regs[1], $affects)) $affects[$regs[1]]['active'] = 0;
    }
    // on/off
    foreach ($affects as $name => $v) {
        if (ereg($v['on'], $l)) $affects[$name]['active'] = 1; else
        if (ereg($v['off'], $l)) $affects[$name]['active'] = 0;
    }
}

//================================================
// event to initialize vars
function affects_onstart($params) {
    load_affects('affects');
}

//affects_onstart($params);
//print_r($affects); exit;

?>