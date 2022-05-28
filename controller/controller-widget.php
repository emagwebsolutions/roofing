<?php
class Widget{

	public function getusersonline() {
		DB::query("UPDATE users SET date = now() WHERE user_id = ?",array($_SESSION['edfghl']));

		$qry = DB::query("SELECT * FROM users");

		echo json_encode($qry);
	}

	public function gethistory(){
		$user_id = $_SESSION['edfghl'];

		$qry = DB::query("SELECT h.*, u.firstname,u.lastname FROM history as h JOIN users as u ON u.user_id = h.user_id WHERE h.user_id =?", array($user_id));

		echo json_encode($qry);
	}


	public function menu(){
		$qry = DB::query("SELECT * FROM user_menu WHERE user_id =?",array($_SESSION['edfghl']));
		echo json_encode($qry);
	}


	
}