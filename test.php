<?php 
require_once 'model/utils.php';

$arr = array( 
"Dashboard",
"null",
"1",
2,
"Sales",
"null",
"2",
2,
"Contacts",
"null",
"8",
2
);


echo insertPlaceholders( $arr, 4 );
