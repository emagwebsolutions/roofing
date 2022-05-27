<?php session_start();
require_once (dirname(dirname(dirname(__DIR__))).'/model/model.php');
function proforma($GET){

		//Invoice Number
		$invoice_no = $GET['invoice_no'];
		$user_id = $_SESSION['edfghl'];

		$get_cust_id = DB::get_row("SELECT cust_id FROM sales WHERE invoice_no = ?", array($invoice_no));
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


		/*-----------------------------------------
		BEGIN IMAGES
		-----------------------------------------*/
		$logo = '<img src="../../assets/images/'.$settings[0]['comp_logo'].'" alt="test alt attribute" width="160" height="80" border="0" />';
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

		//Invoice
		$invoice = json_decode(sale::single_invoice($invoice_no), true);
		$duration_status = array();
		foreach($invoice as $v){
			$invoice_date = $v['date'];
			$tduration = $v['tduration'];
			$duration_status[] = $v['duration'];
			$project = $v['project'];
			$message = $v['message'];
		}


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
		$dates = '<br><br><span style="font-size: 12px;">Proforma Date: '.$invoice_date.' </span> ';
		/*-------------------------------------------------
		END CHECK IF INVOICE HAS DURATION
		--------------------------------------------------*/


		/*-------------------------------------------------------------
		BEGIN INVOICE HEADER 
		------------------------------------------------------------*/
		$tbl = '
		<table style="width: 660px; font-size: 12px;" cellspacing="0" border="0">
		<tr>
		<td>
			<img src="images/header-top.png" alt="test alt attribute" width="660" height="68" border="0" />
		</td>
		</tr>
		<tr>
		<td style="width: 330px; border-right: solid 1px #000000; border-top: solid 1px #000000; border-bottom: solid 1px #000000;">
		<br><br>
			<b>PROFORMA TO:</b>
			<br>
			<span>'.$customer[0]['fullname'].'</span>
			<br>
			<span>'.$customer[0]['phone'].'</span>		
			<br>
			<span>'.$customer[0]['location'].'</span>				
			<br><br>
			<b>PROFORMA #</b><span>&nbsp;&nbsp;&nbsp; '.$invoice_no.'</span>
			<br>
			<b>PROFORMA DATE</b><span>&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;'.$invoice_date.'</span>
			<br>
		</td>
		<td  style="width: 330px; border-top: solid 1px #000000; border-bottom: solid 1px #000000;">
		<br><br>
				&nbsp;&nbsp;&nbsp;&nbsp;<span>'.$prepared_by.'</span>		
				<br>
				&nbsp;&nbsp;&nbsp;&nbsp;<span>'.$settings[0]['comp_addr'].'</span>
				<br>
				&nbsp;&nbsp;&nbsp;&nbsp;<span>'.$settings[0]['comp_phone'].'</span>
				<br>
				&nbsp;&nbsp;&nbsp;&nbsp;<span>'.$settings[0]['comp_email'].'</span>
				<br>
				&nbsp;&nbsp;&nbsp;&nbsp;<span>'.$settings[0]['comp_website'].'</span>
		<br>
		</td>
		</tr> 
	    <tr>
		<td style="width: 660px;">
			<img src="images/header-bottom.png" alt="test alt attribute" width="660" height="30" border="0" />
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
				  $prod_size = strip_tags($v['prod_size']);				  
				  $durations = strip_tags($v['duration']);
					if(!empty($durations)){
						$duration = $durations.'month(s)';
					}
					else{
						$duration = '';
					}
				  $unit_price = strip_tags($v['unit_price']);	
				  $qty 	= strip_tags($v['qty']);
				  $total = strip_tags($v['total']);	
				  $subtotal = $v['subtotal'];	
				  $vat = $v['vat'];	
				  $nhils = $v['nhils'];		  
				  $getfunds = $v['getfunds'];		  
				  $discount = $v['discount'];	
				  $grandtotal = number_format($v['grandtotal']);	
				  $cust_id = $v['cust_id'];
				if(!empty(trim($prod_size))){
					  $size = '('.$prod_size.')';
				  }
				  else{
					  $size = '';
				  }			  
				  
				$tbl .= '
					<table cellpadding="10">
					<tr>
					<td style="width: 60px; border-right: solid 1px #ccc;">
					'.$n++.'
					</td>
					<td style="width: 265px; border-right: solid 1px #ccc;">
					'.$prod_name.' '.$size.'
					</td>
					<td style="width:80px; border-right: solid 1px #ccc;">
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
		<td style="width: 150px;">
		Price  
		</td>
		<td style="width: 80px;">
		Qty
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
				  $prod_size = strip_tags($v['prod_size']);				  
				  $unit_price = strip_tags($v['unit_price']);	
				  $qty 	= strip_tags($v['qty']);
				  $total = strip_tags($v['total']);	
				  $subtotal = $v['subtotal'];	
				  $vat = $v['vat'];	
				  $nhils = $v['nhils'];		  
				  $getfunds = $v['getfunds'];		  
				  $discount = $v['discount'];	
				  $grandtotal = $v['grandtotal'];	
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
					<td style="width:150px; border-right: solid 1px #ccc;">
					'.$unit_price.' 
					</td>
					<td style="width: 80px;  border-right: solid 1px #ccc;">
					'.$qty.'
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
		
		if(!empty($discount)){		
		$tbl .= '
		<span>Discount:</span><br>
		';
		}
		
		
		if(!empty($nhils)){		
		$tbl .= '
		<span>NHIL:</span><br>
		';
		}
		

		if(!empty($getfunds)){		
		$tbl .= '
		<span>GETFUND:</span><br>
		';
		}
		
		
		if(!empty($vat)){		
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
		<span>'.round($subtotal).'</span><br>
		';
		if(!empty($discount)){
		$tbl .= '
		<span>'.$discount.'</span><br>
			';
		}		
		if(!empty($nhils)){
		$tbl .= '
		<span>'.$nhils.'</span><br>
		';
		}
		if(!empty($getfunds)){
		$tbl .= '
		<span>'.$getfunds.'</span><br>
		';
		}
		if(!empty($vat)){
		$tbl .= '
		<span>'.$vat.'</span><br>
		';
		}
		$tbl .= '
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
		/*-------------------------------------------------------------
		BEGIN TERMS AND CONDITIONS
		------------------------------------------------------------*/	
		$tbl .= '
		<br><br>
		<table style="width: 660px;  font-size: 12px;" cellspacing="0" border="0" cellpadding="10">
		<tr>
		<td>
		<div>
		'.$message.'
		</div>
		<br><br>
		</td>
		</tr>
		<tr>
		<td>'.$terms.'</td>
		</tr>
		</table>';
		/*-------------------------------------------------------------
		END TERMS AND CONDITIONS
		------------------------------------------------------------*/	
		return $tbl;
	}