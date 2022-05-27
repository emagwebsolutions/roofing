<?php
class sales{

public function add_proforma(){
		/*------------------------------------------------
		*BEGIN SINGLE VALUES
		------------------------------------------------*/
		//Proforma & Invoice inputs fields 
		//Top Section 
		$nhil = $_POST['nhil'];
		$getfund = $_POST['getfund'];
		$vatinp =  $_POST['vatinp'];
		$discountinpt = $_POST['discountinpt'];
		$invoice_no =   accounts::inv_num('proforma', 'PRO-');
		$pro_date = $_POST['pro_date'];
		$project = $_POST['project'];
		$tduration = $_POST['tduration'];		
		//Bottom Section 
		$subtotal = $_POST['subtotal'];
		$discount = $_POST['discount'];
		$nhils= $_POST['nhils'];
		$getfunds = $_POST['getfunds'];	
		$vat = $_POST['vat'];
		$grandtotal = $_POST['grandtotal'];
		$message = textboxcleaner($_POST['message']);
		//Hidden inputs 
		$user_id = $_SESSION['edfghl'];
		$cust_id = $_POST['cust_id'];
		$trans_type = 'proforma';
		/*------------------------------------------------
		*END SINGLE VALUES
		------------------------------------------------*/
		/*------------------------------------------------
		*BEGIN ARRAY ROW VALUES
		------------------------------------------------*/		
		$prod_qty = json_decode($_POST['prod_qty']);
		$prod_name = json_decode($_POST['prod_name']);	
		$duration = json_decode($_POST['duration']);		
		$price = json_decode($_POST['price']);
		$total = json_decode($_POST['total']);
		//Hidden inputs 		
		$cat_name = json_decode($_POST['cat_name']);	
		$prod_id = json_decode($_POST['prod_id']);
		/*------------------------------------------------
		*END ARRAY VALUES
		------------------------------------------------*/

		/*---------------------------------------------
		Begin date validation
		----------------------------------------------*/
		//Proforma date validation
		$pro_date = date("Y-m-d", strtotime($pro_date)).' '.date('H:i:s');
		validation::date_validation($pro_date, 'Proforma Date field required!');
		/*---------------------------------------------
		End date validation
		----------------------------------------------*/
		

		//Check if PROFORMA already exists 
		$date = date("Y-m-d");
		$rzlt = DB::get_row("SELECT  invoice_no FROM sales WHERE invoice_no = ?", array($invoice_no));
		 if(!empty($rzlt)){
			 echo "<span style='font-size:0;'>errors</span>";	
				?>
				This <?php echo $rzlt['invoice_no']; ?> proforma already exists!
				<?php
				exit;
		 }
		 else{
		 }
		
            /*---------------------------------------------
			Begin General Validation
			----------------------------------------------*/
			sale::invoiceValidation(
				$vat,$vatinp,$discount,$discountinpt,$nhil,$nhils,$getfunds,$getfund,$tduration,$subtotal,$grandtotal,$project,$cust_id,$prod_name,$total,$duration
			);
			/*---------------------------------------------
			End General Validation
			----------------------------------------------*/

			

			/*-------------------------------------------------
			Begin Generate Invoice
			-------------------------------------------------*/	
			$arr1 = array($price,$prod_qty,$total,$prod_id,$prod_name,$duration, $cat_name);

			$arr2 = array();
			foreach($arr1[0] as $k => $v){
				$arr2[] =  array( 
					$v, 
					$arr1[1][$k],  
					$arr1[2][$k], 
					$subtotal,
					$vat,
					$tduration,	
					$grandtotal,
					$discount,
					$trans_type,
					$pro_date,
					$invoice_no,
					$project,
					$vatinp,
					$nhil, 
					$getfund,
					$nhils,
					$getfunds,
					$discountinpt,
					$arr1[3][$k], 
					$arr1[4][$k], 
					$arr1[5][$k], 
					$arr1[6][$k],
					$cust_id,
					$user_id					
				);
			}
			/*-------------------------------------------------
			End Generate Invoice
			-------------------------------------------------*/

			$insertPlaceholder = sale::insertPlaceholders($arr2);
			$mergeArrays = sale::mergeMultidimensionalArrs($arr2);

			/*-------------------------------------------------
			Begin insert into database
			-------------------------------------------------*/		
			$inst = "INSERT INTO sales(
						unit_price,
						qty,
						total,
						subtotal,
						vat,
						tduration,
						grandtotal,
						discount,
						trans_type,
						date,
						invoice_no,
						project,
						vat_rate,
						nhil,
						getfund,
						nhils,
						getfunds,
						discount_rate,
						prod_id,
						prod_name,
						duration,
						cat_name,
						cust_id,
						user_id


			) VALUES ".$insertPlaceholder." ";

			DB::query($inst, $mergeArrays);
			/*-------------------------------------------------
			End insert into database
			-------------------------------------------------*/	
					
			//Create note
			sale::createProformaNote('', $message, $invoice_no);

			//Proforma json 
			sale::proformaJson($cust_id);

			//Inset into history table
			$user_mang = users::get_manager($_SESSION['edfghl']);
		 
			widgets::add_history(
				array(
				'activity'=> 'Added Proforma',
				'reference'=> $project,
				'date'=> date('Y-m-d H:i:s'),
				'link'=> '?page=viewproforma&inv_no='.$invoice_no,
				'type'=>'',
				'user_id'=> $user_id,
				'user_mang'=> $user_mang
				)
			);

			echo $invoice_no.'--'.$cust_id; 


			}
			public function update_proforma(){
				/*------------------------------------------------
				*BEGIN SINGLE VALUES
				------------------------------------------------*/
				//Proforma & Invoice inputs fields 
				//Top Section 
				$nhil = $_POST['nhil'];
				$getfund = $_POST['getfund'];	
				$vatinp = $_POST['vatinp'];
				$discountinpt = $_POST['discountinpt'];
				$pro_date = $_POST['pro_date'];
				$project = $_POST['project'];
				$tduration = $_POST['tduration'];	
				//Bottom Section 
				$subtotal = $_POST['subtotal'];
				$discount = $_POST['discount'];
				$nhils = $_POST['nhils'];
				$getfunds = $_POST['getfunds'];		
				$vat = $_POST['vat'];
				$grandtotal = $_POST['grandtotal'];
				$message = $_POST['message'];
				//Hidden inputs 
				$user_id = $_POST['user_id'];
				$cust_id = $_POST['cust_id'];	
				$invoice_no = $_POST['invoice_no'];
				$note_id = $_POST['note_id'];
				$trans_type = 'proforma';
				/*------------------------------------------------
				*END SINGLE VALUES
				------------------------------------------------*/
				/*------------------------------------------------
				*BEGIN ARRAY ROW VALUES
				------------------------------------------------*/		
				$prod_qty = json_decode($_POST['prod_qty']);
				$prod_name = json_decode($_POST['prod_name']);			
				$duration = json_decode($_POST['duration']);		
				$price = json_decode($_POST['price']);
				$total = json_decode($_POST['total']);
				//Hidden inputs 		
				$cat_name = json_decode($_POST['cat_name']);	
				$prod_id = json_decode($_POST['prod_id']);
				$s_id = json_decode($_POST['s_id']);	
				/*------------------------------------------------
				*END ARRAY VALUES
				------------------------------------------------*/			
				$date = date("Y-m-d H:i:s");
				/*---------------------------------------------
				Begin date validation
				----------------------------------------------*/
				//Start date validation
				$pro_date = date("Y-m-d", strtotime($pro_date)).' '.date('H:i:s');
				validation::date_validation($pro_date, 'Proforma Date field required!');
				
				/*---------------------------------------------
				End date validation
				----------------------------------------------*/	
		
					/*---------------------------------------------
					Begin General Validation
					----------------------------------------------*/
					sale::invoiceValidation(
						$vat,$vatinp,$discount,$discountinpt,$nhil,$nhils,$getfunds,$getfund,$tduration,
						$subtotal,$grandtotal,$project,$cust_id,$prod_name,$total,$duration
					);
					/*---------------------------------------------
					End General Validation
					----------------------------------------------*/
		
					
		
					/*-------------------------------------------------
					Begin Generate Invoice
					-------------------------------------------------*/	
					$arr1 = array($s_id, $price, $prod_qty,  $total, $prod_id, $prod_name ,$duration, $cat_name);
		
					$arr2 = array();
					foreach($arr1[1] as $k => $v){
						$arr2[] =  array( 
							$arr1[0][$k],
							$v, 
							$arr1[2][$k],  
							$arr1[3][$k], 
							$subtotal,
							$vat,
							$tduration,	
							$grandtotal,
							$discount,
							$trans_type,
							$pro_date,
							$invoice_no,
							$project,
							$vatinp,
							$nhil, 
							$getfund,
							$nhils,
							$getfunds,
							$discountinpt,
							$arr1[4][$k], 
							$arr1[5][$k], 
							$arr1[6][$k], 
							$arr1[7][$k],
							$cust_id,
							$user_id					
						);
					}
					/*-------------------------------------------------
					End Generate Invoice
					-------------------------------------------------*/
		
					$insertPlaceholder = sale::insertPlaceholders($arr2);
					$mergeArrays = sale::mergeMultidimensionalArrs($arr2);
		
						/*-------------------------------------------------
					Begin insert into database
					-------------------------------------------------*/		
					$qry = "
						INSERT INTO sales(
							 s_id,
							unit_price, 	
							qty, 
							total, 
							subtotal, 
							vat, 	
							tduration,
							grandtotal, 		
							discount, 
							trans_type, 	
							date, 
							invoice_no,
							project, 		
							vat_rate,
							nhil,
							getfund,
							nhils,
							getfunds,
							discount_rate,
							prod_id, 
							prod_name, 						
							duration, 				
							cat_name, 	
							cust_id, 			
							user_id
						)      
						VALUES ".$insertPlaceholder."    ON DUPLICATE KEY UPDATE
							unit_price = VALUES(unit_price), 	
							qty = VALUES(qty), 
							total = VALUES(total), 
							prod_id = VALUES(prod_id), 
							prod_name = VALUES(prod_name), 					
							duration = VALUES(duration), 				
							cat_name = VALUES(cat_name), 	
							subtotal = VALUES(subtotal), 	
							vat = VALUES(vat), 	
							tduration = VALUES(tduration), 
							grandtotal = VALUES(grandtotal), 		
							discount = VALUES(discount), 	
							date = VALUES(date), 
							project = VALUES(project), 		
							vat_rate = VALUES(vat_rate),
							nhil = VALUES(nhil),
							getfund = VALUES(getfund),
							nhils = VALUES(nhils),
							getfunds = VALUES(getfunds),
							discount_rate = VALUES(discount_rate),
							cust_id  = VALUES(cust_id), 						
							user_id  = VALUES(user_id)
						";		
			
					DB::query($qry, $mergeArrays);
					/*-------------------------------------------------
					End insert into database
					-------------------------------------------------*/
					
					//Create note
					sale::createProformaNote($note_id, $message, $invoice_no);
		
					//Proforma json 
					sale::proformaJson($cust_id);
				
		
					//Inset into history table
					$user_mang = users::get_manager($_SESSION['edfghl']);
					widgets::add_history(
					array(
					'activity'=> 'Updated Proforma',
					'reference'=> $project,
					'date'=> date('Y-m-d H:i:s'),
					'link'=> '?page=viewproforma&inv_no='.$invoice_no,
					'type'=>'',
					'user_id'=> $user_id,
					'user_mang'=> $user_mang
					)
					);
		
					echo 'Proforma updated successfully!';
				}


		public function get_max_group_no(){
			//Get maximum group_no
			$gn = DB::get_row("SELECT MAX(group_no) AS group_no FROM entries");
			if($gn['group_no']){
				$group_no = $gn['group_no'] + 1;
			}
			else{
				$group_no = 1;
			}
			return $group_no;
		}


		public function add_invoice(){
		
			/*------------------------------------------------
			*BEGIN SINGLE VALUES
			------------------------------------------------*/
			//Proforma & Invoice inputs fields 
			//Top Section 
			$nhil = $_POST['nhil'];
			$getfund = $_POST['getfund'];
			$vatinp =  $_POST['vatinp'];
			$discountinpt = $_POST['discountinpt'];
			$invoice_no = accounts::inv_num('invoice', 'INV-');
			$pro_date = $_POST['pro_date'];
			$project = $_POST['project'];
			$tduration = $_POST['tduration'];		
			//Bottom Section 
			$subtotal = $_POST['subtotal'];
			$discount = $_POST['discount'];
			$nhils = $_POST['nhils'];
			$getfunds = $_POST['getfunds'];	
			$vat = $_POST['vat'];
			$grandtotal = $_POST['grandtotal'];
			$exp_dates = $_POST['exp_date'];
			//Hidden inputs 
			$user_id = $_SESSION['edfghl'];
			$cust_id = $_POST['cust_id'];
			$ac_id = $_POST['ac_id'];
			$trans_type = 'invoice';
			/*------------------------------------------------
			*END SINGLE VALUES
			------------------------------------------------*/
			//Check if PROFORMA already exists 
			$date = date("Y-m-d");
			$rzlt = DB::get_row("SELECT  invoice_no FROM sales WHERE invoice_no = ?", array($invoice_no));
			if(!empty($rzlt)){
				echo "<span style='font-size:0;'>errors</span>";	
					?>
					This <?php echo $rzlt['invoice_no']; ?> Invoice already exists!
					<?php
					exit;
			}
			else{
			}
			/*------------------------------------------------
			*BEGIN ARRAY ROW VALUES
			------------------------------------------------*/		
			$prod_qty = json_decode($_POST['prod_qty']);
			$prod_name = json_decode($_POST['prod_name']);	
			$duration = json_decode($_POST['duration']);		
			$price = json_decode($_POST['price']);
			$total = json_decode($_POST['total']);
			//Hidden inputs 		
			$cat_name = json_decode($_POST['cat_name']);	
			$prod_id = json_decode($_POST['prod_id']);
			/*------------------------------------------------
			*END ARRAY VALUES
			------------------------------------------------*/	
			 
			$date = date("Y-m-d");
			if(empty($exp_dates)){
				$exp_date = "0000-00-00";
			}
			else{
				$exp_date = date('Y-m-d', strtotime($exp_dates));
			}


			if(!isset($_POST['ignore_ac_id'])){
			//Check account field if it's empty
			if(accounts::activate_acc() == 1){
				validation::empty_validation(array('Account'=>$ac_id));
			}

			//Check if Account already exists
			accounts::account_verification($ac_id);
			}

				
			/*---------------------------------------------
			Begin date validation
			----------------------------------------------*/
			//Start date validation
			$pro_date = date("Y-m-d", strtotime($pro_date)).' '.date('H:i:s');
			validation::date_validation($pro_date, 'Start Date field required!');
			/*---------------------------------------------
			End date validation
			----------------------------------------------*/


			/*---------------------------------------------
			Begin General Validation
			----------------------------------------------*/
			sale::invoiceValidation(
				$vat,$vatinp,$discount,$discountinpt,$nhil,$nhils,$getfunds,$getfund,$tduration,
				$subtotal,$grandtotal,$project,$cust_id,$prod_name,$total,$duration
			);
			/*---------------------------------------------
			End General Validation
			----------------------------------------------*/



			/*-------------------------------------------------
			Begin Generate Invoice
			-------------------------------------------------*/	
			$arr1 = array($price, $prod_qty,  $total, $prod_id, $prod_name , $duration, $cat_name);

			$arr2 = array();
			foreach($arr1[0] as $k => $v){
				$arr2[] =  array( 
					$v, 
					$arr1[1][$k],  
					$arr1[2][$k], 
					$subtotal,
					$vat,
					$tduration,	
					$grandtotal,
					$discount,
					$trans_type,
					$pro_date,
					$invoice_no,
					$project,
					$vatinp,
					$nhil, 
					$getfund,
					$nhils,
					$getfunds,
					$discountinpt,
					$exp_date,
					$arr1[3][$k], 
					$arr1[4][$k], 
					$arr1[5][$k], 
					$arr1[6][$k],
					$cust_id,
					$ac_id,
					$user_id					
				);
			}
			/*-------------------------------------------------
			End Generate Invoice
			-------------------------------------------------*/

			$insertPlaceholder = sale::insertPlaceholders($arr2);
			$mergeArrays = sale::mergeMultidimensionalArrs($arr2);

			/*-------------------------------------------------
			Begin insert into database
			-------------------------------------------------*/		
			$inst = "INSERT INTO sales(
						unit_price,
						qty,
						total,
						subtotal,
						vat,
						tduration,
						grandtotal,
						discount,
						trans_type,
						date,
						invoice_no,
						project,
						vat_rate,
						nhil,
						getfund,
						nhils,
						getfunds,
						discount_rate,
						exp_date,
						prod_id,
						prod_name,
						duration,
						cat_name,
						cust_id,
						ac_id,
						user_id


			) VALUES ".$insertPlaceholder." ";

			DB::query($inst, $mergeArrays);
			/*-------------------------------------------------
			End insert into database
			-------------------------------------------------*/	
			
			//Create invoice json file
			sale::invoiceJson($cust_id);



			/*============================================
			BEGIN OPEN BALANCE UPDATE
			============================================*/
			if($ac_id != 'null'){
			//Update customer wih it parent ac_id
			customers::update_customer_ac_id($cust_id);

			//Update Account 
			$new_open_balance = json_decode($_POST['new_open_balance'], TRUE);
			foreach($new_open_balance as $v){
				DB::query("UPDATE accounts SET open_balance = '".$v['open_balance']."' WHERE ac_id ='".$v['ac_id']."' ");
			}

			//Update groups
			$groups = json_decode($_POST['groups'], TRUE);
			foreach($groups as $k=>$v){
				DB::query("UPDATE accounts SET groups = '".$v."' WHERE ac_id ='".$k."' ");
			}

			//Update Income Account
			$qry = DB::get_row("SELECT open_balance FROM accounts WHERE ac_id = '1'");
			$income = $qry['open_balance'] + $grandtotal;
			DB::query("UPDATE accounts SET open_balance = ? WHERE ac_id = '1'",array($income));

			
			/*============================================
			END OPEN BALANCE UPDATE
			============================================*/
			$group_no = $this->get_max_group_no();

			/*============================================
			BEGIN ADD ACCOUNT RECEIVABLE ENTRIES
			============================================*/
			$customer_name = customers::get_customer_name($cust_id);
			DB::query("
			INSERT INTO entries(
				ac_id,	
				account_type,	
				debit,	
				name,	
				name_id,	
				date,	
				entry_no,	
				credit_type,
				debit_type,	
				entry_type,		
				user_id,
				group_no
			)
			VALUES 
			(?,'Accounts Receivable',?,?,?,curdate(),?,'Decrease','Increase','INV',?,?)
			",array($ac_id,$grandtotal,$customer_name, $cust_id,$invoice_no,$user_id,$group_no));
			/*============================================
			END ADD ACCOUNT RECEIVABLE ENTRIES
			============================================*/



			/*============================================
			BEGIN ADD INCOME ACCOUNT ENTRIES
			============================================*/
			DB::query("
			INSERT INTO entries(
				ac_id,	
				account_type,	
				credit,	
				name,	
				name_id,	
				date,	
				entry_no,	
				credit_type,
				debit_type,	
				entry_type,		
				user_id,
				group_no
			)
			VALUES 
			('1','Income',?,?,?,curdate(),?,'Decrease','Increase','INV',?,?)
			",array($grandtotal,$customer_name, $cust_id,$invoice_no,$user_id,$group_no));
			/*============================================
			END ADD INCOME ACCOUNT ENTRIES
			============================================*/
			}

			//Insert into history table
			$user_mang = users::get_manager($_SESSION['edfghl']);
			widgets::add_history(
				array(
				'activity'=> 'Added Invoice',
				'reference'=> $project,
				'date'=> date('Y-m-d H:i:s'),
				'link'=> '?page=viewinvoice&inv_no='.$invoice_no,
				'type'=>'',
				'user_id'=> $user_id,
				'user_mang'=> $user_mang
				)
			);	
			
			echo $invoice_no.'--'.$cust_id; 
			}
			

			
		public function update_invoice(){
			/*------------------------------------------------
			*BEGIN SINGLE VALUES
			------------------------------------------------*/
			//Proforma & Invoice inputs fields 
			//Top Section 
			$nhil = $_POST['nhil'];
			$getfund = $_POST['getfund'];
			$vatinp =  $_POST['vatinp'];
			$discountinpt = $_POST['discountinpt'];
			$pro_date = $_POST['pro_date'];
			$project = $_POST['project'];
			$tduration = $_POST['tduration'];		
			//Bottom Section 
			$subtotal = $_POST['subtotal'];
			$discount = $_POST['discount'];
			$nhils = $_POST['nhils'];
			$getfunds = $_POST['getfunds'];	
			$vat = $_POST['vat'];
			$grandtotal = $_POST['grandtotal'];
			$exp_dates = $_POST['exp_date'];
			//Hidden inputs 
			$user_id = $_POST['user_id'];
			$cust_id = $_POST['cust_id'];
			$ac_id = $_POST['ac_id'];
			$invoice_no = $_POST['invoice_no'];
			$trans_type = 'invoice';
			/*------------------------------------------------
			*END SINGLE VALUES
			------------------------------------------------*/
			/*------------------------------------------------
			*BEGIN ARRAY ROW VALUES
			------------------------------------------------*/		
			$prod_qty = json_decode($_POST['prod_qty']);
			$prod_name = json_decode($_POST['prod_name']);	
			$duration = json_decode($_POST['duration']);		
			$price = json_decode($_POST['price']);
			$total = json_decode($_POST['total']);
			//Hidden inputs 		
			$cat_name = json_decode($_POST['cat_name']);	
			$prod_id = json_decode($_POST['prod_id']);
			$s_id = json_decode($_POST['s_id']); 
			/*------------------------------------------------
			*END ARRAY VALUES
			------------------------------------------------*/	

			if(empty($exp_dates)){
				$exp_date = "0000-00-00";
			}
			else{
				$exp_date = date('Y-m-d', strtotime($exp_dates));
			}
			$date = date("Y-m-d");


			/*---------------------------------------------
			Begin date validation
			----------------------------------------------*/
			//Start date validation
			$pro_date = date("Y-m-d", strtotime($pro_date)).' '.date('H:i:s');
			validation::date_validation($pro_date, 'Start Date field required!');
			/*---------------------------------------------
			End date validation
			----------------------------------------------*/	


			/*---------------------------------------------
			Begin General Validation
			----------------------------------------------*/
			sale::invoiceValidation(
				$vat,$vatinp,$discount,$discountinpt,$nhil,$nhils,$getfunds,$getfund,$tduration,
				$subtotal,$grandtotal,$project,$cust_id,$prod_name,$total,$duration
			);
			/*---------------------------------------------
			End General Validation
			----------------------------------------------*/


			/*-------------------------------------------------
			Begin Accounts Validation
			-------------------------------------------------*/
			//Check account field if it's empty
			if(accounts::activate_acc() == 1){
				validation::empty_validation(array('Account'=>$ac_id));
			}

			//Check if Account already exists
			accounts::account_verification2($ac_id, $cust_id);
			/*-------------------------------------------------
			End Accounts Validation
			-------------------------------------------------*/
			

			/*-------------------------------------------------
			Begin Generate Invoice
			-------------------------------------------------*/	
			$arr1 = array($s_id, $price, $prod_qty,  $total, $prod_id, $prod_name , $duration, $cat_name);

			$arr2 = array();
			foreach($arr1[1] as $k => $v){
				$arr2[] =  array( 
					$arr1[0][$k],
					$v, 
					$arr1[2][$k],  
					$arr1[3][$k], 
					$subtotal,
					$vat,
					$tduration,	
					$grandtotal,
					$discount,
					$trans_type,
					$pro_date,
					$invoice_no,
					$project,
					$vatinp,
					$nhil, 
					$getfund,
					$nhils,
					$getfunds,
					$discountinpt,
					$exp_date,
					$arr1[4][$k], 
					$arr1[5][$k], 
					$arr1[6][$k], 
					$arr1[7][$k],
					$cust_id,
					$ac_id,
					$user_id					
				);
			}
			/*-------------------------------------------------
			End Generate Invoice
			-------------------------------------------------*/

			$insertPlaceholder = sale::insertPlaceholders($arr2);
			$mergeArrays = sale::mergeMultidimensionalArrs($arr2);

			/*-------------------------------------------------
			Begin insert into database
			-------------------------------------------------*/		
			$qry = "
				INSERT INTO sales(
					 s_id,
					unit_price, 	
					qty, 
					total, 
					subtotal, 
					vat, 	
					tduration,
					grandtotal, 		
					discount, 
					trans_type, 	
					date, 
					invoice_no,
					project, 		
					vat_rate,
					nhil,
					getfund,
					nhils,
					getfunds,
					discount_rate,
					exp_date,
					prod_id, 
					prod_name, 				
					duration, 				
					cat_name, 	
					cust_id, 	
					ac_id, 					
					user_id
				)      
				VALUES ".$insertPlaceholder."    ON DUPLICATE KEY UPDATE
					unit_price = VALUES(unit_price), 	
					qty = VALUES(qty), 
					total = VALUES(total), 
					prod_id = VALUES(prod_id), 
					prod_name = VALUES(prod_name), 			
					duration = VALUES(duration), 				
					cat_name = VALUES(cat_name), 	
					subtotal = VALUES(subtotal), 	
					vat = VALUES(vat), 	
					tduration = VALUES(tduration), 
					grandtotal = VALUES(grandtotal), 		
					discount = VALUES(discount), 	
					date = VALUES(date), 
					project = VALUES(project), 		
					vat_rate = VALUES(vat_rate),
					nhil = VALUES(nhil),
					getfund = VALUES(getfund),
					nhils = VALUES(nhils),
					getfunds = VALUES(getfunds),
					discount_rate = VALUES(discount_rate),
					exp_date = VALUES(exp_date),
					cust_id  = VALUES(cust_id), 	
					ac_id  = VALUES(ac_id), 					
					user_id  = VALUES(user_id)
				";		
	
			DB::query($qry, $mergeArrays);
			/*-------------------------------------------------
			End insert into database
			-------------------------------------------------*/	

			//Create invoice json file
			sale::invoiceJson($cust_id);

		

			/*============================================
			BEGIN OPEN BALANCE UPDATE
			============================================*/
			if($ac_id){
			//Update customer wih it parent ac_id
			customers::update_customer_ac_id($cust_id);

			//Update Account 
			$new_open_balance = json_decode($_POST['new_open_balance'], TRUE);
			foreach($new_open_balance as $v){
				DB::query("UPDATE accounts SET open_balance = '".$v['open_balance']."' WHERE ac_id ='".$v['ac_id']."' ");
			}

			//Update groups
			$groups = json_decode($_POST['groups'], TRUE);
			foreach($groups as $k=>$v){
				DB::query("UPDATE accounts SET groups = '".$v."' WHERE ac_id ='".$k."' ");
			}

			//Update Income Account
		
			$income = $_POST['income_account'] + $grandtotal;
			DB::query("UPDATE accounts SET open_balance = ? WHERE ac_id = '1'",array($income));

			/*============================================
			END OPEN BALANCE UPDATE
			============================================*/

			$qry = DB::get_row("SELECT entry_no FROM entries WHERE entry_no = ?",array($invoice_no));

		if($qry){
			/*============================================
			BEGIN ADD ENTRIES
			============================================*/
			$customer_name = customers::get_customer_name($cust_id);
			DB::query("UPDATE entries SET ac_id = ?,debit=?,name=?,name_id =?,date = CURDATE() WHERE entry_no = ? AND account_type ='Accounts Receivable' ",array($ac_id,$grandtotal,$customer_name, $cust_id,$invoice_no));

			DB::query("UPDATE entries SET credit=?,name=?,name_id =?,date = CURDATE() WHERE entry_no = ? AND account_type ='Income' ",array($grandtotal,$customer_name, $cust_id,$invoice_no));
			/*============================================
			END ADD ENTRIES
			============================================*/
		}
		else{
			$group_no = $this->get_max_group_no();
			/*============================================
			BEGIN ADD ACCOUNT RECEIVABLE ENTRIES
			============================================*/
			$customer_name = customers::get_customer_name($cust_id);
			DB::query("
			INSERT INTO entries(
				ac_id,	
				account_type,	
				debit,	
				name,	
				name_id,	
				date,	
				entry_no,	
				credit_type,
				debit_type,	
				entry_type,		
				user_id,
				group_no
			)
			VALUES 
			(?,'Accounts Receivable',?,?,?,curdate(),?,'Decrease','Increase','INV',?,?)
			",array($ac_id,$grandtotal,$customer_name, $cust_id,$invoice_no,$user_id,$group_no));
			/*============================================
			END ADD ACCOUNT RECEIVABLE ENTRIES
			============================================*/



			/*============================================
			BEGIN ADD INCOME ACCOUNT ENTRIES
			============================================*/
			DB::query("
			INSERT INTO entries(
				ac_id,	
				account_type,	
				credit,	
				name,	
				name_id,	
				date,	
				entry_no,	
				credit_type,
				debit_type,	
				entry_type,		
				user_id,
				group_no
			)
			VALUES 
			('1','Income',?,?,?,curdate(),?,'Decrease','Increase','INV',?,?)
			",array($grandtotal,$customer_name, $cust_id,$invoice_no,$user_id,$group_no));
			/*============================================
			END ADD INCOME ACCOUNT ENTRIES
			============================================*/
		}
	}



			//Insert into history table
				$user_mang = users::get_manager($_SESSION['edfghl']);
				widgets::add_history(
				array(
				'activity'=> 'Updated Invoice',
				'reference'=> $project,
				'date'=> date('Y-m-d H:i:s'),
				'link'=> '?page=viewinvoice&inv_no='.$invoice_no,
				'type'=>'',
				'user_id'=> $user_id,
				'user_mang'=> $user_mang
				)
				); 

		
			   echo 'Invoice updated successfully!';
	
					
			}


		public function delete_invoice(){
			$invoice_no = $_GET['inv_no'];
			$cust_id = $_GET['cust_id'];
			DB::query("DELETE FROM  sales   WHERE  invoice_no  =  ?", array($invoice_no));
			//Create invoice json file
			sale::invoiceJson($cust_id);
		}


		public function delete_invoice_row(){
			$s_id = $_GET['s_id'];
			$cust_id = $_GET['cust_id'];
			$invoice_no = $_GET['invoice_no'];
			DB::query("DELETE FROM  sales   WHERE  s_id  =  ?", array($s_id));
			//Create invoice json file
			sale::invoiceJson($cust_id);
		}

		public function delete_proforma_row(){
			$s_id = $_GET['s_id'];
			$cust_id = $_GET['cust_id'];
			$invoice_no = $_GET['invoice_no'];
			DB::query("DELETE FROM  sales   WHERE  s_id  =  ?", array($s_id));
			$qry = DB::get_row("SELECT COUNT(invoice_no) as tot FROM sales WHERE invoice_no = ? ", array($invoice_no));
			if($qry['tot'] < 1){
				DB::query('DELETE FROM note WHERE reference = ?', array($invoice_no));
			}
			//Create invoice json file
			sale::proformaJson($cust_id);
		}
		public function delete_proforma(){
			$invoice_no = $_GET['inv_no'];
			$cust_id = $_GET['cust_id'];
			DB::query("DELETE FROM  sales   WHERE  invoice_no  =  ?", array($invoice_no));
			//Create invoice json file
			sale::proformaJson($cust_id);
			DB::query('DELETE FROM note WHERE reference = ?', array($invoice_no));
		}


		public function add_payment(){
			//Get single values
			$user_id = $_SESSION['edfghl'];
			$date = date('Y-m-d', strtotime($_POST['date']));
			$invoice_no= $_POST['invoice_no'];
			$pay_type= $_POST['pay_type'];
			$payment= $_POST['payment'];
			$cust_id= $_POST['cust_id'];
			$receipt_no =   accounts::inv_num('receipt', 'REC-');
			$note = textboxcleaner($_POST['note']); 
			$note_id= $_POST['note_id'];
			$balance= $_POST['balance'];
			
			//Payment date Validation
			if($date == '1970-01-01'){
				template::output(false, 'Payment date field required!');
			}

			validation::empty_validation(
				array(
				'Customer'=>$cust_id, 
				'Invoice#'=>$invoice_no,
				'Payment Type'=>$pay_type,
				'Payment'=>$payment
				)
			);

			validation::string_validation(
				array(
				'Invoice#'=>$invoice_no,
				'Payment Type'=>$pay_type,
				'Payment'=>$payment
				)
			);


			DB::query("INSERT INTO payment(amount,pay_type,pay_date,pay_no,invoice_no,cust_id,
				user_id) 
				VALUES(?,?,?,?,?,?,?)", array($payment,$pay_type, $date,$receipt_no,$invoice_no,$cust_id, $user_id));

			$p_id = DB::get_row("SELECT MAX(p_id) AS p_id FROM payment");



			if(!empty($note)){
				DB::query(
					"INSERT INTO note(note_id, message, reference) 
					VALUES(?,?,?) ON DUPLICATE KEY UPDATE message = values(message)
					", 
				array($note_id, $note, $invoice_no));
			}
			

			//Insert into history table
			$user_mang = users::get_manager($_SESSION['edfghl']);
			widgets::add_history(
			array(
			'activity'=> 'added payment',
			'reference'=> 'GHs '.$payment,
			'date'=> date('Y-m-d H:i:s'),
			'link'=> '?page=viewreceipt&rec_no='.$p_id['p_id'].'&inv_no='.$invoice_no.'&cust_id='.$cust_id.'&amnt='.$payment.'',
			'type'=>'',
			'user_id'=> $user_id,
			'user_mang'=> $user_mang
			)
			); 

			$setting = json_decode(setting::settings_json_file(),true);
			$cust = json_decode(customers::current_customer($cust_id),true);
			$activate = $setting[0]['activate_receipt_sms'];
			if(!empty($activate)){
				$cont = explode('/', $cust[0]['phone']);
				if(!empty($setting[0]['sms_cc'])){
					$contact = $cont[0].','.$setting[0]['sms_cc'];
				}
				else{
					$contact = $cont[0];
				}
				$message = "The amount of GHs ".number_format($payment).".00 \r\n received from {$cust[0]['fullname']}.\r\n Remaining balance: GHs ".number_format($balance).".00";
				widgets::sms_api($contact,$message);
			}
			else{
				echo 'Receipt added successfully!';
			}
		}


		public function max_pay_id(){
			$invoice_no = $_GET['invno'];
			$p_id = DB::get_row("SELECT MAX(p_id) AS p_id FROM payment WHERE invoice_no = ?", array($invoice_no));
			echo $p_id['p_id'];
		}


		public function delete_receipt(){
			$p_id = $_GET['p_id'];
			DB::query("DELETE FROM  payment   WHERE p_id  =  ?", array($p_id));
		}
		
	public function cactive(){
		$qry = "
			 SELECT 
			    s.invoice_no,
				s.project,
				s.date,
				s.exp_date,
				c.cust_id,
				c.fullname,
				c.phone
				FROM 
				sales as s JOIN customers as c
				ON s.cust_id = c.cust_id
				JOIN users_details as us ON c.user_id = us.user_id
				WHERE 
				s.status = '1' AND c.type = 'Customer' GROUP BY s.invoice_no  ORDER BY s.exp_date ASC
			 ";
		 $res = DB::query($qry);
		echo json_encode($res);
	}



	public function cexpired(){
		$qry = "
		SELECT 
		   s.invoice_no,
		   s.project,
		   s.date,
		   s.exp_date,
		   c.cust_id,
		   c.fullname,
		   c.phone
		   FROM 
		   sales as s JOIN customers as c ON s.cust_id = c.cust_id
		   WHERE s.status = '0' AND c.type = 'Customer' GROUP BY invoice_no  ORDER BY s.exp_date DESC
		";
   	$res = DB::query($qry);
   	echo json_encode($res);
	}




	public function get_invoice_no(){
		$cust_id = $_GET['cust_id'];
		$qry = DB::query("SELECT invoice_no FROM sales WHERE cust_id =? AND trans_type = 'invoice'   GROUP BY invoice_no", array($cust_id));
		echo json_encode($qry);
	}




	public function get_arrears(){

		$invoice_no = $_GET['invoice_no'];

		$slct = DB::query("
		SELECT 
		IFNULL(s.message, '') as note, 
		IFNULL(s.note_id, '') as note_id,
		s.invoice_no,
		(IFNULL(s.grandtotal,0) - IFNULL(p.amount,0)) as balance
		FROM (
		SELECT s.grandtotal, n.message, n.note_id, s.invoice_no, n.reference  FROM 
		sales as s LEFT JOIN note as n ON s.invoice_no = n.reference
		WHERE s.invoice_no = ? 
		) as s
		LEFT JOIN
		(SELECT  invoice_no, SUM(amount) AS amount FROM payment WHERE invoice_no = ?) as p
		ON p.invoice_no = s.invoice_no
		", array($invoice_no, $invoice_no));

		echo json_encode($slct);
	}


	public function receipt_info(){

		$p_id = $_GET['p_id'];
		$inv_no = $_GET['invoice_no'];
		
		$qry = DB::query("
		SELECT 
		p.amount,
		p.name as preparedby,
		s.grandtotal,
		s.message,
		(IFNULL(s.grandtotal, 0) - IFNULL(p.amount, 0) ) AS balance
		FROM
		(
		SELECT 
		p.cust_id, 
		p.invoice_no, 
		SUM(p.amount) AS amount,
		CONCAT(u.firstname,' ',u.lastname) AS name
		FROM 
		payment AS p
		JOIN users_details as u
		ON p.user_id = u.user_id
		WHERE p.p_id <= ? AND p.invoice_no =?    
		) AS p
		JOIN
		(
		SELECT 
		s.grandtotaL, 
		s.cust_id,
		n.message
		FROM 
		sales as s
		LEFT JOIN
		note as n 
		ON s.invoice_no = n.reference
		WHERE s.invoice_no = ?
		GROUP BY s.invoice_no
		) AS s
		ON p.cust_id = s.cust_id
		", array($p_id, $inv_no, $inv_no));
		
		echo json_encode($qry);
		
	}


	public function get_invoice_json(){
		$invoice_no = $_GET['inv_no'];
		$qry = DB::query("SELECT s.*, n.message, n.reference, n.note_id, 
		c.fullname,c.phone,c.email,c.location FROM sales as s LEFT JOIN note as n ON s.invoice_no = n.reference JOIN customers as c ON s.cust_id = c.cust_id WHERE s.invoice_no = ? ", array($invoice_no));
		echo json_encode($qry);
	}


	public function single_invoice(){
		$invoice_no = $_GET['invoice_no'];
		echo sale::single_invoice($invoice_no);
	}


	public function duplicate_invoice($invoiceno, $inv_type, $inv_ext,$t_type){
		$user_id = $_SESSION['edfghl'];
		$ac_id = '';
		$trans_type = $t_type;
		$invoice_no = accounts::inv_num($inv_type, $inv_ext);
		$pro_date = date('Y-m-d');

		/*------------------------------------------------
		*BEGIN ARRAY ROW VALUES
		------------------------------------------------*/		
		$prod_qty = array();
		$prod_name = array();
		$duration = array();		
		$price = array();
		$total = array();
		//Hidden inputs 		
		$cat_name = array();	
		$prod_id = array();
		/*------------------------------------------------
		*END ARRAY VALUES
		------------------------------------------------*/	

		$slct = DB::query("SELECT * FROM sales WHERE invoice_no = ?", array($invoiceno));
		if($slct){
			foreach($slct as $v){
				//Proforma & Invoice inputs fields 
				//Top Section 
				$nhil = $v['nhil'];
				$getfund = $v['getfund'];
				$vatinp =  $v['vat_rate'];
				$discountinpt = $v['discount_rate'];
				
				$project = $v['project'];
				$tduration = $v['tduration'];		
				//Bottom Section 
				$subtotal = $v['subtotal'];
				$discount = $v['discount'];
				$nhils = $v['nhils'];
				$getfunds = $v['getfunds'];	
				$vat = $v['vat'];
				$grandtotal = $v['grandtotal'];
				$exp_date = date('Y-m-d', strtotime("+{$tduration} months"));
				$cust_id = $v['cust_id'];

				/*------------------------------------------------
				*BEGIN ARRAY ROW VALUES
				------------------------------------------------*/		
				$prod_qty[] = $v['qty'];
				$prod_name[] = $v['prod_name'];
				$duration[] = $v['duration'];		
				$price[] = $v['unit_price'];
				$total[] = $v['total'];
				//Hidden inputs 		
				$cat_name[] = $v['cat_name'];	
				$prod_id[] = $v['prod_id'];
				/*------------------------------------------------
				*END ARRAY VALUES
				------------------------------------------------*/
			}

		}
		
			/*-------------------------------------------------
			Begin Generate Invoice
			-------------------------------------------------*/	
			$arr1 = array($price, $prod_qty,$total, $prod_id, $prod_name ,$duration, $cat_name);

			$arr2 = array();
			foreach($arr1[0] as $k => $v){
				$arr2[] =  array( 
					$v, 
					$arr1[1][$k],  
					$arr1[2][$k], 
					$subtotal,
					$vat,
					$tduration,	
					$grandtotal,
					$discount,
					$trans_type,
					$pro_date,
					$invoice_no,
					$project,
					$vatinp,
					$nhil, 
					$getfund,
					$nhils,
					$getfunds,
					$discountinpt,
					$exp_date,
					$arr1[3][$k], 
					$arr1[4][$k], 
					$arr1[5][$k], 
					$arr1[6][$k],
					$cust_id,
					$ac_id,
					$user_id					
				);
			}
			/*-------------------------------------------------
			End Generate Invoice
			-------------------------------------------------*/

			$insertPlaceholder = sale::insertPlaceholders($arr2);
			$mergeArrays = sale::mergeMultidimensionalArrs($arr2);

			/*-------------------------------------------------
			Begin insert into database
			-------------------------------------------------*/		
			$inst = "INSERT INTO sales(
						unit_price,
						qty,
						total,
						subtotal,
						vat,
						tduration,
						grandtotal,
						discount,
						trans_type,
						date,
						invoice_no,
						project,
						vat_rate,
						nhil,
						getfund,
						nhils,
						getfunds,
						discount_rate,
						exp_date,
						prod_id,
						prod_name,
						duration,
						cat_name,
						cust_id,
						ac_id,
						user_id


			) VALUES ".$insertPlaceholder." ";

			DB::query($inst, $mergeArrays);
			/*-------------------------------------------------
			End insert into database
			-------------------------------------------------*/	
			
			//Create invoice json file
			sale::invoiceJson($cust_id);
		  

			//Insert into history table
			$user_mang = users::get_manager($_SESSION['edfghl']);
			widgets::add_history(
				array(
				'activity'=> 'Added '.ucfirst($trans_type),
				'reference'=> $project,
				'date'=> date('Y-m-d H:i:s'),
				'link'=> '?page=viewinvoice&inv_no='.$invoice_no,
				'type'=>'',
				'user_id'=> $user_id,
				'user_mang'=> $user_mang
				)
			);	
			return $invoice_no;
		}

	public function all_grouped_invoice(){
		$cust_id = $_GET['cust_id'];
		$invoiceno = $_GET['invoice_no'];
		$this->duplicate_invoice($invoiceno,'proforma','PRO-','proforma');
		echo sale::get_grouped_invoice($cust_id);
	}

	public function convert_profoma(){
		$invoiceno = $_GET['invoice_no'];
		echo $this->duplicate_invoice($invoiceno,'invoice','INV-','invoice');
	}

	}
		