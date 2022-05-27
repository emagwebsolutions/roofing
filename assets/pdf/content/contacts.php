<?php session_start();
require_once (dirname(dirname(dirname(__DIR__))).'/model/model.php');

	function contacts($GET){
	
		if($GET > 0){
		$customers = json_decode(customers::single_customer_json($_GET['user_id']), true);
		}
		else{
			$qry = "SELECT  c.cust_id, c.date, c.fullname, c.phone, c.email, c.location, c.user_id,u.firstname, u.lastname FROM  customers as c JOIN users_details as u ON c.user_id = u.user_id
			ORDER BY u.firstname ASC";	
			$rzlt = DB::query($qry);

			$customers = $rzlt;
		}
		 

		/*====================================
		BEGIN NAME AND QUANTITY
		====================================*/
		$tbl = '<h5 style="color: #888; text-transform:uppercase">CUSTOMERS</h5>';
		/*====================================
		END NAME AND QUANTITY
		===================================*/

		/*====================================
		BEGIN TABLE HEADER
		====================================*/
		$tbl .= '<table style="width: 638px; font-size: 12px;" cellspacing="0" border="0">';
		
		$tbl .= '<tr>

		<td 
		style="
		width: 40px;
		font-size: 12px; 
		border-left: solid 1px #000000;  
		border-bottom: solid 1px #000000; 
		border-top: solid 1px #000;  
		">
		<br><br>
		#
		<br>
		</td>	

		<td 
		style="
		width: 170px;
		font-size: 12px; 
		border-left: solid 1px #000000;   
		border-top: solid 1px #000; 
		border-bottom: solid 1px #000000; 
		">
		<br><br>
		<strong>NAME</strong>
		<br>
		</td>

		<td 
		style="
		width:140px; 
		font-size: 12px; 
		text-align: left; 
		border-left: solid 1px #000000;   
		border-right: solid 1px #000000; 
		border-bottom: solid 1px #000000; 
		border-top: solid 1px #000;
		">
		<br><br>
		<strong>PHONE</strong>
		<br>
		</td>	

		<td 
		style="
		width: 140px;
		font-size: 12px; 
		border-left: solid 1px #000000;  
		border-bottom: solid 1px #000000; 
		border-top: solid 1px #000;  
		">
		<br><br>
		<strong>LOCATION</strong>
		<br>
		</td>	

		<td 
		style="
		width: 150px;
		font-size: 12px; 
		border-left: solid 1px #000000;  
		border-right: solid 1px #000000;
		border-top: solid 1px #000; 
		border-bottom: solid 1px #000000;  
		">
		<br><br>
		<strong>ASSIGNED TO</strong>
		<br>
		</td>
	
		</tr>';  


		$n=1;
		foreach($customers as $v){ 
				
		$tbl .= '
		<tr>
		<td 
		style="
		width: 40px;
		font-size: 12px; 
		border-left: solid 1px #000000;  
		border-bottom: solid 1px #000000; 
		border-top: solid 1px #000;  
		">
		<br><br>
		'.$n++.'
		<br>
		</td>	

		<td 
		style="
		width: 170px;
		font-size: 12px; 
		border-left: solid 1px #000000;   
		border-top: solid 1px #000; 
		border-bottom: solid 1px #000000; 
		">
		<br><br>
		'.$v['fullname'].'
		<br>
		</td>

		<td 
		style="
		width:140px; 
		font-size: 12px; 
		text-align: left; 
		border-left: solid 1px #000000;   
		border-right: solid 1px #000000; 
		border-bottom: solid 1px #000000; 
		border-top: solid 1px #000;
		">
		<br><br>
		'.$v['phone'].'
		<br>
		</td>	

		<td 
		style="
		width: 140px;
		font-size: 12px; 
		border-left: solid 1px #000000;  
		border-bottom: solid 1px #000000; 
		border-top: solid 1px #000;  
		">
		<br><br>
		'.$v['location'].'
		<br>
		</td>	

		<td 
		style="
		width: 150px;
		font-size: 12px; 
		border-left: solid 1px #000000;  
		border-right: solid 1px #000000;
		border-top: solid 1px #000; 
		border-bottom: solid 1px #000000;  
		">
		<br><br>
		'.$v['firstname'].' '.$v['lastname'].'
		<br>
		</td>
	
		</tr>
		';
		
		}
		/*====================================
		END TABLE BODY
		====================================*/
$tbl .= '</table>';
return $tbl;
	}