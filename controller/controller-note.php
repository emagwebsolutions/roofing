<?php

class note{

public function add_draft(){
    extract($_POST);
    $date = date('d M, Y');

    validation::empty_validation(array(
        'Subject' => $subject,
        'Message' => $message
    ));
    
    validation::string_validation(array(
        'Subject' => $subject
    ));
    
    $size = 1024/strlen($message);

    DB::query("INSERT INTO note(reference,assigned,subject,message,type,date,status) 
    VALUES(?,?,?,?,?,curdate(),'Draft')",array($_SESSION['edfghl'],$_SESSION['edfghl'],$subject,$message,round($size)));
        
    /*===========================
    End draft message update
    ===========================*/
    echo 'Saved as draft!';

}


public function add_message(){
    extract($_POST);
    $date = date('d M, Y');
    
    validation::empty_validation(array(
        'To' => $to,
        'Subject' => $subject,
        'Message' => $message
    ));
    
    validation::string_validation(array(
        'Subject' => $subject
    ));
    
    $size = 1024/strlen($message);

    /*===========================
    Begin draft message update
    ===========================*/

    // 'to' => reference
    // 'from' => assigned
    // 'subject' => subject
    // 'message' => message
    // 'date' => date
    // 'size' => type

    DB::query("INSERT INTO note(reference,assigned,subject,message,type,date,status) 
    VALUES (?,?,?,?,?,curdate(),'Unread'), (?,?,?,?,?,curdate(),'Sent')",
    array($to,$_SESSION['edfghl'],$subject,$message,round($size),
    $to,$_SESSION['edfghl'],$subject,$message,round($size)));


        
    /*===========================
    End draft message update
    ===========================*/
    echo 'Message sent!';
}


public function delete_notes(){
    $keys = json_decode($_POST['keys'], true);
    $imp = implode(',',$keys);
    DB::query("DELETE FROM note WHERE note_id IN(".$imp.")");
}


public function get_sent_note(){
    $status = $_GET['status'];
    if($status == 'Draft'){
        $qry = DB::query("SELECT n.*, CONCAT(u.firstname,' ',u.lastname) AS fullname FROM note as n JOIN users_details as u ON n.reference = u.user_id  WHERE n.assigned =? AND n.status = 'Draft' ORDER BY note_id DESC",array($_SESSION['edfghl']));
        echo json_encode($qry);
    }
    else{
        $qry = DB::query("SELECT n.*, CONCAT(u.firstname,' ',u.lastname) AS fullname FROM note as n JOIN users_details as u ON n.reference = u.user_id  WHERE n.assigned =? AND n.status = 'Sent' ORDER BY note_id DESC",array($_SESSION['edfghl']));
        echo json_encode($qry);       
    }

}

public function get_inbox(){
    $qry = DB::query("SELECT n.*,  CONCAT(u.firstname,' ',u.lastname) AS fullname FROM note as n JOIN users_details as u ON n.reference = u.user_id  WHERE n.reference =? AND n.status ='Unread' OR n.status ='Read' ORDER BY note_id DESC",array($_SESSION['edfghl']));
    echo json_encode($qry);
}

public function get_unread(){
    $qry = DB::query("SELECT count(*) as total FROM note WHERE reference =? AND status ='Unread' ORDER BY note_id DESC",array($_SESSION['edfghl']));
    echo json_encode($qry);    
}


public function read_note(){
    // 'to' => reference
    // 'from' => assigned
    // 'subject' => subject
    // 'message' => message
    // 'date' => date
    // 'size' => type

    $note_id = $_GET['note_id'];
    DB::query("UPDATE note SET status = 'Read' WHERE note_id = ? AND status ='Unread'",array($note_id));
    $qry = DB::query("
    SELECT 
    f.fname as frm, 
    t.tname as fullname, 
    t.subject, 
    t.message,
    t.date

    FROM 
    (
        SELECT 
        CONCAT(u.firstname,' ',u.lastname) as tname, 
        t.subject, 
        t.message,
        t.type,
        t.assigned,
        t.note_id,
        t.date
        FROM note as t JOIN users_details as u ON u.user_id = t.reference
    ) AS t 

    JOIN 

    (
        SELECT 
        u.user_id, 
        CONCAT(u.firstname,' ',u.lastname) as fname 
        FROM users_details as u
        JOIN note as n 
        ON n.assigned = u.user_id
    ) AS f ON t.assigned = f.user_id 
    WHERE t.note_Id = ?
    ", array($note_id));
    echo json_encode($qry);
}








}