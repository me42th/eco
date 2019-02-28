<?php
class Validate{
    

    
    private $rules = [
                        "DESLOGIN" =>   [
                                            "UNIQUE" => [
                                                            "MSG" => "LOGIN EM USO",
                                                            "TABLE" => "tb_users",
                                                            "FIELD" => "deslogin"
                                                        ],
                                            "REQUIRED"                        
                                        ],
                        "DESZIPCODE" => [
                                            "NUMBER"
                                        ],
                        "DESPERSON" =>  [
                                            "REGEX",
                                            "REQUIRED"
                                        ],
                        "DESEMAIL" =>[
                                            "EMAIL",
                                            "UNIQUE"=> [
                                                            "MSG" => "EMAIL EM USO",
                                                            "TABLE" => "tb_persons",
                                                            "FIELD" => "desemail"
                                            ],
                                            "REQUIRED"
                                    ]
                    ];
    

    public function __construct($rules){
        $this->rules = $rules;
        $this->errors_msgs = $errors_msgs; 
    }

    private function required($field_data,$rule_support = null){

    }
    private function email($field_data,$rule_support = null){

    }
    private function unique($field_data,$rule_support = null){

    }
    private function regex($field_data,$rule_support = null){

    }    
    private function number($field_data,$rule_support = null){

    }            

    public function you_shall_not_pass($data){
        foreach($this->rules as $field => $rules){
            foreach($rules as $rule => $rule_support){
                $this->$rule($data[$field],$rule_support);
            }
        }
        return true;
    }

}
?>