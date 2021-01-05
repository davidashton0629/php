<?php

	error_reporting(E_ALL);
	require_once("joiner.php");
	
	class ALF {
		
		private $pageID;
		private $pageInstance;
		private $homepage;
		private $t;
		private $customizer, $medical, $connection, $blog, $faq, $boot, $sponsor, $website, $magicflower, $rusticharmonycandles, $caregiver, $pvp, $pve, $freetunez;
		protected $sys;
		public $pageRoute;
		
		function __construct($page = 0)
		{
			ini_set('memory_limit', '256M');
			$base_url = $this->getCurrentUri();
			$routes = explode('/', $base_url);
			
			array_shift($routes);
			
			$this->pageRoute = $routes;
			
			//var_dump($routes); die();
			
			if($this->pageRoute[0] == ""){
				$this->homepage = true;
			} else {
				$this->homepage = false;
			}
			
			switch($page){
				default:
					header("Location: http://czgames-ark.000webhostapp.com/");
					die();
				case "websites": 
					$this->pageID = 1;
					break;
				case "caregiver":
					$this->pageID = 2;
					break;
				case "customizer":
				    $this->pageID = 3;
				    break;
				case "blog":
					$this->pageID = 4;
					break;
				case "magicflower":
					$this->pageID = 7;
					break;
				case "rusticharmonycandles":
					$this->pageID = 8;
					break;
				case "pvp":
				    $this->pageID = 9;
				    break;
				case "pve":
				    $this->pageID = 10;
				    break;
				case "freetunez":
				    $this->pageID = 11;
				    break;
			}
			
			$this->initialize();
		}
		
		####
		
		/*
		
			The following function will strip the script name from URL
			i.e.  http://www.something.com/search/book/fitzgerald will become /search/book/fitzgerald
			
		*/
		function getCurrentUri()
		{
			$basepath = implode('/', array_slice(explode('/', $_SERVER['SCRIPT_NAME']), 0, -1)) . '/';
			$uri = substr($_SERVER['REQUEST_URI'], strlen($basepath));
			if (strstr($uri, '?')) $uri = substr($uri, 0, strpos($uri, '?'));
			$uri = '/' . trim($uri, '/');
			return $uri;
		}
		
		private function initialize() 
		{
			
			$this->boot = new Boot();
			
			switch($this->pageID) {
				
				default: 
					header("Location: http://czgames-ark.000webhostapp.com/");
					die();
				case 3:
				    $this->customizer = $this->k = new Customizer();
				    break;
			}
			
			if(connection::connect(intval($this->pageID))) {
				$this->pageInstance = $this->k;
				$this->pageInstance->start($this->pageRoute, $this->homepage);
			} else {
				die("There was an error connecting to the database. Please try again later!");
			}
			
		}
		
	}
	
?>