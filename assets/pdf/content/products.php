<?php session_start();
require_once (dirname(dirname(dirname(__DIR__))).'/model/model.php');

	function products(){
	


		$p = json_decode(file_get_contents(dirname(__DIR__).'/images/genProducts.txt'), true);


		/*====================================
		BEGIN NAME AND QUANTITY
		====================================*/
		$tbl = '<h5 style="color: #888; text-transform:uppercase">ALL PRODUCTS</h5>';
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
		width: 280px;
		font-size: 12px; 
		border-left: solid 1px #000000;   
		border-top: solid 1px #000; 
		border-bottom: solid 1px #000000; 
		">
		<br><br>
		<strong>PRODUCT NAME</strong>
		<br>
		</td>


		
		<td 
		style="
		width: 200px;
		font-size: 12px; 
		border-left: solid 1px #000000;  
		border-right: solid 1px #000000;
		border-top: solid 1px #000; 
		border-bottom: solid 1px #000000;  
		">
		<br><br>
		<strong>PRICE</strong>
		<br>
		</td>


		<td 
		style="
		width: 146px;
		font-size: 12px; 
		border-bottom: solid 1px #000000; 
		border-right: solid 1px #000000;
		border-top: solid 1px #000;  
		">
		<br><br>
		<strong>QTY</strong>
		<br>
		</td>	
	
		</tr>';  

		/*====================================
		END TABLE HEADER
		===================================*/
		
		
		/*====================================
		BEGIN TABLE BODY
		====================================*/
		$n=1;
		foreach($p as $v){ 

				
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
		width: 280px;
		font-size: 12px; 
		border-left: solid 1px #000000;   
		border-top: solid 1px #000; 
		border-bottom: solid 1px #000000; 
		">
		<br><br>
		'.$v['prod_name'].'
		<br>
		</td>


		
		<td 
		style="
		width: 200px;
		font-size: 12px; 
		border-left: solid 1px #000000;  
		border-right: solid 1px #000000;
		border-top: solid 1px #000; 
		border-bottom: solid 1px #000000;  
		">
		<br><br>
		'.number_format($v['selling_price'],2,'.', ',').'
		<br>
		</td>


		<td 
		style="
		width: 146px;
		font-size: 12px; 
		border-bottom: solid 1px #000000; 
		border-right: solid 1px #000000;
		border-top: solid 1px #000;  
		">
		<br><br>
		'.$v['remaining'].'
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