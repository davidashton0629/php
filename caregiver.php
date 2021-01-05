<?php

	class Caregiver extends Boot
	{
		
		function __construct() 
		{
			
			$this->sys['path'] =  "http://caregiver.alocalfarmer.com";
			
		}
		
		public $pageRoute;
		
		protected function start($route, $homepage = false) 
		{
			
			$this->pageRoute = $route;
			$bodyID = $this->pageRoute[0];
			
			if($this->pageRoute[0] !== "about-us" && 
			$this->pageRoute[0] !=="contact-us" &&  
			$this->pageRoute[0] !== "view" &&
			$this->pageRoute[0] !== "how-to-use" &&
			$this->pageRoute[0] !== "") {
				header("Location: " . $this->sys['path']);
			}
			
			if($bodyID == "") {
				$bodyID = "home";
			}
			
			$data = "";
			$data .= "<!DOCTYPE html>";
			$data .= "<html lang='en'>";
				$data .= "<head>";
					$data .= "<title>Maine Caregiver Collective</title>";
					$data .= "<meta name='viewport' content='height=device-height, width=device-width, initial-scale=1.0'>";
					$data .= "<link href='https://fonts.googleapis.com/css?family=Open+Sans|Open+Sans+Condensed:300' rel='stylesheet' type='text/css' />";
					$data .= "<link href='https://fonts.googleapis.com/css?family=Roboto+Condensed' rel='stylesheet' type='text/css' />"; 
					$data .= "<link href='https://fonts.googleapis.com/css?family=Amatic+SC' rel='stylesheet' />";
					$data .= "<link rel='stylesheet' href='" . $this->sys['path'] . "/styles/style.css' type='text/css' />";
					$data .= "<script src='https://code.jquery.com/jquery-3.2.1.js' type='text/javascript'></script>";
					$data .= "<script src='" . $this->sys['path'] . "/scripts/jquery-ui.min.js' type='text/javascript'></script>";
					$data .= "<script src='" . $this->sys['path'] . "/scripts/global.js' type='text/javascript'></script>";
					$data .= "<script src='" . $this->sys['path'] . "/scripts/basic.js' type='text/javascript'></script>";
				$data .= "</head>";
				$data .= "<body id='" . $bodyID . "'>";
					$data .= "<div id='wrapper'>";
					
						$options = array(
							"homeLink" =>  $this->sys['path'],
							"homeLinkTitle" => "Maine Caregiver Collective Homepage",
							"logoEnabled"=>false,
							"topMenuEnabled"=>false,
							"topMenu" => array(
								"topMenuLinks" => array(
									"home"=>array(
										"url"=> $this->sys['path'],
										"title"=>"Maine Caregiver Collective Homepage",
										"text"=>"Home"
									),
									"search"=>array(
										"url"=> $this->sys['path'] . '/search/',
										"title"=>"Search MCC",
										"text"=>"Search By ZIP"
									),
									"listing"=>array(
										"url"=> $this->sys['path'] . '/listing/',
										"title"=>"See Full MCC Listing",
										"text"=>"See All Caregivers"
									),
								)
							)
						);
						$bodyOptions = array();
						
						if($this->pageRoute[0] == "") {
							$bodyOptions['page'] = "websiteHome";
							$bodyOptions['pageType'] = "home";
							$options['topMenu']['topMenuLinks']['home']['class'] = 'active';
						}elseif($this->pageRoute[1] == "/search") {
							$bodyOptions['page'] = "websiteInside";
							$bodyOptions['pageType'] = "search";
							$options['topMenu']['topMenuLinks']['search']['class'] = 'active';
						}
						
						$data .= $this->topHeader($options);
						
						$data .= $this->bodyContent($bodyOptions);
						
					$data .= "</div>";
				$data .= "</body>";
			$data .= "</html>";
			
			echo $data;
			
		}
		
		public function homeBody() 
		{
			
			$data = "";
				
			return $data;
			
		}
		
	}

?>