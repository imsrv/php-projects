<?

// gameplay commands

register_cmd('var');
register_cmd('vars');
register_cmd('alias');
register_cmd('aliases');
register_cmd('hl');
register_cmd('hls');
register_cmd('trigger');
register_cmd('triggers');
register_cmd('action');
register_cmd('actions');
register_cmd('sub');
register_cmd('subs');
register_cmd('gag');
register_cmd('gags');

//================================================
// define variable
function cmd_var($params) {
    global $vars, $float_format, $varnameformat;
    $p = explode(' ', $params, 2);
    if (!$p[0]) {
        client_smcwrite("Parameters expected: <name> [value]");
        return;
    }
    $p[0] = str_replace('$', '', $p[0]); // remove $ from var's name
    if (is_numeric($p[0]) and is_array($vars)) {
        $a = array_keys($vars);
        $p[0] = $a[$p[0]-1];
    }
        else if (!$p[0]) $p[0] = '';
    if ($p[1] == '') {
        if (isset($vars[$p[0]])) {
            delete_var($p[0]);
            client_smcwrite("Variable $p[0] removed");
        } else   
            client_smcwrite("No variable $p[0]");
    } else {
        $l = parse_vars($p[1], true);
        if (is_float($l)) $l = sprintf($float_format, $l);
        $vars[$p[0]] = $l;
        ksort($vars);
        client_smcwrite("$p[0] = $l");
    }
}

//================================================
// display all variables
function cmd_vars($params) {
    global $vars;
    if (!count($vars)) {
        client_smcwrite("No variables defined");
        return;
    }
    ksort($vars);
    $s = '';
    foreach ($vars as $name => $value) {
        $i++;
        if ($params and (strpos($name, $params) === false)) continue;
        if ($s) $s .= "\n"; 
        $s .= sprintf("%3d %s = %s", $i, $name, $value);
    }
    client_smcwrite("Defined variables:\n$s");
}

//================================================
// define alias
function cmd_alias($params) {
    global $vars, $aliases;
    if (!$params) {
        client_smcwrite("Parameters expected: <{name}> [{value}]");
        return;
    }
    $p = nonbracketed_explode(' ', stripslashes($params));
    trim_brackets($p);
    if (!$p[0]) {
        client_smcwrite("Invalid expression");
        return;
    }
    // define or redefine
    if (count($p) > 1) {
        $aliases[$p[0]] = $p[1];
        ksort($aliases);
        client_smcwrite("$p[0] now aliases $p[1]");
    } else {
        // no value -> remove alias if exists
        if (isset($aliases[$p[0]])) {
            $aliases = del_array($aliases, $p[0]);
            client_smcwrite("Alias $p[0] removed");
        } else
            client_smcwrite("No alias found for $p[0]");
    }
}

//================================================
// display all aliases
function cmd_aliases($params) {
    global $aliases;
    if (!count($aliases)) {
        client_smcwrite("No aliases defined");
        return;
    }
    $s = '';
    foreach ($aliases as $name => $value) {
        if ($params and (strpos($name, $params) === false)) continue;
        if ($s) $s .= "\n"; 
        $s .= sprintf('   {%s} aliases {%s}', $name, $value);
    }
    client_smcwrite("Defined aliases:\n$s");
}

//================================================
// define highlight
function cmd_hl($params) {
    global $highlights;
    if (!$params) {
        client_smcwrite("Parameters expected: <{regexp}> <color1> [color2]");
        return;
    }
    $p = nonbracketed_explode(' ', $params);
    trim_brackets($p);
    if (!$p[0]) {
        client_smcwrite("Invalid expression");
        return;
    }
    if (is_numeric($p[0]) and is_array($highlights)) {
        $a = array_keys($highlights);
        $p[0] = $a[$p[0]-1];
    }
        else if (!$p[0]) $p[0] = '';
    // define or redefine
    if (count($p) > 1) {
        $highlights[$p[0]] = array($p[1], $p[2]);//addslashes($p[1]);
        ksort($highlights);
        client_smcwrite('{'.$p[0].'} now highlighted '.$p[1].' '.$p[2]);
    } else {
        // no value -> remove highlight if exists
        if (isset($highlights[$p[0]])) {
            $highlights = del_array($highlights, $p[0]);
            client_smcwrite('Highlight {'.$p[0].'} removed');
        } else
            client_smcwrite('No highlight found for {'.$p[0].'}');
    }
}

//================================================
// display all highlights
function cmd_hls($params) {
    global $highlights, $colors_c;
    if (!count($highlights)) {
        client_smcwrite("No highlights defined");
        return;
    }
    $s = '';
    foreach ($highlights as $name => $value) {
        //if ($params and (strpos($name, $params) === false)) continue;
        if ($s) $s .= "\n"; 
        $ss = '{'.$name.'} highlighted '.highlight($value[0], $value[0], CMD_COLOR).' '.highlight($value[1], $value[1], CMD_COLOR);
        $s .= sprintf("%3d %s", ++$i, $ss);
    }
    client_smcwrite("Defined highlights:\n$s");
}

//================================================
// define triggers
function cmd_trigger($params) {
    global $vars, $triggers;
    if (!$params) {
        client_smcwrite("Parameters expected: <{regexp}> [{command}]");
        return;
    }
    $p = nonbracketed_explode(' ', $params);
    trim_brackets($p);
    if (!$p[0]) {
        client_smcwrite("Invalid expression");
        return;
    }
    if (is_numeric($p[0]) and is_array($triggers)) {
        $a = array_keys($triggers);
        $p[0] = $a[$p[0]-1];
    }
        else if (!$p[0]) $p[0] = '';
    // define or redefine
    if (count($p) > 1) {
        $p[2] = (strtolower($p[2]) == 'block'?1:0);
        $triggers[$p[0]] = array ($p[1], $p[2]);
        //ksort($triggers);
        client_smcwrite('{'.$p[0].'} now triggers {'.$p[1].'}');
    } else {
        if (isset($triggers[$p[0]])) {
            $triggers = del_array($triggers, $p[0]);
            client_smcwrite('Trigger {'.$p[0].'} removed');
        } else
            client_smcwrite('No trigger found for {'.$p[0].'}');
    }
}

//================================================
// display all triggers
function cmd_triggers($params) {
    global $triggers, $cmd_color;
    if (!count($triggers)) {
        client_smcwrite('No triggers defined');
        return;
    }
    $s = '';
    foreach ($triggers as $name => $value) {
        $i++;
        if ($params and (strpos($name, $params) === false)) continue;
        if ($s) $s .= "\n"; 
        $s .= sprintf('%3d %s {%s} triggers {%s}', $i, ($value[1]?'[BLOCK]':''), $name,  $value[0]);
    }
    client_smcwrite("Defined triggers:\n$s");
}

//================================================
// define actions
function cmd_action($params) {
    global $vars, $actions;
    if (!$params) {
        client_smcwrite("Parameters expected: <{string with vars}> [{command}]");
        return;
    }
    $p = nonbracketed_explode(' ', $params);
    trim_brackets($p);
    if (!$p[0]) {
        client_smcwrite("Invalid expression");
        return;
    }
    if (is_numeric($p[0]) and is_array($actions)) {
        $a = array_keys($actions);
        $p[0] = $a[$p[0]-1];
    }
        else if (!$p[0]) $p[0] = '';
    // define or redefine
    if (count($p) > 1) {
        $actions[$p[0]] = $p[1];
        //ksort($actions);
        client_smcwrite('{'.$p[0].'} now actions {'.$p[1].'}');
    } else {
        if (isset($actions[$p[0]])) {
            $actions = del_array($actions, $p[0]);
            client_smcwrite('Action {'.$p[0].'} removed');
        } else
            client_smcwrite('No action found for {'.$p[0].'}');
    }
}

//================================================
// display all actions
function cmd_actions($params) {
    global $actions;
    if (!count($actions)) {
        client_smcwrite("No actions defined");
        return;
    }
    $s = '';
    foreach ($actions as $name => $value) {
        $i++;
        if ($params and (strpos($name, $params) === false)) continue;
        if ($s) $s .= "\n"; 
        $s .= sprintf('%3d {%s} actions {%s}', $i, $name, $value);
        //$s .= stripslashes(sprintf('%3d {%s} actions {%s}', $i, $name, $value));
    }
    client_smcwrite("Defined actions:\n$s");
}

//================================================
// define subs
function cmd_sub($params) {
    global $vars, $subs;
    if (!$params) {
        client_smcwrite("Parameters expected: <{string with vars}> [{replacement with vars}] [later]");
        return;
    }
    $p = nonbracketed_explode(' ', $params);
    trim_brackets($p);
    if (!$p[0]) {
        client_smcwrite("Invalid expression");
        return;
    }
    if (is_numeric($p[0]) and is_array($subs)) {
        $a = array_keys($subs);
        $p[0] = $a[$p[0]-1];
    }
        else if (!$p[0]) $p[0] = '';
    // define or redefine
    if (count($p) > 1) {
        $p[2] = (strtolower($p[2]) == 'later'?1:0);
        $subs[$p[0]] = array ($p[1], $p[2]);
        //ksort($subs);
        client_smcwrite('{'.$p[0].'} now replaced with {'.$p[1].'}');
    } else {
        if (isset($subs[$p[0]])) {
            $subs = del_array($subs, $p[0]);
            client_smcwrite('Substitution {'.$p[0].'} removed');
        } else
            client_smcwrite('No substitution found for {'.$p[0].'}');
    }
}

//================================================
// display all subs
function cmd_subs($params) {
    global $subs, $cmd_color;
    if (!count($subs)) {
        client_smcwrite('No substitutions defined');
        return;
    }
    $s = '';
    foreach ($subs as $name => $value) {
        $i++;
        if ($params and (strpos($name, $params) === false)) continue;
        if ($s) $s .= "\n"; 
        $s .= sprintf('%3d %s {%s} replaced with {%s}', $i, ($value[1]?'[LATER]':''), $name, $value[0]);
    }
    client_smcwrite("Defined substitutions:\n$s");
}

//================================================
// define gag
function cmd_gag($params) {
    global $gags;
    if (!$params) {
        client_smcwrite("Parameters expected: <{regexp}> <vis|hiddden> [vis|hidden]");
        return;
    }
    $p = nonbracketed_explode(' ', $params);
    trim_brackets($p);
    if (!$p[0]) {
        client_smcwrite("Invalid expression");
        return;
    }
    if (is_numeric($p[0]) and is_array($gags)) {
        $a = array_keys($gags);
        $p[0] = $a[$p[0]-1];
    }
        else if (!$p[0]) $p[0] = '';
    // define or redefine
    if (count($p) > 1) {
        if (!in_array(strtolower($p[1]), array('vis', 'hidden'))) $p[1] = 'hidden';
        if (!in_array(strtolower($p[2]), array('vis', 'hidden'))) $p[2] = 'vis';
        $gags[$p[0]] = array($p[1], $p[2]);
        client_smcwrite('{'.$p[0].'} hides as '.$p[1].' '.$p[2]);
    } else {
        if (isset($gags[$p[0]])) {
            $gags = del_array($gags, $p[0]);
            client_smcwrite('Gag {'.$p[0].'} removed');
        } else
            client_smcwrite('No gag found for {'.$p[0].'}');
    }
}

//================================================
// display all gags
function cmd_gags($params) {
    global $gags;
    if (!count($gags)) {
        client_smcwrite("No gags defined");
        return;
    }
    $s = '';
    foreach ($gags as $name => $value) {
        $i++;
        if ($params and (strpos($name, $params) === false)) continue;
        if ($s) $s .= "\n"; 
        $s .= sprintf('%3d {%s} hides as %s %s', $i, $name, $value[0], $value[1]);
    }
    client_smcwrite("Defined gags:\n$s");
}



?>