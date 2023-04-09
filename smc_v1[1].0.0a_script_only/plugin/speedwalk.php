<?

/***********************************************
    Solace MUD Client (SMC)
    Author: Ilya Zubov
    E-Mail: solace@ezmail.ru
            zilav@allnetwork.ru
    Web: http://solace.allnetwork.ru/smc.php

    Plugin Speedwalk
    Author: Ilya Zubov
    E-Mail: solace@ezmail.ru
            zilav@allnetwork.ru
    Web: http://solace.allnetwork.ru/smc.php
************************************************/

// This version works only for 6 directions: NSWEUD


// set messages that abort speedwalking (MUD specific)
$sw_abort[] = "Alas, you cannot go that way.";
$sw_abort[] = "No way! You are still fighting!";

// set reserved commands that shouldn't be treated as speedwalk
$sw_reserved[] = 'new';
$sw_reserved[] = 'ne';
$sw_reserved[] = 'nw';
$sw_reserved[] = 'se';
$sw_reserved[] = 'sw';

$sw_path = '';

register_event('sw_onstart', 'onstart');
register_event('sw_ontimer', 'ontimer');
register_event('sw_onprompt', 'onprompt');
register_event('sw_oninput', 'oninput');
register_cmd('speedwalk');

//================================================
// decode speedwalk string
function speedwalk_decode($l = '') {
    $ii = 0;
    for ($i=0;$i<strlen($l);$i++) {
        if (is_numeric($l[$i])) continue;
        else {
            $w = substr($l, $ii, $i-$ii+1);
            if (strlen($w) > 1) $w = str_repeat($w[strlen($w)-1], substr($w, 0, strlen($w)-1));
            $way .= $w;
            $ii = $i+1;
        }
    }
    return $way;
}

    //echo speedwalk_decode('2w');
    //exit;

//================================================
// encode path string
function speedwalk_encode($l = '') {
    if (strlen($l) < 2) return $l;
    $cnt = 1;
    $char = $l[0];
    for ($i=1;$i<strlen($l);$i++) {
        if ($l[$i] == $char) $cnt++;
        else {
            if ($cnt == 1) $way .= $char; else $way .= $cnt.$char;
            $char = $l[$i];
            $cnt = 1;
        }
    }
    if ($cnt == 1) $way .= $char; else $way .= $cnt.$char;
    return $way;
}

//================================================
// command toggle speedwalk on/off
function cmd_speedwalk($params) {
    global $vars, $sw_path;
    $p = explode(' ', strtolower($params));
    if (!$p[0]) {
        $vars['speedwalk_on'] = 1 - $vars['speedwalk_on'];
    } else {
        if ($p[0] == 'on') $vars['speedwalk_on'] = 1; else
        if ($p[0] == 'off') $vars['speedwalk_on'] = 0;
    }
    if (!$vars['speedwalk_on']) $sw_path = '';
    client_smcwrite("Speedwalk mode is ".($vars['speedwalk_on']?'ON':'OFF'));
}

//================================================
// event on timer
function sw_ontimer($ticks) {
    global $vars, $sw_path;
    if (!$vars['speedwalk_on']) $sw_path = '';
    if (!$sw_path) return;
    $step = substr($sw_path, 0, $vars['speedwalk_stepsize']);
    if (strlen($sw_path) >= $vars['speedwalk_stepsize'])
        $sw_path = substr($sw_path, $vars['speedwalk_stepsize']);
    else
        $sw_path = '';
    if ($step) {
        client_smcwrite("Speedwalking $step...");
        for ($i=0;$i<strlen($step);$i++) mud_writeln($step[$i]);
    }
    if (!$sw_path) client_smcwrite("Speedwalk completed");

}

//================================================
// event on user's input
function sw_oninput($l) {
    global $vars, $in_line, $freg, $sw_reserved, $sw_path;
    if (!$GLOBALS['mud_connected']) return;
    $len = strlen($l);
    if ($len < 2) return;
    $l = strtolower($l);
    if (!is_numeric($l) and @$freg('[0-9wensud]{'.$len.'}', $l) and !in_array($l, $sw_reserved)) {
        $sw_path = speedwalk_decode($l);
        $in_line = false;
    }
}

//================================================
// event on prompt (check for abort)
function sw_onprompt($l) {
    global $sw_path, $sw_abort;
    //to_log($l);
    if (!$sw_path) return;
    if (is_array($sw_abort))
    foreach ($sw_abort as $k => $s)
    if (strpos($l, $s) !== false) {
        $sw_path = '';
        client_smcwrite('Speedwalk ABORTED!');
        return;
    }
}

//================================================
// event to initialize vars
function sw_onstart($params) {
    global $vars;
    if (!isset($vars['speedwalk_on'])) $vars['speedwalk_on'] = 1;
    if (!isset($vars['speedwalk_stepsize'])) $vars['speedwalk_stepsize'] = 3;
}


?>