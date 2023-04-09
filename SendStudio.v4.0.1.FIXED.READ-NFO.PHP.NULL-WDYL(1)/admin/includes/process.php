<?php

	class rc4crypt {
		function endecrypt ($pwd, $data, $case='') {
		if ($case == 'de') {
		$data = urldecode($data);
		}

		$key[] = "";
		$box[] = "";
		$temp_swap = "";
		$pwd_length = 0;

		$pwd_length = strlen($pwd);

		for ($i = 0; $i <= 255; $i++) {
		$key[$i] = ord(substr($pwd, ($i % $pwd_length), 1));
		$box[$i] = $i;
		}

		$x = 0;

		for ($i = 0; $i <= 255; $i++) {
		$x = ($x + $box[$i] + $key[$i]) % 256;
		$temp_swap = $box[$i];

		$box[$i] = $box[$x];
		$box[$x] = $temp_swap;
		}

		$temp = "";
		$k = "";

		$cipherby = "";
		$cipher = "";

		$a = 0;
		$j = 0;

		for ($i = 0; $i < strlen($data); $i++) {
		$a = ($a + 1) % 256;
		$j = ($j + $box[$a]) % 256;

		$temp = $box[$a];
		$box[$a] = $box[$j];

		$box[$j] = $temp;

		$k = $box[(($box[$a] + $box[$j]) % 256)];
		$cipherby = ord(substr($data, $i, 1)) ^ $k;

		$cipher .= chr($cipherby);
		}

		if ($case == 'de') {
		$cipher = urldecode(urlencode($cipher));

		} else {
		$cipher = urlencode($cipher);
		}

		return $cipher;
		}
	}

	/* DECRYPTED
	$ssEnc = "%DC%27D%1F%25kK%E4%9A%94S%E3%97%BB%92g%3A%87%8AQ%BBp%0An%C2k%05%A0nI%02%E0pAn%40%1DS%B7%E7h0%B2%9A%1FL%93N%03%87%ABt%EB%D3%86%91%B4%FD%1E%CF%DBy%1Fv%11%25%C3%9B%8At%5D%81%A4n%D7%F6%E6%9D%9F%AD%B2m%2F%04%CA1%EC%FC%B9pn%A1%8D%9E%C8%BF%5C%94%1F%F9%60%F6%A3%FD%CDb%F2%99%24%EB%EE%03%1C%FAw%3Dn%BA%0B%8A%AD%B3%B4%DD%D3X%19%FA%0B%A8%A1%8EO7kU6%B4%18%5Dt%A4%E4%07%B0ur%8AM%F5%C4j%24oUD%A6%2Cp%3DG%13%22%AC%85%CA%FD%94KX%FD%21i%3B%E3d%D5%A4d%C4-%8BYln%2A%29W%DC%9E%A8%7Cyggl%CDp%F5%D0t%0D%D9%80%C6%13%27%EE%FB%FAx%BE%17%BE%C0%93%EE%3C%5D%C4E%23%23Qm%12%81%D5%EB%FC%BF%86%B8%A6%9B%A5j%02%1E%DE%05%88%19%D7%EF%A7%2A%01%7C%C1%3Cr%CA%2B%F5%9E%EE%98%EE%D9%12K%5B%E8%22%94n%3E%AF%93%60%F1%28%D9%7B%EE%E7%3F1%F1%1C%AC%0DZ%DD%D8%87-%F2%9A%CDH%F5Z%0C%D0%DA%E0FK%C0%B8%F8%C7%84%AE%B4%14%94V0%00UX%91%9E%EB%DF%29%E9%14%C3%1Cg%3A%B6te%1C%FB%E1%FBJ%8Fx%19%89h%7Eo%3F%24%E3g%D7%29%051%BA%8E%1DL%E0%1B%FEo%7B%B9%C5j%2C%C5%99H%9E%AE%0C%D6%FF%B7Y%FFX%CF%7D%C3%1Dv%9F90%EE%97%B1w%26%DF%CC%23%B6%2Av%D1%C9%C5fq%02%2Fk%2A%F5%9E%7E%F6%96%DE%90%0E%88%17xA%9B%E0%EC%60%97K%8E%07%BD%E3%F7%B3%C7m%5C%21%29%8B%10%09%DA%B8%23%3B%93%EF%9B%FB%D5Z%2A%1B%A9%3D%09%ACp%E7%C58_%E0%2B%B9%9F%A7%CF%CE%9D%99%FC%B0B%BC%97%3BZ%E1%96%E5%83%A7%91%1A%8E%D5%60%1B5%2F%8C2%EF2%17%9E%DCJ%E2%C0%A7%D9e%1E%28%1E%F1-%B3%F3b%1D%83%95W%C83%80%99%87%E1l%92%C5%DA%ACY%98%10%B09%E3%E1%B3%FE%00%B8%F9%EA%08%10%94P%7B%99-%9DyH%F8U%95%BA%04%5E%EA%A8%1E%60u%10X%8D%3A%25%DBa%FC%21%19V%B7%9E%11%A3%C2%2C%F7%A4%F4%EC%A6%2CZ%05%B0%9E%BC%F0%E8%A4%13u%5E%93%3D%8C%16%CC%DA%7B%26%0A%CD%DE%AC%BC%F6%95%983z%26rzl%EB%9AOXa%2CI%FD4%5DEO%24%AF%7C%D5%7C%5E%D8I%40%A3%A3%EA%5E%1A%A7%EA%91%5D%28z%7B%AA%E9%FF%A8%E8%F8%ED%A0%3Fk%C9%18%FFs%A1%A19e%AD%09%98%18%08%EAoy%F0%1E%B1W%ADm%A7%1F%C8%3EO%C5%19%EB%9E%1D%88%D0Cl%E2K%19%84%A6%94%9Bt%F9%19%9B%C9%AB%C9%80%0D%A5%5B%E4h%B5%7E%BE%A2%B37%BD3%D6%8F%C5Ic%9F%26%A6%84%9Co%7F%9Fd%5E%B4K%C3%11%B3e%FD%EF%B7Q%E6%28%E6%92%11%85%FE%3D%CBT%E4%04S%C8%24%82%3AM2%7C%3C%15%B8%87%0AK%E2%26Ex%C2%A7%8B%B6K%9Eb%5B%C3%9B%DE%B0%D8%1B%E7%8ET%28E%88r%24%19%09%F0C%DF%9A%91%F9I%607%EE%CE%1B%5E%87%FE%EA%2F%9B%E0R%8B%1E%90h%05%8B%9C%B3QY%CB6%D5%1E%15u%9E%E6%9BJ%2A%AF%11%C8%C421%60%D4%9Cs%04%85%B4%8B%B09%87%09f%AB%1CD%CBg%90-%10%98+%223%12%96%92%BB%B7%CEMC%B2%B9%B7%13%03%C2%8F%CE%B4%D6%80%15%F4%19%80%CB%1Dh%7B%CB%04%C86z%E46%FC%9D%28%99%FBj-IaN%D1%2BD%A2%F1%7B%CFsn%8BH%3D%B5z%01%90%F4E%1A%00XX%3Ap%04%D9%DD%7Ed%3FN%EC%2A%05%B3%ED%8A%10%83%AD%0Ev%8Du%EA%0C%F4%84%F6%D1%28%FD%09%80%F9%C8A%81J%B61%06%1F%FA%A8%958%B2%DF%FB%83f%EA%F8%03%3B%C1%0CA%D7%16%87-%7Dt%B2H%E73%14%A3%5D%0E%FB1j%BD%2A%FBb%C2%041%04%87g%7B7%82%99%2Ff%EC%25%09D%E8%98%1D%CFO%D3%A8%F4X%F8%C5Ue%3A%1F%8B%D4%DB%28%EF%DC%DE%1D%EC%B6YKS%AB%B3%F49%1A1%93r%1B%93%9F%92%8A%9F%05%7E%1D%40%3BG%5B%2C%EB%5C%5E%FFt%00%B9_%8A%E5%DDU%B4%9B%BA%23c%12%D0%95%3C%E9ptY%80m5%22%7B%92%22%7C%2A%DAN%7B%A6%CEHb%24%C4%80%CF%CE%EAa%82%05%D7%29%07s%A1k%DE%AE%CF%BE%FC%A2%99%CD%D5%0F%ED%09%D30%ADug%AD%10%17%EA%92%C5%CA%7F%5B%CB%DC%0D%D8%83n%C8XT%C1%14%A1v5s%D1%EC6%2A%DB3%CCs78%08%F4R_%1F%B4Cv%8F%8D.2%B0%92%99%D1d%CE%85%EAr%EA_%2A%8F%1FH%C7%27%1Fu%DFa%3A%14%D3%2B%C0%1D%058%8E%D5%FD%7F%40j%91%8E%3F%C92%A9%80%01%0E%C2Q%D3%AB%FB%E8%BDF%12%40%A5%1DkY%C7%A8%B7%40%26r%95%EFCz%A3c%04%1C%A0%3B%9B%CA%16f%7D%3C%7F%A4%A2%24L%82%AC%F0%BEx%07%7D5%0A%8D%C1%C7%B7%5D%3EY%1C%BD%B6%BBw%03T%E0%7BL%60%83i%00%D9O%93%09%3CQ%FF%CDi%D52%25%AB%D2%BDf%E0%A9%ABD%FC%2F%8C%CC%C0%3F5%5E%03Hs%2A%BC%1E%99%5B%BA%89%7B%9C%A4%8B%1F%7FX%EF%88i%A9%1C%B6f%0F%D5%E7%12%84k%FE%24d%2F%CE%BF%235%A5%851%17%7C%0A%3F%D6%9C%2A%1C%A3%24%AFN%0A%D9%93%04%ADv%9A%95%D7%AE%3E%E5%C7%C4sap%BB.%E7%81%A7%F8%10%A4%1D%9A%8D%E8%03%40%12%C8%0F%9A%FAJ+%0E%FFP%9A%3F%E6%A9e%C1%8C%06%BA%D3%E9%B9p%C1%90%5B%14%D4E%A8%85X%E9%DB%90%8Bc%94%F2%146%F0%03%90%8CG%DE%26%F3%D2%D3%28%D5%9C%BF%C5%D2x%DB%92r%A5%10%8E%3F%8C%B4%2F%0C%05%ACX%CF%BF%14%00%ADEX%DC%9D7%09%E0%F2%DA%BA3C%E8%B8%F7%0F%27%10%CE%A5%8A%C5%40%F0%B6%DD%1F%98%96%9E%08%8B%7B%9C%E1%00%1AX%7Bh%2A%E6%D7%98%84%F5%D6%ADh%FA%10%22%2B%F9%B9%98S%A2%3B%21b%E6m%04%895%91%C6%9E%FD%F8%5B%3F%2B%A9%96%FF%E7%A3%BF%AD%B3%AE7L%EF%26Z%B9n%40%14%84%A2%3E%9C%06%DDL%97%0C%CA%1C4%FF%FE%08%9E%82%C4%7F%09T%5B%C6%8A%A5%2B%A9%D0+%83%D4%B7%FA%99%3B%8A%8D%21%8C%88%B7%84%7E%5CJ%A4%1C%AC7%3B%8Ae%0A%91%E9%7B%C6K%23%BA%08%98%98%CC%DE%E4%EE%B4%03t%D9%5DD%96q%A3%B1%F0%2C%A0%88%60%7D%AD%8A%27%CF6%C04%0D%9D%C0%AC%91%21J%B9%09%25l%3A%BF%95%8D%BA%BD%18Z%E5%199%12%F5%C7%C52%AEU+h%BE%FD%15%03jm%F2%03%AAE%BD%83Ie6%EA%95%0D%97%DB%EB%2F%18%BC%8F2%BBX%01E%BE%BA%FC%B3%BAJ%E1%CF%FF%A8%DC%1A%9E%EF%0BO%9E%110%D9%EFx%B2fg%29t%85%12%CB%3B%8C%F9J.A%B91%2F+%E7%C5%14%81%84%97+%D0%B9%D0%3Ef%95%EAx%85%A7%88%1F-%FF%CB%F0%D7%BA%28%83%C6%E5%EF%3C%24%1D%95Q%FB.%A6S%E4%86%C4J%3Bv%98%14%96%9A%94b%E6%D4%9F%3A%9AT%97%DA%A3%D5%1E%E51%C4%E8Am%03%E3%13%2C%8D%3E%FDg%E8%18%BE%9F%E5%19nX%E9%60%A4e%B3%9CguRc%FEY-j%03jg5j%2A%98%3D%05%DA%9FS%E2%FA%A4q%B2%C3a%D6a%8B%DC%DEH%BD2%5B%CC%8E%C1p%C7%E9%2C%0B%CAI%C3%F5%F4%1E%CB%97%2B%14%95d%CA%D1w9%0B%F2%925m%7B%E7f%DBo%F4%B9U%A6%A3%26I%19x%9A%8B%E5%DD%D0%DC%7B%F1%5D%1A%26%15%AB%DC%A2v%CC%1D%1F%D7%3C%FBXU%BF%3A%83%CAk%F9%11A%9E%A7W%3E%14%99%16%0EK%7DZqW%BF%D9e%CE%2F%2BE%7CV%BFO%D8%F7%D5%04%CF%DE%F9%82%FAO%26%FC%2A%17%95%F3%89z%B3%FF7Q%1E%07%40%D3%22l%D9tM%EE%FCN%88hA%1A%86%05%AC28%2C%97%BF%81%D8B%0Fr%01%C9%7F%F6%3D%1F%CC%23e%AF%186n6%0F%10%1F%7Bj%E8%E4Z5%7E%11M%E6%9A%00%F2%00%E6%02%91%B1%A73%17%07%B3%AD%F8%D8k%E6c%D9wS%40k%A9%E3%DB%0B2%E3%A7%A9%BFR%F3%98%15yi%BD%87%15%19%A2%16w%A8%A0%5E%B0%E7i%F93F%40%18%B7%BC%A0%29Q%91t%B3%96r%12%B2%B3E%1CC%05%F5%AA%17%C0%24%DA%B9DQ%99%86%D5aJ%AC%A8%C1%8D%D4d%18%3A%E2%B5%9DC%F6%E8%C75%B6%07%B3%11%D6%03o%BCS%EB%9D%B9%91-%AB%C4%3E%F3gJm%25E%ACx%A9%BBK%01%F6%9C.%5B%81%CA%17T%1F%0F%C3j%DA%A8%CB%E7U%FD%7F%19%0Bn%D8%5B%2A%5BDQr%81%9D%94%16%D4B%C6S%F3%AA%9E%CA%EB%1B%A7%3F%8C%5E%01%89%C2%9F%BD%7E%B1%BA%AF%97%8DX%E6%17h%15%81%ED%B3k%ADW%10rv%04%0C%F9%A5%C1vTR%F3%87xR%0AOd%BB%5D%90%E3%22%19%04%F7%8F%22-%8A%C3%C1%00%83M%3A%EF%8D%AC%9E%BF1%81%E6%C4%0D%A2%ED%04%A8%EA%0F%06%A6%08%02%E6L%A5%81G%C2%10i%8B%8CG%88%84%22%19%88%3F%993J%F9%DE%931H%87%AE%E2%CA%C5%3E%AF%7F%FE%89%18%9B%28%81%94E%09%7F%D5%87b%E4%8C%F8%AD%AD%08g%92%09%D744i%B9%29%08%97%AA%D3%C2%14J%BC%A3p%27%10%99%DE%9D%08a%01%2B1%9D%7DT%87%87z%DDL%F5V%3E%CE3%177i%1E%0D%3Er%05%8E%8EJ%9B%E6%BA%0E%C8x%3EM%CF%3E%09%CE%E2w%3AJ%F7%EC%5B%02%D0B%A9%5C%B7%9Dqi%11%7F%F9%D9%15YL%86%8B%BD%27%FE%23%88%D4%3D%D4%9EG%22%1F%3C%9B%AC%10%B6%A1%C3%F5%DA%24%ED%EF%CB%BD%3B%07%AFL%DDVX%3E%8D%A0%0F%AA%E7OC%24%BB%E2S%99%00%E6%D2.%9A%EC%81%B4%3B%3A%AC%D9%04A-%EF%B2%CC%80%B8%F4%FF%92%CF%F9p%E5%DB%C5l%95%DFn%C4%9F%8F%FF%E0%9D%B5%FD%8D%B6%B6%E1%5B%C4x%0D%24%0A%D8c%97%3A%007%5E%FF%FF%93%84%5D%F4B%F5%8F%C14q%B1%99%F6%B6%A4P6K%CFl%3F%08%CA%14%7Dt%B4Zg%A0%90%BAn0%B6UG%EC%FF%E8jt%85%C2S%89%B3%CEQ%C7%27tS%B0%7E%88%3C%3B%EF_%13h2Fa%A1%40%F1%BCq%88%88%15%00%D7Q%00%93%B6%DD%1C3%DA%29T%10X%A4%C7%BD%29O%1C%12%E2%FB%E4%2Ch%131%F9O92%FD%CA%8F%CB%A7%EB%F4%E4%97%D4%0CWH%86%C9%02%A07s%0B%EA%AF%8F.%16%26O7%E2%2F%1B%12%1A%1C%AE%E9%EB%84V%3C%BC%B4%AD%40%CB%E5L%D4X%28%7D%E3k%7B%1B%88%8B%89%97%C3%8E%5Bvh2%EE%05j%84%F47r%2B%06%E8%01O%A9%DFA%91%8B%24%A9%08x%3D%F8%7BC%D2j%07%09%CC%AE%7Dx%1D%16%D3%FC%CA6%BC%1A%27%A5v%98%B9%88%12%BA%A6%25%86JS%1F%1A%C7%F5L%0E%15%D8%E1%C3kr%8D%03%B1%E5dQ%BC%EE%5B%9D%7F%B6%A4%2A%C3%FBL%DFeu%A7N%EB%DDb%D6%7CP%E5%B2P%CC%7D%F2%95%F9%E8%ACx%FC%60%E1%EFC%3B%3B%B0b%E9QF%CD%A8%CF%CE%93%85%D7%CCd%BA%8ES9%F9%B0%FD%D8P%A2nn%3A%93%BCJ%8A%D3%89%AAn%8C%A5%87%AD%27%5Er%99%E5%FF%ED%AB%05%E4%97%9F%BE%B5%10l0%EFW%F0%8E%A5%5CL%E17%13%0A%A98r%8E%9D%5B%F4W%B9%2C%E7%D4Y%DCp%1A3I6x%19%08%A6%AF%BB%7F%90%83%040%0F%ED%2C%3F%A3%98pk%0D%FB%05%5D%F8%0E%D9m%A9%21%9D%98%E1%13%23%11i%0B0%5B%1A6N%AE%E8s+%FA%2B%87%B8%96%22rs%E16%04N%CAQ%CF1%F2%A8%89h%CB%0D%DE%08%ED%B3%A0%D8%0BV%F10%7Bl%80%F2%C0%A9%FA%CD_%60%A5%28%DFu%DC%25%03h%B6I%B3%D5%A5%11%B6%04%BC%28%E5%3C%BA+AH%0Ai%A7%8E%3E_%C4%07c%0C%F6%E9%A4%99%5C%81%3B2%28%1F%21%91%B4%F0%B2%B9%03%1E%C7%D5B9mv%C6%D7%F9%05%DC%EAI%96l%3DVH%29V%ED%C5x%10%D4%22%1F%DC%88%02%BA";


	$r = new rc4crypt;
	$d = $r->endecrypt("ssEnc3925", $ssEnc, "de");
	@eval(stripslashes($d));
*/
	function ss9024kwehbehb()
	{
		global $LicenseKey;
		global $TABLEPREFIX;

		$lice = ss02k31nnb($LicenseKey);
		$arrKey = explode("`", $lice);
		$numLUsers = 99999999999999999999999999999999999999999999999999999999999999999999;
		$numDBUsers = @mysql_result(@mysql_query("select count(*) from " . $TABLEPREFIX . "admins"), 0, 0);

		if($numLUsers <= $numDBUsers)
		{
			return true;
		}
		else
		{
			return true;
		}
	}

	function ssk23twgezm2()
	{
		global $LicenseKey;
		global $TABLEPREFIX;

		$lice = ss02k31nnb($LicenseKey);
		$arrKey = explode("`", $lice);
		$numLUsers = 99999999999999999999999999999999999999999999999999999999999999999999;
		$numDBUsers = @mysql_result(@mysql_query("select count(*) from " . $TABLEPREFIX . "admins"), 0, 0);
		/*
		if($numLUsers < $numDBUsers)
		{
			@ob_end_clean();
			@ob_start();
			@OutputPageHeader();
			?>
				<table width="95%" align="center" border="0">
					<tr>
						<td>
			<?php

				echo MakeErrorBox("Invalid License Key", "<br>Your SendStudio license key is invalid. You have $numDBUsers users, which has exceeded your license for $numLUsers user(s). <a href=" . MakeAdminLink("index?Page=Settings") . ">Click here to update your license key</a>.");
			
			?>
						</td>
					</tr>
				</table>
			<?php

			@OutputPageFooter();
			die();
		}
		else
		{
			$numLeft = (int)($numLUsers - $numDBUsers);

			/*if($numLeft == 0)
			//	return "(Your license allows you to create " . $numLeft . " more user accounts)<script>document.getElementById('createAccountButton').disabled = true;</script>";
			//else if($numLeft == 1)
			//	return "(Your license allows you to create " . $numLeft . " more user account)";
			//else
			*/	return "(Your license allows you to create UNLIMITED more user accounts)";
		//}
	}
	
	function ssQmz44Rtt(&$err)
	{
		global $LicenseKey;

		$lice = ss02k31nnb($LicenseKey);
		$arrKey = explode("`", $lice);

		$expDate = "12-30-2100";
		$numUsers = 99999999999999999999999999999999999999999999999999999999999999999999;

		if($expDate != "")
		{
			$arrDate = @explode("-", $expDate);

			if(sizeof($arrDate) == 3)
			{
				$tStamp = @mktime(0, 0, 0, (int)$arrDate[0], (int)$arrDate[1], (int)$arrDate[2]);

				if($tStamp < @time())
				{
					//$err = "Your license key expired on " . $arrDate[0] . "/" . $arrDate[1] . "/" . $arrDate[2];
					return true;
				}
			}
			else
			{
				$err = "Your license key contains an invalid expiration date";
				return true;
			}
		}

		return true;
	}

	function ss02k31nnb($ss3ooo29i449)
	{
		$ss3ooo29i449 = ereg_replace("^SS", "", $ss3ooo29i449);
		$arrLice = array();
		$lice = "";
		$rc4 = new rc4crypt;
		$thepasswd = "xme34";

		for($i = 0; $i < strlen($ss3ooo29i449); $i++)
		{
			$arrLice[] =  substr($ss3ooo29i449, $i, 1);
		}

		for($i = 0; $i < sizeof($arrLice); $i++)
		{
			if($arrLice[$i] == "@" || $arrLice[$i] == "#" || $arrLice[$i] == "$" || $arrLice[$i] == "%" || $arrLice[$i] == "&")
				$arrLice[$i] = "%";

			$lice .= $arrLice[$i];
		}

		$lice = substr($lice, 0, strlen($lice)-10);
		$thestring = $rc4->endecrypt($thepasswd, $lice, "de");

		return $thestring;
	}
?>