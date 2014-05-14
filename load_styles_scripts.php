<?php 

	$styles;

	$scripts;

	function init(){
		general_styles();
		general_scripts();
	}


	function general_styles(){
		global $styles;

		if(!$styles)
			general_styles();

		$styles = array(

			);
	}

	function register_styles($new){
		global $styles;

		if(is_array($new)){

			array_merge($styles,$new);

		}else if (is_string($new)){

			array_push($styles, $new);
		}

	}

	function add_styles(){
		global $styles;

		foreach ($styles as $value) {
			build_style($value);
		}

	}

	function build_style($path){
		echo '<link rel="stylesheet" type="text/css" href="$path">' ;
	}	


	function general_scripts(){
		global $scripts;

		if(!$scripts)
			general_scripts();

		$scripts = array(

			);
	}

	function register_scripts($new, $order = null){
		global $scripts;

		if(is_array($new)){

			if(!$order || !isset($scripts[$order])){

				array_merge($scripts,$new);
				
			} else {


				$new_scripts = array();

				foreach ($scripts as $key => $script) {
					if($order != $key){
						array_push($new_scripts, $script);
						
					}else{

						foreach ($new as $new_script) {

							array_push($new_scripts, $new_script);

						}

						array_push($new_scripts, $script);
					}
				}

				$scripts = $new_scripts;

			}



		}else if (is_string($new)){

			if(!$order){

				array_push($scripts, $new);
				
			} else {

				$new_scripts = array();

				foreach ($scripts as $key => $script) {

					if($order != $key){

						array_push($new_scripts, $script);
						
					}else{

						array_push($new_scripts, $new);
						array_push($new_scripts, $script);
					}
				}

				$scripts = $new_scripts;
				
			}

		}

	}

	function add_scripts(){
		global $scripts;

		foreach ($scripts as $value) {
			build_script($value);
		}

	}

	function build_script($path){
		echo '<script type="text/javascript" src="$path"></script>' ;
	}


 ?>


