<?php

class admin
{
	
	static $account, $pageView;
	
	
	/*
			
			Handles the initial administration load screen. Shows list items
			
	*/
	static public function administration($page = "")
	{
		self::$pageView = $page;
		/*
		
			Authenticates login by checking for a cookie. If no cookie, force user to log in.
		
		*/
		if(self::$account == null) {
			if(!isset($_COOKIE['alfAccount' . $page])) {
				if(isset($_POST['user'])) {
					
					$options = array(
						"selectType"=>"*",
						"tableName"=>"admins",
						"identifier"=>"WHERE user='" . mysqli_real_escape_string(connection::$con, $_POST['user']) . "' AND password_encrypt='" . hash("md5", $_POST['password'] + "alocalfarmer") . "'"
					);
					//var_dump($options);die();
					if(connection::getData($options)) {
						setcookie("alfAccount" . $page, $_POST['user'], time()+36000, '/');						
						die("<script>window.location = '". str_replace("#","","http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]'</script>"));
					} else {
						return admin::login();
					}
				} else {
					return admin::login();
				}
			} else {
				self::$account = $_COOKIE['alfAccount' . $page];
				setcookie("alfAccount" . $page, self::$account, time()+36000, '/');
			}
		}
		
		/*
		
			Begin data collection
		
		*/
		
		$data = "";
		
		$data .= admin::adminTools($page); # Always includes admin tools, send page type to handle additional items
		//var_dump($page); die();
		$data .= "<div id='adminPanel'>";
		
		if($page == "blog") {
			/*
				BLOG HANDLING
			*/
			$data .= self::displayItems("posts");
		} elseif($page == "websites") {
			/*
				WEBSITE HANDLING
			*/
			$data .= self::displayItems("slides","portfolio");
		} elseif($page == "rusticharmonycandles") {
			/*
				RUSTIC HARMONY CANDLES N THINGS HANDLING
			*/
			$data .= self::displayItems("categories","products");
		}
		
		$data .= "</div>";
		
		return $data;
	}
		
	static public function login()
	{
		$data = "";
		
		$data .= "<div id='login'>";
			$data .= "<form id='loginForm' method='post' action='#'>";
				$data .= "<input id='user' name='user' placeholder='username' />";
				$data .= "<input id='password' name='password' type='password' placeholder='password' />";
				$data .= "<input id='submit' name='submit' type='submit' value='Login' />";
			$data .= "</form>";
		$data .= "</div>";
		
		return $data;
	}
	
	
	
	
	/*
	
		CREATE NEW ITEM BLOCK SECTION
	
	*/
	
	
	static public function create($page = "", $modifier = "")
	{		
		$data = "";
		switch($page)
		{
			default: break;
			
			case "blog":
				$items = array(
					"title"			=>	array(
										'title'=>'title',
										'type'=>'text',
										'text'=>'Title',
										'break'=>true
									),
					"short_desc"		=>	array(
										'title'=>'short_desc',
										'type'=>'text',
										'text'=>'Preview Content',
										'break'=>true
									),
					"tags"			=>	array(
										'title'=>'tags',
										'type'=>'text',
										'text'=>'Tags'
									),
					"theme"			=>	array(
										'title'=>'theme',
										'type'=>'text',
										'text'=>'Theme'
									),
					"coverStyle"	=>	array(
										'title'=>'coverStyle',
										'type'=>'select',
										'text'=>'Cover Style',
										'options'=>array(
											"round",
											"square"
										)
									),
					"cover"			=>	array(
										'title'=>'cover',
										'type'=>'file',
										'text'=>'Slider Photo<span>760w x 300h</span>',
										'break'=>true,
										'size'=>'760,300'
									),
					"content"	=>	array(
										'title'=>'content',
										'type'=>'text',
										'text'=>'Post Content',
										'break'=>true
									),
					"submit"		=>	array(
										'title'=>'submit',
										'type'=>'submit',
										'text'=>'Create',
										'class'=>'right'
									)
				);
				break;
			case "websites":
				if($modifier == "slides") {
					$items = array(
						"title"			=>	array(
											'title'=>'title',
											'type'=>'text',
											'text'=>'Title'
										),
						"cover"			=>	array(
											'title'=>'cover',
											'type'=>'file',
											'text'=>'Slider Photo<span>760w x 300h</span>',
											'size'=>'760,300'
										),
						"description"	=>	array(
											'title'=>'description',
											'type'=>'text',
											'text'=>'Description',
											'class'=>'threefourth',
											'break'=>true
										),
						"submit"		=>	array(
											'title'=>'submit',
											'type'=>'submit',
											'text'=>'Create',
											'class'=>'right'
										),
					);
				} elseif($modifier == "portfolio") {
					$items = array(
						"title"			=>	array(
											'title'=>'title',
											'type'=>'text',
											'text'=>'Title'
										),
						"cover"			=>	array(
											'title'=>'cover',
											'type'=>'file',
											'text'=>'Portfolio Photo<span>450w x 275h</span>',
											'size'=>'450,275'
										),
						"link"			=>	array(
											'title'=>'link',
											'type'=>'text',
											'text'=>'Link To Site'
										),
						"description"	=>	array(
											'title'=>'description',
											'type'=>'text',
											'text'=>'Description',
											'class'=>'twothird',
											'break'=>true
										),
						"submit"		=>	array(
											'title'=>'submit',
											'type'=>'submit',
											'text'=>'Create',
											'class'=>'right'
										),
					);
				}
				break;
			case "rusticharmonycandles":
				if($modifier == "categories") {
					$items = array(
						"title"			=>	array(
											'title'=>'title',
											'type'=>'text',
											'text'=>'Title'
										),
						"cover"			=>	array(
											'title'=>'cover',
											'type'=>'file',
											'text'=>'Category Photo<span>345w x 280h</span>',
											'size'=>'345,280'
										),
						"short_desc"	=>	array(
											'title'=>'short_desc',
											'type'=>'text',
											'text'=>'Short Description'
										),
						"description"	=>	array(
											'title'=>'description',
											'type'=>'text',
											'text'=>'Description',
											'class'=>'twothird',
											'break'=>true
										),
						"tags"			=>	array(
											'title'=>'tags',
											'type'=>'text',
											'text'=>'Tags'
										),
						"category"		=>	array(
											'title'=>'category',
											'type'=>'select',
											'text'=>'Parent Category',
											'options'=>array("Top Level")
										),
						"submit"		=>	array(
											'title'=>'submit',
											'type'=>'submit',
											'text'=>'Update',
											'class'=>'right'
										),
					);
				} elseif($modifier == "products") {
					$items = array(
						"title"			=>	array(
											'title'=>'title',
											'type'=>'text',
											'text'=>'Title'
										),
						"cover"			=>	array(
											'title'=>'cover',
											'type'=>'file',
											'text'=>'Category Photo<span>345w x 280h</span>',
											'size'=>'345,280'
										),
						"short_desc"	=>	array(
											'title'=>'short_desc',
											'type'=>'text',
											'text'=>'Short Description'
										),
						"description"	=>	array(
											'title'=>'description',
											'type'=>'text',
											'text'=>'Description',
											'class'=>'twothird',
											'break'=>true
										),
						"tags"			=>	array(
											'title'=>'tags',
											'type'=>'text',
											'text'=>'Tags'
										),
						"category"		=>	array(
											'title'=>'category',
											'type'=>'select',
											'text'=>'Parent Category',
											'options'=>array("Top Level")
										),
						"price"			=>	array(
											'title'=>'price',
											'type'=>'text',
											'text'=>'Product Price'
										),
						"ingredients"	=>	array(
											'title'=>'ingredients',
											'type'=>'text',
											'text'=>'Product Ingredients',
											'class'=>'last',
											'break'=>true
										),
						"gallery"		=>	array(
											'title'=>'gallery',
											'type'=>'gallery',
											'text'=>'Gallery Images',
											'class'=>'gallery'
										),
						"submit"		=>	array(
											'title'=>'submit',
											'type'=>'submit',
											'text'=>'Create',
											'class'=>'right'
										),
					);
					
				}
			
				$catData = connection::getData(array("selectType"=>"*","tableName"=>"categories","identifier"=>""));
				$categories = $catData;
				foreach($categories as $index=>$category) {
					$items['category']['options'][] = $category['title'];
				}
				break;
		}
		$data .= self::createForm($page, $modifier, $items);
		return $data;
	}
	
	static public function edit($page = "", $id = 0, $modifier = "")
	{
		
		$data = "";
		$data .= admin::adminTools();
		
		$data .= "<div id='adminPanel'>";
		
		/* 
		
			ADMIN EDIT PAGE FOR BLOG SYSTEM
			
		*/
		if($page == "blog") {
			$displayOptions = array(
				"title"			=>	array(
									'title'=>'title',
									'type'=>'text',
									'text'=>'Title',
									'break'=>true
								),
				"short_desc"		=>	array(
									'title'=>'short_desc',
									'type'=>'text',
									'text'=>'Preview Content',
									'break'=>true
								),
				"tags"			=>	array(
									'title'=>'tags',
									'type'=>'text',
									'text'=>'Tags'
								),
				"theme"			=>	array(
									'title'=>'theme',
									'type'=>'text',
									'text'=>'Theme'
								),
				"coverStyle"	=>	array(
									'title'=>'coverStyle',
									'type'=>'select',
									'text'=>'Cover Style',
									'options'=>array(
										"round",
										"square"
									)
								),
				"cover"			=>	array(
									'title'=>'cover',
									'type'=>'file',
									'text'=>'Slider Photo<span>760w x 300h</span>',
									'break'=>true,
									'size'=>'760,300'
								),
				"content"	=>	array(
									'title'=>'content',
									'type'=>'text',
									'text'=>'Post Content',
									'break'=>true
								),
				"submit"		=>	array(
									'title'=>'submit',
									'type'=>'submit',
									'text'=>'Update',
									'class'=>'right'
								)
			);
		} elseif ($page == "websites"){
			/*
			
				ADMIN EDIT PAGE FOR WEBSITES SYSTEM
			
			*/
			if($modifier == "slides") {
				$displayOptions = array(
					"title"			=>	array(
										'title'=>'title',
										'type'=>'text',
										'text'=>'Title'
									),
					"cover"			=>	array(
										'title'=>'cover',
										'type'=>'file',
										'text'=>'Slider Photo<span>760w x 300h</span>',
										'size'=>'760,300'
									),
					"description"	=>	array(
										'title'=>'description',
										'type'=>'text',
										'text'=>'Description',
										'class'=>'threefourth',
										'break'=>true
									),
					"submit"		=>	array(
										'title'=>'submit',
										'type'=>'submit',
										'text'=>'Update',
										'class'=>'right'
									),
				);
			} elseif($modifier == "portfolio") {
				$displayOptions = array(
					"title"			=>	array(
										'title'=>'title',
										'type'=>'text',
										'text'=>'Title'
									),
					"cover"			=>	array(
										'title'=>'cover',
										'type'=>'file',
										'text'=>'Portfolio Photo<span>450w x 275h</span>',
										'size'=>'450,275'
									),
					"link"			=>	array(
										'title'=>'link',
										'type'=>'text',
										'text'=>'Link To Site'
									),
					"description"	=>	array(
										'title'=>'description',
										'type'=>'text',
										'text'=>'Description',
										'class'=>'twothird',
										'break'=>true
									),
					"submit"		=>	array(
										'title'=>'submit',
										'type'=>'submit',
										'text'=>'Update',
										'class'=>'right'
									),
				);
			} else {
				return false;
			}			
		} elseif($page == "rusticharmonycandles") {
			if($modifier == "categories") {
				$displayOptions = array(
					"title"			=>	array(
										'title'=>'title',
										'type'=>'text',
										'text'=>'Title'
									),
					"cover"			=>	array(
										'title'=>'cover',
										'type'=>'file',
										'text'=>'Category Photo<span>345w x 280h</span>',
										'size'=>'345,280'
									),
					"short_desc"	=>	array(
										'title'=>'short_desc',
										'type'=>'text',
										'text'=>'Short Description'
									),
					"description"	=>	array(
										'title'=>'description',
										'type'=>'text',
										'text'=>'Description',
										'class'=>'twothird',
										'break'=>true
									),
					"tags"			=>	array(
										'title'=>'tags',
										'type'=>'text',
										'text'=>'Tags'
									),
					"category"		=>	array(
										'title'=>'category',
										'type'=>'select',
										'text'=>'Parent Category',
										'options'=>array("Top Level")
									),
					"submit"		=>	array(
										'title'=>'submit',
										'type'=>'submit',
										'text'=>'Update',
										'class'=>'right'
									),
				);
			} elseif($modifier == "products") {
				$displayOptions = array(
					"title"			=>	array(
										'title'=>'title',
										'type'=>'text',
										'text'=>'Title'
									),
					"cover"			=>	array(
										'title'=>'cover',
										'type'=>'file',
										'text'=>'Category Photo<span>345w x 280h</span>',
										'size'=>'345,280'
									),
					"short_desc"	=>	array(
										'title'=>'short_desc',
										'type'=>'text',
										'text'=>'Short Description'
									),
					"description"	=>	array(
										'title'=>'description',
										'type'=>'text',
										'text'=>'Description',
										'class'=>'twothird',
										'break'=>true
									),
					"tags"			=>	array(
										'title'=>'tags',
										'type'=>'text',
										'text'=>'Tags'
									),
					"category"		=>	array(
										'title'=>'category',
										'type'=>'select',
										'text'=>'Parent Category',
										'options'=>array("Top Level")
									),
					"price"			=>	array(
										'title'=>'price',
										'type'=>'text',
										'text'=>'Product Price'
									),
					"ingredients"	=>	array(
										'title'=>'ingredients',
										'type'=>'text',
										'text'=>'Product Ingredients',
										'class'=>'last',
										'break'=>true
									),
					"gallery"		=>	array(
										'title'=>'gallery',
										'type'=>'gallery',
										'text'=>'Gallery Images',
										'class'=>'gallery'
									),
					"submit"		=>	array(
										'title'=>'submit',
										'type'=>'submit',
										'text'=>'Update',
										'class'=>'right'
									),
				);
			}
			
			$catData = connection::getData(array("selectType"=>"*","tableName"=>"categories","identifier"=>""));
			
			$categories = $catData;
			foreach($categories as $index=>$category) {
				$displayOptions['category']['options'][] = $category['title'];
			}
		}
		
		$data .= self::editForm($modifier,$id,$displayOptions);
		$data .= "</div>";
		
		return $data;
	}
	
	static public function createForm($page = "", $modifier = "", $items = array())
	{
		$data = "";
		$data .= "<div id='adminPanel' class='item-display'>";
			$data .= admin::adminTools();
			$opt = array(
				"selectType"=>"*",
				"tableName"=>$modifier,
				"identifier"=>"ORDER BY id DESC"
			);
			
			if(connection::getData($opt)) {
				$lastPost = connection::getData($opt);
				$lastPostInfo = array_values($lastPost);
				$lastPostInfo = $lastPostInfo[0];
				$id = intval($lastPostInfo['id']) + 1;
			} else {
				die("THERE WAS AN ISSUE");
				return false;
			}
			
			if(!$id) {
				$id = 1;
			}
			
			$data .= "<div id='" . $modifier . "Listing'>";
				$data .= "<form id='edit' enctype='multipart/form-data' method='post' action='http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]/$id'>";
					foreach($items as $key=>$item) {
						$item = array_merge(array(
							'title'=>'',
							'type'=>'',
							'text'=>'',
							'options'=>array(),
							'class'=>'',
							'break'=>false
						), $item);
						//if(isset($item['class'])) {
						//	$data .= "<div class='" . $item['title'] . " " . $item['class'] . "'>";
						//} else {
							$data .= "<div class='" . $item['title'] . "'>";
						//}
							if($item['type'] !== 'submit') {
								$data .= "<label class='" . $item['title'] . "' for='" . $item['title'] . "'>";
								if($item['title'] == 'price') {
									$data .= "<span class='pricetag'>$</span>";
								}
								$data .= $item['text'];
								$data .= "</label>";
							}
							if($item['type'] == "file") {
								if(isset($item['class']) && !empty($item['class'])) {
									$data .= "<input type='file' name='upload' id='photo' class='" . $item['class'] . "' />";
								} else {
									$data .= "<input type='file' name='upload' id='photo' />";
								}
								$data .= "<input type='hidden' name='size' id='size' value='" . $item['size'] . "' />";
							} elseif($item['type'] == 'select') {
								if(isset($item['class']) && !empty($item['class'])) {
									$data .= "<select id='" . $item['title'] . "' name='" . $item['title'] . "' class='" . $item['class'] . "'>";
								} else {
									$data .= "<select id='" . $item['title'] . "'  name='" . $item['title'] . "'>";
								}
								
								foreach($item['options'] as $option) {
									if($option == "Top Level") {
										$data .= "<option value='0'>" . ucwords($option) . "</option>";
									} else {
										$data .= "<option value='" . strtolower($option) . "'>" . ucwords($option) . "</option>";
									}
								}
								
								$data .= "</select>";
							} elseif($item['type'] == 'gallery') {
								$data .= "<span id='addImage'>Add Image</span>";
								if(isset($item['class']) && !empty($item['class'])) {
									$data .= "<textarea class='" . $item['class'] . "' name='" . $item['title'] . "' id='" . $item['title'] . "'></textarea>";
								} else {
									$data .= "<textarea name='" . $item['title'] . "' id='" . $item['title'] . "'></textarea>";
								}
							} elseif($item['type'] == 'submit') {
								if(isset($item['class']) && !empty($item['class'])) {
									$data .= "<input type='submit' name='submit' id='update' value='" . $item['text'] . "' class='" . $item['class'] . "' />";
								} else {
									$data .= "<input type='submit' name='submit' id='update' value='" . $item['text'] . "' />";
								}
								$data .= "<input type='hidden' name='id' value='" . $id . "' />";
							} else {
								if(isset($item['class']) && !empty($item['class'])) {
									$data .= "<textarea class='" . $item['class'] . "' name='" . $item['title'] . "' id='" . $item['title'] . "'>";
									$data .= "</textarea>";
								} else {
									$data .= "<textarea name='" . $item['title'] . "' id='" . $item['title'] . "'>";
									$data .= "</textarea>";
								}
							}
						$data .= "</div>";
						if(isset($item['break']) && $item['break']) {
							$data .= "<div class='clear'></div>";
						}
					}
				$data .= "</form>";
			$data .= "</div>";
			
		$data .= "</div>";
		
		return $data;
	}
	
	static public function editForm($pageType = "", $id, $items = array())
	{
		//var_dump($pageType, $id, $items); die();
		$data = "";
		
		$options = array(
			"selectType"=>"*",
			"tableName"=>$pageType,
			"identifier"=>"WHERE id='$id'"
		);
		
		$posts = connection::getData($options);
		$postInfo = array_values($posts);
		$postInfo = $postInfo[0];
		
		$data .= "<form id='edit' enctype='multipart/form-data' method='post' action='http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]/update'>";
			foreach($items as $key=>$item) {
				$item = array_merge(array(
					'title'=>'',
					'type'=>'',
					'text'=>'',
					'options'=>array(),
					'class'=>'',
					'break'=>false
				), $item);
				$data .= "<div class='" . $item['title'] . "'>";
					if($item['type'] !== 'submit') {
						$data .= "<label class='" . $item['title'] . "' for='" . $item['title'] . "'>";
						if($item['title'] == 'price') {
							$data .= "<span class='pricetag'>$</span>";
						}
						$data .= $item['text'];
						$data .= "</label>";
					}
					if($item['type'] == "file") {
						if(isset($item['class']) && !empty($item['class'])) {
							$data .= "<input type='file' name='upload' id='photo' class='" . $item['class'] . "' />";
						} else {
							$data .= "<input type='file' name='upload' id='photo' />";
						}
						$data .= "<input type='hidden' name='size' id='size' value='" . $item['size'] . "' />";
					} elseif($item['type'] == 'select') {
						if(isset($item['class']) && !empty($item['class'])) {
							$data .= "<select id='" . $item['title'] . "' name='" . $item['title'] . "' class='" . $item['class'] . "'>";
						} else {
							$data .= "<select id='" . $item['title'] . "'  name='" . $item['title'] . "'>";
						}
						
						if($pageType == "categories" || $pageType == "products") {
							if(isset($postInfo['category']) && !empty($postInfo['category'])) {
								$data .= "<option value='" . strtolower($postInfo['category']) . "'>" . ucwords($postInfo['category']) . "</option>";
							}
						}
						
						foreach($item['options'] as $option) {
							if(isset($postInfo['category']) && !empty($postInfo['category'])) {
								if(strtolower($option) == strtolower($postInfo['category'])) {
									continue;
								}
							}
							if($option == "Top Level") {
								$data .= "<option value='0'>" . ucwords($option) . "</option>";
							} else {
								$data .= "<option value='" . strtolower($option) . "'>" . ucwords($option) . "</option>";
							}
						}
						
						$data .= "</select>";
					} elseif($item['type'] == 'gallery') {
						/*$data .= "<span id='addImage'>Add Image</span>";
						if(isset($item['class']) && !empty($item['class'])) {
							$data .= "<textarea class='" . $item['class'] . "' name='" . $item['title'] . "' id='" . $item['title'] . "'>" . $postInfo[$item['title']] . "</textarea>";
						} else {
							$data .= "<textarea name='" . $item['title'] . "' id='" . $item['title'] . "'>" . $postInfo[$item['title']] . "</textarea>";
						}*/
						//$data .= "<form action='/file-upload' class='dropzone' id='my-awesome-dropzone'></form>";
					} elseif($item['type'] == 'submit') {
						if(isset($item['class']) && !empty($item['class'])) {
							$data .= "<input type='submit' name='submit' id='update' value='" . $item['text'] . "' class='" . $item['class'] . "' />";
						} else {
							$data .= "<input type='submit' name='submit' id='update' value='" . $item['text'] . "' />";
						}
						$data .= "<input type='hidden' name='id' value='" . $id . "' />";
					} else {
						if(isset($item['class']) && !empty($item['class'])) {
							$data .= "<textarea class='" . $item['class'] . "' name='" . $item['title'] . "' id='" . $item['title'] . "'>" . $postInfo[$item['title']] . "</textarea>";
						} else {
							$data .= "<textarea name='" . $item['title'] . "' id='" . $item['title'] . "'>" . $postInfo[$item['title']] . "</textarea>";
						}
					}
				$data .= "</div>";
				if(isset($item['break']) && $item['break']) {
					$data .= "<div class='clear'></div>";
				}
			}
		$data .= "</form>";
		$data .= "<form method='post' action='http://$_SERVER[HTTP_HOST]/file-upload/" . $postInfo['slug'] . "' class='dropzone' id='imageGallery'></form>";
		return $data;
	}
	
	static public function upload($page = "", $directory = "", $title = "")
	{
		$boot = new Boot();
		
		if(is_array($_FILES) && !empty($_FILES)) {
			foreach($_FILES as $key=>$item) {
				if($item['name'] !== null && $item['name'] !== "") {
					//if($boot->uploadFile($boot->resize_image($item, 600, 400), $_SERVER['DOCUMENT_ROOT'] . "/img/shop/products/gallery/" . $boot->slugify($title) . "/")) {
					if($boot->uploadFile($item, $_SERVER['DOCUMENT_ROOT'] . "/img/shop/products/gallery/" . $boot->slugify($title) . "/")) {
						return true;
					} else {
						return false;
					}
				} 
			}
		}
		
		return true;
	}
	
	static public function doCreate($page = "", $id = 0, $modifier = "")
	{
		$boot = new Boot();
		
		$fields = array();
		$fields['id'] = $id;		
		//var_dump($page, $id, $modifier, $fields);
		//$fastData = $boot->array_first_value(connection::getData(array('selectType'=>'*','tableName'=>$modifier,'identifier'=>"WHERE id='$id'")));
		
		$query = "INSERT INTO $modifier ";
		$values = "";
		
		foreach($_POST as $key=>$item) {
			if($key == "submit") {
				continue;
			}
			$fields[$key] = htmlentities(mysqli_real_escape_string(connection::$con,$item));
		}
		
		if(isset($fields['category'])) {
			$fields['category'] = strtolower($fields['category']);
		}
		
		//var_dump($fields); die();
		
		if(is_array($_FILES) && !empty($_FILES)) {
			foreach($_FILES as $key=>$item) {
				if($item['name'] !== null && $item['name'] !== "") {
					$size = explode(",",$fields['size']);
					$coverDetails = $boot->uploadFile($boot->resize_image($item, $size[0], $size[1]), $_SERVER['DOCUMENT_ROOT'] . "/img/shop/$modifier/" . $boot->slugify($fields['title']) . ".png");
					if($page == "rusticharmonycandles") {
						if($modifier == "products") {
							$boot->uploadFile($boot->resize_image($item, 750, 325), $_SERVER['DOCUMENT_ROOT'] . "/img/shop/$modifier/full/" . $boot->slugify($fields['title']) . ".png");
						}
					}
					if($coverDetails){
						$fields["cover"] = $boot->slugify($fields['title']) . ".png";
					}
				}
			}
		}
		
		if(isset($fields['size'])) {
			unset($fields['size']);
		}
		
		$values .= "(";
		$query .= "(";
		
		$fields['slug'] = $boot->slugify($fields['title']);
		$fields['edit'] = NULL;
		$fields['date'] = "" . date("Y-m-d H:i:s") . "";
		$fields['active'] = 1;
		
		switch($page)
		{
			default: break;
			case "blog":
				if(isset($fields['cover']) && !empty($fields['cover'])) {
					if($fields['coverStyle'] == 'square') {
						$fields['coveractive'] = "2";
					} elseif($fields['coverStyle'] == 'round') {
						$fields['coveractive'] = "1";
					}
					unset($fields['coverStyle']);
				}
				$fields['views'] = 0;
				break;
			case "websites":
				break;
		}
		
		//var_dump($fields); die();
		
		foreach($fields as $fieldKey=>$field) {
			if($field !== end($fields)) {
				$query .= "$fieldKey,";
				if($fieldKey == 'edit') {
					$values .= ($field==NULL) ? "NULL," : "'$field',";
				} else {
					$values .= "'$field',";
				}
			} else {
				$query .= "$fieldKey";
				if($fieldKey == 'edit') {
					$values .= ($field==NULL) ? "NULL" : "'$field'";
				} else {
					$values .= "'$field'";
				}
			}
		}
		
		$query .= ")";
		$values .= ")";
		
		$query .= " VALUES " . $values;
		
		//var_dump($query); die();
		
		if(connection::updateData(array("override"=>array("query"=>$query)))) {
			if($modifier == "products") {
				$topCat = $fields['category'];
				$q = array('selectType'=>'*','tableName'=>'categories','identifier'=>"WHERE slug='$topCat'");
				if(connection::getData($q)) {
					$topCatData = $boot->array_first_value(connection::getData($q));
					$catItems = $topCatData['items'];
					if(!strpos($catItems, $id)) {
						$catItems .= $id . ",";
						if(!connection::updateData(array("override"=>array("query"=>"UPDATE categories SET items='$catItems' WHERE slug='$topCat'")))) {
							die('<h1>Error</h1>');
						}
					}
				}
			}
			die("<script>window.location = 'http://$_SERVER[HTTP_HOST]/admin?created=true'</script>");
		}
	}
		
	static public function doUpdate($page = "", $id = 0, $modifier = "")
	{
		$boot = new Boot();
		
		$fields = array();
		
		$fastData = $boot->array_first_value(connection::getData(array('selectType'=>'*','tableName'=>$modifier,'identifier'=>"WHERE id='$id'")));
		//var_dump($fastData); die();
		
		$query = "UPDATE $modifier SET ";
		//var_dump($fields);
		foreach($_POST as $key=>$item) {
			if($key == "submit") {
				continue;
			}
			$fields[$key] = htmlentities(mysqli_real_escape_string(connection::$con,$item));
		}
		
		//var_dump($fields);
		if(is_array($_FILES) && !empty($_FILES)) {
			foreach($_FILES as $key=>$item) {
				if($item['name'] !== null && $item['name'] !== "") {
					$size = explode(",",$fields['size']);
					$coverDetails = $boot->uploadFile($boot->resize_image($item, $size[0], $size[1]), $_SERVER['DOCUMENT_ROOT'] . "/img/shop/$modifier/" . $boot->slugify($fields['title']) . ".png");
					if($page == "rusticharmonycandles") {
						if($modifier == "products") {
							$boot->uploadFile($boot->resize_image($item, 750, 325), $_SERVER['DOCUMENT_ROOT'] . "/img/shop/$modifier/full/" . $boot->slugify($fields['title']) . ".png");
						}
					}
					if($coverDetails){
						$fields["cover"] = $boot->slugify($fields['title']) . ".png";
					}
				}
			}
		}
		
		if(isset($fields['size'])) {
			unset($fields['size']);
		}
		//var_dump($fields);
		$fields['slug'] = $boot->slugify($fields['title']);
		$fields['edit'] = date("Y-m-d H:i:s");
		
		switch($page)
		{
			default: break;
			case "blog":
				if(isset($fields['cover']) && !empty($fields['cover'])) {
					if($fields['coverStyle'] == 'square') {
						$fields['coveractive'] = "2";
					} elseif($fields['coverStyle'] == 'round') {
						$fields['coveractive'] = "1";
					}
				}
				unset($fields['coverStyle']);
				break;
			case "websites":
				break;
		}
		
		//var_dump($fields);
		foreach($fields as $fieldKey=>$field) {
			if($field !== end($fields)) {
				$query .= "$fieldKey='$field',";
			} else {
				$query .= "$fieldKey='$field'";
			}
		}
		
		//var_dump($fields);
		$query .= " WHERE id='$id'";
		
		//var_dump($query); die();
		
		if(connection::updateData(array("override"=>array("query"=>$query)))) {
			if($modifier == "products") {
				$topCat = $fields['category'];
				$q = array('selectType'=>'*','tableName'=>'categories','identifier'=>"WHERE slug='$topCat'");
				if(connection::getData($q)) {
					$topCatData = $boot->array_first_value(connection::getData($q));
					$catItems = $topCatData['items'];
					//var_dump($catItems, strpos($catItems, $id)); die();
					if(!isset($catItems) || !strpos($catItems, $id)) {
						$catItems .= $id . ",";
						if(!connection::updateData(array("override"=>array("query"=>"UPDATE categories SET items='$catItems' WHERE slug='$topCat'")))) {
							die('<h1>Error</h1>');
						}
					}
				}
			}
			die("<script>window.location = 'http://$_SERVER[HTTP_HOST]/admin?created=true'</script>");
		}
	}
	
	
	/*
	
		Displays items from requested table $dataType in an easy-to-design table div format.
		
	*/
	
	static public function displayItems()
	{
		$data = "";
		$dataTypes = func_get_args();
		
		foreach($dataTypes as $dataType) {
		
			$data .= "<div id='" . $dataType . "Listing'>";
				
				$data .= "<div id='optionHeader'>";
					$data .= "<span class='idItem' id='idList'>ID</span>";
					$data .= "<span class='titleItem' id='titleList'>Title</span>";
					$data .= "<span class='optionItem'>Options</span>";
				$data .= "</div>";
				
				$options = array(
					"selectType" => "*",
					"tableName" => "$dataType",
					"identifier" => "ORDER BY id DESC"
				);
				//var_dump($dataType);
				$posts = connection::getData($options);
				//var_dump($posts); die();
				$tempPosts = array_values($posts);
				
				$link = "";
				
				switch(self::$pageView)
				{
					default: break;
					case "blog":
						$link .= "/view/posts/";
						break;
					case "websites":
						$link = null;
						break;
					case "magicflower":
						$link = null;
						break;
					case "rusticharmonycandles":
						$link .= "/view/shop/$dataType";
						break;
				}
				
				
				$countID = 0;
				
				foreach($posts as $post) {
					if($post == $tempPosts[0]) {
						$data .= "<div class='first post' id='" . $post['slug'] . "'>";
					} elseif($post == end($posts)) {
						if($countID % 2 !== 0) {
							$data .= "<div class='last post even ' id='" . $post['slug'] . "'>";
						} else {
							$data .= "<div class='last post' id='" . $post['slug'] . "'>";
						}
					} else {
						if($countID % 2 !== 0) {
							$data .= "<div class='post even ' id='" . $post['slug'] . "'>";
						} else {
							$data .= "<div class='post' id='" . $post['slug'] . "'>";
						}
					}
						$data .= "<span id='postID'>" . $post['id'] . "</span>";
						$data .= "<h2><a href='/admin/edit/$dataType/" . $post['id'] . "'>" . $post['title'] . "</a></h2>";
						$data .= "<div class='item-options'>";
							if($dataType == "posts") {
								$data .= "<span class='view'>";
									$data .= "<a target='_blank' title='" . $post['title'] . "'	href='http://$_SERVER[HTTP_HOST]/view/$dataType/" . $post['slug'] . "'>View</a>";
								$data .= "</span>";
							}
							if($link !== null) {
								$data .= "<span class='view'>";
									$data .= "<a target='_blank' href='$link/" . $post['slug'] . "'>View</a>";
								$data .= "</span>";
							}
							$data .= "<span class='edit'>";
								$data .= "<a href='/admin/edit/$dataType/" . $post['id'] . "'>Edit</a>";
							$data .= "</span>";
							$data .= "<span class='delete'>";
								$data .= "<a href='/admin/delete/$dataType/" . $post['id'] . "'>Delete</a>";
							$data .= "</span>";
							if($post['active'] == 1) {
								$data .= "<span class='disable'>";
									$data .= "<a href='/admin/disable/$dataType/" . $post['id'] . "'>Enabled</a>";
								$data .= "</span>";
							} else {
								$data .= "<span class='enable'>";
									$data .= "<a href='/admin/enable/$dataType/" . $post['id'] . "'>Disabled</a>";
								$data .= "</span>";
							}
						$data .= "</div>";
					$data .= "</div>";
					$countID++;
				}
				
			$data .= "</div>";
			
		}
		return $data;
	}
	
	static public function deleteInput($page = "", $id = 0, $modifier = "") 
	{
		if(connection::updateData(array("override"=>array("query"=>"DELETE FROM $modifier WHERE id='$id'")))) {
			die("<script>window.location = 'http://$_SERVER[HTTP_HOST]/admin?deleted=true';</script>");
		}
	}
	
	static public function disable($page = "", $id = 0, $modifier = "", $target = null)
	{
		$options = array(
			"selectType" => "*",
			"tableName" => "$modifier",
			"columnName"=> "active",
			"updatedInfo"=> 0,
			"rowID" => $id
		);
		
		if($target == null) {
			if(connection::updateData($options)) {
				return true;
			} else {
				return false;
			}
		} else {
			$query = "UPDATE posts SET $target=0 WHERE id='$id'";
			if(connection::updateData(array("override"=>array("query"=>$query)))) {
				return true;
			} else {
				return false;
			}
		}
	}
	
	static public function enable($page = "", $id = 0, $modifier = "", $target = null)
	{
		$options = array(
			"selectType" => "*",
			"tableName" => "$modifier",
			"columnName"=> "active",
			"updatedInfo"=> 1,
			"rowID" => $id
		);
		
		if($target == null) {
			if(connection::updateData($options)) {
				return true;
			} else {
				return false;
			}
		} else {
			$query = "UPDATE posts SET $target=1 WHERE id='$id'";
			if(connection::updateData(array("override"=>array("query"=>$query)))) {
				return true;
			} else {
				return false;
			}
		}
	}
	
	static public function adminTools($page = "")
	{
		$data = "";
		if($page == "websites") {
			if(debug_backtrace()[1]['function'] !== null && debug_backtrace()[1]['function'] = "administration") {
				$data .= "<div id='panels'>";
					$data .= "<script type='text/javascript'>$(function(){ $('.createItem').attr('href','/admin/create/slides');  });</script>";
					$data .= "<ul class='panelItems'>";
						$data .= "<li class='panelItem active sliderListing'><a href='#'>Slider Items</a></li>";
						$data .= "<li class='panelItem portfolioListing'><a href='#'>Portfolio Items</a></li>";
					$data .= "</ul>";
				$data .= "</div>";
			}
		}
		if($page == "rusticharmonycandles") {
			if(debug_backtrace()[1]['function'] !== null && debug_backtrace()[1]['function'] = "administration") {
				$data .= "<div id='panels'>";
					$data .= "<script type='text/javascript'>$(function(){ $('.createItem').attr('href','/admin/create/categories');  });</script>";
					$data .= "<ul class='panelItems'>";
						$data .= "<li class='panelItem active categoriesListing'><a href='#'>Category Items</a></li>";
						$data .= "<li class='panelItem productsListing'><a href='#'>Product Items</a></li>";
					$data .= "</ul>";
				$data .= "</div>";
			}
		}
		$data .= "<div id='adminControls'>";
			$data .= "<span><a class='createItem' href='/admin/create/posts' title='Create New Item'>New Item</a> | </span>";
			$data .= "<span><a href='/admin/' title='Admin Panel'>Admin Home</a></span>";
		$data .= "</div>";
		
		return $data;
	}
	
}

?>