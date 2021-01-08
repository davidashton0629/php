<?php
/*

	Generates a <div> set of breadcrumbs, pass array('qLink'=>false) to remove <span>Quick Links</span>

*/

function breadcrumbs($options = array())
{
	$o = array_merge(array(
		'qLink'=>true
	), $options);
	
	extract($o);
	
	$crumbs = explode("/",$_SERVER["REQUEST_URI"]);
	$link = $data = "";
	
	if($qLink) {
		$data .= "<span id='identifier'>Quick Links</span> - ";
	}
	
	
	$total = count($crumbs); 
	if(end($crumbs) == "" || end($crumbs) == "/") {
		array_pop($crumbs);
	}
	
	foreach($crumbs as $crumb){
		$item = strtolower(str_replace(array(".php","_","/"),array(""," ",""),$crumb));
		if($item !== '' && $item !== '/') {
			if($crumb !== $crumbs[count($crumbs) -1]) {
				$link .= $item . '/';
				if($item !== "view" && $item !== 'category') {
					$data .= "<a href='/$link'>$item</a> / ";
				}
			} else {
				$link .= $item;
				if($item !== "view" && $item !== 'category') {
					$data .= "<a href='/$link'>$item</a>";
				}
			}
		} else {
			
		}
	}
	
	return $data;
}

echo breadcrumbs();

?>
