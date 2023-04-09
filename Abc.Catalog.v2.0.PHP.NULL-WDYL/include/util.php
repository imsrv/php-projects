<?php

//------------------------------------------------------------------------
// This script is a part of Zakkis PHP library.
//
// Version: 2.0
// Homepage: www.zakkis.ca
// Copyright (c) 2002-2003 Zakkis Technology, Inc.
// All rights reserved.
//
// Author: Maxim A. Perenesenko, 2002-2003
//
// THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
// "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
// LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
// FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
// REGENTS OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
// INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
// (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR
// SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION)
// HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT,
// STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
// ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED
// OF THE POSSIBILITY OF SUCH DAMAGE.
//
//------------------------------------------------------------------------

//-----------------------------------------------------
// HTTP parameter functions
//-----------------------------------------------------

	function IsPost()
	{
		return $_SERVER[REQUEST_METHOD] == 'POST';
	}
	
	function IsGet()
	{
		return $_SERVER[REQUEST_METHOD] == 'GET';
	}

	function HasGetParam( $name )
	{
		if( IsGet() )
			return isset( $_GET[$name] );
		return false;
	}

	function HasPostParam( $name )
	{
		if( IsPost() )
			return isset( $_POST[$name] );
		return false;
	}
	
	function HasGlobalParam( $name )
	{
		if( isset($_POST[$name]) || isset($_GET[$name]) )
			return true;
		else
			return false;
	}
	
	function HasParam( $name )
	{
		if( IsGet() )
			return HasGetParam( $name );
		elseif( IsPost() )
			return HasPostParam( $name );
		else
			return HasGlobalParam( $name );
	}

	function ExtractParam( $name, $def = '' )
	{
		if( IsGet() )
			return $_GET[ $name ];
		elseif( IsPost() )
			return $_POST[ $name ];
          else
          	return $def;
	}
	
	function ExtractGlobalParam( $name, $def = '' )
	{
     	if( isset( $_POST[$name] ) )
			return $_POST[$name];
		elseif( isset( $_GET[$name] ) )
			return $_GET[$name];
		else
			return $def;
	}
	
	function ExtractArrayParam( $name, $keys = array() )
	{
		if( !HasParam( $name ) )
			HttpBadRequest();
		$param = ExtractParam( $name );
		if( !is_array( $param ) )
			HttpBadRequest();
			
		foreach( $keys as $key )
			if( !isset( $param[$key] ) )
				HttpBadRequest();
			
		return $param;
	}
	
//-----------------------------------------------------
// HTTP errors functoins
//-----------------------------------------------------

	function HttpNotFound()
	{
		header("HTTP/1.0 404 Not Found");
		exit;
	}
	
	function HttpMethodNotAllowed()
	{
		header("HTTP/1.0 405 Method Not Allowed");
		exit;
	}
	
	function HttpBadRequest()
	{
		header("HTTP/1.0 400 Bad Request");
		exit;
	}
	
//-----------------------------------------------------
// Misc functoins
//-----------------------------------------------------
	
	function make_seed()
	{
	    list($usec, $sec) = explode(' ', microtime());
	    return (float) $sec + ((float) $usec * 100000);
	}
	
	function GeneratePassword()
	{
		srand(make_seed());
		$str="abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$len = strlen( $str );
		for( $i = 0; $i < 6; $i++ )
			$newpwd .= substr( $str, rand( 0, $len - 1 ), 1 );
		return $newpwd;
	}
	
//-----------------------------------------------------
// Array related functoins
//-----------------------------------------------------

	function _ArrayEnclose(&$item, $key, $ch)
	{
		$item = "$ch$item$ch";
	}

	function EncloseArrayValues( &$arr, $ch = "'" )
	{
		array_walk( $arr, '_ArrayEnclose', $ch );
	}
	
	function ArrayTrim( &$arr )
	{
		for( reset($arr); $key=key($arr); next($arr) )
			$arr[$key] = trim($arr[$key]);
	}
	
//-----------------------------------------------------
// Filesystem functions
//-----------------------------------------------------

	
	// Writes conf file from array.
	// for format of $data see parse_ini_file( $filename, true );
	
	function WriteIniFile( $filename, $data )
	{
		$fh = @fopen( $filename, 'wb+' );
		if( !$fh )
			return 'Failed to open configuration file.';
		
		foreach( $data as $section_name => $section )
		{
			$rc = fwrite( $fh, "[$section_name]\n" );
			if( $rc == -1 )
				return 'Failed to write configuration file.';
				
			foreach( $section as $key => $value )
			{
				$rc = fwrite( $fh, "$key = $value\n" );
				if( $rc == -1 )
					return 'Failed to write configuration file.';
			}
			
			$rc = fwrite( $fh, "\n" );
			if( $rc == -1 )
				return 'Failed to write configuration file.';
		}
		
		@fclose( $fh );
		
		return 'ok';
	}
	
	//
	// Removes directory recursively
	
		function RemoveDirectory( $dirname )
	{
		$dir = dir($dirname);
		while( false != ($entry = $dir->read()) )
		{
			if( $entry == '.' || $entry == '..' )
				continue;
				
			$name = $dirname . '/' . $entry;
				
			if( is_dir( $name ) )
				RemoveDirectory( $name );
			else
				@unlink( $name );
		}
		$dir->close();
		@rmdir( $dirname );
	}
	
	function ReadBinaryFile( $name )
	{
		$fd = fopen( $name, 'rb');
		$content = fread ($fd, filesize ($name));
		fclose($fd);
		return $content;
	}
	
	function GetFilePermissions( $filename )
	{
		$perms = fileperms( $filename );
		if( !$perms )
			return FALSE;
		
		$flags = array( 'x', 'w', 'r' );
		$rc = '';
		for( $i = 0; $i < 3; $i++ )
		{
			for( $idx = 0; $idx < 3; $idx++ )
			{
				$rc .= ($perms & 1) ? $flags[$idx] : '-';
				$perms >>= 1;
			}
		}
		
		$rc .= is_dir( $filename ) ? 'd' : '-';
		
		return strrev( $rc );
	}
	
//-----------------------------------------------------
// Redirection function
//-----------------------------------------------------
	
	$_serverHost = $_SERVER['HTTP_HOST'];
	$_phpSelf = $_SERVER['PHP_SELF'];
	$_serverDir = dirname( $_phpSelf );
	$_serverPort = $_SERVER['SERVER_PORT'];
	$_baseDir = sprintf("Location: http://%s:%s%s/", $_serverHost, $_serverPort, $_serverDir );
	
	function RedirectTo( $script )
	{
		global $_baseDir;
		header( "$_baseDir$script" );
		exit;
	}

//-----------------------------------------------------
// Generate page state from form hidden fields
//-----------------------------------------------------
	
	function _GenerateHiddenState( $arr, $except = array() )
	{
		foreach( $arr as $key => $val )
		{
			if( in_array( $key, $except ) )
				continue;
			$rc .= "<input type=hidden name=\"$key\" value=\"$val\">\n";
		}
		return $rc;
	}
	
	function GenerateHiddenState( $except = array() )
	{
		$rc .= _GenerateHiddenState( $_POST, $except );
		$rc .= _GenerateHiddenState( $_GET, $except );
		return $rc;
	}
	
//-----------------------------------------------------
// Mail utility function
//-----------------------------------------------------
	
	function SendMailReplyTo( $to, $from, $reply_to, $subj, $body )
	{
		$headers = "From: $from\r\n";
		$headers .= "Reply-To: $reply_to\r\n";
		return mail($to, $subj, $body, $headers);
	}

	function SendMail( $to, $from, $subj, $body )
	{
		return SendMailReplyTo( $to, $from, $from, $subj, $body );
	}

//-----------------------------------------------------
// Debug function
//-----------------------------------------------------

	function DbgOut()	// multi-args
	{
		print '<pre>';
		$args = func_get_args();
		foreach( $args as $arg )
			print_r ( $arg );
		print '</pre>';
	}


//-----------------------------------------------------
// SaveDbDumpFile
//-----------------------------------------------------

function SaveDbDumpFile ($db) {

	$sqldump="";

	$tbl = $db -> Exec ("Show tables"); // Get table names in database;
	while ($res = $tbl -> FetchArray())
	$tables[]=$res[0];

	if(!empty($tables))
	{

	foreach ($tables as $table) {
		
		$sqldump.="DROP TABLE IF EXISTS $table;"; // Instructions for drop table
		
		$tbl = $db -> Exec ("SHOW CREATE TABLE $table"); // Get table names in database;
		while ($res = $tbl -> FetchArray())
		$sqldump.=$res[1] .';';
		
		// Insert instructions
		
		$insert_instr="INSERT INTO $table (";
		
		$tbl = $db -> Exec ("SHOW COLUMNS FROM $table"); // Get row names in table;
		while ($res = $tbl -> FetchArray())
		$insert_instr.=$res[0] . ',';
		
		$insert_instr[strlen($insert_instr)-1]=')';
		$insert_instr.=' VALUES (';
		
		$tbl = $db -> Exec ("SELECT * FROM $table"); // Get data
		while ($res = $tbl -> FetchRow()) {
		
		$sqldump.=$insert_instr;
		
		foreach ($res as $r) {
		$r=addslashes($r);
		$sqldump.= "\"" . $r . "\",";
		}
		
		$sqldump[strlen($sqldump)-1]=')';
		$sqldump.=';';
		}
	
	}
	
	
	$filename="backup_" . date ("Y-m-d");
	$ext="sql";
	
	
	
	header('Content-Type: application/octetstream');
	header('Content-Disposition: inline; filename="' . $filename . '.' . $ext . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
	
	echo $sqldump;
	
	}
	
}


//-----------------------------------------------------
// Restore from dump file
//-----------------------------------------------------

function RestoreDbFromFile( $db, $file ) {
	
	set_time_limit (0); //Setting no time limit for execution

	$err=0;
	
	if(is_file($file)) {
	
	$f=fopen($file,'r');
	$content=fread($f,filesize($file));
	
	$sqlquery=array();
	splitSqlFile ($sqlquery,$content,0);
	
	foreach ($sqlquery as $sql ) {
	
	$res= $db -> Exec($sql);
	
	if(!$res)
	$err=1;
	
	}
	
	if ($err==0)
	return '';
	else return 'Some errors occured!';
	
	} else return 'Bad backup file!';
	
}





/**
 * Removes comment lines and splits up large sql files into individual queries
 *
 *
 * @param   array    the splitted sql commands
 * @param   string   the sql commands
 * @param   integer  the MySQL release number (because certains php3 versions
 *                   can't get the value of a constant from within a function)
 *
 * @return  boolean  always true
 *
 * @access  public
 */
function splitSqlFile(&$ret, $sql, $release)
{
    $sql          = trim($sql);
    $sql_len      = strlen($sql);
    $char         = '';
    $string_start = '';
    $in_string    = FALSE;
    $time0        = time();

    for ($i = 0; $i < $sql_len; ++$i) {
        $char = $sql[$i];

        // We are in a string, check for not escaped end of strings except for
        // backquotes that can't be escaped
        if ($in_string) {
            for (;;) {
                $i         = strpos($sql, $string_start, $i);
                // No end of string found -> add the current substring to the
                // returned array
                if (!$i) {
                    $ret[] = $sql;
                    return TRUE;
                }
                // Backquotes or no backslashes before quotes: it's indeed the
                // end of the string -> exit the loop
                else if ($string_start == '`' || $sql[$i-1] != '\\') {
                    $string_start      = '';
                    $in_string         = FALSE;
                    break;
                }
                // one or more Backslashes before the presumed end of string...
                else {
                    // ... first checks for escaped backslashes
                    $j                     = 2;
                    $escaped_backslash     = FALSE;
                    while ($i-$j > 0 && $sql[$i-$j] == '\\') {
                        $escaped_backslash = !$escaped_backslash;
                        $j++;
                    }
                    // ... if escaped backslashes: it's really the end of the
                    // string -> exit the loop
                    if ($escaped_backslash) {
                        $string_start  = '';
                        $in_string     = FALSE;
                        break;
                    }
                    // ... else loop
                    else {
                        $i++;
                    }
                } // end if...elseif...else
            } // end for
        } // end if (in string)

        // We are not in a string, first check for delimiter...
        else if ($char == ';') {
            // if delimiter found, add the parsed part to the returned array
            $ret[]      = substr($sql, 0, $i);
            $sql        = ltrim(substr($sql, min($i + 1, $sql_len)));
            $sql_len    = strlen($sql);
            if ($sql_len) {
                $i      = -1;
            } else {
                // The submited statement(s) end(s) here
                return TRUE;
            }
        } // end else if (is delimiter)

        // ... then check for start of a string,...
        else if (($char == '"') || ($char == '\'') || ($char == '`')) {
            $in_string    = TRUE;
            $string_start = $char;
        } // end else if (is start of string)

        // ... for start of a comment (and remove this comment if found)...
        else if ($char == '#'
                 || ($char == ' ' && $i > 1 && $sql[$i-2] . $sql[$i-1] == '--')) {
            // starting position of the comment depends on the comment type
            $start_of_comment = (($sql[$i] == '#') ? $i : $i-2);
            // if no "\n" exits in the remaining string, checks for "\r"
            // (Mac eol style)
            $end_of_comment   = (strpos(' ' . $sql, "\012", $i+2))
                              ? strpos(' ' . $sql, "\012", $i+2)
                              : strpos(' ' . $sql, "\015", $i+2);
            if (!$end_of_comment) {
                // no eol found after '#', add the parsed part to the returned
                // array if required and exit
                if ($start_of_comment > 0) {
                    $ret[]    = trim(substr($sql, 0, $start_of_comment));
                }
                return TRUE;
            } else {
                $sql          = substr($sql, 0, $start_of_comment)
                              . ltrim(substr($sql, $end_of_comment));
                $sql_len      = strlen($sql);
                $i--;
            } // end if...else
        } // end else if (is comment)

        // ... and finally disactivate the "/*!...*/" syntax if MySQL < 3.22.07
        else if ($release < 32270
                 && ($char == '!' && $i > 1  && $sql[$i-2] . $sql[$i-1] == '/*')) {
            $sql[$i] = ' ';
        } // end else if

        // loic1: send a fake header each 30 sec. to bypass browser timeout
        $time1     = time();
        if ($time1 >= $time0 + 30) {
            $time0 = $time1;
            header('X-pmaPing: Pong');
        } // end if
    } // end for

    // add any rest to the returned array
    if (!empty($sql) && ereg('[^[:space:]]+', $sql)) {
        $ret[] = $sql;
    }

    return TRUE;
} // end of the 'PMA_splitSqlFile()' function


?>