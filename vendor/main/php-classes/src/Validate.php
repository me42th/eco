<?php
class Validate{
    

    // UNIQUE NUMBER REGEX EMAIL REQUIRED 
    private $rules;
    private $error_msg;

    public function __construct($rules,$errors_msgs){
        $this->rules = $rules;
        $this->errors_msgs = $errors_msgs; 
    }

    public function you_shall_not_pass(){
        return true;
    }
}
?>