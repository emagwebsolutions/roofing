<?php
class user{

	public function get_users(){
		$qry = DB::query("SELECT * FROM users");
		echo json_encode($qry);
	}

	public function get_user_menu(){
		$qry = DB::query("SELECT * FROM user_menu");
		echo json_encode($qry);
	}

	public function get_users_details(){
		$qry = DB::query("SELECT * FROM users_details");
		echo json_encode($qry);
	}

	public function get_note(){
		$qry = DB::query("SELECT * FROM note");
		echo json_encode($qry);
	}
	

	}	
	