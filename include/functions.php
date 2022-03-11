<?php

	function pre($var){
		echo '<pre>'.print_r($var,true).'</pre>';
	}


	function get_template_coffing($file , $args, $return = false ){

		ob_start();
		extract($args);
		include($file);
		$html = ob_get_contents();
		ob_clean();

		if ($return) 
			return $html;
		else
			echo $html;

	}

?>