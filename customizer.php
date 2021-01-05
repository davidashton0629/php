<?php

	class Customizer extends Boot
	{
		
		function __construct() 
		{
			$this->sys['path'] =  "http://czgames-ark.000webhostapp.com/pages/customizer";
		}
		
		public $pageRoute;
		
		protected function start($route, $homepage = false) 
		{
			$this->pageRoute = $route;
			$bodyID = $this->pageRoute[0];
			
			if($this->pageRoute[0] !=="contact-us" && 
			$this->pageRoute[0] !== "tools" &&
			$this->pageRoute[0] !== "execute" &&
			$this->pageRoute[0] !== "") {
				if($this->pageRoute[0] == "contact") {
					header("Location: " . $this->sys['path'] . "/contact-us");
					die();
				} elseif($this->pageRoute[0] == "tool") {
					header("Location: " . $this->sys['path'] . "/tools");
					die();
				} else {
					header("Location: " . $this->sys['path']);
				}
			}
			
			if($bodyID == "") {
				$bodyID = "home";
			}
			
			$data = "";
			$data .= "<!DOCTYPE html>";
			$data .= "<html lang='en'>";
				$data .= "<head>";
					$data .= "<meta name='viewport' content='height=device-height, width=device-width, initial-scale=1.0'>";
					$data .= "<title>CZGames ARK Tools</title>";
					$data .= "<link href='https://fonts.googleapis.com/css?family=Open+Sans|Open+Sans+Condensed:300' rel='stylesheet' type='text/css' />";
					$data .= "<link href='https://fonts.googleapis.com/css?family=Roboto+Condensed' rel='stylesheet' type='text/css' />"; 
					$data .= "<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Permanent+Marker' rel='stylesheet'> ";
					$data .= "<link href='https://fonts.googleapis.com/css?family=Amatic+SC' rel='stylesheet' />";
					$data .= "<link rel='stylesheet' href='http://czgames-ark.000webhostapp.com/globals/global.css' type='text/css' />";
					$data .= "<link rel='stylesheet' href='" . $this->sys['path'] . "/styles/style.css' type='text/css' />";
					$data .= "<script src='https://code.jquery.com/jquery-3.2.1.js' type='text/javascript'></script>";
					$data .= "<script src='http://czgames-ark.000webhostapp.com/globals/jquery-ui.min.js' type='text/javascript'></script>";
					$data .= '<script src="http://czgames-ark.000webhostapp.com/globals/global.js" type="text/javascript"></script>';
					$data .= "<script src='" . $this->sys['path'] . "/scripts/basic.js' type='text/javascript'></script>";
					$data .= "<script src='" . $this->sys['path'] . "/scripts/exp-gen.js' type='text/javascript'></script>";
				$data .= "</head>";
				$data .= "<body id='" . $bodyID . "'>";
					$data .= "<div id='wrapper'>";
					
						$options = array(
							"homeLink" =>  $this->sys['path'],
							"homeLinkTitle" => "CZGames ARK Tools Homepage",
							"topMenu" => array(
								"topMenuLinks" => array(
									"home"=>array(
										"url"=> $this->sys['path'],
										"title"=>"CZGames ARK Tools Homepage",
										"text"=>"Home"
									),
									"tools"=>array(
										"url"=> $this->sys['path'] . "/tools",
										"title"=>"CZGames ARK Tools",
										"text"=>"ARK Tools"
									),
									"contact-us"=>array(
										"url"=> $this->sys['path'] . "/contact-us",
										"title"=>"Contact CZGames",
										"text"=>"Contact Us"
									),
									"donate"=>array(
									    "url"=> "https://paypal.me/arkfilepvp",
									    "title"=>"Support Us!",
									    "text"=>"Donate",
									    "target"=>"_blank"
									)
								)
							),
							"slogan"=>"Free ARK Server Development Tools!</span>"
						);
						$bodyOptions = array();
						
						if($this->pageRoute[0] == "") {
							$bodyOptions['page'] = "websiteHome";
							$options['topMenu']['topMenuLinks']['home']['class'] = 'active';
						} elseif ($this->pageRoute[0] == "tools"){
							if(isset($this->pageRoute[1]) && $this->pageRoute[1] !== null) {
								if(isset($this->pageRoute[2]) && $this->pageRoute[2] !== null) {
									$bodyOptions['page'] = "websiteInside";
									$bodyOptions['pageType'] = $this->pageRoute[2];
									$options['topMenu']['topMenuLinks']['tools']['class'] = 'active';
								} else {
									$bodyOptions['page'] = "websiteInside";
									$bodyOptions['pageType'] = $this->pageRoute[1];
									$options['topMenu']['topMenuLinks']['tools']['class'] = 'active';
								}
							} else {
								$bodyOptions['page'] = "websiteInside";
								$bodyOptions['pageType'] = "tools";
								$options['topMenu']['topMenuLinks']['tools']['class'] = 'active';
							}
						} elseif ($this->pageRoute[0] == "contact-us") {
							$bodyOptions['page'] = "websiteInside";
							$bodyOptions['pageType'] = "contact";
							$options['topMenu']['topMenuLinks']['contact-us']['class'] = 'active';
						} elseif ($this->pageRoute[0] == "execute") {
							if(isset($this->pageRoute[1]) && $this->pageRoute[1] !== null) {
								if(isset($this->pageRoute[2]) && $this->pageRoute[2] !== null) {
									$bodyOptions['page'] = "websiteInside";
									$bodyOptions['pageType'] = $this->pageRoute[2];
									$options['topMenu']['topMenuLinks']['tools']['class'] = 'active';
								} else {
									$bodyOptions['page'] = "websiteInside";
									$bodyOptions['pageType'] = $this->pageRoute[1];
									$options['topMenu']['topMenuLinks']['tools']['class'] = 'active';
								}
							} else {
								$bodyOptions['page'] = "websiteInside";
								$bodyOptions['pageType'] = "tools";
								$options['topMenu']['topMenuLinks']['tools']['class'] = 'active';
							}
						}
						
						$data .= $this->topHeader($options);
						//var_dump($bodyOptions); die();
						$data .= $this->bodyContent($bodyOptions);
						
					$data .= "</div>";
				$data .= "</body>";
			$data .= "</html>";
			
			echo $data;
			
		}
		
		public function homeBody() 
		{
			
			$data = "";
				$data .= "<div id='container'>";
					$data .= "<div id='content'>";
					    $data .= "<div id='cta'><h1>Welcome To CZGames</h1></div>";
						$data .= "<p>Our team is dedicated to bringing you a top quality, efficient website, focused on generating ARK ini script. With our integrated web system, we take 'Doing the work for you', to a whole new level.</p>";
						$data .= "<p>We offer several tools to pick from, all with different utility purposes. These include an automatic level experience generator, a tame calculator, a crafting cost generator, and more!</p>";
						$data .= "<p id='tagline'>So, how about you <a href='" . $this->sys['path'] . "/tools' title='Start Exploring!'>start exploring!</a></p>";
						$data .= "<p id='contentImages'>";
						    $data .= "<span><img src='" . $this->sys['path'] . "/img/img.png'></img></span>";
						    $data .= "<span><img src='" . $this->sys['path'] . "/img/img.png'></img></span>";
						    $data .= "<span><img src='" . $this->sys['path'] . "/img/img.png'></img></span>";
						    $data .= "<span><img src='" . $this->sys['path'] . "/img/img.png'></img></span>";
						    $data .= "<span><img src='" . $this->sys['path'] . "/img/img.png'></img></span>";
						    $data .= "<span><img src='" . $this->sys['path'] . "/img/img.png'></img></span>";
						$data .= "</p>";
					$data .= "</div>";
					
					$data .= "<div id='footer'>";
						$data .= "<p>Designed By: <span>David Ashton</span> | <span>CognizanceGaming</span></p>";
					$data .= "</div>";
					
				$data .= "</div>";
				
			return $data;
			
		}
		
		public function aboutBody()
		{
			
			$data = "";
				$data .= "<div id='container'>";
				
					$data .= "<div id='mainContent'>";
					$data .= "</div>";
					$data .= "<div id='sidebar'>";
						$data .= $this->form('contact', true);
					$data .= "</div>";
					$data .= "<div class='clr'></div>";
					
					$data .= "<div id='content'>";
					$data .= "</div>";
					
					$data .= "<div id='footer'>";
						$data .= "<p>Designed By: <span>David Ashton</span> | <span>CognizanceGaming</span></p>";
					$data .= "</div>";
					
				$data .= "</div>";
				
			return $data;
			
		}
	
		public function portfolioBody()
		{
			
			$data = "";
				$data .= "<div id='container'>";
					$data .= "<div id='content'>";
					$data .= "</div>";
					$data .= "<div id='footer'>";
						$data .= "<p>Designed By: <span>David Ashton</span> | <span>CognizanceGaming</span></p>";
					$data .= "</div>";
					
				$data .= "</div>";
				
			return $data;
			
		}
		
		public function contactBody()
		{
			
			$data = "";
				$data .= "<div id='container'>";
					$data .= "<div id='contact-page'>";
						$data .= "<h1>Contact The CZGames Team</h1>";
						$data .= "<div id='contactForm'>";
							$data .= $this->form($this->sys['path'] . '/contact/send','contact', false);
						$data .= "</div>";
						$data .= "<div id='sidebar'>";
							$data .= "<h2>The CZGames Team</h2>";
							$data .= "<div class='member' id='david-ashton'>";
								$data .= "<h3>David Ashton</h3>";
								$data .= "<h4><span>Owner</span> Designer &amp; Developer</h4>";
								$data .= "<p class='job'>Designs, developes, and upgrades websites. Creates 3D models, and programs in C#/PHP/Java.</p>";
								$data .= "<p class='email'><a href='mailto:cognizancegaming@gmail.com' title='Conctact David Ashton Directly'>cognizancegaming@gmail.com</a></p>";
							    $data .= "<div class='clr'></div>";
							$data .= "</div>";
							$data .= "<div class='clr'></div>";
						$data .= "</div>";
    					$data .= "<div id='footer'>";
    						$data .= "<p>Designed By: <span>David Ashton</span> | <span>CognizanceGaming</span></p>";
    					$data .= "</div>";
						$data .= "<div class='clr'></div>";
					$data .= "</div>";
					$data .= "<div class='clr'></div>";
				$data .= "</div>";
				
			return $data;
			
		}
		
		public function adminPanel()
		{
			if(!connection::$con) {
				connection::connect(4);
			}
			
			if(isset($this->pageRoute[1])) {
				if($this->pageRoute[1] == "edit") {
					if(isset($this->pageRoute[3])) {
						if($this->pageRoute[2] == "disableCover") {
							return admin::disable("websites",$this->pageRoute[3],$this->pageRoute[2],"cover");
						} elseif($this->pageRoute[2] == "enableCover") {
							return admin::enable("websites",$this->pageRoute[3],$this->pageRoute[2],"cover");
						} else {
							if(is_numeric($this->pageRoute[3])) {
								if(isset($this->pageRoute[4]) && !is_numeric($this->pageRoute[4]) && $this->pageRoute[4] == "update") {
									return admin::updateEdit("websites",$this->pageRoute[3],$this->pageRoute[2]);
								} else {
									return admin::edit("websites",$this->pageRoute[3],$this->pageRoute[2]);
								}
							}
							return admin::updateEdit("websites",$this->pageRoute[2]);
						}
					} else {
						return admin::edit("websites",$this->pageRoute[2]);
					}
				} elseif ($this->pageRoute[1] == "disable") {
							return admin::disable("websites",$this->pageRoute[3],$this->pageRoute[2]);
				} elseif ($this->pageRoute[1] == "enable") {
							return admin::enable("websites",$this->pageRoute[3],$this->pageRoute[2]);
				} elseif ($this->pageRoute[1] == "create") {
					if(isset($this->pageRoute[2]) && is_numeric( $this->pageRoute[2] )) {
						return admin::doCreate("websites", $this->pageRoute[2]);
					} elseif(isset($this->pageRoute[2]) && is_string($this->pageRoute[2])) {
						if(isset($this->pageRoute[3]) && is_numeric( $this->pageRoute[3] )) {		
							return admin::doCreate("websites", $this->pageRoute[3], $this->pageRoute[2]);
						} else {
							////
							return admin::create("websites", $this->pageRoute[2]);
						}
					} else {
						return admin::createForm("websites");
					}
				} elseif ($this->pageRoute[1] == "delete") {
					if(isset($this->pageRoute[2]) && is_numeric($this->pageRoute[2])) {
						return admin::deleteInput("websites",$this->pageRoute[2]);
					} else {
						if(isset($this->pageRoute[3]) && is_numeric($this->pageRoute[3])) {
							return admin::deleteInput("websites",$this->pageRoute[3], $this->pageRoute[2]);
						}
					}
				}
			} else {
				return admin::administration("websites");
			}
		}
		
		public function teamBody()
		{
			
			$data = "";
				$data .= "<div id='container'>";
				
					$data .= "<div id='teamContent'>";
						$data .= "<div id='david-ashton' class='team-member'>";
							$data .= "<div class='picture'><img src='" . $this->sys['path'] . "/img/team/david-ashton.png' title='David Ashton / Owner'/></div>";
							$data .= "<h2>David Ashton - Owner</h2>";
							$data .= "<p>Born in New York, raised in Maine, David studied at the United Technical Center for website design, game development, and 3D modeling. He designs and develops websites and provides direct support. In his free time, David enjoys music, botany and is an avid gardener.</p>";
							$data .= "<div class='clr'></div>";
						$data .= "</div>";
					$data .= "</div>";
					$data .= "<div id='content'>";
						$data .= "<p id='tagline'>So, how can I <a href='" . $this->sys['path'] . "/contact-us' title='Contact Us Now!'>help you today?</a></p>";
					$data .= "</div>";
					
					$data .= "<div id='footer'>";
						$data .= "<p>Designed By: <span>David Ashton</span> | <span>CognizanceGaming</span></p>";
					$data .= "</div>";
					
				$data .= "</div>";
				
			return $data;
			
		}
		
		public function toolsView()
		{
			$con = null;
			
		    $data = "";
				$data .= "<div id='container'>";
					$data .= "<div id='breadcrumb'>";
						$data .= $this->breadcrumbs(array('qLink'=>false,'override'=>"http://czgames-ark.000webhostapp.com"));
					$data .= "</div>";
					$data .= "<div id='containerWrap'>";
						if($con = connection::connect(3)){ 
							$tools = connection::getData(array('tableName'=>'tools'));
							foreach($tools as $tool) {
								$data .= "<div class='toolItem'>";
									$data .= "<div class='toolWrap'>";
										$data .= "<div class='toolTitle " . $this->slugify($tool['tool_name']) . "'>";
											$data .= "<h3>" . $tool['tool_name'] . "</h3>";
										$data .= "</div>";
										$data .= "<div class='toolDesc'>";
											$data .= "<p>" . $tool['tool_snip'] . "</p>";
										$data .= "</div>";
										$data .= "<div class='toolImg'>";
											$data .= "<img src='" . $this->sys['path'] . "/img/" . $this->slugify($tool['tool_name']) . ".png'></img>";
										$data .= "</div>";
										$data .= "<div class='toolLink'>";
											$data .= "<a title='" . $tool['tool_name'] . "' href='" . $this->sys['path'] . "/tools/" . $this->slugify($tool['tool_name']) . "'>" . $tool['tool_name'] . "</a>";
										$data .= "</div>";
									$data .= "</div>";
									$data .= "<div class='clr'></div>";
								$data .= "</div>";
							}
						} else {
							die(1);
						}
						$data .= "<div class='clr'></div>";
					$data .= "</div>";
					$data .= "<div id='footer'>";
						$data .= "<p>Designed By: <span>David Ashton</span> | <span>CognizanceGaming</span></p>";
					$data .= "</div>";
				$data .= "</div>";
			return $data;
		}
		
		function expRamp()
		{
			$con = null;
			
		    $data = "";
				$data .= "<div id='container'>";
					$data .= "<div id='breadcrumb'>";
						$data .= $this->breadcrumbs(array('qLink'=>false,'override'=>"http://czgames-ark.000webhostapp.com"));
					$data .= "</div>";
					$data .= "<div id='containerWrap'>";
						$data .= "<div id='expWrap'>";
							$data .= "<div id='expForm'>";
								$data .= $this->form($this->sys['path'] . "/execute/exp/","exp",false,"_blank");
							$data .= "</div>";
						$data .= "</div>";
						$data .= "<div class='clr'></div>";
					$data .= "</div>";
					$data .= "<div id='footer'>";
						$data .= "<p>Designed By: <span>David Ashton</span> | <span>CognizanceGaming</span></p>";
					$data .= "</div>";
				$data .= "</div>";
			return $data;
		}
		
		public function performExpRamp()
		{
			if(!isset($_POST['totalWantedLevels'])) {
				header("Location: http://czgames-ark.000webhostapp.com/pages/customizer");
			}
			
			$params = array();
			if(isset($_POST['totalWantedLevels']) && $_POST['totalWantedLevels'] !== "") {
				$params['levels'] = $_POST['totalWantedLevels'];
			}
			if(isset($_POST['totalExpRamps']) && $_POST['totalExpRamps'] !== "") {
				$params['ramps'] = $_POST['totalExpRamps'];
			}
			if(isset($_POST['totalEngramRamps']) && $_POST['totalEngramRamps'] !== "") {
				$params['engrams'] = $_POST['totalEngramRamps'];
			}
			if(isset($_POST['useAugment']) && $_POST['useAugment'] !== "") {
				$params['augment'] = $_POST['useAugment'];
			}
			if(isset($_POST['changeDino']) && $_POST['changeDino'] !== "") {
				$params['changeDinos'] = $_POST['changeDino'];
			}
			if(isset($_POST['augmentPower']) && $_POST['augmentPower'] !== "") {
				$params['power'] = $_POST['augmentPower'];
			} else {
				$params['power'] = 1.12;
			}
			
			$data = "";
			
			foreach($params as $key=>$param) {
				$sets[$key] = explode(",",$param);
			}
			
			foreach($sets as $sKey=>$set) {
				$sets[$sKey] = array_filter($sets[$sKey]);
			}
			extract($sets);
			//var_dump($levels, $ramps, $engrams, $augment, $changeDinos, $power); die();
			
			$rQ = 5; 																		
			$l = 1;																			
			$c = intval($levels[0]); 														
			$dC = intval($levels[0]);														
			$dTO = 1.00;																	// Offset for required XP for dinos.
			$dCA = filter_var($changeDinos[0], FILTER_VALIDATE_BOOLEAN) ? filter_var($changeDinos[0], FILTER_VALIDATE_BOOLEAN) : filter_var($changeDinos, FILTER_VALIDATE_BOOLEAN);
			$lP = array();
			
			$i = 0;
			while($i < count($ramps)) {
				$lP[] = round($c / count($ramps),0,PHP_ROUND_HALF_UP);
				$i++;
			}
																							
			$lA = $ramps;																	
			$pT = "ExperiencePointsForLevel";												
			$lO = "LevelExperienceRampOverrides";											
			$t = $lO . "=(" . $pT . "[0]=" . $rQ . ","; 									
			$dT = $lO . "=(" . $pT . "[0]=" . $rQ . ",";									
			$eP = "OverridePlayerLevelEngramPoints=1<br/>"; 
			$eA = $engrams;																	
			$aEO = filter_var($augment[0], FILTER_VALIDATE_BOOLEAN) ? filter_var($augment[0], FILTER_VALIDATE_BOOLEAN) : filter_var($augment, FILTER_VALIDATE_BOOLEAN);
			$aEM = floatval($power[0]) ? floatval($power[0]) : floatval($power);
			if(is_string($aEM) || is_array($aEM)) {
				$aEM = floatval(1.12);
			}
			
			if((count($lP) !== count($lA)) 
				|| (count($lP) !== count ($eA)) 
				|| (count($lA) !== count($eA))){											// Kills code if you broke it :P
				die('YOU MUST MAKE SURE $lP, $eA AND $lA HAVE IDENTICAL LENGTHS. PLEASE TRY AGAIN.');
			}
			
			$levelInterval = round($c / count($ramps),0,PHP_ROUND_HALF_UP);
			//var_dump($dCA, $aEO, $levelInterval, $aEM); die();
			foreach($lA as $rampKey=>$ramp) {
				
				while($l < ($levelInterval * ($rampKey + 1))) {
					//var_dump($l);
					if($l > ($c - 1) || $l > ($dC - 1 )) {
						break;
					}
					if($l < ($c - 1)) { 														
						$t .= $pT . "[" . $l . "]=" . $rQ . ",";
					} else {
						$t .= $pT . "[" . $l . "]=" . $rQ . ")<br/>";
					}
					
					if($l < ($dC - 1)) { 														
						$dT .= $pT . "[" . $l . "]=" . $rQ . ",";
					} else {
						$dT .= $pT . "[" . $l . "]=" . $rQ . ")<br/>";
					}
					
					$cS = -1;																	
					foreach($lP as $key=>$lS){
						if($l >= $lS) {
							$cS = $key;
						}
					}
					if($cS == -1) {																
						$cS = 0;
					}
					
					if($aEO) {																	
						$rQ = round($rQ * $aEM,PHP_ROUND_HALF_UP);								
					} else {																	
						$rQ = round($rQ + $lA[$rampKey],PHP_ROUND_HALF_UP);							
					}
					
					$eP .= "OverridePlayerLevelEngramPoints=" . $eA[$rampKey] . "<br/>";
					
					$l++;
				}
			}
			
			$data .= $t;																	
			
			if($dCA) {																		
				$data .= $dT;																	
			}
			$data .= $eP;																	
			echo $data; die();
		}
		
	}

?>