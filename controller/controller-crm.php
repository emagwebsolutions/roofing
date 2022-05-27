<?php
class crm{


	public function add_lead(){
		extract($_POST);
		/*----------------------------
		Begin Check if mobile already exist
		----------------------------*/
		if(!empty($mobile)){
		$chk = DB::query("SELECT 
		c.mobile,
		CONCAT(u.firstname,' ',u.lastname) AS fullname
		FROM crm as c JOIN users_details as u ON c.user_id = u.user_id 
		WHERE c.mobile =?", array($mobile));
		if(!empty($chk)){
			foreach($chk as $v){
			template::output(false, 'Mobile already assigned to '.$v['fullname'].'!');
			}
		}
		}
		/*----------------------------
		End Check if mobile already exist
		----------------------------*/

		/*----------------------------
		Begin empty validtion
		----------------------------*/
		validation::empty_validation(
			array(
				'Contact Name'=>$contactname,
				'Lead Name'=>$leadname,
				'Company'=>$company,
				'Industry'=>$industry,
				'Mobile'=>$mobile,
				'Lead Source'=>$lead_source,
				'Lead Status'=>$lead_status,
				'Sales Stage'=>$sales_stage,
				'Region'=>$region,
				'Cityy'=>$city
			)
			);
		/*----------------------------
		End empty validtion
		----------------------------*/

		if($industry == 'Select Industry'){
			template::output(false, 'Select Industry');
		}
		if($lead_source == 'Select Lead Source'){
			template::output(false, 'Select Lead Source');
		}
		if($region == 'Select Region'){
			template::output(false, 'Select Region');
		}
		if($lead_status == 'Select Lead Status'){
			template::output(false, 'Select Lead Status');
		}
		if($sales_stage == 'Select Sales Stage'){
			template::output(false, 'Select Sales Stage');
		}



		/*----------------------------
		Begin string validation
		----------------------------*/
		validation::string_validation(
			array(
				'Contact Name'=>$contactname,
				'Lead Name'=>$leadname,
				'Company'=>$company,
				'Industry'=>$industry,
				'Lead Source'=>$lead_source,
				'Lead Status'=>$lead_status,
				'Sales Stage'=>$sales_stage,
				'Region'=>$region,
				'Cityy'=>$city,
				'Description'=>$description
			)
			);
		/*----------------------------
		End string validation
		----------------------------*/

		/*----------------------------
		Begin mobile validation
		----------------------------*/
		validation::phone_validation(
			array(
			'Mobile'=>$mobile
			)
			);
		/*----------------------------
		End mobile validation
		----------------------------*/

		/*----------------------------
		Begin optional validation
		----------------------------*/
		if(!empty($email)){
			validation::email_validation($email); 
			$chk = DB::query("
			SELECT 
			CONCAT(u.firstname,' ',u.lastname) AS fullname,
			c.email 
			FROM crm as c JOIN users_details as u ON c.user_id = u.user_id
			WHERE c.email =?", array($email));
			if(!empty($chk)){
				foreach($chk as $v){
				template::output(false, 'Email already assigned to '.$v['fullname'].'!');
				}
			}
		}

		if(!empty($url)){
			validation::website_validation($url);
			$chk = DB::query("
			SELECT 
			CONCAT(u.firstname,' ',u.lastname) AS fullname,
			c.url 
			FROM crm as c JOIN users_details as u ON c.user_id = u.user_id
			WHERE c.url =?", array($url));
			if(!empty($chk)){
				foreach($chk as $v){
				template::output(false, 'Website addr already assigned to '.$v['fullname'].'!');
				}
			}
		}
		if(!empty($phone)){
			validation::phone_validation(array('Phone'=>$phone));
			$chk = DB::query("
			SELECT 
			CONCAT(u.firstname,' ',u.lastname) AS fullname,
			c.phone FROM crm as c JOIN users_details as u ON u.user_id = c.user_id
			WHERE c.phone =?", array($phone));
			if(!empty($chk)){
				foreach($chk as $v){
				template::output(false, 'Phone already assigned to '.$v['fullname'].'!');
				}
			}
		}
		if(!empty($skype)){
			validation::website_validation($skype);
		}
		if(!empty($twitter)){
			validation::website_validation($twitter);
		}
		if(!empty($facebook)){
			validation::website_validation($facebook);
		}
		if(!empty($description)){
			$description = textboxcleaner($description);
		}
		/*----------------------------
		End optional validation
		----------------------------*/
		$user_id = $_SESSION['edfghl'];

		DB::query("
		INSERT INTO crm(
			leadname,
			contactname,
			company,
			industry,
			email,
			url,
			phone,
			mobile,
			lead_source,
			lead_status,
			sales_stage,
			skype,
			twitter,
			facebook,
			region,
			city,
			description,
			category,
			date,
			user_id
		)
		VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,'Lead', curdate(), ?)
		", array(
			$leadname,
			$contactname,
			$company,
			$industry,
			$email,
			$url,
			$phone,
			$mobile,
			$lead_source,
			$lead_status,
			$sales_stage,
			$skype,
			$twitter,
			$facebook,
			$region,
			$city,
			$description,
			$user_id

		));


		$crm_id = DB::get_row("SELECT MAX(crm_id) AS crm_id FROM crm WHERE category ='Lead' ");

		//Insert into history table
		$user_mang = users::get_manager($user_id);
		widgets::add_history(
			array(
			'activity'=> 'added lead',
			'reference'=> $leadname,
			'date'=> date('Y-m-d H:i:s'),
			'link'=> '?page=viewlead&crm_id='.$crm_id['crm_id'],
			'type'=>'',
			'user_id'=> $user_id,
			'user_mang'=> $user_mang
			)
		); 

		echo 'Lead added successfully!';
	}


	public function update_lead(){
		extract($_POST);

		/*----------------------------
		Begin Check if mobile already exist
		----------------------------*/
		if(!empty($mobile)){
		$chk = DB::query("SELECT 
		c.mobile,
		CONCAT(u.firstname,' ',u.lastname) AS fullname
		FROM crm as c JOIN users_details as u ON c.user_id = u.user_id 
		WHERE c.mobile =? AND c.crm_id != ?", array($mobile, $crm_id));
		if(!empty($chk)){
			foreach($chk as $v){
			template::output(false, 'Mobile already assigned to '.$v['fullname'].'!');
			}
		}
		}
		/*----------------------------
		End Check if mobile already exist
		----------------------------*/

		/*----------------------------
		Begin empty validtion
		----------------------------*/
		validation::empty_validation(
			array(
				'Contact Name'=>$contactname,
				'Lead Name'=>$leadname,
				'Company'=>$company,
				'Industry'=>$industry,
				'Mobile'=>$mobile,
				'Lead Source'=>$lead_source,
				'Lead Status'=>$lead_status,
				'Sales Stage'=>$sales_stage,
				'Region'=>$region,
				'Cityy'=>$city
			)
			);
		/*----------------------------
		End empty validtion
		----------------------------*/
		
		if($industry == 'Select Industry'){
			template::output(false, 'Select Industry');
		}
		if($lead_source == 'Select Lead Source'){
			template::output(false, 'Select Lead Source');
		}
		if($region == 'Select Region'){
			template::output(false, 'Select Region');
		}
		if($lead_status == 'Select Lead Status'){
			template::output(false, 'Select Lead Status');
		}
		if($sales_stage == 'Select Sales Stage'){
			template::output(false, 'Select Sales Stage');
		}

		/*----------------------------
		Begin string validation
		----------------------------*/
		validation::string_validation(
			array(
				'Contact Name'=>$contactname,
				'Lead Name'=>$leadname,
				'Company'=>$company,
				'Industry'=>$industry,
				'Lead Source'=>$lead_source,
				'Lead Status'=>$lead_status,
				'Sales Stage'=>$sales_stage,
				'Region'=>$region,
				'Cityy'=>$city,
				'Description'=>$description
			)
			);
		/*----------------------------
		End string validation
		----------------------------*/

		/*----------------------------
		Begin mobile validation
		----------------------------*/
		validation::phone_validation(
			array(
			'Mobile'=>$mobile
			)
			);
		/*----------------------------
		End mobile validation
		----------------------------*/

		/*----------------------------
		Begin optional validation
		----------------------------*/
		if(!empty($email)){
			validation::email_validation($email); 
			$chk = DB::query("
			SELECT 
			CONCAT(u.firstname,' ',u.lastname) AS fullname,
			c.email 
			FROM crm as c JOIN users_details as u ON c.user_id = u.user_id
			WHERE c.email =? AND c.crm_id != ?", array($email, $crm_id));
			if(!empty($chk)){
				foreach($chk as $v){
				template::output(false, 'Email already assigned to '.$v['fullname'].'!');
				}
			}
		}

		if(!empty($url)){
			validation::website_validation($url);
			$chk = DB::query("
			SELECT 
			CONCAT(u.firstname,' ',u.lastname) AS fullname,
			c.url 
			FROM crm as c JOIN users_details as u ON c.user_id = u.user_id
			WHERE c.url =? AND c.crm_id != ?", array($url, $crm_id));
			if(!empty($chk)){
				foreach($chk as $v){
				template::output(false, 'Website addr already assigned to '.$v['fullname'].'!');
				}
			}
		}
		if(!empty($phone)){
			validation::phone_validation(array('Phone'=>$phone));
			$chk = DB::query("
			SELECT 
			CONCAT(u.firstname,' ',u.lastname) AS fullname,
			c.phone FROM crm as c JOIN users_details as u ON u.user_id = c.user_id
			WHERE c.phone =? AND c.crm_id !=? ", array($phone, $crm_id));
			if(!empty($chk)){
				foreach($chk as $v){
				template::output(false, 'Phone already assigned to '.$v['fullname'].'!');
				}
			}
		}
		if(!empty($skype)){
			validation::website_validation($skype);
		}
		if(!empty($twitter)){
			validation::website_validation($twitter);
		}
		if(!empty($facebook)){
			validation::website_validation($facebook);
		}
		if(!empty($description)){
			$description = textboxcleaner($description);
		}
		/*----------------------------
		End optional validation
		----------------------------*/
		$user_id = $_SESSION['edfghl'];

		DB::query("
		UPDATE crm SET 
			leadname = ?,
			contactname = ?,
			company = ?,
			industry = ?,
			email = ?,
			url = ?,
			phone = ?,
			mobile = ?,
			lead_source = ?,
			lead_status = ?,
			sales_stage = ?,
			skype = ?,
			twitter = ?,
			facebook = ?,
			region = ?,
			city = ?,
			description = ?,
			date = curdate(),
			user_id = ?
			WHERE crm_id = ?
	
		", array(
			$leadname,
			$contactname,
			$company,
			$industry,
			$email,
			$url,
			$phone,
			$mobile,
			$lead_source,
			$lead_status,
			$sales_stage,
			$skype,
			$twitter,
			$facebook,
			$region,
			$city,
			$description,
			$user_id,
			$crm_id
		));

		//Insert into history table
		$user_mang = users::get_manager($user_id);
		widgets::add_history(
			array(
			'activity'=> 'updated lead',
			'reference'=> $leadname,
			'date'=> date('Y-m-d H:i:s'),
			'link'=> '?page=viewlead&crm_id='.$crm_id,
			'type'=>'',
			'user_id'=> $user_id,
			'user_mang'=> $user_mang
			)
		); 

		echo 'Lead updated successfully!';
	}





	public function add_opp(){
		$user_id = $_SESSION['edfghl'];	
		extract($_POST);

		
		/*----------------------------
		Begin Check if mobile already exist
		----------------------------*/
		if(!empty($mobile)){
			$chk = DB::query("SELECT 
			c.mobile,
			CONCAT(u.firstname,' ',u.lastname) AS fullname
			FROM crm as c JOIN users_details as u ON c.user_id = u.user_id 
			WHERE c.phone =?", array($phone));
			if(!empty($chk)){
				foreach($chk as $v){
				template::output(false, 'Phone already assigned to '.$v['fullname'].'!');
				}
			}
			}
		/*----------------------------
		End Check if mobile already exist
		----------------------------*/
		

		validation::empty_validation(
		array(
		'Contact Name' => $contactname,
		'City' => $city, 
		'Opportunity Name' => $opp_name, 
		'Closing Date' => $closing_date, 
		'Company' => $company, 
		'Stage' => $stage, 
		'Type' => $type, 
		'Probability' => $probability, 
		'Expected Revenue' => $revenue, 
		'Lead Source' => $lead_source, 
		'Phone' => $phone
		)
		);


		if($stage == 'Select Stage'){
			template::output(false, 'Select Stage');
		}

		if($lead_source == 'Select Lead Source'){
			template::output(false, 'Select Lead Source');
		}

		if($type == 'Select Type'){
			template::output(false, 'Select Type');
		}
		
		validation::string_validation(
		array(
			'Contact Name' => $contactname,
			'City' => $city, 
			'Opportunity Name' => $opp_name, 
			'Company' => $company, 
			'Stage' => $stage, 
			'Type' => $type, 
			'Probability' => $probability, 
			'Lead Source' => $lead_source
		)
		);
		
		validation::numbers_validation(
		array(
		'Probability' => $probability,
		'Expected Revenue' => $revenue
		)
		);	


		if(!empty($description)){
			$description = textboxcleaner($description);
		}



		/*----------------------------
		Begin mobile validation
		----------------------------*/
		validation::phone_validation(
			array(
			'Phone'=>$phone
			)
			);
		/*----------------------------
		End mobile validation
		----------------------------*/

		/*----------------------------
		Begin optional validation
		----------------------------*/
		if(!empty($email)){
			validation::email_validation($email); 
			$chk = DB::query("
			SELECT 
			CONCAT(u.firstname,' ',u.lastname) AS fullname,
			c.email 
			FROM crm as c JOIN users_details as u ON c.user_id = u.user_id
			WHERE c.email =?", array($email));
			if(!empty($chk)){
				foreach($chk as $v){
				template::output(false, 'Email already assigned to '.$v['fullname'].'!');
				}
			}
		}
	
	
		if($closing_date == '1970-01-01'){
			template::output(false, 'Closing Date field required!');	
		}
		

		$qry = "
		INSERT  INTO crm( 
			contactname,
			city,
			opp_name,
			closing_date,
			company,
			stage,
			type,
			probability,
			revenue,
			lead_source,
			description,
			email,
			phone,
			category, 
			date, 
			user_id 
			)
			VALUES(?,?,?,?,?, ?, ?, ?, ?, ?, ?, ?, ?,'Opportunity', curdate(), ?)
		";

		DB::query(
			$qry, 
			array(
				$contactname,
				$city,
				$opp_name,
				date('Y-m-d', strtotime($closing_date)),
				$company,
				$stage,
				$type,
				$probability,
				$revenue,
				$lead_source,
				$description,
				$email,
				$phone,
				$user_id
			)
		);
		$crm_id = DB::get_row("SELECT MAX(crm_id) AS crm_id FROM crm WHERE category ='Opportunity' ");


			//Insert into history table
			$user_mang = users::get_manager($user_id);
			widgets::add_history(
				array(
				'activity'=> 'Added Opportunity',
				'reference'=> $opp_name,
				'date'=> date('Y-m-d H:i:s'),
				'link'=> '?page=viewopportunity&crm_id='.$crm_id['crm_id'],
				'type'=>'',
				'user_id'=> $user_id,
				'user_mang'=> $user_mang
				)
			); 
	
			echo 'Opportunity added successfully!';

	
	}










	public function get_crm_owners(){
		$qry = DB::query("
		SELECT u.firstname, u.lastname, u.user_id FROM users_details as u 
		JOIN crm as c ON u.user_id = c.user_id  GROUP BY c.user_id
		");
		echo json_encode($qry);
	}













	public function update_opp(){
		$user_id = $_SESSION['edfghl'];	
		extract($_POST);

		
		/*----------------------------
		Begin Check if mobile already exist
		----------------------------*/
		if(!empty($mobile)){
			$chk = DB::query("SELECT 
			c.mobile,
			CONCAT(u.firstname,' ',u.lastname) AS fullname
			FROM crm as c JOIN users_details as u ON c.user_id = u.user_id 
			WHERE c.phone =? AND u.user_id != ?", array($phone, $user_id));
			if(!empty($chk)){
				foreach($chk as $v){
				template::output(false, 'Phone already assigned to '.$v['fullname'].'!');
				}
			}
			}
		/*----------------------------
		End Check if mobile already exist
		----------------------------*/
		

		validation::empty_validation(
		array(
		'Contact Name' => $contactname,
		'City' => $city, 
		'Opportunity Name' => $opp_name, 
		'Closing Date' => $closing_date, 
		'Company' => $company, 
		'Stage' => $stage, 
		'Type' => $type, 
		'Probability' => $probability, 
		'Expected Revenue' => $revenue, 
		'Lead Source' => $lead_source, 
		'Phone' => $phone
		)
		);

		if($stage == 'Select Stage'){
			template::output(false, 'Select Stage');
		}

		if($lead_source == 'Select Lead Source'){
			template::output(false, 'Select Lead Source');
		}

		if($type == 'Select Type'){
			template::output(false, 'Select Type');
		}
		
		validation::string_validation(
		array(
			'Contact Name' => $contactname,
			'City' => $city, 
			'Opportunity Name' => $opp_name, 
			'Company' => $company, 
			'Stage' => $stage, 
			'Type' => $type, 
			'Probability' => $probability, 
			'Lead Source' => $lead_source
		)
		);
		
		validation::numbers_validation(
		array(
		'Probability' => $probability,
		'Expected Revenue' => $revenue
		)
		);	


		if(!empty($description)){
			$description = textboxcleaner($description);
		}



		/*----------------------------
		Begin mobile validation
		----------------------------*/
		validation::phone_validation(
			array(
			'Phone'=>$phone
			)
			);
		/*----------------------------
		End mobile validation
		----------------------------*/

		/*----------------------------
		Begin optional validation
		----------------------------*/
		if(!empty($email)){
			validation::email_validation($email); 
			$chk = DB::query("
			SELECT 
			CONCAT(u.firstname,' ',u.lastname) AS fullname,
			c.email 
			FROM crm as c JOIN users_details as u ON c.user_id = u.user_id
			WHERE c.email =? AND u.user_id != ?", array($email, $user_id));
			if(!empty($chk)){
				foreach($chk as $v){
				template::output(false, 'Email already assigned to '.$v['fullname'].'!');
				}
			}
		}
	
	
		if($closing_date == '1970-01-01'){
			template::output(false, 'Closing Date field required!');	
		}
		

		$qry = "
		UPDATE crm  SET 
			contactname = ?,
			city = ?,
			opp_name = ?,
			closing_date = ?,
			company = ?,
			stage = ?,
			type = ?,
			probability = ?,
			revenue = ?,
			lead_source = ?,
			description = ?,
			email = ?,
			phone = ?,
			date = curdate()
			WHERE crm_id = ?
		";

		DB::query(
			$qry, 
			array(
				$contactname,
				$city,
				$opp_name,
				date('Y-m-d', strtotime($closing_date)),
				$company,
				$stage,
				$type,
				$probability,
				$revenue,
				$lead_source,
				$description,
				$email,
				$phone,
				$crm_id
			)
		);


			//Insert into history table
			$user_mang = users::get_manager($user_id);
			widgets::add_history(
				array(
				'activity'=> 'Added Opportunity',
				'reference'=> $opp_name,
				'date'=> date('Y-m-d H:i:s'),
				'link'=> '?page=viewopportunity&crm_id='.$crm_id,
				'type'=>'',
				'user_id'=> $user_id,
				'user_mang'=> $user_mang
				)
			); 
	
			echo 'Opportunity updated successfully!';

	
	}

























	public function convert_lead(){

		$user_id = $_SESSION['edfghl'];	
		
		/*==========================================
		BEGIN CUSTOMER
		==========================================*/
		if(isset($_POST['active'])){
			//Get values from form fields 
			$fullname = $_POST['fullname'];
			$email = $_POST['email'];
			$phone = $_POST['phone'];
			$location = $_POST['location'];

			validation::empty_validation(
			array(
			'Fullname' => $fullname,
			'Phone' => $phone,
			'Location' => $location
			)
			);
				
			validation::string_validation(
			array(
			'Fullname' =>  $fullname,
			'Location' => $location
			)
			);

			if(empty($email)){
				$email = '';
			}
			else{
			validation::email_validation($email);
				//Check if email exists 
				$qry = "SELECT fullname, email FROM customers WHERE  email = ? ";
				$rzlt = DB::query($qry, array($email));
				if(!empty($rzlt)){
					foreach($rzlt as $v){
					template::output(false, 'Email assigned to '.$v['fullname']);
					}
				}
			}
		
			//Check if phone exists 
			$qry = "SELECT fullname, phone FROM customers WHERE  phone = ? ";
			$rzlt = DB::query($qry, array($phone));
			if(!empty($rzlt)){
				foreach($rzlt as $v){
					template::output(false, 'Phone number assigned to '.$v['fullname']);
				}
			}
		
			$role = users::current_role($_SESSION['edfghl']);
			if( ($role == 'manager') OR ($role == 'admin') ){
				$user_mang = $_SESSION['edfghl'];
			}
			else{
				$user_mang = users::get_manager($_SESSION['edfghl']);
			}

			DB::query("INSERT INTO  customers(fullname, phone, email, location, date, user_id, user_mang,type) VALUES(?, ?, ?, ?, curdate(), ?, ?,'Customer')", 
			array( $fullname, $phone, $email, $location, $user_id, $user_mang)
			);

			$qry = "SELECT  c.cust_id, c.date, c.fullname, c.phone, c.email, c.location, c.user_id,u.firstname, u.lastname FROM  customers as c JOIN users_details as u ON c.user_id = u.user_id  WHERE c.type = 'Customer'
			ORDER BY c.fullname ASC";	
			$rzlt = DB::query($qry);
			$jsnenc = json_encode($rzlt);
			file_put_contents('assets/json/customers.json', $jsnenc);

		}
		/*==========================================
		END CUSTOMER
		==========================================*/


		/*==========================================
		BEGIN OPPORTUNITY
		==========================================*/
		$category  =  'Opportunity';
		$closing_date   = date('Y-m-d', strtotime($_POST['closing_date']));
		$stage   = trim($_POST['stage']);
		$type  =   trim($_POST['type']);
		$probability  = trim($_POST['probability']);

		$contactname  = trim($_POST['contactname']);
		$city  = trim($_POST['city']);
		$leadname   = trim($_POST['leadname']);
		$company   = trim($_POST['company']);
		$lead_source  =  trim($_POST['lead_source']);
		$crm_id = $_POST['crm_id'];
		$opemail   = trim($_POST['opemail']);
		$opphone   = trim($_POST['opphone']);

		validation::empty_validation(
		array(
			'Stage' => $stage,
			'Type' => $type,
			'Probability' => $probability
		)
		);
		
		validation::string_validation(
		array(
			'Stage' => $stage,
			'Type' => $type
		)
		);
		
		validation::numbers_validation(
		array(
		'Probability' => $probability
		)
		);	
	
	
		if($closing_date == '1970-01-01'){
			template::output(false, 'Closing Date field required!');	
		}
		

		$qry = "
		INSERT  INTO crm( 
			contactname, 
			city, 
			opp_name, 
			closing_date, 
			company, 
			stage, 
			type, 
			probability, 
			lead_source, 
			category, 
			date, 
			user_id,
			mobile,
			email
			)
			VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, curdate(), ?,?,?)
		";

		DB::query(
			$qry, 
			array(
			$contactname, 
			$city, 
			$leadname, 
			$closing_date, 
			$company, 
			$stage, 
			$type, 
			$probability, 
			$lead_source, 
			$category, 
			$user_id,
			$opphone,
			$opemail
			)
		);

		DB::query("UPDATE crm SET category = 'Converted' WHERE crm_id = ?", array($crm_id));
		/*==========================================
		END OPPORTUNITY
		==========================================*/
	
	}
	
	

	public function get_opp_stage(){
		$stage = $_GET['stage'];
		$user_id = $_SESSION['edfghl'];
		$role = users::get_role($user_id);
		if($role == 'user'){
			$slct = DB::query("SELECT * FROM crm 
			WHERE user_id = ? AND stage = ? ORDER BY crm_id DESC", array($user_id, $stage));
			echo json_encode($slct);
		}
		else{
			if(isset($_GET['usid'])){
				$slct = DB::query("SELECT * FROM crm 
				WHERE user_id = ? AND stage = ? ORDER BY crm_id DESC", array($_GET['usid'], $stage));
				echo json_encode($slct);
			}
			else{
				$slct = DB::query("SELECT * FROM crm 
				WHERE stage = ? ORDER BY crm_id DESC", array($stage));
				echo json_encode($slct);
			}
		}


	}


	public function fetch_single_lead(){
		crms::get_single_lead_json();
	}
	

	public function delete_leads(){
		$data = json_decode($_POST['data'], true);
		$crmids = implode(',', $data);
		DB::query("DELETE FROM crm WHERE crm_id IN($crmids)");
	}


	public function send_email(){
		extract($_POST);
		/*----------------------------
		Begin empty validtion
		----------------------------*/
		validation::empty_validation(
			array(
				'Subject'=>$subject,
				'Email'=>$email,
				'Message'=>$message
			)
			);
		/*----------------------------
		End empty validtion
		----------------------------*/

		validation::email_validation($email); 

		emails::sendEmail($subject, $email, $message);

	}

	public function fetch_all_leads(){
		$user_id = $_SESSION['edfghl'];
		$role = users::get_role($user_id);
		if($role == 'user'){
		$qry = "SELECT  * FROM crm WHERE category = 'Lead' AND lead_status != 'Lost Lead' AND user_id = ?
		ORDER BY leadname ASC  
		";
		$res = DB::query($qry, array($user_id));
		echo json_encode($res);		
		}
		else{
		//ADMIN
		if(isset($_GET['usid'])){
			$qry = "SELECT  * FROM crm WHERE category = 'Lead' AND user_id = ?
			ORDER BY leadname ASC  
			";
			$res = DB::query($qry, array($_GET['usid']));
			echo json_encode($res);	
		}
		else{
			$qry = "SELECT  * FROM crm WHERE category = 'Lead' 
			ORDER BY leadname ASC  
			";
			$res = DB::query($qry);
			echo json_encode($res);	
		}

		}
	}






	public function fetch_all_opp(){
		$user_id = $_SESSION['edfghl'];
		$role = users::get_role($user_id);
		if($role == 'user'){
		$qry = "SELECT  * FROM crm WHERE category = 'Opportunity' AND user_id = ?
		ORDER BY opp_name ASC  
		";
		$res = DB::query($qry, array($user_id));
		echo json_encode($res);		
		}
		else{
		//ADMIN
		if(isset($_GET['usid'])){
			$qry = "SELECT  * FROM crm WHERE category = 'Opportunity' AND user_id = ?
			ORDER BY opp_name ASC  
			";
			$res = DB::query($qry, array($_GET['usid']));
			echo json_encode($res);	
		}
		else{
			$qry = "SELECT  * FROM crm WHERE category = 'Opportunity' 
			ORDER BY opp_name ASC  
			";
			$res = DB::query($qry);
			echo json_encode($res);	
		}

		}
	}




	public function todays_leads(){
		$user_id = $_SESSION['edfghl'];
		$role = users::get_role($user_id);
		if($role == 'user'){
		$qry = "SELECT  * FROM crm WHERE date = CURDATE() AND category = 'Lead' AND user_id = ?
		ORDER BY leadname ASC  
		";
		$res = DB::query($qry, array($user_id));
		echo json_encode($res);		
		}
		else{
		//ADMIN

		if(isset($_GET['usid'])){
			$qry = "SELECT  * FROM crm WHERE date = CURDATE() AND category = 'Lead' AND user_id = ?
			ORDER BY leadname ASC  
			";
			$res = DB::query($qry, array($_GET['usid']));
			echo json_encode($res);	
		}
		else{
			$qry = "SELECT  * FROM crm WHERE date = CURDATE() AND category = 'Lead' 
			ORDER BY leadname ASC  
			";
			$res = DB::query($qry);
			echo json_encode($res);	
		}
		}
		
	}
	
	public function converted_leads(){
		$user_id = $_SESSION['edfghl'];
		$role = users::get_role($user_id);
		if($role == 'user'){
			$qry = "SELECT  * FROM crm WHERE category = 'Converted' AND user_id = ?
			ORDER BY leadname ASC 
			";
			$res = DB::query($qry, array($user_id));
			echo json_encode($res);	
		}
		else{
		//ADMIN
		if(isset($_GET['usid'])){
			$qry = "SELECT  * FROM crm WHERE category = 'Converted' AND user_id = ?
			ORDER BY leadname ASC 
			";
			$res = DB::query($qry, array($_GET['usid']));
			echo json_encode($res);	
		}
		else{
			$qry = "SELECT  * FROM crm WHERE category = 'Converted'
			ORDER BY leadname ASC 
			";
			$res = DB::query($qry);
			echo json_encode($res);	
		}

		}
	}

	public function closing_this_month(){
		$user_id = $_SESSION['edfghl'];
		$role = users::get_role($_SESSION['edfghl']);
		if($role == "user"){
		//Single
		$qry = "SELECT  crm_id, opp_name, revenue, stage, closing_date FROM crm WHERE MONTH(closing_date)  = MONTH(CURDATE()) AND 
		YEAR(closing_date)  = YEAR(CURDATE()) AND
		category = 'Opportunity'  AND user_id = ? ORDER BY  closing_date ASC LIMIT 100
		";
		$res = DB::query($qry, array($user_id));
		echo json_encode($res);			
		}
		else{				
		//Admin
		$qry = "SELECT  crm_id, opp_name, revenue, stage, closing_date FROM crm WHERE MONTH(closing_date) = MONTH(CURDATE())  AND YEAR(closing_date) = YEAR(CURDATE()) AND category = 'Opportunity'  ORDER BY  closing_date ASC LIMIT 100
		";
		$res = DB::query($qry);
		echo json_encode($res);					
		}
	}

	public function not_contacted_leads(){
		$user_id = $_SESSION['edfghl'];
		$role = users::get_role($user_id);
		if($role == 'user'){
			$qry = "SELECT  * FROM crm WHERE lead_status = 'Not Contacted' AND user_id = ?
			ORDER BY leadname ASC 
		";
		$res = DB::query($qry, array($user_id));
		echo json_encode($res);
		}
		else{
		//ADMIN
		if(isset($_GET['usid'])){
			$qry = "SELECT  * FROM crm WHERE lead_status = 'Not Contacted' AND user_id = ?
			ORDER BY leadname ASC 
			";
			$res = DB::query($qry, array($_GET['usid']));
			echo json_encode($res);
		}
		else{
			$qry = "SELECT * FROM crm WHERE lead_status = 'Not Contacted' 
			ORDER BY leadname ASC 
			";
			$res = DB::query($qry);
			echo json_encode($res);
		}

		}
	}

	public function add_comment(){
		$crm_id = $_POST['crm_id'];
		$user_id = $_SESSION['edfghl'];
		$comment = textboxcleaner($_POST['comment']);
		$leadname = $_POST['lead_name'];

		DB::query("INSERT INTO note(message, type, date, reference, assigned) VALUES(?, ?, curdate(), ?, ?)", array($comment, 'comment', $crm_id, $user_id));
		//Insert into history table
		$user_mang = users::get_manager($user_id);
		widgets::add_history(
			array(
			'activity'=> 'Commented on',
			'reference'=> $leadname,
			'date'=> date('Y-m-d H:i:s'),
			'link'=> '?page='.$_POST['page'].'&crm_id='.$crm_id,
			'type'=>'',
			'user_id'=> $user_id,
			'user_mang'=> $user_mang
			)
		); 

		//JSON
		$qry = DB::query("
		SELECT n.*, CONCAT(u.firstname,' ',u.lastname) AS fullname
		FROM note as n JOIN users_details as u ON n.assigned = u.user_id
		WHERE n.reference = ? AND n.type = 'comment' ORDER BY n.note_id DESC
		", array($crm_id));
		echo json_encode($qry);
 
	}


	public function update_comment(){
		$note_id = $_POST['note_id'];
		$crm_id = $_POST['crm_id'];
		$comment = textboxcleaner($_POST['comment']);
		$leadname = $_POST['lead_name'];
		$user_id = $_SESSION['edfghl'];
		DB::query("UPDATE note SET message =? WHERE note_id = ?", array($comment, $note_id));
		//Insert into history table
		$user_mang = users::get_manager($user_id);
		widgets::add_history(
			array(
			'activity'=> 'Update comment',
			'reference'=> $leadname,
			'date'=> date('Y-m-d H:i:s'),
			'link'=> '?page='.$_POST['page'].'&crm_id='.$crm_id,
			'type'=>'',
			'user_id'=> $user_id,
			'user_mang'=> $user_mang
			)
		); 
	}


	public function get_comments(){
		$crm_id = $_GET['crm_id'];
		$qry = DB::query("
		SELECT n.*, CONCAT(u.firstname,' ',u.lastname) AS fullname
		FROM note as n JOIN users_details as u ON n.assigned = u.user_id
		WHERE n.reference = ? AND n.type = 'comment' ORDER BY n.note_id DESC
		", array($crm_id));
		echo json_encode($qry);
	}


	public function delete_comment(){
		$note_id = $_GET['note_id'];
		DB::query("DELETE FROM note WHERE note_id = ?", array($note_id));
	}


	public function get_contact_details(){
		echo crms::get_contact_details();
	}

	public function get_single_contact(){
		echo crms::get_single_contact($_GET['crm_id']);
	}











	public function get_crm(){
		$qry = DB::query("SELECT * FROM crm");
		echo json_encode($qry);
	}

	public function get_crm_note(){
		$qry = DB::query("SELECT * FROM note WHERE type = 'comment'");
		echo json_encode($qry);
	}













}
