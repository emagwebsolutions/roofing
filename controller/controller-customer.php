<?php
class customer{

public function add_new_customer(){
	//Get values from form fields 
	extract(json_decode($_POST['data'],TRUE));

	//Empty Fields Validation
    validation::empty_validation(
	array(
	'Full Name'=>$fullname,
	'Location' => $location
	)
	);
	//String Validation
	validation::string_validation(
	array(
		'Full Name'=>$fullname,
		'Location'=>$location
	)
	);



	//Check fullname and location 
	$qry = "SELECT fullname FROM customers WHERE  fullname = ? AND location =?";
	$rzlt = DB::query($qry, array($fullname,$location));
	if(!empty($rzlt)){
		foreach($rzlt as $v){
		template::output(false, 'Customer already exists!');
		}
	}

	if($phone){
		validation::phone_validation(
			array(
			'Phone no.'=>$phone
			)
		);
		//Check if phone exists 
		$qry = "SELECT fullname, phone FROM customers WHERE  phone = ?";
		$rzlt = DB::query($qry, array($phone));
		if(!empty($rzlt)){
			foreach($rzlt as $v){
			template::output(false, 'Phone number assigned to '.$v['fullname']);
			}
		}
	}


	if($email){
		validation::email_validation($email);
		//Check if email exists 
		$qry = "SELECT fullname, email FROM customers WHERE  email = ? AND type = 'Customer'";
		$rzlt = DB::query($qry, array($email));
		if(!empty($rzlt)){
			foreach($rzlt as $v){
			   template::output(false, 'Email assigned to '.$v['fullname']);
			}
		}
	}

	 $role = users::current_role($_SESSION['edfghl']);
	if( ($role == 'manager') OR ($role == 'admin') ){
		$user_mang = $_SESSION['edfghl'];
	}
	else{
		$user_mang = users::get_manager($_SESSION['edfghl']);
	}
	 DB::query("INSERT INTO   customers(fullname, phone, email, location, date, user_id, user_mang,type) VALUES(?, ?, ?, ?, curdate(), ?, ?,'Customer')", 
	array( $fullname, $phone, $email, $location, $_SESSION['edfghl'], $user_mang)
	);


	echo 'Customer added successfully!';


	}



	public function edit_customer(){
	//Get values from form fields 
	extract($_POST);
	$date = date('Y-m-d');
	if(empty($user_id) OR ($user_id == 'undefined')){
		template::output(false, 'Invalid Assigned to');
	}
	//Empty Fields Validation
    validation::empty_validation(
	array(
	'Full Name'=>$fullname,
	'Location'=>$location
	)
	);
	//String Validation
	validation::string_validation(
	array(
		'Full Name'=>$fullname,
		'Location'=>$location
	)
	);



	if($phone){
		validation::phone_validation(
			array(
			'Phone no.'=>$phone
			)
		);
	}


    validation::phone_validation(
	array(
	'Phone no.'=>$phone
	)
	);
	if(empty($email)){
		$email = '';
	}
	else{
	validation::email_validation($email);
	}


	if(empty($email)){
		$email = '';
	}
	else{
	validation::email_validation($email);
		//Check if email exists 
		$qry = "SELECT fullname, email FROM customers WHERE  email = ? AND cust_id != ?";
		$rzlt = DB::query($qry, array($email, $cust_id));
		if(!empty($rzlt)){
			foreach($rzlt as $v){
			   template::output(false, 'Email assigned to '.$v['fullname']);
			}
		}
	}


	//Check if phone exists 
	$qry = "SELECT fullname, phone FROM customers WHERE  phone = ? AND cust_id != ?";
	 $rzlt = DB::query($qry, array($phone, $cust_id));
	 if(!empty($rzlt)){
		 foreach($rzlt as $v){
			template::output(false, 'Phone number assigned to '.$v['fullname']);
		 }
	 }


	DB::query("UPDATE customers  SET  fullname = ?, phone = ?, email = ?, location = ?, date = ? , user_id = ?   WHERE cust_id = ? ",
	array(
	$fullname,
	$phone,
	$email,
	$location,
	$date,
	$user_id,
	$cust_id)
	);

	//Insert into history table
	$user_mang = users::get_manager($_SESSION['edfghl']);
	widgets::add_history(
		array(
		'activity'=> 'Updated Customer',
		'reference'=> $fullname,
		'date'=> date('Y-m-d H:i:s'),
		'link'=> '#',
		type=>'customer',
		'user_id'=> $_SESSION['edfghl'],
		'user_mang'=> $user_mang
		)
	);

	echo 'Customer updated!';

	}
	


	public function delete_customer(){
		$cust_id = $_POST['cust_id'];
		$cust = DB::get_row("SELECT fullname FROM customers WHERE cust_id = ?", array($cust_id));
		DB::query("DELETE FROM customers  WHERE cust_id = ?", array($cust_id));
		$user_mang = users::get_manager($_SESSION['edfghl']);
		widgets::add_history(
			array(
			'activity'=> 'Deleted Customer',
			'reference'=> $cust['fullname'],
			'date'=> date('Y-m-d H:i:s'),
			'link'=> '#',
			type=>'customer',
			'user_id'=> $_SESSION['edfghl'],
			'user_mang'=> $user_mang
			)
		);
	}


	
	
	
	
	
	
	
	
	public function get_customers_transactioons(){
		/*==========================================
		Begin Customers details
		==========================================*/
			$cust_id = $_GET['cust_id'];
		
			$qry1 = "SELECT  c.cust_id, c.date, c.fullname, c.phone, c.email, c.location, c.user_id, u.firstname, u.lastname FROM  customers as c JOIN users_details as u ON c.user_id = u.user_id   WHERE c.cust_id = ? AND c.type = 'Customer' ORDER BY c.fullname ASC";	
			$rzlt = DB::query($qry1, array($cust_id));

			$jsnenc = json_encode($rzlt);
			file_put_contents('assets/json/customer-'.$_SESSION['edfghl'].'-file.json', $jsnenc);
	    /*==========================================
		End Customers details
		==========================================*/
	
		/*==========================================
		Begin Invoice Details
		==========================================*/
			$qry2 = sale::invoiceJson($cust_id);
			if(!empty($qry2)){
				$invx = group_array($qry2);
			}
			else{
				$invx = array();
			}
		/*==========================================
		End Invoice Details
		==========================================*/
		
		/*==========================================
		Begin Proforma details
		==========================================*/
			$qry3 = sale::proformaJson($cust_id);
			if(!empty($qry3)){
				$profx = group_array($qry3);
			}
			else{
				$profx = array();
			}
		/*==========================================
		End Proforma details
		==========================================*/	


		/*==========================================
		Begin Receipt details
		==========================================*/
		$receipt = sale::get_receipt($cust_id);
		/*==========================================
		End Receipt details
		==========================================*/
		
		

		/*==========================================
		Begin Proforma details
		==========================================*/
		$role = users::get_role($_SESSION['edfghl']);


		?>
		<!-------------------------------------------------------------
		BEGIN PROFORMA
		-------------------------------------------------------------->
		<div class="tab-pane fade show active" id="proforma1">
				<div class="container grid-striped" id="tabscroll">
				
					<div class="row py-2  table-header mt-2">
					<div class="col" >Proforma #</div>
					<div class="col">Date</div>
					<div class="col">Project</div>
					<div class="col">Total (GHs)</div>
					<div class="col" >Actions</div>
					</div>

					<!-- BEGIN PROFORMA SEARCH BOX -->
					<br>
					<div class="form-group">
					<input type="text" class="form-control search prosearchbox" placeholder="Search by Project Name">
					</div>
					<!-- END PROFORMA SEARCH BOX -->

					<div id="proformares"  class="trans_search_table">

					<?php

					foreach($profx as $v){
					?>
					<div class="text-dark  row py-2 " style="font-size: 12px;">

					<div class="col"><?php echo $v['invoice_no']; ?></div>
					<div class="col"><?php echo date('d M Y', strtotime($v['date'])); ?></div>
					<div class="col prosearch_word"><?php echo $v['project']; ?></div>
					<div class="col"><?php echo $v['grandtotal']; ?></div>


					<div class="col">

					<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="Duplicate Proforma" class="badge badge-danger duplic" 
					data-cust_id = "<?php echo $v['cust_id']; ?>"  id="duplicate" data-inv_no = "<?php echo $v['invoice_no']; ?>" >Duplicate</a>&nbsp;&nbsp;

					<a href="?page=editproforma&inv_no=<?php echo $v['invoice_no'];?>&cust_id=<?php echo $v['cust_id']; ?>">
					<i class="fa fa-edit fa-xs editprof"  data-toggle="tooltip" data-placement="top" title="Edit Proforma">
					</i>
					</a>&nbsp;&nbsp;

					<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="Delete Invoice"><i class="fa fa-trash fa-md delete_proforma" data-inv_no = "<?php echo $v['invoice_no']; ?>" data-cust_id = "<?php echo $v['cust_id']; ?>"   ></i></a>&nbsp;&nbsp;


					<a href="?page=viewproforma&inv_no=<?php echo $v['invoice_no'];?>&cust_id=<?php echo $v['cust_id']; ?>">
					<i class="fa fa-eye fa-xs "  data-toggle="tooltip" data-placement="top" title="View Proforma"></i>
					</a>

					</div>
					</div>

					<?php
					}

					?>
					</div>
					<!-- BEGIN PROFORMA TOTAL AMOUNT -->
					<div class="proamountPaid mt-3 row" style="display: none;">
					<div class="col-md-3">Total Amount</div>
					<div class="col-md-2" id="prototalAmount"></div>
					</div>
					<!-- END PROFORMA TOTAL AMOUNT -->

				</div>
			</div>
		<!-------------------------------------------------------------
		END PROFORMA
		-------------------------------------------------------------->		


		<!-------------------------------------------------------------
		BEGIN INVOICE
		-------------------------------------------------------------->		
		<div class="tab-pane fade" id="invoice1">
		<div class="container grid-striped">

		<div class="row py-2  table-header mt-2">
		<div class="col">Invoice#</div>
		<div class="col">Date</div>
		<div class="col">Project</div>
		<div class="col">Total (GHs)</div>
		<div class="col" >Actions</div>
		</div>

		<!-- BEGIN INVOICE SEARCH BOX -->
		<br>
		<div class="form-group">
		<input type="text" class="form-control search invsearchbox" placeholder="Search by Project Name">
		</div>
		<!-- END INVOICE SEARCH BOX -->

		<div class="trans_search_table" id="invoiceres">
		<?php


		foreach($invx as $v){

		?>
		<div class="text-dark  row py-2 " style="font-size: 12px;">

		<div class="col"><?php echo $v['invoice_no']; ?></div>
		<div class="col"><?php echo date('d M Y', strtotime($v['date'])); ?></div>
		<div class="col invsearch_word"><?php echo $v['project']; ?></div>
		<div class="col"> <?php echo $v['grandtotal']; ?> </div>

		<div class="col">
		<a href="?page=viewinvoice&inv_no=<?php echo $v['invoice_no']; ?>&cust_id=<?php echo $v['cust_id']; ?>">
		<i class="fa fa-eye fa-xs"  data-toggle="tooltip" data-placement="top" title="View Invoice"></i>
		</a>&nbsp;&nbsp;&nbsp;&nbsp;
		

		<?php if($role == 'admin'){ ?>
		<a href="?page=editinvoice&inv_no=<?php echo $v['invoice_no'];?>&cust_id=<?php echo $v['cust_id']; ?>">
<i class="fa fa-edit fa-xs"  data-toggle="tooltip" data-placement="top" title="Edit Invoice">
		</i>
		</a>&nbsp;&nbsp;


		<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="Delete Invoice"><i class="fa fa-trash fa-md delete_proforma" data-inv_no = "<?php echo $v['invoice_no']; ?>" data-cust_id = "<?php echo $v['cust_id']; ?>"   ></i></a>&nbsp;&nbsp;


		<?php } ?>

		</div>
		</div>

		<?php
		}

		?>
		</div>
		<!-- BEGIN INVOICE TOTAL AMOUNT -->
		<div class="invamountPaid mt-3 row" style="display: none;">
		<div class="col-md-3">Total Amount</div>
		<div class="col-md-2" id="invtotalAmount"></div>
		</div>
		<!-- END INVOICE TOTAL AMOUNT -->
		</div>
		</div>
		<!-------------------------------------------------------------
		END INVOICE
		-------------------------------------------------------------->	


		<!-------------------------------------------------------------
		BEGIN RECEIPT
		-------------------------------------------------------------->				
		<div class="tab-pane fade" id="receipt1">

					<div class="container grid-striped">	

					<div class="row py-2  table-header mt-2">
					<div class="col ">Receipt#</div>		
					<div class="col">Invoice#</div>				
					<div class="col">Amount</div>
					<div class="col">Type</div>
					<div class="col">Date</div>
					<div class="col" >Action</div>
					</div>

					<!-- BEGIN RECEIPT SEARCH BOX -->
					<br>
					<div class="form-group">
					<input type="text" class="form-control recsearchbox" placeholder="Search by Invoice Number">
					</div>
					<!-- END RECEIPT SEARCH BOX -->

					<div class="trans_search_table"  id="receipt">

					<?php
					foreach($receipt as $v){

					?>
					<div class="text-dark  row py-2 " style="font-size: 12px;">

					<div class="col"><?php echo $v['pay_no']; ?></div>
					<div class="col recsearch_word"><?php echo $v['invoice_no']; ?></div>
					<div class="col"> <?php echo $v['amount']; ?> </div>
					<div class="col"> <?php echo $v['pay_type']; ?> </div>
					<div class="col"><?php echo date('d M Y', strtotime($v['pay_date'])); ?>
					</div>
				
					<div class="col">
					<a href="?page=viewreceipt&rec_no=<?php echo $v['p_id']; ?>&inv_no=<?php echo $v['invoice_no']; ?>&cust_id=<?php echo $v['cust_id']; ?>&amnt=<?php echo $v['amount']; ?>">
					<i class="fa fa-eye fa-xs" data-invoice_no = "<?php echo $v['invoice_no']; ?>"  
					data-amnt = "<?php echo $v['amount']; ?>" data-cust_id = "<?php echo $v['cust_id']; ?>"
					  data-toggle="tooltip" data-placement="top" title="View Receipt"></i>
					</a>&nbsp;&nbsp;

					<?php if($role == 'admin'){ ?>
					<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="Delete Receipt"><i class="fa fa-trash fa-md delete_receipt" data-rec_no = "<?php echo $v['p_id']; ?>" data-cust_id = "<?php echo $v['cust_id']; ?>"   ></i></a>&nbsp;&nbsp;
					<?php } ?>

					</div>
					</div>
					<?php
					}

					?>
					
					</div>

				<div class="recamountPaid mt-3 row" style="display: none;">
				<div class="col-md-3">Total Amount</div>
				<div class="col-md-2" id="rectotalAmount"></div>
				</div>
				<!-- END RECEIPT TOTAL AMOUNT -->

				</div>
			</div>
		<!-------------------------------------------------------------
		END RECEIPT
		-------------------------------------------------------------->	

		<?php

		foreach($rzlt as $v){
			if($v['user_id'] == $_SESSION['edfghl']){
				?>
				<style>
					.cust-note{
						display: inline-block;
						float: right;
						margin-left: 4px!important;
					}
				</style>
				<?php
			}
		}

	}




	public function maxCustID(){
		$cust = DB::get_row("SELECT MAX(cust_id) AS cust_id FROM customers WHERE type = 'Customer'");
		echo $cust['cust_id'];
	}

	public function all_vendors(){
		echo customers::vendors_json_file();
	}



	public function get_single_customer(){
		echo customers::single_customer_json($_GET['user_id']);
	}

	public function current_customer(){
		echo customers::current_customer($_GET['cust_id']);
	}

	public function customer_list(){
		echo customers::customer_list();
	}



	public static function add_funds(){
		$funds = $_POST['funds'];
		$cust_id = $_POST['cust_id'];
		validation::empty_validation(array('Funds'=>$funds));
		DB::query("UPDATE customers SET funds = ? WHERE cust_id = ? AND type = 'Customer'", array($funds, $cust_id));
		echo 'Note added successfully!';
	}

	public static function add_note(){
		$mess = $_POST['message'];
		$cust_id = $_POST['cust_id'];
		validation::empty_validation(array('Note'=>$mess));
		DB::query("UPDATE customers SET note = ? WHERE cust_id = ? AND type = 'Customer'", array($mess, $cust_id));
		echo 'Note added successfully!';
	}






	public function getCustomerSales(){
		$qry = DB::query("SELECT * FROM sales");
		echo json_encode($qry);
	}

	public function getCustomersReceipts(){
		$qry = DB::query("SELECT * FROM payment");
		echo json_encode($qry);
	}

	public function all_customers(){
		$qry = DB::query("SELECT * FROM customers");
		echo json_encode($qry);
	}



}
