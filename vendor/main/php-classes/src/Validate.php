<?php

namespace main;

use main\DB\Sql;

class Validate{
    
     private $rules;

    public function __construct($rules){
        $this->rules = $rules;        
    }

    private function file(){}

    private function cpf(){}
        
    private function required($field_data,$rule_support){       
        if(!isset($field_data)) throw new \Exception($rule_support['msg']);
        if($field_data == '') throw new \Exception($rule_support['msg']);
    }

    private function email($field_data,$rule_support){        
        if(!isset($field_data)) return;
        if($field_data == '') return;        
        $re = '/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/i';
        if (!preg_match($re, $field_data)) { throw new \Exception($rule_support['msg']); }
        
      
    }

    private function unique($field_data,$rule_support){        
        if(!isset($field_data)) return;
        if($field_data == '') return;
        $sql = new Sql;
        $field = $rule_support['field'];
        $table = $rule_support['table'];
        $count = $sql->select(
                "select count(*) as cont from $table where $field = '$field_data';"
        )[0]['cont'];
        if($count != 0)
            throw new \Exception($rule_support['msg']);    
    }

    private function regex($field_data,$rule_support){        
        if(!isset($field_data)) return;
        if($field_data == '') return;
    }    
    
    private function number($field_data,$rule_support){        
        if(!isset($field_data)) return;
        if($field_data == '') return;
        if(!is_numeric($field_data))
        throw new \Exception($rule_support['msg']);
    }            

    public function you_shall_not_pass($data){        
        foreach($data as $field_name => $field_data){
            foreach($this->rules[$field_name] as $rule => $rule_support){  
                $this->$rule($field_data,$rule_support);
            }
        }
        return true;
    }
}
?>