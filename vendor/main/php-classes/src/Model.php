<?php
namespace main;

class Model{
//dados capturados do banco
private $values = [];

//método mágico que faz tudo não declarado
public function __call($name, $args)
{
    
    //captura se get ou set
    $method = substr($name, 0, 3);
    //captura qual campo
    $fieldName = substr($name,3, strlen($name));
    
    switch($method){

        case 'get':
            return $this->values[$fieldName];
        break;

        case 'set':
            $this->values[$fieldName] = $args[0];
        break;

        default:
            throw new \Exception("Método inválido");
    }
   

}
public function setData($data = array())
{
    foreach($data as $key => $value)
    {
        //cria o nome do metodo dinamicamente
        $this->{"set".$key}($value);
    }
}

public function getData(){
    return $this->values;
}

}
?>