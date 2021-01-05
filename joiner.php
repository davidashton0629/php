<?php
	$files = array(
		"connection.php", 		// SQL service
		"boot.php",				// GLOBAL service
		"admin.php", 			// ADMIN service
		"faq.php",				// FAQ site
		"caregiver.php",		// CAREGIVER site
		"customizer.php",       // CUSTOMIZER site
	);
	
	foreach($files as $file) {
		require_once($file);
	}
?>