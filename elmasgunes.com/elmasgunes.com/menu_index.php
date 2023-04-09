<?php
  if( !$tiklama ) $tiklama = "normal";
  if( $tiklama == "normal" )
  {
  echo '<MAP NAME="menu_index">
        <AREA SHAPE=POLY COORDS="1,23,6,16,6,8,13,1,117,1,124,6,125,9,125,17,129,23,1,23,1,23" HREF="hosting.php?menu=hosting">
        <AREA SHAPE=POLY COORDS="133,1,238,1,245,8,245,18,248,22,248,23,130,23,126,17,126,8,133,1" HREF="design.php?menu=design">
        <AREA SHAPE=POLY COORDS="252,1,358,1,365,8,365,17,369,23,250,23,246,18,246,9,252,1" HREF="alan_adi.php?menu=alan_adi">
        </MAP>
        <img src="images/menu_index.gif" usemap="#menu_index" width="370" height="23" border="0">';
  }
  if( $tiklama == "hosting" )
  {
  echo '<MAP NAME="menu_hosting">
        <AREA SHAPE=POLY COORDS="133,1,238,1,245,8,245,18,248,22,248,23,130,23,126,17,126,8,133,1" HREF="design.php?menu=design">
        <AREA SHAPE=POLY COORDS="252,1,358,1,365,8,365,17,369,23,250,23,246,18,246,9,252,1" HREF="alan_adi.php?menu=alan_adi">
        </MAP>
        <img src="images/menu_hosting.gif" usemap="#menu_hosting" width="370" height="23" border="0">';
  }
  if( $tiklama == "design" )
  {
  echo '<MAP NAME="menu_design">
        <AREA SHAPE=POLY COORDS="1,23,6,16,6,8,13,1,117,1,124,6,125,9,125,17,129,23,1,23,1,23" HREF="hosting.php?menu=hosting">
        <AREA SHAPE=POLY COORDS="252,1,358,1,365,8,365,17,369,23,250,23,246,18,246,9,252,1" HREF="alan_adi.php?menu=alan_adi">
        </MAP>
        <img src="images/menu_design.gif" usemap="#menu_design" width="370" height="23" border="0">';
  }
  if( $tiklama == "alan_adi" )
  {
  echo '<MAP NAME="alan_adi">
        <AREA SHAPE=POLY COORDS="1,23,6,16,6,8,13,1,117,1,124,6,125,9,125,17,129,23,1,23,1,23" HREF="hosting.php?menu=hosting">
        <AREA SHAPE=POLY COORDS="133,1,238,1,245,8,245,18,248,22,248,23,130,23,126,17,126,8,133,1" HREF="design.php?menu=design">
        </MAP>
        <img src="images/menu_alanadi.gif" usemap="#alan_adi" width="370" height="23" border="0">';
  }
?>