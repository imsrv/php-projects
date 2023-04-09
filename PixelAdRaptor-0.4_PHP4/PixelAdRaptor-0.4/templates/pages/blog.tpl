<div class="adsense" style="{scal:adsense_style}">
  {scal:adsense}
</div>
<div style="text-align: left; padding-left: 10px; font-size: 15px; font-weight: bold; color: #435e82;">
  <p>Blog</p>
</div>

<div class="blog_wrapper">
{loop:entries}
<div class="blog">
 <div class="blog_title">{entries.title}</div>
 <div class="blog_text"><blockquote class="quote"><div>{entries.text}</div></blockquote></div>
 <div class="blog_date">{entries.date}</div>
</div>
{endloop:entries}
</div>

<div class="adsense" style="{scal:adsense_style}">
  {scal:adsense}
</div>

