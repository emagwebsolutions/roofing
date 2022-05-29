<?php
class User{

	public function add_user(){
		extract($_POST);

		extract(json_decode($users, TRUE));
		$menu = json_decode($menu, TRUE);

		echo $firstname;
		
	}

	public function get_users(){
		$qry = DB::query("SELECT * FROM users");
		echo json_encode($qry);
	}

	public function get_user_menu(){
		$qry = DB::query("SELECT * FROM user_menu");
		echo json_encode($qry);
	}


	public function get_note(){
		$qry = DB::query("SELECT * FROM note");
		echo json_encode($qry);
	}
	

	}	
	