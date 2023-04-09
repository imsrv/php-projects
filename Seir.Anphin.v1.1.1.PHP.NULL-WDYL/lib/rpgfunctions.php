<?php

$types=array('rhand', 'lhand', 'head', 'body', 'legs', 'accessory');
$armors=array('head', 'body', 'legs', 'accessory');
$shortstattypes=array('hp', 'mp', 'str', 'end', 'dex', 'int', 'wil');

function getitemname($itemid)
{
	GLOBAL $dbr;
	if ($itemid!=0 && $itemid!="") {
		$thisitem=$dbr->query("SELECT itemid,name,iconpath,power,statbonus,type,addpoison,addsleep,addpetrify,adddeath FROM arc_item WHERE itemid=$itemid");
		$this=$dbr->getarray($thisitem);
	} else {
		$this=1;
	}
	GLOBAL $iconpath,$power,$statbonus,$type,$itemid,$poison,$sleep,$petrify,$death;

	if (is_array($this)) {
		$iconpath=$this['iconpath'];
		if ($this['power']!=0) {
			$power=$this['power'];
		} else {
			$power='';
		}
		if ($this['addpoison']!=0) {
			$poison=$this['addpoison'];
		} elseif($this['addsleep']!=0) {
			$sleep=$this['addsleep'];
		} elseif($this['addpetrify']!=0) {
			$petrify=$this['addpetrify'];
		} elseif($this['adddeath']!=0) {
			$death=$this['adddeath'];
		}
		$statbonus=$this['statbonus'];
		$type=$this['type'];
		$itemid=$this['itemid'];
		return $this['name'];
	} else {
		$iconpath='lib/images/default.gif';
		$power='';
		$statbonus='';
		$type=0;
		$itemid=0;
		return '';
	}
}

function getrandombg($backvar)
{
	if ($backvar=='random') {
		$backgrounds=array();
		$dh=opendir('../lib/images/backgrounds');
		while ($file=readdir($dh)) {
			if (!preg_match("/\.\.?$/", $file)) $backgrounds[]=$file;
		}
		$index=mt_rand(0, count($backgrounds)-1);
		return '../lib/images/backgrounds/'.$backgrounds[$index];
	} else {
		return $backvar;
	}
}

function getskilleffect($flag)
{
	if ($flag==1) {
		return 'Damage';
	} elseif($flag==0) {
		return 'Recover';
	} elseif($flag==2) {
		return 'Revive';
	}
}

function checkmax($current, $maximum)
{
	if ($current>=$maximum) {
		return $maximum;
	} else {
		return $current;
	}
}

// never use in a loop
function getclassname($classid)
{
	GLOBAL $dbr;
	return stripslashes($dbr->result("SELECT name FROM arc_class WHERE classid=$classid"));
}

function getelementicon($elementkey='none')
{
	$elements=array('fir'=>'fire', 'cld'=>'ice', 'air'=>'air', 'wat'=>'water', 'drk'=>'bane',
					'hly'=>'holy', 'ear'=>'earth', 'lit'=>'lightning', 'none'=>'default');
	if (isset($elements[$elementkey])) {
		return 'lib/images/misc/'.$elements[$elementkey].'.gif';
	} else {
		return 'lib/images/default.gif';
	}
}

function getstatname($abbreviation)
{
	$stats=array('str'=>'Strength', 'dex'=>'Dexterity', 'end'=>'Endurance', 'int'=>'Intelligence', 'wil'=>'Will',
				 'atk'=>'Attack', 'def'=>'Defense', 'eva'=>'Evasion', 'cld'=>'Cold Affinity', 'fir'=>'Fire Affinity',
				 'lit'=>'Lightning Affinity', 'air'=>'Air Affinity', 'drk'=>'Dark Affinity', 'hly'=>'Holy Affinity',
				 'ear'=>'Earth Affinity', 'air'=>'Air Affinity', 'wat'=>'Water Affinity', 'chp'=>'Current HP',
				 'cmp'=>'Current MP');
	return $stats[$abbreviation];
}

function setstatvars($override=0,$add_m=0)
{
	GLOBAL $chpplus,$cmpplus,$hpplus,$mpplus,$strplus,$endplus,$intplus,$wilplus,$dexplus,$airplus,$drkplus,$earplus,$firplus,$cldplus,$litplus,$hlyplus,$watplus;
	$plus=array('chpplus', 'cmpplus', 'hpplus', 'mpplus', 'strplus', 'endplus', 'intplus', 'wilplus', 'dexplus', 'drkplus', 'earplus', 'firplus', 'airplus', 'cldplus', 'litplus', 'hlyplus', 'watplus');
	foreach ($plus as $val) {
		if ($add_m==0) {
			if (empty($$val) || $override==1) $$val=0;
		} else {
			$mval='m'.$val;
			$$mval=0;
		}
	}
}

function splitstatbonus($string)
{
	if ($string!='') {
		$bonusarr=explode('|', $string);
		$bonuses='';
		foreach ($bonusarr as $key=>$val) {
			$stat=substr($val, 0, 3);
			$modifier=str_replace($stat, '', $val);
			$stat=getstatname($stat);
			if ($bonuses!='')
				$bonuses.=', ';
			$bonuses.="$stat $modifier";
		}
		return $bonuses;
	} else {
		return FALSE;
	}
}

function setstatbonuses($string, $add_m=0)
{
	if ($string!='') {
		$bonusarr=explode('|', $string);
		$bonuses='';

		if ($add_m==0) {
			GLOBAL $chpplus,$cmpplus,$hpplus,$mpplus,$strplus,$endplus,$intplus,$wilplus,$dexplus;
			GLOBAL $airplus,$drkplus,$earplus,$firplus,$cldplus,$litplus,$hlyplus,$watplus;
		} else {
			GLOBAL $mstrplus,$mendplus,$mintplus,$mdexplus,$mwilplus,$mairplus,$mdrkplus;
			GLOBAL $mchpplus,$mcmpplus,$mearplus,$mfirplus,$mcldplus,$mlitplus,$mhlyplus,$mwatplus;
		}

		foreach ($bonusarr as $key=>$val) {
			if ($add_m==0) {
				$stat=substr($val, 0, 3);
			} else {
				$stat=substr($val, 0, 3);
			}
			$modifier=str_replace($stat, '', $val);
			if ($add_m==0) {
				$stat=substr($val, 0, 3). 'plus';
			} else {
				$stat='m'.substr($val, 0, 3). 'plus';
			}
			if (empty($$stat))
				$$stat = 0;
			if (empty($modifier))
				$modifier = 0;
			$$stat=$$stat+$modifier;
		}
	} else {
		return FALSE;
	}
}

function getattackpower($strength, $weapon=0, $bonuses='')
{
	GLOBAL $lhand;
	$bonusarr=set_val_as_key(explode('|', $bonuses));

	if (isset($bonusarr['str2attack']) && $weapon==0) {
		$str=$strength;
	} else {
		$str=round($strength / 2);
	}
	if (isset($bonusarr['weapon2attack'])) {
		$atk=$weapon;
	} else {
		$atk=round($weapon / 2);
	}
	if ($lhand==0) {
		$strplus=ceil($str * getSetting('2hand_multiplier'));
		$str=$str+$strplus;
	}
	return $str + $atk;
}

function getdefense($endurance, $armor=0, $bonuses='')
{
	$bonusarr=set_val_as_key(explode('|', $bonuses));

	if (isset($bonusarr['end2defense']) && $armor==0) {
		$end=$endurance;
	} else {
		$end=round($endurance / 2);
	}
	if (isset($bonusarr['armor2defense'])) {
		$armor=$armor;
	} else {
		$armor=round($armor / 2);
	}
	return $end + $armor;
}

function getevade($dexterity)
{
	return round($dexterity / 2);
}

function gethitbonus($dexterity)
{
	return round($dexterity / 2);
}

function getdamage($attackpower, $defense=0)
{
	$base=round(($attackpower * getSetting('damage_attack_multiplier')) - ($defense * getSetting('damage_resist_multiplier')));
	$variance=$base * getSetting('damage_variance');
	$lower=$base - $variance;
	$upper=$base + $variance;
	return rand($lower, $upper);
}

function getdef($defense)
{
	GLOBAL $damage_resist_multiplier;
	$base=round($defense * getSetting('damage_resist_multiplier'));
	$variance=$base * getSetting('damage_variance');
	$lower=$base - $variance;
	$upper=$base + $variance;
	return rand($lower, $upper);
}

function attackdamage($basedamage, $resist)
{
	GLOBAL $wordbit;
	$damage=$basedamage;
	if ($resist>$damage) {
		$x=round($damage/$resist, 2);
		if ($x<=0.15) {
			$damage=0;
		} elseif ($x<=0.2) {
			$damage=$damage*0.5;
		} else {
			$damage=$damage*0.1;
		}
	} else {
		$damage=$damage-($resist * 0.9);
	}
	$critical_roll=rand(1,20);
	if ($critical_roll>=20) {
		$damage=$damage*2;
		$wordbit='battle_msg_critical_hit';
	}
	return floor($damage);
}

function skilldamage($basedamage, $resist, $skillelement, $damageflag=1, $formula=0)
{
	GLOBAL $wordbit,$self,$target,$airplus,$drkplus,$earplus,$firplus,$cldplus,$litplus,$hlyplus,$watplus;
	GLOBAL $mairplus,$mdrkplus,$mearplus,$mfirplus,$mcldplus,$mlitplus,$mhlyplus,$mwatplus, $dbr;

	$damage=$basedamage;

	if ($skillelement!="" && $damageflag==1) { //  get elemental bonus scores and add them to damage
		$avarname=$skillelement.'plus';
		$atk_elem_bonus=$$avarname;

		if ($atk_elem_bonus<0) {
			$isnegative=1;
			$atk_elem_bonus=$atk_elem_bonus*-1;
		}

		$dmgbonus=$atk_elem_bonus/250;
		if ($atk_elem_bonus<0) $dmgbonus=$dmgbonus/.5;

		$dvarname='m'.$skillelement.'plus';
		$def_elem_bonus=$$dvarname;

		if ($atk_elem_bonus>=0) {
			if (isset($isnegative)) {
				$dmgplus=round($damage*$dmgbonus);
				$damage=$damage-$dmgplus;
			} else {
				$dmgplus=round($damage*$dmgbonus);
				$damage=$damage+$dmgplus;
			}

		} elseif ($atk_elem_bonus<0) {
			$damage=round($damage/($dmgbonus*-1));
		}

		if ($def_elem_bonus>999) {
			$damage=0;
		} else {
			$defbonus=$def_elem_bonus/250;
			$defplus=round($damage*$defbonus);
			$damage=$damage-$defplus;
		}


//		echo "<hr>attack skill element bonus: ".$$avarname." || defense skill element  bonus: ".$$dvarname."<br>
//		effective damage ratio increase: $dmgbonus<br>effective defense damage reduction: $defbonus<br>
//		total damage: (basedamage: $basedamage) + (damage * damage ratio increase: $dmgplus)
//		- (basedamage * defense ratio bonus: $defbonus) = $damage<hr>";

	}

	if ($formula!=0) {
		$damageformula=stripslashes($dbr->result("SELECT formula FROM arc_formula WHERE id=$formula"));
		eval($damageformula);
	}

	if ($resist>$damage) {
		$x=round($damage/$resist, 2);
		if ($x<=0.15) {
			$damage=0;
		} elseif ($x<=0.2) {
			$damage=$damage*0.5;
		} else {
			$damage=$damage*0.1;
		}
	} else {
		$damage=$damage-($resist * 0.9);
	}

	return floor($damage);
}


?>