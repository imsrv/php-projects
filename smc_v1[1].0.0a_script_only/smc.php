#!/usr/bin/php -q
<?

/***********************************************
    Solace MUD Client (SMC)
    Author: Ilya Zubov
    E-Mail: solace@ezmail.ru
            zilav@allnetwork.ru
    Web: http://solace.allnetwork.ru/smc.php
************************************************/

include('include/func.php');
include('include/parser.php');

//=============================================================
// shutdown script function
function shutdown() {
    autosave_log();
    if ($GLOBALS['s_serv']) @socket_close($GLOBALS['s_serv']);
    if ($GLOBALS['s_serv_listen']) @socket_close($GLOBALS['s_serv_listen']);
    if ($GLOBALS['s_client']) @socket_close($GLOBALS['s_client']);
    save_profile($GLOBALS['profile']);
    echo "End of work.\n"; flush();
}

//=============================================================
// error handler function
function SMCErrorHandler ($errno, $errstr, $errfile, $errline) {
    $s = '';
    //echo $errstr;
    switch ($errno) {
        case E_PARSE: $s = 'Parse error'; break;
        case E_WARNING:
            if (strpos($errstr, 'REG_') !== false) $s = "ERROR: $errstr"; // incorrect POSIX regexp
            break;
        case E_ERROR:
        case E_USER_NOTICE:
            $s = "ERROR: $errstr (in file $errfile line $errline)";
            break;
    }
    if ($s <> '') {
        to_log($s);
        if ($GLOBALS['client_connected']) client_smcwrite($s); else echo $s;
    }
}

//=============================================================
// log autosaving
function autosave_log() {
    global $log, $logfile, $logformat;
    if ($logfile) {
        if (strlen($log) > 0) cmd_savelog("$logfile $logformat");
    }
        else $log = '';
}


//=============================================================
// MUD connection
function mud_connection($addr) {
    if (!$addr) $addr = $GLOBALS['mud_address'];
    $a = explode(' ', str_replace(':', ' ', $addr));
    if (count($a) <> 2) {
        client_smcwrite("Invalid mud address: $addr (must be 'address:port' or 'address port')");
        return;
    }
    $address = gethostbyname($a[0]);
    client_smcwrite("Connecting to $address on port $a[1]...");
    $GLOBALS['s_client'] = @socket_create(AF_INET, SOCK_STREAM, 0);
    if ($GLOBALS['s_client'] === false) {
        user_error("Can't create socket for server connection");
        return;
    }
    if (@socket_connect($GLOBALS['s_client'], $address, $a[1]) === false) {
        //user_error("Can't connect to the MUD server!");
        client_smcwrite("Unable to connect");
        return;
    }
    client_smcwrite('Connected!');
    $GLOBALS['mud_connected'] = true;
}


//*************************************************************
// Startup

    echo '  -== SOLACE MUD CLIENT (SMC) v'.SMC_VERSION.' on PHP v'.phpversion()." ==-\n"; flush();

    set_time_limit(0);
    //ignore_user_abort();
    error_reporting(E_ERROR | E_WARNING | E_PARSE);
    $old_error_handler = set_error_handler('SMCErrorHandler');
    register_shutdown_function('shutdown');

    load_profile($profile);

    // mess with databases
    if ($db_type and file_exists("include/db_${db_type}.php")) {
        echo "Initializing database interface... "; flush();
        include("include/db_${db_type}.php");
        $q = new DB_Sql;
        initialize_db($db_type);
        echo "Done.\n";
    } else {
        if ($db_type <> '')
            echo "Invalid or unsupported database type '$db_type'. Check your smc.ini settings.\n";
        $db_type = '';
    }
    flush();
     
    // mess with sockets
    $s_serv_listen = @socket_create(AF_INET, SOCK_STREAM, 0);
    if ($s_serv_listen === false) {
        echo "Can't create socket.\n";
        exit;
    }
    // Release the port as soon as the socket closes.
    @socket_setopt($s_serv_listen, SOL_SOCKET, SO_REUSEADDR, 1);
    $a = explode(':', $listen_address);
    if(!@socket_bind($s_serv_listen, $a[0], $a[1])) {
        @socket_close($s_serv_listen);
        user_error("Can't bind to ip $a[0] on port $a[1]\n");
        exit;
    }
    if (@socket_listen($s_serv_listen, 1) === false) {
        @socket_close($s_serv_listen);
        user_error("Can't setup socket for listening\n");
        exit;
    }

    echo 'Option connect_to_mud is ';
    if ($connect_to_mud) echo "on, you will be proxied to server\n";
        else echo "off, you will work off-line (use 'connect' command to connect)\n";
    echo "Waiting for connection on $a[0] port $a[1] ...\n";
    flush();

    $authorized = (($allowed_ip == '') and ($password == ''));
    do {
        // waiting for a client connection...
        $s_serv = @socket_accept($s_serv_listen);
        if ($s_serv === false) {
            user_error("Can't accept connection\n");
            exit;
        }
        @socket_getpeername($s_serv, $remote_ip, $remote_port);
        $remote_host = @gethostbyaddr($remote_ip);
        echo "Incoming connection from IP $remote_ip host $remote_host port $remote_port\n";
        flush();

        $bad_auth = false;
        // ip mask protection
        if ($allowed_ip <> '')
        if (compare_ip($remote_ip, $allowed_ip))
            $authorized = true;
        else {
            echo "Access denied for this IP\n";
            client_writeln('You are not allowed to connect here');
            $bad_auth = true;
        }

        // password protection
        if (!$bad_auth)
        if ($password <> '') {
            @socket_setopt($s_serv, SOL_SOCKET, SO_RCVTIMEO, 10000);
            client_write("Enter password:\n");
            $p = trim(@socket_read($s_serv, 128));
            if ($p == $password) {
                unset($p);
                @socket_setopt($s_serv, SOL_SOCKET, SO_RCVTIMEO, 0);
                client_writeln('');
                $authorized = true;
            } else {
                echo "Invalid password ('$p') or time-out\n";
                client_writeln("Invalid password ('$p') or time-out");
            }
        }

        flush();
        if (!$authorized) @socket_close($s_serv);
    } while (!$authorized);
    unset($bad_auth);
    unset($authorized);

    // stop listening - only 1 connection allowed
    @socket_close($s_serv_listen);

    $client_connected = true;

    //socket_setopt($s_serv, SOL_SOCKET, SO_OOBINLINE, 0);
    //socket_setopt($s_serv, SOL_SOCKET, SO_LINGER, 0);
    @socket_set_nonblock($s_serv);

    call_events('onstart');
    execute_cmd('about');

    if ($connect_to_mud) execute_cmd("connect $mud_address");

    $in_line = '';      // string from client
    $out_line = '';     // string from mud
    $out_cline = '';    // string from mud with ANSI
    $in_bytes = 0;
    $out_bytes = 0;
    $ticks = 0;
    $tick = time();

    do {
        $newtick = time();
        if ($tick <> $newtick) {
            $ticks += $newtick - $tick;
            $tick = $newtick;
            call_events('ontimer');
        }
        
        $ret = client_read();
        if ($ret === false) {
            $client_abort = true;
            break;
        }
        $n = strlen($ret);
        if ($n > 0) {
            $out_bytes += $n;
            process_input($ret);
        }

        if ($mud_connected) {
            $ret = mud_read();
            if ($ret === false) {
                client_smcwrite('### Connection lost ###');
                $mud_connected = false;
                call_events('ondisconnect');
            } else {
                $n = strlen($ret);
                if ($n > 0) {
                    $in_bytes += $n;
                    process_output($ret);
                }
            }
        }
    } while (true);

    call_events('onexit');
    
?>

