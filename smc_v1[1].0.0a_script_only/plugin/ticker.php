<?

/***********************************************
    Solace MUD Client (SMC)
    Author: Ilya Zubov
    E-Mail: solace@ezmail.ru
            zilav@allnetwork.ru
    Web: http://solace.allnetwork.ru/smc.php

    Plugin Ticker
    Author: Ilya Zubov
    E-Mail: solace@ezmail.ru
            zilav@allnetwork.ru
    Web: http://solace.allnetwork.ru/smc.php
************************************************/

// set messages that restart ticker (MUD specific)
$tick_clears[] = 'The night has begun';
$tick_clears[] = 'The day has begun';


register_event('ticker_ontimer', 'ontimer');
register_event('ticker_onconnect', 'onconnect');
register_event('ticker_onoutput', 'onoutput');
register_cmd('ticksize');
register_cmd('ticknotify');
register_cmd('tick');

//================================================
// command to set tick size
function cmd_ticksize($params) {
    global $vars;
    if (is_numeric($params) and ($params > 0)) {
        $vars['ticksize'] = $params;
        $vars['tickcount'] = $params;
    }
    client_smcwrite("The current ticksize is $vars[ticksize]");
}

//================================================
// command to set tick notification seconds
function cmd_ticknotify($params) {
    global $vars;
    if ($params <> '') $vars['ticknotify'] = $params;
    client_smcwrite("You will be notified on this seconds to tick: $vars[ticknotify]");
}

//================================================
// command to show seconds to tick;
// restart ticker ('start' parameter)
// stop ticker ('stop' parameter)
function cmd_tick($params) {
    global $vars;
    switch (strtolower(trim($params))) {
        case 'stop':
            $vars['tickcount'] = 'NA';
            client_smcwrite("Ticker stopped");
            break;
        case 'start':
            if (is_numeric($vars['ticksize']) and ($vars['ticksize'] > 0)) {
                $vars['tickcount'] = $vars['ticksize'];
                client_smcwrite("Ticker is restarting now");
            }
            break;
    }
    client_smcwrite("$vars[tickcount] seconds to TICK");
}

//================================================
// event on timer
function ticker_ontimer($ticks) {
    global $vars;
    if (!is_numeric($vars['tickcount'])) return;
    $vars['tickcount']--; // = abs($vars['tickcount']--);
    if ($vars['tickcount'] == 0) call_events('ontick');
    $a = explode(' ', $vars['ticknotify']);
    if (in_array($vars['tickcount'], $a)) {
        $s = "$vars[tickcount] seconds to TICK";
        process_output($s."\n");
    }
    if ($vars['tickcount'] == 0) {
        $vars['tickcount'] = $vars['ticksize'];
    }
}

//================================================
// event on prompt
function ticker_onoutput($block) {
    global $vars, $tick_clears;
    if (!is_numeric($vars['ticksize'])) return;
    for($i=0;$i<count($tick_clears);$i++)
        if (strpos($block, $tick_clears[$i]) !== false) {
            $vars['tickcount'] = $vars['ticksize'];
            return;
        }
}

//================================================
// event to initialize vars
function ticker_onconnect($ticks) {
    global $vars;
    $vars['tickcount'] = 'NA';
    if (!isset($vars['ticknotify'])) $vars['ticknotify'] = '-1';
    if (!is_numeric($vars['ticksize'])) $vars['ticksize'] = 'NA';
}


?>