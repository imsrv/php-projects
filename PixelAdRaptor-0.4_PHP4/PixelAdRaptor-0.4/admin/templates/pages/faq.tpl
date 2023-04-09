<div style="font-size: 15px; font-weight: bold; color: #435e82; text-align: left;">
  <p>Manage FAQ.</p>
</div>

<div class="wrapper">

<div style="width: 410px;">
  <span style="text-align: left;">{scal:errors1}</span>  
  <form action="" method="post">
    
    <div class="row">
      <span class="label">Question:</span>
      <span class="formw">
        <textarea cols="0" rows="0" style="height: 100px;" name="question" id="question" class="form-item">{scal:question}</textarea>
      </span>
    </div>
    <div class="row">
      <span class="label">Answer:</span>
      <span class="formw">
        <textarea cols="0" rows="0" style="height: 100px;" name="answer" id="answer" class="form-item">{scal:answer}</textarea>
      </span>
    </div>    
    <div class="row">
      <span class="label"></span>
      <span class="formw">
        <input type="submit" name="submit_q" class="button" value="Add question to FAQ" />
      </span>
    </div>
    {scal:error_js1}
  </form>
</div>

</div>

[include:templates/pages/{scal:subpage}]

