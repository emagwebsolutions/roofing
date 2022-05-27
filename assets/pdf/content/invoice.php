<?php session_start();
require_once (dirname(dirname(dirname(__DIR__))).'/model/model.php');
function invoice($GET){
		//Invoice Number
		$invoice_no = $GET['invoice_no'];
		$user_id = $_SESSION['edfghl'];

		$get_cust_id = DB::get_row("SELECT cust_id FROM sales WHERE invoice_no = ?
		GROUP BY invoice_no
		", array($invoice_no));
		$cust_id = $get_cust_id['cust_id'];

		//Customer
		$customer = json_decode(customers::current_customer($cust_id), true);

		//Settings
		$settings = json_decode(setting::settings_json_file(), true);

		//Users 
		$users = json_decode(users::users_json_file(), true);
		$user = array_filter($users, function($val) use($user_id){
			return $val['user_id'] == $user_id;
		});
		foreach($user as $v){
			$sign_by = $v['signature'];
			$user = $v['firstname'].' '.$v['lastname'];
		}

		//Invoice
		$invoice = json_decode(sale::single_invoice($invoice_no), true);
		$duration_status = array();
		foreach($invoice as $v){
			$invoice_date = $v['date'];
			$tduration = $v['tduration'];
			$exp_date = $v['exp_date'];
			$duration_status[] = $v['duration'];
			$project = $v['project'];
		}

			/*-----------------------------------------
		BEGIN IMAGES
		-----------------------------------------*/
		$logo = '<img src="../../assets/images/'.$settings[0]['comp_logo'].'" alt="test alt attribute" width="80" height="80" border="0" />';
		if(!empty($sign_by)){
		$signature = '<img src="../../assets/images/'.$sign_by.'" alt="test alt attribute" width="160" height="50" border="0"  style="float: right" />';
		}
		else{
		$signature = $user;	
		}
		$invoic =  '<img src="images/invoice.jpg"  width="40" height="300" border="0">'; 
		$banner = '<img src="images/banner.jpg"  width="360" height="100" border="0">'; 
		/*-----------------------------------------
		END IMAGES
		-----------------------------------------*/	


		/*-------------------------------------------------
		BEGIN FORMATTED VARIABLES
		--------------------------------------------------*/
		$terms = html_entity_decode($settings[0]['comp_terms']);
		//$note = html_entity_decode($GLOBALS['note']);
		$invoice_date = date('D d M, Y', strtotime($invoice_date));
		$prepared_by = $user;
		$tduration = empty($tduration)? '': 'Duration: '.$tduration.' month(s)';
		/*-------------------------------------------------
		END FORMATTED VARIABLES
		--------------------------------------------------*/

		/*-------------------------------------------------
		BEGIN CHECK IF INVOICE HAS DURATION
		--------------------------------------------------*/
		
		if(!empty(implode('',$duration_status))){
			$dates = '
			<br><br><span style="font-size: 12px;">Start Date: '.$invoice_date.' </span>
			<br><br>
			<span style="font-size: 12px;">End Date: '.$exp_date.' </span>
			';
		}
		else{
			$dates = '<br><br><span style="font-size: 12px;">Invoice Date: '.$invoice_date.' </span> ';
		}

		/*-------------------------------------------------
		END CHECK IF INVOICE HAS DURATION
		--------------------------------------------------*/


	/*-------------------------------------------------------------
		BEGIN INVOICE HEADER 
		------------------------------------------------------------*/
		$tbl = '
		<table style="width: 660px; font-size: 12px;" cellspacing="0" border="0" cellpadding = "0">
		<tr>
		<td style="width: 430px;">
		'.$logo.'
		<br>
		<span style="font-size: 20px;">'.$settings[0]['comp_name'].'</span>
		<br>
		</td>		
		<td style="width: 230px;">
		<div style="font-size: 14px; border-bottom: solid 1px #000;">SALES INVOICE</div>
		<br>
		<span style="font-size: 12px;">INVOICE #</span><span style="font-size: 12px;">&nbsp;&nbsp;&nbsp; '.$invoice_no.'</span>
			<br>
		<span style="font-size: 12px;">DATE:</span><span style="font-size: 12px;">&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;'.$invoice_date.'</span>
			<br>
		<br>
		</td>
		</tr> 
		<br>
		<tr>
		<td style="width: 300px;">
		<div style="font-size: 12px; border-bottom: solid 1px #000;">INVOICE FROM</div>
		<br>
			<span>'.$prepared_by.'</span>		
			<br>
			<span>'.$settings[0]['comp_addr'].'</span>
				<br>
			<span>'.$settings[0]['comp_phone'].'</span>
				<br>
			<span>'.$settings[0]['comp_email'].'</span>
				<br>
			<span>'.$settings[0]['comp_website'].'</span>
		</td>		
		<td style="width: 60px;">
		</td>	
		<td style="width: 300px;">
		<div style="font-size: 12px; border-bottom: solid 1px #000;">INVOICE TO:</div>
			<br>
			<span>'.$customer[0]['fullname'].'</span>
			<br>
			<span>'.$customer[0]['phone'].'</span>		
			<br>
			<span>'.$customer[0]['location'].'</span>	
				'.$dates.'			
				<br><br><br>
		</td>
		</tr> 	
		</table>
		';
		/*-------------------------------------------------------------
		END INVOICE HEADER 
		------------------------------------------------------------*/	
		/*-------------------------------------------------------------
		BEGIN INVOICE BODY
		------------------------------------------------------------*/
		if(!empty(implode('',$duration_status))){
			$tbl .= ' 
			<table style="width: 660px; font-size: 12px;" cellspacing="0" border="0">
			<tr>
			<td style="background-color: #e6e6e6;">
			<table cellpadding="10">
			<tr>
			<td style="width: 60px;">
			#
			</td>
			<td style="width: 265px;">
			Description
			</td>
			<td style="width: 80px;">
			Price
			</td>
			<td style="width: 50px;">
			Qty 
			</td>
			<td style="width: 105px;">
			Duration 
			</td>
			<td style="width: 100px;">
			Total
			</td>		
			</tr>
			</table>
			</td>
			</tr>
			</table>
			';
			$tbl .=  '
			<table style="width: 660px; font-size: 12px;" cellspacing="0" border="0">
			<tr>
			<td style="border: solid 1px #ccc;">
			';
			if(!empty($invoice)){
				$n = 1;
			foreach($invoice as  $v){
					  $prodname = explode('--', $v['prod_name']);
					  $prod_name = $prodname[0];
					  $durations = strip_tags($v['duration']);
					  if(!empty($durations)){
						  $duration = $durations.'month(s)';
					  }
					  else{
						  $duration = '';
					  }
					  $unit_price = strip_tags($v['unit_price']);	
					  $qty 	= strip_tags($v['qty']);
					  $total = number_format($v['total'],2,'.', ',');
					  $subtotal = number_format($v['subtotal'],2,'.', ',');
					  $vat = number_format($v['vat'],2,'.', ',');
					  $nhils = number_format($v['nhils'],2,'.', ','); 
					  $getfunds = number_format($v['getfunds'],2,'.', ',');  
					  $discount = number_format($v['discount'],2,'.', ','); 
					  $grandtotal = number_format($v['grandtotal'],2,'.', ','); 
					  $cust_id = $v['cust_id'];
	
					$tbl .= '
						<table cellpadding="10">
						<tr>
						<td style="width: 60px; border-right: solid 1px #ccc;">
						'.$n++.'
						</td>
						<td style="width: 265px; border-right: solid 1px #ccc;">
						'.$prod_name.'
						</td>
						<td style="width: 80px; border-right: solid 1px #ccc;">
						'.$unit_price.' 
						</td>
						<td style="width: 50px;  border-right: solid 1px #ccc;">
						'.$qty.'
						</td>
						<td style="width: 105px; border-right: solid 1px #ccc;">
						'.$duration.'
						</td>
						<td style="width: 100px;">
						'.$total.'
						</td>		
						</tr>
						</table>
				';
					 }
			 }
			$tbl .='
			</td>
			</tr>	
			</table>';
				}
				else{
			$tbl .= ' 
			<table style="width: 660px; font-size: 12px;" cellspacing="0" border="0">
			<tr>
			<td style="background-color: #e6e6e6;">
			<table cellpadding="10">
			<tr>
			<td style="width: 60px;">
			#
			</td>
			<td style="width: 270px;">
			Description
			</td>		
			<td style="width: 130px;">
			Price  
			</td>
			<td style="width: 92px;">
			Qty
			</td>
			<td style="width: 118px;">
			Total
			</td>		
			</tr>
			</table>
			</td>
			</tr>
			</table>
			';
			$tbl .=  '
			<table style="width: 660px; font-size: 12px;" cellspacing="0" border="0">
			<tr>
			<td style="border: solid 1px #ccc;">
			';
			if(!empty($invoice)){
				$n = 1;
			foreach($invoice as  $v){
					  $prodname = explode('--', $v['prod_name']);
					  $prod_name = $prodname[0];			  
					  $durations = strip_tags($v['duration']);
					  if(!empty($durations)){
						  $duration = $durations.'month(s)';
					  }
					  else{
						  $duration = '';
					  }
					  $unit_price = number_format($v['unit_price'],2,'.', ','); 
					  $qty 	= strip_tags($v['qty']);
					  $total = number_format($v['total'],2,'.', ','); 	
					  $subtotal = number_format($v['subtotal'],2,'.', ','); 
					  $vat = number_format($v['vat'],2,'.', ',');
					  $nhils = number_format($v['nhils'],2,'.', ',');	  
					  $getfunds = number_format($v['getfunds'],2,'.', ',');	  
					  $discount = number_format($v['discount'],2,'.', ',');
					  $grandtotal = number_format($v['grandtotal'],2,'.', ',');
					  $cust_id = $v['cust_id'];
					$tbl .= '
						<table cellpadding="10">
						<tr>
						<td style="width: 60px; border-right: solid 1px #ccc;">
						'.$n++.'
						</td>
						<td style="width: 270px; border-right: solid 1px #ccc;">
						'.$prod_name.'
						</td>					
						<td style="width:130px; border-right: solid 1px #ccc;">
						'.$unit_price.' 
						</td>
						<td style="width: 92px;  border-right: solid 1px #ccc;">
						'.$qty.'
						</td>
						<td style="width: 118px;">
						'.$total.'
						</td>		
						</tr>
						</table>
				';
					 }
			 }
			$tbl .='
			</td>
			</tr>	
			</table>';
					}
			/*-------------------------------------------------------------
			END INVOICE BODY
			------------------------------------------------------------*/	
		/*-------------------------------------------------------------
		BEGIN INVOICE FOOTER
		------------------------------------------------------------*/
		$tbl .= '
		<br><br>
		<table style="width: 660px;  font-size: 12px;" cellspacing="0" border="0" cellpadding="10">
		<tr>
		<td style="width: 330px; background-color: #e6e6e6; color: #000;">
		<b>Payment Info</b>
		<br><br>

		<table>
		<tr>
		<td style="width: 80px;">Account #:</td><td>'.$settings[0]['bank_acc'].'</td>
		</tr>
		<tr>
		<td>A/C Name:</td><td>'.$settings[0]['acc_name'].'</td>
		</tr>
		<tr>
		<td>Bank:</td><td>'.$settings[0]['comp_bank'].'</td>
		</tr>
		</table>
		<br>
		</td>
		<td style="width: 330px;">
		<table>
		<tr>
		<td style="width: 100px;">
		</td>
		<td style="width: 130px;">
		<br>
		<span>Sub Total:</span><br>
				';
		if($discount  !== '0.00'){		
		$tbl .= '
		<span>Discount:</span><br>
		';
		}
		if($nhils  !== '0.00'){		
		$tbl .= '
		<span>NHIL:</span><br>
		';
		}
		if($getfunds  !== '0.00'){		
		$tbl .= '
		<span>GETFUND:</span><br>
		';
		}
		if($vat  !== '0.00'){		
		$tbl .= '
		<span>VAT:</span><br>
		';
		}
		$tbl .= '
		<br><br>
		<b>Total GHs:</b>
		<br>
		</td>
		<td style="width: 100px;">
		<br>
		<span>'.$subtotal.'</span><br>
		';
		if($discount  !== '0.00'){
		$tbl .= '
		<span>'.$discount.'</span><br>
		';
		}
		if($nhils  !== '0.00'){
		$tbl .= '
		<span>'.$nhils.'</span><br>
		';
		}
		if($getfunds  !== '0.00'){
		$tbl .= '
		<span>'.$getfunds.'</span><br>
		';
		}
		if($vat  !== '0.00'){
		$tbl .= '
		<span>'.$vat.'</span><br>
		';
		}
		$tbl .='
				<br><br>
		<b>'.$grandtotal.'</b>
		<br>
		</td>
		</tr>
		</table>
		</td>
		</tr>
		<tr>
		<td style="width: 330px;">
		</td>
		<td style="width: 330px;">
		<table>
		<tr>
		<td style="width: 100px;">
		</td>
		<td style="width: 80px;">
		</td>
		<td style="width: 150px;">
		<span>'.$signature.'</span>
		<br>
		<hr>
		<br>
		<i style="text-align: center;">Signature</i>
		</td>
		</tr>
		</table>
		</td>
		</tr>
		</table>
		';
		/*-------------------------------------------------------------
		END INVOICE FOOTER
		------------------------------------------------------------*/		
		return $tbl;
	}