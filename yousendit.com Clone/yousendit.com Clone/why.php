<?php
require_once("include/vars.php");
require_once("include/functions.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title><?=SITE_NAME?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="style.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="740" border="0" align="center" cellpadding="0" cellspacing="0" style="border: solid 1px #999999">
  <tr>
    <td><?php
	require_once("header.php");
	?></td>
  </tr>
  <tr>
    <td valign="top"> 
      <table width="100%" border="0" cellspacing="0" cellpadding="2">
        <tr> 
          <td><table width="70%" border="0" align="center" cellpadding="2" cellspacing="0">
              <tr> 
                <td class="ltxt"> <h4>Why <?=SITE_NAME?>?</h4>
                  <hr> </td>
              </tr>
              <tr> 
                <td class="ltxt"><div align="justify"><strong> 
                    <?=SITE_NAME?>
                    is easy, fast, secure, safe, and lets you send large files.</strong><br>
                    <br>
                  </div>
                  <P align="justify">If you have ever experienced <A 
            href="<?=HostURL()?>">
                    <?=HostURL()?>
                    </A> or <strong>
                    <?=SITE_NAME?>
                    </strong> Enterprise Server, you already know the answer to 
                    this question: You find yourself effortlessly working with 
                    its easy to use interface, having complete confidence that 
                    your data will get to its destination without errors, risk, 
                    or confusion. Feeling comfortable with the knowledge that 
                    your sensitive information is completely safe and secure. 
                  </P>
                  <P align="justify"><strong>
                    <?=SITE_NAME?>
                    </strong> is the only true complete solution. You don’t have 
                    to take our word for it. The proof is below. The Comparison 
                    table shows you how other methods compare to <strong>
                    <?=SITE_NAME?>
                    </strong>.</P>
                  <H4 align="justify" class="ltxt">Key Benefits</H4>
                  <P align="justify"><B>Easy of Use </B>3 simple steps on one 
                    web page! No account nor files to maintain. </P>
                  <P align="justify"><B>Safety </B>Your data goes to who you want 
                    it to and nobody else. No risk of having old data end up in 
                    the wrong hands.</P>
                  <P align="justify"><B>Send Large Files </B>Up to 1000MB (1GB).</P>
                  <P align="justify"><B>Simply the fastest data transfer system 
                    available </B><strong>
                    <?=SITE_NAME?>
                    </strong> had been designed to be lightning fast in order 
                    to provide the best user experience. </P>
                  <P align="justify"><B>Data Security </B>Encrypted HTTPS session 
                    (SSL/TLS) to make sure your data is secure.</P>
                  <P align="justify"><STRONG>Uses Typical Firewall Permissions 
                    </STRONG>If you can browse the Web, you can use <strong>
                    <?=SITE_NAME?>
                    </strong>. </P>
                  <P align="justify"><B>Proven Technology </B>Millions of people 
                    use it.</P>
                  <P align="justify"><B>Value </B><A 
            href="<?=HostURL()?>">
                    <?=HostURL()?>
                    </A> is completely free.</P>
            </td>
              </tr>
              <tr>
                <td class="ltxt"><strong><a href="index.php">&laquo; Back</a></strong></td>
              </tr>
            </table>
            <br>
          </td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td>
	<?php
	require_once("footer.php");
	?>
	</td>
  </tr>
</table>  
</body>
</html>
