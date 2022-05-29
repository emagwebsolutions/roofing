<?php
class User{

	public function add_user(){
		extract($_POST);

		extract(json_decode($users, TRUE));
		$menu = json_decode($menu, TRUE);

		validation::empty_validation(
			array(
				'First Name' => $firstname, 
				'Last Name' => $lastname,  
				'Phone'  => $phone, 
				'Email' => $email,  
				'Residence' => $residence,  
				'Hire Date'  => $hire_date, 
				'Birthdate'  => $birthdate, 
				'Username'  => $username, 
				'Re-Password' => $repassword,  
				'Password' => $password
			)
		);

		validation::string_validation(
			array(
				'First Name' => $firstname, 
				'Last Name' => $lastname,  
				'Residence' => $residence,  
				'Username'  => $username, 
				'Re-Password' => $repassword,  
				'Password' => $password
			)
		);

		validation::email_validation($email); 

		validation::password_validation($password); 

		validation::date_validation($hire_date, 'Hire Date field required!');

		validation::date_validation($birthdate, 'Birthdate field required!');

		validation::password_compare($password,$repassword);

		validation::phone_validation(array('Phone'=>$phone));

		//Check if username already exists
		$userExists = DB::query("SELECT username FROM users WHERE username = ?", array($username));
		if($userExists) {
			output('Username is already in use!');
		}

		//Check if email already exists
		$userExists = DB::query("SELECT email FROM users WHERE email = ?", array($email));
		if($userExists) {
			output('Email is already in use!');
		}

		//Check if phone already exists
		$userExists = DB::query("SELECT phone FROM users WHERE phone = ?", array($phone));
		if($userExists) {
			output('Phone is already in use!');
		}
		


		DB::query("INSERT INTO users(
			user_id,
			firstname,
			lastname,
			phone,
			residence,
			email,
			hire_date,
			birthdate,
			username,
			password,
			date
		) VALUES( ?,?,?,?,?,?,?,?,?,?, curdate())", array(
			$user_id,
			$firstname,
			$lastname,
			$phone,
			$residence,
			$email,
			$hire_date,
			$birthdate,
			$username,
			password_hash($password, PASSWORD_BCRYPT)
		));


		$placeholder = insertPlaceholders( $menu, 4 );

		DB::query("INSERT INTO user_menu(
				menu_name,
				menu_parent,
				menu_id,	
				user_id
		) VALUES ".$placeholder." ", $menu);

		echo 'New user added successfully!';
	
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
	