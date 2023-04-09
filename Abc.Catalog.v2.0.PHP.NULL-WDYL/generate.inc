<?php 

//------------------------------------------------------------------------
// This script is a part of Zakkis ABC Catalog.
//
// Version: 2.0
// Homepage: www.zakkis.ca
// Copyright (c) 2002-2003 Zakkis Technology, Inc.
// All rights reserved.
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

include_once ("excelparser.php");
include_once ("fatal.inc");
include_once ("genstyle.inc");

$start_file_name = '';

function uc2html($str) {
	$ret = '';
	for( $i=0; $i<strlen($str)/2; $i++ ) {
		$charcode = ord($str[$i*2])+256*ord($str[$i*2+1]);
		$ret .= '&#'.$charcode;
	}
	return $ret;
}

$td_class = '';
function GetStyle( $current )
{
	global $td_class;
	return $td_class == '' ? $current : $td_class;
}

function GenerateWorksheetPart( $exc, $start, $end )
{
	global $td_class, $borderWidth, $borderColor;

	$ws = $exc->worksheet['data'][0];

	ob_start();
	echo "\n<br><br><table border=\"$borderWidth\" borderColor=\"$borderColor\" cellspacing=0 cellpadding=2>\n";

	for( $i=$start; $i<$end; $i++ )
	{
		if( !is_array($ws['cell'][$i]) )
		{
			// print an empty row
			for( $j=0; $j<=$ws['max_col']; $j++ )
				print "<td class=empty>&nbsp;</td>";
			print "\n</tr>\n";
			continue;
		} // !is_array

		if( !is_array($ws['cell'][$i][1]) )
			$td_class = 'chapter';
		else
			$td_class = '';

		for( $j=0; $j<=$ws['max_col']; $j++ )
		{
			if( !is_array($ws['cell'][$i][$j]) )
			{
				$tdc = GetStyle('empty');
				print "<td class=$tdc>&nbsp;</td>\n";
				continue;
			} // !is_array
			
			// print cell data
			print "<td class=";
			$data = $ws['cell'][$i][$j];

			switch ($data[type])
			{
			// string
			case 0:
				$tdc = GetStyle('dt_string');
				print "$tdc>";
				$ind = $data[data];
				
				if( $exc->sst[unicode][$ind] )
					$s = uc2html($exc->sst[data][$ind]);
				else
					$s = $exc->sst[data][$ind];

				if( strlen(trim($s))==0 )
					print "&nbsp;";
				else
					print $s;	

				break;

				// integer number
			case 1:
				$tdc = GetStyle('dt_int');
				print "$tdc>";
				print (int)($data[data]);
				break;
				// float number
			case 2:
				$tdc = GetStyle('dt_float');
				print "$tdc>";
				print (float)($data[data]);
				break;
			default:
				$tdc = GetStyle('dt_unknown');
				print "$tdc>&nbsp;";
				break;
			} // switch
			print "</td>\n";
		} // for( col )
		print "</tr>\n";
	} // for( row )
	
	print "</table>\n";
	
	$rc = ob_get_contents();
	ob_end_clean();
		
	return $rc;
}

function FormatLink( $name, $output_name, $no, $dummy, $title = '' )
{
	if( !$dummy )
	{
		$href = basename( $output_name );
		if( $no != 0 )
			$href = str_replace( '.htm', $no . '.htm', $href );
		if( $title == '' )
			$rc = "<a href=\"$href\">$name</a>&nbsp;&nbsp;";
		else
			$rc = "<a title=\"$title\" href=\"$href\">$name</a>&nbsp;&nbsp;";
	}
	else
		$rc = "<b>$name</b>&nbsp;&nbsp;";
	return $rc;
}

function GenerateNavigator( $pagecount, $pageno, $maxpage, $output_name )
{
	$blockno = floor( $pageno / $pagecount );
	$maxblock = ceil( $maxpage / $pagecount );
	
	$rc = FormatLink( '&lt;&lt;', $output_name, ($blockno - 1) * $pagecount, $blockno == 0 ? true : false,
		"Previous $pagecount pages.");
	
	$endpage = ($blockno + 1) * $pagecount;
	if( $maxpage < $endpage )
		$endpage = $maxpage;
	
	for( $i = $blockno * $pagecount; $i < $endpage; $i++ )
		$rc .= FormatLink( $i + 1, $output_name, $i, $i == $pageno ? true : false );
	
	$next10 = ($blockno + 1) * $pagecount;
	if( $next10 > $maxpage )
		$next10 = $maxpage - 1;
		
	$rc .= FormatLink( '&gt;&gt;', $output_name, $next10, $blockno == $maxblock - 1 ? true : false,
		"Next $pagecount pages");
	
	return $rc;
}

function GenerateExcelTable( $excel_file, $output_name, $rows_on_page, $pagecount )
{
	global $start_file_name, $htmlStyles;

	$err_corr = "Unsupported format or file corrupted";
	
	$excel_file = $excel_file['tmp_name'];
	if( $excel_file == '' )
		return "No file uploaded";
	
	if( filesize($excel_file)==0 )
		return "No file uploaded";

	$fh = @fopen ($excel_file,'rb');
	if( !$fh )	
		return "No file uploaded";
	$fc = @fread( $fh, filesize($excel_file) );
	@fclose($fh);
	
	if( strlen($fc) < filesize($excel_file) )
		return "Cannot read file";
	
	$exc = new ExcelFileParser;
	$res = $exc->ParseFromString($fc);
	
	switch ($res) {
		case 0: break;
		case 1: return "Can't open file";
		case 2: return "File too small to be an Excel file";
		case 3: return "Error reading file header";
		case 4: return "Error reading file";
		case 5: return "This is not an Excel file or file stored in Excel < 5.0";
		case 6: return "File corrupted";
		case 7: return "No Excel data found in file";
		case 8: return "Unsupported file version";
	
		default:
			return "Unknown error";
	}
	
	$ws = $exc->worksheet['data'][0];
	
	if( is_array($ws) &&
		isset($ws['max_row']) && isset($ws['max_col']) )
	{
		$page_count = ceil($ws['max_row'] / $rows_on_page);

		// Generate pages
		$tcontents = join ('', file ('table.html'));
		
		for( $i = 0; $i < $page_count; $i++ )
		{
			$start = $i * $rows_on_page;
			$end = ($i + 1 ) * $rows_on_page;
			if( $end > $ws['max_row'] + 1 )
				$end = $ws['max_row'] + 1;
			
			$tbl = GenerateWorksheetPart( $exc, $start, $end );
			
			if( $page_count > 1 )
				$nav = GenerateNavigator( $pagecount, $i, $page_count,  $output_name );
				
			if( $page_count == 1 || $i == 0 )
				$filename = $output_name;
			else
				$filename = str_replace('.htm', $i . '.htm', $output_name );
				
			$rc = str_replace( '<%NAVIGATOR%>', $nav, $tcontents);
			$rc = str_replace( '<%TABLE%>', $tbl, $rc );
			$rc = str_replace( '<%PAGENO%>', $i + 1, $rc );
			$rc = str_replace( '<%PAGECOUNT%>', $page_count, $rc );
			$rc = str_replace( '<%PREVPAGE%>', 
				FormatLink( 'Prev', $output_name, $i - 1, $i == 0 ? true : false ), $rc );
			$rc = str_replace( '<%NEXTPAGE%>', 
				FormatLink( 'Next', $output_name, $i + 1, $i + 1 == $page_count ? true : false ), $rc );
			$rc = $htmlStyles . $rc;
			
			if( $i == 0 )
				$start_file_name = $filename;
			
			$fh = @fopen( $filename, 'wb+' );
			if( !$fh )
				return "Failed to create file $output_name";
			if( @fwrite( $fh, $rc ) == -1 )
			{
				fclose( $fh );
				return "Failed to write file $output_name";
			}
			@fclose( $fh );
		}
	} // if (!is_array

	return 1;
}
?>