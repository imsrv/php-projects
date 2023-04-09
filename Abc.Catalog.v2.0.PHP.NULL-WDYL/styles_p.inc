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

if( $guest )
{
	AddError('Update of styles is <font color=red>disabled</font> in the demo version.');
	return;
}

$styles = parse_ini_file('style.rc', false);

foreach( $styles as $key => $value )
	$$key = ExtractParam( $key );
		
$data = array( 'Border' =>
	array( 'borderColor' => $borderColor,
		   'borderWidth' => $borderWidth),
          	   'Category' =>
	array( 'catFontColor' => $catFontColor,
		   'catBgColor' => $catBgColor) );
		   
WriteIniFile( 'style.rc', $data );

$message = 'Table styles have been updated successfully.';

?>