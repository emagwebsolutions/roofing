<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require("PHPMailer.php");
require("Exception.php");
class emails{

	private static function phpMail($to, $from, $from_name, $subject, $body,$file='',$bcc=''){
		//self::phpMail($to, $from, $from_name, $subject, $body,$file='',$bcc='');

		$mail = new PHPMailer;

		//From email address and name
		$mail->From = $from;
		$mail->FromName = $from_name;

		//To address and name
		$mail->addAddress($to,$subject);
		 $mail->AddReplyTo($from,$subject);
        if(!empty($bcc)){
            $mail->addBCC($bcc, $subject);
        }
		$mail->Subject = $subject;
		$mail->Body = html_entity_decode($body);
		$mail->AltBody = "$body";
		$mail->isHTML(true);
        if(!empty($file)){
		    $mail->addAttachment("$file"); //Filename is optional
        }
		if(!$mail->send()) 
		{
			return "Mailer Error: " . $mail->ErrorInfo;
		} 
		else 
		{
			return "Message sent to $to"; 
		}
	}


	/*----------------------------------------------------------------
	Begin BACKUP EMAIL
	---------------------------------------------------------------*/
	public static function  backupEmail($subject, $to, $body,$file){
		//Settings
		$setting = json_decode(setting::settings_json_file(), true);
		$from = $setting[0]['comp_email'];  
		$from_name = $setting[0]['comp_name']; 
		self::phpMail($to, $from, $from_name, $subject, $body,$file);
	}
	/*----------------------------------------------------------------
	End Backup EMAIL
	---------------------------------------------------------------*/


	/*----------------------------------------------------------------
	Begin GENERAL EMAIL
	---------------------------------------------------------------*/
	public static function  sendEmail($subject, $to, $body){

		//Sender details
		$arr = json_decode(users::users_json_file(), true);
		
		if(isset($_SESSION['edfghl'])){
			$user_id = $_SESSION['edfghl'];
			$sender = array_filter($arr, function($val) use($user_id){
				return ($val['user_id'] == $user_id);
			});
		
			foreach($sender as $v){
				$from = $v['email']; 
				$from_phone = $v['phone'];
				$from_name = $v['firstname'].' '.$v['lastname'];
			}
		}
		else{
			//Settings
			$setting = json_decode(setting::settings_json_file(), true);

			$from = $setting[0]['comp_email']; 
			$from_phone = $setting[0]['comp_phone']; 
			$from_name = $setting[0]['comp_name']; 
		}

		echo self::phpMail($to, $from, $from_name, $subject, $body,'',$from);

	}

	/*----------------------------------------------------------------
	End EMAIL
	---------------------------------------------------------------*/

		
	/*----------------------------------------------------------------
	Begin Invoice Email 
	---------------------------------------------------------------*/

	public static function invoice_email($file, $subject,$cust_id){

		//Settings
		$setting = json_decode(setting::settings_json_file(), true);

		//Sender details
		$arr = json_decode(users::users_json_file(), true);
		$user_id = $_SESSION['edfghl'];
		$sender = array_filter($arr, function($val) use($user_id){
			return ($val['user_id'] == $user_id);
		});
		foreach($sender as $v){
			$from = $v['email'];
			$from_phone = $v['phone'];
			$from_name = $setting[0]['comp_name']; //$v['firstname'].' '.$v['lastname'];
		}

		//Receipient details
		$customer = json_decode(customers::current_customer($cust_id), true);
		$to = $customer[0]['email'];
		
		//Email Validation
		validation::receipt_email_empty_validation(array('Email'=> $to));
		validation::email_validation($to);

		$message= 'Download attaached Invoice';

		//Create message content
		$body = '
		<table>
		<tr>
		<td>From: </td>
		<td>'.$from_name.'</td>
		</tr>
		<tr>
		<td>Phone: </td>
		<td>'.$from_phone.'</td>
		</tr>
		<tr>
		<td>Message: </td>
		<td>'.$message.'</td>
		</tr>
		</table>';
		echo self::phpMail($to, $from, $from_name, $subject, $body,$file,$from);

	}

	/*----------------------------------------------------------------
	End Invoice Email 
	---------------------------------------------------------------*/


	/*----------------------------------------------------------------
	Begin PRODUCTS Email 
	---------------------------------------------------------------*/
	public static function products_email($POST){

		if(isset($_SESSION['edfghl'])){
			//Get details of user
			$arr = json_decode(users::users_json_file(), true);
			$user_id = $_SESSION['edfghl'];

			$p = array_filter($arr, function($val) use($user_id){
				return ($val['user_id'] == $user_id);
			});
			
			foreach($p as $v){
				$POST['fullname'] = $v['firstname'].' '.$v['lastname'];
				$POST['semail'] = $v['email'];
			}

			//Convert post variables into normal variables
			extract($POST);
			$to = $email;
			$from = $semail;
			$from_name = $fullname;
		}
		else{
		extract($POST);
		$cust = DB::get_row("SELECT  fullname FROM customers WHERE phone = ? AND type = 'Customer'", array($phone));
			if(!empty($cust['fullname'])){
				$fullname = $cust['fullname'];
			}
			else{
				$fullname = 'Customer';
			}
			$to = $remail;
			$from = $remail;
			$from_name = $fullname;
		}

		//Email Validation
		validation::empty_validation(array('Email'=> $to));
		validation::email_validation($to);

		echo self::phpMail($to, $from, $from_name, $subject, $message,$file,$from);

	}
	/*----------------------------------------------------------------
	End PRODUCTS Email 
	---------------------------------------------------------------*/


}
?>