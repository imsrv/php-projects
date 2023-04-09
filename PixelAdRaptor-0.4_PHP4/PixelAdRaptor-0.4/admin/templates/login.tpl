<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html 
          PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
          "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <title>Admin</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link href="templates/scripts/style.css" rel="stylesheet" type="text/css" />
  </head>
 <body>
   
<div style="width: 410px; text-align: center;">
   
<span style="text-align: left;">{scal:errors}</span>

<form action="" method="post">
  <div class="row">
    <span class="label">Login:</span>
    <span class="formw"><input type="text" name="login" id="login" maxlength="50" class="form-item" value="{scal:login}" style="width: 150px;" /></span>
  </div>
  <div class="row">
    <span class="label">Password:</span>
    <span class="formw"><input type="password" name="password" id="password" class="form-item" style="width: 150px;" /></span>
  </div>  
  <div class="row">
    <span class="label"></span>
    <span class="formw">
      <input type="submit" name="submit" value="Login" class="button" />
    </span>
  </div>
  {scal:error_js}
</form>

</div>

 </body>
</html>