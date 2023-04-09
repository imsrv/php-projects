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

//
// Get page parameters

$data = ExtractarrayParam('data');

//
// Verify directory name

if( $guest )
	$data[dir] = 'guest';
elseif( $data[dir] == '' )
	AddError('Directory name is missed.');

//
// Verify page count
	
if( !isset( $data[pages] ) || !is_numeric( $data[pages] ) || $data[pages] <= 0 )
	$data[pages] = 10;

//
// Verify and process template name

if( !$guest && $_FILES['template']['name'] != '' )
{
	$tmp_name = $_FILES['template']['tmp_name'];
	if( $has_template )
		unlink('table.html');
	move_uploaded_file( $tmp_name, 'table.html');
	$has_template = true;
}

//
// Verify excel file name

if( $_FILES['excel']['name'] != '' )
{
	$excel_file = $_FILES['excel'];
	if( !is_uploaded_file( $excel_file['tmp_name'] ) )
		AddError('You should upload Excel file.');
}

//
// Verify rows on page

if( !is_numeric($data[rop]) )
	AddError("Value of 'Rows On Page' is not a number.");
elseif( $data[rop] <= 0 )
	AddError("Value of 'Rows On Page' is invalid.");

//
// Check the template is here

if( !$has_template )
	AddError('You should upload page template.');

//
// Process errors (if any)

if( $has_errors )
	return;

//
// Generate html catalog from excel

include_once ('generate.inc');
if( !file_exists( $data[dir] ) )
	mkdir( $data[dir], 0777 );
$output_name = $data[dir] . '/' . 'index.htm';
$msg = GenerateExcelTable( $excel_file,
						   $output_name,
						   $data[rop],
						   $data[pages] );

//
// Process generation errors (if any)
						   
if( $msg != 1 )
{
	AddError( $msg );
	return;
}

//
// Format link to the generated file and output it into the message

$message = "File <a href=\"$start_file_name\" target=_blank>$output_name</a> generated from $excel_file[name]";

?>