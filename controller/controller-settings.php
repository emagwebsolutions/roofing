<?php
class settings{

	public function menu(){
		$qry = DB::query("SELECT * FROM user_menu WHERE user_id =?",array($_SESSION['edfghl']));
		echo json_encode($qry);
	}

















































	public function update_cover(){
		$name = $_FILES['cover']['name'];
		$type = $_FILES['cover']['type'];
		$tmp = $_FILES['cover']['tmp_name'];
		$size = $_FILES['cover']['size'];

		validation::file_type_validation($type);
		validation::file_size_validation($size);

		$cover = template::moveuploadedfile($tmp, $type);
		template::unlink_settings_file('cover_image');

		DB::query('UPDATE settings SET cover_image = ?', array($cover));
	}


	public function update_logo(){

		$name = $_FILES['logo']['name'];
		$type = $_FILES['logo']['type'];
		$tmp = $_FILES['logo']['tmp_name'];
		$size = $_FILES['logo']['size'];

		validation::file_type_validation($type);
		validation::file_size_validation($size);

		$logo = template::moveuploadedfile($tmp, $type);
		template::unlink_settings_file('comp_logo');

		DB::query('UPDATE settings SET comp_logo = ?', array($logo));	
		echo 'Settings Updated!';		
}

	


public function update_general_settings(){
extract($_POST);

	validation::empty_validation(
	array(
	'Company Name'=> $comp_name, 
	'Company Address'=> $comp_addr, 
	'Company Phone'=> $comp_phone, 
	'Company Email'=> $comp_email, 
	'Backup Email'=> $backup_email,
	'Currency'=> $currency,
	'Duration'=> $duration
	)
	);


	validation::string_validation(
	array(
		'Company Name'=> $comp_name, 
		'Company Address'=> $comp_addr,
		'Income Account' => $income_acc,
		'Expense Account' => $expense_acc
	)
	);




	if(isset($income_acc)){
		validation::string_validation(
			array(
				'Income Account' => $income_acc
			)
		);
	}
	else{
		$income_acc = '';
	}


	if(isset($expense_acc)){
		validation::string_validation(
			array(
				'Expense Account' => $expense_acc
			)
		);
	}
	else{
		$expense_acc = '';
	}





	validation::phone_validation(
	array(
	'Company Phone'=>$comp_phone
	)
	);
	validation::email_validation($comp_email); 
	validation::email_validation($backup_email);
	
	if(!empty($comp_website)){
		validation::website_validation($comp_website); 
	}

	if(!empty($comp_bank)){
		validation::string_validation(
			array(
				'Company Bank'=> $comp_bank
			)
		);
	}

	if(!empty($bank_acc)){
		validation::string_validation(
			array(
				'Bank Account'=> $bank_acc
			)
		);
	}

	if(!empty($acc_name)){
		validation::string_validation(
			array(
				'Account Name'=> $acc_name
			)
		);
	}

	DB::query("UPDATE accounts SET account_name = ? WHERE  ac_id ='1'", array($income_acc));

	DB::query("UPDATE accounts SET account_name = ? WHERE  ac_id ='2'", array($expense_acc));

	DB::query('UPDATE settings SET
	comp_name = ?,
	comp_addr = ?,
	comp_phone = ?,
	comp_email = ?,
	backup_email = ?,
	comp_website = ?,
	comp_bank = ?,
	bank_acc = ?,
	acc_name = ?,
	currency = ?,
	duration = ?
	  ', array( 
	$comp_name,
	$comp_addr,
	$comp_phone,
	$comp_email,
	$backup_email,
	$comp_website,
	$comp_bank,
	$bank_acc,
	$acc_name,
	$currency,
	$duration
	  ));
	echo 'Settings Updated!';	
}

	
public function update_terms(){

	$comp_terms = $_POST['comp_terms'];

	validation::empty_validation(
		array(
		'Terms & Conditions'=> $comp_terms
		)
		);

	DB::query('UPDATE settings SET comp_terms = ?', array($comp_terms));
	echo 'Settings Updated!';	
}

/*==========================================
Begin Social Media settings
==========================================*/
public function update_social_settings(){
	extract($_POST);

	if(!empty($email_url)){
		validation::website_validation($email_url); 
	}

	if(!empty($facebook)){
		validation::website_validation($facebook); 
	}

	if(!empty($instagram)){
		validation::website_validation($instagram); 
	}

	if(!empty($twitter)){
		validation::website_validation($twitter); 
	}

	DB::query('UPDATE settings SET email_url = ?, facebook = ?, instagram = ?, twitter = ?', array( $email_url, $facebook, $instagram, $twitter));
	echo 'Settings Updated!';		
}

/*==========================================
End Social Media settings
==========================================*/


/*==========================================
Begin SMS Settings
==========================================*/
public function update_sms_settings(){
	$sms_cc  = $_POST['sms_cc'];
	$sms_sender_id = $_POST['sms_sender_id'];
	$sms_api_key = $_POST['sms_api_key'];
	$sms_api_url = $_POST['sms_api_url'];
	$activate_receipt_sms = $_POST['activate_receipt_sms'];

	validation::empty_validation(
		array(
			'SMS Sender ID'=> $sms_sender_id, 
			'SMS API Key'=> $sms_api_key,
			'SMS API url'=> $sms_api_url
		)
	);

	
	validation::string_validation(
		array(
			'SMS Sender ID'=> $sms_sender_id,
			'SMS API Key'=> $sms_api_key
		)
	);

	validation::website_validation($sms_api_url); 

	if(!empty($sms_cc)){
		validation::phone_validation(array('SMS CC'=>$sms_cc));
	}

	DB::query('UPDATE settings SET 
	sms_cc = ?,
	sms_sender_id = ?,
	sms_api_key = ?,
	sms_api_url = ?,
	activate_receipt_sms = ?
	 ', array( 
	$sms_cc,
	$sms_sender_id,
	$sms_api_key,
	$sms_api_url,
	$activate_receipt_sms
	 ));
	echo 'Settings Updated!';	
}

/*==========================================
End SMS Settings
==========================================*/



/*==========================================
Begin Database Backup
==========================================*/

public function database_backup(){
	require('model/constants.php');
	
	$fname = 'backup-'.date('d-m-Y-H-i-s').".sql";
	$toDay = 'assets/upload/'.$fname;

	$domain = $_GET['domain'];
	$dbhost = host;
	$dbuser = username;
	$dbpass = password;
	$dbname = dbname;

	//Settings
	$setting = json_decode(setting::settings_json_file(), true);

	$email = trim($setting[0]['backup_email']);
	$subject = trim($setting[0]['comp_name']).' Database Backup';
	$message = "This a manual backup of ".trim($setting[0]['comp_name'])." database";

	if($domain == 'localhost'){
		exec("C://xampp/mysql/bin/mysqldump --opt --host=$dbhost --user=$dbuser --password=$dbpass $dbname > ".$toDay);
		echo 'Backup Completed';
	}
	else{
		exec("mysqldump --user=$dbuser --password='$dbpass' --host=$dbhost $dbname > ".$toDay);
		emails::backupEmail($subject, $email, $message,$toDay);
		echo 'Backup Completed';
    }

}
	
/*==========================================
End Database Backup
==========================================*/





/*==========================================
Begin Database Restore
==========================================*/
	public function restore_backup(){
			ini_set('max_execution_time', 0); // 0 = Unlimited
			if(isset($_FILES['rFile'])){
			if($_FILES['rFile']['name'] != ''){

				include("model/constants.php");
				$domain = $_POST['domain'];
				$name = $_FILES['rFile']['name'];	
				$tmp_name = $_FILES['rFile']['tmp_name'];
				$exp = explode('.', $name);
				$ext = end($exp);

				if($ext == 'sql'){

					$path = dirname(__DIR__)."/assets/upload/restore-".rand().".sql";
					move_uploaded_file($tmp_name, $path);
					$dbhost = host;
					$dbuser = username;
					$dbpass = password;
					$dbname = dbname;
					$mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
					$mysqli->query('SET foreign_key_checks = 0');
					if ($result = $mysqli->query("SHOW TABLES"))
					{
						while($row = $result->fetch_array(MYSQLI_NUM))
						{
							$mysqli->query('DROP TABLE IF EXISTS '.$row[0]);
						}
					}
					$mysqli->query('SET foreign_key_checks = 1');
					$mysqli->close();
	
					if($domain == 'localhost'){
						$cmd = "C://xampp/mysql/bin/mysql -h {$dbhost} -u {$dbuser} -p{$dbpass} {$dbname} < $path";
					}
					else{
						$cmd = "mysql -h {$dbhost} -u {$dbuser} -p{$dbpass} {$dbname} < $path";
					}

				
			    exec($cmd);
				unlink($path);
				echo 'Backup Restored!';
				}
				else{
					?>
					<span style='font-size: 0px; '>errors</span>
					Unsupported File!
					<?php
					exit;
				}
			}
			}
			else{
			?>
			<span style='font-size: 0px; '>errors</span>
			Upload Backup File
			<?php
			exit;
			}
	}
	/*==========================================
	End Database Restore
	==========================================*/


	public function all_settings(){
		echo setting::settings_json_file();
	}


		
	public function send_sms(){
		$contacts = $_POST['contacts'];
		$message = $_POST['message'];

		validation::empty_validation(
			array(
			'Contacts'=>$contacts, 
			'Message'=>$message
			)
		);

		$setting = json_decode(setting::settings_json_file(),true);

		//defining the parameters
		$key = $setting[0]['sms_api_key'];  // Remember to put your own API Key here
		$to = $contacts; //You only need to separate the contacts with commas
		$msg = $message;
		$sender_id = $setting[0]['sms_sender_id']; //11 Characters maximum
		//encode the message
		$msg = urlencode($msg);
		//prepare your url   "https://apps.mnotify.net/smsapi?"
		$url =  $setting[0]['sms_api_url']."?key=$key"."&to=$to"."&msg=$msg"."&sender_id=$sender_id";	
		$response  = @file_get_contents($url);
		$exp = explode(":", $response);
		if(isset($exp[1])){
		  $result = $exp[1];
		}
		else{
		  $result = $response;					
		}

		echo $result;
	
	}


}