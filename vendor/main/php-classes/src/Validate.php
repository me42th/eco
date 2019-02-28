<?php

namespace main;

class Validate{
    

    //ARRAY DE EXEMPLO PARA GERAR A VALIDAÇÃO
    private $rules;

    public function __construct($rules){
        $this->rules = $rules;        
    }

    private function required($field_data,$rule_support = null){
        echo '<br> required ';
        print_r($rule_support);
    }
    private function email($field_data,$rule_support = null){
        echo '<br> email ';       
        print_r($rule_support);
    }
    private function unique($field_data,$rule_support = null){
        echo '<br> unique ';      
        print_r($rule_support);
    }
    private function regex($field_data,$rule_support = null){
        echo '<br> regex ';       
        print_r($rule_support);
    }    
    private function number($field_data,$rule_support = null){
        echo '<br> number ';        
        print_r($rule_support);
    }            



    public function you_shall_not_pass($data){
        foreach($this->rules as $field => $rules){
            echo '<br><br><b>'.$field.'</b>';
            echo '<br>'.$data[$field].'<br>';
            foreach($rules as $rule => $rule_support){                
                $this->$rule($data[$field],$rule_support);
            }
        }
        return true;
    }

}
?>