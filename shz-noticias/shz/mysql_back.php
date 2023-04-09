<?php
include "stl.php";
include "config.php";

$host = $dbserver; // endereço do servidor de banco de dados
$user = $dbuser; // login para acessar o banco de dados
$senha = $dbpass; // senha para acessar o banco de dados
$banco = $dbname; // nome do banco de dados

$conex = @mysql_connect($host,$user,$senha)
					or die("Não conectou no MySql. Você já configurou os dados de acesso ao servidor MySQL neste script? Caso não, abra o arquivo e configure.");

if (!@mysql_select_db($banco,$conex))
{
	echo "Erro ao selecionar a DB";
	mysql_close($db);
	exit;
}

if (function_exists("set_time_limit")==1 and get_cfg_var("safe_mode")==0)
{
	@set_time_limit(0);
}

function sqlAddslashes($str = '', $is_like = FALSE)
{
	if ($is_like)
	{
        	$str = str_replace('\\', '\\\\\\\\', $str);
        }else{
		$str = str_replace('\\', '\\\\', $str);
        }
        $str = str_replace('\'', '\\\'', $str);
        return $str;
}

// data dump functions
function sqldumptable($table) {
	$nline = "\n";
	$dump = 'DROP TABLE IF EXISTS ' . $table . ';' . $nline;
	$dump .= 'CREATE TABLE ' . $table . '(' . $nline;
	$firstfield = 1;
	$fields_array = mysql_query("SHOW FIELDS FROM $table");
	
	while ($field = mysql_fetch_array($fields_array))
	{
		if (!$firstfield)
		{
			$dump .= ",\n";
		}else{
			$firstfield = 0;
		}
		$dump .= "   $field[Field] $field[Type]";
		if (isset($field['Default']) && $field['Default'] != '')
		{
                	$dump .= ' default \'' . sqlAddslashes($field['Default']) . '\'';
		}
		if ($field['Null'] != 'YES')
		{
			$dump .= ' NOT NULL';
		}
		if (!empty($field[Extra]))
		{
			$dump .= " $field[Extra]";
		}
	}
	mysql_free_result($fields_array);

	$keysindex_array = mysql_query("SHOW KEYS FROM $table");
	while ($key = mysql_fetch_array($keysindex_array))
	{
		$kname=$key['Key_name'];
		if ($kname != "PRIMARY" and $key['Non_unique'] == 0)
		{
			$kname="UNIQUE|$kname";
		}
		if(!is_array($index[$kname]))
		{
			$index[$kname] = array();
		}
		$index[$kname][] = $key['Column_name'];
	}
	mysql_free_result($keysindex_array);
	
	while(list($kname, $columns) = @each($index))
	{
		$dump .= ",\n";
		$colnames=implode($columns,",");
		if($kname == 'PRIMARY')
		{
			$dump .= "   PRIMARY KEY ($colnames)";
		}else{
			if (substr($kname,0,6) == 'UNIQUE')
			{
				$kname=substr($kname,7);
			}
			$dump .= "   KEY $kname ($colnames)";
		}
	}
	$dump .= "\n);\n\n";
	$rows = mysql_query("SELECT * FROM $table");
	$numfields=mysql_num_fields($rows);
	
	while ($row = mysql_fetch_array($rows))
	{
		$dump .= "INSERT INTO $table VALUES(";
		$fieldcounter=-1;
		$firstfield=1;
		while (++$fieldcounter<$numfields)
		{
			if(!$firstfield)
			{
				$dump.=',';
			}else{
				$firstfield=0;
			}
			if (!isset($row[$fieldcounter]))
			{
				$dump .= 'NULL';
			}else{
				$dump .= "'".mysql_escape_string($row[$fieldcounter])."'";
			}
		}
		$dump .= ");\n";
	}
	mysql_free_result($rows);
	return $dump;
}
if ($HTTP_POST_VARS['action'] == 'sqlbrowser')
{
	$table = mysql_query("SHOW tables");
	unset($temp_buffer);
	while ($row = mysql_fetch_array($table))
	{
		if (!empty($row[0]))
		{
			$temp_buffer .= sqldumptable($row[0])."\n\n\n";
		}
	}
	/* show content */
	// zip file
	$file_name = $banco.'_backup-'.date("Y-m-d");
	if($HTTP_POST_VARS['compress_type'] == 'bzip'){
		if(function_exists('bzcompress'))
		{
			header("Content-disposition: filename=$file_name.bz2");
			header("Content-type: unknown/unknown");
			echo bzcompress($temp_buffer);
		} 
	// gzipped file
	}elseif( $HTTP_POST_VARS['compress_type'] == 'gzip'){
		if(function_exists('gzencode'))
		{
			header("Content-disposition: filename=$file_name.gz");
			header("Content-type: unknown/unknown");
			// without the optional parameter level because it bug
			echo gzencode($temp_buffer);
		}
	// screen
	}else{
		header("Content-disposition: filename=$file_name.sql");
		header("Content-type: unknown/unknown");
		echo $temp_buffer;
	}
	exit;
}

if ($HTTP_POST_VARS['action']=='sqlfile')
{
	$filehandle = fopen($HTTP_POST_VARS['filename'],'w');
	$result = mysql_query("SHOW tables");
	while ($row = mysql_fetch_array($result))
	{
		fwrite($filehandle,sqldumptable($row[0])."\n\n\n");
		echo "<p>Dumping $row[0]</p>";
	}
	fclose($filehandle);
	unset($row);
	echo "<p><b>Backup realizado com sucesso</b></p>";
	$action = '';
}

if (empty($action))
{
	echo "
	<form action='mysql_back.php'  name='name' method='post'>
		<input type='hidden' name='action' value='sqlbrowser' />
		<table cellpadding='4' border='1' cellspacing='0' width='95%' bordercolor='#C0C0C0' align='center'>
		<tr><th bgcolor='$colorbg'><font color=$colortex size=$sizetex>Tabelas que serão incluidas no backup</b></font></th></tr>";
	$result=mysql_query("SHOW tables");
	while ($currow=mysql_fetch_array($result))
	{
		echo "<tr><td><p><font color=$colortex size=$sizetex>". $currow[0]  ."</font></p></td></tr>";
	}
	// gzip and bzip2 encode features
	$is_zip  = (@function_exists('gzcompress'))?1:0;
    $is_gzip = (@function_exists('gzencode'))?1:0;
    $is_bzip = (@function_exists('bzcompress'))?1:0;
    if ($is_zip || $is_gzip || $is_bzip)
	{
		echo "<tr valign='top'><td colspan='2'><font color=$colortex size=$sizetex>Opções de compressão disponível :</font> \n";
		echo '(';
		if ($is_zip==1)
		{
			echo " <input type='radio' name='compress_type' value='zip'><b>zip</b> ";
		}
		if ($is_gzip==1)
		{
			echo " <input type='radio' name='compress_type' value='gzip'><b>gz</b> ";
		}
		if ($is_bzip==1)
		{
			echo " <input type='radio' name='compress_type' value='bzip'><b>bizp</b> ";
		}
		echo ')';
		echo '</td></tr>';
	}
	echo "</table><div align='center'>
		<table border='0'>
		<tr><td><input type='submit' name='submit' value='   Fazer Download do Backup    ' width='200' /> <input type='reset' name='reset' value='   Cancelar   ' /></td></tr>
		</table>
	</div>
	</form>";
	

}
echo "<font color=$colortex size=$sizetex>Se você não selecionar nenhum modo de compressão, o arquivo ficará .sql";
exit;

?>
