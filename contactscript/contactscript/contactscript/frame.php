<?php
      $pg = $_GET[pg];
      ?><title>Frame</title>
<table width=800px  border=0 align=center cellpadding=0 cellspacing=0>
  <tr>
    <td bgcolor=#000066><table width=100%  border=0 cellspacing=5 cellpadding=5>
      <tr>
        <td><center><center><form method="post">
<input type="button" value="Close Window"
onclick="window.close()">
</form></center></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><iframe
        src="<? echo $pg ?>" width=100%
        height=800
        border=0
        frameborder=0
        scrolling=yes
        name=main></iframe></td>
  </tr>
</table>
<title>Frame </title>
             