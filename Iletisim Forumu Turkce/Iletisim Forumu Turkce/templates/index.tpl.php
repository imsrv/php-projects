<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<link href="css/style.css" rel="stylesheet" type="text/css">
<body topmargin="0" leftmargin="30">
<table cellpadding="1" width="702" cellspacing="1" border="0"
<tr>
    <td class="tdmain" style="border: 0px solid #BFBFBF;">
    <form method="POST" action="index.php?cmd=send">
    <table cellspacing="1" width="80%" align="left">
    <tr>
        <td width="30%">&nbsp;</td>
        <td width="70%"><b><?php echo $this->REQUIREDFIELDS; ?></b></td>
    </tr>
    <tr>
        <td class="headbox"><?php echo $this->NAME; ?>:</td>
        <td>
        <p align="left"><input class="formbox" type="text" name="name" size="30"> <?php echo $this->IS_NAME_REQUIRED; ?></td>
    </tr>
    <tr>
        <td class="headbox"><b><?php echo $this->SUBJECT; ?>:</b></td>
        <td><input class="formbox" type="text" name="subject" size="30"> <?php echo $this->IS_SUBJECT_REQUIRED; ?></td>
    </tr>
    <tr>
        <td class="headbox"><b><?php echo $this->EMAIL; ?>:</b></td>
        <td><input class="formbox" type="text" name="email" size="30"> <?php echo $this->IS_EMAIL_REQUIRED; ?></td>
    </tr>
    <tr>
        <td class="headbox"><b><?php echo $this->COMMENTS; ?>:</b></td>
        <td><textarea cols="29" rows="8" name="comments"></textarea> <?php echo $this->IS_COMMENTS_REQUIRED; ?></td>
    </tr>
    <tr>
    <td colspan="2"><br>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <input class="formbox" type="submit" value="<?php echo $this->SEND; ?>" title="<?php echo $this->SEND; ?>"> <input class="formbox" type="reset" value="<?php echo $this->CLEAR; ?>" title="<?php echo $this->CLEAR; ?>"></td><p align="left">
    </tr>
    </table>
    </form>
    </td>
</tr>