<?php 
    use \main\Model\User;

    function check_login($boo){
       return User::check_login($boo);
    }

    function user_name(){
        return User::find(User::find_by_session()['iduser'])['desperson'];
    }

    function formatPrice(float $vlprice){
        return number_format($vlprice, 2, ',','.');
    }
    function hasCategory($id_category, $categories){
        return in_array($id_category, $categories);
    }
    function create_user_date(){
       
        return date('m/Y',strtotime(User::find(User::find_by_session()['iduser'])['dtregister']));
        
    }
?>