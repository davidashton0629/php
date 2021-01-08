<?php
	#############################################################################
	#																			#
	#				 COPY AND TRIGGER TEXT ON THIS WEBSITE						#
	#				https://sandbox.onlinephpfunctions.com/						#
	#																			#
	#############################################################################
	
	$rQ = 5; 																		// Required Experience. Listed # is Level 1 XP
	$l = 1;																			// Starting level. Required to be at 1, not 0, despite ARK EXP override system.
	$c = 250; 																		// Maximum level available to gain through EXP.
	$dC = 250;																		// Maximum levels available to dinos through EXP gain.
	$dTO = 1.00;																	// Offset for required XP for dinos.
	$dCA = true;																	// Sets true/false if Dino Cap is Available to change.
	$lP = array(1,30,75,105,150);													// Array of EXP pools. E.G. 0-30,30-75,75-105,105-150. 
																					## Final EXP pool will be from last($lP) -> Cap
	$lA = array(5,200,1000,10000,1000000);											// Array of EXP additions. Adds to required EXP per level. 
																					## E.G. 0-30=10xp per lvl
																					## MAKE SURE You have an EXP addition FOR EACH EXP Pool.
																					
	$pT = "ExperiencePointsForLevel";												// ARK Override Text
	$lO = "LevelExperienceRampOverrides";											// ARK Override Text
	$t = $lO . "=(" . $pT . "[0]=" . $rQ . ","; 									// EXP Text. Creates first level.
	$dT = $lO . "=(" . $pT . "[0]=" . $rQ . ",";									// Dino EXP Text. Creates first level.
	$eP = "OverridePlayerLevelEngramPoints=1\n"; 									// Engram Text. 
	$eAO = true;																	// Sets true/false if you should gain your level in engram points.
																					## E.G. Level 2 gives 2 points, 3 gives 3, etc. [Hard Mode]
	$eA = array(10,20,40,100,125);													// Engram points per interval.
																					## E.G. Level 1-5 gives 10 engram points per level
	$aEO = false;																	// Sets true/false for augmented experience override.
																					## False -- Experience ramps by the values set in $lA array
																					## True -- Experience ramps by previes levels experience + 12%
	$aEM = 1.12;																	// Sets amount to increase required experience by with Augmented Experience. 
																					## Default 12% [1.12]
	
	if((count($lP) !== count($lA)) 
		|| (count($lP) !== count ($eA)) 
		|| (count($lA) !== count($eA))){											// Kills code if you broke it :P
		die('YOU MUST MAKE SURE $lP, $eA AND $lA HAVE IDENTICAL LENGTHS. PLEASE TRY AGAIN.');
	}
	
	while($l < $c){																	// Loop to create text for each level.
		
		if($l < ($c - 1)) { 														// Uses -1 on check due to Level scale starting at [0] not [1]
			$t .= $pT . "[" . $l . "]=" . $rQ . ",";
		} else {
			$t .= $pT . "[" . $l . "]=" . $rQ . ")\n";
		}
		
		if($l < ($dC - 1)) { 														// Uses -1 on check due to Level scale starting at [0] not [1]
			$dT .= $pT . "[" . $l . "]=" . $rQ . ",";
		} else {
			$dT .= $pT . "[" . $l . "]=" . $rQ . ")\n";
		}
		
		$cS = -1;																	// Creates current lvl check to determine which addition to use.
		foreach($lP as $key=>$lS){
			if($l >= $lS) {
				$cS = $key;
			}
		}
		if($cS == -1) {																// This sets addition to FIRST addition if LVL is LESS THAN 1st pool.
			$cS = 0;
		}
		
		if($aEO) {																	// [AUGMENTED EXPERIENCE RAMP]
			$rQ = round($rQ * $aEM,PHP_ROUND_HALF_UP);									// Increases required experience each interval
		} else {																	// [ARRAY EXPERIENCE RAMP]
			$rQ = round($rQ + $lA[$cS],PHP_ROUND_HALF_UP);								// Increases required experience each interval
		}
		
		if(!$eAO) {
			$eP .= "OverridePlayerLevelEngramPoints=" . $eA[$cS] . "\n";			// Creates engram config lines if no override enabled
		} else {
			$eP .= "OverridePlayerLevelEngramPoints=" . ($l + 1) . "\n";			// Creates engram config lines with override [Hard Mode]
		}
		$l++;
	}
	echo $t;																		// Prints experience override
	if($dCA) {																		// Checks if $dCA is true. If true, prints second experience override for dinos.
		echo $dT;																	
	}
	echo $eP;																		// Prints engram points override
?>
