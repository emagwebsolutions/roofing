<?php 
require_once 'model/model.php';

$user_id = 1;

$name = json_decode(file_get_contents(dirname(__FILE__).'/assets/logs/users.txt'), TRUE);
$val = array_filter($name, function($v){
    return $v;
});

$fullname = $val[0]['firstname'].' '.$val[0]['lastname'];

echo $fullname;