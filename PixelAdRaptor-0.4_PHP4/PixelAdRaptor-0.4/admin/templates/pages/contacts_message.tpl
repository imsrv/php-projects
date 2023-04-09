<div class="wrapper">

<div style="width: 410px;">
    
    <div class="row">
      <span class="label">Author:</span>
      <span class="formw">{scal:name}</span>
    </div>
    <div class="row">
      <span class="label">Email:</span>
      <span class="formw"><a href="mailto:{scal:email}" class="link">{scal:email}</a></span>
    </div>
    <div class="row">
      <span class="label">Subject:</span>
      <span class="formw">{scal:subject}</span>
    </div>
    <div class="row">
      <span class="label">Message:</span>
      <span class="formw">{scal:message}</span>
    </div>
    <div class="row">
      <span class="label"></span>
      <span class="formw">
       <input type="button" value="Reply" class="button" onclick="return location.href = 'index.php?page=contacts&amp;act=read&amp;id={scal:id}&amp;reply=true'" />
       <input type="button" value="Delete" class="button" onclick="if (confirm('Do you really want to delete this message?')) { location.href = 'index.php?page=contacts&amp;act=delete&amp;id={scal:id}'; }" />
       <input type="button" value="Back" class="button" onclick="return location.href = 'index.php?page=contacts'" />
      </span>
    </div>    
    
    <span style="{scal:reply}">
    <div class="Vspace"></div>
    <span style="text-align: left;">{scal:errors}</span>  
    <form action="" method="post">
    <div class="row">
      <span class="label">Subject:</span>
      <span class="formw">
        <input type="text" value="Re: {scal:subject}" name="subject" class="form-item" id="subject" />
      </span>
    </div>
    <div class="row"">
      <span class="label">Message:</span>
      <span class="formw">
        <textarea rows="0" cols="0" name="message" class="form-item" id="message">{scal:reply_msg}</textarea>
      </span>
    </div>
    <div class="row">
     <span class="label"></span>
     <span class="formw">
      <input type="submit" value="Send" name="submit" class="button" />
     </span>
    </div>
    {scal:error_js}    
    </form>
  </span>
    
</div>

</div>

<div class="Vspace"></div>
