<?php
class widget{


	

	public function getusersonline() {
		DB::query("UPDATE users_details SET date = now() WHERE user_id = ?",array($_SESSION['edfghl']));

		$qry = DB::query("SELECT * FROM users_details");

		echo json_encode($qry);
	}

	public function gethistory(){
		$user_id = $_SESSION['edfghl'];
		$qry = DB::query("SELECT h.*, u.firstname,u.lastname FROM history as h JOIN users_details as u ON u.user_id = h.user_id WHERE h.user_id =? OR h.user_mang = ?", array($user_id,$user_id));
		echo json_encode($qry);
	}


























	
}