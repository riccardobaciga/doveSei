<?php

class user_Class extends myDb_Class {
    
    function getUsers(){
        $sql= "SELECT * FROM user ORDER BY nome";
        
        return $this->get_results($sql);
        
    }
     
    
}
$myApp->user = new user_Class();