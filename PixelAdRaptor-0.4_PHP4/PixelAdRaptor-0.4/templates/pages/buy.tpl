<div class="adsense" style="{scal:adsense_style}">
  {scal:adsense}
</div>

<div style="text-align: left; padding-left: 10px; font-size: 15px; font-weight: bold; color: #435e82;">
  <p>Fill the following form to complete your request.</p>
</div>

<div style="width: 410px; text-align: center;">  
  <span style="text-align: left;">{scal:errors}</span>
  
  <form action="" method="post" enctype="multipart/form-data">
    <div class="row">
      <span class="label">Name:</span>
      <span class="formw">
       <input type="text" name="name" id="name" maxlength="50" class="form-item" value="{scal:name}" />
       <input type="hidden" id="predefined_price" name="predefined_price" value="{scal:predefined_price}" />
       <input type="hidden" id="hidden_price" name="price" value="{scal:price_}" />      
      </span>
    </div>
    <div class="row">
      <span class="label">Email:</span>
      <span class="formw"><input type="text" name="email" id="email" maxlength="250" class="form-item" value="{scal:email}" /></span>
    </div>
    <div class="row">
      <span class="label">X_1 position:</span>
      <span class="formw">
      {scal:x_1}
      <input type="hidden" name="x" value="{scal:x_1}" />
      </span>
    </div>
    <div class="row">
      <span class="label">Y_1 position:</span>
      <span class="formw">
      {scal:y_1}
      <input type="hidden" name="y" value="{scal:y_1}" />
      </span>
    </div>
    <div class="row">
      <span class="label">Width (in blocks):</span>
      <span class="formw"><input type="text" name="width" id="width" maxlength="3" class="form-item" style="width: 30px;" value="{scal:width}" onchange="return calculate();" /></span>
    </div>  
    <div class="row">
      <span class="label">Height (in blocks):</span>
      <span class="formw"><input type="text" name="height" id="height" maxlength="3" class="form-item" style="width: 30px;" value="{scal:height}" onchange="return calculate();" /></span>
    </div> 
    <div class="row">
      <span class="label">Website link:</span>
      <span class="formw"><input type="text" name="link" id="link" maxlength="250" class="form-item" value="{scal:link}" /></span>
    </div> 
    <div class="row">
      <span class="label">Message (link title):</span>
      <span class="formw"><input type="text" name="title" id="title" maxlength="50" class="form-item" value="{scal:title}" /></span>
    </div>
    <div class="row">
      <span class="label">Image:</span>
      <span class="formw"><input type="file" name="file" /></span>
    </div> 
    <div class="row">
      <span class="label">Allowed file types:</span>
      <span class="formw">*.jpg, *jpeg, *.gif, *.png, *.bmp. Not animated!</span>
    </div>
    <div class="Vspace"></div>
    <div class="row">
      <span class="label">Price:</span>
      <span class="formw" style="font-weight: bold;" id="price_">{scal:price}</span>
    </div>
    <div class="row">
      <span class="label"></span>
      <span class="formw">
       <input type="image" src="templates/images/paypal.gif" name="submit" onclick="return this.form.submit();" /></span>
    </div>
    {scal:error_js}
    <div class="Vspace"></div>
  </form>
</div>