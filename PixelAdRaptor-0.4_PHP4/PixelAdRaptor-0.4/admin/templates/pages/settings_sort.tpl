<div style="font-size: 15px; font-weight: bold; color: #435e82; text-align: left;">
  <p>Manage navigation links.</p>
</div>

<div class="wrapper">

<div style="width: 510px;">
  <span style="text-align: left;">{scal:errors2}</span>  
  <form action="" method="post">
    
    <div class="row">
      <span class="label" style="text-align: left;">Weight and Options</span>
      <span class="formw" style="font-weight: bold;">Title</span>
    </div>
    
    {loop:links}
    <div class="row">
      <span class="label" style="width: 250px; text-align: left;">
        <input type="button" class="button" value="Edit" onclick="location.href = 'index.php?page=settings&amp;act=edit&amp;id={links.id}';" />
        <input type="button" value="Delete" class="button" onclick="if (confirm('Do you really want to delete this link?')) { location.href = 'index.php?page=settings&amp;act=delete&amp;id={links.id}'; }" />             
        <input type="button" value="{links.activation}" class="button" onclick="location.href = 'index.php?page=settings&amp;act=toogle&amp;id={links.id}';" />
        <input type="text" name="weight[]" value="{links.weight}" class="form-item" style="width: 20px;" maxlength="2" />
      </span>
      <span class="formw" style="background-color: {links.color}; width: 300px;">
        {links.title}
      </span>     
    </div>
    {endloop:links}
    
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