<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html 
     PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
 <head>
  <title>{scal:w_title} - {scal:w_subtitle}</title>
  <base href="{scal:w_siteurl}" />    
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta name="description" content="{scal:w_description}" />  
  <link href="templates/scripts/style.css" rel="stylesheet" type="text/css" />
  <link rel="icon" href="templates/images/favicon.ico" />
  <link rel="shortcut icon" href="templates/images/favicon.ico" />  
  <script src="templates/scripts/script.js" type="text/javascript"></script>
 </head>
 <body onload="{scal:onload}">
  <div class="container">
   <div class="header">
   <div style="padding: 15px;">{scal:w_slogan}</div>
    <div class="header_stats">
     <div style="font-size: 12px; position: relative; top: 7px; padding-right: 8px;">{scal:sold}</div>
     <div style="font-size: 12px; position: relative; top: 11px; padding-right: 8px;">{scal:available}</div>     
    </div>
   </div>
   <div class="header_nav">
    <div class="header_div">
     {loop:header_links}
      <a href="{header_links.url}" class="header_link" title="{header_links.title}">{header_links.title}</a>{header_links.space}
     {endloop:header_links}
    </div>
   </div>
   <div class="center">
    [include:{scal:page}]
   </div>
   <div class="Vspace"></div>
   <div class="bottom" style="{scal:grid_hack}">
    &copy; 2005 <a href="http://pxraptor.phpwood.com/" class="link" title="Your Million Pixel Page Engine">PixelAdRaptor</a> / <a href="http://validator.w3.org/check?uri=referer" class="link">Valid XHTML Strict!</a>  
   </div>
  </div>
  <script src="templates/scripts/wz_tooltip.js" type="text/javascript"></script>    
 </body>
</html>