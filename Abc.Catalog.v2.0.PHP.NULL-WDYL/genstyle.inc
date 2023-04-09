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

$styles = parse_ini_file('style.rc', false);
extract( $styles );

$htmlStyles = "<STYLE>
<!--
body, table, tr, td {font-size: 12px; font-family: Verdana, MS sans serif, Arial, Helvetica, sans-serif}
td.index {font-size: 10px; color: #000000; font-weight: normals}
td.dt_string {font-size: 10px; color: #000000; font-weight: normal}
td.dt_int {font-size: 10px; color: #000000; font-weight: normal}
td.dt_float {font-size: 10px; color: #000000; font-weight: normal}
td.dt_unknown {
	font-size: 10px;
	background-color: #CCCCCC;
	font-weight: normal;
	color: #990000;
}
td.empty {
	font-size: 10px;
	background-color: #CCCCCC;
	font-weight: normal;
	color: #990000;
}
td.chapter {
	font-size: 12px;
	background-color: $catBgColor;
	font-weight: bold;
	color: $catFontColor;
}
-->
</STYLE>
";

?>