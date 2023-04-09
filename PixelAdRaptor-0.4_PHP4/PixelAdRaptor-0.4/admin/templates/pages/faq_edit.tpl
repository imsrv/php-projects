<div style="font-size: 15px; font-weight: bold; color: #435e82; text-align: left;">
  <p>Edit FAQ question.</p>
</div>

<div class="wrapper">

<div style="width: 410px;">
  <span style="text-align: left;">{scal:errors2}</span>  
  <form action="" method="post">
    
    <div class="row">
      <span class="label">Question:</span>
      <span class="formw">
        <textarea cols="0" rows="0" style="height: 100px;" name="question_e" id="question_e" class="form-item">{scal:question_e}</textarea>
      </span>
    </div>
    <div class="row">
      <span class="label">Answer:</span>
      <span class="formw">
        <textarea cols="0" rows="0" style="height: 100px;" name="answer_e" id="answer_e" class="form-item">{scal:answer_e}</textarea>
      </span>
    </div>    
    <div class="row">
      <span class="label"></span>
      <span class="formw">
        <input type="submit" name="submit_edit" class="button" value="Save modifications" />
        <input type="button" value="Back" class="button" onclick="return location.href = 'index.php?page=faq'" />        
      </span>
    </div>
    {scal:error_js2}
  </form>
</div>

</div>