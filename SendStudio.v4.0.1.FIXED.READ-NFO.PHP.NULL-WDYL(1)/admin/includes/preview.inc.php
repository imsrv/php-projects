<?php

	$Type = @$_REQUEST["Type"];
	$SubAction = @$_REQUEST["SubAction"];

	// We're previewing a template
	if($SubAction == "Template")
	{
		?>
			<html>
			<head>
			<title>Preview</title>
			<script>

				<?php if($Type == "HTML") { ?>

				document.write(window.opener.foo.document.body.innerHTML);
				document.write(window.opener.foo2.document.body.innerHTML);
				document.close();

				<?php } else { ?>

				var tContent = window.opener.document.all.TEXTHEADER.value;
				var tContent1 = window.opener.document.all.TEXTFOOTER.value;

				tContent = tContent.replace(/\r\n/g,"<br>");
				tContent1 = tContent1.replace(/\r\n/g,"<br>");

				document.write(tContent);
				document.write(tContent1);
				document.close();

				<?php } ?>

			</script>
			</head>
			<body style="font-family:arial; font-size:8pt; margin:10">


			</body>
			</html>
		<?php
	}
	else
	{
		// We're previewing a newsletter
		?>
			<html>
			<head>
			<title>Preview</title>
			<script>

				<?php if($Type == "HTML") { ?>

				document.write(window.opener.foo.document.body.innerHTML);
				document.close();

				<?php } else { ?>

				var tContent = window.opener.document.all.TEXTBODY.value;
				tContent = tContent.replace(/\r\n/g,"<br>");

				document.write(tContent);
				document.close();

				<?php } ?>

			</script>
			</head>
			<body style="font-family:arial; font-size:8pt; margin:10">


			</body>
			</html>
		<?php
	}
?>