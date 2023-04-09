<div style="font-size: 15px; font-weight: bold; color: #435e82; text-align: left;">
  <p>Manage your adsense ads.</p>
</div>

<div class="wrapper">

<div style="width: 410px;">
  <span style="text-align: left;">{scal:errors}</span>  
  <form action="" method="post">
    
    <div class="row">
      <span class="label">Adsense code:</span>
      <span class="formw">
        <textarea cols="0" rows="0" id="adsense_code" name="adsense_code" class="form-item">{scal:adsense_code}</textarea>
      </span>
    </div>
    <div class="row">
      <span class="label">Is adsense ads enabled?</span>
      <span class="formw">
       <select name="enabled">
        <option value="0"{scal:selected_0}>No</option>
        <option value="1"{scal:selected_1}>Yes</option>
       </select>
      </span>
    </div>    
    <div class="row">
      <span class="label"></span>
      <span class="formw">
        <input type="submit" name="submit" class="button" value="Submit" />
      </span>
    </div>
    {scal:error_js}
  </form>
</div>

</div>
