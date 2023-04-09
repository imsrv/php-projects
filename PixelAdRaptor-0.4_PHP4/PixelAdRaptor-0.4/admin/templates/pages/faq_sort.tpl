<div style="font-size: 15px; font-weight: bold; color: #435e82; text-align: left;">
  <p>Sort questions.</p>
</div>

<div class="wrapper">

<div style="width: 410px;">
  <span style="text-align: left;">{scal:errors2}</span>  
  <form action="" method="post">
    
    <div class="row">
      <span class="label">Weight</span>
      <span class="formw" style="font-weight: bold;">Question</span>
    </div>
    
    {loop:faq}
    <div class="row">
      <span class="label" style="width: 140px;">
        <input type="button" class="button" value="Edit" onclick="location.href = 'index.php?page=faq&amp;act=edit&amp;id={faq.id}';" />
        <input type="button" value="Delete" class="button" onclick="if (confirm('Do you really want to delete this question?')) { location.href = 'index.php?page=faq&amp;act=delete&amp;id={faq.id}'; }" />             
        <input type="text" name="weight[]" value="{faq.weight}" class="form-item" style="width: 20px;" maxlength="2" />
      </span>
      <span class="formw">
        {faq.question}
      </span>     
    </div>
    {endloop:faq}
    
    <div class="row">
      <span class="label"></span>
      <span class="formw">
        <input type="submit" name="submit_sort" class="button" value="Apply" />
      </span>
    </div>
    {scal:error_js2}        
  </form>
  
</div>

</div>