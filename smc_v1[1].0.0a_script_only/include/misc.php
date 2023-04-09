<?

//===========================================================================
function to_log($s) {
    error_log(sprintf("%-12s %s\r\n", date('H:i:s'), $s), 3, 'debug');
}

//===========================================================================
function to_scr($s) {
    echo sprintf("%-12s %s\r\n", date('H:i:s'), $s);
    flush();
}

//===========================================================================
function compare_ip($ip, $mask) {
    $ip = explode('.', $ip);
    $m = explode('.', $mask);
    for ($i=0;$i<count($m);$i++)
        if (($m[$i] <> '*') and ($m[$i] <> $ip[$i])) return false;
    return true;
}

//===========================================================================
function datetime2timestamp($dt) {
    if ($dt)
    list($y, $m, $d, $hh, $mm, $ss) = sscanf($dt, "%d-%d-%d %d:%d:%d");
    return mktime($hh, $mm, 0, $m, $d, $y);
}

//===========================================================================
function sqldatetime($dt) {
    if ($dt)
    list($y, $m, $d, $hh, $mm, $ss) = sscanf($dt, "%d-%d-%d %d:%d:%d");
    if (!$y) return ''; else
        return sprintf("%02d.%02d.%d %02d:%02d", $d, $m, $y, $hh, $mm);
}

//===========================================================================
function sqldate($dt) {
    if ($dt)
    list($y, $m, $d, $hh, $mm, $ss) = sscanf($dt, "%d-%d-%d %d:%d:%d");
    if (!$y) return ''; else
        return sprintf("%02d.%02d.%d", $d, $m, $y);
}

//===========================================================================
function tosqldatetime($dt) {
    if ($dt)
    list($d, $m, $y, $hh, $mm) = sscanf($dt, "%d.%d.%d %d:%d");
    if (!$y) return ''; else
        return sprintf("%d-%02d-%02d %02d:%02d", $y, $m, $d, $hh, $mm);
}

//===========================================================================
// получить имя файла
function get_fname($fn) {
    $p = SrPos($fn, '.');
    if (p<>-1) $fname = substr($fn, 0, $p);
        else $fname = $fn;
    return $fname;
}

//===========================================================================
// получить расширение
function get_fext($fn) {
    $p = SrPos($fn, '.');
    if (p<>-1) $fext = substr($fn, $p+1, strlen($fn)-$p);
        else $fext = '';
    return $fext;
}

//===========================================================================
// проверить наличие ip адреса в пуле адресов
function ip_in_pool($ip, $pool) {
    foreach ($pool as $ipmask)
        if (SPos($ip, $ipmask) == 0) return true;
    return false;
}

//=============================================================================
// генерация datafile по выборке для load data infile
function datafile(&$q, $fname) {
    $f = fopen($fname, 'w+');
    if (!$f) return false;
    while ($q->next_record()) {
        $v = '';
        for ($i=0;$i<$q->num_fields();$i++) {
           $fld = addcslashes($q->f($i), "\0..\37\\");
           if ($fld == '') $fld = '\N';
           $v .= "$fld\t";
        }
        $v = substr($v, 0, strlen($v) - 1)."\n";
        fwrite($f, $v);
    }
    fclose($f);
    return true;
}

//=============================================================================
function getmicrotime(){ 
    list($usec, $sec) = explode(' ',microtime()); 
    return ((float)$usec + (float)$sec); 
} 

//=============================================================================
// генерация mysql dump
function sqldump(&$q, $tblname, $fname) {
    if (!$q->num_rows()) return false;
    $f = fopen($fname, 'w+');
    if (!$f) return false;
    $fnum = $q->num_fields();
    for ($i=0;$i<$fnum;$i++) $fields[] = @mysql_field_name($q->Query_ID, $i);
    $fnames = implode(',', $fields);
    $sql = "insert into $tblname ($fnames) values (";
    while ($q->next_record()) {
        $s = '';
        for ($i=0;$i<$fnum;$i++) {
            $v = $q->f($i);
            if (strlen($v) == 0) $v = 'NULL'; else {
                $v = '"'.str_replace("\n", "\\n", addslashes($v)).'"';
                $v = str_replace("\r", '', $v);
            }
            $s .= $v.',';
        }
        $s = substr($s, 0, strlen($s) - 1);
        fwrite($f, $sql.$s.");\n");
    };
    fclose($f);
    return true;
}

//=============================================================================
// генерация sql отчета
function sqlprint(&$q) {
    $fnum = $q->num_fields();
    for ($i=0;$i<$fnum;$i++) {
        $n = @mysql_field_name($q->Query_ID, $i);
        $fields[$i]['name'] = $n;
        $fields[$i]['len'] = strlen($n)+2;
    }
//    print_r($fields);
    while ($q->next_record())
        for ($i=0;$i<$fnum;$i++) {
            $n = strpos($q->f($i),"\n");
            if ($n === false) $n = strlen($q->f($i));
            $fields[$i]['len'] = max($fields[$i]['len'], $n+2);
        }
    for ($i=0;$i<$fnum;$i++) $headl .= '+'.str_repeat('-', $fields[$i]['len']);
    $headl .= '+';
    for ($i=0;$i<$fnum;$i++) $head .= '| '.str_pad($fields[$i]['name'], $fields[$i]['len']-1);
    $head .= '|';
    $out[] = $headl;
    $out[] = $head;
    $out[] = $headl;
    if ($q->num_rows()) $q->seek(0);
    while ($q->next_record()) {
        $l = '';
        for ($i=0;$i<$fnum;$i++) $l .= '| '.str_pad($q->f($i), $fields[$i]['len']-1);
        $out[] = $l.'|';
    }
    $out[] = $headl;
    return $out; //implode("\n", $out);
}

//=============================================================================
// выполнение sql скрипта
function sqlload($fname) {
    global $q;
    $f = fopen($fname, 'r');
    if (!$f) return false;
    $s = fread($f, filesize($fname));
    $sql = explode(');', $s);
    foreach ($sql as $s) if ($s) $q->query($s.')');
    fclose($f);
    return true;
}

?>