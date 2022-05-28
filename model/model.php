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


