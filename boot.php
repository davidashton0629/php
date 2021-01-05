<?php
	class Boot extends ALF
	{
		
		function __construct()
		{
			
		}
		
		/*
		
			Generates a <div> set of breadcrumbs, pass array('qLink'=>false) to remove <span>Quick Links</span>
		
		*/
		
		public function breadcrumbs($options = array())
		{
			$o = array_merge(array(
				'qLink'=>true,
				'override'=>null
			), $options);
			
			extract($o);
			
			$crumbs = explode("/",$_SERVER["REQUEST_URI"]);
			$data = "";
			$link = $this->sys['path'];
			if(isset($override) && $override !== null) {
				$link = $override;
			}
			
			if($qLink) {
				$data .= "<span id='identifier'>Quick Links</span>";
			}
			
			$total = count($crumbs); 
			if(end($crumbs) == "") {
				array_pop($crumbs);
			}
			
			$curLink = 1;
			$extender = "";
			
			foreach($crumbs as $crumb) {
				$item = strtolower(str_replace(array(".php","_","/"),array(""," ",""),$crumb));
				if($item !== '' && $item !== '/') {
					$extender .= "/" . $item;
					if($item !== "view"
					&& $item !== "category"
					&& $item !== "pages") {
						if($crumb !== $crumbs[$total - 1]) {
							$data .= "<a class='link" . $curLink . "' href='" . $link . $extender . "'>" . $item . "</a>&nbsp;<span class='link" . $curLink . "'>/</span>&nbsp;";
						} else {
							$data .= "<a class='active link" . $curLink . "' href='" . $link . $extender . "'>" . $item . "</a>";
						}
					}
				}
				$curLink++;
			}
			
			return $data;
		}
		
		/*
		
			Populates the topHeader with given information, including links and a slogan
			array(
				"homeLink" => "",
				"homeLinkTitle" => "",
				"topMenu" => array(
					"topMenuLinks" => array(),
				),
				"slogan"=>""
			)
		*/
		
		public function topHeader($data = array()) 
		{
			
			$options = array_merge(
			array(
				"homeLink" => "",
				"homeLinkTitle" => "",
				"logoEnabled" => true,
				"topMenuEnabled"=> true,
				"bottomMenuEnabled"=> true,
				"allowSearch"=>false,
				"topMenu" => array(
					"topMenuLinks" => array(
					),
				),
				"slogan"=>""
			), $data);
			
			extract($options);
			
			$html = "";
				$html .= "<div id='header'>";
					$html .= "<div id='headerWrap'>";
					if($logoEnabled) {
						$html .= "<div id='logo'>";
							$html .= "<h1>";
								$html .= "<a href='" . $homeLink . "' title='" . $homeLinkTitle . "'>" . $homeLinkTitle . "</a>";
							$html .= "</h1>";
						$html .= "</div>";
					}
					if($topMenuEnabled) {
						$html .= "<div id='topMenu'>";
							$html .= "<ul class='menu'>";
							
								foreach($topMenu['topMenuLinks'] as $menuItem) {
									if(isset($menuItem['subMenu']) && $menuItem['subMenu'] !== null) {
										if(isset($menuItem['class']) && $menuItem['class'] !== '') {
											$menuItem['class'] .= " dropdown";
										} else {
											$menuItem['class'] = "dropdown";
										}
									}
									if(isset($menuItem['title']) && $menuItem['title'] !== null && isset($menuItem['text']) && $menuItem['text'] !== null) {
										if(isset($menuItem['class']) && $menuItem['class'] !== null) {
											if(isset($menuItem['target']) && $menuItem['target'] !== null) {
												$html .= "<li target='" . $menuItem['target'] . "' class='item " . $menuItem['class'] . "'><a title='" . $menuItem['title'] . "' href='" . $menuItem['url'] . "'>" . $menuItem['text'] . "</a>";
											} else {
												$html .= "<li class='item " . $menuItem['class'] . "'><a title='" . $menuItem['title'] . "' href='" . $menuItem['url'] . "'>" . $menuItem['text'] . "</a>";
											}
										} else {
											if(isset($menuItem['target']) && $menuItem['target'] !== null) {
												$html .= "<li target='" . $menuItem['target'] . "' class='item'><a title='" . $menuItem['title'] . "' href='" . $menuItem['url'] . "'>" . $menuItem['text'] . "</a>";
											} else {
												$html .= "<li class='item'><a title='" . $menuItem['title'] . "' href='" . $menuItem['url'] . "'>" . $menuItem['text'] . "</a>";
											}
										}
										if(isset($menuItem['subMenu']) && $menuItem['subMenu'] !== null) {
											$html .= "<ul>";
											$subMenuItems = $menuItem['subMenu'];
											foreach($subMenuItems as $subMenuItem) {
												if(isset($subMenuItem['class']) && $subMenuItem['class'] !== null) {
													if(isset($subMenuItem['target']) && $subMenuItem['target'] !== null) {
														$html .= "<li target='" . $subMenuItem['target'] . "' class='item " . $subMenuItem['class'] . "'><a title='" . $subMenuItem['title'] . "' href='" . $subMenuItem['url'] . "'>" . $subMenuItem['text'] . "</a></li>";
													} else {
														$html .= "<li class='item " . $subMenuItem['class'] . "'><a title='" . $subMenuItem['title'] . "' href='" . $subMenuItem['url'] . "'>" . $subMenuItem['text'] . "</a></li>";
													}
												} else {
													if(isset($subMenuItem['target']) && $subMenuItem['target'] !== null) {
														$html .= "<li target='" . $subMenuItem['target'] . "' class='item'><a title='" . $subMenuItem['title'] . "' href='" . $subMenuItem['url'] . "'>" . $subMenuItem['text'] . "</a></li>";
													} else {
														$html .= "<li class='item'><a title='" . $subMenuItem['title'] . "' href='" . $subMenuItem['url'] . "'>" . $subMenuItem['text'] . "</a></li>";
													}
												}
											}
											$html .= "</ul>";
										}
										$html .= "</li>";
									
									} else {
									    
										if(isset($menuItem['title'])) {
										    $html .= "<li title='" . $menuItem['title'] . "'><a href='" . $menuItem['url'] . "'>" . $menuItem['text'] . "</a>";
										}
										if(isset($menuItem['subMenu']) && $menuItem['subMenu'] !== null) {
											$html .= "<ul>";
											foreach($menuItem['subMenu'] as $subMenuItem) {
												if(isset($subMenuItem['class']) && $subMenuItem['class'] !== null) {
													$html .= "<li class='" . $subMenuItem['class'] . "'><a title='" . $subMenuItem['title'] . "' href='" . $subMenuItem['url'] . "'>" . $subMenuItem['text'] . "</a></li>";
												} else {
													$html .= "<li><a title='" . $subMenuItem['title'] . "' href='" . $subMenuItem['url'] . "'>" . $subMenuItem['text'] . "</a></li>";
												}
											}
											$html .= "</ul>";
										}
										$html .= "</li>";
									}
								}
								
							$html .= "</ul>";
						$html .= "</div>";
					}
					
					if($slogan !== "") {
						$html .= "<div id='slogan'>";
							$html .= "<p>" . $slogan . "</p>";
						$html .= '</div>';
					}
					
					if($bottomMenuEnabled) {
						$html .= "<div id='nav'>";
							$html .= "<ul class='menu'>";
							
								foreach($topMenu['topMenuLinks'] as $menuItem) {
									if(isset($menuItem['subMenu']) && $menuItem['subMenu'] !== null) {
										if(isset($menuItem['class']) && $menuItem['class'] !== '') {
											$menuItem['class'] .= " dropdown";
										} else {
											$menuItem['class'] = "dropdown";
										}
									}
									
									if(isset($menuItem['class']) && $menuItem['class'] !== null) {
										$html .= "<li class='" . $menuItem['class'] . "'><a title='" . $menuItem['title'] . "' href='" . $menuItem['url'] . "'>" . $menuItem['text'] . "</a>";
										
										if(isset($menuItem['subMenu']) && $menuItem['subMenu'] !== null) {
											$html .= "<ul>";
											foreach($menuItem['subMenu'] as $subMenuItem) {
												if(isset($subMenuItem['class']) && $subMenuItem['class'] !== null) {
													$html .= "<li class='" . $subMenuItem['class'] . "'><a title='" . $subMenuItem['title'] . "' href='" . $subMenuItem['url'] . "'>" . $subMenuItem['text'] . "</a></li>";
												} else {
													$html .= "<li><a title='" . $subMenuItem['title'] . "' href='" . $subMenuItem['url'] . "'>" . $subMenuItem['text'] . "</a></li>";
												}
											}
											$html .= "</ul>";
										}
										$html .= "</li>";
									
									} else {
										$html .= "<li><a title='" . $menuItem['title'] . "' href='" . $menuItem['url'] . "'>" . $menuItem['text'] . "</a>";
										if(isset($menuItem['subMenu']) && $menuItem['subMenu'] !== null) {
											$html .= "<ul>";
											foreach($menuItem['subMenu'] as $subMenuItem) {
												if(isset($subMenuItem['class']) && $subMenuItem['class'] !== null) {
													$html .= "<li class='" . $subMenuItem['class'] . "' title='" . $subMenuItem['title'] . "'><a href='" . $subMenuItem['url'] . "'>" . $subMenuItem['text'] . "</a></li>";
												} else {
													$html .= "<li><a title='" . $subMenuItem['title'] . "' href='" . $subMenuItem['url'] . "'>" . $subMenuItem['text'] . "</a></li>";
												}
											}
											$html .= "</ul>";
										}
										$html .= "</li>";
									}
								}
								
							$html .= "</ul>";
							
							if($allowSearch) {
								$html .= $this->searchBar();
							}
						$html .= "</div>";
						
					}
					
					$html .= "<div class='clr'></div>";
					$html .= "</div>";
				$html .= "</div>";
				
			return $html;
			
		}
		
		
		/*
		
			Creates body content with given information.
			
			REQUIRED FOR EACH PAGE EXTENSION E.G. /ABOUT/ /CONTACT/ /STORE/ /VIEW/
			array(
				"page" => "",
				"pageType"=>""
			)
		
		*/
		public function bodyContent($data = array()) 
		{
			//var_dump($data); die();
			$options = array_merge( array(
				"page" => "",
				"pageType"=>""
			), $data);
			
			extract($options);
			
			$locationDefault = "http://czgames-ark.000webhostapp.com/";
			if(strpos("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]", "ark") > 0) {
				if(strpos("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]", "customizer") > 0) {
					if(strpos("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]", "tools") > 0) {
						$locationDefault = "http://czgames-ark.000webhostapp.com/pages/customizer/tools";
					} elseif(strpos("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]", "execute") > 0) {
						$locationDefault = "http://czgames-ark.000webhostapp.com/pages/customizer/execute";
					} else {
						$locationDefault = "http://czgames-ark.000webhostapp.com/pages/customizer/";
					}
				} else{
					$locationDefault = "http://czgames-ark.000webhostapp.com/";
				}
			}
			
			if($page == "websiteHome") {
				return $this->homeBody();
			} else {
				//var_dump($pageType);die();
				switch($pageType) 
				{
					default:
						header("Location: $locationDefault");
						break;
					case "about":
						return $this->aboutBody();
						break;
					case "contact":
						return $this->contactBody();
						break;
					case "contact-us":
						return $this->contactBody();
						break;
					case "portfolio":
						return $this->portfolioBody();
						break;
					case "team":
						return $this->teamBody();
						break;
					case "trending":
						return $this->trendingBody();
						break;
					case "view":
						return $this->view();
						break;
					case "search":
						return $this->search();
						break;
					case "admin":
						return $this->adminPanel();
						break;
					case "shop":
						return $this->view();
						break;
					case "tips":
						return $this->tips();
						break;
					case "get":
						return $this->get();
						break;
					case "cart":
						return $this->cart();
						break;
					case "file-upload":
						return $this->adminPanel();
						break;
					case "rates":
					    return $this->ratesView();
					    break;
					case "mods":
					    return $this->modsView();
					    break;
					case "tools":
						return $this->toolsView();
						break;
					case "experience-ramp-generator":
						return $this->expRamp();
						break;
					case "exp":
						return $this->performExpRamp();
						break;
				}
			}
			
		}
		
		public function resize_image($file, $w, $h, $crop=FALSE) {
			//var_dump($file, $w, $h); die();
			list($width, $height) = getimagesize($file['tmp_name']);
			$r = $width / $height;
			if ($crop) {
				if ($width > $height) {
					$width = ceil($width-($width*abs($r-$w/$h)));
				} else {
					$height = ceil($height-($height*abs($r-$w/$h)));
				}
				$newwidth = $w;
				$newheight = $h;
			} else {
				if ($w/$h > $r) {
					$newwidth = $h*$r;
					$newheight = $h;
				} else {
					$newheight = $w/$r;
					$newwidth = $w;
				}
			}

			if($file['type'] == "image/jpeg") { 
				$src = imagecreatefromjpeg($file['tmp_name']);
			} else {
				$src = imagecreatefrompng($file['tmp_name']);
			}
			$dst = imagecreatetruecolor($newwidth, $newheight);
			imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
			//var_dump($dst); die();
			//return imagejpeg($dst);
			return $dst;
		}
		
		public function array_first_value($arr = array())
		{
			return array_values($arr)[0];
		}
		
		/*
		
			Creates a form with specifications
		
		*/
		
		public function form($link = "", $type = "", $fast = false, $target = "")
		{
			
			$data = "";
			
			switch($type)
			{
				
				default: 
					break;
				case "contact":
					$data .= "<form id='contact' method='post' action='$link'>";
						$data .= "<fieldset>";
						
							if($fast) {
								$data .= "<legend>Contact Us</legend>";
								$data .= "<input class='required' id='name' placeholder='Your Name' name='name' type='text' />";
								$data .= "<input class='required' id='email' placeholder='Your Email' name='email' type='email' />";
								$data .= "<textarea class='required' id='message' placeholder='Your Message' name='message'></textarea>";
								$data .= "<input id='contact' value='Contact Now' name='contact' type='submit'>";
							} else {
								$data .= "<div class='input inputText' id='name'>";
									$data .= "<input class='required' name='name' type='text' placeholder='Your Name' />";
								$data .= "</div>";
								$data .= "<div class='input inputText' id='phone'>";
									$data .= "<input class='required' name='phone' type='text' placeholder='A Contact Number' />";
								$data .= "</div>";
								$data .= "<div class='input inputText' id='email'>";
									$data .= "<input class='required' name='email' type='email' placeholder='A Confirmation Email' />";
								$data .= "</div>";
								$data .= "<div class='input textarea' id='contactMessage'>";
									$data .= "<textarea class='required' name='message' id='message' placeholder ='Your Message or Question'></textarea>";
								$data .= "</div>";
								$data .= "<div class='input submit' id='contactSend'>";
									$data .= "<input name='contact' type='submit' value='Send Message' />";
								$data .= "</div>";
							}
							
						$data .= "</fieldset>";
					$data .= "</form>";
					break;
				case "exp":
					if($target !== "") { 
					$data .= "<form target='$target' id='contact' method='post' action='$link'>"; } 
					else { 
					$data .= "<form id='contact' method='post' action='$link'>"; }
						$data .= "<fieldset>";
							$data .= "<legend>How Many Levels Do You Want?</legend>";
							$data .= "<div id='step1'>";
								$data .= "<div class='input inputText' id='levels'>";
										$data .= "<input title='Supports Up To 300 Levels' onkeypress='return nKey(event)' class='required' name='levels' type='text' placeholder='Total Levels' />";
									$data .= "</div>";
									$data .= "<div class='input checkBox' id='augment'>";
										$data .= "<span>Use Augmented Experience?</span>";
										$data .= "<input title='Use Customized Experience Scheme - 12% Interval' class='optional' name='augment' type='checkbox' />";
									$data .= "</div>";
									$data .= "<div class='input button' id='continueButton1'>";
										$data .= "<input type='button' class='continue' id='continue1' value='Continue' />";
									$data .= "</div>";
							$data .= "</div>";
							$data .= "<div id='step2' class='hidden'>";
								$data .="<div class='input inputText' id='intervals'>";
									$data .= "<span>This is the amount of times your experience should increase. E.G. -- Lvl 150 cap, 3 intervals -- 0-50,50-100,100-150</span>";
									$data .= "<input type='text' onkeypress='return nKey(event)' class='required' name='intervals' placeholder='Experience Intervals' />";
									$data .= "<input type='text' onkeypress='return nKey(event,true)' class='augment hidden required' name='intervals' placeholder='Augment Amount - Default 1.12' />";
								$data .= "</div>";
								$data .= "<div class='hidden array' id='expArray'>";
									$data .= "<h4>How much experience does each section need?</h4>";
								$data .= "</div>";
								$data .= "<div class='hidden array' id='engramArray'>";
									$data .= "<h4>How many engrams should each section get?</h4>";
								$data .= "</div>";
								$data .= "<div class='input button' id='continueButton2'>";
									$data .= "<input type='button' class='disabled continue' id='continue2' value='Continue' />";
								$data .= "</div>";
							$data .= "</div>";
							$data .= "<div id='step3' class='hidden'>";
								$data .= "<div id='expConfirm'>";
								
								$data .= "</div>";
							$data .= "</div>";
							$data .= "<div id='finalStep' class='hidden'>";
								$data .= "<input id='changeDino' type='hidden' name='changeDino' value='false' />";
							$data .= "</div>";
							$data .= "<input id='generate' value='Generate' name='generate' type='submit'>";
						$data .= "</fieldset>";
					$data .= "</form>";
					$data .= "<p class='notify'>To reset, just refresh the page.</p>";
					break;
				
			}
			
			return $data;
			
		}
		
		public function cutStringToLength($string, $length)
		{
			return substr($string, 0, $length);
		}
		
		/*
			JSON method for IP grab
		*/
		
		public function getUserIP()
		{
			echo $_SERVER['REMOTE_ADDR']; die();
		}
		
		/*
		`	Sends Email
		*/
		
		public function sendForm($type = "",$data = null)
		{
			//return $data !== null ? implode($data) : $data;
			if($data !== null) {
				return mail("support@" . $this->sys['path'] . ".com","Contact Email From: " . $data['name'], $data['message'], "From: " . $data['email']);
			}
		}
		
		/*
		
			returns a genetic search bar html sequence
		
		*/
		
		public function searchBar($list = false)
		{
			
			$data = "";
			
			if(!$list) {
				$data .= "<div id='search'>";
					$data .= "<form id='searchForm'><input id='search-text' placeholder='Search ALFs Blog' /><input type='submit' id='search-submit' value='search' /></form>";
				$data .= "</div>";
			} else {
				$data .= "<li id='search'>";
					$data .= "<form id='searchForm'><input id='search-text' placeholder='Search ALFs Blog' /><input type='submit' id='search-submit' value='search' /></form>";
				$data .= "</li>";
			}
			
			return $data;
			
		}
		
		/*
		
			Unmakes a slug out of a given string. E.G. unSlugify("some-random-text"); returns "Some Random Text"
		
		*/
		
		public function unSlugify($text, $uppercase = false)
		{
			if(!$uppercase) {
				$text = strtolower($text);
				$text = str_replace(array('we-re'),array('we\'re'),$text);
				$text = strtolower(str_replace('-',' ', $text));
			}
			if(substr($text, -1) == ' ') {
				$text = substr(trim($text), 0, -1);
			}
			
			return $text;
		}
		
		/*
		
			Creates a slug out of a given string. E.G. slugify("Some Random Text"); returns "some-random-text"
		
		*/
		
		public function slugify($text, $uppercase = false)
		{
			if(!$uppercase) {
				$text = strtolower(preg_replace('~[^\pL\d]+~u', '-', $text));
			}
			if(substr($text, -1) == '-') {
				$text = substr(trim($text), 0, -1);
			}
			
			return $text;
		}
		
		/*
		
			Function that handles file uploads, only requires $_POST of a $_FILE and an open directory to store in.
		
		*/
		
		public function uploadFile($file, $directory)
		{
			//var_dump($file); die();
			//header('Content-Type: text/plain; charset=utf-8');
			if(gettype($file) == "resource") {
				//opendir($directory);
				//var_dump($file); die();
				try {
					if(imagepng($file, $directory, 9)) {
						return true;
					} else {
						throw new RuntimeException('There was an error uploading the file.');
					}
				} catch (RuntimeException $e) {
					echo $e->getMessage();
					die();
				}
				
			} else {
				if (!is_dir($directory)) {
					mkdir($directory, 0777, true);
				}
				try {
					// Undefined | Multiple Files | $_FILES Corruption Attack
					// If this request falls under any of them, treat it invalid.
					if (!isset($file['error']) || is_array($file['error'])) {
						throw new RuntimeException('Invalid parameters.');
					}
					
					// Check $_FILES['upfile']['error'] value.
					switch ($file['error']) {
						case UPLOAD_ERR_OK:
							break;
						case UPLOAD_ERR_NO_FILE:
							throw new RuntimeException('No file sent.');
						case UPLOAD_ERR_INI_SIZE:
							throw new RuntimeException('Unknown Error');
						case UPLOAD_ERR_FORM_SIZE:
							throw new RuntimeException('Exceeded filesize limit.');
						default:
							throw new RuntimeException('Unknown errors.');
					}

					// You should also check filesize here.
					if ($file['size'] > 1000000) {
						throw new RuntimeException('Exceeded filesize limit.');
					}

					// DO NOT TRUST $_FILES['upload']['mime'] VALUE !!
					// Check MIME Type by yourself.
					$finfo = new finfo(FILEINFO_MIME_TYPE);
					if (false === $ext = array_search(
						$finfo->file($_FILES['upload']['tmp_name']),
						array(
							'jpg' => 'image/jpeg',
							'png' => 'image/png',
							'gif' => 'image/gif',
						),
						true
					)) {
						throw new RuntimeException('Invalid file format.');
					}
					// You should name it uniquely.
					// DO NOT USE $_FILES['upload']['name'] WITHOUT ANY VALIDATION !!
					// On this example, obtain safe unique name from its binary data.
					if (!move_uploaded_file($file['tmp_name'], $directory . $file['name'])) {
						throw new RuntimeException('Failed to move uploaded file.');
					} else {
						return true;
					}

				} catch (RuntimeException $e) {
					echo $e->getMessage();
					die();
				}
			}
		}
	}
?>