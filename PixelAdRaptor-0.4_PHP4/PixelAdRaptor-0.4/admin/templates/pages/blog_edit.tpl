<div style="font-size: 15px; font-weight: bold; color: #435e82; text-align: left;">
  <p>Blog.</p>
</div>

<div class="wrapper">

<div style="width: 410px;">
  <span style="text-align: left;">{scal:errors}</span>  
  <form action="" method="post">
    
    <div class="row">
      <span class="label">Entry subject:</span>
      <span class="formw">
       <input type="text" name="title" id="title" value="{scal:title}" class="form-item" maxlength="250" />
       <input type="hidden" name="id" value="{scal:id}" />
      </span>
    </div>
 
    <div class="row">
      <span class="label"></span>
      <span class="formw">
       <img src="templates/images/bold.gif" alt="Bold" onclick="return addBold('text');" />
       <img src="templates/images/italic.gif" alt="Italic" onclick="return addItalic('text');" />
       <img src="templates/images/underline.gif" alt="Underline" onclick="return addUnderline('text');" />       
      </span>
    </div>
    <div class="row">
      <span class="label">Text:</span>
      <span class="formw">
        <textarea name="text" id="text" class="form-item" style="height: 400px; width: 400px;" rows="0" cols="0">{scal:text}</textarea>
      </span>
    </div>    
    <div class="row">
      <span class="label"></span>
      <span class="formw">
        <input type="submit" name="submit_edit" class="button" value="Save changes" />
        <input type="button" value="Back" class="button" onclick="return location.href = 'index.php?page=blog'" />                        
      </span>
    </div>
    {scal:error_js}
  </form>
</div>

</div>

<div class="Vspace"></div>
