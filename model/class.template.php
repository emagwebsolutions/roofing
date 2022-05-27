<?php
class template{
	public static $image_name; 
	
	/*------------------------------------
	Clear History
	---------------------------------*/
	//template::output($type=false, $output);
	public static function output($type, $output){
		if($type == false){
			?>
			<span style='font-size: 0px; '>errors</span>
			<?php
			echo $output; 
			exit;
		}
		else{
			echo $output;
			exit;
		}
	}


	/*
	template::image_upload();
	template::$image_name;
	*/
	public static function image_upload(){
		if(!empty($_FILES['uFile'])){
			$name = $_FILES['uFile']['name'];
			$type = $_FILES['uFile']['type'];			
			$size = $_FILES['uFile']['size'];			
			$tmp_name = $_FILES['uFile']['tmp_name'];
			switch($type){
				case 'image/jpeg':
				case 'image/png':
				break;
				default :
					?>
					<span style='font-size:0;'>errors</span>
					Unsupported file!
					<?php 
					exit;
			}
			if($size > 10000000){
				?>
					<span style='font-size:0;'>errors</span>
					File size is too large!
					<?php 
					exit;

			}
			$path = dirname(__DIR__).'/assets/images';
			$fext = explode('/', $type);
			$ext = $fext[1];
			$fname = mt_rand(100, 999);
			$picname = 'img'.$fname.'.'.$ext;
			$filepath = $path.'/'.$picname;
			move_uploaded_file($tmp_name, $filepath);
			self::$image_name = $picname;
			return self::$image_name;
			}
			else{
			self::$image_name = '';
			return self::$image_name;
			}
	}
	public static function document_upload(){
		if(!empty($_FILES['uFile'])){
			$name = $_FILES['uFile']['name'];
			$type = $_FILES['uFile']['type'];			
			$size = $_FILES['uFile']['size'];			
			$tmp_name = $_FILES['uFile']['tmp_name'];
			switch($type){
				case "image/jpeg":	
				case "image/gif":	
				case "image/png":	
				case "application/msword":
				case "application/x-zip-compressed":
				case "application/pdf":
				case "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet":
				break;
				default :
					?>
					<span style='font-size:0;'>errors</span>
					Unsupported file!
					<?php 
					exit;
			}
			if($size > 10000000){
				?>
					<span style='font-size:0;'>errors</span>
					File size is too large!
					<?php 
					exit;
			}
			$path = dirname(__DIR__).'/assets/images';
			$picname = $name;
			$filepath = $path.'/'.$picname;
			move_uploaded_file($tmp_name, $filepath);
			self::$image_name = $picname;
			return self::$image_name;
			}
			else{
			self::$image_name = '';
			return self::$image_name;
			}
	}
	
	

	
	
	
	public static function moveuploadedfile($tmp_name, $type){

		$path = dirname(__DIR__).'/assets/images';
		$fext = explode('/', $type);
		$ext = $fext[1];
		$fname = mt_rand(100, 999);
		$picname = 'img'.$fname.'.'.$ext;
		$filepath = $path.'/'.$picname;
				
		move_uploaded_file($tmp_name, $filepath);
				
		return $picname;

	}	
	
	
	
	public static function unlink_file($col, $user_id){
		$file = users::get_user_single_record($col, $user_id);
		$path = dirname(__DIR__).'/assets/images';	
		if(empty($file)){
				
		}
		else{
			if(file_exists($path.'/'.$file)){
			unlink($path.'/'.$file);
			}
		}
	}	
	

	
	
	public static function unlink_settings_file($col){
		$qry = DB::get_row("SELECT ".$col." FROM  settings");
		$file = $qry[$col];
		$path = dirname(__DIR__).'/assets/images';	
		if(empty($file)){
				
		}
		else{
			if(file_exists($path.'/'.$file)){
			unlink($path.'/'.$file);
			}
		}
	}
	
	
	
}