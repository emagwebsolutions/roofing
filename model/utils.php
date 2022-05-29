<?php
	require_once 'class.DB.php';
	require_once 'class.Emails.php';
	require_once 'class.Validation.php';

	ini_set('memory_limit','10000M');


	function history(
		$user_id,
		$link='#',
		$activity='Logged in'
		){
		
			$inst = DB::query("INSERT INTO history(	
				activity,	
				date,
				link,	
				user_id
			) VALUES( ?, NOW(),?,?)",array(
				$activity,$link,$user_id
			));

	}


	function insertPlaceholders( $arr, $max_number ) {
		$genPlaceholders = array_fill(0,$max_number,'?');
	
		$commaSeperatePlaceholders = '('.implode(',', $genPlaceholders).')';
		
		$count = count($arr) / $max_number;
		
		$newArr = [];
		for($i = 0; $i < $count; $i++) {
			$newArr[] = $commaSeperatePlaceholders;
		}
		
		return implode(',', $newArr);
	}


	function output( $message ){
		?><span style='font-size:0;'>errors</span><?php 
		echo $message; 
		exit;
	}