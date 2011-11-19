<?php
	function pluralize($number, $string){
		if ($number > 1 || $number == 0){
			return "{$string}s";
		} else {
			return $string;
		}
	}
?>
