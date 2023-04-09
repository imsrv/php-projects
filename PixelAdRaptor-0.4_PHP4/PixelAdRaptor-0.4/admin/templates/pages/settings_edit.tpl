<div style="font-size: 15px; font-weight: bold; color: #435e82; text-align: left;">
  <p>Edit navigation link.</p>
</div>

<div class="wrapper">

<div style="width: 410px;">
  <span style="text-align: left;">{scal:errors}</span>  
  <form action="" method="post">
    
    <div class="row">
      <span class="label">Link URL:</span>
      <span class="formw">
       <input type="hidden" name="id" value="{scal:id}" />      
       <input type="text" name="url" id="url" class="form-item" value="{scal:url}" maxlength="250" />
      </span>
    </div> 
    <div class="row">
      <span class="label">Link Title:</span>
      <span class="formw">
        <input type="text" name="title" id="title" class="form-item" value="{scal:title}" maxlength="250" />
      </span>
    </div>
       
    <div class="row">
      <span class="label"></span>
      <span class="formw">
        <input type="submit" name="submit_edit" class="button" value="Save modifications" />
        <input type="button" value="Back" class="button" onclick="return location.href = 'index.php?page=settings'" />        
      </span>
    </div>
    {scal:error_js}
  </form>
</div>

</div>