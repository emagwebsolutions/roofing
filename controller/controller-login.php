<?php
	class login{
		public function signin(){

				extract(json_decode($_POST['data'],TRUE));

				validation::empty_validation(
					array(
					'User Name'=>$username, 
					'Password'=>$password
					)
				);

				$qry = DB::get_row("SELECT user_id, password FROM users WHERE username = ?",array($username));
				$hash_pass = $qry['password'];

				if(password_verify($password, $hash_pass)) {
					$_SESSION['edfghl'] = $qry['user_id'];

					//Update inactive users 
					DB::query("UPDATE users SET  date = now() WHERE user_id = ?",array($_SESSION['edfghl']));

					history($_SESSION['edfghl']);
					
					echo $_SESSION['edfghl'];
				}
				else{
					?>
					<span style='font-size:0;'>errors</span>
					<span>Invalid Password/Username!</span>
					<?php 
					exit;
				}
		}
	}