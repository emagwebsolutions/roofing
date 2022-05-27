<?php
	require_once 'class.DB.php';
	require_once 'class.emails.php';
	require_once 'class.template.php';
	require_once 'class.validation.php';

	ini_set('memory_limit','10000M');

	function remove_spaces($name){
		return preg_replace("/[\s]/", "", $name);
	}

	//history($user_id,$user_mang,$type='',$link='#',$activity='Logged in')
	function history(
		$user_id,
		$user_mang,
		$type='',
		$link='#',
		$activity='Logged in'
		){
		
			$inst = DB::query("INSERT INTO history(	
				activity,	
				date,
				link,	
				type,
				user_id,
				user_mang	
			) VALUES( ?, NOW(),?,?,?,?)",array(
				$activity,$link,$type,$user_id,$user_mang
			));

	}

	function generateUsers(){
		$qry = DB::query('SELECT * FROM users_details');
		$path = dirname(__DIR__).'/assets/logs/users.txt';
		file_put_contents($path,json_encode($qry));
	}

	function textboxcleaner($data){
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}


	function group_array($arr = array()){
		if(!empty($arr)){
		$group = array();
		foreach ( $arr as $value ) {
			$group[$value['invoice_no']] = $value;
		}
		return $group;
	}
	}
	function group_arrays($arr = array(), $val){
		if(!empty($arr)){
		$group = array();
		foreach ( $arr as $value ) {
			$group[$value[$val]] = $value;
		}
		return $group;
	}
	}

	function flat($arr){
		if(is_array($arr)){
			$ar = array();
			array_walk_recursive($arr, function($v) use(&$ar){
				return $ar[] = $v;
			});
			return $ar;
		}
	}

	function checkFileExists( $page ){
		$file = dirname(__DIR__);
		return (file_exists($file.'/view/pages/'.$page.'.html'))? true : false;
	}
	