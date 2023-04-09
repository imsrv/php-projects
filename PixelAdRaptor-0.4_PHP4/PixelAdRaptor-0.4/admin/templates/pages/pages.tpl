<div style="font-size: 15px; font-weight: bold; color: #435e82; text-align: left;">
  <p>Static pages.</p>
</div>

<div class="wrapper">

<div style="width: 410px;">
  <span style="text-align: left;">{scal:errors}</span>  
  <form action="" method="post">
    
    <div class="row">
      <span class="label">Page title (title tags):</span>
      <span class="formw">
       <input type="text" name="title" id="title" value="{scal:title}" class="form-item" maxlength="250" />
      </span>
    </div>
    <div class="row">
      <span class="label">Page url (for example 'test'):</span>
      <span class="formw">
        <input type="text" name="url" id="url" value="{scal:url}" class="form-item" maxlength="250" />
      </span>
    </div>  
    <div class="row">
      <span class="label"></span>
      <span class="formw">
       <img src="templates/images/bold.gif" alt="Bold" onclick="return addBold('content');" />
       <img src="templates/images/italic.gif" alt="Italic" onclick="return addItalic('content');" />
       <img src="templates/images/underline.gif" alt="Underline" onclick="return addUnderline('content');" />       
      </span>
    </div>
    <div class="row">
      <span class="label">Content:</span>
      <span class="formw">
        <textarea name="content" id="content" class="form-item" style="height: 400px; width: 400px;">{scal:content}</textarea>
      </span>
    </div>    
    <div class="row">
      <span class="label"></span>
      <span class="formw">
        <input type="submit" name="submit" class="button" value="Create page" />
      </span>
    </div>
    {scal:error_js}
  </form>
</div>

</div>

<div class="Vspace"></div>
[include:templates/pages/{scal:subpage}]