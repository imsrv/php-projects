<?

/*

	PHP Chatengine version 1.9
	by Michiel Papenhove
	e-mail: michiel@mipamedia.com
	http:// www.mipamedia.com
	
	Software is supplied "as is". You cannot hold me responsible for any problems that
	might of occur because of the use of this chat
	
*/

// process_speak.php3

function crap($text)
{
	$pool = "!@    #$%^&*()    oaeiuoae    eiuo";
	
	srand((double)microtime()*1000000);
	
	$strng = "";
	
	for ($f = 0; $f < strlen($text); $f++)
	{
		$randval = rand(0,strlen($pool));
		$strng .= substr($pool, $randval, 1);
	}
	
	return $strng;
}

function no_spaces($text)
{
	$text = eregi_replace(" ", "", $text);
	
	return $text;
}

function reverse($text)
{
	$text = strrev($text);
	
	return $text;
}

function yell($text)
{
	$text = "<b>".strtoupper($text)."</b>";
	return $text;
}

function stutter($text)
{
	$words = split(" ", $text);
	$aantal = count($words);
	$new_text = "";
	
	for ($f = 0; $f < $aantal; $f++)
	{
		// pak eerste letter
		if (strlen($words[$f]) > 1)
		{
			$letter = substr($words[$f], 0, 1);
			$words[$f] = $letter."-".$letter."-".$letter."-".$words[$f];
		}
		$new_text .= $words[$f]." ";
	}
	
	return $new_text;
}

function nerdie($text)
{
	$text = eregi_replace("e", "3", $text);
	$text = eregi_replace("i", "1", $text);
	$text = eregi_replace("a", "@", $text);
	$text = eregi_replace("o", "0", $text);
	$text = eregi_replace("s", "5", $text);
	return $text;
}

function swear($text)
{
	srand((double)microtime()*1000000);

	$words = array(	"-FUCK!-", "-COCKSUCKER!-", "-ASSHOLE!-", "-CUNT!-", "-BITCH!-",
			"-WHORE!-", "-SLUT!-", "-GODDAMN!-", "-MOTHERFUCKER!-", "-DICK!-");
	$aantal = count($words);
	$lengte = strlen($text);
	
	$new_text = "";
	
	for ($f = 0; $f < $lengte; $f++)
	{
		$letter = substr($text, $f, 1);
		$rval = rand(0, 15);
		if ($rval < 2)
		{
			$letter .= $words[rand(0, $aantal)];
		}
		$new_text .= $letter;
		
	}
	
	return $new_text;
	
}

function porn($text)
{
	srand((double)microtime()*1000000);

	$words = array(	"....hmmm....weiter...", "....ja weiter!.....", "....mmmmmmmmm...", "..Fick mich, du geiles luder..", "...Lick meine natte Arsloch..",
			"...Nimm mir, nimm mir hart....", "Hmm....ich will dich..", "..lick meine Mushi....", "O ja...ich komme.", "..ja...komm mal...", "...Ich spritze meines riesiges Schwanz in dein gesicht ab!...");
	$aantal = count($words);
	$lengte = strlen($text);
	
	$new_text = "";
	
	for ($f = 0; $f < $lengte; $f++)
	{
		$letter = substr($text, $f, 1);
		if ($letter == " ")
		{
			$randval = rand (0, 15);
			if ($randval < 5)
			{
				$letter .= ".<i>".$words[rand(0, $aantal)]."</i>.";
			}
		}
		$new_text .= $letter;
		
	}
	
	return $new_text;
	
}

function no_vowels($text)
{
	$text = eregi_replace("[aAeEiIuUoO]", "", $text);
	
	return $text;
}

function ome_jo($text)
{
	srand((double)microtime()*1000000);

	$words = array(	"...Hee hallo..", "...nee....eh..ja...", "..hoe gaat het..", "....wat moffe duike....", ".....met jou?....",
			"...ken wel janke....", "....wat een vent...", "...hij gaf geen kick.......", "....ik weet het nog goed...", "..al die nieuwerwetse zooi...", "...hebtie met z'n eigen handen gedaan...");
	$aantal = count($words);
	$lengte = strlen($text);
	
	$new_text = "";
	
	for ($f = 0; $f < $lengte; $f++)
	{
		$letter = substr($text, $f, 1);
		if ($letter == " ")
		{
			$randval = rand (0, 15);
			if ($randval < 10)
			{
				$letter .= ".<i>".$words[rand(0, $aantal)]."</i>.";
			}
		}
		$new_text .= $letter;
		
	}
	
	return $new_text;
	
}

function nazi($text)
{
	srand((double)microtime()*1000000);

	$words = array(	"-AUFMACHEN!!!!-", "-WASS IST DAS???-", "-GEGEN DIE MAUER!!!-", "-SCHNELL!!!!-", "-LINKS, RECHTS, LINKS, RECHTS!!!!-",
			"-JAWOHL!!!!-", "-ICH HABE ES NICHT GEWUST!!!!-");
	$aantal = count($words);
	$lengte = strlen($text);
	
	$new_text = "";
	
	for ($f = 0; $f < $lengte; $f++)
	{
		$letter = substr($text, $f, 1);
		if ($letter == " ")
		{
			$randval = rand (0, 15);
			if ($randval < 10)
			{
				$letter .= ".<i>".$words[rand(0, $aantal)]."</i>.";
			}
		}
		$new_text .= $letter;
		
	}
	
	return $new_text;
	
}

function maroc($text)
{
	srand((double)microtime()*1000000);

	$words = array(	"-wat moetzje dan??-", "-waar izz die jonco??-", "-jij kaikt naar mai-", "-dazz mooie maisje!!!-", "-jij tyfuzzz zzsjlet-",
			"-allah akbar-", "-wat izzsjer dan??-", "-kom dan!!!-", "-ik weet waar je huisj woont-");
	$aantal = count($words);
	$lengte = strlen($text);
	
	$new_text = "";
	
	for ($f = 0; $f < $lengte; $f++)
	{
		$letter = substr($text, $f, 1);
		// voeg scheldwoord toe of niet
		if ($letter == " ")
		{
			$randval = rand (0, 15);
			if ($randval < 10)
			{
				$letter .= ".<i>".$words[rand(0, $aantal)]."</i>.";
			}
		}
		$new_text .= $letter;
		
	}
	
	return $new_text;
	
}

function southpark($text)
{
	srand((double)microtime()*1000000);

	$words = array(	"-Screw you, hippie-", "-fattass-", "-I hate you Kenny-", "-Oh my God, they killed kenny !!-", "-That is so gay-",
			"-Screw you guys-", "-Ass sucker-", "-Uncle Fucker-", "-BEEFCAKE !!-", "-You bastards !!-", "-Spank my ass and call me charley-",
			"-You little DILDO-", "-KICK THE BABY !!-", "-KICKASS-", "-You go to hell! You go to hell and you die!-", "-Ah, son of a bitch!-", 
			"-ass-master!-", "-You piece of crap, I'll kill you!-", "-Stan's dog's a homo-", "-shut up dude-", "-Stanley, gay people...well, gay people are evil-", 
			"-I'll kick you in the nuts!-", "-you shitfaced cockmaster!-", "-Suck my balls!-", "-SWEEET-", "-This chat has warped my fragile little mind-", 
			"-M’kay?-", "-Aw, crap!-", "-Ah! Fuckin’ weak, dude!-", "-Cheers, fuckface.-", "-Holy shit, dude!-", "-Hey, relax, guy!-", "-Dude, what the fuck is wrong with German people?-",
			"-God? He is the biggest bitch of them all!-", "-Damn! Shit! Respect my fuckin’ authorita!-", "-blood drenched frozen tampon popsicle!-", "-Fuck! Shit! Cock! Ass! Shitty boner bitch! Muff! Pussy! Cock!-",
			"-Butthole! Barbara Streisand!");
	$aantal = count($words);
	$lengte = strlen($text);
	
	$new_text = "";
	
	for ($f = 0; $f < $lengte; $f++)
	{
		$letter = substr($text, $f, 1);
		if ($letter == " ")
		{
			$randval = rand (0, 15);
			if ($randval < 5)
			{
				$letter .= ".<i>".$words[rand(0, $aantal)]."</i>.";
			}
		}
		$new_text .= $letter;
		
	}
	
	return $new_text;
	
}


function shut_up($text)
{
	$text = "<font color=\"Red\">This user is in shut-up mode</font>";
	return $text;
}

?>
