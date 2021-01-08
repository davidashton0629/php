<?php
	/*
	Made for personal use for old game.
	*/
	$level = 1;
	$requiredExperience = 1;
	$text = "LevelExperienceRampOverrides=(ExperiencePointsForLevel[0]=0.01,";
	
	// Player
	while($level <= 178) {
		if($level !== 178) {
			if($level <= 104) {
				$text .= "ExperiencePointsForLevel[" . $level . "]=";
				$text .= "" . round((($level * 3) * ($requiredExperience * 1.8) + 1.5) * 1.05) . ",";
			} else {
				$text .= "ExperiencePointsForLevel[" . $level . "]=175000";
				$text .= round($level / 50) . "00,";
			}
		}else{
			$text .= "ExperiencePointsForLevel[178]=175000";
			$text .= round($level / 50) . "00";
		}		
		$level++;
		$requiredExperience = $level * 2.8;
	}
	$text .= ")";
	echo $text;
	
	#####################
?>

<?php
	$level = 1;
	$requiredExperience = 1;
	$text = "LevelExperienceRampOverrides=(ExperiencePointsForLevel[0]=0.01,";
	
	// Dino
	while($level <= 300) {
		if($level !== 300) {
			if($level <= 149) {
				$text .= "ExperiencePointsForLevel[" . $level . "]=";
				$text .= "" . round((($level * 3) * ($requiredExperience * 1.8) + 2) * 1.45) . ",";
			} else {
				$text .= "ExperiencePointsForLevel[" . $level . "]=85000";
				$text .= round($level / 25) . "00,";
			}
		}else{
			$text .= "ExperiencePointsForLevel[300]=85000";
			$text .= round($level / 25) . "00";
		}		
		$level++;
		$requiredExperience = $level * 2.8;
	}
	$text .= ")";
	echo $text;
	##################
?>

<?php
	$text = "";
	$types = array("small"=>3,"medium"=>6,"large"=>9,"huge"=>12);
	
	// BerryBush Cost for Dinos 2000+
	$level = 1525;
	while($level < 10050) {
		$text .= "Cost for Level $level<br/><span>";
		foreach($types as $key=>$type) {
			$text .= $type;
			if($key == "huge") {
				$text .= round((($level - 1500) * $type) * 7) . "[" . $key . "]";
			} else {
				$text .= round((($level - 1500) * $type) * 7) . "[" . $key . "], ";
			}
		}
		$text .= "</span>";
		$level += 25;
	}
	
	echo $text;
?>

<?php
	$num = 1;
	$text = "";
	while($num <= 165) {
		$text .= "OverridePlayerLevelEngramPoints=";
		$text .= 1 + $num;
		$text .= "\n";
		$num++;
	}
	echo $text;
?>
