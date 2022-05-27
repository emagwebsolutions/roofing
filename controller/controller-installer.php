<?php
ini_set("display_errors", 1);
class installer{
public function install(){
	extract($_POST);

	extract(json_decode($data, TRUE));

    validation::empty_validation(
	array(
		'Db Name'=>$dbname,
		'Db User Name'=>$dbuser, 
		'Db Password'=>$dbpwd, 
		'First Name'=>$firstname,
		'Last Name'=>$lastname,
		'Email'=>$email,
		'Username'=>$username,
		'Password'=>$password
	)
	);

	validation::string_validation(
	array(
		'First Name'=>$firstname,
		'Last Name'=>$lastname
	)
	);

	validation::password_lenght($password);

	validation::email_validation($email); 	

		try{
			$conn = new PDO("mysql:host=localhost;dbname=".$dbname.";charset=utf8mb4", $dbuser, $dbpwd);
			$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
			$conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		}
		catch(PDOException $e){
			?>
			<span style="font-size: 0;">errors</span>
			<?php
			echo 'Incorrect Database Details!';
			exit;
		}

		//Create constants.php file
		$details = "<?php
		define('host','localhost');
		define('username','$dbuser');
		define('password','$dbpwd');
		define('dbname','$dbname');
		?>";
		file_put_contents(dirname(__DIR__).'/model/constants.php', $details);


		$tbl1 = "
			CREATE TABLE IF NOT EXISTS users(
			user_id INT(11) NOT NULL AUTO_INCREMENT,
			username VARCHAR(100) NOT NULL,
			password VARCHAR(100) NOT NULL,
			email VARCHAR(100) NOT NULL,
			user_date DATE NOT NULL,
			user_mang INT(11) NOT NULL,	
			status VARCHAR(100)  NOT NULL DEFAULT 'Unblock', 
			PRIMARY KEY(user_id)
			)ENGINE=InnoDB;
		";
		$conn->query($tbl1);


		$tbl2 = "
		CREATE TABLE role (
		  role_id int(11) NOT NULL AUTO_INCREMENT,
		  name varchar(100) NOT NULL,
		  PRIMARY KEY(role_id)
		) ENGINE=InnoDB";
		$conn->query($tbl2);

		$tbl3 = "
		CREATE TABLE IF NOT EXISTS users_details(
		id INT(11) NOT NULL AUTO_INCREMENT,
		firstname VARCHAR(100) NOT NULL,
		lastname VARCHAR(100) NOT NULL,
		phone VARCHAR(100) NOT NULL,
		location VARCHAR(100) NOT NULL,
		photo VARCHAR(100) NOT NULL,
		hire_date DATE NOT NULL,
		date DATETIME NOT NULL,
		department VARCHAR(100) NOT NULL,
		signature VARCHAR(100) NOT NULL,
		user_id INT(11) NOT NULL,
		user_mang INT(11) NOT NULL,	
		role_id INT(11) NOT NULL,
		tasks TEXT NOT NULL,
		FOREIGN KEY fk1(user_id) REFERENCES users(user_id)
		ON DELETE CASCADE
		ON UPDATE CASCADE,
		FOREIGN KEY usm(user_mang) REFERENCES users(user_id)
		ON DELETE CASCADE
		ON UPDATE CASCADE,	
		FOREIGN KEY rid(role_id) REFERENCES role(role_id)
		ON DELETE CASCADE
		ON UPDATE CASCADE,	
		PRIMARY KEY(id)
		)ENGINE=InnoDB;
		";
		$conn->query($tbl3);	
		

		$tbl4 = "
		CREATE TABLE IF NOT EXISTS settings(
		comp_id INT(11) NOT NULL AUTO_INCREMENT,
		comp_name VARCHAR(100) NOT NULL,
		comp_addr VARCHAR(100) NOT NULL,	
		comp_phone VARCHAR(100) NOT NULL,
		comp_email VARCHAR(100) NOT NULL,
		backup_email  VARCHAR(100) NOT NULL,
		comp_website VARCHAR(100) NOT NULL,
		comp_terms TEXT NOT NULL,
		comp_logo VARCHAR(100) NOT NULL,
		cover_image VARCHAR(100) NOT NULL,	
		comp_bank VARCHAR(100) NOT NULL,
		bank_acc VARCHAR(100) NOT NULL,
		acc_name VARCHAR(100) NOT NULL,
		currency VARCHAR(100) NOT NULL,
		duration VARCHAR(100) NOT NULL,
		email_url   VARCHAR(100) NOT NULL,		
		facebook   VARCHAR(100) NOT NULL,
		instagram	  VARCHAR(100) NOT NULL,
		twitter  VARCHAR(100) NOT NULL,
		sms_sender_id  VARCHAR(100) NOT NULL,
		sms_api_key  VARCHAR(100) NOT NULL,	
		sms_api_url  VARCHAR(100) NOT NULL,	
		sms_cc  VARCHAR(100) NOT NULL,	
		activate_receipt_sms  VARCHAR(100) NOT NULL,
		PRIMARY KEY(comp_id)
		)ENGINE=InnoDB;
		";	
		$conn->query($tbl4);


		$tbl5 = "
		CREATE TABLE IF NOT EXISTS history(
		hist_id int(11) NOT NULL AUTO_INCREMENT,
		activity varchar(100) NOT NULL,
		reference varchar(100) NOT NULL,
		date datetime NOT NULL,
		link TEXT NOT NULL,
		type varchar(50) NOT NULL,
		user_id int(11) NOT NULL,
		user_mang INT(11) NOT NULL,	
		FOREIGN KEY hist1(user_id) REFERENCES users(user_id)
		ON DELETE CASCADE
		ON UPDATE CASCADE,
		FOREIGN KEY hist2(user_mang) REFERENCES users(user_id)
		ON DELETE CASCADE
		ON UPDATE CASCADE,	
		PRIMARY KEY(hist_id)
		) ENGINE=InnoDB;
		";
		$conn->query($tbl5);


		$tbl6 = "
		  CREATE TABLE category (
			cat_id int(11) NOT NULL AUTO_INCREMENT,
			cat_name varchar(100) NOT NULL,
			ref varchar(100) NOT NULL,
			PRIMARY KEY(cat_id)
		) ENGINE=InnoDB";
		$conn->query($tbl6);

		$tbl7 = "
		CREATE TABLE products (
		  prod_id INT(11) NOT NULL AUTO_INCREMENT,
		  prod_code varchar(100) NOT NULL,
		  prod_name varchar(100) NOT NULL,
		  prod_qty varchar(100) NOT NULL,
		  cat_id int(11) NOT NULL,
		  buying_price varchar(100) NOT NULL,
		  selling_price varchar(100) NOT NULL,
		  date datetime NOT NULL,
		  package  varchar(100) NOT NULL,
		  updated_on datetime NOT NULL,
		  FOREIGN KEY fkcat(cat_id) REFERENCES category(cat_id)
		  ON DELETE CASCADE
		  ON UPDATE CASCADE,
		  PRIMARY KEY(prod_id)
		) ENGINE=InnoDB";
		$conn->query($tbl7);


		$tbl8 = "
		CREATE TABLE IF NOT EXISTS customers(
		cust_id INT(11) NOT NULL AUTO_INCREMENT,
		fullname VARCHAR(100) NOT NULL,
		phone VARCHAR(100) NOT NULL,
		email VARCHAR(100) NOT NULL, 
		location VARCHAR(100) NOT NULL,
		date DATE NOT NULL,
		user_id INT(11) NOT NULL,
		user_mang INT(11) NOT NULL,		
		note TEXT NOT NULL,
		type VARCHAR(255) NOT NULL,
		funds VARCHAR(255) NOT NULL,
		ac_id INT(11) NOT NULL,
		FOREIGN KEY fkuss1(user_id) REFERENCES users(user_id)
		ON DELETE CASCADE
		ON UPDATE CASCADE,
		PRIMARY KEY(cust_id)
		)ENGINE=InnoDB;
		";
		$conn->query($tbl8);


		$tbl9 = "	
		CREATE TABLE IF NOT EXISTS payment(
		p_id INT(11) NOT NULL AUTO_INCREMENT,
		amount VARCHAR(100) NOT NULL,
		pay_type VARCHAR(100) NOT NULL,
		pay_date   DATE  NOT NULL,
		pay_no VARCHAR(100) NOT NULL,
		invoice_no VARCHAR(100) NOT NULL,
		cust_id INT(11) NOT NULL,
		user_id INT(11) NOT NULL,
		FOREIGN KEY fkicid(cust_id) REFERENCES customers(cust_id)
		ON DELETE CASCADE
		ON UPDATE CASCADE,
		FOREIGN KEY fkuisid(user_id) REFERENCES users(user_id)
		ON DELETE CASCADE
		ON UPDATE CASCADE,
		PRIMARY KEY(p_id)
		)ENGINE=InnoDB;
		";
	  	$conn->query($tbl9);	


		  $tbl10 = "
		  CREATE TABLE IF NOT EXISTS sales(
		  s_id INT(11) NOT NULL AUTO_INCREMENT,
		  unit_price VARCHAR(100) NOT NULL,
		  qty VARCHAR(100) NOT NULL,
		  total VARCHAR(100) NOT NULL,
		  subtotal VARCHAR(100) NOT NULL,
		  vat VARCHAR(100) NOT NULL,
		  tduration VARCHAR(100) NOT NULL,
		  grandtotal VARCHAR(100) NOT NULL,
		  discount VARCHAR(100) NOT NULL,
		  trans_type VARCHAR(100) NOT NULL,
		  date DATETIME NOT NULL,
		  invoice_no VARCHAR(100) NOT NULL,	
		  project VARCHAR(100) NOT NULL,		
		  vat_rate VARCHAR(100) NOT NULL,			
		   nhil  VARCHAR(100) NOT NULL,  
		   getfund   VARCHAR(100) NOT NULL,
		   nhils  VARCHAR(100) NOT NULL,  
		   getfunds   VARCHAR(100) NOT NULL,		 
		  discount_rate VARCHAR(100) NOT NULL,		
		  exp_date DATE NOT NULL,
		  prod_id INT(11) NOT NULL,
		  prod_name VARCHAR(100) NOT NULL,	
		  duration  VARCHAR(100) NOT NULL,		
		  cat_name  VARCHAR(100) NOT NULL,				
		  cust_id INT(11) NOT NULL,
		  ac_id INT(11) NOT NULL,		
		  user_id INT(11) NOT NULL,
		  status int(11) NOT NULL,
		  FOREIGN KEY fkcid(cust_id) REFERENCES customers(cust_id)
		  ON DELETE CASCADE
		  ON UPDATE CASCADE,
		  FOREIGN KEY fkusid(user_id) REFERENCES users(user_id)
		  ON DELETE CASCADE
		  ON UPDATE CASCADE,
		  PRIMARY KEY(s_id)
		  )ENGINE=InnoDB;
	  ";
	  $conn->query($tbl10);

	  $tbl11 = "
	  CREATE TABLE IF NOT EXISTS note(
	  note_id INT(11) NOT NULL AUTO_INCREMENT,
	  subject  VARCHAR(100) NOT NULL,
	  message TEXT NOT NULL,
	  date DATE NOT NULL,
	  reference VARCHAR(100) NOT NULL,
	  type VARCHAR(100) NOT NULL,
	  status VARCHAR(100) NOT NULL,
	  assigned VARCHAR(100) NOT NULL,
	  PRIMARY KEY (note_id)
	  )ENGINE=InnoDB;
  	  ";
  	  $conn->query($tbl11);


		$tbl12 = "
		CREATE TABLE IF NOT EXISTS crm(
		crm_id INT(11) NOT NULL AUTO_INCREMENT,
		leadname VARCHAR(100) NOT NULL, 
		contactname VARCHAR(100) NOT NULL, 
		company VARCHAR(100) NOT NULL, 
		industry VARCHAR(100) NOT NULL, 
		email   VARCHAR(100) NOT NULL, 
		url   VARCHAR(100) NOT NULL, 
		phone VARCHAR(100) NOT NULL, 
		mobile VARCHAR(100) NOT NULL, 
		lead_source VARCHAR(100) NOT NULL, 
		lead_status VARCHAR(100) NOT NULL, 
		sales_stage VARCHAR(100) NOT NULL, 
		skype VARCHAR(100) NOT NULL, 
		twitter VARCHAR(100) NOT NULL, 
		facebook VARCHAR(100) NOT NULL, 
		region VARCHAR(100) NOT NULL, 
		city VARCHAR(100) NOT NULL, 
		description TEXT NOT NULL,
		opp_name VARCHAR(100) NOT NULL, 
		closing_date DATE,
		stage VARCHAR(100) NOT NULL, 
		type VARCHAR(100) NOT NULL, 
		probability INT(11) NOT NULL,
		revenue VARCHAR(100) NOT NULL, 
		category  VARCHAR(100) NOT NULL, 
		date DATETIME,
		cust_id INT(11) NOT NULL, 
		user_id INT(11) NOT NULL,
		FOREIGN KEY cmsfk2(user_id)  REFERENCES users(user_id)
		ON DELETE CASCADE
		ON UPDATE CASCADE,
		PRIMARY KEY(crm_id)
		)ENGINE=InnoDB;
			";
		$conn->query($tbl12);	


		$tbl13 = "
		CREATE TABLE IF NOT EXISTS menu (
		menu_id INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
		menu_name	VARCHAR(150) NOT NULL,
		menu_parent		VARCHAR(150) NOT NULL
		)ENGINE=InnoDB;
		";
		$conn->query($tbl13);
		  

		$tbl14 = "
		CREATE TABLE IF NOT EXISTS user_menu (
		usermenu_id INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
		menu_name	VARCHAR(150) NOT NULL,
		menu_parent		VARCHAR(150) NOT NULL,
		menu_position 	INT(11) NOT NULL,
		user_id	INT(11) NOT NULL
		)ENGINE=InnoDB;
		";
		$conn->query($tbl14);
	
	/*------------------------------------------------------------
	BEGIN INSERT INTO USERS 
	-------------------------------------------------------------*/
	
	$qry = $conn->prepare("INSERT INTO users(user_id, username, password, email, user_date, user_mang)  VALUES ('1', ?, ?, ?, curdate(), '1')");
	$qry->bindParam(1, $username);
	$qry->bindParam(2, password_hash($password, PASSWORD_BCRYPT));
	$qry->bindParam(3, $email);
	$qry->execute();
	
	/*------------------------------------------------------------
	END  INSERT INTO USERS 
	-------------------------------------------------------------*/	

	/*------------------------------------------------------------
	BEGIN INSERT INTO ROLE
	-------------------------------------------------------------*/
	$conn->query("INSERT INTO role(role_id, name) VALUES
	('1', 'admin'),
	('2', 'user'),
	('3', 'manager'),
	('4', 'customer'),
	('5', 'agent')
	");

	$conn->query("INSERT INTO menu(menu_id, menu_name,menu_parent) VALUES
	('1', 'Dashboard','null'),
	('2', 'Customer','null'),
	('3', 'Customer Accounts','Customer'),
	('4', 'Create Sales Invoice','Customer'),
	('5', 'Create Proforma Invoice','Customer'),
	('6', 'Employees','null'),
	('7', 'Products','null'),
	('8', 'Contacts','null'),
	('9', 'Note','null'),
	('10', 'SMS','null'),
	('11', 'Leads','null'),
	('12', 'Opportunity','null'),
	('13', 'Settings','null')
	");




	$conn->query("INSERT INTO user_menu(usermenu_id,menu_name,menu_parent,menu_position,user_id) VALUES
	('1', 'Dashboard','null','1','1'),
	('2', 'Customer','null','2','1'),
	('3', 'Customer Accounts','Customer','3','1'),
	('4', 'Create Sales Invoice','Customer','4','1'),
	('5', 'Create Proforma Invoice','Customer','5','1'),
	('6', 'Employees','null','6','1'),
	('7', 'Products','null','7','1'),
	('8', 'Contacts','null','8','1'),
	('9', 'Note','null','9','1'),
	('10', 'SMS','null','10','1'),
	('11', 'Leads','null','11','1'),
	('12', 'Opportunity','null','12','1'),
	('13', 'Settings','null','13','1')
	");

	/*--------------------------------------------------
	END INSERT INTO ROLE
	-------------------------------------------------*/
	
	/*--------------------------------------------------
	BEGIN INSERT INTO SETTINGS 
	--------------------------------------------------*/	
	$conn->query("INSERT INTO settings(comp_name,currency,duration) VALUES('Emagweb Solutions','GHs','Month')");
	/*----------------------------------------------------
	END INSERT INTO
	----------------------------------------------------*/	

	/*------------------------------------------------------------
	BEGIN INSERT INTO USERS DETAILS
	-------------------------------------------------------------*/
	$usdet = $conn->prepare("INSERT INTO users_details(firstname, lastname, user_id, user_mang, role_id, date) VALUES(?, ?, '1', '1', '1',now())");
	$usdet->bindParam(1, $firstname);
	$usdet->bindParam(2, $lastname);
	$usdet->execute();
	
	/*------------------------------------------------------------
	END INSERT INTO USERS DETAILS
	--------------------------------------------------*/

	}
}