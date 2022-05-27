<?php
include dirname(dirname(__DIR__)).'/model/model.php'; 
    if (isset($_GET['d'])) {
       $id = $_GET['d'];
		  	  $get_document = get_document($id);
			  if(!empty($get_document)){
			  foreach($get_document as $v){
				$name = strip_tags($v['name']);
				$type =  strip_tags($v['type']); 
			  }
			  }  
    }
    $file = $name;
    header('Content-Description: File Transfer');
    header('Content-Type:'.$type);
    header('Content-Disposition: attachment; filename=' . basename($file));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    ob_clean();
    flush();
    readfile($file);
    exit;