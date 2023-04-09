<div class="adsense" style="{scal:adsense_style}">
  {scal:adsense}
</div>

<div class="grid" id="grid" onclick="return getPosition(event);" onmouseover="return escape('These pixels are available, click on the spot where you want your ad placed.');""></div>

<div style="position: relative;">
 {loop:ads}
 <a href="Redir/{ads.id}" style="position: absolute; left: {ads.x}px; top: {ads.y}px; z-index: 1;" title="{ads.title}">
  <img src="images/{ads.file}" alt="{ads.title}" />
 </a>
 {endloop:ads}
</div>

<form action="Buy" method="post" id="grid_form">
 <input type="hidden" name="x" />
 <input type="hidden" name="y" />
</form>