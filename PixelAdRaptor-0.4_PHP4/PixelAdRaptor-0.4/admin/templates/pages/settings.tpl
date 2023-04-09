<div style="font-size: 15px; font-weight: bold; color: #435e82; text-align: left;">
  <p>System settings.</p>
</div>

<div class="wrapper">

<div style="width: 410px;">
  <span style="text-align: left;">{scal:errors}</span>  
  <form action="" method="post">
    
    <div class="row">
      <span class="label">Website title (title tags):</span>
      <span class="formw">
        <textarea cols="0" rows="0" style="height: 100px;" name="w_title" id="w_title" class="form-item">{scal:w_title}</textarea>
      </span>
    </div>
    <div class="row">
      <span class="label">Website URL (with the trailing slash):</span>
      <span class="formw">
        <input type="text" value="{scal:w_siteurl}" name="w_siteurl" id="w_siteurl" class="form-item" />
      </span>
    </div>    
    <div class="row">
      <span class="label">Website description (meta):</span>
      <span class="formw">
        <textarea cols="0" rows="0" style="height: 100px;" name="w_description" id="w_description" class="form-item">{scal:w_description}</textarea>
      </span>
    </div>
    <div class="row">
      <span class="label">Slogan (pixel price for example):</span>
      <span class="formw">
        <textarea cols="0" rows="0" style="height: 100px;" name="w_slogan" id="w_slogan" class="form-item">{scal:w_slogan}</textarea>
      </span>
    </div> 
    <div class="row">
      <span class="label">Pixel price:</span>
      <span class="formw">
        <input type="text" style="width: 30px;" value="{scal:w_price}" name="w_price" id="w_price" class="form-item" />
      </span>
    </div> 
    <div class="row">
      <span class="label">Business email (for Paypal):</span>
      <span class="formw">
        <input type="text" value="{scal:w_business}" name="w_business" id="w_business" class="form-item" />
      </span>
    </div>          
    <div class="row">
      <span class="label"></span>
      <span class="formw">
        <input type="submit" name="submit_settings" class="button" value="Save settings" />
      </span>
    </div>
    {scal:error_js}
  </form>
</div>
<div class="Vspace"></div>

</div>

[include:templates/pages/{scal:subpage}]

<div class="wrapper">

<div style="font-size: 15px; font-weight: bold; color: #435e82; text-align: left;">
  <p>Add navigation links.</p>
</div>

<div style="width: 410px;">
  <span style="text-align: left;">{scal:errors2}</span>  
  <form action="" method="post">
    
    <div class="row">
      <span class="label">Link URL:</span>
      <span class="formw">
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
      <span class="label">Link weight:</span>
      <span class="formw">
        <select name="weight">
         <option value="0" selected="selected">0</option>
         <option value="1">1</option>
         <option value="2">2</option>
         <option value="3">3</option>
         <option value="4">4</option>
         <option value="5">5</option>
         <option value="6">6</option>
         <option value="7">7</option>
         <option value="8">8</option>
         <option value="9">9</option>
         <option value="10">10</option>         
        </select>
      </span>
    </div>    
    <div class="row">
      <span class="label"></span>
      <span class="formw">
        <input type="submit" name="submit_nav" class="button" value="Add navigation link" />
      </span>
    </div>
    {scal:error_js2}
  </form>
</div>

</div>
