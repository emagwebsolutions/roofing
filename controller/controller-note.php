<?php

class Note{

    public function add_note(){

        $message = $_POST['message'];	
        $date = $_POST['date'];		
        $id = $_POST['id'];		

        validation::empty_validation(
            array(
            'Date'=>$date, 
            'Message'=>$message
            )
        );

        validation::date_validation($date, 'Valid date required!');

        $message = validation::textboxcleaner($message);

        DB::query("INSERT INTO note(message,date,id) VALUES(?,?,?)",array($message,date('Y-m-d', strtotime($date)),$id));

        echo 'Note added successfully!';
    }

    public function edit_note(){

        $message = $_POST['message'];	
        $date = $_POST['date'];		
        $note_id = $_POST['note_id'];		

        validation::empty_validation(
            array(
            'Date'=>$date, 
            'Message'=>$message
            )
        );

        validation::date_validation($date, 'Valid date required!');

        $message = validation::textboxcleaner($message);

        DB::query("UPDATE note SET message=?, date=? WHERE note_id =?", array($message,$date,$note_id));

        echo 'Note updated successfully!';

        
    }

    public function delete_note(){
        $note_id = $_POST['note_id'];
        DB::query("DELETE FROM note WHERE note_id = ?", array($note_id));
        echo '';
        
    }

    public function get_note(){
        $qry = DB::query("SELECT * FROM note");
        echo json_encode($qry);
    }

}