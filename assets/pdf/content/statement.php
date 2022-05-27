<?php session_start();
require_once (dirname(dirname(dirname(__DIR__))).'/model/model.php');
function statement($GET){
		//Invoice Number
		$cust_id = $GET['s'];


		$sales = DB::query("SELECT 
			date,
			grandtotal,
			invoice_no
			FROM sales  WHERE cust_id = ? AND trans_type = 'invoice' GROUP BY invoice_no
		",array($cust_id));

 
		$payment = DB::query("SELECT 
		pay_date,
		pay_no,
		amount
		FROM payment  WHERE cust_id = ? 
		",array($cust_id));

		$st = array_merge($sales,$payment);

		//Customer
		$customer = json_decode(customers::current_customer($cust_id), true);

		//Settings
		$settings = json_decode(setting::settings_json_file(), true);


			/*-----------------------------------------
		BEGIN IMAGES
		-----------------------------------------*/
		$logo = '<img src="../../assets/images/'.$settings[0]['comp_logo'].'" alt="test alt attribute" width="160" height="80" border="0" />';

		$invoic =  '<img src="images/invoice.jpg"  width="40" height="300" border="0">'; 
		$banner = '<img src="images/banner.jpg"  width="360" height="100" border="0">'; 
		/*-----------------------------------------
		END IMAGES
		-----------------------------------------*/	



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
		<div style="font-size: 14px; border-bottom: solid 1px #000;">STATEMENT OF ACCOUNT</div>
		<br>
		<span style="font-size: 12px;">REFERENCE #</span>
		<span style="font-size: 12px;">
		&nbsp;&nbsp;&nbsp; '.mt_rand(100,900).'
		</span>
		<br>
		<span style="font-size: 12px;">DATE:</span><span style="font-size: 12px;">
		&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;
		'.date('d M Y').'
		</span>
		<br>
		<br>
		<span style="font-size: 12px;">OPENING BALANCE:</span>
		<span style="font-size: 12px;">
		&nbsp;&nbsp;&nbsp;  
		</span>
		</td>
		</tr> 
		<br>
		<tr>
		<td style="width: 300px;">
		<div style="font-size: 12px; border-bottom: solid 1px #000;">FROM</div>
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
		<div style="font-size: 12px; border-bottom: solid 1px #000;">TO:</div>
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

			$tbl .= ' 
			<table style="width: 660px; font-size: 12px;" cellspacing="0" border="0">
			<tr>
			<td style="background-color: #e6e6e6;">
			<table cellpadding="10">
			<tr>
			<td style="width: 40px;">
			#
			</td>
			<td style="width: 90px;">
			Date
			</td>
			<td style="width: 100px;">
			Reference
			</td>
			<td style="width: 130px;">
			Description
			</td>
			<td style="width: 100px;">
			Amount
			</td>

			<td style="width: 100px;">
			Payment
			</td>	

			<td style="width: 100px;">
			Amount Due
			</td>	
			
			
			</tr>
			</table>
			</td>
			</tr>
			</table>
			';
			$tbl .=  '
			<table style="width: 660px; font-size: 12px;" cellspacing="0" border="0">
			';
			$n = 0;
			$mt = 0;
			foreach($st as  $v){
					$dates = $v['date']? $v['date'] : $v['pay_date'];
					$ref = $v['invoice_no']? $v['invoice_no'] : $v['pay_no'];
					$desc  = $v['invoice_no']? 'Sale' : 'Payment';
					$payment = $v['amount']? $v['amount'] : '';
					$gt = $v['grandtotal'];
					$pt = $v['amount']? 0 - $v['amount'] : '';
					$due = $gt.' '.$pt;

					$mt += (int) $due;

					$n++;
					//$nhils = number_format($v['nhils'],2,'.', ','); 

					$tbl .= '
					<tr>
					<td>
					<table cellpadding="10">
					<tr>
					<td style="width: 40px;">
					'.$n.'
					</td>
					<td style="width: 90px;">
					'.date('Y-m-d', strtotime($dates)).'
					</td>
					<td style="width: 100px;">
					'.$ref.'
					</td>
					<td style="width: 130px;">
					'.$desc.'
					</td>
					<td style="width: 100px;">
					'.$v['grandtotal'].'
					</td>
		
					<td style="width: 100px;">
					'.$payment.'
					</td>	
		
					<td style="width: 100px;">
					'.number_format($due,2,'.', ',').'
					</td>	
	
					</tr>
					</table>
					</td>
					</tr>
						';
				
			 }
			$tbl .='
			</table>';
		

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
		
				';

		$tbl .= '
		<br><br>
		<b>Total Due GHs:</b>
		<br>
		</td>
		<td style="width: 100px;">

		';

		$tbl .='
				<br><br>
		<b>'.number_format($mt,2,'.', ',').'</b>
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