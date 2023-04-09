<div class="adsense" style="{scal:adsense_style}">
  {scal:adsense}
</div>

<div style="text-align: left; padding-left: 10px; font-size: 15px; font-weight: bold; color: #435e82;">
  <p>Frequently Asked Questions</p>
</div>

<ul>
 {loop:faq}
 <li>
   <a href="FAQ#" class="link" onclick="return faq('id_{faq.id}');">{faq.question}</a>
 </li>
 <li id="id_{faq.id}" style="list-style-type: none; display: none;" class="faq_answer">{faq.answer}</li>
 {endloop:faq}
</ul>

<div class="adsense" style="{scal:adsense_style}">
  {scal:adsense}
</div>