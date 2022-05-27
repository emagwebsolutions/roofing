<?php session_start();
require_once (dirname(dirname(dirname(__DIR__))).'/model/model.php');
define("MAJOR", 'GH. CEDIS');
define("MINOR", 'PESEWAS');
class toWords
{
    var $pounds;
    var $pence;
    var $major;
    var $minor;
    var $words = '';
    var $number;
    var $magind;
    var $units = array('', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine');
    var $teens = array('ten', 'eleven', 'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen');
    var $tens = array('', 'ten', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety');
    var $mag = array('', 'thousand', 'million', 'billion', 'trillion');
    function toWords($amount, $major = MAJOR, $minor = MINOR)
    {
        $this->__toWords__((int)($amount), $major);
        $whole_number_part = $this->words;
        #$right_of_decimal = (int)(($amount-(int)$amount) * 100);
        $strform = number_format($amount,2);
        $right_of_decimal = (int)substr($strform, strpos($strform,'.')+1);
        $this->__toWords__($right_of_decimal, $minor);
        $this->words = $whole_number_part . ' ' . $this->words;
    }
    function __toWords__($amount, $major)
    {
        $this->major  = $major;
        #$this->minor  = $minor;
        $this->number = number_format($amount, 2);
        list($this->pounds, $this->pence) = explode('.', $this->number);
        $this->words = " $this->major";
        if ($this->pounds == 0)
            $this->words = "Zero $this->words";
        else {
            $groups = explode(',', $this->pounds);
            $groups = array_reverse($groups);
            for ($this->magind = 0; $this->magind < count($groups); $this->magind++) {
                if (($this->magind == 1) && (strpos($this->words, 'hundred') === false) && ($groups[0] != '000'))
                    $this->words = ' and ' . $this->words;
                $this->words = $this->_build($groups[$this->magind]) . $this->words;
            }
        }
    }
    function _build($n)
    {
        $res = '';
        $na  = str_pad("$n", 3, "0", STR_PAD_LEFT);
        if ($na == '000')
            return '';
        if ($na{0} != 0)
            $res = ' ' . $this->units[$na{0}] . ' hundred';
        if (($na{1} == '0') && ($na{2} == '0'))
            return $res . ' ' . $this->mag[$this->magind];
        $res .= $res == '' ? '' : ' and';
        $t = (int) $na{1};
        $u = (int) $na{2};
        switch ($t) {
            case 0:
                $res .= ' ' . $this->units[$u];
                break;
            case 1:
                $res .= ' ' . $this->teens[$u];
                break;
            default:
                $res .= ' ' . $this->tens[$t] . ' ' . $this->units[$u];
                break;
        }
        $res .= ' ' . $this->mag[$this->magind];
        return $res;
    }
}
function receipt($invoice_no, $p_id){


	$qry = DB::query("
		SELECT 
		p.amount,
		p.name as preparedby,
		p.user_id,
		p.pay_date,
		p.pay_no,
		p.pay_type,
		s.grandtotal,
		s.message,
		(IFNULL(s.grandtotal, 0) - IFNULL(p.amount, 0) ) AS balance
		FROM
		(
		SELECT 
		p.user_id,
		p.pay_date,
		p.pay_no,
		p.cust_id, 
		p.pay_type,
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
		", array($p_id, $invoice_no, $invoice_no));

		/*------------------------------------------
		BEGIN RECEIPT DETAILS
		------------------------------------------*/
		foreach($qry as $v){
			$amount = $v['amount'];
			$balance = $v['balance'];
			$preparedby = $v['preparedby'];
			$user_id = $v['user_id'];
			$pay_date = $v['pay_date'];
			$pay_no = $v['pay_no'];
			$pay_type = $v['pay_type'];
			$pay_status = ($balance <= 0)? 'Full Payment': 'Part Payment';

		}
		$sql = DB::query("SELECT amount FROM payment WHERE p_id =?", array($p_id));
		$payment = $sql[0]['amount'];

		$sq = DB::query("SELECT project FROM sales WHERE invoice_no = ?", array($invoice_no));
		$project = $sq[0]['project'];
		

		/*------------------------------------------
		END RECEIPT DETAILS
		------------------------------------------*/

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
			$sign = $v['signature'];
			$user = $v['firstname'].' '.$v['lastname'];
		}

		/*------------------------------------------
		BEGIN PAYMENT TYPE
		------------------------------------------*/
		switch($pay_type){
			case 'Cash':
			$cash = '<img src="images/chk.png" width="20" height="11" border="0">';
			break;
			case 'Cheque':
			$cheque = '<img src="images/chk.png" width="20" height="11" border="0">';
			break;
			default:
			$other = '<img src="images/chk.png" width="20" height="11" border="0">';
			break;
		}


		/*------------------------------------------
		END PAYMENT TYPE
		------------------------------------------*/




		/*-----------------------------------------
		BEGIN IMAGES
		-----------------------------------------*/
		$logo = '<img src="../../assets/images/'.$settings[0]['comp_logo'].'" alt="test alt attribute" width="90" height="50" border="0" />';

		$signature = '<img src="../../assets/images/'.$sign.'" alt="test alt attribute" width="160" height="50" border="0" />';
		/*-----------------------------------------
		END IMAGES
		-----------------------------------------*/		
	
			$obj    = new toWords($amount);
			

			
		/*-------------------------------------------------
		BEGIN RECEIPT HEADER 
		--------------------------------------------------*/		
			$tbl .= '			
			<table style="width: 660px; font-size: 12px; border-bottom: solid 1px #888; background-color: #eee;" cellspacing="0" cellpadding="2" border="0">
			
			<br><br>
			<tr>
			<td style="width: 90px;">
			</td>
			<td style="width: 130px;">
			<br>
			'.$logo.'
			</td>
			<td style="width: 350px;">
			<b style="text-align: center; font-size: 18px;">'.strtoupper($settings[0]['comp_name']).'</b>
			<br>
			<span style="text-align: center;"><b>'.$settings[0]['comp_addr'].'</b> </span> <br>
			<span style="text-align: center;"><b>Tel:'.$settings[0]['comp_phone'].'</b> </span><br>
			<span style="text-align: center;">Email:'.$settings[0]['comp_email']. '</span>
				<br>
			</td>
			<td style="width: 90px;">
			</td>
		
			</tr>
				
			</table>';
			
		/*-------------------------------------------------
		END RECEIPT HEADER 
		--------------------------------------------------*/		
			
		
		/*-------------------------------------------------
		BEGIN RECEIPT BODY 
		--------------------------------------------------*/		
			$tbl .= '

			<table style="width: 660px; font-size: 12px;" cellspacing="0" cellpadding="4" border="0">
			<tr>
			<td>	
			<h2>Official Receipt</h2>
			</td>
			</tr>		
			</table>	
			
			<table style="width: 660px; font-size: 12px;" cellspacing="0" cellpadding="4" border="0">
			<tr>
			<td style="width: 50px;">	
			<span style="font-size: 12px; ">Date: </span>
			</td>
			<td style="width: 120px; border-bottom: solid 1px #888; ">
			<span style="font-size: 12px; ">'.date('d M, Y', strtotime($pay_date)).'</span>
			</td>
			<td style="width: 340px;">
			</td>
			<td style="width: 150px; border-bottom: solid 1px #888; text-align: right;">
			<span style="font-size: 12px; ">No. '.$pay_no.'</span>		
			</td>		
			</tr>
			

			<tr>
			<td style="width: 170px;">	
			<span style="font-size: 12px; ">Amount Received from:</span>
			</td>
			<td style="width: 490px; border-bottom: solid 1px #888; ">
			 <span style="font-size: 12px; ">'.strtoupper($customer[0]['fullname']).'</span>
			</td>
			</tr>	
			
			
			<tr>
			<td style="width: 70px;">	
			<span style="font-size: 12px; ">Address:</span>
			</td>
			<td style="width: 590px; border-bottom: solid 1px #888; ">
			<span style="font-size: 12px; ">'.strtoupper($customer[0]['location']).'</span>
			</td>
			</tr>

			<tr>
			<td style="width: 100px;">	
			<span style="font-size: 12px; ">Amount GHs:</span>
			</td>
			<td style="width: 560px; border-bottom: solid 1px #888; ">
			 <span style="font-size: 12px; ">'.number_format($payment).'.00</span>
			</td>
			</tr>	
			
			
			<tr>
			<td style="width: 150px;">	
			<span style="font-size: 12px; ">Purpose of Payment:</span>
			</td>
			<td style="width: 510px; border-bottom: solid 1px #888; ">
			  <span style="font-size: 12px; ">'.strtoupper($pay_status).' FOR '.strtoupper($project).'</span>
			</td>
			</tr>	
			</table>
	

			<br><br>
			

			<table style="width: 660px; font-size: 12px;" cellspacing="0" cellpadding="2" border="0">
				<tr>
				<td style="width: 300px;">
				
					<table style="font-size: 12px; width: 300px; border: solid 1px #888;" cellspacing="0" cellpadding="2" border="0">
					<tr>
					<td style="border-bottom: solid 1px #888; text-align: center; ">
					Account
					</td>
					</tr>

					<tr>
					<td style="width: 150px; border-bottom: solid 1px #888; border-right: solid 1px #888;">
					Total Amount Due
					</td>
					<td style="width: 150px; border-bottom: solid 1px #888;">
						GHs '.number_format($balance+$payment).'
					</td>
					</tr>

					<tr>
					<td style="width: 150px; border-bottom: solid 1px #888; border-right: solid 1px #888;">
					Amount Paid
					</td>
					<td style="width: 150px; border-bottom: solid 1px #888;">
					GHs '.number_format($payment).'
					</td>
					</tr>

					<tr>
					<td style="width: 150px; border-right: solid 1px #888;">
					Balance Due
					</td>
					<td style="width: 150px;">
					'.number_format($balance).'
					</td>
					</tr>
					</table>
				
				</td>
				
				
				<td style="width: 60px;"></td>
				
				
				<td style="width: 300px;">
				<table style="font-size: 12px; width: 300px; border: solid 1px #888;" cellspacing="0" cellpadding="2" border="0">
					<tr>
					<td style="border-bottom: solid 1px #888; text-align: center; ">
					Payment Made By
					</td>
					</tr>

					<tr>
					<td style="width: 150px; border-bottom: solid 1px #888; border-right: solid 1px #888;">
					Cash
					</td>
					<td style="width: 150px; border-bottom: solid 1px #888;">
						'.@$cash.'
					</td>
					</tr>

					<tr>
					<td style="width: 150px; border-bottom: solid 1px #888; border-right: solid 1px #888;">
					Cheque
					</td>
					<td style="width: 150px; border-bottom: solid 1px #888;">
					 '.@$cheque.'
					</td>
					</tr>

					<tr>
					<td style="width: 150px; border-right: solid 1px #888;">
					Others
					</td>
					<td style="width: 150px;">
				      '.@$other.'
					</td>
					</tr>

				</table>
				</td>			

				</tr>	
				
			<br>
			<tr>
			<td style="width: 110px;">	
			<span style="font-size: 12px; ">Received By:</span>
			</td>
			<td style="width: 260px; ">
			  <span style="font-size: 12px;">'.$preparedby.'</span>
			</td>
			
			
			<td style="width: 150px;">	
			<span style="font-size: 12px; ">
			Authorised Signature
			</span>
			</td>
			<td style="width: 140px;">
			  <span style="font-size: 12px; ">'.$signature.'</span>
			</td>			
			
			</tr>
					
			</table>
			';
		/*-------------------------------------------------
		END RECEIPT FOOTER
		--------------------------------------------------*/		

		
		return $tbl;
	}